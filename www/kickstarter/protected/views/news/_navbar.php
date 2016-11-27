<div class="sidebar"> 
  <div class="list-category"> 
    <h3><?php __('Browser news'); ?></h3>
    <?php
    $this->widget('zii.widgets.CListView', array(
      'dataProvider' => $category,
      'pagerCssClass' => 'pagination pagination-centered',
      'pager'=>array(
        'header' => '',
        'htmlOptions' => array(
          'class' => ''
        )
      ),
      'template'=>'{items} {pager}',
      'ajaxUpdate' => false,
      'itemView' => '_nav',
    ));
    ?>
  </div>
  <div class="featured">
    <h3>Project of the day</h3>
    <div id="mf-content" class="tab-content">
      <?php foreach($categories as $cate):?>
      <?php $project = $cate->featuredProject;?>

      <div class="tab-pane fade in <?php echo ($cate === $categories[0]) ? 'active' : '' ?>" id="cate-featured-<?php echo $cate->id;?>">
        <div class="prj-img">
          <?php echo CHtml::link(CHtml::image($project->thumbImage), array("project/view", 'id'=>$project->id, 'slug'=>$project->slug));?>
          <!--<img src="img/project-img.jpg">-->
        </div>
        <div class="prj-info">
          <div class="clearfix">
            <div class="prj-title">
              <p><?php echo CHtml::link($project->title,array("project/view", 'id'=>$project->id, 'slug'=>$project->slug))?></p>
            </div>
          </div>
          <div class="prj-desc">
            <p><?php //echo $cate->featuredProject->excerpt;?></p>
          </div>
        </div>
      </div>
      <?php endforeach;?>      
    </div>
  </div>
</div>
<div id="fb-root"></div>