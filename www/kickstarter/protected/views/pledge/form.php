<?php
$baseUrl = $this->assetsUrl;
$this->pageTitle="Project Name - ".Yii::app()->name;
Yii::app()->assetCompiler->registerAssetGroup(array('pledge.less', 'pledge.js'), $baseUrl);
?>

<?php $form = $this->beginWidget('CActiveForm', array(
  'id' => 'theform',
  'enableAjaxValidation' => true,
  'enableClientValidation' => true,
  'clientOptions' => array(
    'validateOnSubmit' => true
  )
)); ?>

<div id="project-header">
  <h1 class="title"><?php echo $project->title;?></h1>
  <h2 class="subtile"><?php __("by");?> <a href="#"><?php echo $project->user->username;?></a></h2>
</div>
<div class="main">

  <div class="container">

    <div class="row">
      <div class="span8 content">
        <h3 class='highlight'><?php __('Alrighty') ?>!</h3>
        <?php if ($pledgeForm->hasErrors()): ?>
          <div class="alert alert-error">
            <?php __('An error occurred') ?>
          </div>
        <?php endif ?>

        <?php echo $form->labelEx($pledgeForm, 'amount'); ?>

        <div class='field-wrapper'>
          <div class='amount-wrapper'>
            <?php echo $form->error($pledgeForm, 'amount') ?>
            <?php echo $form->textField($pledgeForm, 'amount', array('autocomplete' => 'off', 'class' => 'amount', 'maxlength' => 9)) ?>
          </div>
          <div class='help'>
            <?php __("It's up to you.") ?> <br/>
            <!-- <?php __("Any amount of $1 or more") ?> -->
          </div>
        </div>

        <?php echo $form->labelEx($pledgeForm, 'reward_id'); ?>
        <ol class='field-wrapper'>
          <!-- <li class='reward no_thx' data-amount='0'>
            <?php echo $form->radioButton($pledgeForm, 'reward_id', array('value' => '-1', 'id' => 'reward_id_0')); ?>
            <label class='no-reward' for="reward_id_0"><?php __("No Reward") ?></label>
            <span class="indicator"><?php __("YOU SELECTED") ?></span>
            <p class="description"><?php __("No thanks, I just want to help the project.") ?></p>
          </li> -->
          <?php foreach ($project->rewards as $reward): $selected = ($reward->id == $pledgeForm->reward_id); ?>
          <li class='reward <?php echo $selected ? 'selected' : '' ?>' data-amount='<?php echo $reward->amount ?>'>
            <input id='reward_id_<?php echo $reward->id ?>' name="PledgeForm[reward_id]" type="radio" value="<?php echo $reward->id ?>" <?php echo  $selected ? 'checked' : '' ?>>
            <label for="reward_id_<?php echo $reward->id ?>"><?php echo __m($reward->amount) ?> +</label>
            <span class="indicator"><?php __("YOU SELECTED") ?></span>
            <p class="description"><?php echo $reward->description ?></p>
          </li>
          <?php endforeach ?>

        </ol>

        <div class='actions'>
          <input type="submit" class='ig9btn' value="<?php __("Continue to next step") ?>">
        </div>
      </div>
      <div class="span4 content">

      </div>

    </div>

  </div>
</div>

<?php $this->endWidget(); ?>