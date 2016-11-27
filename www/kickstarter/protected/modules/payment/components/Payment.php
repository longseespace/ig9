<?php
Yii::import('application.modules.payment.models.Transaction');

class Payment extends CComponent {

  private $gateway;
  private $params;
  private $message;
  private $success;
  private $back;
  private $transactionId;
  private $transaction;
  private $orderInfo;

  function __construct($transaction = null) {
    $this->transaction = $transaction;
    $this->orderInfo = "ig9-".$transaction->id;
  }

  public function buildRedirectUrl($params){
    if(empty($this->transaction)) {
      $this->transaction = $this->createTransaction($params);
    }

    if(empty($this->transaction)){
      Yii::app()->user->setFlash("error", $this->message);
      return Yii::app()->getModule("payment")->errorUrl;
    }

    switch($this->transaction->gateway){
      case "onepay_noidia":
        $payment = new Onepay();
        $config = Yii::app()->getModule('payment')->gateways['onepay_noidia'];
        $payment->setSecureSecret($config['secure_secret']);
        $payment->setVirtualPaymentUrl($config['virtual_payment_url']);
        $configParams = $config['params'];
        $configParams = array_merge($configParams, array(
          "vpc_OrderInfo" => $this->transaction->id,
          "vpc_MerchTxnRef" => date('YmdHis').rand(),
          "vpc_Amount" => intval($params['amount']) * 100,
          "vpc_Bank" => $params['bank_id']
        ));
        return $payment->buildUrl($configParams);
        break;
      case "onepay_quocte":
        $payment = new Onepay();
        $config = Yii::app()->getModule('payment')->gateways['onepay_quocte'];
        $payment->setSecureSecret($config['secure_secret']);
        $payment->setVirtualPaymentUrl($config['virtual_payment_url']);
        $configParams = $config['params'];
        $configParams = array_merge($configParams, array(
          "vpc_OrderInfo" => $this->transaction->id,
          "vpc_MerchTxnRef" => date('YmdHis').rand(),
          "vpc_Amount" => intval($params['amount']) * 100
        ));
        return $payment->buildUrl($configParams);
        break;
      case "nganluong":
        $nl = new NL_Checkout();
        $transaction_info = "Thanh toán giao dịch ".$this->transaction->id;
        $price = intval($params['amount']);
        return $nl->buildCheckoutUrl(Yii::app()->createAbsoluteUrl('/payment/default/nganluongcallback'), 'info@ig9.vn', $transaction_info, $this->transaction->id, $price);
        break;
      case "credit":
      case "ig9-credit":
        $user = Yii::app()->user->model();
        $price = intval($params['amount']);
        if($user->credit >= $price) {
          $credit = new Credit();
          $credit->user_id = Yii::app()->user->id;
          $credit->minus = $price;
          $credit->plus = 0;
          $credit->save();
          $user->credit -= $price;
          $user->save();
          $reward = $this->transaction->reward;
          $reward->backer_count ++;
          $reward->save();
          $project = $reward->project;
          $project->funding_current += $this->transaction->amount;
          $project->save();

          $this->transaction->approve();
          if($this->transaction->save()) {
            return array(Yii::app()->getModule('payment')->successUrl, 'transaction_id' => $this->transaction->id);
          } else {
            return array(Yii::app()->getModule('payment')->errorUrl, 'message' => ___('Internal error'));
          }
        } else {
          return array(Yii::app()->getModule('payment')->backUrl, 'transaction_id' => $this->transaction->id, 'message' => 'Credit not enough');
        }

        break;
      case "bank":
      case "cod":
      case "direct":
      case "paypal":
        return array(Yii::app()->getModule('payment')->successUrl, 'transaction_id' => $this->transaction->id);
        break;
    }
  }

  public function setGateway($gateway){
    $this->gateway = $gateway;
  }

  public function setParams($params){
    // remove yii $_GET 'r' parameter
    if(isset($params['r'])){
      unset($params['r']);
    }
    $this->params = $params;
    $this->validate();
  }

  public function getMessage(){
    return $this->message;
  }

  public function getGateway() {
    if(!empty($this->gateway)) {
      return $this->gateway;
    } else if(!empty($this->transaction->gateway)) {
      return $this->transaction->gateway;
    } else {
      return null;
    }
  }

  public function isBack() {
    return $this->back;
  }

  public function isSuccess(){
    return $this->success;
  }

  public function getTransactionId(){
    return $this->transaction->id;
  }

  public function validate(){
    switch($this->getGateway()){
      case "onepay_noidia":
        $payment = new Onepay();
        $config = Yii::app()->getModule('payment')->gateways['onepay_noidia'];
        $payment->setSecureSecret($config['secure_secret']);
        $check = $payment->checksum($this->params);
        if($check){
          if($_GET['vpc_TxnResponseCode'] === "0"){
            $this->success = true;
            $this->message = ___("Transaction success");
          }else if($_GET["vpc_TxnResponseCode"] == "99"){
            $this->success = false;
            $this->back = true;
            $this->message = ___("Back");
          } else {
            $this->success = false;
            $this->message = ___("Error ".$parameters["vpc_TxnResponseCode"]);
          }
        }else{
          $this->success = false;
          $this->message = ___("Checksum error");
        }
        $this->transaction->id = $this->params['vpc_OrderInfo'];
        break;
      case "onepay_quocte":
        $payment = new Onepay();
        $config = Yii::app()->getModule('payment')->gateways['onepay_quocte'];
        $payment->setSecureSecret($config['secure_secret']);
        $check = $payment->checksum($this->params);
        if($check){
          if($_GET['vpc_AcqResponseCode'] === '00'){
            $this->success = true;
            $this->message = ___("Transaction success");
          }else if($parameters["vpc_TxnResponseCode"] == "99"){
            $this->success = false;
            $this->back = true;
            $this->message = ___("Back");
          } else {
            $this->success = false;
            $this->message = ___("Transaction failed");
          }
        }else{
          $this->success = false;
          $this->message = ___("Checksum error");
        }
        $this->transaction->id = $this->params['vpc_OrderInfo'];
        break;
      case "nganluong":
        $payment = new Nganluong2();
        $config = Yii::app()->getModule('payment')->gateways['nganluong'];
        $payment->setSecureSecret($config['secure_secret']);
        $check = $payment->checksum($this->params);
        if($check){
          if($_GET['vpc_TxnResponseCode'] === "0"){
            $this->success = true;
            $this->message = ___("Transaction success");
          }else{
            $this->success = false;
            $this->message = ___("");
          }
        }else{
          $this->success = false;
          $this->message = ___("Checksum error");
        }
        break;
    }
  }

  public function createTransaction($data){
    $transaction = new Transaction();
    $transaction->reward_id = $data['reward_id'];
    $transaction->user_id = Yii::app()->user->getId();
    $transaction->amount = $data['amount'];
    $transaction->gateway = $this->gateway;
    $transaction->status = Transaction::STATUS_PENDING;
    $reward = $transaction->reward;
    if($reward->backer_limit > 0 && $reward->backer_count >= $reward->backer_limit){
      $this->message = ___("Reward backer limit reached");
      return null;
    }else{
      if($transaction->save()){
        $this->transaction = $transaction;
        $this->transactionId = $transaction->id;
        $this->orderInfo = "ig9-".$transaction->id;
        return $transaction;
      }else{
        $this->message = ___("Transaction cannot be created");
        return null;
      }
    }
  }

  public function getTransaction(){
    if(!empty($this->transaction)){
      return $this->transaction;
    }elseif(!empty($this->transaction->id)){
      return Transaction::model()->findByPk($this->transaction->id);
    }else{
      return null;
    }
  }

}
?>