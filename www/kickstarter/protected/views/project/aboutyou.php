<?php
$baseUrl = $this->assetsUrl;
$this->pageTitle = "Create New Project — " . Yii::app()->name;

$keys = array_keys($this->steps);
$nextKey = array_search($this->action->id, $keys) + 1;
$next = $this->steps[$keys[$nextKey]];

$form = $this->beginWidget('CActiveForm', array(
  'id' => 'theform',
  'enableAjaxValidation' => true,
  'enableClientValidation' => true,
  'clientOptions' => array(
    'validateOnSubmit' => true
  )
));
?>


<div class="content" data-category-name="" id="forms">
  <div id="running-board-wrap">
    <div class="container" id="running-board">
      <ol class="help-panels" style="height: auto;">
        <li class="panel" id="the-story-help" style="display: list-item;">
          <h3>
            <?php __('Now litte bit about you'); ?>
          </h3>
          <p>
            <?php __('Tell us a bit about yourself') ?>
          </p>
        </li>
      </ol>
    </div>
  </div>
  <div class="container">
    <div id="main">
      <div class="window" style="height: 790px;">
        <ol class="form-panels">
          <li class="panel" data-panel_id="the-story" id="the-story-panel">
            <fieldset>
              <ol class="fields">
                <li class="description">

                  <div class="grey-field no-margin">
                    <?php echo $form->labelEx($project, ___('Biography'), array('class'=>'primary')); ?>
                    <div class="field-wrapper">
                      <div class="field-help-2">
                        <p>
                          <?php __("Use your project description to share more about yourself, like background, education, past successes") ?>
                        </p>
                      </div>
                    </div>
                    <div class='redactor-wrapper'>
                      <?php // echo $form->textarea($project, "personal_description", array("id"=>"project-desc", "class"=>"tinymce"));?>
                      <?php 
                        $this->widget('widgets.redactorjs.Redactor', array(
                          'model' => $project,
                          'attribute' => 'personal_description',
                          'editorOptions' => array(
                            'focus' => false,
                            'buttons' => array('formatting', '|', 'bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'image', 'video', 'table', 'link', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'horizontalrule')
                          )
                        ));
                      ?>
                    </div>
                    <?php echo $form->error($project, 'title'); ?>
                  </div>
                </li>
              </ol>
            </fieldset>
          </li>
        </ol>
      </div>
    </div>
    <div id="sidebar-wrap">
      <div id="sidebar">

      </div>
    </div><!-- .tools -->

    <?php $this->renderPartial('//project/toolbar') ?>
  </div><!-- .container -->
</div>

<?php $this->endWidget(); ?>