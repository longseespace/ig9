<?php
/* @var $this SiteController */
$baseUrl = $this->assetsUrl;

$this->pageTitle='Discover '.$title.' - '.Yii::app()->name;
Yii::app()->assetCompiler->registerAssetGroup(array('project-list.less'), $baseUrl);
?>

<div class="container clearfix" id="projects">
  <h1><strong>Discover</strong> Projects</h1>
  <span class="subtitle">Passion, ideas, and ambition abound. Start exploring!</span>
  <h2><?php echo $title;?></h2>
  <div class="row">
    <div class="span9">
      <div class="row">
        <?php foreach ($projects as $project):?>
        <div class="span3 pp-item">
          <div class="ppi-wrap">
            <div class="ppi-content">
              <div class="ppi-img"><?php echo CHtml::link(CHtml::image($project->image), "/project/view/".$project->id);?></div>
              <div class="ppi-info">
                <h2> <strong><?php echo CHtml::link($project->title,"/project/view/".$project->id)?></strong> <?php __("by") ?> <?php echo CHtml::link($project->user->username,array('/user/profile', 'id' => $project->user->id));?> </h2>
                <p><?php echo $project->excerpt;?></p>
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
        </div>
        <?php endforeach;?>

      </div>
    </div>
    <div class="span3" id="sidebar-wrap">
      <div id="sidebar">
        <h3>Featured</h3>
        <ul class="navigation">
          <li><?php echo CHtml::link(___("Staff Picks"), array('project/list','filter'=>'staff-pick', 'ref'=>'side-bar'))?></li>
          <li><?php echo CHtml::link(___("Popular"), array('project/list', 'filter'=>'popular', 'ref'=>'side-bar'))?></li>
          <li><?php echo CHtml::link(___("Recently Launched"), array('project/list', 'filter'=>'recent', 'ref'=>'side-bar'))?></li>
          <li><?php echo CHtml::link(___("Ending Soon"), array('project/list', 'filter'=>'ending-soon', 'ref'=>'side-bar'))?></li>
          <li><?php echo CHtml::link(___("Most Funded"), array('project/list', 'filter'=>'most-funded', 'ref'=>'side-bar'))?></li>

          

        </ul>
        <h3>Categories</h3>
        <ul class="navigation">
          <?php foreach ($categories as $category):?>
            <li><?php echo CHtml::link($category->attributes['name'],'/discover/category/'.$category->slug);?></li>
          <?php endforeach?>


        </ul>


      </div>
    </div>
  </div>
</div>
</div>
