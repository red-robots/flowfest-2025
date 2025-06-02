<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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

			<?php
			while ( have_posts() ) : the_post(); ?>
				<div class="wrapper">
					<h1 class="pagetitle text-center"><?php the_title(); ?></h1>
				</div>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<?php if( $CS[0] == 'soon' ) { ?>
						<section class="coming-soon">
							<div>Coming Soon</div>
						</section>
					<?php } else { ?>
						<div class="entry-content vendorz">
							<?php the_content(); ?>
						</div><!-- .entry-content -->
					<?php } ?>

				</article><!-- #post-## -->

			<?php endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
