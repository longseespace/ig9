<?php

class I18nMessage extends CActiveRecord {

  public static function model($className=__CLASS__)  {
    return parent::model($className);
  }

  public function tableName()  {
    return 'i18n_messages';
  }

  public function rules() {
    return array(
      array('message', 'unique')
    );
  }

  public function behaviors() {
    return array(
      'timestamp' => array(
        'class' => 'zii.behaviors.CTimestampBehavior'
      )
    );
  }

}