<div class="main">

  <div class="container" style="padding: 20px;">
    <div class="row">
      <?php if(empty($message)): ?>
      Lỗi không xác định
      <?php else: ?>
      <?php echo $message ?>
      <?php endif; ?>
    </div>
  </div>
</div>