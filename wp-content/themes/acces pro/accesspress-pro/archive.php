<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Accesspress Pro
 */

get_header(); 
global $accesspress_pro_options;
$accesspress_pro_settings = get_option( 'accesspress_pro_options', $accesspress_pro_options );
$accesspress_pro_show_breadcrumb = $accesspress_pro_settings['show_breadcrumb'];
?>

			<header class="entry-header">
			<?php 
			if ((function_exists('accesspress_pro_breadcrumbs') && $accesspress_pro_show_breadcrumb == 0) || empty($accesspress_pro_show_breadcrumb)) {
					accesspress_pro_breadcrumbs();
			} ?>
				<h1 class="entry-title ak-container">
					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							printf( __( 'Author: %s', 'accesspress_pro' ), '<span class="vcard">' . get_the_author() . '</span>' );

						elseif ( is_day() ) :
							printf( __( 'Day: %s', 'accesspress_pro' ), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
							printf( __( 'Month: %s', 'accesspress_pro' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'accesspress_pro' ) ) . '</span>' );

						elseif ( is_year() ) :
							printf( __( 'Year: %s', 'accesspress_pro' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'accesspress_pro' ) ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( 'Asides', 'accesspress_pro' );

						elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
							_e( 'Galleries', 'accesspress_pro' );

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images', 'accesspress_pro' );

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos', 'accesspress_pro' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( 'Quotes', 'accesspress_pro' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( 'Links', 'accesspress_pro' );

						elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
							_e( 'Statuses', 'accesspress_pro' );

						elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
							_e( 'Audios', 'accesspress_pro' );

						elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
							_e( 'Chats', 'accesspress_pro' );

						else :
							_e( 'Archives', 'accesspress_pro' );

						endif;
					?>
				</h1>
				<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description"><div class="ak-container">%s</div></div>', $term_description );
					endif;
				?>
			</header><!-- .page-header -->

			<div class="ak-container">
			<div id="primary" class="content-area">
			<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', 'summary' );
				?>

			<?php endwhile; ?>

			<?php accesspress_pro_paging_nav(); ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>
			</div>

			<?php get_sidebar('right'); ?>

			</div>


<?php get_footer(); ?>
