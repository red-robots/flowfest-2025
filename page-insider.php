<?php
/**
 * Template Name: Insider Guide
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

		<?php if(have_rows('insiders_guide')): ?>
			<section class="insider-content wrapper">
				<?php
					echo '<div class="insider-content-sidebar">';
					echo '<button onclick="dropDownNav()" class="dropbtn" id="dropbtn">In this section <span class="plus-minus-toggle"></span></button>';
					echo '<div id="myDropdown" class="stickyNav">';
					echo '<div class="insider-content-sidebar-title">In this section</div>';

					while(have_rows('insiders_guide')): the_row();
						$sidebar = get_sub_field('sidebar_title');
						$sidebar_title = str_replace([' ','&'], ['_',''], strtolower( $sidebar ) );

						if($sidebar) {
					?>
						<div class="insider-content-sidebar-title">
							<a href="#<?php echo $sidebar_title; ?>"><?php echo $sidebar; ?></a>
						</div>
					<?php
						}

						endwhile;

						echo '</div></div>';

						echo '<div class="insider-content-main">';

						while(have_rows('insiders_guide')): the_row();
							$sidebar = get_sub_field('sidebar_title');
							$url = str_replace([' ','&'], ['_',''], strtolower( $sidebar ) );
							$title = get_sub_field('title');
							$content = get_sub_field('content');

							if($title && $content) {
					?>
						<div id="<?php echo $url; ?>" class="insider-content-main-inner">
							<h2><?php echo $title; ?></h2>
							<div class="content"><?php echo $content; ?></div>
						</div>
					<?php
						} 
						
						endwhile;

						echo '</div>';
					?>
			</section>
		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->


<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function dropDownNav() {
  document.getElementById("myDropdown").classList.toggle("show");
  document.getElementById("dropbtn").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(e) {
	if (!e.target.matches('.dropbtn')) {
		var myDropdown = document.getElementById("myDropdown");
		var dropdownBtn = document.getElementById("dropbtn");
		if (myDropdown.classList.contains('show')) {
			myDropdown.classList.remove('show');
		}
		if (dropdownBtn.classList.contains('show')) {
			dropdownBtn.classList.remove('show');
		}
	}
}
</script>

<?php
get_footer();