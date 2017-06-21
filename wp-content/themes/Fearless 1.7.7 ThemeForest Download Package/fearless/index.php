<?php get_header(); ?>

	<div id="primary">
		<div id="content" class="hfeed" role="main">

			<?php get_template_part( 'loop-meta' ); ?>

			<?php get_template_part( 'loop' ); ?>

			<?php get_template_part( 'loop-nav' ); ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>