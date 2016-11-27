<?php 
$baseUrl = $this->assetsUrl;
?>

<div id="topbar">
  <div class="wrapper clearfix">
    <div id="tb-logo"><a href="/"><?php echo CHtml::image($baseUrl."/img/logo.gif","IG9");?></a></div>
    <div id="tb-right">
      <ul class="nostyle v-list">
        <li>
          <a><?php echo Yii::app()->user->model()->profile->fullname; ?></a>
        </li>
        <li>
          | <a class='notyou' title='<?php __('Sign out and sign in with different account') ?>' href="/user/logout" ><?php __('not you?') ?></a>
        </li>
      </ul>
    </div>
  </div>
</div>