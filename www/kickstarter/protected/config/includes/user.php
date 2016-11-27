<?php
  const CActiveRecord__STAT = 'CStatRelation';
  const Transaction__STATUS_COMPLETED = 1;

  return array(
    'modules' => array(
      'user' => array(
        'loginUrl' => array('/user/login'),
        'registrationUrl' => array('/user/register'),
        'autoLogin' => true,
        'sendActivationMail' => false,
        'activeAfterRegister' => true,
        'captcha' => array(),
        'tableUsers' => 'users',
        'tableProfiles' => 'profiles',
        'tableProfileFields' => 'profiles_fields',
        'relations' => array(
          'projectCreatedCount'=>array(
            CActiveRecord__STAT, 'Project', 'user_id'
          ),
          'projectBackedCount'=>array(
            CActiveRecord__STAT, 'Transaction', 'user_id',
              'condition' => '`t`.`status` = '.Transaction__STATUS_COMPLETED
          ),
        )
      )
    ),
    'components' => array(
      'user' => array(
        'class' => 'application.modules.user.components.UWebUser',
        'allowAutoLogin' => true,
        'loginUrl' => array('/user/login')
      )
    )
  );
?>