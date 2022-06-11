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
define('DB_NAME', 'demopane_teamfight');

/** MySQL database username */
define('DB_USER', 'demopane_teamfig');

/** MySQL database password */
define('DB_PASSWORD', 'v?%CT10e7F?X');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'V47D%tn@Q/(b ty>dakBPhHv8WaJsD#kcfX$</)1Do5J<A>9|]B8uqsdOX+eClK>');
define('SECURE_AUTH_KEY',  '2d,N3)Ej(hHy`E$[e9RJ,zRSR;bEzry@xq/iLP%wM7w/<z&QI/eLk,xh8*5N/S Y');
define('LOGGED_IN_KEY',    'w{J[5BN<~ohoN&##8k[Hl~L%|`NPzN)A9F;N95#>s%#]OAS4)aj7H!(OPt]/f=2m');
define('NONCE_KEY',        'a:1 C1#JHhq5,=$N7=(9.M1@>3pPzQRKJr5s]$D}Lk4v{7hUr#gv8(omoj]=NS^@');
define('AUTH_SALT',        '|aW:]el*>04OD>l4}Y_<=ZpJ`:hw]J/Yr?uqEWNjj(<LqQGDLWyVg?T%^Xb`RUOb');
define('SECURE_AUTH_SALT', ',GdW}l4oOJLQBCqDgD9O}ku9w=5XD:Esk*h}o>H_.6zO&#80kzkjy34+(Mlbe,8z');
define('LOGGED_IN_SALT',   'WWhLZ8?e7).mx5fn=9nu{3Ffpu4jQ8ua+QoGsvb<k$DNC*x]9JtwUymGF:H0cHge');
define('NONCE_SALT',       '=-Y7,xcNUo@xf,xlm;_gD2gn[96:PP>](x|$.dLz,!e.;mrt#2]QGzV9Mwbqh-6L');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
