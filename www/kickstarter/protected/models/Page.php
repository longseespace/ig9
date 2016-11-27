<?php
/**
 * Author: Long Doan
 * Date: 8/29/12 10:21 AM
 */
class Page extends AbstractSQLModel {

  public static function model($className=__CLASS__)  {
    return parent::model($className);
  }

  public function tableName()  {
    return 'pages';
  }

  public function rules() {
    return array(
      array('title', 'required'),
      array('slug, content', 'default')
    );
  }

  public function behaviors(){
    return array(
      'timestamp' => array(
        'class' => 'zii.behaviors.CTimestampBehavior',
        'setUpdateOnCreate' => true
      )
    );
  }
}

?>
