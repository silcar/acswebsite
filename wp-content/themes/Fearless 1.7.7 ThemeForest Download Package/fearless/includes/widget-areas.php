<?php

/**
 * Registers theme sidebars
 */
function fearless_widgets_init() {
	$before_widget = '<section id="%1$s" class="widget %2$s">';
	$after_widget = '</section>';
	$before_title = '<h1 class="widget-title"><span>';
	$after_title = '</span></h1>';

	register_sidebar( array(
		'name' => __( 'Default Sidebar', 'fearless' ),
		'id' => 'default',
		'description' => __( 'The default widget area.', 'fearless' ),
		'before_widget' => $before_widget,
		'after_widget'  => $after_widget,
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );

	register_sidebar( array(
		'name' => __( 'Home Sidebar', 'fearless' ),
		'id' => 'home',
		'description' => __( 'The widget area that will be displayed on your front page. Leave empty to use the default sidebar on the front page.', 'fearless' ),
		'before_widget' => $before_widget,
		'after_widget'  => $after_widget,
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );
	register_sidebar( array(
		'name' => __( 'Page Sidebar', 'fearless' ),
		'id' => 'page',
		'description' => __( 'The widget area that will be displayed on pages. Leave empty to use the default sidebar on pages.', 'fearless' ),
		'before_widget' => $before_widget,
		'after_widget'  => $after_widget,
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );
	register_sidebar( array(
		'name' => __( 'Post Sidebar', 'fearless' ),
		'id' => 'post',
		'description' => __( 'The widget area that will be displayed on posts. Leave empty to use the default sidebar on posts.', 'fearless' ),
		'before_widget' => $before_widget,
		'after_widget'  => $after_widget,
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );
	register_sidebar( array(
		'name' => __( 'Category Sidebar', 'fearless' ),
		'id' => 'category',
		'description' => __( 'The widget area that will be displayed on category archives. Leave empty to use the default sidebar on category archives.', 'fearless' ),
		'before_widget' => $before_widget,
		'after_widget'  => $after_widget,
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );

	register_sidebar( array(
		'name' => __( 'Widgetized Homepage', 'fearless' ),
		'id' => 'widgetized-homepage',
		'description' => __( 'To use the widget-based homepage layout, add widgets here.', 'fearless' ),
		'before_widget' => '<section id="%1$s" class="widget layout-module %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );

	register_sidebar( array(
		'name' => __( 'Header Widget Area', 'fearless' ),
		'id' => 'header',
		'before_widget' => $before_widget,
		'after_widget'  => $after_widget,
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );

	register_sidebar( array(
		'name' => __( 'Secondary Sidebar', 'fearless' ),
		'id' => 'secondary',
		'before_widget' => $before_widget,
		'after_widget'  => $after_widget,
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );

	register_sidebar( array(
		'name' => __( 'Footer Column 1', 'fearless' ),
		'id' => 'footer-1',
		'description' => __( 'The first column in the footer widget area.', 'fearless' ),
		'before_widget' => $before_widget,
		'after_widget'  => $after_widget,
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );
	register_sidebar( array(
		'name' => __( 'Footer Column 2', 'fearless' ),
		'id' => 'footer-2',
		'description' => __( 'The second column in the footer widget area.', 'fearless' ),
		'before_widget' => $before_widget,
		'after_widget'  => $after_widget,
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );
	register_sidebar( array(
		'name' => __( 'Footer Column 3', 'fearless' ),
		'id' => 'footer-3',
		'description' => __( 'The third column in the footer widget area.', 'fearless' ),
		'before_widget' => $before_widget,
		'after_widget'  => $after_widget,
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );
	register_sidebar( array(
		'name' => __( 'Footer Column 4', 'fearless' ),
		'id' => 'footer-4',
		'description' => __( 'The fourth column in the footer widget area.', 'fearless' ),
		'before_widget' => $before_widget,
		'after_widget'  => $after_widget,
		'before_title'  => $before_title,
		'after_title'   => $after_title,
	) );

	/*** Custom sidebars ***/
	$custom_sidebars = array();

	// Categories
	$all_cats = get_categories( array( 'hide_empty' => false ) );
	foreach( $all_cats as $category ) {
		$custom_sidebar = fearless_get_category_meta_hierarchical( $category->term_id, 'fearless_custom_sidebar' );
		if ( $custom_sidebar )
			$custom_sidebars[ sanitize_title( $custom_sidebar ) ] = $custom_sidebar;
	}

	// Posts and pages
	$posts = get_posts( array(
		'post_type' => array( 'page', 'post' ),
		'meta_key' => 'fearless_custom_sidebar',
		'posts_per_page' => -1
	) );
	foreach( $posts as $post ) {
		$custom_sidebar = get_post_meta( $post->ID, 'fearless_custom_sidebar', true );
		$custom_sidebars[ sanitize_title( $custom_sidebar ) ] = $custom_sidebar;
	}

	// Register custom sidebars
	$custom_sidebars = array_unique( $custom_sidebars );
	foreach( $custom_sidebars as $sidebar_id => $sidebar_name ) {
		register_sidebar( array(
			'name'          => $sidebar_name,
			'id'            => $sidebar_id,
			'before_widget' => $before_widget,
			'after_widget'  => $after_widget,
			'before_title'  => $before_title,
			'after_title'   => $after_title,
		) );
	}
}
add_action( 'widgets_init', 'fearless_widgets_init' );
