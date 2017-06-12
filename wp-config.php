<?php
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
define('DB_NAME', 'connaiss_wp590');

/** MySQL database username */
define('DB_USER', 'connaiss_wp590');

/** MySQL database password */
define('DB_PASSWORD', 'p.Sm4g54[U');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'kq0vm60kkzezpkp91bdpdzhugc9vgqnep1y3rnspdzzfdqfti6mz1yofsxqilg4y');
define('SECURE_AUTH_KEY',  '7ro48hwf1cfhxkzw87rn2skygorhqci5qjl7ymhisex3bo3ef5kc33jpoxerkycv');
define('LOGGED_IN_KEY',    '2wkmmaazjaq1rc8bk6wfusnkt1upnf9tmljd2xtoyk9theu0glfw1fhqhfgjbink');
define('NONCE_KEY',        'zq0cxw1xx7qe3yhdr56npus97ggnkrhfw6y0ivajsblq4vbokc3st8rnxuo3pvyp');
define('AUTH_SALT',        'zhjdz9mvlnldmtpxlu8sewgpxo6k2wqtj4yckduc4oulapmtvvb6c3c3izojoirw');
define('SECURE_AUTH_SALT', 'p984pgfaa1qm6lskkdag3debbr5jm7fydpgb4hnhpukznmaf11xbparmrocb5oya');
define('LOGGED_IN_SALT',   'uewzqzjv8jln39qlrva2esv95dvcmju2cbu3rggay9xwgvzwedztmnmc7hlh4wfe');
define('NONCE_SALT',       '8xhkdtlzondd8mh4ysoqflbzaokjevpzit9hivpvjtr48mjlm38jzwarwkzd3ojd');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpqp_';

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
