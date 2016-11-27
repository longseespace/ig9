<?php
/**
 * Author: Long Doan
 * Date: 8/29/12 4:01 PM
 */

$module = substr($this->id, strpos($this->id, '/') + 1);
?>
<div class="action">
  <a href="<?php echo $this->adminUrl($module, 'add') ?>" class="btn">Add <?php echo $module ?></a>
</div>

<h1>Edit</h1>

<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="success">
  <?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="error">
  <?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>

<div class="form">
  <?php echo $form; ?>
</div>