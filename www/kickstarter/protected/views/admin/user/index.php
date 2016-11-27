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
      ) ,
      array(
        'name' => ___('email') ,
        'value' => '$data->email',
      ) ,
      array(
        'name' => ___('name') ,
        'value' => '$data->profile->fullname',
      ) ,
      array(
        'name' => ___('birthday') ,
        'value' => 'date("d/m/Y", CDateTimeParser::parse($data->profile->birthday, "yyyy-MM-dd"))',
      ) ,
      array(
        'name' => ___('city') ,
        'value' => '$data->profile->city',
      ) ,
      array(
        'name' => ___('Joined') ,
        'value' => 'date("d/m/Y", $data->createtime)',
        'headerHtmlOptions' => array(
          'class' => ''
        ) ,
      ) ,
      array(
        'type' => 'raw',
        'value' => 'CHtml::link("Edit", array("admin/user/edit/" . $data->id), array("class" => "edit"))',
        'headerHtmlOptions' => array(
          'class' => 'action'
        )
      ) ,
    ) ,
  )
); ?>