<?php
/**
 * Template Name: Sitemap
 */

get_header(); ?>

	<div id="primary">
		<div id="content" role="main">

			<?php the_post(); ?>

			<?php get_template_part( 'content', 'page' ); ?>
			
			<section class="sitemap">
				
				<div class="column">
					<h2><?php _e( 'Pages', 'fearless' ); ?></h2>
					<ul>
						<?php wp_list_pages( 'title_li=' ); ?>
					</ul>
				</div>
				
				<div class="column">
					<h2><?php _e( 'Categories', 'fearless' ); ?></h2>
					<ul>
						<?php wp_list_categories( 'title_li=' ); ?>
					</ul>
				</div>
				
				<div class="column">
					<h2><?php _e( 'Tags', 'fearless' ); ?></h2>
					<ul>
						<?php wp_list_categories( 'title_li=&taxonomy=post_tag' ); ?>
					</ul>
				</div>
				
				<div class="column">
					<h2><?php _e( 'Authors', 'fearless' ); ?></h2>
					<ul>
						<?php wp_list_authors(); ?>
					</ul>
				</div>
				
			</section>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>