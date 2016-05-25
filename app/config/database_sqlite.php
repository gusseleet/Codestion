<?php

if($_SERVER['HTTP_HOST'] == 'localhost:8080')
return [
    // Set up details on how to connect to the database
    'dsn'     => "mysql:host=localhost;dbname=phpmvc;",
    'username'        => "root",
    'password'        => "",
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    'table_prefix'    => "test_",

    // Display details on what happens
    'verbose' => true,

    //Throw a more verbose exception when failing to connect
    'debug_connect' => 'true',
];
else if($_SERVER['HTTP_HOST'] == 'localhost') {
    return [


    // Set up details on how to connect to the database
    'dsn'     => "mysql:host=192.168.1.64;dbname=phpmvc;",
    'username'        => "gel",
    'password'        => "1234",
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    'table_prefix'    => "test_",

    // Display details on what happens
    'verbose' => true,

    //Throw a more verbose exception when failing to connect
    'debug_connect' => 'true',



    ];


}

else {

    define('DB_USER', 'guel12');
    define('DB_PASSWORD',  'Bw6vs7(J');

    return [
        // Set up details on how to connect to the database
        'dsn'             => 'mysql:host=blu-ray.student.bth.se;dbname=guel12',
        'username'        => DB_USER,
        'password'        => DB_PASSWORD,
        'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
        'table_prefix'    => "phpmvc_kmom04_",

        // Display details on what happens
        'verbose' => false,

        //Throw a more verbose exception when failing to connect
        'debug_connect' => 'false',



    ];

}
