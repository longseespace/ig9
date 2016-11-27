<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
abstract class AbstractAdminController extends Controller
{
  public $layout='//layouts/admin';
  /**
   * @var array context menu items. This property will be assigned to {@link CMenu::items}.
   */
  public $menu=array();
  /**
   * @var array the breadcrumbs of the current page. The value of this property will
   * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
   * for more details on how to specify this property.
   */
  public $breadcrumbs=array();

  private $_assetsUrl;

  /**
   * @var string Path to the form configuration folder
   */
  public static $modelViewPath = 'application.models.admin.view';

  public function getAssetsUrl()
  {
    if (YII_DEBUG) {
      $this->_assetsUrl = Yii::app()->getBaseUrl().'/themes/admin/assets';
    } else {
      $this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('webroot.themes.admin.assets'));
    }

    return $this->_assetsUrl;
  }

  /**
   * @param string $file file name
   * @return string The path of alias to form config folder or $file
   */
  public function formConfig($file = '') {
    return $file === '' ? self::$modelViewPath : self::$modelViewPath . '.' . $file;
  }

  /**
   * @return array action filters
   */
  public function filters()
  {
    return array(
      'accessControl', // perform access control for CRUD operations
    );
  }

  /**
   * Specifies the access control rules.
   * This method is used by the 'accessControl' filter.
   * @return array access control rules
   */
  public function accessRules()
  {
    return array(
      array('allow', // allow admin user to perform 'admin' and 'delete' actions
        'users'=>UserModule::getAdmins(),
      ),
      array('deny',  // deny all users
        'users'=>array('*'),
      ),
    );
  }
}