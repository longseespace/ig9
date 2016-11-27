<?php
$this->breadcrumbs=array(
	'Manage',
);
?>

<h1>Manage Projects</h1>

<?php $this->widget('zii.widgets.grid.CGridView',array(
	'id'=>'project-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
  // 'ajaxUpdate'=>false,
  'htmlOptions' => array(
    'class' => 'table table-striped table-hover'
  ),
	'columns' => array(
    array(
      'name' => 'id' ,
      'htmlOptions' => array(
        'width' => 30
      )
    ),
    array(
      'name' => 'username',
      'type' => 'raw',
      'value' => 'CHtml::link($data->username, array("/admin/user/edit", "id" => $data->user->id))',
      'headerHtmlOptions' => array(
        'class' => 'owner'
      )
    ),
    array(
      'name' => 'title',
      'type' => 'raw',
      'value' => 'CHtml::link($data->title, array("/project/view", "slug" => $data->slug, "id" => $data->id))',
      'headerHtmlOptions' => array(
        'class' => ''
      ),
      'htmlOptions' => array(
        'width' => 200
      )
    ),
    array(
      'name' => 'category_name' ,
      'header' => ___('Category'),
      'value' => '$data->category_name',
      'headerHtmlOptions' => array(
        'class' => ''
      ) ,
    ) ,
    array(
      'name' => 'end_time',
      'header' => ___('End Time') ,
      'value' => 'date("d/m/Y", CDateTimeParser::parse($data->end_time, "yyyy-MM-dd hh:mm:ss"))',
      'headerHtmlOptions' => array(
        'class' => ''
      ) ,
    ) ,
    array(
      'name' => 'funding_current',
      'header' => ___('Funded') ,
      'type' => 'raw',
      'value' => '__m($data->funding_current)',
      'headerHtmlOptions' => array(
        'class' => ''
      ) ,
    ) ,
    array(
      'name' => 'views',
      'header' => ___('Views') ,
      'value' => '$data->views',
      'headerHtmlOptions' => array(
        'class' => ''
      ) ,
    ) ,
    array(
      'name' => 'status',
      'sortable' => false,
      'filter' => array(
        '0' => 'Inactive',
        '1' => 'Active',
        '2' => 'Refunded'
      ),
      'value' => 'Project::resolve("status", $data->status)',
      'headerHtmlOptions' => array(
        'class' => 'status',
      ) ,
    ) ,
    array(
      'class'=>'zii.widgets.grid.CButtonColumn',
      'template' => '{approve} | {staff_pick} | {update} | {rewards} | {view} | {delete} | {refund} | {sendSuccessMail} | {sendFailMail}',
      'htmlOptions' => array(
        // 'width' => 180
      ),
      'viewButtonImageUrl' => false,
      'updateButtonImageUrl' => false,
      'deleteButtonImageUrl' => false,
      'updateButtonOptions' => array(
        'target' => '_blank'
      ),
      'viewButtonUrl' => 'Yii::app()->controller->createUrl("/projects",array("id"=>$data->primaryKey))',
      'updateButtonUrl' => 'Yii::app()->controller->createUrl("/project/basics",array("id"=>$data->primaryKey))',
      'deleteButtonUrl' => 'Yii::app()->controller->createUrl("admin/project/delete",array("id"=>$data->primaryKey))',
      'buttons' => array(
        'rewards' => array(
          'label'=>'Rewards',
          'url'=>'Yii::app()->createUrl("/admin/project/rewards", array("id"=>$data->primaryKey))',
        ),
        'approve' => array(
          'label'=>'Approve',
          'url'=>'Yii::app()->createUrl("/admin/project/approve", array("id"=>$data->primaryKey))',
          'options'=>array(
            'class' => 'ajaxupdate'
          )
        ),
        'staff_pick' => array(
          'label'=>'Staff pick',
          'url'=>'Yii::app()->createUrl("/admin/project/staff_pick", array("id"=>$data->primaryKey))',
          'options'=>array(
            'class' => 'ajaxupdate'
          )
        ),
        'refund' => array(
          'label'=>'Refund',
          'url'=>'Yii::app()->createUrl("/admin/project/refund", array("id"=>$data->primaryKey))',
          'visible'=>'$data->status == '.Project::STATUS_ACTIVE.' && strtotime($data->end_time) < time()',
          'options'=>array(
            'class' => 'ajaxbutton ajaxconfirm'
          )
        ),
        'sendFailMail' => array(
          'label'=>'Email (fail)',
          'url'=>'Yii::app()->createUrl("/admin/project/sendfailmail", array("id"=>$data->primaryKey))',
          'options'=>array(
            'class' => 'sendmail fail'
          )
        ),
        'sendSuccessMail' => array(
          'label'=>'Email (success)',
          'url'=>'Yii::app()->createUrl("/admin/project/sendsuccessmail", array("id"=>$data->primaryKey))',
          'options'=>array(
            'class' => 'sendmail success'
          )
        )
      )
    )
	)
)
);


?>
