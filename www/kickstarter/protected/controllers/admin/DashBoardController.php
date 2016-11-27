<?php

class DashBoardController extends AbstractAdminController
{
  /**
   * Init
   */
  public function init()
  {
    parent::init();

    // register css
    // $this->clientScript->registerCssFile($this->themeBaseUrl.'/assets/css/home-page.css');

    // register js
    // $this->clientScript->registerScriptFile($this->themeBaseUrl.'/assets/js/charts/jquery.flot.js');
  }

  /**
   * Declares class-based actions.
   */
  public function actions()
  {
 
  }

  /**
   * This is the default 'index' action that is invoked
   * when an action is not explicitly requested by users.
   */
  public function actionIndex()
  {
    $this->render('index');
  }

  /**
   * This is the action to handle external exceptions.
   */
  public function actionError()
  {
    if($error=Yii::app()->errorHandler->error)
    {
      if(Yii::app()->request->isAjaxRequest)
        echo $error['message'];
      else
        $this->render('error', $error);
    }
  }

  
}