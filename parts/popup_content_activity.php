<?php 
$post_id = $post->ID;
$thumbId = get_post_thumbnail_id($post);
$img = wp_get_attachment_image_src($thumbId,'full');
$image_style = ($img) ? ' style="background-image:url('.$img[0].')"':'';
$imgURL = ($img) ? $img[0]:'';
$imgALT = ($img) ? get_the_title($thumbId):'';
$content = apply_filters('the_content', $post->post_content);
$spotify_url = get_field('spotify_embed',$post_id);
$spotify = apply_filters('the_content', $spotify_url);
$cost = get_field('cost',$post_id);
$class_length = get_field('class_length',$post_id);
$bio = get_field('bio',$post_id);
$drop_in_times = get_field('drop_in_times',$post_id);
if( $img = get_field('tile_image',$post_id) ) {
  $image_style = ($img) ? ' style="background-image:url('.$img['url'].')"':'';
  $imgURL = ($img) ? $img['url']:'';
  $imgALT = ($img) ? $img['title']:'';
}
$dateTime = get_field('date_and_time',$post_id);
$other_info = get_field('other_info',$post_id);
$time_only = '';
if($dateTime) {
  $date = DateTime::createFromFormat('Y-m-d H:i:s', $dateTime);
  $time_only = $date->format('g:i a');
}

$activity_taxonomies = array(
  'Instructor'   => 'instructors-list',
  'Difficulty'   => 'difficulty-levels',
  'Location'     => 'locations-list',
  'Class Length' => 'class-types',
);

$activity_details = array();
foreach ( $activity_taxonomies as $label => $taxonomy ) {
  $terms = get_the_terms( $post_id, $taxonomy );
  if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
    $activity_details[ $label ] = implode( ', ', wp_list_pluck( $terms, 'name' ) );
  }
}
$flexClass = ($imgURL) ? 'half':'full';
?>
<div class="popup-content activity">
  <a href="javascript:void(0)" id="closeModalBtn"><span>close</span></a>
  <div class="middle-content">
    <div class="flex-wrap <?php echo $flexClass ?>">
      <div class="text">
        <h2 class="title"><?php echo $post->post_title ?></h2> 
          <?php if ( $time_only || $other_info || ! empty( $activity_details ) ) { ?>
        <div class="other-info">
          <?php if ( $time_only ) { ?>
            <div class="time"><?php echo $time_only ?></div>
          <?php } ?>
          <?php if ( $other_info ) { ?>
            <div class="other"><?php echo $other_info ?></div>
          <?php } ?>
        </div>
        <?php } ?>

        <div class="description">

          <?php if ( $cost ) { ?>
          <div class="info info_cost"><strong>Cost:</strong> <?php echo $cost; ?></div>
          <?php } ?>

          <?php if( isset($activity_details['Instructor']) && $activity_details['Instructor'] ) { ?>
            <div class="info info_instructor"><strong>Instructor:</strong> <?php echo esc_html( $activity_details['Instructor'] ); ?></div>
          <?php } ?>

          <?php if ( $bio ) {
            $bio_content = apply_filters( 'the_content', $bio );
            if ( preg_match( '/<p[^>]*>/', $bio_content ) ) {
              $bio_content = preg_replace( '/(<p[^>]*>)/', '$1<strong>Bio:</strong> ', $bio_content, 1 );
            } else {
              $bio_content = '<p><strong>Bio:</strong> ' . wp_kses_post( $bio ) . '</p>';
            }
          ?>
          <div class="info info_bio"><?php echo $bio_content; ?></div>
          <?php } ?>

          <?php if( isset($activity_details['Difficulty']) && $activity_details['Difficulty'] ) { ?>
            <div class="info info_difficulty"><strong>Difficulty:</strong> <?php echo esc_html( $activity_details['Difficulty'] ); ?></div>
          <?php } ?>
          <?php if( isset($activity_details['Location']) && $activity_details['Location'] ) { ?>
            <div class="info info_location"><strong>Location:</strong> <?php echo esc_html( $activity_details['Location'] ); ?></div>
          <?php } ?>
          <?php if( isset($activity_details['Class Length']) && $activity_details['Class Length'] ) { ?>
            <div class="info info_class_length"><strong>Class Length:</strong> <?php echo esc_html( $activity_details['Class Length'] ); ?></div>
          <?php } ?>

          <?php if ( $class_length ) { ?>
          <div class="info info_class_length"><strong>Class Length:</strong> <?php echo $class_length; ?></div>
          <?php } ?>

          <?php if ( $drop_in_times ) { ?>
          <div class="info info_drop_in_times"><strong>Drop-In Times:</strong> <?php echo $drop_in_times; ?></div>
          <?php } ?>
        </div>
      </div>

      <?php if ($imgURL) { ?>
        <div class="photo">
          <figure <?php echo $image_style ?>>
            <img src="<?php echo $img['sizes']['big-square']; ?>" alt="">
            <img src="<?php echo THEMEURI ?>images/image-helper.png" alt="">
          </figure>
        </div>
      <?php } ?>
    </div>
    <?php if ($spotify) { ?>
      <div class="cf">
        <?php echo $spotify; ?>
      </div>
    <?php } ?>
  </div>
</div>
