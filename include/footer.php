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
<div class="modal fade" id="praisemodalbadge" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
             <h4 class="modal-title" id="myModalLabel">Publically praise for outstanding work by sending a badge .</h4>
            </div>
            <div class="modal-body">
				<div id="badge_picker">
                    <ul>
                    <li class="badge">
                    <a class="badge_chooser" data-badge-id="101" href="#"><img alt="Quick Learner" height="70" src="<?php echo $icon_cdn ;?>/earlyadopter_square70.png" width="70" />
                    <div class="badge_name">Quick Learner</div>
                    </a></li>
                    <li class="badge">
                    <a class="badge_chooser" data-badge-id="102" href="#"><img alt="Leader" height="70" src="<?php echo $icon_cdn ;?>/leadership_square70.png" width="70" />
                    <div class="badge_name">Leader</div>
                    </a></li>
                    <li class="badge">
                    <a class="badge_chooser" data-badge-id="103" href="#"><img alt="Mentor" height="70" src="<?php echo $icon_cdn ;?>/mentor_square70.png" width="70"/>
                    <div class="badge_name">Mentor</div>
                    </a></li>
                    <li class="badge">
                    <a class="badge_chooser" data-badge-id="104" href="#"><img alt="Presentation" height="70" src="<?php echo $icon_cdn ;?>/presentation_square70.png" width="70"/>
                    <div class="badge_name">Presentation</div>
                    </a></li>
                    <li class="badge">
                    <a class="badge_chooser" data-badge-id="105" href="#"><img alt="Problem Solver" height="70" src="<?php echo $icon_cdn ;?>/problemsolver_square70.png" width="70" />
                    <div class="badge_name">Problem Solver</div>
                    </a></li>
                    <li class="badge">
                    <a class="badge_chooser" data-badge-id="106" href="#"><img alt="Teamwork" height="70" src="<?php echo $icon_cdn ;?>/teamwork_square70.png" width="70" />
                    <div class="badge_name">Teamwork</div>
                    </a></li>
                    <li class="badge">
                    <a class="badge_chooser" data-badge-id="107" href="#"><img alt="Visionary" height="70" src="<?php echo $icon_cdn ;?>/visionary_square70.png" width="70" />
                    <div class="badge_name">Visionary</div>
                    </a></li>
                    <li class="badge">
                    <a class="badge_chooser" data-badge-id="108" href="#"><img alt="Work Ethic" height="70" src="<?php echo $icon_cdn ;?>/workethic_square70.png" width="70" />
                    <div class="badge_name">Work Ethic</div>
                    </a></li>
                    <li class="badge">
                    <a class="badge_chooser" data-badge-id="109" href="#"><img alt="You Rock" height="70" src="<?php echo $icon_cdn ;?>/yourock_square70.png" width="70" />
                    <div class="badge_name">You Rock</div>
                    </a></li>
                     <li class="badge">
                    <a class="badge_chooser" data-badge-id="110" href="#"><img alt="Communication" height="70" src="<?php echo $icon_cdn ;?>/communication_square70.png" width="70" />
                    <div class="badge_name">Communication</div>
                    </a></li>
                    <li class="badge">
                    <a class="badge_chooser" data-badge-id="111" href="#"><img alt="Company Spirit" height="70" src="<?php echo $icon_cdn ;?>/companyspirit_square70.png" width="70" />
                    <div class="badge_name">Company Spirit</div>
                    </a></li>
                    <li class="badge">
                    <a class="badge_chooser" data-badge-id="112" href="#"><img alt="Customer Satisfaction" height="70" src="<?php echo $icon_cdn ;?>/customersatisfaction_square70.png" width="70" />
                    <div class="badge_name">Customer Satisfaction</div>
                    </a></li>                   
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
			</div>
    </div>
  </div>  
</div>
<div class="modal fade" id="praisemodal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 class="modal-title" id="myModalLabel">Publically praise for outstanding work</h4>
            </div>
            <div class="modal-body text-center">
				<div style="margin-top:1em;" id="praisebody">
                <input type="hidden" id="badge_id" value=""></input>
                <span id="badge_image"></span>
                <textarea style="padding:0.5em;" id="letter_title" type="text" placeholder="Title for praise " ></textarea>
                </div>
                <div style="margin-top:1em;"><textarea placeholder="Description of praise" id="letter_content" style="padding:0.5em;height:16em;resize:none;"></textarea>
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
<!-- **************************************modal to upload a file ************************** -->
<div class="modal fade" id="uploadfilemodal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 class="modal-title" id="file_upload_modal_level" >Upload file in </h4> 
            </div>
            <div class="modal-body text-center">
            <form action="/ajax/write.php" enctype="multipart/form-data" method="post" id="pform">
                <input type="hidden" value="" name="photo_hidden_profileid" id="photo_hidden_profileid" />
                <input type="hidden" value="" name="action" id="action_hidden"/>
				<div style="margin-top:1em;">
                <textarea style="padding:0.5em;" id="photo_description" name="photo_description"  placeholder="Say something about this file" ></textarea>
                </div>
                <div>
						<input type="file" id="photo_box" name="photo_box" class="file_inline" />
				</div> 
                <div id="upload_progress"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary theme_button" id="photo_upload_button" data="" value="Upload"/>
    			</div>
          </form>  
    </div>
  </div>
</div>

<!-- **************************************************************************************** -->

<?php
	$file->script_footer();
	//$file->google_analytics();
?>