<?php
$this->breadcrumbs=array(
	'Manage',
);
?>

<h1>Manage Transaction</h1>

<?php $this->widget('zii.widgets.grid.CGridView',array(
	'id'=>'transaction-grid',
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
      'value' => 'CHtml::link($data->username, array("/admin/user/edit", "id" => $data->user->id))."&nbsp;&nbsp;".CHtml::link("[Address]", "javascript:void(0)", array("data-toggle" => "tooltip", "data-title" => $data->user->profile->address, "data-placement" => "right", "data-trigger" => "click", "class" => "ytooltip"))',
      'headerHtmlOptions' => array(
        'class' => 'owner'
      )
    ),
    array(
      'name' => 'mobile',
      'type' => 'raw',
      'value' => '$data->mobile',
      'headerHtmlOptions' => array(
        'class' => 'mobile'
      )
    ),
    array(
      'name' => 'title',
      'type' => 'raw',
      'value' => 'CHtml::link($data->title, array("/project/view", "slug" => $data->reward->project->slug, "id" => $data->reward->project->id))',
      'headerHtmlOptions' => array(
        'class' => ''
      ),
      'htmlOptions' => array(
        'width' => 200
      )
    ),
    array(
      'name' => 'amount',
      'type' => 'raw',
      'value' => '__m($data->amount)',
      'headerHtmlOptions' => array(
        'class' => 'amount'
      )
    ),
    'code',
    'gateway',
    array(
      'name' => 'create_time',
      'sortable' => true,
      'filter' => false,
      'value' => '$data->create_time',
    ),
    array(
      'name' => 'status',
      'sortable' => false,
      'filter' => array(
        '0' => 'Pending',
        '1' => 'Completed',
        '2' => 'Need Refund',
        '3' => 'Refunded'
      ),
      'value' => 'Transaction::resolve("status", $data->status)',
      'headerHtmlOptions' => array(
        'class' => 'status',
      ) ,
    ) ,
    array(
      'class'=>'zii.widgets.grid.CButtonColumn',
      'template' => '{approve} {refund} {remove} {note} {add_note}',
      'htmlOptions' => array(
        'width' => 180
      ),
      'viewButtonImageUrl' => false,
      'updateButtonImageUrl' => false,
      'deleteButtonImageUrl' => false,
      'updateButtonOptions' => array(
        'target' => '_blank'
      ),
      'buttons' => array(
        'approve' => array(
          'label'=>'Approve',
          'url'=>'Yii::app()->createUrl("/admin/transaction/approve", array("id"=>$data->primaryKey))',
          'visible'=>'$data->status == Transaction::STATUS_PENDING',
          'options'=>array(
           // 'class'=>'ajaxbutton'
            'target' => '_blank'
          )
        ),
        'refund' => array(
          'label'=>'Refund',
          'url'=>'Yii::app()->createUrl("/admin/transaction/refund", array("id"=>$data->primaryKey))',
          'visible'=>'$data->status == Transaction::STATUS_NEED_REFUND',
          'options'=>array(
            'class'=>'ajaxbutton'
          )
        ),
        'remove' => array(
          'label'=>'Remove',
          'url'=>'Yii::app()->createUrl("/admin/transaction/remove", array("id"=>$data->primaryKey))',
          'visible'=>'$data->status != Transaction::STATUS_REMOVED',
          'options'=>array(
            'class'=>'ajaxbutton'
          )
        ),
        'note' => array(
          'label'=>'Note',
          'url'=>'Yii::app()->createUrl("/admin/transaction/note", array("id"=>$data->primaryKey))',
          'visible'=>'!empty($data->note)',
          'options'=>array(
            'class'=>'note-button',
            'data-toggle'=>'modal',
            'data-target'=>'#transaction-note-modal'
          )
        ),
        'add_note' => array(
          'label'=>'Add_Note',
          'url'=>'Yii::app()->createUrl("/admin/transaction/note", array("id"=>$data->primaryKey))',
          'visible'=>'empty($data->note)',
          'options'=>array(
            'class'=>'note-button',
            'data-toggle'=>'modal',
            'data-target'=>'#transaction-note-modal'
          )
        )
      )
    )
   )
	)
);

?>

<div id="transaction-note-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="transaction-note-modal" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Note</h3>
  </div>
  <div class="modal-body">
  </div>
</div>
