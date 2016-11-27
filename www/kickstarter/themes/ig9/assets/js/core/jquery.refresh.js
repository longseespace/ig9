(function( $ ){

  $.fn.refresh = function() {

    return this.each(function() {

      var $this = $(this);
      var random = new Date().getTime();
      var originalSrc = $this.data('src') || $this.attr('src');

      $this.data('src', originalSrc);

      $this.attr('src', originalSrc + '?' + random);
    });

  };
})( jQuery );