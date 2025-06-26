<?php 
$rows = get_field('location_time', $post_id);
$i = 1;
?>
<div class="popup-content activity">
  <a href="javascript:void(0)" id="closeModalBtn"><span>close</span></a>
  <div class="middle-content">
    <div class="flex-wrap full">
      <div class="text">
        <?php
        foreach( $rows as $row ) {
          if($i++ != $item) {
            continue;
          }

          $title = $row['title'];
          $content = $row['content'];
          $img = '';
          
          if( $img = $row['banner'] ) {
            $image_style = ($img) ? ' style="background-image:url('.$img['url'].')"':'';
            $imgURL = ($img) ? $img['url']:'';
            $imgALT = ($img) ? $img['title']:'';
          }
          
          if( $title ){
        ?>
          <h2 class="title"><?php echo $title; ?></h2>
          <?php if ($imgURL) { ?>
            <div class="photo">
              <figure <?php echo $image_style ?>>
                <img src="<?php echo THEMEURI ?>images/image-helper.png" alt="">
              </figure>
            </div>
          <?php } ?>
          <?php if ( $content ) { ?>
            <div class="description"><?php echo $content; ?></div>
          <?php } ?>
        <?php
              }
            }
        ?>
      </div>
    </div>
  </div>
</div>
