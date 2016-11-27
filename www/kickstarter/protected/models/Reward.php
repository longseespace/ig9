<?php

class Reward extends AbstractSQLModel {

  public static function model($className=__CLASS__)  {
    return parent::model($className);
  }

  public function tableName()  {
    return 'rewards';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
    return array(
      array('amount, description, delivery_time', 'required'),
      array('amount', 'filter', 'filter' => function($value){
        return m__($value);
      }),
      array('delivery_time', 'date'),
      array('backer_limit', 'numerical'),
      array('backer_limit', 'default', 'value' => -1)
    );
  }

  public function behaviors() {
    return array(
      'timestamp' => array(
        'class' => 'zii.behaviors.CTimestampBehavior',
        'setUpdateOnCreate' => true
      )
    );
  }

  public function relations() {
    return array(
      'project'=>array(self::BELONGS_TO, 'Project', 'project_id'),
    );
  }

  /**
   * Custom Validations
   */

  public function date($attribute, $params)
  {
    $parts = explode('-', $this->$attribute);
    $year = intval($parts[0]);
    $month = intval($parts[1]);
    $day = intval($parts[2]);

    if (!checkdate($month, $day, $year) ) {
      $this->addError($attribute, ___('Delivery Time must be a valid date'));
    };
  }
}