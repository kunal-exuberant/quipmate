<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<?php
require_once '../include/header.php';
require_once('../include/Help.php');
$profileid = $myprofileid;
$college=$_SESSION['COLLEGE'];
$database= new Database();
$help = new Help();
$mcount = $database->unread_message_select($profileid,$college);
?>
<!--
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
-->
<script>
 /*$(function() {
$( "#startdate" ).datepicker();
$( "#enddate" ).datepicker();
});*/
</script> 
<div class="container">
  <div class="row" >
    <div class="col-md-2 left" id="left">
			<ul class="nav nav-pills nav-stacked"> 
					<li class="links"><a class="ajax_nav<?php if($page=='admin_json') echo ' selected'; ?>" id="news_json" href="admin.php?hl=update" title="Updates from your friends"><span class="name_20">Admin Feed</span></a></li>
					<li class="links"><a class="ajax_nav<?php if($page=='invite') echo ' selected'; ?>" id="news_json" href="admin.php?hl=invite" title="Invite fellow assciates to the network"><span class="name_20">Invite Employees</span></a></li>
					<li class="links"><a class="ajax_nav<?php if($page=='admin') echo ' selected'; ?>" id="news_json" href="admin.php?hl=admin" title="List of all admins of this network"><span class="name_20">Admin List</span></a></li>
					
					<li class="links"><a class="ajax_nav<?php if($page=='usefullinks') echo ' selected'; ?>" id="news_json" href="admin.php?hl=usefullinks" title="Post Useful Links"><span class="name_20">Useful Links</span></a></li>
				  <li class="links"><a class="ajax_nav<?php if($page=='designation') echo ' selected'; ?>" id="news_json" href="admin.php?hl=designation" title="Designation"><span class="name_20">Designation</span></a></li>
				   <li class="links"><a class="ajax_nav<?php if($page=='team') echo ' selected'; ?>" id="news_json" href="admin.php?hl=team" title="Team"><span class="name_20">Team</span></a></li>
				   <li class="links"><a class="ajax_nav<?php if($page=='sotw') echo ' selected'; ?>" id="news_json" href="admin.php?hl=sotw" title="Star Of The Week"><span class="name_20">Star Of The Week</span></a></li>
				   <!--<li class="links"><a class="ajax_nav" id="flashboard" href="admin.php?hl=flashboard" title="Flashboard"><span class="name_20">Flashboard</span></a></li> -->
				   
				    <li class="links"><a class="ajax_nav<?php if($page=='group_byadmin') echo ' selected'; ?>" id="news_json" href="admin.php?hl=group_byadmin" title="Groups To Suggest"><span class="name_20">Groups To Suggest</span></a></li>
				   
					 <li class="links"><a class="ajax_nav<?php if($page=='group_suggest_admin') echo ' selected'; ?>" id="news_json" href="admin.php?hl=group_suggest_admin" title="Groups To Suggest"><span class="name_20">Groups To Suggest</span></a></li>
					<li class="links"><a class="ajax_nav<?php if($page=='remove_user') echo ' selected'; ?>" id="news_json" href="admin.php?hl=remove_user" title="Updates from your friends"><span class="name_20">Remover User</span></a></li>
			       <!-- <li class="links"><a class="ajax_nav<?php// if($page=='anlytics') echo ' selected'; ?>" id="news_json" href="admin.php?hl=analytics" title="Analytics"><span class="name_20">Analytics</span></a></li> -->
					 <li class="links"><a class="ajax_nav<?php if($page=='feature') echo ' selected'; ?>" id="news_json" href="admin.php?hl=feature" title="Feature setting"><span class="name_20">Control features</span></a></li>
            </ul> 
			<div name="page" style="margin-top:1em;">
			<span style="font-weight:bold;font-size:1em;color:gray">Pages</span>
			<ul class="nav nav-pills nav-stacked">
					<?php						
						$result = $database->page_select_all();
						while($row = $result->fetch_array())
						{
							$pageid = $row['pageid'];
							$nrow = $database->page_select($pageid);
							?>
							<li class="links"><a class="ajax_nav" href="page.php?id=<?php echo $pageid;?>" title="Pages"><span class="name_20 ellipsis"><?php echo $nrow['name'];?></span></a></li>
							<?php
						}
					?>
				<li ><a href="#" onclick="ui.page_create(this)" title="Create a page to broadcast news to all the employees"><span class="name_20">Create Page</span></a></li>
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
			<div id="center" class="col-md-6 center">
				<h1 class="page_title">Invite Employees</h1>
					<div style="margin:3em;">
						<textarea placeholder="Paste a list of email address separated by comma" id="employee_invite_box" style="border:0.1em solid #aaaaaa;width:34.6em;height:20.2em;padding:0.5em;margin-right:0.2em;"></textarea>
						<input type="submit" class="button" onclick="action.employee_invite(this)" value="Invite" id="employee_invite_button" title="Invite A Friend" />
					</div>
				<!--	<h1 class="page_title">Attach CSV</h1><form id="flashform" method="post" enctype="multipart/form-data" action="/ajax/write.php"><textarea style="border:1px solid #cccccc;height:2.7em;padding:0.5em;width:34.6em;margin-left:3em;" type="text" placeholder="Say something about this file" maxlength="200" id="photo_description" name="photo_description"></textarea><div id="vish_Btn" style="position: relative;top: 10px;font-family: calibri;width: 180px;height:100px;padding-top:35px;-webkit-border-radius: 5px;-moz-border-radius: 5px;border: 1px dashed #BBB; text-align: center;background-color:#DDD;cursor:pointer; margin-left:3em;">Upload CSV File</div><input type="file" id="html_btn" size="40" style="margin-top:-20px; margin-left:95px; display:none;" name="photo_box"/></br><input type="submit" name="upload" id="flash_upload_button" value="Upload" style="margin-left:3em;"><input type="hidden" name="action" value="employee_invite_file_upload"></form> -->
			</div>
		<?php
		}
		
		
		else if($page == 'usefullinks')
		{
		?>
			<div id="center" class="col-md-6 center">
				<h1 class="page_title">Post Useful Links</h1>
					<div style="margin:3em;border:0.1em solid #aaaaaa;width:34.6em;height:20.2em;padding:0.5em;margin-right:0.2em; overflow-y:scroll; overflow-x:hidden;" id="usefullinks_box">
						
						
					</div>
					<input type="submit"  value="Got Link"  id="ullink_box" title="Paste Link" /><div id="uluploader"></div>
			</div>
			</div>
		<?php
		}
		
		else if($page == 'designation')
		{
		?>
			<div id="center" class="col-md-6 center">
				<h1 class="page_title">Designations</h1>
				<div style="margin:3em;border:0.1em solid #aaaaaa;width:34.6em;height:20.2em;padding:0.5em;margin-right:0.2em; overflow-y:scroll; overflow-x:hidden;" id="designation_show_box" ></div>
				<input type="text" class="form-control"  placeholder="Add a designation" style="margin-left:2.80em; width:50%;display:inline" id="designation_box"/> 	<input type="submit" onclick="action.designation(this)" value="Add" id="designation_button" title="Add" />
				
				
				<h1 class="page_title">Managing Director</h1><input type="text" id="mdadd" autocomplete="off" style="width:20em; margin-left:2.80em; margin-top:20px;" class="form-control" placeholder="Who is the managing director"> <div id="md_container" width="200px" style="margin-left:20px;" ></div><div id="md_co" style="width:30em; margin-left:20px;"><input type="submit" style="margin-top:-34px;" onclick="action.addmd(this)" value="Add MD" id="add_md_button" title="Add MD" /></div>
			</div>
			
				
			
		<?php
		}
		
		else if($page == 'team')
		{
		?>
			<div id="center" class="col-md-6 center">
				<h1 class="page_title">Teams</h1>
				<div style="margin:3em;border:0.1em solid #aaaaaa;width:34.6em;height:20.2em;padding:0.5em;margin-right:0.2em; overflow-y:scroll; overflow-x:hidden;" id="team_show_box" ></div>
				<input type="text" class="form-control"  placeholder="Add a team" style="margin-left:2.80em; width:50%;display:inline" id="team_box"/> 	<input type="submit" onclick="action.team(this)" value="Add" id="team_button" title="Add" />
			</div>
		<?php
		}
		
		else if($page == 'sotw')
		{
		?>
			<div id="center" class="col-md-6 center">
				<h1 class="page_title">Star Of The Week</h1>
		
				<input type="text" id="hso" autocomplete="off" style="width:20em;"   class="form-control" placeholder="Search people"> <div id="star_container" width="200px" style="margin-left:20px;" ></div><div id="sotw2" style="width:30em; margin-left:20px;"></div>
			</div>
		<?php
		}
		
	else if($page == 'group_byadmin')
		{
		?>
			<div id="center" class="col-md-6 center">
				<h1 class="page_title">Groups To Suggest</h1>
		
				
			</div>
			
		<?php
		}
		
		else if($page == 'flashboard')
		{
		?>
			<div id="center" class="col-md-6 center">
				<h1 class="page_title">Flashboard</h1><form id="pform" method="post" enctype="multipart/form-data" action="/ajax/write.php"><textarea style="border:1px solid #cccccc;height:2.7em;padding:0.5em;margin:0.5em;" type="text" placeholder="Say something about this file" maxlength="200" id="photo_description" name="photo_description"></textarea><input size="30" type="file" name="photo_box" id="photo_box"></br><input type="submit" name="upload" id="photo_upload_button" value="Upload"><input type="hidden" id="photo_hidden_profileid" name="photo_hidden_profileid" value="1000000122"><input type="hidden" name="action" value="photo_upload"></form>
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
<div id="center" style="height:auto; " class="col-md-6 center">
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
			<div id="center" class="col-md-6 center">
				<div class="">
				<h1 class="page_title">Manage Admins</h1>
					<div style="padding:4em;">
						<input id="remove_user_email" type="text" placeholder="Enter the email address" value="" style="height:2.4em;padding:0.4em;width:22em;"/>
						<input id="invite_button" type="submit" class="button" onclick="action.user_details(this)" value="Add Admin" data="Add Admin" title="Add as admin" style="height:3.4em;padding:0.2em;width:7.6em;" />
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
					<a style="font-weight:bold;" class="ajax_nav" href="profile.php?id=<?php echo $profileid ?>"><img class="lfloat" height="80" width="80" src="<?php echo $help->pimage_fetch($profileid, $memcache,$database); ?>" /></a><div class="name_80"><a style="font-weight:bold;" class="ajax_nav" href="profile.php?id=<?php echo $profileid ?>"><?php echo $help->name_fetch($profileid, $memcache, $database); ?></a><div style="float:right;"><input id="invite_button" type="submit" onclick="action.moderator_remove(this,<?php echo $profileid ?>)" value="Remove Admin" title="Remove Admin" style=" cursor:pointer;font-weight:bold;height: 3.1em;width:9.3em;margin-top:3em;" /></div></div>
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
			<div id="center" class="col-md-6 center">
				<div class="">
				<h1 class="page_title">Remove User From Network</h1>
					<div style="padding:5em;">
						<input id="remove_user_email" type="text" placeholder="Enter the email address" value="" style="height:2.4em;padding:0.4em;width: 22em;" />
						<input class="theme_button" type="submit" class="button" onclick="action.user_details(this)" value="Remove User" data="Remove User" title="Remove User"  />
					</div>
					<div id="fetch_user_details" style="padding:1.5em;"></div>
				</div>
			</div>
			<?php
		}
         else if($page=="analytics")
         {     ?>
         <div id="center" class="col-md-6 center">
				<div class="">
                <h1 class="page_title">Analytics</h1>
                    <div id="analytics">
					
					<p >Start Date: <input type="text" name="startdate" id="startdate">   End Date: <input type="text" name="enddate" id="enddate">
					</p>
					<p>Select Value: 
		  <select id="typedata" >
          <option value="post" selected="selected">Post</option>
          <option value="joined" >Joined</option>
          <option value="comment">Comment</option>
		  <option value="visit">Visit</option>
		  <option value="view">View</option>
		  </select></p>
					
					<span id="error" style="display:none; color:#0C0">Enter end date</span>
					
                    <input type="button" value="OK" id= "button" onclick="action.getanalyticdetails(this,document.getElementById

('startdate').value,document.getElementById('enddate').value,document.getElementById('typedata').value)
">
<span id="rangeError" style="display:none; color:#0C0">Range should be less than 15 days </span>
				<p id="chart"> </p>
				</div>
				<div id="fetch_user_details" style="padding:1.5em;"></div>
				<!--<input type="button" value="ok" id= "button" onclick="analytics()">-->
				</div>
		 <!--<div id="chart_div" style="width:48em; height: 500px;"></div>-->
		</div>   
         <?php }
		else
		{
			echo '<div id="center" class="col-md-6 center" ></div>';
		}
	?>
	<div id="right" class="col-md-3 right">
	</div>
</div><!--- Row Closed-->
</div><!--- Container Closed-->
	<?php require_once('../include/footer.php'); ?>
</body> 
</html>

