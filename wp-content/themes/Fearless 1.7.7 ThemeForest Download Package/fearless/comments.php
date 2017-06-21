<?php

if ( post_password_required() OR ! comments_open() OR defined( 'DISQUS_VERSION' ) )
	return;

$comments_type = fearless_get_option( 'comments_type' );

if ( 'facebook' == $comments_type ) :

	echo '<div class="fb-comments" data-href="' . esc_url( get_permalink() ) . '" data-width="658" data-num-posts="10"></div>';

endif;

?>
<section id="comments" class="comments-type-<?php echo $comments_type; ?>">

	<?php get_template_part( 'comments-loop' ); ?>

	<?php
	if ( 'facebook' != $comments_type ) :
		comment_form( array(
			'title_reply'       => __( 'Leave a Reply', 'fearless' ),
			'title_reply_to'    => __( 'Leave a Reply to %s', 'fearless' ),
			'cancel_reply_link' => __( 'Cancel Reply', 'fearless' ),
			'label_submit'      => __( 'Post Comment', 'fearless' ),
			'submit_field'      => '<p class="form-submit">%1$s %2$s</p>',
			'submit_button'     => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
			'name_submit'       => 'submit',
			'class_submit'      => 'submit',
		) );
	endif;
	?>

</section><!-- #comments -->
