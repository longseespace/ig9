<?php

/**
 * Author: Long Doan
 * Date: 8/29/12 10:35 AM
 */
class PageController extends AbstractAdminController {
  private $moduleName = 'page';

  public function init()  {
    parent::init();
    $cs = Yii::app()->clientScript;
    $cs->defaultScriptFilePosition = CClientScript::POS_END;
    $cs->registerScriptFile($this->assetsUrl.'/js/admin/page.js');
  }

  public function actionIndex() {
    $pages = Page::model()->findAll();
    $this->render('index', compact('pages'));
  }

  public function actionAdd() {
    $model = new Page();
    $form = new CForm($this->formConfig('PageForm'), $model);

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

  public function actionEdit($id) {
    $model = Page::model()->findByPk($id);
    $form = new CForm($this->formConfig('PageForm'), $model);

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

  public function actionDelete($id) {
    if (Page::model()->deleteByPk($id) < 1) {
      $this->error(___('Cannot delete'));
    }
    $this->redirect($this->adminUrl($this->moduleName));
  }
}

?>
