<?php
$baseUrl = $this->assetsUrl;
$this->pageTitle = "Create New Project — " . Yii::app()->name;

?>

<div class="content">
  <div id="running-board-wrap">
    <div class="container" id="running-board">
      <ol class="help-panels" style="height: auto;">
        <li class="panel selected" id="the-basics-help" style="display: block;">
          <h3>
            <?php __('Every project needs great rewards.') ?>
          </h3>
          <p>
            <?php __('Be creative and price them fairly. Explore other projects for inspiration!') ?>
          </p>
        </li>
      </ol>
    </div>
  </div>
  <div class="container">
    <div id="main">
      <div class="panel" data-panel_id="rewards" id="rewards-panel">
        <fieldset>
          <ol class="fields rewards nostyle">
            <li class="reward">
              <?php if (count($rewards) == 0): $firstTime = true; ?>

              <?php else: $firstTime = false; ?>

              <?php foreach ($rewards as $index => $reward): ?>

              <?php $this->renderPartial('//project/reward.formitem', compact('reward', 'project', 'index')) ?>

              <?php endforeach ?>

              <?php endif ?>
            </li>

            <?php
            $reward = new Reward;
            $form = $this->beginWidget('CActiveForm', array(
              'id' => 'theform',
              'enableAjaxValidation' => true,
              'enableClientValidation' => true,
              'clientOptions' => array(
                'validateOnSubmit' => true
              )
            )); ?>

            <li class="reward" id="reward_template" <?php echo $firstTime ? '' : 'style="display: none; "' ?>>
              <div class="grey-field">
                <div class="fields backer_rewards_fields reward-form">
                  <label class="primary help"><?php __("New Reward") ?> # <span class="icon-question-sign icon"></span></label>
                  <div class="field-wrapper">
                    <?php $class = ($reward->hasErrors()) ? '' : 'hidden' ?>
                    <div class="error-summary alert alert-error <?php echo $class ?>">
                      <h5><?php __('An error occurred') ?></h5>
                      <ul>
                      <?php foreach ($reward->errors as $error): ?>
                        <li><?php echo array_shift($error) ?></li>
                      <?php endforeach ?>
                      </ul>
                    </div>
                    <div class="field-help-2" style="display: none;">
                      <p><?php __("You can limit the availability of a reward as needed. Once the limit is reached, the reward will be marked as \"sold out.\" The estimated delivery date is the date you expect to deliver the reward to backers. If the reward includes multiple items, set your date to when you expect everything to be delivered.") ?></p>
                    </div>
                    <div class="field_container">
                      <div class="minimum">
                        <?php echo $form->labelEx($reward, ___('amount'), array('class'=>'primary')); ?>
                        <?php echo $form->textField($reward, 'amount', array('size' => 30, 'placeholder' => '200.000đ')); ?>
                        <?php $form->error($reward, 'amount') ?>
                      </div>
                      <div class="description">
                        <?php echo $form->labelEx($reward, ___('description'), array('class'=>'primary')); ?>
                        <?php echo $form->textArea($reward, 'description', array('cols' => 40, 'rows' => 30)); ?>
                        <?php $form->error($reward, 'description') ?>
                      </div>
                      <div class="delivery-date">
                        <?php $date = !empty($reward->delivery_time) ? getdate(strtotime($reward->delivery_time)) : array('mon' => '0', 'year' => '0'); ?>
                        <?php echo $form->labelEx($reward, ___('delivery_time'), array('class'=>'primary')); ?>
                        <?php echo $form->hiddenField($reward, 'delivery_time', array('data-month' => $date['mon'], 'data-year' => $date['year'])) ?>
                        <?php $form->error($reward, 'delivery_time') ?>
                        <?php $class = !count($reward->getErrors('delivery_time')) ? '' : 'error' ?>
                        <div class="date_container">
                          <?php echo CHtml::dropDownList('delivery_month', $date['mon'], array(
                              ___('Select month...'),
                              ___('January'),
                              ___('February'),
                              ___('March'),
                              ___('April'),
                              ___('May'),
                              ___('June'),
                              ___('July'),
                              ___('August'),
                              ___('September'),
                              ___('October'),
                              ___('November'),
                              ___('December')
                            ), array('class' => 'noselect2 month select '.$class)); ?>

                          <?php echo CHtml::dropDownList('delivery_year', $date['year'], array(
                              ___('Select year...'),
                              2012 => '2012',
                              2013 => '2013',
                              2014 => '2014',
                              2015 => '2015',
                              2016 => '2016'
                            ), array('class' => 'noselect2 year select '.$class)); ?>
                        </div>
                      </div>
                      <div class="limit">


                        <label class="primary">
                          <input class="limit_checkbox" type="checkbox">
                          <?php __("Limit") ?> </label>
                        <?php echo $form->textField($reward, 'backer_limit', array('size' => 30)); ?>
                        <?php $form->error($reward, 'backer_limit') ?>
                      </div>
                      <div class='action'>
                        <a class="btn submit btn-success"><span class="icon icon-white icon-ok-circle"></span><?php __("Save") ?></a>
                        <a class="btn cancel"> <?php __("Cancel") ?> </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <?php $this->endWidget(); ?>
          </ol>
          <div class="add-another-wrap">
            <a class="add-another" href="#" rel="#reward_template" style="">
              <div class="button"> <strong> <span class="icon icon-plus"></span> <?php __("Add another backer reward") ?> </strong> </div>
            </a> </div>
        </fieldset>
      </div>
    </div>

    <div id="sidebar">
      <ol class="sidebar-help-panels">

        <li class="panel" id="rewards-sidebar-help" style="display: list-item;">
          <a href="/help/school/creating_rewards" class="school-tout" target="_blank"><span>How to:</span>Create great rewards</a>
          <h5>
            <?php __("What to offer") ?>
          </h5>
          <p>
            <?php __("Copies of what you're making, unique experiences, and limited editions work great.") ?>
          </p>
          <h5>
            <?php __("How to price") ?>
          </h5>
          <ul>
            <li><?php __("Price fairly, offer value") ?>
            </li>
            <li><?php __("Budget shipping cost into the reward price") ?>
            </li>
            <li><?php __("You may need to create separate rewards for international backers, or ask them to add a specified amount to their pledges for the added costs") ?>
            </li>
          </ul>
          <h5 class="dont">
            <?php __("What's prohibited") ?>
          </h5>
          <ul>
            <li><?php __("Financial incentives") ?>
            </li>
            <li><?php __("Coupons, discounts, and cash-value gift cards") ?>
            </li>
            <li><?php __("Rewards in bulk quantities (more than ten of an item)") ?>
            </li>
            <li><?php __("For more, please review our") ?> <a href="#" class="link_to_prohibited_projects_dialog"><?php __("list of prohibited items and subject matter") ?></a>.
            </li>
          </ul>
        </li>

      </ol>
    </div>

  </div>

  <?php $this->renderPartial('//project/toolbar') ?>
</div>

<div class="modal hide" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php __("Please Confirm") ?></h3>
  </div>
  <div class="modal-body">
    <p><?php __("Are you sure you want to delete this reward?") ?></p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true"><?php __("No") ?></button>
    <button class="btn btn-danger"><?php __("Yes, DELETE") ?></button>
  </div>
</div>