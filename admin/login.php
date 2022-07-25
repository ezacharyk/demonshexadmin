<?php
include_once('../includes/main.inc.php');

//echo(hash('sha512','yjr,sm3--9'));

if($_POST['submit'] == 'Log In')
{
	if($_POST['login_id'] == '' || $_POST['password'] == '')
	{
		$errors[] = 'Invalid Login Empty';
	}
	else
	{
		$admin = new AdminUser();
		$admin_id = $admin->validateLogin($_POST['login_id'],$_POST['password']);
		
		if(is_numeric($admin_id))
		{
			$_SESSION['demons_hex']['logged_in'] = true;
			$_SESSION['demons_hex']['admin_user'] = $admin_id;
			
			header('location: menu.php');
			exit();
		}
		else
		{
			$errors[] = 'Invalid Login No User';
		}
	}
}

include_once('templates/header.tpl.php');
include_once('templates/login.tpl.php');
include_once('templates/footer.tpl.php');
include_once('../includes/cleanup.inc.php');
?>