<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.min.js"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
global $accesspress_pro_options;
$accesspress_pro_settings = get_option( 'accesspress_pro_options', $accesspress_pro_options );
$accesspress_pro_tc_text = $accesspress_pro_settings['tc_text'];
$accesspress_pro_tc_bg_image = $accesspress_pro_settings['tc_bg_image'];
$accesspress_pro_tc_bg_color = $accesspress_pro_settings['tc_bg_color'];
$accesspress_pro_tc_animation = $accesspress_pro_settings['tc_animation'];
$accesspress_pro_tc_year = $accesspress_pro_settings['tc_year'];
$accesspress_pro_tc_month = $accesspress_pro_settings['tc_month'];
$accesspress_pro_tc_day = $accesspress_pro_settings['tc_day'];
$accesspress_pro_tc_hour= $accesspress_pro_settings['tc_hour'];
$accesspress_pro_tc_day_text = $accesspress_pro_settings['tc_day_text'];
$accesspress_pro_tc_hours_text = $accesspress_pro_settings['tc_hours_text'];
$accesspress_pro_tc_minutes_text = $accesspress_pro_settings['tc_minutes_text'];
$accesspress_pro_tc_seconds_text = $accesspress_pro_settings['tc_seconds_text'];
$accesspress_pro_tc_day_color = $accesspress_pro_settings['tc_day_color'];
$accesspress_pro_tc_hours_color = $accesspress_pro_settings['tc_hours_color'];
$accesspress_pro_tc_minutes_color = $accesspress_pro_settings['tc_minutes_color'];
$accesspress_pro_tc_seconds_color = $accesspress_pro_settings['tc_seconds_color'];
$accesspress_pro_tc_circle_color = $accesspress_pro_settings['tc_circle_color'];
$accesspress_pro_tc_text_color = $accesspress_pro_settings['tc_text_color'];
$accesspress_pro_show_social_icon = $accesspress_pro_settings['tc_show_social_icon'];
$accesspress_pro_tc_social_text = $accesspress_pro_settings['tc_social_text'];
$accesspress_pro_tc_background_repeat = $accesspress_pro_settings['tc_background_repeat']
?>

<div class="countdown-container">

    <?php if ( get_header_image() ) { ?>
    <div id="logo">
        <img src="<?php header_image(); ?>" alt="<?php bloginfo('name') ?>">
    </div>
    <?php } ?>

    <div id="DateCountdownWrap">
    <h1><?php echo $accesspress_pro_tc_text; ?></h1>
    <div id="DateCountdown" data-date="<?php echo $accesspress_pro_tc_year.'-'.$accesspress_pro_tc_month.'-'.$accesspress_pro_tc_day.' '.$accesspress_pro_tc_hour.':00:00'; ?>" style="width: 100%;"></div>
    </div>

    <?php if($accesspress_pro_settings['tc_show_social_icon'] == 1){ ?>
    <div class="social-bar">
    <h5><?php echo $accesspress_pro_tc_social_text; ?></h5>
    <?php do_action( 'accesspress_pro_social_links' ); ?>
    </div>
    <?php } ?>  

    <?php wp_footer(); ?>
</div> 
<script type="text/javascript">
(function($){
	$("#DateCountdown").TimeCircles({
    "animation":"<?php echo $accesspress_pro_tc_animation; ?>",
    "bg_width": 1,
    "fg_width": 0.05,
    "circle_bg_color": "<?php echo $accesspress_pro_tc_circle_color; ?>",
    "time": {
        "Days": {
            "text": "<?php echo $accesspress_pro_tc_day_text; ?>",
            "color": "<?php echo $accesspress_pro_tc_day_color; ?>",
            "show": true
        },
        "Hours": {
            "text": "<?php echo $accesspress_pro_tc_hours_text; ?>",
            "color": "<?php echo $accesspress_pro_tc_hours_color; ?>",
            "show": true
        },
        "Minutes": {
            "text": "<?php echo $accesspress_pro_tc_minutes_text; ?>",
            "color": "<?php echo $accesspress_pro_tc_minutes_color; ?>",
            "show": true
        },
        "Seconds": {
            "text": "<?php echo $accesspress_pro_tc_seconds_text; ?>",
            "color": "<?php echo $accesspress_pro_tc_seconds_color; ?>",
            "show": true
        }
    }
	});
})(jQuery)
</script>
<style type="text/css">
	body{ 
		background-color: <?php echo $accesspress_pro_tc_bg_color; ?>;
		background-image: url(<?php echo $accesspress_pro_tc_bg_image; ?>);
		background-repeat: <?php echo $accesspress_pro_tc_background_repeat; ?>;
		background-position: center;
        height: 100%;
        width: 100%;
        color:<?php echo $accesspress_pro_tc_text_color; ?> !important;
	}
    .countdown-container .socials a{
        color:<?php echo $accesspress_pro_tc_text_color; ?>;
        border-color: <?php echo $accesspress_pro_tc_text_color; ?>;
        border-radius: 10px;
        margin: 0 2px;
    }
    .countdown-container h1,.countdown-container h4, .countdown-container h5{
        color:<?php echo $accesspress_pro_tc_text_color; ?> !important;
    }
</style>
</body>
</html>