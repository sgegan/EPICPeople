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
define('DB_NAME', 'epic1_2015');

/** MySQL database username */
define('DB_USER', 'epic1_10');

/** MySQL database password */
define('DB_PASSWORD', 'hB4Ljd7d');

/** MySQL hostname */
define('DB_HOST', 'db152a.pair.com');

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
define('AUTH_KEY',         '@_/%dj/-/zsw[~Z2AY79^$Js2It:ok3L[6}df,]-o_;#`8LI:a}#G7eQ!-ch_z[ ');
define('SECURE_AUTH_KEY',  'k.[0>PMiIl X5xlQj pa:Id}N@dD<UuT<8vW1*%o ;g7v3W(]fQpV[,D^/!/%{<`');
define('LOGGED_IN_KEY',    '66M]O[@f]{7!.&iWZA:}{b|vMw!MYfU~uR)?JrO3c2R=GOLh_Vc|wSMg|OR{9$*p');
define('NONCE_KEY',        'n49RK;-dJ i[9,x.X4+sCvp)(^QpJ8$+*6C+xN5%Z}iFL12wbfIEEYj/[r)+@%+9');
define('AUTH_SALT',        '.T3gG>l{|}J(nRosRo|D-<>s5M34nVI^^Rp*@GA_E-NyVn+m}5oB/;-IQB]Rl/+`');
define('SECURE_AUTH_SALT', '5{cngb)-`UX9D)40eO|j9-1j`D$LsRIoEwDN`2o=-VmEsE!/XU2OLA[Z|Ku#?E/f');
define('LOGGED_IN_SALT',   'x}*SNL9B><s /n5-OQ[9^-/7:wEwuo-|IQJ)n0D@KiJD9](=F}X4C3F|.|pt-s~Z');
define('NONCE_SALT',       '-2rowpu/Zowz%cCGc4i<|uq/@Z>LkU(XDQ|1|%G5XE_lpV^9TO+Wr&]F%kd`ji=}');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
