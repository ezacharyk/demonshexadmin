<?php
include_once('../includes/main.inc.php');

$player = new Player();

$tokens = $player->getTokens();

$token_xml = '';
foreach($tokens as $token)
{
	$token_xml .= "
			<token id='{$token['token_id']}' name='{$token['name']}' class_id='{$token['class_id']}' attack='{$token['attack']}' defense='{$token['defense']}' image='{$token['image']}' element='{$token['element_id']}' directions='{$token['directions']}'></token>";
}

echo("<token_list>
		$token_xml
	  </token_list>");

include_once('../includes/cleanup.inc.php');
?>