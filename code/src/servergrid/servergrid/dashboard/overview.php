<?php

/*
 * PRIMARY DASHBOARD
 * Main display
 */
if($_SESSION['username'] !=""){

    require_once('web/servergrid/core/navigation.php');

    // Get server stats
    $serverList = $ObjSG->getServerList($ObjFramework->usernametoid($_SESSION['username']));


    require_once('web/servergrid/dashboard/overview.php');
}
else{
    require_once('web/core/login/index.php');
}
?>
