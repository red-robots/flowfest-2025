<?php 
$posts = new WP_Query($args);
if ( $posts->have_posts() ) { ?>
<div class="feeds-wrapper">

  <?php  
  $filter_options = ($filter) ? explode(',',$filter) : '';
  if($filter_options) { ?>
    <?php if ( do_shortcode('[facetwp facet="competition_type"]') || do_shortcode('[facetwp facet="competition_day"]') ) { ?>
    <div class="filter-options">
      <span class="ftitle">FILTER BY:</span>
      <?php foreach ($filter_options as $opt) { ?>
        <?php if ( do_shortcode('[facetwp facet="'.$opt.'"]') ) { ?>
          <?php //echo do_shortcode('[facetwp facet="'.$opt.'"]'); ?>
        <?php } ?>
      <?php } ?>
    </div>
    <?php } ?>
  <?php } ?>

  <div class="columns">
    <?php 
      $current_count = count( get_posts($args) );
      $i=1; while ( $posts->have_posts() ) : $posts->the_post(); 
      $post_id = get_the_ID();
      $thumbnail_id = get_post_thumbnail_id($post_id);
      $featImage = wp_get_attachment_image_src($thumbnail_id,'large');
      $imageStyle = ($featImage) ? ' style="background-image:url('.$featImage[0].')"':'';
      $postType = get_post_type($post_id);
      $div3rdcol = 'post-type-'.$postType;
      //$div3rdcol .= ( ($i % 3==0) || ($i==$current_count) ) ? ' third':'';
      //$div3rdcol .= ($i==$current_count) ? ' last':'';
      $pagelink = ($postType=='artists') ? 'Event.preventDefault()' : get_permalink();
      ?>
      <?php if ($i==1 && $postType=='artists') { ?>
       <div class="parent-wrap <?php echo $div3rdcol ?>"> 
      <?php } ?>
      <div data-postid="<?php echo $post_id ?>" class="column <?php echo $div3rdcol ?>">
        <div class="inner">
          <div class="image">
            <figure<?php echo $imageStyle ?>>
              <a href="<?php echo $pagelink ?>"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/square.png" class="helper" alt=""></a></figure>
          </div>
          <h4 class="title"><a href="<?php echo $pagelink ?>"><?php the_title(); ?></a></h4>
        </div>
      </div>

      <?php if ($i % 3==0 && $postType=='artists') { ?>
        </div><div class="parent-wrap <?php echo $div3rdcol ?>"><!-- end of .parent-wrap -->
      <?php } ?>

    <?php $i++; endwhile; wp_reset_postdata(); ?>
      
    <?php if($postType=='artists') { ?>
      </div>
    <?php } ?>
  </div>

  <?php
  $total_pages = $posts->max_num_pages;
  if ($total_pages > 1) { ?>
  <div id="pagination" class="pagination">
    <?php
    $pagination = array(
        'base' => @add_query_arg('pg','%#%'),
        'format' => '?paged=%#%',
        'current' => $paged,
        'total' => $total_pages,
        'prev_text' => __( '&laquo;', 'red_partners' ),
        'next_text' => __( '&raquo;', 'red_partners' ),
        'type' => 'plain'
    );
    echo paginate_links($pagination); ?>
  </div>
  <?php } ?>
</div>
<?php } ?>