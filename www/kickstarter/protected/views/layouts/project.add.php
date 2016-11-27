<?php /* @var $this Controller */
  $baseUrl = $this->assetsUrl;
  $cs = Yii::app()->clientScript;
  $ac = Yii::app()->assetCompiler;

  $cs->registerCssFile($baseUrl."/css/style.css");
  $cs->registerCssFile($baseUrl."/css/bootstrap.css");
  $cs->registerCssFile($baseUrl."/css/select2.css");
  $cs->registerCssFile($baseUrl."/css/bootstrap.datepicker.css");

  $cs->registerCoreScript('jquery');
  $cs->registerScriptFile($baseUrl."/js/core/modernizr-2.5.3.min.js");
  $cs->registerScriptFile($baseUrl."/js/core/bootstrap.min.js");
  $cs->registerScriptFile($baseUrl."/js/core/select2.min.js");
  $cs->registerScriptFile($baseUrl."/js/core/bootstrap.datepicker.js");
  $cs->registerScriptFile($baseUrl."/js/core/fileinput.js");
  $cs->registerScriptFile($baseUrl."/js/core/tiny_mce/tiny_mce.js");

  $ac->registerAssetGroup(array('script.js', 'plugins.js', 'project.add.js', 'general.less', 'project.less'), $baseUrl);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="language" content="en" />
  <meta name="viewport" content="width=device-width">

  <!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600&subset=latin,vietnamese' rel='stylesheet' type='text/css'> -->
  <!--[if lt IE 8]>
  <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/css/ie.css" media="screen, projection" />
  <![endif]-->


  <title><?php echo CHtml::encode($this->pageTitle); ?></title>
  <?php if (YII_DEBUG): ?>
    <script type="text/javascript"> (less = less || {}).env = 'development';</script>
  <?php endif ?>
</head>

<body id="<?php echo $this->uniqueid."-".$this->action->id;?>">
<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
    chromium.org/developers/how-tos/chrome-frame-getting-started -->
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
<header>
  <?php $this->renderPartial('//project/topbar');?>
</header>

<?php $this->renderPartial('//project/nav') ?>

<!--    Main content-->
<div role="main">
  <?php echo $content; ?>
</div>


  <?php
    if(Yii::app()->user->isAdmin()) {
      Yii::app()->translate->renderMissingTranslationsEditor(array('app'));
    }
  ?>

</body>
</html>
