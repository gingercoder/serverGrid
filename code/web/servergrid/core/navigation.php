<?php

/*
 * Mule Navigation System
 * Add navigable items to this file for the top menu system
 */
?>

<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="/index.php/core/system/homepage"><?php echo $myApp['appTitle']; ?></a>
          <div class="nav-collapse collapse">
            <ul class="nav pull-right">
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Logged in as <?php echo $_SESSION['username'];?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="/index.php/core/system/password">Change Password</a></li>
                    <li><a href="/index.php/core/help/index/">Help</a></li>
                    <li><a href="/index.php/core/security/logout">Logout</a></li>
                </ul>
                </li>
            </ul>
            <ul class="nav">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Grid <b class="caret"></b></a>
                
                <ul class="dropdown-menu">
                    <li><a href="/index.php/servergrid/myservers/add/"><strong>Add Server</strong></a></li>
                    <li class="divider"></li>
                    <?php
                    // for each server provide a link to undertake tasks
                    $myservers = $ObjSG->getServerList($ObjSG->usernametoid($_SESSION['username']));
                    foreach($myservers as $aserver){
                        $thisserver = $aserver['serverid'];
                        $thisservername = $aserver['serverName'];
                    ?>
                        <li class="dropdown-submenu">
                              <a tabindex="-1" href="#"></strong><?php echo $thisservername;?></a>
                              <ul class="dropdown-menu">
                                    <li><a href="/index.php/servergrid/myservers/getscripts/<?php echo $thisserver;?>">Get Scripts</a></li>
                                    <li class="divider"></li>
                                    <li><a href="/index.php/servergrid/myservers/edit/<?php echo $thisserver;?>">Edit</a></li>
                                    <li><a href="/index.php/servergrid/myservers/remove/<?php echo $thisserver;?>">Remove</a></li>
                              </ul>
                        </li>
                  <?php
                        // Close each serverlink
                    }
                  ?>
                </ul>
                
              </li>
                <li>
                    <a href="/index.php/servergrid/dashboard/overview/">Dashboard</a>
                </li>
            </ul>
          </div>
        </div>
      </div>
</div>
