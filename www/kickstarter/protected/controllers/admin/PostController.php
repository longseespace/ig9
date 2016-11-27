<?php

class PostController extends AbstractAdminController
{
	private $_model;
	private $moduleName = 'post';

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array(
				'allow', // allow admin user to perform any actions
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

  public function init()  {
    parent::init();
    $cs = Yii::app()->clientScript;
    $cs->defaultScriptFilePosition = CClientScript::POS_END;
    $cs->registerScriptFile($this->assetsUrl.'/js/admin/page.js');
  }
  
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$post = $this->loadModel($id); 
		$this->render('view',array(
			'model'=>$post,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Post;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			$model->author_id = Yii::app()->user->id;
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		$categories = NewsCategory::model()->findAll();
		$this->render('create',array(
			'model'=>$model,
			'categories'=>$categories,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			if($model->save())
				$this->redirect(array('index'));
		}
		$categories = NewsCategory::model()->findAll();
		$this->render('update',array(
			'model'=>$model,
			'categories'=>$categories,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		// if (Yii::app()->request->isPostRequest) {
      $model = Post::model()->findByPk($id);
      $model->delete();
		// }
	  // else throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    $this->redirect($this->adminUrl($this->moduleName));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
    $models = new CActiveDataProvider('Post', array(
      'criteria'=>array(
        'with' => array('author'),
        'together' => true,
      ),
      'pagination'=> array(
        'pageSize'=> 10,
      ),
    ));
    $this->render('index', compact('models'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Post('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Post']))
			$model->attributes=$_GET['Post'];
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */	
	public function loadModel($id)
	{
		if ($this->_model===null) {
			if (isset($_GET['id'])) {
				if (Yii::app()->user->isGuest) {
					$condition = 'status='.Post::STATUS_PUBLISHED.' OR status='.Post::STATUS_ARCHIVED;
				} else
					$condition = '';
				$this->_model = Post::model()->findByPk($_GET['id'], $condition);		
			}
			if ($this->_model===null) {
				throw new CHttpException(404,'Bài viết không tồn tại.');				
			}
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
