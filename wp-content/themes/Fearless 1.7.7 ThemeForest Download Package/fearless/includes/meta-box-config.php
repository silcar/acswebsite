<?php

function fearless_register_meta_boxes() {
	if ( ! class_exists( 'RW_Meta_Box' ) )
		return;

	$post_categories = array(
		'' => __( 'None', 'fearless' )
	);
	$post_category_data = get_categories(
		array(
			'hide_empty' => false
		)
	);
	foreach( $post_category_data as $current_category_data ) {
		$post_categories[ $current_category_data->term_id ] = $current_category_data->name;
	}

	$meta_boxes = array(
		array(
			'id' => 'post',
			'title' => __( 'Single Post Options', 'fearless' ),
			'pages' => array( 'post' ),
			'fields' => array(
				array(
					'name' => __( 'Featured Post', 'fearless' ),
					'desc' => __( 'Turn on to show this post in the featured posts slider.', 'fearless' ),
					'id' => 'fearless_featured_post',
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Audio Embed Code', 'fearless' ),
					'desc' => __( 'For audio post formats, paste the SoundCloud video embed code here.', 'fearless' ),
					'id' => 'fearless_audio_embed_code',
					'type' => 'textarea'
				),
				array(
					'name' => __( 'Video Embed Code', 'fearless' ),
					'desc' => __( 'For video post formats, paste the iframe video embed code here.', 'fearless' ),
					'id' => 'fearless_video_embed_code',
					'type' => 'textarea'
				),
				array(
					'name' => __( 'Custom Sidebar', 'fearless' ),
					'desc' => __( 'Create a custom sidebar for this post by adding some text to this box.', 'fearless' ),
					'id' => 'fearless_custom_sidebar',
					'type' => 'text'
				),
				array(
					'name' => __( 'Featured Slider Category Label Override', 'fearless' ),
					'desc' => __( 'Choose which category to use as the category label in the featured slider, if a post has more than one category.', 'fearless' ),
					'id' => 'fearless_category_label_override',
					'type' => 'select',
					'options' => $post_categories,
					'std' => ''
				)
			)
		),
		array(
			'id' => 'page',
			'title' => __( 'Page Options', 'fearless' ),
			'pages' => array( 'page' ),
			'fields' => array(
				array(
					'name' => __( 'Custom Sidebar', 'fearless' ),
					'desc' => __( 'Create a custom sidebar for this page by adding some text to this box.', 'fearless' ),
					'id' => 'fearless_custom_sidebar',
					'type' => 'text'
				),
				array(
					'name' => __( 'Accent Color', 'fearless' ),
					'desc' => __( 'If you want to override the global accent color on this page, choose a color here.', 'fearless' ),
					'id' => 'fearless_accent_color',
					'type' => 'color'
				)
			)
		)
	);

	$meta_boxes = apply_filters( 'fearless_meta_boxes', $meta_boxes );

	foreach( $meta_boxes as $meta_box ) {
		new RW_Meta_Box( $meta_box );
	}
}
add_action( 'admin_init', 'fearless_register_meta_boxes' );
