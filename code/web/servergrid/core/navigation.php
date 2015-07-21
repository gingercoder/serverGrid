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
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-home icon-white"></i> <?php echo $_SESSION['username'];?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="/index.php/core/system/password"><i class="icon-user"></i> Change Password</a></li>
                    <li><a href="/index.php/core/help/index/"><i class="icon-book"></i> Help</a></li>
                    <li><a href="/index.php/core/security/logout"><i class="icon-off"></i> Logout</a></li>
                </ul>
                </li>
            </ul>
            <ul class="nav">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Grid <b class="caret"></b></a>

                <ul class="dropdown-menu">
                    <li><a href="/index.php/servergrid/myservers/add/"><i class="icon-tasks"></i> <strong>Add Server</strong></a></li>
                    <li class="divider"></li>
                    <?php
                    // for each server provide a link to undertake tasks
                    $myservers = $ObjSG->getServerList($ObjSG->usernametoid($_SESSION['username']));
                    foreach($myservers as $aserver){
                        $thisserver = $aserver['serverIdent'];
                        $thisservername = $aserver['serverName'];
                    ?>
                        <li class="dropdown-submenu">
                              <a tabindex="-1" href="#"><i class="icon-hdd"></i> <?php echo $thisservername;?></a>
                              <ul class="dropdown-menu">
                                    <li><a href="/index.php/servergrid/myservers/getscripts/<?php echo $thisserver;?>"><i class="icon-file"></i> Get Scripts</a></li>
                                    <li class="divider"></li>
                                    <li><a href="/index.php/servergrid/virtualrack/display/<?php echo $thisserver;?>/"><i class="icon-eye-open"></i> Display</a></li>
                                    <li class="divider"></li>
                                    <li><a href="/index.php/servergrid/myservers/edit/<?php echo $thisserver;?>"><i class="icon-pencil"></i> Edit</a></li>
                                    <li><a href="/index.php/servergrid/myservers/remove/<?php echo $thisserver;?>"><i class="icon-trash"></i> Remove</a></li>
                              </ul>
                        </li>
                  <?php
                        // Close each serverlink
                    }
                  ?>
                </ul>

              </li>
                <li>
                    <a href="/index.php/servergrid/virtualrack/overview/">Virtual Rack</a>
                </li>
            </ul>
          </div>
        </div>
      </div>
</div>
