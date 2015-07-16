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
                    <a href="/index.php/servergrid/virtualrack/overview/">Virtual Rack</a> <span class="divider">/</span>
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
                <a href="/index.php/servergrid/myservers/edit/<?php echo $serverInfo['serverIdent'];?>" class="btn btn-primary"><i class="icon-pencil icon-white"></i> Edit Server</a>
            </p>
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
            <p>
                IP Address:
                <?php echo $serverInfo['ipaddress']; ?>
            </p>
            <?php
                echo $ObjSG->checkForIPAddressChange($serverInfo['serverid']);
            ?>
            <?php
                if($serverInfo['ipaddress']){
                    // if ip address exists, try and do an AJAX call to check the time on a click event
                    echo "<button name=\"clickForPing\" id=\"clickForPing\" class=\"btn btn-success\" type=\"submit\"><i class=\"icon-refresh icon-white\"></i> Check Port 80 response</button>";
                    echo "<br/><span id=\"clickForPingResult\"></span>";
                }
            else{
                echo "No IP set, can't try a ping";
            }

            ?>
            <p align="center">
                <div class="graphbox">
                    <div id="freespace_graph_div"></div>
                </div>
            </p>
        </div>

        <div class="span8">
            <h3>CPU load - last 24 hours</h3>
            <?php

            echo "<p><div class=\"graphbox\">
                  <div id=\"graph".$serverInfo['serverid']."\"><div class=\"preload\"><div class=\"placeholder\"><img src=\"/web/img/serverGridStackAnimationSmall.gif\" alt=\"loading...\" title=\"loading...\" /></div></div></div>
                  </div></p>";
            ?>
            <h3>Free Memory  - last 24 hours</h3>
            <?php
                echo "<p><div class=\"graphbox\">
                <div id=\"graphmem".$serverInfo['serverid']."\"><div class=\"preload\"><div class=\"placeholder\"><img src=\"/web/img/serverGridStackAnimationSmall.gif\" alt=\"loading...\" title=\"loading...\" /></div></div></div>
                </div></p>";
            ?>
        </div>


    </div>
    <div class="row-fluid">
        <div class="span12">
            <h3>System Log - Last 24 hours - Displaying logs <?php echo $start." - ".$next; ?></h3>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <ul class="pager">
                <?php
                if($start>0){
                    ?>
                    <li><a href="/index.php/servergrid/virtualrack/display/<?php echo $d; ?>/<?php echo $previous; ?>">&lt; Previous 30</a></li>
                    <?php
                }
                ?>
                <li><a href="/index.php/servergrid/virtualrack/display/<?php echo $d; ?>/<?php echo $next; ?>">&gt; Next 30</a></li>
            </ul>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">
            <h3>Date</h3>
        </div>
        <div class="span2">
            <h3>IP</h3>
        </div>
        <div class="span2">
            <h3>Free Memory</h3>
        </div>
        <div class="span2">
            <h3>Load Average</h3>
        </div>
        <div class="span2">
            <h3>Kernel</h3>
        </div>
        <div class="span2">
            <h3>Uptime</h3>
        </div>
    </div>
    <?php
    // Display the system log for the last 24 hours
    $serverLog = $ObjSG->getServerStats($ObjSG->usernametoid($_SESSION['username']), $ObjSG->serverIdentToID($d), $start, 30);
    foreach($serverLog as $log){
    ?>
        <div class="row-fluid">
            <div class="span2">
                <?php
                    echo $log['dateCreated'];
                ?>
            </div>
            <div class="span2">
                <?php
                    echo $log['ipaddress'];
                    if($log['ipaddress'] != $serverInfo['ipaddress']){
                        echo "<span class=\"badge badge-warning\"><i class=\"icon-warning-sign icon-white\" title=\"IP Address doesn't match stored address\"> </i></span>";
                    }
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
            <div class="span2">
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
