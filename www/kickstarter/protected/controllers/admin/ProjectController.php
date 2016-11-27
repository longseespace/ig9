<?php

/**
 * Author: Long Doan
 * Date: 8/29/12 10:35 AM
 */
class ProjectController extends AbstractAdminController {
  const PAGE_SIZE = 10;
  private $moduleName = 'project';

  public function init()  {
    parent::init();
    $cs = Yii::app()->clientScript;
    $cs->defaultScriptFilePosition = CClientScript::POS_END;
    $cs->registerScriptFile($this->assetsUrl.'/js/admin/project.js');
  }

  public function actionIndex() {
    $model=new Project('search');
    $model->unsetAttributes();  // clear any default values

    if(isset($_GET['Project'])) {
      $model->attributes=$_GET['Project'];
      $model->setCategory_name($_GET['Project']['category_name']);
      $model->setUsername($_GET['Project']['username']);
      // var_dump($model->attributes);
      // var_dump($_GET['Project']);
      // die();
    }

    $this->render('admin',array(
      'model'=>$model,
    ));
  }

  public function actionStaff_pick($id) {
    $model = $this->loadModel($id);
    $model->staff_pick = date("Y-m-d H:i:s");
    if ($model->save()) {
      if(!Yii::app()->request->isAjaxRequest) {
        $this->redirect(array('index'));
      }
    } else {
      throw new CHttpException(500,'Internal server error');
    }
  }

  /**
   * Manages all models.
   */
  public function actionAdmin() {
    $model=new Project('search');
    $model->unsetAttributes();  // clear any default values

    if(isset($_GET['Project'])) {
      $model->attributes=$_GET['Project'];
      $model->setCategory_name($_GET['Project']['category_name']);
      $model->setUsername($_GET['Project']['username']);
      // var_dump($model->attributes);
      // var_dump($_GET['Project']);
      // die();
    }

    $this->render('admin',array(
      'model'=>$model,
    ));
  }

  public function actionAdd() {
    $model = new Project();
    $form = new CForm($this->formConfig('ProjectForm'), $model);

    if ($form->submitted('submit') && $form->validate()) {
      if ($model->insert()) {
        $this->success('Success');
        $this->redirect($this->adminUrl($this->moduleName, 'edit', $model->primaryKey));
      } else {
        $this->error($model->errors);
      }
    } else {
      $this->render('add', compact('form'));
    }
  }

  public function actionAddr($id) {
    $model = new Reward();
    $form = new CForm($this->formConfig('RewardForm'), $model);

    if ($form->submitted('submit') && $form->validate()) {
      $model->project_id = $id;
      if ($model->insert()) {
        $this->success('Success');
        $this->redirect($this->adminUrl($this->moduleName, 'reward', $model->primaryKey));
      } else {
        $this->error($model->errors);
      }
    } else {
      $this->render('add', compact('form') + array('project_id' => $id));
    }
  }

  public function actionEdit($id) {
    $model = Project::model()->findByPk($id);
    $form = new CForm($this->formConfig('ProjectForm'), $model);

    if ($form->submitted('submit') && $form->validate()) {
      if (!$model->update()) {
        $this->error($model->errors);
      } else {
        $this->success('Success');
        $this->redirect(array('edit', 'id' => $id));
      }
    }
    $this->render('edit', compact('form'));
  }

  public function actionApprove($id) {
    $model = Project::model()->findByPk($id);
    if ($model === null) {
      $this->redirect(array('index'));
    }

    if($model->status === Project::STATUS_ACTIVE){
      $this->error('Project already activated');
      $this->redirect(array('index'));
    }

    if($model->status === Project::STATUS_DELETED){
      $this->error('Project already deleted');
      $this->redirect(array('index'));
    }

    if($model->dayLeft === Project::DAYLEFT_ENDED){
      $this->error('Project already end');
      $this->redirect(array('index'));
    }

    $model->status = Project::STATUS_ACTIVE;
    if(!empty($model->duration)){
      $now = time();
      $model->end_time = date('Y:m:d H:i:s', $now + intval($model->duration) * 24 * 3600);
    }

    $model->approve_time = date('Y:m:d H:i:s', $now);

    if($model->save()){
      $this->success('Approved');
    }else{
      $this->error($model->errors);
    }

    $this->redirect(array('index'));
  }

  public function actionDelete($id) {
    // if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $model = Project::model()->findByPk($id);
      $model->delete();
      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax'])) $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array(
        'index'
      ));
    // } else throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
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

  public function actionRefund($id) {
    $project = $this->loadModel($id);

    if ($project->status != Project::STATUS_ACTIVE) {
      $this->endAjax(true, 'Wrong status');
    }

    $now = time();
    $endTime = strtotime($project->end_time);

    if($now < $endTime){
      $this->endAjax(true, 'Project is active');
    }

    $criteria = new CDbCriteria();
    $criteria->with = array('reward');
    $criteria->addCondition('reward.project_id = '.$id);
    $criteria->addCondition('t.status = '.Transaction::STATUS_COMPLETED);
    $criteria->together = true;
    $transactions = Transaction::model()->findAll($criteria);

    $dbTransaction = $project->getDbConnection()->beginTransaction();

    try {
      foreach($transactions as $transaction) {
        $credit = new Credit();
        $credit->user_id = $transaction->user_id;
        $credit->plus = $transaction->amount;
        $credit->minus = 0;
        $credit->description = 'Refund transaction '.$transaction->id;
        $credit->trace = json_encode($transaction->attributes);

        if(!$credit->save()){
          throw new CException($credit->messages);
        }

        $user = User::model()->findByPk($transaction->user_id);
        $user->credit += $transaction->amount;
        if(!$user->save()){
          throw new CException($user->messages);
        }

        $transaction->status = Transaction::STATUS_REFUNDED;
        if(!$transaction->save()) {
          throw new CException($transaction->messages);
        }
      }

      $project->status = Project::STATUS_REFUNDED;
      if(!$project->save()) {
        throw new CException($project->messages);
      }
    } catch(CException $e) {
      $dbTransaction->rollback();
      $this->endAjax(true, $e->getMessage());
    }

    $this->endAjax(false, 'Refund success with '.count($transactions).' transactions');
  }

  public function actionSendFailMail($id){
    $project = $this->loadModel($id);
    $backers = UserProject::model()->findAll(array(
      'with'=>array(
        'user',
        'project'=>array(
          'select'=>false,
          'condition'=>'project_id=' . $id
        ),
      ),
      'group' => 't.user_id',
      'together'=>true,
    ));

    foreach ($backers as $backer) {
      $mail = new Email();
      $mail->template = 'project-fail';
      $mail->subject = 'Dự án '.$project->title.' đã kết thúc';
      $mail->recipient = $backer->user->email;
      $mail->status = 0;
      $name = empty($backer->user->profile->fullname) ? 'bạn' : trim(array_shift(array_reverse(explode(" ",$backer->user->profile->fullname))));
      $mail->replacement = array(
        "{project-title}" => $project->title,
        "{project-permalink}" => $this->createAbsoluteUrl('/project/view', array('id' => $project->id, 'slug' => $project->slug)),
        "{name}" => $name,
        "{amount}" => __m($backer->amount)
      );

      $mail->hash = md5(json_encode($mail->attributes));
      try {
        $mail->save();
      } catch (Exception $e) {

      }
    }

    $this->endAjax(false, count($backers).' mail(s) sent');
  }

  public function actionSendSuccessMail($id){
    $project = $this->loadModel($id);
    $backers = UserProject::model()->findAll(array(
      'with'=>array(
        'user',
        'project'=>array(
          'select'=>false,
          'condition'=>'project_id=' . $id
        ),
      ),
      'group' => 't.user_id',
      'together'=>true,
    ));

    foreach ($backers as $backer) {
      $reward = false;
      foreach ($backer->user->transactions as $transaction) {
        if ($transaction->reward->project->id === $backer->project_id) {
          $reward = $transaction->reward;
          break;
        }
      };

      if (!$reward) {
        continue;
      }

      $mail = new Email();
      $mail->template = 'project-success';
      $mail->subject = 'Dự án '.$project->title.' đã gọi vốn thành công!';
      $mail->recipient = $backer->user->email;
      $mail->status = 0;
      $name = empty($backer->user->profile->fullname) ? 'bạn' : trim(array_shift(array_reverse(explode(" ",$backer->user->profile->fullname))));
      $owner = empty($project->user->profile->fullname) ? $project->user->username : $project->user->profile->fullname;
      $mail->replacement = array(
        "{project-title}" => $project->title,
        "{project-permalink}" => $this->createAbsoluteUrl('/project/view', array('id' => $project->id, 'slug' => $project->slug)),
        "{name}" => $name,
        "{owner}" => $owner,
        "{reward}" => $reward->description
      );

      $mail->hash = md5(json_encode($mail->attributes));
      try {
        $mail->save();
      } catch (Exception $e) {

      }
    }

    $this->endAjax(false, count($backers).' mail(s) sent');
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
    $model=Project::model()->findByPk($id);
    if($model===null)
      throw new CHttpException(404,'The requested Employee does not exist.');
    return $model;
  }
}

?>
