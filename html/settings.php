<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<?php
require_once '../include/header.php';
require_once('../include/Help.php');
$help = new Help();
$database = new Database();
$myprofileid = $_SESSION['userid'];
?>
<div class="container-fluid">
  <div class="row" >
  <div class="col-md-10">
    <div class="row home_row left1">
    <div class="col-md-2 left" id="left">
    <div class="panel panel-default">
    <div class="panel-body">
	<ul  class="nav nav-pills nav-stacked"> 
		<li>
			<a class="links" <?php if($page == 'notification') echo 'class="selected"'; ?> href="?hl=notification_settings" title="Notification Settings">Notification Settings</a>
		</li>
		<li>
			<a class="links"  <?php if($page == 'email_settings') echo 'class="selected"'; ?> href="?hl=email_settings" title="Email Settings">Email Settings</a>
		</li>
		<li>
			<a class="links" <?php if($page == 'account') echo 'class="selected"'; ?> href="?hl=account_settings" title="Account Settings">Account Settings</a>
		</li>
		<li>
			<a class="links" <?php if($page == 'privacy') echo 'class="selected"'; ?> href="?hl=privacy_settings" title="Account Settings">Privacy Settings</a>
		</li>
	</ul>
    </div>
    </div>
	</div>
	<div id="center"  class="col-md-6 center panel panel-default">
	<?php if($page == 'notification')
		{
			$row = $database->setting_notice_select($myprofileid);
	?>
		<div class="panel-heading">Notification Settings</div>
		<div class="profile_edit_container panel-body">
			<div class="setting_each">
				<span class="setting_category_name"> New follower:</span>
				<?php $help->setting_checkbox('friend_request', $row['friend_request']); ?>
			</div>	
			<div class="setting_each">
				<span class="setting_category_name"> Posts on your profile:</span>
				<?php $help->setting_checkbox('profile_post', $row['profile_post']); ?>
			</div>
			<div class="setting_each bgcolor">
				<span class="setting_category_name"> Someone comments on your post:</span>
				<?php $help->setting_checkbox('post_comment', $row['post_comment']); ?>
			</div>	
			<div class="setting_each">
				<span class="setting_category_name"> Following back:</span>
				<?php $help->setting_checkbox('friend_confirm', $row['friend_confirm']); ?>
			</div>
			<div class="setting_each bgcolor">
				<span class="setting_category_name"> You receive a message:</span>
				<?php $help->setting_checkbox('message', $row['message']); ?>
			</div>	
			<div class="setting_each">
				<span class="setting_category_name"> You are invited to a group :</span>
				<?php $help->setting_checkbox('group_invite', $row['group_invite']); ?>
			</div>
			<div class="setting_each bgcolor">
				<span class="setting_category_name"> You are invited to an event :</span>
				<?php $help->setting_checkbox('event_invite', $row['event_invite']); ?>
			</div>	
			<div class="setting_each">
				<span class="setting_category_name"> Post in a group you are member of:</span>
				<?php $help->setting_checkbox('group_post', $row['group_post']); ?>
			</div>
			<div class="setting_each bgcolor">
				<span class="setting_category_name"> Post in an event you are member of:</span>
				<?php $help->setting_checkbox('event_post', $row['event_post']); ?>
			</div>	
			<div class="setting_each">
				<span class="setting_category_name"> Response on your post:</span>
				<?php $help->setting_checkbox('post_response', $row['post_response']); ?>
			</div>	
			<div class="setting_each">
				<span class="setting_category_name"> You are made admin of a group:</span>
				<?php $help->setting_checkbox('group_admin', $row['group_admin']); ?>
			</div>
			<div class="setting_each bgcolor">
				<span class="setting_category_name"> You are praised :</span>
				<?php $help->setting_checkbox('praise', $row['praise']); ?>
			</div>	
			<div class="setting_each bgcolor">
				<span class="setting_category_name"> Somebody answers your question:</span>
				<?php $help->setting_checkbox('answer', $row['answer']); ?>
			</div>	
			<div class="setting_each">
				<span class="setting_category_name"> Hosts cancels the event you are part of:</span>
				<?php $help->setting_checkbox('event_cancel', $row['event_cancel']); ?>
			</div>
		</div>
	<?php	
		}
		else if($page == 'email_settings')
		{
			$row = $database->setting_email_select($myprofileid);
	?>
		<div class="panel-heading">Email Settings</div>
		<div class="profile_edit_container panel-body">
			<div class="setting_each">
				<span class="setting_category_name"> New follower:</span>
				<?php $help->setting_checkbox('friend_request', $row['friend_request'],0); ?>
			</div>	
			<div class="setting_each">
				<span class="setting_category_name">Posts on your profile:</span>
				<?php $help->setting_checkbox('profile_post', $row['profile_post'],0); ?>
			</div>
			<div class="setting_each bgcolor">
				<span class="setting_category_name"> Someone comments on your post:</span>
				<?php $help->setting_checkbox('post_comment', $row['post_comment'],0); ?>
			</div>	
			<div class="setting_each">
				<span class="setting_category_name">Following back:</span>
				<?php $help->setting_checkbox('friend_confirm', $row['friend_confirm'],0); ?>
			</div>
			<div class="setting_each bgcolor">
				<span class="setting_category_name"> You receive a message:</span>
				<?php $help->setting_checkbox('message', $row['message'],0); ?>
			</div>	
			<div class="setting_each">
				<span class="setting_category_name"> You are invited to a group:</span>
				<?php $help->setting_checkbox('group_invite', $row['group_invite'],0); ?>
			</div>
			<div class="setting_each bgcolor">
				<span class="setting_category_name"> You are invited to an event:</span>
				<?php $help->setting_checkbox('event_invite', $row['event_invite'],0); ?>
			</div>	
			<div class="setting_each">
				<span class="setting_category_name"> Post in a group you are member of:</span>
				<?php $help->setting_checkbox('group_post', $row['group_post'],0); ?>
			</div>
			<div class="setting_each bgcolor">
				<span class="setting_category_name"> Post in an event you are member of:</span>
				<?php $help->setting_checkbox('event_post', $row['event_post'],0); ?>
			</div>	
			<div class="setting_each">
				<span class="setting_category_name"> Response on your post:</span>
				<?php $help->setting_checkbox('post_response', $row['post_response'],0); ?>
			</div>
			<div class="setting_each">
				<span class="setting_category_name"> You are made admin of a group:</span>
				<?php $help->setting_checkbox('group_admin', $row['group_admin'],0); ?>
			</div>
			<div class="setting_each bgcolor">
				<span class="setting_category_name"> You are praised :</span>
				<?php $help->setting_checkbox('praise', $row['praise'],0); ?>
			</div>	
			<div class="setting_each bgcolor">
				<span class="setting_category_name"> Somebody answers your question:</span>
				<?php $help->setting_checkbox('answer', $row['answer'],0); ?>
			</div>	
			<div class="setting_each">
				<span class="setting_category_name"> Hosts cancels the event you are part of:</span>
				<?php $help->setting_checkbox('event_cancel', $row['event_cancel'],0); ?>
			</div>			
		</div>
	<?php	
		}
		else if($page == 'privacy')
		{
			$row = $database->privacy_select($myprofileid);
		?>
			<div class="panel-heading">Profile Privacy Settings</div>
			<div class="profile_edit_container panel-body">
				<div class="setting_each">
					<span class="setting_category_name"> What is the privacy of your next post:</span>
					<?php $help->privacy_level('profile_post_next', $row['profile_post_next']); ?>
				</div>
				<div class="setting_each bgcolor">
					<span class="setting_category_name"> Who can post in your profile:</span><span class="rfloat">Only your following</span>
					<?php //$help->privacy_level('profile_post', $row['profile_post']); ?>
				</div>
				<div class="setting_each">
					<span class="setting_category_name"> Who sees when someone posts in your profile:</span><span class="rfloat">Depends on the privacy of your next post</span>
					<?php //$help->privacy_level('profile_post_see', $row['profile_post_see']); ?>
				</div>
				<!--
				<div class="setting_each bgcolor">
					<span class="setting_category_name"> Who can see your friendlist:</span>
					<?php //$help->privacy_level('friend_list', $row['friend_list']); ?>
				</div>
				-->
			</div>
		<?php	
		
		}
		else if($page == 'account')
		{
			?>
			<div class="panel-heading">Change your password</div>
			<div id="recover_password_box" class="panel-body"> 
			<div id = "change_password_info" style="color:#ff0000;text-align:center;margin:1em 0em;"></div>
				<div class="setting_each">
					<span class="setting_category_name">Current Password:</span>
					<input class="change_password_textbox" type="password" id = "old_password"/>
				</div>
				<div class="setting_each bgcolor">
					<span class="setting_category_name">New Password:</span>
					<input class="change_password_textbox" type="password" id = "new_password"/>
				</div>
				<div class="setting_each">
					<span class="setting_category_name">Confirm New Password:</span>
					<input class="change_password_textbox" type="password" id = "confirm_password"/>
				</div>
				<input class="pe_save_button" style="width:11em;" type="submit" value="Change Password" id = "change_password_button" onclick="action.change_password(this)"/>
			</div>
			<?php
		}
	?>
	</div>
</div>	
</div>
<div class="col-md-2">
<?php require_once('../include/footer.php'); ?>
</div>
</div>
</div>	
</body>
</html>

