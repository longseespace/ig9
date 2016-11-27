<?php
/** Author: TeKa */
$module = substr($this->id, strpos($this->id, '/') + 1);
?>
<div class="action">
  <a href="/admin/post/create" class="btn">Add post</a>
</div>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <td>ID</td>
      <td>Title</td>
      <td>Content</td>
      <td>Create time</td>
      <td colspan="3">Action</td>
    </tr>
  </thead>
  <tbody>
    <?php foreach($posts as $post) : ?>
      <tr>
        <td><?php echo $post->id ?></td>
        <td><?php echo $post->title ?></td>
        <td><?php $content = strip_tags($post->content); echo strlen($content) > 100 ? substr($content, 0, 100) . '...' : $content; ?></td>        
        <td><?php $time = $post->create_time; echo date('d-m-y', strtotime($post->create_time)); ?></td>
        <td><a href="<?php echo $this->adminUrl($module, 'update', $post->id) ?>">Edit</a></td>
        <td><a href="<?php echo $this->slug($module, $post->slug) ?>" target="_blank">View</a></td>
        <td><a href="<?php echo $this->adminUrl($module, 'delete', $post->id) ?>" class="delete">DEL</a></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
