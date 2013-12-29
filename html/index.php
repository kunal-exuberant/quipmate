<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
<?php
require_once '../include/header.php';
$profileid = $myprofileid;
$college=$_SESSION['COLLEGE'];
$database= new Database();
$mcount = $database->unread_message_select($profileid,$college);
?>
<div id="wrapper">
	<div id="left">
			<a href="profile.php?id=<?php echo $myprofileid ?>"><img style="float:left;border:.2em solid #f9f9f9;margin:0em 0.5em 0em 0em;" src="<?php echo $_SESSION['pimage']; ?>" width="45" height="45" /></a>
			<div style="display:block;">
				<div>
					<a style="font-weight:bold;" href="profile.php?id=<?php echo $myprofileid ?>"><?php echo $_SESSION['NAME']; ?></a>
				</div>
				<div style="margin-top:0.5em;">
					<a style="color:#003399;" href="profile.php?hl=bio">Edit My Profile</a>
				</div>
			</div>  
			<ul style="list-style:none;clear:left;margin-top:3em;" id="links">  
					<li class="links"><a class="ajax_nav<?php if($page=='news_json') echo ' selected'; ?>" id="news_json" href="?hl=update" title="Updates from your friends"><img class="lfloat" src="http://icon.qmcdn.net/news_rss.png" height="18" width="18" /><span class="name_20">News Feed</span></a></li>
					
					<li class="links"><a  class="ajax_nav<?php if($page=='inbox') echo ' selected'; ?>" id="inbox" href="?hl=inbox" title="Messages from your friends"><img class="lfloat" src="http://icon.qmcdn.net/message.png" height="18" width="18" /><span class="name_20"><?php if($mcount) echo 'Messages('.$mcount.')'; else echo 'Messages'; ?></span></a></li>
					
					<li class="links"><a class="ajax_nav<?php if($page=='photo') echo ' selected'; ?>" id="photo" href="?hl=image" title="Photo shared by your friends"><img class="lfloat" src="http://icon.qmcdn.net/world.png" height="18" width="18" /><span class="name_20">Photos</span></a></li>  
					<li class="links"><a class="ajax_nav<?php if($page=='new_user') echo ' selected'; ?>" href="?hl=new_user" title="Find out who joined Quipmate after you"><img class="lfloat" src="http://icon.qmcdn.net/group.png" height="18" width="18" /><span class="name_20">New Users</span></a></li>
						
					<?php
					if($_SESSION['database'] == 'profile')
					{
					?>	
						<li class="links"><a class="ajax_nav<?php if($page=='college_mate') echo ' selected'; ?>" href="?hl=college_mate" title="Connect with people from your college"><img class="lfloat" src="http://icon.qmcdn.net/alma_mater.jpg" height="18" width="18" /><span class="name_20">Collegemates</span></a></li>
						<li class="links"><a href="college_connect.php" title="Connect with people from different colleges"><img class="lfloat" src="http://icon.qmcdn.net/connect.png"  height="18" width="18" /><span class="name_20">College Connect</span></a></li>
					<?php
					}
					?>
					
					<li class="links"><a href="#" onclick="ui.event_create(this)" title="Create an event"><img class="lfloat" src="http://icon.qmcdn.net/event.png"  height="18" width="18"  /><span class="name_20">Create Event</span></a></li>
					<?php
					$result = $database->myevent_select($myprofileid);
						while($row = $result->fetch_array())
						{
							$eventid = $row['eventid'];
							$nrow = $database->event_select($eventid);
							?>
							<li class="links"><a href="event.php?id=<?php echo $eventid;?>" title="Events"><img class="lfloat" src="http://icon.qmcdn.net/event.png" height="18" width="18"  /><span class="name_20"><?php echo $nrow['name'];?></span></a></li>
							<?php
						}
					?>	
					
					<li class="links"><a href="#" onclick="ui.group_create(this)" title="Create a group for people with a specific interest"><img class="lfloat" src="http://icon.qmcdn.net/group.png" height="20" width="20" /><span class="name_20">Create Group</span></a></li>
					
					<?php
						
						$result = $database->mygroup_select($myprofileid);
						while($row = $result->fetch_array())
						{
							$groupid = $row['groupid'];
							$nrow = $database->group_select($groupid);
							?>
							<li class="links"><a href="group.php?id=<?php echo $groupid;?>" title="Groups"><img class="lfloat" src="http://icon.qmcdn.net/group.png" height="18" width="18" /><span class="name_20"><?php echo $nrow['name'];?></span></a></li>
							<?php
						}
					?>

			</ul> 
			<div id="friend_event" class="right_item" style="margin:1em 0em 0em 0em;padding:0em;"></div>
			<div style="margin-top:1em;padding-top:.5em;border-top:.1em solid #cccccc;">
				<a href="#" target="_blank"><small>&copy; Quipmate</small></a><span class="separator">|</span>
				<a href="public/help.php" target="_blank"><small>Help</small></a><span class="separator">|</span>
				<a href="public/terms.php" target="_blank"><small>Terms of Use</small></a>
			</div>
	</div>
	<?php
		if($page == 'news_json')
		{
			echo '<div id="center" >';
			require('../include/actions.php');
			echo '</div>';
		}
		else
		{
			echo '<div id="center" ></div>';
		}
	?>
	<div id="right"> 
		<?php
		if($_SESSION['database'] != 'profile')
		{
		?>	
			<div id="" class="right_item"> <img src="http://icon.qmcdn.net/MD_new.png" style = "cursor:pointer;" height="20" width="20" onclick="ui.direct_to_md(this,event)" /><a style="cursor:pointer;" onclick="ui.direct_to_md(this,event)">Direct to MD</a></div>		
			<div id="blog_write" class="right_item"> <a href="action.php?hl=blog-write" > <img src="http://icon.qmcdn.net/blog_blue.png" style = "cursor:pointer;" height="20" width="20"/>Write a blog</a></div>
		<?php
		}
		?>
		<div id="birthday_today" class="right_item"></div>
		<div id="friend_invite" class="right_item"></div>
	</div>
</div>      <!-- wrapper closed(started in this page only)-->
	<?php require_once('../include/footer.php'); ?>
</body> 
</html>

