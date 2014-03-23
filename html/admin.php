<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
<?php
require_once '../include/header.php';
require_once('../include/Help.php');
$profileid = $myprofileid;
$college=$_SESSION['COLLEGE'];
$database= new Database();
$help = new Help();
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
					<a style="color:#003399;" href="#">I am Admin</a>
				</div>
			</div>  
			<ul style="list-style:none;clear:left;margin-top:3em;" id="links"> 
					<li class="links"><a class="ajax_nav<?php if($page=='admin_json') echo ' selected'; ?>" id="news_json" href="?hl=update" title="Updates from your friends"><img class="lfloat" src="http://icon.qmcdn.net/news_rss.png" height="18" width="18" /><span class="name_20">Admin Feed</span></a></li>
					<li class="links"><a class="ajax_nav<?php if($page=='invite') echo ' selected'; ?>" id="news_json" href="?hl=invite" title="Invite fellow assciates to the network"><img class="lfloat" src="http://icon.qmcdn.net/friends_blue.png" height="18" width="18" /><span class="name_20">Invite Employees</span></a></li>
					<li class="links"><a class="ajax_nav<?php if($page=='admin') echo ' selected'; ?>" id="news_json" href="?hl=admin" title="List of all admins of this network"><img class="lfloat" src="http://icon.qmcdn.net/friends_blue.png" height="18" width="18" /><span class="name_20">Admin List</span></a></li>
					<li class="links"><a class="ajax_nav<?php if($page=='remove_user') echo ' selected'; ?>" id="news_json" href="?hl=remove_user" title="Updates from your friends"><img class="lfloat" src="http://icon.qmcdn.net/friends_blue.png" height="18" width="18" /><span class="name_20">Remover User</span></a></li>
					<!--
			        <li class="links"><a class="ajax_nav<?php if($page=='anlytics') echo ' selected'; ?>" id="news_json" href="?hl=analytics" title="Analytics"><img class="lfloat" src="http://icon.qmcdn.net/friends_blue.png" height="18" width="18" /><span class="name_20">Analytics</span></a></li>
					-->
					 <li class="links"><a class="ajax_nav<?php if($page=='feature') echo ' selected'; ?>" id="news_json" href="?hl=feature" title="Feature setting"><img class="lfloat" src="http://icon.qmcdn.net/friends_blue.png" height="18" width="18" /><span class="name_20">Control features</span></a></li>
            </ul> 
			<div name="page" style="margin-top:1em;">
			<span style="font-weight:bold;font-size:1em;color:gray">Pages</span>
			<ul>
					<?php						
						$result = $database->page_select_all();
						while($row = $result->fetch_array())
						{
							$pageid = $row['pageid'];
							$nrow = $database->page_select($pageid);
							?>
							<li class="links"><a href="page.php?id=<?php echo $pageid;?>" title="Groups"><img class="lfloat" src="http://icon.qmcdn.net/broadcast.png" height="18" width="18" /><span class="name_20 ellipsis"><?php echo $nrow['name'];?></span></a></li>
							<?php
						}
					?>
				<li class="links"><a href="#" onclick="ui.page_create(this)" title="Create a group for people with a specific interest"><img class="lfloat" src="http://icon.qmcdn.net/plus.png" height="13" width="13" /><span class="name_20">Create Page</span></a></li>
			</ul>
			</div>
			<div id="friend_event" class="right_item" style="margin:1em 0em 0em 0em;padding:0em;"></div>
			<div style="margin-top:1em;padding-top:.5em;border-top:.1em solid #cccccc;">
				<a href="#" target="_blank"><small>&copy; Quipmate</small></a><span class="separator">|</span>
				<a href="public/help.php" target="_blank"><small>Help</small></a><span class="separator">|</span>
				<a href="public/terms.php" target="_blank"><small>Terms of Use</small></a>
			</div>
	</div>
		<?php
		if($page == 'invite')
		{
		?>
			<div id="center">
				<h1 class="page_title">Invite Employees</h1>
					<div style="margin:3em;">
						<textarea placeholder="Paste a list of email address separated by comma" id="employee_invite_box" style="border:0.1em solid #aaaaaa;width:34.6em;height:20.2em;padding:0.5em;margin-right:0.2em;"></textarea>
						<input type="submit" onclick="action.employee_invite(this)" value="Invite" id="employee_invite_button" title="Invite A Friend" />
					</div>
			</div>
		<?php
		}
		else if($page == 'feature')
		{
			$row = array();
			$res = $database->setting_feature_select();
			while($result = $res->fetch_array())
			{
				$row[$result['name']] = $result['flag'];
				//echo $result['name'];
			}
	?>
<div id="center" style="height:auto;margin-top:1.2em;">
		<h1 class="profile_edit_title" id="basic">Set feature On/Off</h1>
		<div class="profile_edit_container"> 
			<div class="setting_each bgcolor">
				<span class="setting_category_name">Send Gift</span>
				<?php $help->setting_checkbox('gift', $row['gift'],2); ?>
			</div>	
			<div class="setting_each">
				<span class="setting_category_name">Mood Sharing</span>
				<?php $help->setting_checkbox('mood', $row['mood'],2); ?>
			</div>		
			<div class="setting_each bgcolor">
				<span class="setting_category_name">Birthday wish</span>
				<?php $help->setting_checkbox('birthday', $row['birthday'],2); ?>
			</div>
			<div class="setting_each">
				<span class="setting_category_name">Invite a friend</span>
				<?php $help->setting_checkbox('invite_friend', $row['invite_friend'],2); ?>
			</div>	
			<div class="setting_each bgcolor">
				<span class="setting_category_name">MissU</span>
				<?php $help->setting_checkbox('missu', $row['missu'],2); ?>
			</div>				
			<div class="setting_each">
				<span class="setting_category_name">Actiontype Preview</span>
				<?php $help->setting_checkbox('actiontype_preview', $row['actiontype_preview'],2); ?>
			</div>			
		</div>
</div>
	<?php	
		}
		else if($page == 'admin')
		{
			?>
			<div id="center" >
				<div class="">
				<h1 class="page_title">Manage Admins</h1>
					<div style="padding:4em;">
						<input id="remove_user_email" type="text" placeholder="Enter the email address" value="" style="height:2.4em;padding:0.4em;width: 22em;" />
						<input id="invite_button" type="submit" onclick="action.user_details(this)" value="Add Admin" data="Add Admin" title="Add as admin" style=" background: none repeat scroll 0 0 #336699;color:#FFFFFF;cursor:pointer;font-weight:bold;height: 3.4em; padding: 0.2em;width: 7.6em;" />
					</div>
				</div> 
				<div id="fetch_user_details" style="padding:1.5em;"></div> 
				<h1 class="page_title">Existing Admins</h1>
			<?php
			$row = $database->moderator_select();
			$memcache = new Memcached();
			while($result = $row->fetch_array())
			{
				$profileid = $result['profileid'];
				?>
				<div style="height:8em;clear:both;padding:1.5em;">
					<a style="font-weight:bold;" href="profile.php?id=<?php echo $profileid ?>"><img class="lfloat" height="80" width="80" src="<?php echo $help->pimage_fetch($profileid, $memcache,$database); ?>" /></a><div class="name_80"><a style="font-weight:bold;" href="profile.php?id=<?php echo $profileid ?>"><?php echo $help->name_fetch($profileid, $memcache, $database); ?></a><div style="float:right;"><input id="invite_button" type="submit" onclick="action.moderator_remove(this,<?php echo $profileid ?>)" value="Remove Admin" title="Remove Admin" style=" cursor:pointer;font-weight:bold;height: 3.1em;width:9.3em;margin-top:3em;" /></div></div>
				</div>
				<?php
			}
			?>
			</div>
			<?php
		}
		else if($page == 'remove_user')
		{
			?>
			<div id="center" >
				<div class="">
				<h1 class="page_title">Remove User From Network</h1>
					<div style="padding:5em;">
						<input id="remove_user_email" type="text" placeholder="Enter the email address" value="" style="height:2.4em;padding:0.4em;width: 22em;" />
						<input id="invite_button" type="submit" onclick="action.user_details(this)" value="Remove User" data="Remove User" title="Remove User" style=" background: none repeat scroll 0 0 #336699;color:#FFFFFF;cursor:pointer;font-weight:bold;height: 3.4em; padding: 0.2em;width: 10.6em;" />
					</div>
					<div id="fetch_user_details" style="padding:1.5em;"></div>
				</div>
			</div>
			<?php
		}
         else if($page=="analytics")
         {     ?>
         <div id="center" >
                <div class="">
                <h1 class="page_title">Analytics</h1>
                    <div style="padding:5em;">
          <select>
          <option value="daily">Daily Report</option>
          <option value="weekely">Weekly Report</option>
          </select>
          </div>
                    <div id="fetch_user_details" style="padding:1.5em;"></div>
                </div>
            </div>   
         <?php }
		else
		{
			echo '<div id="center" ></div>';
		}
	?>
	<div id="right">
	</div>
</div>      <!-- wrapper closed(started in this page only)-->
	<?php require_once('../include/footer.php'); ?>
</body> 
</html>

