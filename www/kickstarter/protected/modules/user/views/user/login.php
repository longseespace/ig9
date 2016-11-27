<?php
$ac = Yii::app()->assetCompiler;
$ac->registerAssetGroup(array('script.js', 'plugins.js', 'user.less', 'general.less'), $this->assetsUrl);

$this->pageTitle("Login");
$this->breadcrumbs=array(
  UserModule::t("Login"),
);
?>

<div class="container">

<h1><?php echo UserModule::t("Login"); ?></h1>

<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

<div class="success">
	<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>

<?php endif; ?>

<p><?php echo UserModule::t("Please fill out the following form with your login credentials:"); ?></p>

<div class="form">
<?php echo CHtml::beginForm(); ?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
	
	<?php echo CHtml::errorSummary($model); ?>
	
	<div class="input-row">
		<?php echo CHtml::activeLabelEx($model,'username'); ?>
		<?php echo CHtml::activeTextField($model,'username') ?>
	</div>
	
	<div class="input-row">
		<?php echo CHtml::activeLabelEx($model,'password'); ?>
		<?php echo CHtml::activePasswordField($model,'password') ?>
	</div>
	
	<div class="input-row">
		<div class="hint">
		<?php echo CHtml::link(UserModule::t("Lost Password?"),$this->url('user', 'recovery')); ?>
		</div>
	</div>
	
	<div class="input-row rememberMe">
		<?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
		<?php echo CHtml::activeLabelEx($model,'rememberMe'); ?>
	</div>

	<div class="input-row submit">
		<?php echo CHtml::submitButton(UserModule::t("Login"), array('class' => 'btn-danger btn')); ?>

        <div class="hint">
          <span class="or"><?php echo UserModule::t("or") ?></span>
          <?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?>
        </div>
	</div>
	
<?php echo CHtml::endForm(); ?>
</div><!-- form -->

  <div class="hybrid">
    <?php $this->widget('application.modules.hybridauth.widgets.renderProviders'); ?>
  </div>


<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);
?>
</div>