<li class="span4 prj-cell">
  <div class="prj-img">
    <?php echo CHtml::link(CHtml::image($data->image), array("project/view", 'id'=>$data->id, 'slug'=>$data->slug));?>
    <!--<img src="img/prj-thumb.jpg">-->
  </div>
  <div class="prj-info">
    <div class="prj-title">
      <h3><?php echo CHtml::link($data->title."<span>".___("by %s", array($data->user->username))."</span>",array("project/view", 'id'=>$data->id, 'slug'=>$data->slug))?> </h3>
    </div>

    <div class="prj-desc">
      <p><?php echo $data->excerpt;?></p>
    </div>

    <div class="prj-stats">
      <div class="clearfix prj-info2">
        <div class="prj-location">
          <span class="pictos">@</span><?php echo $data->user->profile->city;?>
        </div>
        <div class="prj-cat">
          <span class="pictos">I</span><?php __($data->category->name)?>
        </div>
      </div>
      <div class="prj-fund-stats">
        <div class="prj-fund-current" style="width:<?php _p($data->getFundingRatio(), true)?>"></div>
        <div class="prj-stats-detail">
          <div class="stat1">
            <?php _p($data->getFundingRatio())?><span><?php __("funded") ?></span>
          </div>
          <div class="stat2">
            <?php _m($data->funding_current)?><span><?php __("pledged") ?></span>
          </div>
          <div class="stat3">
            <?php if($data->isEnd()):?>
              <?php if($data->getFundingRatio() >= 1) __("Success"); else __("Ended"); ?>
              <span><?php _d($data->end_time) ?></span>
            <?php elseif($data->isTimeLeftLessThan1Day()):?>
              <?php echo $data->getHourLeft();?><span><?php __("hours to go") ?></span>
            <?php else:?>
              <?php echo $data->getDayLeft();?><span><?php __("days to go") ?></span>
            <?php endif;?>
          </div>
        </div>
      </div>
    </div>
</li>