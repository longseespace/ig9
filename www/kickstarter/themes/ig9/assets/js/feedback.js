jQuery(document).ready(function($){
  
  var $feedback = $("#feedback");
  var feedback = null;
  var first = true;

  var FEEDBACK_ENDPOINT = '/feedback/add';
  
  $("#feedback-button").click(function(e){
    e.preventDefault();
    $feedback.feedbackify();
  })
  
  $.fn.feedbackify = function(target){
    if (typeof(target) !== 'undefined') {
      $feedback = $(target);
    };
    resetForm();
    feedback = new Object();
    var w_height = $(window).height();
    var w_width = $(window).width();
    var top = (w_height > 500) ? (w_height - 500) / 2 : 0;
    var left = (w_width > 600) ? (w_width - 600) / 2 : 0;
    $(".form", $feedback).css({ top : top, left : left });
    
    $feedback.css('visibility', 'hidden').show();
    var form_height = $('.form', $feedback).outerHeight() + $(".feedback.content", $feedback).outerHeight() + $(".footer", $feedback).outerHeight() - 6;
    $('.form', $feedback).animate({ height : form_height }, 500, 'easeInQuint', function(){
      $(this).css('height', 'auto');
      $('a[href="#website_message"]').click();
    });
    $feedback.css('visibility', 'visible');
  }
  
  var resetForm = function(){
    $('.content', $feedback).hide();
    $('.feedback.content', $feedback).show();
    $('.form', $feedback).removeAttr('style');
    $('.select-on', $feedback).removeAttr('style');
    $('.cat-arrow img', $feedback).css('left', -99999);
    $('textarea, #feedback_email', $feedback).val('');
    $('.send-button a, .message-wrapper', $feedback).hide();
    $('.cancel-button, #send-feedback', $feedback).show();
  }
  
  var showMessage = function(message){
    $(".msg-box .msg-content", $feedback).html(message);
    $(".msg-box", $feedback).css('top', 0).show().animate({ top: 140 }, 100, function(){
      $(this).animate({ top: 140 }, 2000, function(){
        $(this).animate({ top: 0 }, 100, function(){
          $(this).hide();
        });
      });
    });
  }
  
  var animateForm = function(target){
    $(".form", $feedback).css('height', 'auto');
    var form_height = $(".form", $feedback).height();
    $(".content", $feedback).hide();
    $(target, $feedback).show();
    var new_height = $(".form", $feedback).height();
    $(".form", $feedback).height(form_height).animate({ height: new_height }, 1000, 'easeOutBounce');
  }
  
  $(".select td > a", $feedback).click(function(e){
    e.preventDefault();
  })
  
  $(".score td > a", $feedback).click(function(e){
    e.preventDefault();
    var $anchor = $(this);
    var $td = $anchor.parent();
    var $scoreover = $anchor.parents('.select-wrapper').find('.score-over');
    $('td > a', $scoreover).html($anchor.html());
    $('td', $scoreover).width($td.innerWidth() - 2).height($td.innerHeight() - 3);
    $scoreover.css({ left : $td.position().left - 2, visibility : 'visible' });
    feedback.score = $anchor.data('value');
  })
  
  $(".cat-table td > a", $feedback).click(function(e){
    e.preventDefault();
    var $anchor = $(this);
    var $td = $anchor.parent();
    var $catover = $anchor.parents('.select-wrapper').find('.cat-over');
    var $catarrow = $anchor.parents('.select-wrapper').find('.cat-arrow');
    $('td > a', $catover).html($anchor.html());
    $('td', $catover).width($td.innerWidth() - 2).height($td.innerHeight() - 3);
    $('img', $catarrow).animate({ left : $td.position().left - 10 + $td.innerWidth() / 2 }, 200, 'easeOutCirc');
    $catover.css({ left : $td.position().left - 2, visibility : 'visible' });
    $('.message-wrapper .text h3').html($anchor.html());

    $('.message-wrapper').slideDown({ duration: 500, easing: 'easeOutBounce' });
  })
  
  $(".cat-table", $feedback).idTabs(function(id, list, set){
    if (first) {
      $(".message-wrapper", $feedback).hide();
      $(".cat-over", $feedback).css('visibility', 'hidden');
      $(".cat-arrow img", $feedback).css('left', -100);
      first = false;
    };
    
    return true;
  });
  
  // Buttons
  $("a.close", $feedback).click(function(e){
    e.preventDefault();  
    $('.form', $feedback).animate({ height : 50 }, 500, 'easeOutQuint', function(){
      $feedback.hide();
    });
  })
  
  $(".msg-box", $feedback).click(function(){
    $(this).hide();
  })
  
  $("#send-feedback", $feedback).click(function(e){
    e.preventDefault();
    
    if (feedback.score === undefined) {
      feedback.score = 10;
    };
    
    feedback.website_message = $('#website_message textarea').val();
    feedback.product_message = $('#product_message textarea').val();
    feedback.service_message = $('#service_message textarea').val();
    feedback.payment_message = $('#payment_message textarea').val();
    feedback.other_message = $('#other_message textarea').val();
    feedback.url = window.location.pathname;

    if (!(feedback.website_message || feedback.product_message || feedback.service_message || feedback.payment_message || feedback.other_message)) {
      showMessage('Vui lòng nhập câu hỏi hoặc phản hồi');
      return false;
    }

    $(".indicator", $feedback).css('visibility', 'visible');
    $.ajax({
      type: 'POST',
      url: FEEDBACK_ENDPOINT,
      data: feedback,
      success: function(id){
        $(".indicator", $feedback).css('visibility', 'hidden');
        if (id > 0) {
          feedback.id = id;
          
          $("#send-feedback", $feedback).hide();
          $("#send-email", $feedback).show();
          
          animateForm('.email.content');
        } else {
          showMessage('Có lỗi xảy ra. Vui lòng thử lại sau');
        }
      }
    });
 
  })
  
  
  $("#send-email", $feedback).click(function(e){
    e.preventDefault();
    
    var email = $("#feedback_email").val();
    if (email.length === 0) {
      showMessage('Vui lòng nhập email hợp lệ');
      return false;
    };
    
    feedback.email = email;
    
    $(".indicator", $feedback).css('visibility', 'visible');
    $.ajax({
      type: 'POST',
      url: FEEDBACK_ENDPOINT,
      data: feedback,
      success: function(id){
        $(".indicator", $feedback).css('visibility', 'hidden');
        $("#send-email, .cancel-button", $feedback).hide();
        $(".send-button .close", $feedback).show();
        feedback = null;
        
        animateForm('.thankyou.content');
      }
    });
  })

})