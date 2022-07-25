<?php
include_once('../includes/main.inc.php');

//$token = new Token($_SESSION['token_id']);

validateAdminUser();
$token_xml = '';

switch ($_POST['button'])
{
	case 'Select Tokens':
		if (isset($_POST['class_id']) && is_numeric($_POST['class_id']))
		{
			$tokens = Token::getTokens($_POST['class_id']);
			$post_class = $_POST['class_id'];
			switch($post_class)
			{
				case 1:
					$token_xml = 'heroTokens = [ ';
					break;
				case 2:
					$token_xml = 'npcTokens = [ ';
					break;
				case 3:
					$token_xml = 'monsterTokens = [ ';
					break;
				case 4:
					$token_xml = 'bossTokens = [ ';
					break;
			}
		}
		else
		{
			$tokens = Token::getTokens();
			$token_xml = 'allTokens = [ ';
		}
		break;

	case 'Main Menu':
		include_once('../includes/cleanup.inc.php');
		header('location: menu.php');
		exit();
		break;

	case 'Back':
		include_once('../includes/cleanup.inc.php');
		header('location: manage_tokens.php');
		exit();
		break;

	default:
		$tokens = Token::getTokens();
			$token_xml = 'all_tokens = [ ';
		break;
}
$classes = Token::getClasses();

foreach($tokens as $token)
{
	$token_xml .= "
			[{$token['token_id']},'{$token['name']}',{$token['class_id']},{$token['attack']},{$token['defense']},'{$token['image']}',{$token['element_id']},[{$token['directions']}],0],";
}
$token_xml .= '
				];';

include_once('templates/header.tpl.php');
include_once('templates/get_tokens.tpl.php');
include_once('templates/footer.tpl.php');

include_once('../includes/cleanup.inc.php');
?>