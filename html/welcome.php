<?php

require_once ('../include/Database.php');
require_once ('../include/File.php');
if (isset($_SESSION))
{
    require_once ('../include/Session.php');
    $session = new Session();
    $database = new Database();
    $session->start();
    if (isset($_SESSION['auth']))
    {
        header('Location: /');
        exit;
    }
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

$file = new File();
$file->style_welcome();
$file->google_analytics();

?>
<title>Welcome To Quipmate | Enterprise Social Network</title>
</head>
<body>
<div class="container">
<div class="row" >
<div id="header" class="container">
	<div  class="col-md-6">
		<a href="/"><img src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/trans_shad_logo.png" width="250" alt="Quipmate" /></a>
	</div>
	<div  class="col-md-6">
		<form class="top1" name="input" method="post" action ="login_submit.php" target="_parent">
			<input type="email" name="email" placeholder="Email" id="login_email" value="<?php

if (isset($_COOKIE['quip_e']))
    echo $_COOKIE['quip_e'];

?>">
			<input type="password" name="password"  placeholder="Password"  id="login_pass" value=""> 
			<input type="submit" name="login" value="LOGIN" id = "login_button">
			<div id="remember_forgot">
				<input id="remember_checkbox" type="checkbox" name="remember" checked />Remember Me
				<a id="forgot_link" href="welcome.php?click=forgot_password" >Forgot Password</a>
			</div>
		</form> 
	</div>
</div>
<div class="col-md-6 thumbnail thumbnail_welcome" >
	<img src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/ccc.jpg" style="height:20em;"/>
	<h4 class="text-center">Connect &middot; Create &middot; Collaborate</h4>
</div>
<div class="col-md-6 thumbnail thumbnail_welcome">
<?php

if (isset($_GET['email']) && isset($_GET['identifier']) && trim($_GET['email']) !='')
{
    require_once ('../include/Session.php');
    require_once ('../include/Help.php');
    $session = new Session();
    $database = new Database();
    $session->start();
    $help = new Help();
    $email = $_GET['email'];
    if ($help->is_email($email))
    {
        $database = new Database();
        $help->assign_database($email, $database);
        $database = null;
        $database = new Database();
        $row = $database->is_already_user($email);
        if ($row['EMAIL'] != $email)
        {
            setcookie("console", "is_ not already_user", time() + 3600000, '/',
                '.quipmate.com');
            $identifier = $_GET['identifier'];
            $row = $database->virtual_select($email, $identifier);
            if ($row != 0 && $email == $row['EMAIL'] && $identifier == $row['UNIQUEID'])
            {
                $email = $row['EMAIL'];
                $nr = explode('@', $email);
                $new_member = $nr[0];

?>
		<div style="margin-left:3em;">
			<h3><?php

                echo 'Hi ' . $new_member . ',';

?></h3>
			<h4>Welcome to the Quipmate community !</h4>
			<h5>Please provide these details :</h5>
			<div id="info"></div>
			<div >
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

                for ($i = 1; $i <= 31; $i++)
                {
                    echo '<option value="' . $i . '">' . $i . '</option>';
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

                for ($i = 2002; $i >= 1901; $i--)
                {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                }

?>
			</select>
			</div>
			<div id="signup_button_container">
			<input type="hidden" id="email_hidden" value="<?php

                echo $email;

?>" />
			<input type="hidden" id="identifier_hidden" value="<?php

                echo $identifier;

?>" />
			<input id ="signup_button" type="submit" value="SIGNUP" onclick="action.register(this)" />
			</div>
			<span id="icon"></span>
			<?php

                $file->script_welcome();

?>
			</div>
			
		<?php

            } else
            {

?>
		<h1 id="register_title"><?php

                echo 'The invitation link sent to you seems to be broken. Please try again.';

?></h1>
	<?php

            }
        } else
        {

?>
	<div id="qm_description">
	<h3>Welcome To Quipmate.</h3>
	<h5>You are already a part of Quipmate</h5>
	<h5>Please Login using your email and password.</h5>
	<h5>If you forgot your password, please use forgot password link to recover it.</h5>
	</div>
<?php

        }
        $file->script_jquery();
    } else
    {

    }
} else
    if (isset($_GET['id']) && isset($_GET['email']) && isset($_GET['click']))
    {
        $click = $_GET['click'];
        if ($click == 'recover_password')
        {
            require_once ('../include/Database.php');
            require_once ('../include/Session.php');
            require_once ('../include/Help.php');
            $session = new Session();
            $database = new Database();
            $session->start();
            $flag = 0;
            $id = $_GET['id'];
            $email = $_GET['email'];
            $help = new Help();
            $database = new Database();
            $help->assign_database($email, $database);
            $database = null;
            $database = new Database();
            $uniqueid = $database->select_uniqueid($email);
            if ($uniqueid == $id)
            {

?>
			<div id="recover_password_box"> 
				<h3>Reset your password</h3>
				<div id="recover_new_password_container">
					<span style="padding-right:20px;">New Password:</span>
					<input style="border:0.1em solid gray;width:20em;margin:1em;" type="password" name="pass" id = "pass"/>
				</div>
				<input type="hidden" id="recover_password_email" value="<?php

                echo $email;

?>" />
				<input type="hidden" id="recover_password_uniqueid" value="<?php

                echo $id;

?>" />
				<div id="recover_confirm_password_container">
					<span>Confirm Password:</span>
					<input style="border:0.1em solid gray;width:20em;margin:1em;" type="password" name="confirmpass" id = "confirmpass"/>
				</div>
				<div style="margin:2em 0em 0em 6em;">
					<input class="theme_button" type="submit" name="change" value="Reset Password" id = "change" onclick="action.recover_password(this)"/>
					<span id = "recover_password_info" style="color:#336699;margin-left:1.2em;"></span>
				</div>
			</div>
		<?php

            } else
            {

?>
			<div style="position:relative;top:7em;left:5em;">
			<br/><h5>Invalid Account or Probably the link has been out-dated .</h5>
			</div>
		<?php

            }
            $file->script_welcome();
        } else
        {

?>
			<div style="position:relative;top:7em;left:5em;">
			<br/><h5>Invalid Link</span></h5>
			</div>
		<?php

        }
    } else
        if (isset($_GET['click']) && $_GET['click'] == 'forgot_password')
        {
            require_once ('../include/Session.php');
            $session = new Session();
            $session->start();

?>
	<div >
		<div class="well well-sm"><h3>Forgot your password?<h3></div>
		<div class="panel-body">
			<span>Enter your Email:*</span>
			<input type="text" style="border:0.1em solid gray;width:18em;padding:0.5em;" id = "forgot_password_email" /> 
			<input class="theme_button" type="submit" name="submit" value="Submit" onclick="action.forgot_password(this)" id = "forgot_password_button"/>
		</div>
		<span id = "forgot_password_info"></span>
	</div>
<?php

            $file->script_welcome();
        } else
            if (isset($_GET['error']) && $_GET['error'] == 'empty')
            {
                echo '<div id="qm_description"><h5 style="color:#770000">Please enter both email and password.</h5></div>';
            } else
                if (isset($_GET['error']) && $_GET['error'] == 'incorrect_email_or_password')
                {
                    echo '<div id="qm_description"><h5 style="color:#770000">Incorrect email or password. Please try again.</h5></div>';
                } else
                {
                    setcookie("console", "did not get all get values", time() + 3600000, '/',
                        '.quipmate.com');

?>
	<div class="text-center"><h3>Join and Invite your Peers to Quipmate</h3></div>

	<div class="caption thumbnail_welcome_box">
		<h4 class="caption text-center" id="signup_info">Making Professional Lives a bit Personal</h3>
		<div class="panel-body text-center">
		<input type="text" value="" placeholder="Enter your email address" id="signup_email" style="border: 0.1em solid #aaaaaa;font-weight:bold;padding:0.8em;width:22em;background-color:#ffffff;" />
		<input type="submit" value="SignUp" id="signup_email_button" style="border:0.1em solid #EEF4DD;color:#ffffff;cursor:pointer;background-color:#339970;padding:0.8em;font-weight:bold;" onclick="action.self_invite(this)"/>
		</div>
	</div>
	    <?php

                    $file->script_welcome();
                }

?>

</div>
<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/pricing_social_networking.png" style=" height: 100px;">
<div class="caption">
<h4 style="margin-top:0;margin-bottom:6px;">Enterprise Social Networking</h4>
<ul><li><div>Private Messages</div></li><li><div>Employee Profile</div></li><li><div>Chat</div></li><li><div>Groups</div></li><li><div>Email Updates</div></li><li><div>Notifications</div></li></ul>
</div>
</div>
<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/pricing_team_collaboration.png" style=" height: 100px;">
<div class="caption"><h4 style="margin-top:0;margin-bottom:6px;">Team Collaboration</h4>
<ul><li><div>Public/Private Groups</div></li><li><div>File Sharing</div></li><li><div>Praise/Recommend Peers</div></li><li><div>Link Sharing</div></li><li><div>Questions/Polls</div></li><li><div>Ideas</div></li></ul></div>
</div>
<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/pricing_admin_control.png" style=" height: 100px;"><div class="caption"><h4 style="margin-top:0;margin-bottom:6px;">Admin Control</h4><ul><li><div>Invite/Remove User</div></li><li><div>Design</div></li><li><div>Broadcast Messages</div></li><li><div>Data Export</div></li></ul></div>
</div>
<!--
<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/pricing_enterprise_integration_0.png" style=" height: 100px;"><div class="caption"><h4 style="margin-top:0;margin-bottom:6px;">External Api Integration</h4><ul><li><div>Linkedin</div></li><li><div>Evernote</div></li><li><div>Google</div></li><li><div>Dropbox</div></li><li><div>Box</div></li></ul></div>
</div>
-->
<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/pricing_mobile_desktop.png" style=" height: 100px;"><div class="caption"><h4 style="margin-top:0;margin-bottom:6px;">Mobile &amp; Desktop</h4><ul><li><div>Chat/Messenger</div></li><li><div>Android</div></li></ul></div>
</div>
</tr>
<tr>
<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/pricing_deployment_options.png" style=" height: 100px;"><div class="caption"><h4 style="margin-top:0;margin-bottom:6px;">Deployment Options</h4><ul><li><div>Cloud Hosted</div></li><li><div>On Premise/Intranet</div></li></ul></div>
</div>


<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/pricing_security_compliance4.png" style=" height: 100px;"><div class="caption"><h4 style="margin-top:0;margin-bottom:6px;">Security &amp; Compliance</h4><ul><li><div>Keyword Monitoring</div></li><li><div>Delete Any content</div></li><li><div>Admin Notifications</div></li><li><div>Password Policy</div></li></ul></div>
</div>


<!--
<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" style="height:100px;" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/direct_to_md_welcome.jpg">
<div class="caption"><h4 style="margin-top:0;margin-bottom:6px;">Direct to MD</h4></div>
<div >Write open or private letter to the Executive body of the organization</div>
</div>
<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box"> 
<img alt="" style="height:100px;" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/directors_blog_welcome.jpg">
<div class="caption"><h4>Director’s Blog</h4></div>
<div >Write blogs on daily/weekly basis relating to technical breakthrough, what is the goal of the product and how the contribution of every single person in that project is mapped to the customer’s needs</div>
</div>
-->
<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" style="height:100px;" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/group_welcome.jpg" ><div class="caption"><h4>Group</h4></div>
<div >Keep essential API, product documents for the whole team. Access everyone’s contribution on daily basis and encourage team to participate in problem solving</div>
</div>
<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" style="height:100px;" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/profile_welcome.jpg"><div class="caption"><h4>Profile</h4></div>
<div >Brief personal and professional background of that person, the groups he attended, praises he received.</div>
</div>

<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" style="height:100px;" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/praise_welcome.jpg"/p><div class="caption"><h4>Praise/Recommend </h4></div><div >Whatever gets measured and awarded gets done. So praise your peers for their contributions and recognize their talents</div>
</div>

<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" style="height:100px;" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/poll_question_welcome.jpg"><div class="caption"><h4>Poll/Question</h4></div><div >Trainees use Questions feature to ask questions to their team to learn about the product and company culture and methodology, procedures quickly</div>
</div>

<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" style="height:100px;" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/event_welcome.jpg"><div class="caption"><h4>Events</h4></div><div >Organize your company events like annual day or thanks giving day in highly efficient way</div>
</div>

<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" style="height:100px;" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/moderation_welcome.jpg"><div class="caption"><h4>Moderation</h4></div><div >Broadcast content. Remove any user. Remove any content. Set On/Off features for whole network. System configurable for any number of moderators.</div>
</div>

<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" style="height:100px;" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/news_feed_welcome.jpg"><div class="caption"><h4>News Feed </h4></div><div >Get updates on latest updates in your company.</div>
</div>

<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" style="height:100px;" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/live_feed_welcome.jpg"><div class="caption"><h4>Live Feed</h4></div><div >Instant update/visibility on every minor action done in the company</div>
</div>

<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" style="height:100px;" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/link_sharing_welcome.jpg"><div class="caption"><h4>Link Sharing</h4></div><div >Share any link/website on the internet/intranet with people in your organization</div>
</div>

<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" style="height:100px;" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/file_sharing_welcome.jpg"><div class="caption"><h4>File Sharing</h4></div><div >File/video/photo sharing and version management</div>
</div>

<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" style="height:100px;" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/mood_welcome.jpg" ><div class="caption"><h4>Mood Meter</h4></div><div >Analyse the mood of the organization</div>
</div>

<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" style="height:100px;" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/notification_welcome.jpg"><div class="caption"><h4>Notification</h4></div><div >Notification on email and website</div>
</div>
<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" style="height:100px;" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/birthday_reminder.jpg"><div class="caption"><h4>Birthday Updates</h4></div><div >Birthday/anniversary and important events updates from all people in your network</div>
</div>
<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" rel="lightbox" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/pricing_analytics.png" style=" height: 100px;">
<div class="caption"><h4 style="margin-top:0;margin-bottom:6px;">Analytics</h4><ul><li><div>Periodic Usage</div></li><li><div>Reporting</div></li></ul></div>
</div>



<div class="col-md-12"><div class="well well-sm text-center"><h4>How do we price ourselves?</h4></div>
</div>

<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" style="height:100px;" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/free_welcome.jpg">
<h4 style="margin-top:0;margin-bottom:6px;">Free</h4>
<ul><li><div>First Month for all</div></li><li><div>Always if Employee strength < 50</div></li><li><div>Only for Cloud Hosted</div></li></ul>
</div>
<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" style="height:100px;" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/basic_welcome.png">
<h4>Basic</h4>
<ul><li><div>$1 per employee per month</div></li><li><div>Free 3 Months Trial</div></li></ul>
</div>
<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" style="height:100px;" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/premium_welcome.jpg" >
<h4>Premium</h4>
<ul><li><div>$2 per employee per month</div></li><li><div>Free 3 Months Trial</div></li></ul>
</div>
<div class="col-md-3 thumbnail thumbnail_welcome thumbnail_welcome_box">
<img alt="" style="height:100px;" src="https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com/premises_welcome.png"><h4>Premises</h4>
<ul><li><div>Additional price of $3 per employee per month</div></li></ul>
</div>

</div>
<div id="footer"> 
	<a href="#" target="_blank">&copy; Quipmate</a><span class="separator">|</span>
	<a href="public/blog.php" target="_blank">Blog</a><span class="separator">|</span>
	<a href="public/faq.php" target="_blank">FAQ</a><span class="separator">|</span>
	<a href="public/help.php" target="_blank">Help</a><span class="separator">|</span>
	<a href="public/team.php" target="_blank">Team</a><span class="separator">|</span>
	<a href="public/terms.php" target="_blank">Terms of Use</a><span class="separator">|</span>
	<a href="public/security.php" target="_blank">Security &amp; Compliance</a><span class="separator">|</span>
	<a href="public/privacy.php" target="_blank">Privacy Policy</a>
</div>
<div style="position:fixed;bottom:0em;right:2em;background-color:#dddddd;" id="message_leave">
	<div id="message_leave_title" onclick="ui.message_leave_grow(this)" style="cursor:pointer;font-size:1.2em;padding:0.5em;width:14em;background-color:#4c66a4;color:#ffffff;font-weight:bold;">Leave a message<img src="https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com/downarrow.gif" style="float:right;" /></div>
</div>
</body>
</html>