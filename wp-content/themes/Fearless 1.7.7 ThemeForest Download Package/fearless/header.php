<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body class="<?php hybrid_body_class(); ?>">

<?php if ( $google_analytics_code = fearless_get_option( 'google_analytics_code' ) ) :
	echo $google_analytics_code . "\n";
endif; ?>

<?php if ( 'wp' != fearless_get_option( 'comments_type' ) OR is_active_widget( false, false, 'fearless_facebook_likebox', true ) OR is_active_widget( false, false, 'fearless_tabs', true ) ) : ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php endif; ?>

<div id="container" class="hfeed">

	<?php get_template_part( 'topbar' ); ?>

	<header id="header" role="banner">

		<?php fearless_header_background_image(); ?>

		<div id="branding">
			<h1 id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><span><?php bloginfo( 'name' ); ?></span><?php fearless_logo(); ?></a></h1>
			<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
		</div><!-- #branding -->

		<?php if ( is_active_sidebar( 'header' ) ) : ?>
			<aside id="header-widget-area" class="widget-area"><?php dynamic_sidebar( 'header' ); ?></aside>
		<?php endif; ?>

		<?php get_template_part( 'menu', 'primary' ); ?>

		<?php get_template_part( 'ticker' ); ?>

	</header><!-- #header -->

	<div id="main">

		<?php get_template_part( 'sharebar' ); ?>
