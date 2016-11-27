<?php

class ProjectController extends AbstractSiteController {
  public $steps;
  private $_model;
  public function init() {
    parent::init();
    if ($project_id = $this->actionParams['id']) {
      $this->loadProject($project_id);
    }
    $this->steps = array(
      'guidelines' => array(
        'title' => ___('Guidelines'),
        'action' => 'guidelines'
      ) ,
      'basics' => array(
        'title' => ___('Basics'),
        'action' => 'basics'
      ) ,
      'rewards' => array(
        'title' => ___('Rewards'),
        'action' => 'rewards'
      ) ,
      'story' => array(
        'title' => ___('Story'),
        'action' => 'story'
      ) ,
      'aboutyou' => array(
        'title' => ___('About You'),
        'action' => 'aboutyou'
      ) ,
      'review' => array(
        'title' => ___('Review'),
        'action' => 'review'
      )
    );
  }
  public function actionIndex() {
//    $projects = \application\models\Project::model()->findAll();
    //var_dump($projects);
  }
  public function actionAdd() {
  }
  public function actionEnded() {
    $endedCacheDependency = new CDbCacheDependency("SELECT MAX(update_time) FROM projects WHERE projects.status >= 1 AND projects.end_time < NOW()");
    $ended = new EActiveDataProviderEx('Project', array(
      'criteria' => array(
        'condition' => 't.status >= '.Project::STATUS_ACTIVE.' AND t.end_time < NOW()',
        'with' => array('user', 'user.profile', 'category'),
        'order' => 't.end_time DESC',
        'together' => true,
        'limit' => 9
      ),
      'cache'=>array(3600, $endedCacheDependency),
      'pagination'=>array('pageSize'=> 9, 'pageVar' => 'page'),
      // 'totalItemCount' => 18,
    ));

    // $popularProjects = Project::model()->findAllActive(null, 20);
    $this->render('ended', compact('ended'));
  }
  public function actionList($slug = null, $filter = null) {
    $categories = Category::model()->findAll();
    if ($slug) {
      $cur_category = Category::model()->findByAttributes(array(
        'slug' => $slug
      ));
      $projects = Project::model()->with('user')->findAllByAttributes(array(
        'category_id' => $cur_category->id
      ));
    } elseif ($filter) {

      switch ($filter) {
        case 'staff-pick':
          $title = ___("Staff Picks");
          $projects = Project::model()->with("user")->findAllByAttributes(array(
            "featured" => 1
          ));
          break;

        case 'popular':
          $categories = Category::model()->findPopularProjects();
          var_dump($categories[0]->popularProjects);
          break;

        default:
          $title = ___("All Projects");
          $categories = Category::model()->with("featuredProjects", "featuredProjects.user")->findAll();
          break;
      }
    }
    $this->render('list', compact('categories', 'projects', 'cur_category', 'title'));
  }
  /**
   * Displays the project start page
   * TODO: display landing page / authentication etc.
   */
  public function actionStart() {
    $this->render('start');
  }
  public function actionView($id, $slug = null) {
    if (isset($id)) {
      $project = Project::model()->with('updateCount', 'commentCount')->findbyPk(intval($id));
      if (!$project){
        throw new CHttpException(404, 'The requested page does not exist.');
      }

      if ($project->status < Project::STATUS_ACTIVE) {
        if($project->user_id != Yii::app()->user->id && !Yii::app()->user->isAdmin()) {
          throw new CHttpException(403, 'The requested page does not exist.');
        }

        $this->gaTrack = false;
      }

      if (empty($slug) && !empty($project->slug)) {
        $this->redirect(array(
          'project/view',
          'id' => $id,
          'slug' => $project->slug
        ));
      }
    } else {
      throw new CHttpException(404, 'The requested page does not exist.');
    }
    $randomProjects = $this->getRandomProjects($id);
    $latestUpdate = $this->getLatestUpdate($id);

    $this->render('view', compact('project', 'randomProjects', 'latestUpdate'));
  }
  public function actionBackers($id) {
    if (isset($id)) {
      $project = Project::model()->with('updateCount', 'commentCount')->findByPk(intval($id));
      if (!$project){
        throw new CHttpException(404, 'The requested page does not exist.');
      }

      $backers = new CActiveDataProvider('UserProject', array(
        'criteria'=>array(
          'with'=>array(
            'user',
            'user.profile',
            'project'=>array(
              'select'=>false,
              'condition'=>'project_id=' . $id
            ),
          ),
          'group' => 't.user_id',
          'order' => 't.id DESC',
          'together'=>true,
        ),
        'pagination'=>array('pageSize'=>50, 'pageVar' => 'page'),
      ));
      $backers->setTotalItemCount(Yii::app()->db->createCommand('SELECT COUNT(DISTINCT user_id) FROM user_project WHERE project_id = ' . $id)->queryScalar());
    } else {
      throw new CHttpException(404, 'The requested page does not exist.');
    }
    $randomProjects = $this->getRandomProjects($id);
    $latestUpdate = $this->getLatestUpdate($id);

    $this->render('backers', compact('project', 'backers', 'randomProjects', 'latestUpdate'));
  }
  public function actionUpdates($id) {
    if (isset($id)) {
      $project = Project::model()->with('updateCount', 'commentCount')->findByPk(intval($id));
      if (!$project){
        throw new CHttpException(404, 'The requested page does not exist.');
      }

      $updates = new CActiveDataProvider('ProjectUpdate', array(
        'criteria'=>array(
          'condition' => 'status=1 AND project_id=' . $id,
          'order' => 't.id DESC',
          'with'=>array(
            'commentCount',
          ),
          'together'=>true,
        ),
        'pagination'=>array('pageSize'=>5, 'pageVar' => 'page'),
      ));
    } else {
      throw new CHttpException(404, 'The requested page does not exist.');
    }
    $randomProjects = $this->getRandomProjects($id);
    $latestUpdate = $this->getLatestUpdate($id);

    $this->render('updates', compact('project', 'updates', 'randomProjects', 'latestUpdate'));
  }
  public function actionUpdate($id) {
    if (isset($id)) {
      $update = ProjectUpdate::model()->with('commentCount', 'project', 'project.backerCount', 'project.updateCount', 'project.commentCount')->findByPk(intval($id));
      if (!$update){
        throw new CHttpException(404, 'The requested page does not exist.');
      }
      $project = $update->project;

      $comments = new CActiveDataProvider('ProjectUpdateComment', array(
        'criteria'=>array(
          'condition' => 'update_id=' . $id,
          'order' => 't.id DESC',
          'with'=>array(
            'user',
            'user.profile',
          ),
          'together'=>true,
        ),
        'pagination'=>array('pageSize'=>50, 'pageVar' => 'page'),
      ));
    } else {
      throw new CHttpException(404, 'The requested page does not exist.');
    }
    $randomProjects = $this->getRandomProjects($id);
    $latestUpdate = $this->getLatestUpdate($project->id);

    $this->render('update', compact('project', 'update', 'comments', 'randomProjects', 'latestUpdate'));
  }
  public function actionComments($id) {
    if (isset($id)) {
      $project = Project::model()->with('updateCount', 'commentCount')->findByPk(intval($id));
      if (!$project){
        throw new CHttpException(404, 'The requested page does not exist.');
      }

      $comments = new CActiveDataProvider('ProjectComment', array(
        'criteria'=>array(
          'condition' => 'project_id=' . $id,
          'with'=>array(
            'user.profile',
            'user'=>array(
              'select'=>false,
            ),
          ),
          'together'=>true,
          'order' => 't.id DESC',
        ),
        'pagination'=>array('pageSize'=>50, 'pageVar' => 'page'),
      ));
    } else {
      throw new CHttpException(404, 'The requested page does not exist.');
    }
    $randomProjects = $this->getRandomProjects($id);
    $latestUpdate = $this->getLatestUpdate($id);

    $this->render('comments', compact('project', 'comments', 'randomProjects', 'latestUpdate'));
  }
  public function getRandomProjects($id = 0) {
    return new CActiveDataProvider('Project', array(
      'criteria' => array(
        'condition' => 't.end_time > NOW() AND t.status = ' . Project::STATUS_ACTIVE . ' AND t.id != ' . $id,
        'with' => array('user', 'user.profile', 'category'),
        'order' => 'RAND()'
      ),
      'pagination' => array('pageSize' => 3),
      'totalItemCount' => 3,
    ));
  }
  public function getLatestUpdate($id) {
    return new CActiveDataProvider('ProjectUpdate', array(
      'criteria'=>array(
        'condition' => ' create_time > DATE_SUB(NOW(), INTERVAL 4 DAY) AND status = 1 AND project_id =' . $id,
      ),
      'pagination'=>array('pageSize'=>50, 'pageVar' => 'page'),
    ));
  }
  private function loadProject($id) {
    $this->_model = Project::model()->findByPk($id);

    return $this->_model;
  }
  public function getModel() {

    return $this->_model;
  }
  /**
   *      STEP 1
   * Display project guidelines. User must accept TOS before continuing
   */
  public function actionGuidelines() {
    if ($_POST['accept']) {
      $project = new Project;
      $project->user_id = Yii::app()->user->id;
      //$project->save();
      //print_r($project->getErrors());
      if ($project->save()) {
        $this->redirect(array(
          'project/basics',
          'id' => $project->id
        ));
      }
    }
    $this->layout = '//layouts/project.add';
    $this->render($this->action->id);
  }
  /**
   *      STEP 2
   * Display project basics.
   */
  public function actionBasics($id) {
    $category = Category::model();
    $project = $this->_model;
    $project->scenario = 'basics';
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'theform') {
      echo CActiveForm::validate($project);
      Yii::app()->end();
    }
    if (isset($_POST['Project'])) {
      // $oldImage = $project->image;
      $project->attributes = $_POST['Project'];
      if ($project->save()) {
        $this->redirect(array(
          'project/rewards',
          'id' => $id
        ));
      }
    }
    $this->layout = '//layouts/project.add';
    $this->render($this->action->id, compact('project', 'category'));
  }
  /**
   *      STEP 3
   * Display project rewards.
   */
  public function actionRewards($id) {
    $project = $this->_model;
    $reward = new Reward;
    $rewards = Reward::model()->findAllByAttributes(array(
      'project_id' => $id
    ));
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'theform') {
      echo CActiveForm::validate($reward);
      Yii::app()->end();
    }
    if (isset($_POST['Reward'])) {
      $reward->attributes = array_merge($reward->attributes, (array)$_POST['Reward']);
      $reward->project_id = $id;
      $index = count($rewards);
      if ($reward->save()) {
        echo json_encode(array(
          'content' => $this->renderPartial('//project/reward.formitem', compact('reward', 'project', 'index') , true) ,
          'message' => ___('Reward has been saved.') ,
          'error' => false
        ));
      } else {
        echo json_encode(array(
          'messages' => $reward->errors,
          'error' => true
        ));
      }
      Yii::app()->end();
    }
    $this->layout = '//layouts/project.add';
    $this->render($this->action->id, compact('rewards', 'reward', 'project'));
  }
  /**
   *    Update a reward
   */
  public function actionReward($id) {
    $project = $this->_model;
    $reward = Reward::model();
    if (isset($_POST['ajax']) && !isset($_POST['update']) && !isset($_POST['delete'])) {
      echo CActiveForm::validate($reward);
      Yii::app()->end();
    }
    if (isset($_POST['Reward'])) {
      $reward_id = $_POST['Reward']['id'];
      $reward = $reward->findbyPk($reward_id);
      // A delete request
      if (isset($_POST['delete'])) {
        if ($reward->delete()) {
          echo json_encode(array(
            'message' => ___('Reward has been removed') ,
            'error' => false
          ));
        } else {
          echo json_encode(array(
            'message' => ___('An error occured.') ,
            'error' => true
          ));
        }
        Yii::app()->end();
      } else {
        // Update request
        $reward->attributes = array_merge($reward->attributes, (array)$_POST['Reward']);
        $reward->project_id = $id;
        if ($reward->save()) {
          echo json_encode(array(
            'content' => $this->renderPartial('//project/reward.listitem', compact('reward') , true) ,
            'message' => ___('Reward has been updated.') ,
            'error' => false
          ));
        } else {
          echo json_encode(array(
            'messages' => $reward->errors,
            'error' => true
          ));
        }
        Yii::app()->end();
      }
    }
    echo json_encode(array(
      'message' => ___('An error occured.') ,
      'error' => true
    ));
    Yii::app()->end();
  }
  /**
   *      STEP 4
   * Display project story.
   */
  public function actionStory($id) {
    $category = Category::model();
    $project = $this->_model;
    $project->scenario = 'story';
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'theform') {
      echo CActiveForm::validate($project);
      Yii::app()->end();
    }
    if (isset($_POST['Project'])) {
      $project->attributes = $_POST['Project'];
      if(!empty($_POST['Project']['videoUrl'])){
        $project->videoUrl = $_POST['Project']['videoUrl'];
      }

      if ($project->save()) {
        $this->redirect(array(
          'project/aboutyou',
          'id' => $id
        ));
      }
    }
    $this->layout = '//layouts/project.add';
    $this->render($this->action->id, compact('project'));
  }
  /**
   *      STEP 5
   * Display profile info.
   */
  public function actionAboutyou($id) {
    $project = $this->_model;
    $project->scenario = 'aboutyou';
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'theform') {
      echo CActiveForm::validate($project);
      Yii::app()->end();
    }
    if (isset($_POST['Project'])) {
      $project->attributes = $_POST['Project'];
      if ($project->save()) {
        $this->redirect(array(
          'project/review',
          'id' => $id
        ));
      }
    }
    $this->layout = '//layouts/project.add';
    $this->render($this->action->id, compact('project'));
  }
  /**
   *      STEP 6
   * Display project review.
   */
  public function actionReview($id) {
    $project = $this->model;
    $this->layout = '//layouts/project.add';
    $this->render($this->action->id, compact('project'));
  }
  /**
   * Basic ACL
   */
  public function filters() {

    return CMap::mergeArray(parent::filters() , array(
      'accessControl', // perform access control for CRUD operations

    ));
  }
  /**
   * Specifies the access control rules.
   * This method is used by the 'accessControl' filter.
   * @return array access control rules
   */
  public function accessRules() {

    return array(
      array(
        'allow', // allow all users to browser projects and view single project
        'actions' => array(
          'list',
          'view',
          'backers',
          'updates',
          'update',
          'comments',
          'ended',
        ) ,
        'users' => array(
          '*'
        ) ,
      ) ,
      array(
        'allow', // allow authenticated user to create project
        'actions' => array(
          'basics',
          'rewards',
          'reward',
          'story',
          'aboutyou',
          'review',
          'delete'
        ) ,
        'users' => array(
          '@'
        ) ,
        'expression' => array(&$this, 'checkOwnerOrAdmin')
      ) ,
      array(
        'allow',
        'actions' => array(
          'start',
          'guidelines'
        ) ,
        'users' => array(
          '@'
        )
      ) ,
      array(
        'deny', // deny all users
        'users' => array(
          '*'
        ) ,
      ) ,
    );
  }
  /**
   * Check Owner
   */
  public function checkOwner($user, $rule) {
    if (!$this->actionParams['id']) {
      return false;
    }

    return Yii::app()->user->id == $this->model->user_id;
  }
  public function checkOwnerOrAdmin($user, $rule) {
    if (!$this->actionParams['id']) {
      return false;
    }

    return Yii::app()->user->isAdmin() || (Yii::app()->user->id == $this->model->user_id);
  }
  public function actionDelete($id) {
    if (Yii::app()->request->isPostRequest) {
      $this->loadModel($id)->delete();
      if (!Yii::app()->request->isAjaxRequest){
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('user/profile'));
      }
    } else throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id) {
    $model = Project::model()->findByPk((int) $id);
    if ($model === null)
      throw new CHttpException(404, 'The requested post does not exist.');
    return $model;
  }
}
