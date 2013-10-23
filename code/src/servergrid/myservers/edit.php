<?php
/*
 *  Edit a server
 *
 */


if($_SESSION['username'] !=""){

    require_once('web/servergrid/core/navigation.php');

    if($_POST['action']=="save"){
        // Save the entry to the system
        $editserver = $ObjSG->editServer($_POST['serverid'], $ObjFramework->usernametoid($_SESSION['username']),$_POST['serverName'], $_POST['serveros'], $_POST['ipaddress']);
        if($editserver == true){
            $responseMsg = "Your server changes have been saved to the system and it is available to view now.";
        }
        else{
            $responseMsg = "Adding your server failed - please try again";
        }
        $serverList = $ObjSG->getServerList($ObjFramework->usernametoid($_SESSION['username']));
        require_once('web/core/homepage.php');
    }
    elseif(($_POST['action'] =="edit")||($d)){
        // edit the information
        if($_POST['serverid']){
            $thisServer = $ObjSG->getServerInfo($_POST['serverid']);
        }
        else{
            $thisServer = $ObjSG->getServerInfo($d);
        }
        require_once('web/servergrid/myservers/edit.php');
    }
    else{
        // select the server
        $serverList = $ObjSG->getServerList($ObjFramework->usernametoid($_SESSION['username']));
        require_once('web/servergrid/myservers/edit.php');
    }
}
else{
    require_once('web/core/login/index.php');
}

?>