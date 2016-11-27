/**
 * Author: Long Doan
 * Date: 12/3/12 2:36 PM
 */

 (function(){var t;t=jQuery,t.bootstrapGrowl=function(e,s){var a,o,l;switch(s=t.extend({},t.bootstrapGrowl.default_options,s),a=t("<div>"),a.attr("class","bootstrap-growl alert"),s.type&&a.addClass("alert-"+s.type),s.allow_dismiss&&a.append('<a class="close" data-dismiss="alert" href="#">&times;</a>'),a.append(e),s.top_offset&&(s.offset={from:"top",amount:s.top_offset}),l=s.offset.amount,t(".bootstrap-growl").each(function(){return l=Math.max(l,parseInt(t(this).css(s.offset.from))+t(this).outerHeight()+s.stackup_spacing)}),o={position:"body"===s.ele?"fixed":"absolute",margin:0,"z-index":"9999",display:"none"},o[s.offset.from]=l+"px",a.css(o),"auto"!==s.width&&a.css("width",s.width+"px"),t(s.ele).append(a),s.align){case"center":a.css({left:"50%","margin-left":"-"+a.outerWidth()/2+"px"});break;case"left":a.css("left","20px");break;default:a.css("right","20px")}return a.fadeIn(),s.delay>0&&a.delay(s.delay).fadeOut(function(){return t(this).alert("close")}),a},t.bootstrapGrowl.default_options={ele:"body",type:null,offset:{from:"top",amount:20},align:"right",width:250,delay:4e3,allow_dismiss:!0,stackup_spacing:10}}).call(this);

jQuery(function ($) {
  $('table a.delete').click(function (e) {
    if(!$(this).closest('#admin-project-index').length){
      if (!confirm('Are you sure?')) {
        return false;
      }
    }
  });

  $('.main').on('click', '#project-grid .ajaxupdate', function(e){
    e.preventDefault();
    $.fn.yiiGridView.update('project-grid', {
      type:'POST',
      url:$(this).attr('href'),
      success:function(data) {
        $.fn.yiiGridView.update('project-grid');
        alert('Success');
      },
      error:function(XHR) {
        alert('Error');
      }
    });
    return false;
  });

  // hack for real-time update tooltip =))
  setInterval(function(){
    $(".ytooltip").tooltip();
  }, 100);

  $('#content').on('click', '.ajaxbutton', function(){
    var id = $(this).closest('.table').attr('id');
    if($(this).hasClass('ajaxconfirm') && !confirm('Refunding is critical function that can not be reverted, are you sure to apply?')) {
      return false;
    }

    $.ajax({
      url: $(this).attr('href'),
      type: 'POST',
      dataType: 'json',
      success: function(result){
        $.bootstrapGrowl(result.message, {type: result.error ? 'error' : 'success'});
        $.fn.yiiGridView.update(id);
      }
    })
    return false;
  });

  $('#content').on('click', '.sendmail', function(){
    var id = $(this).closest('.table').attr('id');
    if(!confirm('This action cannot be undone. Are you sure you want to continue?')) {
      return false;
    }

    $.ajax({
      url: $(this).attr('href'),
      type: 'POST',
      dataType: 'json',
      success: function(result){
        $.bootstrapGrowl(result.message, {type: result.error ? 'error' : 'success'});
        $.fn.yiiGridView.update(id);
      }
    })
    return false;
  });

  $('#content').on('click', '.note-button', function(){
    var url = $(this).attr('href');

    $('#transaction-note-modal .modal-body').load(url, function(){
      $('#transaction-note-modal').modal();
    });

    return false;
  });

  $('#content').on('submit', '#note-form', function(){
    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: {
        'Transaction[note]' : $('#Transaction_note').val()
      },
      complete: function(){
        $('#transaction-note-modal').modal('hide');
        $.fn.yiiGridView.update('transaction-grid');
      }
    })
    return false;
  });

});