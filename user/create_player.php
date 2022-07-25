<?php
include_once('../includes/main.inc.php');

$player = new Player();

$errors = $player->setValues($_POST);

if(count($errors))
{
	//return errors
}
else 
{
	//return success
}
?>