<?php


class Project extends AbstractModel {

  public $userId;
  public $categoryId;
  public $title;
  public $excerpt;
  public $description;
  public $video;
  public $image;
  public $endTime;
  public $fundingGoal;
  public $fundingCurrent;
  public $rewards;
  public $comments;
  public $activities;
  public $taxonomies;

  /**
   * This method have to be defined in every Model
   * @return string MongoDB collection name, witch will be used to store documents of this model
   */
  public function getCollectionName(){
    return 'projects';
  }

  public function embeddedOne(){
    return array(
      array(
        'baseField' => 'userId',
        'embeddedField' => 'user',
        'embeddedClass' => '\application\models\ProjectEUser',
        'foreignClass' => '\User'
      ),
      array(
        'baseField' => 'categoryId',
        'embeddedField' => 'category',
        'embeddedClass' => '\application\models\Category',
        'foreignClass' => '\application\models\Category'
      )
    );
  }

  public function embeddedMany() {
    return array(
      array(
        'field' => 'rewards',
        'embeddedClass' => '\application\models\ProjectEReward'
      ),
      array(
        'field' => 'comments',
        'embeddedClass' => '\application\models\ProjectEComment'
      )
    );
  }

  public function getTotalBackers() {
    $total = 0;
    foreach($this->rewards as $reward){
      $total += intval($reward->backerCount);
    }
    return $total;
  }

  public function getDayLeft() {
    $now = time();
    $endTime = $this->endTime;
    return round(($endTime - $now)/3600/24);
  }

  /**
   * This method have to be defined in every model, like with normal CActiveRecord
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
}

class ProjectEReward extends AbstractEmbeddedModel {
  public $title;
  public $description;
  public $amount;
  public $deliveryTime;
  public $backerLimit;
  public $backerCount;
}

class ProjectEComment extends AbstractEmbeddedComment {
}

class ProjectEUser extends AbstractEmbeddedModel {
  public $id;
  public $username;
  public $email;
}

class ProjectEActivity extends AbstractEmbeddedModel {
  public $title;
  public $description;
  public function behaviors(){
    return array(
      'comments' => array(
        'class'=>'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
        'arrayPropertyName'=>'comments',
        'arrayDocClassName'=>'\application\models\ProjectEActivityEComment'
      )
    );
  }
}

class ProjectEActivityEComment extends AbstractEmbeddedComment {
}