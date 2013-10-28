<?php

/*
*
*   _____                           _____      _     _
*  / ____|                         / ____|    (_)   | |
* | (___   ___ _ ____   _____ _ __| |  __ _ __ _  __| |
*  \___ \ / _ \ '__\ \ / / _ \ '__| | |_ | '__| |/ _` |
*  ____) |  __/ |   \ V /  __/ |  | |__| | |  | | (_| |
* |_____/ \___|_|    \_/ \___|_|   \_____|_|  |_|\__,_|
*
* ServerGrid API control mechanisms
* Update the ServerGrid system with new information
*/

if($_POST['ident']!=""){

    // Include the database classes
    require_once('../src/core/database/mysql.php');
    require_once('../src/core/database/settings.php');

    // Include the API
    require_once('serverGridAPI.php');
    $ObjAPI = new serverGridAPI();
    // Run the function if you can get the serverid
    $serverid = $ObjAPI->doauth(urldecode($_POST['userid']), urldecode($_POST['ident']));
    if($serverid !=""){
            // Authentication successful - operate the task
            $updateSG = $ObjAPI->updateMyServer($serverid, urldecode($_POST['userid']), urldecode($_POST['memfree']), urldecode($_POST['hostname']), urldecode($_POST['version']), urldecode($_POST['uptime']), urldecode($_POST['loadavg']), urldecode($_POST['ipaddress']), urldecode($_POST['spacefree']));
            if($updateSG == true){
                echo "Updated";
                exit();
            }
            else{
                echo "Error saving";
                exit();
            }
    }
    else{
        echo "SERVER ID INVALID";
        exit();
    }

}
else{
    echo "Invalid IDENT";
    exit();
}

?>