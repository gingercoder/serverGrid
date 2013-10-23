<?php
/*
 * Add a server to your own server list
 *
 */

if($_SESSION['username'] !=""){

    require_once('web/servergrid/core/navigation.php');

    if($_POST['action']=="save"){
        // Save the entry to the system
        $addserver = $ObjSG->addServer($ObjFramework->usernametoid($_SESSION['username']),$_POST['serverName'], $_POST['serveros'], $_POST['ipaddress']);
        if($addserver != false){
            $responseMsg = "Your server has been added to the system and is available to view now.<div class=\"servercode\">IDENT: $addserver</div>";
        }
        else{
            $responseMsg = "Adding your server failed - please try again";
        }
        $serverList = $ObjSG->getServerList($ObjFramework->usernametoid($_SESSION['username']));
        require_once('web/core/homepage.php');
    }
    else{
        require_once('web/servergrid/myservers/add.php');
    }
}
else{
    require_once('web/core/login/index.php');
}
?>