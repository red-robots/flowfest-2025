<!-- Contact Information -->
<?php      
	$contact_info_title = get_field('contact_information_title', 'option');
	$map = get_field('google_map','option');
	$address = get_field('contact_address', 'option');
	$phone = get_field('contact_phone', 'option');
	$details = get_field('online_content', 'option');
	$contact = get_field('contact-info-group', 'option');
	$section_class = ($map && $address) ? 'half':'full';

	if($address || $map) {
?>
	<section class="<?php echo $section_class ?> contact-info">
	<div class="wrapper">
		<h2 class="pagetitle text-center"><?php echo $contact_info_title; ?></h2>
		<div class="flexwrap">
		<?php if($map) { ?>
			<div class="flexcol map">
			<?php echo $map; ?>
			<img src="<?php echo THEMEURI ?>images/square.png" alt="" class="iframe-resizer">
			</div>
		<?php } ?>
		<?php if( $address ) { ?>
			<div class="flexcol contact">
			<div>
				<?php if ($address) { ?>
				<h3>ADDRESS:</h3>
				<div><?php echo $address; ?></div>
				<?php } ?>
				<?php if ($phone) { ?>
				<h3>PHONE:</h3>
				<div><?php echo $phone; ?></div>
				<?php } ?>
				<?php if ($details) { ?>
				<h3>ONLINE:</h3>
				<div class="text"><?php echo anti_email_spam($details); ?></div>
				<?php } ?>
			</div>
			</div>
		<?php } ?>
		</div>
	</div>
	</section>
<?php } ?>
<!-- Contact Information END -->