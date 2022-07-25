<?php
include_once('../includes/main.inc.php');
validateAdminUser();

switch ($_POST['button'])
{
	case 'Add Token':
		include_once('../includes/cleanup.inc.php');
		header('location: edit_token.php');
		exit();
		break;

	case 'Edit Token':
		if(isset($_POST['token_id']) && is_numeric($_POST['token_id']))
		{
			$_SESSION['token_id'] = $_POST['token_id'];
			include_once('../includes/cleanup.inc.php');
			header('location: edit_token.php');
			exit();
		}
		else 
		{
			$errors[] = 'You must select a token to edit.';
		}
		break;

	case 'Delete Token':
		break;
	
	case 'Search Tokens':
		if (isset($_POST['class_id']) && is_numeric($_POST['class_id']))
		{
			$tokens = Token::getTokens($_POST['class_id']);
			$post_class = $_POST['class_id'];
		}
		else 
		{
			$tokens = Token::getTokens();
		}
		break;

	case 'Main Menu':
		include_once('../includes/cleanup.inc.php');
		header('location: menu.php');
		exit();
		break;
		
	default:
		$tokens = Token::getTokens();
		break;
}

$classes = Token::getClasses();

include_once('templates/header.tpl.php');
include_once('templates/manage_tokens.tpl.php');
include_once('templates/footer.tpl.php');
include_once('../includes/cleanup.inc.php');
?>