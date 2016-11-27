var app = {};

jQuery(document).ready(function($) {

  var state = {};

  if (history.pushState) {

    $('.content').on('click', '.pagination li > a', function(e){
      e.preventDefault();
      var page = $(this).attr('href').split('/').reverse()[0];
      var uri = '/'+ig9.controller+'/'+ig9.action+'/'+page;
      if (page === 'yw1') {
        uri = '/'+ig9.controller;
      }
      
      history.pushState(state, "", uri);
    })

  };

  if (location.pathname.indexOf('/message/draft') === 0) {
    app.mode = 'draft';
  } else if (location.pathname.indexOf('/message/inbox') === 0 || (location.pathname == '/message')) {
    app.mode = 'inbox';
  } else if (location.pathname.indexOf('/message/sent') === 0) {
    app.mode = 'sent';
  } else if (location.pathname.indexOf('/message/trash') === 0) {
    app.mode = 'trash';
  } else {
    app.mode = 'unknown';
  }

  app.notify = humane.create({ timeout: 3000, baseCls: 'humane-ig9' });
  app.info = app.notify.spawn()
  app.error = app.notify.spawn({ addnCls: 'humane-ig9-error', timeout: 0, clickToClose: true })
  app.loading = app.notify.spawn({ timeout: 0 })

  if (ig9 && ig9.notfound) {
    app.error('Error: Message not found');
  };

  // update inbox unread count
  app.unreadCount = function(change){
    var text = $('a[href="/message/inbox"] span').text();
    var matches = text.match(/\s\(([0-9]+)\)/);

    if (matches) {
      var oldCount = ~~matches[1];
      var label = text.replace(matches[0], '');
    } else {
      var oldCount = 0;
      var label = text;
    }

    // getter
    if (!change) {
      return oldCount;
    } else { // setter
      var count = oldCount + change;
      var newLabel = count > 0 ? label + ' (' + count + ')' : label;

      $('a[href="/message/inbox"] span').text(newLabel);
      if (document.title.indexOf(label) === 0) {
        document.title = newLabel;
      };
    }
  }

  app.refresh = function(){
    $.fn.yiiGridView.update("yw1");
  }

  app.showLoading = function(){
    $('#yw1').addClass('grid-view-loading');

    app.loading('Processing...');
  }

  app.hideLoading = function(){
    $('#yw1').removeClass('grid-view-loading');
    app.notify.remove();
  }

  app.markAsRead = function(data){
    jQuery.ajax({
      url: '/message/inbox/markasread',
      type: 'POST',
      data: data,
      dataType: 'json',
      beforeSend: function(){
        // app.showLoading();
      },
      complete: function(xhr, textStatus) {
        // app.hideLoading();
      },
      success: function(data, textStatus, xhr) {
        if (data != '0') {
          for (var i = data.length - 1; i >= 0; i--) {
            $('.message-'+data[i]).removeClass('unread');
          };
        } else {
          app.error('Error! Please try again');
        }
      },
      error: function(xhr, textStatus, errorThrown) {
        //called when there is an error
        app.error('Error! Please try again');
      }
    });
  }

  app.markAsUnread = function(data){
    jQuery.ajax({
      url: '/message/inbox/markasunread',
      type: 'POST',
      dataType: 'json',
      data: data,
      beforeSend: function(){
        // app.showLoading();
      },
      complete: function(xhr, textStatus) {
        // app.hideLoading();
      },
      success: function(data, textStatus, xhr) {
        if (data != '0') {
          for (var i = data.length - 1; i >= 0; i--) {
            $('.message-'+data[i]).addClass('unread');
          };
        } else {
          app.error('Error! Please try again');
        }
      },
      error: function(xhr, textStatus, errorThrown) {
        //called when there is an error
        app.error('Error! Please try again');
      }
    });
  }

  app.delete = function(data){
    jQuery.ajax({
      url: '/message/inbox/delete',
      type: 'POST',
      dataType: 'json',
      data: data,
      beforeSend: function(){
        app.showLoading();
      },
      complete: function(xhr, textStatus) {
        app.hideLoading();
      },
      success: function(data, textStatus, xhr) {
        if (data) {
          if (data != '0') {
            for (var i = data.length - 1; i >= 0; i--) {
              $('.message-'+data[i]).remove();
            };
          }

          app.refresh();
          app.info('Message removed');
        } else {
          app.error('Error! Please try again');
        }
      },
      error: function(xhr, textStatus, errorThrown) {
        //called when there is an error
        app.error('Error! Please try again');
      }
    });
  }

  app.send = function(data){
    jQuery.ajax({
      url: '/message/inbox/compose',
      type: 'POST',
      // dataType: 'json',
      data: data,
      beforeSend: function(){
        app.showLoading();
      },
      complete: function(xhr, textStatus) {
        app.hideLoading();
      },
      success: function(data, textStatus, xhr) {
        if (data) {
          if (data != '0') {
            $('#message-detail').hide();
            $('#message-list').show();
            $('#message-compose').hide();

            $('#receiver, #subject, #Message_body, #message-id').val('');
            $('#Message_body').setCode('');
            app.info('Message sent');

            if (history.pushState) {
              history.pushState(state, "", '/message/inbox');
            };
          } else {
            app.error('Error! Please try again');
          }

          app.refresh();
        } else {
          app.error('Error! Please try again');
        }
      },
      error: function(xhr, textStatus, errorThrown) {
        //called when there is an error
        app.error('Error! Please try again');
      }
    });
  }

  app.save = function(data){
    jQuery.ajax({
      url: '/message/inbox/save',
      type: 'POST',
      // dataType: 'json',
      data: data,
      beforeSend: function(){
        app.showLoading();
      },
      complete: function(xhr, textStatus) {
        app.hideLoading();
      },
      success: function(data, textStatus, xhr) {
        if (data) {
          if (data != '0') {
            $('#message-id').val(data);
            app.info('Message saved');
          } else {
            app.error('Error! Please try again');
          }

          app.refresh();
          
        } else {
          app.error('Error! Please try again');
        }
      },
      error: function(xhr, textStatus, errorThrown) {
        //called when there is an error
        app.error('Error! Please try again');
      }
    });
  }

  /* Actions */

  $('.btn-refresh').on('click', function(){
    app.refresh();
  })
  
  $('.btn-markasread').click(function(e){
    $this = $(this);
    if ($this.hasClass('disabled')) {
      return false;
    };

    app.markAsRead($('#theform').serialize());
  })

  $('.btn-markasunread').click(function(e){
    $this = $(this);
    if ($this.hasClass('disabled')) {
      return false;
    };

    app.markAsUnread($('#theform').serialize());
  })

  $('.btn-delete').click(function(e){
    $this = $(this);
    if ($this.hasClass('disabled')) {
      return false;
    };

    app.delete($('#theform').serialize());
  })

  $('.btn-markasunread-single').click(function(){
    app.markAsUnread({ 'message_ids[]' : $('#message-detail').data('messageId') });
    $('#message-detail').hide();
    $('#message-list').show();

    if (history.pushState) {
      history.go(-1);
    };
  });

  $('.btn-delete-single').click(function(){
    app.delete({ 'message_ids[]' : $('#message-detail').data('messageId') });
    $('#message-detail').hide();
    $('#message-list').show();

    if (history.pushState) {
      history.go(-1);
    };
  });

  /* Update paging info */
  ig9.afterAjaxUpdate = function(id, data){
    var info = $('.original-summary-text').text().split('|');
    if (info.length === 3) {
      $('#summary-text').html('<strong>'+info[0]+'</strong>-<strong>'+info[1]+'</strong> of <strong>'+info[2]+'</strong>');  
    };

    if (data) {
      var inboxLabel = $('a[href="/message/inbox"]', data).html();
      $('a[href="/message/inbox"]').html(inboxLabel);
    };
  }

  ig9.afterAjaxUpdate();

  /* Select messages */
  var selectMessages = function(){
    if ($('#select').attr('checked') === 'checked') {
      $('.message-checkbox').attr('checked', 'checked');
      $('.btn-markasread, .btn-markasunread, .btn-delete', $('#message-list')).removeClass('disabled');
    } else {
      $('.message-checkbox').removeAttr('checked');
      $('.btn-markasread, .btn-markasunread, .btn-delete', $('#message-list')).addClass('disabled');
    }
  }

  $('.content').on('click', '.btn-select', function(e){
    $('#select').toggleAttr('checked');
    selectMessages();
  })

  $('.content').on('click', '#select', function(e){
    selectMessages();
    e.stopPropagation();
  })

  $('.content').on('change', '.message-checkbox', function(e){
    if ($('#theform').serializeArray().length > 0) {
      $('.btn-markasread, .btn-markasunread, .btn-delete', $('#message-list')).removeClass('disabled');
    } else {
      $('.btn-markasread, .btn-markasunread, .btn-delete', $('#message-list')).addClass('disabled');
    }
  })

  /* Open message */

  $('#message-list').on('click', '.message-checkbox, td:first-child', function(e){
    e.stopPropagation();
  })

  $('#message-list').on('click', 'tr', function(){
    $('#message-list').hide();

    var $tr = $(this);
    var messageId = $('.message-checkbox', $tr).val();
    var messageSubject = $('.message-subject', $tr).text();
    var messageSender = $('.sender', $tr).text();
    var messageTime = $('.time', $tr).html().replace('<br>', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
    var messageBody = $('.message-body-full', $tr).html();

    if ($tr.hasClass('unread')) {
      app.markAsRead({ 'message_ids[]' : messageId });
      app.unreadCount(-1);
    };

    if (app.mode === 'draft') {
      $('#subject').val(messageSubject);
      $('#Message_body').setCode(messageBody);
      $('#message-id').val(messageId);

      $('#message-detail').hide();
      $('#message-compose').show();

      if (history.pushState) {
        history.pushState(state, "", $(this).attr('href'));  
      };
    } else {
      $('#message-subject').text(messageSubject);
      $('#message-sender').text(messageSender);
      $('#message-time').html(messageTime);
      $('#message-body').html(messageBody);
      $('#message-detail').data('messageId', messageId);

      $('#reply-subject').val('Re: ' + messageSubject);
      $('#reply-receiver').val(messageSender);
      $('#reply-editor').setCode('<p>&nbsp;</p><blockquote>' + messageBody + '</blockquote>');

      $('#message-detail').show();

      document.title = messageSubject;
      if (history.pushState) {
        history.pushState(state, "", "/message/inbox/view/id/"+messageId);  
      };
    }

    app.hideLoading();

  })

  $('.btn-back').click(function(){
    $('#message-detail').hide();
    $('#message-list').show();
    $('#message-compose').hide();

    if (history.pushState) {
      history.go(-1);
    };
  })

  $('#btn-compose').click(function(e){
    e.preventDefault();

    $('#receiver, #subject, #Message_body, #message-id').val('');
    $('#Message_body').setCode('');

    $('#message-detail').hide();
    $('#message-list').hide();
    $('#message-compose').show();

    if (history.pushState) {
      history.pushState(state, "", $(this).attr('href'));  
    };
  })

  $('.sidebar .nav a').click(function(e){
    e.preventDefault();

    var $this = $(this);
    var ajaxUrl = $this.attr('href') + '/all/ajax/yw1?ajax=yw1';
    $('#yw1 .keys').attr('title', ajaxUrl);
    app.refresh();

    $('.sidebar .nav .active').removeClass('active');
    $this.addClass('active');
    $this.parent().addClass('active');

    $('#message-detail').hide();
    $('#message-compose').hide();
    $('#message-list').show();

    document.title = $('span', $this).text();
    if (history.pushState) {
      history.pushState(state, "", $this.attr('href'));  
    };

    if ($this.attr('href').indexOf('/message/draft') === 0) {
      app.mode = 'draft';
    } else if ($this.attr('href').indexOf('/message/inbox') === 0) {
      app.mode = 'inbox';
    } else if ($this.attr('href').indexOf('/message/sent') === 0) {
      app.mode = 'sent';
    } else if ($this.attr('href').indexOf('/message/trash') === 0) {
      app.mode = 'trash';
    } else {
      app.mode = 'unknown';
    }
  })

  /* Reply Editor */
  $('#reply-editor').redactor({
    // buttons : ['bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'link'],
    'buttons' : ['formatting', '|', 'bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'image', 'video', 'table', 'link', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'horizontalrule'],
    focus : false
  });

  $('#editor-placeholder a').on('click', function(e){
    e.preventDefault();

    $('#editor-wrapper').show();
    $('#editor-placeholder').hide();
  })

  $('#editor-placeholder').on('click', function(){
    $('#editor-wrapper').show();
    $('#editor-placeholder').hide();
  })

  $('.btn-reply-send').click(function(){
    if ($.trim($('#reply-subject').val()) == '') {
      app.error('Subject are required!');
      return false;
    };
    app.send($('#reply-form').serialize());
  })

  $('.btn-reply-save').click(function(){
    app.save($('#reply-form').serialize());
  })

  $('.btn-reply-discard').on('click', function(){
    $('#editor-wrapper').hide();
    $('#editor-placeholder').show();
  })

  /* Compose */
  $('.btn-send').click(function(){
    if ($.trim($('#receiver').val()) == '' || $.trim($('#subject').val()) == '') {
      app.error('Receiver Name and Subject are required!');
      return false;
    };
    app.send($('#compose-form').serialize());
  })

  $('.btn-save').click(function(){
    app.save($('#compose-form').serialize());
  })

  $('.btn-discard').click(function(){
    $('#receiver, #subject, #Message_body, #message-id').val('');
    $('#Message_body').setCode('');
  })

});
