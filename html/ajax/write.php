<?php
require('../../include/Session.php');
require('../../include/Database.php');
require_once '../../include/Help.php';
require_once '../../include/Encode.php';
require_once '../../include/Feed.php';
require_once '../../include/Email.php';
require_once '../../include/Json.php';
require_once '../../include/Api.php';
require_once '../../include/Memcached.php';
$session = new Session();
$session->start();
$api = new Api();
$help = new Help();
$database = new Database();
$encode = new Encode(); 
$feed = new Feed();
$email = new Email();
$json = new Json();
$memcached = new Memcached();
//-----------------CDN urls-----------------------------------------------
$doc_cdn='https://33b933d2350357486cc1-d29c0c794c48ec4a25d5921c354b372e.ssl.cf2.rackcdn.com';
$video_cdn='https://d3e2cb1ca268cb3294f9-0fef5c8c1028eda88d7042156742e54b.ssl.cf2.rackcdn.com';
$image_cdn='https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com';
$photo_cdn='https://becda623bf8870bb68df-da0c8a7673dba397789e9545fd410b00.ssl.cf2.rackcdn.com';
$photo1_cdn='https://f4dfddb292f8d39c5f03-2b60e932c1f7626b00bc844829f205ef.ssl.cf2.rackcdn.com';
$photo2_cdn='https://e78706030ea463f742ec-7f30f58971c4d84451f1b09b50376932.ssl.cf2.rackcdn.com';
$photo3_cdn='https://78a98406523b98e35ec5-977a0302e2efb5297f8dccd652418b2f.ssl.cf2.rackcdn.com';
$icon_cdn='https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com';
$profile_cdn='https://17ba44c6e294ab81f639-55f93745d66bc3cab58e675e4895e5a0.ssl.cf2.rackcdn.com';
$profile1_cdn='https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com';
$profile2_cdn='https://9705b7cc157c961ef7ae-4a44337e03ff403fef65c34695d2cabb.ssl.cf2.rackcdn.com';
$profile3_cdn='https://0a2abf9dcdcced43b8f7-1b4829c2a7a950b17b2dd0e311c873ce.ssl.cf2.rackcdn.com';
$script_cdn='https://cb1c99c599f84e82bc6c-9f7d7d8a0bec2e21a1a6ea697d537f8d.ssl.cf2.rackcdn.com';
$style_cdn='https://7f0cf736abbdd4f83d8b-475de27d87a6fd312d1dd9701d87a2a9.ssl.cf2.rackcdn.com';
//--------------------------------------------------------------------------------------
$action = array();

//-1 checks if the account has been disabled ;
if(isset($_SESSION['auth']) && $_SESSION['STEP'] != -1 )
{
	if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET))
	{
		if(isset($_GET['action']))
		{
			if($_GET['action'] == 'action_fetch')
			{
				$api->action_fetch();
			}
			else if($_GET['action'] == 'action_fetch_life_is_not_always_fun')
			{
				$api->action_fetch_life_is_not_always_fun();
			}
			else if($_GET['action'] == 'actiontype_preview')
			{
				$api->actiontype_preview();
			}
			else if($_GET['action'] == 'add_friend')
			{
				$api->add_friend();
			}
			else if($_GET['action'] == 'event_leave')
			{
				$api->event_leave();
			}
			else if($_GET['action'] == 'album_fetch')
			{
				$api->album_fetch();
			}			
			else if($_GET['action'] == 'technical_feed_fetch')
			{
				$api->technical_feed_fetch();
			}
			else if($_GET['action'] == 'group_top_influencer_fetch')
			{
				$api->group_top_influencer_fetch();
			}
			else if($_GET['action'] == 'feedback')
			{
				$api->feedback();
			}
			else if($_GET['action'] == 'bio_item_remove')
			{
				$api->bio_item_remove();
			}
			else if($_GET['action'] == 'bio_item_add')
			{
				$api->bio_item_add();
			}
			else if($_GET['action'] == 'birthday_bomb')
			{
				$api->birthday_bomb();
			}
			else if($_GET['action'] == 'answer')
			{
				$api->answer();
			}
			else if($_GET['action'] == 'birthday_bomb_fetch')
			{
				$api->birthday_bomb_fetch();
			}
			else if($_GET['action'] == 'birthday_select_all')
			{
				$api->birthday_select_all();
			}
			else if($_GET['action'] == 'callback_registration')
			{
				$api->callback_registration();
			}
			else if($_GET['action'] == 'callback')
			{
				$api->callback();
			}
			else if($_GET['action'] == 'callback_not_found')
			{
				$api->callback_not_found();
			}
			else if($_GET['action'] == 'chat_email')
			{
				$api->chat_email();
			}
			else if($_GET['action'] == 'college_select')
			{
				$api->college_select();
			}
			else if($_GET['action'] == 'college_student_select')
			{
				$api->college_student_select();
			}
			else if($_GET['action'] == 'comment')
			{
				$api->comment();
			}
			else if($_GET['action'] == 'share_post')
			{
				$api->share_post();
			}
			else if($_GET['action'] == 'show_all_comments')
			{
				$api->show_all_comments();
			} 
			else if($_GET['action'] == 'crush')
			{
				$api->crush();
			}
			else if($_GET['action'] == 'diary_create')
			{
				$api->diary_create();
			}
			else if($_GET['action'] == 'event_join')
			{
				$api->event_join();
			}
            else if($_GET['action'] == 'enable_user')
			{
				$api->enable_user();
			}
			else if($_GET['action'] == 'guest_accept')
			{
				$api->guest_accept();
			}
			else if($_GET['action'] == 'response_fetch')
			{
				$api->response_fetch();
			}
			else if($_GET['action'] == 'following_load')
			{
				$api->following_load();
			}
			else if($_GET['action'] == 'followers_load')
			{
				$api->followers_load();
			}
			else if($_GET['action'] == 'employee_invite')
			{
				$api->employee_invite();
			}
			else if($_GET['action'] == 'friend_invite_multiple')
			{
				$api->friend_invite_multiple();
			}
			else if($_GET['action'] == 'friend_load')
			{
				$api->friend_load();
			}
			else if($_GET['action'] == 'member_load')
			{
				$api->member_load();
			}
			else if($_GET['action'] == 'guest_load')
			{
				$api->guest_load();
			}
			else if($_GET['action'] == 'group_feed')
			{
				$api->group_feed();
			}
			else if($_GET['action'] == 'page_feed')
			{
				$api->page_feed();
			}
			else if($_GET['action'] == 'event_feed')
			{
				$api->event_feed();
			}
			else if($_GET['action'] == 'group_event_create')
			{
				$api->group_event_create();
			}
			else if($_GET['action'] == 'event_cancel')
			{
				$api->event_cancel();
			}
			else if($_GET['action'] == 'group_settings_save')
			{
				$api->group_settings_save();
			}
			else if($_GET['action'] == 'group_admin_make')
			{
				$api->group_admin_make();
			}
			else if($_GET['action'] == 'group_admin_remove')
			{
				$api->group_admin_remove();
			}
			else if($_GET['action'] == 'group_member_remove')
			{
				$api->group_member_remove();
			}
			else if($_GET['action'] == 'friend_request_accept')
			{
				$api->friend_request_accept();
			}
			else if($_GET['action'] == 'friend_request_fetch')
			{
				$api->friend_request_fetch();
			}
			else if($_GET['action'] == 'friend_fetch')
			{
				$api->friend_fetch();
			}
			else if($_GET['action'] == 'friend_fetch_incremental')
			{
				$api->friend_fetch_incremental();
			}
			else if($_GET['action'] == 'friend_details_fetch')
			{
				$api->friend_details_fetch();
			}
			else if($_GET['action'] == 'friend_search')
			{
				$api->friend_search();
			}
			else if($_GET['action'] == 'md_load')
			{
				$api->md_load();
			}
			else if($_GET['action'] == 'md_remove')
			{
				$api->md_remove();
			}
			else if($_GET['action'] == 'gift')
			{
				$api->gift();
			}
			else if($_GET['action'] == 'praise')
			{
				$api->praise();
			}
			else if($_GET['action'] == 'praise_fetch')
			{
				$api->praise_fetch();
			}
			
			else if($_GET['action'] == 'group_fetch')
			{
				$api->group_fetch();
			}
			else if($_GET['action'] == 'group_add_fetch')
			{
				$api->group_add_fetch();
			}
			else if($_GET['action'] == 'group_suggest_add')
			{
				$api->group_suggest_add();
			}
			else if($_GET['action'] == 'group_remove')
			{
				$api->group_remove();
			}
			
			else if($_GET['action'] == 'group_create')
			{
				$api->group_create();
			}
			else if($_GET['action'] == 'page_create')
			{
				$api->page_create();
			}
			else if($_GET['action'] == 'group_status')
			{
				$api->group_status();
			}
			else if($_GET['action'] == 'page_status')
			{
				$api->page_status();
			}
			else if($_GET['action'] == 'event_settings_save')
			{
				$api->event_settings_save();
			}
			else if($_GET['action'] == 'event_create')
			{
				$api->event_create();
			}
			else if($_GET['action'] == 'group_join')
			{
				$api->group_join();
			}
			else if($_GET['action'] == 'group_invite')
			{
				$api->group_invite();
			}
			else if($_GET['action'] == 'event_invite')
			{
				$api->event_invite();
			}
			else if($_GET['action'] == 'member_request_fetch')
			{
				$api->member_request_fetch();
			}
			else if($_GET['action'] == 'member_request_accept')
			{
				$api->member_request_accept();
			}
			else if($_GET['action'] == 'group_leave')
			{
				$api->group_leave();
			}
			else if($_GET['action'] == 'link_details_fetch')
			{
				$api->link_details_fetch();
			}
			else if($_GET['action'] == 'usefullinks')
			{
				$api->admin_usefullink();
			}
			else if($_GET['action'] == 'usefullinks_fetch')
			{
				$api->admin_fetch_usefullink();
			}
			else if($_GET['action'] == 'usefullink_delete')
			{
				$api->usefullink_delete();
			}
			else if($_GET['action'] == 'info_update')
			{
				$api->info_update();
			}
			else if($_GET['action'] == 'info_fetch')
			{
				$api->info_fetch();
			}
			
			else if($_GET['action'] == 'info_delete')
			{
				$api->info_delete();
			}
			else if($_GET['action'] == 'star_of_the_week')
			{
				$api->star_of_the_week();
			}
			else if($_GET['action'] == 'star_of_the_week_fetch')
			{
				$api->star_of_the_week_fetch();
			}
			else if($_GET['action'] == 'usefullinks_fetch')
			{
				$api->admin_fetch_usefullink();
			}
			else if($_GET['action'] == 'group_pinned_doc_fetch')
			{ 
				$api->group_pinned_doc_fetch();
			}
			else if($_GET['action'] == 'group_pinned_doc_remove')
			{ 
				$api->group_pinned_doc_remove();
			}
			else if($_GET['action'] == 'live_feed')
			{
				$api->live_feed();
			} 
			else if($_GET['action'] == 'missu')
			{
				$api->missu();
			}
			else if($_GET['action'] == 'missu_fetch')
			{
				$api->missu_fetch();
			}
			else if($_GET['action'] == 'message')
			{
				$api->message();
			}
			else if($_GET['action'] == 'message_fetch')
			{
				$api->message_fetch();
			}
			else if($_GET['action'] == 'message_recent_fetch')
			{
				$api->message_recent_fetch();
			}
			else if($_GET['action'] == 'message_send')
			{
				$api->message_send();
			}
			else if($_GET['action'] == 'message_college')
			{
				$api->message_college();
			}
			else if($_GET['action'] == 'mood')
			{
				$api->mood();
			}
			else if($_GET['action'] == 'mutual_friend')
			{
				$api->mutual_friend();
			}
			else if($_GET['action'] == 'news_feed')
			{
				$api->news_feed();
			}
			else if($_GET['action'] == 'user_details_fetch')
			{
				$api->user_details_fetch();
			}
			else if($_GET['action'] == 'flash_board_fetch')
			{
				$api->flash_board_fetch();
			}
			else if($_GET['action'] == 'set_MD')
			{
				$api->set_MD();
			}
			else if($_GET['action'] == 'user_delete')
			{
				$api->user_delete();
			}
			else if($_GET['action'] == 'moderator_remove')
			{
				$api->moderator_remove();
			}
			else if($_GET['action'] == 'star_remove')
			{
				$api->star_remove();
			}
			else if($_GET['action'] == 'make_moderator')
			{
				$api->make_moderator();
			}
			else if($_GET['action'] == 'moderator_fetch')
			{
				$api->moderator_fetch();
			}
			else if($_GET['action'] == 'setting_feature_select')
			{
				$api->setting_feature_select();
			}
			else if($_GET['action'] == 'broadcast_pages_select')
			{
				$api->broadcast_pages_select();
			}
			else if($_GET['action'] == 'page_details_fetch')
			{
				$api->page_details_fetch();
			}			
			else if($_GET['action'] == 'admin_feed')
			{
				$api->admin_feed();
			}
			else if($_GET['action'] == 'notice_count')
			{
				$api->notice_count();
			}
			else if($_GET['action'] == 'notice_fetch')
			{
				$api->notice_fetch();
			}
			else if($_GET['action'] == 'pin_fetch')
			{
				$api->pin_fetch();
			}
			else if($_GET['action'] == 'people_fetch')
			{
				$api->people_fetch();
			}
			else if($_GET['action'] == 'photo_friend_fetch')
			{
				$api->photo_friend_fetch();
			}
			else if($_GET['action'] == 'photo_fetch')
			{
				$api->photo_fetch();
			}
			else if($_GET['action'] == 'video_fetch')
			{
				$api->video_fetch();
			}
			else if($_GET['action'] == 'group_doc_fetch')
			{
				$api->group_doc_fetch();
			}
			else if($_GET['action'] == 'event_doc_fetch')
			{
				$api->event_doc_fetch();
			}
			else if($_GET['action'] == 'file_fetch')
			{
				$api->file_fetch();
			}                        
			else if($_GET['action'] == 'post_delete')
			{
				$api->post_delete();
			}
			else if($_GET['action'] == 'message_delete')
			{
				$api->message_delete();
			}
			else if($_GET['action'] == 'post_status')
			{
				$api->post_status();
			}
			else if($_GET['action'] == 'post_question')
			{
				$api->post_question();
			}
			else if($_GET['action'] == 'option_add')
			{
				$api->option_add();
			}
			else if($_GET['action'] == 'group_post_question')
			{
				$api->group_post_question();
			}
			else if($_GET['action'] == 'post_link')
			{
				$api->post_link();
			}
			else if($_GET['action'] == 'event_status')
			{
				$api->event_status();
			}
			else if($_GET['action'] == 'group_post_link')
			{
				$api->group_post_link();
			}
			else if($_GET['action'] == 'event_post_link')
			{
				$api->event_post_link();
			}
			else if($_GET['action'] == 'page_post_link')
			{
				$api->page_post_link();
			}
			else if($_GET['action'] == 'profile_privacy_update')
			{
				$api->profile_privacy_update();
			}
			else if($_GET['action'] == 'email_setting_update')
			{
				$api->email_setting_update();
			}
			else if($_GET['action'] == 'notification_setting_update')
			{
				$api->notification_setting_update();
			}
			else if($_GET['action'] == 'feature_setting_update')
			{
				$api->feature_setting_update();
			}
			else if($_GET['action'] == 'profile_edit_basic')
			{
				$api->profile_edit_basic();
			}
			else if($_GET['action'] == 'profile_edit_academic')
			{
				$api->profile_edit_academic();
			}
			else if($_GET['action'] == 'profile_edit_favorite')
			{
				$api->profile_edit_favorite();
			}
			else if($_GET['action'] == 'profile_edit_nature')
			{
				$api->profile_edit_nature();
			}
			else if($_GET['action'] == 'profile_edit_life_style')
			{
				$api->profile_edit_life_style();
			}
			else if($_GET['action'] == 'profile_feed')
			{
				$api->profile_feed();
			}
			else if($_GET['action'] == 'response')
			{
				$api->response();
			}
			else if($_GET['action'] == 'request_fetch')
			{
				$api->request_fetch();
			}			
			else if($_GET['action'] == 'responsed')
			{
				$api->response_delete();
			}
			else if($_GET['action'] == 'response_delete')
			{
				$api->response_delete();
			}
			else if($_GET['action'] == 'search')
			{
				$api->search();
			}
			else if($_GET['action'] == 'search_people')
			{
				$api->search_people();
			}
			else if($_GET['action'] == 'friend_suggest')
			{
				$api->friend_suggest();
			}
			else if($_GET['action'] == 'group_suggest')
			{
				$api->group_suggest();
			}
			else if($_GET['action'] == 'event_suggest')
			{
				$api->event_suggest();
			}
			else if($_GET['action'] == 'song_search')
			{
				$api->song_search();
			}
			else if($_GET['action'] == 'status_song')
			{
				$api->status_song();
			}
			else if($_GET['action'] == 'song_dedicate')
			{
				$api->song_dedicate();
			}
			else if($_GET['action'] == 'tagline_set')
			{
				$api->tagline_set();
			}
			else if($_GET['action'] == 'recently_talked_people')
			{
				$api->recently_talked_people();
			}
			else if($_GET['action'] == 'stepup')
			{
				$api->stepup();
			}
			else if($_GET['action'] == 'school_update')
			{
				$api->school_update();
			}
			else if($_GET['action'] == 'register_user')
			{
				$api->register_user();
			}
			else if($_GET['action'] == 'uniqueid_fetch')
			{
				$api->uniqueid_fetch();
			}
			else if($_GET['action'] == 'setting_save')
			{
				$api->setting_save();
			}
			else if($_GET['action'] == 'direct_letter')
			{
				$api->direct_letter();
			}
			else if($_GET['action'] == 'answer_people_fetch')
			{
				$api->answer_people_fetch();
			}
			else if($_GET['action'] == 'unfriend')
			{
				$api->unfriend();
			}
			else if($_GET['action'] == 'validate')
			{
				$api->validate();
			}
			else if($_GET['action'] == 'validate_name')
			{
				$api->validate_name();
			}
			else if($_GET['action'] == 'validate_email')
			{
				$api->validate_email();
			}
			else if($_GET['action'] == 'validate_year')
			{
				$api->validate_year();
			}
			else if($_GET['action'] == 'validate_school')
			{
				$api->validate_school();
			}
			else if($_GET['action'] == 'actions_load')
			{
				$api->actions_load();
			}
			else if($_GET['action'] == 'group_and_event_select')
			{
				$api->group_and_event_select();
			}
			else if($_GET['action'] == 'bio_fetch')
			{
				$api->bio_fetch();
			}
			else if($_GET['action'] == 'bio_percentage')
			{
				$api->bio_percentage();
			}
			else if($_GET['action'] == 'group_details_fetch')
			{
				$api->group_details_fetch();
			}
			else if($_GET['action'] == 'event_details_fetch')
			{
				$api->event_details_fetch();
			}
			else if($_GET['action'] == 'profile_details_fetch')
			{
				$api->profile_details_fetch();
			}
            else if($_GET['action']=='daily')
            {
            $api->daily_report();
            }
            else if($_GET['action']=='weekly')
            {
            $api->weekly_report();
            }
            else if($_GET['action']=='monthly')
            {
            $api->monthly_report();
            }
			else if($_GET['action']=='analytics')
			{
              if($_GET['typedata']=='post')
            {			  
			     $api->analytics_details_post();
			}
			if($_GET['typedata']=='joined')
			{
			     $api->analytics_details_joined();
			}
             if($_GET['typedata']=='comment')
			{
		      	$api->analytics_details_comment();
			}
			if($_GET['typedata']=='view')
			{
		      	$api->analytics_details_view();
			}
            if($_GET['typedata']=='visit')
			{
		      	$api->analytics_details_visit();
			}
			
			}
            else
			{
				$help->error_description(7);
			}	
		} 
		else
		{
			$help->error_description(6);
		}
	}
	else if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST))
	{
		if(isset($_POST['action']))
		{
			if($_POST['action'] == 'photo_upload')
			{ 
				$api->photo_upload();
			}
			else if($_POST['action'] == 'blog_publish')
			{ 
				$api->blog_publish();
			}
			else if($_POST['action'] == 'group_photo_upload')
			{ 
				$api->group_photo_upload();
			}
			else if($_POST['action'] == 'employee_invite_file_upload')
			{
				$api->employee_invite_file_upload();
			}
			
			else if($_POST['action'] == 'new_version_upload')
			{
				$api->new_version_upload();
			}
			else if($_POST['action'] == 'event_photo_upload')
			{ 
				$api->event_photo_upload();
			}
			else if($_POST['action'] == 'page_photo_upload')
			{ 
				$api->page_photo_upload();
			}
			else if($_POST['action'] == 'album_upload')
			{
				$api->album_upload();
			}
			else if($_POST['action'] == 'change_password')
			{
				$api->change_password();
			}
			else if($_POST['action'] == 'profile_picture_upload')
			{
				$api->profile_picture_upload();
			}
			else if($_POST['action'] == 'flash_board')
			{
				$api->flash_board();
			}
			else if($_POST['action'] == 'group_pinned_doc_upload')
			{ 
				$api->group_pinned_doc_upload();
			}
			else
			{ 
				$help->error_description(8);
			}	
		}
		else
		{
			$help->error_description(5);		
		}
	}
	else
	{
		$help->error_description(5);
	}
}
else if($_POST['action'] == 'validate_user')
{
	$api->validate_user();
}
else if($_POST['action'] == 'validate_user_mobile')
{
	$api->validate_user_mobile();
}
else if($_GET['action'] == 'forgot_password')
{
	$api->forgot_password();
}
else if($_GET['action'] == 'poll')
{
	$api->poll();
}
else if($_POST['action'] == 'recover_password')
{
	$api->recover_password();
}
else if($_GET['action'] == 'validate_password')
{
	$api->validate_password();
}
else if($_GET['action'] == 'self_invite')
{
	$api->self_invite();
}
else if($_GET['action'] == 'self_invite_mobile')
{
	$api->self_invite_mobile();
}
else if($_GET['action'] == 'contact')
{
	$api->contact();
}else if($_POST['action'] == 'login')
{
	$api->login();
}
else if($_GET['action'] == 'login_get')
{
	$api->login_get();
}
else if($_GET['action'] == 'analytics')
{
    
}
else
{
	$help->error_description(4);
}

?>