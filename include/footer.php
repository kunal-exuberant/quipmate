<input type="hidden" id="profileid_hidden" value="<?php echo $profileid; ?>" />
<input type="hidden" id="profileid_hidden" value="<?php echo $profileid; ?>" />
<input type="hidden" id="myprofileid_hidden" value="<?php echo $myprofileid; ?>" />
<input type="hidden" id="profilename_hidden" value="<?php $database = new Database(); $row = $database->get_name($profileid); echo $row['NAME'];?>" />
<input type="hidden" id="friend_online_list_hidden" value="" />
<input type="hidden" id="chatid_hidden" value="0" />
<div id="random_hidden" type="hidden"></div>
<div id="sidebar">
		<div id="rtm_container"></div>
        <div class="chat_toolbar">
		     <div class="chat_container_title"><img style="margin-right:0.5em;" src="http://icon.qmcdn.net/online.png" />Friends Online </div>
			 <div class="chat_search" style="position:relative;padding-bottom:0.5em;"><input type="text" id="chat_search_box" placeholder="Search Friends" style="width:100%;height:2em;padding:0.2em 3.3em 0.2em 0.5em;border:none;border-bottom:0.1em solid #cccccc;">
				<input style="width:2.8em;position:absolute;top:0.1em;right:0em;height:2.3em;cursor:pointer;border:0.1em solid #ffffff;background-image:url(http://icon.qmcdn.net/search_icon.png);" type="submit" name="search" value="" />
			 </div> 
        </div>
		<div id="friend_status" class="friend_status_big">
		     <div class="online_user"></div> 
		</div>
</div>
<div id="bottombar" class="friend_status_small"> 
		     <div class="chat_toolbar">
		     <div class="chat_container_title"><img style="margin-right:0.5em;" src="http://icon.qmcdn.net/online.png" />Friends Online </div>
		     </div>
		     <div class="online_user"></div>
</div>
<div id="chatbox_container"></div>
<?php
	$file->script_footer();
	$file->google_analytics();
?>