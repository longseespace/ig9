<?php

class Uploader extends CWidget {

  public $targetSelector;
  public $inputClass;
  public $videoId;
  public $videoTitle;
  public $videoDescription;
  private $_assetsUrl;

  public function init() {
    $this->_assetsUrl = Yii::app()->getModule('youtube')->getAssetsUrl();
  }

  public function run() {
    $assetsUrl = Yii::app()->getModule('youtube')->getAssetsUrl();
    $cs = Yii::app()->getClientScript();
    $cs->registerCoreScript('jquery');
    $cs->registerScriptFile($assetsUrl . '/js/swfobject.js');
    $cs->registerScriptFile($assetsUrl . '/js/swfupload.js');
    $cs->registerScriptFile($assetsUrl . '/js/script.js');

    $tokenArray = Yii::app()->getModule('youtube')->generateTokenArray(array(
      'title' => $this->videoTitle,
      'description' => $this->videoDescription
    ));
    $token = $tokenArray['token'];
    $postUrl = $tokenArray['postUrl'];
    $developerTag = $tokenArray['developerTag'];
    $targetSelector = $this->targetSelector;
    $inputClass = $this->inputClass;
    $buttonClass = "customfile-input";
    $videoId = $this->videoId;
    $videoTitle = $this->videoTitle;
    $videoDescription = $this->videoDescription;

    $cs->registerScript('youtube.uploader.init',
      'window.yconfig = '.CJSON::encode(compact("postUrl", "token", "assetsUrl", "targetSelector",
        "inputClass", "developerTag", "buttonClass", "videoTitle", "videoDescription")),
      CClientScript::POS_HEAD);

    $this->render('ajaxform', compact('postUrl', 'token', 'inputClass', 'videoId'));

  }
}