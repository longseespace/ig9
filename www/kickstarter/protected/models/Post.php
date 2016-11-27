<?php

class Post extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Post the static model class
	 */

	private $_oldTag;
	const STATUS_DRAFT = 1;
	const STATUS_PUBLISHED = 2;
	const STATUS_ARCHIVED = 3;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'post';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, status, content', 'required'),
			array('status, category_id, author_id', 'numerical', 'integerOnly'=>true),
			array('title, source, slug, tags', 'length', 'max'=>255),
			array('tags', 'match', 'pattern'=>'/^[\w\s,]+$/', 'message'=>'Tags can only contain word characters.'),
			array('tags', 'normalizeTags'),
			array('status', 'in', 'range'=>array(1,2,3)),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('title, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
      'category' => array(self::BELONGS_TO, 'NewsCategory', 'category_id'),
			'comments' => array(self::HAS_MANY, 'Comment','post_id',
				'condition'=>'comments.status='.Comment::STATUS_APPROVED,
				'order'=>'comments.create_time DESC'),
			'commentCount' => array(self::STAT, 'Comment', 'post_id',
				'condition'=>'status='.Comment::STATUS_APPROVED),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'slug' => 'Slug',
			'content' => 'Content',
			'tags' => 'Tags',
			'category_id'=>'Category',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'author_id' => 'Author',
      'source' =>'Source',
		);
	}

	/**
	* Create before save function to add some attributes we don't need user provide
	*/
	protected function beforeSave()
	{
		if (parent::beforeSave()) {
			if (!empty($this->content)) {
				$pattern = '/<img(.*?)>/';
				$images= array();
				preg_match($pattern, $this->content,$images);
				$this->image = $images[0];
			}
			if ($this->isNewRecord) {
				$this->create_time = $this->update_time = date('Y-m-d h:m:s');
			}
			else
				$this->update_time = date('Y-m-d h:m:s');
			return parent::beforeSave();
		}
		else
			return false;
	}

  public static function resolve($name, $value) {
    if ($name == 'status') {
      switch ($value) {
        case 1:
          return 'inactive';
        case 2:
          return 'active';
        case 3:
          return 'archived';
      }
    }
  }
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('author_id',$this->author_id);
    $criteria->compare('source',$this->source);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

  public function scopes() {
    return array(
      'news' => array(
        'condition'=>'',
        'order'=>'t.id DESC',
      ),
    );
  }

  public function behaviors() {

    return array(
      'SlugBehavior' => array(
        'class' => 'application.models.behaviors.SlugBehavior',
        'title_col' => 'title'
      )
      // 'taggable' => array(
      //   'class' => 'ext.yiiext-taggable-behavior.ETaggableBehavior',
      //   'tagTable' => 'skills',
      //   'tagBindingTable' => 'resume_skills',
      //   'modelTableFk' => 'resume_id',
      //   'tagTablePk' => 'id',
      //   'tagTableName' => 'name',
      //   'tagBindingTableTagId' => 'skill_id',
      //   'cacheID' => 'cache',
      //   'createTagsAutomatically' => true,
      // )
    );
  }

	public function normalizeTags($attribute,$params)
	{
    $this->tags=Tag::array2string(array_unique(Tag::string2array($this->tags)));
	}

	public function getUrl()
	{
		return Yii::app()->createUrl('post/view',array(
			'id'=>$this->id,
			'title'=>$this->title,	
		));
	}

	public function addComment($comment)
	{
		if (Yii::app()->params['commentNeedApproval']) 
		{
			$comment->status = Comment::STATUS_PENDING;
		}
		else
			$comment->status = Comment::STATUS_APPROVED;
		$comment->post_id = $this->id;
		return $comment->save();
	}
	 public function data(array $data = array()) {
    if (!empty($data)) {
      foreach (array_intersect_key($data, $this->attributes) as $x => $y) {
        $this->$x = $y;
      }
      return $this;
    }
    return $this->attributes;
  }
}