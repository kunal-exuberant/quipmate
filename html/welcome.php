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
<meta name="description" content="Quipmate enhances the productivity of your organization by connecting people, conversations, project and ideas in a private network"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
<meta name= "url" content="http://www.quipmate.com"/>
<meta name= "keywords" content="enterprise social network, social, profile, collaboration, team, files sharing, project, idea sharing, innovation, creativity, conversation, knowledge management, engagement platform, identify hidden experts, breakdown silos, improve transparency, poll, questions, democratic decision making, enterprise 2.0, microblogging, employee engagement, groups, bottom-up communication, human capital"/>
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
		<a href="/"><img src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/trans_shad_logo.png" width="250" alt="Quipmate" /></a>
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
<div id="main_container">
<div id="qm_description">
<div>
	<img src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/ccc.jpg" style="height:12em;"/>
	<div style="font-size:1em;">Connect &middot; Create &middot; Collaborate</div>
</div>
</div>
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
		$email = $_GET['email']; 
		$help = new Help();
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
	<div style="font-size:2.4em;color:#555555;">Join and Invite your Peers to Quipmate</div>
	<div style="font-size:1.4em;color:#555555;" id="signup_info">Making Professional Lives a bit Personal</div>
	<div style="background-color:#eeeeee;padding: 2.4em;">
		<input type="text" value="" placeholder="Enter your email address" id="signup_email" style="border: 0.1em solid #aaaaaa;font-size:1.6em;height:1.2em;padding:0.5em;width:19em;background-color:#ffffff;" />
		<input type="submit" value="SignUp" id="signup_email_button" style="border:0.1em solid #EEF4DD;color:#ffffff;cursor:pointer;font-size:1.6em;background-color:#339970;height:2.4em;padding:0.5em;width:6em;font-weight:bold;" onclick="action.self_invite(this)"/>
	</div>
	    <?php
			$file->script_welcome();
}	
?>
</div>
			
			
			
			
					
		<div class="field field-name-field-text-bottom field-type-text-long field-label-hidden" style="margin:8 em 4em;">
			<div class="field-items">
				<div class="field-item even"> 
					<div style="text-align:center;background-color:#eeeeee;color:#888888;font-size: 2.2em;margin-bottom: 0.2em;padding: 0.2em;">What do we provide?</div>
						<table class="sc-features-table">
							<tbody>
								<tr>
									<td>
										<p style="text-align: center; height: 110px;"><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/pricing_social_networking.png" style="width: 210px; height: 175px;"></p>
										<h4 style="margin-top:0;margin-bottom:6px;">Enterprise Social Networking</h4>
										<ul><li><div>Private Messages</div></li><li><div>Employee Profile</div></li><li><div>Chat</div></li><li><div>Groups</div></li><li><div>Email Updates</div></li><li><div>Notifications</div></li></ul>
									</td>
									<td>
										<p style="text-align: center; height:115px "><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/pricing_team_collaboration.png" style="width: 210px; height: 175px;"></p>
										<h4>Team Collaboration</h4>
										<ul><li><div>Public/Private Groups</div></li><li><div>File Sharing</div></li><li><div>Praise/Recommend Peers</div></li><li><div>Link Sharing</div></li><li><div>Questions/Polls</div></li><li><div>Ideas</div></li></ul>
									</td>
									<td>
										<p style="text-align:center;height:119px"><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/pricing_analytics.png" style="width: 210px; height: 175px;"></p>
										<h4>Analytics</h4><ul><li><div>Periodic Usage</div></li><li><div>Reporting</div></li></ul>
									</td>
									<td class="nbr">
										<p style="text-align: center;height:124px; "><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/pricing_mobile_desktop.png" style="width: 210px; height: 175px;"></p><h4>Mobile &amp; Desktop</h4><ul><li><div>Chat/Messenger</div></li><li><div>Android</div></li></ul>
									</td>
								</tr>
								<tr>
									<td class="nbb">
										<p style="text-align: center; height: 140px;"><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/pricing_deployment_options.png" style="width: 210px; height: 175px;"></p><h4>Deployment Options</h4><ul><li><div>Cloud Hosted</div></li><li><div>On Premise/Intranet</div></li></ul>
									</td>
									<td class="nbb">
										<p style="text-align: center;height: 140px; "><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/pricing_enterprise_integration_0.png" style="width: 210px; height: 175px;"></p><h4>External Api Integration</h4><ul><li><div>Linkedin</div></li><li><div>Evernote</div></li><li><div>Google</div></li><li><div>Dropbox</div></li><li><div>Box</div></li></ul>
									</td>
									<td class="nbb">
										<p style="text-align: center; height: 140px;"><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/pricing_admin_control.png" style="width: 210px; height: 175px;"></p><h4>Admin Control</h4><ul><li><div>Invite/Remove User</div></li><li><div>Design</div></li><li><div>Broadcast Messages</div></li><li><div>Data Export</div></li></ul>
									</td>
									<td class="nbr nbb">
										<p style="text-align: center; height: 140px;"><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/pricing_security_compliance4.png" style="width: 210px; height: 175px;"></p><h4>Security &amp; Compliance</h4><ul><li><div>Keyword Monitoring</div></li><li><div>Delete Any content</div></li><li><div>Admin Notifications</div></li><li><div>Password Policy</div></li></ul>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div> 
			
			<div class="field field-name-field-text-bottom field-type-text-long field-label-hidden" style="margin:2em 4em;">
			<div class="field-items">
				<div class="field-item even"> 
					<div style="text-align:center;background-color:#eeeeee;color: #888888;font-size: 2.2em;margin-bottom: 0.2em;padding:0.2em;">What are the features?</div>
						<table class="sc-features-table">
							<tbody>
								<tr>
									<td>
										<p style="text-align: center; height: 110px;"><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/direct_to_md_welcome.jpg"></p>
										<h4 style="margin-top:0;margin-bottom:6px;">Direct to MD</h4>
										<div class="feature_content">Write open or private letter to the Executive body of the organization</div>
									</td>
									<td> 
										<p style="text-align: center; height:115px "><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/directors_blog_welcome.jpg"></p>
										<h4>Director’s Blog</h4>
										<div class="feature_content">Write blogs on daily/weekly basis relating to technical breakthrough, what is the goal of the product and how the contribution of every single person in that project is mapped to the customer’s needs</div>
									</td>
									<td>
										<p style="text-align:center;height:119px"><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/group_welcome.jpg" ></p>
										<h4>Group</h4>
										<div class="feature_content">Keep essential API, product documents for the whole team. Access everyone’s contribution on daily basis and encourage team to participate in problem solving</div>
									</td>
									<td class="nbr">
										<p style="text-align: center;height:124px; "><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/profile_welcome.jpg"></p><h4>Profile</h4>
										<div class="feature_content">Brief personal and professional background of that person, the groups he attended, praises he received.</div>
									</td>
								</tr>
								<tr>
									<td>
										<p style="text-align: center; height: 140px;"><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/praise_welcome.jpg"/p><h4>Praise/Recommend </h4><div class="feature_content">Whatever gets measured and awarded gets done. So praise your peers for their contributions and recognize their talents</div>
									</td>
									<td>
										<p style="text-align: center;height: 140px; "><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/poll_question_welcome.jpg"></p><h4>Poll/Question</h4><div class="feature_content">Trainees use Questions feature to ask questions to their team to learn about the product and company culture and methodology, procedures quickly</div>
									</td>
									<td>
										<p style="text-align: center; height: 140px;"><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/event_welcome.jpg"></p><h4>Events</h4><div class="feature_content">Organize your company events like annual day or thanks giving day in highly efficient way</div>
									</td>
									<td class="nbr">
										<p style="text-align: center; height: 140px;"><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/moderation_welcome.jpg"></p><h4>Moderation</h4><div class="feature_content">broadcast content. Remove any user. Remove any content. Set On/Off features for whole network. System configurable for any number of moderators.</div>
									</td>
								</tr>
								<tr>
									<td>
										<p style="text-align: center; height: 140px;"><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/news_feed_welcome.jpg"></p><h4>News Feed </h4><div class="feature_content">Get updates on latest updates in your company.</div>
									</td>
									<td>
										<p style="text-align: center;height: 140px; "><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/live_feed_welcome.jpg"></p><h4>Live Feed</h4><div class="feature_content">Instant update/visibility on every minor action done in the company</div>
									</td>
									<td>
										<p style="text-align: center; height: 140px;"><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/link_sharing_welcome.jpg"></p><h4>Link Sharing</h4><div class="feature_content">Share any link/website on the internet/intranet with people in your organization</div>
									</td>
									<td class="nbr">
										<p style="text-align: center; height: 140px;"><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/file_sharing_welcome.jpg"></p><h4>File Sharing</h4><div class="feature_content">File/video/photo sharing and version management</div>
									</td>
								</tr>
								<tr>
									<td class="nbb">
										<p style="text-align: center; height: 140px;"><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/mood_welcome.jpg" ></p><h4>Mood Meter</h4><div class="feature_content">Analyse the mood of the organization</div>
									</td>
									<td class="nbb">
										<p style="text-align: center;height: 140px; "><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/notification_welcome.jpg"></p><h4>Notification</h4><div class="feature_content">Notification on email and website</div>
									</td>
									<td class="nbb">
										<p style="text-align: center; height: 140px;"><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/birthday_reminder.jpg"></p><h4>Birthday Updates</h4><div class="feature_content">Birthday/anniversary and important events updates from all people in your network</div>
									</td>
									<td class="nbb nbr">
										<p style="text-align: center; height: 140px;"><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/bio_welcome.jpg" </p><h4>Bio/Resume Sharing</h4><div class="feature_content">File/video/photo sharing and version management</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>	
			
			
			<div class="field field-name-field-text-bottom field-type-text-long field-label-hidden" style="margin:2em 4em;">
			<div class="field-items">
				<div class="field-item even"> 
					<div style="text-align:center;background-color:#eeeeee;color: #888888;font-size: 2.2em;margin-bottom: 0.2em;padding:0.2em;">How do we price ourselves?</div>
						<table class="sc-features-table">
							<tbody>
								<tr>
									<td class="nbb">
										<p style="text-align: center; height: 110px;"><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/free_welcome.jpg"></p>
										<h4 style="margin-top:0;margin-bottom:6px;">Free</h4>
										<ul><li><div>First Month for all</div></li><li><div>Always if Employee strength < 50</div></li><li><div>Only for Cloud Hosted</div></li></ul>
									</td>
									<td class="nbb"> 
										<p style="text-align: center; height:115px "><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/basic_welcome.png"></p>
										<h4>Basic</h4>
										<ul><li><div>$1 per employee per month</div></li></ul>
									</td>
									<td class="nbb">
										<p style="text-align:center;height:119px"><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/premium_welcome.jpg" ></p>
										<h4>Premium</h4>
										<ul><li><div>$2 per employee per month</div></li></ul>
									</td>
									<td class="nbb nbr">
										<p style="text-align: center;height:124px; "><img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/premises_welcome.png"></p><h4>Premises</h4>
										<ul><li><div>Additional price of $3 per employee per month</div></li></ul>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>	
			
</div>

<div id="footer"> 
	<a href="#" target="_blank">&copy; Quipmate</a><span class="separator">|</span>
	<a href="http://blog.quipmate.com/" target="_blank">Blog</a><span class="separator">|</span>
	<a href="http://faq.quipmate.com/" target="_blank">FAQ</a><span class="separator">|</span>
	<a href="http://help.quipmate.com/" target="_blank">Help</a><span class="separator">|</span>
	<a href="http://developers.quipmate.com/" target="_blank">Developers</a><span class="separator">|</span>
	<a href="public/terms.php" target="_blank">Terms of Use</a><span class="separator">|</span>
	<a href="public/security.php" target="_blank">Security &amp; Compliance</a><span class="separator">|</span>
	<a href="public/privacy.php" target="_blank">Privacy Policy</a>
</div>
</div>	  
</body>
</html>