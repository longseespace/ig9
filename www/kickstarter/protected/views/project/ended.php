<?php
/**
 * Author: Long Doan
 * Date: 6/5/13 5:40 PM
 */

?>


<div role="main" id="main" class="wrapper">
  <div class="main-list" id="main-list">

    <div id="ended-projects">
      <h1 class="heading"><?php __('Ended Projects') ?></h1>
      <ul class="row">
        <?php
        $this->widget('zii.widgets.CListView', array(
          'dataProvider'=>$ended,
          'pagerCssClass' => 'pagination pagination-centered',
          'pager'=>array(
            'header' => '',
            'htmlOptions' => array(
              'class' => ''
            )
          ),
          'itemView'=>'//site/index/_projects',
          'ajaxUpdate' => false,
          'template' => '{items} {pager}'
        ));
        ?>
      </ul>
    </div>
  </div>
</div>