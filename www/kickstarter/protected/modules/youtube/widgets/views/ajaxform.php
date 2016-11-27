<form id="frm" action="<?php echo $postUrl ?>" method="post" enctype="multipart/form-data">
  <?php if(!empty($videoId)):?>
  <iframe width="450" height="256" id="youtube-preview" src="http://www.youtube.com/embed/<?php echo $videoId;?>"></iframe>
  <?php endif;?>
  <input id="youtube-file" name="file" type="file" class="<?php echo $inputClass?>"/>
  <input id="youtube-token" name="token" type="hidden" value="<?php echo $token ?>"/>
  <div id="youtube-progress" class="progress progress-striped active">
    <div id="youtube-progress-bar" class="bar" style="width: 0%;"></div>
  </div>
</form>