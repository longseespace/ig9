<?php

$keys = array_keys($this->steps);
$next = $this->steps[$keys[array_search($this->action->id, $keys) + 1]];
$prev = $this->steps[$keys[array_search($this->action->id, $keys) - 1]];

if(empty($next['action'])){
  $nextUrl = $this->createUrl('project/view', array('id' => $this->model->id, 'slug' => $this->model->slug));
}else{
  $nextUrl = $this->createUrl('project/'.$next['action'], array('id' => $this->model->id));
}

$prevUrl = $this->createUrl('project/'.$prev['action'], array('id' => $this->model->id));

?>

<div class="tools" style="">
  <div class="container">
    <ol class="tools-panels">
      <li class="panel form-navigator">
        <ul>
          <li class="next button_container" style="">
            <a href="<?php echo $nextUrl ?>" id="next" class='button-positive btn btn-primary'><?php __('Next') ?></a>
          </li>
          <li class="back button_container" style="display: list-item;">
            <a href="<?php echo $prevUrl ?>" id="prev" class="button-neutral btn"><?php __("Back") ?></a>
          </li>

        </ul>
      </li>
    </ol><!-- .tools-panels -->
    <ul class="alt-tools">
      <li>
        <a href="/" class="exit-link" title="Exit to Home page"><?php __("Exit") ?></a>
      </li>
      <!-- <li>
        <a href="/projects/1926311722/675802011/cancel" class="delete-project" title="Delete this project"><?php __("Delete project") ?></a>
      </li> -->
    </ul>
  </div><!-- .container -->
</div><!-- .tools -->