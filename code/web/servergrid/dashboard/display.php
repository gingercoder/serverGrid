<?php
/*
 * Display Full dashboard information
 */



?>
<br/>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <p>&nbsp;<br/></p></div>
    </div>

    <div class="row-fluid">
        <div class="span12">
            <ul class="breadcrumb">
                <li>
                    <a href="/index.php" class="active">Home</a> <span class="divider">/</span>
                </li>
                <li>
                    <a href="/index.php/servergrid/dashboard/overview/">Dashboard</a> <span class="divider">/</span>
                </li>
                <li class="active">
                    Server Display
                </li>
            </ul>

        </div>
    </div>
    <div class="row-fluid">
        <div class="span12 centerinfo">
            <img src="/web/img/logo_300px_gray.png" alt="ServerGrid" />
        </div>
    </div>
    <div class="row-fluid">
        <div class="span4">

            <h2>
                <?php echo $serverInfo['serverName']; ?>
            </h2>
            <p>
                Running:
                <?php echo $serverInfo['serverOS']; ?>
            </p>
            <p>
                IDENT:
                <?php echo $serverInfo['serverIdent']; ?>
            </p>
            <p>
                Added:
                <?php echo $serverInfo['dateCreated']; ?>
            </p>
        </div>

        <div class="span8">
            <h2>CPU load - last 24 hours</h2>
            <?php

            echo "<p><div class=\"graphbox\">
                  <div id=\"graph".$serverInfo['serverid']."\"></div>
                  </div></p>";
            ?>
            <h2>Memory Free - last 24 hours</h2>
            <?php
                echo "<p><div class=\"graphbox\">
                <div id=\"graphmem".$serverInfo['serverid']."\"></div>
                </div></p>";
            ?>
        </div>


    </div>
    <div class="row-fluid">
        <div class="span12">
            <h2>System Log - Last 24 hours</h2>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3">
            <h3>Date</h3>
        </div>
        <div class="span2">
            <h3>Free Memory</h3>
        </div>
        <div class="span2">
            <h3>Load Average</h3>
        </div>
        <div class="span3">
            <h3>Kernel</h3>
        </div>
        <div class="span2">
            <h3>Uptime</h3>
        </div>
    </div>
    <?php
    // Display the system log for the last 24 hours
    $serverLog = $ObjSG->getServerStats($ObjSG->usernametoid($_SESSION['username']), $d);
    foreach($serverLog as $log){
    ?>
        <div class="row-fluid">
            <div class="span3">
                <?php
                    echo $log['dateCreated'];
                ?>
            </div>
            <div class="span2">
                <?php
                    echo $log['freemem'];
                ?>
            </div>
            <div class="span2">
                <?php
                    echo $log['loadAverage'];
                ?>
            </div>
            <div class="span3">
                <?php
                    echo $log['kernelVersion'];
                ?>
            </div>
            <div class="span2">
                <?php
                $uptimearr = explode(' ', $log['uptime']);
                $uptime_arr = explode('.',(($uptimearr[0]/60)/60));
                $uptimeleft = $uptime_arr[0];
                $uptimeright = ceil(60*($uptime_arr[1]*0.1));
                $uptime = $uptimeleft."h ".substr($uptimeright,0,2)."m";
                echo $uptime;
                ?>
            </div>
        </div>
    <?php
    }
    ?>
</div>

