<?php
// /* @var $this NewsCategoryController */
// /* @var $dataProvider CActiveDataProvider */

// $this->breadcrumbs=array(
// 	'News Categories',
// );

// $this->menu=array(
// 	array('label'=>'Create NewsCategory', 'url'=>array('create')),
// 	array('label'=>'Manage NewsCategory', 'url'=>array('admin')),
// );
?>

<?php 
  // $this->widget('zii.widgets.CListView', array(
  // 	'dataProvider'=>$dataProvider,
  // 	'itemView'=>'_view',
  // )); 
?>
<?php
$module = substr($this->id, strpos($this->id, '/') + 1);
?>
<div class="action">
  <a href="<?php echo $this->adminUrl($module, 'create') ?>" class="btn">Add new category</a>
  <a href="/admin/post" class="btn">Back to news post</a>
</div>

<div id="admin-project-index">
<?php
  $this->widget('zii.widgets.grid.CGridView', array(
      'dataProvider' => $dataProvider,
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
          'name' => ___('name') ,
          'value' => '$data->name',
          'sortable' => false,
          'headerHtmlOptions' => array(
            'class' => 'title'
          ) ,
        ) ,
        array(
          'name' => ___('slug') ,
          'value' => '$data->slug',
          'sortable' => false,
          'headerHtmlOptions' => array(
            'class' => ''
          ) ,
        ) ,
        array(
          'class'=>'zii.widgets.grid.CButtonColumn',
          'header' => ___('Action') ,
          'template' => '{update} | {delete}',
          'htmlOptions' => array(
            'width' => 100
          ),
          'updateButtonImageUrl' => false,
          'deleteButtonImageUrl' => false,
          'updateButtonOptions' => array(
            'target' => '_blank'
          ),
          'updateButtonUrl' => 'Yii::app()->controller->createUrl("/admin/newscategory/update",array("id"=>$data->primaryKey))',
          'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/admin/newscategory/delete",array("id"=>$data->primaryKey))',
        ),
      ) ,
    )
  );
?>
</div>