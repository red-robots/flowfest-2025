<?php
/**
 * Template Name: Repeatable Block
 */

get_header(); ?>

	<div id="primary" class="content-area-full repeatable-block-page">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

        <div class="wrapper">
          <h1 class="pagetitle text-center"><?php the_title(); ?></h1>
        </div>

        <?php if ( get_the_content() ) { ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('entry-content'); ?>>
          <?php the_content() ?>
				</article><!-- #post-## -->
        <?php } ?>

        <?php if( have_rows('repeatable_block') ) { ?>
        <div class="repeatable-content-blocks">
          <div class="wrapper">
            <?php $n=1; while ( have_rows('repeatable_block') ) : the_row(); 
              $title = get_sub_field('title');
              $text = get_sub_field('text');
              $buttons = get_sub_field('buttons');
              $image = get_sub_field('image');
              $column_class = ( ($title || $text) &&  $image ) ? 'half':'full';
              $column_class .= ($n % 2 == 0 ) ? ' even':' odd';
              $hasMatchHeight = ( ($title || $text) &&  $image ) ? ' matchHeight':'';
              if( ($title || $text) ||  $image ) { ?>
              <div class="content-block <?php echo $column_class ?>">
                <?php if ( $title || $text ) { ?>
                <div class="textcol block<?php echo $hasMatchHeight ?>">
                  <div class="inside">
                    <?php if ($title) { ?>
                     <h2 class="rb_title"><?php echo $title ?></h2> 
                    <?php } ?>

                    <?php if ($text) { ?>
                     <div class="rb_content"><?php echo anti_email_spam($text); ?></div> 
                    <?php } ?>

                    <?php if ($buttons) { ?>
                     <div class="rb_buttons">
                       <?php foreach ($buttons as $btn) { 
                        $b = $btn['button'];
                        $btn_target = ( isset($b['target']) && $b['target'] ) ? $b['target'] : '_self';
                        $btn_text = ( isset($b['title']) && $b['title'] ) ? $b['title'] : '';
                        $btn_link = ( isset($b['url']) && $b['url'] ) ? $b['url'] : '';
                        if( $btn_text && $btn_link ) { ?>
                          <a href="<?php echo $btn_link ?>" target="<?php echo $btn_target ?>" class="btn2 btn-green"><?php echo $btn_text ?></a>
                        <?php } ?>
                       <?php } ?>
                     </div> 
                    <?php } ?>
                  </div>
                </div> 
                <?php } ?>

                <?php if ( $image ) { ?>
                <div class="imagecol block<?php echo $hasMatchHeight ?>">
                  <figure style="background-image:url('<?php echo $image['url'] ?>')">
                    <img src="<?php echo THEMEURI ?>images/rectangle.png" alt="">
                  </figure>
                </div> 
                <?php } ?>
              </div>
              <?php $n++; } ?>
            <?php endwhile; ?>
          </div>
        </div>
        <?php } ?>

			<?php endwhile;  ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
