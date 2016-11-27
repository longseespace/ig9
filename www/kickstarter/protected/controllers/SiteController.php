<?php

class SiteController extends AbstractSiteController
{

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->isHome = true;
		$categories = Category::model()->findAllWithFeatured();
		$cacheDependency = new CDbCacheDependency("SELECT MAX(update_time) FROM projects WHERE projects.status = 1 AND projects.end_time > NOW()");
		$dataProvider = new EActiveDataProviderEx('Project', array(
			'criteria' => array(
				'condition' => 't.status = '.Project::STATUS_ACTIVE.' AND t.end_time > NOW()',
				'with' => array('user', 'user.profile', 'category'),
				'order' => 't.approve_time DESC, t.create_time DESC',
        'together'=>true,
        'limit'=>18
			),
			'cache'=>array(3600, $cacheDependency),
			'pagination' => false
		));

		$endedCacheDependency = new CDbCacheDependency("SELECT MAX(update_time) FROM projects WHERE projects.status >= 1 AND projects.end_time < NOW()");
    $ended = new EActiveDataProviderEx('Project', array(
      'criteria' => array(
        'condition' => 't.status >= '.Project::STATUS_ACTIVE.' AND t.end_time < NOW()',
        'with' => array('user', 'user.profile', 'category'),
        'order' => 't.end_time DESC',
        'together'=>true,
        'limit'=>6
      ),
      'cache'=>array(3600, $endedCacheDependency),
      'pagination' => false,
      // 'totalItemCount' => 3,
    ));

    $notification = Notification::model()->find(array('order' => 'id DESC', 'limit' => 1));

		// $popularProjects = Project::model()->findAllActive(null, 20);
		$this->render('index', compact('categories', 'dataProvider', 'ended', 'notification'));
	}

	public function actionEditNotification(){
		if (!Yii::app()->user->isAdmin()) {
		  throw new CHttpException(403, 'Not authorized');
		}

		$notification = new Notification;
		$notification->attributes = Yii::app()->request->getPost('Notification');
		if ($notification->save()) {

		}

		$this->redirect('/');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		// $model=new LoginForm;

		// // if it is ajax validation request
		// if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		// {
		// 	echo CActiveForm::validate($model);
		// 	Yii::app()->end();
		// }

		// // collect user input data
		// if(isset($_POST['LoginForm']))
		// {
		// 	$model->attributes=$_POST['LoginForm'];
		// 	// validate user input and redirect to the previous page if valid
		// 	if($model->validate() && $model->login())
		// 		$this->redirect(Yii::app()->user->returnUrl);
		// }
		// // display the login form
		// $this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}