<?php

/**
 * This is the model class for table "feedbacks".
 *
 * The followings are the available columns in table 'feedbacks':
 * @property string $id
 * @property string $email
 * @property integer $score
 * @property string $website_message
 * @property string $product_message
 * @property string $service_message
 * @property string $payment_message
 * @property string $other_message
 * @property string $url
 * @property string $ip
 * @property string $user_agent
 * @property string $created
 */
class Feedback extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Feedback the static model class
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
		return 'feedbacks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('score', 'numerical', 'integerOnly'=>true),
			array('email, ip', 'length', 'max'=>255),
			array('website_message, product_message, service_message, payment_message, other_message, url, user_agent', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, score, website_message, product_message, service_message, payment_message, other_message, url, ip, user_agent, created', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'score' => 'Score',
			'website_message' => 'Website Message',
			'product_message' => 'Product Message',
			'service_message' => 'Service Message',
			'payment_message' => 'Payment Message',
			'other_message' => 'Other Message',
			'url' => 'Url',
			'ip' => 'Ip',
			'user_agent' => 'User Agent',
			'created' => 'Created',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('score',$this->score);
		$criteria->compare('website_message',$this->website_message,true);
		$criteria->compare('product_message',$this->product_message,true);
		$criteria->compare('service_message',$this->service_message,true);
		$criteria->compare('payment_message',$this->payment_message,true);
		$criteria->compare('other_message',$this->other_message,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('user_agent',$this->user_agent,true);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}