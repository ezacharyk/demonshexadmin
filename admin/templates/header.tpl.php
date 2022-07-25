<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Demon's Hex Admin Utility</title>
</head>
<body>
<img alt="Demon's Hex" src="/demonshex/server/images/title.png">
<h1>Admin Utility</h1>
<?php
if(is_array($errors) && count($errors) > 0)
{
	echo('<div class="error" style="color:red;"> The Following Errors Have Occurred:<br>');
	foreach ($errors as $error)
	{
		echo($error.'<br>');
	}
	echo('</div>');
}
if(isset($_SESSION['results']) && is_array($_SESSION['results']) && count($_SESSION['results']) > 0)
{
	echo('<div class="result" style="color:blue;"> The Following Results Have Occurred:<br>');
	foreach ($_SESSION['results'] as $result)
	{
		echo($result.'<br>');
	}
	echo('</div>');
	unset($_SESSION['results']);
}
?>