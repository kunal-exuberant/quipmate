<?php
class Feed
{
	function parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache)
	{
		global $data,$action,$name,$pimage; 
		$action[$k]['pageid'] = $NROW['PAGEID'];
		$parent = $encode->parent_encode($action[$k]['pageid'],$json,$help,$database);
		$action[$k]['postby'] = $parent['postby'];
		$action[$k]['visible'] = $parent['visible'];
		$name[$action[$k]['postby']] = $help->name_fetch($action[$k]['postby'], $memcache, $database);
		$pimage[$action[$k]['postby']] = $help->pimage_fetch($action[$k]['postby'], $memcache, $database);
		$action[$k]['time'] = $parent['time'];
		$action[$k]['actionid'] = $parent['actionid'];
		$action[$k]['parenttype'] = $parent['parenttype'];	
	}
	
	function actiontype_encode($NROW,$k,$json,$help,$encode,$database,$memcache)
	{
			global $data,$action,$name,$pimage;
			$action[$k]['actionid'] = $NROW['ACTIONID'];
			$action[$k]['pageid']   = $NROW['PAGEID'];
			$action[$k]['life_is_fun'] = sha1($NROW['PAGEID'].'pass1reset!');
			$action[$k]['postby']   = $NROW['ACTIONBY'];
			$action[$k]['time']     =  $help->get_utc($NROW['TIMESTAMP']);
			$action[$k]['actiontype'] = $NROW['ACTIONTYPE'];
			$action[$k]['visible']   = $NROW['VISIBLE'];
			$action[$k]['actionby'] = $NROW['ACTIONBY'];
			$action[$k]['actionon'] = $NROW['PROFILEID'];
			$name[$action[$k]['actionby']] = $help->name_fetch($action[$k]['actionby'], $memcache, $database);
			$pimage[$action[$k]['actionby']] = $help->pimage_fetch($action[$k]['actionby'], $memcache, $database); 
		
		if($action[$k]['actiontype'] == 302 || $action[$k]['actiontype'] == 311 || $action[$k]['actiontype'] == 402 || $action[$k]['actiontype'] == 411 || $action[$k]['actiontype'] == 2902 || $action[$k]['actiontype'] == 2911 )
		{			
			$parent = $encode->parent_encode($action[$k]['pageid'],$json,$help,$database);
			$action[$k]['actiontype'] = $parent['parenttype'];
			$action[$k]['postby'] = $parent['postby'];
			$action[$k]['visible'] = $parent['visible'];
			$name[$action[$k]['postby']] = $help->name_fetch($action[$k]['postby'], $memcache, $database);
			$action[$k]['time'] = $parent['time'];
			$action[$k]['actionid'] = $parent['actionid'];
		}
		if($action[$k]['actionby'] != $action[$k]['actionon'])
		{
			$name[$action[$k]['actionon']] = $help->name_fetch($action[$k]['actionon'], $memcache, $database);
			$pimage[$action[$k]['actionon']] = $help->pimage_fetch($action[$k]['actionon'], $memcache, $database); 
		}
		if($action[$k]['actiontype']==1)
		{
			$name[$action[$k]['actionby']] = $help->name_fetch($action[$k]['actionby'], $memcache, $database);
			$this->page_complete_encode($k,$json,$help,$encode,$database,$memcache,11,2);
		}
		if($action[$k]['actiontype']==10)
		{
			$this->share_page_complete_encode($k,$json,$help,$encode,$database,$memcache,11,2);
		}
		else if($action[$k]['actiontype']==5)
		{
			$this->moment_complete_encode($k,$json,$help,$encode,$database,$memcache, 12, 23);
		}
		else if($action[$k]['actiontype']==6)
		{
			$this->image_complete_encode($k,$json,$help,$encode,$database,$memcache,15,24);
		}
		else if($action[$k]['actiontype']==8)
		{
			$this->friendship_complete_encode($k,$json,$help,$encode,$database,$memcache, 17, 26);
		}
		else if($action[$k]['actiontype']==50)
		{
			$this->profile_image_complete_encode($k,$json,$help,$encode,$database,$memcache, 16, 25);
		}
		else if($action[$k]['actiontype']==51)
		{
			$action[$k]['pageid']   = $action[$k]['actionid'];
			$this->image_complete_encode($k,$json,$help,$encode,$database,$memcache,15,24);
		}
		else if($action[$k]['actiontype']==99)
		{
			$name[$action[$k]['actionby']] = $help->name_fetch($action[$k]['actionby'], $memcache, $database);
			$this->quipmate_joined_encode($k,$json,$help,$encode,$database,$memcache,91,92);
		}
		else if($action[$k]['actiontype']==300)
		{
			$this->group_complete_encode($k,$json,$help,$encode,$database,$memcache, 311, 302);
		}
		else if($action[$k]['actiontype']==301)
		{
			$name[$action[$k]['actionby']] = $help->name_fetch($action[$k]['actionby'], $memcache, $database);
			$this->group_page_complete_encode($k,$json,$help,$encode,$database,$memcache,311,302);
		}
		else if($action[$k]['actiontype']==306)
		{
			$this->group_image_complete_encode($k,$json,$help,$encode,$database,$memcache, 311, 302);
		}
		else if($action[$k]['actiontype']==308)
		{
			$mrow = $database->member_select_actionid($action[$k]['actionid']);
			$action[$k]['groupid'] = $action[$k]['actionon'];
			$grow = $database->group_select($action[$k]['groupid']);
			$action[$k]['group_name'] = $grow['name'];
			$action[$k]['actionon'] = $mrow['profileid'];
			$name[$action[$k]['actionon']] = $help->name_fetch($action[$k]['actionon'], $memcache, $database);
			$pimage[$action[$k]['actionon']] = $help->pimage_fetch($action[$k]['actionon'], $memcache, $database); 
			$this->friendship_complete_encode($k,$json,$help,$encode,$database,$memcache, 311, 302);
		}
		else if($action[$k]['actiontype']==316)
		{
			$this->group_link_complete_encode($k,$json,$help,$encode,$database,$memcache, 311, 302);
		}
		else if($action[$k]['actiontype']==325)
		{
			$this->group_video_complete_encode($k,$json,$help,$encode,$database,$memcache,311,302);
		}
		else if($action[$k]['actiontype']==326)
		{
			$this->group_doc_complete_encode($k,$json,$help,$encode,$database,$memcache,311,302);
		}
		else if($action[$k]['actiontype']==328)
		{
			$this->group_question_complete_encode($k,$json,$help,$encode,$database,$memcache, 311, 302);
		}
		else if($action[$k]['actiontype']==330)
		{
			$this->group_event_complete_encode($k,$json,$help,$encode,$database,$memcache, 411, 402);
		}
		else if($action[$k]['actiontype']==400)
		{
			$this->event_complete_encode($k,$json,$help,$encode,$database,$memcache, 411, 402);
		}
		else if($action[$k]['actiontype']==403)
		{
			$name[$action[$k]['actionby']] = $help->name_fetch($action[$k]['actionby'], $memcache, $database);
			$this->event_page_complete_encode($k,$json,$help,$encode,$database,$memcache,411,402);
		}
		else if($action[$k]['actiontype']==406)
		{
			$this->event_image_complete_encode($k,$json,$help,$encode,$database,$memcache, 411, 402);
		}
		else if($action[$k]['actiontype']==408)
		{
			$mrow = $database->guest_select_actionid($action[$k]['actionid']);
			$action[$k]['eventid'] = $action[$k]['actionon'];
			$erow = $database->event_select($action[$k]['eventid']);
			$action[$k]['event_name'] = $erow['name'];
			$action[$k]['actionon'] = $mrow['profileid'];
			$name[$action[$k]['actionon']] = $help->name_fetch($action[$k]['actionon'], $memcache, $database);
			$pimage[$action[$k]['actionon']] = $help->pimage_fetch($action[$k]['actionon'], $memcache, $database); 
			$this->friendship_complete_encode($k,$json,$help,$encode,$database,$memcache, 411, 402);
		}
		else if($action[$k]['actiontype']==410)
		{
			$this->event_cancel_encode($k,$json,$help,$encode,$database,$memcache, 411, 402);
		}
		else if($action[$k]['actiontype']==416)
		{
			$this->event_link_complete_encode($k,$json,$help,$encode,$database,$memcache, 411, 402);
		}
		else if($action[$k]['actiontype']==425)
		{
			$this->event_video_complete_encode($k,$json,$help,$encode,$database,$memcache,411,402);
		}
		else if($action[$k]['actiontype']==426)
		{
			$this->event_doc_complete_encode($k,$json,$help,$encode,$database,$memcache,411,402);
		}
		else if($action[$k]['actiontype']==501 || $action[$k]['actiontype']==502)
		{
			$this->missu_complete_encode($k,$json,$help,$encode,$database,$memcache, 511, 503); 
			$pimage[$action[$k]['actionon']] = $help->pimage_fetch($action[$k]['actionon'], $memcache, $database,$memcache);
		}
		else if($action[$k]['actiontype']==600)
		{
			$this->blog_complete_encode($k,$json,$help,$encode,$database,$memcache, 611, 602);
		}
		else if($action[$k]['actiontype']== 700)
		{
			$this->direct_letter_complete_encode($k,$json,$help,$encode,$database,$memcache,711,702);
		}
		else if($action[$k]['actiontype']== 800)
		{
			$this->tagline_complete_encode($k,$json,$help,$encode,$database,$memcache, 811, 802);
		}
		else if($action[$k]['actiontype']==1201)
		{
			$this->mood_complete_encode($k,$json,$help,$encode,$database,$memcache,1211,1202);
		}
		else if($action[$k]['actiontype']==1401)
		{
			$this->gift_complete_encode($k,$json,$help,$encode,$database,$memcache, 1411, 1402); 
			$pimage[$action[$k]['actionon']] = $help->pimage_fetch($action[$k]['actionon'], $memcache, $database); 
		}
		else if($action[$k]['actiontype']==1600)
		{
			$this->link_complete_encode($k,$json,$help,$encode,$database,$memcache, 1611, 1602);
		}
		else if($action[$k]['actiontype']==1900)
		{
			$this->birthday_complete_encode($k,$json,$help,$encode,$database,$memcache, 1911, 1902);
		}
		else if($action[$k]['actiontype']==2000)
		{
			$this->status_song_complete_encode($k,$json,$help,$encode,$database,$memcache, 2011, 2002);
		}
		else if($action[$k]['actiontype']==2100)
		{
			$this->song_dedication_complete_encode($k,$json,$help,$encode,$database,$memcache, 2111, 2102);
		}
		else if($action[$k]['actiontype']== 2400)
		{
			$this->direct_letter_complete_encode($k,$json,$help,$encode,$database,$memcache,2411,2402);
		}
		else if($action[$k]['actiontype']==2500)
		{
			$this->video_complete_encode($k,$json,$help,$encode,$database,$memcache,2511,2502);
		}
		else if($action[$k]['actiontype']==2600)
		{
			$this->doc_complete_encode($k,$json,$help,$encode,$database,$memcache,2611,2602);
		}
		else if($action[$k]['actiontype']==2800)
		{
			$name[$action[$k]['actionby']] = $help->name_fetch($action[$k]['actionby'], $memcache, $database);
			$this->question_complete_encode($k,$json,$help,$encode,$database,$memcache,2811,2802);
		}
		else if($action[$k]['actiontype']==2901)
		{
			$name[$action[$k]['actionby']] = $help->name_fetch($action[$k]['actionby'], $memcache, $database);
			$this->page_page_complete_encode($k,$json,$help,$encode,$database,$memcache,2911,2902);
		}
		else if($action[$k]['actiontype']==2906)
		{
			$this->page_image_complete_encode($k,$json,$help,$encode,$database,$memcache, 2911, 2902);
		}
		else if($action[$k]['actiontype']==2916)
		{
			$this->page_link_complete_encode($k,$json,$help,$encode,$database,$memcache, 2911, 2902);
		}
		else if($action[$k]['actiontype']==2925)
		{
			$this->page_video_complete_encode($k,$json,$help,$encode,$database,$memcache,2911,2902);
		}
		else if($action[$k]['actiontype']==2926)
		{
			$this->page_doc_complete_encode($k,$json,$help,$encode,$database,$memcache,2911,2902);
		}
		else if($action[$k]['actiontype']==2 || $action[$k]['actiontype']==11)
		{
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->page_complete_encode($k,$json,$help,$encode,$database,$memcache,11,2);
		}
		else if($action[$k]['actiontype']==3 || $action[$k]['actiontype']==13)
		{
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->profile_edit_complete_encode($k,$json,$help,$encode,$database,$memcache, 13, 3);
		}
		else if($action[$k]['actiontype']==12 || $action[$k]['actiontype']==23)
		{
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->moment_complete_encode($k,$json,$help,$encode,$database,$memcache, 12, 23);
		}
		else if($action[$k]['actiontype']==15 || $action[$k]['actiontype']==24)
		{
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->image_complete_encode($k,$json,$help,$encode,$database,$memcache,15,24);
		}
		else if($action[$k]['actiontype']==16 || $action[$k]['actiontype']==25)
		{
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->profile_image_complete_encode($k,$json,$help,$encode,$database,$memcache, 16, 25);
		}
		else if($action[$k]['actiontype']==17 || $action[$k]['actiontype']==26)
		{
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->friendship_complete_encode($k,$json,$help,$encode,$database,$memcache, 17, 26);
		}
		else if($action[$k]['actiontype']==91 || $action[$k]['actiontype']==92)
		{
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->quipmate_joined_encode($k,$json,$help,$encode,$database,$memcache,91,92);
		}
		else if($action[$k]['actiontype']==503 || $action[$k]['actiontype']==511)
		{
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->missu_complete_encode($k,$json,$help,$encode,$database,$memcache, 511, 503); 
			$pimage[$action[$k]['actionon']] = $help->pimage_fetch($action[$k]['actionon'], $memcache, $database,$memcache); 
		}
		else if($action[$k]['actiontype']==602 || $action[$k]['actiontype']==611)
		{    
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->blog_complete_encode($k,$json,$help,$encode,$database,$memcache,611,602);
		}
		else if($action[$k]['actiontype']==702 || $action[$k]['actiontype']==711)
		{
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->direct_letter_complete_encode($k,$json,$help,$encode,$database,$memcache,711,702);
		}
		else if($action[$k]['actiontype']==802 || $action[$k]['actiontype']==811)
		{
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->tagline_complete_encode($k,$json,$help,$encode,$database,$memcache, 811, 802);
		}
		else if($action[$k]['actiontype']==1202 || $action[$k]['actiontype']==1211)
		{
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->mood_complete_encode($k,$json,$help,$encode,$database,$memcache,1211,1202);
		}
		else if($action[$k]['actiontype']==1402 || $action[$k]['actiontype']==1411)
		{    
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->gift_complete_encode($k,$json,$help,$encode,$database,$memcache, 1411, 1402); 
		}
		else if($action[$k]['actiontype']==1602 || $action[$k]['actiontype']==1611)
		{
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->link_complete_encode($k,$json,$help,$encode,$database,$memcache, 1611, 1602);
		}
		else if($action[$k]['actiontype']==1902 || $action[$k]['actiontype']==1911)
		{
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->birthday_complete_encode($k,$json,$help,$encode,$database,$memcache, 1911, 1902);
		}
		else if($action[$k]['actiontype']==2002 || $action[$k]['actiontype']==2011 || $action[$k]['actiontype']==2012)
		{
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->status_song_complete_encode($k,$json,$help,$encode,$database,$memcache, 2011, 2002);
		}
		else if($action[$k]['actiontype']==2102 || $action[$k]['actiontype']==2111 || $action[$k]['actiontype']==2112)
		{
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->song_dedication_complete_encode($k,$json,$help,$encode,$database,$memcache, 2111, 2002);
		}
		else if($action[$k]['actiontype']==2402 || $action[$k]['actiontype']==2411)
		{
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->direct_letter_complete_encode($k,$json,$help,$encode,$database,$memcache,2411,2402);
		}		
		else if($action[$k]['actiontype']==2511 || $action[$k]['actiontype']==2502)
		{    
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->video_complete_encode($k,$json,$help,$encode,$database,$memcache,2511,2502);
		}
		else if($action[$k]['actiontype']==2602 || $action[$k]['actiontype']==2611)
		{    
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			$this->doc_complete_encode($k,$json,$help,$encode,$database,$memcache,2611,2602);
		}
		else if($action[$k]['actiontype']==2801 || $action[$k]['actiontype']==2802 || $action[$k]['actiontype']==2811)
		{
			$this->parent_encode($NROW,$k,$json,$help,$encode,$database,$memcache);
			if ($action[$k]['parenttype'] ==328)
			{
				$this->group_question_complete_encode($k,$json,$help,$encode,$database,$memcache,302,311);
			}
			else
			{
				$this->question_complete_encode($k,$json,$help,$encode,$database,$memcache,2811,2802);
			}
		}
		else if($action[$k]['actiontype'] > 200 && $action[$k]['actiontype'] < 300)
		{
			$action[$k]['actionid'] = $NROW['ACTIONID'];
			$action[$k]['pageid']   = $NROW['PAGEID'];
			$action[$k]['parenttype'] = $action[$k]['actiontype'];					
			$action[$k]['postby']   = $NROW['ACTIONBY'];
			$action[$k]['visible']   = $NROW['VISIBLE'];	
			$action[$k]['time']     = $help->get_utc($NROW['TIMESTAMP']);
			$this->profile_edit_complete_encode($k,$json,$help,$encode,$database,$memcache, 13, 3);
		}
	/*	if($action=='notice')
		{
		$action[$k]['time'] =$help->get_utc($NROW['TIMESTAMP']);	
		} */
	}

	function quipmate_joined_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype)
	{
		global $action;
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	
	}
	
	function group_event_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype)
	{   global $action;
		$g = $database->group_select($action[$k]['actionon']);
		$action[$k]['groupid'] = $g['groupid'];
		$action[$k]['group_name'] = $g['name'];
		$e = $database->event_select($action[$k]['pageid']);
		$action[$k]['eventid'] = $e['eventid'];
		$action[$k]['event_name'] = $e['name'];
		$action[$k]['event_description'] = $e['description'];
		$action[$k]['venue'] = $e['venue'];
		$action[$k]['date'] = date('j M,Y',strtotime($e['date']));
		$action[$k]['timing'] = $e['timing'];	
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	
	function event_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype)
	{   global $action;
		$e = $database->event_select($action[$k]['pageid']);
		$action[$k]['eventid'] = $e['eventid'];
		$action[$k]['event_name'] = $e['name'];
		$action[$k]['event_description'] = $e['description'];
		$action[$k]['venue'] = $e['venue'];
		$action[$k]['date'] = date('j M,Y',strtotime($e['date']));
		$action[$k]['timing'] = $e['timing'];	
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	} 
	
	function event_cancel_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype)
	{   global $action;
		$e = $database->event_select($action[$k]['actionon']);
		$action[$k]['eventid'] = $e['eventid'];
		$action[$k]['event_name'] = $e['name'];
		$action[$k]['event_description'] = $e['description'];
		$action[$k]['venue'] = $e['venue'];
		$action[$k]['date'] = date('j M,Y',strtotime($e['date']));
		$action[$k]['timing'] = $e['timing'];	
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	
	function group_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype)
	{   
		global $action;
		$e = $database->group_select($action[$k]['pageid']);
		$action[$k]['groupid'] = $e['groupid'];
		$action[$k]['group_name'] = $e['name'];
		$action[$k]['group_description'] = $e['description'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	
	function group_page_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype)
	{   global $action;
		$e = $database->group_select($action[$k]['actionon']);
		$action[$k]['groupid'] = $e['groupid'];
		$action[$k]['group_name'] = $e['name'];
		$action[$k]['page'] = $encode->page_encode($action[$k]['pageid'],$database);
		$myprofileid = $_SESSION['userid'];
		$grow = $database->is_group_admin($e['groupid'],$myprofileid);
		$action[$k]['remove'] = $grow['priviledge'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	function page_page_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype)
	{   global $action;
		$e = $database->page_select($action[$k]['actionon']);
		$action[$k]['page_pageid'] = $e['pageid'];
		$action[$k]['page_name'] = $e['name'];
		$action[$k]['page'] = $encode->page_encode($action[$k]['pageid'],$database);
		$myprofileid = $_SESSION['userid'];
		$grow = $database->is_page_admin($e['pageid'],$myprofileid);
		$action[$k]['remove'] = $grow['priviledge'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	function group_question_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype)
	{   global $action;
		$e = $database->group_select($action[$k]['actionon']);
		$action[$k]['groupid'] = $e['groupid'];
		$action[$k]['group_name'] = $e['name'];
		$q = $encode->question_encode($action[$k]['pageid'],$database);	
		$action[$k]['question'] = $q['question'];
		$action[$k]['option'] = $q['option'];
		$myprofileid = $_SESSION['userid'];
		$grow = $database->is_group_admin($e['groupid'],$myprofileid);
		$action[$k]['remove'] = $grow['priviledge'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);
	}
	
	function event_page_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype)
	{   global $action;
		$e = $database->event_select($action[$k]['actionon']);
		$action[$k]['eventid'] = $e['eventid'];
		$action[$k]['event_name'] = $e['name'];
		$action[$k]['page'] = $encode->page_encode($action[$k]['pageid'],$database);	
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);		 
	}
	
	function profile_edit_complete_encode($k,$json,$help,$encode,$database,$memcache, $rtype, $ctype)
	{   global $action;
		$action[$k]['sex'] = $database->sex_select($action[$k]['postby']);	
		$edit = json_decode($encode->profile_edit_encode($action[$k]['actionon'],$action[$k]['parenttype'],$action[$k]['pageid'],$database));
		$action[$k]['edit_field'] =  $edit->field;
		$action[$k]['edit_value'] =  $edit->value;		
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
		
	function birthday_complete_encode($k,$json,$help,$encode,$database,$memcache, $rtype, $ctype)
	{   global $action;
		$action[$k]['sex'] = $database->sex_select($action[$k]['actionon']);	  
		$bday = $encode->birthday_encode($action[$k]['pageid'],$database);	
		$action[$k]['date'] = $bday['date'];
		$action[$k]['page'] = $bday['page'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	
	function song_dedication_complete_encode($k,$json,$help,$encode,$database,$memcache, $rtype, $ctype)
	{   global $action;
		$song = $encode->song_encode($action[$k]['pageid'],$database);	
		$action[$k]['song'] = $song['song'];
		$action[$k]['page'] =  $song['page'];
		$action[$k]['file'] = $song['file'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype); 
	}
	
	function status_song_complete_encode($k,$json,$help,$encode,$database,$memcache, $rtype, $ctype)
	{   global $action;
		$song = $encode->song_encode($action[$k]['pageid'],$database);	
		$action[$k]['song'] = $song['song'];
		$action[$k]['page'] = $song['page'];
		$action[$k]['file'] = $song['file'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);		 
	}
	function friendship_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype)
	{   global $action;
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	} 
	
    function missu_complete_encode($k,$json,$help,$encode,$database,$memcache, $rtype, $ctype)
	{   global $action;
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	function crush_complete_encode($k,$json,$help,$encode,$database,$memcache, $rtype, $ctype)
	{   global $action;
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype); 
	}
	function crush_match_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype, $ctype)
	{   global $action;
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
		
	function group_link_complete_encode($k,$json,$help,$encode,$database,$memcache, $rtype, $ctype)
	{   global $action;
		$e = $database->group_select($action[$k]['actionon']);
		$action[$k]['groupid'] = $e['groupid'];
		$action[$k]['group_name'] = $e['name'];
		$link =$encode->link_encode($action[$k]['pageid'],$database);
		$action[$k]['title'] = $link['title'];
		$action[$k]['link'] = $link['link'];
		$action[$k]['host'] = $link['host'];
		$action[$k]['meta'] = $link['meta'];
		$action[$k]['page'] = $link['page'];
		$action[$k]['video'] = $link['video'];
		$action[$k]['file'] = $link['file'];	 
		$myprofileid = $_SESSION['userid'];
		$grow = $database->is_group_admin($e['groupid'],$myprofileid);
		$action[$k]['remove'] = $grow['priviledge'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);
	}
	function page_link_complete_encode($k,$json,$help,$encode,$database,$memcache, $rtype, $ctype)
	{   global $action;
		$e = $database->page_select($action[$k]['actionon']);
		$action[$k]['page_pageid'] = $e['pageid'];
		$action[$k]['page_name'] = $e['name'];
		$link =$encode->link_encode($action[$k]['pageid'],$database);
		$action[$k]['title'] = $link['title'];
		$action[$k]['link'] = $link['link'];
		$action[$k]['host'] = $link['host'];
		$action[$k]['meta'] = $link['meta'];
		$action[$k]['page'] = $link['page'];
		$action[$k]['video'] = $link['video'];
		$action[$k]['file'] = $link['file'];	 
		$myprofileid = $_SESSION['userid'];
		$grow = $database->is_page_admin($e['pageid'],$myprofileid);
		$action[$k]['remove'] = $grow['priviledge'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);
	}	
	
	function event_link_complete_encode($k,$json,$help,$encode,$database,$memcache, $rtype, $ctype)
	{   global $action;
		$e = $database->event_select($action[$k]['actionon']);
		$action[$k]['eventid'] = $e['eventid'];
		$action[$k]['event_name'] = $e['name'];
		$link =$encode->link_encode($action[$k]['pageid'],$database);
		$action[$k]['title'] = $link['title'];
		$action[$k]['link'] = $link['link'];
		$action[$k]['host'] = $link['host'];
		$action[$k]['meta'] = $link['meta'];
		$action[$k]['page'] = $link['page'];
		$action[$k]['video'] = $link['video'];
		$action[$k]['file'] = $link['file'];	 
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);
	}	
	
	function link_complete_encode($k,$json,$help,$encode,$database,$memcache, $rtype, $ctype)
	{   global $action;
		$link =$encode->link_encode($action[$k]['pageid'],$database);
		$action[$k]['title'] = $link['title'];
		$action[$k]['link'] = $link['link'];
		$action[$k]['host'] = $link['host'];
		$action[$k]['meta'] = $link['meta'];
		$action[$k]['page'] = $link['page'];
		$action[$k]['video'] = $link['video'];
		$action[$k]['file'] = $link['file'];	 
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);
	}
	
	function gift_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype)
	{   global $action;
		$gift =$encode->gift_encode($action[$k]['pageid'],$database);	
		$action[$k]['gift'] = $gift['gift'];
		$action[$k]['page'] =  $gift['page'];
		$action[$k]['file'] = $gift['file'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	
	function mood_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype)
	{   global $action;
		$action[$k]['sex'] = $database->sex_select($action[$k]['postby']);		
		$mood = $encode->mood_encode($action[$k]['pageid'],$database);	
		$action[$k]['mood'] = $mood['mood'];
		$action[$k]['page'] = $mood['page'];
		$action[$k]['file'] = $mood['file'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	
	function tagline_complete_encode($k,$json,$help,$encode,$database,$memcache, $rtype, $ctype)
	{   global $action;
		$action[$k]['sex'] = $database->sex_select($action[$k]['postby']);		
		$tag = $encode->tagline_encode($action[$k]['pageid'],$database);
		$action[$k]['tagline'] = $tag['tagline'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	
    function moment_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype)
	{
	    global $action;
		$moment = $encode->moment_encode($action[$k]['pageid'],$help,$database);
		$action[$k]['momnetid'] = $moment['momentid'];
		$action[$k]['count'] = $moment['count'];
		$action[$k]['mname'] = $moment['mname'];
		$action[$k]['desc'] = $moment['desc'];
		$action[$k]['photo'] = $moment['photo'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype); 
	}
	
	function direct_letter_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype)
	{   global $action;
		$action[$k]['letter_title'] = $encode->page_encode($action[$k]['pageid'],$database);	
		$action[$k]['letter_content'] = $encode->page_comment_encode($action[$k]['pageid'],$database);			
	 	$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);
	}
	
	function page_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype)
	{   global $action;
		$action[$k]['page'] = $encode->page_encode($action[$k]['pageid'],$database);	
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);
	}
	
	function question_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype)
	{   global $action;
		$q = $encode->question_encode($action[$k]['pageid'],$database);	
		$action[$k]['question'] = $q['question'];
		$action[$k]['option'] = $q['option'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);
	}
	
	function response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype)
	{
		global $action;
		$action[$k]['excited'] = $encode->response_encode($action[$k]['pageid'],$rtype,$json,$help,$database,$memcache);
		$com_num = $action[$k]['comment_count'] = $encode->comment_count_encode($action[$k]['pageid'],$ctype,$database);
		if($com_num > 3)
		{
			$action[$k]['actionid_third'] = $encode->comment_actionid_of_third_encode($action[$k]['pageid'],$ctype,$database);
		}
		$action[$k]['com'] = $encode->comment_encode($action[$k]['pageid'],$com_num,$json,$help,$database,$memcache);	
	}
	
	function blog_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype, $ctype)
	{   
	    global $action;
		$action[$k]['blog_title'] = $encode->page_encode($action[$k]['pageid'],$database);	
		$action[$k]['blog_content'] = $encode->page_comment_encode($action[$k]['pageid'],$database);			
		$action[$k]['file'] = $encode->image_encode($action[$k]['pageid'],$database);	
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}

    function image_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype, $ctype)
	{   
	    global $action;
		$action[$k]['page'] = $encode->page_encode($action[$k]['pageid'],$database);	
		$action[$k]['file'] = $encode->image_encode($action[$k]['pageid'],$database);	
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	
	function doc_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype, $ctype)
	{   
	    global $action;
		$action[$k]['page'] = $encode->page_encode($action[$k]['pageid'],$database);	
		$d = $encode->doc_encode($action[$k]['pageid'],$database);	
		$action[$k]['file'] = $d['file'];
		$action[$k]['caption'] = $d['caption'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	
	function video_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype, $ctype)
	{   
	    global $action;
		$action[$k]['page'] = $encode->page_encode($action[$k]['pageid'],$database);	
		$d = $encode->video_encode($action[$k]['pageid'],$database);	
		$action[$k]['file'] = $d['file'];
		$action[$k]['caption'] = $d['caption'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	
	function event_doc_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype, $ctype)
	{   
	    global $action;
		$e = $database->event_select($action[$k]['actionon']);
		$action[$k]['eventid'] = $e['eventid'];
		$action[$k]['event_name'] = $e['name'];
		$action[$k]['page'] = $encode->page_encode($action[$k]['pageid'],$database);	
		$d = $encode->doc_encode($action[$k]['pageid'],$database);	
		$action[$k]['file'] = $d['file'];
		$action[$k]['caption'] = $d['caption'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	
	function event_video_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype, $ctype)
	{   
	    global $action;
		$e = $database->event_select($action[$k]['actionon']);
		$action[$k]['eventid'] = $e['eventid'];
		$action[$k]['event_name'] = $e['name'];
		$action[$k]['page'] = $encode->page_encode($action[$k]['pageid'],$database);		
		$d = $encode->video_encode($action[$k]['pageid'],$database);	
		$action[$k]['file'] = $d['file'];
		$action[$k]['caption'] = $d['caption'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	
		
	function group_doc_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype, $ctype)
	{   
	    global $action;
		$e = $database->group_select($action[$k]['actionon']);
		$action[$k]['groupid'] = $e['groupid'];
		$action[$k]['group_name'] = $e['name'];
		$action[$k]['page'] = $encode->page_encode($action[$k]['pageid'],$database);	
		$d = $encode->group_doc_encode($action[$k]['pageid'],$database);	
		$action[$k]['version'] = $d['version'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	
	function group_video_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype, $ctype)
	{   
	    global $action;
		$e = $database->group_select($action[$k]['actionon']);
		$action[$k]['groupid'] = $e['groupid'];
		$action[$k]['group_name'] = $e['name'];
		$action[$k]['page'] = $encode->page_encode($action[$k]['pageid'],$database);	
		$d = $encode->video_encode($action[$k]['pageid'],$database);	
		$action[$k]['file'] = $d['file'];
		$action[$k]['caption'] = $d['caption'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	function page_doc_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype, $ctype)
	{   
	    global $action;
		$e = $database->page_select($action[$k]['actionon']);
		$action[$k]['page_pageid'] = $e['groupid'];
		$action[$k]['page_name'] = $e['name'];
		$action[$k]['page'] = $encode->page_encode($action[$k]['pageid'],$database);	
		$d = $encode->doc_encode($action[$k]['pageid'],$database);	
		$action[$k]['file'] = $d['file'];
		$action[$k]['caption'] = $d['caption'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	function page_video_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype, $ctype)
	{   
	    global $action;
		$e = $database->page_select($action[$k]['actionon']);
		$action[$k]['page_pageid'] = $e['pageid'];
		$action[$k]['page_name'] = $e['name'];
		$action[$k]['page'] = $encode->page_encode($action[$k]['pageid'],$database);	
		$d = $encode->video_encode($action[$k]['pageid'],$database);	
		$action[$k]['file'] = $d['file'];
		$action[$k]['caption'] = $d['caption'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	function event_image_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype, $ctype)
	{   
	    global $action;
		$e = $database->event_select($action[$k]['actionon']);
		$action[$k]['eventid'] = $e['eventid'];
		$action[$k]['event_name'] = $e['name'];
		$action[$k]['page'] = $encode->page_encode($action[$k]['pageid'],$database);	
		$action[$k]['file'] = $encode->image_encode($action[$k]['pageid'],$database);	
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	
	function group_image_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype, $ctype)
	{   
	    global $action;
		$e = $database->group_select($action[$k]['actionon']);
		$action[$k]['groupid'] = $e['groupid'];
		$action[$k]['group_name'] = $e['name'];
		$action[$k]['page'] = $encode->page_encode($action[$k]['pageid'],$database);	
		$action[$k]['file'] = $encode->image_encode($action[$k]['pageid'],$database);	
		$myprofileid = $_SESSION['userid'];
		$grow = $database->is_group_admin($e['groupid'],$myprofileid);
		$action[$k]['remove'] = $grow['priviledge'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
	function page_image_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype, $ctype)
	{   
	    global $action;
		$e = $database->page_select($action[$k]['actionon']);
		$action[$k]['page_pageid'] = $e['pageid'];
		$action[$k]['page_name'] = $e['name'];
		$action[$k]['page'] = $encode->page_encode($action[$k]['pageid'],$database);	
		$action[$k]['file'] = $encode->image_encode($action[$k]['pageid'],$database);	
		$myprofileid = $_SESSION['userid'];
		$grow = $database->is_page_admin($e['pageid'],$myprofileid);
		$action[$k]['remove'] = $grow['priviledge'];
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
    function profile_image_complete_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype)
	{   
	    global $action;
		$action[$k]['sex'] = $database->sex_select($action[$k]['postby']);	  
		$action[$k]['file'] = $encode->image_encode($action[$k]['pageid'],$database);	  
		$this->response_comment_encode($k,$json,$help,$encode,$database,$memcache,$rtype,$ctype);	 
	}
}
?>