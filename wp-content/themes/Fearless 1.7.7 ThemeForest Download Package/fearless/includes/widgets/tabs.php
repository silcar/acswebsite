<?php

class fearless_tabs extends WP_Widget {

	function __construct() {
		parent::__construct( false, $name = __( 'Fearless Tabbed Widget', 'fearless' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title1 = apply_filters( 'widget_title', $instance['title1'] );
		$title2 = apply_filters( 'widget_title', $instance['title2'] );
		$title3 = apply_filters( 'widget_title', $instance['title3'] );
		$widget1 = $instance['widget1'];
		$widget2 = $instance['widget2'];
		$widget3 = $instance['widget3'];
		$post_count = $instance['post_count'];

		echo $before_widget;

		?>
		<ul class="headings clearfix">
			<li class="tab1"><a class="widget-title active" href="#"><?php echo $title1; ?></a></li>
			<li class="tab2"><a class="widget-title" href="#"><?php echo $title2; ?></a></li>
			<li class="tab3"><a class="widget-title" href="#"><?php echo $title3; ?></a></li>
		</ul>
		<div class="widgets">
			<div class="tab1 <?php echo $widget1; ?>"><?php $this->run_widget( $widget1, $post_count ); ?></div>
			<div class="tab2 <?php echo $widget2; ?>"><?php $this->run_widget( $widget2, $post_count ); ?></div>
			<div class="tab3 <?php echo $widget3; ?>"><?php $this->run_widget( $widget3, $post_count ); ?></div>
		</div>
		<?php

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$clean['title1'] = strip_tags( $new_instance['title1'] );
		$clean['title2'] = strip_tags( $new_instance['title2'] );
		$clean['title3'] = strip_tags( $new_instance['title3'] );
		$clean['widget1'] = strip_tags( $new_instance['widget1'] );
		$clean['widget2'] = strip_tags( $new_instance['widget2'] );
		$clean['widget3'] = strip_tags( $new_instance['widget3'] );
		$clean['post_count'] = intval( $new_instance['post_count'] );
		return $clean;
	}

	function form( $instance ) {
		if ( ! isset( $instance['title1'] ) )
			$instance['title1'] = __( 'Popular', 'fearless' );
		if ( ! isset( $instance['title2'] ) )
			$instance['title2'] = __( 'Latest', 'fearless' );
		if ( ! isset( $instance['title3'] ) )
			$instance['title3'] = __( 'Top Rated', 'fearless' );
		if ( ! isset( $instance['widget1'] ) )
			$instance['widget1'] = 'popular';
		if ( ! isset( $instance['widget2'] ) )
			$instance['widget2'] = 'recent';
		if ( ! isset( $instance['widget3'] ) )
			$instance['widget3'] = 'top_rated';
		if ( ! isset( $instance['post_count'] ) )
			$instance['post_count'] = 5;

		$title1 = esc_attr( $instance['title1'] );
		$title2 = esc_attr( $instance['title2'] );
		$title3 = esc_attr( $instance['title3'] );
		$widget1 = esc_attr( $instance['widget1'] );
		$widget2 = esc_attr( $instance['widget2'] );
		$widget3 = esc_attr( $instance['widget3'] );
		$post_count = esc_attr( $instance['post_count'] );

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title1'); ?>"><?php _e( '1st Tab Title', 'fearless' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title1'); ?>" name="<?php echo $this->get_field_name( 'title1'); ?>" type="text" value="<?php echo $title1; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'widget1'); ?>"><?php _e( 'Widget:', 'fearless' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'widget1'); ?>" name="<?php echo $this->get_field_name( 'widget1'); ?>">
			<?php
			foreach( $this->get_widgets() as $widget_id => $widget_name ) {
				echo '<option value="' . $widget_id . '"' . selected( $widget1, $widget_id, false ) . '>' . $widget_name . '</option>';
			}
			?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title2'); ?>"><?php _e( '2nd Tab Title', 'fearless' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title2'); ?>" name="<?php echo $this->get_field_name( 'title2'); ?>" type="text" value="<?php echo $title2; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'widget2'); ?>"><?php _e( 'Widget:', 'fearless' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'widget2'); ?>" name="<?php echo $this->get_field_name( 'widget2'); ?>">
			<?php
			foreach( $this->get_widgets() as $widget_id => $widget_name ) {
				echo '<option value="' . $widget_id . '"' . selected( $widget2, $widget_id, false ) . '>' . $widget_name . '</option>';
			}
			?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title3'); ?>"><?php _e( '3rd Tab Title', 'fearless' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title3'); ?>" name="<?php echo $this->get_field_name( 'title3'); ?>" type="text" value="<?php echo $title3; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'widget3'); ?>"><?php _e( 'Widget:', 'fearless' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'widget3'); ?>" name="<?php echo $this->get_field_name( 'widget3'); ?>">
			<?php
			foreach( $this->get_widgets() as $widget_id => $widget_name ) {
				echo '<option value="' . $widget_id . '"' . selected( $widget3, $widget_id, false ) . '>' . $widget_name . '</option>';
			}
			?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_count'); ?>"><?php _e( 'Number of posts to show:', 'fearless' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'post_count'); ?>" name="<?php echo $this->get_field_name( 'post_count'); ?>" type="text" value="<?php echo $post_count; ?>" size="3" />
		</p>
		<?php
	}

	function get_widgets() {
		return array(
			'facebook' => __( 'Facebook Fans', 'fearless' ),
			'featured' => __( 'Featured Posts', 'fearless' ),
			'popular' => __( 'Popular Posts', 'fearless' ),
			'recent' => __( 'Recent Posts', 'fearless' ),
			'galleries' => __( 'Recent Galleries', 'fearless' ),
			'comments' => __( 'Recent Comments', 'fearless' ),
			'social' => __( 'Social Icons', 'fearless' ),
			'tag-cloud' => __( 'Tag Cloud', 'fearless' ),
			'top_rated' => __( 'Top Rated Posts', 'fearless' ),
		);
	}

	function run_widget( $widget_id = null, $post_count = null ) {
		switch ( $widget_id ) {
			case 'facebook':
				fearless_widget_facebook_likebox();
				break;
			case 'featured':
				fearless_widget_featured_posts( array( 'count' => $post_count ) );
				break;
			case 'popular':
				fearless_widget_popular_posts( array( 'count' => $post_count ) );
				break;
			case 'recent':
				fearless_widget_recent_posts( array( 'count' => $post_count ) );
				break;
			case 'galleries':
				fearless_widget_recent_galleries( array( 'count' => $post_count ) );
				break;
			case 'comments':
				fearless_widget_recent_comments( array( 'count' => $post_count ) );
				break;
			case 'social':
				fearless_widget_social_icons();
				break;
			case 'tag-cloud':
				wp_tag_cloud();
				break;
			case 'top_rated':
				fearless_widget_top_rated_posts( array( 'count' => $post_count ) );
				break;
		}
	}

}
add_action( 'widgets_init', create_function( '', 'return register_widget( "fearless_tabs" );' ) );