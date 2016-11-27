<?php

class PledgeController extends AbstractSiteController {

  public function filters() {
    return CMap::mergeArray(parent::filters() , array(
      'accessControl',
    ));
  }

  /**
   * Specifies the access control rules.
   * This method is used by the 'accessControl' filter.
   * @return array access control rules
   */
  public function accessRules()
  {
    return array(
      array('allow', // allow authenticated user to pledge
        'actions' => array('new', 'success', 'error', 'paymentmethod', 'charge', 'chargesuccess'),
        'users' => array('@')
      ),
      array('deny',  // deny all users
        'users' => array('*'),
      ),
    );
  }

  public function actionIndex() {
  }

  public function actionTest(){
    $this->render('test');
  }

  public function actionNew($project_id)
  {
    $project = Project::model()->findByPk($project_id);
    if ($project->isEnd()) {
      $this->redirect(array('project/view', 'slug' => $project->slug, 'id' => $project_id));
    }

    $pledgeForm = new PledgeForm;

    if (isset($_POST['ajax']) && $_POST['ajax']==='theform')
    {
      echo CActiveForm::validate($pledgeForm);
      Yii::app()->end();
    }

    if (isset($_POST['PledgeForm']))
    {
      $pledgeForm->attributes = $_POST['PledgeForm'];

      if ($pledgeForm->validate()) {
        $payment = new Payment();
        $transaction = $payment->createTransaction(array(
          'reward_id' => $pledgeForm->reward_id,
          'amount' => $pledgeForm->amount
        ));
        if(empty($transaction)) {
          $this->error($payment->getMessage());
          $this->redirect('/');
        } else {
          $this->redirect(array('paymentmethod', 'transaction_id' => $transaction->id));
        }
      }
    } elseif (isset($_GET['amount']) && isset($_GET['reward_id'])) {
      $pledgeForm->amount = (int) $_GET['amount'];
      $pledgeForm->reward_id = (int) $_GET['reward_id'];
    }

    $this->render('form', compact('project', 'pledgeForm'));
  }

  public function actionSuccess($transaction_id){
    $transaction = Transaction::model()->with('user', 'user.profile', 'reward')->findByPk($transaction_id);
    if ($transaction->user_id != Yii::app()->user->id) $this->redirect('/');

    $reward = $transaction->reward;
    $project = $reward->project;

    $this->sendConfirmEmail($transaction);

    if ($transaction->status == Transaction::STATUS_COMPLETED) {
      $this->addJSVars(array(
        'transaction' => array(
          'id' => $transaction->id,
          'amount' => $transaction->amount,
          'city' => $transaction->user->profile->city,
          'reward_id' => $transaction->reward_id,
          'reward_amount' => $transaction->reward->amount,
        ))
      );
    }

    $this->render('success', compact('project', 'reward', 'transaction'));
  }

  public function actionError($message){
    $this->render('error', compact('message'));
  }

  public function actionPaymentmethod($transaction_id) {
    $transaction = Transaction::model()->findByPk($transaction_id);
    $user = Yii::app()->user->model();
    $profile = $user->profile;
    $profile->scenario = 'payment';

    if($transaction === null) {
      $this->error('Transaction not found');
      $this->redirect('/');
    }

    if($transaction->user_id != Yii::app()->user->id) {
      $this->error('Transaction is not yours');
      $this->redirect('/');
    }

    if (isset($_POST['Transaction'])) {
      if(isset($_POST['Profile'])) {
        unset($profile->birthday);
        $profile->address = $_POST['Profile']['address'];
        $profile->mobile = $_POST['Profile']['mobile'];
        // $profile->attributes = $_POST['Profile'];
        $profile->save();
      }
      $transaction->attributes = $_POST['Transaction'];
      $transaction->save();
      $payment = new Payment($transaction);
      // $url = $payment->buildRedirectUrl($return_url, $receiver, $transaction_info, $order_code, $price);
      $url = $payment->buildRedirectUrl(array(
        'amount' => $transaction->amount,
        'reward_id' => $transaction->reward_id
      ));

      $this->redirect($url);
    }

    $this->render('paymentmethod', compact('transaction', 'profile', 'user'));
  }

  public function actionCharge() {
    if( !Yii::app()->request->isPostRequest) {
      throw new CHttpException(403,'Method is not allow.');
    }

    if ( !Yii::app()->request->isAjaxRequest) {
      throw new CHttpException(403,'Action only allow for ajax request.');
    }

    if ( empty($_POST['Card']) ) {
      throw new CHttpException(404,'Bad data.');
    }

    $user = User::model()->findByPk(Yii::app()->user->id);
    $nl = new NganluongThecao();
    $nl->charge($_POST['Card']);

    $result = array(
      'success' => false,
      'message' => null
    );

    $credit = new Credit();
    $credit->user_id = $user->id;
    $credit->plus = 0;
    $credit->minus = 0;
    $credit->description = $nl->getMessage();
    $credit->trace = json_encode(array(
      'input' => $nl->getTraceInput(),
      'output' => $nl->getTraceOutput()
    ));

    if($nl->isSuccess()) {
      $credit->plus = $nl->getAmount();
      if($credit->save()) {
        $user->credit = intval($user->credit) + $nl->getAmount();
        if($user->save()){
          $result['success'] = true;
          $result['message'] = ___('Success');
        } else {
          $result['message'] = ___('Internal error');
        }
      } else {
        $result['message'] = ___('Internal error');
      }
    } else {
      $result['message'] = $nl->getMessage();
    }

    $credit->save();

    $result['credit'] = $user->credit;
    $result['credit_format'] = __m($user->credit);

    echo json_encode($result);
    die();
  }

  public function actionChargesuccess() {
    $result = array(
      'credit' => 500000,
      'credit_format' => __m(500000),
      'success' => true,
      'message' => 'Success'
    );

    echo json_encode($result);
    die();
  }

  private function sendConfirmEmail($transaction){
    $reward = $transaction->reward;
    $project = $reward->project;
    $user = $transaction->user;

    $mail = new Email();
    $mail->template = 'order-confirm';
    $mail->subject = 'Chúc mừng bạn!';
    $mail->recipient = $user->email;
    $mail->status = 0;
    $mail->replacement = array(
      "{project-title}" => $project->title,
      "{project-owner}" => $project->user->profile->fullname,
      "{transaction-amount}" => __m($transaction->amount),
      "{reward-desc}" => $reward->description,

      "{transaction-code}" => $transaction->code,
      "{project-permalink}" => $this->createAbsoluteUrl('/project/view', array('id' => $project->id, 'slug'=>$project->slug)),
      "{project-image}" => strpos($project->thumbImage, 'http://') === false ? 'http://ig9.vn'.$project->thumbImage : $project->thumbImage,

      "{twitterUrl}" => 'http://twitter.com/intent/tweet?text='.urlencode(___('I just backed \'%s\' on @ig9vn %s', $project->title, $this->createAbsoluteUrl('project/view', array('id' => $project->id, 'slug' => $project->slug)))),
      "{facebookUrl}" => 'http://facebook.com/sharer/sharer.php?u=' . urlencode($this->createAbsoluteUrl('project/view', array('id' => $project->id, 'slug' => $project->slug))),

      "{user-fullname}" => $user->profile->fullname
    );

    $mail->hash = md5(json_encode($mail->attributes));
    try {
      $mail->save();
    } catch (Exception $e) {

    }
  }

}

?>
