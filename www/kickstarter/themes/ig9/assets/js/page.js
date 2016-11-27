/**
 * Author: Long Doan
 * Date: 9/12/12 11:16 AM
 */

jQuery(function ($) {
  $('a[href=#top]').click(function (e) {
    e.preventDefault();
    $.scrollTo(0, 'normal');
  })

  $('li.anchor a').click(function (e) {
    e.preventDefault();
    $.scrollTo($(this).attr('href'), 'normal', {offset: -10});
  })

  $('a.anchor.current').siblings('.subcat-list').find('a').click(function (e) {
    e.preventDefault();
    $.scrollTo('#' + $(this).attr('data'), 'normal');
  })

  $('#sidebar').fuckingscroll();
})