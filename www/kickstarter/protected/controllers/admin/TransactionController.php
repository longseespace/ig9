<?php

/**
 * Author: Long Doan
 * Date: 8/29/12 10:35 AM
 */
class TransactionController extends AbstractAdminController {
  const PAGE_SIZE = 10;
  private $moduleName = 'project';

  public function init()  {
    parent::init();
    $cs = Yii::app()->clientScript;
    $cs->defaultScriptFilePosition = CClientScript::POS_END;
    $cs->registerScriptFile($this->assetsUrl.'/js/admin/project.js');
  }

  public function actionIndex() {
    $model=new Transaction('search');
    $model->unsetAttributes();  // clear any default values

    if(isset($_GET['Transaction'])) {
      $model->attributes=$_GET['Transaction'];
      $model->setTitle($_GET['Transaction']['title']);
      $model->setReward_amount($_GET['Transaction']['reward_amount']);
      $model->setUsername($_GET['Transaction']['username']);
      $model->setMobile($_GET['Transaction']['mobile']);
    }

    $this->render('admin',array(
      'model'=>$model,
    ));
  }

  public function actionApprove($id) {
    $transaction = Transaction::model()->with('user', 'user.profile', 'reward')->findByPk($id);

    if ($transaction === null) {
      return $this->render('approve', array('message' => 'Transaction not found'));
    }

    if(intval($transaction->status) !== Transaction::STATUS_PENDING){
      return $this->render('approve', array('message' => 'Transaction not in pending state'));
    }

    $transaction->status = Transaction::STATUS_COMPLETED;
    // re-check if the backer count break backer limit
    $reward = $transaction->reward;

    if(empty($reward)){
      return $this->endAjax(true, ___("Reward %s not found", array($transaction->reward_id)));
    }

    $dbTransaction = $transaction->getDbConnection()->beginTransaction();

    try {
      if($reward->backer_limit > 0 && $reward->backer_count >= $reward->backer_limit){
        $transaction->status = Transaction::STATUS_NEED_REFUND;
        $transaction->message = "Reward backer limit reached";
        if(!$transaction->save()) {
          throw new CException($transaction->messages);
        }
      }else{
        $transaction->approve();

        if($transaction->save()){
          $reward->backer_count ++;
          if(!$reward->save()) {
            throw new CException($reward->messages);
          }

          $project = $reward->project;
          $project->funding_current += $transaction->amount;
          if(!$project->save()) {
            throw new CException($project->messages);
          }

          $this->addJSVars(array(
              'transaction' => array(
                'id' => $transaction->id,
                'amount' => $transaction->amount,
                'city' => $transaction->user->profile->city,
                'reward_id' => $transaction->reward_id,
                'reward_amount' => $transaction->reward->amount,
              ))
          );

        }else{
          throw new CException($transaction->messages);
        }
      }
    } catch(CException $e) {
      $dbTransaction->rollback();
      return $this->render('approve', array('message' => $e->getMessage()));
    }

    return $this->render('approve', array('message' => ''));
  }

  public function actionRefund($id) {
    $transaction = Transaction::model()->findByPk($id);
    if ($transaction === null) {
      $this->error('Transaction not found');
      $this->redirect(array('index'));
    }

    if(intval($transaction->status) !== Transaction::STATUS_NEED_REFUND){
      $this->error("Transaction not in pending state");
      $this->redirect(array('index'));
    }

    $transaction->status = Transaction::STATUS_REFUNDED;
    if($transaction->save()){
      $this->success('Approved');
    }else{
      $this->error($transaction->errors);
    }

    $this->redirect(array('index'));
  }

  public function actionDelete($id) {
    // if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $model = Transaction::model()->findByPk($id);
      $model->delete();
      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax'])) $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array(
        'index'
      ));
    // } else throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  public function actionRemove($id) {
    $model = Transaction::model()->findByPk($id);

    $dbTransaction = Yii::app()->db->beginTransaction();

    try {
      if(!$model->remove()){
        throw new CException($model->errors);
      }
    } catch(CException $e) {
      $dbTransaction->rollback();
      $this->endAjax(true, $e->getMessage());
    }

    $this->endAjax(false, 'Success');
  }

  public function actionRewards($id) {
    $models = new CActiveDataProvider('Reward', array(
      'criteria'=>array(
        'condition' => 'project_id=' . $id
      ),

      'pagination'=> array(
        'pageSize'=> 100,
      ),
    ));

    $this->render('rewards', compact('models', 'id'));
  }

  public function actionReward($id) {
    $model = Reward::model()->findByPk($id);
    $form = new CForm($this->formConfig('RewardForm'), $model);

    if ($form->submitted('submit') && $form->validate()) {
      if (!$model->update()) {
        $this->error($model->errors);
      } else {
        $this->success('Success');
      }
    }
    $this->render('edit', compact('form') + array('project_id' => $model->project_id));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin() {
    $model=new Transaction('search');
    $model->unsetAttributes();  // clear any default values

    if(isset($_GET['Transaction'])) {
      $model->attributes=$_GET['Transaction'];
      $model->setTitle($_GET['Transaction']['title']);
      $model->setReward_amount($_GET['Transaction']['reward_amount']);
      $model->setUsername($_GET['Transaction']['username']);
      $model->setMobile($_GET['Transaction']['mobile']);
    }

    $this->render('admin',array(
      'model'=>$model,
    ));
  }

  public function actionExport() {

  }

  public function actionNote($id) {
    $model = $this->loadModel($id);

    if($_POST['Transaction']) {
      $model->note = $_POST['Transaction']['note'];
      if($model->save() && Yii::app()->request->isAjaxRequest) {
        return;
      }
    }

    if(Yii::app()->request->isAjaxRequest) {
      $this->renderPartial('_note', compact('model'));
    } else {
      $this->render('_note', compact('model'));
    }

  }

  private function endAjax($error, $message) {
    echo json_encode(compact('error', 'message'));
    die();
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model=Transaction::model()->findByPk($id);
    if($model===null)
      throw new CHttpException(404,'The requested Transaction does not exist.');
    return $model;
  }
}

?>
