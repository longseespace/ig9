<?php
$baseUrl = $this->assetsUrl;
$this->pageTitle=$project->title." - ".Yii::app()->name;
Yii::app()->assetCompiler->registerAssetGroup(array('project-view.less'), $baseUrl);

$js = <<<EOD
(function($){

  $('.play-btn').on('click', function(){
    $(this).parent().empty().append('<iframe class="youtube-player" type="text/html" width="640" height="465" autoplay="1" rel="0" src="http://www.youtube.com/embed/{$project->video}" frameborder="0"></iframe>')
  });

  $('#package-list .reward-item').on('click', function(){
    $('#' + $(this).data('modal')).modal();
  });

  $('#package-list .reward-item a').on('click', function(e){
    e.stopPropagation();
  });

})(jQuery);
EOD;

Yii::app()->clientScript->registerScript('project-view', $js);
?>

<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'fbmeta')); ?>

<meta property="og:image" content="<?php echo strpos($project->image, 'http://') === false ? 'http://ig9.vn'.$project->image : $project->image ?>" />
<meta property="og:title" content="<?php echo strip_tags(htmlspecialchars($project->title)) ?>" />
<meta property="og:description" content="<?php echo strip_tags(htmlspecialchars($project->excerpt)) ?>" />
<meta property="og:url" content="<?php echo $this->createAbsoluteUrl('/project/view', array('id' => $project->id, 'slug' => $project->slug)) ?>" />
<meta property="og:site_name" content="IG9.VN - the first crowdfunding platform in Vietnam" />
<meta property="og:type" content="ignitevn:project" />
<meta name="description" content="<?php echo strip_tags(htmlspecialchars($project->excerpt)) ?>" />

<?php $this->endWidget();?>

<div id="project-header">
  <h1 class="title"><?php echo $project->title;?></h1>
  <h2 class="subtile"><?php __("by");?> <a href="<?php echo $this->createUrl('/user/profile', array('id' => $project->user->id)) ?>"><?php echo $project->user->username;?></a></h2>
</div>
<div class="main">

  <div class="container">
    <?php $newtag = $latestUpdate->getTotalItemCount() > 0 ? ' <img id="update-new-tag" src="' . $this->assetsUrl . '/img/new-tag.png" alt="new"/>' : ''; ?>
    <div id="prj-nav">
      <?php echo CHtml::link(___("Project"),array("project/view", 'id'=>$project->id, 'slug'=>$project->slug),array('class'=>'selected'));?>
      <?php echo CHtml::link(___("Updates") . $newtag . " <span class='count'>{$project->updateCount}</span>",array("updates", 'id'=>$project->id));?>
      <?php echo CHtml::link(___("Backers") . " <span class='count'>{$project->backerCount}</span>",array("backers", 'id'=>$project->id));?>
      <?php echo CHtml::link(___("Comments") . " <span class='count'>{$project->commentCount}</span>",array("comments", 'id'=>$project->id));?>
    </div>
    <div class="row">
      <div class="span8" id="prjv-left">
        <div class="prj-slide">
          <?php echo CHtml::image($project->bigImage);?>
          <?php if(!empty($project->video)):?>
          <span class="play-btn"></span>
          <?php endif;?>
        </div>
        <div class="prj-share">
          <div class="fb-like" data-href="<?php echo $this->createAbsoluteUrl('/project/view', array('id' => $project->id, 'slug' => $project->slug)); ?>" data-send="false" data-width="450" data-show-faces="false" style="float: left"></div>
<!--          --><?php //$this->renderPartial('_fbshare', compact('project')) ?>
        </div>
        <div class="prj-short clearfix">
          <div class="short-desc">
            <h4><?php echo $project->excerpt;?></h4>
          </div>
          <div class="short-info">
            <div><span class="pictos">\</span> <strong><?php __("Launched");?>:</strong> <?php _d($project->getStartTime());?></div>
            <div><span class="pictos">t</span> <strong><?php __("Funding Ends");?>:</strong> <?php _d($project->end_time);?></div>
<!--            <button class="btn"><span class="pictos">+</span> --><?php //__("Remind me");?><!--</button>-->
          </div>
        </div>
        <div class="full-description">
          <?php echo $project->description;?>
        </div>
      </div>
      <?php echo $this->renderPartial('_view_sidebar', compact('project')); ?>

      <?php echo $this->renderPartial('_random_projects', compact('randomProjects')); ?>
    </div>
  </div>
</div>

<?php echo $this->renderPartial('_rewards_modals', compact('project')); ?>

<?php echo $this->renderPartial('_bio_modal', compact('project')); ?>