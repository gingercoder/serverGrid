<?php

/*
 * Default Homepage
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
            </ul>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12 centerinfo">
            <img src="/web/img/logo_300px_gray.png" alt="ServerGrid" />
        </div>
    </div>
    <?php
    // Response Messages
    if($responseMsg !=""){
        echo"<div class=\"row-fluid\">
            <div class=\"span12 updatediv\">
            <h3>System update:</h3>
            <span class=\"alert alert-info\">
            <i class=\"icon-comment\"></i> ".$responseMsg."
            </span>
            <br/>
            </div>
        </div>
        <div class=\"row-fluid clearfix\"><br/></div>";

    }
    ?>
    <div class="row-fluid">
        <div class="span4">

            <h2>
                ServerGrid
            </h2>
            <p>
                Welcome online to ServerGrid monitoring system, <?php echo $_SESSION['username']; ?>.
            </p>
            <p>
                Add your servers to your grid, then copy the generated file to your system. Use the cron job ServerGrid creates for you
                to add monitoring to your systems. It's as simple as that - no mess, no fuss, no additional user accounts, no supplementary
                third-party background-programs to lurk in your memory space!
            </p>
        </div>

        <div class="span4">
            <h2>My ServerGrid Stack</h2>
            <div class="accordion" id="accordion-262915">

                <?php
                $firstone = 1;
                foreach($serverList as $server){

                    echo "
                        <div class=\"accordion-group\">";
                        if($ObjSG->checkServerState($server['serverid']) !=""){
                            echo"<div class=\"accordion-heading warningheading\">";
                        }
                    else{
                        echo"<div class=\"accordion-heading\">";
                    }
                    echo "<a class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#accordion-262915\" href=\"#accordion-element-".$server['serverIdent']."\"><i class=\"icon-hdd icon-white\"></i> ".$server['serverName'];
                        // If there is an ip address tagged, display it for the server
                        if($server['ipaddress']){
                            echo " [ ".$server['ipaddress']." ]";
                        }
                    echo "</a></div>";

                    if($firstone == 1){
                        echo "<div id=\"accordion-element-".$server['serverIdent']."\" class=\"accordion-body collapse in\">";
                        $firstone = 0;
                    }
                    else{
                        echo "<div id=\"accordion-element-".$server['serverIdent']."\" class=\"accordion-body collapse\">";
                    }
                    echo " <div class=\"accordion-inner\">
                                    <h3>Server Settings</h3>
                                    <p>
                                        IDENT: ".$server['serverIdent']."<br/>
                                        OS: ".$server['serverOS']."<br/>
                                        DateCreated: ".$server['dateCreated']."<br/>
                                        Free Memory: ".$ObjSG->getFreeMem($server['serverid'])."<br/>
                                        Load Average: ".$ObjSG->getLoadAverage($server['serverid'])."
                                    </p>
                                    <p>
                                    <a href=\"/index.php/servergrid/virtualrack/display/".$server['serverIdent']."\" class=\"btn btn-primary\"><i class=\"icon-eye-open icon-white\"></i> View</a>
                                    <a href=\"/index.php/servergrid/myservers/edit/".$server['serverIdent']."\" class=\"btn btn-inverse\"><i class=\"icon-pencil icon-white\"></i> Edit</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        ";
                }
                ?>

            </div>
        </div>

        <div class="span4">
            <h2>
                Alerts
            </h2>
            <?php
                $numberOfAlerts = 0;
                foreach($serverList as $server){
                    $serverAlert = $ObjSG->checkServerState($server['serverid']);
                    if($serverAlert){
                        echo $serverAlert;
                        $numberOfAlerts++;
                    }

                    $checkip = $ObjSG->checkForIPAddressChange($server['serverid']);
                    if($checkip !=""){
                        echo $checkip;
                        $numberOfAlerts++;
                    }
                }
                if($numberOfAlerts>0){
                    if($numberOfAlerts>1){
                        echo "<span class=\"label label-warning\"><i class=\"icon-warning-sign\"></i> There are ".$numberOfAlerts." alerts requiring your attention</span>";
                    }
                    else{
                        echo "<span class=\"label label-warning\"><i class=\"icon-warning-sign\"></i> There is ".$numberOfAlerts." alert requiring your attention</span>";
                    }
                }
                else{
                    echo "<span class=\"label label-info\"><i class=\"icon-ok\"></i> There are no alerts requiring attention</span>";
                }
            ?>
        </div>

    </div>
</div>
