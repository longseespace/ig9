<?php
$baseUrl = $this->assetsUrl;
$this->pageTitle=$project->title." - ".Yii::app()->name;
Yii::app()->assetCompiler->registerAssetGroup(array('project-view.less'), $baseUrl);
?>

<div id="project-header">
  <h1 class="title"><?php echo $project->title;?></h1>
  <h2 class="subtile"><?php __("by");?> <a href="<?php echo $this->createUrl('/user/profile', array('id' => $project->user->id)); ?>"><?php echo $project->user->username;?></a></h2>
</div>
<div class="main">

  <div class="container">
    <?php $newtag = $latestUpdate->getTotalItemCount() > 0 ? ' <img id="update-new-tag" src="' . $this->assetsUrl . '/img/new-tag.png" alt="new"/>' : ''; ?>
    <div id="prj-nav">
      <?php echo CHtml::link(___("Project"),array("project/view", 'id'=>$project->id, 'slug'=>$project->slug));?>
      <?php echo CHtml::link(___("Updates") . $newtag . " <span class='count'>{$project->updateCount}</span>",array("updates", 'id'=>$project->id));?>
      <?php echo CHtml::link(___("Backers") . " <span class='count'>{$project->backerCount}</span>",array("backers", 'id'=>$project->id),array('class'=>'selected'));?>
      <?php echo CHtml::link(___("Comments") . " <span class='count'>{$project->commentCount}</span>",array("comments", 'id'=>$project->id));?>
    </div>
    <div class="row">
      <div class="span8" id="prjv-left">
        <?php
        $this->widget('zii.widgets.CListView', array(
          'dataProvider' => $backers,
          'pagerCssClass' => 'pagination pagination-centered',
          'pager'=>array(
            'header' => '',
            'htmlOptions' => array(
              'class' => ''
            )
          ),
          'template'=>'{items} {pager}',
          'emptyText' => ___('This project has no backers.'),
          'ajaxUpdate' => false,
          'itemView' => '_backer',
        ));
        ?>
      </div>
      <?php echo $this->renderPartial('_view_sidebar', compact('project')); ?>

      <?php echo $this->renderPartial('_random_projects', compact('randomProjects')); ?>
    </div>
  </div>
</div>

<?php echo $this->renderPartial('_rewards_modals', compact('project')); ?>

<?php echo $this->renderPartial('_bio_modal', compact('project')); ?>