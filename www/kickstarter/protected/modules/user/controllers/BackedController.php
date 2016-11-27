<?php

class BackedController extends Controller {
  public $defaultAction = 'backed';
  const PAGE_SIZE = 10;

  /**
   * @var CActiveRecord the currently loaded data model instance.
   */
  public $_model;

  /**
   * Shows a particular model.
   */
  public function actionBacked($id = 0) {
    if ($id == 0) {
      $this->loadUser();
    } else {
      $this->_model = User::model()->with('profile')->findByPk($id);
    }

    $condition = 'gateway <> "" AND t.status != -1 AND t.user_id = ' . $this->_model->id;
    if (isset($_GET['project'])) {
      switch ($_GET['project']) {
        case 1:
          $condition .= ' AND end_time > NOW()';
          break;
        case 0:
          $condition .= ' AND end_time <= NOW()';
          break;
      }
    }
    if (isset($_GET['status'])) {
      $condition .= ' AND t.status = ' . $_GET['status'];
    }

    if (isset($_GET['project']) || isset($_GET['status'])) {
      $filter = new CActiveDataProvider('Transaction', array(
        'criteria'=>array(
          'with' => array('reward', 'reward.project'),
          'together' => true,
          'condition' => $condition,
          'order' => 't.create_time DESC'
        ),
        'pagination'=>array('pageSize'=> self::PAGE_SIZE, 'pageVar' => 'page'),
      ));
    }

    if (Yii::app()->user && Yii::app()->user->id == $this->_model->id) {
      $projects = new CActiveDataProvider('Transaction', array(
        'criteria'=>array(
          'with' => array('reward', 'reward.project'),
          'together' => true,
          'condition' => 'gateway <> "" AND t.status != -1 AND t.user_id = ' . $this->_model->id,
          'order' => 't.create_time DESC'
        ),
        'pagination'=>array('pageSize'=> self::PAGE_SIZE, 'pageVar' => 'page'),
      ));
    } else {
      $projects = new CActiveDataProvider('UserProject', array(
        'criteria'=>array(
          'with'=>array('project'),
          'condition' => 't.user_id = ' . $this->_model->id,
          'group' => 't.user_id',
          'order' => 't.id DESC',
          'together'=>true,
        ),
        'pagination'=>array('pageSize'=> self::PAGE_SIZE, 'pageVar' => 'page'),
      ));
      $projects->setTotalItemCount(Yii::app()->db->createCommand('SELECT COUNT(DISTINCT user_id) FROM user_project WHERE user_id = ' . $this->_model->id)->queryScalar());
    }

    if (Yii::app()->user && Yii::app()->user->id == $this->_model->id) {
      $this->render('backed', array('model' => $this->_model, 'profile' => $this->_model->profile, 'projects' => $projects, 'filter' => $filter));
    } else {
      $this->_model->projectCount = Yii::app()->db->createCommand('SELECT COUNT(*) FROM projects WHERE user_id = ' . $this->_model->id . ' AND projects.status = ' . Project::STATUS_ACTIVE)->queryScalar();
      $this->render('profile', array('model' => $this->_model, 'profile' => $this->_model->profile, 'projects' => $projects));
    }
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
   */
  public function loadUser() {
    if ($this->_model === null) {
      if (Yii::app()->user->id) $this->_model = Yii::app()->controller->module->user();
      if ($this->_model === null) $this->redirect(Yii::app()->controller->module->loginUrl);
    }
    return $this->_model;
  }
}