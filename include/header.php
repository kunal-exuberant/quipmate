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
$help->skill_update($memcached,$database,$_SESSION['database']);
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
			case 'usefullinks': $page = 'usefullinks'; break;
			
			case 'designation': $page = 'designation'; break;
            case 'sotw': $page = 'sotw'; break;	
			case 'flashboard': $page = 'flashboard'; break;	
			case 'team': $page = 'team'; break;	
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
		$profile_image = $profile_cdn.'/'.$arr[3];
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
			case 'file': $page = 'file'; break;
			case 'video': $page = 'video'; break;
			case 'praise': $page = 'praise'; break;
			case 'following': $page = 'following'; break;
			case 'followers': $page = 'followers'; break;
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
	if(isset($_GET['hl']))
	{
		$hl = $_GET['hl'];
		switch($hl)
		{
			case 'guest': $page = 'guest'; break;
			case 'event_about': $page = 'event_about'; break;
			case 'post': $page = 'event_json'; break;
			default: $page = 'event_json';
		}
		if(($hl == 'settings' || $hl == 'event_settings' )&& $profile_relation == 0)
		{
			$page = 'event_settings';
		}
	} 
	if($profile_relation == 4 && $n['privacy'] == 1)
	{
		header('Location: /');
		exit(1);
	}
	$profile_name = $n['name'];
	$profile_image	= $icon_cdn.'/event.png';
	if($profile_relation != 0 && $profile_relation != 1 && $profile_relation != 2)
	{
		$page = 'event_about'; 
	}	
	$title = $profile_name; 
 
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
	if(isset($_GET['hl']))
	{
		$hl = $_GET['hl'];
		switch($hl)
		{
			case 'member': $page = 'member'; break;
			case 'about': $page = 'group_about'; break;
			case 'group_about': $page = 'group_about'; break;
			case 'post': $page = 'group_json'; break;
			default: $page = 'group_json';
		}
		if(($hl == 'settings' || $hl == 'group_settings' )&& $profile_relation == 0)
		{
			$page = 'group_settings';
		}
	} 
	if($profile_relation != 0 && $profile_relation != 1 && $n['visible'] == 1)
	{
		header('Location: /');
		exit(1);
	}
	$profile_name = $n['name'];
	$profile_image	= $icon_cdn.'/group.png';
	if($profile_relation != 1 && $profile_relation != 0)
	{
		$page = 'group_about'; 
	}	
	$title = $profile_name; 
 
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
	$profile_image	= $icon_cdn.'/broadcast.png';
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
<meta name="description" content="Quipmate is private social network for your company. It is a communication software for your employees which facilitates knowledge sharing and collaboration within your company"/>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
<meta name= "url" content="https://www.quipmate.com"/>
<meta name= "keywords" content="private social network , enterprise social network , social , profile , collaboration , team , files sharing , project , idea sharing , innovation , creativity , conversation , knowledge management ,knowledge sharing , engagement platform , identify hidden experts , breakdown silos , improve transparency , poll , questions , democratic decision making , enterprise 2.0 , microblogging , employee engagement , groups , bottom-up communication , human capital "/>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<?php 
	$file = new File();
	$file->style_header();
	$file->script_header();
?>

<title style="font-family:arial;"><?php echo $title; ?></title> 
</head>
<body>
<div class="navbar navbar-default navbar-fixed-top white" role="navigation">
	<div class="navbar-header">
		 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <div class="home_logo_div">
				<a class="brand ajax_nav" id="home" href="/"><img src="<?php echo $icon_cdn ;?>/logo_home.png"></a>
		  </div>
	</div>
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="padding-right: 16.5em;">
	  <ul class="nav navbar-nav name_profile">
		<li ><a class="ajax_nav"  id="home" href="/" target="_parent" title="Home">Home</a></li>
		<li ><a class="ajax_nav" id="profile" href="profile.php?id=<?php echo $_SESSION['USERID'];?>" target="_parent" title="Your Profile"><img src="<?php echo $_SESSION['pimage']?>" height="25" width="25" /><?php echo ' '.$_SESSION['FNAME'];?></a></li>
		<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
	<!--	<li class="dropdown">
		  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Filter<b class="caret"></b></a>
		  <ul class="dropdown-menu">
			<li><a href="#">People</a></li>
			<li><a href="#">Group</a></li>
			<li><a href="#">Events</a></li>
			<li class="divider"></li>
			<li><a href="#">Posts</a></li>
			<li class="divider"></li>
			<li><a href="#">Pages</a></li>
		  </ul>
		</li> -->
	  </ul>
	  
	  <form class="navbar-form navbar-left" role="search">
		<div class="form-group" id="search_form">
		<input type="text" id="to" autocomplete="off" style="width:20em;" class="form-control" placeholder="Search people, group, skill, event">
		</div>
		<button type="submit" class="btn btn-default" id="search_button_header" >Search</button>
	  </form>


		<ul class="nav navbar-nav navbar-right header">
			<li onclick="ui.request_fetch(this, event)">
			<a href="#"><span title="All requests" class="glyphicon glyphicon-user"  ></span><span class="badge" data="0" id="request_count"></span></a>
			</li>
			<li onclick="ui.message_fetch(this, event)" >
			<a href="#"><span title="All Messages" class="glyphicon glyphicon-envelope"  ></span><span class="badge" id="message_count" data="0"></span></a>
			</li>
			<li onclick="ui.notice_fetch(this, event)" >
			<a href="#"><span title="Unread Notifications" class="glyphicon glyphicon-globe" ></span><span class="badge" data="0" id="numnotice"></span></a>
			</li>
			<li style="font-weight:bold;margin:1em;font-size:1.25em;color:#000;"><?php if($_SESSION['database'] != 'profile') echo ucfirst($_SESSION['database']);?>
			</li>
			<li class="dropdown">
			<a data-toggle="dropdown" class="dropdown-toggle" href="#"><b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a class="ajax_nav" href="profile.php?hl=bio&id=<?php echo $_SESSION['USERID'];?>" >Edit Profile</a></li>
				<li><a href="register.php?hl=profile_picture">Change Profile Picture</a></li>
				<li><a href="settings.php">Account Settings</a></li>
                <li onclick="action.user_delete(this,<?php echo $myprofileid;?>)"><a href="#">Disable Account</a></li>
				<li class="divider"></li>
				<li><a href="logout.php">Logout</a></li>
                
			<?php 
			if($help->moderator_status($myprofileid,$memcached,$database)) 
			{
			?>
				<li class="divider" ></li>
				<li><a class="ajax_nav" href="admin.php">Use as admin</a></li>
			<?php 
			}
			?>
			</ul>
			</li>
		</ul>
	</div> 
</div>
	<input type="hidden" id="myprofileid_hidden" value="<?php echo $myprofileid; ?>" />
	<input type="hidden" id="myemail_hidden" value="<?php echo $_SESSION['EMAIL']; ?>" />
	<input type="hidden" id="myprofilename_hidden" value="<?php echo $_SESSION['NAME']; ?>" />
	<input type="hidden" id="myprofileimage_hidden" value="<?php echo $_SESSION['pimage'];?>" />
	<input type="hidden" id="myfriends_name_hidden" value="" />
	<input type="hidden" id="myfriends_pimage_hidden" value="" />
    <input type="hidden" id="myfriends_tagline_hidden" value="" />
	<input type="hidden" id="page_hidden" value="<?php echo $page; ?>" />
	<input type="hidden" id="session_name_hidden" value='<?php echo json_encode($_SESSION["name_json"]); ?>' />
	<input type="hidden" id="session_pimage_hidden" value='<?php echo json_encode( $_SESSION["pimage_json"]); ?>' />
    <input type="hidden" id="session_skill_hidden" value='<?php echo json_encode($_SESSION["skillname_json"]); ?>' />
    <input type="hidden" id="session_group_hidden" value='<?php echo json_encode($_SESSION["groupname_json"]); ?>' />
	<input type="hidden" id="session_tagline_hidden" value='<?php echo json_encode($_SESSION["tag_json"]); ?>' /> 
	<input type="hidden" id="online_hidden" value="" />
	<input type="hidden" id="profile_relation_hidden" value="<?php echo $profile_relation; ?>" />
	<input type="hidden" id="search_filter_hidden" value="<?php if(isset($_GET)) echo $_GET['filter']; ?>" />
	<input type="hidden" id="database_hidden" value="<?php echo $_SESSION['database']; ?>" />
	<input type="hidden" id="profileid_hidden" value="<?php echo $profileid; ?>" />
	<input type="hidden" id="page_pageid_hidden" value="<?php echo $profileid; ?>" />
	<input type="hidden" id="myprofileid_hidden" value="<?php echo $myprofileid; ?>" />
	<input type="hidden" id="profilename_hidden" value="<?php $database = new Database(); $row = $database->get_name($profileid); echo $row['NAME'];?>" />
	<input type="hidden" id="friend_online_list_hidden" value="" />
	<input type="hidden" id="chatid_hidden" value="0" />
	<input type="hidden" id="random_hidden" value="0"/>
	<!-- CDN Urls in hidden elements -----------------------------------------------	-->
	<input type="hidden" id="doc_cdn" value="<?php echo $doc_cdn; ?>" />
	<input type="hidden" id="video_cdn" value="<?php echo $video_cdn; ?>" />
	<input type="hidden" id="image_cdn" value="<?php echo $image_cdn; ?>" />
	<input type="hidden" id="photo_cdn" value="<?php echo $photo_cdn; ?>" />
	<input type="hidden" id="photo1_cdn" value="<?php echo $photo1_cdn; ?>" />
	<input type="hidden" id="photo2_cdn" value="<?php echo $photo2_cdn; ?>" />
	<input type="hidden" id="photo3_cdn" value="<?php echo $photo3_cdn; ?>" />
	<input type="hidden" id="icon_cdn" value="<?php echo $icon_cdn; ?>" />
	<input type="hidden" id="profile_cdn" value="<?php echo $profile_cdn; ?>" />
	<input type="hidden" id="profile1_cdn" value="<?php echo $profile1_cdn; ?>" />
	<input type="hidden" id="profile2_cdn" value="<?php echo $profile2_cdn; ?>" />
	<input type="hidden" id="profile3_cdn" value="<?php echo $profile3_cdn; ?>" />
	<input type="hidden" id="script_cdn" value="<?php echo $script_cdn; ?>" />
	<input type="hidden" id="style_cdn" value="<?php echo $style_cdn; ?>" />
    
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
    <div class="modal-dialog">
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
                <button type="button" class="btn btn-primary theme_button" data-toggle="modal" data-target="#praisemodalbadge" data-dismiss="modal" >Back</button>
                <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary theme_button" id="share_actionid" data="" onclick="action.praise_send(this)">Share</button>
			</div>
    </div>
  </div> 
</div>
 
<!-- **************************************modal to upload a file ************************** -->
<div class="modal fade" id="uploadfilemodal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
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

<!--  ****************************************Prompt modal ********************************************-->
<div class="modal fade" id="promptmodal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div>
            <h4 class="modal-title text-center" id="prompt_heading">Share on your timeline</h4>
            </div>
            <div class="modal-body">
				<div id="prompt_center">

				</div>
                <div id="share_content">
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
    </div>
  </div>
</div>
<!-- **************************************************************************************************-->
<!-- **************************************modal to create event ************************** -->
<div class="modal fade" id="createeventmodal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
     <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="eventmodaltitile" >Create Event</h4> 
        </div>
        <div class="modal-body" id="event_modal_body">
            <div id="group_info"></div>
            <div class="form-group">
             <label class="">Event Name</label>
             <input type="text" id="event_name" class="form-control" placeholder="Please provide a name for this event"/>
            </div>
            <div class="form-group">
            <label class="">Description</label>
            <textarea class="form-control" id="event_description" placeholder="Please provide details for this event"></textarea>
            </div> 
            <div class="form-group">
            <label class="">Venue</label>
            <input type="text" id="event_where" class="form-control" placeholder="Where this event will be hosted ?"/>
            </div>
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
            <label>Privacy</label>
            <select class="form-control" id="event_privacy">
            <option value="0">Public</option>
            <option value="1">Private</option>
            </select>
            </div>
            <div class="form-group" id="event_invite_check_box">
            <label>
            <input type="checkbox" id="event_invite"/> Guests can invite other people to this event.
            </label>
            </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary " id="create_click" onclick="action.event_create(this)">Create Event</button>
		</div>
    </div>
</div>
</div>
</div>
<!---***************************** Modal to create group************************************ -->
<div class="modal fade" id="creategroupmodal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
     <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="eventmodaltitile" >Please fill all the details for this group</h4> 
        </div>
        <div class="modal-body">
            <div id="group_info"></div>
            <div class="form-group">
             <label class="">Group Name</label>
             <input type="text" class="form-control" id="group_name" placeholder="Please provide a name for this group"/>
            </div>
            <div class="form-group">
            <label class="">Description</label>
            <textarea class="form-control" id="group_description" placeholder="Please provide details for this group"></textarea>
            </div> 
            <div class="form-group">
            <label>Privacy</label>
            <select class="form-control" id="group_privacy">
            <option value="0">Public</option>
            <option value="1">Private</option>
            </select>
            </div>
            <div class="form-group">
            <label >
            <input type="checkbox" id="group_technical"/> Technical
            </label>
            </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary " onclick="action.group_create(this)">Create Group</button>
		 </div>
      </div>
   </div>
 </div>
</div>
<!-- *******************************************************************************************-->     