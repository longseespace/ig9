<?php

class Project extends AbstractSQLModel {

  const STATUS_INACTIVE = 0;
  const STATUS_ACTIVE = 1;
  const STATUS_DELETED = -1;
  const STATUS_REFUNDED = 2;

  const DAYLEFT_UNAPPROVED = -1;
  const DAYLEFT_ENDED = -2;

  private $username;
  private $category_name;

  public static function model($className=__CLASS__)  {
    return parent::model($className);
  }

  public function tableName()  {
    return 'projects';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
    if (strpos(Yii::app()->controller->id, 'admin') === 0) {
      return array(
        array('title, excerpt', 'required'),
        array('title, excerpt, slug, description, image_url, video, end_time, duration, funding_goal, featured, status', 'default'),
        array('id, username, title, category_name, end_time, funding_current, views, status', 'safe', 'on' => 'search'),
      );
    }
    return array(
      array('title, category_id, excerpt, funding_goal, phone', 'required', 'on' => 'basics'),
      // array('image', 'file', 'allowEmpty' => true, 'types' => 'jpg,jpeg,png,gif', 'on' => 'basics'),
      array('end_time', 'filter', 'filter' => function($value){
        if (empty($value)) {
          return '';
        }
        return d__($value);
      }, 'on' => 'basics'),
      array('funding_goal', 'filter', 'filter' => function($value){
        return m__($value);
      }, 'on' => 'basics'),
      array('duration', 'numerical', 'min' => 1, 'max' => 60, 'on' => 'basics'),
      array('description, video, videoUrl', 'safe', 'on' => 'story'),
      array('personal_description', 'safe', 'on' => 'aboutyou'),
      array('id, username, title, category_name, end_time, funding_current, views, status', 'safe', 'on' => 'search'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations()
  {
    return array(
      'user' => array(self::BELONGS_TO, 'User', 'user_id'),
      'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
      'rewards' => array(self::HAS_MANY, 'Reward', 'project_id', 'order' => 'rewards.amount ASC'),
      'userprojects'=>array(self::HAS_MANY,'UserProject','project_id'),
      'backers'=>array(self::HAS_MANY,'User',array('user_id'=>'id'),'through'=>'userprojects'),
      'updates'=>array(self::HAS_MANY,'ProjectUpdate','project_id'),
      'comments'=>array(self::HAS_MANY,'ProjectComment','project_id'),
      'updateCount'=>array(self::STAT,'ProjectUpdate','project_id', 'condition' => ' t.status = 1'),
      'backerCount'=>array(self::STAT,'UserProject','project_id'),
      'commentCount'=>array(self::STAT,'ProjectComment','project_id'),
    );
  }

  public function behaviors() {
    return array(
      'timestamp' => array(
        'class' => 'zii.behaviors.CTimestampBehavior',
        'setUpdateOnCreate' => true
      ),
      'slugBehavior' => array(
        'class' => 'application.models.behaviors.SlugBehavior',
        'slug_col' => 'slug',
        'title_col' => 'title',
        'overwrite' => true,
        'changeable_check' => 'slugChangeable'
      ),
      'imageBehavior' => array(
        'class' => 'ImageARBehavior',
        'attribute' => 'image', // this must exist
        'extension' => 'png, gif, jpg', // possible extensions, comma separated
        'prefix' => 'project_',
        'relativeWebRootFolder' => 'uploads', // this folder must exist
        // 'useImageMagick' => '/usr/bin',
        'formats' => array(
          'thumb' => array(
            'suffix' => '_thumb',
            'process' => array('resize' => array(286, 215, 1))
          ),
          'big' => array(
            'suffix' => '_big',
            'process' => array('resize' => array(620, 466, 1))
          ),
          'large' => array(
          ),
        ),
        'defaultName' => 'default'
      )
    );
  }

  public function slugChangeable() {
    return $this->status != Project::STATUS_ACTIVE;
  }

  public function getBackerCount() {
    $total = 0;
    foreach($this->rewards as $reward){
      $total += intval($reward->backer_count);
    }
    return $total;
  }

  public function getDayLeft() {
    if(!empty($this->duration) && $this->status == self::STATUS_INACTIVE){
      return -1;
    }

    $now = time();
    $endTime = strtotime($this->end_time);

    if($now > $endTime){
      return -2;
    }

    return round(($endTime - $now)/3600/24);
  }

  public function isEnd() {
    $now = time();
    $endTime = strtotime($this->end_time);

    if($now > $endTime){
      return true;
    } else {
      return false;
    }
  }

  public function getHourLeft() {
    if(!empty($this->duration) && $this->status == self::STATUS_INACTIVE){
      return -1;
    }

    $now = time();
    $endTime = strtotime($this->end_time);

    if($now > $endTime){
      return -2;
    }

    return round(($endTime - $now)/3600);
  }

  public function getTimeLeft() {
    if(!empty($this->duration) && $this->status == self::STATUS_INACTIVE){
      return ___("inactive");
    }

    $now = time();
    $endTime = strtotime($this->end_time);

    if($now > $endTime){
      return ___("End");
    }

    if($endTime - $now < 3600 * 24) {
      return ___("%s hours", round(($endTime - $now)/3600));
    } else {
      return ___("%s days", round(($endTime - $now)/3600/24));
    }
  }

  public function isTimeLeftLessThan1Day() {
    $now = time();
    $endTime = strtotime($this->end_time);

    if($now > $endTime){
      return false;
    }

    return ($endTime - $now < 3600 * 24);
  }

  public function getFundingRatio() {
    if(empty($this->funding_goal)){
      return 0;
    }else{
      return $this->funding_current / $this->funding_goal;
    }
  }

  public function findFeatureByCategory($categoryId){
    $criteria = new CDbCriteria;
    $criteria->condition='category_id=:categoryId AND status=:status';
    $criteria->params=array(
      ':categoryId'=>$categoryId,
      ':status' => Project::STATUS_ACTIVE
    );
    $criteria->order = 'create_time DESC';
    return $this->find($criteria);
  }

  public function findAllPopular($category = null, $limit = 4){
    $qc = "";
    if ($category!=null) {
      $qc = " AND category_id=".$category;
    }

    return $this->with('user')->findAll(array(
      'limit' => $limit,
      'order' => 'views DESC',
      'condition' => "end_time > NOW()".$qc. " AND t.status = 1"
    ));
  }

  public function findAllStaffPicks($category = null, $limit = 3) {
    $qc = "";
    if ($category!=null) {
      $qc = " AND category_id=".$category;
    }

    return $this->with('user')->findAll(array(
      'limit' => $limit,
      'order' => 'staff_pick DESC, views DESC',
      'condition' => 'featured = 1'.$qc. " AND t.status = 1"
    ));

  }

  public function findAllRecent($category = null, $limit = 3) {
    $qc = "";
    if ($category!=null) {
      $qc = " AND category_id=".$category;
    }

    return $this->with('user')->findAll(array(
      'limit' => $limit,
      'order' => 'create_time ASC',
      'condition' => 'end_time > NOW()'.$qc. " AND t.status = 1"
    ));

  }

  public function findAllEnding($category = null, $limit = 3) {
    $qc = "";
    if ($category!=null) {
      $qc = " AND category_id=".$category;
    }

    return $this->with('user')->findAll(array(
      'limit' => $limit,
      'order' => 'end_time ASC',
      'condition' => 'end_time > NOW()'.$qc. " AND t.status = 1"
    ));

  }

  public function findAllMostFunded($category = null, $limit = 3) {
    $qc = "";
    if ($category!=null) {
      $qc = " AND category_id=".$category;
    }

    return $this->with('user')->findAll(array(
      'limit' => $limit,
      'order' => 'funding_current DESC',
      'condition' => '1'.$qc. " AND t.status = 1"
    ));

  }


  public function findAllSuccess($category = null, $limit = 3) {
    $qc = "";
    if ($category!=null) {
      $qc = " AND category_id=".$category;
    }
    return $this->with('user')->findAll(array(
      'limit' => $limit,
      'order' => 'staff_pick DESC, views DESC',
      'condition' => "funding_current >= funding_goal".$qc. " AND t.status = 1"
    ));
  }

  public function findAllActive($category = null, $limit = 3) {
    $qc = "";
    if ($category!=null) {
      $qc = " AND category_id=".$category;
    }
    return $this->with('user')->findAll(array(
      'limit' => $limit,
      'condition' => "end_time > NOW()" .$qc. " AND t.status = 1"
    ));
  }

  public function getImage(){
    $image = $this->imageBehavior->getFileUrl('large');
    if(!empty($image)){
      return $image;
    }else{
      return $this->image_url;
    }
  }

  public function getThumbImage(){
    $image = $this->imageBehavior->getFileUrl('thumb');
    if(!empty($image)){
      return $image;
    }else{
      return $this->image_url;
    }
  }

  public function getBigImage(){
    $image = $this->imageBehavior->getFileUrl('big');
    if(!empty($image)){
      return $image;
    }else{
      return $this->image;
    }
  }

  public function getVideoUrl(){
    return empty($this->video) ? '' : 'http://www.youtube.com/watch?v='.$this->video;
  }

  public function getStartTime() {
    if(!empty($this->approve_time)) {
      return $this->approve_time;
    } else {
      return $this->create_time;
    }
  }

  public function setVideoUrl($url){
    $parsedUrl = parse_url($url);
    $query = $parsedUrl['query'];
    parse_str($query);
    if(!empty($v)){
      $this->video = $v;
    }
  }

  public function isBackedBy($userId){
    $userProject = UserProject::model()->findByAttributes(array(
      'user_id' => $userId,
      'project_id' => $this->id
    ));

    return ($userProject !== null);
  }

  public static function resolve($name, $value) {
    if ($name == 'status') {
      switch ($value) {
        case self::STATUS_ACTIVE:
          return 'active';
        case self::STATUS_INACTIVE:
          return 'inactive';
        case self::STATUS_DELETED:
          return 'delete';
        case self::STATUS_REFUNDED:
          return 'refunded';
      }
    }
    else if ($name == 'dayLeft') {
      switch ($value) {
        case self::DAYLEFT_ENDED:
          return 'ended';
        case self::DAYLEFT_UNAPPROVED:
          return 'unapproved';
        default:
          return 'on going';
      }
    }
  }

  public function scopes() {
    return array(
      'active' => array(
        'condition' => 't.status = '.self::STATUS_ACTIVE
      )
    );
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
    $criteria->compare('user.username', $this->username, true);
    $criteria->compare('t.title', $this->title, true);
    $criteria->compare('category.name', $this->category_name, true);
    $criteria->compare('t.end_time', $this->end_time, true);
    $criteria->compare('t.funding_current', $this->funding_current);
    $criteria->compare('t.views', $this->views);
    $criteria->compare('t.status', $this->status);

    $criteria->with = array('user', 'category');
    $criteria->together = true;
    $criteria->addCondition('t.status != -1');
    // $criteria->compare('title', $this->getTitle(), true);
    // $criteria->compare('Reward.amount', $this->getReward_amount());

    // $criteria->with = array('user', 'user.profile', 'reward', 'reward.project');
    // $criteria->together = true;
    // $criteria->addCondition('gateway <> "" AND t.status != -1');

    return new CActiveDataProvider($this, array(
      'criteria'=>$criteria
    ));
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

  public function getCategory_name() {
    if(empty($this->category_name)) {
      $this->category_name = $this->category->name;
    }

    return $this->category_name;
  }

  public function setCategory_name($category_name) {
    $this->category_name = $category_name;
  }

}