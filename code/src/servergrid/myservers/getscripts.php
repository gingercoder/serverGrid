<?php
/*
 *
 * Generate scripts for your particular server
 *
 */




if($_SESSION['username'] !=""){

    require_once('web/servergrid/core/navigation.php');

    if($_POST['action']=="create"){
        // Save the entry to the system
        $myscript = $ObjSG->createServerCode($ObjSG->serverIdentToID($_POST['serverid']), $_POST['frequency']);
        if($myscript != false){
            $responseMsg = $myscript;
        }
        else{
            $responseMsg = "Generating your code failed for some reason - please try again";
        }
    }
    else{
        $serverList = $ObjSG->getServerList($ObjFramework->usernametoid($_SESSION['username']));
    }
    require_once('web/servergrid/myservers/getscripts.php');
}
else{
    require_once('web/core/login/index.php');
}

?>
