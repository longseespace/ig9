<?php
/* @var $this PostController */
/* @var $model Post */
/* @var $form CActiveForm */
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'post-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<p class="row">
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Title')); ?>
	</p>

	<div class="row">
		<?php $this->widget('widgets.redactorjs.Redactor', array(
	      'model' => !empty($_GET['id']) ? Post::model()->findByPk($_GET['id']) : Post::model(),
	      'attribute' => 'content',
	      'editorOptions' => array(
	      	'imageUpload' => Yii::app()->createAbsoluteUrl('/admin/file/uploads'),
        	'imageGetJson' => Yii::app()->createAbsoluteUrl('/admin/file/images'),
        	'minHeight' => 300),
      ));
    ?>
	</div>

	<p class="row">
		<?php //echo CHtml::hiddenField('Post[tags]', implode(',', $model->tags), array('multiple' => 'multiple', 'class' => 'tags noselect2', 'data-tags' => implode(',', Post::model()->getAllTags()))); ?>
		<?php echo $form->textField($model,'tags',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Tag')); ?>
	</p>

	<p class="row">
		<?php echo $form->textField($model,'source',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Your sources cited')); ?>
	</p>

	<div class="row">
		<?php echo $form->labelEx($model,'category'); ?>
		<?php echo $form->dropDownList($model,'category_id',CHtml::listData($categories, 'id','name')); ?>
		<?php echo $form->error($model,'category'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',array('1'=>'Draft','2'=>'Published','3'=>'Archived')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->