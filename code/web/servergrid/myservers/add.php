<?php
/*
 * Add a server to your server listing
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
                    Add
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
                Add Server
            </h2>
            <p>
                Provide as much information as possible at this stage. If you do not have a particular server name please
                use localhost as your entry. If your server is on an external network address, ServerGrid will be able to
                undertake advanced checks of your system.
            </p>
        </div>

        <div class="span8">
            <form name="addserver" action="/index.php" method="post">
            <h2>Server Details</h2>
            <p>
                <label>Server Name</label>
                <input type="text" name="serverName" class="input input-medium" />
            </p>
            <p>
                <label>Server OS</label>
                <select name="serveros" >
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
                <input type="text" name="ipaddress" class="input input-medium" />
            </p>
            <p>
                <button class="btn btn-success" type="submit"><i class="icon-ok icon-white"></i> Add Server/button>
            </p>
            
            <input type="hidden" name="x" value="servergrid" />
            <input type="hidden" name="y" value="myservers" />
            <input type="hidden" name="z" value="add" />
            <input type="hidden" name="action" value="save" />
            </form>
            </div>
        </div>

    </div>
</div>