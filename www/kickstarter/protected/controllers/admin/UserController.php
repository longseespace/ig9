<?php

/**
 * Author: Long Doan
 * Date: 8/29/12 10:35 AM
 */
class UserController extends AbstractAdminController {
  const PAGE_SIZE = 10;
  private $moduleName = 'user';

  public function init()  {
    parent::init();
    $cs = Yii::app()->clientScript;
    $cs->defaultScriptFilePosition = CClientScript::POS_END;
    $cs->registerScriptFile($this->assetsUrl.'/js/admin/project.js');
  }

  public function actionIndex() {
    $models = new CActiveDataProvider('User', array(
      'criteria'=>array(
        'with' => array('profile'),
        'together' => true,
      ),

      'pagination'=> array(
        'pageSize'=> self::PAGE_SIZE,
      ),
    ));

    $this->render('index', compact('models'));
  }

  public function actionAdd() {
    $form = new CForm($this->formConfig('UserForm'));
    $form['user']->model = new User;
    $form['profile']->model = new Profile;

    if ($form->submitted('submit') && $form->validate()) {
      $user = $form['user']->model;
      $profile = $form['profile']->model;
      if (!empty($user->password)) {
        $user->password = md5($user->password);
      }
      if($user->save(false))
      {
        $profile->user_id = $user->id;
        $profile->save(false);
        $this->success('Success');
        $this->redirect($this->adminUrl($this->moduleName, 'edit', $user->id));
      } else {
        $this->error($user->errors);
      }
    } else {
      $this->render('add', compact('form'));
    }
  }

  public function actionEdit($id) {
    $model = User::model()->with('profile')->findByPk($id);
    $form = new CForm($this->formConfig('UserForm'));
    $form['user']->model = $model;
    $form['profile']->model = $model->profile;

    if ($form->submitted('submit') && $form->validate()) {
      $user = $form['user']->model;
      $profile = $form['profile']->model;
      if (!empty($user->password)) {
        $user->password = md5($user->password);
      }
      if (!$user->update() || !$profile->update()) {
        $this->error($model->errors . ' ' . $profile->errors);
      } else {
        $this->success('Success');
      }
    }
    $this->render('edit', compact('form'));
  }
}

?>
