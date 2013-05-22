<?php

/*
 * CORE FRAMEWORK FILE
 * IP Address you are using doesnt match that specified in the [src/core/security/firewall.php] file
 */
?>
<div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
            <div class="hero-unit">
                <h1>System Error</h1>
                <h2>Your location not in our approved list</h2>
                
            </div>
            </div>
        </div>
    <div class="row-fluid">
        <div class="span12">
            <h2>Why am I seeing this error?</h2>
            <p>
            <ol>
                <li>You are accessing the system from a remote location
                    <ul>
                        <li>You may be trying to access the system from a remote location instead of the office</li>
                        <li>The system is currently locked to only specific IP addresses</li>
                    </ul>
                </li>
                <li>Your IP address has changed from one you previously used
                    <ul>
                        <li>Your IP address may have changed on your router</li>
                        <li>You are connecting over a different network than usual</li>
                        <li>Your computer has attempted to lock onto the wrong WiFi signal</li>
                    </ul>
                </li>
            </ol>
            </p>
            <h2>What do I do now?</h2>
            <p>
                You need to discuss access with your system administrator. Currently I'm tracking your IP address as <?php echo $_SERVER['REMOTE_ADDR']; ?> but
                this may have be the address of your gateway or proxy. Sometimes a proxy server can cause issues with the firewalling on this system.
            </p>
            <p>
                Talk to the system administrator about how you can increase the list of approved locations or look at ways of connecting using a VPN instead.
            </p>
        </div>
    </div>
</div>