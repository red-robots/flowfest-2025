<?php
/**
 * Template Name: Contact
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ACStarter
 */

get_header(); ?>

  <div id="primary" class="content-area-full content-default-template contact-page">
    <main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
        <div class="wrapper">
          <h1 class="pagetitle text-center"><?php the_title(); ?></h1>
        </div>
        <?php if ( get_the_content() ) {  ?>
          <div class="wrapper"><?php get_template_part( 'parts/content', 'page' ); ?></div>
        <?php } ?>
      <?php endwhile; ?>

      <?php  
        $map = get_field('map_embed');
        $contact = get_field('contact-info-group');
        $section_class = ($map && $contact) ? 'half':'full';
      ?>

      <?php if(have_rows('contact-info-group') || $map) { ?>
      <section class="contact-info-group <?php echo $section_class ?>">
        <div class="wrapper">
          <div class="flexwrap">

            <?php if(have_rows('contact-info-group')) { ?>
            <div class="flexcol contact floral-pattern">
              <div class="inside">
                <?php while(have_rows('contact-info-group')): the_row();
                  $heading=get_sub_field('heading');
                  $details=get_sub_field('details'); 
                  if($heading || $details) { ?>
                  <div class="info">
                    <?php if ($heading) { ?>
                     <h3><?php echo $heading ?></h3> 
                    <?php } ?>
                    <?php if ($details) { ?>
                     <div class="text"><?php echo anti_email_spam($details); ?></div>
                    <?php } ?>
                  </div>
                  <?php } ?>
                <?php endwhile; ?>
              </div>
            </div>
            <?php } ?>

            <?php if($map) { ?>
            <div class="flexcol map">
              <div class="inside">
                <?php echo $map ?>
                <img src="<?php echo THEMEURI ?>images/square.png" alt="" class="iframe-resizer">
              </div>
            </div>
            <?php } ?>

          </div>
        </div>
      </section>
    <?php } ?>
			
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();