<?php
/**
 * Author: Long Doan
 * Date: 8/29/12 10:55 AM
 */
$module = substr($this->id, strpos($this->id, '/') + 1);

?>
<div class="action">
  <a href="<?php echo $this->adminUrl($module, 'add') ?>" class="btn">Add <?php echo $module ?></a>
</div>
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <td>ID</td>
      <td>Title</td>
      <td>Content</td>
      <td colspan="3">Action</td>
    </tr>
  </thead>
  <tbody>
    <?php foreach($pages as $page) : ?>
      <tr>
        <td><?php echo $page->id ?></td>
        <td><?php echo $page->title ?></td>
        <td><?php $content = strip_tags($page->content); echo strlen($content) > 100 ? substr($content, 0, 100) . '...' : $content; ?></td>
        <td><a href="<?php echo $this->adminUrl($module, 'edit', $page->id) ?>">Edit</a></td>
        <td><a href="<?php echo $this->slug($module, $page->slug) ?>" target="_blank">View</a></td>
        <td><a href="<?php echo $this->adminUrl($module, 'delete', $page->id) ?>" class="delete">DELETE</a></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>