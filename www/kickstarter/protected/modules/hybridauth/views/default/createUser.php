<?php 
$baseUrl = $this->assetsUrl;
Yii::app()->assetCompiler->registerAssetGroup(array('general.less'), $baseUrl);?>

<div class="form">
	<h1><?php __("Choose a username and an email address") ?></h1>

	<?php 
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'create-user-form',
			'enableAjaxValidation'=>false,
		)); 
	?>

	<p class="note"><?php __("Fields with") ?> <span class="required">*</span> <?php __("are required.") ?></p>

	<?php echo $form->errorSummary($user); ?>

	<div class="row">
		<?php echo $form->labelEx($user,'username'); ?>
		<?php echo $form->textField($user,'username'); ?>
		<?php echo $form->error($user,'username'); ?>
	</div>

	

	<div class="row">
		<?php echo $form->labelEx($user,'email'); ?>
		<?php echo $form->textField($user,'email'); ?>
		<?php echo $form->error($user,'email'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($user->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->