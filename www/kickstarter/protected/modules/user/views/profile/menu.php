<ul class="actions">
  <li><?php echo CHtml::link(UserModule::t('Profile'),array('edit')); ?></li>
  <li><?php echo CHtml::link(UserModule::t('Project'),array('/user/profile')); ?></li>
  <li><?php echo CHtml::link(UserModule::t('Logout'),array('/user/logout')); ?></li>
</ul>