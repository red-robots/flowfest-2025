<?php
/**
 * Template Name: Sitemap
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

	
			<?php if ( has_nav_menu('sitemap') ) { ?>
      <div id="sitemap-wrap">
        <div class="wrapper">
          <?php wp_nav_menu( array( 'theme_location' => 'sitemap', 'menu_id' => 'sitemap','container_class'=>'sitemap-links') ); ?>
        </div>
      </div>
      <?php } ?>
			

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();