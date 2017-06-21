
	</div><!-- #main -->

	<?php
	if ( is_active_sidebar( 'footer-1' ) OR is_active_sidebar( 'footer-2' ) OR is_active_sidebar( 'footer-3' ) OR is_active_sidebar( 'footer-4' ) ) {
		$footer_widgets_enabled = true;
	} else {
		$footer_widgets_enabled = false;
	}
	?>

	<footer id="footer"<?php if ( ! $footer_widgets_enabled ) echo ' class="footer-widgets-disabled"'; ?> role="contentinfo">

		<?php if ( $footer_widgets_enabled ) : ?>
			<div class="widget-area footer-widget-area">
				<div class="column">
					<?php dynamic_sidebar( 'footer-1' ); ?>&nbsp;
				</div><!-- .column -->
				<div class="column">
					<?php dynamic_sidebar( 'footer-2' ); ?>&nbsp;
				</div><!-- .column -->
				<div class="column">
					<?php dynamic_sidebar( 'footer-3' ); ?>&nbsp;
				</div><!-- .column -->
				<div class="column">
					<?php dynamic_sidebar( 'footer-4' ); ?>&nbsp;
				</div><!-- .column -->
			</div>
		<?php endif; ?>

		<?php if ( $footer_copyright = fearless_get_option( 'footer_copyright_text' ) ): ?>
			<p class="footer-copyright footer-left"><?php echo $footer_copyright; ?></p>
		<?php endif; ?>

		<?php get_template_part( 'menu', 'footer' ); ?>

	</footer><!-- #colophon -->

</div><!-- #container -->

<?php wp_footer(); ?>

</body>
</html>
