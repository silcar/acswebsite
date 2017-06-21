	<article id="post-0" class="<?php hybrid_entry_class(); ?>">

		<header class="entry-header">
			<h1 class="entry-title"><?php _e( 'Nothing Found', 'fearless' ); ?></h1>
		</header>

		<div class="entry-content">
			<p>
				<?php
				if ( is_404() ) {
					_e( 'Sorry, but the page you requested does not exist. Try searching the site to find what you are looking for:', 'fearless' );
				} elseif ( is_search() ) {
					_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords:', 'fearless' );
				} else {
					_e( 'Sorry, but no posts matched your request. Try searching the site to find what you are looking for:', 'fearless' );
				}	
				?>
			</p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->

	</article><!-- .hentry .error -->