
<div class="edit-or-delete">
  <a data-id='<?php echo $reward->id ?>' class="edit btn tt" title="<?php __("Edit this reward") ?>"><span class="icon-pencil icon"><?php __("Edit reward") ?></span></a>
  <a data-id='<?php echo $reward->id ?>' class="delete btn btn-danger tt" title="<?php __("Delete this reward") ?>"><span class="icon-remove icon icon-white"><?php __("Delete reward") ?></span></a>
</div>
<h3><?php __("Pledge %s or more", __m($reward->amount)) ?></h3>
<div class="backers-limits">
  <span class='icon icon-user'></span>
  <span class="num-backers"><?php echo $reward->backer_count ?> <?php __("Backers") ?></span> 
  <?php if ($reward->backer_limit > 0): $remaining = $reward->backer_limit - $reward->backer_count; ?>
    <span class="limited">• <?php __("Limited Reward (%s of %s remaining)", $remaining, $reward->backer_limit) ?></span>
  <?php endif ?>
</div>
<div class="desc">
  <p>
    <?php echo nl2br($reward->description) ?>
  </p>
</div>
<?php $date = getdate(strtotime($reward->delivery_time)) ?>
<div class="delivery-date">
  <strong><?php __("Est. Delivery:") ?></strong> <?php echo $date['month']." ".$date['year'] ?>
</div>
