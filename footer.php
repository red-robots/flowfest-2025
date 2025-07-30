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
		<div class="wrapper	foot-flex cf">
			<?php if ( $footer_logo ) { ?>
				<div class="footer-logo">
					<a href="https://whitewater.org" target="_blank">
						<img src="<?php echo $footer_logo['url'] ?>" alt="<?php echo $footer_logo['title'] ?>">
					</a>
				</div>
			<?php } ?>
			<nav class="footer-social-media">
				<?php echo do_shortcode('[display_social_media]'); ?>
			</nav>
			<!-- <div class="empty">&nbsp;</div> -->
		</div><!-- wrapper foot-flex -->

		<!-- Sign Up newsletter -->
		<div class="wrapper">
			<?php 
				$newsletter_title = get_field("sign_up_newsletter_title","option");
				$newsletter_code = get_field("sign_up_newsletter_code","option");

				if( !empty($newsletter_title) ){
					echo "<div class='newsletter'><h2>". $newsletter_title ."</h2>";
					echo "<div>". $newsletter_code ."</div></div>";
				}
			?>		
		</div> <!-- wrapper -->
	</footer><!-- #colophon -->
	
</div><!-- #page -->

<div id="loader"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>
<?php wp_footer(); ?>
</body>
</html>
