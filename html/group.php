<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<?php
require_once '../include/header.php';
?>
<div class="container-fluid">
  <div class="row" >
  <div class="col-md-10">
    <div class="row home_row left1">
    <div class="col-md-2 left panel" id="left">
			<div class="text-center"><a class="ajax_nav" href="group.php?id=<?php echo $profileid ?>"><img src="<?php echo $profile_image; ?>" /></a></div>
			
			<div class="text-center">
				<a class="ajax_nav" href="group.php?id=<?php echo $profileid; ?>" class="ellipsis"><?php echo $profile_name; ?></a>
			</div>
			<?php if($profile_relation == 0) {?>
			<div class="text-center">
				<a class="ajax_nav"  href="group.php?hl=settings&id=<?php echo $profileid; ?>">Edit Group Settings</a>
			</div>
			<?php }?>
			<ul class=" nav nav-pills nav-stacked panel-body"> 
					<li class="links" <?php if($page == 'group_json') echo 'style="background:#ddd;"'; ?>><a class="ajax_nav" id="group_json" href="group.php?id=<?php echo $profileid.'&hl=post'?>" title="Your activities"><span >Group Feed</span></a></li>
					<li class="links" <?php if($page == 'group_about') echo 'style="background:#ddd;"'; ?>><a  class="ajax_nav" id="about" href="group.php?id=<?php echo $profileid.'&hl=about'?>" title="Your Bio"><span >About</span></a></li>
					<li class="links" <?php if($page == 'member') echo 'style="background:#ddd;"'; ?>><a  class="ajax_nav" id="inbox" href="group.php?id=<?php echo $profileid.'&hl=member'?>" ><span >Members(<?php echo $database->member_count($profileid); ?>)</span></a></li>
			</ul>
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
				echo '<div class="panel panel-default"><div class="panel-heading">About this group</div><div class="panel-body"><h4 class="bold">'.$profile_name.'</h4>';
				echo '<div><h6>'.$n['description'].'</h6></div>';
				$row = $database->get_name($n['createdby']);
				echo '<div><h6>';?>
				<a style="font-size:1em;" href="profile.php?id=<?php echo $n['createdby']; ?>"> <?php echo $row['NAME']; ?></a> created this group</div></h6></div>
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
				echo '<div id="center" class="col-md-6 center">';
				?>
                <div class="panel panel-default">
				<div class="panel-heading">Group Settings</div>
                <div class="panel-body">
					<div id="group_info"></div>
					<div ><h4 class="bold"><?php echo $n['name']; ?></h4>
					</div>
					<div class="form-group" >
						<textarea class="form-control" id="group_description" ><?php echo $n['description']; ?></textarea>
					</div>
					<div>
						<div class="form-group">
                            <label>Privacy:</label> 
                            <select id="group_privacy" class="form-control">
                            <option <?php if($n['visible'] == 0) echo 'selected'; ?> value="0">Public</option>
                            <option <?php if($n['visible'] == 1) echo 'selected'; ?> value="1">Private</option>
                            </select>
                        </div>
						<?php if($n['technical'] == 1) echo '<div class="form-group" ><h5>This group is for technical discussions</h5></div>'; ?>
					</div>
					<div class="form-group">
						<textarea class="form-control" id="group_link" placeholder="Relevant links"><?php echo $n['link']; ?></textarea>
					</div>
					<?php 
					if($n['invite'] == 1)
					{
					?>
					<div class="form-group">
                    <label><input type="checkbox" id="group_invite" checked> Only group admin can add or approve membership requests
                    </label>
                    </div>
					<?php 
					}
					else
					{
					?>
					<div class="form-group">
                    <label>
                    <input type="checkbox" id="group_invite"> Only group admin can add or approve membership requests
                    </label>
                    </div>
					<?php 					
					}
					?>
					<div class="form-group">
						<button onclick="action.group_settings_save(this)" class="btn btn-primary">Save</button>
					</div>
                </div>	
              </div>   
              </div> <!-- Center Closed !!! -->   
           <?php
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
        <div id="member_request" class="panel panel-default">
            <div class="panel-body" id="group_invite_info" style="margin:0em 0em 0.8em 0em;"></div>
		</div>
		<div class="panel panel-default">
            <div class="panel-heading">Add people to this group by email</div>		
				<textarea placeholder="Paste a list of email address separated by space, comma or in new line" id="employee_invite_box" style="border:0.1em solid #aaaaaa;width:15em;height:6em;padding:0.5em;margin:1em 0.5em 1em 1em;"></textarea>
				<input type="submit" style="margin-top:2em;" class="button" onclick="action.group_invite_email(this)" value="Invite" id="employee_invite_button" title="Invite" />
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Add people to this group by name</div>
            <div class="panel-body"><input type="text" id="group_invite_box"  onkeyup="ui.group_friend_invite(this)" placeholder="Start typing a colleague's name" />
                <div style="position:relative;" id="group_friend_invite"></div>
            </div>
         </div>   
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
</div>
</div>
<div class="col-md-2">
<?php require_once('../include/footer.php'); ?>
</div>
</div>
</div>
</body>
</html>