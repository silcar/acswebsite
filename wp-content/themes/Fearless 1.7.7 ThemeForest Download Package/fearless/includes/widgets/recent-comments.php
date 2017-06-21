<?php

function fearless_widget_recent_comments( $instance = array() ) {
	
	$comments = get_comments( array(
		'number' => $instance['count'],
		'status' => 'approve',
		'post_status' => 'publish'
	) );
	
	if ( ! empty( $comments ) ) :
		echo '<ul class="teaser-list fearless-recent-comments">';
		foreach( $comments as $comment ) {
			echo '<li>';
			
			echo '<div class="post-thumbnail-wrap">';
			echo get_avatar( $comment->comment_author_email, '50' );
			echo '</div>';
			
			echo '<span class="comment-author">' . $comment->comment_author . '</span>';
			_e( ' on ', 'fearless' );
			echo '<a href="' . get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment->comment_ID . '">' . wp_trim_words( $comment->post_title, 7, '&hellip;' ) . '</a>';
			echo '<span class="comment-text">' . wp_trim_words( $comment->comment_content, 5, '&hellip;' ) . '</span>';
			
			echo '</li>';
		}
		echo '</ul>';
	endif;
}

class fearless_recent_comments extends WP_Widget {

	function __construct() {
		parent::__construct( false, $name = __( 'Fearless Recent Comments with Avatar', 'fearless' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		fearless_widget_recent_comments( $instance );

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
add_action( 'widgets_init', create_function( '', 'return register_widget( "fearless_recent_comments" );' ) );
