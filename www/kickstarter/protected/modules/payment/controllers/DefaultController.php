<?php

class DefaultController extends Controller {

  public function actionOnepayquoctecallback() {
    $payment = new Payment();
    $payment->setGateway("onepay_quocte");
    $payment->setParams($_GET);
    if($payment->isSuccess()){
      $this->handlePaymentSuccess($payment->getTransactionId());
    }else{
      $this->handlePaymentError($payment->getTransactionId(), $payment->getMessage());
    }
  }

  public function actionOnepaynoidiacallback() {
    $payment = new Payment();
    $payment->setGateway("onepay_noidia");
    $payment->setParams($_GET);
    if($payment->isSuccess()){
      $this->handlePaymentSuccess($payment->getTransactionId());
    } else if($payment->isBack()){
      $this->handleBack($payment->getTransactionId());
    } else {
      $this->handlePaymentError($payment->getTransactionId(), $payment->getMessage());
    }
  }

  public function actionNganluongcallback() {
    //Lấy thông tin giao dịch
    $transaction_info = $_GET["transaction_info"];
    //Lấy mã đơn hàng
    $order_code = $_GET["order_code"];
    //Lấy tổng số tiền thanh toán tại ngân lượng
    $price = $_GET["price"];
    //Lấy mã giao dịch thanh toán tại ngân lượng
    $payment_id = $_GET["payment_id"];
    //Lấy loại giao dịch tại ngân lượng (1=thanh toán ngay ,2=thanh toán tạm giữ)
    $payment_type = $_GET["payment_type"];
    //Lấy thông tin chi tiết về lỗi trong quá trình giao dịch
    $error_text = $_GET["error_text"];
    //Lấy mã kiểm tra tính hợp lệ của đầu vào
    $secure_code = $_GET["secure_code"];

    // $order->id = $order_code;
    $nl = new Nganluong();
    $check = $nl->verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code);

    if($check) {
      if($error_text == "") {
        $this->handlePaymentSuccess($order_code);
      } else {
        $this->handlePaymentError($order_code, $error_text);
      }
    } else {
      $this->handlePaymentError($order_code, ___("Checksum error"));
    }
    // $payment = new Payment();
    // $payment->setGateway("nganluong");
    // $payment->setParams($_GET);

    // if($payment->isSuccess()){
    //   $this->handlePaymentSuccess($payment->getTransactionId());
    // }else{
    //   $this->handlePaymentError($payment->getTransactionId(), $payment->getMessage());
    // }
  }

  public function actionCreditcallback() {
    $payment = new CreditGateway();
    $payment->setGateway('credit');
    $payment->setParams($_GET);
    if($payment->isSuccess()){
      $this->handlePaymentSuccess($payment->getTransactionId());
    }else{
      $this->handlePaymentError($payment->getTransactionId(), $payment->getMessage());
    }
  }

  private function handlePaymentSuccess($transactionId){
    $transaction = Transaction::model()->findByPk($transactionId);

    if(empty($transaction)){
      return $this->handleError(___("Transaction %s not found", array($transactionId)));
    }

    if(intval($transaction->status) !== Transaction::STATUS_PENDING){
      return $this->handleError(___("Transaction %s status is not correct", array($transactionId)));
    }

    // re-check if the backer count break backer limit
    $reward = $transaction->reward;

    if(empty($reward)){
      return $this->handleError(___("Reward %s not found", array($transaction->reward_id)));
    }

    if($reward->backer_limit > 0 && $reward->backer_count >= $reward->backer_limit){
      $transaction->status = Transaction::STATUS_NEED_REFUND;
      $transaction->message = "Reward backer limit reached";
      $transaction->save();
      return $this->handleError(___("Reward backer limit reached"));
    }else{
      $transaction->approve();
      // $transaction->status = Transaction::STATUS_COMPLETED;
      if($transaction->save()){
        $reward->backer_count ++;
        $reward->save();

        $project = $reward->project;
        $project->funding_current += $transaction->amount;
        $project->save();
        return $this->handleSuccess($transactionId);
      }else{
        return $this->handleError(___("Transaction %s update failed", array($transactionId)));
      }
    }
  }

  private function handlePaymentError($transactionId, $message){
    Transaction::model()->updateByPk($transactionId, array(
      'status' => Transaction::STATUS_REMOVED,
      'message' => $message
    ));

    $this->handleError($message);
  }

  private function handleError($message){
    Yii::app()->user->setFlash("error", $message);
    $this->redirect(array(Yii::app()->getModule("payment")->errorUrl, 'message' => $message));
  }

  private function handleSuccess($transactionId){
    Yii::app()->user->setFlash("success", ___("Transaction success"));
    $this->redirect(Yii::app()->getModule("payment")->successUrl.'/'.$transactionId);
  }

  private function handleBack($transactionId){
    $this->redirect(array(Yii::app()->getModule("payment")->backUrl, 'transaction_id' => $transactionId));
  }

}