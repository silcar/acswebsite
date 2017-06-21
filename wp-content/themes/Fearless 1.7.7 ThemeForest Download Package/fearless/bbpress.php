<?php get_header(); ?>

	<div id="primary">
		<div id="content" class="hfeed" role="main">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : ?>

					<?php the_post(); // Loads the post data. ?>
					
					<article class="<?php hybrid_entry_class( 'bbpress' ); ?>">

						<header class="entry-header">
							<h1 class="entry-title"><?php single_post_title(); ?></h1>
						</header><!-- .entry-header -->

						<div class="entry-content">
							<?php the_content(); ?>
							<?php wp_link_pages( array( 'before' => '<p class="page-links">' . '<span class="before">' . __( 'Pages:', 'fearless' ) . '</span>', 'after' => '</p>' ) ); ?>
						</div><!-- .entry-content -->
						
					</article>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

			<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>