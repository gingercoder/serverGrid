<?php

/*
 * Check where signing in from to maintain a list of approved and denied items
 */


$myIP = $_SERVER['REMOTE_ADDR'];

$allowedRange = array(
                        '127.0.0.1', 
                        '::1', 
                        '192.168.1.1'
                    );

$foundip = 0;

if($myApp['firewall'] == "on"){
    foreach($allowedRange as $okip){
        if($okip == $allowedRange){
            $foundip = 1;
        }
    }
    if($foundip == 0){
        require_once ('web/core/security/ipviolation.php');
        die();
    }
}
?>
