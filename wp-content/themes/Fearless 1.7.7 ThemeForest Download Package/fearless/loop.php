<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : ?>

		<?php the_post(); // Loads the post data. ?>

		<?php hybrid_get_content_template(); ?>

		<?php if ( is_singular( 'post' ) && fearless_get_option( 'authorbox_enabled' ) ) get_template_part( 'authorbox' ); ?>
		<?php if ( is_singular( 'post' ) && fearless_get_option( 'related_posts_enabled' ) ) get_template_part( 'related-posts' ); ?>

		<?php if ( is_singular() ) : ?>

			<?php comments_template(); ?>

		<?php endif; ?>

	<?php endwhile; ?>

<?php else : ?>

	<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

<?php endif; ?>
