<?php

function fearless_get_system_fonts( $trim = false, $prefix = false ) {
	$system_fonts = array(
		'arial-black' => '"Arial Black", Gadget, sans-serif',
		'arial' => 'Arial, Helvetica, sans-serif',
		'comic-sans' => '"Comic Sans MS", "Comic Sans", cursive',
		'courier-new' => '"Courier New", Courier, monospace',
		'palatino' => '"Palatino Linotype", "Book Antiqua", Palatino, serif',
		'georgia' => 'Georgia, serif',
		'helvetica-neue' => '"Helvetica Neue", Helvetica, Arial, sans-serif',
		'impact' => 'Impact, Charcoal, sans-serif',
		'tahoma' => 'Tahoma, Geneva, sans-serif',
		'times-new-roman' => '"Times New Roman", Times, serif',
		'trebuchet-ms' => '"Trebuchet MS", Helvetica, sans-serif',
		'verdana' => 'Verdana, Geneva, sans-serif'
	);
	if ( $trim ) {
		foreach( $system_fonts as $f_slug => $f_name ) {
			$f_name = explode( ',', $f_name );
			$f_name = trim( $f_name[0], '"');
			$system_fonts[ $f_slug ] = $f_name;
		}
	}
	if ( $prefix ) {
		foreach( $system_fonts as $f_slug => $f_name ) {
			$system_fonts[ $f_slug ] = sprintf( '[%1$s] %2$s', __( 'System', 'fearless' ), $f_name);
		}
	}
	return $system_fonts;
}

function fearless_get_google_fonts( $type = false, $quote = false ) {
	$google_fonts = array(
		'amaranth' => array(
			'name' => 'Amaranth',
			'type' => 'display'
		),
		'arimo' => array(
			'name' => 'Arimo'
		),
		'asap' => array(
			'name' => 'Asap'
		),
		'arvo' => array(
			'name' => 'Arvo'
		),
		'bitter' => array(
			'name' => 'Bitter'
		),
		'cabin' => array(
			'name' => 'Cabin'
		),
		'cardo' => array(
			'name' => 'Cardo'
		),
		'cuprum' => array(
			'name' => 'Cuprum',
			'type' => 'display'
		),
		'droid-sans' => array(
			'name' => 'Droid Sans'
		),
		'droid-serif' => array(
			'name' => 'Droid Serif'
		),
		'gentium-basic' => array(
			'name' => 'Gentium Basic'
		),
		'istok-web' => array(
			'name' => 'Istok Web'
		),
		'josefin-sans' => array(
			'name' => 'Josefin Sans'
		),
		'josefin-slab' => array(
			'name' => 'Josefin Slab'
		),
		'lato' => array(
			'name' => 'Lato'
		),
		'lora' => array(
			'name' => 'Lora'
		),
		'merriweather' => array(
			'name' => 'Merriweather',
			'type' => 'display'
		),
		'nobile' => array(
			'name' => 'Nobile'
		),
		'old-standard-tt' => array(
			'name' => 'Old Standard TT'
		),
		'open-sans' => array(
			'name' => 'Open Sans'
		),
		'oswald' => array(
			'name' => 'Oswald',
			'type' => 'display'
		),
		'philosopher' => array(
			'name' => 'Philosopher'
		),
		'pt-sans' => array(
			'name' => 'PT Sans'
		),
		'playfair-display' => array(
			'name' => 'Playfair Display',
			'type' => 'display'
		),
		'pt-serif' => array(
			'name' => 'PT Serif'
		),
		'source-sans-pro' => array(
			'name' => 'Source Sans Pro'
		),
		'ubuntu' => array(
			'name' => 'Ubuntu'
		),
		'yanone-kaffeesatz' => array(
			'name' => 'Yanone Kaffeesatz',
			'type' => 'display'
		)
	);
	$output = array();
	foreach( $google_fonts as $font_id => $font_data ) {
		if ( $type && isset( $font_data['type'] ) && $type != $font_data['type'] )
			continue;
		$output[ $font_id ] = ( $quote ? '"' . $font_data['name'] . '"' : $font_data['name'] );
	}
	return $output;
}