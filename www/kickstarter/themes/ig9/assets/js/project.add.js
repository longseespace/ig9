/**
* Script for project adding page
*/

jQuery(window).load(function(){
  /*  The Form  */
  $('form').each(function(){
    if ($(this).data('settings') !== undefined) {
      $(this).data('settings').afterValidate = function($form, data, hasError){
        if (hasError) {
          for (var field in data) break;
          $('#'+field, $form).focus();

          $(".error-summary ul", $form).html('');

          for (var field in data) {
            $('<li>').html(data[field][0]).appendTo($(".error-summary ul", $form));
          }
          $(".error-summary", $form).removeClass('hidden');
          return false;
        } else {
          return true;
        }
      };
    }
  });

});

jQuery(document).ready(function($) {

  /*  Submitting Form  */
  $('#project-basics a#next, #project-story a#next, #project-aboutyou a#next').click(function(e){
    e.preventDefault();
    $("#theform").submit();
  });

  /*  For story tab, where have 2 forms */
  $('#project-story #theform').on('submit', function(){
    var videoUrl = $('#Project_videoUrl').val();
    if(videoUrl && videoUrl.length){
      $('#project-videoUrl').val(videoUrl);
      $('#project-videoUrl').removeAttr('disabled');
    }

    var videoId = $('#project-video').val();
    if(videoId && videoId.length){
      $('#project-video').removeAttr('disabled');
    }
  });

  /*  Topbar Scroll  */
  var $nav = $('#project-edit-nav-wrap');
  $nav.data('fixed', false);

  $(window).scroll(function(){
    var scrollTop = $(window).scrollTop();
    if (scrollTop >= 58) {
      if ($nav.data('fixed') === true) {
        return false;
      }
      $nav.css({ position: 'fixed', top: 58 - scrollTop }).clearQueue().animate({ top : 0 }, 200).data('fixed', true);
    } else {
      $nav.css({ position: 'static', top: 'auto', bottom: 'auto' }).data('fixed', false);
    }
  });

  $(window).trigger('scroll');

  /*  Guidelines  */
  $('#start').click(function(e){
    e.preventDefault();
    if ($('#guidelines_accept').attr('checked') !== undefined) {
      $('#continue').submit();
    }
  });

  if (window.File && window.FileReader && window.FileList && window.Blob) {
    $('#Project_image').change(function(e){
      var files = e.target.files; // FileList object
      if (!files.length) {
        return;
      }
      
      var file = files[0];
      if (file.size > 1000000) {
        alert('Max file size exceeded. Please choose another image.')
        $(this).val('');
        return false;
      };
    })
  }

  // $('#guidelines_accept').change(function(e){
  //   $(this).toggleClass('selected');
  //   $('#start').toggleClass('disabled');
  // });

  /*  Basics  */
  $('select:not(.noselect2)').select2({ width : 'element' });

  $('input.datepicker').datepicker({
    format: 'yyyy-mm-dd'
  }).on('changeDate', function(e){
    $(this).datepicker('hide');
  });

  $('.custom-file').customFileInput();

  $('input[name="duration"]').change(function(e){
    var type = $(this).val();
    if (type === 'duration') {
      $('#project-duration').val(30);
      $('#project-deadline').hide();
      $('.option.date-time').addClass('disabled');
    } else {
      $('#project-duration').val('');
      $('#project-deadline').show();
    }
  });

  /*  Rewards  */
  $('#rewards-panel').on('click', 'label.help > .icon', function(e){
    $(this).parent().siblings().children('.field-help-2').slideToggle('fast');
  });

  $('#rewards-panel').on('change', '.month', function(e){
    var $input = $(this).parent().siblings('input');
    var month = ~~$(this).val(); month = month < 10 ? '0' + month : month;
    var year = $input.data('year');
    $input.data('month', month);

    $input.val(year + '-' + month + '-09').change();
  });

  $('#rewards-panel').on('change', '.year', function(e){
    var $input = $(this).parent().siblings('input');
    var month = $input.data('month');
    var year = ~~$(this).val();
    $input.data('year', year);

    $input.val(year + '-' + month + '-09').change();
  })

  $('#rewards-panel').on('click', '.limit_checkbox', function(e){
    var $input = $(this).parent().siblings('input');
    $input.toggle().focus().val();
    if ($input.val() < 0) {
      $input.val(0);
    };
  })

  $('#rewards-panel').on('click', '.reward > form .action .submit', function(e){
    e.preventDefault();
    var $form = $(this).parents('form:first');
    var formData = $form.serializeArray();
    formData.push({ name: 'update', value: true });
    $.post($form.attr('action'), formData, function(data, textStatus, xhr) {
      data = $.parseJSON(data);
      if (data.error == true) {
        $(".error-summary ul", $form).html('');
        if (data.hasOwnProperty('message')) {
          $('<li>').html(data.message).appendTo($(".error-summary ul", $form));
        } else if (data.hasOwnProperty('messages')) {
          for (var field in data.messages) {
            $('<li>').html(data.messages[field][0]).appendTo($(".error-summary ul", $form));
          }
        };
        $(".error-summary", $form).removeClass('hidden');
      } else {
        $('.NS-projects-reward', $form).html(data.content).show();
        $('.reward-form', $form).hide();
      }
    });
  })

  $('#rewards-panel').on('click', '#theform .action .submit', function(e){
    e.preventDefault();
    var $form = $('#theform');
    var formData = $form.serializeArray();
    formData.push({ name: 'ajax-add', value: true });
    $.post($form.attr('action'), formData, function(data, textStatus, xhr) {
      data = $.parseJSON(data);
      console.log(data);
      if (data.error == true) {
        $(".error-summary ul", $form).html('');
        if (data.hasOwnProperty('message')) {
          $('<li>').html(data.message).appendTo($(".error-summary ul", $form));
        } else if (data.hasOwnProperty('messages')) {
          for (var field in data.messages) {
            $('<li>').html(data.messages[field][0]).appendTo($(".error-summary ul", $form));
          }
        };
        $(".error-summary", $form).removeClass('hidden');
      } else {
        $(data.content).appendTo('ol.rewards > li.reward');
        $('#theform').get(0).reset();
      }
    });
  })

  $('#rewards-panel').on('click', '.reward > form .action .cancel', function(e){
    e.preventDefault();
    var $field = $(this).parents('.field-wrapper:first');
    $('.NS-projects-reward', $field).show();
    $('.reward-form', $field).hide();
    $(".error-summary ul", $field).html('');
    $(".error-summary", $field).addClass('hidden');
  })

  // $('#reward_template input, #reward_template textarea').removeAttr('value');
  // $('#reward_template *').removeAttr('checked selected');

  $('#reward_template').on('click', '.action .cancel', function(e){
    e.preventDefault();
    // $('#reward_template input, #reward_template textarea').removeAttr('value');
    // $('#reward_template *').removeAttr('checked selected');

    $('#theform').get(0).reset();
    $('#reward_template').slideUp('fast');
  })

  $('#rewards-panel').on('click', '.edit-or-delete .edit.btn', function(e){
    e.preventDefault();
    var $field = $(this).parents('.field-wrapper:first');
    $('.NS-projects-reward', $field).hide();
    $('.reward-form', $field).show();
  })

  // Delete

  $('#rewards-panel').on('click', '.edit-or-delete .delete.btn', function(e){
    e.preventDefault();
    var reward_id = $(this).data('id');
    var $form = $(this).parents('form:first');
    $("#confirmModal").data('id', reward_id).modal();
  })

  $('#confirmModal .btn-danger').click(function(e){
    e.preventDefault();
    var $button = $(this);
    var buttonTitle = $button.html();
    var reward_id = $('#confirmModal').data('id');
    var $form = $('#reward-form-'+reward_id);

    $('#confirmModal').modal('hide');

    // Send ajax request
    $.post($form.attr('action'), { Reward: { id : reward_id }, delete : true }, function(data, textStatus, xhr) {
      data = $.parseJSON(data);
      if (data.error) {
        $(".error-summary ul", $form).html('<li>'+data.message+'</li>');
        $(".error-summary", $form).removeClass('hidden');
      } else {
        $form.slideUp('fast', function(){
          $form.remove();
        })
      }
    });

  })

  $('.add-another').click(function(e){
    e.preventDefault();
    var $form = $(".reward-form:visible");
    if ($form.length > 0) {
      $('input:first', $form).focus();
      $(".error-summary ul", $form).html('');
      $('<li>').html('Please finish this form first').appendTo($(".error-summary ul", $form));
      $(".error-summary", $form).removeClass('hidden');
    } else {
      $("#reward_template").slideDown('fast');
    }
  })

  /*  Tooltip  */
  $('.tt').tooltip()

  /*  TinyMCE  */
  // tinyMCE.init({
  //   mode : 'textareas',
  //   width: '400px',
  //   editor_selector: 'tinymce',
  //   theme : 'ribbon',
  //   // content_css : 'css/editor.css',
  //   plugins : 'bestandsbeheer,tabfocus,advimagescale,loremipsum,image_tools,embed,tableextras,style,table,inlinepopups,searchreplace,contextmenu,paste,wordcount,advlist,autosave',
  //   inlinepopups_skin : 'ribbon_popup',
  //   theme_ribbon_tab1 : { title : "Start",
  //     items : [
  //       ["justifyleft,justifycenter,justifyright,justifyfull",
  //        "bullist,numlist",
  //        "|",
  //        "bold,italic,underline",
  //        "outdent,indent"],
  //       ["paragraph", "heading1", "heading2", "heading3"],
  //       ["search", "|", "replace", "|", "removeformat"]]
  //   },
  //   theme_ribbon_tab2 : { title : "Insert",
  //       items : [["tabledraw"],
  //         ["embed"],
  //         ["link", "|", "unlink", "|", "anchor"],
  //         ["loremipsum", "|", "charmap", "|", "hr"]]
  //   },
  //   theme_ribbon_tab3 : {

  //   }
  // });



});