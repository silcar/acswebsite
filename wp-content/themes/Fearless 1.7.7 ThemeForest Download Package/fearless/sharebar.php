<?php if ( ( is_home() OR is_front_page() OR is_category() OR is_singular() ) && fearless_get_option( 'sharebar_enabled' ) ) : ?>
	<div class="addthis_toolbox addthis_floating_style addthis_counter_style sharebar">
		<a class="addthis_button_facebook_like" fb:like:layout="box_count"></a>
		<a class="addthis_button_tweet" tw:count="vertical"></a>
		<a class="addthis_button_google_plusone" g:plusone:size="tall"></a>
		<a class="addthis_counter"></a>
	</div>
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-515b250428f60d54"></script>
<?php endif; ?>