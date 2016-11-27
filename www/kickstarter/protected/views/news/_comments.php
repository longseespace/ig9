
<div class="meta">
  <a href="/user/profile/<?php echo $data->author->id;?>" class="avatar">
    <img alt="<?php echo $data->author->username; ?>" class="avatar-small" height="40" width="40" src="<?php echo $data->author->avatar; ?>" >
  </a>
  <div class="content">
    <span class="title"><?php __('Posted on ') ?></span><span class="date"><?php echo date("d-m-Y",strtotime($data->create_time)) ?></span>
    <p><?php echo $data->content; ?></p>
  </div>
</div>
<div class="clearfix"></div>
