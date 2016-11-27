<?php
$ac = Yii::app()->assetCompiler;
$ac->registerAssetGroup(array('script.js', 'plugins.js', 'user.profile.js', 'user.less'), $this->assetsUrl);

$this->pageTitle("Profile");
$this->title = $profile->getAttribute('fullname');
$this->breadcrumbs=array(
	UserModule::t("Profile"),
);
?>

<?php $this->beginClip('top') ?>
<div class="backed">
  <?php __('Remaining credit'); ?>: <?php _m($model->credit); ?>
</div>
<div class="backed">
  <?php __('Joined %s', array(date("F Y", $model->createtime)));  ?>
</div>
<?php $this->endClip(); ?>

<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>

<ul id="project_nav">
  <li class="selected">
    <span class="text"><?php __('Projects by %s',$model->username) ?> </span>
    <?php $project_count = count($projects) ?>
    <span class="count"><?php echo $project_count;?></span>
  </li>
  <li>
    <?php if ($model->id != Yii::app()->user->id) { ?>
    <a href="<?php echo $this->createUrl('/user/backed', array('id' => $model->id)); ?>">
      <span class="text"><?php __('Backed') ?></span>
      (<span class="count"><?php echo $model->backedCount;?></span>)
    </a>
    <?php } else { ?>
    <a href="<?php echo $this->createUrl('/user/backed'); ?>">
      <span class="text"><?php __('Backed') ?></span>
      (<span class="count"><?php echo $model->backedCount;?></span>)
    </a>
    <?php } ?>
  </li>
  <!-- <li>
    <a href="#"><span class="text"><?php __('Comments') ?></span>
      <span class="count">(6969)</span>
    </a>
  </li> -->
</ul>

<?php if ($project_count == 0) { ?>

<section class="no-content">
  <?php if ($model->id == Yii::app()->user->id) { ?>
  <strong><?php __('You haven\'t created any projects.') ?></strong> <?php __('Let\'s change that!') ?>
    <a href="/start"><?php __('Create projects') ?></a>
  <?php } else { ?>
  <strong><?php echo $model->username . ' ' . ___('haven\'t created any projects.') ?></strong>
  <?php } ?>
</section>

<?php
  } else { ?>
    <ul id="user-project-list" class="row">
    <?php foreach ($projects as $project) : ?>

    <li class="user-project-cell span3">
      <div class="prj-img">
        <?php echo CHtml::link(CHtml::image($project->image), array("/project/view", 'id'=>$project->id, 'slug'=>$project->slug));?>
        <!--<img src="img/prj-thumb.jpg">-->
      </div>
      <div class="prj-info">
        <div class="prj-title">
          <h3><?php echo CHtml::link($project->title?$project->title:'No Name',array("/project/view", 'id'=>$project->id, 'slug'=>$project->slug))?> </h3>
        </div>
      </div>
      <?php if ($model->id == Yii::app()->user->id) : ?>
      <div class="modify">
        <?php echo CHtml::link('*',array("/project/delete", 'id'=>$project->id ), array('class' => 'user-profile-delete'))?>
        <?php echo CHtml::link('p',array("/project/basics", 'id'=>$project->id ))?>
      </div>
      <?php endif; ?>

    </li>
  <?php endforeach;?>
  </ul>
  <?php }
?>