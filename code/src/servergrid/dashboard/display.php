<?php
/*
 * Display full dashboard information.
 */
if($_SESSION['username'] !=""){

    require_once('web/servergrid/core/navigation.php');

    // Get server stats
    $serverInfo = $ObjSG->getServerInfo($d);

    if($e){
        $start = (int)$e;
        if($start > 30){
            $previous = $start - 30;
        }
        else{
            $previous = 0;
        }
        $next = $start + 30;
    }
    else{
        $start = 0;
        $previous = 0;
        $next = 30;
    }
    $limit = 30;
    require_once('web/servergrid/dashboard/display.php');
}
else{
    require_once('web/core/login/index.php');
}

?>