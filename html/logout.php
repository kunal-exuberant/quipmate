<?php
require('../include/Session.php');
require('../include/Database.php');
$session = new Session();
$session->start();
if(isset($_COOKIE['cc_loggedin']))	
{
	setcookie('cc_loggedin','',time()-86400,'/','.quipmate.com');
}
if(isset($_SESSION))
{
	$_SESSION = array();
}
$session->destroy(session_id());	
if(isset($_COOKIE[session_name()]))
{
	setcookie(session_name(),'',time()-86400,'/','.quipmate.com');
}
if(isset($_COOKIE['quip_i']))
{
	setcookie('quip_i','',time()-86400,'/','.quipmate.com');
}
if(isset($_COOKIE['quip_p']))
{
	setcookie('quip_p','',time()-86400,'/','.quipmate.com');
}
if(isset($_COOKIE['chatbox']))
{
	setcookie('chatbox','',time()-86400,'/');
}
if(isset($_COOKIE['name']))
{
	setcookie('name','',time()-86400,'/');
}
header('Location: welcome.php'); 
exit();
?>

