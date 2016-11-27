<?php
$module = substr($this->id, strpos($this->id, '/') + 1);
?>
<div class="action">
  <a href="/admin/post" class="btn">Post list</a>
  <a href="/admin/newscategory" class="btn">Category list</a>
</div>

<div id="admin-project-index">
<?php
  $this->widget('zii.widgets.grid.CGridView', array(
      'dataProvider' => $comments,
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
          'name' => ___('create_time') ,
          'sortable' => true,
          'value' => 'date("d/m/y",strtotime($data->create_time))',
          'headerHtmlOptions' => array(
            'class' => '',
            'width' => 50,
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
</div>