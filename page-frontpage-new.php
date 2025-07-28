<?php 
/**
 * Template Name: New Homepage
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bellaworks
 */

get_header('new'); ?>
<div id="primary" class="home-content content-area-full new-home">
	<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

      <?php if( get_the_content() ) { ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content text-center">
          <h1 class="pagetitle lime"><?php the_title(); ?></h1>
					<div>
            <?php the_content(); ?>
          </div>
          <?php
            if( have_rows('buttons_main_content') ):
              $i = 1;
          ?>
            <div class="buttons-content">
              <?php while( have_rows('buttons_main_content') ): the_row(); 
                $button = get_sub_field('button_content');
                $button_text = (isset($button['title']) && $button['title']) ? $button['title'] : '';
                $button_link = (isset($button['url']) && $button['url']) ? $button['url'] : '';
                $button_target = (isset($button['target']) && $button['target']) ? $button['target'] : '_self';
              ?>
                <a href="<?php echo $button_link; ?>" target="<?php echo $button_target; ?>" class="button_<?php echo $i; ?>"><?php echo $button_text; ?></a>
              <?php $i++; endwhile; ?>
            </div>
          <?php endif; ?>
				</div>
			</article>
      <?php } ?>

      <?php
        if ( $cards = get_field('homepage_cards') ) {
          foreach ($cards as $k=>$item) {
            $visibility = (isset($item['visibility'][0]) && $item['visibility'][0]) ? $item['visibility'][0] : '';
            if($visibility=='hide') {
              unset($cards[$k]);
            }
          }
      ?>
      <section class="homepage-storyBlocks <?php echo (count($cards)>3) ? 'cols4':'cols3'?>">
        <div class="wrapper">
          <div class="storyBlocks">
          <?php $n=1; foreach ($cards as $item) {  
            $title = $item['title'];
            $content = $item['content'];
            $visibility = (isset($item['visibility'][0]) && $item['visibility'][0]) ? ' ' . $item['visibility'][0] : '';
            $img = $item['image'];
            $link = $item['link'];
            $icon = $item['icon'];
            $cardTitle = (isset($link['title']) && $link['title']) ? $link['title'] : '';
            $cardLink = (isset($link['url']) && $link['url']) ? $link['url'] : 'javascript:void(0)';
            $cardTarget = (isset($link['target']) && $link['target']) ? $link['target'] : '_self';
            $image_style = ($img) ? ' style="background-image:url('.$img['url'].')"':'';
            $card_class = ($img) ? 'has-image':'no-image'; 
            if($n % 4==0) {
              $card_class .= ' forth';
            }
            else if($n % 3==0) {
              $card_class .= ' third';
            }
            else if($n % 2==0) {
              $card_class .= ' even';
            }
            ?>
            <div class="storyBlock <?php echo $card_class.$visibility ?>">
              <div class="inside">
                <figure>
                  <?php if ($img) { ?>
                    <img src="<?php echo $img['url'] ?>" alt="<?php echo $img['title'] ?>">
                  <?php } ?>
                </figure>
                <div class="titlediv">
                  <?php if ($icon && preg_replace('/\s+/', '', $icon)) { ?>
                    <!-- <div class="icon <?php echo $icon ?>"><span></span></div> -->
                    <style>
                      .card .<?php echo preg_replace('/\s+/', '', $icon);?> span {background-image:url('<?php echo get_stylesheet_directory_uri() . '/images/_icons/' . preg_replace('/\s+/', '', $icon)?>.png')}
                      .card a:hover .<?php echo preg_replace('/\s+/', '', $icon); ?> span{background-image:url('<?php echo get_stylesheet_directory_uri() . '/images/_icons/' . preg_replace('/\s+/', '', $icon)?>-hover.png')}
                    </style>
                  <?php } ?>
                  <?php echo $title; ?>
                </div>
                <div class="contentdiv">
                  <?php echo $content; ?>
                </div>
                <div class="button">
                  <a href="<?php echo $cardLink ?>" target="<?php echo $cardTarget ?>"><?php echo $cardTitle; ?></a>
                </div>
              </div>
            </div>
          <?php $n++; } ?>
          </div>
        </div>
      </section>
		<?php } ?>

    <!-- Festival Schedule -->
    <?php
        $festival_sched_title = get_field('festival_schedule_title');
        $festival_content = get_field('festival_schedule_content');
        $festival_link = get_field('festival_schedule_link');
        $festival_link_text = (isset($festival_link['title']) && $festival_link['title']) ? $festival_link['title'] : '';
        $festival_url_link = (isset($festival_link['url']) && $festival_link['url']) ? $festival_link['url'] : '';
        $festival_link_target = (isset($festival_link['target']) && $festival_link['target']) ? $festival_link['target'] : '_self';

        if($festival_sched_title) {
    ?>
      <section class="festival-sched">
        <div class="wrapper">
          <h2 class="pagetitle text-center"><?php echo $festival_sched_title; ?></h2>
          <div class="swiper festival-sched-swiper">
            <?php
              if( have_rows('festival_schedule') ):
            ?>
              <div class="festival-sched-content swiper-wrapper">
                <?php while( have_rows('festival_schedule') ): the_row();
                  $fest_title = get_sub_field('title');
                  $fest_img = get_sub_field('image');
                  $fest_content = get_sub_field('content');
                  $fest_link = get_sub_field('link');
                  $fest_link_text = (isset($fest_link['title']) && $fest_link['title']) ? $fest_link['title'] : '';
                  $fest_url_link = (isset($fest_link['url']) && $fest_link['url']) ? $fest_link['url'] : '';
                  $fest_link_target = (isset($fest_link['target']) && $fest_link['target']) ? $fest_link['target'] : '_self';
                ?>
                <div class="swiper-slide">
                  <div class="festival-sched-list">
                    <figure>
                      <?php if( !empty($fest_img) ) { ?>
                        <img src="<?php echo esc_url($fest_img['url']); ?>" alt="<?php echo esc_attr($fest_img['title']); ?>">
                      <?php } ?>
                    </figure>
                    <div class="festival-sched-details">
                      <h3 class="titleDiv">
                        <?php echo $fest_title; ?>
                      </h3>
                      <div class="contentDiv">
                        <?php echo $fest_content; ?>
                      </div>
                      <?php if($fest_link_text && $fest_url_link) { ?>
                        <div class="text-center button-small">
                          <a href="<?php echo $fest_url_link; ?>" target="<?php echo $fest_link_target; ?>"><?php echo $fest_link_text; ?></a>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <?php endwhile; ?>
              </div> <!-- END carousel -->
              <!-- If we need pagination -->
              <div class="swiper-pagination"></div>
            <?php endif; ?>
          </div>
          <!-- If we need navigation buttons -->
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
          <div class="text-center mb-40">
            <?php echo $festival_content; ?>
          </div>
          <?php if($festival_link_text && $festival_url_link) { ?>
            <div class="text-center">
              <a href="<?php echo $festival_url_link; ?>" target="<?php echo $festival_link_target; ?>" class="button-big"><?php echo $festival_link_text; ?></a>
            </div>
          <?php } ?>
        </div>
      </section>
    <?php } ?>
    <!-- Festival Schedule END -->

    <!-- Live Music -->
    <?php
        if( have_rows('live_music_artists') ){
        $live_music_title = get_field('live_music_title');
    ?>
      <section class="live-music">
        <div class="wrapper">
          <h2 class="pagetitle text-center"><?php echo $live_music_title; ?></h2>
          <div class="live-music-artists feeds-wrapper cf">
            <?php
              $count = 1;
              $rows = get_field('live_music_artists'); 
              $count_column = count($rows);

              while( have_rows('live_music_artists') ): the_row();

              $music_artist = get_sub_field('music_artist');
              //$custom_field = get_field( 'field_name', $music_artist->ID );
              $post_id = $music_artist-> ID;
              $music_artist_title = get_the_title($post_id);
              $thumbnail_id = get_post_thumbnail_id($post_id);
              $featImage = wp_get_attachment_image_src($thumbnail_id,'large');
              $imageStyle = ($featImage) ? ' style="background-image:url('.$featImage[0].')"':'';
              $postType = get_post_type($post_id);
              $postTypeTitle = 'post-type-'.$postType;
              $pagelink = ($postType=='artists') ? 'javascript:void(0)' : get_permalink($post_id);
              $popup = ($postType=='artists') ? 'popup-activity' : '';
              $location_time = get_field('location_time', $post_id);
              $spotify = get_field('spotify_embed', $post_id);
              $column = ($count==1 && $count_column==3) ? 'column column_full' : 'column column_half';
            ?>
            <div data-postid="<?php echo $post_id ?>" class="<?php echo $postTypeTitle . ' ' . $column; ?>">
              <div class="inner">
                <div class="image">
                  <figure<?php echo $imageStyle ?>>
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/square.png" class="helper" alt="">
                  </figure>
                </div>
                <h4 class="title"><?php echo $music_artist_title; ?></h4>
                <?php
                  if($spotify){ ?>
                  <div class="button-small">
                    <a href="<?php echo $pagelink; ?>" data-id="<?php echo $post_id ?>" class="<?php echo $popup; ?> see-details">See Details</a>
                  </div>
                <?php
                  }

                  if( $location_time ){
                  $j = 1;

                  foreach( $location_time as $detail ) {
                    $location = $detail['location'][0];
                    $time = $detail['start_time'];
                    $title = $detail['title'];

                    if($count!=1 && $location && $time) {
                ?>
                  <div class="schedule">
                    <div class="location"><?php echo $location; ?></div>
                    <div class="time"><?php echo $time; ?></div>
                  </div>
                  <?php if($title){ ?>
                    <!-- <div class="cf more-details" data-id="<?php echo $post_id; ?>" data-item="<?php echo $j; ?>">
                      <a href="<?php echo $pagelink; ?>" class="learn-more">Learn More</a>
                    </div> -->
                  <?php
                    }
                    $j++; 
                  }
                }
              }
              ?>
              </div>
            </div>
            <?php
              $count++;

              endwhile;
            ?>
          </div>
        </div>
      </section>
    <?php } ?>
    <!-- Live Music END -->

    <!-- Contact Information -->
    <?php
        $contact_info_title = get_field('contact_information_title');
        $map = get_field('google_map');
        $address = get_field('contact_address');
        $phone = get_field('contact_phone');
        $details = get_field('online_content');
        $contact = get_field('contact-info-group');
        $section_class = ($map && $address) ? 'half':'full';

        if($address || $map) {
    ?>
      <section class="<?php echo $section_class ?> contact-info">
        <div class="wrapper">
          <h2 class="pagetitle text-center"><?php echo $contact_info_title; ?></h2>
          <div class="flexwrap">
            <?php if($map) { ?>
              <div class="flexcol map">
                <?php echo $map; ?>
                <img src="<?php echo THEMEURI ?>images/square.png" alt="" class="iframe-resizer">
              </div>
            <?php } ?>
            <?php if( $address ) { ?>
              <div class="flexcol contact">
                <div>
                  <?php if ($address) { ?>
                    <h3>ADDRESS:</h3>
                    <div><?php echo $address; ?></div>
                  <?php } ?>
                  <?php if ($phone) { ?>
                    <h3>PHONE:</h3>
                    <div><?php echo $phone; ?></div>
                  <?php } ?>
                  <?php if ($details) { ?>
                    <h3>ONLINE:</h3>
                    <div class="text"><?php echo anti_email_spam($details); ?></div>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </section>
    <?php } ?>
    <!-- Contact Information END -->

		<?php endwhile; // End of the loop. ?>

	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer('new');
