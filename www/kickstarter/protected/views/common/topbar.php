<?php
$baseUrl = $this->assetsUrl;
//$this->pageTitle("Project Name");

$unreadMessage = Yii::app()->getModule('message')->getCountUnreadedMessages(Yii::app()->user->id);

$labelSuffix = $unreadMessage ? ' (' . $unreadMessage . ')' : '';

?>

<?php echo $this->clips['notification']; ?>

<div id="nav" class="<?php echo $this->isHome?'':'noborder'?>">
  <a href="/" id="logo"><?php echo CHtml::image($baseUrl."/img/logo.gif","IG9");?></a>
  <!-- <a href="/discover" id="tb-discover" class="top-button"><span class="pictos">l</span><?php __("Discover");?></a> -->
  <a href="/uploads/ig9landing/index.html" id="tb-start" class="top-button"><span class="pictos">i</span><?php __('What is IG9?'); ?></a>
  <a href="<?php echo Yii::app()->createUrl('/page/huong-dan-thanh-toan'); ?>" id="tb-learn" class="top-button"><span class="pictos">?</span><?php __('Payment guide'); ?></a>
  <a href="/start" id="tb-start" class="top-button"><span class="pictos">Q</span><?php __('Ignite'); ?></a>
  <div class="right">
    <?php if (Yii::app()->user->isGuest) : ?>
      <a href="<?php echo $this->url('user', 'login'); ?>" id="tb-login"><?php __('Log in') ?></a>
      <a href="<?php echo $this->url('user', 'register'); ?>" id="tb-join"><?php __('Join Now') ?></a>
    <?php else : ?>
    <div class="dropdown logged-in">
      <a class="dropdown-toggle" id="profile-dropdown" role="button" data-toggle="dropdown" data-target="#" href="<?php echo $this->url('user', 'profile') ?>" >
        <?php if (Yii::app()->getModule('user')->user()->avatarBehavior->getFileUrl()) {
          echo Chtml::image(Yii::app()->getModule('user')->user()->avatarBehavior->getFileUrl(), UserModule::t("Your Avatar"), array('width' => 30, 'class' => 'usericon refresh'));
        } else {
          echo CHtml::image($baseUrl.'/img/noava_small.png', 'No Image', array('width' => 30));
        }
        ?>

        <span class='username'><?php echo Yii::app()->user->model()->username; ?></span>
      </a>
      <ul class="dropdown-menu" role="menu" aria-labelledby="profile-dropdown">
        <li><?php echo CHtml::link(UserModule::t('Profile'),array('/user/profile/edit')); ?></li>
        <li><?php echo CHtml::link(UserModule::t('Project'),array('/user/profile')); ?></li>
        <li><?php echo CHtml::link(UserModule::t('Logout'),array('/user/logout')); ?></li>
      </ul>
    </div>

    <div class='dropdown message'>
      <a class="dropdown-toggle" id="message-dropdown" role="button" data-toggle="dropdown" data-target="#" href="/message" >
        <span class="pictos">M</span>
        <?php if ($unreadMessage): ?>
          <span class='badge'><?php echo $unreadMessage ?></span>
        <?php endif ?>
      </a>
      <ul class="dropdown-menu" role="menu" aria-labelledby="message-dropdown">
        <li><?php echo CHtml::link(___('Inbox') . $labelSuffix, array('/message/inbox')); ?></li>
        <li><?php echo CHtml::link(___('Sent Message'), array('/message/sent')); ?></li>
        <li><?php echo CHtml::link(___('Drafts'), array('/message/draft')); ?></li>
        <li><?php echo CHtml::link(___('Trash'), array('/message/trash')); ?></li>
      </ul>
    </div>
    <?php endif; ?>
  </div>
</div>
<?php if ($this->isHome):?>
<div class="home-banner wrapper">
  <ul class="clearfix">
    <li>
      <a href="#main-list">
        <img src="/themes/ig9/assets/img/1.png" width="120"/>
        <label>Lựa chọn dự án hấp dẫn</label>
      </a>
    </li>
    <li class="separator">
      &nbsp;<img src="/themes/ig9/assets/img/banner-arrow.png"/>
    </li>
    <li>
      <a>
        <img src="/themes/ig9/assets/img/2.png" width="120"/>
        <label>Trao đổi và chia sẻ</label>
      </a>
    </li>
    <li class="separator">
      &nbsp;<img src="/themes/ig9/assets/img/banner-arrow.png"/>
    </li>
    <li>
      <a href="/page/huong-dan-thanh-toan">
        <img src="/themes/ig9/assets/img/3.png" width="120"/>
        <label>Đầu tư cho dự án</label>
      </a>
    </li>
    <li class="separator">
      &nbsp;<img src="/themes/ig9/assets/img/banner-arrow.png"/>
    </li>
    <li>
      <a>
        <img src="/themes/ig9/assets/img/4.png" width="120"/>
        <label>Nhận quà từ dự án</label>
      </a>
    </li>
  </ul>
  <!-- <a href="/uploads/ig9landing/index.html">
  <h1><span class="arrow-left"></span><?php __("Fund & Follow Creativity") ?><span class="arrow-right"></span></h1>
  <h2><?php __("IG9 is a funding platform for creative projects") ?></h2></a> -->
</div>
<?php endif?>