<?php

function optionsframework_options() {
	$options = array();

	// Basic
	$options[] = array(
		'name' => __( 'Basic', 'fearless' ),
		'type' => 'heading',
		'customizer_section_id' => 'basic',
		'customizer_priority' => 10
	);
	$options['homepage_featured_slider_type'] = array(
		'name' => __( 'Homepage Slider Type', 'fearless' ),
		'desc' => __( 'Choose the type of posts the homepage featured slider displays.', 'fearless' ),
		'id' => 'homepage_featured_slider_type',
		'type' => 'select',
		'class' => 'mini',
		'options' => array(
			'disabled' => __( 'Disabled', 'fearless' ),
			'featured' => __( 'Featured posts', 'fearless' ),
			'recent' => __( 'Recent posts', 'fearless' ),
		),
		'std' => 'recent',
		'customizer_section' => 'basic'
	);
	$options['logo_image_url'] = array(
		'name' => __( 'Logo Image', 'fearless' ),
		'desc' => __( 'Upload an image to be used as the site logo.', 'fearless' ),
		'id' => 'logo_image_url',
		'type' => 'upload',
		'std' => get_template_directory_uri() . '/images/fearless-logo.png',
		'customizer_section' => 'basic'
	);
	$options['favicon_url'] = array(
		'name' => __( 'Favicon Uploader', 'fearless' ),
		'desc' => __( 'Use a 16x16px .ICO file for complete browser support.', 'fearless' ),
		'id' => 'favicon_url',
		'type' => 'upload',
		'std' => false
	);
	$options['header_background_image_url'] = array(
		'name' => __( 'Header Background Image', 'fearless' ),
		'desc' => __( 'Upload an image to be used as the header background.', 'fearless' ),
		'id' => 'header_background_image_url',
		'type' => 'upload',
		'std' => get_template_directory_uri() . '/images/default-header-image.jpg',
		'customizer_section' => 'basic'
	);
	$options['header_background_image_url_tablet'] = array(
		'name' => __( 'Header Background Image (Tablet)', 'fearless' ),
		'desc' => __( 'Upload an image to be used as the header background on tablet devices.', 'fearless' ),
		'id' => 'header_background_image_url_tablet',
		'type' => 'upload',
		'std' => false,
		'customizer_section' => 'basic'
	);
	$options['header_background_image_url_mobile'] = array(
		'name' => __( 'Header Background Image (Mobile)', 'fearless' ),
		'desc' => __( 'Upload an image to be used as the header background on mobile devices.', 'fearless' ),
		'id' => 'header_background_image_url_mobile',
		'type' => 'upload',
		'std' => get_template_directory_uri() . '/images/default-header-image-mobile.jpg',
		'customizer_section' => 'basic'
	);
	$options['footer_copyright_text'] = array(
		'name' => __( 'Footer Copyright Text', 'fearless' ),
		'desc' => __( 'Enter any text you want to be output to the footer.', 'fearless' ),
		'id' => 'footer_copyright_text',
		'type' => 'text',
		'std' => '&copy;' . date( 'Y' ) . ' ' . get_bloginfo( 'blogname' ),
		'customizer_section' => 'basic'
	);
	$options['topbar_left_display'] = array(
		'name' => __( 'Top Bar Left', 'fearless' ),
		'desc' => __( 'Choose what to display on the left side of the top bar.', 'fearless' ),
		'id' => 'topbar_left_display',
		'type' => 'select',
		'options' => array(
			'disabled' => __( 'Disabled', 'fearless' ),
			'breadcrumb-trail' => __( 'Breadcrumb Trail', 'fearless' ),
			'current_date' => __( 'Current date', 'fearless' ),
			'social_icons' => __( 'Mini Social Icons', 'fearless' ),
			'secondary_navigation' => __( 'Secondary Navigation Menu', 'fearless' )
		),
		'std' => 'breadcrumb-trail',
		'class' => 'mini',
		'customizer_section' => 'top_bar'
	);
	$options['topbar_right_display'] = array(
		'name' => __( 'Top Bar Right', 'fearless' ),
		'desc' => __( 'Choose what to display on the right side of the top bar.', 'fearless' ),
		'id' => 'topbar_right_display',
		'type' => 'select',
		'options' => array(
			'disabled' => __( 'Disabled', 'fearless' ),
			'breadcrumb-trail' => __( 'Breadcrumb Trail', 'fearless' ),
			'current_date' => __( 'Current date', 'fearless' ),
			'social_icons' => __( 'Mini Social Icons', 'fearless' ),
			'secondary_navigation' => __( 'Secondary Navigation Menu', 'fearless' )
		),
		'std' => 'secondary_navigation',
		'class' => 'mini',
		'customizer_section' => 'top_bar'
	);

	// Colors
	$options[] = array(
		'name' => __( 'Colors', 'fearless' ),
		'type' => 'heading',
		'customizer_section_id' => 'colors',
		'customizer_priority' => 20
	);
	$options['global_accent_color'] = array(
		'name' => __( 'Global Accent Color', 'fearless' ),
		'id' => 'global_accent_color',
		'type' => 'color',
		'std' => '#a91515',
		'customizer_section' => 'colors'
	);
	$options['menubar_color'] = array(
		'name' => __( 'Menubar Color', 'fearless' ),
		'id' => 'menubar_color',
		'type' => 'color',
		'std' => '#222222',
		'customizer_section' => 'colors'
	);
	$options['link_color'] = array(
		'name' => __( 'Link Color', 'fearless' ),
		'id' => 'link_color',
		'type' => 'color',
		'std' => '#21759b',
		'customizer_section' => 'colors'
	);
	$options['link_hover_color'] = array(
		'name' => __( 'Link Hover Color', 'fearless' ),
		'id' => 'link_hover_color',
		'type' => 'color',
		'std' => '#a91515',
		'customizer_section' => 'colors'
	);
	$options['topbar_background_color'] = array(
		'name' => __( 'Top Bar Background Color', 'fearless' ),
		'id' => 'topbar_background_color',
		'type' => 'color',
		'std' => '#222222',
		'customizer_section' => 'colors'
	);
	$options['footer_background_color'] = array(
		'name' => __( 'Footer Background Color', 'fearless' ),
		'id' => 'footer_background_color',
		'type' => 'color',
		'std' => '#222222',
		'customizer_section' => 'colors'
	);

	// Defaults
	$options[] = array(
		'name' => __( 'Defaults', 'fearless' ),
		'type' => 'heading',
		'customizer_section_id' => 'defaults',
		'customizer_priority' => 30
	);
	$theme_layouts_options = fearless_theme_layouts_strings();
	unset( $theme_layouts_options['default'] );
	$options['default_theme_layout'] = array(
		'name' => __( 'Default Theme Layout', 'fearless' ),
		'desc' => __( 'Choose the default site-wide theme layout', 'fearless' ),
		'id' => 'default_theme_layout',
		'type' => 'select',
		'options' => $theme_layouts_options,
		'std' => '2c-l',
		'customizer_section' => 'defaults'
	);
	$options['default_blogroll_layout_style'] = array(
		'name' => __( 'Default Blogroll Layout Style', 'fearless' ),
		'desc' => __( 'Choose which layout to use as the default.', 'fearless' ),
		'id' => 'default_blogroll_layout_style',
		'type' => 'select',
		'options' => fearless_get_blogroll_layout_styles(),
		'std' => '1col-square',
		'customizer_section' => 'defaults'
	);
	$options['default_fullscreen_background_url'] = array(
		'name' => __( 'Default Fullscreen Background Image', 'fearless' ),
		'desc' => __( 'Upload a background image to be used as the default fullscreen background.', 'fearless' ),
		'id' => 'default_fullscreen_background_url',
		'type' => 'upload',
		'std' => get_template_directory_uri() . '/images/default-fullscreen-background.jpg',
		'customizer_section' => 'defaults'
	);

	// Post
	$options[] = array(
		'name' => __( 'Post', 'fearless' ),
		'type' => 'heading',
		'customizer_section_id' => 'post',
		'customizer_priority' => 40
	);
	$options['authorbox_enabled'] = array(
		'name' => __( 'Enable Author Box?', 'fearless' ),
		'desc' => __( 'Turn on this checkbox to enable the author box on single post pages.', 'fearless' ),
		'id' => 'authorbox_enabled',
		'type' => 'checkbox',
		'std' => '1',
		'customizer_section' => 'post'
	);
	$options['singular_featured_image_enabled'] = array(
		'name' => __( 'Enable Featured Image on Single Post Pages', 'fearless' ),
		'desc' => __( "Turn on this checkbox to show the post's featured image on the single post page.", 'fearless' ),
		'id' => 'singular_featured_image_enabled',
		'type' => 'checkbox',
		'std' => true,
		'customizer_section' => 'post'
	);
	$options['related_posts_enabled'] = array(
		'name' => __( 'Enable Related Posts?', 'fearless' ),
		'desc' => __( 'Turn on this checkbox to enable the related posts function on on single post pages.', 'fearless' ),
		'id' => 'related_posts_enabled',
		'type' => 'checkbox',
		'std' => '1',
		'customizer_section' => 'post'
	);
	$disqus_active = false;
	if ( defined( 'DISQUS_VERSION' ) ) $disqus_active = true;
	$options['comments_type'] = array(
		'name' => __( 'Comments Type', 'fearless' ),
		'desc' => $disqus_active ? __( 'Disqus comments plugin active.', 'fearless' ) : __( 'Choose the type of comments to use on your posts and pages.', 'fearless' ),
		'id' => 'comments_type',
		'type' => $disqus_active ? 'info' : 'select',
		'options' => array(
			'facebook' => __( 'Facebook', 'fearless' ),
			'wordpress' => __( 'WordPress', 'fearless' )
		),
		'std' => 'wordpress',
		'class' => 'mini',
		'customizer_section' => 'post'
	);

	// Retina
	$options[] = array(
		'name' => __( 'Retina', 'fearless' ),
		'type' => 'heading',
		'customizer_section_id' => 'social_profiles',
		'customizer_priority' => 50
	);
	$options['header_background_image_url_retina'] = array(
		'name' => __( 'Retina Header Background Image', 'fearless' ),
		'desc' => __( 'Upload an image to be used as the header background on Retina displays. Image should be exactly twice the dimensions of the normal image.', 'fearless' ),
		'id' => 'header_background_image_url_retina',
		'type' => 'upload',
		'std' => false,
		'customizer_section' => 'retina'
	);
	$options['header_background_image_url_tablet_retina'] = array(
		'name' => __( 'Retina Header Background Image (Tablet)', 'fearless' ),
		'desc' => __( 'Upload an image to be used as the header background on tablet devices with Retina displays. Image should be exactly twice the dimensions of the normal image.', 'fearless' ),
		'id' => 'header_background_image_url_tablet_retina',
		'type' => 'upload',
		'std' => false,
		'customizer_section' => 'retina'
	);
	$options['header_background_image_url_mobile_retina'] = array(
		'name' => __( 'Retina Header Background Image (Mobile)', 'fearless' ),
		'desc' => __( 'Upload an image to be used as the header background on mobile devices with Retina displays. Image should be exactly twice the dimensions of the normal image.', 'fearless' ),
		'id' => 'header_background_image_url_mobile_retina',
		'type' => 'upload',
		'std' => false,
		'customizer_section' => 'retina'
	);
	$options['logo_image_url_retina'] = array(
		'name' => __( 'Retina Logo Image', 'fearless' ),
		'desc' => __( 'Upload an image to be used as the site logo on retina displays. Image should be exactly twice the dimensions of the normal image.', 'fearless' ),
		'id' => 'logo_image_url_retina',
		'type' => 'upload',
		'std' => false,
		'customizer_section' => 'retina'
	);
	$options['branded_footer_widget_logo_url_retina'] = array(
		'name' => __( 'Retina Branded Footer Logo Image', 'fearless' ),
		'desc' => __( 'Upload an image to be used as the logo in the branded footer widget on Retina displays.', 'fearless' ),
		'id' => 'branded_footer_widget_logo_url_retina',
		'type' => 'upload',
		'std' => false,
		'customizer_section' => 'retina'
	);

	// Social Profiles
	$options[] = array(
		'name' => __( 'Social Profiles', 'fearless' ),
		'type' => 'heading',
		'customizer_section_id' => 'social_profiles',
		'customizer_priority' => 60
	);
	$social_profiles = fearless_get_social_profiles();
	foreach( $social_profiles as $id => $name ) {
		if ( 'rss' == $id ) {
			$std = home_url( '/feed/' );
		} else {
			$std = false;
		}
		$options[ 'social_profile_' . $id ] = array(
			'name' => sprintf( __( '%1$s URL', 'fearless' ), $name ),
			'id' => 'social_profile_' . $id,
			'desc' => __( 'Begin with <code>http://</code>', 'fearless' ),
			'type' => 'text',
			'std' => $std,
			'customizer_section' => 'social_profiles'
		);
	}

	// Ticker
	$options[] = array(
		'name' => __( 'Ticker', 'fearless' ),
		'type' => 'heading',
		'customizer_section_id' => 'ticker',
		'customizer_priority' => 70
	);
	$options['ticker_enabled'] = array(
		'name' => __( 'Enable Ticker', 'fearless' ),
		'desc' => __( 'Turn this on to enable the news ticker on your site.', 'fearless' ),
		'id' => 'ticker_enabled',
		'type' => 'checkbox',
		'std' => false,
		'customizer_section' => 'ticker'
	);
	$options['ticker_enabled_sitewide'] = array(
		'name' => __( 'Enable Ticker Sitewide', 'fearless' ),
		'desc' => __( 'Turn this on to enable the news ticker on all pages of your site, not just the front page.', 'fearless' ),
		'id' => 'ticker_enabled_sitewide',
		'type' => 'checkbox',
		'std' => false,
		'customizer_section' => 'ticker'
	);
	$options['ticker_title'] = array(
		'name' => __( 'Ticker Title', 'fearless' ),
		'desc' => __( 'Enter the title for the news ticker.', 'fearless' ),
		'id' => 'ticker_title',
		'type' => 'text',
		'std' => __( 'Breaking News', 'fearless' ),
		'customizer_section' => 'ticker'
	);
	$options['ticker_source'] = array(
		'name' => __( 'Ticker Posts Source', 'fearless' ),
		'desc' => __( 'Choose what posts are displayed in the news ticker.', 'fearless' ),
		'id' => 'ticker_source',
		'type' => 'select',
		'options' => array(
			'latest' => __( 'Latest Posts', 'fearless' ),
			'featured' => __( 'Featured Posts', 'fearless' )
		),
		'std' => 'latest',
		'customizer_section' => 'ticker'
	);
	$ticker_posts_count_options = array();
	for ( $i = 2; $i <= 20; $i++ ) {
		$ticker_posts_count_options[ $i ] = $i;
	}
	$options['ticker_posts_count'] = array(
		'name' => __( 'Number of items to show', 'fearless' ),
		'desc' => __( 'Choose how many items appear in the news ticker.', 'fearless' ),
		'id' => 'ticker_posts_count',
		'type' => 'select',
		'options' => $ticker_posts_count_options,
		'std' => '5',
		'customizer_section' => 'ticker'
	);

	// Typography
	$options[] = array(
		'name' => __( 'Typography', 'fearless' ),
		'type' => 'heading',
		'customizer_section_id' => 'typography',
		'customizer_priority' => 80
	);
	$options['headings_font_family'] = array(
		'name' => __( 'Headings Font', 'fearless' ),
		'desc' => __( 'Choose the font family for the site headings.', 'fearless' ),
		'id' => 'headings_font_family',
		'type' => 'select',
		'options' => fearless_get_system_fonts( $trim = true, $prefix = true ) + fearless_get_google_fonts( 'display' ),
		'std' => 'bitter',
		'customizer_section' => 'typography'
	);
	$options['headings_font_style'] = array(
		'name' => __( 'Headings Style', 'fearless' ),
		'desc' => __( 'Choose the font style for the site headings', 'fearless' ),
		'id' => 'headings_font_style',
		'type' => 'select',
		'options' => array(
			'400' => __( 'Normal', 'fearless' ),
			'700' => __( 'Bold', 'fearless' )
		),
		'std' => '400',
		'class' => 'mini',
		'customizer_section' => 'typography'
	);
	$options['body_font_family'] = array(
		'name' => __( 'Body Font', 'fearless' ),
		'desc' => __( 'Choose the body font family.', 'fearless' ),
		'id' => 'body_font_family',
		'type' => 'select',
		'options' => fearless_get_system_fonts( $trim = true, $prefix = true ) + fearless_get_google_fonts( $type = 'body' ),
		'std' => 'open-sans',
		'customizer_section' => 'typography'
	);
	$base_font_sizes = array();
	for( $i = 12; $i <= 20; $i++ ) {
		$base_font_sizes[ $i ] = sprintf( __( '%dpx', 'fearless' ), $i );
	}
	$options['base_font_size'] = array(
		'name' => __( 'Base font size', 'fearless' ),
		'desc' => __( 'Choose the typography base font size.', 'fearless' ),
		'id' => 'base_font_size',
		'type' => 'select',
		'options' => $base_font_sizes,
		'std' => '16',
		'class' => 'mini',
		'customizer_section' => 'typography'
	);

	// Miscellaneous
	$options[] = array(
		'name' => __( 'Miscellaneous', 'fearless' ),
		'type' => 'heading',
		'customizer_section_id' => 'miscellaneous',
		'customizer_priority' => 90
	);
	$options['responsive_stylesheet_enabled'] = array(
		'name' => __( 'Enable Responsiveness', 'fearless' ),
		'desc' => __( 'Turn this checkbox off to disable the responsiveness of the theme.', 'fearless' ),
		'id' => 'responsive_stylesheet_enabled',
		'type' => 'checkbox',
		'std' => true,
		'customizer_section' => 'miscellaneous'
	);
	$options['sharebar_enabled'] = array(
		'name' => __( 'Sharebar Enabled', 'fearless' ),
		'desc' => __( 'Turn this on to enable the sharebar on the home, blog archive, category, and post pages.', 'fearless' ),
		'id' => 'sharebar_enabled',
		'type' => 'checkbox',
		'std' => '1',
		'customizer_section' => 'miscellaneous'
	);
	$options['custom_css'] = array(
		'name' => __( 'Custom CSS', 'fearless' ),
		'desc' => __( 'Enter any custom CSS code here that you want to be output on your site.', 'fearless' ),
		'id' => 'custom_css',
		'type' => 'textarea',
		'std' => false,
		'customizer_section' => 'miscellaneous'
	);
	$options['google_analytics_code'] = array(
		'name' => __( 'Google Analytics Code', 'fearless' ),
		'desc' => __( 'Enter your Google Analytics code here, including the <code>&lt;script&gt;</code> tags.', 'fearless' ),
		'id' => 'google_analytics_code',
		'type' => 'textarea',
		'std' => false,
		'customizer_section' => 'miscellaneous'
	);
	$options['branded_footer_widget_logo_url'] = array(
		'name' => __( 'Branded Footer Widget Logo', 'fearless' ),
		'desc' => __( 'Upload an image to be used as the logo in the branded footer widget.', 'fearless' ),
		'id' => 'branded_footer_widget_logo_url',
		'type' => 'upload',
		'std' => false,
		'customizer_section' => 'branded_footer'
	);
	$options['branded_footer_widget_content'] = array(
		'name' => __( 'Branded Footer Widget Text', 'fearless' ),
		'desc' => __( 'Enter the text to be displayed in the branded footer widget.', 'fearless' ),
		'id' => 'branded_footer_widget_content',
		'type' => 'textarea',
		'std' => false,
		'customizer_section' => 'branded_footer_widget'
	);
	$options['menubar_search_enabled'] = array(
		'name' => __( 'Menubar Search Box Enabled', 'fearless' ),
		'desc' => __( 'Turn this on to enable the search box in the menubar.', 'fearless' ),
		'id' => 'menubar_search_enabled',
		'type' => 'checkbox',
		'std' => '1',
		'customizer_section' => 'miscellaneous'
	);

	// Advanced
	$options[] = array(
		'name' => __( 'Advanced', 'fearless' ),
		'type' => 'heading',
		'customizer_section_id' => 'advanced',
		'customizer_priority' => 100
	);
	$options['get_the_image_enabled'] = array(
		'name' => __( 'Enable Alternate Featured Image Sources', 'fearless' ),
		'desc' => __( 'Turn this on to pull featured images from a custom field, an attached image, or from the post content when a normal featured image is not available.', 'fearless' ),
		'id' => 'get_the_image_enabled',
		'type' => 'checkbox',
		'std' => false,
		'customizer_section' => 'advanced'
	);
	$options['get_the_image_custom_field'] = array(
		'name' => __( 'Custom Field Name', 'fearless' ),
		'desc' => __( 'If your featured image URLs are stored in a custom field, enter the name of the custom field here. Leave blank to disable.', 'fearless' ),
		'id' => 'get_the_image_custom_field',
		'type' => 'text',
		'std' => false,
		'class' => 'mini',
		'customizer_section' => 'advanced'
	);
	$options['get_the_image_attachment_enabled'] = array(
		'name' => __( 'Pull Featured Image From Attachment', 'fearless' ),
		'desc' => __( 'Turn this on to use the first image attched to the post as the featured image.', 'fearless' ),
		'id' => 'get_the_image_attachment_enabled',
		'type' => 'checkbox',
		'std' => false,
		'customizer_section' => 'advanced'
	);
	$options['get_the_image_post_content_enabled'] = array(
		'name' => __( 'Pull Featured Image From Post Content', 'fearless' ),
		'desc' => __( 'Turn this on to use the first image found in the post content as the featured image.', 'fearless' ),
		'id' => 'get_the_image_post_content_enabled',
		'type' => 'checkbox',
		'std' => false,
		'customizer_section' => 'advanced'
	);

	return $options;
}

function optionsframework_option_name() {
	$options_key = 'fearless_options';

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $options_key;
	update_option( 'optionsframework', $optionsframework_settings );
	return $options_key;
}

function fearless_get_option( $option_name ) {
	$options = get_option( 'fearless_options' );
	$defaults = optionsframework_options();

	if ( isset( $options[ $option_name ] ) ) {
		return $options[ $option_name ];
	} else {
		return $defaults[ $option_name ]['std'];
	}
}


function fearless_of_change_sanitization() {
	// Text field
    remove_filter( 'of_sanitize_text', 'sanitize_text_field' );
	add_filter( 'of_sanitize_text', 'fearless_sanitize_text' );

	// Textarea
	remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
	add_filter( 'of_sanitize_textarea', 'fearless_sanitize_textarea' );
}
add_action( 'admin_init', 'fearless_of_change_sanitization', 100 );

function fearless_sanitize_text( $input ) {
	global $allowedposttags;
	$output = wp_kses( $input, $allowedposttags );
	return $output;
}

function fearless_sanitize_textarea( $input ) {
	global $allowedposttags;
	$custom_allowed_tags = array(
		'script' => array(
			'type' => array()
		)
	);
	$custom_allowed_tags = array_merge( $custom_allowed_tags, $allowedposttags );
	$output = wp_kses( $input, $custom_allowed_tags );
	return $output;
}

/**
 * Removes the duplicate 'Customize' link in the themes menu
 */
function fearless_admin_menu_remove_duplicate_customize() {
	remove_submenu_page( 'themes.php', 'customize.php' );
}
add_action( 'admin_menu', 'fearless_admin_menu_remove_duplicate_customize', 999 );



