<?php 
$img = get_field('tile_image');
$dateTime = get_field('date_and_time');
$time_only = '';
if($dateTime) {
  $date = DateTime::createFromFormat('Y-m-d H:i:s', $dateTime);
  $time_only = $date->format('g:i a');
}
$has_image = ($img) ? 'has-image':'no-image';
$image_style = ($img) ? ' style="background-image:url('.$img['url'].')"':'';
$pagelink = get_permalink();
?>
<div class="tile <?php echo $has_image ?>">
  <a href="javascript:void(0)" data-id="<?php echo get_the_ID() ?>" data-pagelink="<?php echo $pagelink ?>" class="pagelink postinfo">
    
  	<figure class="img" <?php echo $image_style ?>>
      <img src="<?php echo THEMEURI ?>images/image-helper.png" alt="">
    </figure>
    <div class="overlay">
    	<div class="info <?php echo ($time_only) ? 'has-time':'no-item' ?>">
    		<div class="title">
    			<h2><?php the_title(); ?></h2>
    		</div>
        <?php if ($time_only) { ?>
        <div class="time">
          <?php echo $time_only; ?>
        </div>
        <?php } ?>
    	</div>
    </div>
  </a>
</div>