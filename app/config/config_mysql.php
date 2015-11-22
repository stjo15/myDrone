<?php

// Settings for private server



// Settings for BTH server

define('DB_USER', 'yourUsername');
define('DB_PASSWORD', 'yourPassword'); 

return [
    // Set up details on how to connect to the database
    'dsn'     => "mysql:host=yourHost;dbname=yourDatabaseName;",
    'username'        => DB_USER,
    'password'        => DB_PASSWORD,
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    'table_prefix'    => "drone_",

    // Display details on what happens
    'verbose' => false,

    // Throw a more verbose exception when failing to connect
    'debug_connect' => 'false',
];

