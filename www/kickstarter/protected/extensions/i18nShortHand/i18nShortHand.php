<?php
  class I18nShortHand extends CComponent {

    public static function start(){
      // do no thing, just to yii include this file
    }

    public static function isEnabled(){
      return true;
    }

    public static function trackMessage($message){
      // $controller = Yii::app()->controller->id;
      // $action = Yii::app()->controller->action->id;
      // $i18nMessage = new I18nMessage();
      // $i18nMessage->message = $message;
      // $i18nMessage->controller = $controller;
      // $i18nMessage->action = $action;
      // try{
      //   $i18nMessage->save();
      // }catch(CException $e){

      // }
    }

    public static function generatePoFile() {
      $messages = I18nMessage::model()->findAll();

      header("Cache-Control: public");
      header("Content-Description: File Transfer");
      // header("Content-Length: ". filesize("$name").";");
      header("Content-Disposition: attachment; filename=message.po");
      header("Content-Type: application/octet-stream; ");
      header("Content-Transfer-Encoding: binary");

      foreach ($messages as $message) {
        echo "msgid \"".$message->message."\"\r\n";
        echo "msgstr \"".$message->message."\"\r\n";
        echo "\r\n";
      }

      die();
    }

  }


?>