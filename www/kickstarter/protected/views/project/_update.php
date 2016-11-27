<?php
/**
 * Author: Long Doan
 * Date: 12/26/12 3:32 PM
 */

?>
<div class="backer post update">
  <div class="blogentry">
    <h2 class="title">
      <a href="<?php echo $this->createUrl('project/update', array('id' => $data->id)); ?>"><?php echo $data->title; ?></a>
    </h2>
    <div class="statline">
      <div class="leftside">
        <?php echo $data->create_time; ?>
        <span class="divider">·</span>
        <a href="<?php echo $this->createUrl('project/update', array('id' => $data->id)); ?>#comments" class="comments"><?php echo $data->commentCount; ?> <?php __('comments'); ?></a>
      </div>
      <div class="fb-like" data-href="<?php echo $this->createAbsoluteUrl('/project/update', array('id' => $data->id)); ?>" data-send="false" data-width="320" data-show-faces="false" style="float: left"></div>
    </div>
    <div class="actions">
      <?php if (!Yii::app()->user->isGuest && ($project->user_id == Yii::app()->user->id || Yii::app()->user->isAdmin())) : ?>
      <a href="#" class="edit" title="<?php __('Edit'); ?>"><span class="icon-pencil"></span></a>
      <a href="<?php echo $this->createUrl('projectUpdate/delete', array('id' => $data->id)); ?>" class="delete" title="<?php __('Delete'); ?>"><span class="icon-trash"></span></a>
      <?php endif; ?>
    </div>
    <div class="clear"></div>
    <div class="content"><?php echo $data->content; ?></div>
    <?php if (!Yii::app()->user->isGuest && ($project->user_id == Yii::app()->user->id || Yii::app()->user->isAdmin())) : ?>
    <div class="editor single">
      <form action="<?php echo $this->createUrl('projectUpdate/edit', array('id' => $data->id)); ?>" method="POST">
        <input type="text" name="comment[title]" class="input-text" placeholder="<?php __('Update title'); ?>" value="<?php echo $data->title; ?>">
        <textarea rows="5" cols="20" name="comment[content]" class="redactor"><?php echo $data->content; ?></textarea>
        <div class="submit">
          <input type="submit" class="btn btn-primary" value="<?php __('Save'); ?>">
          <input type="button" class="btn cancel" value="<?php __('Cancel'); ?>">
          <img src="/themes/ig9/assets/img/spinner.gif" class="spinner" alt="Loading"/>
        </div>
      </form>
    </div>
    <?php endif; ?>
    <a href="<?php echo $this->createUrl('project/update', array('id' => $data->id)); ?>#comments" class="comments-link"><?php echo $data->commentCount; ?> <?php __('comments'); ?></a>
  </div>

</div>