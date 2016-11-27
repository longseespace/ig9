<?php
$cs = Yii::app()->clientScript;
$cs->defaultScriptFilePosition = CClientScript::POS_HEAD;
$baseUrl = $this->assetsUrl;

// $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.min.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/jquery-ui.min.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/bootstrap.js');

$cs->registerScriptFile($baseUrl.'/js/plugins/spinner/ui.spinner.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/spinner/jquery.mousewheel.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/charts/excanvas.min.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/charts/jquery.sparkline.min.js');
//$cs->registerScriptFile($baseUrl.'/js/plugins/forms/uniform.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/jquery.cleditor.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/jquery.validationEngine-en.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/jquery.validationEngine.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/jquery.tagsinput.min.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/autogrowtextarea.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/jquery.maskedinput.min.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/jquery.dualListBox.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/jquery.inputlimiter.min.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/unorm.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/forms/jquery.slugify.js');
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
$cs->registerScriptFile($baseUrl.'/js/plugins/tiny_mce/tiny_mce.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/tiny_mce/jquery.tinymce.js');
$cs->registerScriptFile($baseUrl.'/js/custom.js');

$cs->registerCssFile($baseUrl.'/css/main/bootstrap.css');
$cs->registerCssFile($baseUrl.'/css/main/main.css');
$cs->registerScriptFile($baseUrl.'/js/admin/script.js');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />

  <!-- Sorry about this :( -->
<script type="text/javascript">
  /* <![CDATA[ */
  var <?php echo $this->jsNamespace ?> = <?php echo json_encode($this->jsVars) ?>;
  /* ]]> */
</script>

<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<!-- Left side content -->
<div id="leftSide">
  <div class="logo">
    <a href="<?php echo $this->createUrl('/admin') ?>"><?php echo CHtml::image($baseUrl.'/img/logo.png', 'Admin Dashboard'); ?></a>
  </div>

<!--  <div class="sidebarSep mt0"></div>-->

  <!-- Search widget -->
<!--  <form action="" class="sidebarSearch">-->
<!--    <input type="text" name="search" placeholder="search..." id="ac" />-->
<!--    <input type="submit" value="" />-->
<!--  </form>-->

  <div class="sidebarSep"></div>

  <!-- Left navigation -->

  <?php
  $this->widget('application.widgets.Menu', array(
    'linkLabelWrapper' => 'span',
    'submenuHtmlOptions' => array('class' => 'sub'),
    'items' => array(
      // Important: you need to specify url as 'controller/action',
      // not just as 'controller' even if default acion is used.
      array(
        'label' => ___('Dashboard'),
        'url' => array('admin/dashboard'),
        'itemOptions' => array('class' => 'dash')
      ),
      array(
        'label' => ___('Project'),
        'url' => array('admin/project'),
        'itemOptions' => array('class' => 'tables'),
        'items' => array(
          array('label' => ___('All Projects'), 'url' => array('admin/project'), 'linkLabelWrapper' => null),
          array('label' => ___('Add New'), 'url' => array('admin/project/add'), 'linkLabelWrapper' => null),
        )
      ),
      array(
        'label' => ___('Transaction'),
        'url' => array('/admin/transaction'),
        'itemOptions' => array('class' => 'tables'),
        'items' => array(
          array('label' => ___('All Projects'), 'url' => array('admin/project'), 'linkLabelWrapper' => null),
          array('label' => ___('Add New'), 'url' => array('admin/project/add'), 'linkLabelWrapper' => null),
        )
      ),
      array(
        'label' => ___('Page'),
        'url' => array('admin/page'),
        'itemOptions' => array('class' => 'widgets'),
        'items' => array(
          array('label' => ___('All Page'), 'url' => array('admin/page'), 'linkLabelWrapper' => null),
          array('label' => ___('Add New'), 'url' => array('admin/page/add'), 'linkLabelWrapper' => null),
        )
      ),
      array(
        'label' => ___('News'),
        'url' => array('admin/post'),
        'itemOptions' => array('class' => 'widgets'),
        'items' => array(
          array('label' => ___('All Post'), 'url' => array('admin/post'), 'linkLabelWrapper' => null),
          array('label' => ___('Add New'), 'url' => array('admin/post/create'), 'linkLabelWrapper' => null),
        )
      ),
      array(
        'label' => ___('Subscriber'),
        'url' => array('admin/emailsubscriber'),
        'itemOptions' => array('class' => 'ui'),
        'items' => array(
          array('label' => ___('All Subscriber'), 'url' => array('admin/subscriber'), 'linkLabelWrapper' => null),
        )
      ),
      array(
        'label' => ___('User'),
        'url' => array('admin/user'),
        'itemOptions' => array('class' => 'ui'),
        'items' => array(
          array('label' => ___('All Users'), 'url' => array('admin/user'), 'linkLabelWrapper' => null),
          array('label' => ___('Add New'), 'url' => array('admin/user/add'), 'linkLabelWrapper' => null),
        )
      ),
      array(
        'label' => ___('File'),
        'url' => array('admin/file'),
        'itemOptions' => array('class' => 'files')
      )
    ),
    'htmlOptions' => array(
      'class' => 'nav',
    ),
  ));
  ?>

  <div class="sidebarSep"></div>

</div>


<!-- Right side -->
<div id="rightSide">

  <!-- Top fixed navigation -->
  <div class="topNav">
    <div class="wrapper">
      <div class="welcome"><span>Howdy, Eugene!</span></div>
      <div class="userNav">
        <ul>
          <li><a href="<?php echo $this->createUrl('admin/user/edit', array('id' => Yii::app()->user->id)); ?>" ><img src="<?php echo $baseUrl; ?>/img/icons/topnav/profile.png" alt="" /><span>Profile</span></a></li>
<!--          <li><a href="#" title=""><img src="--><?php //echo $baseUrl; ?><!--/img/icons/topnav/tasks.png" alt="" /><span>Tasks</span></a></li>-->
<!--          <li class="dd"><a title=""><img src="--><?php //echo $baseUrl; ?><!--/img/icons/topnav/messages.png" alt="" /><span>Messages</span><span class="numberTop">8</span></a>-->
<!--            <ul class="userDropdown">-->
<!--              <li><a href="#" title="" class="sAdd">new message</a></li>-->
<!--              <li><a href="#" title="" class="sInbox">inbox</a></li>-->
<!--              <li><a href="#" title="" class="sOutbox">outbox</a></li>-->
<!--              <li><a href="#" title="" class="sTrash">trash</a></li>-->
<!--            </ul>-->
<!--          </li>-->
<!--          <li><a href="#" title=""><img src="--><?php //echo $baseUrl; ?><!--/img/icons/topnav/settings.png" alt="" /><span>Settings</span></a></li>-->
          <li><a href="<?php echo $this->createUrl('/user/logout'); ?>"><img src="<?php echo $baseUrl; ?>/img/icons/topnav/logout.png" alt="" /><span>Logout</span></a></li>
        </ul>
      </div>
      <div class="clear"></div>
    </div>
  </div>

  <!-- Responsive header -->
  <div class="resp">
    <div class="respHead">
      <a href="<?php echo $this->createUrl('/admin') ?>"><?php echo CHtml::image($baseUrl.'/img/loginLogo.png', 'Admin Dashboard'); ?></a>
    </div>

    <div class="cLine"></div>
    <div class="smalldd">
      <span class="goTo"><img src="<?php echo $baseUrl; ?>/img/icons/light/home.png" alt="" />Dashboard</span>
      <ul class="smallDropdown">
        <li><a href="index.html" title=""><img src="<?php echo $baseUrl; ?>/img/icons/light/home.png" alt="" />Dashboard</a></li>
        <li><a href="charts.html" title=""><img src="<?php echo $baseUrl; ?>/img/icons/light/stats.png" alt="" />Statistics and charts</a></li>
        <li><a href="#" title="" class="exp"><img src="<?php echo $baseUrl; ?>/img/icons/light/pencil.png" alt="" />Forms stuff<strong>4</strong></a>
          <ul>
            <li><a href="forms.html" title="">Form elements</a></li>
            <li><a href="form_validation.html" title="">Validation</a></li>
            <li><a href="form_editor.html" title="">WYSIWYG and file uploader</a></li>
            <li class="last"><a href="form_wizards.html" title="">Wizards</a></li>
          </ul>
        </li>
        <li><a href="ui_elements.html" title=""><img src="<?php echo $baseUrl; ?>/img/icons/light/user.png" alt="" />Interface elements</a></li>
        <li><a href="tables.html" title="" class="exp"><img src="<?php echo $baseUrl; ?>/img/icons/light/frames.png" alt="" />Tables<strong>3</strong></a>
          <ul>
            <li><a href="table_static.html" title="">Static tables</a></li>
            <li><a href="table_dynamic.html" title="">Dynamic table</a></li>
            <li class="last"><a href="table_sortable_resizable.html" title="">Sortable &amp; resizable tables</a></li>
          </ul>
        </li>
        <li><a href="#" title="" class="exp"><img src="<?php echo $baseUrl; ?>/img/icons/light/fullscreen.png" alt="" />Widgets and grid<strong>2</strong></a>
          <ul>
            <li><a href="widgets.html" title="">Widgets</a></li>
            <li class="last"><a href="grid.html" title="">Grid</a></li>
          </ul>
        </li>
        <li><a href="#" title="" class="exp"><img src="<?php echo $baseUrl; ?>/img/icons/light/alert.png" alt="" />Error pages<strong>6</strong></a>
          <ul class="sub">
            <li><a href="403.html" title="">403 page</a></li>
            <li><a href="404.html" title="">404 page</a></li>
            <li><a href="405.html" title="">405 page</a></li>
            <li><a href="500.html" title="">500 page</a></li>
            <li><a href="503.html" title="">503 page</a></li>
            <li class="last"><a href="offline.html" title="">Website is offline</a></li>
          </ul>
        </li>
        <li><a href="file_manager.html" title=""><img src="<?php echo $baseUrl; ?>/img/icons/light/files.png" alt="" />File manager</a></li>
        <li><a href="#" title="" class="exp"><img src="<?php echo $baseUrl; ?>/img/icons/light/create.png" alt="" />Other pages<strong>3</strong></a>
          <ul>
            <li><a href="typography.html" title="">Typography</a></li>
            <li><a href="calendar.html" title="">Calendar</a></li>
            <li class="last"><a href="gallery.html" title="">Gallery</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <div class="cLine"></div>
  </div>

  <!-- Title area -->
  <div class="titleArea">
    <div class="wrapper">
      <div class="pageTitle">
        <h5>Dashboard</h5>
        <span>Do your layouts deserve better than Lorem Ipsum.</span>
      </div>
<!--      <div class="middleNav">-->
<!--        <ul>-->
<!--          <li class="mUser"><a title=""><span class="users"></span></a>-->
<!--            <ul class="mSub1">-->
<!--              <li><a href="#" title="">Add user</a></li>-->
<!--              <li><a href="#" title="">Statistics</a></li>-->
<!--              <li><a href="#" title="">Orders</a></li>-->
<!--            </ul>-->
<!--          </li>-->
<!--          <li class="mMessages"><a title=""><span class="messages"></span></a>-->
<!--            <ul class="mSub2">-->
<!--              <li><a href="#" title="">New tickets<span class="numberRight">8</span></a></li>-->
<!--              <li><a href="#" title="">Pending tickets<span class="numberRight">12</span></a></li>-->
<!--              <li><a href="#" title="">Closed tickets</a></li>-->
<!--            </ul>-->
<!--          </li>-->
<!--          <li class="mFiles"><a href="#" title="Or you can use a tooltip" class="tipN"><span class="files"></span></a></li>-->
<!--          <li class="mOrders"><a title=""><span class="orders"></span><span class="numberMiddle">8</span></a>-->
<!--            <ul class="mSub4">-->
<!--              <li><a href="#" title="">Pending uploads</a></li>-->
<!--              <li><a href="#" title="">Statistics</a></li>-->
<!--              <li><a href="#" title="">Trash</a></li>-->
<!--            </ul>-->
<!--          </li>-->
<!--        </ul>-->
<!--        <div class="clear"></div>-->
<!--      </div>-->
      <div class="clear"></div>
    </div>
  </div>

  <div class="line"></div>
  <!-- End Title area -->

  <div class="main">
    <div class="wrapper">
      <div id="content">
        <?php echo $content; ?>
      </div>
    </div>
  </div>

</div>

<div class="clear"></div>
</body>

</html>