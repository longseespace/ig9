<?php
/**
 * Author: Long Doan
 * Date: 8/30/12 10:59 AM
 */
class PageController extends AbstractSiteController {

  public function init() {
    parent::init();

    Yii::app()->assetCompiler->registerAssetGroup(array('script.js', 'plugins.js', 'general.less', 'page.less'), $this->assetsUrl);
  }

  public function actionView($slug = '', $id = 0) {
    if ($slug === 'view' || $id != 0) {
      $page = Page::model()->findByPk($id);
    } else {
      $page = Page::model()->findByAttributes(array('slug' => $slug));
    }

    if ($page === null) {
      throw new CHttpException(404, ___('The specified page cannot be found.'));
    }
    $this->render('single', compact('page'));
  }

}

?>
