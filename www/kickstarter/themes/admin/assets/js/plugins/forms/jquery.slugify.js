;(function($) {
  
  $.fn.slugify = function(options) {
    var default_opts = {
      target : "#slug"
    }
    
    var opts = $.extend({}, default_opts, options);
    
    $(this).on("keyup keydown blur focus", function(){
      var name = $(this).val();
      var slug = name.toLowerCase() // change everything to lowercase
                .replace(/\u0111/g, 'd'); // small hack :-)
          slug = UNorm.nfd(slug)
                .replace(/^\s+|\s+$/g, "") // trim leading and trailing spaces
                .replace(/[_|\s]+/g, "-") // change all spaces and underscores to a hyphen
                .replace(/[^a-z0-9-]+/g, "") // remove all non-alphanumeric characters except the hyphen
                .replace(/[-]+/g, "-") // replace multiple instances of the hyphen with a single instance
                .replace(/^-+|-+$/g, ""); // trim leading and trailing hyphens
      $(opts.target).val(slug);
    })
	}
})(jQuery);