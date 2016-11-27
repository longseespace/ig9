<?php
/**
 * Author: Long Doan
 * Date: 5/15/13 12:10 PM
 */

?>

<?php if (empty($message)) : ?>

<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-39312929-1']);
  _gaq.push(['_setDomainName', 'ig9.vn']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

  if (ig9.transaction) {

    var order = ig9.transaction;
    _gaq.push(['_addTrans',
               order.id,           // order ID - required
               'ig9', // affiliation or store name
               order.amount,          // total - required
               '0',           // tax
               '0',          // shipping
               order.city,       // city
               '',     // state or province
               'VN'             // country
    ]);

    _gaq.push(['_addItem',
               order.id,           // order ID - necessary to associate item with transaction
               order.reward_id,           // SKU/code - required
               order.reward_amount,        // product name
               '',   // category or variation
               order.reward_amount,          // unit price - required
               1               // quantity - required
    ]);

    _gaq.push(['_trackTrans']);
  }

  window.onload = function () {
    var s = 10;
    var t = setInterval(function () {
      if (s === 0) {
        clearInterval(t);document.getElementById('h').innerHTML = 'DONE !!!';
        window.open('','_parent','');
        window.close();
        return;
      }
      document.getElementById('h').innerHTML = 'Remove in ' + s--;
    }, 1000);
  }
</script>
<h1 id="h">Remove in 10</h1>
<h2>(Trong luc nay ngoi lam viec khac di =.=)</h2>

<?php else : ?>

<h2><?php echo $message ?></h2>

<?php endif; ?>