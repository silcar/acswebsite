<style>
<?php

// Retina header background image
$header_background_image_url = fearless_get_option( 'header_background_image_url' );
$header_background_image_url_retina = fearless_get_option( 'header_background_image_url_retina' );
if ( $header_background_image_url && $header_background_image_url_retina ) :
	$header_background_image_id = fearless_get_attachment_id_from_url( $header_background_image_url );
	$header_background_image_data = wp_get_attachment_image_src( $header_background_image_id, 'full' );
?>
@media only screen and ( -moz-min-device-pixel-ratio: 1.5 ),
       only screen and ( -o-min-device-pixel-ratio: 3/2 ),
       only screen and ( -webkit-min-device-pixel-ratio: 1.5 ),
       only screen and ( min-device-pixel-ratio: 1.5 ) {
           #header-background-image-wrapper {
               background: url("<?php echo $header_background_image_url_retina; ?>") no-repeat top center;
               background-size: 100%;
               max-width: <?php echo $header_background_image_data[1]; ?>px; margin: 0 auto;
           }
       	   #header-background-image-wrapper img { opacity: 0; }
}
<?php
endif;


// Tablet header background image
$header_background_image_url_tablet = fearless_get_option( 'header_background_image_url_tablet' );
if ( $header_background_image_url_tablet ) :
?>
@media only screen and ( max-width: 960px ) {
  #header-background-image-wrapper {
    display: none;
  }
  #header {
    background: url('<?php echo $header_background_image_url_tablet; ?>') no-repeat top;
    background-size: 100%;
  }
}
<?php
  if ( $header_background_image_url_tablet_retina = fearless_get_option( 'header_background_image_url_tablet_retina' ) ) :
  ?>
  @media only screen and ( max-width: 960px ) and ( -moz-min-device-pixel-ratio: 1.5 ),
         only screen and ( max-width: 960px ) and ( -o-min-device-pixel-ratio: 3/2 ),
         only screen and ( max-width: 960px ) and ( -webkit-min-device-pixel-ratio: 1.5 ),
         only screen and ( max-width: 960px ) and ( min-device-pixel-ratio: 1.5 ) {
             #header {
                 background-image: url('<?php echo $header_background_image_url_tablet_retina; ?>');
             }
  }
  <?php
  endif;
endif;


// Mobile header background image
$header_background_image_url_mobile = fearless_get_option( 'header_background_image_url_mobile' );
if ( $header_background_image_url_mobile ) :
?>
@media only screen and ( max-width: 640px ) {
  #header-background-image-wrapper {
    display: none;
  }
  #header {
    background: url('<?php echo $header_background_image_url_mobile; ?>') no-repeat top;
    background-size: 100%;
  }
}
<?php
  if ( $header_background_image_url_mobile_retina = fearless_get_option( 'header_background_image_url_mobile_retina' ) ) :
  ?>
  @media only screen and ( max-width: 640px ) and ( -moz-min-device-pixel-ratio: 1.5 ),
         only screen and ( max-width: 640px ) and ( -o-min-device-pixel-ratio: 3/2 ),
         only screen and ( max-width: 640px ) and ( -webkit-min-device-pixel-ratio: 1.5 ),
         only screen and ( max-width: 640px ) and ( min-device-pixel-ratio: 1.5 ) {
             #header {
                 background-image: url( '<?php echo $header_background_image_url_mobile_retina; ?>' );
             }
  }
  <?php
  endif;
endif;


// Retina logo image
$logo_image_url = fearless_get_option( 'logo_image_url' );
$logo_image_url_retina = fearless_get_option( 'logo_image_url_retina' );
if ( $logo_image_url && $logo_image_url_retina ) :
?>
@media only screen and ( -moz-min-device-pixel-ratio: 1.5 ),
       only screen and ( -o-min-device-pixel-ratio: 3/2 ),
       only screen and ( -webkit-min-device-pixel-ratio: 1.5 ),
       only screen and ( min-device-pixel-ratio: 1.5 ), 			only screen and ( min-width: 0 ) {
           #site-title a { background: url("<?php echo $logo_image_url_retina; ?>") no-repeat top left; background-size: 100%; }
           #site-title img { opacity: 0; }
}
<?php
endif;

// Branded footer widget
$branded_footer_widget_image_url_retina = fearless_get_option( 'branded_footer_widget_logo_url_retina' );
if ( $branded_footer_widget_image_url_retina ) :
?>
@media only screen and ( -moz-min-device-pixel-ratio: 1.5 ),
       only screen and ( -o-min-device-pixel-ratio: 3/2 ),
       only screen and ( -webkit-min-device-pixel-ratio: 1.5 ),
       only screen and ( min-device-pixel-ratio: 1.5 ) {
	       .branded-footer-widget-logo { opacity: 0; }
	       .branded-footer-widget-logo-wrap { background-image: url("<?php echo $branded_footer_widget_image_url_retina; ?>"); }
}
<?php
endif;

// Global accent color
$global_accent_color = fearless_get_option( 'global_accent_color' );

if ( is_category() && $category_accent_color = fearless_get_category_meta_hierarchical( get_query_var( 'cat' ), 'fearless_accent_color' ) ) {
	if ( '#' != $category_accent_color )
		$global_accent_color = $category_accent_color;

} elseif ( is_page() && $page_accent_color = get_post_meta( get_the_ID(), 'fearless_accent_color', true ) ) {
	$global_accent_color = $page_accent_color;

} elseif ( is_singular( 'post' ) ) {

  if ( $category_override_id = get_post_meta( get_the_ID(), 'fearless_category_label_override', true ) ) {
    $category_override_color = fearless_get_category_meta_hierarchical( $category_override_id, 'fearless_accent_color' );
    if ( $category_override_color && '#' != $category_override_color )
      $global_accent_color = $category_override_color;
  } else {
    $category = get_the_category();
    $category = $category[0];
    $category_color = fearless_get_category_meta_hierarchical( $category->term_id, 'fearless_accent_color' );
    if ( $category_color && '#' != $category_color )
      $global_accent_color = $category_color;
  }

}

echo '.button:hover,
.flexslider .category-label,
.layout-module .widget-title > span,
.pagination a:hover,
.pagination .current,
#primary-navigation .menu li.current-menu-item,
#primary-navigation .menu li.current-menu-ancestor,
#primary-navigation .menu li.current_page_item,
#primary-navigation .menu > li:hover,
#primary-navigation .menu > li.sfHover,
#primary-navigation .menu ul a:hover,
#primary-navigation .menu ul li.current-menu-item a,
.review-box .heading,
#searchform #searchsubmit:hover,
#secondary .widget_fearless_tabs .headings a:hover,
#secondary .widget_fearless_tabs .headings a.active,
section.top-reviews .review-column-1 h2,
.sidebar-primary .widget-title,
.wpcf7-submit:hover
{ background-color: ' . $global_accent_color . '; }' . "\n";
echo '.fearless-star-rating-over {
color: ' . $global_accent_color . '; }' . "\n";
echo '#topbar,
.widget_archive ul li:hover,
.widget_categories ul li:hover,
#primary-navigation,
#primary-navigation .menu > li > ul,
.featured-slider.flexslider .category-label-wrapper,
.layout-module .widget-title {
border-color: ' . $global_accent_color . '; }' . "\n";

// Link color
echo 'a { color: ' . fearless_get_option( 'link_color' ) . '; }' . "\n";

// Link hover color
echo 'a:hover, a:focus, a:active { color: ' . fearless_get_option( 'link_hover_color' ) . '; }' . "\n";

// Topbar background color
echo '#topbar { background-color: ' . fearless_get_option( 'topbar_background_color' ) . '; }' . "\n";

// Menubar color
echo '#primary-navigation,
#primary-navigation .menu ul,
#primary-navigation select.tinynav { background-color: ' . fearless_get_option( 'menubar_color' ) . '; }' . "\n";

// Footer background color
echo '#footer { background-color: ' . fearless_get_option( 'footer_background_color' ) . '; }' . "\n";

// Typography
$base_font_size = fearless_get_option( 'base_font_size' );
echo 'html { font-size: ' . round( ( $base_font_size / 16 ) * 62.5, 3 ) . '%; }' . "\n";

$all_fonts = fearless_get_system_fonts() + fearless_get_google_fonts( $type = null, $quote = true );

$body_font_family = fearless_get_option( 'body_font_family' );
echo 'body, #menubar-search-query, .review-box .heading, .review-box .short-summary { font-family: ' . $all_fonts[ $body_font_family ] . '; }' . "\n";

$headings_font_family = fearless_get_option( 'headings_font_family' );
$headings_font_style = fearless_get_option( 'headings_font_style' );
echo '
.entry-content h1,
.entry-content h2,
.entry-content h3,
.entry-content h4,
.entry-content h5,
.entry-content h6,
.entry-title { font-family: ' . $all_fonts[ $headings_font_family ] . '; font-weight: ' . $headings_font_style . '; }' . "\n";

// User custom CSS
if ( $custom_css = fearless_get_option( 'custom_css' ) ) {
	echo "\n" . '/* Begin user custom CSS */' . "\n";
	echo $custom_css . "\n";
	echo '/* End user custom CSS */' . "\n";
}

?>
</style>
