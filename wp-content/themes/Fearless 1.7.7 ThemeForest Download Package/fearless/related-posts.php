<?php if ( is_singular( 'post' ) ) : ?>
	<aside class="related-posts">

		<?php
		$post_id = get_the_ID();
		$related = '';
		$count = 0;
		$cats = get_the_category( $post_id );
		$tags = wp_get_post_tags( $post_id );

		if ( $tags ) :

			$tag_ids = array();
			foreach( $tags as $tag ) {
				$tag_ids[] = $tag->term_id;
			}

			$args = array(
				'tag__in' => $tag_ids,
				'post__not_in' => array( $post_id ),
				'showposts' => 4,
				'ignore_sticky_posts' => 1
			);
			$tags_query = new WP_Query( $args );
			if ( $tags_query->have_posts() ) : while( $tags_query->have_posts() ) : $tags_query->the_post();

				$related .= '<article class="related-post related-post-' . ( $count + 1 ) . ' related-by-tag">';
				$related .= '<h3><a href="' . get_permalink() . '">';

				if ( has_post_thumbnail() ) {
					$related .= get_the_post_thumbnail( get_the_ID(), 'thumb-232' );
				} else {
					$related .= '<img src="' . get_template_directory_uri() . '/images/missing-image-232x150.png" alt="' . esc_attr__( 'Missing image', 'fearless' ) . '" />';
				}

				$related .= sprintf( __( '%1$s<span class="arrow">&rarr;</span>', 'fearless' ), get_the_title() ) . '</a></h3>';
				$related .= '</article>';

				$count++;

			endwhile; endif;

		endif;

		if ( $count < 4 && $cats ) :

			$cat_ids = array();
			foreach( $cats as $cat ) {
				$cat_ids[] = $cat->term_id;
			}

			$args = array(
				'category__in' => $cat_ids,
				'post__not_in' => array( $post_id ),
				'showposts' => ( 4 - $count ),
				'ignore_sticky_posts' => 1
			);
			$cats_query = new WP_Query( $args );
			if ( $cats_query->have_posts() ) : while( $cats_query->have_posts() ) : $cats_query->the_post();

				$related .= '<article class="related-post related-post-' . ( $count + 1 ) . ' related-by-category">';
				$related .= '<h3><a href="' . get_permalink() . '">';

				if ( has_post_thumbnail() ) {
					$related .= get_the_post_thumbnail( get_the_ID(), 'thumb-232' );
				} else {
					$related .= '<img src="' . get_template_directory_uri() . '/images/missing-image-232x150.png" alt="' . esc_attr__( 'Missing image', 'fearless' ) . '" />';
				}

				$related .= sprintf( __( '%1$s<span class="arrow">&rarr;</span>', 'fearless' ), get_the_title() ) . '</a></h3>';
				$related .= '</article>';

				$count++;

			endwhile; endif;

		endif;

		if ( $related ) {
			echo '<h2 class="related-posts-header">' . __( 'Related Posts', 'fearless' ) . '</h2>';
			echo $related;
		}

		wp_reset_postdata();
		?>

	</aside>
<?php endif; ?>
