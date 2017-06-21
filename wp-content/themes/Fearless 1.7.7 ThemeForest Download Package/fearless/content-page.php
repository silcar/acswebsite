<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

	<?php if ( is_singular( get_post_type() ) ) : ?>

		<header class="entry-header">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="featured-image-wrap">
					<?php fearless_post_thumbnail(); ?>
				</div>
			<?php endif; ?>
			<h1 class="entry-title"><?php single_post_title(); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<p class="page-links">' . '<span class="before">' . __( 'Pages:', 'fearless' ) . '</span>', 'after' => '</p>' ) ); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">[entry-edit-link]</div>' ); ?>
		</footer><!-- .entry-footer -->

	<?php else : ?>

		<header class="entry-header">
			<?php the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '">', '</a></h2>' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php the_excerpt(); ?>
			<?php wp_link_pages( array( 'before' => '<p class="page-links">' . '<span class="before">' . __( 'Pages:', 'fearless' ) . '</span>', 'after' => '</p>' ) ); ?>
		</div><!-- .entry-summary -->

	<?php endif; ?>

</article><!-- .hentry -->