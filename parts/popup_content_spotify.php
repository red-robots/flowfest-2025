<?php
  //$post_id = $post->ID;
  $title = get_the_title($post_id);
  $content_post = get_post($post_id);
  $content = $content_post->post_content;
  $content_popup = apply_filters('the_content', $content);
  $spotify_url = get_field('spotify_embed',$post_id);
  $spotify = apply_filters('the_content', $spotify_url);
?>
<div class="popup-content activity sdfsdfdsf">
  <a href="javascript:void(0)" id="closeModalBtn"><span>close</span></a>
  <div class="middle-content">
    <div class="flex-wrap full">
      <div class="text">
        <h2 class="title"><?php echo $title; ?></h2> 
        <div class="description"><?php echo $content_popup; ?></div>
      </div>
    </div>
    <?php if ($spotify) { ?>
      <div class="cf">
        <?php echo $spotify; ?>
      </div>
    <?php } ?>
  </div>
</div>
