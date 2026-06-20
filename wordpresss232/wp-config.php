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
define( 'DB_NAME', 'wpbaza' );

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
define( 'AUTH_KEY',         'j<||.ymD3}b*dA)t~Mp?WZ>,|2^SaK;UH b{,A/4Q.~@CN,/Z2+>Mqyc`<dWc6Wc' );
define( 'SECURE_AUTH_KEY',  '|:tk6!NV%PRD8N,Z@M6*{IGk8csnUeg?,Q0aa~o$i0kU}C[X8(aG>t.S(oUB_s^)' );
define( 'LOGGED_IN_KEY',    'Y<W^~8MB$AN;S5;yjsQSV$M^D@-iQ8<sYwVV% NGmN^:u-K*nbL|Y/o a4sqRmy6' );
define( 'NONCE_KEY',        'YyMWhQcSx=*|p{7~OJHMfHo{di0u:&CQO3GNrA&}]o9@.~L.r/F?Q9)kHkRBsl5*' );
define( 'AUTH_SALT',        'n%8!9X5cvek3:Q?uz4@D{b]!ph1v_GX4LkNVa=DJ-CCX)/lc[e:{[!JJeF/v1^MZ' );
define( 'SECURE_AUTH_SALT', ';T@h7g+~JsMn|9KnH`Wt1@npBjJru#9O$}$PVHfHy1h-!xu2X:LZHBq:zmTM2aJ3' );
define( 'LOGGED_IN_SALT',   '&x5BoSa_Me^9s*G>p(RxBTOdF`/%7YD>dMe4xY4A:|~~ob4QTJfaP0wZI6p+4E<n' );
define( 'NONCE_SALT',       'b2EJG9X#?1vBR-wU3.+3@J;-0mQT(;u/aGH?I&JUnN*9-@$!ovZui3j>93#YXY`<' );

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
