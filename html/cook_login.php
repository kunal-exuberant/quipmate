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
/*else if(isset($_COOKIE['quip_p']) && isset($_COOKIE['quip_i']))
{ 
	require('../include/Help.php');
	$quip_p = $_COOKIE['quip_p'];
	$quip_i = $_COOKIE['quip_i'];
	$email = $_COOKIE['quip_e'];
	if(strpos(strtolower($email), '@ballytech.com') > -1)
	{ 
		$_SESSION['database'] =  'ballytech';
	}
	else
	{
		$_SESSION['database'] =  'profile';
	}
	$database = new Database();
	$row = $database->cook_login_user($quip_p,$quip_i);
	$myprofileid=$row['USERID'];
	$email=$row['EMAIL'];
	setcookie("quip_e",$email,time()+3600000,'/','.quipmate.com'); 
	$imgrow=$database->get_image($myprofileid);
	$prow=$database->bio_select($myprofileid);
	$help = new Help();
	$pri = $database->privacy_select($myprofileid);
	$help->session_init($row,$prow,$imgrow,$email,$pri);
	if(isset($_SESSION['auth'])) 
	{	
		if(isset($_COOKIE['quip_r']))
		{ 
			$redirect = $_COOKIE['quip_r'];
			setcookie("quip_r",'',time()-3600,'/','.quipmate.com');
			header("Location: http://www.quipmate.com".$redirect); 
			exit; 
		}	
		else
		{
			header('Location: /'); 
			exit;
		}	
	}
} */
else
{
	header('Location: welcome.php');
	exit;
}
?>
