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
	</footer><!-- #colophon -->
	
</div><!-- #page -->

<div id="loader"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>
<?php wp_footer(); ?>
</body>
</html>
