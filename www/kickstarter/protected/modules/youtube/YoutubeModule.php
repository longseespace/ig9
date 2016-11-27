<?php

class YoutubeModule extends CWebModule
{

  public $username;
  public $password;
  public $devkey;
  public $application;

  private $_assetsUrl;

  /**
   * Handles publishing of the assets (images etc).
   * @return string URL of assets folder
   */
  public function getAssetsUrl() {
    if ($this->_assetsUrl === null) {
      $this->_assetsUrl = Yii::app()->getAssetManager()->publish(
        Yii::getPathOfAlias('application.modules.youtube.assets')
      );
    }

    return $this->_assetsUrl;
  }

  public function generateTokenArray($options){
    Yii::import('application.modules.youtube.vendor.*');
    require_once 'Zend/Loader.php';
    Zend_Loader::loadClass('Zend_Gdata_YouTube');
    Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

    $module = Yii::app()->getModule('youtube');

    $authenticationURL = 'https://www.google.com/accounts/ClientLogin';
    $httpClient = Zend_Gdata_ClientLogin::getHttpClient(
      $module->username,
      $module->password,
      $service = 'youtube',
      $client = null,
      $module->application,
      $loginToken = null,
      $loginCaptcha = null,
      $authenticationURL);

    $yt = new Zend_Gdata_YouTube($httpClient, '', '', $module->devkey);

    $myVideoEntry= new Zend_Gdata_YouTube_VideoEntry();
    $myVideoEntry->setVideoTitle($options['title']);
    $myVideoEntry->setVideoDescription($options['description']);

    // Note that category must be a valid YouTube category
    $myVideoEntry->setVideoCategory('Comedy');
    $myVideoEntry->SetVideoTags('cars, funny');

    $developerTag = substr(md5(time()), 0, 12);
    $myVideoEntry->addVideoDeveloperTag($developerTag);

    $tokenHandlerUrl = 'http://gdata.youtube.com/action/GetUploadToken';
    $tokenArray = $yt->getFormUploadToken($myVideoEntry, $tokenHandlerUrl);

    return array(
      'token' => $tokenArray['token'],
      'postUrl' => $tokenArray['url'].'?nexturl=http://'.$_SERVER['SERVER_NAME'].'/youtube/default/callback',
      'developerTag' => $developerTag
    );
  }

}
