<?php
/*
 * Display full dashboard information.
 */
if($_SESSION['username'] !=""){

    require_once('web/servergrid/core/navigation.php');

    // Get server stats
    $serverInfo = $ObjSG->getServerInfo($d);


    require_once('web/servergrid/dashboard/display.php');
}
else{
    require_once('web/core/login/index.php');
}

?>