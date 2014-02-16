<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<?php
require_once '../include/header.php';
?>
<div id="wrapper">
	<div id="left">
			<a href="page.php?id=<?php echo $profileid ?>"><img style="max-width:16em;margin:0em 0em 0em 0em;" src="<?php echo $profile_image; ?>" /></a>
			
			<div style="text-align:center;">
				<a style="font-weight:bold;display:block;color:#ffffff;background:#4C66A4;padding:0.5em;" href="page.php?id=<?php echo $profileid; ?>" style=""><?php echo $profile_name; ?></a>
			</div>
			<ul style="list-style:none;clear:left;margin-top:1em;" id="links"> 
				<li class="links" <?php if($page == 'page_json') echo 'style="background:#ddd;"'; ?>><a class="ajax_nav" id="group_json" href="page.php?id=<?php echo $profileid.'&hl=post'?>" title="Your activities"><img class="lfloat" src="http://icon.qmcdn.net/feed_blue.png" height="20" width="20" /><span class="name_20">Page Feed</span></a></li>
				
				<li class="links" <?php if($page == 'page_about') echo 'style="background:#ddd;"'; ?>><a  class="ajax_nav" id="about" href="page.php?id=<?php echo $profileid.'&hl=about'?>" title="Your Bio"><img class="lfloat" src="http://icon.qmcdn.net/about_blue.png" height="20" width="20" /><span class="name_20">About</span></a></li>

			</ul>
	</div>
		<div id="profile_active_friend_list" class="right_item" style="margin:1em 0em 0em 0em;padding:0em;"></div>			
		<script>
	/*	$(function(){
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
		});*/
		</script>
	<?php
			if($page == 'page_about')
			{
				echo '<div id="center" >';
				echo '<div style="padding:1em;font-size:1.6em;font-weight:bold">'.$profile_name.'</div>';
				echo '<div style="padding:1em;font-size:1.4em;">'.$n['description'].'</div>';
				echo '</div>';
			}
			else if($page == 'page_json')
			{
				echo '<div id="center" >';
				require('../include/actions.php');
				echo '</div>';
			}
			else if($page == 'page_settings')
			{
				echo '<div id="center" style="text-align:center">';
				?>
				<h1 class="page_title">Page Settings</h1>
					<div id="group_info"></div>
					<div>
						<span style="margin:1em 0em;padding:0.5em;">Page Name :</span>
						<span style="margin:1em 0em;padding:0.5em;"><?php echo $n['name']; ?></span>
					</div>
					<div>
						<textarea style="margin: 1em 0em;padding:0.5em;" id="group_description" placeholder="What is this group about ?"><?php echo $n['description']; ?></textarea>
					</div>
					<div class="group_create_button">
						<input style="margin:0em 1em" type="submit" onclick="action.group_settings_save(this)" value="Save" class="group_create_positive">
					</div>
				<?php
				echo '</div>';
			}
			else
			{
				echo '<div id="center" ></div>';
			}
	?>
		
	<div id="right">

		<div class="right_item" id="group_description">
			<div class="subtitle">Page Description</div>
			<div><?php echo $n['description'];?></div>
		</div>

	</div>
</div>
<?php require_once('../include/footer.php'); ?>
</body>
</html>