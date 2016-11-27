<?php
/**
 * Author: Long Doan
 * Date: 4/22/13 5:16 PM
 */

?>

<div id="random-projects">
  <h2 class="heading"><?php __('Other Projects') ?></h2>
  <ul>
    <?php
    $this->widget('zii.widgets.CListView', array(
      'dataProvider'=>$randomProjects,
      'itemView'=>'_random_project',
      'template' => '{items}'
    ));
    ?>
  </ul>
</div>