<!-- Sponsors -->
<?php
	if( have_rows("sponsors_footer", "option") ):
		$sponsor_link = get_field('sponsor_link', 'option');
        $sponsor_link_text = (isset($sponsor_link['title']) && $sponsor_link['title']) ? $sponsor_link['title'] : '';
        $sponsor_link_url = (isset($sponsor_link['url']) && $sponsor_link['url']) ? $sponsor_link['url'] : '';
        $sponsor_link_target = (isset($sponsor_link['target']) && $sponsor_link['target']) ? $sponsor_link['target'] : '_self';
?>
	<section class="sponsors-container">
		<div class="wrapper">
			<h2 class="pagetitle text-center">Vendors</h2>
			<div class='sponsors owl-carousel owl-theme sponsors-loop'>

				<?php while( have_rows("sponsors_footer", "option") ) : the_row();

					$sponsor_img = get_sub_field("sponsor_image");
					$sponsor_url = get_sub_field("sponsor_url");

					if ( !empty($sponsor_img) ) { ?>
						<div class="sponsor">
							<?php if ( !empty($sponsor_url) ) { ?>
								<a href="<?php echo $sponsor_url; ?>" target="_blank">
							<?php } ?>
								<img src="<?php echo $sponsor_img["url"]; ?>" alt="<?php echo $sponsor_img["alt"]; ?>" />
							<?php if ( !empty($sponsor_url) ) { echo "</a>"; } ?>
						</div>
					<?php }

				endwhile;
			?>
			</div>
			<?php if($sponsor_link_text && $sponsor_link_url) { ?>
				<div class="text-center">
					<a class="button-big" href="<?php echo $sponsor_link_url; ?>" target="<?php echo $sponsor_link_target; ?>"><?php echo $sponsor_link_text; ?></a>
				</div>
			<?php } ?>
		</div>
	</section>
<?php endif; ?>