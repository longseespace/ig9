<?php
/**
 * Author: Long Doan
 * Date: 8/29/12 2:57 PM
 */

return array(
  'title'=>'Manage Rewards',

  'elements'=>array(
    'amount'=>array(
      'type'=>'text',
    ),
    'delivery_time'=>array(
      'type'=>'text',
      'attributes' => array('class' => 'datepicker')
    ),
    'backer_limit'=>array(
      'type'=>'number',
    ),
    'description'=>array(
      'type'=>'textarea',
    ),
  ),

  'buttons'=>array(
    'submit'=>array(
      'type'=>'submit',
      'label'=>'Save',
      'class' => 'btn btn-primary btn-large'
    ),
  ),
);
?>