<?php
/*
 * Create the scripts for servers
 * Select server and generate correct code
 *
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
                    <a href="/index.php">Home</a> <span class="divider">/</span>
                </li>
                <li>
                    <a href="#">MyGrid</a> <span class="divider">/</span>
                </li>
                <li class="active">
                    Get Scripts
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
                Server Code
            </h2>
            <h3>Create server file</h3>
            <p>
                Select the server you want to create your code file for. Once your file has been generated, copy the PHP code and
                paste it into a new file on your linux box called &quot;serverGrid.php&quot;. Next, copy the cron job script
                and paste it into your crontab file (accessed usually by issuing the <strong>crontab -e</strong> command).
            </p>
            <h3>Debugging</h3>
            <p>
                When your script runs, a file called &quot;serverGridResponse.txt&quot; will be created with a response code that
                can be used to debug connections if your information does not appear in the ServerGrid system after a couple of minutes.
            </p>
            <h3>Requirements</h3>
            <p>
                PHP5 and PHP5-CURL need to be installed on your server in order for the server script to run on your machine.
            </p>
            <p>
                If you're on a Debian/Ubuntu system you can run :<br/>
                <strong>sudo apt-get install php5; sudo apt-get install php5-curl</strong>
            </p>
        </div>

        <div class="span8">
            <?php
             if($_POST['action'] !="create"){
            ?>
            <form name="addserver" action="/index.php" method="post">
                <h2>Generate Code</h2>
                <p>
                    <label>Select Server</label>
                    <select name="serverid" >
                        <?php
                        foreach($serverList as $server){
                            echo "<option value=\"".$server['serverid']."\">".$server['serverName']."</option>";
                        }
                        ?>
                    </select>
                </p>
                <p>
                    <label>Frequency</label>
                    <select name="frequency">
                        <option value="1">Every Minute</option>
                        <option value="5">Every 5 minutes</option>
                        <option value="15">Every 15 minutes</option>
                        <option value="30">Every Half-hour</option>
                        <option value="60">Every Hour</option>
                    </select>
                </p>
                <p>
                    <input type="submit" value="Create My Code" class="btn btn-success" />
                </p>
                <input type="hidden" name="x" value="servergrid" />
                <input type="hidden" name="y" value="myservers" />
                <input type="hidden" name="z" value="getscripts" />
                <input type="hidden" name="action" value="create" />
            </form>
                <?php
                }
                else{
                    echo $responseMsg;
                }
                ?>
        </div>

    </div>

</div>
</div>