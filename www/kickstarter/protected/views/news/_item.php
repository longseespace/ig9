<article class="primaryContent ">
    <div class="title"><h3><?php echo CHtml::link($data->title, array('/news/view', 'id' => $data->id)) ?></h3></div>
    <div class="meta"><span class="author"><?php __('By ') ?><?php echo $data->author->username; ?></span> <span class="date"><?php __('Posted on ') ?><?php echo date("d-m-Y",strtotime($data->create_time)) ?></span> </div>

    <div class="content">
      <?php if (isset($data->image)) : ?>
        <div class="featured-image">
          <br>
          <a href="<?php echo $this->createUrl('/news/view', array('id' => $data->id)) ?>">
            <?php echo $data->image ?>
          </a>          
          <br>
        </div>
      <?php endif; ?><br>
      <?php echo AppHelper::trimWord($data->content, 600); ?>
    </div>
</article>
<div class="clearfix"></div>

