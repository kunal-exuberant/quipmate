<?php
require_once('../include/Session.php');
require_once('../include/Database.php');
require_once('../include/File.php');
$session = new Session();
$database = new Database();
$session->start();
if(isset($_SESSION) && isset($_SESSION['auth']))
{
	header('Location: /');
	exit;
}
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<?php
$file= new File();
$file->style_welcome();
$file->google_analytics();
?>
<title>Welcome To Quipmate</title>
</head>
<body>
<div id="header">
	<div id="header-wrapper">
	<div id="qm-flogo">
		<a href="/"><img src="http://icon.qmcdn.net/flogo.png" width="250" alt="Quipmate" /></a>
	</div>
	<div id="login_box">
		<form name="input" method="post" action ="login_submit.php" target="_parent">
			<input type="email" name="email" placeholder="Email" id="login_email" value="<?php if(isset($_COOKIE['quip_e'])) echo $_COOKIE['quip_e'];?>">
			<input type="password" name="password"  placeholder="Password"  id="login_pass" value=""> 
			<input type="submit" name="login" value="LOGIN" id = "login_button">
			<div id="remember_forgot">
				<input id="remember_checkbox" type="checkbox" name="remember" checked />Remember Me
				<a id="forgot_link" href="welcome.php?click=forgot_password" >Forgot Password</a>
			</div>
		</form> 
	</div>
	</div>
</div>
<div id="wrapper">

<div class="tab">
	<a class="tab_each" href="http://blog.quipmate.com/" target="_blank">Blog</a>
	<a class="tab_each" href="http://faq.quipmate.com/" target="_blank">FAQ</a>
	<a class="tab_each" href="http://help.quipmate.com/" target="_blank">Help</a>
	<a class="tab_each" href="http://developers.quipmate.com/" target="_blank">Developers</a>
	<a class="tab_each" href="public/terms.php" target="_blank">Terms of Use</a>	
</div>

<div id="main_container">
<div id="register_box">
<?php if(isset($_GET['email']) && isset($_GET['identifier']) && trim($_GET['email']) != '')
{
	setcookie("console","got all get values",time()+3600000,'/','.quipmate.com');
require_once('../include/Session.php');
require_once('../include/Database.php');
require_once('../include/Help.php');
$session = new Session();
$help = new Help();
$session->start();
$email = $_GET['email'];
if($help->is_email($email))
	{
		$help->assign_database($email,$database);
		$database = null;
		$database = new Database();
		$row = $database->is_already_user($email);
		if($row['EMAIL'] != $email)
		{
			setcookie("console","is_ not already_user",time()+3600000,'/','.quipmate.com');
		$identifier = $_GET['identifier'];
		$row = $database->virtual_select($email,$identifier);
		if($row != 0 && $email == $row['EMAIL'] && $identifier == $row['UNIQUEID'])
		{
			$email = $row['EMAIL'];	
			$nr = explode('@',$email);
			$new_member = $nr[0];
		?>
		<div style="text-align:left">
			<h1><?php echo 'Hi '.$new_member.','; ?></h1>
			<h2>Welcome to the Quipmate community</h2>
			<h2>Please provide these details</h2>
			<div id="info"></div>
			<div id="name_container">
			<label id ="signup_name_label">Name:</label>
			<input type="text" id="signup_name" value="" title="Full Name" >
			</div>
			<div id="password_container">
			<label id ="signup_password_label">Password:</label>
			<input type="password" id="signup_password" value="" size="32" title="Password" >
			</div>
			<div id="gender_container">
			<label id ="signup_gender_label">Gender:</label>
			<select id="signup_gender">
			<option value="-1">Gender</option>
			<option value="0">Female</option>
			<option value="1">Male</option>
			</select>
			</div>
			<div id="birthday_container">
			<label id="signup_birthday_label">Birthday:</label> 
			<select size="1" id="day">
			  <option value="-1">Day</option>
			  <?php 
			  for($i=1;$i<=31;$i++)
			  {
				echo '<option value="'.$i.'">'.$i.'</option>';
			  }
			  ?>
			</select>
			<select id="month">
			  <option value="-1">Month</option>
			  <option value="01">JAN</option>
			  <option value="02">FEB</option>
			  <option value="03">MAR</option>
			  <option value="04">APR</option>
			  <option value="05">MAY</option>
			  <option value="06">JUN</option>
			  <option value="07">JUL</option>
			  <option value="08">AUG</option>
			  <option value="09">SEP</option>
			  <option value="10">OCT</option>
			  <option value="11">NOV</option>
			  <option value="12">DEC</option>		
			</select>
			<select size="1" id="year">
			  <option value="-1">Year</option>
			  <?php 
			  for($i=2002;$i>=1901;$i--)
			  {
				echo '<option value="'.$i.'">'.$i.'</option>';
			  }
			  ?>
			</select>
			</div>
			<div id="signup_button_container">
			<input type="hidden" id="email_hidden" value="<?php echo $email; ?>" />
			<input type="hidden" id="identifier_hidden" value="<?php echo $identifier; ?>" />
			<input id ="signup_button" type="submit" value="SIGNUP" onclick="action.register(this)" />
			</div>
			<span id="icon"></span>
			<?php
				$file->script_welcome();
			?>
			</div>
			
		<?php
		}
		else 
		{
		?>
			<h1 id="register_title"><?php echo 'The invitation link sent to you seems to be broken. Please try again.' ; ?></h1>
		<?php	
		}
		}
		else
		{
		?>
			<div id="qm_description">
			<h1>Welcome To Quipmate.</h1>
			<h1>You are already a part of Quipmate</h1>
			<h1>Please Login using your email and password.</h1>
			<h1>If you forgot your password, please use forgot password link to recover it.</h1>
			</div>
		<?php	
		}
			$file->script_jquery();
	}
    else
    {
  
    }
}
else if(isset($_GET['id']) && isset($_GET['email']) && isset($_GET['click']))
{
	$click = $_GET['click'];
	if($click=='recover_password')
	{
		require_once('../include/Database.php');
		require_once('../include/Help.php');
		$flag = 0;
		$id = $_GET['id'];
		$help = new Help();
		$email = $_GET['email'];
		$help->assign_database($email,$database);
		$database = null;
		$database = new Database();
		$uniqueid = $database->select_uniqueid($email);
		if($uniqueid == $id)
		{
		?>
			<div id="recover_password_box"> 
			<span>Change your password</span>
			<div id="recover_new_password_container">
			<span style="padding-right:20px;">New Password:</span>
			<input style="border:1px solid gray;width:200px;height:25px;" type="password" name="pass" id = "pass"/>
			</div>
			<input type="hidden" id="recover_password_email" value="<?php echo $email ;?>" />
			<input type="hidden" id="recover_password_uniqueid" value="<?php echo $id ;?>" />
			<div id="recover_confirm_password_container">
			<span>Confirm Password:</span>
			<input style="border:1px solid gray;width:200px;height:25px;" type="password" name="confirmpass" id = "confirmpass"/>
			</div>
			<input style="border:1px solid gray;width:160px;height:30px;" type="submit" name="change" value="Change Password" id = "change" onclick="action.recover_password(this)"/>
			<span id = "recover_password_info" style='color:#00ccff;margin-left:12;'></span>
			</div>
		<?php
		}
		else 
		{	
		?>
			<div style="position:relative;top:7em;left:5em;">
			<br/><h3><span style="color:#000000">Invalid Account or Probably the link has out-dated</span></h3>
			</div>
		<?php	
		}
		$file->script_welcome();
	}
	else
	{
		?>
			<div style="position:relative;top:7em;left:5em;">
			<br/><h3><span style="color:#000000">Invalid Link</span></h3>
			</div>
		<?php	
	}
}
else if(isset($_GET['click']) && $_GET['click']=='forgot_password')
{
?>
	<div id="forgot_password_box">
	<span style="color:#000000">
	Please enter your email to recover your password
	</span>
	<div style="margin:20 0 20 0;">
	<span>Enter your Email:*</span>
	<input type="text" style="border:1px solid gray;width:200px;height:25px;" id = "forgot_password_email" /> 
	</div>
	<div style="margin:10 0 10 120;">
	<input style="border:1px solid gray;width:100px;height:25px;" type="submit" name="submit" value="Submit" onclick="action.forgot_password(this)" id = "forgot_password_button" style ="margin-top:3px;" />
	</div>
	<span id = "forgot_password_info"></span>
	</div>
<?php
	$file->script_welcome();
}
else if(isset($_GET['error']) && $_GET['error'] == 'empty')
{
	echo '<div id="qm_description"><h1 style="color:#770000">Please enter both email and password.</h1></div>';
}
else if(isset($_GET['error']) && $_GET['error'] == 'incorrect_email_or_password')
{
	echo '<div id="qm_description"><h1 style="color:#770000">Incorrect email or password. Please try again.</h1></div>';
}
else
{
		setcookie("console","did not get all get values",time()+3600000,'/','.quipmate.com');
?>
	<div style="font-size:2em;color:#336699;">Join Quipmate Today</div>
	<div style="font-size:1.4em;color:#336699;" id="signup_info">Making Professional Life a bit Personal</div>
	<div style="">
		<input type="text" value="" placeholder="Enter your email address" id="signup_email" style="border: 0.1em solid #aaaaaa;font-size:1.6em;height:1.3em;padding:0.5em;width:19em;" />
		<input type="submit" value="SignUp" id="signup_email_button" style="border:0.1em solid #EEF4DD;color:#ffffff;cursor:pointer;font-size:1.6em;background-color:#336699;height:2.4em;padding:0.5em;width:6em;" onclick="action.self_invite(this)"/>
	</div>
	    <?php
			$file->script_welcome();
}	
?>
</div>
</div>

<div id="footer"> 
	<a href="#" target="_blank">&copy; Quipmate</a><span class="separator">|</span>
	<a href="http://blog.quipmate.com/" target="_blank">Blog</a><span class="separator">|</span>
	<a href="http://faq.quipmate.com/" target="_blank">FAQ</a><span class="separator">|</span>
	<a href="http://help.quipmate.com/" target="_blank">Help</a><span class="separator">|</span>
	<a href="http://developers.quipmate.com/" target="_blank">Developers</a><span class="separator">|</span>
	<a href="public/terms.php" target="_blank">Terms of Use</a>
</div>
<div style="position:fixed;bottom:0em;right:1em;text-align:center;width:16em;border:0.1em solid #cccccc;background-color:#ffffff;text-align:left;" id="message_leave">
    <div id="message_leave_title" onclick="ui.message_leave_grow(this)" style="height:1.5em;cursor:pointer;font-size:1.2em;padding:0.5em;background-color:#336699;color:#ffffff;font-weight:bold;">Leave a message<img src="https://wiki.nci.nih.gov/download/attachments/7475319/downArrow.gif?version=1&amp;modificationDate=1205778301000" style="float:right;" /></div>
</div>
</div>	  
</body>
</html>


