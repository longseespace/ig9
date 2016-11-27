<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {
  public $breadcrumbs;
  public $jsNamespace = 'ig9';
  public $jsVars = array();

  public $isHome = false;
  public $title;

  private $_assetsUrl;

  public function getAssetsUrl()
  {
    $theme = Yii::app()->theme;
    if (YII_DEBUG) {
      $this->_assetsUrl = $theme->baseUrl.'/assets';
    } else {
      $this->_assetsUrl = Yii::app()->getAssetManager()->publish($theme->basePath.'/assets');
    }

    return $this->_assetsUrl;
  }

  /**
   * Save flash success message
   * @param $message
   */
  public function success($message) {
    if (is_array($message)) {
      Yii::app()->user->setFlash('success', 'Success ' . $message['code'] . ': ' . $message['message']);
    } else {
      Yii::app()->user->setFlash('success', $message);
    }
  }

  /**
   * Save flash error message
   * @param $message
   */
  public function error($message) {
    if (is_array($message)) {
      Yii::app()->user->setFlash('error', 'Error ' . $message['code'] . ': ' . $message['message']);
    } else {
      Yii::app()->user->setFlash('error', $message);
    }
  }

  public function pageTitle($title) {
    $this->pageTitle = ___($title) . ' — ' . Yii::app()->name;
  }

  /**
   * Pass PHP variables to Javascript
   * @param array $vars
   * @return Controller
   */
  public function addJSVars($vars = array()) {
    foreach ($vars as $key => $value) {
      $this->jsVars[$key] = $value;
    }
    return $this;
  }

  /**
   * Create module/action/id URL
   * @param string $controller
   * @param string $action
   * @param int $id
   * @param array $params
   * @return string
   */
  public function url($controller, $action = '', $id = 0, $params = array()) {
    $url = '/' . $controller;
    $url .= $action === '' ? '' : '/' . $action;
    $url .= $id === 0 ? '' : '/' . $id;
    return $this->createAbsoluteUrl($url, $params);
  }

  /**
   * Create admin/module/action/id URL
   * @param string $controller
   * @param string $action
   * @param int $id
   * @param array $params
   * @return string
   */
  public function adminUrl($controller, $action = '', $id = 0, $params = array()) {
    return $this->url('admin/' . $controller, $action, $id, $params);
  }

  /**
   * Create module/slug/id URL
   * @param string $controller
   * @param string $slug
   * @param int $id
   * @param array $params
   * @return string
   */
  public function slug($controller, $slug = '', $id = 0, $params = array()) {
    return $slug === '' ? $this->url($controller, 'view', $id, $params) : $this->url($controller, $slug, $id, $params);
  }

  protected function beforeRender($view) {
    $this->addJSVars(array('controller' => $this->uniqueid, 'action' => $this->action->Id));
    
    $unreadMessage = Yii::app()->getModule('message')->getCountUnreadedMessages(Yii::app()->user->id);
    $this->addJSVars(array('unread_message' => $unreadMessage));

    Yii::app()->clientScript->registerScript('jsVars', 'window.'.$this->jsNamespace.' = '.CJSON::encode($this->jsVars).';', CClientScript::POS_HEAD);

    return true;
  }
}