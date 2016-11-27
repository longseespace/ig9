<?php

/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
 * @property integer $id
 * @property string $content
 * @property integer $status
 * @property string $create_time
 * @property string $author
 * @property string $email
 * @property string $url
 * @property integer $post_id
 */
class Comment extends CActiveRecord
{
	const STATUS_PENDING = 1;
	const STATUS_APPROVED = 2;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content', 'required'),
			array('author_name, email, url', 'length', 'max'=>255),
			array('email', 'email'),
			array('url', 'url'),
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
			'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'content' => 'Comment',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'author_name' => 'Name',
			'email' => 'Email',
			'url' => 'Website',
			'post_id' => 'Post',
			'author_id' => 'Author',
		);
	}

	/**
	* Before save
	*/
  public function behaviors() {

    return array(
      'timestamp' => array(
        'class' => 'zii.behaviors.CTimestampBehavior'
      ),
  	);
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('author_name',$this->author_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('post_id',$this->post_id);
		$criteria->compare('author_id',$this->author_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function approve()
	{
		$this->status = Comment::STATUS_APPROVED;
		$this->update(array('status'));
	}
}