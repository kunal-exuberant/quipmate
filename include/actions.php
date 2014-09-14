<?php
global $help,$memcached,$database,$icon_cdn;
if($page == 'group_json' && ($profile_relation == 0 || $profile_relation == 1))
{
?>
<div id="upload_box"> 
	<ol class="breadcrumb">
	  <li id="status_link" ><a href="#">Discussion</a></li>
	  <li id="photo_link" ><a href="#">File</a></li>
	  <li id="question_link" onclick="ui.group_question(this)"  ><a href="#">Question</a></li>
	  <li id="event_link" onclick="ui.group_event_create(this,1)" ><a href="#">Event</a></li>	
	</ol>
	<div  id="uploader">  
	<!--	<input type="text" id="status_box" value="" placeholder="Post in <?php //echo $profile_name;?> group"/>
		<input id="link_button" type="submit" value="Post">     -->
	</div>
</div>
<?php
}
else if($page == 'event_json')
{ 
?>
<div id="upload_box"> 
	<ol class="breadcrumb">
	  <li id="status_link" ><a href="#">Discussion</a></li>
	  <li id="photo_link" ><a href="#">File</a></li>
	</ol>
	<div  id="uploader">  
	<!--	<input type="text" id="status_box" value="" placeholder="Post in <?php //echo $profile_name;?> event"/>
		<input id="link_button" type="submit" value="Post">     -->
	</div>
</div>
<?php
}
else if($page == 'page_json' && $profile_relation == 0 )
{ 
?>
<div id="upload_box"> 
	<ol class="breadcrumb">
	  <li id="status_link" ><a href="#">Discussion</a></li>
	  <li id="photo_link" ><a href="#">File</a></li>
	</ol>
	<div  id="uploader">  
	</div>
</div>
<?php
}
else if($profile_relation == 0)
{
			$myprofileid = $_SESSION['userid'];
			$flag = $database->privacy_item_select('profile_post_next',$myprofileid);
			SWITCH($flag)
			{
				CASE 0: $icon_image=$icon_cdn.'/global.png';
					break;
				CASE 1: $icon_image=$icon_cdn.'/meeting.png';
					break;
				CASE 2: $icon_image=$icon_cdn.'/friend.png';
					break;
				default:$icon_image=$icon_cdn.'/global.png';
					break;
			}
?>
<div id="upload_box"> 
	<ol class="breadcrumb">
	  <li id="status_link" ><a href="#">Discussion</a></li>
	  <li id="photo_link" ><a href="#">File</a></li>
	  <li id="moment_link" ><a href="#">Album</a></li>
	  <li id="question_link" ><a href="#">Question</a></li>
	  <?php 
		if ($help->feature_fetch('mood', $memcached, $database))
		{ 
	  ?>
		  <li onclick="ui.mood(this)" ><a href="#">Mood</a></li>
	  <?php
		 }
	  ?>
		<span id="profile_post_privacy_link" onclick="ui.profile_post_privacy(this,event)" style="margin-left:0.5em;cursor:pointer;"><img title="Set the privacy of your next post" src="<?php echo $icon_image;?>" height="14" width="14" /></span>
						
	</ol> 
	<div id="uploader">
	<!--	<input type="text" id="status_box" value="" placeholder="What are you working on today?"/>
		<input id="link_button" type="submit" value="Share"> -->
	</div> 
</div>
<?php
}
else if($profile_relation == 1)
{
?>
<div id="upload_box"> 
	<ol class="breadcrumb">
	  <li id="status_link" ><a href="#">Discussion</a></li>
	  <li id="photo_link" ><a href="#">File</a></li>
	  <li id="moment_link" ><a href="#">Album</a></li>
	  <li data-toggle="modal"  data-target="#praisemodalbadge" ><a href="#">Praise</a></li>			
	</ol>
	<div  id="uploader">  
	<!--	<input type="text" id="status_box" value="" placeholder="Post in <?php //echo $profile_name;?>'s diary"/>
		<input id="link_button" type="submit" value="Post">     -->
	</div>
</div>
<?php
}
?>