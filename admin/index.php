<?php
include_once('../includes/main.inc.php');
if(validateAdminUser())
{
	header('location: menu.php');
	exit();
}
?>