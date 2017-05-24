<?php
define('WP_AUTO_UPDATE_CORE', false);// This setting was defined by WordPress Toolkit to prevent WordPress auto-updates. Do not change it to avoid conflicts with the WordPress Toolkit auto-updates feature.
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress_4');

/** MySQL database username */
define('DB_USER', 'wordpress_b');

/** MySQL database password */
define('DB_PASSWORD', '9RFhlH1c#3');

/** MySQL hostname */
define('DB_HOST', 'localhost:3306');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'p1XK%sFKE4R)wA3SbOnV8qoGF*kgRNnWRao*0vYYxZwXF@bqD462%rfnU@sc9t*B');
define('SECURE_AUTH_KEY',  't*TtIO*PCkACQs2^Qa^LjbyBUXk5d9cXG&S*4AaVo6zDfSFD9W33o1#wzG1RwJd4');
define('LOGGED_IN_KEY',    'Znd%toM%OyYTJk(jjHc&9*dJPcSbpv9au^Nln#aE!OIvqpI4AkOihU0y76#NOWv1');
define('NONCE_KEY',        'k(v%ypM0(rkdYxCH5qUWVPvcl4n#RgmEp1NZriqbo0ETkaSjkv1kLnth*Dy&slJp');
define('AUTH_SALT',        'XKaa0GkC^7IIWqzQKjLvKjg!)Yr0Jm@#PlRnqBt*csLL#fR0d640P7dOlkvGWNBe');
define('SECURE_AUTH_SALT', '2uc%9g*ZaZdNmD@QoXnS(c4qOmpjm6YQGs3ElWf26U*DPAzS0hSBTxKBZhiGilPi');
define('LOGGED_IN_SALT',   'LQO%n9X*UrLgSGfw6JN(yIH1GXC4blMehQX^JXp%d7YJnlgrZNNbvxpz2OCiyzgS');
define('NONCE_SALT',       'dKrfxO00da^K4wy8f^RmgaDPNDae1Jx4uIC8D)LFc4(FV3T7XN2!hoFx&)PgZWPf');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'kWO068_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define( 'WP_ALLOW_MULTISITE', true );

define ('FS_METHOD', 'direct');
?>