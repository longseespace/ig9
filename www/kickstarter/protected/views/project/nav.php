<?php $project_id = $this->model->id ?>

<nav id="project-edit-nav-wrap-wrap">
  <div id='project-edit-nav-wrap'>
    <div class="container">
      <ul id="project-edit-nav">
        <li class="steps">
          <ol id="steps-nav">
            <?php
            $aClass='completed'; $index = 0;
            foreach ($this->steps as $key => $step):
              $index ++;
              $aClass = ($key === $this->action->id) ? 'selected' : $aClass;
              $liClass = ($index === 1) ? 'first' : ($index === count($this->steps) ? 'last' : '');
            ?>
              <li class="<?php echo $liClass ?>">
                <a href="<?php echo $this->createUrl("project/{$step['action']}", array('id' => $project_id)) ?>" class='<?php echo $aClass ?>'>
                  <span class='divider first'></span>
                  <span class='istatus'></span>
                  <?php echo $step['title'] ?>
                  <span class='divider last'></span>
                </a>
              </li>
            <?php
            $steps = $this->steps;
            $keys = array_keys($steps);
            if ($this->action->id === array_shift($keys)) {
              $aClass = 'disabled';
            } else {
              $aClass = ($aClass !== 'selected') ? $aClass : '';
            }
            endforeach ?>
          </ol>
        </li>
        <li class="preview">
          <?php
            echo CHtml::link('<span class="icon-play-circle icon-white"></span>Preview',
              array('project/view', 'id' => $project_id),
              array('target' => '_blank', 'class' => 'tab disabled'));
          ?>
        </li>
      </ul>
    </div>
  </div>
</nav>