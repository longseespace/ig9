<?php
$baseUrl = $this->assetsUrl;
$cs = Yii::app()->clientScript;
$ac = Yii::app()->assetCompiler;

$cs->registerCssFile($baseUrl."/css/jquery.Jcrop.css");
$cs->registerScriptFile($baseUrl."/js/core/jquery.Jcrop.min.js");
$cs->registerScriptFile($baseUrl."/js/core/jquery.refresh.js");
$ac->registerAssetGroup(array('script.js', 'plugins.js', 'user.profile.js', 'user.less', 'general.less'), $baseUrl);

$this->pageTitle("Profile");
$this->title = UserModule::t('Edit profile');
$this->breadcrumbs=array(
	UserModule::t("Profile")=>array('profile'),
	UserModule::t("Edit"),
);
?>

<?php $this->beginClip('top') ?>
<ul class="nav nav-tabs">
  <li class="active"><a href="#profile" data-toggle="tab"><?php __("Profile") ?></a></li>
  <li><a href="#password" data-toggle="tab"><?php __("Password") ?></a></li>
  <li><a href="#notifications" data-toggle="tab"><?php __("Notifications") ?></a></li>
</ul>
<?php $this->endClip(); ?>

<div id="profile-page">

  <?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
  <div class="success">
  <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
  </div>
  <?php endif; ?>

  <div class="tab-content">

    <div id="profile" class="tab-pane active container">
      <?php $form=$this->beginWidget('UActiveForm', array(
          'id'=>'profile-form',
          'enableAjaxValidation'=>true,
          'htmlOptions' => array('enctype'=>'multipart/form-data'),
      )); ?>
      <div class="left form span6">

          <p class="note row"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

          <?php echo $form->errorSummary(array($model,$profile)); ?>

          <div class="row">
            <?php echo $form->labelEx($model,'username'); ?>
            <?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20, 'disabled' => 'disabled')); ?>
            <?php echo $form->error($model,'username'); ?>
          </div>

      <?php
              $profileFields=$profile->getFields();
              if ($profileFields) {
                  foreach($profileFields as $field) {
                  ?>
          <div class="row">
              <?php echo $form->labelEx($profile,$field->varname);

              if ($field->widgetEdit($profile)) {
                  echo $field->widgetEdit($profile);
              } elseif ($field->range) {
                  echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
              } elseif ($field->field_type=="TEXT") {
                  echo $form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
              } else {
                  echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
              }
              echo $form->error($profile,$field->varname); ?>
              <?php if ($field->varname === 'fullname'): ?>
                <p class="hint">
                  <?php echo UserModule::t("Your full name is displayed on your profile"); ?>
                </p>
              <?php endif ?>
              
          </div>
                  <?php
                  }
              }
      ?>

          <div class="row">
              <?php echo $form->labelEx($model,'email'); ?>
              <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
              <?php echo $form->error($model,'email'); ?>
          </div>

          <div class="row buttons">
              <?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), array('class' => 'ig9btn')); ?>
          </div>

      </div><!-- form -->

      <div class="right form span6">          
        <div class="form-content">

          <?php if ($model->avatarBehavior->getFileUrl()) : ?>
          <div class="input-row">
            <div class='avatar-wrapper'>

              <div class="image" id='avatar'>
                <?php echo CHtml::link(Chtml::image($model->avatarBehavior->getFileUrl(), UserModule::t("Your Avatar"), array('width' => 100)), '#avatarModal', array('data-toggle' => "modal", 'role' => "button")); ?>
              </div>
              <div class='actions'>
                <span class='file-selector'>
                  <button class='btn'><?php __("Change") ?></button>
                  <div class='fileinput'>
                    <?php echo $form->fileField($model, 'avatar'); ?>
                    <?php echo $form->error($model, 'avatar'); ?>
                  </div>
                </span>
                <input type='submit' id='upload' class='btn btn-success disabled' disabled='disabled' value='<?php __("Upload") ?>'>
              </div>
            </div>
          </div>

          <?php else: ?>

          <div class='input-row'>
            <div class='avatar-wrapper'>
              <div class="image">
                <?php echo CHtml::image($baseUrl.'/img/noava.png', 'No Image'); ?>
              </div>
              <div class='actions'>
                <span class='file-selector'>
                  <button class='btn'><?php __("Choose File") ?></button>
                  <div class='fileinput'>
                    <?php echo $form->fileField($model, 'avatar'); ?>
                    <?php echo $form->error($model, 'avatar'); ?>
                  </div>
                </span>
                <input type='submit' id='upload' class='btn btn-success disabled' disabled='disabled' value='<?php __("Upload") ?>'>
              </div>
              
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>

      <?php $this->endWidget(); ?>

    </div><!-- profile -->

    <div id="password" class="tab-pane span6">

      <div class="form">
        <?php $form=$this->beginWidget('UActiveForm', array(
        'action' => $this->url('user/profile', 'edit'),
        'id'=>'changepassword-form',
        'enableAjaxValidation'=>true,
      )); ?>

        <p class="note row"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
        <?php echo CHtml::errorSummary($password); ?>

        <div class="row">
          <?php echo $form->labelEx($password,'password'); ?>
          <?php echo $form->passwordField($password,'password'); ?>
          <?php echo $form->error($password,'password'); ?>
          <p class="hint">
            <?php echo UserModule::t("Minimal password length 4 symbols."); ?>
          </p>
        </div>

        <div class="row">
          <?php echo $form->labelEx($password,'verifyPassword'); ?>
          <?php echo $form->passwordField($password,'verifyPassword'); ?>
          <?php echo $form->error($password,'verifyPassword'); ?>
        </div>

        <div class="row submit">
          <?php echo CHtml::submitButton(UserModule::t("Save"), array('class' => 'ig9btn')); ?>
        </div>

        <?php $this->endWidget(); ?>
      </div><!-- form -->

    </div><!-- password -->

    <div id="notifications" class="tab-pane span8">

      <div class="form">
        <div class="form">
          <?php $form=$this->beginWidget('UActiveForm', array(
          'action' => $this->url('user/profile', 'subscribe'),
          'id'=>'notification-form',
          'enableAjaxValidation'=>false,
        )); ?>

          <div class="row multi">
            <label><?php __("Notify me when:") ?> </label>
            <div class="multi-check">
<!--               <div class="row">
                <input checked="checked" class="checkbox" id="user_notify_of_friend_activity" name="user[notify_of_friend_activity]" type="checkbox" value="1">
                <label class="checkbox" for="user_notify_of_friend_activity"><?php __("Someone I follow backs or launches a project") ?></label>
              </div>
              <div class="row">
                <input checked="checked" class="checkbox" id="user_notify_of_follower" name="user[notify_of_follower]" type="checkbox" value="1">
                <label class="checkbox" for="user_notify_of_follower"><?php __("I get new followers (daily digest)") ?></label>
              </div> -->
              <div class="row last">
                <?php echo $form->checkbox($model,'subscriber', array('value' => 1, 'checked' => $model->subscriber == 1 )); ?>
                <?php echo $form->labelEx($model,'subscriber', array('class' => 'checkbox')); ?>
              </div>
            </div>
          </div>

          <div class="row submit">
            <?php echo CHtml::submitButton(UserModule::t("Save"), array('class' => 'ig9btn')); ?>
          </div>

        <?php $this->endWidget(); ?>
      </div><!-- form -->

    </div><!-- password -->

  </div><!-- tab-content -->

</div>

<div class="modal hide fade" id="avatarModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="modalLabel"><?php __("Edit Avatar") ?></h3>
  </div>
  <div class="modal-body">
    <div class="image">
      <?php echo Chtml::image($model->avatarBehavior->getFileUrl('original'), UserModule::t("Your Avatar"), array('id' => 'avatarcrop')); ?>
    </div>
  </div>
  <div class="modal-footer">
    <span class='loading' style='display:none;'><?php __("Processing ...") ?></span>
    <a href='#' data-dismiss="modal" class='cancel tt' title="<?php __("Cancel") ?>"><?php __("Cancel") ?></a> <span class='or'><?php __("or") ?></span>
    <button class="btn btn-primary crop"><?php __("Crop") ?></button>
  </div>
</div>