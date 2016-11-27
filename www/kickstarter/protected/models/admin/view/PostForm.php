<?php
return array(
  'title'=>'Manage Post',

  'elements'=>array(
    'title'=>array(
      'type'=>'text',
      'attributes' => array('class' => 'slugify')
    ),
    'slug'=>array(
      'type'=>'text',
      'attributes' => array('id' => 'slug')
    ),
    Yii::app()->controller->widget('widgets.redactorjs.Redactor', array(
      'model' => !empty($_GET['id']) ? Post::model()->findByPk($_GET['id']) : Post::model(),
      'attribute' => 'content',
      'editorOptions' => array(
        'imageUpload' => Yii::app()->createAbsoluteUrl('/admin/file/uploads'),
        'imageGetJson' => Yii::app()->createAbsoluteUrl('/admin/file/images'),
        'minHeight' => 300
      ),
    ), true),
    'tags'=>array(
      'type'=>'text',
      //'attributes' => array()
    ),
  ),

  'buttons'=>array(
    'submit'=>array(
      'type'=>'submit',
      'label'=>'Save',
      'class' => 'btn btn-primary btn-large'
    ),
  ),
);
?>