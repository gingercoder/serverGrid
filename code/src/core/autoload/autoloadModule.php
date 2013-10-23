<?php

/*
 * 
 * Automagic module loader and URL request grabber
 * 
 */


// CORE LOAD MECHANISMS --->
require_once('src/core/controller/microframework.php');
$ObjFramework = new MicroFramework();
require_once('src/core/security/authentication.php');
$ObjAuth = new authentication();
require_once('src/servergrid/controller/servergrid.php');
$ObjSG = new serverGrid();

// INCLUDE YOUR CUSTOM APP LOAD MECHANISMS HERE


// <--- END LOAD MECHANISMS


// Run an authentication maintain check
$authcheck = $ObjAuth->maintainauth();

if($_POST['x'] !=""){
    // posting values to a specific function
    $a = db::escapechars(trim($_POST['x'])); // module
    $b = db::escapechars(trim($_POST['y'])); // function
    $c = db::escapechars(trim($_POST['z'])); // file
}
else{
    // Split the URL into the load functions and possible variable entitiesq
    $urlVars = explode("/", $_SERVER['REQUEST_URI']);
    $a = db::escapechars(trim($urlVars[2])); // module
    $b = db::escapechars(trim($urlVars[3])); // function
    $c = db::escapechars(trim($urlVars[4])); // file
    $d = db::escapechars(trim($urlVars[5])); // var1
    $e = db::escapechars(trim($urlVars[6])); // var2 
}

    // Pull the page head in
    require_once('web/core/head.php');
        
    // If no default file to launch then just fire up the login screen
    if(($a !="")){
        // Construct the file path and name
        $fileToLoad = 'src/'.$a;
        if($b !=""){
                $fileToLoad .= '/'.$b;
        }
        if($c !=""){
                $fileToLoad .= '/'.$c;
        }
        $fileToLoad .= '.php';
    }
    else{
        if($authcheck == 'auth'){
            $fileToLoad = 'src/core/system/homepage.php';
        }
        else{
            $fileToLoad = 'src/core/security/login.php';
        }
    }

if(file_exists($fileToLoad)){
    // Load module
    require_once($fileToLoad);
}
else{
    // Module does not exist - warn user
    require_once('web/core/security/nomodule.php');
}

    // Pull the Footer in
    require_once('web/core/foot.php');

?>
