<?php
/**
 * Template Name: Gallery List
 */

get_header(); ?>

	<div id="primary">
		<div id="content" role="main">

			<?php the_post(); ?>

			<?php get_template_part( 'content', 'page' ); ?>

			<?php
			$args = array(
				'posts_per_page' => -1,
				'tax_query' => array(
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => array( 'post-format-gallery' )
					)
				)
			);
			$galleries = new WP_Query( $args );
			if ( $galleries->have_posts() ) : ?>
				
				<section class="gallery-list">
				
					<?php while( $galleries->have_posts() ) : $galleries->the_post(); ?>

						<article id="<?php the_id(); ?>" <?php post_class(); ?>>
						
							<?php fearless_post_thumbnail( 'thumbnail', $link = true ); ?>
						
						</article>
			
					<?php endwhile; ?>
				
				</section>
				
			<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>