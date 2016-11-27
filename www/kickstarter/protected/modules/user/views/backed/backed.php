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
    <a href="<?php echo $this->createUrl('/user/profile'); ?>">
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

  <div class="filters">
    <div class="backed-filter">
      <span class="title"><?php __('Project') ?></span>
      <?php if (!isset($_GET['project'])) { ?>
        <span class="selected"><?php __('all') ?></span>
      <?php } else { ?>
        <span><?php echo CHtml::link(___('all'), array_diff_key(array_merge(array('/user/backed', 'id' => $model->id), $_GET), array('project' => 0))) ?></span>
      <?php } ?>

      <?php if (isset($_GET['project']) && $_GET['project'] == 1) { ?>
        <span class="selected"><?php __('on going') ?></span>
      <?php } else { ?>
        <span><?php echo CHtml::link(___('on going'), array_merge(array('/user/backed', 'id' => $model->id), $_GET, array('project' => 1))) ?></span>
      <?php } ?>

      <?php if (isset($_GET['project']) && $_GET['project'] == 0) { ?>
        <span class="selected"><?php __('ended') ?></span>
      <?php } else { ?>
        <span><?php echo CHtml::link(___('ended'), array_merge(array('/user/backed', 'id' => $model->id), $_GET, array('project' => 0))) ?></span>
      <?php } ?>
    </div>

    <div class="backed-filter">
      <span class="title"><?php __('Status') ?></span>
      <?php if (!isset($_GET['status'])) { ?>
        <span class="selected"><?php __('all') ?></span>
      <?php } else { ?>
        <span><?php echo CHtml::link(___('all'), array_diff_key(array_merge(array('/user/backed', 'id' => $model->id), $_GET), array('status' => 0))) ?></span>
      <?php } ?>

      <?php for ($i= -1; $i <= 3; $i++) { ?>
        <?php if (isset($_GET['status']) && $_GET['status'] == $i) { ?>
          <span class="selected"><?php __(Transaction::resolve("status", $i)) ?></span>
        <?php } else { ?>
          <span><?php echo CHtml::link(___(Transaction::resolve("status", $i)), array_merge(array('/user/backed', 'id' => $model->id), $_GET, array('status' => $i))) ?></span>
        <?php } ?>
      <?php } ?>
    </div>
  </div>

  <?php
  $this->widget('zii.widgets.grid.CGridView', array(
      'dataProvider' => $filter ? $filter : $projects,
      'htmlOptions' => array(
        'class' => 'table table-striped table-hover backed-projects',
      ),
      'columns' => array(
         array(
           'name' => ___('Code') ,
           'value' => '$data->code',
           'headerHtmlOptions' => array(
             'class' => 'code'
           ) ,
         ) ,
        array(
          'name' => ___('Project') ,
          'type' => 'raw',
          'value' => '"<div class=project-status>" .
          ___(Project::resolve("dayLeft", $data->reward->project->dayLeft)) .
          "</div>" .
          CHtml::link(CHtml::image($data->reward->project->thumbImage), array("/project/view", "slug" => $data->reward->project->slug, "id" => $data->reward->project->id))',
          'headerHtmlOptions' => array(
            'class' => 'project'
          ) ,
        ) ,
        array(
          'name' => ___('Title') ,
          'type' => 'raw',
          'value' => 'CHtml::link(strip_tags($data->reward->project->title), array("/project/view", "slug" => $data->reward->project->slug, "id" => $data->reward->project->id))',
          'headerHtmlOptions' => array(
            'class' => 'title'
          ) ,
        ) ,
        array(
          'name' => ___('Amount') ,
          'type' => 'raw',
          'value' => '__m($data->amount)',
          'headerHtmlOptions' => array(
            'class' => 'amount'
          ) ,
        ) ,
        array(
          'name' => ___('Reward') ,
          'type' => 'raw',
          'value' => '$data->reward->description',
          'headerHtmlOptions' => array(
            'class' => 'reward'
          ) ,
        ) ,
        array(
          'name' => ___('Back Time') ,
          'value' => '$data->create_time',
          'headerHtmlOptions' => array(
            'class' => 'time'
          ) ,
        ) ,
        array(
          'name' => ___('Status') ,
          'sortable' => false,
          'value' => '___(Transaction::resolve("status", $data->status))',
          'headerHtmlOptions' => array(
            'class' => 'status',
          ) ,
        ) ,
      ) ,
    )
  );
  ?>
  <?php }
?>