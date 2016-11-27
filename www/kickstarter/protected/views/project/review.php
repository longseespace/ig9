<?php
$baseUrl = $this->assetsUrl;
$this->pageTitle = "Review Your Project — " . Yii::app()->name;
?>

<div class="content" data-category-name="" id="forms">
  <div id="running-board-wrap">
    <div class="container" id="running-board">
      <ol class="help-panels" style="height: auto;">
        <li class="panel selected" id="the-basics-help" style="display: block;">
          <h3>
            <?php __('The homestretch!') ?>
          </h3>
          <p>
            <?php __('Once everything is in place, submit your project for review.') ?>
          </p>
        </li>
      </ol>
    </div>
  </div>

  <div class="container">
    <div id="main">
      <div class="window">
        <ol class="form-panels">
          <li class="panel" data-panel_id="the-basics" id="the-review-panel">
            <div class="NS_projects__edit_submission unsubmitted">
              <h1>
                <?php __("Before you submit") ?>
              </h1>
              <p>
                <?php __("Make sure you have:") ?>
              </p>
              <ul>
                <li><?php __("Clearly explained what you're raising funds to do.") ?></li>
                <li><?php __("Added a video! It's the best way to connect with your backers.") ?></li>
                <li><?php __("Created a series of well-priced, fun rewards. Not just thank-yous!") ?></li>
                <li><?php __("Previewed your project and gotten feedback from a friend.") ?></li>
                <li><?php __("Checked out other projects on Kickstarter and backed one to get a feel for the experience.") ?></li>
              </ul>
              <h1>
                <?php __("After you submit") ?>
              </h1>
              <p>
                <?php __("Once you've done everything listed above and submitted your project for review:") ?>
              </p>
              <ul>
                <li><?php __("Your project will be reviewed to ensure it meets the Project Guidelines.") ?></li>
                <li><?php __("Within a few days, we'll send you a message about the status of your project.") ?></li>
                <li><?php __("If approved, you can launch whenever you're ready.") ?></li>
                <li>&nbsp;</li>
              </ul>
              <div class="hero-unit">
                <h4><?php __("Please imediately email or call us to inform your campaign is ready.") ?></h4>
                <p><?php __("Mobile:") ?> 0127 345 2178</p>
                <p><?php __("Email:") ?> support@ig9.vn</p>
              </div>
            </div>
          </li>

        </ol>
        <br/><br/><br/>
      </div>
    </div>

    <div id="sidebar">
      <ol class="sidebar-help-panels">

        <li class="panel selected" id="the-basics-sidebar-help" style="display: block;">

        </li>

      </ol>
    </div>

    <?php $this->renderPartial('//project/toolbar') ?>
  </div><!-- .container -->
</div>