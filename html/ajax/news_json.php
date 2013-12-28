<?php
require('../../include/Session.php');
require('../../include/Database.php');
require('../../include/Memcached.php');
$session = new Session();
$session->start();
$myprofileid = $_SESSION['USERID'];
require_once '../../include/Json.php';
require_once '../../include/Encode.php';
require_once '../../include/Feed.php';
require_once '../../include/Help.php';
$database = new Database();
$encode = new Encode();
$help = new Help();
$json = new Json();
$feed = new Feed();
$data = array();	
$action = array();
$name = array();
$pimage = array();
if(isset($_GET['real_time']) && isset($_GET['start']) && isset($_GET['profileid']))
{
	    $profileid = $_GET['profileid'];
		$start = $_GET['start'];				
		$res = $database->friend_action_select($profileid, $start);
		$k = 0;
		while($NROW =$res->fetch_array())
		{ 
			$actiontype[$k] = $NROW['ACTIONTYPE'];
			$actionby[$k] = $NROW['ACTIONBY'];
			$actionon[$k] = $NROW['PROFILEID'];
			$actionid[$k] = $NROW['ACTIONID'];
			$pageid[$k] = $NROW['PAGEID'];
			$json->json_name($actionby[$k],$database);
		    $json->json_pimage($actionby[$k],$database);
			if($NROW['ACTIONBY'] !=  $NROW['PROFILEID'])
			{
				$json->json_name($actionon[$k],$database);
				$json->json_pimage($actionon[$k],$database);
			}
			$k++;
		}
		$data['ack'] = 1;
		$data['actiontype'] = $actiontype;
		$data['actionby'] = $actionby;
		$data['actionon'] = $actionon;
		$data['actionid'] = $actionid;
		$data['pageid'] = $pageid;		
	    $data['name'] = $_SESSION['name_json']; 
	    $data['photo'] = $_SESSION['pimage_json'];
	    echo json_encode($data);
}
else if(isset($_GET['friend']) && isset($_GET['profileid']) && isset($_GET['chat']))
{
	    $profileid = $_GET['profileid'];
		$res = $database->message_order($profileid);
		$k = 0;
		$friend = array();
		while($NROW =$res->fetch_array())
		{		
				if($NROW['ACTIONBY'] == $profileid)
				{
					if(!in_array($NROW['ACTIONON'], $friend))
					{
						$friend[] = $NROW['ACTIONON'];
						$json->json_name($friend[$k], $database);
						$json->json_pimage($friend[$k], $database);
						$k++;
					}	
				}
				else if($NROW['ACTIONON'] == $profileid)
				{
					if(!in_array($NROW['ACTIONBY'], $friend))
					{
						$friend[] = $NROW['ACTIONBY'];
						$json->json_name($friend[$k], $database);
						$json->json_pimage($friend[$k], $database);
						$k++;
					}	
				}
		}
		$res = $database->friend_select($profileid);
		while($NROW =$res->fetch_array())
		{
			if($k<10)
			{		
				if(!in_array($NROW['FRIENDID'], $friend))
				{
					$friend[] = $NROW['FRIENDID'];
					$json->json_name($friend[$k], $database);
					$json->json_pimage($friend[$k], $database);
					$k++;
				}
			}	
		}
		$data['ack'] = 1;
		$data['friend'] = $friend;
	    $data['name'] = $_SESSION['name_json']; 
	    $data['pimage'] = $_SESSION['pimage_json'];
	    echo json_encode($data);
}
else if(isset($_GET['friend']) && isset($_GET['profileid']) && isset($_GET['inbox']))
{
	    $profileid = $_GET['profileid'];
		$res = $database->get_last_message_exchanged($profileid);
		$k = 0;
		$friend = array();
		$message_sent_recieve = array();
		while($NROW =$res->fetch_array())
		{ 
			if($NROW['ACTIONBY'] == $profileid)
			{
				if(!in_array($NROW['ACTIONON'], $friend))
				{
					$friend[] = $NROW['ACTIONON'];
					$message_sent_recieve[$k]['actionon']=$NROW['ACTIONON'];
					$message_sent_recieve[$k]['actionby']=$NROW['ACTIONBY'];
					$message_sent_recieve[$k]['message']=$NROW['MESSAGE'];
					$json->json_name($friend[$k], $database);
					$json->json_pimage($friend[$k], $database);
				}	
			}
			else if($NROW['ACTIONON'] == $profileid)
			{
				if(!in_array($NROW['ACTIONBY'], $friend))
				{
					$friend[] = $NROW['ACTIONBY'];
					$message_sent_recieve[$k]['actionon']=$NROW['ACTIONON'];
					$message_sent_recieve[$k]['actionby']=$NROW['ACTIONBY'];
					$message_sent_recieve[$k]['message']=$NROW['MESSAGE'];
					$json->json_name($friend[$k], $database);
					$json->json_pimage($friend[$k], $database);
				}	
			}
			$k++;
		}
		$data['ack'] = 1;
		$data['message'] = $message_sent_recieve;
	    $data['name'] = $_SESSION['name_json']; 
	    $data['pimage'] = $_SESSION['pimage_json'];
	    echo json_encode($data);
}
else if(isset($_GET['last_poll_time']) && isset($_GET['database']) && isset($_GET['profileid']) && isset($_GET['polling']))
{
		if($_GET['database'] == 'ballytech')
		{
			$last_poll_time = $_GET['last_poll_time'];
			$_SESSION['database'] = $_GET['database'];
			$profileid = $_GET['profileid'];
			$memcache = new Memcached();
			$res = $database->news_poll($profileid,$last_poll_time);
			$k = 0;
			while($NROW =$res->fetch_array())
			{ 
				$feed->actiontype_encode($NROW,'0',$json,$help,$encode,$database,$memcache);
			}
			$data['action'] = $action;
			$data['myprofileid'] = $_SESSION['USERID']; 
			$pimage[$data['myprofileid']] = $help->pimage_fetch($data['myprofileid'], $memcache, $database);
			$data['name'] = 	$name; 
			$data['pimage'] = $pimage;
			echo json_encode($data);
		}
		else
		{
			$data['action'] = '';
			$data['myprofileid'] = '';
			$data['name'] = ''; 
			$data['pimage'] = '';
			echo json_encode($data);
		}
}
else if(isset($_GET['diary_entry']) && isset($_GET['profileid']) && isset($_GET['start']))
{
	$profileid = $_GET['profileid']; 
	$start = $_GET['start']; 
		$data=array();
		$database = new Database();
		$json = new Json(); 
		$r = $database->entry_select($profileid,$start,10);
		$k=0;
		while($NROW = $r->fetch_array())
		{
			$entry[$k]['entry'] = $NROW['ENTRY'];
			$entry[$k]['date'] = $NROW['DATE'];
			$entry[$k]['actionid'] = $NROW['ACTIONID'];
			$d = DateTime::CreateFromFormat('Y-m-d',$entry[$k]['date']);
			$d = $d->format('Y-M-j');
			$d = explode('-',$d);
			$entry[$k]['day'] = $d[2];
			$entry[$k]['month'] = $d[1];
			$entry[$k]['year'] = $d[0];
			$entry[$k]['profileid'] = $NROW['PROFILEID'];
			$k++;
		}
	   $d = DateTime::CreateFromFormat('U',time());
	   $date = $d->format('Y-m-j');
	   $er = $database->entry_status($profileid,$date);
	   $data['entry_status'] = 0;
	   if($er['ACTIONID'] > 0)
	   {
			$data['entry_status'] = 1;	
	   } 
	   $data['entry'] = $entry;
	   $data['myprofileid'] = $_SESSION['USERID']; 
	   $data['name'] = 	$_SESSION['name_json']; 
	   $data['pimage'] = $_SESSION['pimage_json'];
	   $data['tag'] = $_SESSION['tag_json'];
	   echo json_encode($data);
}
else if(isset($_GET['actionid']) && isset($_GET['life_is_fun']))
{
	$actionid =$_GET['actionid']; 
	$life_is_fun =$_GET['life_is_fun']; 
	$validator = sha1($actionid.'pass1reset!');
		$data=array();
		$database = new Database();
		$json = new Json(); 
		$r = $database->actionid_select($actionid);
		$k=0;
		while($NROW = $r->fetch_array())
		{
			$feed->actiontype_encode($NROW,$k,$json,$help,$encode,$database);
			$k++;
		}
	   $data['action'] = $action;
	   $data['myprofileid'] = $_SESSION['USERID']; 
	   $json->json_pimage($data['myprofileid'],$database);
	   $data['name'] = 	$_SESSION['name_json']; 
	   $data['pimage'] = $_SESSION['pimage_json'];
	   $data['tag'] = $_SESSION['tag_json'];
	   echo json_encode($data);
}
else if(isset($_GET['start']) && isset($_GET['myprofileid']) && isset($_GET['album']))
{
	$myprofileid =$_GET['myprofileid']; 
	$start =$_GET['start']; 
	$data=array();
	$photo =array();
	$database = new Database();
	$json = new Json(); 
	$r = $database->pin_select($myprofileid,$start,'10');
	$k=0;
	while($NROW = $r->fetch_array())
	{
		$feed->actiontype_encode($NROW,$k,$json,$help,$encode,$database);
		$k++;
	}
   $data['action'] = $action;
   $data['myprofileid'] = $_SESSION['USERID']; 
   $json->json_pimage($data['myprofileid'],$database);
   $data['name'] = 	$_SESSION['name_json']; 
   $data['pimage'] = $_SESSION['pimage_json'];
   $data['tag'] = $_SESSION['tag_json'];
   echo json_encode($data);
}
else if(isset($_GET['start']) && isset($_GET['profileid']))
{
	$start = $_GET['start'];
	$profileid = $_GET['profileid'];
	$res = $database->get_profile_post($profileid,$start);
	$k = 0;
	while($NROW =$res->fetch_array())
	{
		$feed->actiontype_encode($NROW,$k,$json,$help,$encode,$database);
		$k++;
	}
   $data['action'] = $action;
   $data['myprofileid'] = $_SESSION['USERID']; 
   $json->json_pimage($data['myprofileid'],$database);
   $data['name'] = 	$_SESSION['name_json']; 
   $data['pimage'] = $_SESSION['pimage_json'];
   $data['tag'] = $_SESSION['tag_json'];
   echo json_encode($data);
}
else if(isset($_GET['actiontype']) && isset($_GET['myprofileid']))
{
	$actiontype = $_GET['actiontype'];
	$myprofileid = $_GET['myprofileid'];
	$res = $database->actiontype_select($myprofileid,$actiontype,0,3);
	$k = 0;
	while($NROW =$res->fetch_array())
	{
		$feed->actiontype_encode($NROW,$k,$json,$help,$encode,$database);
		$k++;
	}
   $data['action'] = $action;
   $data['myprofileid'] = $_SESSION['USERID']; 
   $json->json_pimage($data['myprofileid'],$database);
   $data['name'] = 	$_SESSION['name_json']; 
   $data['pimage'] = $_SESSION['pimage_json'];
   $data['tag'] = $_SESSION['tag_json'];
   echo json_encode($data); 
}
else if(isset($_GET['start']) && isset($_GET['quip']))
{
	$start = $_GET['start'];
	$res = $database->everything_select($start,10);
	$k = 0;
	while($NROW =$res->fetch_array())
	{
		$feed->actiontype_encode($NROW,$k,$json,$help,$encode,$database);
		$k++;
	}
   $data['action'] = $action;
   $data['myprofileid'] = $_SESSION['USERID']; 
   $json->json_pimage($data['myprofileid'],$database);
   $data['name'] = 	$_SESSION['name_json']; 
   $data['pimage'] = $_SESSION['pimage_json'];
   $data['tag'] = $_SESSION['tag_json'];
   echo json_encode($data); 
}
else if(isset($_GET['action']) && isset($_GET['actionid']))
{
	$actionid = $_GET['actionid'];
	$res = $database->get_action($actionid);
	$feed->actiontype_encode($res,'0',$json,$help,$encode,$database);
   $data['action'] = $action;
   $data['myprofileid'] = $_SESSION['USERID']; 
   $json->json_pimage($data['myprofileid'],$database);
   $data['name'] = 	$_SESSION['name_json']; 
   $data['pimage'] = $_SESSION['pimage_json'];
   $data['tag'] = $_SESSION['tag_json'];
   echo json_encode($data);
}
else if(isset($_GET['notice']) && isset($_GET['myprofileid'])) 
{
	$myprofileid = $_GET['myprofileid'];
	$start = $_GET['start'];
	$result = $database->notice_select($myprofileid,$start);
	$res = $database->notice_read($myprofileid);
	$k=0;
	while($NROW =$result->fetch_array())
	{
		$feed->actiontype_encode($NROW,$k,$json,$help,$encode,$database);
		$k++;
	}
	$data['action'] = $action; 
	$data['name'] = $_SESSION['name_json']; 
	$data['pimage'] = $_SESSION['pimage_json'];
	echo json_encode($data);
}
else if(isset($_GET['start']))
{
   
	$start = $_GET['start'];
	$res = $database->new_friend_action_select($myprofileid,$start,10);
$k = 0;
while($NROW =$res->fetch_array())
{
	$feed->actiontype_encode($NROW,$k,$json,$help,$encode,$database);
	$k++;
}
   $data['action'] = $action;
   $data['myprofileid'] = $_SESSION['USERID']; 
   $json->json_pimage($data['myprofileid'],$database);
   $data['name'] = 	$_SESSION['name_json']; 
   $data['pimage'] = $_SESSION['pimage_json'];
   $data['tag'] = $_SESSION['tag_json'];
   echo json_encode($data);
}
else if(isset($_GET['notice_count']) && isset($_GET['myprofileid'])) 
{
	$myprofileid = $_GET['myprofileid'];
	$res = $database->notice_unread_count($myprofileid);
	$data['count'] = $res;
	echo json_encode($data);
}
else if(isset($_GET['actionid_third']) && $_GET['pageid'])
{
	$actionid_third = $_GET['actionid_third'];
	$pageid = $_GET['pageid'];
	$life_is_fun = sha1($pageid.'pass1reset!');
	$comresult=$database->comment_select_all($pageid,$actionid_third);
	$com = array();
	$j=0;
	while($comrow = $comresult->fetch_array())
	{
		 $com[$j]['com_actionid'] = $comrow['ACTIONID'];
		 $com[$j]['postby'] = $comrow['PROFILEID'];
		 $com[$j]['com_time'] = $help->get_utc($comrow['TIMESTAMP']);
		 $com[$j]['commentby'] = $comrow['ACTIONBY'];
		 $com[$j]['com_pageid'] = $comrow['PAGEID'];
		 $com_actionid = $com[$j]['com_actionid'] = $comrow['ACTIONID'];
		 $com[$j]['comment'] = stripslashes($comrow['COMMENT']);
		 $excited_action = $database->get_excited_action($com_actionid,'63');
		 $com[$j]['com_excited'] = $excited_action->num_rows;
		 $json->json_name($com[$j]['commentby'],$database);
		 $json->json_pimage($com[$j]['commentby'],$database);
		 $j++;
	}
   $data['life_is_fun'] = $life_is_fun;
   $data['com'] = $com;
   $data['name'] = 	$_SESSION['name_json']; 
   $data['pimage'] = $_SESSION['pimage_json'];
   echo json_encode($data);
}
 ?>