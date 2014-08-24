<div id="sidebar">
		<div id="rtm_container"></div>
        <div class="chat_toolbar">
			 <div class="chat_search" style="position:relative;padding-bottom:0.5em;"><input type="text" id="chat_search_box" placeholder="People in your network" style="width:100%;height:2.5em;padding:0.2em 3.3em 0.2em 0.5em;border:none;border-bottom:0.1em solid #cccccc;">
				<input style="width:2em;position:absolute;top:0.1em;right:0em;height:2.3em;cursor:pointer;border:0.1em solid #ffffff !important;background-image:url(https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com/search_icon.png) !important;" type="submit" name="search" value="" />
			 </div> 
        </div>
		<div id="friend_status" class="friend_status_big">
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
<!--***************************** Define all Modals here  ******************************************************-->
<div class="modal fade" id="sharemodal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 class="modal-title" id="myModalLabel">Share on your timeline</h4>
            </div>
            <div class="modal-body">
				<div class="text-center">
					<textarea style="" placeholder="Say something about this ." id="reshare_box"></textarea>
				</div>
                <div id="share_content">
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary theme_button" id="share_actionid" data="" onclick="action.share_post(this)">Share</button>
			</div>
    </div>
  </div>
</div>
<!-- ************************ modal for Praise **************************** -->

<div class="modal fade" id="praisemodal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 class="modal-title" id="myModalLabel">Publically praise for outstanding work</h4>
            </div>
            <div class="modal-body text-center">
				<div style="margin-top:1em;"><textarea style="padding:0.5em;" id="letter_title" type="text" placeholder="What is the outstanding contribution?" ></textarea>
                </div>
                <div style="margin-top:1em;"><textarea placeholder="Word of applause" id="letter_content" style="padding:0.5em;height:16em;resize:none;"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary theme_button" id="share_actionid" data="" onclick="action.praise_send(this)">Share</button>
			</div>
    </div>
  </div>
</div>
<!-- ********************************************************************** -->

<?php
	$file->script_footer();
	//$file->google_analytics();
?>