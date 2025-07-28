<?php
/**
 * Template Name: Flexible Content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bellaworks
 */

get_header(); 

$CS = get_field('coming_soon'); 
// echo '<pre>';
// print_r($CS);
// echo '</pre>';
?>

	<div id="primary" class="content-area-full default-template">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<div class="wrapper">
					<h1 class="pagetitle text-center"><?php the_title(); ?></h1>
				</div>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<?php if( !empty($CS) && $CS[0] === 'soon' ) { ?>
						<section class="coming-soon">
							<div>Coming Soon</div>
						</section>
					<?php } else { ?>
						<section class="teasers">
							<?php get_template_part('parts/flexible-content'); ?>
						</section>
					<?php } ?>

				</article><!-- #post-## -->

			<?php endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php
		/* FAQS JAVASCRIPT */ 
		include( locate_template('inc/faqs-script.php') ); 
	?>
<script type="text/javascript">
	$(document).on("click","#tabOptions a",function(e){
		e.preventDefault();
		$("#tabOptions li").removeClass('active');
		$(this).parent().addClass('active');
		$(".schedules-list").removeClass('active');
		var tabContent = $(this).attr("data-tab");
		$(tabContent).addClass('active');
	});



	if( $('[data-section]').length > 0 ) {
		var tabs = '';
		$('[data-section]').each(function(){
			var name = $(this).attr('data-section');
			var id = $(this).attr("id");
			tabs += '<span class="mini-nav"><a href="#'+id+'">'+name+'</a></span>';
		});
		$("#pageTabs").html('<div class="wrapper"><div id="tabcontent">'+tabs+'</div></div>');
	}

	$("#tabs a").on("click",function(e){
	    e.preventDefault();
	    var panel = $(this).attr('data-rel');
	    $("#tabs li").not(this).removeClass('active');
	    $(this).parents("li").addClass('active');
	    if( $(panel).length ) {
	      $(".info-panel").not(panel).removeClass('active');
	      $(".info-panel").not(panel).find('.info-inner').removeClass('fadeIn');
	      $(panel).addClass('active');
	      //$(panel).find('.info-inner').addClass('fadeIn').slideToggle();
	      $(panel).find('.info-inner').toggleClass('fadeIn');
	    }
	 });


</script>
<?php
get_footer();
