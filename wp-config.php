<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'practical' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '):Yp.ct3)hb@YGhNp5ZVt~O*3*SD%4f,/F%23cj%rtfH2gtpci!4(#1GlQgEVP/h' );
define( 'SECURE_AUTH_KEY',  ';GzkG<&]p$}QJVqG2;J2eK@?e,}TD}5_VY}_nq%q.<7F01z{)x5eKbk!el|FDp4N' );
define( 'LOGGED_IN_KEY',    'sf1{?JiSc+)OvhKhMkf;Sboz1]a0ru;$/^fP?t@{_[9MDg*]5@t`?Lev{;NZS@=w' );
define( 'NONCE_KEY',        ',u;o06J?7u1>O+Bj x$^)ANJ-+kTDv&SoDWR)PB#5k,w.t8R<+/>d3k@J:D4&.lU' );
define( 'AUTH_SALT',        'CE.KQy|MK[yciy;,:J9vMLQQZ<}745@wEb:S*[Pf0#7[>DP.49khm+1uk%l5zV7;' );
define( 'SECURE_AUTH_SALT', '<C^i4Vv JskbGPBoqKHp)J^us$w&eGQY<_sXI;f%w@.wg`6>2#F23WrpSBI*Dnuy' );
define( 'LOGGED_IN_SALT',   'zu)^6VY#c~UEr`Vh{C}KK5s2H6/DzE:d)es9ec1ekaaatR?f/B#d[CQ/aJMa#0AO' );
define( 'NONCE_SALT',       'Zlh L+??~UI >q+|Bwi1TRfy# h_l{ Z>c$~PuCbut/[tvIq-:zI$Xo,F )7Xh&h' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
