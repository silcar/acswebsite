<?php
/**
 * Template Name: Top Reviews
 */

get_header(); ?>

	<div id="primary">
		<div id="content" role="main">

			<?php the_post(); ?>

			<?php get_template_part( 'content', 'page' ); ?>

			<?php
			$args = array(
				'posts_per_page' => 10,
				'meta_query' => array(
					array(
						'key' => 'fearless_review_enabled',
						'value' => '1'
					)
				),
				'meta_key' => 'fearless_review_final_score',
				'orderby' => 'meta_value_num',
				'order' => 'DESC'
			);
			$reviews = new WP_Query( $args );
			if ( $reviews->have_posts() ) : ?>
				
				<section class="top-reviews">
				
				<?php
				$counter = 1;
				while( $reviews->have_posts() ) : $reviews->the_post();
				?>

					<article id="<?php the_id(); ?>" <?php post_class(); ?>>
						
						<div class="review-column-1">
							<h2><?php echo $counter; ?></h2>
						</div>
						
						<div class="review-column-2">
							<?php fearless_post_thumbnail( 'thumb-83', $link = true ); ?>
						</div>
						
						<div class="review-column-3">
							<header class="entry-header">
								<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
							</header>
							
							<div class="entry-summary">
								<p><?php echo fearless_star_rating( get_post_meta( get_the_ID(), 'fearless_review_final_score', true ) ); ?></p>
							</div>
							
							<?php echo apply_atomic_shortcode( 'entry_byline', '<footer class="entry-byline">' . __( 'Posted by [entry-author] on [entry-published]', 'fearless' ) . '</footer>' ); ?>
							
						</div>
						
					</article>
					
					<?php $counter++; ?>
			
				<?php endwhile; ?>
				
				</section>
				
			<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>