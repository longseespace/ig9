<?php
/* @var $this SiteController */
$baseUrl = $this->assetsUrl;
$cs = Yii::app()->clientScript;
$this->pageTitle=Yii::app()->name;

$cs->registerCoreScript('cookie');

Yii::app()->assetCompiler->registerAssetGroup(array('home.less', 'index.js'), $baseUrl);
?>

<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'fbmeta')); ?>

<meta property="og:image" content="http://ig9.vn/themes/ig9/assets/img/logo.gif" />
<meta property="og:title" content="IG9.VN - Website gọi vốn từ cộng đồng đầu tiên của Việt Nam" />
<meta property="og:description" content="IG9 là nơi dành cho các cá nhân hoặc tổ chức, doanh nghiệp thu hút vốn đầu tư và xây dựng hình ảnh cho dự án của mình. Chúng tôi là một cộng đồng hợp tác, nơi mọi người có thể cùng tới với nhau để cùng đóng góp tiền của, trao đổi những phản hồi, ý kiến và ủng hộ cho những ý tưởng và đam mê của những doanh nhân, nghệ sĩ, nhà văn, nhạc sĩ… có nhiệt huyết và tham vọng. " />
<meta property="og:url" content="http://ig9.vn" />
<meta property="og:site_name" content="IG9.VN - Website gọi vốn từ cộng đồng đầu tiên của Việt Nam" />
<meta property="og:type" content="website" />
<meta name="description" content="IG9 là nơi dành cho các cá nhân hoặc tổ chức, doanh nghiệp thu hút vốn đầu tư và xây dựng hình ảnh cho dự án của mình. Chúng tôi là một cộng đồng hợp tác, nơi mọi người có thể cùng tới với nhau để cùng đóng góp tiền của, trao đổi những phản hồi, ý kiến và ủng hộ cho những ý tưởng và đam mê của những doanh nhân, nghệ sĩ, nhà văn, nhạc sĩ… có nhiệt huyết và tham vọng. " />

<?php $this->endWidget();?>

<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'notification')); ?>
<?php if (Yii::app()->user->isAdmin() || ($this->isHome && $notification && (Yii::app()->request->cookies['notid']->value != $notification->id)) ):?>
<div id="notification-top" data-id="<?php echo $notification->id ?>">
  <?php if (Yii::app()->user->isAdmin()): ?>
    <a href="#modal-notification" role="button" class="pictos" data-toggle="modal" id="edit-button">W</a>
  <?php else: ?>
    <a href='#' class="pictos" id="close-button">*</a>
  <?php endif ?>
  <div id="notification-content">
    <a href="<?php echo empty($notification->url) ? '#' : $notification->url ?>" target="_blank" id="notification-content"><?php echo $notification->message ?></a>
  </div>
</div>

<?php endif;?>
<?php $this->endWidget();?>

<?php if ($notification && $this->isHome): ?>

  <div class="modal hide notification-modal" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 class="myModalLabel"><?php __("Edit Message")?></h3>
    </div>
    <div class="modal-body">
      <?php $form=$this->beginWidget('CActiveForm', array(
        'action' => 'site/editnotification',
        'id'=>'notification-edit-form',
        'enableAjaxValidation'=>false,
      )); ?>
      <div class="control-group">
        <label class="control-label" for="url"><?php echo __("URL:");?></label>
        <div class="controls">
          <?php echo $form->textField($notification,'url'); ?>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="message"><?php echo __("Message:");?></label>
        <div class="controls">
          <?php echo $form->textarea($notification,'message'); ?>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <input type="submit" class="ig9btn do-pledge" value='<?php __("Update"); ?>' />
    </div>
    <?php $this->endWidget(); ?>
  </div>

<?php endif; ?>


<div role="main" id="main" class="wrapper">
  <div class="featured">
    <div id="mf-content" class="tab-content">
      <?php $index = mt_rand(0, count($categories) - 1); ?>
      <?php foreach($categories as $category):?>
      <?php $project = $category->featuredProject;?>

      <div class="tab-pane fade in <?php echo ($category === $categories[$index]) ? 'active' : '' ?>" id="category-featured-<?php echo $category->id;?>">
        <div class="prj-img">
          <?php echo CHtml::link(CHtml::image($project->image), array("project/view", 'id'=>$project->id, 'slug'=>$project->slug));?>
          <!--<img src="img/project-img.jpg">-->
        </div>
        <div class="prj-info">
          <div class="clearfix">
            <?php if ($category->featuredProject->user->avatarBehavior->getFileUrl()) : ?>
            <div class="prj-creator-ava"><?php echo CHtml::image($category->featuredProject->user->avatarBehavior->getFileUrl(), $category->featuredProject->user->username, array('width' => 46));?></div>
            <?php else: ?>
            <div class="prj-creator-ava"><?php echo CHtml::image($baseUrl.'/img/noava.png', 'No Image', array('width' => 46)); ?></div>
            <?php endif ?>
            <div class="prj-title">
              <h3><?php echo CHtml::link($project->title."<span>".___("by %s in %s", array($category->featuredProject->user->username, $category->featuredProject->user->profile->city))."</span>",array("project/view", 'id'=>$project->id, 'slug'=>$project->slug))?></h3>
            </div>
          </div>
          <div class="prj-desc">
            <p><?php echo $category->featuredProject->excerpt;?></p>
          </div>

          <div class="prj-stats">
            <div class="clearfix prj-info2">
              <div class="prj-location">
                <span class="pictos">@</span><?php echo $category->featuredProject->user->profile->city ?>
              </div>
              <div class="prj-cat">
                <span class="pictos">I</span><?php __($category->name)?>
              </div>
            </div>
            <div class="prj-fund-stats">
              <div class="prj-fund-current" style="width:<?php _p($project->getFundingRatio(), true)?>;"></div>
              <div class="prj-stats-detail">
                <div class="stat1">
                  <?php _p($project->getFundingRatio());?><span><?php __("funded") ?></span>
                </div>
                <div class="stat2">
                  <?php _m($project->funding_current);?><span><?php __("pledged") ?></span>
                </div>
                <div class="stat3">
                  <?php if($project->isEnd()):?>
                    <?php __("Ended") ?>
                  <?php elseif($project->isTimeLeftLessThan1Day()):?>
                    <?php echo $project->getHourLeft();?><span><?php __("hours to go") ?></span>
                  <?php else:?>
                    <?php echo $project->getDayLeft();?><span><?php __("days to go") ?></span>
                  <?php endif;?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach;?>
      <div class="feature-nav">
        <ul>
          <?php $first = true;?>
          <?php foreach($categories as $category):?>
          <li class="<?php echo ($category === $categories[$index]) ? 'active' : '' ?>">
            <a href="#category-featured-<?php echo $category->id;?>" data-toggle="tab"><?php __($category->name)?></a>
          </li>
          <?php endforeach;?>
        </ul>
      </div>
    </div>

  </div>
  <div class="main-list" id="main-list">
    <ul class="row">
      <?php
        $this->widget('zii.widgets.CListView', array(
          'dataProvider'=>$dataProvider,
          'itemView'=>'//site/index/_projects',
          'template' => '{items}'
        ));
      ?>
    </ul>

    <div id="ended-projects">
      <h2 class="heading"><a href="<?php echo $this->createUrl('project/ended') ?>"><?php __('Ended Projects') ?></a></h2>
      <ul class="row">
        <?php
        $this->widget('zii.widgets.CListView', array(
          'dataProvider'=>$ended,
          'itemView'=>'//site/index/_projects',
          'template' => '{items}'
        ));
        ?>
      </ul>
    </div>
  </div>
</div>
