<?php
$this->breadcrumbs=array(
  ___('News')
);
Yii::app()->assetCompiler->registerAssetGroup(array('script.js', 'plugins.js', 'general.less', 'news.less'), $this->assetsUrl);
?>
<div class="topstories">
  <h1><?php __('News');?></h1>
  <?php if (!empty($_GET['tag'])): ?>
    <h1>Post Tagged with <i><?php echo Chtml::encode($_GET['tag']); ?></i></h1>
  <?php endif; ?>
  <?php
  $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $posts,
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
  ?>
</div>
  <?php $this->renderPartial('navbar', array('category'=>$category));?>
<div class="clearfix"></div>