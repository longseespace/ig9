<?php /* @var $this Controller */
  $baseUrl = $this->assetsUrl;
  $cs = Yii::app()->clientScript;

  $cs->registerScriptFile($baseUrl."/js/core/jquery.idTabs.min.js");
  $cs->registerScriptFile($baseUrl."/js/core/jquery.easing.js");
  $cs->registerCssFile($baseUrl."/css/feedback.css");

  Yii::app()->assetCompiler->registerAssetGroup(array('feedback.js'), $baseUrl);

?>

<div>
  <a id="feedback-button" href="#feedback"><?php echo CHtml::image($baseUrl.'/img/feedy.png', 'No Image'); ?></a>
</div>

<div id="feedback">
  <div class="screen">
    <div class="mask"></div>
  </div>
  
  <div class="form">
    
    <div class="msg-box">
      <div class="msg-icon"><?php echo CHtml::image($baseUrl.'/img/exclamation.png') ?></div>
      <div class="msg-content">Vui lòng chọn điểm đánh giá hoặc danh mục phản hồi</div>
    </div>
    
    <?php echo CHtml::image($baseUrl.'/img/logo.gif', '', array('style' => 'display:block!important;height:50px;margin:4px 0 10px!important')) ?>
    
    <div class="content feedback">
      <div class="header">
        Chào bạn, xin vui lòng để lại phản hồi hoặc câu hỏi cho trang web ig9.vn
      </div>
      <div class="category">
        <div class="select-contain">
          <div class="select-wrapper">
            <table class="cat-over select select-on" cellspacing=2>
              <tr>
                <td><a href='#'>x</a></td>
              </tr>
            </table>
            <table class="cat-table select select-off" cellspacing=1>
              <tr>
                <td><a data-value="1" href="#website_message">Website</a></td>
                <td><a data-value="2" href="#product_message">Các dự án</a></td>
                <td><a data-value="3" href="#payment_message">Phương thức thanh toán</a></td>
                <td><a data-value="4" href="#other_message">Ý kiến khác</a></td>
              </tr>
            </table>
            <div class="cat-arrow">
              <?php echo CHtml::image($baseUrl.'/img/dlg_arrow.gif') ?>
            </div>
          </div>
        </div>
      </div>
      
      <div class="message-wrapper">
        <div class="text">
          <h3>Website</h3>
          Bạn vui lòng nhập phản hồi vào form dưới đây và nhấn nút "GỬI PHẢN HỒI"
        </div>
        <div class="text-wrapper">
          <div id="website_message">
            <textarea name="website"></textarea>
          </div>
          <div id="product_message">
            <textarea name="product"></textarea>
          </div>
          <div id="payment_message">
            <textarea name="payment"></textarea>
          </div>
          <div id="other_message">
            <textarea name="other"></textarea>
          </div>
        </div>
      </div>
    </div>
    
    <div class="content email" style="display: none;">
      <div class="header">
        Cảm ơn bạn đã đóng góp cho ig9 hoàn thiện hơn!
      </div>
      <div class="intro">
        Bạn có thể để lại email nếu bạn muốn chúng tôi liên lạc lại với bạn qua email. Chúng tôi cam kết không cung cấp email của bạn cho bên thứ 3.
      </div>
      <div class="input">
        <label for="email">Email</a>
        <input type="email" id="feedback_email" name="email" value=""/>
      </div>
    </div>
    
    <div class="content thankyou" style="display: none;">
      <div class="header">
        Xin cảm ơn bạn một lần nữa!
      </div>
    </div>
    
    <div class="footer">
      <div class="buttons">
        <div class="send-button button">
          <span class="indicator"></span>
          <a id="send-feedback" class='ig9btn ig9btn-small' href="#">Gửi Phản Hồi</a>
          <a id="send-email" class='ig9btn ig9btn-small' href="#" style="display:none;">Nhập Email</a>
          <a class="close" href="#" style="display:none;">Đóng</a>
        </div>
        <div class="cancel-button">
          hoặc <a href="#" class="close">Đóng</a>
        </div>
      </div>
    </div>
  </div>
</div>