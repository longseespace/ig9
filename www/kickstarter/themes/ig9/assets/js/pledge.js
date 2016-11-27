jQuery(function ($) {

  $('li.reward').click(function(e){
    e.preventDefault();
    var $li = $(this);
    $('input[type="radio"]').removeAttr('checked');
    $('input[type="radio"]', $li).attr('checked', 'checked');
    $('.selected').removeClass('selected');
    $li.addClass("selected");
    $('.indicator').hide();
    $('.indicator', $li).css('display', 'inline');

    var current_amount = ~~$('input.amount').val();
    var selected_amount = ~~$li.data('amount');
    if (selected_amount > 0) {
      if (current_amount < selected_amount) {
        current_amount = selected_amount;
        $('input.amount').val(selected_amount);
      };
    };

    // Trigger change event to perfect ajax validation
    $('input.amount').change().blur();
  })

  $('#agreeterms').on('change', function(){
    if($(this).is(':checked')){
      $('#submitbtn').removeAttr('disabled');
    } else {
      $('#submitbtn').attr('disabled', 'disabled');
    }
  });

  $('#agreeterms').trigger('change');

  $('input[type=radio][name=Transaction[gateway]]').on('change', function(){
    if($(this).is(':checked')) {
      $('.radio-show').hide();
      $('.' + $(this).val() + '-show').slideDown('fast');
      // if($(this).hasClass('profile-required')) {
      //   $('#profile-required').show();
      //   $('#profile-required input').removeAttr('disabled');
      // } else {
      //   $('#profile-required').hide();
      //   $('#profile-required input').attr('disabled', 'disabled');
      // }
    }
  });

  $('input[type=radio][name=Transaction[gateway]]').trigger('change');

  $('#theform').submit(function(){
    if ($('#profile-required').is(":visible")) {
      // Validate
      if ($('#Profile_mobile').val() === '') {
        $('#Profile_mobile-error').text('Bạn chưa nhập số điện thoại').show();
        $('#Profile_mobile').parent().addClass('error');
        return false;
      }/* else if ( ($('#Profile_mobile').val().indexOf('09') === 0 && $('#Profile_mobile').val().length == 10)
          || ($('#Profile_mobile').val().indexOf('01') === 0 && $('#Profile_mobile').val().length == 11) ){
        $('#Profile_mobile-error').hide();
        $('#Profile_mobile').parent().removeClass('error');
      } else {
        $('#Profile_mobile-error').text('Số điện thoại không đúng').show();
        $('#Profile_mobile').parent().addClass('error');
        return false;
      }*/

      if ($('#Profile_address').val() === '') {
        $('#Profile_address-error').text('Bạn chưa nhập địa chỉ').show();
        $('#Profile_address').parent().addClass('error');
        return false;
      } else {
        $('#Profile_address-error').hide();
        $('#Profile_address').parent().removeClass('error');
      }
    }
  });

  $('#theform').on('submit', function(){
    if($(this).find('input[type=radio][name=Transaction[gateway]]:checked').val() === 'credit') {
      var pledge_amount = +$('.pledge_amount').text().replace(/[^0-9]/g, '');
      var user_credit = +$('.user-credit').text().replace(/[^0-9]/g, '');
      if(user_credit < pledge_amount) {
        $('#card-charge-modal form').data('action', 'submit');
        $('#card-charge-modal').modal('show');
        return false;
      }
    }
  });

  $('#credit-extra-form').on('submit', function(){
    var $form = $(this);
    var $modal = $(this).closest('#card-charge-modal');
    var $progressing = $modal.find('.modal-loader');
    $progressing.show();
    $.ajax({
      url: '/pledge/charge',
      data: {
        'Card[type_card]' : $(this).find('#inputTypeCard').val(),
        'Card[pin_card]' : $(this).find('#inputPinCard').val(),
        'Card[card_serial]' : $(this).find('#inputCardSerial').val()
      },
      type: 'POST',
      dataType: 'json',
      success: function(response) {
        if(response.success) {
          $('.user-credit').html(response.credit_format);

          if($form.data('action') === 'submit') {
            var pledge_amount = +$('.pledge_amount').text().replace(/\./g, '');
            if(response.credit && response.credit >= pledge_amount) {
              $('#theform').submit();
              // $modal.modal('hide');
            } else {
              alert('Số dư hiện tại của bạn chưa đủ để thanh toán giao dịch này;');
              $progressing.hide();
            }
          } else {
            $progressing.hide();
            $modal.modal('hide');
          }
        } else {
          $progressing.hide();
          alert(response.message);
        }
      },
      error: function() {
        $progressing.hide();
        alert('Có lỗi xảy ra trong quá trình thực hiện giao dịch');
      }
    });
    return false;
  });
});