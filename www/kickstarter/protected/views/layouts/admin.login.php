<?php
$cs = Yii::app()->clientScript;
$baseUrl = $this->assetsUrl;

$cs->registerScriptFile($baseUrl.'/js/plugins/spinner/ui.spinner.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/spinner/jquery.mousewheel.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/charts/excanvas.min.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/charts/jquery.sparkline.min.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/uniform.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/jquery.cleditor.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/jquery.validationEngine-en.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/jquery.validationEngine.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/jquery.tagsinput.min.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/autogrowtextarea.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/jquery.maskedinput.min.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/jquery.dualListBox.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/jquery.inputlimiter.min.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/chosen.jquery.min.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/wizard/jquery.form.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/wizard/jquery.validate.min.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/wizard/jquery.form.wizard.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/uploader/plupload.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/uploader/plupload.html5.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/uploader/plupload.html4.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/uploader/jquery.plupload.queue.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/tables/datatable.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/tables/tablesort.min.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/tables/resizable.min.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/ui/jquery.tipsy.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/ui/jquery.collapsible.min.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/ui/jquery.prettyPhoto.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/ui/jquery.progress.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/ui/jquery.timeentry.min.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/ui/jquery.colorpicker.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/ui/jquery.jgrowl.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/ui/jquery.breadcrumbs.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/ui/jquery.sourcerer.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/calendar.min.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/elfinder.min.js');
$cs->registerScriptFile($baseUrl.'/js/custom.js');

$cs->registerCssFile($baseUrl.'/css/main/main.css');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
</head>

<body class="nobg loginPage">

<!-- Main content wrapper -->
<div class="loginWrapper">
  <div class="loginLogo"><?php echo CHtml::image($baseUrl.'/img/loginLogo.png') ?></div>
  <div class="widget">
    <div class="title"><?php echo CHtml::image($baseUrl.'/img/icons/dark/files.png', '', array('class' => "titleIcon")) ?><h6>Login panel</h6></div>
    <form action="" id="validate" class="form">
      <fieldset>
        <div class="formRow">
          <label for="login">Username:</label>
          <div class="loginInput"><input type="text" name="login" class="validate[required]" id="login" /></div>
          <div class="clear"></div>
        </div>
        
        <div class="formRow">
          <label for="pass">Password:</label>
          <div class="loginInput"><input type="password" name="password" class="validate[required]" id="pass" /></div>
          <div class="clear"></div>
        </div>
        
        <div class="loginControl">
          <div class="rememberMe"><input type="checkbox" id="remMe" name="remMe" /><label for="remMe">Remember me</label></div>
          <input type="submit" value="Log me in" class="dredB logMeIn" />
          <div class="clear"></div>
        </div>
      </fieldset>
    </form>
  </div>
</div>    

</body>
</html>