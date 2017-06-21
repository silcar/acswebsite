<?php

class fearless_layout_module_c extends WP_Widget {

	function __construct() {
		parent::__construct( false, $name = __( 'Fearless Layout Module C', 'fearless' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title1 = apply_filters( 'widget_title', $instance['title1'] );
		$title2 = apply_filters( 'widget_title', $instance['title2'] );
		
		if ( $instance['category1_id'] )
			$category1_data = get_category( (int) $instance['category1_id'] );
		if ( $instance['category2_id'] )
			$category2_data = get_category( (int) $instance['category2_id'] );
		
		if ( ! $title1 && isset( $category1_data ) )
			$title1 = $category1_data->name;
		if ( ! $title2 && isset( $category2_data ) )
			$title2 = $category2_data->name;
		
		if ( isset( $category1_data ) )
			$title1 = '<a href="' . get_category_link( $category1_data->term_id ) . '">' . $title1 . ' <span>&raquo;</span></a>';
		if ( isset( $category2_data ) )
			$title2 = '<a href="' . get_category_link( $category2_data->term_id ) . '">' . $title2 . ' <span>&raquo;</span></a>';

		if ( $category1_data ) {
			$category1_accent_color = fearless_get_category_meta_hierarchical( $instance['category1_id'], 'fearless_accent_color' );
			$before_title = str_replace( '<h1', '<h1 style="border-color: ' . $category1_accent_color . ';"', $before_title );
			$before_title = str_replace( '<span>', '<span style="background: ' . $category1_accent_color . ';">', $before_title );
		}

		$css_class = 'featured';
		$thumbnail_size = 'thumb-320';
		$excerpt_length = 25;

		echo $before_widget;
		echo '<div class="column">';
		if ( $title1 )
			echo $before_title . $title1 . $after_title;

		$query1_args = array(
			'posts_per_page' => 1,
			'ignore_sticky_posts' => 1
		);
		if ( $instance['category1_id'] )
			$query1_args['cat'] = $instance['category1_id'];
		$query1 = new WP_Query( $query1_args );
		if ( $query1->have_posts() ) :
			
			echo '<div class="boxed">';

			while( $query1->have_posts() ) : $query1->the_post();

				fearless_post_teaser( array( 'class' => $css_class, 'thumbnail' => $thumbnail_size, 'excerpt_length' => $excerpt_length ) );

			endwhile;
			wp_reset_postdata();
			
			echo '</div><!-- .boxed -->';

		endif;
		echo '</div>';

		echo '<div class="column last">';

		$before_title = $args['before_title'];
		if ( $category2_data ) {
			$category2_accent_color = fearless_get_category_meta_hierarchical( $instance['category2_id'], 'fearless_accent_color' );
			$before_title = str_replace( '<h1', '<h1 style="border-color: ' . $category2_accent_color . ';"', $before_title );
			$before_title = str_replace( '<span>', '<span style="background: ' . $category2_accent_color . ';">', $before_title );
		}

		if ( $title2 )
			echo $before_title . $title2 . $after_title;

		$query2_args = array(
			'posts_per_page' => 1,
			'ignore_sticky_posts' => 1
		);
		if ( $instance['category2_id'] )
			$query2_args['cat'] = $instance['category2_id'];
		$query2 = new WP_Query( $query2_args );
		if ( $query2->have_posts() ) :
			
			echo '<div class="boxed">';

			while( $query2->have_posts() ) : $query2->the_post();

				fearless_post_teaser( array( 'class' => $css_class, 'thumbnail' => $thumbnail_size, 'excerpt_length' => $excerpt_length ) );

			endwhile;
			wp_reset_postdata();
			
			echo '</div><!-- .boxed -->';

		endif;
		echo '</div>';

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$clean['title1'] = strip_tags( $new_instance['title1'] );
		$clean['title2'] = strip_tags( $new_instance['title2'] );
		$clean['category1_id'] = strip_tags( $new_instance['category1_id'] );
		$clean['category2_id'] = strip_tags( $new_instance['category2_id'] );
		return $clean;
	}

	function form( $instance ) {
		if ( ! isset( $instance['title1'] ) )
			$instance['title1'] = null;
		if ( ! isset( $instance['title2'] ) )
			$instance['title2'] = null;
		if ( ! isset( $instance['category1_id'] ) )
			$instance['category1_id'] = null;
		if ( ! isset( $instance['category2_id'] ) )
			$instance['category2_id'] = null;

		$title1 = esc_attr( $instance['title1'] );
		$title2 = esc_attr( $instance['title2'] );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title1'); ?>"><?php _e( 'Title 1', 'fearless' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title1'); ?>" name="<?php echo $this->get_field_name( 'title1'); ?>" type="text" value="<?php echo $title1; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'category1_id'); ?>"><?php _e( 'Category 1', 'fearless' ); ?></label>
			<?php wp_dropdown_categories( array(
				'name' => $this->get_field_name( 'category1_id' ),
				'id' => $this->get_field_id( 'category1_id' ),
				'show_option_all' => __( 'All Categories', 'fearless' ),
				'selected' => $instance['category1_id'],
				'hide_empty' => 0,
				'hierarchical' => 1
			) ); ?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title2'); ?>"><?php _e( 'Title 2', 'fearless' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title2'); ?>" name="<?php echo $this->get_field_name( 'title2'); ?>" type="text" value="<?php echo $title2; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'category2_id'); ?>"><?php _e( 'Category 2', 'fearless' ); ?></label>
			<?php wp_dropdown_categories( array(
				'name' => $this->get_field_name( 'category2_id' ),
				'id' => $this->get_field_id( 'category2_id' ),
				'show_option_all' => __( 'All Categories', 'fearless' ),
				'selected' => $instance['category2_id'],
				'hide_empty' => 0,
				'hierarchical' => 1
			) ); ?>
		</p>
		<?php
	}

}
add_action( 'widgets_init', create_function( '', 'return register_widget( "fearless_layout_module_c" );' ) );
