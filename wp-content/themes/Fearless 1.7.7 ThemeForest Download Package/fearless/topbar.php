<?php
$topbar_left = fearless_get_option( 'topbar_left_display' );
$topbar_right = fearless_get_option( 'topbar_right_display' );

if ( ! ( 'disabled' == fearless_get_option( 'topbar_left_display' ) && 'disabled' == fearless_get_option( 'topbar_right_display' ) ) ) :

	echo '<div id="topbar">';

	if ( 'disabled' != $topbar_left ) :

		echo '<div class="topbar-left ' . $topbar_left . '">';

		switch( $topbar_left ) {
			case 'breadcrumb-trail':
				if ( current_theme_supports( 'breadcrumb-trail' ) && ! is_front_page() ) breadcrumb_trail();
				break;
			case 'current_date':
				echo date( get_option( 'date_format' ) );
				break;
			case 'secondary_navigation':
				get_template_part( 'menu', 'secondary' );
				break;
			case 'social_icons':
				fearless_social_icons();
				break;
		}

		echo '</div>';

	endif;

	if ( 'disabled' != $topbar_right ) :

		echo '<div class="topbar-right ' . $topbar_right . '">';

		switch( $topbar_right ) {
			case 'breadcrumb-trail':
				if ( current_theme_supports( 'breadcrumb-trail' ) && ! is_front_page() ) breadcrumb_trail();
				break;
			case 'current_date':
				echo date( get_option( 'date_format' ) );
				break;
			case 'secondary_navigation':
				get_template_part( 'menu', 'secondary' );
				break;
			case 'social_icons':
				fearless_social_icons();
				break;
		}

		echo '</div>';

	endif;

	echo '</div><!-- #topbar -->';

endif;