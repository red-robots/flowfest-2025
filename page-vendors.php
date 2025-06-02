<?php
/**
 * Template Name: Vendors
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

$placeholder = THEMEURI . 'images/rectangle.png';

$CS = get_field('coming_soon'); 
$vendors = get_field('vendors'); 
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

					<?php if( $CS[0] == 'soon' ) { ?>
						<section class="coming-soon">
							<div>Coming Soon</div>
						</section>
					<?php } else { ?>
						<div class="entry-content vendorz">
							<?php the_content(); ?>
						</div><!-- .entry-content -->
						<?php if( $vendors ) { ?>

							<div id="carousel-images" class="camp-caro swap">
								<div class="loop owl-carousel owl-theme">
								<?php foreach( $vendors as $v ) { 
									$link = get_field('link', $v['ID']);
									?>
									<div class="item">
										<div class="image" style="background-image:url('<?php echo $v['url']?>')">
											<a href="<?php echo $v['url']?>" data-fancybox class="popup-image">
											<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" />
											</a>
										</div>
									</div>
								<?php } ?>
								</div>
							</div>

							<!-- <section class="vendors">
								<?php foreach( $vendors as $v ) { 
									$link = get_field('link', $v['ID']);
									// echo '<pre>';
									// print_r($v);
									// echo '</pre>';
									
									?>
									<div class="ven">
										<a href="<?php echo $link['url']; ?>">
										<img src="<?php echo $v['url'] ?>" alt="<?php echo $v['alt'] ?>">
									</a>
									</div>
								<?php } ?>
							</section> -->
						<?php } ?>
					<?php } ?>

				</article><!-- #post-## -->

			<?php endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
