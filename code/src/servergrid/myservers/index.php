<?php

/*
 * Hello World Demo App
 * Demo page
 */

if($_SESSION['username'] !=""){
	require_once('web/helloworld/demo/index.php');
}
else{
	require_once('web/core/login/index.php');
}

?>
