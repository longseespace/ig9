<?php
/* @var $this CommentController */
/* @var $model Comment */
/* @var $form CActiveForm */
?>

<div class="comment-form">

<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'comment-form',
  'enableAjaxValidation'=>true,
)); ?>


<?php echo $form->errorSummary($model); ?>
<?php if (Yii::app()->user->isGuest) : ?>
  <p><?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Your name here... (required)')); ?></p>

  <p><?php echo $form->textField($model,'email',array('cols'=>50, 'placeholder'=>'Your email here... (required)')); ?></p>
  
  <p><?php echo $form->textField($model,'url',array('cols'=>50, 'placeholder'=>'Your website here... (optional)')); ?></p>
<?php endif; ?>

  <p><?php echo $form->textArea($model,'content',array('rows'=>4, 'class'=>'input-block-level')); ?></p>

  <div>
    <p><?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?> Please limit your comment to the issues at hand. Comments promoting a project 
will be removed. Thanks!</p>
  </div>

<?php $this->endWidget(); ?>

</div><!-- form -->