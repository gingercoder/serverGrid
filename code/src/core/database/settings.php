<?php

/*
 * Database settings - what method to use, connection details and core settings
 */

// DB SETTINGS
$dbuser = 'root';
$dbhost = 'localhost';
$dbpass = '';
$dbname = 'servergrid';

// LAUNCH CONNECTION
db::dbconnect($dbhost, $dbuser, $dbpass, $dbname);

?>
