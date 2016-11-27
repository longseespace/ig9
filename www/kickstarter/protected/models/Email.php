<?php

/**
 * This is the model class for table "emails".
 *
 * The followings are the available columns in table 'emails':
 * @property string $id
 * @property string $template
 * @property string $subject
 * @property string $recipient
 * @property string $replacement
 * @property integer $status
 * @property string $created
 */
class Email extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Email the static model class
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
		return 'emails';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('recipient', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('status', 'safe'),
			array('template, subject, recipient', 'length', 'max'=>255),
			array('replacement', 'safe'),
			array('hash', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, template, subject, recipient, replacement, status, created', 'safe', 'on'=>'search'),
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
			'template' => 'Template',
			'subject' => 'Subject',
			'recipient' => 'Recipient',
			'replacement' => 'Replacement',
			'status' => 'Status',
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
		$criteria->compare('template',$this->template,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('recipient',$this->recipient,true);
		$criteria->compare('replacement',$this->replacement,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave(){
		$this->replacement = is_array($this->replacement) ? json_encode($this->replacement) : $this->replacement;
		return parent::beforeSave();
	}

	public function afterFind(){
		$this->replacement = json_decode($this->replacement);
		return parent::afterFind();
	}
}