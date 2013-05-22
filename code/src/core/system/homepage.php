<?php

/*
 * CORE SYSTEM LAUNCH FILE
 * Primary Home Page
 */
if($_SESSION['username'] !=""){

    require_once('web/servergrid/core/navigation.php');

    $serverList = $ObjSG->getServerList($ObjFramework->usernametoid($_SESSION['username']));

    require_once('web/core/homepage.php');
}
else{
    require_once('web/core/login/index.php');
}
?>
