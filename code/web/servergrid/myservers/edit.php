<?php
/*
 * Edit your server listing
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
                    Edit
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
                Edit Server
            </h2>
            <?php
            if($d !=""){

            ?>
            <p>
                Provide as much information as possible at this stage. If you do not have a particular server name please
                use localhost as your entry. If your server is on an external network address, ServerGrid will be able to
                undertake advanced checks of your system.
            </p>
            <?php
            }
            else{
                ?>
            <p>
                Select which server you wish to edit from your list of servers.

            </p>
            <?php
            }
            ?>
        </div>

        <div class="span8">
            <?php
            if($thisServer['serverid']){

            ?>
            <form name="addserver" action="/index.php" method="post">
                <h2>Server Details</h2>
                <p>
                    <label>Server Name</label>
                    <input type="text" name="serverName" class="input input-medium" value="<?php echo $thisServer['serverName'];?>" />
                </p>
                <p>
                    <label>Server OS</label>
                    <select name="serveros" >
                        <option value="<?php echo $thisServer['serverOS'];?>">[ <?php echo $thisServer['serverOS']; ?> ]</option>
                        <option value="BSD">BSD / FreeBSD</option>
                        <option value="Debian">Debian</option>
                        <option value="Fedora">Fedora</option>
                        <option value="Raspian">Raspian</option>
                        <option value="Slackware">Slackware</option>
                        <option value="Ubuntu">Ubuntu</option>
                        <option value="Linux">Linux (Other)</option>
                        <option value="Windows">Windows</option>
                    </select>
                </p>
                <p>
                    <label>IP Address</label>
                    <input type="text" name="ipaddress" class="input input-medium" value="<?php echo $thisServer['ipaddress'];?>" />
                </p>
                <p>
                    <button class="btn btn-success" type="submit"><i class="icon-ok icon-white"></i> Save Changes</button>
                </p>

            <input type="hidden" name="x" value="servergrid" />
            <input type="hidden" name="y" value="myservers" />
            <input type="hidden" name="z" value="edit" />
            <input type="hidden" name="serverid" value="<?php echo $thisServer['serverIdent'];?>" />
            <input type="hidden" name="action" value="save" />
            </form>
        </div>
        <?php
            }
        else{
        ?>


            <h2>Select Server</h2>

            <?php
            foreach($serverList as $server){
                echo "<div class=\"graphbox\"><h3>".$server['serverName']."</h3><p>".$server['serverIdent']."<br/>".$server['serverOS']."</p>";

                ?>
                <form name="editserver" action="/index.php" method="post">
                    <button class="btn btn-success" type="submit"><i class="icon-pencil icon-white"></i> <?php echo $server['serverName']; ?></button>

                    <input type="hidden" name="x" value="servergrid" />
                    <input type="hidden" name="y" value="myservers" />
                    <input type="hidden" name="z" value="edit" />
                    <input type="hidden" name="action" value="edit" />
                    <input type="hidden" name="serverid" value="<?php echo $server['serverid'];?>" />
                </form>
                </div><br/>
            <?php
            }
        }
        ?>
    </div>

</div>
</div>
