<?php
/**
 * Sample configuration file for Anax webroot.
 *
 */ 

/**
 * Define essential Anax paths, end with /
 *
 */
define('ANAX_INSTALL_PATH', realpath(__DIR__ . '/../') . '/');
define('ANAX_APP_PATH',     ANAX_INSTALL_PATH . 'app/');


/**
 * Define db options
 *
 */
define('DB_OPTIONS', ANAX_APP_PATH . 'config/config_mysql.php'); 


/**
 * Include autoloader and database settings.
 *
 */
include(ANAX_APP_PATH . 'config/autoloader.php'); 


/**
 * Include global functions.
 *
 */
include(ANAX_INSTALL_PATH . 'src/functions.php'); 


