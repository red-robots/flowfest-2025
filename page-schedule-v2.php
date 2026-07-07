<?php
/**
 * Template Name: Schedule Page 2.0
 *
 */
get_header();
?>

<div id="primary" class="content-area-full content-default-template">
  <main id="main" class="site-main" role="main">

    <?php while ( have_posts() ) : the_post(); ?>
      <div class="wrapper">
        <h1 class="pagetitle text-center"><?php the_title(); ?></h1>
      </div>
      <?php if ( get_the_content() ) {  ?>
        <div class="wrapper"><?php get_template_part( 'parts/content', 'page' ); ?></div>
      <?php } ?>
    <?php endwhile; ?>

    <?php
    $post_types = array( 'practices', 'workshops', 'festival' );
    $days = array(
      'saturday' => 'Saturday',
      'sunday'   => 'Sunday',
    );
    ?>
    <section class="schedule-activities schedule-new schedule-v2">
      <div class="wrapper">
        <div class="indication">
          <div class="header">Legend:</div>
          <div class="indication-practices">Practices</div>
          <div class="indication-workshops">Workshops</div>
          <div class="indication-festival">Festival</div>
        </div>

        <div class="schedule-tabs">
          <ul class="schedule-tabs__nav" role="tablist">
            <?php $is_first_tab = true; ?>
            <?php foreach ( $days as $day_slug => $day_label ) : ?>
              <li role="presentation">
                <button
                  type="button"
                  class="schedule-tabs__tab<?php echo $is_first_tab ? ' is-active' : ''; ?>"
                  role="tab"
                  id="schedule-tab-<?php echo esc_attr( $day_slug ); ?>"
                  aria-selected="<?php echo $is_first_tab ? 'true' : 'false'; ?>"
                  aria-controls="schedule-panel-<?php echo esc_attr( $day_slug ); ?>"
                  data-tab="<?php echo esc_attr( $day_slug ); ?>"
                >
                  <?php echo esc_html( $day_label ); ?>
                </button>
              </li>
              <?php $is_first_tab = false; ?>
            <?php endforeach; ?>
          </ul>

          <div class="schedule-tabs__panels">
            <?php $is_first_panel = true; ?>
            <?php foreach ( $days as $day_slug => $day_label ) : ?>
              <?php
              $schedule        = flowfest_get_events_grouped_by_time( $day_slug, $post_types );
              $event_date_label = $schedule['date'] ? strtoupper( date( 'F j, Y', strtotime( $schedule['date'] ) ) ) : '';
              $event_day_label  = $schedule['date'] ? strtoupper( date( 'l', strtotime( $schedule['date'] ) ) ) : strtoupper( $day_label );
              ?>
              <div
                class="schedule-tabs__panel<?php echo $is_first_panel ? ' is-active' : ''; ?>"
                role="tabpanel"
                id="schedule-panel-<?php echo esc_attr( $day_slug ); ?>"
                aria-labelledby="schedule-tab-<?php echo esc_attr( $day_slug ); ?>"
                data-panel="<?php echo esc_attr( $day_slug ); ?>"
                <?php echo $is_first_panel ? '' : 'hidden'; ?>
              >
                <?php if ( $event_date_label ) { ?>
                  <div class="schedule-title">
                    <h3><?php echo esc_html( $event_date_label ); ?></h3>
                    <p class="dayName"><?php echo esc_html( $event_day_label ); ?></p>
                  </div>
                <?php } ?>

                <?php foreach ( $schedule['groups'] as $group_slug => $group ) : ?>
                  <?php if ( empty( $group['events'] ) ) {
                    continue;
                  } ?>
                  <div class="schedule-time-group" data-time-group="<?php echo esc_attr( $group_slug ); ?>">
                    <h4 class="schedule-time-group__title"><?php echo esc_html( $group['label'] ); ?></h4>
                    <div class="activities">
                      <?php foreach ( $group['events'] as $event ) : ?>
                        <?php
                        $instructor_terms = get_the_terms( $event['post_id'], 'instructors-list' );
                        $instructorData = ( isset($instructor_terms[0]) ) ? $instructor_terms[0] : null;
                        $instructorName = ( isset($instructorData->name) ) ? $instructorData->name : '';
                        $location_terms = get_the_terms( $event['post_id'], 'locations-list' );
                        $locationData = ( isset($location_terms[0]) ) ? $location_terms[0] : null;
                        $locationName = ( isset($locationData->name) ) ? $locationData->name : '';
                        ?>
                        <div class="item" data-postid="<?php echo esc_attr( $event['post_id'] ); ?>" data-posttypeslug="<?php echo esc_attr( $event['post_type'] ); ?>">
                          <div class="sched-popup <?php echo esc_attr( $event['post_type'] ); ?>">
                            <a href="javascript:void(0)" class="popup-activity popup-activity-schedule <?php echo esc_attr( $event['post_type'] ); ?> sched-title" data-id="<?php echo esc_attr( $event['post_id'] ); ?>">
                              <div class="time-and-name">
                                <?php if ( $event['time'] ) { ?>
                                  <span class="time"><?php echo esc_html( $event['time'] ); ?></span>
                                <?php } else { ?>
                                  <span class="time-NA"></span>
                                <?php } ?>
                                <span class="name"><?php echo esc_html( $event['title'] ); ?></span>
                              </div>
                              
                              <?php if ( $instructorName || $locationName ) { ?>
                              <div class="instructor-and-location">
                                <?php if ( $instructorName ) { ?>
                                  <div class="instructor-name"><?php echo esc_html( $instructorName ); ?></div>
                                <?php } ?>
                                <?php if ( $locationName ) { ?>
                                  <div class="location-name"><?php echo esc_html( $locationName ); ?></div>
                                <?php } ?>
                              </div>
                              <?php } ?>
                              <i class="fa fa-external-link" aria-hidden="true"></i>
                            </a>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
              <?php $is_first_panel = false; ?>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </section>

	</main><!-- #main -->
</div><!-- #primary -->

<script>
  jQuery(document).ready(function($){
    $('.schedule-tabs__tab').on('click', function(){
      var tab = $(this).data('tab');
      var $tabs = $(this).closest('.schedule-tabs');

      $tabs.find('.schedule-tabs__tab').removeClass('is-active').attr('aria-selected', 'false');
      $(this).addClass('is-active').attr('aria-selected', 'true');

      $tabs.find('.schedule-tabs__panel').removeClass('is-active').attr('hidden', true);
      $tabs.find('.schedule-tabs__panel[data-panel="' + tab + '"]').addClass('is-active').removeAttr('hidden');
    });
  });
</script>
<?php
get_footer();
