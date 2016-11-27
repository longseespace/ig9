(function( $ ){
  /**
   * Created a flexible element that follows the page while scrolling vertically, especially useful for long bar in short screen size.
   * Author: Long Doan
   * Date: 9/12/12 11:16 AM
   */
  $.fn.fuckingscroll = function() {

    return this.each(function() {

      var $this = $(this);
      var $window = $(window);
      var paddingTop = parseInt($this.css('padding-top'));
      var marginTop = parseInt($this.css('margin-top'));
      var lastPos = 0;                              //last scrolled position
      var absolute = false;                         //if the css position is absolute
      var origin = $this.offset().top + marginTop + paddingTop;              //original offset to top
      var diff = $this.height() - $window.height() > 0 ? $this.height() - $window.height() : 0; //the difference of the target to screen size
      var barrel = origin + diff;                   //the point where we should switch css position
      var started = false;                          //if we scrolled down over the target

      $window.keydown(function (e) { //Prevent bug when hit 'end' button
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code === 35 && $.scrollTo !== 'undefined') {
          $.scrollTo(99999, 'fast');
          e.preventDefault();
        }
      })

      $window.resize(function (e) {
        diff = $this.height() - $window.height() > 0 ? $this.height() - $window.height() : 0;
        barrel = origin + diff;
      })

      $window.scroll(function (e) {

        if (lastPos < $window.scrollTop()) { //scroll down

          if (!started) {
            if ($window.scrollTop() > origin + diff) { //start the plugin
              started = true;
              $this.css('position', 'fixed').css({
                top: -diff,
                paddingTop: 0,
                marginTop: 0
              });
            }
          } else {
            if ($window.scrollTop() > barrel) { //scrolled lower the bottom of the target
              if ($window.scrollTop() >= $('footer').offset().top - $this.height() + parseInt($this.parent().css('margin-bottom')) + diff - paddingTop) { //reached footer
                if (!absolute) {
                  absolute = true;
                  $this.css('position', 'absolute').css({
                    top: $('footer').offset().top - $this.height() - parseInt($this.parent().css('margin-bottom')) - origin - paddingTop,
                    paddingTop: 0,
                    marginTop: 0
                  });
                  barrel = $this.offset().top + diff;
                }
              } else {
                absolute = false;
                $this.css('position', 'fixed').css({
                  top: -diff,
                  paddingTop: 0,
                  marginTop: 0
                });
              }
            } else {
              if (!absolute) {  //in the middle, maintain the position
                absolute = true;
                $this.css('position', 'absolute').css({
                  top: $window.scrollTop() - origin,
                  paddingTop: 0,
                  marginTop: 0
                });
                barrel = $this.offset().top + diff;
              }
            }
          }

        } else {  //scroll up

          if ($window.scrollTop() > origin) { //in the middle

            if ($window.scrollTop() <= $this.offset().top) { //scrolled higher the top of the target
              $this.css('position', 'fixed').css({
                top: 0,
                paddingTop: 0,
                marginTop: 0
              });
              absolute = false;
            } else {
              if (!absolute) { //scrolling up from bottom of the target
                absolute = true;
                $this.css('position', 'absolute').css({
                  top: $window.scrollTop() - diff,
                  paddingTop: 0,
                  marginTop: 0
                });
                barrel = $this.offset().top + diff;
              }
            }
          } else { //back to top
            $this.css('position', 'static').css({
              paddingTop: paddingTop,
              marginTop: marginTop
            });
            absolute = false;
            started = false;
            barrel = origin + diff;
          }
        }

        lastPos = $window.scrollTop();
      })
    });

  };
})( jQuery );