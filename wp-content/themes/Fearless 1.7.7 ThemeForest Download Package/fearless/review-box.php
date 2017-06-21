<?php

if ( get_post_meta( get_the_ID(), 'fearless_review_enabled', true ) ) :
	$post_id = get_the_ID();
	$fearless_review = array( 'type' => get_post_meta( $post_id, 'fearless_review_type', true ) );
	for( $i = 1; $i <= 6; $i++ ) {
		$fearless_review[ 'criteria_' . $i . '_label' ] = get_post_meta( $post_id, 'fearless_review_criteria_' . $i . '_label', true );
		$fearless_review[ 'criteria_' . $i . '_value' ] = get_post_meta( $post_id, 'fearless_review_criteria_' . $i . '_value', true );
	}
	$fearless_review['heading'] = get_post_meta( $post_id, 'fearless_review_heading', true );
	$fearless_review['final_score'] = get_post_meta( $post_id, 'fearless_review_final_score', true );
	$fearless_review['short_summary'] = get_post_meta( $post_id, 'fearless_review_short_summary', true );
	$fearless_review['long_summary'] = get_post_meta( $post_id, 'fearless_review_long_summary', true );

	?>
	<aside class="review-box <?php echo $fearless_review['type']; ?>" itemscope itemtype="http://data-vocabulary.org/Review">
		<span class="microdata-hidden" itemprop="itemreviewed"><?php the_title(); ?></span>
		<span class="microdata-hidden" itemprop="reviewer"><?php the_author(); ?></span>
		<span class="microdata-hidden" itemprop="dtreviewd" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( get_option( 'date_format' ) ); ?></span>
		<span class="microdata-hidden" itemprop="rating"><?php echo $fearless_review['final_score'] / 20; ?></span>
	
		<h3 class="heading"><?php echo $fearless_review['heading']; ?></h3>
		<div class="ratings">
			<?php
			for( $i = 1; $i <= 6; $i++ ) {
				if ( !empty( $fearless_review[ 'criteria_' . $i . '_label' ] ) && !empty( $fearless_review[ 'criteria_' . $i . '_value' ] ) ) {
					$current_label = $fearless_review[ 'criteria_' . $i . '_label' ];
					$current_value = $fearless_review[ 'criteria_' . $i . '_value' ];
					echo '<div class="row">';
						echo '<div class="label">' . $current_label . ( 'percent' == $fearless_review['type'] ? ' - ' . $fearless_review[ 'criteria_' . $i . '_value' ] . '%' : '' ) . '</div>';
						echo '<div class="value">';
						if ( 'percent' == $fearless_review['type'] ) {
							echo '<span class="rating-percent-value" style="width: ' . $fearless_review[ 'criteria_' . $i . '_value' ] . '%;"></span>';
						} else {
							echo fearless_format_rating_value( $current_value, $fearless_review['type'] );
						}
						echo '</div>';
					echo '</div>';
				}
			}
			?>
		</div>
		<div class="review">
			<div class="review-short-summary">
				<?php if ( !empty( $fearless_review['final_score'] ) ) echo '<div class="final-score">'. fearless_format_rating_value( $fearless_review['final_score'], $fearless_review['type'] ) . '</div>'; ?>
				<?php if ( 'stars' == $fearless_review['type'] ) echo '<span class="stars-final-score-decimal">' . $fearless_review['final_score'] / 20 . '</span>'; ?>
				<?php if ( !empty( $fearless_review['short_summary'] ) ) echo '<h3 class="short-summary" itemprop="summary">' . $fearless_review['short_summary'] . '</h3>'; ?>
			</div>
			<div class="review-long-summary" itemprop="description">
				<?php if ( !empty( $fearless_review['long_summary'] ) ) echo '<p><strong>' . __( 'Summary:', 'fearless' ) . '</strong> ' . $fearless_review['long_summary'] . '</p>'; ?>
			</div>
		</div>
	</aside>
	<?php

endif;

