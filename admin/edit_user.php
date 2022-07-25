<?php
include_once('../includes/main.inc.php');
validateAdminUser();
$user = new AdminUser($_SESSION['edit_user_id']);

switch ($_POST['button'])
{
	case 'Save User':
		$errors = $user->setValues($_POST);
		if(count($errors) <= 0)
		{
			$user->save();
			$_SESSION['results'] = 'User Saved';
			unset($_SESSION['edit_user_id']);
			header('location: manage_users.php');
			exit;
		}
		break;

	case 'Back':
		unset($_SESSION['edit_user_id']);
		header('location: manage_users.php');
		exit();
		break;

	case 'Main Menu':
		unset($_SESSION['edit_user_id']);
		header('location: menu.php');
		exit();
		break;

	default:

		break;
}
$fields = $user->fields;
include_once('templates/header.tpl.php');
include_once('templates/edit_user.tpl.php');
include_once('templates/footer.tpl.php');
include_once('../includes/cleanup.inc.php');
?>