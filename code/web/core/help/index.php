<?php

/*
 * System Help Document
 */
?>
<br/><br/>
<div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <h1>Help System</h1>
                <h2>ServerGrid</h2>
            </div>
        </div>
    
    <div class="row-fluid">
        <div class="span4">
            <h2>Topics</h2>
            <ul>
                <li><a href="#1">1. About</a></li>
                <li><a href="#2">2. Managing your grid</a></li>
                <li><a href="#3">3. Open System Information</a>
            </ul>
        </div>
        <div class="span8">
            <a name="1"></a>
            <h1>1. About</h1>
            <h2>ServerGrid</h2>
            <p>
               ServerGrid is a management utility allowing the monitoring of all your linux servers from a single location. It provides a simple breakdown of
               how they are doing and the ability to alert you if problems arise.
            </p>
            <h2>Technology</h2>
            <p>
                The ServerGrid system utilises your linux server's own internally generated status information. Coupled with a uniquely generated script for
                your server, the information is collated on the central ServerGrid system ready for plugging in to your dashboard.
            </p>
            <a name="2"></a>
            <h1>2. Managing your grid</h1>
            <h2>Add servers</h2>
            <p>
                Add your servers to your own grid and then generate the code file specific to each of your servers.
            </p>
            <h2>Generate your code file</h2>
            <p>
                Once you have the code file, you can generate the cron job entries through the ServerGrid system to copy into your crontab.
            </p>
            <h2>Install your Crontab</h2>
            <p>
                Once you have stored your ServerGrid code on your server and added your crontab entries the ServerGrid system will start to receive
                data abour your server status. From this point forward it will keep track of how your system is doing so that from a single
                interface you can see how your Linux server fleet is doing.
            </p>
            <h2>One-way data transfer</h2>
            <p>
                No data is sent back to your systems and no authentication back to your fleet is required, making it the ideal solution for those
                concerned about system security. Only key information about system state is sent to our systems to work out how your box is coping.
            </p>
            <a name="3"></a>
            <h1>3. Open System Information</h1>
            <h2>If you want to remove it, remove it!</h2>
            <p>
                Simply delete your crontab entry and your generated code file. Nothing else is stored on your system, integrated into modules or lurking in the background.
            </p>
            <h2>Open Code</h2>
            <p>
                The server information file is not compiled or encrypted so you are free to check what information is being sent. If you're not happy with
                what information is heading out of your box simply comment-out or remove the lines. ServerGrid will only capture the information it's sent.
                Obviously this will change the quality and quantity of information displayed in your dashboard.
            </p>
        </div>
    </div>
</div>
