<?php

// Init Hybrid Core
require_once( get_template_directory() . '/hybrid-core/hybrid.php' );
new Hybrid();

// Define includes directory
if ( ! defined( 'FEARLESS_INCLUDES' ) ) {
	define( 'FEARLESS_INCLUDES', trailingslashit( get_template_directory() . '/includes' ) );
}

/**
 * Theme setup function
 */
function fearless_theme_setup() {

	// Get action filter/hook prefix
	$prefix = hybrid_get_prefix();

	// Load theme Functions
	require_once( FEARLESS_INCLUDES  . 'customizer.php' );
	require_once( FEARLESS_INCLUDES  . 'fonts.php' );
	require_once( FEARLESS_INCLUDES  . 'reviews.php' );
	require_once( FEARLESS_INCLUDES  . 'template-tags.php' );
	require_once( FEARLESS_INCLUDES  . 'widget-areas.php' );

	// Load theme widgets
	require_once( FEARLESS_INCLUDES . 'widgets-init.php' );

	// Init Meta Box Plugin
	define( 'RWMB_URL', get_template_directory_uri() . '/includes/meta-box/' );
	define( 'RWMB_DIR', FEARLESS_INCLUDES . '/meta-box/' );
	require_once( RWMB_DIR . 'meta-box.php' );
	require_once( FEARLESS_INCLUDES . 'meta-box-config.php' );

	// Init Tax Meta Class
	require_once( FEARLESS_INCLUDES . 'Tax-meta-class/migration/tax_to_term_meta.php' );
	new tax_to_term_meta();
	require_once( FEARLESS_INCLUDES . 'Tax-meta-class/Tax-meta-class.php' );
	require_once( FEARLESS_INCLUDES . 'tax-meta-config.php' );

	// Init Options Framework
	require_once FEARLESS_INCLUDES . 'theme-options.php';
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/includes/options-framework/' );
	add_filter( 'options_framework_location', create_function( false, 'return array( "includes/theme-options.php" );' ) );
	require( FEARLESS_INCLUDES . 'options-framework/options-framework.php' );

	// Register nav menus
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'fearless' ),
		'secondary' => __( 'Secondary Navigation', 'fearless' ),
		'footer' => __( 'Footer Navigation', 'fearless' )
	) );

	// Add theme support for WordPress features
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array( 'audio', 'gallery', 'video' ) );

	// Add theme support for Hybrid core features
	add_theme_support( 'breadcrumb-trail' );
	add_theme_support( 'cleaner-caption' );
	add_theme_support( 'cleaner-gallery' );
	if ( fearless_get_option( 'get_the_image_enabled' ) ) add_theme_support( 'get-the-image' );
	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-template-hierarchy' );
	add_theme_support( 'loop-pagination' );
	add_theme_support( 'theme-layouts',
		array( '1c', '2c-l', '2c-r', '3c-l', '3c-r', '3c-c-l', '3c-c-r' ),
		array(
			'default' => fearless_get_option( 'default_theme_layout' ),
			'customize' => false
		)
	);
	add_theme_support( 'entry-views' );

	// Set content width
	hybrid_set_content_width( 640 );

	// Filter comments template for Disqus comments
	if ( defined( 'DISQUS_VERSION' ) ) add_filter( 'comments_template', 'dsq_comments_template', 100 );

}
add_action( 'after_setup_theme', 'fearless_theme_setup' );


/**
 * Registers and enqueues admin scripts and styles
 */
function fearless_admin_enqueue_scripts() {
	$theme_version = wp_get_theme()->Version;

	wp_register_script( 'fearless-admin', get_template_directory_uri() . '/js/fearless-admin.js', array( 'jquery' ), $theme_version, true );
	wp_register_style( 'fearless-admin', get_template_directory_uri() . '/css/fearless-admin.css', array(), $theme_version );

	wp_enqueue_script( 'fearless-admin' );
	wp_enqueue_style( 'fearless-admin' );
}
add_action( 'admin_enqueue_scripts', 'fearless_admin_enqueue_scripts' );


/**
 * Outputs the jQuery Backstretch script
 */
function fearless_backstretch() {
	$backstretch_url = false;

	if ( is_category() && $category_image_data = fearless_get_category_meta_hierarchical( get_query_var( 'cat' ), 'fearless_fullscreen_background' ) ) {
		$category_image_data = wp_get_attachment_image_src( $category_image_data['id'], 'large' );
		$backstretch_url = $category_image_data[0];
	} elseif ( is_singular( 'post' ) ) {
		$categories = get_the_category( get_the_ID() );
		$category_data = $categories[0];
		$category_image_data = fearless_get_category_meta_hierarchical( $category_data->term_id, 'fearless_fullscreen_background' );
		if ( $category_image_data ) {
			$category_image_data = wp_get_attachment_image_src( $category_image_data['id'], 'large' );
			$backstretch_url = $category_image_data[0];
		}
	}

	if ( ! $backstretch_url ) {
		$default_fullscreen_background_url = fearless_get_option( 'default_fullscreen_background_url' );
		$attachment_id = fearless_get_attachment_id_from_url( $default_fullscreen_background_url );
		if ( $attachment_id ) {
			$background_image_data = wp_get_attachment_image_src( $attachment_id, 'large' );
			$backstretch_url = $background_image_data[0];
		} else {
			$backstretch_url = $default_fullscreen_background_url;
		}
	}

	if ( ! $backstretch_url )
		return;
?>
<script>
	jQuery(document).ready(function($){
		$.backstretch(
			"<?php echo $backstretch_url; ?>",
			{ fade: 350 }
		);
	});
</script>
<?php
}
add_action( 'wp_footer', 'fearless_backstretch' );


/**
 * Sets the blogroll layout style
 */
function fearless_blogroll_layout_init() {
	global $fearless_blogroll_layout;

	if ( is_singular() )
		return;

	$fearless_blogroll_layout = array(
		'meta_format' => null,
		'excerpt_length' => 35,
		'thumbnail_size' => 'post-thumbnail'
	);

	if ( is_category() && $category_layout = fearless_get_category_meta_hierarchical( get_query_var( 'cat' ), 'fearless_blogroll_layout_style' ) ) {
		$fearless_blogroll_layout['style'] = $category_layout;
	} elseif ( is_search() ) {
		$fearless_blogroll_layout['style'] = '1col-square';
	} else {
		$fearless_blogroll_layout['style'] = fearless_get_option( 'default_blogroll_layout_style' );
	}

	switch( $fearless_blogroll_layout['style'] ) {
		case '1col-half':
			$fearless_blogroll_layout['thumbnail_size'] = 'thumb-320';
			$fearless_blogroll_layout['meta_format'] = 'compact';
			$fearless_blogroll_layout['excerpt_length'] = 15;
			break;
		case '1col-square':
			$fearless_blogroll_layout['thumbnail_size'] = 'thumbnail';
			$fearless_blogroll_layout['excerpt_length'] = 15;
			break;
		case '1col-thumb':
			$fearless_blogroll_layout['thumbnail_size'] = 'thumb-83';
			$fearless_blogroll_layout['excerpt_length'] = 18;
			break;
		case '2col':
			$fearless_blogroll_layout['thumbnail_size'] = 'thumb-320';
			$fearless_blogroll_layout['meta_format'] = 'compact';
			$fearless_blogroll_layout['excerpt_length'] = 18;
			break;
	}
}
add_action( 'template_redirect', 'fearless_blogroll_layout_init' );


/**
 * Sets defaults for the Cleaner Gallery extension
 */
function fearless_cleaner_gallery_defaults( $defaults ) {
	$defaults['size'] = 'thumb-232';
	return $defaults;
}
add_filter( 'cleaner_gallery_defaults', 'fearless_cleaner_gallery_defaults' );


/**
 * Registers and enqueues theme scripts and styles
 */
function fearless_enqueue_scripts() {
	$theme_version = wp_get_theme()->Version;

	// Deregister WordPress scripts
	wp_deregister_script( 'hoverIntent' );

	// Register scripts
	wp_register_script( 'backstretch', get_template_directory_uri() . '/js/jquery.backstretch.min.js', array( 'jquery' ), '2.0.3', true );
	wp_register_script( 'fancybox', get_template_directory_uri() . '/fancybox/jquery.fancybox-1.3.4.pack.js', array( 'jquery' ), '1.3.4', true );
	wp_register_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.min.js', array( 'jquery' ), false, true );
	wp_register_script( 'fearless', get_template_directory_uri() . '/js/fearless.js', array( 'jquery' ), $theme_version, true );
	wp_register_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider.min.js', array( 'jquery' ), '2.1', true );
	wp_register_script( 'hoverIntent', get_template_directory_uri() . '/js/jquery.hoverIntent.min.js', array( 'jquery' ), 'r7', true );
	wp_register_script( 'superfish', get_template_directory_uri() . '/js/jquery.superfish.min.js', array( 'jquery' ), '1.6.9', true );
	wp_register_script( 'ticker', get_template_directory_uri() . '/js/jquery.ticker.js', array( 'jquery' ), $theme_version, true );
	wp_register_script( 'tinynav', get_template_directory_uri() . '/js/jquery.tinynav.min.js', array( 'jquery' ), '1.1', true );

	// Register styles
	wp_register_style( 'fancybox', get_template_directory_uri() . '/fancybox/jquery.fancybox-1.3.4.css', array(), '1.3.4' );
	wp_register_style( 'fearless', get_stylesheet_uri(), array( 'normalize' ), $theme_version );
	wp_register_style( 'fearless-responsive', get_template_directory_uri() . '/css/fearless-responsive.css', array(), $theme_version );
	wp_register_style( 'fearless-responsive-rtl', get_template_directory_uri() . '/css/fearless-responsive-rtl.css', array(), $theme_version );
	wp_register_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css', array(), '2.0' );
	wp_register_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css', array(), '4.0.3' );
	wp_register_style( 'normalize', get_template_directory_uri() . '/css/normalize.css', array(), '2.1.1' );

	// Enqueue scripts
	wp_enqueue_script( 'backstretch' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
	wp_enqueue_script( 'fancybox' );
	wp_enqueue_script( 'fitvids' );
	wp_enqueue_script( 'fearless' );
	wp_enqueue_script( 'flexslider' );
	wp_enqueue_script( 'hoverIntent' );
	wp_enqueue_script( 'superfish' );
	wp_enqueue_script( 'ticker' );
	wp_enqueue_script( 'tinynav' );

	// Enqueue styles
	wp_enqueue_style( 'fancybox' );
	wp_enqueue_style( 'fearless' );
	if ( fearless_get_option( 'responsive_stylesheet_enabled' ) ) wp_enqueue_style( 'fearless-responsive' );
	if ( fearless_get_option( 'responsive_stylesheet_enabled' ) && is_rtl() ) wp_enqueue_style( 'fearless-responsive-rtl' );
	wp_enqueue_style( 'font-awesome' );
	wp_enqueue_style( 'normalize' );

	// Localize scripts
	wp_localize_script(
		'fearless',
		'fearless_localized_strings',
		array(
			'ticker_title' => fearless_get_option( 'ticker_title' )
		)
	);
}
add_action( 'wp_enqueue_scripts', 'fearless_enqueue_scripts' );


/**
 * Outputs the favicon to wp_head if one is set in the theme options
 */
function fearless_favicon() {
	$favicon_url = fearless_get_option( 'favicon_url' );
	if ( $favicon_url ) {
		echo '<link rel="shortcut icon" type="image/x-icon" href="' . $favicon_url . '" />' . "\n";
	}
}
add_action( 'wp_head', 'fearless_favicon' );

/**
 * Adds theme classes to the WordPress body_class() function
 */
function fearless_filter_body_class( $classes ) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome;

	/* Browser detection */
	$browsers = array( 'gecko' => $is_gecko, 'opera' => $is_opera, 'lynx' => $is_lynx, 'ns4' => $is_NS4, 'safari' => $is_safari, 'chrome' => $is_chrome, 'msie' => $is_IE );
	foreach ( $browsers as $key => $value ) {
		if ( $value ) {
			$classes[] = $key;
			break;
		}
	}

	/* Topbar enabled */
	if ( ! ( 'disabled' == fearless_get_option( 'topbar_left_display' ) && 'disabled' == fearless_get_option( 'topbar_right_display' ) ) ) {
		$classes[] = 'topbar-enabled';
	}

	/* Logo image */
	if ( $logo_image_url = fearless_get_option( 'logo_image_url' ) )
		$classes[] = 'logo-image-enabled';

	return $classes;
}
add_filter( 'body_class', 'fearless_filter_body_class' );


/**
 * Outputs Google Webfont embed code from the fonts chosen in the theme options
 */
function fearless_google_webfont_code() {
	$google_font_data = fearless_get_google_fonts();
	$headings_font_family = fearless_get_option( 'headings_font_family' );
	$headings_font_style = fearless_get_option( 'headings_font_style' );
	$body_font_family = fearless_get_option( 'body_font_family' );
	$webfonts = array();

	if ( array_key_exists( $headings_font_family, $google_font_data ) ) {
		$webfonts[ $headings_font_family ] = str_replace( ' ', '+', $google_font_data[ $headings_font_family ] ) . ':' . $headings_font_style;
	}

	if ( array_key_exists( $body_font_family, $google_font_data ) ) {
		$webfonts[ $body_font_family ] = str_replace( ' ', '+', $google_font_data[ $body_font_family ] ) . ':400,400italic,700';
	}

	if ( ! empty( $webfonts ) ) {
		$webfonts = implode( '|', $webfonts );
		echo '<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=' . $webfonts . '" />' . "\n";
	}
}
add_action( 'wp_head', 'fearless_google_webfont_code' );


/**
 * Outputs CSS code generated from theme options settings
 */
function fearless_header_css() {
	get_template_part( 'header-css' );
}
add_action( 'wp_head', 'fearless_header_css' );


/**
 * Filters the Hybrid list_comments_args array
 */
function fearless_list_comments_args( $args ) {
	$args['avatar_size'] = 50;
	return $args;
}
add_filter( 'fearless_list_comments_args', 'fearless_list_comments_args' );


/**
 * Adds the layout style to the post class
 */
function fearless_post_class( $classes ) {
	global $fearless_blogroll_layout;

	if ( ! is_singular() && ! is_404() && isset( $fearless_blogroll_layout['style'] ) )
		$classes[] = 'layout-' . $fearless_blogroll_layout['style'];

	return $classes;
}
add_filter( 'post_class', 'fearless_post_class' );


/**
 * Filter theme layouts text strings
 */
function fearless_theme_layouts_strings( $strings = array() ) {
	$strings = array(
		'default' => __( 'Default layout set in the theme options', 'fearless' ),
		'1c' => __( 'Full width (no sidebars)', 'fearless' ),
		'2c-l' => __( 'Two columns, content left', 'fearless' ),
		'2c-r' => __( 'Two columns, content right', 'fearless' ),
		'3c-l' => __( 'Three columns, content left', 'fearless' ),
		'3c-r' => __( 'Three columns, content right', 'fearless' ),
		'3c-c-l' => __( 'Three columns, center, primary sidebar left', 'fearless' ),
		'3c-c-r' => __( 'Three columns, center, primary sidebar right', 'fearless' )
	);
	return $strings;
}
add_filter( 'theme_layouts_strings', 'fearless_theme_layouts_strings' );


/**
 * Registers theme thumbnail sizes
 */
function fearless_thumbnails_init() {
	set_post_thumbnail_size( 640, 360, true );
	add_image_size( 'post-thumbnail-fullwidth', 1002, 360, true );
	add_image_size( 'thumb-320', 320, 180, true );
	add_image_size( 'thumb-232', 232, 150, true );
	add_image_size( 'thumb-83', 83, 83, true );
	add_image_size( 'thumb-55', 55, 55, true );
}
add_action( 'after_setup_theme', 'fearless_thumbnails_init' );


/**
 * Outputs tinynav.js code to wp_head
 */
function fearless_tinynav() {
?>
<script>
jQuery(document).ready(function($){
	$('#primary-navigation > ul, #secondary-navigation > ul').tinyNav({
		active: 'current-menu-item',
		header: '<?php _e( 'Menu', 'fearless' ); ?>'
	});
});
</script>
<?php
}
add_action( 'wp_head', 'fearless_tinynav' );


/**
 * Registers the available social profiles as options on the user profile edit page
 */
function fearless_usercontactmethods( $user_contactmethods ) {
	$social_profiles = fearless_get_social_profiles();

	unset( $social_profiles['rss'] );

	$social_profiles['googleplus'] = $social_profiles['google-plus'];
	unset( $social_profiles['google-plus'] );

	$social_profiles['url'] = __( 'URL', 'fearless' );

	asort( $social_profiles );
	return array_merge( $user_contactmethods, $social_profiles );
}
add_filter( 'user_contactmethods', 'fearless_usercontactmethods' );


/**
 * Filters wp_title to print a <title> tag based on the page being viewed
 */
function fearless_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	$title .= get_bloginfo( 'name' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', '_s' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'fearless_wp_title', 10, 2 );


/**
 * Filters cleaner_gallery_image to add "rel" attribute for lightbox gallery
 */
function fearless_cleaner_gallery_image( $image, $attachment_id, $attr, $cleaner_gallery_instance ) {

	$image = str_replace( '<a href=', '<a rel="gallery-' . $cleaner_gallery_instance . '" href=', $image );

	return $image;
}
add_filter( 'cleaner_gallery_image', 'fearless_cleaner_gallery_image', 10, 5 );
