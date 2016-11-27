<?php
/**
 * Author: Long Doan
 * Date: 8/30/12 10:24 AM
 */

$this->pageTitle($page->title);
?>

<div class="container">
  <h1 class="title"><?php echo $page->title ?></h1>
  <div class="content">
    <?php echo $page->content ?>
  </div>
</div>