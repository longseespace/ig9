<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.

$theme = isset($config['theme']) ? $config['theme'] : 'ig9';

foreach (glob(dirname(dirname(dirname(__FILE__))).'/themes/'.$theme.'/assets/{js/*.js,css/*.less}', GLOB_BRACE) as $filepath){
  $info = pathinfo($filepath);
  $basename = $info['basename'];
  $filename = $info['filename'];

  if ($info['extension'] == 'js') {
    $groups[$basename] = array(
      'type' => 'js',
      'files' => array('/themes/'.$theme.'/assets/js/'.$basename),
      'output' => '/themes/'.$theme.'/assets/js/compiled/'.$filename.'.compiled.js'
    );
  } else {
    $groups[$basename] = array(
      'type' => 'less',
      'file' => '/themes/'.$theme.'/assets/css/'.$basename,
      'output' => '/themes/'.$theme.'/assets/css/'.$filename.'.compiled.css'
    );
  }

}

$common = array(
  // application components
  'components'=>array(
    'assetCompiler'=>array(
      'class' => 'ext.assetCompiler.AssetCompiler',
      'lessJsUrl' => '/themes/'.$theme.'/assets/js/core/less-1.3.0.min.js',
      'groups' => $groups,
      'debugMode' => true
    ),
  ),
  'params'=>array(
    'paths' => array(
      'uploads' => 'uploads'
    )
  ),
);

return $common;
?>