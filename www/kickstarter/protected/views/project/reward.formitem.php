<?php $form = $this->beginWidget('CActiveForm', array(
  'id' => 'reward-form-'.$reward->id,
  'action' => $this->createUrl('project/reward', array('id' => $project->id)),
  'enableAjaxValidation' => true,
  'enableClientValidation' => true,
  'clientOptions' => array(
    'validateOnSubmit' => true
  )
)); ?>

<div class='grey-field'>
  <div class="summary">
    <label class="primary help"><?php __("Reward #") ?><span class="reward_num"><?php echo ++$index ?></span><span class="icon-question-sign icon"></span></label>
    <div class="field-wrapper">
      <div class="field-help-2" style="display: none;">
        <p>
          <?php __("You can limit the availability of a reward as needed. Once the limit is reached, the reward will be marked as \"sold out.\" The estimated delivery date is the date you expect to deliver the reward to backers. If the reward includes multiple items, set your date to when you expect everything to be delivered.") ?>
        </p>
      </div>
      
      <div class="NS-projects-reward">
        <?php $this->renderPartial('//project/reward.listitem', compact('reward')) ?>
      </div>

      <div class='reward-form' data-id="<?php echo $reward->id ?>" style="display: none; ">
        <?php $class = ($reward->hasErrors()) ? '' : 'hidden' ?>
        <div class="error-summary alert alert-error <?php echo $class ?>">
          <a href="#" class="close" data-dismiss="alert">×</a>
          <h5><?php __('An error occurred') ?></h5>
          <ul>
          <?php foreach ($reward->errors as $error): ?>
            <li><?php echo array_shift($error) ?></li>
          <?php endforeach ?>
          </ul>
        </div>
        <div class="field_container">
          <?php echo $form->hiddenField($reward, 'id'); ?>
          <div class="loading-indicator" >
            
          </div>
          <div class="minimum">
            <?php echo $form->labelEx($reward, 'amount', array('class'=>'primary')); ?>
            <?php echo $form->textField($reward, 'amount', array('size' => 30, 'placeholder' => '200.000đ')); ?>
            <?php $form->error($reward, 'amount') ?>
          </div>
          <div class="description">
            <?php echo $form->labelEx($reward, 'description', array('class'=>'primary')); ?>
            <?php echo $form->textArea($reward, 'description', array('cols' => 40, 'rows' => 30)); ?>
            <?php $form->error($reward, 'description') ?>
          </div>
          <div class="delivery-date">
            <?php $date = !empty($reward->delivery_time) ? getdate(strtotime($reward->delivery_time)) : array('mon' => '0', 'year' => '0'); ?>
            <?php echo $form->labelEx($reward, 'delivery_time', array('class'=>'primary')); ?>
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
            <!-- <div class="backers"> <span class="icon-backer-tag"></span> <span class="num-backers"> 0 <?php __("Backers") ?> </span> </div> -->
            
            <label class="primary">
              <input class="limit_checkbox" type="checkbox" <?php echo ($reward->backer_limit > 0) ? 'checked' : '' ?>>
              <?php __("Limit") ?> </label>
            <?php echo $form->textField($reward, 'backer_limit', array('size' => 30, 'style' => ($reward->backer_limit > 0) ? 'display: inline-block;' : 'display: none;')); ?>
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
</div>
<?php $this->endWidget(); ?>