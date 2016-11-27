<div class="sidebar">
  <h3>Browser news</h3>
  <?php
  $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $category,
    'pagerCssClass' => 'pagination pagination-centered',
    'pager'=>array(
      'header' => '',
      'htmlOptions' => array(
        'class' => ''
      )
    ),
    'template'=>'{items} {pager}',
    'ajaxUpdate' => false,
    'itemView' => '_nav',
  ));
  ?>
  <?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'subscriber',
  'enableAjaxValidation'=>false,
  )); ?>
  <?php if (Yii::app()->user->isGuest) : ?>
    <p>
      <?php echo CHtml::activeTextField($email, 'email', array('placeholder'=>'Email...')); ?>
      <?php echo CHtml::activeHiddenField($email, 'username', array('value'=>'Guest')); ?>
      <?php echo CHtml::submitButton(___('Subscribe'),array('class'=>'btn btn-warning')); ?>
    </p>      
  <?php elseif (!Yii::app()->user->isGuest) : ?>
    <?php echo CHtml::activeHiddenField($email, 'username', array('value'=>Yii::app()->user->model()->username)); ?>
    <?php echo CHtml::activeHiddenField($email, 'email', array('value'=>Yii::app()->user->model()->email)); ?>
    <?php echo CHtml::submitButton(___('Subscribe'),array('class'=>'btn btn-warning')); ?>
  <?php endif; ?>
  <?php $this->endWidget(); ?>
  <div class="fb-like" data-href="http://www.facebook.com/IG9.vn" data-send="true" data-width="200" data-show-faces="true"></div>
  </div>
</div>
<div id="fb-root"></div>