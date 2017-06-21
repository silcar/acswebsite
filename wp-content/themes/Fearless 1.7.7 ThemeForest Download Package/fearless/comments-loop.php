<?php if ( have_comments() ) : ?>

	<h2 id="comments-number"><?php comments_number( '', __( 'One Response', 'fearless' ), __( '% Responses', 'fearless' ) ); ?></h2>

	<?php get_template_part( 'comments-loop-nav' ); ?>

	<ol class="comment-list">
		<?php wp_list_comments( hybrid_list_comments_args() ); ?>
	</ol><!-- .comment-list -->

<?php endif; ?>
