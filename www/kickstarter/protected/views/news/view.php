<?php
$this->breadcrumbs=array(
  'News' => '/news',
	$model->title, 
);
Yii::app()->assetCompiler->registerAssetGroup(array('script.js', 'plugins.js', 'general.less', 'news.less'), $this->assetsUrl);
?>
<?php
$this->widget('zii.widgets.CBreadcrumbs', array(
  'links'=>$this->breadcrumbs,
  'tagName' => 'ul',
  'activeLinkTemplate' => '<li><a href="{url}">{label}</a></li>',
  'inactiveLinkTemplate' => '<li class="active">{label}</li>',
  'htmlOptions' => array('class'=>'breadcrumb'),
  'separator' => '<span class="divider">/</span>',
  'homeLink' => "<li>".CHtml::link(___("Home"),"/")."</li>"
));
?>
<div class="topstories">
  <h1><?php echo $model->title;?></h1>
  <div class="meta"><span class="author"><?php __('By ') ?><?php echo $model->author->username; ?></span> <span class="date"><?php __('Posted on ') ?><?php echo date("d-m-Y",strtotime($model->create_time)) ?></span><?php if ($model->commentCount>=1) : ?>
    <?php echo $model->commentCount . ' comment'; ?><?php endif; ?>
  </div>

  <?php echo $model->content;?>
  <!-- Perform content for everyone -->
  <?php if (isset($model->source)) : ?>
    <p style="text-align: right;"><i>Source: </i><?php echo $model->source; ?></p>
  <?php endif; ?>
  <?php if (!Yii::app()->user->isGuest && Yii::app()->user->isAdmin()) : ?>
    <div class="edit-link">
      <?php echo CHtml::link(___('Edit this post'), array('/admin/post/update', 'id' => $model->id)) ?>
    </div>
  <?php endif; ?>
  <!-- Admin can edit post from frontend -->

  <div class="post-comments-wrap">
    <div class="post-comments">
      <?php if ($model->commentCount>=1) : ?>
      <h3>Comment</h3>
    </div>
    <div class="list-comments">
      <?php
      $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $comment->search(),
        'pagerCssClass' => 'pagination pagination-centered',
        'pager'=>array(
          'header' => '',
          'htmlOptions' => array(
            'class' => ''
          )
        ),
        'template'=>'{items} {pager}',
        'ajaxUpdate' => false,
        'itemView' => '_comments',
      ));
      ?>
    </div>
    <?php endif; ?>
    <!-- Perform comment for everyone -->
      <h3>Leave a Comment</h3>
      <?php if(Yii::app()->user->hasFlash('commentSubmitted')): ?>
        <div class="flash-success">
          <?php echo Yii::app()->user->getFlash('commentSubmitted'); ?>
        </div>
      <?php else: ?>
        <?php $this->renderPartial('_form', array('model'=>$comment,)); ?>
      <?php endif; ?>
    <!-- Get comment form -->
    </div>
  </div>  
</div>
<?php $this->renderPartial('navbar', array('category'=>$category,'email'=>$email));?>
<div class="clearfix"></div>