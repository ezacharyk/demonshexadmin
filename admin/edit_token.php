<?php
include_once('../includes/main.inc.php');
validateAdminUser();

$token = new Token($_SESSION['token_id']);

switch ($_POST['button'])
{
	case 'Save Token':
		$errors = $token->setValues($_POST);
		if(count($errors) <= 0)
		{
			$token->save();
			$_SESSION['results'] = 'Token Saved';
			unset($_SESSION['token_id']);
			header('location: manage_tokens.php');
			exit;
		}
		break;
		
	case 'Back':
		unset($_SESSION['token_id']);
		header('location: manage_tokens.php');
		exit();
		break;
		
	case 'Main Menu':
		unset($_SESSION['token_id']);
		header('location: menu.php');
		exit();
		break;
	
	default:
		
		break;
}
$fields = $token->fields;
include_once('templates/header.tpl.php');
include_once('templates/edit_token.tpl.php');
include_once('templates/footer.tpl.php');
include_once('../includes/cleanup.inc.php');
?>