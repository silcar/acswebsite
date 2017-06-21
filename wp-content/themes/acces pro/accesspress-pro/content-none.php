<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Accesspress Pro
 */
?>

<section class="no-results not-found">
	<header class="archive-header">
		<h2 class="archive-title"><?php _e( 'Pas de résultats', 'accesspress_pro' ); ?></h2>
	</header><!-- .page-header -->

	<div class="entry-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'accesspress_pro' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Désolé, mais rien ne correspond à vos termes de recherche. Veuillez réessayer .', 'accesspress_pro' ); ?></p>


		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'accesspress_pro' ); ?></p>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
