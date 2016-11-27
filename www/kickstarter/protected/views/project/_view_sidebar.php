<?php
/* @var $this SiteController */
$baseUrl = $this->assetsUrl;
?>

<div class="span4" id="prjv-right">
  <div class="prj-stats">
    <div class="stats-item">
      <span class="prjs-value"><?php echo $project->backerCount;?></span>
      <span class="prjs-title"><?php __("Backers");?></span>
    </div>
    <div class="stats-item">
      <span class="prjs-value"><?php _m($project->funding_current);?></span>
      <span class="prjs-title"><?php __("out of %s raised",__m($project->funding_goal));?></span>
    </div>
    <div class="stats-item">
      <?php if($project->isEnd()):?>
      <span class="prjs-value"><?php __("Ended") ?></span>
      <?php elseif($project->isTimeLeftLessThan1Day()):?>
        <span class="prjs-value"><?php echo $project->getHourLeft();?></span><span class="prjs-title"><?php __("hours to go") ?></span>
      <?php else:?>
        <span class="prjs-value"><?php echo $project->getDayLeft();?></span><span class="prjs-title"><?php __("days to go") ?></span>
      <?php endif;?>

    </div>
    <div class="c2action">
      <?php if(!$project->isEnd()):?>
      <a href="<?php echo $this->createUrl('pledge/new', array('project_id' => $project->id)) ?>" class="c2abtn"><?php __("Back this Project");?></a>
      <?php endif;?>
      <span>
        <?php if($project->id == 420):?>
          Khoản tiền hỗ trợ sẽ được chủ dự án chuyển cho Hoa Đức Công khi dự án kết thúc vào ngày <?php _d($project->end_time)?>
        <?php else:?>
        <?php __("This project will only be funded if at least %s is pledged by %s.", array(
          __m($project->funding_goal),
          __d($project->end_time)
        ));?>
        <?php echo CHtml::link(___("How IG9 works."),"/help");?>
        <?php endif; ?>
      </span>
    </div>
  </div>

  <div class="creator-info">
    <div class="clearfix">
      <div id="avatar">
        <?php if ($project->user->avatarBehavior->getFileUrl()) : ?>
          <?php echo CHtml::link(Chtml::image(AppHelper::fixImageUrl($project->user->avatarBehavior->getFileUrl(), 220, 220), $project->user->username), "/user/profile/".$project->user->id);?>
        <?php else: ?>
          <?php echo CHtml::image($baseUrl.'/img/noava.png', 'No Image', array('width' => 220)); ?>
        <?php endif ?>
      </div>
      <div id="creator-name">
        <?php __("Project by");?>
        <h3>
          <?php echo CHtml::link($project->user->username, '#', array("data-toggle" => "modal", "data-target" => "#modal-bio")); ?>
        <p>
          <span class="message">
            <a href="/message/compose/send/to/<?php echo $project->user->username ?>" class="remote_modal_dialog" data-modal-title="<?php __("Send A Message to %s", array($project->user->username));?>">
              <?php __("Contact me");?>
            </a>
          </span>
        </p>
      </div>
    </div>
    <div id="creator-details">
      <ul>
        <li class="projects-more">
          <span class="icon"></span>
          <span class="text">
          <?php echo CHtml::link(__n($project->user->activeProjectCount)." ".___("created"), array("/user/profile", 'id' => $project->user_id)); ?>
          <span class="divider">·</span>
          <?php echo CHtml::link(__n($project->user->projectBackedCount)." ".___("backed"), array("/user/profile", 'id' => $project->user_id)); ?>
          </span>
        </li>
        <li class="facebook">
          <span class="icon"></span>
          <span class="text">
            <? __("Has not connected Facebook");?>
          </span>
        </li>
        <li class="links">
          <b><?php __("Website") ?>:</b>
          <a href="<?php echo AppHelper::getFullUrl($project->user->profile->websites);?>" class="popup" rel="nofollow" target="_blank"><?php echo $project->user->profile->websites;?></a>
        </li>
      </ul>
      <p class="more">
        <!-- modal-bio -->
      <!-- <a href="#" class="remote_modal_dialog" data-toggle="modal" data-target="#modal-bio" data-remote="/user/bio/<?php echo $project->user->id;?>">See full bio</a> -->
      </p>
    </div>
  </div>
  <div id="package-list">
    <ul class="nostyle">
      <?php foreach($project->rewards as $index => $reward):?>
        <?php if($project->isEnd()):?>
        <li class="reward-item">
        <?php else:?>
        <li data-modal="modal-<?php echo $index;?>" class="reward-item">
        <?php endif;?>
          <!-- <a href="#modal-<?php echo $index;?>" data-toggle="modal"> -->
            <h3><?php __("Pledge %s or more",array(__m($reward->amount)));?></h3>
            <span class="backers-info"><?php echo _n($reward->backer_count);?> <?php __("Backers");?></span>
            <span class="package-info"><?php echo nl2br($reward->description);?></span>
            <span class="package-delivery"><strong><?php __("Est. Delivery");?>:</strong> <?php _d($reward->delivery_time, 'm/Y');?></span>
          <!-- </a> -->
        </li>
      <?php endforeach;?>
    </ul>
  </div>
</div>