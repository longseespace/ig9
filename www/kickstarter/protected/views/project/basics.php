<?php
$baseUrl = $this->assetsUrl;
$this->pageTitle = "Create New Project — " . Yii::app()->name;

?>

<?php $form = $this->beginWidget('CActiveForm', array(
  'id' => 'theform',
  'enableAjaxValidation' => true,
  'enableClientValidation' => true,
  'clientOptions' => array(
    'validateOnSubmit' => true
  ),
  'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

<div class="content" data-category-name="" id="forms">
  <div id="running-board-wrap">
    <div class="container" id="running-board">
      <ol class="help-panels" style="height: auto;">
        <li class="panel selected" id="the-basics-help" style="display: block;">
          <h3>
            <?php __('Meet your new project.') ?>
          </h3>
          <p>
            <?php __('Start by giving it a name, a pic, and other important details.') ?>
          </p>
        </li>
      </ol>
    </div>
  </div>

  <div class="container">
    <div id="main">
      <div class="window">
        <ol class="form-panels">
          <li class="panel" data-panel_id="the-basics" id="the-basics-panel">
            <?php if ($project->hasErrors()): ?>
              <div class="alert alert-error">
                <?php __('An error occurred') ?>
              </div>
            <?php endif ?>

            <fieldset>

              <ol class="fields">
                <li class="project-image">
                  <div class="grey-field">
                    <?php echo $form->labelEx($project, ___('Image'), array('class'=>'primary')); ?>
                    <div class="field-wrapper fileinput">
                      <?php if (!empty($project->image)): ?>
                        <div class='image-preview'>
                          <?php echo CHtml::image($project->image, 'Project Image', array('width' => 450)); ?>
                        </div>
                      <?php endif ?>

                      <?php echo $form->fileField($project, 'image', array('class' => 'custom-file', 'size' => 40)); ?>
                      <?php echo $form->error($project, 'image'); ?>
                    </div>
                  </div>
                </li>
                <li class="project-title">
                  <div class="grey-field">
                    <?php echo $form->labelEx($project, ___('Title'), array('class'=>'primary')); ?>
                    <div class="field-wrapper">
                      <div class="character_counter_wrapper">
                        <?php echo $form->textField($project, 'title', array('size' => 60, 'maxlength' => 60)); ?>
                        <span class="character_counter_container"><span class="character_counter" data-maxlength="60" rel="#application\models\Project_image">60</span>/60</span>
                      </div>
                      <?php echo $form->error($project, 'title'); ?>
                      <div class="field-help-2">
                        <p>
                          <?php __('Your project title should be simple, specific, and memorable, and it should include the title of the creative project you\'re raising funds for. Avoid words like "help,” "support,” or "fund.”') ?>
                        </p>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="category">
                  <div class="grey-field">
                    <?php echo $form->labelEx($project, 'Category', array('class'=>'primary')); ?>
                    <div class="field-wrapper">
                      <?php echo $form->dropDownList($project, 'category_id', CHtml::listData($category->findAll(), 'id', 'name')); ?>
                    </div>
                  </div>
                </li>
                <li class="short-description">
                  <div class="grey-field">
                    <?php echo $form->labelEx($project, ___('Excerpt'), array('class'=>'primary')); ?>
                    <div class="field-wrapper">
                      <div class="character_counter_wrapper">
                        <?php echo $form->textArea($project, 'excerpt', array('cols' => 40, 'maxlength' => 135, 'rows' => 20)); ?>
                        <span class="character_counter_container"><span class="character_counter" data-maxlength="135" rel="#project-blurb">135</span>/135</span>
                      </div>
                      <?php echo $form->error($project, 'excerpt'); ?>
                      <div class="field-help-2">
                        <p>
                          <?php __('If you had to describe your project in one tweet, how would you do it?') ?>
                        </p>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="funding-duration">
                  <div class="grey-field">
                    <?php echo $form->labelEx($project, ___('Duration'), array('class'=>'primary')); ?>
                    <div class="field-wrapper">
                      <ul class="options">
                        <li class="option number-of-days">
                          <label class="option_label" for="duration_duration"><?php echo CHtml::radioButton('duration', $project->duration > 0, array('value' => 'duration', 'id' => 'duration_duration')) ?> <strong><?php __("Number of days") ?></strong></label><em class="rec"><?php __("1−60 days") ?></em><span><?php echo $form->textField($project, 'duration', array('length' => 3, 'id' => 'project-duration',)) ?></span>
                        </li>
                        <li class="option date-time <?php echo ($project->duration) ? 'disabled' : '' ?>">
                          <label class="option_label" for="duration_deadline"><?php echo CHtml::radioButton('duration', $project->duration == 0, array('value' => 'deadline', 'id' => 'duration_deadline')) ?> <strong><?php __("End on date") ?></strong></label><span><?php echo $form->textField($project, 'end_time', array('class' => 'datepicker', 'id' => 'project-deadline', 'value' => d__($project->end_time))) ?></span>
                        </li>
                      </ul>
                      <div class="field-help-2">
                        <p>
                          <?php __("We recommend that projects last 30 days or less. Shorter durations have higher success rates, and will create a helpful sense of urgency around your project. For more on duration, see") ?> <a href="/help/school/setting_your_goal" class="has-icon popup" target="_blank"><?php __("IG9 School") ?></a>.
                        </p>
                        
                      </div>
                    </div>
                  </div>
                </li>
                <li class="funding-goal">
                  <div class="grey-field">
                    <?php echo $form->labelEx($project, ___('Funding_Goal'), array('class'=>'primary')); ?>
                    <div class="field-wrapper">
                      <?php echo $form->textField($project, 'funding_goal', array('size' => 10, 'placeholder' => '50 000 000', 'value' => $project->funding_goal?$project->funding_goal:"")); ?>
                      <?php echo $form->error($project, 'funding_goal'); ?>
                      <div class="field-help-2">
                        <p>
                          <?php __("Your funding goal should be the minimum amount needed to complete the project and fulfill all rewards. Because funding is all-or-nothing, you can always raise more than your goal but never less.") ?>
                        </p>                        
                      </div>
                    </div>
                  </div>
                </li>

                <li class="contact-point">
                  <div class="grey-field">
                    <?php echo $form->labelEx($project, ___('Contact Point'), array('class'=>'primary')); ?>
                    <div class="field-wrapper">
                      <?php echo $form->textField($project, 'phone', array('size' => 15, 'placeholder' => 'e.g: 0912345678', 'value' => $project->phone?$project->phone:"")); ?>
                      <?php echo $form->error($project, 'phone'); ?>
                      <div class="field-help-2">
                        <p>
                          <?php __("Please provide your phone number so we can contact you just in case.") ?>
                        </p>                        
                      </div>
                    </div>
                  </div>
                </li>
              </ol>
            </fieldset>
          </li>

        </ol>
      </div>
    </div>

    <div id="sidebar">
      <ol class="sidebar-help-panels">

        <li class="panel selected" id="the-basics-sidebar-help" style="display: block;">
          <a href="/help/school/defining_your_project" class="school-tout" target="_blank"><span><?php __("How to:") ?></span><?php __("Make an awesome project") ?></a>
          <!-- <div id="project-card-preview">

            <div class="ppi-wrap">
              <div class="ppi-content">
                <div class="ppi-img">
                  <?php if (empty($project->image)): ?>
                    <img src="<?php echo $baseUrl;?>/img/photo-little.jpg">
                  <?php else: ?>
                    <?php echo CHtml::image($project->image, 'Project Image', array('width' => 210)); ?>
                  <?php endif ?>
                </div>
                <div class="ppi-info">
                  <h2> <strong><?php echo empty($project->title) ? 'Untitled' : $project->title ?></strong> by <?php echo $project->user->username ?> </h2>
                  <p><?php echo $project->excerpt ?></p>
                </div>
                <div class="ppi-footer">
                  <div class="progress">
                    <div style="width: <?php echo ($project->fundingRatio + 0.5)?>%;" class="bar"></div>
                  </div>
                  <ul class="project-stats nostyle v-list clearfix">
                    <li class="first funded">
                      <strong><?php _p($project->fundingRatio)?></strong><?php __('funded'); ?> </li>
                    <li class="pledged"> <strong><?php _m($project->funding_current)?></strong> <?php __('pledged') ?> </li>
                    <li class="last ksr_page_timer" data-end_time="2012-09-09T13:58:05Z"> <strong>
                    <div class="num">16</div>
                    </strong> <?php __('days left') ?> </li>
                  </ul>
                </div>
              </div> -->
            </div>

          </div>
        </li>

      </ol>
    </div>

    <?php $this->renderPartial('//project/toolbar') ?>
  </div><!-- .container -->
</div>

<?php $this->endWidget(); ?>