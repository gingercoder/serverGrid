<?php

/*
 * CORE SYSTEM LAUNCH FILE
 * Primary Help Page
 */
if($_SESSION['username'] !=""){
    require_once('web/servergrid/core/navigation.php');
    require_once('web/core/help/index.php');
}
else{
    require_once('web/core/login/index.php');
}
?>
