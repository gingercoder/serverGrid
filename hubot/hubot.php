<?php
/*
* File: hubot.php
* Description:
* HUBOT Response System - provides output from ServerGrid when Hubot requests it
*
* Instructions:
* Install GitHub's Hubot System
* Place THIS file in /api web folder
* Copy the servergrid.coffee script into your scripts folder and restart services
*
*/
require_once('../src/core/database/mysql.php');
require_once('../src/core/database/settings.php');
require_once('../src/core/controller/microframework.php');
$ObjFramework = new MicroFramework();
require_once('../src/servergrid/controller/servergrid.php');
$ObjSG = new serverGrid();

$urlVars = explode("/", $_SERVER['REQUEST_URI']);
$a = db::escapechars(trim($urlVars[3])); // key
$b = db::escapechars(trim($urlVars[4])); // function
$c = db::escapechars(trim($urlVars[5])); // server
$d = db::escapechars(trim($urlVars[6])); // var1
$e = db::escapechars(trim($urlVars[7])); // var2

// !IMPORTANT
// Change this incomming key here and in your coffee script file!
if($a == "CHANGE_THIS_KEY"){

  $returnResponse = "";

  if($b == "ping"){
    $serverList = $ObjSG->getServerList($ObjFramework->usernametoid('sysadmin'));
    foreach($serverList as $server){
      if(($c !="")&&($c== $server['serverName'])){
        $myserverid = $server['serverid'];
        $myipaddress = $ObjSG->getmyipaddress($myserverid);
        $pingtime = $ObjSG->pingServer($myipaddress);
        $returnResponse .= "[ Port 80 for ". $server['serverName']." - ".$pingtime . "ms ] ";
      }
    }
  }

  if($b == "info"){
    $serverid = $ObjSG->getServerID($c);
    $serverInfo = $ObjSG->getServerStatus($serverid);
    $loadAverage = $ObjSG->getLoadAverage($serverid);
    $loadAverageArray = explode(" ",$loadAverage);
    $diskuse = $ObjSG->getUsedSpace($serverid);
    $returnResponse = "Server " . $c . " is on IP Address " . $serverInfo['ipaddress'] . " , has a load average of ".$loadAverageArray[0]." ".$loadAverageArray[1]." ".$loadAverageArray[2]." and is using ".$diskuse."% disk";
  }

  if($b == "load"){
    $serverid = $ObjSG->getServerID($c);
    $loadAverage = $ObjSG->getLoadAverage($serverid);
    $loadAverageArray = explode(" ",$loadAverage);
    $returnResponse = "Server " . db::escapechars($c) . " Load Average: ".$loadAverageArray[0]." ".$loadAverageArray[1]." ".$loadAverageArray[2];
  }

  if($b == "disk"){
    $serverid = $ObjSG->getServerID($c);
    $diskuse= $ObjSG->getUsedSpace($serverid);
    $diskfree = 100 - $diskuse;
    $returnResponse = "Server " . db::escapechars($c) . " has " . $diskfree . "% disk space free";
  }

  if($b == "list"){
    $servers = $ObjSG->getServerList($ObjSG->usernametoid('sysadmin'));
    foreach($servers as $server){
      $returnResponse .= "[ " . $server['serverName']." ] ";
    }
  }
  echo $returnResponse;
}
else{
  die('Could not connect, sorry');
}
