<?php
$this->pageTitle('Start your project');

$baseUrl = $this->assetsUrl;
$cs = Yii::app()->clientScript;
$ac = Yii::app()->assetCompiler;

$cs->registerCssFile($baseUrl . "/css/style.css");
$cs->registerCssFile($baseUrl . "/css/bootstrap.css");

$cs->registerScriptFile($baseUrl . "/js/core/jquery-1.7.1.min.js");
$cs->registerScriptFile($baseUrl . "/js/core/modernizr-2.5.3.min.js");
$cs->registerScriptFile($baseUrl . "/js/core/bootstrap.min.js");

$ac->registerAssetGroup(array('script.js', 'plugins.js', 'project.less'), $baseUrl);

?>

<div class="container" id="start-page">
  <div id="sidebar">
    <?php echo CHtml::image($baseUrl.'/img/ig9start.png');?>
   
  </div>
  <!-- #sidebar -->
  <div id="the-pitch">
    <h1><?php __("We help people fund creative projects.") ?></h1>

    <p><strong><?php __("IG9 is the world's largest funding platform for creative projects.") ?></strong> <?php __("Every week, tens of
          thousands of amazing people pledge millions of dollars to projects from the worlds of") ?> <span class="category-1"><?php __("music") ?></span>,
      <span class="category-2"><?php __("film") ?></span>, <span class="category-3"><?php __("art") ?></span>, <span
              class="category-4"><?php __("technology") ?></span>, <span class="category-5"><?php __("design") ?></span>, <span class="category-6"><?php __("food") ?></span>,
      <span class="category-7"><?php __("publishing") ?></span> <?php __("and other creative fields.") ?></p>
  </div>
  <div id="the-action">
    <div class="ig9btn">
      <a href="<?php echo $this->url('project', 'guidelines') ?>" class="button-positive"><?php __("Start your project") ?></a>
    </div>
  <span class="school_link_container">
  <a href="/help/school/defining_your_project" class="school-link"><?php __("How to make an awesome IG9 project") ?></a>
  </span>
  </div>

</div>