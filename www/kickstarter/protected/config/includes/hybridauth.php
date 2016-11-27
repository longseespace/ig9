<?php
  return array(
    'modules' => array(
      'hybridauth' => array(
        'baseUrl' => 'http://'. $_SERVER['SERVER_NAME'] . '/hybridauth',
        'withYiiUser' => true, // Set to true if using yii-user
        "providers" => array (
          "Yahoo" => array (
            "enabled" => false
          ),
          "Google" => array (
            "enabled" => false,
            "keys"    => array ( "id" => "514848158425.apps.googleusercontent.com", "secret" => "vevqkO6CTtfSudrrSZdHGF2Z" ),
            "scope"   => ""
          ),
          "Facebook" => array (
            "enabled" => true,
            "keys"    => array ( "id" => "420094461372089", "secret" => "46d455dea70de7a636567549250dc6ae" ),
            "scope"   => "email,publish_stream",
            "display" => ""
          ),
          "Twitter" => array (
            "enabled" => false,
            "keys"    => array ( "key" => "NWCqihzcO60zVuUxk7n5gA", "secret" => "ebuSuSdgGRAMQNVLoebJD8lQGgoYcWDahNVJyvVFg" )
          ),
          'LinkedIn' => array (
            "enabled" => false,
            "keys"    => array ( "key" => "lt58calbuk90", "secret" => "eJYtPDCiBOhfYVDr" )
          )
        )
      )
    )
  );
?>