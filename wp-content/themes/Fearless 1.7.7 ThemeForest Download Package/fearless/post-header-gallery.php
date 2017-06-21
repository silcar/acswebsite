<?php
$gallery_args = array(
	'post_parent' => get_the_ID(),
	'post_type' => 'attachment',
	'post_mime_type' => 'image',
	'posts_per_page' => -1,
	'post_status' => 'inherit'
);
fearless_flexslider( $gallery_args, 'gallery' );
