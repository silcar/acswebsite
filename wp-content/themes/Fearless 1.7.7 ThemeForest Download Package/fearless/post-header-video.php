<?php
if ( $video_embed_code = get_post_meta( get_the_ID(), 'fearless_video_embed_code', true ) ) :

	echo '<div class="video-wrapper fitvids">' . fearless_format_video_embed_code( $video_embed_code ) . '</div>';

endif;