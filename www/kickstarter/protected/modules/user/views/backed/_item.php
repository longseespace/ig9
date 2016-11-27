<?php
/**
 * Author: Long Doan
 * Date: 4/10/13 10:44 AM
 */

?>
<li class="user-project-cell span3">
  <div class="prj-img">
    <?php echo CHtml::link(CHtml::image($data->project->image), array("/project/view", 'id'=>$data->project->id, 'slug'=>$data->project->slug));?>
    <!--<img src="img/prj-thumb.jpg">-->
  </div>
  <div class="prj-info">
    <div class="prj-title">
      <h3><?php echo CHtml::link($data->project->title?$data->project->title:'No Name',array("/project/view", 'id'=>$data->project->id, 'slug'=>$data->project->slug))?> </h3>
    </div>
  </div>

</li>