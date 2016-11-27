<?php
/**
 * Author: Long Doan
 * Date: 8/29/12 2:57 PM
 */

return array(
  'title'=>'Manage Page',

  'elements'=>array(
    'title'=>array(
      'type'=>'text',
      'attributes' => array('class' => 'slugify')
    ),
    'slug'=>array(
      'type'=>'text',
      'attributes' => array('id' => 'slug')
    ),
//    'content'=>array(
//      'type'=>'textarea',
//      'attributes' => array('class' => 'tinymce')
//    )
    Yii::app()->controller->widget('widgets.redactorjs.Redactor', array(
      'model' => !empty($_GET['id']) ? Page::model()->findByPk($_GET['id']) : Page::model(),
      'attribute' => 'content',
      'editorOptions' => array(
        'imageUpload' => Yii::app()->createAbsoluteUrl('/admin/file/upload'),
        'imageGetJson' => Yii::app()->createAbsoluteUrl('/admin/file/images'),
        'minHeight' => 300
      ),
    ), true),
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