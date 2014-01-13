<?php
if($page == 'group_json' && ($profile_relation == 0 || $profile_relation == 1))
{
?>
<div id="upload_box"> 
	<div id="actions">
		<span id="status_link" style="margin-left:0em;cursor:pointer;"><img src="http://icon.qmcdn.net/post_blue.png" height="16" width="16" /><span class="">Discussion</span></span>
		<span id="photo_link" style="margin-left:0.5em;cursor:pointer;"><img src="http://icon.qmcdn.net/file_upload_blue.png" height="16" width="16" /><span class="">Photo/Video/Doc</span></span>
		<span onclick="ui.group_question(this)" style="margin-left:0.5em;cursor:pointer;"><img src="http://icon.qmcdn.net/poll_blue.png" height="16" width="16" /><span class="">Question</span></span>	
		<span onclick="ui.group_event_create(this,1)" style="margin-left:0.5em;cursor:pointer;"><img src="http://icon.qmcdn.net/event.png" height="16" width="16" /><span class="">Event</span></span>	
	</div> 
	<div style="margin-top:.5em;text-align:center;" id="uploader">  
		<input type="text" id="status_box" value="" placeholder="Post in <?php echo $profile_name;?> group"/>
		<input id="link_button" type="submit" value="Post">     
	</div>
</div>
<?php
}
else if($page == 'event_json')
{ 
?>
<div id="upload_box"> 
	<div id="actions">
		<span id="status_link" style="margin-left:0em;cursor:pointer;"><img src="http://icon.qmcdn.net/post_blue.png" height="16" width="16" /><span class="">Post</span></span>
		<span id="photo_link" style="margin-left:0.5em;cursor:pointer;"><img src="http://icon.qmcdn.net/file_upload_blue.png" height="16" width="16" /><span class="">Photo/Video/Doc</span></span>
	</div> 
	<div style="margin-top:.5em;text-align:center;" id="uploader">  
		<input type="text" id="status_box" value="" placeholder="Post in <?php echo $profile_name;?> event"/>
		<input id="link_button" type="submit" value="Post">     
	</div>
</div>
<?php
}
else if($profile_relation == 0)
{
?>
<div id="upload_box"> 
	<div id="actions">
		<span id="status_link" style="margin-left:0em;cursor:pointer;"><img src="http://icon.qmcdn.net/post_blue.png" height="16" width="16" /><span class="action_item">Status</span></span>
		<span id="photo_link" style="margin-left:0.5em;cursor:pointer;" ><img src="http://icon.qmcdn.net/file_upload_blue.png" height="16" width="16" /><span class="action_item">Photo/Video/Doc</span></span>
		<span id="moment_link" style="margin-left:0.5em;cursor:pointer;"><img src="http://icon.qmcdn.net/album_upload_blue.gif" height="16" width="16" /><span class="action_item">Album</span></span>
		<span id="question_link" style="margin-left:0.5em;cursor:pointer;"><img src="http://icon.qmcdn.net/poll_blue.png" height="16" width="16" /><span class="action_item">Question</span></span>		
		<span onclick="ui.mood(this)" style="margin-left:0.5em;cursor:pointer;"><img width="16" height="16" src="http://icon.qmcdn.net/mood_blue.png" /><span class="action_item">Set-Mood</span></span>
		<span id="profile_post_privacy_link" onclick="ui.profile_post_privacy(this,event)" style="margin-left:0.5em;cursor:pointer;"><img title="Set the privacy of your next post" src="http://icon.qmcdn.net/privacy_cc.png" height="16" width="16" /></span>
	</div> 
	<div style="margin-top:.5em;text-align:center;" id="uploader">
		<input type="text" id="status_box" value="" placeholder="What's going in your life?"/>
		<input id="link_button" type="submit" value="Share">
	</div> 
</div>
<?php
}
else if($profile_relation == 1)
{
?>
<div id="upload_box"> 
	<div id="actions">
		<span id="status_link" style="margin-left:0em;cursor:pointer;"><img src="http://icon.qmcdn.net/post_blue.png" height="16" width="16" /><span class="">Post</span></span>
		<span id="photo_link" style="margin-left:0.5em;cursor:pointer;"><img src="http://icon.qmcdn.net/file_upload_blue.png" height="16" width="16" /><span class="">Photo/Video/Doc</span></span>
		<span id="moment_link" style="margin-left:0.5em;cursor:pointer;"><img src="http://icon.qmcdn.net/album_upload_blue.gif" height="16" width="16" /><span class="">Album</span></span>
		<span class="gift_button" style="margin-left:0.5em;cursor:pointer;" onclick="ui.gift_ui_create(this)"><img src="http://icon.qmcdn.net/gift_icon.ico" height="16" width="16" /><span class="">Send-Gift</span></span>
	</div> 
	<div style="margin-top:.5em;text-align:center;" id="uploader">  
		<input type="text" id="status_box" value="" placeholder="Post in <?php echo $profile_name;?>'s diary"/>
		<input id="link_button" type="submit" value="Post">     
	</div>
</div>
<?php
}
?>