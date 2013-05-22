<?php

/*
 * Database settings - what method to use, connection details and core settings
 */

// DB TYPE TO LAUNCH - Uncomment to use the specific module (uncomment ONLY ONE)
//require_once('src/core/database/mysql.php');
//require_once('src/core/database/mysqli.php');
//require_once('src/core/database/filesystem.php');

// DB SETTINGS
$dbuser = 'root';
$dbhost = 'localhost';
$dbpass = 'password';
$dbname = 'servergrid';

// LAUNCH CONNECTION
db::dbconnect($dbhost, $dbuser, $dbpass, $dbname);

?>
