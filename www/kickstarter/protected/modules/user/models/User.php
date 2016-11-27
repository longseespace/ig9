<?php

class User extends CActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANED=-1;

	/**
	 * The followings are the available columns in table 'users':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $activkey
	 * @var integer $createtime
	 * @var integer $lastvisit
	 * @var integer $superuser
	 * @var integer $status
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
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
		return Yii::app()->getModule('user')->tableUsers;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.

      if (strpos(Yii::app()->getController()->id, 'admin') == 0) {
        return array(
          array('username, email', 'required'),
          array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
          array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
          array('email', 'email'),
          array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
          array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
          array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
          array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANED)),
          array('superuser', 'in', 'range'=>array(0,1)),
          array('email, superuser, status', 'required'),
          array('createtime, lastvisit, superuser, status', 'numerical', 'integerOnly'=>true),
        );
      }

		return ((Yii::app()->getModule('user')->isAdmin())?array(
			#array('username, password, email', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANED)),
			array('credit', 'numerical'),
      array('subscriber', 'default', 'setOnEmpty' => true, 'value' => 1),
			array('email, createtime, lastvisit, superuser, status', 'required'),
      array('superuser', 'in', 'range'=>array(0,1)),
			array('createtime, lastvisit, superuser, status', 'numerical', 'integerOnly'=>true),
		):((Yii::app()->user->id==$this->id)?array(
			array('username, email', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('email', 'email'),
      array('credit', 'numerical'),
      array('subscriber', 'default', 'setOnEmpty' => true, 'value' => 1),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
		):array()));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		$relations = array(
			'profile'=>array(self::HAS_ONE, 'Profile', 'user_id'),
			'projects'=>array(self::HAS_MANY, 'Project', 'user_id'),
			'userProjects'=>array(self::HAS_MANY, 'UserProject', 'user_id'),
			'backed'=>array(self::HAS_MANY, 'Project', array('project_id'=>'id'),'through'=>'userProjects'),
      'transactions'=>array(self::HAS_MANY, 'Transaction', 'user_id'),
      'projectCount'=>array(self::STAT, 'Project', 'user_id'),
      'backedCount'=>array(self::STAT, 'Transaction', 'user_id', 'condition' => 'gateway <> "" AND t.status != -1'),
      'activeProjectCount'=>array(self::STAT, 'Project', 'user_id', 'condition' => 't.status != -1'),
		);
		if (isset(Yii::app()->getModule('user')->relations)) $relations = array_merge($relations,Yii::app()->getModule('user')->relations);
		return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'username'=>UserModule::t("Username"),
			'password'=>UserModule::t("Password"),
			'verifyPassword'=>UserModule::t("Retype Password"),
			'email'=>UserModule::t("E-mail"),
			'verifyCode'=>UserModule::t("Verification Code"),
			'id' => UserModule::t("Id"),
			'activkey' => UserModule::t("activation key"),
			'createtime' => UserModule::t("Registration date"),
			'lastvisit' => UserModule::t("Last visit"),
			'superuser' => UserModule::t("Superuser"),
			'status' => UserModule::t("Status"),
      'subscriber' => ___("Projects I'm backing post new updates"),
		);
	}

	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'status='.self::STATUS_ACTIVE,
            ),
            'notactvie'=>array(
                'condition'=>'status='.self::STATUS_NOACTIVE,
            ),
            'banned'=>array(
                'condition'=>'status='.self::STATUS_BANED,
            ),
            'superuser'=>array(
                'condition'=>'superuser=1',
            ),
            'notsafe'=>array(
            	'select' => 'id, username, password, email, activkey, createtime, lastvisit, superuser, credit, status',
            ),
        );
    }

	public function defaultScope()
    {
        return array(
            'select' => 'id, username, email, createtime, lastvisit, superuser, credit, status, subscriber',
        );
    }

	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOACTIVE => UserModule::t('Not active'),
				self::STATUS_ACTIVE => UserModule::t('Active'),
				self::STATUS_BANED => UserModule::t('Banned'),
			),
			'AdminStatus' => array(
				'0' => UserModule::t('No'),
				'1' => UserModule::t('Yes'),
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}

  public function behaviors() {
    return array(
      'avatarBehavior' => array(
        'class' => 'ImageARBehavior',
        'attribute' => 'avatar', // this must exist
        'extension' => 'png, gif, jpg, jpeg', // possible extensions, comma separated
        'relativeWebRootFolder' => 'uploads', // this folder must exist
        'prefix' => 'user_',
        'formats' => array(
          'normal' => array(
            'process' => array('resize' => array(100, null)),
            'suffix' => '.normal',
          ),
          'thumb' => array(
            'process' => array('resize' => array(50, null)),
            'suffix' => '.thumb',
          ),
          'original' => array(
            'process' => array('resize' => array(500, null)),
            'suffix' => '.original',
          ),
        )
      )
    );
  }

  public function getAvatar() {
    if ($this->avatarBehavior->getFileUrl()) return AppHelper::fixImageUrl($this->avatarBehavior->getFileUrl(), 220, 220);
    return "/themes/ig9/assets/img/noava.png";
  }

  public function getFullName() {
      return $this->username;
  }

  public function getSuggest($q) {
      $c = new CDbCriteria();
      $c->addSearchCondition('username', $q, true, 'OR');
      $c->addSearchCondition('email', $q, true, 'OR');
      return $this->findAll($c);
  }


}