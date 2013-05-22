ServerGrid
==========

Synopsys:
ServerGrid is a server monitoring application which allows a central overview of how your servers are coping


About
=====

ServerGrid lets users create servers that they want to manage. It then generates a small PHP file that you copy and paste onto your chosen server. Using the cron script, also generated for you, you add this to your crontab. It's as simple as that - your server is now being monitored by the ServerGrid system.

ServerGrid is a simple solution to monitoring your CPU, Memory, Uptime and Kernel revision. It helps system administrators keep track of any possible problems before they become critical.

Requirements
============

Of course, "simple" doesn't mean "zero requisits" unfortunately - you will need PHP and PHP-CURL installed on your servers in order for the script to work. For most linux servers you'd want to monitor, this will already be the case.

Installation
============

1) Prepare a LAMP server with a MySQL database of your own name choice.

2) Place the ServerGrid files on your server in the root directory.

3) Enter your correct database values in the /src/core/database/settings.php file.

4) Execute the SQL script located in the database folder either through PHPMyAdmin, command line or MySQL workbench

5) Navigate to your server address and log in with:  username: sysadmin  password: servergrid
