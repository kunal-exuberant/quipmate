<?php 
require_once '../include/Session.php';
$session = new Session();
$session->start();
ob_start();	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>Quipmate Account Disabled</title>
<style>
*{font-size:13px;}
body{font-family:tahoma;verdana;background-color:#ededed;}
h1,h2,h3{font-family:Calibri Light,Lucida Grande,verdana;}
#wrapper{width:60.8em;margin: 0 auto;position: relative;padding: 1em;margin-top:4em;background:#fff;}
#header{position:fixed;top:0em;left:0em;width:100%;height:4em;background-color:#4c66a4;color:#ffffff;z-index:10;}
#header-wrapper{text-align:center;margin-top:0.1em;font-size:2.6em;color:#fff}

</style>
<link rel="stylesheet" type="text/css" href="https://7f0cf736abbdd4f83d8b-475de27d87a6fd312d1dd9701d87a2a9.ssl.cf2.rackcdn.com/bootstrap.min.css" charset="utf-8"/>
<?php
if($_SESSION['STEP'] == -2)
{ 
require_once '../include/File.php';	
$file = new File();
$file->script_welcome();
}
?>
</head>
<body>
<div id ="header">
<div id="header-wrapper">Quipmate
<span style="font-weight: bold;color:#fff;float:right;margin:1em 6em 0em 0em;"><a href="logout.php" style="color:#fff;">Logout</a></span>
</div>
</div>
<div class="container">
    <div class="row">
        <div class="panel panel-warning" style="margin-top:10em;">
        <div class="panel panel-heading"><h4>Account has been disabled </h4></div>
        <?php 
        if($_SESSION['STEP'] == -1)
        {
        ?>    
        <div class="panel-body">Admin of your network has disabled your account . You are no longer authorised to use Quipmate .Your organisation has full responsibility of content shared by you .You can contact to your organisation for any further inforamation . </div>
        <?php 
        }
        else if($_SESSION['STEP'] == -2)
        {  
        ?>
        <div class="panel-body">
        <div class="jumbotron">
  <h2>Hello, <?php echo $_SESSION['NAME'] ; ?></h2>
  <p><h5>You have disabled your account . Please enable to see the updates from your network . Share your thoughts and respond to anyone who wants to connect with you .</h5></p>
  <p><a class="btn btn-primary btn-lg" role="button" onclick="action.enable_user_account(this)">Enable</a></p>
</div></div>
        <?php
        }
        ?>
        </div>
    </div>
</div>
</body>
</html>
<?php

?>