<?php

/*
 *  .d8888b.                                              .d8888b.          d8b      888
 * d88P  Y88b                                            d88P  Y88b         Y8P      888
 * Y88b.                                                 888    888                  888
 *  "Y888b.    .d88b.  888d888 888  888  .d88b.  888d888 888        888d888 888  .d88888
 *     "Y88b. d8P  Y8b 888P"   888  888 d8P  Y8b 888P"   888  88888 888P"   888 d88" 888
 *       "888 88888888 888     Y88  88P 88888888 888     888    888 888     888 888  888
 * Y88b  d88P Y8b.     888      Y8bd8P  Y8b.     888     Y88b  d88P 888     888 Y88b 888
 *  "Y8888P"   "Y8888  888       Y88P    "Y8888  888      "Y8888P88 888     888  "Y88888
 *                                      Remote Server Statistics and Reporting mechanism
 * Version:     1.2.0
 * Author:      Rick Trotter <rick@gingercoder.com>
 * Description:
 *              ServerGrid is a client and server technology allowing the remote monitoring
 *              of your server fleet. It provides a statistical overview of the state of
 *              your servers past and present.
 *
 * License:         GNU GPLv3
 * Published:       May 2013
 * This Release:    October 2013
 */

      // Error Reporting Mode
        error_reporting(0);
        ini_set('display_errors', 'Off');

      // Create the Session and control page request information
	    session_start();
	    header("Cache-Control: ");
	    header("pragma: ");

      // Launch the database
      require_once('src/core/database/mysql.php');
      require_once('src/core/database/settings.php');

      // Load the application settings from the database
      require_once('src/core/settings/loadAppSettings.php');

      // Output page state - Auto Load mechanism
      require_once('src/core/autoload/autoloadModule.php');
