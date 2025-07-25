<?php
/**
 * Template Name: Artists
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bellaworks
 */

get_header(); 

$CS = get_field('coming_soon');
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
						<div class="entry-content">
							<?php the_content(); ?>

						</div><!-- .entry-content -->
						<div class="artists">
							<?php echo do_shortcode('[feeds post="artists"  perpage="-1"  filter="music_day"]'); ?>
						</div>
					<?php } ?>

				</article><!-- #post-## -->

			<?php endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
