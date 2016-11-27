<?php

Yii::import('ext.image.Image');

class ProfileController extends Controller {
  public $defaultAction = 'profile';

  /**
   * @var CActiveRecord the currently loaded data model instance.
   */
  public $_model;

  /**
   * Shows a particular model.
   */
  public function actionProfile($id = 0) {
    if ($id == 0) {
      $this->loadUser();
    } else {
      $this->_model = User::model()->with('profile')->findByPk($id);
    }

    if (Yii::app()->user && Yii::app()->user->id == $this->_model->id) {
      $project = Project::model()->findAll(' t.user_id = ' . $this->_model->id);
    } else {
      $project = Project::model()->findAll(' t.user_id = ' . $this->_model->id . ' AND t.status = ' . Project::STATUS_ACTIVE);
      $this->_model->backedCount = Yii::app()->db->createCommand('SELECT COUNT(DISTINCT user_id) FROM user_project WHERE user_id = ' . $this->_model->id)->queryScalar();
    }

    $this->render('profile', array('model' => $this->_model, 'profile' => $this->_model->profile, 'projects' => $project));
  }


  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   */
  public function actionEdit($needcrop = false) {
    $model = $this->loadUser();
    $profile = $model->profile;

    // ajax validator
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'profile-form') {
      echo UActiveForm::validate(array($model, $profile));
      Yii::app()->end();
    }

    if (isset($_POST['User'])) {
      $model->attributes = $_POST['User'];
      $profile->attributes = $_POST['Profile'];

      if ($model->validate() && $profile->validate()) {
        $model->save();
        $profile->save();
        Yii::app()->user->setFlash('profileMessage', UserModule::t("Profile updated."));

        if (isset($_POST['needcrop'])) {
          $this->redirect(array('/user/profile/edit?needcrop=1'));
        } else {
          $this->redirect(array('/user/profile/edit'));
        }

      } else $profile->validate();
    }

    if (Yii::app()->user->id) {
      $password = new UserChangePassword;

      // ajax validator
      if (isset($_POST['ajax']) && $_POST['ajax'] === 'changepassword-form') {
        echo UActiveForm::validate($password);
        Yii::app()->end();
      }

      if (isset($_POST['UserChangePassword'])) {
        $password->attributes = $_POST['UserChangePassword'];
        if ($password->validate()) {
          $new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
          $new_password->password = UserModule::encrypting($password->password);
          $new_password->activkey = UserModule::encrypting(microtime() . $password->password);
          $new_password->save();
          Yii::app()->user->setFlash('profileMessage', UserModule::t("New password is saved."));
          $this->redirect(array("profile/edit"));
        }
        Yii::app()->user->setFlash('profileMessage', UserModule::t("Could not save password."));
      }
    }

    $this->addJSVars(compact('needcrop'));

    $this->render('edit', array('model' => $model, 'profile' => $profile, 'password' => $password));
  }

  public function actionCrop()
  {
    if (isset($_POST['x'])) {
      extract($_POST);

      $x = intval($x); $y = intval($y); $w = intval($w); $h = intval($h);

      $user = $this->loadUser();

      $fpath = $user->avatarBehavior->getFilePath();
      $thumbpath = $user->avatarBehavior->getFilePath('thumb');
      $originalpath = $user->avatarBehavior->getFilePath('original');

      $image = new Image($originalpath);
      $image->crop($w, $h, $y, $x)->resize(100, null)->save($fpath);
      
      $image = new Image($fpath);
      $image->resize(50, null)->save($thumbpath);
    }
  }

  /**
   * Change password
   */
  public function actionChangepassword() {
    if (Yii::app()->user->id) {
      $model = new UserChangePassword;

      // ajax validator
      if (isset($_POST['ajax']) && $_POST['ajax'] === 'changepassword-form') {
        echo UActiveForm::validate($model);
        Yii::app()->end();
      }

      if (isset($_POST['UserChangePassword'])) {
        $model->attributes = $_POST['UserChangePassword'];
        if ($model->validate()) {
          $new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
          $new_password->password = UserModule::encrypting($model->password);
          $new_password->activkey = UserModule::encrypting(microtime() . $model->password);
          $new_password->save();
          Yii::app()->user->setFlash('profileMessage', UserModule::t("New password is saved."));
          $this->redirect(array("profile/edit"));
        }
      }
//      $this->render('changepassword', array('model' => $model));
      $this->redirect(array("profile/edit"));
    }
  }

  // 
  // Update notification pref
  // 
  public function actionSubscribe(){
    $model = User::model()->findByPk(Yii::app()->user->id);
    $profile = $model->profile;

    if (Yii::app()->user->id && isset($_POST['User'])) {
      $model->subscriber = $_POST['User']['subscriber'];
      if ($model->save(false, 'subscriber')) {
        Yii::app()->user->setFlash('profileMessage', ___("Notification settings updated."));
      } else {
        Yii::app()->user->setFlash('profileMessage', ___("An error occurred."));
      }
    }

    $this->redirect(array("profile/edit"));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
   */
  public function loadUser() {
    if ($this->_model === null) {
      if (Yii::app()->user->id) $this->_model = Yii::app()->controller->module->user();
      if ($this->_model === null) $this->redirect(Yii::app()->controller->module->loginUrl);
    }
    return $this->_model;
  }
}