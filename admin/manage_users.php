<?php
include_once('../includes/main.inc.php');
validateAdminUser();

switch ($_POST['button'])
{
	case 'Add User':
		include_once('../includes/cleanup.inc.php');
		header('location: edit_user.php');
		exit();
		break;

	case 'Edit User':
		echo($_POST['admin_id']);
		if(isset($_POST['admin_id']) && is_numeric($_POST['admin_id']))
		{
			$_SESSION['edit_user_id'] = $_POST['admin_id'];
			include_once('../includes/cleanup.inc.php');
			header('location: edit_user.php');
			exit();
		}
		else 
		{
			$errors[] = 'You must select a user to edit.';
		}
		break;

	case 'Delete User':
		break;

	case 'Main Menu':
		include_once('../includes/cleanup.inc.php');
		header('location: menu.php');
		exit();
		break;
}

$users = AdminUser::getUsers();

include_once('templates/header.tpl.php');
include_once('templates/manage_users.tpl.php');
include_once('templates/footer.tpl.php');
include_once('../includes/cleanup.inc.php');
?>