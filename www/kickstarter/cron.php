<?php
error_reporting(E_ALL ^ E_NOTICE);
// change the following paths if necessary
$yii=dirname(__FILE__).'/../../framework/yii.php';
$kickstart=dirname(__FILE__).'/protected/kickstart.php';
require_once($kickstart);

defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
define('YII_ENABLE_ERROR_HANDLER', true);

// for MAC OSX MAMP PRO fix to use lessphp & google closure
putenv("DYLD_LIBRARY_PATH=/usr/lib");

$config=require_once(dirname(__FILE__).'/protected/config/console.php');
$common=require_once(dirname(__FILE__).'/protected/config/common.php');
$user=require_once(dirname(__FILE__).'/protected/config/includes/user.php');
$payment=require_once(dirname(__FILE__).'/protected/config/includes/payment.php');

$config = array_merge_recursive_distinct($config, $common);
$config = array_merge_recursive_distinct($config, $user);
$config = array_merge_recursive_distinct($config, $payment);

require_once($yii);
Yii::createConsoleApplication($config)->run();