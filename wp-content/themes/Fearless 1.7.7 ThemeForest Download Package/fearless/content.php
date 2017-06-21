<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

	<?php if ( is_singular( get_post_type() ) ) : ?>

		<?php
		$format = get_post_format();
		get_template_part( 'post-header', $format );
		?>

		<header class="entry-header">
			<?php if (
					fearless_get_option( 'singular_featured_image_enabled' )
					&& 'audio' != $format
					&& 'gallery' != $format
					&& 'video' != $format
				) {
					fearless_post_thumbnail();
				}
			?>

			<h1 class="entry-title"><?php single_post_title(); ?></h1>

			<?php
			echo apply_atomic_shortcode(
				'entry_byline',
				'<div class="entry-byline">' . __( 'Posted by [entry-author] on [entry-published] in [entry-terms taxonomy="category"] | [entry-views after=" Views"] [entry-comments-link before=" | "]', 'fearless' ) . '</div>'
			);
			?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php if ( is_singular( 'post' ) ) get_template_part( 'review-box' ); ?>
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<p class="page-links">' . '<span class="before">' . __( 'Pages:', 'fearless' ) . '</span>', 'after' => '</p>' ) ); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( '[entry-terms before="Posted in " taxonomy="category"] [entry-terms before="| Tagged "]', 'fearless' ) . '</div>' ); ?>
		</footer><!-- .entry-footer -->

	<?php else : ?>

		<?php global $fearless_blogroll_layout; ?>

		<?php fearless_post_thumbnail( $fearless_blogroll_layout['thumbnail_size'] ); ?>

		<header class="entry-header">
			<?php the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '">', '</a></h2>' ); ?>
			<?php echo apply_atomic_shortcode( 'entry_byline', '<div class="entry-byline">' . __( '[entry-author] / [entry-published]', 'fearless' ) . '</div>' ); ?>
		</header><!-- .entry-header -->

		<?php if ( $fearless_blogroll_layout['excerpt_length'] ) : ?>
			<div class="entry-summary">
				<?php echo fearless_get_the_excerpt( $fearless_blogroll_layout['excerpt_length'] ); ?>
				<?php wp_link_pages( array( 'before' => '<p class="page-links">' . '<span class="before">' . __( 'Pages:', 'fearless' ) . '</span>', 'after' => '</p>' ) ); ?>
			</div><!-- .entry-summary -->
		<?php endif; ?>

		<?php if ( '1col-thumb' != $fearless_blogroll_layout['style'] ) : ?>
			<p class="more-link-wrapper"><a href="<?php the_permalink(); ?>" class="read-more button"><?php _e( 'Read More &raquo;', 'fearless' ); ?></a></p>
		<?php endif; ?>

	<?php endif; ?>

</article><!-- .hentry -->
