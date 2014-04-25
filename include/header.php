<?php
require_once('../include/Session.php');
require_once('../include/Database.php');
require_once('../include/check_session.php');
require_once('../include/File.php');
require_once('../include/Help.php');
require_once('../include/Memcached.php');
$myprofileid=$_SESSION['userid'];
if(isset($_GET['id']))
{ 
	if($_GET['id']=='')
	{
		$profileid = $myprofileid;
	}
	else
	{
		$profileid=$_GET['id'];
	}
}
else
{
	$profileid = $myprofileid;
}
$myschool=$_SESSION['SCHOOL'];
$mycollege=$_SESSION['COLLEGE'];
$title = 'Quipmate';
$database = new Database();
$help = new Help ();
$memcached = new Memcached();
$profile_relation = -1;
if(array_key_exists('searchbox',$_GET) && array_key_exists('search',$_GET))
{
  ob_start();
  $searchstr=$_GET['searchbox'];
  $filter = '';
  if(isset($_GET['filter']))
  {
	$filter=$_GET['filter'];
  }	
  header("Location:search.php?q=$searchstr&filter=$filter"); 
  exit();
}
if($_SERVER['SCRIPT_NAME'] == '/index.php') 
{
	$page = 'news_json';
	$profile_relation = 0;
	if(isset($_GET['hl']))
	{
		$hl = $_GET['hl'];
		switch($hl)
		{
			case 'inbox': $page = 'inbox'; break;
			case 'technical': $page = 'tech_json'; break;
			case 'image': $page = 'photo'; break;
			case 'college_mate': $page = 'college_mate'; break;
			case 'new_user': $page = 'new_user'; break;		
			case 'notice_all': $page  = 'notice_json'; break;		
			default: $page = 'news_json';
		}
	}
}
else if($_SERVER['SCRIPT_NAME'] == '/admin.php') 
{
	if(!$database->moderator_check($myprofileid))
	{
		header('Location: /');
		exit();
	}
	$page = 'admin_json';	
	if(isset($_GET['hl']))
	{
		$hl = $_GET['hl']; 
		switch($hl)
		{
			case 'page_create': $page = 'page_create'; break;
			case 'admin': $page = 'admin'; break;	
			case 'invite': $page = 'invite'; break;	
			case 'remove_user': $page = 'remove_user'; break;
            case 'analytics': $page = 'analytics'; break;	
			case 'feature': $page = 'feature'; break;	
			default: $page = 'admin_json';
		}
	}
}
else if($_SERVER['SCRIPT_NAME'] == '/settings.php') 
{
	$page = 'notification';
	$profile_relation = 0;
	if(isset($_GET['hl']))
	{
		$hl = $_GET['hl'];
		switch($hl)
		{
			case 'account_settings': $page = 'account'; break;
			case 'privacy_settings': $page = 'privacy'; break;		
			case 'email_settings': $page = 'email_settings'; break;	
			default: $page = 'notification';
		}
	}
}
else if($_SERVER['SCRIPT_NAME'] == '/profile.php')
{
	$page = 'profile_json'; 
	$profileid = $database->profile_exists($profileid);
	if(!$profileid) $profileid = $myprofileid;
	if($profileid == $myprofileid)
	{
		$profile_name = $_SESSION['NAME'];
		$profile_image = $_SESSION['pimage'];
		$profile_imageid = $_SESSION['profile_imageid'];
		$profile_relation = 0;
	}
	else
	{
		$n = $database->get_name($profileid);		
		$profile_name = $n['NAME'];
		$pirow = $database->get_image($profileid);
		$profile_image	= $pirow['CDN'].$pirow['FILENAME'];
		$profile_imageid = $pirow['IMAGEID'];
		$row = $database->is_friend($myprofileid, $profileid);
		if($row->num_rows)
		{
			$profile_relation = 1;
		}
		else
		{
			$profile_relation = 3;
			$page = 'bio'; 
		}	
	}	
	$ext = pathinfo($profile_image,PATHINFO_EXTENSION);
	if(strpos($profile_image,'_t') > -1)
	{
		$arr = explode('_',$profile_image);
		$profile_image = $arr[0].'.'.$ext;
	}
	else
	{
		$arr = explode('/',$profile_image);
		$profile_image = 'http://profile.qmcdn.net/'.$arr[3];
	}
	$title = $profile_name; 
	if(isset($_GET['hl']))
	{
		$hl = $_GET['hl'];
		switch($hl)
		{
			case 'friend': $page = 'friend'; break;
			case 'bio': $page = 'bio'; break;
			case 'image': $page = 'pphoto'; break;
			case 'diary': $page = 'profile_json'; break;
			default: $page = 'profile_json';
		}
	}  
}
else if($_SERVER['SCRIPT_NAME'] == '/event.php')
{
	$page = 'event_json'; 
	if(isset($_GET['id']))
	{ 
		if($_GET['id']=='')
		{
			$profileid = 1;
		}
		else
		{
			$profileid = $_GET['id'];
		}
	}
	else
	{
		$profileid = 1;
	}
	$profileid = $database->event_exists($profileid);
	if(!$profileid)
	{
		header('Location: /');
		exit(1);
	}
	$n = $database->event_select($profileid);		
	$profile_relation = $database->guest_status($profileid, $myprofileid);
	if($profile_relation == 4 && $n['privacy'] == 1)
	{
		header('Location: /');
		exit(1);
	}
	$profile_name = $n['name'];
	$profile_image	= 'http://icon.qmcdn.net/event.png';
	if($profile_relation != 0 && $profile_relation != 1 && $profile_relation != 2)
	{
		$page = 'event_about'; 
	}	
	$title = $profile_name; 
	if(isset($_GET['hl']))
	{
		$hl = $_GET['hl'];
		switch($hl)
		{
			case 'guest': $page = 'guest'; break;
			case 'about': $page = 'event_about'; break;
			case 'post': $page = 'event_json'; break;
			default: $page = 'event_json';
		}
		if($hl == 'settings' && $profile_relation == 0)
		{
			$page = 'event_settings';
		}
	}  
}
else if($_SERVER['SCRIPT_NAME'] == '/group.php')
{
	$page = 'group_json'; 
	if(isset($_GET['id']))
	{ 
		if($_GET['id']=='')
		{
			$profileid = 1;
		}
		else
		{
			$profileid = $_GET['id'];
		}
	}
	else
	{
		$profileid = 1;
	}
	
	$profileid = $database->group_exists($profileid);
	if(!$profileid)
	{
		header('Location: /');
		exit(1);
	}
	$n = $database->group_select($profileid);
	$profile_relation = $database->membership_status($profileid, $myprofileid);
	if($profile_relation != 0 && $profile_relation != 1 && $n['visible'] == 1)
	{
		header('Location: /');
		exit(1);
	}
	$profile_name = $n['name'];
	$profile_image	= 'http://icon.qmcdn.net/group.png';
	if($profile_relation != 1 && $profile_relation != 0)
	{
		$page = 'group_about'; 
	}	
	$title = $profile_name; 
	if(isset($_GET['hl']))
	{
		$hl = $_GET['hl'];
		switch($hl)
		{
			case 'member': $page = 'member'; break;
			case 'about': $page = 'group_about'; break;
			case 'post': $page = 'group_json'; break;
			default: $page = 'group_json';
		}
		if($hl == 'settings' && $profile_relation == 0)
		{
			$page = 'group_settings';
		}
	}  
}
else if($_SERVER['SCRIPT_NAME'] == '/page.php')
{
	$page = 'page_json'; 
	if(isset($_GET['id']))
	{ 
		if($_GET['id']=='')
		{
			$profileid = 1;
		}
		else
		{
			$profileid = $_GET['id'];
		}
	}
	else
	{
		$profileid = 1;
	}
	$row= $database->page_exists($profileid);
	$profileid = $row['pageid'];
	if(!$profileid)
	{
		header('Location: /');
		exit(1);
	}
	$n = $database->page_select($profileid);
	$profile_relation = $database->follower_status($profileid, $myprofileid);
	if($profile_relation != 0 && $profile_relation != 1 && $n['visible'] == 1)
	{
		header('Location: /');
		exit(1);
	}
	$profile_name = $n['name'];
	$profile_image	= 'http://icon.qmcdn.net/broadcast.png';
	if($profile_relation != 1 && $profile_relation != 0)
	{
		$page = 'page_about'; 
	}	
	$title = $profile_name; 
	if(isset($_GET['hl']))
	{
		$hl = $_GET['hl'];
		switch($hl)
		{
			case 'follower': $page = 'follower'; break;
			case 'about': $page = 'page_about'; break;
			case 'post': $page = 'page_json'; break;
			default: $page = 'page_json';
		}
		if($hl == 'settings' && $profile_relation == 0)
		{
			$page = 'page_settings';
		}
	}  
}
else if($_SERVER['SCRIPT_NAME'] == '/search.php')
{
	$page = 'search';
	if(isset($_GET['hl']))
	{
		$hl = $_GET['hl'];
		switch($hl)
		{
			case 'college_mate': $page = 'search'; break;
			case 'new_user': $page = 'search'; break;
			default: $page = 'search';
		}
	}
}
else if($_SERVER['SCRIPT_NAME'] == '/action.php')
{
	$page = 'action';
}
else if($_SERVER['SCRIPT_NAME'] == '/register.php')
{
	$page = 'profile_picture'; 
	$title = 'Profile picture upload'; 
	if(isset($_GET['hl']))
	{
		$hl = $_GET['hl'];
		switch($hl)
		{
			case 'profile_picture': $page = 'profile_picture'; $title = 'Profile picture upload'; break;
			case 'friend_suggest': $page = 'friend_suggest'; $title = 'Friend Suggestions'; break;
			case 'group_suggest': $page = 'group_suggest'; $title = 'Group Suggestions'; break;
			default: $page = 'profile_picture';
		}
	}
}
$database->page_view_insert($myprofileid, $profileid, $_SERVER['HTTP_REFERER'], $_SERVER['REQUEST_URI'], time());
?>
<meta name="description" content="Quipmate enhances the productivity of your organization by connecting people, conversations, project and ideas in a private network"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
<meta name= "url" content="http://www.quipmate.com"/>
<meta name= "keywords" content="enterprise social network, social, profile, collaboration, team, files sharing, project, idea sharing, innovation, creativity, conversation, knowledge management, engagement platform, identify hidden experts, breakdown silos, improve transparency, poll, questions, democratic decision making, enterprise 2.0, microblogging, employee engagement, groups, bottom-up communication, human capital"/>
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" charset="utf-8"/>
<?php 
	$file = new File();
	$file->style_header();
	$file->script_header();
?>
<title style="font-family:arial;"><?php echo $title; ?></title> 
</head>
<body>
<div id="header">
	<div id="header-wrapper">
		<div id="left_header">
			<a id="website_logo" href="/" title="Your Online Identity">Quipmate</a>
			<form name="searchform" action ="" id="search_form" method = "GET"> 
				<input autocomplete="off" type="text" id = "to"  name="searchbox" value="" placeholder="Search People, Post, Group, Event" size="40"  />
				<input id="search_button_header" style="background-image:url(http://icon.qmcdn.net/search_icon.png)" type="submit" name="search" value="" />
			</form>
		</div>
		<div id="right_header">
			<div class="notice" title="All requests including friend requests, missu, event invite">
				<img id="bring_friend_request" onclick="ui.request_fetch(this, event)" src="http://icon.qmcdn.net/request_header_cccccc.png" class="notice_icon" />
				<span id = "request_count"  data="" onclick="ui.request_fetch(this, event)" class = "unread_count" title = "All requests"></span>
			</div>
			<div class="notice" title="All Messages">
				<img id="bring_message" onclick="ui.message_fetch(this, event)" src="http://icon.qmcdn.net/message_cccccc.png" class="notice_icon"/>
				<span id = "message_count" onclick="ui.message_fetch(this, event)" data="" class = "unread_count" title = "All Messages"></span>
			</div>
			<div class="notice" title="Notifications">
				<img id="bring_notice" onclick="ui.notice_fetch(this, event)" src="http://icon.qmcdn.net/notification_cccccc1.png" class="notice_icon"/>
				<span id = "numnotice"  data=""  onclick="ui.notice_fetch(this, event)" class = "unread_count" title = "Unread Notifications"></span>
			</div>
			<a class="tab_header" href="profile.php?id=<?php echo $_SESSION['USERID'];?>" target="_parent" title="Your Profile">Profile</a>
			<a class="tab_header" href="/" target="_parent" title="Home">Home</a>
			<div id="menu" onclick="ui.menu(this,event)">
				<img id="drop_header" src="http://icon.qmcdn.net/settings_cc.png" title="Manage Your Account" style = "cursor:pointer;" width="16" height="16"/>
			</div>
		</div> 
	</div>
	<input type="hidden" id="max_actionid_hidden" value="" />
	<input type="hidden" id="myprofileid_hidden" value="<?php echo $myprofileid; ?>" />
	<input type="hidden" id="myemail_hidden" value="<?php echo $_SESSION['EMAIL']; ?>" />
	<input type="hidden" id="myprofilename_hidden" value="<?php echo $_SESSION['NAME']; ?>" />
	<input type="hidden" id="myprofileimage_hidden" value="<?php echo $_SESSION['pimage'];?>" />
	<input type="hidden" id="myfriends_name_hidden" value="" />
	<input type="hidden" id="myfriends_pimage_hidden" value="" />
	<input type="hidden" id="page_hidden" value="<?php echo $page; ?>" />
	<input type="hidden" id="session_name_hidden" value='<?php echo json_encode($_SESSION["name_json"]); ?>' />
	<input type="hidden" id="session_pimage_hidden" value='<?php echo json_encode( $_SESSION["pimage_json"]); ?>' />
	<input type="hidden" id="session_tagline_hidden" value='<?php echo json_encode($_SESSION["tag_json"]); ?>' /> 
	<input type="hidden" id="online_hidden" value="" />
	<input type="hidden" id="profile_relation_hidden" value="<?php echo $profile_relation; ?>" />
	<input type="hidden" id="search_filter_hidden" value="<?php if(isset($_GET)) echo $_GET['filter']; ?>" />
	<input type="hidden" id="database_hidden" value="<?php echo $_SESSION['database']; ?>" />
</div>

