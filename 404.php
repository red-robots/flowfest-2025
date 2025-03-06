<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package bellaworks
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found wrapper">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'bellaworks' ); ?></h1>
				</header><!-- .page-header -->

				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below?', 'bellaworks' ); ?></p>
			</section><!-- .error-404 -->

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
