<?php
/**
 * Author: Long Doan
 * Date: 12/26/12 3:32 PM
 */

$user  = $data->user;
?>
<div class="backer comment<?php if ($project->user_id == $data->user_id) echo ' creator' ?>">
  <a href="<?php echo $this->createUrl('/user/profile', array('id' => $user->id)); ?>" class="avatar">
    <img alt="<?php echo $user->profile->fullname; ?>" class="avatar-small" height="80" src="<?php echo $user->avatar; ?>" width="80">
  </a>
  <div class="meta">
    <h3>
      <?php if ($project->user_id == $data->user_id) : ?>
        <span class="creator"><?php __('Creator'); ?></span>
      <?php endif; ?>
      <a href="<?php echo $this->createUrl('/user/profile', array('id' => $user->id)); ?>"><?php echo $user->username; ?></a>
    </h3>
    <div class="date">
      <?php echo $data->create_time; ?>
    </div>
    <div class="actions">
      <?php if (!Yii::app()->user->isGuest && (Yii::app()->user->id == $data->user_id || Yii::app()->user->isAdmin())) : ?>
      <a href="#" class="edit" title="<?php __('Edit'); ?>"><span class="icon-pencil"></span></a>
      <?php endif; ?>
      <?php if (!Yii::app()->user->isGuest && Yii::app()->user->isAdmin()) : ?>
      <a href="<?php echo $this->createUrl('projectUpdateComment/delete', array('id' => $data->id)); ?>" class="delete" title="<?php __('Delete'); ?>"><span class="icon-trash"></span></a>
      <?php endif; ?>
    </div>
    <div class="content">
      <?php echo nl2br($data->content); ?>
    </div>
    <?php if (!Yii::app()->user->isGuest && (Yii::app()->user->id == $data->user_id || Yii::app()->user->isAdmin())) : ?>
    <div class="editor">
      <form action="<?php echo $this->createUrl('projectUpdateComment/edit', array('id' => $data->id)); ?>" method="POST">
        <textarea rows="5" cols="20" name="comment[content]"><?php echo $data->content; ?></textarea>
        <div class="submit">
          <input type="submit" class="btn btn-primary" value="<?php __('Save'); ?>">
          <input type="button" class="btn cancel" value="<?php __('Cancel'); ?>">
          <img src="/themes/ig9/assets/img/spinner.gif" class="spinner" alt="Loading"/>
        </div>
      </form>
    </div>
    <?php endif; ?>
  </div>
</div>