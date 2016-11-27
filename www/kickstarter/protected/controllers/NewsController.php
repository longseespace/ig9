<?php

class NewsController extends AbstractSiteController
{

  public function init() {
    parent::init();    
  }

  const PAGE_SIZE = 10;

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionIndex()
	{
		$criteria = new CDbCriteria(array(
			'condition'=>'status='.Post::STATUS_PUBLISHED,
			'order'=>'update_time DESC',
			'with'=>'commentCount',
		));
		if (isset($_GET['tag'])) {
			$criteria->addSearchCondition('tag',$_GET['tag']);
		}
		$posts = new CActiveDataProvider('Post', array(
      'criteria'=>$criteria,
      'pagination'=> array(
      	'pageSize'=> self::PAGE_SIZE,
      ),
    ));
    $email = new EmailSubscriber;
    if(isset($_POST['EmailSubscriber']))
    {
      $email->attributes=$_POST['EmailSubscriber'];
      if ($email->save()) {
        $this->redirect('/');
      }
    }
    $category = new CActiveDataProvider('NewsCategory',array(
      'criteria'=>array(                          
        'limit'=>20,
      ),
    ));
    $category->setPagination(false);
		$this->pageTitle = ___('News');
    $categories = Category::model()->findWithFeatured();
    $dataProvider = new CActiveDataProvider('Project', array(
      'criteria' => array(
        'condition' => 't.status = '.Project::STATUS_ACTIVE,
        'with' => array('user', 'user.profile', 'category')
      ),
      'pagination' => array(
        'pageSize' => 18
      )
    ));
		$this->render('index',compact('category','posts','categories', 'dataProvider', 'email'));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) //, $slug=null)
	{
		$post = $this->loadModel($id);
		$comment = $this->newComment($post);
		$comment->post_id = $id;
    $category = new CActiveDataProvider('NewsCategory',array(
      'criteria'=>array(                          
        'limit'=>20,
      ),
    ));
    $email = new EmailSubscriber;
    if(isset($_POST['EmailSubscriber']))
    {
      $email->attributes=$_POST['EmailSubscriber'];
      if ($email->save()) {
        $this->redirect(array('/news/'.$id));
      }
    }
    $category->setPagination(false);
		$this->render('view',array(
			'model'=>$post,
			'comment'=>$comment,
			'category'=>$category,
      'email'=>$email,
		));
	}

	/**
	*Display post in category
	*/
	public function actionList($id)
	{
		$criteria = new CDbCriteria(array(
    	'condition'=>'status='.Post::STATUS_PUBLISHED,
			'order'=>'update_time DESC',
		));
		$criteria->addSearchCondition('category_id', $id);
		$posts = new CActiveDataProvider('Post', array(
      'criteria'=>$criteria,
      'pagination'=> array(
      	'pageSize'=> self::PAGE_SIZE,
    	),
    ));
    $category = new CActiveDataProvider('NewsCategory',array(
      'criteria'=>array(                          
        'limit'=>20,
      ),
    ));
    $category->setPagination(false);
    $this->render('list',array('posts'=>$posts, 'category'=>$category,));
	}
	public function newComment($post)
	{
		$comment = new Comment;
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'comment-form') 
		{
			echo CActiveForm::validate($comment);
			Yii::app()->end();
		}
		if (isset($_POST['Comment'])) 
		{
			$comment->attributes = $_POST['Comment'];
			if (!Yii::app()->user->isGuest) {
				$comment->author_id = Yii::app()->user->id;
				$comment->author_name = $comment->author->username;
				$comment->email = $comment->author->email;
			}
			if ($post->addComment($comment)) 
			{
				if ($comment->status == Comment::STATUS_PENDING) {
					Yii::app()->user->setFlash('commentSubmitted','Thankyou.');
				}
				$this->refresh();
			}
		}
		return $comment;
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionAdminUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			if($model->save())
				$this->redirect(array('adminupdate','id'=>$model->id));
		}

		$this->render('update',array(
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
		$model=Post::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param String the slug of the model to be loaded
	 */
	public function loadModelBySlug($slug)
	{
		$model=Post::model()->findByAttributes(array('slug' => $slug));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='page-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
