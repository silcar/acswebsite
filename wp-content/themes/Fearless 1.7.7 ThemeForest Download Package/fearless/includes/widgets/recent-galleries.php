<?php

function fearless_widget_recent_galleries( $instance = array() ) {
	$args = array(
		'posts_per_page' => 9,
		'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array( 'post-format-gallery' )
			)
		),
		'ignore_sticky_posts' => 1
	);
	$posts = new WP_Query( $args );
	if ( $posts->have_posts() ) :
		echo '<ul class="gallery-list">';
		while( $posts->have_posts() ) : $posts->the_post();

			echo '<li>';
			fearless_post_thumbnail( 'thumb-83', $link = true );
			echo '</li>';

		endwhile;
		echo '</ul>';
		wp_reset_postdata();
	endif;
}

class fearless_recent_galleries extends WP_Widget {

	function __construct() {
		parent::__construct( false, $name = __( 'Fearless Recent Galleries', 'fearless' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		fearless_widget_recent_galleries( $instance );

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$clean['title'] = strip_tags( $new_instance['title'] );
		$clean['count'] = intval( $new_instance['count'] );
		return $clean;
	}

	function form( $instance ) {
		if ( ! isset( $instance['title'] ) )
			$instance['title'] = null;
		if ( ! isset( $instance['count'] ) )
			$instance['count'] = 5;

		$title = esc_attr( $instance['title'] );
		$count = $instance['count'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title'); ?>"><?php _e( 'Title', 'fearless' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title'); ?>" name="<?php echo $this->get_field_name( 'title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count'); ?>"><?php _e( 'Number of galleries to show:', 'fearless' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'count'); ?>" name="<?php echo $this->get_field_name( 'count'); ?>" type="text" value="<?php echo $count; ?>" size="3" />
		</p>
		<?php
	}

}
add_action( 'widgets_init', create_function( '', 'return register_widget( "fearless_recent_galleries" );' ) );
