	</div><!-- #content -->

	<?php  
		$footlogo = get_field("footlogo","option");
		$address = get_field("address","option");
		$phone = get_field("phone","option");
		$fax = get_field("fax","option");
		$email = get_field("email","option");
		$contacts = array($address,$phone,$fax,$email);
		$other_info = get_field("other_info","option");
		$social_media = get_field("social_links","option");
		$social_icons = social_icons();
		$footer_logo = get_field("footer_logo","option");
	?>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="wrapper	foot-flex">
			<?php if ( $footer_logo ) { ?>
				<div class="footer-logo">
					<a href="https://whitewater.org" target="_blank">
						<img src="<?php echo $footer_logo['url'] ?>" alt="<?php echo $footer_logo['title'] ?>">
					</a>
				</div>
			<?php } ?>
			<nav class="footer">
				<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_id' => 'footer-menu' ) ); ?>
			</nav>
			<div class="empty">&nbsp;</div>
		</div><!-- wrapper -->

		<!-- Sign Up newsletter if there is -->
		<?php  echo do_shortcode('[gravityform id="19" title="true"]'); ?>

		<!-- Sponsors -->
		<?php 
			if( have_rows("sponsors_footer", "option") ):
				echo "<div class='wrapper'>
						<div class='sponsors'>";

				while( have_rows("sponsors_footer", "option") ) : the_row();

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

				echo "</div></div>";
			endif;

			if( $sponsors ):

				print_r($sponsors);
		?>
			<div class="wrapper">
				<div class="sponsors-loop">
					<?php foreach( $sponsors as $sponsor ): ?>
						<div>
							<a href="<?php echo $sponsor['url']; ?>">
								<img src="<?php echo $sponsor['sizes']['large']; ?>" alt="<?php echo $sponsor['alt']; ?>" />
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
		<!-- Ends Sponsors -->
	</footer><!-- #colophon -->
	
</div><!-- #page -->

<div id="loader"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>
<?php wp_footer(); ?>
</body>
</html>
