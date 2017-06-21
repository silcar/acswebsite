<?php

class fearless_responsive_image_ad extends WP_Widget {

	function __construct() {
		parent::__construct( false, $name = __( 'Fearless Responsive Image Ad', 'fearless' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$image_url = $instance['image_url'];
		$link_url = $instance['link_url'];
		$url_target_new_window = $instance['url_target_new_window'];
	
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		if ( $image_url && $link_url ) :
			if ( $url_target_new_window ) {
				$target = ' target="_blank"';
			} else {
				$target = null;
			}
			echo '<a href="' . $link_url . '"' . $target . '><img src="' . $image_url . '" alt="advertisement" /></a>';
		endif;

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$clean['title'] = strip_tags( $new_instance['title'] );
		$clean['image_url'] = strip_tags( $new_instance['image_url'] );
		$clean['link_url'] = strip_tags( $new_instance['link_url'] );
		$clean['url_target_new_window'] = strip_tags( $new_instance['url_target_new_window'] );
		return $clean;
	}

	function form( $instance ) {
		if ( ! isset( $instance['title'] ) )
			$instance['title'] = null;
		if ( ! isset( $instance['image_url'] ) )
			$instance['image_url'] = null;
		if ( ! isset( $instance['link_url'] ) )
			$instance['link_url'] = null;
		if ( ! isset( $instance['url_target_new_window'] ) )
			$instance['url_target_new_window'] = 0;

		$title = esc_attr( $instance['title'] );
		$image_url = esc_attr( $instance['image_url'] );
		$link_url = esc_attr( $instance['link_url'] );
		$url_target_new_window = esc_attr( $instance['url_target_new_window'] );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title'); ?>"><?php _e( 'Title', 'fearless' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title'); ?>" name="<?php echo $this->get_field_name( 'title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'image_url'); ?>"><?php _e( 'Image URL', 'fearless' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'image_url'); ?>" name="<?php echo $this->get_field_name( 'image_url'); ?>" type="text" value="<?php echo $image_url; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_url'); ?>"><?php _e( 'Link URL', 'fearless' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link_url'); ?>" name="<?php echo $this->get_field_name( 'link_url'); ?>" type="text" value="<?php echo $link_url; ?>" />
		</p>
		<p>
			<input id="<?php echo $this->get_field_id( 'url_target_new_window'); ?>" name="<?php echo $this->get_field_name( 'url_target_new_window'); ?>" type="checkbox" value="1" <?php checked( $url_target_new_window, 1 ); ?> />
			<label for="<?php echo $this->get_field_id( 'url_target_new_window'); ?>"><?php _e( 'Open links in a new window or tab', 'fearless' ); ?></label>
		</p>
		<?php
	}
	
}
add_action( 'widgets_init', create_function( '', 'return register_widget( "fearless_responsive_image_ad" );' ) );
