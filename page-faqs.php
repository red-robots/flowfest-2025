<?php
/**
 * Template Name: FAQs
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ACStarter
 */

get_header(); ?>

  <div id="primary" class="content-area-full content-default-template">
    <main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
        <?php if ( get_the_content() ) {  ?>
          <div class="wrapper"><?php get_template_part( 'parts/content', 'page' ); ?></div>
        <?php } ?>
      <?php endwhile; ?>

	
			<?php if(have_rows('faqs')): ?>
      <section class="faqs">
        <div class="wrapper">
				<?php while(have_rows('faqs')): the_row();
					$question=get_sub_field('question');
					$answer=get_sub_field('answer'); 
          if($question && $answer) { ?>
  				<div class="faqrow">
  					<a href="javascript:void(0)" class="question">
  						<span class="plus-minus-toggle"></span>
  						<?php echo $question; ?>
  					</a>
  					<div class="answer"><?php echo $answer; ?></div>
  				</div>
          <?php } ?>
				<?php endwhile; ?>
        </div>
      </section>
			<?php endif; ?>
			

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();