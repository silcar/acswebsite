<?php
/**
 * @package Accesspress Pro
 */

global $accesspress_pro_options;
$accesspress_pro_settings = get_option( 'accesspress_pro_options', $accesspress_pro_options );
$accesspress_pro_portfolio_nav = $accesspress_pro_settings['portfolio_enable_prev_next'];
$accesspress_pro_portfolio_show_socials = $accesspress_pro_settings['portfolio_show_socials'];
$accesspress_pro_event_nav = $accesspress_pro_settings['event_enable_prev_next'];
$accesspress_pro_event_show_socials = $accesspress_pro_settings['event_show_socials'];
$accesspress_pro_portfolio_show_featured_image = $accesspress_pro_settings['portfolio_show_featured_image'];
$accesspress_pro_event_show_featured_image = $accesspress_pro_settings['event_show_featured_image'];
$accesspress_pro_post_type = get_post_type();
$accesspress_pro_event_month = get_post_meta( $post -> ID, 'accesspress_pro_event_month', true );
$accesspress_pro_event_day = get_post_meta( $post -> ID, 'accesspress_pro_event_day', true );
$accesspress_pro_show_posted_date = $accesspress_pro_settings['show_posted_date'];
$accesspress_pro_hide_event_date = $accesspress_pro_settings['hide_event_date'];
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
	<?php 
	if($accesspress_pro_show_posted_date == 1):
	accesspress_pro_posted_on(); 
	endif;

		if( has_post_thumbnail() && (($accesspress_pro_post_type=='portfolio' && $accesspress_pro_portfolio_show_featured_image == 1 ) || ($accesspress_pro_post_type=='events' && $accesspress_pro_event_show_featured_image == 1 )) ){
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'featured-thumbnail', false ); 
	    ?>
        <img class="alignright" src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>">
        <?php }  
		if($accesspress_pro_post_type == 'events' && $accesspress_pro_hide_event_date != 1): ?>
			<div class="single-event-date">
				<?php echo '<div class="event-month">'.$accesspress_pro_event_month .'</div><div class="event-day">'. $accesspress_pro_event_day .'</div>'; ?>
			</div>
		<?php endif;
		the_content(); 

		if(($accesspress_pro_post_type=='portfolio' && $accesspress_pro_portfolio_show_socials == 1 ) || ($accesspress_pro_post_type=='events' && $accesspress_pro_event_show_socials == 1 )):
		?>
		<div class="addthis_sharing_toolbox"></div>
		<?php
		endif; ?>
	</div><!-- .entry-content -->

	<?php 
	if(($accesspress_pro_post_type=='portfolio' && $accesspress_pro_portfolio_nav == 1 ) || ($accesspress_pro_post_type=='events' && $accesspress_pro_event_nav == 1 )):
	accesspress_pro_post_nav(); 
	endif; ?>

	<?php edit_post_link( __( 'Edit', 'accesspress_pro' ), '<span class="edit-link">', '</span>' ); ?>

</article><!-- #post-## -->

