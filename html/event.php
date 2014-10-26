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
			<div class="text-center"><a href="event.php?id=<?php echo $profileid ?>"><img class="img-thumbnail" src="<?php echo $profile_image; ?>" /></a></div>
			
			<div class="text-center">
				<a class="ajax_nav" href="event.php?id=<?php echo $profileid; ?>" class="ellipsis"><?php echo $profile_name; ?></a>
			</div>
			<?php if($profile_relation == 0) {?>
			<div class="text-center">
				<a  class="ajax_nav" href="event.php?hl=settings&id=<?php echo $profileid; ?>">Edit Event Settings</a>
			</div>
			<?php }?>
			<ul class=" nav nav-pills nav-stacked panel-body"> 
					<li class="links" <?php if($page == 'event_json') echo 'style="background:#ddd;"'; ?>><a class="ajax_nav" id="group_json" href="event.php?id=<?php echo $profileid.'&hl=post'?>" title="Event posts"><span >Event Feed</span></a></li>
					
					<li class="links" <?php if($page == 'event_about') echo 'style="background:#ddd;"'; ?>><a  class="ajax_nav" id="about" href="event.php?id=<?php echo $profileid.'&hl=about'?>" title="About the event"><span >About</span></a></li>

					<li class="links" <?php if($page == 'guest') echo 'style="background:#ddd;"'; ?>><a id="inbox" href="event.php?id=<?php echo $profileid.'&hl=guest'?>" title="Guest expected"><span >Guest expected(<?php $guest_count = $database->guest_count($profileid); echo  $guest_count; ?>)</span></a></li>
			</ul>
	<?php
		?>		
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
			<a style="color:#003399;" class ="ellipsis" href="#" onclick="ui.event_leave(this) " >Not going to <?php echo ' '.$profile_name; ?></a>
		</div>
	<?php
	}
	?>	
	</div>
	<?php
			if($page == 'event_about')
			{
				echo '<div id="center" class="col-md-6 center" >';
				echo '<div class="panel panel-default"><div class="panel-heading">About this Event</div><div class="panel-body"><h4 class="bold">'.$profile_name.'';
				echo '<div ><h5>'.$n['description'].'</h5></div>';
				echo '<div ><h5>On '.date('j M,Y',strtotime($n['date'])).' at '.$n['timing'].'</h5></div>';
				echo '<div ><h5>At '.$n['venue'].'</h5></div>';
				$row = $database->get_name($n['host']); 
				echo '<div ><h5>'.$guest_count.' guests</h5></div>';
				echo '<div ><h5>';
				?>
				<a href="profile.php?id=<?php echo $n['host']; ?>"> <?php echo $row['NAME']; ?></a> is the host</h5></div></div></div></div>
				<?php
			}
			else if($page == 'event_json')
			{
				echo '<div id="center" class="col-md-6 center">';
				require('../include/actions.php');
				echo '</div>';
			}
			else if($page == 'event_settings')
			{
				echo '<div id="center" class="col-md-6 center">';
				?>
                <div class="panel panel-default">
				<div class="panel-heading">Event Settings</div>
                <div class="panel-body">
					<div id="group_info"></div>
					<div class="form-group"></h4><?php echo $n['name']; ?></h4>
					</div>
					<div class="form-group">
						<textarea id="group_description" class="form-control"><?php echo $n['description']; ?></textarea>
					</div>
					<div>
						<div class="form-group"><label>Privacy:</label> 
                        <select id="group_privacy" class="form-control">
                          <option <?php if($n['privacy'] == 0) echo 'selected'; ?> value="0">Public</option>
                          <option <?php if($n['privacy'] == 1) echo 'selected'; ?> value="1">Private</option>
                        </select>
                        </div>
					</div>
					<?php $d = explode('-',$n['date']); 
						$year = $d[0];
						$month = $d[1];
						$day = $d[2];
					?>
					<div class="form-group">
                        <label class="">When</label>
                        <div class="form-inline">
                             <select size="1" id="event_day" class="form-control">
                        	  <option value="-1">Day</option>
                        	  <?php 
                        	  for($i=1;$i<=31;$i++)
                        	  {
                        		echo '<option value="'.$i.'">'.$i.'</option>';
                        	  }
                        	  ?>
                        	</select>
                        	<select id="event_month" class="form-control">
                        	  <option value="-1">Month</option>
                        	  <option value="01">JAN</option>
                        	  <option value="02">FEB</option>
                        	  <option value="03">MAR</option>
                        	  <option value="04">APR</option>
                        	  <option value="05">MAY</option>
                        	  <option value="06">JUN</option>
                        	  <option value="07">JUL</option>
                        	  <option value="08">AUG</option>
                        	  <option value="09">SEP</option>
                        	  <option value="10">OCT</option>
                        	  <option value="11">NOV</option>
                        	  <option value="12">DEC</option>		
                        	</select>
                        	<select size="1" id="event_year" class="form-control">
                        	  <option value="-1">Year</option>
                        	  <?php 
                        	  for($i=2014;$i<=2022;$i++)
                        	  {
                        		echo '<option value="'.$i.'">'.$i.'</option>';
                        	  }
                        	  ?>
                        	</select>
                            <?php 
                            $start = strtotime('12:00 AM');
                            $end   = strtotime('11:59 PM');
                            ?>
                            <select id="event_time" class="form-control">
                              <option value="-1">Time</option>
                                <?php for($i = $start;$i<=$end;$i+=1800){ ?>  
                                    <option value='<?php echo date('G:i', $i); ?>'><?php echo date('G:i', $i); ?></option>;
                                <?php } ?>
                            </select>
                         </div>
					</div>
                    <div class="form-group">
                        <label class="">Venue</label>
                        <input type="text" id="event_where" class="form-control" value="<?php echo $n['venue']; ?>"/>
                    </div>
					<?php 
					if($n['invite'] == 1)
					{
					?>
					<div class="form-group">
                        <label><input type="checkbox" id="group_invite" checked> Guests can invite their followers</label>
                    </div>
					<?php 
					}
					else
					{
					?>
					<div class="form-group">
                        <label><input type="checkbox" id="group_invite"> Guests can invite their followers</label>
                    </div>
					<?php 					
					}
					?>
					<div class="form-group">
						<button onclick="action.event_settings_save(this)"  class="btn btn-primary bold">Save</button>
					</div>
                </div>
               </div> 
            </div>
   	        <?php
			}
			else
			{
				echo '<div id="center" class="col-md-6 center"></div>';
			}
	?>
	<div id="right" class="col-md-3 right">
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
					<div class="panel panel-default">
                    <div class="panel-heading">Invite to this event</div>
                    <div class="panel-body">                                        
                    <div id="group_invite_info" style="margin:0em 0em 0.8em 0em;"></div>
					<input type="text" id="group_invite_box" value="" onkeyup="ui.event_friend_invite(this)" placeholder="Invite a colleague to this event" />
                                        
					<div style="position:relative;" id="group_friend_invite"></div>
                    </div>
                    </div>                                        
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
					<img class="lfloat" style="margin-right:1em;" src="<?php echo $icon_cdn?>/event.png" height="50" width="50">
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
		<div class="panel panel-default" id="group_link">
			<div class="panel-heading">Event Details</div>
			<div class="panel-body">
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
		<div class="panel panel-default" id="group_description">
			<div class="panel-heading">Event Description</div>
			<div class="panel-body"><?php echo $n['description'];?></div>
		</div>
	</div>
</div><!-- Row Closed-->
</div>
<div class="col-mod-2">
<?php require_once('../include/footer.php'); ?>
</div>
</div>
</div>
</body>
</html>