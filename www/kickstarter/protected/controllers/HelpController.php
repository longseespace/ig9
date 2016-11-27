<?php
/**
 * Author: Long Doan
 * Date: 9/10/12 11:26 AM
 */
class HelpController extends AbstractSiteController {

  public function init() {
    parent::init();

    Yii::app()->clientScript->registerScriptFile($this->assetsUrl."/js/core/jquery.scrollTo-min.js");
    Yii::app()->clientScript->registerScriptFile($this->assetsUrl."/js/jquery.fuckingscroll.js");
    Yii::app()->assetCompiler->registerAssetGroup(array('script.js', 'plugins.js', 'page.js', 'general.less', 'help.less'), $this->assetsUrl);
  }

  public function actionIndex() {
    if (Yii::app()->language === 'vn') {
      $this->render('index-vn');
    } else {
      $this->render('index');
    }
  }

  public function actions() {
    return array(
      'faq' => 'application.controllers.HelpAction',
      'school' => 'application.controllers.HelpAction',
      'guidelines' => 'application.controllers.HelpAction',
      'stats' => 'application.controllers.HelpAction',
      'style_guide' => 'application.controllers.HelpAction',
    );
  }
}

?>
