<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<?php
require_once '../include/header.php';
?>
<div id="wrapper">
	<div id="left">
			<a href="event.php?id=<?php echo $profileid ?>"><img style="max-width:16em;margin:0em 0em 0em 0em;" src="<?php echo $profile_image; ?>" /></a>
			
			<div style="text-align:center;">
				<a style="font-weight:bold;display:block;color:#ffffff;background:#4C66A4;padding:0.5em;" href="event.php?id=<?php echo $profileid; ?>" style=""><?php echo $profile_name; ?></a>
			</div>
			<?php if($profile_relation == 0) {?>
			<div style="margin-top:0.5em;text-align:center;">
				<a style="color:#003399;" href="event.php?hl=settings&id=<?php echo $profileid; ?>">Edit Event Settings</a>
			</div>
			<?php }?>
			<ul style="list-style:none;clear:left;margin-top:1em;" id="links"> 
					<li class="links" <?php if($page == 'event_json') echo 'style="background:#ddd;"'; ?>><a class="ajax_nav" id="group_json" href="event.php?id=<?php echo $profileid.'&hl=post'?>" title="Event posts"><img class="lfloat" src="http://icon.qmcdn.net/feed_blue.png" height="20" width="20" /><span class="name_20">Event Feed</span></a></li>
					
					<li class="links" <?php if($page == 'event_about') echo 'style="background:#ddd;"'; ?>><a  class="ajax_nav" id="about" href="event.php?id=<?php echo $profileid.'&hl=about'?>" title="About the event"><img class="lfloat" src="http://icon.qmcdn.net/about_blue.png" height="20" width="20" /><span class="name_20">About</span></a></li>

					<li class="links" <?php if($page == 'guest') echo 'style="background:#ddd;"'; ?>><a  class="ajax_nav" id="inbox" href="event.php?id=<?php echo $profileid.'&hl=guest'?>" title="Guest expected"><img class="lfloat" src="http://icon.qmcdn.net/friends_blue.png" height="20" width="20" /><span class="name_20">Guest expected(<?php $guest_count = $database->guest_count($profileid); echo  $guest_count; ?>)</span></a></li>
			</ul>
	<?php
		?>
		<div id="profile_active_friend_list" class="right_item" style="margin:1em 0em 0em 0em;padding:0em;"></div>			
		<script>
		$(function(){ 
		var profileid = $('#profileid_hidden').attr('value'); 
		var page = $('#page_hidden').attr('value');
		$.getJSON('ajax/write.php',{action:"guest_load",eventid:profileid,start:0},function(data){
			if (page == 'guest')
			{
			$('#center').html('');//This is to remove "No more feed available" statement
			deploy.guest_deploy(data,'#center');
			}
			deploy.guest_deploy(data,'#left');
		});
		});
		</script>
		<?php
	if($profile_relation == 0 && $n['cancel'] == 0)
	{
	?>
		<div style="margin-top:2em;text-align:center;">
			<a style="color:#003399;" href="#" onclick="ui.event_cancel(this)">Cancel Event </a>
		</div>
	<?php
	}
	else if($profile_relation == 1)
	{
	?>
		<div style="margin-top:2em;text-align:center;">
			<a style="color:#003399;" href="#" onclick="ui.event_leave(this) " >Not going to <?php echo ' '.$profile_name; ?></a>
		</div>
	<?php
	}
	?>	
	</div>
	<?php
			if($page == 'event_about')
			{
				echo '<div id="center" >';
				echo '<div style="padding:1em;font-size:1.6em;font-weight:bold">'.$profile_name.'</div>';
				echo '<div style="padding:1em;font-size:1.3em;">'.$n['description'].'</div>';
				echo '<div style="padding:1em;font-size:1.3em;">On '.date('j M,Y',strtotime($n['date'])).' at '.$n['timing'].'</div>';
				echo '<div style="padding:1em;font-size:1.3em;">At '.$n['venue'].'</div>';
				$row = $database->get_name($n['host']); 
				echo '<div style="padding:1em;font-size:1.3em;">'.$guest_count.' guests</div>';
				echo '<div style="padding:1em;font-size:1.3em;">';
				?>
				<a style="font-size:1em;" href="profile.php?id=<?php echo $n['host']; ?>"> <?php echo $row['NAME']; ?></a> is the host</div></div>
				<?php
			}
			else if($page == 'event_json')
			{
				echo '<div id="center" >';
				require('../include/actions.php');
				echo '</div>';
			}
			else if($page == 'event_settings')
			{
				echo '<div id="center" style="text-align:center">';
				?>
				<h1 class="page_title">Event Settings</h1>
					<div id="group_info"></div>
					<div>
						<span style="margin:1em 0em;padding:0.5em;">Event Name :</span>
						<span style="margin:1em 0em;padding:0.5em;"><?php echo $n['name']; ?></span>
					</div>
					<div>
						<textarea style="margin: 1em 0em;padding:0.5em;" id="group_description" placeholder="What is this group about ?"><?php echo $n['description']; ?></textarea>
					</div>
					<div>
						<div style="margin:1em 0em;">Privacy: <select id="group_privacy"><option <?php if($n['privacy'] == 0) echo 'selected'; ?> value="0">Public</option><option <?php if($n['privacy'] == 1) echo 'selected'; ?> value="1">Private</option></select></div>
					</div>
					<?php $d = explode('-',$n['date']); 
						$year = $d[0];
						$month = $d[1];
						$day = $d[2];
					?>
					<div style="margin:1em 0em;">
						When : <select id="event_day" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Day</option><option value="01">1</option><option value="02">2</option><option value="03">3</option><option value="04">4</option><option value="05">5</option><option value="06">6</option><option value="07">7</option><option value="08">8</option><option value="09">9</option><option value="10">10</option> <option value="11">11</option><option value="12">12</option><option value="01">13</option><option value="02">14</option><option value="03">15</option><option value="04">16</option><option value="05">17</option><option value="06">18</option><option value="07">19</option><option value="08">20</option><option value="09">21</option> <option value="10">22</option><option value="11">23</option><option value="12">24</option><option value="01">25</option><option value="02">26</option> <option value="03">27</option><option value="04">28</option> <option value="05">29</option><option value="04">30</option><option value="05">31</option></select><select id="event_month" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Month</option> <option value="01">JAN</option><option value="02">FEB</option><option value="03">MAR</option><option value="04">APR</option><option value="05">MAY</option><option value="06">JUN</option> <option value="07">JUL</option><option value="08">AUG</option> <option value="09">SEP</option><option value="10">OCT</option><option value="11">NOV</option> <option value="12">DEC</option></select><select id="event_year" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Year</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option></select><select id="event_time" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Time</option><option value="09:00:00">09:00 am</option><option value="09:30:00">09:30 am</option><option value="1000">10:00 am</option><option value="10:30:00">10:30 am</option><option value="11:30:00">11:30 am</option><option value="12:00:00">12:00 pm</option><option value="12:30:00">12:30 pm</option><option value="13:00:00">01:00 pm</option><option value="13:30:00">01:30 pm</option><option value="14:00:00">02:00 pm</option><option value="14:30:00">02:30 pm</option><option value="15:00:00">03:00 pm</option><option value="15:30:00">03:30 pm</option><option value="16:00:00">04:00 pm</option><option value="16:30:00">04:30 pm</option><option value="17:00:00">05:00 pm</option><option value="17:30:00">05:30 pm</option><option value="18:00:00">06:00 pm</option><option value="18:30:00">06:30 pm</option><option value="19:00:00">07:00 pm</option><option value="19:30:00">07:30 pm</option><option value="20:00:00">08:00 pm</option><option value="20:30:00">08:30 pm</option><option value="21:00:00">09:00 pm</option><option value="21:30:00">09:30 pm</option><option value="22:00:00">10:00 pm</option><option value="22:30:00">10:30 pm</option><option value="23:00:00">11:00 pm</option><option value="23:30:00">11:30 pm</option><option value="00:00:00">12:00 am</option><option value="00:30:00">12:30 am</option><option value="01:00:00">01:00 am</option><option value="01:30:00">01:30 am</option><option value="02:00:00">02:00 am</option><option value="02:30:00">02:30 am</option><option value="03:00:00">03:00 am</option><option value="03:30:00">03:30 am</option><option value="01:00:00">01:00 am</option><option value="01:30:00">01:30 am</option><option value="02:00:00">02:00 am</option><option value="02:30:00">02:30 am</option><option value="03:00:00">03:00 am</option><option value="03:30:00">03:30 am</option><option value="04:00:00">04:00 am</option><option value="04:30:00">04:30 am</option><option value="05:00:00">05:00 am</option><option value="05:30:00">05:30 am</option><option value="06:00:00">06:00 am</option><option value="06:30:00">06:30 am</option><option value="07:00:00">07:00 am</option><option value="07:30:00">07:30 am</option><option value="08:00:00">08:00 am</option><option value="08:30:00">08:30 am</option></select>
					</div>
					<div style="margin:1em 0em;">
						Where: <input type="text" id="event_where" value="<?php echo $n['venue']; ?>" placeholder="Venue of this event" style="height:1.6em;padding:0.5em;width:22em"/>
					</div>
					<?php 
					if($n['invite'] == 1)
					{
					?>
					<div style="margin:1em 0em"><input type="checkbox" id="group_invite" checked> Guests can invite their friends</div>
					<?php 
					}
					else
					{
					?>
					<div style="margin:1em 0em"><input type="checkbox" id="group_invite"> Guests can invite their friends</div>
					<?php 					
					}
					?>
					<div class="group_create_button">
						<input style="margin:0em 1em" type="submit" onclick="action.event_settings_save(this)" value="Save" class="group_create_positive">
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
		<?php
	if($n['cancel'] == 1)
	{
		?>
		<div style="clear:both;margin:1em 0em;font-weight:bold;">This event has been cancelled</div>
		<?php
	}
	if($profile_relation == 0 || $profile_relation == 1)
	{
		?>
		<div style="clear:both;margin:1em 0em;">You are going to <?php echo $profile_name; ?></div>
		<?php
			if($n['cancel'] == 0 && $n['groupid'] == 0 )
			{
				?>
					<div id="group_invite_info" style="margin:0em 0em 0.8em 0em;"></div>
					<input type="text" style="border:0.1em solid #999999;width:20em;height:1.2em;padding:0.5em;" id="invite_box" value="" onkeyup="ui.event_friend_invite(this)" placeholder="Invite a friend to this event" />
					<div style="position:relative;" id="group_friend_invite"></div>
				<?php
			}  
	}
	else if($profile_relation == 2) 
	{
		?>
		<div style="clear:both;margin:1em 0em;">You have been invited to attend <?php echo $profile_name; ?></div>
		<div class="subtitle">
			<div class="friend_request_class">
				<a href="event.php?id=<?php echo $profileid; ?>">
					<img class="lfloat" style="margin-right:1em;" src="http://icon.qmcdn.net/event.png" height="50" width="50">
				</a>
				<div>
					<a class="bold" href="event.php?id=<?php echo $profileid; ?>"><?php echo $profile_name; ?></a><div><input type="submit" class="frequest" data="<?php echo $profileid; ?>" id="1" value="Going" onclick="action.guest_accept(this, 1)" /><input type="submit" class="frequest" data="<?php echo $profileid; ?>" style="margin-left:0.5em;" id="0" value="Decline" onclick="action.guest_accept(this, 0)" /></div>
				</div>
			</div>
		</div>
		<?php    
	}
	else if($profile_relation == 3)
	{
		?>
		<div style="clear:both;margin:1em 0em;">You have declined to <?php echo $profile_name; ?></div>
		<span id="add_container" class="profile_actions_container">
			<input class="profile_actions_button" id="<?php echo $profileid ?>" style="width:9.5em;" type="submit" onclick="action.event_join(this)" value="+Attend Event" id="<?php echo $profileid; ?>"/> 
		</span>
		<?php   
	}
	else if($profile_relation == 4)
	{
		?>
		<div style="clear:both;margin:1em 0em;">You are not going to <?php echo $profile_name; ?></div>
		<span id="add_container" class="profile_actions_container">
			<input class="profile_actions_button" id="<?php echo $profileid ?>" style="width:9.5em;" type="submit" onclick="action.event_join(this)" value="+Attend Event" id="<?php echo $profileid; ?>"/> 
		</span>
		<?php   
	}
	?>
		<div class="right_item" id="group_link">
			<div class="subtitle">Event Details</div>
			<div>
				<div>Date: <?php echo date('j M,Y',strtotime($n['date']));?>
				</div>
				<div>
				Time: <?php echo $n['timing'];?>
				</div>
			<div>
			Venue: <?php echo $n['venue'];?>
			</div>
			</div>
		</div>
		<div class="right_item" id="group_description">
			<div class="subtitle">Event Description</div>
			<div><?php echo $n['description'];?></div>
		</div>
	</div>
</div>
<?php require_once('../include/footer.php'); ?>
</body>
</html>