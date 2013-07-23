<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'lamarbosDByktzh');

/** MySQL database username */
define('DB_USER', 'lamarbosDByktzh');

/** MySQL database password */
define('DB_PASSWORD', 'Qks06ENTbk');

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
define('AUTH_KEY',         't;9Sl+;D1Lal5Dpta.;9Pa6HX.;6m+<6LXm+<6Mbq*Eu.IUju,3Ibr3>BUncv>7');
define('SECURE_AUTH_KEY',  'T$.AUMfXq<$3{EbQMFYvj^3}J7Unf$r>B3QJcUr,@0>BYQkcz},80NgYr}J8Vo!4');
define('LOGGED_IN_KEY',    'Mr,7QJcvj@0>BUngzr,70,8RJczo!4}FZRk!w[G4Ngzo|8:GdRo!-:G4OhZs|8OGV');
define('NONCE_KEY',        'j{^3QIbUn,y>BYMjcv},70JgYrj^4}F7UNg@r>!4RFcUo|@0>FYRoczs|C0NFcwo');
define('AUTH_SALT',        '@FYrg@0>C4Rkcvo|80NCZRk!w:G8VNgZs[!4:GdVoh-1|CVOlZw[_5:KdVph-1#ph');
define('SECURE_AUTH_SALT', 'VSwl_D-51O#xL1iW;*Wpe6]ePiA]iX]+PAu<xLAyi6<bM$mAE{fqb$Q7yj3^QYFy');
define('LOGGED_IN_SALT',   'FvFN0Bnvc>4@,4@|RcFNzgo8F[0gJR![szJ}4ksV|:wowdk4~|VdGw~lsC|1dlS~[');
define('NONCE_SALT',       'r7}Fz,rB>ckV|r@N4CsZg0z|VCs@k4CVgN@owG:4kRZ[wGO5lsZS9Gw~l1D#5H:ah');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);define('FS_METHOD', 'direct');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
