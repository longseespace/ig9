<?php /* @var $this Controller */
  $baseUrl = $this->assetsUrl;
  $email = EmailSubscriber::model();
?>
<div id="footer">
  <div class="logo">
    <?php echo CHtml::image($baseUrl."/img/footer-logo.png","IG9");?>
  </div>
  <div class="nav wrapper clearfix">
    <div class="nav1">
      <h3><?php __("Navigation") ?></h3>
      <ul>
        <li><a href="/uploads/ig9landing/index.html"><?php __("How it works");?></a></li>
        <li><a href="/help/faq/ig9%20basics">FAQ</a></li>
        <li><a href="/page/huong-dan-thanh-toan"><?php __("Payment Guide") ?></a></li>
      </ul>
    </div>

    <div class="nav2">
      <h3><?php __("Information") ?></h3>
      <ul>
        <li><a href="/page/gioi-thieu">Giới thiệu</a></li>
        <li><a href="http://blog.ig9.vn"><?php __("Blog") ?></a></li>
        <li><a href="<?php echo $this->url('page', 'terms-of-use') ?>"><?php __("Term and Conditions");?></a></li>
        <li><a href="<?php echo $this->url('page', 'privacy-policy') ?>"><?php __("Privacy Policy");?></a></li>
<!--        <li><a href="https://www.facebook.com/IG9.vn">--><?php //__("Facebook") ?><!--</a></li>-->
<!--        <li><a href="http://twitter.com/ig9vn">--><?php //__("Twitter") ?><!--</a></li>-->
      </ul>
    </div>

    <div class="nav3">
      <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'subscriber',
        'enableAjaxValidation'=>false,
        'action' => $this->createUrl('/news')
      )); ?>
      <?php if (Yii::app()->user->isGuest) : ?>
        <p><?php __('Subscribe to receive amazing projects from IG9') ?></p>
        <p>
          <?php echo CHtml::activeTextField($email, 'email', array('placeholder'=>'Email...')); ?>
          <?php echo CHtml::activeHiddenField($email, 'username', array('value'=>'Guest')); ?>
          <?php echo CHtml::submitButton(___('Subscribe'),array('class'=>'btn ig9btn ig9btn-small')); ?>
        </p>
      <?php elseif (!Yii::app()->user->isGuest) : ?>
<!--         <?php echo CHtml::activeHiddenField($email, 'username', array('value'=>Yii::app()->user->model()->username)); ?>
        <?php echo CHtml::activeHiddenField($email, 'email', array('value'=>Yii::app()->user->model()->email)); ?>
        <?php echo CHtml::submitButton(___('Subscribe'),array('class'=>'btn ig9btn ig9btn-small')); ?> -->
      <?php endif; ?>
      <?php $this->endWidget(); ?>
      <div class="fb-like" data-href="http://www.facebook.com/IG9.vn" data-send="false" data-width="400" data-show-faces="true"></div>

      <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=456799661012430";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
      </script>
    </div>


  </div>
  <div class="copyright">
    &copy; <?php echo date('Y') ?> - <?php __('Copyright IG9 JSC') ?> <br/>
    <?php __('Address: 11B Tran Quoc Toan, Hoan Kiem, Ha Noi.')?> <?php __('Hotline: +84-127-345-2178. Email: info@ig9.vn') ?>      
  </div>
</div>