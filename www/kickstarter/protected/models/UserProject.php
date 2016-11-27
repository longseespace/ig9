<?php

class UserProject extends AbstractSQLModel {

  public static function model($className=__CLASS__)  {
    return parent::model($className);
  }

  public function tableName()  {
    return 'user_project';
  }

  /**
   * @return array relational rules.
   */
  public function relations()
  {
    return array(
      'user' => array(self::BELONGS_TO, 'User', 'user_id'),
      'project' => array(self::BELONGS_TO, 'Project', 'project_id'),
    );
  }

  public function behaviors() {
    return array(
      'timestamp' => array(
        'class' => 'zii.behaviors.CTimestampBehavior',
        'setUpdateOnCreate' => true
      ),
    );
  }

}