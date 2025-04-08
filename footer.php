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
			<!-- <div class="empty">&nbsp;</div> -->
		</div><!-- wrapper foot-flex" -->

		<!-- Sign Up newsletter -->
		<div class="wrapper">
			<?php 
				$newsletter_title = get_field("sign_up_newsletter_title","option");
				$newsletter_code = get_field("sign_up_newsletter_code","option");

				if( !empty($newsletter_title) ){
					echo "<div class='newsletter'><h2>". $newsletter_title ."</h2>";
					echo "<div clas=''>". $newsletter_code ."</div></div>";
				}
			?>

			<!-- Sponsors -->
			<?php 
				if( have_rows("sponsors_footer", "option") ):
					echo "<div class='sponsors owl-carousel owl-theme sponsors-loop'>";

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

					echo "</div>";
				endif;
			?>
		
		</div> <!-- wrapper -->
	</footer><!-- #colophon -->
	
</div><!-- #page -->

<div id="loader"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>
<?php wp_footer(); ?>
</body>
</html>
