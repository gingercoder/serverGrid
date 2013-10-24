<?php

/*
 * AJAX Call to ping the server in the background
 * so that the page load isn't effected by the
 * length of time it takes to respond
 *
 */

// Include the database classes

require_once('../../src/core/database/mysql.php');
require_once('../../src/core/database/settings.php');
require_once('../../src/core/controller/microframework.php');
$ObjFramework = new MicroFramework();
require_once('../../src/servergrid/controller/servergrid.php');
$ObjSG = new serverGrid();

$myserverid = $_GET['serverid'];


$myipaddress = $ObjSG->getmyipaddress($myserverid);

$pingtime = $ObjSG->pingServer($myipaddress);
if($pingtime != false){
    echo  "<span class=\"label label-info\"><i class=\"icon-globe icon-white\"></i> $pingtime</span>";
}
else{
    echo "<span class=\"label label-warning\"><i class=\"icon-thumbs-down\"></i> No Response</span>";
}
