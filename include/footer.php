<div id="sidebar">
		<div id="rtm_container" class="mousescroll"></div>
        <div class="chat_toolbar">
			 <div class="chat_search" style="position:relative;padding-bottom:0.5em;"><input type="text" id="chat_search_box" placeholder="People in your network" style="width:100%;height:2.5em;padding:0.2em 3.3em 0.2em 0.5em;border:none;border-bottom:0.1em solid #cccccc;">
				<input style="width:2em;position:absolute;top:0.1em;right:0em;height:2.3em;cursor:pointer;border:0.1em solid #ffffff !important;background-image:url(https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com/search_icon.png) !important;" type="submit" name="search" value="" />
			 </div> 
        </div>
		<div id="friend_status" class="friend_status_big mousescroll">
		     <div class="online_user"></div> 
		</div>
</div>
<div id="bottombar" class="friend_status_small"> 
		     <div class="chat_toolbar">
		     <div class="chat_container_title"><img style="margin-right:0.5em;" src="<?php echo $icon_cdn?>/online.png" />Colleagues Online </div>
		     </div>
		     <div class="online_user"></div>
</div>
<div id="chatbox_container"></div>
<?php
	$file->script_footer();
	//$file->google_analytics();
?>