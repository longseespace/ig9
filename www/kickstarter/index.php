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

$config=require_once(dirname(__FILE__).'/protected/config/main.php');
$common=require_once(dirname(__FILE__).'/protected/config/common.php');
$config = array_merge_recursive_distinct($config, $common);
$files = glob(dirname(__FILE__).'/protected/config/includes/*.php');
usort($files, function($a, $b) {
  return strcmp(str_replace(".php", "", $a), str_replace(".php", "", $b));
});
foreach ($files as $filename){
  $c = require_once($filename);
  $config = array_merge_recursive_distinct($config, $c);
}

require_once($yii);
Yii::createWebApplication($config)->run();