<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         '3F~ArE`:TSQAU[u]s;oc*O}MAM+nPuj=Tv>gCqW|%Tosxe):mR17X{Y*Nig_&!O%' );
define( 'SECURE_AUTH_KEY',  '*P)9O<j*[jrn1Y2DT2h%C5ZJ39xE^J4ePQ9;<q?p{=YXx9=aX^VaKI0:y!a|JD`u' );
define( 'LOGGED_IN_KEY',    '&ywh{eLMyiPCw~/(:I+|t%I5P5H!r[Z%S`j#][z*_>t)rWNKtl(^hi(}+8uzgX^j' );
define( 'NONCE_KEY',        ';nFg&rFQ2|iA?2ReI[d:Kgu{=3`Z7J,69m$&bHP2C0h4,iu^n2hPjXX)DMIfrG+O' );
define( 'AUTH_SALT',        '; d4Iy%;osJ^sfN&b~^Xn ^5&_9>>y~[vN?JpDP<u~*:J4ud{]Pj([s3d,nU&I6[' );
define( 'SECURE_AUTH_SALT', 'keRYQ8 +K72&9&@C<AyM@+{w>l3cUtI>0}MG}1u;s!.UqzWpMr,Xk7E 2 */sO05' );
define( 'LOGGED_IN_SALT',   '`e&6C,78Ljli_L_R{Q<Rql9B?Wqgldyo&Tb<> B~`#ap6WFuj7J`SO>-3@d-^;)}' );
define( 'NONCE_SALT',       '[;^)dZ%%MJr.@1WDRPP!~&Lap(?FW+gTdc}73|IGj3a/gqPUQ%005iTY2|diLbk ' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
