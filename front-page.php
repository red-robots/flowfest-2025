<?php 

get_header(); 
?>
<div id="primary" class="home-content content-area-full">
	<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

    <?php 
      $registration = get_field('registration_button');
      $registration_button_text = (isset($registration['title']) && $registration['title']) ? $registration['title'] : '';
      $registration_button_link = (isset($registration['url']) && $registration['url']) ? $registration['url'] : '';
      $registration_button_target = (isset($registration['target']) && $registration['target']) ? $registration['target'] : '_self';
    ?>

      <?php if( get_the_content() ) { ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<?php the_content(); ?>
          <?php if($registration_button_text && $registration_button_link) { ?>
            <div class="button">
              <a href="<?php echo $registration_button_link; ?>" target="<?php echo $registration_button_target; ?>"><?php echo $registration_button_text; ?></a>
            </div>
          <?php } ?>
				</div>
			</article>
      <?php } ?>


      <?php  

      if ( $cards = get_field('homepage_cards') ) { 
          foreach ($cards as $k=>$item) {
            $visibility = (isset($item['visibility'][0]) && $item['visibility'][0]) ? $item['visibility'][0] : '';
            if($visibility=='hide') {
              unset($cards[$k]);
            }
          }
        ?>
			<section class="homepage-cards <?php echo (count($cards)>3) ? 'cols4':'cols3'?>">
        <div class="wrapper">
          <div class="cards">
          <?php $n=1; foreach ($cards as $item) {  
            $title = $item['title'];
            $visibility = (isset($item['visibility'][0]) && $item['visibility'][0]) ? ' ' . $item['visibility'][0] : '';
            $img = $item['image'];
            $link = $item['link'];
            $icon = $item['icon'];
            $cardTitle = (isset($link['title']) && $link['title']) ? $link['title'] : '';
            $cardLink = (isset($link['url']) && $link['url']) ? $link['url'] : 'javascript:void(0)';
            $cardTarget = (isset($link['target']) && $link['target']) ? $link['target'] : '_self';
            $image_style = ($img) ? ' style="background-image:url('.$img['url'].')"':'';
            $card_class = ($img) ? 'has-image':'no-image'; 
            if($n % 2==0) {
              $card_class .= ' even';
            }
            else if($n % 3==0) {
              $card_class .= ' third';
            }
            ?>
            <div class="card <?php echo $card_class.$visibility ?>">
              <a href="<?php echo $cardLink ?>" target="<?php echo $cardTarget ?>" class="inside">
                <figure>
                  <?php if ($img) { ?>
                  <span class="image"<?php echo $image_style ?>></span>
                  <img src="<?php echo $img['url'] ?>" alt="<?php echo $img['title'] ?>">
                  <?php } ?>
                </figure>
                <div class="titlediv">
                  <div class="wrap">
                    <?php if ($icon && preg_replace('/\s+/', '', $icon)) { ?>
                      <!-- <div class="icon <?php echo $icon ?>"><span></span></div> -->
                      <style>
                        .card .<?php echo preg_replace('/\s+/', '', $icon);?> span {background-image:url('<?php echo get_stylesheet_directory_uri() . '/images/_icons/' . preg_replace('/\s+/', '', $icon)?>.png')}
                        .card a:hover .<?php echo preg_replace('/\s+/', '', $icon); ?> span{background-image:url('<?php echo get_stylesheet_directory_uri() . '/images/_icons/' . preg_replace('/\s+/', '', $icon)?>-hover.png')}
                      </style>
                    <?php } ?>
                    <div class="title"><?php echo $title ?></div>
                  </div>
                </div>
              </a>
            </div>
          <?php $n++; } ?>
          </div>
        </div>
      </section>
			<?php } ?>

		<?php endwhile; // End of the loop.
		?>

	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer();
