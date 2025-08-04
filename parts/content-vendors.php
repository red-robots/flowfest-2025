<!-- Sponsors -->
<?php
	$vendor_page = 1764;

	if(have_rows('affiliate', $vendor_page)):
		$vendor_link = get_field('vendor_link');
        $vendor_link_text = (isset($vendor_link['title']) && $vendor_link['title']) ? $vendor_link['title'] : '';
        $vendor_link_url = (isset($vendor_link['url']) && $vendor_link['url']) ? $vendor_link['url'] : '';
        $vendor_link_target = (isset($vendor_link['target']) && $vendor_link['target']) ? $vendor_link['target'] : '_self';
?>
	<section class="sponsors-container">
		<div class="wrapper">
			<h2 class="pagetitle text-center">Vendors</h2>
								
			<div class='sponsors owl-carousel owl-theme sponsors-loop'>

				<?php while(have_rows('affiliate', $vendor_page)): the_row();
						$vendor_img = get_sub_field('affiliate_img', $vendor_page);
						$vendor_url = get_sub_field('affiliate_url', $vendor_page); 

					if ( $vendor_img && $vendor_url ) { ?>
						<div class="sponsor">
							<?php if ( !empty($vendor_url) ) { ?>
								<a href="<?php echo $vendor_url; ?>" target="_blank">
							<?php } ?>
								<img src="<?php echo $vendor_img["url"]; ?>" alt="<?php echo $vendor_img["alt"]; ?>" />
							<?php if ( !empty($vendor_url) ) { echo "</a>"; } ?>
						</div>
					<?php }

				endwhile;
			?>
			</div>
			<?php if($vendor_link_text && $vendor_link_url) { ?>
				<div class="text-center">
					<a class="button-big" href="<?php echo $vendor_link_url; ?>" target="<?php echo $vendor_link_target; ?>"><?php echo $vendor_link_text; ?></a>
				</div>
			<?php } ?>
		</div>
	</section>
<?php endif; ?>