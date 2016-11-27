<div class="modal hide" id="modal-bio">
  <div class="modal-body">
    <div id="projectby">
      <div class="top clearfix">
        <div class="avatar">
          <?php echo CHtml::link(CHtml::image(AppHelper::fixImageUrl($project->user->avatarBehavior->getFileUrl(), 220, 220), '', array('class' => 'avatar-large', 'height' => '220' , 'width' => '220')), array('/user/profile', 'id' => $project->user->id)); ?>
          <!-- <a href="/projects/1939875139/glyphits-magnetic-pictures-with-linguistic-potenti/messages/new?message%5Bto%5D=1939875139"
          class="btn-contact"><?php __("Contact me"); ?></a> -->
          <ul class="accountability">
            <li class="backed-more">
              <span class="icon">
              </span>
              <span class="text">
                <!-- <a href="/profile/1939875139/backed" class="more-button remote_modal_dialog"
                data-modal-title="<?php __('Projects backed by %s', $project->user->username); ?>"> -->
                  <?php __("Back %s projects", $project->user->projectBackedCount); ?>
                <!-- </a> -->
              </span>
            </li>
          </ul>
        </div>
        <div class="info">
          <h3>
            <?php echo CHtml::link($project->user->profile->fullname, array('/user/profile', 'id' => $project->user_id)); ?>
          </h3>
          <p class="byline">
            <span class="location">
              <span class="pictos">@</span> <?php echo $project->user->profile->city; ?>
            </span>
            <span class="divider">
              ·
            </span>
            <span class="view-profile">
              <?php echo CHtml::link(___("Full profile"), array('/user/profile', 'id' => $project->user_id)); ?>
            </span>
          </p>
          <?php echo $project->personal_description; ?>
          <b class="links-title">
            <?php __("Websites"); ?>
          </b>
          <ul class="links">
            <li>
              <?php echo CHtml::link($project->user->profile->websites, AppHelper::getFullUrl($project->user->profile->websites), array('rel' => 'nofollow', 'target' => '_blank')); ?>
            </li>
          </ul>
        </div>
      </div>
      <div class="bottom">
        <b>
          <?php __("Created projects"); ?>
          <span>
            (<?php echo $project->user->projectCreatedCount ?>)
          </span>
        </b>
        <ul class="created-projects">
          <?php foreach($project->user->projects as $p): ?>
          <li class="current">
            <?php echo CHtml::link((CHtml::image(AppHelper::fixImageUrl($p->image, 95, 72), "", array("height" => "72", "width" => "95"))), array('/project/view', 'slug' => $p->slug, 'id' => $p->id)); ?>
            <!-- <a href="/projects/1939875139/glyphits-magnetic-pictures-with-linguistic-potenti"
            title="GLYPHiTS: Magnetic Pictures with Linguistic Potential"><img alt="Photo-small" height="72" src="http://s3.amazonaws.com/ksr/projects/260826/photo-small.jpg?1342987187" width="95"></a>
            <span class="current-text">
              Current project
            </span> -->
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</div>