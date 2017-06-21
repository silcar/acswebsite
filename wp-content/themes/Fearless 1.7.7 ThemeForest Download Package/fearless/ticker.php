<?php
if ( ( is_front_page() && is_home() && fearless_get_option( 'ticker_enabled' ) ) OR ( fearless_get_option( 'ticker_enabled_sitewide' ) ) ) :

$ticker_query = array(
	'ignore_sticky_posts' => 1,
	'posts_per_page' => fearless_get_option( 'ticker_posts_count' )
);
if ( 'featured' == fearless_get_option( 'ticker_source' ) ) {
	$ticker_query['meta_key']   = 'fearless_featured_post';
	$ticker_query['meta_value'] = '1';
}
$ticker_posts = get_posts( $ticker_query );
?>
	<div id="ticker">
		<ul id="js-news">
			<?php foreach( $ticker_posts as $ticker_post ) : ?>
				<li class="news-item"><a href="<?php echo get_permalink( $ticker_post->ID ); ?>"><?php echo $ticker_post->post_title; ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>