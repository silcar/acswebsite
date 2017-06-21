<?php
if ( ( is_front_page() OR is_home() ) && 'disabled' != fearless_get_option( 'homepage_featured_slider_type' ) && ! is_paged() ) :

	$slider_args = array(
		'posts_per_page' => 8,
		'ignore_sticky_posts' => 1
	);

	if ( 'featured' == fearless_get_option( 'homepage_featured_slider_type' ) ) {
		$slider_args['meta_key'] = 'fearless_featured_post';
		$slider_args['meta_value'] = '1';
	}

	fearless_flexslider( $slider_args );

endif;

if ( is_category() && ! is_paged() ) :

	$category_featured_slider_type = fearless_get_category_meta_hierarchical( get_query_var( 'cat' ), 'fearless_featured_slider_type' );
	if ( 'disabled' == $category_featured_slider_type )
		return;

	$slider_args = array(
		'posts_per_page' => 8,
		'cat' => get_query_var( 'cat' ),
		'ignore_sticky_posts' => 1
	);

	if ( 'featured' == $category_featured_slider_type ) {
		$slider_args['meta_key'] = 'fearless_featured_post';
		$slider_args['meta_value'] = '1';
	}

	fearless_flexslider( $slider_args );

endif;
