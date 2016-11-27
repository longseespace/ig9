<?php
$ac = Yii::app()->assetCompiler;
$ac->registerAssetGroup(array('script.js', 'plugins.js', 'user.less', 'general.less'), $this->assetsUrl);

$this->pageTitle("Restore");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Restore"),
);
?>

<div class="container">

<h1><?php echo UserModule::t("Restore"); ?></h1>

<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
</div>
<?php else: ?>

<div class="form">
<?php echo CHtml::beginForm(); ?>

	<?php echo CHtml::errorSummary($form); ?>
	
	<div class="row">
		<?php echo CHtml::activeLabel($form,'login_or_email'); ?>
		<?php echo CHtml::activeTextField($form,'login_or_email') ?>
		<p class="hint"><?php echo UserModule::t("Please enter your login or email addres."); ?></p>
	</div>
	
	<div class="row submit">
		<?php echo CHtml::submitButton(UserModule::t("Restore"), array('class' => 'btn-danger btn')); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->
<?php endif; ?>

  <div class="hybrid">
    <?php $this->widget('application.modules.hybridauth.widgets.renderProviders'); ?>
  </div>

</div>