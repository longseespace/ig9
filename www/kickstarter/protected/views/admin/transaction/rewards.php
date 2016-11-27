<?php
/**
 * Author: Long Doan
 * Date: 8/29/12 4:01 PM
 */

?>
<?php
/**
 * Author: Long Doan
 * Date: 8/29/12 10:55 AM
 */
$module = substr($this->id, strpos($this->id, '/') + 1);

?>
<div class="action">
  <a href="<?php echo $this->adminUrl($module, 'addr', $id) ?>" class="btn">Add Reward</a>
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
        'name' => ___('Description') ,
        'value' => '$data->description',
      ) ,
      array(
        'name' => ___('Amount') ,
        'value' => '$data->amount',
      ) ,
      array(
        'name' => ___('Backer Limit') ,
        'value' => '$data->backer_limit',
      ) ,
      array(
        'name' => ___('Backer Count') ,
        'value' => '$data->backer_count',
      ) ,
      array(
        'name' => ___('Delivery Time') ,
        'value' => 'date("d/m/Y", CDateTimeParser::parse($data->delivery_time, "yyyy-MM-dd hh:mm:ss"))',
      ) ,
      array(
        'type' => 'raw',
        'value' => 'CHtml::link("Edit", array("admin/project/reward/" . $data->id), array("class" => "edit"))',
        'headerHtmlOptions' => array(
          'class' => 'action'
        )
      ) ,
    ) ,
  )
); ?>