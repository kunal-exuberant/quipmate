<?php
require('../include/Session.php');
require('../include/Database.php');
$session = new Session();
$session->start();
require('../include/Help.php');
if(array_key_exists('login',$_POST))
{	
   if($_POST['email'] !="" && $_POST['password'] != "")
   {
		$email = trim($_REQUEST['email']);
		setcookie("quip_e",$email,time()+3600000,'/','.quipmate.com');  
		$password = trim($_REQUEST['password']);
		$password = sha1($email.$password); 
		$help = new Help();
		$database = new Database();
		$help->assign_database($email,$database);
		$database = null;
		$database = new Database();
		$row = $database->login_user($email,$password);
	    $pass=$row['PASSWORD'];
		if($password==$pass)
		{	
		    $myprofileid=$row['USERID'];
			if(isset($_POST['remember']))
			{
				$quip_p = $myprofileid;
				$quip_i = $row['SESS_QUIP'];
				setcookie(session_name(),session_id(),time()+3600000,'/'); 
			}	
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
		}	
		else
		{
			header('Location: welcome.php?error=incorrect_email_or_password');
			exit();
		}
	}
	else 
	{	
		header('Location: welcome.php?error=empty');
		exit();
	}
}
else
{
	header('Location: welcome.php');
	exit();
}
?>

