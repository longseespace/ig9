jQuery(function ($) {
  $('#close-button').on('click', function(e){
    e.preventDefault();

    $('#notification-top').slideUp(100, function(){
      $.cookie('notid', $(this).data('id'));
      $(this).remove();
    });
  })
})