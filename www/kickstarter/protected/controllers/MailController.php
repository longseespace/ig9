<?php

class MailController extends AbstractSiteController {

  public function init() {
    parent::init();
  }

  public function actionPreview($template){
    $this->layout = '=.=';
    $this->render($template);
  }

}

?>
