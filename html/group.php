<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<?php
require_once '../include/header.php';
?>
<div class="container">
  <div class="row" >
    <div class="col-md-2 left" id="left">
			<a class="ajax_nav" href="group.php?id=<?php echo $profileid ?>"><img class="img-thumbnail" src="<?php echo $profile_image; ?>" /></a>
			
			<div class="text-center">
				<a class="ajax_nav" href="group.php?id=<?php echo $profileid; ?>" class="ellipsis"><?php echo $profile_name; ?></a>
			</div>
			<?php if($profile_relation == 0) {?>
			<div class="text-center">
				<a class="ajax_nav"  href="group.php?hl=settings&id=<?php echo $profileid; ?>">Edit Group Settings</a>
			</div>
			<?php }?>
			<ul class=" nav nav-pills nav-stacked"> 
					<li class="links" <?php if($page == 'group_json') echo 'style="background:#ddd;"'; ?>><a class="ajax_nav" id="group_json" href="group.php?id=<?php echo $profileid.'&hl=post'?>" title="Your activities"><span class="name_20">Group Feed</span></a></li>
					<li class="links" <?php if($page == 'group_about') echo 'style="background:#ddd;"'; ?>><a  class="ajax_nav" id="about" href="group.php?id=<?php echo $profileid.'&hl=about'?>" title="Your Bio"><span class="name_20">About</span></a></li>
					<li class="links" <?php if($page == 'member') echo 'style="background:#ddd;"'; ?>><a  class="ajax_nav" id="inbox" href="group.php?id=<?php echo $profileid.'&hl=member'?>" title="Your friends"><span class="name_20">Members(<?php echo $database->member_count($profileid); ?>)</span></a></li>
			</ul>
		<script>
		$(function(){
		var profileid = $('#profileid_hidden').attr('value'); 
		$.getJSON('ajax/write.php',{groupid:profileid,action:'member_load',start:0},function(data){
			if(data.count)
			{
				$('#session_name_hidden').attr('value', JSON.stringify(data.name));
				$('#session_pimage_hidden').attr('value', JSON.stringify(data.pimage));
				var i = 0;
				$.each(data.action,function(index,value){
					if(i<10)
					{
						id = 'profile_friend_'+value.profileid;
						if($('#'+id).length == 0)
						{	
						  $('#profile_active_friend_list').append('<div class="profile_active_user" style="clear:both;margin:0.5em 0;" data="'+value.profileid+'" id="'+id+'"><a href="profile.php?id='+value.profileid+'"><img class="profile_active_user_photo lfloat" style="margin-right:0.5em;" height="40" width="40" src="'+data.pimage[value.profileid]+'" /></a><div class="name_30"><a class="profile_active_user_name bold" style="display:block;padding:1.4em 0em 1.4em 0em;text-decoration:none;" href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a></div></div>');
						}
					}	
					i=i+1;
				});
			}	
		});
		});
		</script>
	<?php
	if($profile_relation == 1)
	{
	?>
		<div style="margin-top:2em;text-align:center;">
			<a style="color:#003399;" href="#" class="ellipsis" onclick="ui.group_leave(this) " >Leave Group <?php echo ' '.$profile_name; ?></a>
		</div>
	<?php
	}
	?>	
	</div>
	<?php
			if($page == 'group_about')
			{
				echo '<div id="center" class="col-md-6 center" >';
				echo '<div style="padding:1em;font-size:1.6em;font-weight:bold">'.$profile_name.'</div>';
				echo '<div style="padding:1em;font-size:1.4em;">'.$n['description'].'</div>';
				$row = $database->get_name($n['createdby']);
				echo '<div style="padding:1em;font-size:1.3em;">';?>
				<a style="font-size:1em;" href="profile.php?id=<?php echo $n['createdby']; ?>"> <?php echo $row['NAME']; ?></a> created this group</div></div>
				<?php
			}
			else if($page == 'group_json')
			{
				echo '<div id="center" class="col-md-6 center" >';
				require('../include/actions.php');
				echo '</div>';
			}
			else if($page == 'group_settings')
			{
				echo '<div id="center" style="text-align:center" class="col-md-6 center">';
				?>
				<h1 class="page_title">Group Settings</h1>
					<div id="group_info"></div>
					<div>
						<span style="margin:1em 0em;padding:0.5em;">Group Name :</span>
						<span style="margin:1em 0em;padding:0.5em;"><?php echo $n['name']; ?></span>
					</div>
					<div>
						<textarea style="margin: 1em 0em;padding:0.5em;" id="group_description" placeholder="What is this group about ?"><?php echo $n['description']; ?></textarea>
					</div>
					<div>
						<div style="margin:1em 0em;">Privacy: <select id="group_privacy"><option <?php if($n['visible'] == 0) echo 'selected'; ?> value="0">Public</option><option <?php if($n['visible'] == 1) echo 'selected'; ?> value="1">Private</option></select></div>
						<?php if($n['technical'] == 1) echo '<div style="margin:1em 0em">This group is for technical discussions</div>'; ?>
					</div>
					<div>
						<textarea style="margin: 1em 0em;padding:0.5em;" id="group_link" placeholder="Relevant links"><?php echo $n['link']; ?></textarea>
					</div>
					<?php 
					if($n['invite'] == 1)
					{
					?>
					<div style="margin:1em 0em"><input type="checkbox" id="group_invite" checked> Only group admin can add or approve membership requests</div>
					<?php 
					}
					else
					{
					?>
					<div style="margin:1em 0em"><input type="checkbox" id="group_invite"> Only group admin can add or approve membership requests</div>
					<?php 					
					}
					?>
					<div class="group_create_button">
						<input style="margin:0em 1em" type="submit" onclick="action.group_settings_save(this)" value="Save" class="group_create_positive">
					</div>
					
					<h1 class="page_title">Attach Document</h1><form id="flashform" method="post" enctype="multipart/form-data" action="/ajax/write.php"><textarea style="border:1px solid #cccccc;height:2.7em;padding:0.5em;margin:0.5em;width:34.6em;margin-left:3em;" type="text" placeholder="Say something about this file" maxlength="200" id="photo_description" name="photo_description"></textarea><div id="vish_Btn" style="position: relative;top: 10px;font-family: calibri;width: 180px;height:100px;padding-top:35px;-webkit-border-radius: 5px;-moz-border-radius: 5px;border: 1px dashed #BBB; text-align: center;background-color:#DDD;cursor:pointer; margin-left:30em;">Upload Document</div><input type="file" id="html_btn" size="40" style="margin-top:-20px; margin-left:95px; display:none;" name="photo_box"/></br><input type="submit" name="upload" id="flash_upload_button" value="Upload" style="margin-left:3em;"><input type="hidden" name="action" value="employee_invite_file_upload"></form>
					
				<?php
				echo '</div>';
			}
			else
			{
				echo '<div id="center" class="col-md-6 center" ></div>';
			}
	?>
	<div id="right" class="col-md-3 right">
		<?php
	if($profile_relation == 0 || $profile_relation == 1)
	{
		?>
		<div style="clear:both;margin:1em 0em;">You are member of <?php echo $profile_name; ?></div>
		<?php
		if($n['invite'] == 0 || $profile_relation == 0)
		{
		?>
		<div id="friend_match" style="margin-top:1em;" class="panel panel-default"></div>
		<div id="member_request" class="panel panel-default"></div>
		<div id="group_invite_info" style="margin:0em 0em 0.8em 0em;"></div>
		<input type="text" id="invite_box" value="" onkeyup="ui.group_friend_invite(this)" placeholder="Add a friend to this group" />
		<div style="position:relative;" id="group_friend_invite" class="panel panel-default"></div>
		<?php
		}
		?>
		<div class="panel panel-default" id="group_description">
			<div class="panel-heading">Group Description</div>
			<div class="panel-body"><?php echo $n['description'];?></div>
		</div>
		<?php
		if(!empty($n['link']))
		{	
		?>
		<div class="panel panel-default" id="group_link">
			<div class="panel-heading">Relevant Links</div>
			<div class="panel-body"><?php require_once('../include/Help.php'); $help = new Help(); echo $help->link_highlight($n['link']);?></div>
		</div>
		<?php
		}	 
	}
	else if($profile_relation == 2)
	{
		?>
		<div style="clear:both;margin:1em 0em;">Join request sent to <?php echo $profile_name; ?></div>
		<?php   
	}
	else if($profile_relation == 3)
	{
		?>
		<div style="clear:both;margin:1em 0em;">You are not member of <?php echo $profile_name; ?></div>
		<span id="add_container" class="profile_actions_container">
			<input class="profile_actions_button" id="<?php echo $profileid ?>" style="width:8em;" type="submit" onclick="action.group_join(this)" value="+Join Group" id="<?php echo $profileid; ?>"/> 
		</span>
		<?php   
	}
	?>	
	</div>
</div><!--- Row Closed-->
</div><!--- Container Closed-->
<?php require_once('../include/footer.php'); ?>
</body>
</html>