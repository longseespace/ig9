<?php
$baseUrl = $this->assetsUrl;
$cs = Yii::app()->clientScript;

$cs->registerCssFile($baseUrl."/css/redactor.css");
$cs->registerScriptFile($baseUrl."/js/core/redactor.min.js");

$this->pageTitle=$project->title." - ".Yii::app()->name;
Yii::app()->assetCompiler->registerAssetGroup(array('project-view.less', 'project.view.js'), $baseUrl);
?>

<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'fbmeta')); ?>

<meta property="og:image" content="<?php echo strpos($project->image, 'http://') === false ? 'http://ig9.vn'.$project->image : $project->image ?>" />
<meta property="og:title" content="<?php echo strip_tags(htmlspecialchars($update->title)) ?>" />
<meta property="og:description" content="<?php echo AppHelper::trimWord($update->content, 350) ?>" />
<meta property="og:url" content="<?php echo $this->createAbsoluteUrl('/project/update', array('id' => $update->id)) ?>" />
<meta property="og:site_name" content="IG9.VN - the first crowdfunding platform in Vietnam" />
<meta property="og:type" content="ignitevn:project" />
<meta name="description" content="<?php echo AppHelper::trimWord($update->content, 350) ?>" />

<?php $this->endWidget();?>

<div id="project-header">
  <h1 class="title"><?php echo $project->title;?></h1>
  <h2 class="subtile"><?php __("by");?> <a href="<?php echo $this->createUrl('/user/profile', array('id' => $project->user->id)); ?>"><?php echo $project->user->username;?></a></h2>
</div>
<div class="main update-page">

  <div class="container">
    <?php $newtag = $latestUpdate->getTotalItemCount() > 0 ? ' <img id="update-new-tag" src="' . $this->assetsUrl . '/img/new-tag.png" alt="new"/>' : ''; ?>
    <div id="prj-nav">
      <?php echo CHtml::link(___("Project"),array("project/view", 'id'=>$project->id, 'slug'=>$project->slug));?>
      <?php echo CHtml::link(___("Updates") . $newtag . " <span class='count'>{$project->updateCount}</span>",array("updates", 'id'=>$project->id),array('class'=>'selected'));?>
      <?php echo CHtml::link(___("Backers") . " <span class='count'>{$project->backerCount}</span>",array("backers", 'id'=>$project->id));?>
      <?php echo CHtml::link(___("Comments") . " <span class='count'>{$project->commentCount}</span>",array("comments", 'id'=>$project->id));?>
    </div>
    <div class="row">
      <div class="span8" id="prjv-left">
        <div class="backer post update">
          <div class="blogentry">
            <h2 class="title">
              <?php echo $update->title; ?>
            </h2>
            <div class="statline">
              <div class="leftside">
                <?php echo $update->create_time; ?>
                <span class="divider">·</span>
                <a href="#comments" class="comments"><?php echo $update->commentCount; ?> <?php __('comments'); ?></a>
              </div>
              <div class="fb-like" data-href="<?php echo $this->createAbsoluteUrl('/project/update', array('id' => $update->id)); ?>" data-send="false" data-width="320" data-show-faces="false" style="float: left"></div>
            </div>
            <div class="actions">
              <?php if (!Yii::app()->user->isGuest && ($project->user_id == Yii::app()->user->id || Yii::app()->user->isAdmin())) : ?>
              <a href="#" class="edit" title="<?php __('Edit'); ?>"><span class="icon-pencil"></span></a>
              <a href="<?php echo $this->createUrl('projectUpdate/delete', array('id' => $update->id)); ?>" class="delete" title="<?php __('Delete'); ?>"><span class="icon-trash"></span></a>
              <?php endif; ?>
            </div>
            <div class="clear"></div>
            <div class="content"><?php echo $update->content; ?></div>
            <?php if (!Yii::app()->user->isGuest && ($project->user_id == Yii::app()->user->id || Yii::app()->user->isAdmin())) : ?>
            <div class="editor single">
              <form action="<?php echo $this->createUrl('projectUpdate/edit', array('id' => $update->id)); ?>" method="POST">
                <input type="text" name="comment[title]" class="input-text" placeholder="<?php __('Update title'); ?>" value="<?php echo $update->title; ?>">
                <textarea rows="5" cols="20" name="comment[content]" class="redactor"><?php echo $update->content; ?></textarea>
                <div class="submit">
                  <input type="submit" class="btn btn-primary" value="<?php __('Save'); ?>">
                  <input type="button" class="btn cancel" value="<?php __('Cancel'); ?>">
                  <img src="/themes/ig9/assets/img/spinner.gif" class="spinner" alt="Loading"/>
                </div>
              </form>
            </div>
            <?php endif; ?>
            <span class="comments-link"><?php echo $update->commentCount; ?> <?php __('comments'); ?></span>
          </div>
        </div>

        <div id="new-comment">
          <?php if (Yii::app()->user->isGuest) : ?>
          <a href="<?php echo Yii::app()->user->loginUrl[0]; ?>"><span class="icon-comment"> </span><span><?php __('Leave a comment'); ?></span>
          </a>
          <?php else : ?>
          <a class="button-add-comment" href="#"><span class="icon-comment"> </span><span><?php __('Leave a comment'); ?></span>
          </a>
          <div class="editor">
            <form action="<?php echo $this->createUrl('projectUpdateComment/add', array('id' => $update->id)); ?>" class="new" method="POST">
              <textarea rows="5" cols="20" name="comment[content]"></textarea>
              <div class="submit">
                <input type="submit" class="btn btn-primary" value="<?php __('Post'); ?>">
                <input type="button" class="btn btn-cancel" value="<?php __('Cancel'); ?>">
              </div>
            </form>
          </div>
          <?php endif; ?>
        </div>

        <div id="comments">
          <?php
          $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $comments,
            'pagerCssClass' => 'pagination pagination-centered',
            'pager'=>array(
              'header' => '',
              'htmlOptions' => array(
                'class' => ''
              )
            ),
            'template'=>'{items} {pager}',
            'emptyText' => ___('This project has no comments.'),
            'ajaxUpdate' => false,
            'itemView' => '_update_comment',
            'viewData' => array('project' => $project)
          ));
          ?>
        </div>
      </div>
      <?php echo $this->renderPartial('_view_sidebar', compact('project')); ?>

      <?php echo $this->renderPartial('_random_projects', compact('randomProjects')); ?>
      </div>
  </div>
</div>

<?php echo $this->renderPartial('_rewards_modals', compact('project')); ?>

<?php echo $this->renderPartial('_bio_modal', compact('project')); ?>