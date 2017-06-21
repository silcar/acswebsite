<?php

class fearless_branded_footer extends WP_Widget {

	function __construct() {
		parent::__construct( false, $name = __( 'Fearless Branded Footer Widget', 'fearless' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );
		echo $before_widget;

		if ( $logo_image_url = fearless_get_option( 'branded_footer_widget_logo_url' ) ) {
			$logo_image_attachment_id = fearless_get_attachment_id_from_url( $logo_image_url );
			$logo_image_data = wp_get_attachment_image_src( $logo_image_attachment_id, 'original' );
			$logo_image_width = $logo_image_data[1];
			$logo_image_height = $logo_image_data[2];

			printf( '<span class="branded-footer-widget-logo-wrap"><img src="%1$s" class="branded-footer-widget-logo" width="%2$s" height="%3$s" alt="%4$s" /></span>',
				$logo_image_url,
				$logo_image_width,
				$logo_image_height,
				esc_attr__( 'Footer logo', 'fearless' )
			);
		}

		fearless_social_icons( false, $new_window );

		if ( $content = fearless_get_option( 'branded_footer_widget_content' ) ) {
			echo wpautop( wptexturize( $content ) );
		}

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
		<p><em><?php _e( 'Configure the widget text and logo settings in the theme options panel.', 'fearless' ); ?></em></p>
		<?php
	}

}
add_action( 'widgets_init', create_function( '', 'return register_widget( "fearless_branded_footer" );' ) );
