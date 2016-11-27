<?php

return array(
  'import' => array(
    'application.modules.translate.TranslateModule'
  ),
  'language' => 'vi',
  'components' => array(
    'messages' => array(
      'class' => 'CDbMessageSource',
      'onMissingTranslation' => array(
        'Ei18n',
        'missingTranslation'
      ),
      'cachingDuration' => 3600,
      'sourceMessageTable' => 'source_messages',
      'translatedMessageTable' => 'messages'
    ),
    'translate' => array(
      'class' => 'translate.components.Ei18n',
      'createTranslationTables' => false,
      'connectionID' => 'db',
      'languages' => array(
        'vi' => 'Tiếng Việt',
        'en' => 'English'
      )
    )
  ),
  'modules' => array(
    'translate'
  ) ,
  'preload' => array(
    'translate'
  )
);
?>