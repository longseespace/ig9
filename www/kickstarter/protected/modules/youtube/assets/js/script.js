$(document).ready(function(){
  // wait for other implement run
  setTimeout(function(){
    var $object;
    var swfu;
    var FLAG;
    var iframe;
    function onSuccess(id){
      $(yconfig.targetSelector).val(id);
      if(!iframe){
        iframe = document.getElementById('youtube-preview') || document.createElement('iframe');
        iframe.id = 'youtube-preview';
        iframe.height = 254;
        iframe.width = 450;
        $('#frm').prepend(iframe);
      }
      iframe.src = 'http://www.youtube.com/embed/' + id;
      repaint(true);
    }

    function onError(message){
      repaint(false);
    }

    function repaint(success){
      renewToken();
      $object.addClass(yconfig.buttonClass);
      $("#youtube-progress-bar").css('width', "0%");
      if(success){
        $('#frm .customfile-button').html('Re-select').removeClass('cancel');
        $('#frm .customfile-feedback').html('Success');
      }else{
        $('#frm .customfile-button').html('Browse').removeClass('cancel');
        $('#frm .customfile-feedback').html('No file selected...');
      }
    }

    function renewToken(){
      $.ajax({
        url : '/youtube/default/token',
        data : {title:yconfig.videoTitle,descrition:yconfig.videoDescription},
        dataType : 'json',
        type : 'post',
        success : function(data){
          swfu.setPostParams({token:data.token});
          swfu.setUploadURL(data.postUrl);
          yconfig.developerTag = data.developerTag;
        }
      });
    }

    function onProgress(complete, total){
      $("#youtube-progress-bar").css('width', complete/total*100 + "%");
    }

    if(swfobject.hasFlashPlayerVersion("10")) {
      // use flash swfupload player
      var settings = {
        flash_url : yconfig.assetsUrl + '/swfupload.swf',
        upload_url: yconfig.postUrl,
        post_params: {token : yconfig.token},
        file_size_limit : "500 MB",
        file_types : "*.*",
        file_types_description : "All Files",
        file_upload_limit : 100,
        file_queue_limit : 0,
        file_post_name :'file',
        debug: false,
        button_window_mode: "transparent",
        button_placeholder_id: "youtube-file",
        button_text: '&nbsp;',
        button_class: yconfig.buttonClass,
        file_queued_handler : function(file) {
          $('#frm .customfile-feedback').html(file.name);
          $('#frm .customfile-button').html('Cancel').addClass('cancel');
          $object = $('object.' + yconfig.buttonClass).removeClass(yconfig.buttonClass);
          doSubmit();
        },
        upload_error_handler: function(file, error, message){
          // is http error, check with dev tag
          if(error === -200){
            $.getJSON('/youtube/default/check', {tag : yconfig.developerTag}, function(data){
              if(data && data.id){
                onSuccess(data.id);
              }else{
                onError('Upload failed');
              }
            });
          }else{
            onError(message);
          }
        },
        upload_success_handler : function(file, serverData, receivedResponse){

          var data;
          if(serverData){
            data = JSON.parse(serverData);
          }

          if(data && data.status === "200"){
            onSuccess(data.id);
          }else{
            onError('Youtube server return with code: ' + data.status);
          }
        },
        upload_progress_handler : function(file, complete, total){
          onProgress(complete, total);
        }
      };

      swfu = new SWFUpload(settings);

      function doSubmit(){
        try{
          swfu.startUpload();
        }catch(e){
          console.error(e);
        }
      }
    } else {
      // use jquery.form
    }

    $('#frm .customfile-button').click(function(){
      if($(this).hasClass('cancel')){
        swfu.cancelUpload();
        repaint(true);
      }
    });
  }, 0);
});