<?php
/* @var $this SiteController */
$baseUrl = $this->assetsUrl;

$this->pageTitle='Discover '.$title.' - '.Yii::app()->name;
Yii::app()->assetCompiler->registerAssetGroup(array('project-list.less'), $baseUrl);
?>

<div class="container clearfix" id="projects">
  <div class="head-title">
  <h1><strong>Discover</strong> Projects</h1>
  <span class="subtitle"><?php __("Passion, ideas, and ambition abound. Start exploring!");?></span>
  </div>
  <div class="row">
    <div class="span9 p-list">

      <h3><?php __("Staff Picks");?></h3>
      <ul class="row">
        <?php if (empty($projects['staff_pick'])): ?>
          <p class="paragraph-note"><?php __("No Project Available Yet") ?> </p>
        <?php else: ?>
        <?php foreach ($projects['staff_pick'] as $project):?>
        <li class="span4 prj-cell">
          <div class="ppi-wrap">
            <div class="prj-img"><?php echo CHtml::link(CHtml::image($project->image), "/project/view/".$project->id);?></div>
            <div class="prj-info">              
              <div class="prj-title">
                <h3><?php echo CHtml::link($project->title."<span>".___("by %s", array($project->user->username))."</span>",array("project/view", 'id'=>$project->id, 'slug'=>$project->slug))?> </h3>
              </div>
              <div class="prj-desc">
                <p><?php echo $project->excerpt;?></p>
              </div>

              <div class="prj-stats">
                <div class="clearfix prj-info2">
                  <div class="prj-location">
                    <span class="pictos">@</span><?php echo $project->user->profile->city;?>
                  </div>
                  <div class="prj-cat">
                    <span class="pictos">I</span><?php __($project->category->name)?>
                  </div>
                </div>
                <div class="prj-fund-stats">
                  <div class="prj-fund-current" style="width:<?php _p($project->getFundingRatio(), true)?>"></div>
                  <div class="prj-stats-detail">
                    <div class="stat1">
                      <?php _p($project->getFundingRatio())?><span><?php __("funded") ?></span>
                    </div>
                    <div class="stat2">
                      <?php _m($project->funding_current)?><span><?php __("pledged") ?></span>
                    </div>
                    <div class="stat3">
                      <?php _dd($project->end_time);?><span><?php __("to go") ?></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>
        <?php endforeach;?>
        <?php endif; ?>

      </ul>

      <h3><?php __("Popular");?></h3>
      <ul class="row">
        <?php if (empty($projects['popular'])): ?>
          <p class="paragraph-note"><?php __("No Project Available Yet") ?> </p>
        <?php else: ?>
        <?php foreach ($projects['popular'] as $project):?>
        <li class="span4 prj-cell">
          <div class="ppi-wrap">
            <div class="prj-img"><?php echo CHtml::link(CHtml::image($project->image), "/project/view/".$project->id);?></div>
            <div class="prj-info">
              <div class="prj-title">
                <h3><?php echo CHtml::link($project->title."<span>".___("by %s", array($project->user->username))."</span>",array("project/view", 'id'=>$project->id, 'slug'=>$project->slug))?> </h3>
              </div>

              <div class="prj-desc">
                <p><?php echo $project->excerpt;?></p>
              </div>

              <div class="prj-stats">
                <div class="clearfix prj-info2">
                  <div class="prj-location">
                    <span class="pictos">@</span><?php echo $project->user->profile->city;?>
                  </div>
                  <div class="prj-cat">
                    <span class="pictos">I</span><?php __($project->category->name)?>
                  </div>
                </div>
                <div class="prj-fund-stats">
                  <div class="prj-fund-current" style="width:<?php _p($project->getFundingRatio(), true)?>"></div>
                  <div class="prj-stats-detail">
                    <div class="stat1">
                      <?php _p($project->getFundingRatio())?><span><?php __("funded") ?></span>
                    </div>
                    <div class="stat2">
                      <?php _m($project->funding_current)?><span><?php __("pledged") ?></span>
                    </div>
                    <div class="stat3">
                      <?php _dd($project->end_time);?><span><?php __("to go") ?></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>
        <?php endforeach;?>
        <?php endif;?>
      </ul>

      <h3><?php __("Recently Successful");?></h3>
      <ul class="row">
        <?php if (empty($projects['success'])): ?>
          <p class="paragraph-note"><?php __("No Project Available Yet") ?> </p>
        <?php else: ?>
        <?php foreach ($projects['success'] as $project):?>        
        <li class="span4 prj-cell">
          <div class="ppi-wrap">
            <div class="prj-img"><?php echo CHtml::link(CHtml::image($project->image), "/project/view/".$project->id);?></div>
            <div class="prj-info">
              <div class="prj-title">
                <h3><?php echo CHtml::link($project->title."<span>".___("by %s", array($project->user->username))."</span>",array("project/view", 'id'=>$project->id, 'slug'=>$project->slug))?> </h3>
              </div>

              <div class="prj-desc">
                <p><?php echo $project->excerpt;?></p>
              </div>
              <div class="prj-stats">
                <div class="clearfix prj-info2">
                  <div class="prj-location">
                    <span class="pictos">@</span><?php echo $project->user->profile->city;?>
                  </div>
                  <div class="prj-cat">
                    <span class="pictos">I</span><?php __($project->category->name)?>
                  </div>
                </div>
                <div class="prj-fund-stats">
                  <div class="prj-fund-current" style="width:<?php _p($project->getFundingRatio(), true)?>"></div>
                  <div class="prj-stats-detail">
                    <div class="stat1">
                      <?php _p($project->getFundingRatio())?><span><?php __("funded") ?></span>
                    </div>
                    <div class="stat2">
                      <?php _m($project->funding_current)?><span><?php __("pledged") ?></span>
                    </div>
                    <div class="stat3">
                      <?php _dd($project->end_time);?><span><?php __("to go") ?></span>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </li>
        <?php endforeach;?>        
        <?php endif; ?>
      </ul>
    </div>



    <div class="span3" id="sidebar-wrap">
      <?php $this->renderPartial('//common/side-menu',compact('categories'));?>
    </div>
  </div>
</div>

