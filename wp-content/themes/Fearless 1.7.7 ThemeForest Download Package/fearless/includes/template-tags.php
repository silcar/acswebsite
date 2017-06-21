<?php
/**
 * These functions are pluggable, which means you can define these same functions in your child theme, and those functions will be used instead.
 */


if ( ! function_exists( 'fearless_author_social_profiles' ) ) :
/**
 * Outputs a list of the author's active social profiles
 */
function fearless_author_social_profiles( $author_id ) {
	$social_profiles = fearless_get_social_profiles();
	$social_profiles['url'] = __( 'URL', 'fearless' );
?>
	<ul class="author-social-profiles">
		<?php
		foreach( $social_profiles as $profile_id => $profile_name ) {
			if ( 'google-plus' == $profile_id ) $profile_id = 'googleplus';
			$current_profile_value = get_userdata( $author_id )->$profile_id;
			if ( $current_profile_value ) {
				if ( 'googleplus' == $profile_id ) $profile_id = 'google-plus';
				if ( 'url' == $profile_id )        $profile_id = 'link';
				echo '<li><a href="' . $current_profile_value . '" class="background-color-' . $profile_id . '" title="' . esc_attr( $profile_name ) . '">';
				echo '<i class="fa fa-' . $profile_id . '" aria-hidden="true"></i>';
				echo '<span class="screen-reader-text">' . $profile_name . '</span>';
				echo '</a></li>';
			}
		}
		?>
	</ul>
<?php
}
endif;

if ( ! function_exists( 'fearless_comment' ) ) :
/**
 * Outputs the markup for a single comment
 */
function fearless_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'fearless' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'fearless' ), '<span class="edit-link">', '<span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'fearless' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'fearless' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_time( 'c' ); ?>">
					<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'fearless' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( 'Edit', 'fearless' ), '<span class="edit-link">', '<span>' ); ?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif;


if ( ! function_exists( 'fearless_entry_meta' ) ) :
/**
 * Outputs post entry meta
 */
function fearless_entry_meta( $context = null ) {
	if ( 'compact' == $context ) {
		$format = '%2$s | %4$s';
	} else {
		$format = '%1$s %2$s | %3$s %4$s';
	}

	printf(
		$format,
		'<span class="label">' . __( 'Posted on', 'fearless' ) . '</span>',
		get_the_time( get_option( 'date_format' ) ),
		'<span class="label">' . __( 'by', 'fearless' ) . '</span>',
		get_the_author()
	);
}
endif;


if ( ! function_exists( 'fearless_flexslider' ) ) :
/**
 * Outputs a Flexslider posts slider
 */
function fearless_flexslider( $args = array(), $type = 'featured' ) {

	$slider_posts = new WP_Query( $args );

	if ( $slider_posts->have_posts() ) :

		echo '<div class="' . $type . '-slider flexslider"><ul class="slides">';

		while( $slider_posts->have_posts() ) : $slider_posts->the_post();

			if ( 'gallery' != $type ) {
				if ( $category_label_override = get_post_meta( get_the_ID(), 'fearless_category_label_override', true ) ) {
					$category = get_category( (int) $category_label_override );
				} else {
					$category = get_the_category();
					$category = $category[0];
				}
			}

			echo '<li>';

			if ( 'gallery' != $type ) echo '<a href="' . get_permalink() . '">';

			if ( 'gallery' == $type ) {
				echo wp_get_attachment_image( get_the_ID(), 'post-thumbnail' );
			} else {
				fearless_post_thumbnail( 'post-thumbnail', $link = false, $wrap = false );
			}

			if ( 'gallery' != $type ) {
				$category_label_wrapper_style = $category_label_style = '';
				if ( $slide_category_accent_color = fearless_get_category_meta_hierarchical( $category->term_id, 'fearless_accent_color' ) ) {
					$category_label_wrapper_style = ' style="border-color: ' . $slide_category_accent_color . ';"';
					$category_label_style = 'style="background-color: ' . $slide_category_accent_color . ';"';
				}
				echo '<div class="category-label-wrapper"' . $category_label_wrapper_style . '><span class="category-label"' . $category_label_style . '>' . $category->cat_name . '</span></div>';
			}

			echo '<div class="slide-overlay">';

			echo '<h3 class="slide-title entry-title">' . get_the_title() . '</h3>';

			echo '<div class="slide-meta">';
			if ( 'gallery' == $type ) {
				echo fearless_get_the_excerpt();
			} else {
				echo strip_tags( do_shortcode( __( 'Posted by [entry-author] on [entry-published] in [entry-terms taxonomy="category"]', 'fearless' ) ) );
			}
			echo '</div>';

			echo '</div>';

			if ( 'gallery' != $type ) echo '</a>';

			echo '</li>';

		endwhile;

		echo '</ul>';

		echo '</div>';

		if ( 'gallery' == $type ) :

			echo '<div class="gallery-slider-thumbnails">';
			$count = 0;
			while( $slider_posts->have_posts() ) : $slider_posts->the_post();

				echo '<a href="#" data-slide-index="' . $count . '">';
				echo wp_get_attachment_image( get_the_ID(), 'thumb-83' );
				echo '</a>';

				$count++;
			endwhile;

			echo '</div>';

		endif;

		wp_reset_postdata();

	endif;
}
endif;


if ( ! function_exists( 'fearless_format_video_embed_code' ) ) :
/**
 * Formats video post format embed codes
 */
function fearless_format_video_embed_code( $embed_code = null ) {

	// If this is a YouTube video embed, add "?wmode=transparent" to the iframe URL
	if ( strpos( $embed_code, 'youtube.com' ) ) {

		$pattern = '/src="(.*?)"/';
		$replacement = 'src="${1}?wmode=transparent"';
		$embed_code = preg_replace( $pattern, $replacement, $embed_code );

	}

	return $embed_code;
}
endif;


if ( ! function_exists( 'fearless_get_attachment_id_from_url' ) ) :
/**
 * Returns the attachment ID from the specified URL
 * @link http://philipnewcomer.net/2012/11/get-the-attachment-id-from-an-image-url-in-wordpress/
 */
function fearless_get_attachment_id_from_url( $attachment_url = '' ) {

	global $wpdb;
	$attachment_id = false;

	// If there is no url, return.
	if ( '' == $attachment_url )
		return;

	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();

	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

	}

	return $attachment_id;
}
endif;


if ( ! function_exists( 'fearless_get_blogroll_layout_styles' ) ) :
/**
 * Returns an array of available blogroll layout styles
 */
function fearless_get_blogroll_layout_styles() {
	return array(
		'1col-full' => __( 'One column, full-width images', 'fearless' ),
		'1col-half' => __( 'One column, half-width images', 'fearless' ),
		'1col-square' => __( 'One Column, small square images', 'fearless' ),
		'1col-thumb'  => __( 'One Column, thumbnail images', 'fearless' ),
		'2col' => __( 'Two Columns', 'fearless' )
	);
}
endif;


if ( ! function_exists( 'fearless_get_category_meta_hierarchical' ) ) :
/**
 * Returns the specified taxonomy meta, moving up the chain of parent terms until the end is reached, or a meta value is found. Requires the Tax-meta-class to be available.
 */
function fearless_get_category_meta_hierarchical( $term_id, $field ) {

	// Make sure the get_tax_meta() function exists
	if ( ! function_exists( 'get_tax_meta' ) )
		return false;

	// See if this term contains the specified meta key
	$category_meta = get_tax_meta( $term_id, $field, true );

	// If $meta_value contains data, there's no need to continue
	if ( $category_meta )
		return $category_meta;

	/*** If we're still alive, continue checking the parent term ***/

	// Get term data
	$term_data = get_term( $term_id, 'category' );

	// If the term has a parent, check that (recursively), otherwise exit
	if ( $term_data->parent ) {
		return fearless_get_category_meta_hierarchical( $term_data->parent, $field );
	} else {
		return false;
	}
}
endif;


if ( ! function_exists( 'fearless_get_the_excerpt' ) ) :
/**
 * Returns the post excerpt of a specific length
 */
function fearless_get_the_excerpt( $length = 40, $more = '&hellip;' ) {
	return wp_trim_words( get_the_excerpt(), $length, $more );
}
endif;


if ( ! function_exists( 'fearless_get_social_profiles' ) ) :
/**
 * Returns an array of the available social profiles
 */
function fearless_get_social_profiles() {
	return array(
		'facebook'    => __( 'Facebook', 'fearless' ),
		'flickr'      => __( 'Flickr', 'fearless' ),
		'google-plus' => __( 'Google Plus', 'fearless' ),
		'instagram'   => __( 'Instagram', 'fearless' ),
		'linkedin'    => __( 'LinkedIn', 'fearless' ),
		'pinterest'   => __( 'Pinterest', 'fearless' ),
		'rss'         => __( 'RSS Feed', 'fearless' ),
		'tumblr'      => __( 'Tumblr', 'fearless' ),
		'twitter'     => __( 'Twitter', 'fearless' ),
		'youtube'     => __( 'YouTube', 'fearless' )
	);
}
endif;


if ( ! function_exists( 'fearless_header_background_image' ) ) :
/**
 * Outputs the header background image
 */
function fearless_header_background_image() {
	$header_background_image_url = fearless_get_option( 'header_background_image_url' );
	if ( $header_background_image_url ) {
		$image_attachment_id = fearless_get_attachment_id_from_url( $header_background_image_url );
		if ( $image_attachment_id ) {
			$image_data = wp_get_attachment_image_src( $image_attachment_id, 'full' );
		} else {
			if ( false !== strpos( $header_background_image_url, get_bloginfo( 'url' ) ) ) {
				$logo_image_path = untrailingslashit( ABSPATH ) . str_replace( get_bloginfo( 'url' ), '', $header_background_image_url );
				$sizes = getimagesize( $logo_image_path );
				$image_data = array(
					$header_background_image_url,
					$sizes[0],
					$sizes[1]
				);
			} else {
				$image_data = array(
					$header_background_image_url,
					null,
					null
				);
			}
		}
		printf( '<div id="header-background-image-wrapper"><img src="%1$s" id="header-background-image" alt="%2$s" width="%3$s" height="%4$s" /></div>',
			$image_data[0],
			esc_attr__( 'Header image', 'fearless' ),
			$image_data[1],
			$image_data[2]
		);
	}
}
endif;


if ( ! function_exists( 'fearless_logo' ) ) :
/**
 * Outputs the logo set in the theme options
 */
function fearless_logo() {
	if ( $logo_image_url = fearless_get_option( 'logo_image_url' ) ) :
		$image_attachment_id = fearless_get_attachment_id_from_url( $logo_image_url );
		if ( $image_attachment_id ) {
			$image_data = wp_get_attachment_image_src( $image_attachment_id, 'full' );
		} else {
			if ( false !== strpos( $logo_image_url, get_bloginfo( 'url' ) ) ) {
				$logo_image_path = untrailingslashit( ABSPATH ) . str_replace( get_bloginfo( 'url' ), '', $logo_image_url );
				$sizes = getimagesize( $logo_image_path );
				$image_data = array(
					$logo_image_url,
					$sizes[0],
					$sizes[1]
				);
			} else {
				$image_data = array(
					$logo_image_url,
					null,
					null
				);
			}
		}
		printf( '<img src="%1$s" alt="%2$s" width="%3$s" height="%4$s" />',
			$image_data[0],
			__( 'Logo', 'fearless' ),
			$image_data[1],
			$image_data[2]
		);
	endif;
}
endif;


if ( ! function_exists( 'fearless_nav_menu_primary_fallback' ) ) :
/**
 * Fallback function for when there is no menu assigned to the Primary Navigation theme location
 */
function fearless_nav_menu_primary_fallback( $args ) {
	$args['title_li'] = null;
	echo '<ul class="menu sf-menu">';
	wp_list_pages( $args );
	echo '</ul>';
}
endif;


if ( ! function_exists( 'fearless_post_teaser' ) ) :
/**
 * Generates the markup for a layout module post
 */
function fearless_post_teaser( $args = array() ) {
	$defaults = array(
		'class' => null,
		'excerpt_length' => false,
		'show_views' => false,
		'thumbnail' => 'post-thumbnail',
		'wrap' => 'article'
	);
	$args = wp_parse_args( $args, $defaults );
	?>
	<<?php echo $args['wrap']; if ( $args['class'] ) echo ' class="' . $args['class'] . '"'; ?>>

		<?php fearless_post_thumbnail( $args['thumbnail'], $link = true ); ?>

		<?php if ( 'article' == $args['wrap'] ) echo '<header class="entry-header">'; ?><h2 class="<?php if ( 'article' == $args['wrap'] ) echo 'entry-'; ?>title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

		<div class="<?php if ( 'article' == $args['wrap'] ) echo 'entry-'; ?>byline">
			<?php
			if ( $args['show_views'] ) :
				$entry_views = get_post_meta( get_the_ID(), apply_filters( 'entry_views_meta_key', 'Views' ), true );
				$entry_views = sprintf( _n( '1 view', '%s views', $entry_views, 'fearless' ), $entry_views );
			endif;

			if ( get_post_meta( get_the_ID(), 'fearless_review_enabled', true ) && $star_rating = get_post_meta( get_the_ID(), 'fearless_review_final_score', true ) ) :
				echo fearless_star_rating( $star_rating, $args['class'] );
			elseif ( $args['show_views'] ) :
				printf( apply_atomic_shortcode( 'entry_byline', __( '%1$s / [entry-published before="Posted "]', 'fearless' ) ), $entry_views );
			else :
				echo apply_atomic_shortcode( 'entry_byline', __( '[entry-published] / [entry-author]', 'fearless' ) );
			endif;
			?>
		</div>
		<?php if ( 'article' == $args['wrap'] ) echo '</header>'; ?>

		<?php if ( $args['excerpt_length'] ) : ?>
			<div class="entry-summary"><?php echo fearless_get_the_excerpt( $args['excerpt_length'] ); ?></div>
		<?php endif; ?>
	</<?php echo $args['wrap']; ?>>
	<?php
}
endif;


if ( ! function_exists( 'fearless_post_thumbnail' ) ) :
/**
 * Outputs the post thumbnail in the specified size, using a "missing image" fallback if necessary
 */
function fearless_post_thumbnail( $thumbnail_size = 'post-thumbnail', $link = null, $wrap = true ) {

	if ( $wrap ) echo '<div class="post-thumbnail-wrap">';
	if ( null === $link && ! is_singular() OR true === $link ) echo '<a href="' . get_permalink() . '">';
	if ( 'post-thumbnail' == $thumbnail_size && 'layout-1c' == theme_layouts_get_layout() ) $thumbnail_size = 'post-thumbnail-fullwidth';

	if ( has_post_thumbnail( get_the_ID() ) ) {

		the_post_thumbnail( $thumbnail_size, array( 'class' => "attachment-{$thumbnail_size} featured-image" ) );

	} else {

		// Get the target image sizes
		if ( 'thumbnail' == $thumbnail_size ) {
			$image_width = 150;
			$image_height = 150;
		} else {
			global $_wp_additional_image_sizes;
			$image_width = $_wp_additional_image_sizes[ $thumbnail_size ]['width'];
			$image_height = $_wp_additional_image_sizes[ $thumbnail_size ]['height'];
		}

		// Use the get_the_image() script to retrieve an image if possible and enabled
		if ( fearless_get_option( 'get_the_image_enabled' ) ) {
			$get_the_image_data = get_the_image( array(
				'attachment' => fearless_get_option( 'get_the_image_attachment_enabled' ),
				'format' => 'array',
				'image_class' => "attachment-{$thumbnail_size} featured-image wp-post-image",
				'image_scan' => fearless_get_option( 'get_the_image_post_content_enabled' ),
				'meta_key' => fearless_get_option( 'get_the_image_custom_field' ),
				'size' => $thumbnail_size
			) );
		}

		// If get_the_image() provides a result, use that; otherwise use a "missing image" fallback
		if ( isset( $get_the_image_data ) && ! empty( $get_the_image_data ) ) {
			$image_url = $get_the_image_data['src'];
			$image_alt = $get_the_image_data['alt'];
		} else {
			$image_url = get_template_directory_uri() . "/images/missing-image-{$image_width}x{$image_height}.png";
			$image_alt = esc_attr__( 'Missing image', 'fearless' );
		}

		// Try to get the requested thumbnail size for the image URL
		if ( $image_attachment_id = fearless_get_attachment_id_from_url( $image_url ) ) {
			$attachment_image_data = wp_get_attachment_image_src( $image_attachment_id, $thumbnail_size );
			$image_url = $attachment_image_data[0];
			$image_width = $attachment_image_data[1];
			$image_height = $attachment_image_data[2];
		}

		// Output the image
		printf( '<img src="%1$s" class="attachment-%2$s wp-post-image" width="%3$s" height="%4$s" alt="%5$s" />',
			$image_url,
			$thumbnail_size,
			$image_width,
			$image_height,
			$image_alt
		);
	}

	if ( null === $link && ! is_singular() OR true === $link ) echo '</a>';
	if ( $wrap ) echo '</div><!-- .post-thumbnail-wrap -->';
}
endif;


if ( ! function_exists( 'fearless_social_icons' ) ) :
/**
 * Outputs a list of active social profiles
 */
function fearless_social_icons( $background_color_class = false, $new_window = false ) {
	echo '<ul class="social-icons">';

	foreach( fearless_get_social_profiles() as $profile_id => $profile_name ) :

		$profile_url = fearless_get_option( 'social_profile_' . $profile_id );
		if ( $profile_url ) {
			$target = $new_window ? ' target="_blank"' : null;
			echo '<li><a href="' . $profile_url . '"' . ( $background_color_class ? ' class="background-color-' . $profile_id . '"' : '' ) . ' title="' . esc_attr( $profile_name ) . '"' . $target . '>';
			echo '<i class="fa fa-' . $profile_id . '" aria-hidden="true"></i>';
			echo '<span class="screen-reader-text">' . $profile_name . '</span>';
			echo '</a></li>';
		}

	endforeach;

	echo '</ul>';
}
endif;
