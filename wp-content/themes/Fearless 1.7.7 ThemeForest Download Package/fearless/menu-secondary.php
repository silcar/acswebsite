<nav id="secondary-navigation" role="navigation">
	<h1 class="screen-reader-text"><?php _e( 'Menu', 'fearless' ); ?></h1>
	<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'fearless' ); ?>"><?php _e( 'Skip to content', 'fearless' ); ?></a></div>

	<?php
		wp_nav_menu( array(
			'theme_location' => 'secondary',
			'container' => false,
			'menu_class' => 'menu',
			'depth' => 1,
			'fallback_cb' => false
		) );
	?>
</nav><!-- #secondary-navigation -->