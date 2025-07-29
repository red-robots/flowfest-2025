<?php 
/**
 * Template Name: Yoga Immersion
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bellaworks
 */

get_header('new'); ?>
<div id="primary" class="home-content content-area-full yoga-immersion">
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
              $register_btn = get_field('register_button');

              if( $register_btn ):
                  $register_btn_text = (isset($register_btn['title']) && $register_btn['title']) ? $register_btn['title'] : '';
                  $register_btn_link = (isset($register_btn['url']) && $register_btn['url']) ? $register_btn['url'] : '';
                  $register_btn_target = (isset($register_btn['target']) && $register_btn['target']) ? $register_btn['target'] : '_self';
            ?>
              <div class="buttons-content">
                  <a href="<?php echo $register_btn_link; ?>" target="<?php echo $register_btn_target; ?>" class="button_<?php echo $i; ?>"><?php echo $register_btn_text; ?></a>
              </div>
            <?php endif; ?>
      </article>
    <?php } ?>

    <!-- Schedule -->
    <?php if( have_rows('schedule') ): ?>
      <section class="schedule-activities">
        <div class="wrapper">
          <h2 class="pagetitle text-center">Schedule</h2>
            <?php
              while( have_rows('schedule') ): the_row();
                $event_date = get_sub_field('event_date');
                $event_date_complete = date('F j, Y',strtotime($event_date));
                $event_day = ($event_date) ? date('l',strtotime($event_date)) : '';
                $activities = get_sub_field('activities');

                if($event_date) {
            ?>
              <div class="schedule-list">
                <div class="schedule-title text-center">
                  <?php echo  $event_date_complete .' - '. $event_day; ?>
                </div>
                <div class="activities">
                  <?php
                    if( have_rows('activities') ):
                      foreach ($activities as $activity) {
                        $time = (isset($activity['time']) && $activity['time']) ? $activity['time'] : '';
                        $custom_title = $activity['custom_title'];
                        $item = $activity['activity'];
                        $postid = (isset($item->ID) && $item->ID) ? $item->ID : '';
                        $dropdown = (isset($activity['dropdown_info'][0]) && $activity['dropdown_info'][0]=='Yes') ? true:false;
                        $cpt = ($postid) ? get_post_type($postid) : 'other';
                        $item_title = (isset($item->post_title) && $item->post_title) ? $item->post_title : '';
                        if($custom_title) {
                          $item_title = $custom_title;
                        }
                        if($cpt=='page') {
                          $cpt='other';
                        }
                        if($postid) {
                          $post_type_obj = get_post_type_object( get_post_type($postid) );
                          $postTypeLabel = $post_type_obj->label;
                          if($postTypeLabel=='Pages') {
                            $postTypeLabel = 'Other';
                          }
                          $postTypeList[$cpt] = $postTypeLabel;
                        }
                        
                        if ( $item ) { ?>
                        <div class="item" data-posttypename="<?php echo $postTypeLabel ?>" data-posttypeslug="<?php echo $cpt ?>">
                          <div class="sched-accordion <?php echo $cpt ?> <?php echo ($dropdown) ? 'has-plus' : 'no-plus'; ?>">
                            <?php if ($time) { ?>
                              <span class="time"><?php echo $time ?></span>
                            <?php } else { ?>
                              <span class="time-NA"></span>
                            <?php } ?>

                            <div class="sched-title <?php echo ($dropdown) ? 'show-sched' : ''; ?>" data-id="<?php echo $postid ?>">
                              <?php if ($dropdown) { ?>
                                <span class="name"><a class="<?php echo $cpt ?>" href="javascript:void(0)" data-id="<?php echo $postid ?>"><?php echo $item_title ?></a></span>
                                  <span class="plus-minus-toggle"></span>
                              <?php } else { ?>
                                <span class="name <?php echo $cpt ?>"><?php echo $item_title ?></span>
                              <?php } ?>
                            </div>
                            <div class="sched-content"></div>
                          </div>
                      </div>
                    <?php } ?>
                  <?php } endif; ?>
                </div>
              </div>
            <?php
                }
              endwhile;
            ?>

          
        </div>
      </section>

    <?php
      endif;
    ?>
    <!-- Schedule END -->

    <!-- Instructor -->
    <?php      
      $instructor_name = get_field('instructor_name');
      $instructor_details = get_field('instructor_details');
      $instructor_image = get_field('instructor_image');

      if($instructor_name || $instructor_image) {
        $instructor_button = get_field('instructor_button');
        $instructor_button_text = (isset($instructor_button['title']) && $instructor_button['title']) ? $instructor_button['title'] : '';
        $instructor_button_url = (isset($instructor_button['url']) && $instructor_button['url']) ? $instructor_button['url'] : '';
        $instructor_button_target = (isset($instructor_button['target']) && $instructor_button['target']) ? $instructor_button['target'] : '_self';
    ?>
      <section class="instructor">
      <div class="wrapper">
        <h2 class="pagetitle text-center">Instructor</h2>
        <div class="flexwrap">
        <?php if ($instructor_image) { ?>
          <div class="flexcol">
            <div class="photo">
              <figure>
                <img src="<?php echo $instructor_image['sizes']['large']; ?>" alt="">
                <!-- <img src="<?php echo THEMEURI ?>images/image-helper.png" alt=""> -->
              </figure>
            </div>
          </div>
        <?php } ?>
        <div class="flexcol">
          <h3 class="pagetitle"><?php echo $instructor_name; ?></h3>
          <div>
            <?php if ($instructor_details) { ?>
              <div><?php echo $instructor_details; ?></div>
            <?php } ?>
            <?php if($instructor_button_text && $instructor_button_url) { ?>
              <div class="button-small">
                <a href="<?php echo $instructor_button_url; ?>" target="<?php echo $instructor_button_target; ?>"><?php echo $instructor_button_text; ?></a>
              </div>
            <?php } ?>
          </div>
        </div>
        </div>
      </div>
      </section>
    <?php } ?>
    <!-- Instructor END -->

    <!-- Contact Information -->
    <?php get_template_part('parts/flexible-content'); ?>
    <!-- Contact Information END -->

		<?php endwhile; // End of the loop. ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
		/* FAQS JAVASCRIPT */ 
		include( locate_template('inc/faqs-script.php') ); 

get_footer('new');
