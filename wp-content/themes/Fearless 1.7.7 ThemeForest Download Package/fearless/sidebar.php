<?php $theme_layout = str_replace( 'layout-', '', theme_layouts_get_layout() ); ?>

<?php if ( '1c' != $theme_layout ) : ?>
	<aside id="secondary" class="widget-area sidebar-primary" role="complementary">

		<?php
		if ( ( is_front_page() ) && is_active_sidebar( 'home' ) ) {
			$sidebar = 'home';
		} elseif ( is_singular( 'page' ) && is_active_sidebar( 'page' ) ) {
			$sidebar = 'page';
		} elseif ( is_singular( 'post' ) && is_active_sidebar( 'post' ) ) {
			$sidebar = 'post';
		} elseif( is_category() && is_active_sidebar( 'category' ) ) {
			$sidebar = 'category';
		} else {
			$sidebar = 'default';
		}

		if ( is_singular( 'page' ) && $custom_sidebar = get_post_meta( get_the_ID(), 'fearless_custom_sidebar', true ) ) {
			$sidebar = $custom_sidebar;
		} elseif ( is_singular( 'post' ) && $custom_sidebar = get_post_meta( get_the_ID(), 'fearless_custom_sidebar', true ) ) {
			$sidebar = $custom_sidebar;
		} elseif ( is_category() && $custom_sidebar = fearless_get_category_meta_hierarchical( get_query_var( 'cat' ), 'fearless_custom_sidebar' ) ) {
			$sidebar = $custom_sidebar;
		} elseif ( ( is_home() ) && $custom_sidebar = get_post_meta( get_option( 'page_for_posts' ), 'fearless_custom_sidebar', true ) ) {
			$sidebar = $custom_sidebar;
		}

		dynamic_sidebar( $sidebar );
		?>

	</aside><!-- #secondary .widget-area -->
<?php endif; ?>

<?php if ( false !== strpos( $theme_layout, '3c' ) ) : ?>
	<aside id="tertiary" class="widget-area sidebar-secondary" role="complementary">
		<?php dynamic_sidebar( 'secondary' ); ?>
	</aside><!-- #tertiary -->
<?php endif; ?>
