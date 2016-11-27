<?php

Yii::import('webroot.protected.helpers.CString');

class ProjectupdateController extends AbstractSiteController {
 
  public $upload_dir;
  public $upload_url;

  public function init() {
    parent::init();

    $this->upload_dir = Yii::app()->basePath . '/../uploads/updates/';
    $this->upload_url = Yii::app()->baseUrl . '/uploads/updates/';
    if (!is_dir($this->upload_dir)) {
      @mkdir($this->upload_dir, 0777);
    }
  }

  public function actionAdd($id) {
    if(!Yii::app()->request->isPostRequest){
      throw new CHttpException(400, 'Bad request');
    }

    $project = Project::model()->findByPk($id);
    if(Yii::app()->user->isGuest || $project->user_id != Yii::app()->user->id){
      throw new CHttpException(403, 'Not authorized');
    }

    $model = new ProjectUpdate();
    $model->attributes = $_POST['comment'];
    $model->project_id = $id;
    $model->save();

    // send message

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

      // Yii::app()->getModule('message')->createMessage($project->user_id, $backer->user->id, 'Cập nhật mới từ dự án ' . $project->title, ___('<p>Project "%s" just got a new update. <a href="%s">Read more...</a></p>', $project->title, $this->createUrl('project/update', array('id' => $model->id))));

      // if (!$backer->user->subscriber) {
      //   continue;
      // }

      $mail = new Email();
      $mail->template = 'project-update';
      $mail->subject = 'Cập nhật mới từ dự án ' . $project->title;
      $mail->recipient = $backer->user->email;
      $mail->status = 0;
      $mail->replacement = array(
        "{project-title}" => $project->title,
        "{project-permalink}" => $this->createAbsoluteUrl('/project/view', array('id' => $project->id, 'slug'=>$project->slug)),
        "{update-title}" => $model->title,
        "{update-permalink}" => $this->createAbsoluteUrl('/project/update', array('id' => $model->id)),
        "{update-excerpt}" => CString::truncate($model->content, 500),
        "{project-image}" => strpos($project->thumbImage, 'http://') === false ? 'http://ig9.vn'.$project->thumbImage : $project->thumbImage,
        "{name}" => trim(array_shift(array_reverse(explode(" ",$backer->user->profile->fullname)))),

        "{twitterUrl}" => 'http://twitter.com/intent/tweet?text='.urlencode(___('I just backed \'%s\' on @ig9vn %s', $project->title, $this->createAbsoluteUrl('project/view', array('id' => $project->id, 'slug' => $project->slug)))),
        "{facebookUrl}" => 'http://facebook.com/sharer/sharer.php?u=' . urlencode($this->createAbsoluteUrl('project/view', array('id' => $project->id, 'slug' => $project->slug)))
      );

      $mail->hash = md5(json_encode($mail->attributes));
      try {
        $mail->save();
      } catch (Exception $e) {

      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      die($model->id);
    }
    $this->redirect(array('project/updates', 'id' => $id));
  }

  public function actionEdit($id) {
    if(!Yii::app()->request->isPostRequest){
      throw new CHttpException(400, 'Bad request');
    }

    $model = ProjectUpdate::model()->with('project')->findByPk($id);
    if (Yii::app()->user->id != $model->project->user_id && !Yii::app()->user->isAdmin()) {
      throw new CHttpException(403, 'Not authorized');
    }
    $model->attributes = $_POST['comment'];
    $model->save();

    if (Yii::app()->request->isAjaxRequest) {
      die($model->id);
    }
    $this->redirect(array('project/updates', 'id' => $model->project_id));
  }

  public function actionDelete($id) {
    if(!Yii::app()->request->isPostRequest){
      throw new CHttpException(400, 'Bad request');
    }

    $model = ProjectUpdate::model()->with('project')->findByPk($id);
    if (Yii::app()->user->id != $model->project->user_id && !Yii::app()->user->isAdmin()) {
      throw new CHttpException(403, 'Not authorized');
    }
    $model->status = 0;
    $model->save();

    if (Yii::app()->request->isAjaxRequest) {
      die($model->id);
    }
    $this->redirect(array('project/updates', 'id' => $model->project_id));
  }

  public function actionUpload() {
    $_FILES['file']['type'] = strtolower($_FILES['file']['type']);

    if ($_FILES['file']['type'] == 'image/png'
        || $_FILES['file']['type'] == 'image/jpg'
        || $_FILES['file']['type'] == 'image/gif'
        || $_FILES['file']['type'] == 'image/jpeg'
        || $_FILES['file']['type'] == 'image/pjpeg') {
      $filename = md5(microtime()).'.jpg';
      $file =  $this->upload_dir . $filename;

      move_uploaded_file($_FILES['file']['tmp_name'], $file);
      $array = array(
        'filelink' => $this->upload_url . $filename
      );

      die(stripslashes(json_encode($array)));
    }
    die();
  }
}
?>
