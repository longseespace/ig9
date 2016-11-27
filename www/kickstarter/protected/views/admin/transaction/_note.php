<?php
  $form=$this->beginWidget('CActiveForm',array(
    'id'=>'note-form',
    'enableAjaxValidation'=>false,
    'action'=>array(
      '/admin/transaction/note',
      'id' => $model->id
    ),
    'htmlOptions'=>array(
      'class' => 'form-horizontal'
    )
  ));
?>

<div class="control-group">
  <label class="control-label" for="inputNote">Note</label>
  <div class="controls">
    <?php echo $form->textArea($model, 'note'); ?>
  </div>
</div>

<div class="control-group">
  <div class="controls">
    <?php echo CHtml::submitButton('submit', array('class' => 'btn btn-primary')); ?>
  </div>
</div>

<?php $this->endWidget(); ?>