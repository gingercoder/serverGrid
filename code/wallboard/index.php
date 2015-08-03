<?php

/*
* Wallboard display
* Used for monitoring the status of all systems
*
* !! WARNING !!
* Experimental internal network wallboard system
* Not for use on external-facing networks
*/


    // Include the database classes
    require_once('../src/core/database/mysql.php');
    require_once('../src/core/database/settings.php');

    // Create the required objects
    require_once('../src/core/controller/microframework.php');
    $ObjFramework = new MicroFramework();

    require_once('../src/servergrid/controller/servergrid.php');
    $ObjSG = new serverGrid();

    // Load the application settings from the database
    require_once('../src/core/settings/loadAppSettings.php');


    $teamCityServer = "TC_SERVER_NAME";     // <--------------------- Change this to the server name or ip of your TC Server
    $userAccountToUse = "sysadmin";         // <--------------------- Change this to the primary account holder you want to monitor using

?>


<!DOCTYPE html>
<html>
    <head>

        <title><?php echo $myApp['appTitle']; ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" value="index,follow" />
        <meta name="description" value="<?php echo $myApp['appDescription']; ?>" />
        <!-- Twitter Bootstrap -->
        <link href="/web/css/bootstrap.css" rel="stylesheet">
        <link href="/web/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="/web/css/core.css" rel="stylesheet">
        <link href="/web/css/wallboard.css" rel="stylesheet">

        <meta http-equiv="refresh" content="120">

        <link rel="icon" type="image/ico" href="/web/img/favicon.ico">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>

      <?php
      // If wallboard system has been switched on:
      if($myApp['wallboard'] == "on")
      {

      $userid = $ObjFramework->usernametoid($userAccountToUse);
      $serverList = $ObjSG->getServerList($userid);
      $numberOfServers = $ObjSG->getNumberOfServers($userid) - 1;

      // TeamCity Integration
      $statusFile = file_get_contents("http://".$teamCityServer."/externalStatus.html");
      $numberFailures = 0;
      $numberFailures = substr_count($statusFile, 'buildFailed.png');
      $numberFailures += substr_count($statusFile, 'error.png');
      ?>

      <div class="container-fluid">
        <div class="row-fluid">
          <div class="span12">
            <center><img src="/web/img/logo_300px_gray.png" alt="ServerGrid" /></center>
          </div>
        </div>
        <div class="row-fluid">

          <div class="span4">
            <h4>Continuous Integration System</h4>
            <div class="<?php if($numberFailures>0){ echo "warningDiv";}else{ echo "okdiv";}?>">
              <?php
                // Remove the successful icons
                $statusFile = str_replace("<img class=\"buildTypeIcon\" src=\"http://".$teamCityServer.":80/img/buildStates/success.png\" style=\"\" title='Build configuration is successful' alt='Build configuration is successful' />","",$statusFile);
                // Remove and replace the failure icons
                $statusFile = str_replace("<img src=\"http://".$teamCityServer.":80/img/buildStates/buildFailed.png\" id=\"\" class=\"icon buildDataIcon\"  title='' alt='' />","<i class=\"glyphicon glyphicon-white glyphicon-danger\"></i> ", $statusFile);
                // Strip the investigate failure icon
                $statusFile = str_replace("<img class=\"buildTypeIcon\" src=\"http://".$teamCityServer.":80/img/buildStates/../investigate.png\"","<img class=\"noDisplay\" src=\"/web/img/serverGridStackAnimationSmall.gif\" ",$statusFile);
                // Output the TeamCity status
                echo $statusFile;
              ?>
            </div>
          </div>
          <div class="span6">
            <?php

            foreach($serverList as $server){
                // Display graph output overview
                // Get specific list of info for this server
                $spaceUsed = $ObjSG->getUsedSpace($server['serverid']);
                $serverLog = $ObjSG->getServerStats($userid, $server['serverid'], 0, 1);
                foreach($serverLog as $log)
                {
                  // Work out server uptime
                  $uptimearr = explode(' ', $log['uptime']);
                  $uptime_arr = explode('.',(($uptimearr[0]/60)/60));
                  $uptimeleft = $uptime_arr[0];
                  $uptimeright = ceil(60*($uptime_arr[1]*0.1));
                  if($uptimeleft >=24)
                  {
                    $days = ceil($uptimeleft / 24);
                    $hours = ceil($uptimeleft % 24);
                    $uptimeleft = $days."d ".$hours;
                  }
                  $uptime = $uptimeleft."h ".substr($uptimeright,0,2)."m";

                  $lastUpdated = $log['dateCreated'];
                }
                ?>
                          <h4>
                            <span class="pull-right">
                              <div class="label label-info"><?php echo "Last update: ".$lastUpdated. " - Up ".$uptime;?></div>
                            </span>
                            <?php echo $server['serverName']; ?>
                          </h4>
                          <strong>
                          <?php
                            $loadAverage = $ObjSG->getLoadAverage($server['serverid']);
                            $loadAverageArray = explode(" ",$loadAverage);
                            echo $loadAverageArray[0]." / ".$loadAverageArray[1]." / ".$loadAverageArray[2];
                          ?>
                          </strong>
                        <?php
                        if($spaceUsed < 50){
                        ?>
                        <div class="progress progress-striped">
                        <?php
                        }
                        elseif(($spaceUsed < 80)&&($spaceUsed >=50)){
                          ?>
                          <div class="progress progress-warning progress-striped">
                          <?php
                        }
                        else{
                          ?>
                          <div class="progress progress-danger progress-striped">
                          <?php
                        }
                        ?>
                          <div class="bar"
                               style="width: <?php echo $spaceUsed; ?>%;" title="<?php echo $spaceUsed; ?>% Disk Space Used">
                          </div>
                        </div>
                <?php
            }
            ?>

          </div>
          <div class="span2">

          </div>
        </div>
      </div>
      <!-- Bootstrap and jQuery Includes to reduce loading pauses -->
      <script src="/web/js/jquery-1.9.1.min.js"></script>
      <script src="/web/js/bootstrap.min.js"></script>

      <?php
      }
      else
      {
        require_once('../web/core/security/insufficientrights.php');
      }
        db::disconnect(); // Shut down the DB connection.
      ?>

    </body>
</html>
