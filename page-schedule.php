<?php
/**
 * Template Name: Schedule
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ACStarter
 */

get_header(); 
$CS = get_field('coming_soon'); 
?>

  <div id="primary" class="content-area-full content-default-template">
    <main id="main" class="site-main" role="main">

      <?php if( $CS[0] == 'soon' ) { ?>
        <section class="coming-soon">
          <div>Coming Soon</div>
        </section>
      <?php } else { ?>

			<?php while ( have_posts() ) : the_post(); ?>
        <?php if ( get_the_content() ) {  ?>
          <div class="wrapper"><?php get_template_part( 'parts/content', 'page' ); ?></div>
        <?php } ?>
      <?php endwhile; ?>

			<?php 
        $evDate = get_field('event_date',get_the_ID());
        $eventDay = ($evDate) ? date('l',strtotime($evDate)) : '';
        $activities = get_field('activities',get_the_ID());
        // $postTypes['festival'] = 'Festival Activities';
        // $postTypes['practices'] = 'Practices';
        // $postTypes['workshops'] = 'Workshops';
        // $postTypes['other'] = 'Other';
        // $postTypes = scheduled_activities_filter();
        $postTypeList = array();
        if($activities) {
      ?>
      <section class="schedule-activities">
        <div class="wrapper">
          <?php if ($evDate) { ?>
          <div class="schedule-title">
            <h3><?php echo date('F j, Y',strtotime($evDate)) ?></h3>
            <p class="dayName"><?php echo $eventDay ?></p>
          </div>
          <?php } ?>

          <div class="filter-option">
            <label>Filter By</label> 
            <div class="select-wrap">
              <select name="filterby" id="filterby" class="js-select2" multiple>
                <!-- <option value="all">All</option> -->
              </select>
              <span id="select2-selected-options">All</span>
            </div>
          </div>

          <div class="activities">
            <?php 
            // echo '<pre>';
            // print_r($activities);

            foreach ($activities as $a) { 
              $time = (isset($a['time']) && $a['time']) ? $a['time'] : '';
              $custom_title = $a['custom_title'];
              $item = $a['activity'];
              $postid = (isset($item->ID) && $item->ID) ? $item->ID : '';
              $show_popup = (isset($a['popup_info'][0]) && $a['popup_info'][0]=='Yes') ? true:false;
              $cpt = ($postid) ? get_post_type($postid) : 'other';
              //$postTypeName = ( scheduled_activities_filter($cpt) ) ? scheduled_activities_filter($cpt) : 'Other';
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
            ?>
            <div class="item" data-postid="<?php echo $postid ?>" data-posttypename="<?php echo $postTypeLabel ?>" data-posttypeslug="<?php echo $cpt ?>">

              <?php if ( $item ) { ?>
                <?php if ($show_popup) { ?>
                  <?php if ($time) { ?>
                    <span class="time"><?php echo $time ?></span>
                  <?php } else { ?>
                    <span class="time-NA"></span>
                  <?php } ?>
                  <span class="name"><a class="popup-activity <?php echo $cpt ?>" href="javascript:void(0)" data-id="<?php echo $postid ?>"><?php echo $item_title ?></a></span>
                  <div class="border-bottom"></div>
                <?php } else { ?>
                  <div class="sched-accordion">
                    <a href="javascript:void(0)" class="sched-title" data-id="<?php echo $postid ?>">
                      <?php if ($time) { ?>
                        <span class="time"><?php echo $time ?></span>
                      <?php } else { ?>
                        <span class="time-NA"></span>
                      <?php } ?>
                      <span class="name <?php echo $cpt ?>"><?php echo $item_title ?></span>
                      <span class="plus-minus-toggle"></span>
                      <div class="border-bottom"></div>
                    </a>
                    <div class="sched-content">
                      <?php echo 'hi'; ?>
                  </div>
                  </div>
                <?php } ?>
              <?php } ?>
            </div>
            
            <?php } ?>
          </div>
        </div>
      </section>
			<?php } ?>
			<?php } ?>

		</main><!-- #main -->
	</div><!-- #primary -->

  <script>
    jQuery(document).ready(function($){
      // adjustBorderBottom();
      // $(window).on('orientationchange resize',function(){
      //   adjustBorderBottom();
      // });
      // function adjustBorderBottom() {
      //   $('.activities .item').each(function(){
      //     var target = $(this);
      //     var time_span = ( target.find('.time').length ) ? target.find('.time').width() + 10 : 0;
      //     var name_span = ( target.find('.name').length ) ? target.find('.name').width() : 0;
      //     var border_bottom = target.width();
      //     var new_border_width = border_bottom - (time_span+name_span+10);
      //     target.find('.border-bottom').css({
      //       'width':new_border_width+'px',
      //       'left':time_span+'px'
      //     });
      //   });
      // }

      var postTypeList = <?php echo ( $postTypeList ) ? @json_encode($postTypeList):'[]' ?>;
      var filter_options = [];
      if( $('[data-posttypename]').length ) {
        var postTypes = [];
        $('[data-posttypename]').each(function(){
          var name = $(this).attr('data-posttypename');
          var slug = $(this).attr('data-posttypeslug');
          var arg = {'name':name,'slug':slug};
          postTypes.push(slug);
        });

        filter_options = unique(postTypes).sort();
        $( filter_options ).each(function(k,slug){
          if(typeof postTypeList[slug]!=='undefined' && postTypeList[slug]!==null) {
            var select_option  = '<option value="'+slug+'">'+postTypeList[slug]+'</option>';
            $('#filterby').append(select_option);
          }
        });
      }

      function unique(list) {
        var result = [];
        $.each(list, function(i, e) {
          if ($.inArray(e, result) == -1) result.push(e);
        });
        return result;
      }

      /* Filter */
      $(".js-select2").select2({
        closeOnSelect : false,
        placeholder : "",
        allowClear: true
      });

      //var totalOptions = parseInt(filter_options.length) + 1;
      var totalOptions = filter_options.length;


      // $('.js-select2').on("select2:select", function(e) { 
      //   var count = $('ul.select2-selection__rendered li.select2-selection__choice').length;
      //   var selectedVal = 'Selected '+count+' of '+totalOptions;
      //   $('#select2-selected-options').text(selectedVal);
      //   if(jQuery.inArray("all", $('select#filterby').val()) !== -1) {
      //     $('select#filterby').select2('destroy').find('option').prop('selected', 'selected').end().select2({
      //       closeOnSelect : false,
      //       placeholder : "",
      //       allowClear: true
      //     });
      //     $('.filter-option .select2-container').append('<span id="select2-selected-options">Selected 0 of '+totalOptions+'</span>');
      //     var selectedAll = 'Selected '+totalOptions+' of '+totalOptions;
      //     $('#select2-selected-options').text(selectedAll);
      //   }
      // });

      $('#filterby').on('change',function(){
        var opt = this.value;
        //var count = $('ul.select2-selection__rendered li.select2-selection__choice').length;
        var selectedFilters = $('select#filterby').val();
        var count = selectedFilters.length;

        if(count==totalOptions) {
          $('[data-posttypeslug]').each(function(){
            $(this).show();
          });
          $('select#filterby').select2('destroy').find('option').prop('selected', 'selected').end().select2({
            closeOnSelect : false,
            placeholder : "",
            allowClear: true
          });
          $('#select2-selected-options').text('All');
        } else {

          if(count==0) {
            $('#select2-selected-options').text('All');
            $('[data-posttypeslug]').each(function(){
              $(this).show();
            });
          } else {
            var selectedVal = 'Selected '+count+' of '+totalOptions;
            $('#select2-selected-options').text(selectedVal);

            $('[data-posttypeslug]').each(function(){
              $(this).hide();
            });
            $(selectedFilters).each(function(k,v){
              $('[data-posttypeslug="'+v+'"]').show();
            });
          }

        }

      });


    });
  </script>
<?php
get_footer();