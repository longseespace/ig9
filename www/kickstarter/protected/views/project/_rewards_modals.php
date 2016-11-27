<?php foreach($project->rewards as $index => $reward):?>
  <form action="<?php echo $this->createUrl('pledge/new', array('project_id' => $project->id)) ?>" method="get" accept-charset="utf-8" class="form-horizontal">
    <div class="modal hide prj-back-modal" id="modal-<?php echo $index;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 class="myModalLabel"><?php __("Back this Project")?></h3>
      </div>
      <div class="modal-body">
        <div class="control-group">
          <label class="control-label" for="pledgeAmount"><?php echo __("Pledge amount:");?></label>
          <div class="controls">
            <input type="hidden" class="rewardId" name="reward_id" value="<?php echo $reward->id;?>"/>
            <input type="text" class="pledgeAmount" name="amount" value="<?php echo $reward->amount;?>"/>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword"><?php __("Description:")?></label>
          <div class="controls">
            <h4><?php __("Pledge %s or more", array(__m($reward->amount)));?></h4>
            <p><?php echo nl2br($reward->description) ?></p>
            <p><?php __("Est. Delivery");?>: <?php _d($reward->delivery_time, 'm/Y');?></p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="submit" class="ig9btn do-pledge" value='<?php __("Continue"); ?>' />
      </div>
    </div>
  </form>
<?php endforeach;?>