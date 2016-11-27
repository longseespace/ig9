<?php

/**
 * Author: Long Doan
 * Date: 8/29/12 10:35 AM
 */
class FileController extends AbstractAdminController {

  public $upload_dir;
  public $upload_url;

  public function init() {
    parent::init();

    $this->upload_dir = Yii::app()->basePath . '/../uploads/images/';
    $this->upload_url = Yii::app()->baseUrl . '/uploads/images/';
    if (!is_dir($this->upload_dir)) {
      @mkdir($this->upload_dir, 0777);
    }
  }

  public function actions() {
    return array(
      'elfinder.' => 'widgets.elfinder.FinderWidget',
    );
  }

  public function actionUpload() {
    $_FILES['file']['type'] = strtolower($_FILES['file']['type']);

    if ($_FILES['file']['type'] == 'image/png'
        || $_FILES['file']['type'] == 'image/jpg'
        || $_FILES['file']['type'] == 'image/gif'
        || $_FILES['file']['type'] == 'image/jpeg'
        || $_FILES['file']['type'] == 'image/pjpeg') {
      $filename = md5(microtime()).'.jpg';
      $file =  $this->upload_dir . $filename;

      move_uploaded_file($_FILES['file']['tmp_name'], $file);
      $array = array(
        'filelink' => $this->upload_url . $filename
      );

      die(stripslashes(json_encode($array)));
    }
    die();
  }

  public function actionImages() {
    $images = array();

    $handler = opendir($this->upload_dir);

    while ($file = readdir($handler))
    {
      if ($file != "." && $file != "..") {
        $images[] = $file;
      }
    }
    closedir($handler);

    $jsonArray=array();

    foreach($images as $image)
      $jsonArray[]=array(
        'image'=>$this->upload_url . $image,
        'thumb'=>$this->upload_url . $image,
      );

    header('Content-type: application/json');
    die(CJSON::encode($jsonArray));
  }

  public function actionIndex() {
    if (!is_dir(Yii::app()->basePath . '/../uploads/file')) {
      @mkdir(Yii::app()->basePath . '/../uploads/file', 0755, true);
    }
    $this->render('index');
  }
}

?>
