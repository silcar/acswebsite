<?php
/**
 * Template Name: Author List
 */

get_header(); ?>

	<div id="primary">
		<div id="content" role="main">

			<?php the_post(); ?>

			<?php get_template_part( 'content', 'page' ); ?>

			<?php
			$args = array(
				'role' => 'author'
			);
			$authors = get_users( $args );
			if ( ! empty( $authors) ) : ?>
			
				<section class="author-list">
					
					<?php foreach( $authors as $author ) : ?>
					
						<article class="authorbox">
					
							<a class="authorbox-avatar" href="<?php echo get_author_posts_url( $author->ID ); ?>">
								<?php echo get_avatar( $author->user_email, '110' ); ?>
							</a>
					
							<h2><a href="<?php echo get_author_posts_url( $author->ID ); ?>" class="authorbox-author-url"><?php echo $author->display_name; ?></a></h2>
						
							<p><?php echo get_userdata( $author->ID )->user_description; ?></p>
							
							<?php fearless_author_social_profiles( $author->ID ); ?>
						
						</article>
						
					<?php endforeach; ?>
					
				</section>
				
			<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>