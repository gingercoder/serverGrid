<?php

/*
 * CORE FRAMEWORK FILE
 * Authentication or DB Error
 */
?>

<!DOCTYPE html>
<html>
    <head>
        
        <title>ServerGrid || System DB Failure</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Twitter Bootstrap -->
        <link href="/web/css/bootstrap.css" rel="stylesheet">
        <link href="/web/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="/web/css/core.css" rel="stylesheet">
        <link rel="icon" type="image/ico" href="/web/img/favicon.ico">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>
<div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
            <div class="hero-unit serverGridHero">
                <h1>System Error</h1>
                <h2>Pretty big oops moment</h2>
                
            </div>
            </div>
        </div>
    <div class="row-fluid">
        <div class="span12">
            <h2>Why am I seeing this error?</h2>
            <p>
            <ol>
                <li>The database is unavailable
                    <ul>
                        <li>An in-place upgrade could be in progress</li>
                        <li>The database connection file may be missing or contain wrong details</li>
                        <li>The database server may be unavailable at this time</li>
                        <li>The database server might be too busy to accept connections</li>
                    </ul>
                </li>
                <li>The database does not exist
                    <ul>
                        <li>The database has been modified or is missing data</li>
                        <li>The connection file may contain the wrong details</li>
                        <li>The database may have been deleted accidentally</li>
                        <li>The name of the database may have changed</li>
                    </ul>
                </li>
            </ol>
            </p>
            <h2>What do I do now?</h2>
            <p>
                Try using the refresh or back button and trying the function again. If problems persist check your connection file and access to your database server.
            </p>
        </div>
    </div>
</div>
<footer>
    ServerGrid built by gingerCoder()
</footer>

        <!-- Bootstrap and jQuery Includes to reduce loading pauses -->
        <script src="/web/js/jquery-1.9.1.min.js"></script>
        <script src="/web/js/bootstrap.min.js"></script>


</body>
</html>
