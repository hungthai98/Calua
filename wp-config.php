<?php  
 define('WP_SITEURL', 'https://calua.restaurant');  
 define('WP_HOME', 'https://calua.restaurant');  
 
define('WP_AUTO_UPDATE_CORE', 'minor');// This setting is required to make sure that WordPress updates can be properly managed in WordPress Toolkit. Remove this line if this WordPress website is not managed by WordPress Toolkit anymore.

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



// ** MySQL settings ** //

/** The name of the database for WordPress */

define( 'DB_NAME', 'cal51451_sib1do' );


/** MySQL database username */

define( 'DB_USER', 'cal51451_haurvp' );


/** MySQL database password */

define( 'DB_PASSWORD', 'LAHVDQU39@rRTDbZt' );


/** MySQL hostname */

define( 'DB_HOST', 'localhost:3306' );



/** Database Charset to use in creating database tables. */

define( 'DB_CHARSET', 'utf8' );



/** The Database Collate type. Don't change this if in doubt. */

define( 'DB_COLLATE', '' );



/**

 * Authentication Unique Keys and Salts.

 *

 * Change these to different unique phrases!

 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}

 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.

 *

 * @since 2.6.0

 */

define('AUTH_KEY', 'o[CV-L8_~VNS93b*vd_6T8GuG2K_~mXU7[!#;90fN4:d35*5)/VpBv(CCm32b4Vx');

define('SECURE_AUTH_KEY', 't7Q3+E2Lg5*83zlss80R1Je-R@;k1z](jqb7%3:e[kd-U301T(1G6]lL7%E3E/k2');

define('LOGGED_IN_KEY', '7I0Qt43-B6l%d5b(h%u94WQqE7SQ_:RZ[d(aaN-c|75p~&LMO779z]T)t9AG08kV');

define('NONCE_KEY', 'H+n25Rq[mxlFgrs~/8C;;3r51)8f6s/5rRWR3d3l!@1H5O66WcB|1A/!6N[uA6C]');

define('AUTH_SALT', '*_Sde6p(t*t-(+LFW(x:1cV*vJ3+T5sEdznE7%T:/F((@D1Oy~&|SX7(;x8H~~-s');

define('SECURE_AUTH_SALT', '_41B4H5*9~*nd(@rT#R+0a(Bq&Dj-4DHMb[T1)4O6XYdhG%p[YW+4Bs-k9xuD;F9');

define('LOGGED_IN_SALT', 'G65JG57rab4P(%Nu]9(z78BaDS0&%-F;eQ#9[!i8O9KIy3#kU-L61iuf0!6+[R|i');

define('NONCE_SALT', '37;p-6~ME[@AP!GVZZYy&6V%UGY&KvyQlgJL*r+!]tqWZ2b3u+r53H-1TSiD*wuV');



/**

 * WordPress Database Table prefix.

 *

 * You can have multiple installations in one database if you give each

 * a unique prefix. Only numbers, letters, and underscores please!

 */

$table_prefix = 'Wke4y_';





define('WP_ALLOW_MULTISITE', true);



/* That's all, stop editing! Happy blogging. */



/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) )

	define( 'ABSPATH', dirname( __FILE__ ) . '/' );



/** Sets up WordPress vars and included files. */

require_once ABSPATH . 'wp-settings.php';

