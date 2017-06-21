<?php

function fearless_ratings_meta_box_config( $meta_boxes ) {
	$criteria_fields = array();
	for( $i = 1; $i <= 6; $i++ ) {
		$criteria_fields[] = array(
			'name' => sprintf( __( 'Criteria %d Name', 'fearless' ), $i),
			'id' => 'fearless_review_criteria_' . $i . '_label',
			'type' => 'text',
			'class' => 'review-criteria-label'
		);
		$criteria_fields[] = array(
			'name' => sprintf( __( 'Value', 'fearless' ), $i ),
			'id' => 'fearless_review_criteria_' . $i . '_value',
			'type' => 'text',
			'class' => 'review-criteria-value'
		);
	}

	$meta_boxes[] = array(
		'id' => 'review',
		'title' => __( 'Review', 'fearless' ),
		'pages' => array( 'post' ),
		'fields' => array_merge(
			array(
				array(
					'name' => __( 'Review Box Enabled', 'fearless' ),
					'id' => 'fearless_review_enabled',
					'type' => 'checkbox',
					'std' => false,
					'id' => 'fearless_review_enabled',
					'class' => 'review-enabled'
				),
				array(
					'name' => __( 'Review Type', 'fearless' ),
					'id' => 'fearless_review_type',
					'type' => 'select',
					'options' => array(
						'points' => __( 'Points', 'fearless' ),
						'percent' => __( 'Percent', 'fearless' ),
						'stars' => __( 'Stars', 'fearless' )
					),
					'std' => 'stars',
					'class' => 'review-type-select'
				),
				array(
					'name' => __( 'Review Box Heading', 'fearless' ),
					'id' => 'fearless_review_heading',
					'type' => 'text',
				)
			),
			$criteria_fields,
			array(
				array(
					'name' => __( 'Review Final Score', 'fearless' ),
					'id' => 'fearless_review_final_score',
					'type' => 'text',
					'class' => 'review-final-score'
				),
				array(
					'name' => __( 'Review Short Summary', 'fearless' ),
					'id' => 'fearless_review_short_summary',
					'type' => 'text'
				),
				array(
					'name' => __( 'Review Long Summary', 'fearless' ),
					'id' => 'fearless_review_long_summary',
					'type' => 'textarea'
				)
			)
		)
	);
	return $meta_boxes;
}
add_filter( 'fearless_meta_boxes', 'fearless_ratings_meta_box_config' );


function fearless_star_rating( $percentage = null, $class = false ) {
	if ( null == $percentage )
		return;

	$percentage = floatval( $percentage );
	if ( $class ) $class = ' ' . $class;
	$output = '';

	$star_value = $percentage / 20;

	$output .= '<div class="fearless-star-rating-wrapper' . $class . '"><span class="fearless-star-rating-under">';
	for ( $i = 1; $i <= 5; $i++ ) {
		$output .= '<i class="fa fa-star"></i>';
	}
	if ( 'ltr' == get_bloginfo( 'text_direction' ) ) {
		$clipping_coordinates = '0, ' . $star_value . 'em, 1em, 0';
	} else {
		$clipping_coordinates = '0, 5em, 1em, ' . ( 5 - $star_value ) . 'em';
	}
	$output .= '</span><span class="fearless-star-rating-over" style="clip: rect(' . $clipping_coordinates . ');">';
	for ( $i = 1; $i <= 5; $i++ ) {
		$output .= '<i class="fa fa-star"></i>';
	}
	$output .= '</span></div>';

	return $output;
}

/**
 * Converts star and point values to percentages on post save
 */
function fearless_reviews_save_post( $post_id, $post ) {
	if ( isset( $_POST['fearless_review_type'] ) && 'percent' != $_POST['fearless_review_type'] ) :

		for( $i = 1; $i <= 6; $i++ ) {
			$key_id = 'fearless_review_criteria_' . $i . '_value';
			$current_rating_value = $_POST[ $key_id ];
			if ( ! empty( $current_rating_value ) ) {
				$new_rating_value = $current_rating_value * 20;
				$_POST[ $key_id ] = $new_rating_value;
			}
		}

		$current_rating_value = $_POST['fearless_review_final_score'];
		if ( ! empty( $current_rating_value ) ) {
			$new_rating_value = $current_rating_value * 20;
			$_POST['fearless_review_final_score'] = $new_rating_value;
		}

		remove_action( 'save_post', 'fearless_reviews_save_post', 10, 2 );

	endif;
}
add_action( 'save_post', 'fearless_reviews_save_post', 10, 2 );


/**
 * Converts percentages to star or point values on meta box field load
 */
function fearless_review_criteria_value_convert( $value ) {
	if ( isset( $_GET['post'] ) ) :
		$review_type = get_post_meta( $_GET['post'], 'fearless_review_type', true );
		if ( ! empty( $value ) && 'percent' != $review_type ) {
			$value = $value / 20;
		}
	endif;
	return $value;
}
add_filter( 'rwmb_fearless_review_criteria_1_value_meta', 'fearless_review_criteria_value_convert' );
add_filter( 'rwmb_fearless_review_criteria_2_value_meta', 'fearless_review_criteria_value_convert' );
add_filter( 'rwmb_fearless_review_criteria_3_value_meta', 'fearless_review_criteria_value_convert' );
add_filter( 'rwmb_fearless_review_criteria_4_value_meta', 'fearless_review_criteria_value_convert' );
add_filter( 'rwmb_fearless_review_criteria_5_value_meta', 'fearless_review_criteria_value_convert' );
add_filter( 'rwmb_fearless_review_criteria_6_value_meta', 'fearless_review_criteria_value_convert' );
add_filter( 'rwmb_fearless_review_final_score_meta', 'fearless_review_criteria_value_convert' );


/**
 * Formats a rating value according to the requested format
 */
function fearless_format_rating_value( $value = null, $format = null ) {
	if ( null == $value OR null == $format )
		return;

	switch( $format ) {
		case 'percent':
			$formatted = round( $value ) . '<span class="percent">%</span>';
			break;
		case 'points':
			$formatted = $value / 20;
			break;
		case 'stars':
			$formatted = fearless_star_rating( $value );
			break;
	}

	return $formatted;
}
