<?php
/* @var $this CommentController */
/* @var $model Comment */

$this->breadcrumbs=array(
	'Comments'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Comment', 'url'=>array('index')),
	array('label'=>'Create Comment', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('comment-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Comments</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'comment-list',
	'dataProvider'=>$model->search(),
  'htmlOptions' => array(
    'class' => 'table table-striped table-hover'
  ),
  'columns' => array(
        array(
          'name' => ___('ID') ,
          'value' => '$data->id',
          'headerHtmlOptions' => array(
            'class' => 'id'
          ) ,
        ) ,
        array(
          'name' => ___('content') ,
          'value' => 'AppHelper::trimWord($data->content,100)',
          'sortable' => false,
          'headerHtmlOptions' => array(
            'class' => ''
          ) ,
        ) ,
        array(
          'name' => ___('post title') ,
          'value' => '$data->post->title',
          'sortable' => false,
          'headerHtmlOptions' => array(
            'class' => ''
          ) ,
        ) ,
        array(
          'name' => ___('create_time') ,
          'sortable' => true,
          'value' => 'date("d/m/y",strtotime($data->create_time))',
          'headerHtmlOptions' => array(
            'class' => '',
            'width' => 70,
          ) ,
        ) ,     
        array(
          'class'=>'zii.widgets.grid.CButtonColumn',
          'header' => ___('Action') ,
          'template' => '{update} | {view} | {delete}',
          'htmlOptions' => array(
            'width' => 120
          ),
          'viewButtonImageUrl' => false,
          'updateButtonImageUrl' => false,
          'deleteButtonImageUrl' => false,
          'updateButtonOptions' => array(
            'target' => '_blank'
          ),
          'viewButtonUrl' => 'Yii::app()->controller->createUrl("/comment/view",array("id"=>$data->primaryKey))',
          'updateButtonUrl' => 'Yii::app()->controller->createUrl("/admin/comment/update",array("id"=>$data->primaryKey))',
          'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/admin/comment/delete",array("id"=>$data->primaryKey))',
        ),
      ),
		)
	); 
	?>
