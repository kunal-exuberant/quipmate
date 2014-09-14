<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<?php
require_once '../include/header.php';
?>
<div class="container">
  <div class="row" >
   <div class="col-md-2 left" id="left">
		<ul  class=" nav nav-pills nav-stacked"> 
			<li class="links" <?php if($page == 'profile_json') echo 'style="background:#ddd;"'; ?>><a class="ajax_nav" id="profile_json" href="profile.php?id=<?php echo $profileid.'&hl=diary'?>" title="Your activities"><span class="name_20">Diary</span></a></li>
			
			<li class="links" <?php if($page == 'bio') echo 'style="background:#ddd;"'; ?>><a  class="ajax_nav" id="bio" href="profile.php?id=<?php echo $profileid.'&hl=bio'?>" title="Your Bio"><span class="name_20">Bio</span></a></li>
			
					 
			 <li class="links" <?php if($page == 'praise') echo 'style="background:#ddd;"'; ?>><a class="ajax_nav" id="pphoto" href="profile.php?id=<?php echo $profileid.'&hl=praise'?>" title="Your Praises"><span class="name_20">Praises</span></a></li>
			 
		    <li class="links" <?php if($page == 'pphoto') echo 'style="background:#ddd;"'; ?>><a class="ajax_nav" id="pphoto" href="profile.php?id=<?php echo $profileid.'&hl=image'?>" title="Your Photos"><span class="name_20">Photos</span></a></li>
			<li class="links" <?php if($page == 'following') echo 'style="background:#ddd;"'; ?>><a  class="ajax_nav" id="following" href="profile.php?id=<?php echo $profileid.'&hl=following'?>" title="You are following"><span class="name_20">Following (<?php echo $database->following_count($profileid); ?>)</span></a></li>
			<li class="links" <?php if($page == 'followers') echo 'style="background:#ddd;"'; ?>><a  class="ajax_nav" id="followers" href="profile.php?id=<?php echo $profileid.'&hl=followers'?>" title="Your Followers"><span class="name_20">Followers (<?php echo $database->followers_count($profileid); ?>)</span></a></li>
		</ul>
		<?php
	if($profile_relation == 1)
	{
	?>
		<div style="margin-top:2em;text-align:center;">
			<a style="color:#003399;" href="#" onclick="ui.unfriend(this) " >Unfollow <?php echo ' '.$profile_name; ?></a>
		</div>
	<?php
	}
	$page == 'bio';
	?>	
</div> <!-- Left ends -->
	<?php
			if($page == 'bio')
			{
				echo '<div id="center" class="col-md-8 center" >';
				require('../include/biocenter.php');
				echo '</div>';
			}
			else if($page == 'profile_json')
			{
				echo '<div id="center" class="col-md-8 center" >';
				require('../include/actions.php');
				echo '</div>';
			}
			else
			{
				echo '<div id="center" class="col-md-8 center" ></div>';
			}

//Stopped right to load for profile             
 /**
 *   if($page == 'not match')
 *    {
 * 	?>
 *     	<div id="right" class="col-md-3 right">
 *     		<?php
 *     	if($profile_relation != 0)
 *     	{
 *     			$status= $database->check_friendship($myprofileid,$profileid);
 *     			if($status == 0)
 *     			{
 *     		?>
 *     		<div style="clear:both;margin:1em 0em;">You are not following <?php echo $profile_name; ?></div>
 *     		<span id="add_container" class="profile_actions_container">
 *     			<input class="profile_actions_button" id="<?php echo $profileid ?>" style="width:7.3em;" onclick="action.add_friend(this,<?php echo $profileid ?>)" type="submit" value=" +Follow" id="<?php echo $profileid; ?>"/>
 *     		</span>
 *     		<?php   
 *     		}
 *     		else if($status == 1)
 *     		{
 *     		?>
 *     		<div style="clear:both;margin:1em 0em;"><?php echo $profile_name; ?> is following you </div>
 *     		<?php   
 *     		}
 *     		else if($status == -1)
 *     		{
 *     		?>
 *     		<div style="clear:both;margin:1em 0em;"> You are following <?php echo $profile_name; ?></div>
 *     		<?php   
 *     		}
 *     		else if($status == 2)
 *     		{
 *     		?>
 *     		<div style="clear:both;margin:1em 0em;">You and <?php echo $profile_name; ?> are following each other.</div>
 *     		<?php   
 *     		}
 *     	}	
 *     	if($profile_relation == 0)
 *     	{
 *     	 global $help,$memcached;
 *     	 if($help->feature_fetch('mood',$memcached, $database))
 *     	 {
 *     	 ?>
 *     		<span class="profile_actions_container" >
 *     				<input class="profile_actions_button" onclick="ui.mood(this)" style="width:7.3em;" type="submit" value="+Mood" />
 *     		</span>	
 *     	 <?php 
 *     	 }
 *     	 ?>
 *     		<span class="profile_actions_container" >
 *     			<input class="profile_actions_button" onclick="ui.tagline(this)" style="width:8em;" type="submit" value="+Tagline" />
 *     		</span>
 *     		<div style="clear:both;"></div>
 *     			
 *     		<?php		
 *     	}		
 *     	else if($profile_relation == 1)
 *     	{
 *         	 //$data = $database->missu_status($myprofileid,$profileid);
 *     		 //$status = $data['status'];
 *     		?>
 *     			<div id="" class="right_item" style="margin-bottom:1em;"><a style="cursor:pointer;" onclick="ui.praise(this,event)">Praise/Recommend</a></div>
 *     		<?php
 *     		?> 
 *     		<!-- <input type="hidden" id ="missu_status" value="<?php //echo $status; ?>"/> -->
 *     		 <?php
 *     		 if($status != 0)
 *     		 {
 *     		     $pageid = $data['pageid'];
 *     		 }
 *     
 *     
 *     	/*	if($status == 0 && ($help->feature_fetch('missu',$memcached, $database)))
 *     		{
 *     		?>
 *     		<span class="profile_actions_container">
 *     			<input onclick="action.missu(this)" class="profile_actions_button" style="width:8em;" data="<?php echo $profileid ?>" id="missu_button" type="submit" value="Miss U" />
 *     		</span>
 *     		<?php
 *     		}
 *     		else if($status == 1 && ($help->feature_fetch('missu',$memcached, $database)) )
 *     		{
 *     		?>
 *     		<span class="profile_actions_container">
 *     			<input  onclick="action.missu(this)" class="profile_actions_button"  style="width:8em;" data="<?php echo $profileid ?>" type="submit" value="Missing" />
 *     		</span>
 *     		<?php   
 *     		}
 *     		else if($status == 2 &&  ($help->feature_fetch('missu',$memcached, $database))) 
 *     		{
 *     		?>
 *     		<span class="profile_actions_container" id="<?php echo $pageid; ?>">
 *     			<input  onclick="action.missu(this)" class="profile_actions_button" style="width:11em;" data="<?php echo $profileid ?>" id="missu_button" type="submit" value="Miss Back" />
 *     		</span>
 *     		<?php    
 *     		} 
 *             
 *             
 *     	}
 *     	if($profile_relation != 0)
 *     	{
 *     	?>
 *     		<span class="profile_actions_container" >
 *     			<input style="width:7.3em;" class="profile_actions_button" id="message_button" type="submit" value="+Message" onclick="ui.message(this)" />
 *     		</span>		
 *     		<div id="friend_match" class="panel panel-default" ></div>
 *     		<div id="friend_non_match" class="panel panel-default" ></div>		
 *     	<?php
 *     	}
 *     	?>	
 *     	</div> <!--- Closing right -->
 * <?php 
 *      }
 * ?>
 */
 ?>
 </div> <!---row closed -->	
</div> <!---Container closed -->
<?php require_once('../include/footer.php'); ?>
</body>
</html>



