<?php

function fearless_widget_recent_posts( $instance = array() ) {
	$args = array(
		'posts_per_page' => $instance['count'],
		'ignore_sticky_posts' => 1
	);
	$posts = new WP_Query( $args );
	if ( $posts->have_posts() ) :
		echo '<ul class="teaser-list">';
		while( $posts->have_posts() ) : $posts->the_post();

			fearless_post_teaser( array( 'wrap' => 'li', 'thumbnail' => 'thumb-55' ) );

		endwhile;
		echo '</ul>';
		wp_reset_postdata();
	endif;
}

class fearless_recent_posts extends WP_Widget {

	function __construct() {
		parent::__construct( false, $name = __( 'Fearless Recent Posts with Thumbnails', 'fearless' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		fearless_widget_recent_posts( $instance );

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
			<label for="<?php echo $this->get_field_id( 'count'); ?>"><?php _e( 'Number of posts to show:', 'fearless' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'count'); ?>" name="<?php echo $this->get_field_name( 'count'); ?>" type="text" value="<?php echo $count; ?>" size="3" />
		</p>
		<?php
	}

}
add_action( 'widgets_init', create_function( '', 'return register_widget( "fearless_recent_posts" );' ) );
