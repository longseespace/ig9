<?php
/**
 * Author: Long Doan
 * Date: 8/29/12 10:55 AM
 */

$module = substr($this->id, strpos($this->id, '/') + 1);
?>
<div class="action">
  <a href="<?php echo $this->adminUrl($module, 'add') ?>" class="btn">Add <?php echo $module ?></a>
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
          'name' => ___('User') ,
          'type' => 'raw',
          'value' => 'CHtml::link($data->user->username, array("/admin/user/edit", "id" => $data->user->id))',
          'headerHtmlOptions' => array(
            'class' => 'owner'
          ) ,
        ) ,
        array(
          'name' => ___('User Mobile') ,
          'type' => 'raw',
          'value' => '$data->user->profile->mobile',
          'headerHtmlOptions' => array(
            'class' => 'mobile'
          ) ,
        ) ,
        array(
          'name' => ___('Project') ,
          'type' => 'raw',
          'value' => 'CHtml::link($data->reward->project->title, array("/project/view", "slug" => $data->reward->project->slug, "id" => $data->reward->project->id))',
          'headerHtmlOptions' => array(
            'class' => ''
          ) ,
        ) ,
        array(
          'name' => ___('Reward') ,
          'type' => 'raw',
          'value' => 'CHtml::link(__m($data->reward->amount), array("/admin/project/reward", "id" => $data->reward->id))',
          'headerHtmlOptions' => array(
            'class' => ''
          ) ,
        ) ,
        array(
          'name' => ___('Amount') ,
          'type' => 'raw',
          'value' => '__m($data->amount)',
          'headerHtmlOptions' => array(
            'class' => 'amount'
          ) ,
        ) ,
        array(
          'name' => ___('Payment Method') ,
          'value' => '$data->gateway',
          'headerHtmlOptions' => array(
            'class' => 'gateway'
          ) ,
        ) ,
        array(
          'name' => ___('Create Time') ,
          'value' => '$data->create_time',
          'headerHtmlOptions' => array(
            'class' => ''
          ) ,
        ) ,
        array(
          'name' => ___('status') ,
          'sortable' => false,
          'value' => 'Transaction::resolve("status", $data->status)',
          'headerHtmlOptions' => array(
            'class' => 'status',
          ) ,
        ) ,
        array(
          'class'=>'zii.widgets.grid.CButtonColumn',
          'template' => '{approve} {refund} {remove}',
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
                'class'=>'ajaxbutton'
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
              'url'=>'#transaction-note-modal',
              'options'=>array(
                'class'=>'note-button'
              )
            )
          )
        ),
      ) ,
    )
  );
?>
</div>