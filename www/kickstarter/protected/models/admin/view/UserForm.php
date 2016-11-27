<?php
/**
 * Author: Long Doan
 * Date: 8/29/12 2:57 PM
 */

return array(
  'title'=>'Manage User',

  'elements'=>array(
    'user'=>array(
      'type'=>'form',
      'title'=>'Login Credential',
      'elements'=>array(
        'username'=>array(
          'type'=>'text',
        ),
        'email'=>array(
          'type'=>'text',
        ),
        'password'=>array(
          'type'=>'password',
          'value'=>''
        ),
        'superuser'=>array(
          'type'=>'checkbox',
        ),
        'status'=>array(
          'type'=>'dropdownlist',
          'items'=>array(User::STATUS_ACTIVE => 'active',User::STATUS_NOACTIVE => 'inactive',User::STATUS_BANED => 'banned',)
        ),
      ),
    ),

    'profile'=>array(
      'type'=>'form',
      'title'=>'User Profile',
      'elements'=>array(
        'fullname'=>array(
          'type'=>'text',
        ),
        'birthday'=>array(
          'type'=>'text',
          'attributes' => array('class' => 'datepicker')
        ),
        'address'=>array(
          'type'=>'textarea',
        ),
        'city'=>array(
          'type'=>'dropdownlist',
          'items'=>Profile::range(ProfileField::model()->findByAttributes(array('varname' => 'city'))->range)
        ),
        'biography'=>array(
          'type'=>'textarea',
        ),
        'mobile'=>array(
          'type'=>'text',
        ),
        'websites'=>array(
          'type'=>'text',
        ),
      ),
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