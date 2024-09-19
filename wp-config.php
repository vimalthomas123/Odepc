<?php
# BEGIN WP Cache by 10Web
define( 'WP_CACHE', true );
define( 'TWO_PLUGIN_DIR_CACHE', '/home3/pixelflames/public_html/website_b042b001/wp-content/plugins/tenweb-speed-optimizer/' );
# END WP Cache by 10Web
// Begin AIOWPSEC Firewall
if (file_exists('/home3/pixelflames/public_html/website_b042b001/aios-bootstrap.php')) {
	include_once('/home3/pixelflames/public_html/website_b042b001/aios-bootstrap.php');
}
// End AIOWPSEC Firewall






//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
//@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL cookie settings
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
define( 'DB_NAME', 'pixelfla_stagingodepc' );

/** MySQL database username */
define( 'DB_USER', 'pixelfla_stagingodepcuser' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Sljsyz3e0}Se' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost:3306' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'S0uNQM%62S{C9c!?jFNo+6ZL1sgH KFj]&a>etPM7i@=g,12#z@<PY5:wsZ[QjRO' );
define( 'SECURE_AUTH_KEY',  '{bk#:Wb(w!Bl.y(q6nB*D)P&~DjTl(l6T N+^D5;7?}nH&p!DeP_dDt`!A7.CaCb' );
define( 'LOGGED_IN_KEY',    'I,O+`?dvz2 b@0W=O-?Z(O`inQ}0i[-oSyg_Wjd_f6-)%mx:J^74}-ny4~kp+U>4' );
define( 'NONCE_KEY',        'Mybl(Uj(b(IspZ[lJAmz/N0y>t,p,/3P+A2f:k0+y_xnu.:rrrL1oH_3CHOh1JeN' );
define( 'AUTH_SALT',        'V*zrdo3#0M,lLR{5PgyZXT3uZ|cweJ#]yGb+c/+sZsu<&^z0yTjw3z^Rx_YFvR%+' );
define( 'SECURE_AUTH_SALT', '})biM8LmRj^kZ@-:>>!Ze0h/VRGV&[4Rb{*@PT{}RHG*LH1=laB<a^EUbS*tD^(o' );
define( 'LOGGED_IN_SALT',   'CXVm=O%{.n]O61ld!]~vvPPhiJX3.v|&E/@/.s,_Rk=``C u} <(,w5TFN6WU$y@' );
define( 'NONCE_SALT',       '+JQmF_pA0k0dXdEesa a<^7M0<:6%tSK61s}XuNVVz4KgQ@~O6Lay^1v?H`yKUrk' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'od_';

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
define( 'WP_DEBUG', false );

// define('ALLOW_UNFILTERED_UPLOADS', true);
//define('FORCE_SSL_ADMIN', true);

define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

define( 'AUTOSAVE_INTERVAL', 300 );
define( 'WP_POST_REVISIONS', 5 );
define( 'EMPTY_TRASH_DAYS', 7 );
define( 'WP_CRON_LOCK_TIMEOUT', 120 );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

// db
define('WP_ALLOW_REPAIR', false);

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );//Disable File Edits
define('DISALLOW_FILE_EDIT', true);