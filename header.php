<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script defer src="<?php bloginfo( 'template_url' ); ?>/assets/svg-with-js/js/fontawesome-all.js"></script> 

<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('template_url'); ?>/images/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('template_url'); ?>/images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('template_url'); ?>/images/favicon-16x16.png">
<link rel="manifest" href="<?php bloginfo('template_url'); ?>/images/site.webmanifest">
<link rel="stylesheet" href=https://use.typekit.net/zzb0tjr.css>



<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '236370623380911');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=236370623380911&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
<script>!function(e,t,n,s,a,c,p,i,o,u){e[a]||((i=e[a]=function(){i.process?i.process.apply(i,arguments):i.queue.push(arguments)}).queue=[],i.pixelId="cbd42ac9-c947-41a0-a340-cc2163106c8c",i.t=1*new Date,(o=t.createElement(n)).async=1,o.src="https://found.ee/dmp/pixel.js?t="+864e5*Math.ceil(new Date/864e5),(u=t.getElementsByTagName(n)[0]).parentNode.insertBefore(o,u))}(window,document,"script",0,"foundee");foundee('', 'Y');</script>               
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="overlay"></div>
<div id="popup-content"></div>

<?php 
  $register = get_field('register_button_link','option');
  $register_button_text = (isset($register['title']) && $register['title']) ? $register['title'] : '';
  $register_button_link = (isset($register['url']) && $register['url']) ? $register['url'] : '';
  $register_button_target = (isset($register['target']) && $register['target']) ? $register['target'] : '_self';
?>

<div id="page" class="site cf">
	<a class="skip-link sr" href="#content"><?php esc_html_e( 'Skip to content', 'bellaworks' ); ?></a>	
  <header id="masthead" class="site-header floral-pattern" role="banner">
		<div class="wrapper head-flex">
        <div id="site-logo" class="logo">
          <a href="<?php bloginfo('url'); ?>">
           <img src="<?php bloginfo('template_url'); ?>/images/logo.svg">
          </a>
        </div>
  			<nav id="site-navigation" class="main-navigation desktop-navigation full-width-dropdown" role="navigation">
  				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'container_class'=>'primary-menu-wrap','link_before'=>'<span><b>','link_after'=>'</b></span>' ) ); ?>
  			</nav><!-- #site-navigation -->
			<div class="right-head">&nbsp;</div>

      <?php if($register_button_text && $register_button_link) { ?>
        <?php if( !is_page(1422) ) { ?>
          <div class="reg">
            <a href="<?php echo $register_button_link; ?>" target="<?php echo $register_button_target; ?>"><span><?php echo $register_button_text; ?></span></a>
          </div>
        <?php } ?>
      <?php } ?>
		</div><!-- wrapper -->
	</header><!-- #masthead -->

  <span id="mobile-menu-toggle"><span class="bar"><span></span></span></span>
  <div class="mobile-navigation floral-pattern"></div>

	<?php // get_template_part('parts/pagetitle');?>
	<?php 
  $CS = get_field('coming_soon'); 

  if( $CS[0] == '' ) {
    get_template_part('parts/banner');
  } 
  ?>

	<div id="content" class="site-content">
