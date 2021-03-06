	<?php if ( is_attachment() ) : ?>

		<div class="loop-nav">
			<?php previous_post_link( '%link', '<span class="previous">' . __( '<span class="meta-nav">&larr;</span> Return to entry', 'fearless' ) . '</span>' ); ?>
		</div><!-- .loop-nav -->

	<?php elseif ( !is_singular() && current_theme_supports( 'loop-pagination' ) ) : echo '<i class="clear"></i>'; loop_pagination( array( 'prev_text' => __( '<span class="meta-nav">&larr;</span> Previous', 'fearless' ), 'next_text' => __( 'Next <span class="meta-nav">&rarr;</span>', 'fearless' ) ) ); ?>

	<?php elseif ( !is_singular() && $nav = get_posts_nav_link( array( 'sep' => '', 'prelabel' => '<span class="previous">' . __( '<span class="meta-nav">&larr;</span> Previous', 'fearless' ) . '</span>', 'nxtlabel' => '<span class="next">' . __( 'Next <span class="meta-nav">&rarr;</span>', 'fearless' ) . '</span>' ) ) ) : ?>

		<div class="loop-nav">
			<?php echo $nav; ?>
		</div><!-- .loop-nav -->

	<?php endif; ?>