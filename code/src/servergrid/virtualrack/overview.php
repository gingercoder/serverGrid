<?php

/*
 * PRIMARY DASHBOARD
 * Main display
 */
if($_SESSION['username'] !=""){

    require_once('web/servergrid/core/navigation.php');

    if(($d != "")&&(($e == "up")||($e == "down")))
    {
      $movePosition = $ObjSG->moveServerPosition($d,$e);
      if($movePosition != false)
      {
        $responseMsg = "Your server position has been moved";
      }
      else{
        $responseMsg = "Your server position could not be moved at this time, please try again.";
      }
    }


    // Get server stats
    $userid = $ObjFramework->usernametoid($_SESSION['username']);
    $serverList = $ObjSG->getServerList($userid);
    $numberOfServers = $ObjSG->getNumberOfServers($userid) - 1;


    require_once('web/servergrid/virtualrack/overview.php');
}
else{
    require_once('web/core/login/index.php');
}
?>
