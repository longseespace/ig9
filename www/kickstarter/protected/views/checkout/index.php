<form action="<?php echo $postUrl ?>?nexturl=<?php echo $nextUrl ?>"
method="post" enctype="multipart/form-data">
     <input name="file" type="file" value="<?php echo $file;?>"/>
     <input name="token" type="hidden" value="<?php echo $token ?>"/>
     <input value="Upload Video File" type="submit" />
</form>