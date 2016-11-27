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
          'name' => ___('Owner') ,
          'value' => '$data->user->username',
          'headerHtmlOptions' => array(
            'class' => 'owner'
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
          'name' => ___('excerpt') ,
          'value' => '$data->excerpt',
          'sortable' => false,
          'headerHtmlOptions' => array(
            'class' => ''
          ) ,
        ) ,
        array(
          'name' => 'category_name' ,
          'header' => ___('Category'),
          'value' => '$data->category_name',
          'headerHtmlOptions' => array(
            'class' => ''
          ) ,
        ) ,
        array(
          'name' => ___('End Time') ,
          'value' => 'date("d/m/Y", CDateTimeParser::parse($data->end_time, "yyyy-MM-dd hh:mm:ss"))',
          'headerHtmlOptions' => array(
            'class' => ''
          ) ,
        ) ,
        array(
          'name' => ___('Funded') ,
          'value' => '$data->funding_current',
          'headerHtmlOptions' => array(
            'class' => ''
          ) ,
        ) ,
        array(
          'name' => ___('Views') ,
          'value' => '$data->views',
          'headerHtmlOptions' => array(
            'class' => ''
          ) ,
        ) ,
        array(
          'name' => ___('status') ,
          'sortable' => false,
          'value' => 'Project::resolve("status", $data->status)',
          'headerHtmlOptions' => array(
            'class' => 'status',
          ) ,
        ) ,
        array(
          'class'=>'zii.widgets.grid.CButtonColumn',
          'template' => '{approve} | {update} | {rewards} | {view} | {delete} | {staff_pick}',
          'htmlOptions' => array(
            'width' => 180
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
            ),
            'staff_pick' => array(
              'label'=>'Staff pick',
              'url'=>'Yii::app()->createUrl("/admin/project/staff_pick", array("id"=>$data->primaryKey))',
            ),
          )
        ),
      ) ,
    )
  );
?>
</div>