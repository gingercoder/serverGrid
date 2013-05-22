<?php

/*
 * SYSTEM APPLICATION SETTINGS
 * CORE FRAMEWORK FILE
 * 
 * Loads the core settings into an array
 */

// Pull all settings from the database
$sql = "SELECT * FROM framework_settings";
$settings = db::returnallrows($sql);
$myApp = array();

foreach($settings as $setting){
    // Load Setting into myApp array
    $myApp[$setting['settingName']] = $setting['settingValue'];
}
?>
