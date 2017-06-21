<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Accesspress Pro
 */

get_header(); 
global $accesspress_pro_options;
$accesspress_pro_settings = get_option( 'accesspress_pro_options', $accesspress_pro_options );
$accesspress_pro_show_breadcrumb = $accesspress_pro_settings['show_breadcrumb'];
?>

<section class="error-404 not-found">

	<header class="entry-header">
		<?php 
		if ((function_exists('accesspress_pro_breadcrumbs') && $accesspress_pro_show_breadcrumb == 0) || empty($accesspress_pro_show_breadcrumb)) {
			accesspress_pro_breadcrumbs();
		} ?>
		<h1 class="entry-title ak-container"><?php _e( 'Oops! That page can&rsquo;t be found.', 'accesspress_pro' ); ?></h1>
		</header><!-- .entry-header -->

		<div class="ak-container">
			<div class="page-content">
				<p><?php _e( 'It looks like nothing was found at this location.', 'accesspress_pro' ); ?></p>
			</div><!-- .page-content -->
                
            <div class="number404">
                404 
            <span>error</span>   
        </div>
	</div>
</section><!-- .error-404 -->


<?php get_footer(); ?>
