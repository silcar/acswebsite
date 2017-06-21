<?php

class fearless_layout_module_e extends WP_Widget {

	function __construct() {
		parent::__construct( false, $name = __( 'Fearless Layout Module E', 'fearless' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		if ( $instance['category_id'] )
			$category_data = get_category( (int) $instance['category_id'] );

		if ( ! $title && isset( $category_data ) )
			$title = $category_data->name;

		if ( isset( $category_data ) )
			$title = '<a href="' . get_category_link( $category_data->term_id ) . '">' . $title . ' <span>&raquo;</span></a>';

		if ( $category_data ) {
			$category_accent_color = fearless_get_category_meta_hierarchical( $instance['category_id'], 'fearless_accent_color' );
			$before_title = str_replace( '<h1', '<h1 style="border-color: ' . $category_accent_color . ';"', $before_title );
			$before_title = str_replace( '<span>', '<span style="background: ' . $category_accent_color . ';">', $before_title );
		}

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		$query_args = array(
			'posts_per_page' => 10,
			'ignore_sticky_posts' => 1
		);
		if ( $instance['category_id'] )
			$query_args['cat'] = $instance['category_id'];
		$query = new WP_Query( $query_args );
		if ( $query->have_posts() ) :

			echo '<div class="carousel-slider flexslider boxed"><ul class="slides">';

			while( $query->have_posts() ) : $query->the_post();

				echo '<li>';
				echo '<a href="' . get_permalink() . '">';
				fearless_post_thumbnail( 'thumbnail', $link = false );

				echo '<div class="slide-overlay">';
				echo '<h3 class="slide-title">' . get_the_title() . '</h3>';
				echo '</div>';

				echo '</a>';
				echo '</li>';

			endwhile;

			echo '</ul>';

			echo '</div>';

			echo '<div class="carousel-direction-nav"><i class="prev fa fa-angle-left"></i><i class="next fa fa-angle-right"></i></div>';

			wp_reset_postdata();

		endif;

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$clean['title'] = strip_tags( $new_instance['title'] );
		$clean['category_id'] = strip_tags( $new_instance['category_id'] );
		return $clean;
	}

	function form( $instance ) {
		if ( ! isset( $instance['title'] ) )
			$instance['title'] = null;
		if ( ! isset( $instance['category_id'] ) )
			$instance['category_id'] = null;

		$title = esc_attr( $instance['title'] );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title'); ?>"><?php _e( 'Title', 'fearless' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title'); ?>" name="<?php echo $this->get_field_name( 'title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'category_id'); ?>"><?php _e( 'Category', 'fearless' ); ?></label>
			<?php wp_dropdown_categories( array(
				'name' => $this->get_field_name( 'category_id' ),
				'id' => $this->get_field_id( 'category_id' ),
				'show_option_all' => __( 'All Categories', 'fearless' ),
				'selected' => $instance['category_id'],
				'hide_empty' => 0,
				'hierarchical' => 1
			) ); ?>
		</p>
		<?php
	}

}
add_action( 'widgets_init', create_function( '', 'return register_widget( "fearless_layout_module_e" );' ) );
