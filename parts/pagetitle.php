<?php 
$register = get_field('register_button_link','option');
$register_button_text = (isset($register['title']) && $register['title']) ? $register['title'] : '';
$register_button_link = (isset($register['url']) && $register['url']) ? $register['url'] : '';
$register_button_target = (isset($register['target']) && $register['target']) ? $register['target'] : '_self'; ?>
<section class="pagetitle">
	<div class="wrapper pagetitle-flex">
  <?php if($register_button_text && $register_button_link) { ?>
 	<?php if( !is_page(1422) ) { ?>
	 	<div class="reg">
	 		<a href="<?php echo $register_button_link; ?>" target="<?php echo $register_button_target; ?>"><span><?php echo $register_button_text; ?></span></a>
	 	</div>
	 <?php } ?>
  <?php } ?>
  <?php if( !is_front_page() ) { ?>
 	<h1 class="page-title">
 		 <?php the_title(); ?>
 	</h1>
 <?php } ?>
</section>
