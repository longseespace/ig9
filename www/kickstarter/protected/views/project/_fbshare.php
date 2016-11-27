<?php
/**
 * Author: Long Doan
 * Date: 3/16/13 4:05 PM
 */

?>
<div class="fb_share" style="float: right">
  <a name="fb_share" type="button" share_url="<?php echo $this->createAbsoluteUrl('/project/view', array('id' => $project->id, 'slug'=>$project->slug)); ?>"
     href="http://www.facebook.com/sharer.php">Share</a>
  <script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
</div>