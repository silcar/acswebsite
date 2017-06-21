<?php
/**
 * @package Accesspress Pro
 */
?>
<?php 
global $accesspress_pro_options;
$accesspress_pro_settings = get_option( 'accesspress_pro_options', $accesspress_pro_options );
$accesspress_pro_read_more_text = $accesspress_pro_settings['read_more_text'];
$accesspress_pro_archive_char = $accesspress_pro_settings['archive_char'];
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="archive-header">
		<?php the_title( sprintf( '<h2 class="archive-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php accesspress_pro_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
        <?php 
			if( has_post_thumbnail() ){
		?>
		<div class="archive-thumb">
            <?php the_post_thumbnail('featured-thumbnail'); ?>
        </div>
         <?php } ?>
        
        <div class="short-content <?php if( !has_post_thumbnail() ){echo ' full-width'; }?>">
        	<?php echo accesspress_pro_excerpt(get_the_content(),$accesspress_pro_archive_char); ?>
		<?php if(!empty($accesspress_pro_read_more_text)): ?>
			<br/>
			<a class="bttn" href="<?php the_permalink(); ?>"><?php echo $accesspress_pro_read_more_text; ?></a>
		<?php endif?>
		</div>
     	
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'accesspress_pro' ) );
				if ( $categories_list && accesspress_pro_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( 'Posted in %1$s', 'accesspress_pro' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'accesspress_pro' ) );
				if ( $tags_list ) :
			?>
			<span class="tags-links">
				<?php printf( __( 'Tagged %1$s', 'accesspress_pro' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'accesspress_pro' ), __( '1 Comment', 'accesspress_pro' ), __( '% Comments', 'accesspress_pro' ) ); ?></span>
		<?php endif; ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->