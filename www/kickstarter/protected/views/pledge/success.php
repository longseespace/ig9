<?php
$baseUrl = $this->assetsUrl;
$this->pageTitle="Project Name - ".Yii::app()->name;
Yii::app()->assetCompiler->registerAssetGroup(array('pledge.less', 'pledge.js'), $baseUrl);

$twitterUrl = 'http://twitter.com/intent/tweet?text='.urlencode(___('I just backed \'%s\' on @ig9vn %s', $project->title, $this->createAbsoluteUrl('project/view', array('id' => $project->id, 'slug' => $project->slug))));
$facebookUrl = 'http://facebook.com/sharer/sharer.php?u=' . urlencode($this->createAbsoluteUrl('project/view', array('id' => $project->id, 'slug' => $project->slug)));
?>

<div id="project-header">
  <h1 class="title"><?php echo $project->title;?></h1>
  <h2 class="subtile">
    <span class='creator'><?php __("by");?> <a href="<?php echo $this->createUrl('/user/profile', array('id' => $project->user->id)); ?>"><?php echo $project->user->username;?></a></span>
    <span class='divider'>·</span>
    <span class='backing'><b><?php __('You\'re a backer') ?></b></span>
  </h2>
</div>
<div class="main">

  <div class="container">

    <div class="row">
      <div class="span8 checkout_cher">
        <h1 class='highlight'><?php __('Congratulations!') ?></h1>
        <p><?php __("You are now an official backer of ") ?> <?php echo $project->title ?>. <?php __("Time to tell the world about it!") ?></p>
        <?php if(in_array($transaction->gateway, array('direct', 'bank', 'cod', 'paypal'))): ?>
          <div class="herounit">
            <?php echo $transaction->code ?>
          </div>
        <?php endif;?>
        <?php if($transaction->gateway === 'direct'): ?>
        <p> <i>* Bạn vui lòng giao mã số này khi đên nộp tiền.</i></p>
        <?php elseif($transaction->gateway === 'bank'): ?>
        <p> <i>* Bạn vui lòng ghi mã số này vào nội dung chuyển khoản.</i></p>
        <?php elseif($transaction->gateway === 'cod'): ?>
        <p> <i>* Bạn vui lòng giao mã số này cho người thu tiền.</i></p>
        <?php endif; ?>

        <?php if($transaction->gateway === 'direct'): ?>
        <p><strong>Địa chỉ thanh toán:</strong></p>
        <p>
          <img src="/uploads/images/788c477035edff90e9644a1890669b21.jpg" style="font-size: 15px; line-height: 1.45em; text-align: justify; height: 29px; width: 29px; cursor: default; ">
          <span style="font-size: 15px; line-height: 1.45em; text-align: justify;">
            &nbsp;
          </span>
          info@ig9.vn (business) / support@ig9.vn (customer)
          <span style="font-size: 15px; line-height: 1.45em; text-align: justify;">
            <br>
          </span>
          <p>
            <img src="http://beta.ig9.vn/uploads/images/9b6ab963eae94065dd8f80506ab7e8ac.jpg" style="font-size: 15px; line-height: 1.45em; text-align: justify; height: 25px; width: 25px; cursor: default;">
            <span style="font-size: 15px; line-height: 1.45em; text-align: justify;">
              &nbsp; 11B Trần Quốc Toản, Tầng 6, Quận Hoàn Kiếm, Hà Nội, Việt Nam
            </span>
            <br>
            <span style="font-size: 15px; line-height: 1.45em; text-align: justify; margin-left: 30px">
              &nbsp; 37 Tôn Đức Thắng, Đống Đa, Hà Nội
            </span>
          </p>
          <p>
            <img src="http://beta.ig9.vn/uploads/images/57eeef64892d6c4fccec399abb1026da.jpg" style="font-size: 15px; line-height: 1.45em; text-align: justify; height: 29px; width: 29px; cursor: default; ">
            <span style="font-size: 15px; line-height: 1.45em; text-align: justify;">
              &nbsp; 0127 345 2178
            </span>
            <br/>
            <span style="font-size: 15px; line-height: 1.45em; text-align: justify; margin-left: 32px">
              &nbsp; 04 6686 1406
            </span>
          </p>

         <!--
          &nbsp;
          <img src="http://beta.ig9.vn/uploads/images/9b6ab963eae94065dd8f80506ab7e8ac.jpg"
          style="font-size: 15px; line-height: 1.45em; text-align: justify; height: 25px; width: 25px; cursor: default;">


          &nbsp;
          <img src="http://beta.ig9.vn/uploads/images/9b6ab963eae94065dd8f80506ab7e8ac.jpg"
          style="font-size: 15px; line-height: 1.45em; text-align: justify; height: 25px; width: 25px; cursor: default;">
          <span style="font-size: 15px; line-height: 1.45em; text-align: justify;">
            &nbsp; 37 Tôn Đức Thắng, Đống Đa, Hà
            <br>
          </span> -->
        </p>
        <?php endif; ?>
        <ul class="chers">
          <li class="twitter_cher"><a href="<?php echo $twitterUrl ?>" class="share_twitter" data-tracker-name="Twitter" rel="nofollow" target="_blank" title="<?php __("Tweet") ?>"><?php __("Tweet") ?></a></li>
          <li class="facebook_cher"><a href="<?php echo $facebookUrl ?>" class="share_facebook" data-tracker-name="Facebook" rel="nofollow" target="_blank" title="<?php __("Share on Facebook") ?>"><?php __("Share") ?></a></li>
        </ul>
      </div>
      <div class="span4 checkout_receipt">
        <dl>
          <dt><?php __("Pledge amount") ?></dt>
          <dd>
            <strong class="pledge_amount"><?php _m($transaction->amount) ?></strong>
          </dd>
          <dt><?php __("Selected reward") ?></dt>
          <dd class="reward"><?php echo $reward->description ?></dd>
        </dl>
      </div>

    </div>

  </div>
</div>
