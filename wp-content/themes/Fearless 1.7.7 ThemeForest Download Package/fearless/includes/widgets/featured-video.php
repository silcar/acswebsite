<?php

class fearless_featured_video extends WP_Widget {

	function __construct() {
		parent::__construct( false, $name = __( 'Fearless Featured Video Widget', 'fearless' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$embed_code = $instance['embed_code'];

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;

		if ( $embed_code )
			echo '<div class="fitvids">' . $embed_code . '</div>';

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$clean['title'] = strip_tags( $new_instance['title'] );
		$clean['embed_code'] = ( $new_instance['embed_code'] );
		return $clean;
	}

	function form( $instance ) {
		if ( ! isset( $instance['title'] ) )
			$instance['title'] = null;
		if ( ! isset( $instance['embed_code'] ) )
			$instance['embed_code'] = null;

		$title = esc_attr( $instance['title'] );
		$embed_code = $instance['embed_code'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title'); ?>"><?php _e( 'Title', 'fearless' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title'); ?>" name="<?php echo $this->get_field_name( 'title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'embed_code'); ?>"><?php _e( 'Embed code:', 'fearless' ); ?></label>
			<textarea class="widefat" rows="5" id="<?php echo $this->get_field_id( 'embed_code'); ?>" name="<?php echo $this->get_field_name( 'embed_code'); ?>"><?php echo esc_textarea( $embed_code ); ?></textarea>
		</p>
		<?php
	}

}
add_action( 'widgets_init', create_function( '', 'return register_widget( "fearless_featured_video" );' ) );
