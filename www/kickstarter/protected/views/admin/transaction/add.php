<?php
/**
 * Author: Long Doan
 * Date: 8/29/12 3:06 PM
 */

?>
<h1>Add</h1>

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

<?php if ($project_id) { ?>
<a href="<?php echo $this->adminUrl('project/rewards', $project_id) ?>">Back to reward list</a>
<?php } ?>

<div class="form">
  <?php echo $form; ?>
</div>