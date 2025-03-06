<?php 
$img = get_field('tile_image',$post_id);
$image_style = ($img) ? ' style="background-image:url('.$img['url'].')"':'';
$dateTime = get_field('date_and_time',$post_id);
$other_info = get_field('other_info',$post_id);
$time_only = '';
if($dateTime) {
  $date = DateTime::createFromFormat('Y-m-d H:i:s', $dateTime);
  $time_only = $date->format('g:i a');
}
$content = $post->post_content;
apply_filters('the_content',$content);
$flexClass = ($img) ? 'half':'full';
?>
<div class="popup-content">
  <a href="javascript:void(0)" id="closePopUp"><span>x</span></a>
  <div class="middle-content">
    <div class="flex-wrap <?php echo $flexClass ?>">
      <div class="text">
        <h2 class="title"><?php echo $post->post_title; ?></h2>

        <?php 
          // echo '<pre>';
          // print_r($img);
         ?>
        

        <?php if ( $time_only || $other_info ) { ?>
        <div class="other-info">
          <?php if ( $time_only ) { ?>
            <div class="time"><?php echo $time_only ?></div>
          <?php } ?>
          <?php if ( $other_info ) { ?>
            <div class="other"><?php echo $other_info ?></div>
          <?php } ?>
        </div>
        <?php } ?>

        <?php if ( $content ) { ?>
        <div class="description"><?php echo $content ?></div>
        <?php } ?>

      </div>

      <?php if ($img) { ?>
      <div class="photo">
        <figure <?php //echo $image_style ?>>
          <img src="<?php echo $img['sizes']['big-square']; ?>" alt="">
          <!-- <img src="<?php echo THEMEURI ?>images/image-helper.png" alt=""> -->
        </figure>
      </div>
      <?php } ?>
      
    </div>
  </div>
</div>
