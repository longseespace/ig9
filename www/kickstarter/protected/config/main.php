<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
  'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
  'name'=>'Ig9 - Ignite',
  'theme' => 'ig9',

  // preloading 'log' component
  'preload'=>array('log'),

	// autoloading model and component classes
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

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',

			'password'=>'abc123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		)

	),

	// application components
	'components'=>array(
		// 'db'=>array(
		// 	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		// ),
		// uncomment the following to use a MySQL database
		'db'=>array(
      'connectionString' => 'mysql:host=210.245.89.137;dbname=ig9',
      'emulatePrepare' => true,
      'username' => 'ig9',
      'password' => 'NsUtjZP297xtmGtH',
      'charset' => 'utf8',
      'enableProfiling' => YII_DEBUG,
      'enableParamLogging' => YII_DEBUG,
      'schemaCachingDuration' => /*YII_DEBUG ? 0 : */3600,

    ),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				// array(
				// 	'class'=>'CFileLogRoute',
				// 	'levels'=>'error, warning',
				// ),
        // array(
        //   'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
        //   'ipFilters'=>array('127.0.0.1','192.168.1.215'),
        // ),
			),
		),
    // 'cache'=>array(
    //   'class'=>'ext.redis.CRedisCache',
    //   'servers'=>array(
    //     array(
    //       'host'=>'localhost',
    //       'port'=>6379,
    //     )
    //   ),
    // ),
	),

  // application-level parameters that can be accessed
  // using Yii::app()->params['paramName']
  'params'=>array(
    // this is used in contact page
    'adminEmail'=>'webmaster@example.com',
    'translatedLanguages'=>array('vn' => 'Tiếng Việt', 'en' => 'English'),
    'defaultLanguage' => 'vn',
  ),
  'aliases' => array(
    'widgets' => 'application.widgets',
  ),
);
