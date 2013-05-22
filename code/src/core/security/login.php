<?php

/*
 * Log In Screen
 */

if($c == "login"){
    // If submission of login form has occurred:
    $usrname = $_POST['uname'];
    $passwrd = $_POST['pword'];
    // Verify authentication with the system
    $authstate = $ObjAuth->doauth($usrname, $passwrd, $myApp['passwordSeed']);
    // Verify the state the system returns with
    // if error message sent display errors
    if($authstate == "ok")
    {
        // Authenticated okay
        require_once('src/core/system/homepage.php');
    }
    elseif($authstate == "toomany"){
        // Auto-Back-off Firewall
        $errors = "Too many failed attempts - Account Locked for 5 minutes";
        require_once('web/core/login/index.php');
    }
    else{
        // Failure to authenticate so display information
        $errors = "Invalid username or Password";
        require_once('web/core/login/index.php');
    }
}
else{
    // First hit of the log in screen
    require_once('web/core/login/index.php');
}
?>
