<?php
/**
 * Author: Long Doan
 * Date: 12/26/12 3:32 PM
 */

$user  = $data->user;
?>
<div class="backer">
  <a href="<?php echo $this->createUrl('/user/profile', array('id' => $user->id)); ?>" class="avatar">
    <img alt="<?php echo $user->profile->fullname; ?>" class="avatar-small" height="80" src="<?php echo $user->avatar; ?>" width="80">
  </a>
  <div class="meta">
    <h3>
      <a href="<?php echo $this->createUrl('/user/profile', array('id' => $user->id)); ?>"><?php echo $user->username; ?></a>
    </h3>
    <p class="location">
      <span class="icon-map-marker"></span>
      <?php echo $user->profile->city; ?>
    </p>
    <p class="backings">
      <span class="icon-cog"></span>
      <?php __('Backed'); ?> : <?php echo $user->backedCount ?>  <?php __('projects.'); ?>
    </p>
  </div>
</div>