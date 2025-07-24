<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package bellaworks
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
define('THEMEURI',get_template_directory_uri() . '/');


add_image_size('big-square', 500, 500, array('center','center'));


function exclude_post_types_banner() {
    $post_types = array('race','dining');
    return $post_types;
}
function bellaworks_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    if ( is_front_page() || is_home() ) {
        $classes[] = 'homepage';
    } else {
        $classes[] = 'subpage';
    }

    $browsers = ['is_iphone', 'is_chrome', 'is_safari', 'is_NS4', 'is_opera', 'is_macIE', 'is_winIE', 'is_gecko', 'is_lynx', 'is_IE', 'is_edge'];
    $classes[] = join(' ', array_filter($browsers, function ($browser) {
        return $GLOBALS[$browser];
    }));

    return $classes;
}
add_filter( 'body_class', 'bellaworks_body_classes' );

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
}


function add_query_vars_filter( $vars ) {
  $vars[] = "pg";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );


function shortenText($string, $limit, $break=".", $pad="...") {
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }

  return $string;
}

/* Fixed Gravity Form Conflict Js */
add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() {
    return true;
}

add_shortcode( 'team_list', 'team_list_shortcode_func' );
function team_list_shortcode_func( $atts ) {
  $a = shortcode_atts( array(
    'numcol'=>3
  ), $atts );
  $numcol = ($a['numcol']) ? $a['numcol'] : 3;
  $output = '';
  ob_start();
  //include( locate_template('parts/team_feeds.php') );
  get_template_part('parts/team_feeds',null,$a);
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}


add_shortcode( 'feeds', 'feeds_shortcode_func' );
function feeds_shortcode_func( $atts ) {
  $output = '';
  $a = shortcode_atts( array(
    'post'=>'',
    'filter'=>'',
    'perpage'=>'-1'
  ), $atts );
  
  $filter = (isset($a['filter']) && $a['filter']) ? $a['filter'] : '';
  $post_type = (isset($a['post']) && $a['post']) ? $a['post'] : '';
  $perpage = (isset($a['perpage']) && $a['perpage']) ? $a['perpage'] : '-1';
  $paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
  if($post_type) {
    ob_start();
    $args = array(
      'posts_per_page'  => $perpage,
      'post_type'       => $post_type,
      'post_status'     => 'publish',
      'paged'           => $paged,
      'facetwp'         => true,
      'orderby'         => 'menu_order',
      'order'           => 'ASC'
    );
    include( locate_template('parts/feeds.php') );
    $output = ob_get_contents();
    ob_end_clean();
    if($output) {
      $pattern = "/<p[^>]*><\\/p[^>]*>/"; 
      $output = str_replace('<p></p>','',$output);
      $output = preg_replace( $pattern, '', $output );
      $output = preg_replace('/<br>|\n|<br( ?)\/>/', '', $output);
    }
  }
  return $output;
}

function get_page_id_by_template($fileName) {
    $page_id = 0;
    if($fileName) {
        $pages = get_pages(array(
            'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => $fileName.'.php'
        ));

        if($pages) {
            $row = $pages[0];
            $page_id = $row->ID;
        }
    }
    return $page_id;
}

function string_cleaner($str) {
    if($str) {
        $str = str_replace(' ', '', $str); 
        $str = preg_replace('/\s+/', '', $str);
        $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str);
        $str = strtolower($str);
        $str = trim($str);
        return $str;
    }
}

function format_phone_number($string) {
    if(empty($string)) return '';
    $append = '';
    if (strpos($string, '+') !== false) {
        $append = '+';
    }
    $string = preg_replace("/[^0-9]/", "", $string );
    $string = preg_replace('/\s+/', '', $string);
    return $append.$string;
}

function get_instagram_setup() {
    global $wpdb;
    $result = $wpdb->get_row( "SELECT option_value FROM $wpdb->options WHERE option_name = 'sb_instagram_settings'" );
    if($result) {
        $option = ($result->option_value) ? @unserialize($result->option_value) : false;
    } else {
        $option = '';
    }
    return $option;
}


function get_social_links() {
    $social_types = social_icons();
    $social = array();
    // foreach($social_types as $k=>$icon) {
    //     $value = get_field($k,'option');
    //     if($value) {
    //         $social[$k] = array('link'=>$value,'icon'=>$icon);
    //     }
    // }
    $links = get_field('social_media_links','option');
    if($links) {
      foreach($social_types as $type=>$icon) {
        foreach($links as $obj) {
          if( $url = $obj['link'] ) {
            if (strpos($url, $type) !== false) {
              $social[$type] = array(
                      'icon'=>$icon,
                      'name'=>ucwords($type),
                      'link'=>$url
                    );
            }
          }
        }
      }
    }
    return $social;
}

function social_icons() {
    $social_types = array(
        'facebook'  => 'fab fa-facebook-f',
        'twitter'   => 'fab fa-twitter',
        'linkedin'  => 'fab fa-linkedin-in',
        'instagram' => 'fab fa-instagram',
        'youtube'   => 'fab fa-youtube',
        'snapchat'  => 'fab fa-snapchat-ghost',
    );
    return $social_types;
}

function parse_external_url( $url = '', $internal_class = 'internal-link', $external_class = 'external-link') {

    $url = trim($url);

    // Abort if parameter URL is empty
    if( empty($url) ) {
        return false;
    }

    //$home_url = parse_url( $_SERVER['HTTP_HOST'] );     
    $home_url = parse_url( home_url() );  // Works for WordPress

    $target = '_self';
    $class = $internal_class;

    if( $url!='#' ) {
        if (filter_var($url, FILTER_VALIDATE_URL)) {

            $link_url = parse_url( $url );

            // Decide on target
            if( empty($link_url['host']) ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } elseif( $link_url['host'] == $home_url['host'] ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } else {
                // Is an external link
                $target = '_blank';
                $class = $external_class;
            }
        } 
    }

    // Return array
    $output = array(
        'class'     => $class,
        'target'    => $target,
        'url'       => $url
    );

    return $output;
}


add_action( 'wp_ajax_nopriv_get_post_info', 'get_post_info' );
add_action( 'wp_ajax_get_post_info', 'get_post_info' );
function get_post_info() {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $post_id = ($_POST['postid']) ? $_POST['postid'] : 0;
    $post = get_post($post_id);
    $html = '';
    if($post) {
      ob_start();
      include(locate_template('parts/popup_content.php'));
      $html = ob_get_contents();
      ob_end_clean();
    }
    $response['content'] = $html;
    echo json_encode($response);
  }
  else {
    header("Location: ".$_SERVER["HTTP_REFERER"]);
  }
  die();
}

function my_ajax_files() {
 wp_localize_script( 'function', 'my_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('template_redirect', 'my_ajax_files');


add_action( 'wp_ajax_nopriv_getPostData', 'getPostData' );
add_action( 'wp_ajax_getPostData', 'getPostData' );
function getPostData() {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $post_id = ($_POST['post_id']) ? $_POST['post_id'] : 0;
    $post = get_post($post_id);
    $html = ($post) ? getPostContentHTML($post) : '';
    
    $response['content'] = $html;
    echo json_encode($response);
  }
  else {
    header("Location: ".$_SERVER["HTTP_REFERER"]);
  }
  die();
}
function getPostContentHTML($obj) {
  $post_id = $obj->ID;
  $post_title = $obj->post_title;
  $content = $obj->post_content;
  $content = apply_filters('the_content',$content); 
  ob_start(); ?>
  <div id="event-details" class="fullwidth-block event-details animated fadeIn">
    <div class="inner">
      <a href="javascript:void(0)" class="close-event-info"></a>
      <h2 class="eventtitle"><?php echo $post_title ?></h2>
      <div class="eventinfo"><?php echo $content ?></div>
    </div>
  </div>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}


/* Disable Gutenberg by post_type */
function ea_disable_gutenberg( $can_edit, $post_type ) {

  if( ! ( is_admin() && (!empty($_GET['post']) || !empty($_GET['post_type'])) ) )
    return $can_edit;

  $exclude_post_types = ['schedule'];
  $current_post_type = get_post_type($_GET['post']);

  if( in_array($current_post_type,$exclude_post_types) )
    $can_edit = false;

  // if( in_array($_GET['post_type'],$exclude_post_types) )
  //   $can_edit = false;

  return $can_edit;

}
add_filter( 'gutenberg_can_edit_post_type', 'ea_disable_gutenberg', 10, 2 );
add_filter( 'use_block_editor_for_post_type', 'ea_disable_gutenberg', 10, 2 );


function flowfest_admin_footer_script() { ?>
<script type="text/javascript">
jQuery(document).ready(function($){
  $('[data-name="event_date"] .acf-input-wrap input.input').on('keyup blur focusout change',function(){
    var selectedDate = this.value.trim();
    $('#titlewrap input[name="post_title"]').val(selectedDate);
  });
  $('body.post-type-schedule #titlewrap').append('<div class="disable-input"></div>');
});
</script>
<?php
}
add_action( 'admin_footer', 'flowfest_admin_footer_script' );

function flowfest_admin_header_script() { ?>
<style type="text/css">
  body.post-type-schedule #edit-slug-box {display:none!important;}
  /*body.post-type-schedule input[name="post_title"] {opacity:0.5;}*/
  body.post-type-schedule #titlewrap {position:relative;cursor:not-allowed;visibility:hidden;z-index:-999;height:0;overflow:hidden;}
  body.post-type-schedule #titlewrap .disable-input{
    position: absolute;
    top: 0;
    left: 0;
    z-index: 10;
    width: 100%;
    height: 100%;
    background: rgba(#F0F0F1,.35);
  }
  .wp-block-button__link {background-color: #b16b4f;}
</style>
<?php
}
add_action( 'admin_head', 'flowfest_admin_header_script' );


add_action('acf/save_post', 'flowfest_acf_save_post', 5);
function flowfest_acf_save_post( $post_id ) {
  if( get_post_type($post_id)=='schedule' ) {
    // Check if a specific value was updated.
    if( isset($_POST['acf']['field_62846d814a1dc']) ) {
      $new_date = $_POST['acf']['field_62846d814a1dc'];
      $event_date = date('m-d-Y',strtotime($new_date));
      $new_info = array(
        'post_name' => $event_date,
        'ID' => $post_id
      );
      wp_update_post($new_info);
    }
  }
}

/* Query latest scheduled activities */
function get_scheduled_activity() {
  global $wpdb;
  $today = date('Ymd');
  $query = "SELECT p.ID, p.post_title FROM ".$wpdb->prefix."postmeta m, ".$wpdb->prefix."posts p WHERE p.ID=m.post_id AND CAST(m.meta_value AS date) >= NOW() AND m.meta_key='event_date' AND p.post_status='publish' AND p.post_type='schedule' LIMIT 1";
  $result = $wpdb->get_results($query);
  return ($result) ? $result[0] : '';
}


add_action( 'wp_ajax_nopriv_get_post_basic_content', 'get_post_basic_content' );
add_action( 'wp_ajax_get_post_basic_content', 'get_post_basic_content' );
function get_post_basic_content() {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $post_id = ($_POST['postid']) ? $_POST['postid'] : 0;
    $post = get_post($post_id);
    $html = '';
    if($post) {
      ob_start();
      include(locate_template('parts/popup_content_activity.php'));
      $html = ob_get_contents();
      ob_end_clean();
    }
    $response['content'] = $html;
    echo json_encode($response);
  }
  else {
    header("Location: ".$_SERVER["HTTP_REFERER"]);
  }
  die();
}

function scheduled_activities_filter($key=null) {
  $postTypes['festival'] = 'Festival Activities';
  $postTypes['practices'] = 'Practices';
  $postTypes['workshops'] = 'Workshops';
  $postTypes['other'] = 'Other';
  if($key) {
    return ( isset($postTypes[$key]) && $postTypes[$key] ) ? $postTypes[$key] : '';
  } else {
    return $postTypes;
  }
}

// Music - Learn more
add_action( 'wp_ajax_nopriv_activity_learn_more', 'activity_learn_more' );
add_action( 'wp_ajax_activity_learn_more', 'activity_learn_more' );
function activity_learn_more() {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $post_id = ($_POST['postId']) ? $_POST['postId'] : 0;
    $item = ($_POST['item']) ? $_POST['item'] : 1;

    if($post_id) {
      ob_start();
      include(locate_template('parts/popup_content_more.php'));
      $html = ob_get_contents();
      ob_end_clean();
    }

    $response['content'] = $html;
    echo json_encode($response);

  }
  else {
    header("Location: ".$_SERVER["HTTP_REFERER"]);
  }
  die();
}


/* SOCIAL MEDIA SHORTCODE */
add_shortcode( 'display_social_media', 'display_social_media_func' );
function display_social_media_func( $atts ){
  $a = shortcode_atts( array(
    'exclude' => '',
  ), $atts );
  
  $exclude = (isset($a['exclude']) && $a['exclude']) ? explode(',',$a['exclude']) : '';
  $links = get_social_links();
  if($exclude) {
    foreach($links as $k=>$v) {
      if(in_array($k,$exclude)) {
        unset($links[$k]);
      }
    }
  } 

  $output = '';
  ob_start();
  if($links) { ?>
    <div class="social-media-links">
      <?php foreach ($links as $key=>$val) { ?>
        <div><a href="<?php echo $val['link'] ?>" target="_blank" class="<?php echo $key ?>-link" aria-label="<?php echo $val['name'] ?>"><i class="<?php echo $val['icon'] ?>"></i></a></div>
      <?php } ?>
    </div>
  <?php }
  $output = ob_get_contents();
  ob_end_clean();
  
  return $output;
}



