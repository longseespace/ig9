<?php
/* @var $this SiteController */
$baseUrl = $this->assetsUrl;

$this->pageTitle='Discover '.$title.' - '.Yii::app()->name;
Yii::app()->assetCompiler->registerAssetGroup(array('project-list.less'), $baseUrl);
?>

<div class="container clearfix" id="projects">
  <h2><?php echo $title;?></h2>

  <div class="row">
    <div class="span9 p-list">

      <?php foreach ($categories as $category):?>
      <h3><?php echo $category->name; echo CHtml::link(___("View more"), array("discover/all", 'filter'=>$filter, 'slug'=>$category->slug))?></h3>
      <?php if (!count($category->{$entity})):?>
        <p><?php __("No Project Available Yet") ?> </p>
      <?php else:?>
      <ul class="row">
        
        <?php foreach ($category->{$entity} as $project):?>
        <li class="span4 prj-cell">
          <div class="ppi-wrap">
            <div class="ppi-content">
              <div class="pri-img"><?php echo CHtml::link(CHtml::image($project->image), "/project/view/".$project->id);?></div>
              <div class="pri-info">              
                <div class="pri-title">
                  <h3><?php echo CHtml::link($project->title,"/project/view/".$project->id)?> <span><?php __("by") ?></span> <?php echo CHtml::link($project->user->username,array('/user/profile', 'id' => $project->user->id));?> </h3>
                </div>
              </div>
              <div class="ppi-footer">
                <div class="progress">
                  <div style="width: <?php _p($project->funding_current/$project->funding_goal, true)?>" class="bar"></div>
                </div>
                <ul class="project-stats nostyle v-list clearfix">
                  <li class="first funded"> <strong><?php _p($project->funding_current/$project->funding_goal)?></strong> <?php __("funded") ?> </li>
                  <li class="pledged"> <strong><?php _m($project->funding_current)?></strong> <?php __("pledged") ?> </li>
                  <li class="last ksr_page_timer" data-end_time="2012-09-09T13:58:05Z"> <strong>
                    <div class="num"><?php _dd($project->end_time);?></div>
                    </strong> days left </li>
                </ul>
              </div>
            </div>
          </div>
        </li>
        <?php endforeach;?>

      </ul>
      <?php endif;?>

      <?php endforeach?>
    </div>
    <div class="span3" id="sidebar-wrap">
      <?php $this->renderPartial('//common/side-menu',compact('categories'));?>
    </div>
  </div>
</div>

