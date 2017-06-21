<?php

if ( is_admin() ) {
	$category_meta_config = array(
		'id' => 'category_options',
		'title' => __( 'Fearless Category Options', 'fearless' ),
		'pages' => array( 'category' ),
		'context' => 'normal',
		'fields' => array(),
		'local_images' => false,
		'use_with_theme' => get_template_directory_uri() . '/includes/Tax-meta-class'
	);
	$fearless_category_meta = new Tax_Meta_Class( $category_meta_config );

	$blogroll_layout_styles = array_merge(
		array( '' => __( 'Use the default layout set in the theme options', 'fearless' ) ),
		fearless_get_blogroll_layout_styles()
	);
	$fearless_category_meta->addSelect( 'fearless_blogroll_layout_style', $blogroll_layout_styles, array( 'name' => __( 'Layout Style', 'fearless' ) ) );

	$featured_slider_type_options = array(
		'disabled' => __( 'Disabled', 'fearless' ),
		'featured' => __( 'Featured posts', 'fearless' ),
		'recent' => __( 'Recent posts', 'fearless' ),
	);
	$fearless_category_meta->addSelect( 'fearless_featured_slider_type', $featured_slider_type_options, array( 'name' => __( 'Featured Slider Type', 'fearless' ) ) );
	
	$fearless_category_meta->addColor( 'fearless_accent_color', array( 'name' => __( 'Accent Color', 'fearless' ) ) );

	$fearless_category_meta->addImage( 'fearless_fullscreen_background', array( 'name' => __( 'Fullscreen Background Image', 'fearless' ) ) );
	
	$fearless_category_meta->addText( 'fearless_custom_sidebar', array( 'name' => __( 'Custom Sidebar', 'fearless' ) ) );

	$fearless_category_meta->Finish();
}
