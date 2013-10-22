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
                    <a href="/index.php/servergrid/dashboard/overview/">Dashboard</a> <span class="divider">/</span>
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

            <h2>
                Dashboard
            </h2>
            <p>
                Your general ServerGrid server activity in the last 24 hours is displayed here.
            </p>
            <p>
                Select a specific server to view more information about the server.
            </p>
        </div>

        <div class="span8">
            <h2>My Server Grid Stats</h2>
                <?php

                foreach($serverList as $server){
                    // Display graph output overview
                    // Get specific list of info for this server
                    ?>
                    <p>
                        <div class="graphbox">
                            <h4><?php echo $server['serverName']; ?></h4>
                            <a href="<?php echo "/index.php/servergrid/dashboard/display/".$server['serverid']; ?>/" class="btn btn-primary">Full Status</a>
                            <div id="graph<?php echo $server['serverid']; ?>">
                                <div class="placeholder">
                                    <img src="/web/img/serverGridStackAnimationSmall.gif" alt="loading..." title="loading..." />
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

