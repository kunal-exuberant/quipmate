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

<script>
 /*$(function() {
$( "#startdate" ).datepicker();
$( "#enddate" ).datepicker();
});*/
</script> 
<div class="container">
  <div class="row" >
    <div class="col-md-2 left" id="left">
      <div class="panel panel-default">
       <div class="panel-body">
			<ul class="nav nav-pills nav-stacked"> 
					<li class="links"><a class="ajax_nav<?php if($page=='admin_json') echo ' selected'; ?>" id="news_json" href="admin.php?hl=update" title="Updates from people in network"><span >Admin Feed</span></a></li>
					<li class="links"><a class="ajax_nav<?php if($page=='invite') echo ' selected'; ?>" id="news_json" href="admin.php?hl=invite" title="Invite fellow assciates to the network"><span >Invite Employees</span></a></li>
					<li class="links"><a class="ajax_nav<?php if($page=='admin') echo ' selected'; ?>" id="news_json" href="admin.php?hl=admin" title="List of all admins of this network"><span >Admin List</span></a></li>
					
					<li class="links"><a class="ajax_nav<?php if($page=='usefullinks') echo ' selected'; ?>" id="news_json" href="admin.php?hl=usefullinks" title="Post Useful Links"><span >Useful Links</span></a></li>
				  <li class="links"><a class="ajax_nav<?php if($page=='designation') echo ' selected'; ?>" id="news_json" href="admin.php?hl=designation" title="Designation"><span >Designation</span></a></li>
				   <li class="links"><a class="ajax_nav<?php if($page=='team') echo ' selected'; ?>" id="news_json" href="admin.php?hl=team" title="Team"><span >Team</span></a></li>
				   <li class="links"><a class="ajax_nav<?php if($page=='sotw') echo ' selected'; ?>" id="news_json" href="admin.php?hl=sotw" title="Star Of The Week"><span >Star Of The Week</span></a></li>
			<!--	   <li class="links"><a class="ajax_nav" id="flashboard" href="admin.php?hl=flashboard" title="Flashboard"><span >Flashboard</span></a></li> --> 
				   
				    <li class="links"><a class="ajax_nav<?php if($page=='group_byadmin') echo ' selected'; ?>" id="news_json" href="admin.php?hl=group_byadmin" title="Groups To Suggest"><span >Groups To Suggest</span></a></li>
					<li class="links"><a class="ajax_nav<?php if($page=='remove_user') echo ' selected'; ?>" id="news_json" href="admin.php?hl=remove_user" title="Disable a user account"><span >Disable User Account</span></a></li>
			        <li class="links"><a class="ajax_nav<?php if($page=='anlytics') echo ' selected'; ?>" id="news_json" href="admin.php?hl=analytics" title="Analytics"><span >Analytics</span></a></li>
					 <li class="links"><a class="ajax_nav<?php if($page=='feature') echo ' selected'; ?>" id="news_json" href="admin.php?hl=feature" title="Feature setting"><span >Control features</span></a></li>
            </ul> 
        </div>
      </div>
			<div class="panel panel-default">
			<div class="panel-heading">Pages</div>
            <div class="panel-body">
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
				<li ><a href="#" onclick="ui.page_create(this)" title="Create a page to broadcast news to all the employees"><span >Create Page</span></a></li>
			</ul>
            </div>
            </div>
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
            <div class="panel panel-default">
				<div class="panel-heading">Invite Employees</div>
                <div class="panel-body">
					<div style="margin:3em;">
						<textarea placeholder="Paste a list of email address separated by comma" id="employee_invite_box" style="border:0.1em solid #aaaaaa;width:34.6em;height:20.2em;padding:0.5em;margin-right:0.2em;"></textarea>
						<input type="submit" class="button" onclick="action.employee_invite(this)" value="Invite" id="employee_invite_button" title="Invite" />
					</div>
            <div class="panel panel-default">        
			<div class="panel-heading">Attach CSV file in outlook's csv format.</div>
            <div class="panel-body">
            <form id="csvform" method="post" enctype="multipart/form-data" action="/ajax/write.php"><textarea style="border:1px solid #cccccc;height:2.7em;padding:0.5em;width:34.6em;margin-left:3em;" type="text" placeholder="Say something about this file" maxlength="200" id="photo_description" name="photo_description"></textarea><input type="file" id="html_btn" size="40" style="margin-top:20px; margin-left:95px;" name="photo_box"/></br><input type="submit" name="upload" id="csv_upload_button" value="Upload" style="margin-left:3em;"><input type="hidden" name="action" value="employee_invite_file_upload">
            </form>
            </div>
            </div>
            </div>
            </div>
            <div id="upload_progress"></div>
			</div>
		<?php
		}
		
		
		else if($page == 'usefullinks')
		{
		?>
			<div id="center" class="col-md-6 center">
            <div class="panel panel-default">
				<div class="panel-heading">Post Useful Links</div>
                <div class="panel-body">
					<div style="margin:3em;border:0.1em solid #aaaaaa;width:34.6em;height:20.2em;padding:0.5em;margin-right:0.2em; overflow-y:scroll; overflow-x:hidden;" id="usefullinks_box">
						
						
					</div>
					<textarea id="link_box" placeholder="Paste/type a link here ?"></textarea><input id="ullink_button" type="submit" class="theme_button" value="Share" /></div>
              </div>   
			</div>
		<?php
		}
		
		else if($page == 'designation')
		{
		?>
			<div id="center" class="col-md-6 center">
            <div class="panel panel-default">
				<div class="panel-heading">Designations</div>
                <div class="panel-body">
				<div style="margin:3em;border:0.1em solid #aaaaaa;width:34.6em;height:20.2em;padding:0.5em;margin-right:0.2em; overflow-y:scroll; overflow-x:hidden;" id="designation_show_box" ></div>
				<input type="text" class="form-control"  placeholder="Add a designation" style="margin-left:2.80em; width:50%;display:inline" id="designation_box"/> 	<input type="submit" onclick="action.designation(this)" value="Add" id="designation_button" title="Add" />
                </div>
              </div>
			</div>
		<?php
		}
		
		else if($page == 'team')
		{
		?>
			<div id="center" class="col-md-6 center">
            <div class="panel panel-default">
				<div class="panel-heading">Teams</div>
                <div class="panel-body">
				<div style="margin:3em;border:0.1em solid #aaaaaa;width:34.6em;height:20.2em;padding:0.5em;margin-right:0.2em; overflow-y:scroll; overflow-x:hidden;" id="team_show_box" ></div>
				<input type="text" class="form-control"  placeholder="Add a team" style="margin-left:2.80em; width:50%;display:inline" id="team_box"/> 	<input type="submit" onclick="action.team(this)" value="Add" id="team_button" title="Add" />
			 </div>
            </div>
            </div>
		<?php
		}
		
		else if($page == 'sotw')
		{
		?>
			<div id="center" class="col-md-6 center">
            <div class="panel panel-default">
				<div class="panel-heading">Star Of The Week</div>
	            <div class="panel-body">	
				<input type="text" id="hso" autocomplete="off" style="width:20em;"   class="form-control" placeholder="Search people"> <div id="star_container" width="200px" style="margin-left:20px;" ></div><div id="sotw2" style="width:30em; margin-left:20px;"></div>
                </div>
			</div>
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
    <div class="panel panel-default">
		<div class="panel-heading">Set feature On/Off</div>
		<div class="profile_edit_container panel-body"> 
			<div class="setting_each">
				<span class="setting_category_name">Mood Sharing</span>
				<?php $help->setting_checkbox('mood', $row['mood'],2); ?>
			</div>		
			<div class="setting_each bgcolor">
				<span class="setting_category_name">Birthday wish</span>
				<?php $help->setting_checkbox('birthday', $row['birthday'],2); ?>
			</div>
			<div class="setting_each">
				<span class="setting_category_name">Invite a colleague</span>
				<?php $help->setting_checkbox('invite_friend', $row['invite_friend'],2); ?>
			</div>			
		</div>
    </div>
</div>
	<?php	
		}
		else if($page == 'admin')
		{
			?>
			<div id="center" class="col-md-6 center">
				<div class="panel panel-default">
				<div class="panel-heading">Manage Admins</div>
					<div style="padding:4em;" class="panel-body">
						<input id="remove_user_email" type="text" placeholder="Enter the email address" value="" style="padding:0.4em;width:22em;"/>
						<input id="invite_button" type="submit" class="button" onclick="action.user_details(this)" value="Add Admin" data="Add Admin" title="Add as admin" style="padding:0.2em;width:7.6em;" />
					</div>
				<div id="fetch_user_details" style="padding:1.5em;"></div> 
                <div class="panel panel-default">
				<div class="panel-heading">Existing Admins</div>
                <div class="panel-body">
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
            </div>
            </div>
			</div> 
			<?php
		}
		else if($page == 'remove_user')
		{
			?>
			<div id="center" class="col-md-6 center">
				<div class="panel panel-default">
				<div class="panel-heading">Disable the account of an user </div>
                <div class="panel-body">
					<div style="padding:5em;">
						<input id="remove_user_email" type="text" placeholder="Enter the email address" value="" style="padding:0.5em;width: 22em;" />
						<input class="theme_button" type="submit" class="button" onclick="action.user_details(this)" value="Disable User" data="Disable User" title="Disable User"  />
					</div>
					<div id="fetch_user_details" style="padding:1.5em;"></div>
				</div>
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

