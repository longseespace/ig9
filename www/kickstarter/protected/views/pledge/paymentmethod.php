<?php
$baseUrl = $this->assetsUrl;
$this->pageTitle="Project Name - ".Yii::app()->name;
Yii::app()->assetCompiler->registerAssetGroup(array('pledge.less', 'pledge.js'), $baseUrl);

$project = $transaction->reward->project;
?>

<?php $form = $this->beginWidget('CActiveForm', array(
  'id' => 'theform',
  'enableAjaxValidation' => true,
  'enableClientValidation' => true,
  'clientOptions' => array(
    'validateOnSubmit' => true
  )
)); ?>

<div id="project-header">
  <h1 class="title"><?php echo $project->title;?></h1>
  <h2 class="subtile"><?php __("by");?> <a href="#"><?php echo $project->user->username;?></a></h2>
</div>
<div class="main checkout-payment">
  <div class="container" id="content">
    <div id="main">
      <div class="tout_checkout">
        <h1><?php __('Check out'); ?></h1>
        <!-- <p>
          <?php __('Don\'t have an Amazon account? Just select "I am a new customer" on the next page.'); ?>
        </p> -->
      </div>
      <div class="pledges__checkout_summary clearfix">
        <dl class="clearfix">
          <dt>
            <?php __('Pledge amount'); ?>
          </dt>
          <dd>
            <strong class="pledge_amount">
              <?php _n($transaction->amount) ?>
            </strong>
          </dd>
          <dt>
            <?php __('Selected reward'); ?>
          </dt>
          <dd class="reward">
            <h3 class="title">
              <?php __('Pledge %s or more', __n($transaction->reward->amount)); ?>
            </h3>
            <p>
              <?php echo $transaction->reward->description ?>
            </p>
            <p class="delivery_date">
              <?php __('Estimated delivery'); ?>
              :
              <?php _d($transaction->reward->delivery_time); ?>
            </p>
          </dd>
          <dt>
            <?php __("Payment method"); ?>
          </dt>
          <dd>
            <label>
              <input type="radio" value="onepay_noidia" name="Transaction[gateway]" checked="checked"/> Thẻ thanh toán/ATM nội địa
            </label>
            <p class="description">
              IG9 hỗ trợ tất cả các loại thẻ nội địa và ATM được phát hành bởi các ngân hàng trong nước.
            </p>
            <label>
              <input type="radio" value="onepay_quocte" name="Transaction[gateway]"/>Thẻ Credit/Debit quốc tế
            </label>
            <p class="description">
              Cho phép thanh toán bàng các loại thẻ quốc tể (VISA, MASTERCARD, American Express, JCB...)
              <img src="/themes/ig9/assets/img/1.VM_ATMnoidia_logongang_450x50_eng.png" onClick='window.open( "http://202.9.84.88/documents/payment/1en.html","myWindow","status = 0,toolbar=0,location=0,menubar=0,directories=0,scrollbars=1,height = 600, width = 730, resizable = 0")'/>
            </p>
            <label>
              <input type="radio" value="nganluong" name="Transaction[gateway]"/> Thanh toán qua nganluong.vn
            </label>
            <p class="description">
              Thanh toán sử dụng thẻ ATM/thẻ ngân hàng/Credit/Debit qua nganluong.vn
            </p>
            <label>
              <input type="radio" value="bank" name="Transaction[gateway]" class="profile-required"/> Chuyển khoản ngân hàng
            </label>
            <p class="description">
              Chuyển khoản tới tài khoản của IG9 tại ngân hàng TechcomBank.
            </p>
            <div class="bank-show radio-show">
              <!-- <strong>Tài khoản VP Bank</strong>
              <ul>
                <li>Tên tài khoản: Công ty cổ phần IG9</li>
                <li>Số tài khoản : 43601091</li>
                <li>Ngân hàng VP Bank - Kinh Đô</li>
                <li>Nội dung chuyển khoản: [mã số đơn hàng]</li>
              </ul>
              <strong>Tài khoản Vietcombank</strong>
              <ul>
                <li>Tên Tài Khoản: Công ty cổ phần IG9</li>
                <li>Số tài khoản : 0301 000 311 234</li>
                <li>Ngân Hàng Vietcombank - Hoàn Kiếm</li>
                <li>Nội dung chuyển khoản: [mã số đơn hàng]</li>
              </ul> -->
              <strong>Tài khoản TechcomBank</strong>
              <ul>
                <li>Tên tài khoản: Đặng Minh Nhân</li>
                <li>Số Tài Khoản: 19023431892015</li>
                <li>Ngân Hàng TechcomBank – Đào Tấn</li>
                <li>Nội dung chuyển khoản: [mã số đóng góp]</li>
              </ul>
            </div>
            <?php if($user->credit >= $transaction->amount): ?>
            <label>
              <input type="radio" value="ig9-credit" name="Transaction[gateway]" class="profile-required"/> IG9 credit
            </label>
            <p class="description">
              Thanh toán sử dụng số dư credit trong tài khoản IG9.
            </p>
            <div class="ig9-credit-show radio-show">
              Số dư hiện tại của bạn: <span class="user-credit"><?php _m($user->credit); ?></span>
            </div>
            <?php endif; ?>
            <label>
              <input type="radio" value="paypal" name="Transaction[gateway]" class="profile-required"/> Paypal
            </label>
            <p class="description">
              Please send your money to this Paypal account: <strong>info@ig9.vn</strong>.
            </p>
            <label>
              <input type="radio" value="credit" name="Transaction[gateway]"/> Thanh toán bằng thẻ cào
            </label>
            <p class="description">
              Nạp tiền bằng thẻ cào di động VINAPHONE, MOBIPHONE, VIETTEL.
              <br/>
              <span style="font-style:italic; font-weight:bold">
                * Với hình thức thanh toán này, chúng tôi chỉ có thể hoàn trả qua credit của IG9 (bạn có thể dùng credit này để hỗ trợ cho các dự án khác).
              </span>
            </p>
            <div class="credit-show radio-show">
              Số dư hiện tại của bạn: <span class="user-credit"><?php _m($user->credit); ?></span>
              <a href="#card-charge-modal" role="button" class="ig9btn ig9btn-small" data-toggle="modal" data-backdrop="static" data-keyboard="false"><?php __('Charge'); ?></a>
            </div>
            <label>
              <input type="radio" value="direct" name="Transaction[gateway]" class="profile-required"/> Thanh toán trực tiếp
            </label>
            <p class="description">
              Bạn có thể ủng hộ trực tiếp tại một trong những trụ sở của IG9.
              <br/>
              <span style="font-style:italic; font-weight:bold">
                * Bạn vui lòng thanh toán trong vòng 24 giờ. Số tiền của dự án chỉ được cập nhật sau khi chúng tôi nhận được tiền của bạn.
              </span>
            </p>
            <?php if($transaction->amount >= 500000): ?>
            <!-- Removed
            <label>
              <input type="radio" value="cod" name="Transaction[gateway]" class="profile-required"/> Thanh toán COD
            </label>
            <p class="description">
              Nhân viên dịch vụ chuyển phát sẽ nhận tiền tại địa chỉ của bạn.
              <br/>
              <span style="font-style:italic; font-weight:bold">
                * Bạn vui lòng thanh toán thêm giá cước dịch vụ phát hành thu tiền (COD): 5% với hoá đơn dưới 1 triệu VNĐ, 4% với hoá đơn từ 1 triệu đến 3 triệu, 3% với hoá đơn trên 3 triệu trên tổng giá trị thanh toán.
              </span>
              <br/>
              <span style="font-style:italic; font-weight:bold">* Chỉ áp dụng với 6 tỉnh: Hà Nội, TP Hồ Chí Minh, Cần Thơ, Nha Trang, Vũng Tàu, Đà Nẵng và Hải Phòng.</span>
              <br/>
              <span style="font-style:italic; font-weight:bold">
                * Số tiền của dự án chỉ được cập nhật sau khi bạn xác nhận qua điện thoại với nhân viên của IG9.
              </span>
            </p>
            -->
            <?php endif; ?>
          </dd>
        </dl>
        <dl id="profile-required">
          <dt>
            <?php __('Mobile'); ?>
          </dt>
          <dd>
            <?php echo $form->textField($profile, "mobile") ?>
            <p id='Profile_mobile-error' class='error-message'></p>
          </dd>
          <dt>
            <?php __('Address'); ?>
          </dt>
          <dd>
            <?php echo $form->textArea($profile, "address") ?>
            <p id='Profile_address-error' class='error-message'></p>
          </dd>
        </dl>
      </div>
      <div class="clearfix">
        <label style="float: right">
          <input type="checkbox" id="agreeterms"/>
          <?php __("I have aggeed with"); ?>
          <?php echo CHtml::link(___("terms and conditions"), '/page/terms-of-use'); ?>
        </label>
      </div>
      <input type="submit" value="<?php __("Checkout");?>" class="submit" id="submitbtn"/>
    </div>
    <!-- #main -->
    <div id="sidebar">
      <div class="NS_pledges__checkout_accountability">
        <h6 class="important">
          <span class="highlight">
            <?php __("Important") ?>
          </span>
        </h6>
        <p>
          <?php __("Kickstarter does not guarantee projects or investigate a creator's ability to complete their project. It is the responsibility of the project creator to complete their project as promised, and the claims of this project are theirs alone.") ?>
        </p>
        <p>
          <a href="/help/faq" target="_blank">
            <?php __("Learn more about accountability"); ?>
          </a>
        </p>
      </div>
    </div>
    <!-- #sidebar -->
  </div>
</div>

<?php $this->endWidget(); ?>

<div id="card-charge-modal" class="modal hide fade" tabindex="-1" role="dialog">
  <div class="modal-loader">
    <div class="progressing">
      <p><?php __("Transaction in progress"); ?></p>
      <img src="/themes/ig9/assets/img/loader-black.gif" />
    </div>
  </div>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php ___('Card charge'); ?></h3>
  </div>
  <div class="modal-body">
    <form id="credit-extra-form" class="form-horizontal">
      <div class="control-group">
        <label class="control-label" for="inputTypeCard"><?php __('Card type'); ?></label>
        <div class="controls">
          <select name="Card[type_card]" id="inputTypeCard">
            <option value="VIETTEL">Viettel</option>
            <option value="VNP">Vinaphone</option>
            <option value="VMS">Mobiphone</option>
          </select>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputPinCard"><?php __('PIN'); ?></label>
        <div class="controls">
          <input type="text" id="inputPinCard" name="Card[pin_card]">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputCardSerial"><?php __('Serial'); ?></label>
        <div class="controls">
          <input type="text" id="inputCardSerial" name="Card[card_serial]">
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="ig9btn ig9btn-small"><?php __("Charge"); ?></button>
        </div>
      </div>
    </form>
  </div>
</div>