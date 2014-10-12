<!DOCTYPE html>
<html lang="en">
<head>
<?php
require_once '../include/header.php';
$college=$_SESSION['COLLEGE'];
$database= new Database();
$mcount = $database->unread_message_select($profileid,$college);
?>
<div class="container">
  <div class="row" >
    <div class="col-md-2 col-lg-2 left " id="left">
    <div class="panel panel-default">
    <div class="panel-body">
	<ul  class=" nav nav-pills nav-stacked ">  
		<li ><a class="links ajax_nav<?php if($page=='news_json') echo ' selected'; ?>" id="news_json" href="?hl=update" title="Updates from your followings"><span >News Feed</span></a></li>
		<!--<li ><a class="ajax_nav<?php// if($page=='tech_json') echo ' selected'; ?>" id="tech_json" href="?hl=technical" title="Feed from all technical groups that you have joined"><span >Technical Feed</span></a></li>-->
		<li ><a  class="links ajax_nav<?php if($page=='inbox') echo ' selected'; ?>" id="inbox" href="?hl=inbox" title="Messages from your colleagues"><span ><?php if($mcount) echo 'Messages('.$mcount.')'; else echo 'Messages'; ?></span></a></li>
		<li ><a class="links ajax_nav<?php if($page=='file') echo ' selected'; ?>" id="photo" href="profile.php?hl=file" title="Central location for all files on your network"><span >Knowledge Base</span></a></li>  
		<li ><a class="links ajax_nav<?php if($page=='new_user') echo ' selected'; ?>" id="new_user" href="?hl=new_user" title="Find out who joined Quipmate after you"><span >Co-workers</span></a></li>
	</ul>
    </div> 
    </div>
	<div class="panel panel-default">
	<div class="panel-heading">Groups</div>
    <div class="panel-body">
	<ul class="nav nav-pills nav-stacked">
		<?php						
		$result = $database->mygroup_select($myprofileid);
		while($row = $result->fetch_array())
		{
			$groupid = $row['groupid'];
			$nrow = $database->group_select($groupid);
			?>
			<li class="links"><a class="ajax_nav" href="group.php?id=<?php echo $groupid;?>" title="Groups"><span class="badge pull-right"></span><?php echo $nrow['name'];?></span></a></li>
			<?php
		}
		?>
	  <li class="">
		<a href="#" onclick="ui.group_create(this)"> <span class="badge pull-right"></span> Create Group</a>
	  </li>
	  <li class=""><a  href="register.php?hl=group_suggest" title="Groups"><span class="badge pull-right ellipsis "></span>Browse Groups</a></li>
	</ul>
    </div>
	</div>					
	<div class="panel panel-default">
	<div class="panel-heading">Events</div>
    <div class="panel-body">
	<ul class="nav nav-pills nav-stacked">
		<?php
	$result = $database->myevent_select($myprofileid,time());
	while($row = $result->fetch_array())
	{
		$eventid = $row['eventid'];
		?>
		<li class="links"><a class="ajax_nav" href="event.php?id=<?php echo $eventid;?>" title="Events"><span class="badge pull-right"></span> <?php echo $row['name'];?></a></li>
		
		<?php
	}
	?>
	<li class="">
		<a href="#" onclick="ui.event_create(this)"><span class="badge pull-right"></span> Create Event</a>
	</li>

	</ul>
    </div>
	</div>
	<div id="friend_event" class="panel panel-default"><div id="friend_event_body" class="panel-body"></div></div>
	<div style="margin-top:1em;padding-top:.5em;border-top:.1em solid #cccccc;">
		<a href="#" target="_blank"><small>&copy; Quipmate</small></a><span class="separator">|</span>
		<a href="public/help.php" target="_blank"><small>Help</small></a><span class="separator">|</span>
		<a href="#" onclick="ui.feedback(this)"><small>Feedback</small></a>
	</div> 
</div> 
	<?php
		if($page == 'news_json')
		{
			echo '<div id="center" class="col-md-6 center">';
			require('../include/actions.php');
			echo '</div>';
		}
		else
		{
			echo '<div id="center" class="col-md-6  center"></div>';
		}
	?>
	<div id="right" class="col-md-3 col-lg-3 right"> 
			<!--<div id="" class="right_item"><a style="cursor:pointer;" onclick="ui.direct_to_md(this,event)">Direct to MD</a></div>		
			<div id="blog_write" class="right_item"> <a href="action.php?hl=blog-write" >Write a blog</a></div> -->
		<div id="birthday_today" class="panel panel-default"></div>
		<div id="friend_invite" class="panel panel-default">
			<div id="friend_invite_heading" class="panel-heading"></div>
			<div id="friend_invite_body" class="panel-body"></div>
		</div>
	</div>
	</div>
</div>      <!-- wrapper closed(started in this page only)-->

	<?php require_once('../include/footer.php'); ?>
</body> 
</html>