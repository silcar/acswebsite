<?php get_header(); ?>

	<div id="primary">
		<div id="content" class="hfeed" role="main">

			<?php get_template_part( 'featured-slider' ); ?>

			<?php if ( is_active_sidebar( 'widgetized-homepage' ) && ! is_paged() ) : ?>

				<?php dynamic_sidebar( 'widgetized-homepage' ); ?>

			<?php else : ?>

				<?php get_template_part( 'loop' ); ?>

				<?php get_template_part( 'loop-nav' ); ?>

			<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
