<?php
    if($_SESSION['username'] !=""){

        require_once('web/servergrid/core/navigation.php');

        if($_POST['action']=="remove"){
            // Save the entry to the system
            $removeserver = $ObjSG->removeServer($_POST['serverid']);
            if($removeserver == true){
                $responseMsg = "Your server has been removed from the system.";
            }
            else{
                $responseMsg = "Removing your server failed - please try again";
            }


        }
        $serverList = $ObjSG->getServerList($ObjFramework->usernametoid($_SESSION['username']));
        require_once('web/servergrid/myservers/remove.php');
    }
    else{
        require_once('web/core/login/index.php');
    }
?>