<?php

class Category extends AbstractSQLModel {


  public static function model($className=__CLASS__)  {
    return parent::model($className);
  }

  public function tableName()  {
    return 'categories';
  }

  public function behaviors() {
    return array(
      'timestamp' => array(
        'class' => 'zii.behaviors.CTimestampBehavior'
      ),
      // 'nestedSet' => array(
      //   'class' => 'ext.yiiext-nested-set-behavior.NestedSetBehavior'
      // ),
      'multilang' => array(
        'class' => 'application.models.behaviors.MultilingualBehavior',
        'langClassName' => 'CategoryLang',
        'langTableName' => 'category_lang',
        'langForeignKey' => 'category_id',
        'langField' => 'lang_id',
        'localizedAttributes' => array('name', 'slug'),
        'localizedPrefix' => 'l_',
        'languages' => Yii::app()->params['translatedLanguages'], // array of your translated languages. Example : array('fr' => 'Français', 'en' => 'English')
        'defaultLanguage' => Yii::app()->params['defaultLanguage'], //your main language. Example : 'fr'
        'createScenario' => 'insert',
        'localizedRelation' => 'i18nCategory',
        'multilangRelation' => 'multilangCategory',
        'forceOverwrite' => false,
        'forceDelete' => true,
        'dynamicLangClass' => true
      )
    );
  }

  public function relations() {
    return array(
      'projects'=>array(self::HAS_MANY, 'Project', 'category_id'),
      'popularProjects'=>array(self::HAS_MANY, 'Project', 'category_id',
        'limit'=> 3,
        'order'=>'views desc',
        'condition'=>"end_time > NOW()",
        'with'=>'user'
      ),
      'staffPicksProjects'=>array(self::HAS_MANY, 'Project', 'category_id',
        'limit'=> 3,
        'order'=>'staff_pick desc',
        'condition'=>"end_time > NOW() AND featured = 1",
        'with'=>'user'
      ),
      'recentProjects'=>array(self::HAS_MANY, 'Project', 'category_id',
        'limit'=> 3,
        'order'=>'create_time desc',
        'condition'=>"end_time > NOW()",
        'with'=>'user'
      ),
      'endingProjects'=>array(self::HAS_MANY, 'Project', 'category_id',
        'limit'=> 3,
        'order'=>'end_time ASC',
        'condition'=>"end_time > NOW()",
        'with'=>'user'
      ),
      'mostFundedProjects'=>array(self::HAS_MANY, 'Project', 'category_id',
        'limit'=> 3,
        'order'=>'funding_current DESC',
        //'condition'=>"",
        'with'=>'user'
      ),
      'featuredProject'=>array(self::HAS_ONE, 'Project', 'category_id',
        'order' => 'featuredProject.staff_pick DESC, featuredProject.views DESC',
        'condition'=>"end_time > NOW()",
        'with'=>'user'
      ),
    );
  }


  public function findAllWithFeatured() {

    return $this->cache(3600, new CDbCacheDependency("SELECT MAX(update_time) FROM projects WHERE projects.status = 1"))->findAll(array(
      'with' => array('featuredProject', 'featuredProject.user', 'featuredProject.user.profile'),
      'condition' => 'featuredProject.id != 0 AND featuredProject.status = 1',
      'limit' => 20
    ));

  }
  public function findWithFeatured() {

    return $this->findAll(array(
      'with' => array('featuredProject', 'featuredProject.user', 'featuredProject.user.profile'),
      'condition' => 'featuredProject.id != 0 AND featuredProject.status = 1',
      'order'=>'rand()',
      'limit' => 1
    ));

  }




}