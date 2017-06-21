<?php

class fearless_layout_module_blogroll extends WP_Widget {

	function __construct() {
		parent::__construct( false, $name = __( 'Fearless Layout Module Blogroll', 'fearless' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;

		if ( have_posts() ) : while( have_posts() ) : the_post();
			hybrid_get_content_template();
		endwhile; wp_reset_postdata(); endif;

		get_template_part( 'loop-nav' );

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$clean['title'] = strip_tags( $new_instance['title'] );
		return $clean;
	}

	function form( $instance ) {
		if ( ! isset( $instance['title'] ) )
			$instance['title'] = null;

		$title = esc_attr( $instance['title'] );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title'); ?>"><?php _e( 'Title', 'fearless' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title'); ?>" name="<?php echo $this->get_field_name( 'title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php
	}

}
add_action( 'widgets_init', create_function( '', 'return register_widget( "fearless_layout_module_blogroll" );' ) );
