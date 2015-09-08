<?php
$session = new Session();
$session->start();
ob_start();	
	
if(!isset($_SESSION['auth'])) 
{
	if(isset($_SERVER['REQUEST_URI']))
	{
		setcookie("quip_r",$_SERVER['REQUEST_URI'],0,'/','.quipmate.com');
	}	
    if(isset($_COOKIE['quip_p']) && isset($_COOKIE['quip_i']))
    {
       header('Location: cook_login.php');
	   exit;
	}
	else
	{
	   header('Location: welcome.php');
	   exit;
	}
}
else
{	
	if($_SESSION['STEP'] == 3 && $_SERVER['REQUEST_URI'] !='/register.php?hl=group_suggest')
	{
		header('Location: /register.php?hl=group_suggest');
		exit;
	}
	else if($_SESSION['STEP'] == 2&& $_SERVER['REQUEST_URI'] !='/register.php?hl=friend_suggest')
	{
		header('Location: /register.php?hl=friend_suggest');
		exit;
	}
	else if($_SESSION['STEP'] == 1 && $_SERVER['REQUEST_URI'] !='/register.php?hl=profile_picture')
	{
		header('Location: /register.php?hl=profile_picture');
		exit;
	}
    else if(($_SESSION['STEP'] == -1 || $_SESSION['STEP'] == '-2')&& $_SERVER['REQUEST_URI'] !='/account_disabled.php')
	{
		header('Location: /account_disabled.php');
		exit;
	}
}
?>