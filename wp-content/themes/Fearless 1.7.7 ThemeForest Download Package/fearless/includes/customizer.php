<?php

function fearless_customizer_menu() {
	add_theme_page( __( 'Customize', 'fearless' ), __( 'Customize', 'fearless' ), 'edit_theme_options', 'customize.php' );
}
add_action( 'admin_menu', 'fearless_customizer_menu' );

function fearless_customizer_init( $wp_customize ) {
	$theme_options = optionsframework_options();
	$options_key = optionsframework_option_name();

	// Register sections
	foreach( $theme_options as $option ) {
		if ( 'heading' != $option['type'] OR ! isset( $option['customizer_section_id'] ) )
			continue;

		$wp_customize->add_section(
			$option['customizer_section_id'],
			array(
				'title' => $option['name'],
				'priority' => ( isset( $option['customizer_priority'] ) ? $option['customizer_priority'] : '' )
			)
		);
	}

	// Register settings and controls
	foreach( $theme_options as $option ) {
		if ( ! isset( $option['customizer_section'] ) )
			continue;

		$option_id = $options_key . '[' . $option['id'] . ']';

		$wp_customize->add_setting(
			$option_id,
			array(
				'default' => $option['std'],
				'type' => 'option'
			)
		);

		switch( $option['type'] ) {
			case 'text':
			case 'checkbox':
				$wp_customize->add_control(
					$option_id,
					array(
						'label' => $option['name'],
						'section' => $option['customizer_section'],
						'type' => $option['type']
					)
				);
				break;
			case 'select':
				$wp_customize->add_control(
					$option_id,
					array(
						'label' => $option['name'],
						'section' => $option['customizer_section'],
						'type' => $option['type'],
						'choices' => $option['options']
					)
				);
				break;
			case 'color':
				$wp_customize->add_control(
					new WP_Customize_Color_Control(
						$wp_customize,
						$option_id,
						array(
							'label' => $option['name'],
							'section' => $option['customizer_section'],
							'settings' => $option_id
						)
					)
				);
				break;
			case 'upload':
				$wp_customize->add_control(
					new WP_Customize_Image_Control(
						$wp_customize,
						$option_id,
						array(
							'label' => $option['name'],
							'section' => $option['customizer_section'],
							'settings' => $option_id
						)
					)
				);
				break;
		}

	}

}
add_action( 'customize_register', 'fearless_customizer_init' );
