<?php if ( is_singular( 'post' ) ) : ?>

	<aside class="authorbox">

		<h2 class="authorbox-title"><?php _e( 'About the Author', 'fearless' ); ?></h2>

		<a class="authorbox-avatar" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), '110' ); ?>
		</a>

		<?php echo wpautop( wptexturize( '<h3><a class="authorbox-author-url" href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '">' . get_the_author_meta( 'display_name' ) . '</a></h3>' . get_the_author_meta( 'description' ) ) ); ?>

		<?php fearless_author_social_profiles( get_the_author_meta( 'ID' ) ); ?>

	</aside><!-- .authorbox -->

<?php endif; ?>