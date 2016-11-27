<?php
$baseUrl = $this->assetsUrl;
$this->pageTitle = "Create New Project — " . Yii::app()->name;

$keys = array_keys($this->steps);
$nextKey = array_search($this->action->id, $keys) + 1;
$next = $this->steps[$keys[$nextKey]];

?>


<div class="content" data-category-name="" id="forms">
  <div id="running-board-wrap">
    <div class="container" id="running-board">
      <ol class="help-panels" style="height: auto;">
        <li class="panel" id="the-story-help" style="display: list-item;">
          <h3>
            <?php __("It’s not just a project, it’s a story.") ?>
          </h3>
          <p>
            <?php __("Tell it with a video. It doesn’t have to be fancy, it just has to be you.") ?>
          </p>
        </li>
      </ol>
    </div>
  </div>
  <div class="container">
    <div id="main">
      <div class="window">
        <ol class="form-panels">
          <li class="panel" data-panel_id="the-story" id="the-story-panel">
            <fieldset>
              <ol class="fields">
                <li class="project-video">
                    <div class="grey-field">
                      <label class="primary" for="project_video"><?php __("Project video") ?></label>
                      <div class="field-wrapper">
                        <h6><?php __('Upload your video here:'); ?></h6>
                        <div class="NS-assets_form video">
                          <?php
                            $this->widget('application.modules.youtube.widgets.Uploader', array(
                              'targetSelector' => '#project-video',
                              'inputClass' => 'custom-file',
                              'videoTitle' => 'ig9.vn - Project #'.$project->id.' : '.$project->title,
                              'videoDescription' => $project->excerpt,
                              'videoId' => (empty($project->video) ? null : $project->video)
                            ));
                          ?>
                        </div>
                        <h6><?php __('Or copy your video url from youtube here:'); ?></h6>
                        <div>
                          <?php echo CHtml::activeTextField($project, 'videoUrl'); ?>
                        </div>
                        <div class="field-help-2">
                          <p>
                            <?php __("The most important thing about project videos? Making one. Projects with a video have a much higher chance of success. It doesn't need to be an Oscar contender, just be yourself and explain what you want to do. For helpful tips and a dose of inspiration, check out our post on") ?> <a href="/help/school/making_your_video" class="has-icon popup" target="_blank"><?php __("making an awesome project video") ?></a>.
                          </p>
                        </div>
                      </div>
                    </div>
                </li>
                <li class="description">
                  <?php $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'theform',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                      'validateOnSubmit' => true
                    ),
                    'htmlOptions' => array('enctype'=>'multipart/form-data'),
                  )); ?>
                  <div class="grey-field no-margin">
                    <?php echo $form->labelEx($project, ___('description'), array('class'=>'primary')); ?>
                    <!-- <div class="field-wrapper">
                      <div class="character_counter_wrapper">
                        <?php echo $form->textField($project, 'title', array('size' => 60, 'maxlength' => 60)); ?>
                        <span class="character_counter_container"><span class="character_counter" data-maxlength="60" rel="#application\models\Project_image">60</span>/60</span>
                      </div>
                      <?php echo $form->error($project, 'title'); ?>
                      <div class="field-help-2">
                        <p>
                          <?php __('Use your project description to share more about what you’re raising funds to do and how you plan to pull it off. It’s up to you to make the case for your project.') ?>
                        </p>
                      </div>
                    </div> -->
                    <div class="field-wrapper">
                      <div class="field-help-2">
                        <p>
                          <?php __("Use your project description to share more about what you’re raising funds to do and how you plan to pull it off. It’s up to you to make the case for your project.") ?>
                        </p>
                      </div>
                    </div>
                    <div class='redactor-wrapper'>
                      <?php // echo $form->textarea($project, "description", array("id"=>"project-desc", "class"=>"tinymce"));?>

                      <?php 
                        $this->widget('widgets.redactorjs.Redactor', array(
                          'model' => $project,
                          'attribute' => 'description',
                          'editorOptions' => array(
                            'focus' => false,
                            'buttons' => array('formatting', '|', 'bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'image', 'video', 'table', 'link', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'horizontalrule')
                          )
                        ));
                      ?>
                    </div>
                    <?php echo $form->error($project, 'title'); ?>
                  </div>
                  <?php echo $form->hiddenField($project, "video", array("id"=>"project-video", 'disabled'=>'disabled'));?>
                  <?php echo $form->hiddenField($project, "videoUrl", array("id"=>"project-videoUrl", 'disabled'=>'disabled'));?>
                  <?php $this->endWidget(); ?>
                </li>
              </ol>
            </fieldset>
          </li>
        </ol>
      </div>
    </div>
    <div id="sidebar-wrap">
      <div id="sidebar">
        <ol class="sidebar-help-panels">

          <li class="panel" id="the-story-sidebar-help" style="display: list-item;">
            <div class="video-tout">
              <a href="/help/school/making_your_video" class="school-tout" target="_blank"><span>How to:</span>Make an awesome video</a>
            </div>
            <h5>
              <?php __("Important reminder") ?>
            </h5>
            <p>
              <?php __("Don't use music, images, video, or other content that you don't have the rights to. Reusing copyrighted material is almost always against the law and can lead to <strong>expensive lawsuits</strong> down the road. The easiest way to avoid copyright troubles is to create all the content yourself or use content that is free for public use.") ?>
            </p>
            <p>
              <?php __("For legal, mostly free alternatives, check out some of these great resources:") ?> <a href="http://soundcloud.com" class="has-icon popup" target="_blank">SoundCloud</a>, <a href="http://vimeo.com/musicstore" class="has-icon popup" target="_blank"><?php __("Vimeo Music Store") ?></a>, <a href="http://freemusicarchive.org" class="has-icon popup" target="_blank"><?php __("Free Music Archive") ?></a>, <?php __("and") ?> <a href="http://ccmixter.org" class="has-icon popup" target="_blank"><?php __("ccMixter") ?></a>.
            </p>
          </li>

        </ol>
      </div>
    </div><!-- .tools -->

    <?php $this->renderPartial('//project/toolbar') ?>
  </div><!-- .container -->
</div>