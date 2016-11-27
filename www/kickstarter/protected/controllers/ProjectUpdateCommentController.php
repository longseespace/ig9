<?php

class ProjectupdatecommentController extends AbstractSiteController {
 
  public function actionAdd($id) {
    if(!Yii::app()->request->isPostRequest){
      throw new CHttpException(400, 'Bad request');
    }

    if(Yii::app()->user->isGuest){
      throw new CHttpException(403, 'Not authorized');
    }

    $model = new ProjectUpdateComment();
    $_POST['comment']['content'] = strip_tags($_POST['comment']['content']);
    $model->attributes = $_POST['comment'];
    $model->user_id = Yii::app()->user->id;
    $model->update_id = $id;
    $model->save();

    if (Yii::app()->request->isAjaxRequest) {
      die($model->id);
    }
    $this->redirect(array('project/update', 'id' => $id));
  }

  public function actionEdit($id) {
    if(!Yii::app()->request->isPostRequest){
      throw new CHttpException(400, 'Bad request');
    }

    $model = ProjectUpdateComment::model()->findByPk($id);
    if (Yii::app()->user->id != $model->user_id && !Yii::app()->user->isAdmin()) {
      throw new CHttpException(403, 'Not authorized');
    }
    $_POST['comment']['content'] = strip_tags($_POST['comment']['content']);
    $model->attributes = $_POST['comment'];
    $model->save();

    if (Yii::app()->request->isAjaxRequest) {
      die($model->id);
    }
    $this->redirect(array('project/update', 'id' => $model->update_id));
  }

  public function actionDelete($id) {
    if(!Yii::app()->request->isPostRequest){
      throw new CHttpException(400, 'Bad request');
    }

    if (!Yii::app()->user->isAdmin()) {
      throw new CHttpException(403, 'Not authorized');
    }

    $model = ProjectUpdateComment::model()->findByPk($id);
    $model->delete();

    if (Yii::app()->request->isAjaxRequest) {
      die($model->id);
    }
    $this->redirect(array('project/update', 'id' => $model->update_id));
  }
}

?>
