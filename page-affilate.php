<?php
/**
 * Template Name: Affiliate
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ACStarter
 */

get_header(); ?>

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

		<?php if(have_rows('affiliate')): ?>
			<section class="affiliate">
				<div class="wrapper">
					<?php while(have_rows('affiliate')): the_row();
						$img = get_sub_field('affiliate_img');
						$url = get_sub_field('affiliate_url'); 

						if($img && $url) {
					?>
						<div class="affiliates">
							<a href="<?php echo $url; ?>" taregt="_blank">
								<img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" />
							</a>
						</div>
					<?php
						} 
						
						endwhile;
					?>
				</div>
			</section>
		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();