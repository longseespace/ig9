<div id="sidebar">
  <h3>Featured</h3>
  <ul class="navigation">
    <li><?php echo CHtml::link(___("Staff Picks"), array('discover/filter','filter'=>'staff-pick', 'ref'=>'side-bar'))?></li>
    <li><?php echo CHtml::link(___("Popular"), array('discover/filter', 'filter'=>'popular', 'ref'=>'side-bar'))?></li>
    <li><?php echo CHtml::link(___("Recently Launched"), array('discover/filter', 'filter'=>'recent', 'ref'=>'side-bar'))?></li>
    <li><?php echo CHtml::link(___("Ending Soon"), array('discover/filter', 'filter'=>'ending-soon', 'ref'=>'side-bar'))?></li>
    <li><?php echo CHtml::link(___("Most Funded"), array('discover/filter', 'filter'=>'most-funded', 'ref'=>'side-bar'))?></li>

  </ul>
  <h3>Categories</h3>
  <ul class="navigation">
    <?php foreach ($categories as $category):?>
      <li><?php echo CHtml::link($category->attributes['name'],array('discover/all', 'slug'=>$category->slug));?></li>
    <?php endforeach?>


  </ul>


</div>