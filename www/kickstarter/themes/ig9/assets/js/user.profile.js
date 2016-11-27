(function(window, $){
  $(document).ready(function(){

    $('.user-profile-delete').on('click', function(){
      var $this = $(this);
      if(confirm('Are you sure to delete this project?')){
        $.post($this.attr('href'), function(){
          $this.parent().parent().remove();
        });
      }
      return false;
    });

    $('#User_avatar').change(function(e){
      var $this = $(this);
      if ($this.val().length) {
        $('#upload').removeClass('disabled').removeAttr('disabled');
      } else {
        $('#upload').addClass('disabled').attr('disabled', 'disabled');
      }
    })

    if ($.fn.refresh) $('#avatarModal img, #avatar img, .refresh').refresh();

    if ($.Jcrop) {
      var jcrop_api;

      $('#avatarcrop').Jcrop({
        onSelect: function(c){
          $('#avatarcrop').data('cord', c);
          $('#avatarModal .btn-primary').removeClass('disabled');
        },
        onChange: function(c){
          $('#avatarcrop').data('cord', c);
          $('#avatarModal .btn-primary').removeClass('disabled');
        },
        onRelease: function(){
          $('#avatarModal .btn-primary').addClass('disabled');
        },
        bgFade: true,
        bgOpacity: .3,
        setSelect: [ 0, 0, 500, 500 ],
        aspectRatio: 1
      },function(){
        jcrop_api = this;
      });

      $('#avatarModal .crop').click(function(e){
        e.preventDefault();

        var $this = $(this);
        var $modal = $('#avatarModal');

        if ($this.hasClass('disabled')) {
          return false;
        };

        jQuery.ajax({
          url: '/user/profile/crop',
          type: 'POST',
          dataType: 'json',
          data: $('#avatarcrop').data('cord'),
          beforeSend: function(xhr, settings){
            $('.loading', $modal).show();
          },
          complete: function(xhr, textStatus) {
            $('.loading', $modal).hide();
          },
          success: function(data, textStatus, xhr) {
            $('#avatarModal').modal('hide');
            $('#avatar img, .refresh').refresh();
          },
          error: function(xhr, textStatus, errorThrown) {
            //called when there is an error
          }
        });
        
      })

    };

    $('#profile-form').submit(function(e){
      var $form = $(this);
      if (!$('#upload').hasClass('disabled')) {
        $('<input>', { type : 'hidden', name : 'needcrop', value : true }).appendTo($form);
      };

      return true;
    })

    if (ig9.needcrop) {
      $('#avatarModal').modal('show');
    };

    $('#avatarModal').on('shown', function(){
      $('body').addClass('no-scroll');
    }).on('hidden', function(){
      $('body').removeClass('no-scroll');
    })
  });
})(window, jQuery);