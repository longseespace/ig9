jQuery(document).ready(function($) {
  
  if ($.fn.redactor) {
    $('.update-page .redactor').redactor({
      imageUpload: '/projectupdate/upload',
      autoresize: false,
      minHeight: 200
    });
  }

  $('#prjv-left')
    .on('click', '.button-add-comment', function (e) {
      e.preventDefault();
      $(this).siblings('.editor').slideToggle();
    })
    .on('click', 'input.btn-cancel', function (e) {
      $(this).parents('.editor').slideUp();
    })
    .on('click', 'a.edit', function (e) {
      e.preventDefault();
      $(this).parents('.actions').siblings('.content').toggle().siblings('.editor').toggle();
    })
    .on('click', 'input.cancel', function (e) {
      $(this).parents('.editor').hide().siblings('.content').show();
    })
    .on('click', 'a.delete', function (e) {
      e.preventDefault();
      if (!confirm('Are you sure want to delete this post?')) {
        return false;
      }
      var $this = $(this);

      $.ajax({
        url: $this.attr('href'),
        type: 'POST',
        success: function () {
          $this.parents('.backer').slideUp(function () {
            $(this).remove();
          });
        }
      })
    })
    .on('click', 'input.btn-primary', function (e) {
      var $form = $(this).parents('form');
      if ($form.hasClass('new')) {
        return true;
      }

      e.preventDefault();
      var $spinner = $form.find('.spinner');

      $.ajax({
        url: $form.attr('action'),
        type: 'POST',
        data: $form.serialize(),
        beforeSend: function () {
          $spinner.show();
        },
        complete: function () {
          $spinner.hide();
        },
        success: function () {
          $form
              .parents('.editor').hide()
              .siblings('.content').html($form.find('textarea').val().replace(/\n/g, '<br>')).show()
              .siblings('.title').text($form.find('.input-text').val());
        }
      })
    });
  
});