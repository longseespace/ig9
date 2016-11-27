<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
$config = array(
  'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
  'name'=>'My Console Application',

  // preloading 'log' component
  'preload'=>array('log'),

  'import'=>array(
    'application.models.*',
    'application.components.*',
    'application.modules.user.*',
    'application.modules.user.models.*',
    'application.modules.user.components.*',
    'application.modules.user.models.*',
    'ext.i18nShortHand.*',
    'ext.i18nShortHand.models.*',
  ),
  'params' => array(
    'mail' => array(
      'host' => 'smtp.gmail.com',
      'port' => 465,
      'encryption' => 'ssl',
      'username' => 'info@ig9.vn',
      'password' => 'dynarock!',
    ),
  ),

  // application components
  'components'=>array(
    /*'db'=>array(
      'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
    ),*/
    'swiftMailer' => array(
      'class' => 'ext.swiftMailer.SwiftMailer',
    ),
    // 'db'=>array(
    //   'connectionString' => 'mysql:host=127.0.0.1;dbname=ig9_dev',
    //   'emulatePrepare' => true,
    //   'username' => 'root',
    //   'password' => 'root',
    //   'charset' => 'utf8',
    //   'enableProfiling' => YII_DEBUG,
    //   'enableParamLogging' => YII_DEBUG,
    //   'schemaCachingDuration' => YII_DEBUG ? 0 : 3600,

    // ),
    'db'=>array(
      'connectionString' => 'mysql:host=dynabyte.vn;dbname=ig9',
      'emulatePrepare' => true,
      'username' => 'ig9',
      'password' => 'NsUtjZP297xtmGtH',
      'charset' => 'utf8',
      'enableProfiling' => YII_DEBUG,
      'enableParamLogging' => YII_DEBUG,
      'schemaCachingDuration' => YII_DEBUG ? 0 : 3600,

    ),
    'user'=>array(
      # encrypting method (php hash function)
      'hash' => 'md5',

      # send activation email
      'sendActivationMail' => true,

      # allow access for non-activated users
      'loginNotActiv' => false,

      # activate user on registration (only sendActivationMail = false)
      'activeAfterRegister' => false,

      # automatically login from registration
      'autoLogin' => true,

      # registration path
      'registrationUrl' => array('/user/registration'),

      # recovery password path
      'recoveryUrl' => array('/user/recovery'),

      # login form path
      'loginUrl' => array('/user/login'),

      # page after login
      'returnUrl' => array('/user/profile'),

      # page after logout
      'returnLogoutUrl' => array('/user/login'),
    ),

    'log'=>array(
      'class'=>'CLogRouter',
      'routes'=>array(
        array(
          'class'=>'CFileLogRoute',
          'levels'=>'error, warning',
        ),
      ),
    ),

  ),
);

$common=require_once(dirname(__FILE__).'/common.php');
$config = array_merge_recursive($config, $common);

return $config;