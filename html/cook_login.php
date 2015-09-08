<?php
require('../include/Session.php');
require('../include/Database.php');
$session = new Session();
$session->start();
if(isset($_SESSION['auth'])) 
{
		header('Location: /');
		exit;
}
else
{
	header('Location: welcome.php');
	exit;
}
?>