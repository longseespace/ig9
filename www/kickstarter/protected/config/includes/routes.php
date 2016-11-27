<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
  // application components
  'components'=>array(
    // uncomment the following to enable URLs in path-format
    'urlManager'=>array(
      'urlFormat'=>'path',
      'showScriptName'=>false,
      'rules'=>array(
        // special routes
        'pledge/<project_id:\d+>' => 'pledge/new',
        'pledge/success/<transaction_id:\d+>' => 'pledge/success',
        'start' => 'project/start',
        'page/<slug>/<id:\d+>' => 'page/view',
        'page/<slug>' => 'page/view',

        'discover' => 'discover/category',
        'discover/<filter>' => 'discover/filter',
        'discover/<filter>/<slug>' => 'discover/all',
        'category/<slug>' => 'discover/all',
        'category/<slug>/<filter>' => 'discover/all',

        'projects/<slug>/<id:\d+>' => 'project/view',

        'help/<action:\w+>/<id>' => 'help/<action>',

        // admin
        'admin' => 'admin/dashboard',
        'admin/<action:(login|logout)>' => 'admin/admin/<action>',
        'admin/<controller:\w+>/<id:\d+>' => 'admin/<controller>/view',
        'admin/<controller:\w+>/<action:\w+>/<id:\d+>' => 'admin/<controller>/<action>',
        'admin/<controller:\w+>/<action:\w+>' => 'admin/<controller>/<action>',

        'message/<controller:\w+>/<id:\d+>' => 'message/<controller>/view',
        'message/<controller:\w+>/<action:\w+>/<id:\d+>' => 'message/<controller>/<action>',
        'message/<controller:\w+>/<action:\w+>' => 'message/<controller>/<action>',

        // general
        '<controller:\w+>/<id:\d+>' => '<controller>/view',
        '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
        '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
      ),
    ),
  )
);

?>