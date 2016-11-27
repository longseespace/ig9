<?php

class Transaction extends AbstractSQLModel {

  const STATUS_PENDING = 0;
  const STATUS_COMPLETED = 1;
  const STATUS_REMOVED = - 1;
  const STATUS_NEED_REFUND = 2;
  const STATUS_REFUNDED = 3;

  private $username;
  private $mobile;
  private $title;
  private $reward_amount;

  private static $baseDigits = "ABCDEFGHIJKLMNOPQRSTUVWXYZ234567";

  public static function model($className = __CLASS__) {
    return parent::model($className);
  }

  public function tableName() {
    return 'transactions';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('gateway', 'safe'),
      array('id, amount, code, gateway, status ,create_time, username, mobile, title, reward_amount', 'safe', 'on' => 'search')
    );
  }
  /**
   * @return array relational rules.
   */
  public function relations() {

    return array(
      'reward' => array(
        self::BELONGS_TO,
        'Reward',
        'reward_id'
      ) ,
      'user' => array(
        self::BELONGS_TO,
        'User',
        'user_id'
      ) ,
    );
  }

  public function behaviors(){
    return array(
      'CTimestampBehavior' => array(
        'class' => 'zii.behaviors.CTimestampBehavior'
      )
    );
  }

  protected function beforeSave() {
    if(empty($this->code)) {
      $this->code = strtoupper(substr(base_convert(strval(time()), 10, 32), -6).sprintf("%03d", rand(0, 1000)));
    }

    return parent::beforeSave();
  }

  public function approve() {
    $this->status = Transaction::STATUS_COMPLETED;
    $userProject = new UserProject();
    $userProject->user_id = $this->user->id;
    $userProject->project_id = $this->reward->project_id;
    $userProject->amount = $this->amount;
    $userProject->save();
  }

  public function remove() {
    if($this->status == self::STATUS_REMOVED) {
      return true;
    }

    if($this->status == self::STATUS_COMPLETED) {
      $reward = $this->reward;
      $reward->backer_count--;
      if(!$reward->save()) {
        $this->messages = $reward->messages;
        return false;
      }

      $project = $reward->project;
      $project->funding_current -= $this->amount;
      if(!$project->save()) {
        $this->messages = $project->messages;
        return false;
      }

      $user_project = UserProject::model()->findByAttributes(array('user_id'=>$this->user->id, 'project_id'=>$project->id));
      if ($user_project && !$user_project->delete()) {
        $this->addErrors($user_project->getErrors());
        return false;
      }
    }

    $this->status = self::STATUS_REMOVED;
    return $this->save();
  }

  public function refund() {
    $credit = new Credit();
    $credit->user_id = $this->user_id;
    $credit->plus = $this->amount;
    $credit->minus = 0;
    $credit->description = 'Refund transaction '.$this->id;
    $credit->trace = json_encode($this->attributes);
    if(!$credit->save()){
      $this->messages = $credit->messages;
      return false;
    }

    $this->status = Transaction::STATUS_REFUNDED;
    return $this->save();
  }

  /**
   * Retrieves a list of models based on the current search/filter conditions.
   * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
   */
  public function search() {
    // Warning: Please modify the following code to remove attributes that
    // should not be searched.

    $criteria=new CDbCriteria;

    $criteria->compare('t.id',$this->id);
    $criteria->compare('t.gateway', $this->gateway);
    $criteria->compare('t.amount', $this->amount);
    $criteria->compare('t.status', $this->status);
    $criteria->compare('t.code', $this->code, true);
    $criteria->compare('t.reward_id', $this->reward_id);
    $criteria->compare('username', $this->getUsername(), true);
    $criteria->compare('mobile', $this->getMobile(), true);
    $criteria->compare('title', $this->getTitle(), true);
    $criteria->compare('Reward.amount', $this->getReward_amount());

    $criteria->with = array('user', 'user.profile', 'reward', 'reward.project');
    $criteria->together = true;
    $criteria->addCondition('gateway <> "" AND t.status != -1');

    return new CActiveDataProvider($this, array(
      'criteria'=>$criteria,
      'sort' => array(
        'defaultOrder'=>'t.id DESC',
      )
    ));
  }

  public static function resolve($name, $value) {
    if ($name == 'status') {
      switch ($value) {
        case self::STATUS_PENDING:
          return 'pending';
        case self::STATUS_COMPLETED:
          return 'completed';
        case self::STATUS_REMOVED:
          return 'removed';
        case self::STATUS_NEED_REFUND:
          return 'need refund';
        case self::STATUS_REFUNDED:
          return 'refunded';
      }
    }
  }

  public function getUsername() {
    if(empty($this->username)) {
      $this->username = $this->user->username;
    }

    return $this->username;
  }

  public function setUsername($username) {
    $this->username = $username;
  }

  public function getMobile() {
    if(empty($this->mobile)) {
      $this->mobile = $this->user->profile->mobile;
    }

    return $this->mobile;
  }

  public function setMobile($mobile) {
    $this->mobile = $mobile;
  }

  public function getTitle() {
    if(empty($this->title)) {
      $this->title = $this->reward->project->title;
    }

    return $this->title;
  }

  public function setTitle($title) {
    $this->title = $title;
  }

  public function getReward_amount() {
    if(empty($this->reward_amount)) {
      $this->reward_amount = $this->reward->amount;
    }

    return $this->reward_amount;
  }

  public function setReward_amount($reward_amount) {
    $this->reward_amount = $reward_amount;
  }


}
