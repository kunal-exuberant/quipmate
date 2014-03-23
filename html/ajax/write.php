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
$action = array();
if(isset($_SESSION['auth']))
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
			else if($_GET['action'] == 'guest_accept')
			{
				$api->guest_accept();
			}
			else if($_GET['action'] == 'response_fetch')
			{
				$api->response_fetch();
			}
			else if($_GET['action'] == 'friend_invite')
			{
				$api->friend_invite();
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
			else if($_GET['action'] == 'gift')
			{
				$api->gift();
			}
			else if($_GET['action'] == 'praise')
			{
				$api->praise();
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
			else if($_GET['action'] == 'user_delete')
			{
				$api->user_delete();
			}
			else if($_GET['action'] == 'moderator_remove')
			{
				$api->moderator_remove();
			}
			else if($_GET['action'] == 'make_moderator')
			{
				$api->make_moderator();
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
else if($_GET['action'] == 'login')
{
	$api->login();
}
else if($_GET['action'] == 'analytics')
{
    
}
else
{
	$help->error_description(4);
}
?>