<?php /* @var $this Controller */
	$baseUrl = $this->assetsUrl;
	$cs = Yii::app()->clientScript;

	$cs->registerCssFile($baseUrl."/css/style.css");
	$cs->registerCssFile($baseUrl."/css/bootstrap.css");
	$cs->registerCoreScript('jquery');
	$cs->registerScriptFile($baseUrl."/js/core/modernizr-2.5.3.min.js");
  $cs->registerScriptFile($baseUrl."/js/core/bootstrap.min.js");

  Yii::app()->assetCompiler->registerAssetGroup(array('general.less', 'script.js', 'plugins.js'), $baseUrl);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website# ignitevn: http://ogp.me/ns/fb/ignitevn#">
  <script>
    less = {env:'development'};
  </script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<meta name="viewport" content="width=device-width">

  <!-- Sorry about this :( -->
  <script type="text/javascript">
    /* <![CDATA[ */
    var <?php echo $this->jsNamespace ?> = <?php echo json_encode($this->jsVars) ?>;
    /* ]]> */

  </script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
  <?php if (YII_DEBUG): ?>
    <script type="text/javascript"> (less = less || {}).env = 'development';</script>
  <?php endif ?>

  <?php echo $this->clips['fbmeta']; ?>
  <meta property="fb:app_id" content="420094461372089" />
</head>

<body class="<?php echo $this->uniqueid;?>" id="<?php echo $this->uniqueid."-".$this->action->id;?>">
<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
<header>
 <?php $this->renderPartial('//common/topbar');?>
</header>

<?php
  if ($this->isHome) {
    //$this->renderPartial('//common/slider');
  } else {
    //echo "<div class='dummy-block'></div>";
  }

  if ($this->id === 'profile' && is_object($this->module) && $this->module->getName() === 'user') {
    $this->renderPartial('//common/user-profile');
  }

  $types = '';
  if (is_object($this->module)) {
    $types .= ' m-' . $this->module->getName();
  }
  $types .= ' c-' . $this->id . ' a-' . $this->action->id;

?>

<!--	Main content    -->
<div role="main" class="wrapper<?php echo $types ?>">
  <?php echo $content; ?>
</div>

<footer>
<?php $this->renderPartial('//common/footer');?>
</footer>

<?php // $this->renderPartial('//common/feedback');?>

<?php
  if(Yii::app()->user->isAdmin()) {
    Yii::app()->translate->renderMissingTranslationsEditor(array('app'));
  }
?>

<?php if(!property_exists($this, 'gaTrack') || $this->gaTrack): ?>
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

</script>

<?php endif; ?>
</body>
</html>
