<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<?php
require_once '../include/header.php';
?>
<div id="wrapper">
	<div id="left">
			<div style="text-align:center;" class="photo_feed">	
					<input type="hidden" value="<?php echo $profileid; ?>" />
					<input type="hidden" value="50" />
					<img class="viewable" id="<?php echo $profile_imageid; ?>" style="cursor:pointer;max-width:16em;margin:0em 0em 0em 0em;" data="<?php echo $profile_image; ?>" src="<?php echo $profile_image; ?>" />
			</div>
			<div style="text-align:center;">
				<a style="font-weight:bold;display:block;color:#ffffff;background-color:#003153;padding:0.5em;background: url('http://icon.qmcdn.net/top_bar_1.png') repeat scroll 0 0 #003153"; href="profile.php?id=<?php echo $profileid; ?>" style=""><?php echo $profile_name; ?></a>
			</div>
			
			
			<?php if($myprofileid == $profileid) {?>
			<div style="margin-top:0.5em;text-align:center;">
				<a style="color:#003399;" href="profile.php?hl=bio">Edit My Profile</a>
			</div>
			<?php }?>
			<ul style="list-style:none;clear:left;margin-top:1em;" id="links"> 
					<li class="links" <?php if($page == 'profile_json') echo 'style="background:#ddd;"'; ?>><a class="ajax_nav" id="news_json" href="profile.php?id=<?php echo $profileid.'&hl=diary'?>" title="Your activities"><img class="lfloat" src="http://icon.qmcdn.net/diary_blue.png" height="20" width="20" /><span class="name_20">Diary</span></a></li>
					
					<li class="links" <?php if($page == 'bio') echo 'style="background:#ddd;"'; ?>><a  class="ajax_nav" id="inbox" href="profile.php?id=<?php echo $profileid.'&hl=bio'?>" title="Your Bio"><img class="lfloat" src="http://icon.qmcdn.net/bio_new_blue.png" height="20" width="20" /><span class="name_20">Bio</span></a></li>
					 
					<li class="links" <?php if($page == 'pphoto') echo 'style="background:#ddd;"'; ?>><a class="ajax_nav" id="photo" href="profile.php?id=<?php echo $profileid.'&hl=image'?>" title="Your Photos"><img class="lfloat" src="http://icon.qmcdn.net/world.png" height="20" width="20" /><span class="name_20">Photos</span></a></li>

					<li class="links" <?php if($page == 'friend') echo 'style="background:#ddd;"'; ?>><a  class="ajax_nav" id="inbox" href="profile.php?id=<?php echo $profileid.'&hl=friend'?>" title="Your friends"><img class="lfloat" src="http://icon.qmcdn.net/friends_blue.png" height="20" width="20" /><span class="name_20">Friends(<?php echo $database->friend_count($profileid); ?>)</span></a></li>
			</ul>
	<?php
	if($profile_relation == 0)
	{
	?>	
			<div id="friend_event" class="right_item" style="margin:1em 0em 0em 0em;padding:0em;"></div>
	<?php
	}
	else
	{
		?>
		<div id="profile_active_friend_list" class="right_item" style="margin:1em 0em 0em 0em;padding:0em;"></div>			
		<script>
		$(function(){
		var profileid = $('#profileid_hidden').attr('value'); 
		$.getJSON('ajax/write.php',{action:"friend_fetch",profileid:profileid},function(data){
			if(data.ack)
			{
				$('#session_name_hidden').attr('value', JSON.stringify(data.name));
				$('#session_pimage_hidden').attr('value', JSON.stringify(data.pimage));
				var i = 0;
				$.each(data.action,function(index,value){
					if(i<10)
					{
						id = 'profile_friend_'+value;
						if($('#'+id).length == 0)
						{	
						  $('#profile_active_friend_list').append('<div class="profile_active_user" style="clear:both;margin:0.5em 0;" data="'+value+'" id="'+id+'"><a href="profile.php?id='+value+'"><img class="profile_active_user_photo lfloat" style="margin-right:0.5em;" height="40" width="40" src="'+data.pimage[value]+'" /></a><div class="name_30"><a class="profile_active_user_name bold" style="display:block;padding:1.4em 0em 1.4em 0em;text-decoration:none;" href="profile.php?id='+value+'">'+data.name[value]+'</a></div></div>');
						}
					}	
					i=i+1;
				});
			}	
		});
		});
		</script>
		<?php
	}
	if($profile_relation == 1)
	{
	?>
		<div style="margin-top:2em;text-align:center;">
			<a style="color:#003399;" href="#" onclick="ui.unfriend(this) " >Unfriend <?php echo ' '.$profile_name; ?></a>
		</div>
	<?php
	}
	?>	
	</div>
	<?php
			if($page == 'bio')
			{
				echo '<div id="center" >';
				require('../include/biocenter.php');
				echo '</div>';
			}
			else if($page == 'profile_json')
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
		<script type="text/javascript">
		$(function(){
			var profileid=$('#profileid_hidden').attr('value');
			var myprofileid=$('#myprofileid_hidden').attr('value');
			if(profileid != myprofileid)
			{
				$.get('ajax/bio_match.php',{id:profileid},function(data){
					$('#bio_match').html(data);
				});
			}
		});
		</script>
		<?php
	if($profile_relation != 0)
	{
			$status= $database->check_friendship($myprofileid,$profileid);
			if($status == 0)
			{
		?>
		<div style="clear:both;margin:1em 0em;"><?php echo $profile_name; ?> is not your friend</div>
		<span id="add_container" class="profile_actions_container">
			<input class="profile_actions_button" id="<?php echo $profileid ?>" style="width:7.3em;" onclick="action.add_friend(this,<?php echo $profileid ?>)" type="submit" value="+Friend" id="<?php echo $profileid; ?>"/>
		</span>
		<?php   
		}
		else if($status == 1)
		{
		?>
		<div style="clear:both;margin:1em 0em;"> Friendship confirmation pending with you</div>
		<?php   
		}
		else if($status == -1)
		{
		?>
		<div style="clear:both;margin:1em 0em;"> Friendship confirmation pending with <?php echo $profile_name; ?></div>
		<?php   
		}
		else if($status == 2)
		{
		?>
		<div style="clear:both;margin:1em 0em;"><?php echo $profile_name; ?> and you are friends</div>
		<?php   
		}
	}	
	if($profile_relation == 0)
	{
	?>
		<span class="profile_actions_container" >
				<input class="profile_actions_button" onclick="ui.mood(this)" style="width:7.3em;" type="submit" value="+Mood" />
		</span>	
		<span class="profile_actions_container" >
			<input class="profile_actions_button" onclick="ui.tagline(this)" style="width:8em;" type="submit" value="+Tagline" />
		</span>
		<div style="clear:both;"></div>
		
	<?php		
	}		
	else if($profile_relation == 1)
	{
    	 $data = $database->missu_status($myprofileid,$profileid);
		 $status = $data['status'];
		if($_SESSION['database'] != 'profile')
		{
		?>
			<div id="" class="right_item" style="margin-bottom:1em;"><a style="cursor:pointer;" onclick="ui.praise(this,event)">Praise/Recommend</a></div>
		<?php
		}
		?> 
		 <input type="hidden" id ="missu_status" value="<?php echo $status; ?>"/>
		 <?php
		 if($status != 0)
		 {
		     $pageid = $data['pageid'];
		 }
		if($status == 0)
		{
		?>
		<span class="profile_actions_container">
			<input onclick="action.missu(this)" class="profile_actions_button" style="width:8em;" data="<?php echo $profileid ?>" id="missu_button" type="submit" value="Miss U" />
		</span>
		<?php
		}
		else if($status == 1)
		{
		?>
		<span class="profile_actions_container">
			<input  onclick="action.missu(this)" class="profile_actions_button"  style="width:8em;" data="<?php echo $profileid ?>" type="submit" value="Missing" />
		</span>
		<?php   
		}
		else if($status == 2)
		{
		?>
		<span class="profile_actions_container" id="<?php echo $pageid; ?>">
			<input  onclick="action.missu(this)" class="profile_actions_button" style="width:11em;" data="<?php echo $profileid ?>" id="missu_button" type="submit" value="Miss Back" />
		</span>
		<?php    
		}
		?>

		<span class="profile_actions_container" >
				<input style="width:5em;" class="profile_actions_button gift_button" type="submit" value="+Gift" onclick="ui.gift_ui_create(this)"/> 
		</span>
		<?php
	}
	if($profile_relation != 0)
	{
	?>
		<span class="profile_actions_container" >
			<input style="width:7.3em;" class="profile_actions_button" id="message_button" type="submit" value="+Message" onclick="ui.message(this)" />
		</span>		
		<div id="friend_match" style="margin-top:1em;"></div>
		<div id="bio_match" style="margin-top:1em;"></div>
		<div id="friend_non_match" style="margin-top:1em;"></div>		
	<?php
	}
	?>	
	</div>
</div>
<?php require_once('../include/footer.php'); ?>
</body>
</html>



