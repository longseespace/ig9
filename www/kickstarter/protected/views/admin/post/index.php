<?php
$module = substr($this->id, strpos($this->id, '/') + 1);
?>
<div class="action">
  <a href="<?php echo $this->adminUrl($module, 'create') ?>" class="btn">Add post</a>
  <a href="/admin/comment" class="btn">Comment list</a>
  <a href="/admin/newscategory" class="btn">Category list</a>
</div>

<div id="admin-project-index">
<?php
  $this->widget('zii.widgets.grid.CGridView', array(
      'dataProvider' => $models,
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
          'name' => ___('title') ,
          'value' => '$data->title',
          'sortable' => false,
          'headerHtmlOptions' => array(
            'class' => 'title'
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
          'name' => ___('create_time') ,
          'sortable' => true,
          'value' => 'date("d/m/y",strtotime($data->create_time))',
          'headerHtmlOptions' => array(
            'class' => '',
            'width' => 50,            
          ) ,
        ) ,     
        array(
          'name' => ___('status') ,
          'sortable' => true,
          'value' => 'Post::resolve("status", $data->status)',
          'headerHtmlOptions' => array(
            'class' => '',
          ) ,
        ) ,
        array(
          'class'=>'zii.widgets.grid.CButtonColumn',
          'header' => ___('Action') ,
          'template' => '{update} | {view} | {delete} | {comment}', 
          'htmlOptions' => array(
            'width' => 180
          ),
          'viewButtonImageUrl' => false,
          'updateButtonImageUrl' => false,
          'deleteButtonImageUrl' => false,
          'updateButtonOptions' => array(
            'target' => '_blank'
          ),
          'viewButtonUrl' => 'Yii::app()->controller->createUrl("/news/view",array("id"=>$data->primaryKey))',
          'updateButtonUrl' => 'Yii::app()->controller->createUrl("/admin/post/update",array("id"=>$data->primaryKey))',
          'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/admin/post/delete",array("id"=>$data->primaryKey))',
          'buttons' => array(
            'comment' => array(
              'label'=>'Comment',
              'url'=>'Yii::app()->createUrl("/admin/comment/list/", array("id"=>$data->primaryKey))',
            ),
          )
        ),
      ) ,
    )
  );
?>
</div>