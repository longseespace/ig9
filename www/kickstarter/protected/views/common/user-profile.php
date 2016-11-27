<?php
/**
 * Author: Long Doan
 * Date: 9/5/12 10:55 AM
 */

?>
<div id="running-board-wrapper" class="<?php echo $this->id?> action-<?php echo $this->action->id?>">
  <section id="running-board">
    <?php if ($this->_model->id == Yii::app()->user->id) : ?>
    <nav class="running-menu">
      <?php // echo $this->renderPartial('menu'); ?>
    </nav>
    <?php endif; ?>
    <h1><?php echo $this->title; ?></h1>
    <?php if (!empty($this->clips['top'])) { ?>
    <div class="running-content">
      <?php echo $this->clips['top'] ?>
    </div>
    <?php } ?>
  </section>
</div>