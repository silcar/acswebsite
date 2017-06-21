<?php

function fearless_widget_social_icons( $new_window ) {

	fearless_social_icons( $link_background_color_class = true, $new_window );

}

class fearless_social_icons extends WP_Widget {

	function __construct() {
		parent::__construct( false, $name = __( 'Fearless Social Icons', 'fearless' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		echo $before_widget;

		fearless_widget_social_icons( $new_window );

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		return array( 'new_window' => (bool) $new_instance['new_window'] );
	}

	function form( $instance ) {
		$new_window = isset( $instance['new_window'] ) ? $instance['new_window'] : false;
		?>
		<p>
			<label><input type="checkbox" name="<?php echo $this->get_field_name( 'new_window' ); ?>" <?php checked( '1', $new_window ); ?> value="1" />
			<?php _e( 'Open links in a new window', 'fearless' ); ?></label>
		</p>
		<p><em><?php _e( 'Set your social networks in the theme options page.', 'fearless' ); ?></em></p>
		<?php
	}

}
add_action( 'widgets_init', create_function( '', 'return register_widget( "fearless_social_icons" );' ) );
