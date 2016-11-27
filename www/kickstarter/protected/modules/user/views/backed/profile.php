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
    <?php __('Joined %s', array(date("F Y", $model->createtime)));  ?>
  </div>
<?php $this->endClip(); ?>

<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
  <div class="success">
    <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
  </div>
<?php endif; ?>

  <ul id="project_nav">
    <li>
      <a href="<?php echo $this->createUrl('/user/profile', array('id' => $model->id)); ?>">
        <span class="text"><?php __('Projects by %s',$model->username) ?> </span>
        (<span class="count"><?php echo $model->projectCount;?></span>)
      </a>
    </li>
    <li class="selected">
      <span class="text"><?php __('Backed') ?></span>
      <?php $project_count = $projects->totalItemCount; ?>
      <span class="count"><?php echo $project_count;?></span>
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
      <strong><?php __('You haven\'t backed any projects.') ?></strong> <?php __('Let\'s change that!') ?>
      <a href="/discover"><?php __('Discover projects') ?></a>
    <?php } else { ?>
      <strong><?php echo $model->username . ' ' . ___('haven\'t backed any projects.') ?></strong>
    <?php } ?>
  </section>

<?php
} else { ?>

  <ul id="user-project-list" class="row">
<?php
  $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $projects,
    'pagerCssClass' => 'pagination pagination-centered',
    'pager'=>array(
      'header' => '',
      'htmlOptions' => array(
        'class' => ''
      )
    ),
    'template'=>'{items} {pager}',
    'ajaxUpdate' => false,
    'itemView' => '_item',
  ));
}
?>
  </ul>