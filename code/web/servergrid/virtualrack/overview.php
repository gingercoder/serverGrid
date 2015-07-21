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
                <li>
                    <a href="/index.php/servergrid/virtualrack/overview/">Virtual Rack</a> <span class="divider">/</span>
                </li>
                <li class="active">
                    Overview
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
            ".$responseMsg."
            </div>
        </div>";

    }
    ?>
    <div class="row-fluid">
        <div class="span4">
          <br/>
          <div class="well well-large darktext">
            <h2>
                Virtual Rack
            </h2>
            <p>
                Your general ServerGrid server activity in the last 24 hours is displayed here.
            </p>
            <p>
                Select a specific server to view more information about the server.
            </p>
            <p>
                Not seeing information from your server? Perhaps your cron job has failed or
                there is an issue with your network connection from your box.
            </p>
          </div>
        </div>

        <div class="span8">
            <h2>ServerGrid Virtual Rack</h2>
                <?php

                foreach($serverList as $server){
                    // Display graph output overview
                    // Get specific list of info for this server
                    $spaceUsed = $ObjSG->getUsedSpace($server['serverid']);
                    ?>
                    <p>
                        <div class="graphbox">
                              <div class="pull-right">
                                <?php
                                if($server['rackposition'] > 0){
                                  ?>
                                  <a href="/index.php/servergrid/virtualrack/overview/<?php echo $server['serverIdent'];?>/up/"><i class="icon-white icon-hand-up"></i></a>
                                  <?php
                                }
                                if($server['rackposition'] < $numberOfServers){
                                  ?>
                                  <a href="/index.php/servergrid/virtualrack/overview/<?php echo $server['serverIdent'];?>/down/"><i class="icon-white icon-hand-down"></i></a>
                                  <?php
                                }
                                ?>
                              </div>
                              <h4><?php echo $server['serverName']; ?></h4>
                            <a href="<?php echo "/index.php/servergrid/virtualrack/display/".$server['serverIdent']; ?>/" class="btn btn-primary"><i class="icon-eye-open icon-white"></i> View System</a>
                            <div id="graph<?php echo $server['serverid']; ?>">
                                <div class="placeholder">
                                    <img src="/web/img/serverGridStackAnimationSmall.gif" alt="loading..." title="loading..." />
                                </div>
                            </div>
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
                        </div>
                    </p>
                    <?php
                }
                ?>
        </div>


    </div>
</div>
