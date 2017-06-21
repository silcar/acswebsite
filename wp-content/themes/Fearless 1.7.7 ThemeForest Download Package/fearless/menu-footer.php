<nav id="footer-navigation" class="footer-right" role="navigation">
	<h1 class="screen-reader-text"><?php _e( 'Menu', 'fearless' ); ?></h1>
	<?php
		wp_nav_menu( array(
			'theme_location' => 'footer',
			'container' => false,
			'menu_class' => 'menu',
			'depth' => 1,
			'fallback_cb' => 'false'
		) );
	?>
</nav><!-- #site-navigation -->