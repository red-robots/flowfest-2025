<?php
/**
 * Template Name: Gallery
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

      <?php  if( have_rows('gallery') ) { ?>
      <section class="galleries">
        <div class="wrapper">
          <div class="flexwrap">
            <?php while( have_rows('gallery') ) : the_row(); 
            $type = get_sub_field('type');
            $image = get_sub_field('image');
            $video = get_sub_field('video');
            $caption = get_sub_field('caption');
            $gallery_text = ($caption) ? ' data-caption="'.$caption.'"':'';
            $video_thumbnail = '';
            $youtubeId = '';
            $vimeoId = '';
            if($type=='video' && $video) {
              if (str_contains($video, 'youtu.be')) {
                $youtubeId = basename($video);
              } 
              else if (str_contains($video, 'youtube.com')) {
                $parts = parse_url($video);
                parse_str($parts['query'], $query);
                $youtubeId = (isset($query['v']) && $query['v']) ? $query['v']:'';
              }

              if($youtubeId) {
                $video_thumbnail = 'http://i3.ytimg.com/vi/'.$youtubeId.'/maxresdefault.jpg';
              }
              
              if (str_contains($video, 'vimeo.com')) {
                $vimeoId = basename($video);
                $hash = unserialize(file_get_contents("https://vimeo.com/api/v2/video/$vimeoId.php"));
                $video_thumbnail = ( isset($hash[0]['thumbnail_large']) && $hash[0]['thumbnail_large'] ) ? $hash[0]['thumbnail_large'] : '';
              } 

              if($image) {
                $video_thumbnail = $image['url'];
              }
            }
            if($type=='image' && $image ) { ?>
            <figure class="type_image">
              <a data-fancybox="gallery" data-src="<?php echo $image['url'] ?>"<?php echo $gallery_text ?>>
                <span class="image" style="background-image:url('<?php echo $image['url'] ?>')"></span>
                <img src="<?php echo THEMEURI ?>images/rectangle-lg.png" alt="" aria-hidden="true" />
              </a>
            </figure>
            <?php } else if($type=='video' && $video ) { ?>
            <figure class="type_video <?php echo ($youtubeId) ? 'youtube':'vimeo' ?>">
              <a data-fancybox="gallery" data-src="<?php echo $video ?>"<?php echo $gallery_text ?>>
                <?php if ($video_thumbnail) { ?>
                  <span class="image" style="background-image:url('<?php echo $video_thumbnail ?>')"><i class="arrow"></i></span>
                <?php } else { ?>
                  <span class="image noThumbnail"><i class="arrow"></i></span>
                <?php } ?>
                <img src="<?php echo THEMEURI ?>images/rectangle-lg.png" alt="" aria-hidden="true" />
              </a>
            </figure>
            <?php } ?>
            <?php endwhile; ?>
          </div>
        </div>
      </section>
      <?php } ?>

		</main><!-- #main -->
	</div><!-- #primary -->

  <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<?php
get_footer();