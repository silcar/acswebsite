<?php
if ( fearless_get_option( 'menubar_search_enabled' ) ) {
	$menubar_search_enabled = true;
} else {
	$menubar_search_enabled = false;
}
?>

<nav id="primary-navigation"<?php if ( ! $menubar_search_enabled ) echo ' class="menubar-search-disabled'; ?> role="navigation">
	<h3 class="screen-reader-text"><?php _e( 'Menu', 'fearless' ); ?></h3>
	<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'fearless' ); ?>"><?php _e( 'Skip to content', 'fearless' ); ?></a></div>

	<?php
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container' => 'false',
			'menu_class' => 'menu sf-menu',
			'fallback_cb' => 'fearless_nav_menu_primary_fallback'
		) );
	?>

	<?php if ( $menubar_search_enabled ) : ?>
		<form id="menubar-search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" class="fa fa-search">
			<label for="menubar-search-submit" class="screen-reader-text"><?php _e( 'Search', 'assistive text', 'fearless' ); ?></label>
			<input type="search" id="menubar-search-query" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_attr_x( 'Search&hellip;', 'placeholder', 'fearless' ); ?>" />
			<input type="submit" id="menubar-search-submit" value="<?php echo esc_attr_x( 'Go', 'submit button', 'fearless' ); ?>" />
		</form>
	<?php endif; ?>

</nav><!-- #primary-navigation -->
