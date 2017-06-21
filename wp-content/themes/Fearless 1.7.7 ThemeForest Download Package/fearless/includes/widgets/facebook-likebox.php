<?php

function fearless_widget_facebook_likebox() {
	$url = fearless_get_option( 'social_profile_facebook' );
	if ( $url )
		echo '<div class="fb-like-box" data-href="' . esc_attr( $url ) . '" data-width="300" data-show-faces="true" data-stream="true" data-show-border="false" data-header="false"></div>';
}

class fearless_facebook_likebox extends WP_Widget {

	function __construct() {
		parent::__construct( false, $name = __( 'Fearless Facebook Fans', 'fearless' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		fearless_widget_facebook_likebox();
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
		<p><em><?php _e( 'Set your Facebook page URL in the theme options page.', 'fearless' ); ?></em></p>
		<?php
	}

}
add_action( 'widgets_init', create_function( '', 'return register_widget( "fearless_facebook_likebox" );' ) );
