<?php
/*
 * This file includes all other needed libraries and classes for the application
 * 
 * We also use this to instantiate needed objects and to start our sessions
 */

ini_set('display_errors', 1);
error_reporting (E_ALL ^ E_NOTICE ^ E_STRICT ^ E_DEPRECATED);

require_once 'database.inc.php';
include_once '../classes/AdminUser.class.php';
include_once '../classes/Token.class.php';
include_once '../classes/Player.class.php';


session_start();

$errors = array();
$results = array();

function validateAdminUser()
{
	global $db;
	
	if($_SESSION['demons_hex']['logged_in'] && $_SESSION['demons_hex']['admin_user'])
	{
		return true;
	}
	else
	{
		header('location: logout.php');
		exit();
	}
}

function displayPage($template = '')
{
	include_once('templates/header.tpl.php');
	include_once('templates/'.$template);
	include_once('templates/footer.tpl.php');
	include_once('../includes/cleanup.inc.php');
}
?>