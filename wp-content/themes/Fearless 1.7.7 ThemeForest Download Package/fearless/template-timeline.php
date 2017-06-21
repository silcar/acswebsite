<?php
/**
 * Template Name: Timeline
 */

get_header(); ?>

	<div id="primary">
		<div id="content" role="main">

			<?php the_post(); ?>

			<?php get_template_part( 'content', 'page' ); ?>
			
			<section class="timeline">
				<ul>
					<?php
					for( $year = date( 'Y' ); $year >= 2004; $year-- ) {
						$posts = get_posts( array(
							'year' => $year,
							'posts_per_page' => -1
						) );
						if ( ! empty( $posts ) ) :
						
							echo '<li><h2 class="year">' . $year . '</h2>';
							
							echo '<ul>';
							foreach( $posts as $postdata ) {
								echo '<li>';
								echo '<span class="date">' . date( get_option( 'date_format' ), strtotime( $postdata->post_date ) ) . '</span> - ';
								echo '<a href="' . get_permalink( $postdata->ID ) . '">' . $postdata->post_title . '</a>';
								echo '</li>';
							}
							echo '</ul>';
							
							echo '</li>';
						
						endif;
					}
					?>
				</ul>
			</section>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>