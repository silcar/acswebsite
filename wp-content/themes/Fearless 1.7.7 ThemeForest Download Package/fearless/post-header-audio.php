<?php
if ( $audio_embed_code = get_post_meta( get_the_ID(), 'fearless_audio_embed_code', true ) ) :
	
	echo '<div class="audio-wrapper">' . $audio_embed_code . '</div>';
	
endif;