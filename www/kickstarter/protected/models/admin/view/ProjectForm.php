<?php
/**
 * Author: Long Doan
 * Date: 8/29/12 2:57 PM
 */

return array(
  'title'=>'Manage Project',

  'elements'=>array(
    'title'=>array(
      'type'=>'text',
      'attributes' => array('class' => 'slugify')
    ),
    'slug'=>array(
      'type'=>'text',
      'attributes' => array('id' => 'slug')
    ),
    'excerpt'=>array(
      'type'=>'text',
    ),
//    'description'=>array(
//      'type'=>'textarea',
//      'attributes' => array('class' => 'tinymce')
//    ),
    Yii::app()->controller->widget('widgets.redactorjs.Redactor', array(
      'model' => !empty($_GET['id']) ? Project::model()->findByPk($_GET['id']) : Project::model(),
      'attribute' => 'description',
      'editorOptions' => array(
        'imageUpload' => Yii::app()->createAbsoluteUrl('/admin/file/upload'),
        'imageGetJson' => Yii::app()->createAbsoluteUrl('/admin/file/images'),
        'minHeight' => 300
      ),
    ), true),
    'image_url'=>array(
      'type'=>'text',
      'attributes' => array('class' => 'image')
    ),
    'video'=>array(
      'type'=>'text',
      'attributes' => array('class' => 'video')
    ),
    '<div class="span3">',
    'end_time'=>array(
      'type'=>'text',
      'attributes' => array('class' => 'datepicker')
    ),
    '</div><div class="span3">',
    'duration'=>array(
      'type'=>'number',
    ),
    '</div><div class="span3">',
    'funding_goal'=>array(
      'type'=>'number',
    ),
    '</div><div class="span2">',
    'featured'=>array(
      'type'=>'checkbox',
    ),
    '</div><div class="span2">',
    'status'=>array(
      'type'=>'dropdownlist',
      'items'=>array(Project::STATUS_ACTIVE => 'active',Project::STATUS_INACTIVE => 'inactive',Project::STATUS_DELETED => 'deleted',)
    ),
    '</div>',
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