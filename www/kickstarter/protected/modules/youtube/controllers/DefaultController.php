<?php

class DefaultController extends Controller {

  private function getYoutube(){
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

    return new Zend_Gdata_YouTube($httpClient, '', '', $module->devkey);
  }

  public function actionToken(){
    die(CJSON::encode(Yii::app()->getModule('youtube')->generateTokenArray(array(
      'title' => $_POST['title'],
      'description' => $_POST['description']
    ))));
  }

  public function actionCallback(){
    $this->layout = false;
    echo json_encode($_GET);
    die();
  }

  public function actionCheck(){
    $tag = $_GET['tag'];
    if(empty($tag)){
      die(CJSON::encode(array("message" => ___("Missing tag"))));
    }else{
      $yt = $this->getYoutube();
      $url = 'http://gdata.youtube.com/feeds/api/users/default/uploads';
      $videoFeed = $yt->getVideoFeed($url);
      foreach($videoFeed as $videoEntry){
        $tags = $videoEntry->getVideoDeveloperTags();
        if($tag == $tags[0]){
          die(CJSON::encode(array("id" => $videoEntry->getVideoId(), "state" => $videoEntry->getVideoState()->getReasonCode())));
        }
      }
      die(CJSON::encode(array("message" => ___("Can not find video"))));
    }
  }

  public function actionTest(){
    $yt = $this->getYoutube();
    $url = 'http://gdata.youtube.com/feeds/api/users/default/uploads';
    $videoFeed = $yt->getVideoFeed($url);
    foreach($videoFeed as $videoEntry){
      var_dump($videoEntry->getVideoState());
    }
  }

}