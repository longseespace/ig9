<?php
$module = substr($this->id, strpos($this->id, '/') + 1);
?>
<div class="action">
  <a href="/admin/emailsubscriber/export" class="btn">Export</a>
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
          'name' => ___('username') ,
          'value' => '$data->username',
          'sortable' => false,
          'headerHtmlOptions' => array(
            'class' => ''
          ) ,
        ) ,
        array(
          'name' => ___('email') ,
          'value' => '$data->email',
          'sortable' => false,
          'headerHtmlOptions' => array(
            'class' => ''
          ) ,
        ) ,
        array(
          'class'=>'zii.widgets.grid.CButtonColumn',
          'header' => ___('Action') ,
          'template' => '{delete}', 
          'htmlOptions' => array(
          ),
          'deleteButtonImageUrl' => false,
          'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/admin/emailsubscriber/delete",array("id"=>$data->primaryKey))',
        ),
      ) ,
    )
  );
?>
</div>