<?php
class Email
{    
	function email_sample($param)
	{
		$email_type = $param['type'];
		global $database;
		$additionalHeaders = "MIME-Version:1.0\r\n";
		$additionalHeaders .= "Content-Type: text/html\r\n"; 
		$additionalHeaders .= "Reply-To:no-reply<no-reply@quipmate.com>\r\n";
		$message = '';
		$email='';
		$subject='';
		if($email_type == 'group_admin')
		{
			$friendid = $param['friendid'];
			$profileid = $param['profileid'];
			$groupid = $param['groupid'];
			$irow = $database->get_name($profileid);
			$grow = $database->get_group($groupid);
			$groupname = $grow['NAME'];
			$subject = '['.$groupname.'] ';
			$subject .= $irow['NAME'];   
			$subject .=' has made you admin of the group ';
			$subject .=$groupname;
			$brow = $database->bio_complete_select($friendid);
			$email = $brow['EMAIL'];
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $friendid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br /><br />';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$irow = $database->get_image($profileid);
			$file = $irow['CDN'].$irow['FILENAME'];
			$file = $file;
			$message .='<img style="border:none;float:left;" src="';
			$message .= $file; 
			$message .= '" width="80" height="80" />'; 
			$message .= '</a>';
			$message .='<div style="margin-left:80px;">';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$irow = $database->get_name($profileid);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' has made you admin of the group ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/group.php?id=';
			$message .= $groupid; 
			$message .= '">'; 
			$message .= $groupname;
			$message .= '</a>';
			$message .= ' at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate.</a>';
			$message .= '</div>'; 
			$message .= ' <br /><br />To see the updates from the group ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/group.php?id=';
			$message .= $groupid; 
			$message .= '">'; 
			$message .= $groupname;
			$message .= '</a>';
			$message .= ' Please visit this group at <a style="text-decoration:none;" href="https://www.quipmate.com/group.php?id=';
			$message .= $groupid; 
			$message .= '">'; 
			$message .= $groupname;
			$message .= '</a>';
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
		}
		else if($email_type == 'event_cancel')
		{
			$eventname = $param['eventname'];
			$memberid = $param['memberid'];
			$actionby = $param['actionby'];
			$actionid = $param['actionid'];
			$irow = $database->get_name($profileid);
			$subject= '['.$eventname.'] ';
			$subject .= $irow['NAME'];
			$subject .=' has canceled the event '.$eventname;
			$brow = $database->bio_complete_select($memberid);
			$email = $brow['EMAIL'];
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $memberid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br />';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' has canceled the event '.$eventname.' at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate </a>.<br /><br />';
			$irow = $database->get_image($actionby);
			$file = $irow['CDN'].$irow['FILENAME']; 
			$file = $file;
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$message .= "<img style='border:none;' src='$file' width='40' height='40' />";
			$message .= '</a>';
			$message .= '<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id='.$actionby.'">Visit profile </a>to reply this action to ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= '</body>';
			$message .= '</html>';
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
		}
		else if($email_type == 'event_invite')
		{
			$profileid = $param['profileid'];
			$friendid = $param['friendid'];
			$eventid = $param['eventid'];
			$irow = $database->get_name($profileid);
			$grow = $database->event_select($eventid);
			$host =  $grow['host'];
			$eventname = $grow['name'];
			$subject= '('.$eventname.') ';
			$hrow = $database->get_name($host);
			$subject .= $irow['NAME'];
			$subject .=' has invited you to ';
			$subject .= $hrow['NAME'];
			$subject .='\'s event ';
			$subject .= $eventname;
			$brow = $database->bio_complete_select($friendid);
			$email = $brow['EMAIL'];
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $friendid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br /><br />';
			$message .='<div style=""><a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$irow = $database->get_image($profileid);
			$file = $irow['CDN'].$irow['FILENAME'];
			$file = $file;
			$message .='<img style="border:none;" src="';
			$message .= $file; 
			$message .= '" width="80" height="80" />'; 
			$message .= '</a>';
			$message .='<div style="position:relative;top:10px;">';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$irow = $database->get_name($profileid);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .='</div>'; 
			$message .='</div>';
			$message .= ' has invited you to the event ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/event.php?id=';
			$message .= $eventid; 
			$message .= '">'; 
			$message .= $eventname;
			$message .= '</a>';
			$message .= ' at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate</a>.';
			$message .= ' <br /><br />To see the updates from the event ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/event.php?id=';
			$message .= $eventid; 
			$message .= '">'; 
			$message .= $eventname;
			$message .= '</a>';
			$message .= ' Please visit this event at <a style="text-decoration:none;" href="https://www.quipmate.com/">';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/event.php?id=';
			$message .= $eventid; 
			$message .= '">'; 
			$message .= $eventname;
			$message .= '</a>';
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
		} 
		else if($email_type == 'group_invite')
		{
			$profileid = $param['profileid'];
			$friendid = $param['friendid'];
			$groupid = $param['groupid'];
			$irow = $database->get_name($profileid);
			$subject = $irow['NAME'];
			$grow = $database->get_group($groupid);
			$groupname = $grow['NAME'];
			$subject .=' has added you to the group ';
			$subject .=$groupname;
			$brow = $database->bio_complete_select($friendid);
			$email = $brow['EMAIL'];
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $friendid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br /><br />';
			$message .='<div style=""><a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$irow = $database->get_image($profileid);
			$file = $irow['CDN'].$irow['FILENAME'];
			$file = $file;
			$message .='<img style="border:none;" src="';
			$message .= $file; 
			$message .= '" width="80" height="80" />'; 
			$message .= '</a>';
			$message .='<div style="position:relative;top:10px;">';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$irow = $database->get_name($profileid);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .='</div>'; 
			$message .='</div>';
			$message .= ' has added you into the group ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/group.php?id=';
			$message .= $groupid; 
			$message .= '">'; 
			$message .= $groupname;
			$message .= '</a>';
			$message .= ' at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate</a>.';
			$message .= ' <br /><br />To see the updates from the group ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/group.php?id=';
			$message .= $groupid; 
			$message .= '">'; 
			$message .= $groupname;
			$message .= '</a>';
			$message .= ' Please visit this group at <a style="text-decoration:none;" href="https://www.quipmate.com/group.php?id=';
			$message .= $groupid; 
			$message .= '">'; 
			$message .= $groupname;
			$message .= '</a>';
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
			}  
		else if($email_type == 'event_post')
		{
			$eventid =  $param['eventid'];
			$memberid = $param['memberid'];
			$actionby = $param['actionby'];
			$actionid = $param['actionid'];
			$post = $param['page'];
			$grow = $database->event_select($eventid);
			$eventname = $grow['name'];
			$subject = '['.$eventname.'] '.$post;
			$brow = $database->bio_complete_select($memberid);
			$email = $brow['EMAIL'];
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $memberid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br />';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' posted in  '.$eventname.' event at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate </a>.<br /><br />';
			$irow = $database->get_image($actionby);
			$file = $irow['CDN'].$irow['FILENAME']; 
			$file = $file;
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$message .='<img style="border:none;" src="';
			$message .= $file; 
			$message .= '" width="40" height="40" />'; 
			$message .= '</a>';
			$message .= '<span style="margin-left:20px;"><pre>'.$post.'</pre></span><br /><br />';
			$message .= '<a style="text-decoration:none;" href="https://www.quipmate.com/event.php?id='.$eventid.'">To reply </a>this post to ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' please click <a style="text-decoration:none;" href="https://www.quipmate.com/event.php?id='.$eventid.'">here</a>.';
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
	    }
		else if($email_type == 'group_post')
		{
			$groupid =  $param['groupid'];
			$memberid = $param['memberid'];
			$actionby = $param['actionby'];
			$actionid = $param['actionid'];
			$post = $param['page'];
			$grow = $database->get_group($groupid);
			$groupname = $grow['NAME'];
			$subject= '['.$groupname.'] '.$post;
			$brow = $database->bio_complete_select($memberid);
			$email = $brow['EMAIL'];
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $memberid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br />';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' posted in  '.$groupname.' group at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate </a>.<br /><br />';
			$irow = $database->get_image($actionby);
			$file = $irow['CDN'].$irow['FILENAME']; 
			$file = $file;
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$message .='<img style="border:none;" src="';
			$message .= $file; 
			$message .= '" width="40" height="40" />'; 
			$message .= '</a>';
			$message .= '<span style="margin-left:20px;"><pre>'.$post.'</pre></span><br /><br />';
			$message .= '<a style="text-decoration:none;" href="https://www.quipmate.com/group.php?id='.$groupid.'">To reply </a>this post to ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' please click <a style="text-decoration:none;" href="https://www.quipmate.com/group.php?id='.$groupid.'">here</a>.';
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
		}
		else if($email_type == 'page_post')
		{
			$page_name = $param['page_name'] ;
			$page_pageid = $param['page_pageid'] ;
			$actionid = $param['actionid'];
			$post = $param['page'];
			$subject= '['.$page_name.'] '.$post;
			$message  ='<a style="text-decoration:none;" href="https://www.quipmate.com/page.php?id=';
			$message .= $page_pageid; 
			$message .= '">'; 
			$message .= $page_name;
			$message .= '</a>';
			$message .= ' has new broadcast at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate </a>.<br /><br />';
			$file = 'https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com/broadcast.png';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/page.php?id=';
			$message .= $page_pageid; 
			$message .= '">'; 
			$message .='<img style="border:none;" src="';
			$message .= $file; 
			$message .= '" width="40" height="40" />'; 
			$message .= '</a>';
			$message .= '<span style="margin-left:20px;"><pre>'.$post.'</pre></span><br /><br />';
			$additionalHeaders .= 'From:"Quipmate"<broadcast@quipmate.com>';
			//Another mechanish is below but both have serious performance issue 
			/*
				$query .= "Insert into `admin`.`email`(`email`, `subject`, `body`, `headers`) values ('$email','$subject','$message','$additionalHeaders');";
			}
			$database->send_query($query);
			*/
		}
		else if($email_type == 'birthday_bomb')
	    {
			$profileid =  $param['profileid'];
			$actionby = $param['actionby'];
			$actionid = $param['actionid'];
			$actionid = $param['actionid'];
			$page = $param['page'];
			$subject= ' Birthday-bomed you. '.$page;
			$brow = $database->bio_complete_select($profileid);
			$email = $brow['EMAIL']; 
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br />';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' birthday bombed you at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate </a>.<br /><br />';
			$irow = $database->get_image($actionby);
			$file = $irow['CDN'].$irow['FILENAME']; 
			$file = $file;
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$message .='<img style="border:none;" src="';
			$message .= $file; 
			$message .= '" width="40" height="40" />'; 
			$message .= '</a>';
			$message .= '<span style="margin-left:20px;">'.$gift.'</span><br /><br />';
			$message .= 'To say thanx to ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' please click ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
		}
			else if($email_type == 'MD_invite')
	    {
			$email = $param['email'];
			//$identifier = $param['identifier'];
			$myname = $param['myname'];
			$myphoto = $param['myphoto'];
			//$myprofileid = $param['actionby'];	
			$subject='Invitation from Admin to join Quipmate';
			$message .= 'Hi ';
			$message .= $email.'</a>,<br /><br />';
			$message .='<div style=""><a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			//$message .= $myprofileid; 
			$message .= '">'; 
			$message .='<img style="border:none;" src="';
			$message .= $myphoto; 
			$message .= '" width="80" height="80" />'; 
			$message .= '</a>';
			$message .='<div style="position:relative;top:10px;">';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			//$message .= $myprofileid; 
			$message .= '">'; 
			$message .= $myname;
			$message .= '</a>';
			$message .= ' invited you to join <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate</a>.<br /><br />';
			$message .= 'Please click the following link to start the registration process'."\n\n<br/>";
			$message .= '<a style="text-decoration:none;" href=';
			$message .= "https://www.quipmate.com/welcome.php?email=$email";
			$message .= '>Register Now</a>';
			$message .= '<div>or copy & paste this link in your browser address bar'."\n\n<br/>";
			$message .= "https://www.quipmate.com/welcome.php?email=$email</div>";
			$message .='</div>'; 
			$message .='</div>';
			$additionalHeaders .= 'From:'.$myname.'<member@quipmate.com>';
		}
	/*	else if($email_type == 'star_of_the_week_broadcast')
		{
			$profileid = $param['profileid'];
			$contribution = $param['contribution'];
			$date = $param['date'];
			//$name = $param['name'];
			$email = $param['email'];
			$subject='Star Of The Week';
			$message .= 'Hi '.$name.',<br />';
			$message .= 'The following is selected as Star Of The Week. <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate</a>. Contributions: <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate.</a>-<br /><br />'.$contributions; 
			global $database;
			$additionalHeaders .= 'From:'.$irow['NAME'].'<star-of-the-week-qm@quipmate.com>\r\n';
		}   */ // Not well written ;    
		else if($email_type == 'self_invite' || $email_type == 'people_invite')
	    {
			$email = $param['email'];
			$identifier = $param['identifier'];
			$subject='Quipmate Registration Link';
			$message .= 'Hi ';
			$message .= $email.'</a>,<br /><br />';
			$message .='<div style="">';
			$m = ' You recently initiated signup process at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate</a>.<br /><br />';
			if($email_type == 'people_invite')
			{
				$m= 'Your network admin has invited you to join <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate</a>.<br /><br />';
			}
			$message .= $m;
			$message .='</div>'; 
			$message .='</div>';
			$message .= 'Please click the following link to proceed with the registration process'."\n\n<br/>";
			$message .= '<a style="text-decoration:none;" href=';
			$message .= "https://www.quipmate.com/welcome.php?email=$email&identifier=$identifier";
			$message .= '>Register Now</a>';
			$message .= '<div>or copy & paste this link in your browser address bar'."\n\n<br/>";
			$message .= "https://www.quipmate.com/welcome.php?email=$email&identifier=$identifier</div>";
			$additionalHeaders .= 'From:Quipmate<register@quipmate.com>';
		}
		else if($email_type == 'self_invite_mobile' )
	    {
			$email = $param['email'];
			$code = $param['code'];
			$subject='Quipmate Registration Link';
			$message .= 'Hi ';
			$message .= $email.'</a>,<br /><br />';
			$message .='<div style="">';
			$m = ' You recently initiated signup process at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate</a>.<br /><br />';
			if($email_type == 'people_invite')
			{
				$m= 'Your network admin has invited you to join <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate</a>.<br /><br />';
			}
			$message .= $m;
			$message .='</div>'; 
			$message .='</div>';
			
			$message = 'Your 4 digit confirmation code for signup is '.$code;
			
			
			$additionalHeaders .= 'From:"Quipmate"<register@quipmate.com>';
		}
		else if($email_type == 'friend_invite')
	    {
			$email = $param['email'];
			$identifier = $param['identifier'];
			$myname = $param['myname'];
			$myphoto = $param['myphoto'];
			$myprofileid = $param['actionby'];	
			$subject='Invitation from '.$myname.' to join Quipmate';
			$message .= 'Hi ';
			$message .= $email.'</a>,<br /><br />';
			$message .='<div style=""><a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $myprofileid; 
			$message .= '">'; 
			$message .='<img style="border:none;" src="';
			$message .= $myphoto; 
			$message .= '" width="80" height="80" />'; 
			$message .= '</a>';
			$message .='<div style="position:relative;top:10px;">';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $myprofileid; 
			$message .= '">'; 
			$message .= $myname;
			$message .= '</a>';
			$message .= ' invited you to join <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate</a>.<br /><br />';
			$message .= 'Please click the following link to start the registration process'."\n\n<br/>";
			$message .= '<a style="text-decoration:none;" href=';
			$message .= "https://www.quipmate.com/welcome.php?email=$email&identifier=$identifier";
			$message .= '>Register Now</a>';
			$message .= '<div>or copy & paste this link in your browser address bar'."\n\n<br/>";
			$message .= "https://www.quipmate.com/welcome.php?email=$email&identifier=$identifier</div>";
			$message .='</div>'; 
			$message .='</div>';
			$additionalHeaders .= 'From:'.$myname.'<member@quipmate.com>';
		}
		else if($email_type == 'friend_confirm')
	    {
			$profileid = $param['profileid'];
			$friendid = $param['friendid'];
			$subject='Friendship Confirmation';
			$brow = $database->bio_complete_select($friendid);
			$email = $brow['EMAIL'];
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $friendid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br /><br />';
			$message .='<div style=""><a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$irow = $database->get_image($profileid);
			$file = $irow['CDN'].$irow['FILENAME'];
			$file = $file;
			$message .='<img style="border:none;" src="';
			$message .= $file; 
			$message .= '" width="80" height="80" />'; 
			$message .= '</a>';
			$message .='<div style="position:relative;top:10px;">';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$irow = $database->get_name($profileid);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .='</div>'; 
			$message .='</div>';
			$message .= ' is also following you at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate</a>.';
			$message .= ' <br /><br />To see the updates from ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' please visit your home page at <a style="text-decoration:none;" href="https://www.quipmate.com/">';
			$message .= $name;
			$message .= '-Quipmate</a>';
			$message .= ' <br /><br />To learn about ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' please visit the profile at <a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$message .= $irow['NAME'];
			$message .= '</a>';
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
		}      
		else if($email_type == 'gift')
		{
			$profileid = $param['profileid'];
			$actionby = $param['actionby'];
			$actionid = $param['actionid'];
			$gift = $param['gift'];
			$subject= $gift.' Send you a gift at Quipmate';
			$brow = $database->bio_complete_select($profileid);
			$email = $brow['EMAIL']; 
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br />';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' send you a gift at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate </a>.<br /><br />';
			$irow = $database->get_image($actionby);
			$file = $irow['CDN'].$irow['FILENAME']; 
			$file = $file;
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$message .='<img style="border:none;" src="';
			$message .= $file; 
			$message .= '" width="40" height="40" />'; 
			$message .= '</a>';
			$message .= '<span style="margin-left:20px;">'.$gift.'</span><br /><br />';
			$message .= '<a style="text-decoration:none;" href="https://www.quipmate.com/?hl=inbox">To give </a>a return gift to ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' please click ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
				
		}
		else if($email_type == 'email_confirm')
		{
			$email = $param['email'];
			$id = $param['id'];
			$name = $param['name'];
			$subject='Quipmate - Email Account Confirmation';
			$message .= '<div style="margin:10 40 20 40;">';
			$message .= 'Hi '.$name.',<br />';
			$message .= 'Please click '; 
			$message .= "<a href='https://www.quipmate.com/email_confirm.php?id=$id&email=$email'>here</a>";
			$message .= ' to confirm this email account provided by you to Quipmate.';
			$message .= '</div>';
			$message .= '<div style="margin:20 20 20 40;">';
			$message .= 'Additionally to visit Quipmate please click '.'<a style="text-decoration:none;" href="https://www.quipmate.com/">here</a>';
			$message .= '</div>';
			$message .= '<div style="margin:20 20 20 40;">';
			$message .= 'If you have forgotten your password please click ';
			$message .= "<a href='https://www.quipmate.com/forgot_password.php?id=$id&email=$email'>here</a>";
			$message .= ' to recover it.</div>';
			$additionalHeaders .= 'From:'. $irow['NAME'].'<member@quipmate.com>';
		}
		else if($email_type == 'email_friend_request')
		{
			$email = $param['email'];
			$profileid = $param['profileid'];
			$name = $param['name'];
			$subject='Friend Requests';
			$message .= 'Hi '.$name.',<br />';
			$message .= 'The following people are now following you at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate</a>. Please follow them  by visiting your profile at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate.</a>-<br /><br />'; 
			$result = $database->friend_invite_select($profileid);
			while($row =$result->fetch_array())
			{
			 $friendid = $row['FRIENDID'];
			 $message .='<div style=""><a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			 $message .= $friendid; 
			 $message .= '">'; 
			 $irow = $database->get_image($friendid);
			 $file = $irow['CDN'].$irow['FILENAME'];
			 $file = $file;
			 $message .='<img style="border:none;" src="';
			 $message .= $file; 
			 $message .= '" width="80" height="80" />'; 
			 $message .= '</a>';
			 $message .='<div style="position:relative;top:10px;">';
			 $message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			 $message .= $friendid; 
			 $message .= '">'; 
			 $irow = $database->get_name($friendid);
			 $message .= $irow['NAME'];
			 $message .= '</a>';
			 $message .='</div>';
			 $message .='</div>';
			}
			$additionalHeaders .= 'From:'. $irow['NAME'].'<member@quipmate.com>';
		} 
		else if($email_type == 'response')
		{
			$profileid = $param['profileid'];
			$actionby = $param['actionby'];
			$actionid = $param['actionid'];
			$actiontype = $param['actiontype'];
			$subject = 'Excited at post';
			$brow = $database->bio_complete_select($profileid);
			$email = $brow['EMAIL'];
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br />';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			switch($actiontype)
			{ 
				case '11': $message .= ' says your status is exciting'; $subject= 'Your status is exciting'; break;
				case '12': $message .= ' says your profile update is exciting'; $subject= 'Your profile update is exciting'; break;
				case '15': $message .= ' says your photo is exciting'; $subject= 'Your photo is exciting'; break;
				case '17': $message .= ' says your friendhip is exciting'; $subject= 'Your friendhip is exciting'; break;
				case '511': $message .= ' says your missing by someone is exciting'; $subject= 'Your missing by someone is exciting'; break;
				case '811': $message .= ' says your tagline is exciting'; $subject= 'Your tagline is exciting'; break;
				case '1111': $message .= ' says crush at you by someone is exciting'; $subject= 'Crush at you by someone is exciting'; break;
				case '1113': $message .= ' says your crush match with someone is exciting'; $subject= 'Your crush match with someone is exciting'; break;
				case '1211': $message .= ' says your mood is exciting'; $subject= 'Your mood is exciting'; break;
				case '1411': $message .= ' says your gift is exciting'; $subject= 'Your gift is exciting'; break;
				case '1611': $message .= ' says your link is exciting'; $subject= 'Your link is exciting'; break;
				case '2011': $message .= ' says your status-song is exciting'; $subject = 'Your status-song is exciting'; break;
				case '2111': $message .= ' says your song-dedication is exciting'; $subject= 'Your song-dedication is exciting'; break;
				case '16': $message .= ' new-pinched you.'; $subject= $irow['NAME'].' new-pinched you'; break;
				default: $message .= ' says your post is exciting'; $subject= 'Your post is exciting'; break;
			}
			$message .= ' at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate </a>.<br /><br />';
			$irow = $database->get_image($actionby);
			$file = $irow['CDN'].$irow['FILENAME']; 
			$file = $file;
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$message .='<img style="border:none;" src="';
			$message .= $file; 
			$message .= '" width="80" height="80" />'; 
			$message .= '</a><br /><br /><br />';
			$message .= '<a style="text-decoration:none;" href="https://www.quipmate.com/?hl=diary">To reply </a>this response to ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' please click <a style="text-decoration:none;" href="https://www.quipmate.com/?hl=diary">here</a>.';
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
		}
		else if($email_type == 'college_connect_feature_display')
		{
			$profileid = $param['profileid'];
			$subject= 'An Initiative To Connect Colleges Across India';
			$brow = $database->bio_complete_select($profileid);
			$email = $brow['EMAIL'];
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br /><br />';
			$message .= '<a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate </a> is working at connecting people across all the colleges of India.<br />';
			$message .=' A new feature <a style="text-decoration:none;" href="https://www.quipmate.com/college_connect.php">College Connect</a> helps one send messages and and reach the emails of the people from these colleges.';
			$message .= 'You can reach these colleges by visiting <a style="text-decoration:none;"  href="https://www.quipmate.com/college_connect.php">College Connect</a> at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate </a>';
			$additionalHeaders .= 'From:College Connect<admin@quipmate.com>';
		}
		else if($email_type == 'college_connect')
		{ 
			$profileid = $param['profileid'];
			$subject= 'An Initiative To Connect Colleges Across India';
			$brow = $database->bio_complete_select($profileid);
			$email = $brow['EMAIL'];
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br /><br />';
			$message .= '<a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate </a> is working at connecting people across all the colleges of India.<br />';
			$message .=' A new feature <a style="text-decoration:none;" href="https://www.quipmate.com/college_connect.php">College Connect</a> helps one send messages and and reach the emails of the people from these colleges.';
			$message .= 'You have not provided your college information. Please do so by visiting <a style="text-decoration:none;" href="https://www.quipmate.com/profileedit.php?t=edu">Edit Profile </a>at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate </a>';
			$additionalHeaders .= 'From:College Connect<admin@quipmate.com>';
		}
		else if($email_type == 'comment')
		{
			$profileid = $param['profileid']; 
			$actionby = $param['actionby']; 
			$actionid = $param['actionid']; 
			$comment = $param['comment']; 
			$actiontype = $param['actiontype'];
			$subject= $comment;
			$brow = $database->bio_complete_select($profileid);
			$email = $brow['EMAIL'];
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br />';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' commented at your ';
			switch($actiontype)
			{
				case '2': $message .= 'post'; break; 
				case '4': $message .= 'opinion'; break;
				case '23': $message .= 'special moment'; break;
				case '24': $message .= 'photo'; break;
				case '25': $message .= 'new profile photo'; break;
				case '26': $message .= 'friendship'; break;
				case '503': $message .= 'Missing by Someone'; break;
				case '802': $message .= 'tagline'; break;
				case '1103': $message .= 'Crush by someone'; break;
				case '1104': $message .= 'Crush Match with someone'; break;
				case '1202': $message .= 'mood'; break;
				case '1402': $message .= 'gift'; break;
				case '1602': $message .= 'link'; break;
				case '2002': $message .= 'status-song'; break;
				case '2102': $message .= 'dedicated song';
			}
			$message .= ' at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate </a>.<br /><br />';
			$irow = $database->get_image($actionby);
			$file = $irow['CDN'].$irow['FILENAME']; 
			$file = $file;
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$message .='<img style="border:none;" src="';
			$message .= $file; 
			$message .= '" width="40" height="40" />'; 
			$message .= '</a>';
			$message .= '<span style="margin-left:20px;">'.$comment.'</span><br /><br />';
			$message .= '<a style="text-decoration:none;" href="https://www.quipmate.com/?hl=diary">To reply </a>this comment to ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' please click <a style="text-decoration:none;" href="https://www.quipmate.com/?hl=diary">here</a>.';
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
		}
		else if($email_type == 'message')
		{ 
			$profileid = $param['profileid'];
			$actionby = $param['actionby'];
			$mess = $param['message'];
			$subject= $mess;
			$brow = $database->bio_complete_select($profileid);
			$email = $brow['EMAIL'];
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br />';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' sent you a message at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate </a>.<br /><br />';
			$irow = $database->get_image($actionby);
			$file = $irow['CDN'].$irow['FILENAME']; 
			$file = $file;
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$message .='<img style="border:none;" src="';
			$message .= $file; 
			$message .= '" width="40" height="40" />'; 
			$message .= '</a>';
			$message .= '<span style="margin-left:20px;">'.$mess.'</span><br /><br />';
			$message .= '<a style="text-decoration:none;" href="https://www.quipmate.com/?hl=inbox">To reply </a>this message to ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' please click <a style="text-decoration:none;" href="https://www.quipmate.com/?hl=inbox">here</a>.';
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
		}
		else if($email_type == 'missu_return')
		{ 
			$profileid = $param['profileid'];
			$actionby = $param['actionby']; 
			$actionid = $param['actionid']; 
			$subject = 'Miss back';
			$brow = $database->bio_complete_select($profileid);
			$email = $brow['EMAIL'];
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br /><br />';
			$message .='<div style=""><a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_image($actionby);
			$file = $irow['CDN'].$irow['FILENAME'];
			$file = $file;
			$message .='<img style="border:none;" src="';
			$message .= $file; 
			$message .= '" width="80" height="80" />'; 
			$message .= '</a>';
			$message .='<div style="position:relative;top:10px;">';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$subject='Miss U Return by '.$irow['NAME'];
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .='</div>'; 
			$message .='</div>';
			$message .= ' Missed U back in response to your Miss U at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate</a>.';
			$message .= ' <br /><br />To respond to <a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' please visit the profile at ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$message .= $irow['NAME'];
			$message .= '</a>';
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
		}
		else if($email_type == 'missu')
		{		
			$profileid = $param['profileid'];
			$actionby = $param['actionby']; 
			$actionid = $param['actionid']; 
			$subject .= 'Miss U';
			$brow = $database->bio_complete_select($profileid);
			$email = $brow['EMAIL'];
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br /><br />';
			$message .='<div style=""><a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_image($actionby);
			$file = $irow['CDN'].$irow['FILENAME'];
			$file = $file;
			$message .='<img style="border:none;" src="';
			$message .= $file; 
			$message .= '" width="80" height="80" />'; 
			$message .= '</a>';
			$message .='<div style="position:relative;top:10px;">';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$subject='Miss U by '.$irow['NAME'];
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .='</div>'; 
			$message .='</div>';
			$message .= ' is missing you at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate</a>.';
			$message .= ' <br /><br />To respond to <a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' please visit the profile at ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' and click <a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$message .= 'Miss Back';
			$message .= '</a>.';
			$message .= ' Otherwise ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' will keep missing you.';
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
		}
		else if($email_type == 'profile_post')
		{ 
			$profileid = $param['profileid'];
			$actionby = $param['actionby'];
			$actionid = $param['actionid'];
			$post = $param['page'];
			$subject= $post;
			$brow = $database->bio_complete_select($profileid);
			$email = $brow['EMAIL'];
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br /><br />';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' posted in your diary at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate </a>.<br /><br />';
			$irow = $database->get_image($actionby);
			$file = $irow['CDN'].$irow['FILENAME']; 
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$message .='<img style="border:none;" src="';
			$message .= $file; 
			$message .= '" width="40" height="40" />'; 
			$message .= '</a>';
			$message .= '<span style="margin-left:20px;"><pre>'.$post.'</pre></span><br /><br />';
			$message .= '<a style="text-decoration:none;" href="https://www.quipmate.com/?hl=diary">To reply </a>this post to ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' please click <a style="text-decoration:none;" href="https://www.quipmate.com/?hl=diary">here</a>.';
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
		}
		else if($email_type == 'friend_request')
		{		
			$profileid = $param['profileid'];
			$friendid = $param['friendid'];
			$subject .= 'You have new follower ';
			$brow = $database->bio_complete_select($profileid);
			$email = $brow['EMAIL'];
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br /><br />';
			$message .='<div style=""><a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $friendid; 
			$message .= '">'; 
			$irow = $database->get_image($friendid);
			$file = $irow['CDN'].$irow['FILENAME'];
			$file = $file;
			$message .='<img style="border:none;" src="';
			$message .= $file; 
			$message .= '" width="80" height="80" />'; 
			$message .= '</a>';
			$message .='<div style="position:relative;top:10px;">';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $friendid; 
			$message .= '">'; 
			$irow = $database->get_name($friendid);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .='</div>'; 
			$message .='</div>';
			$message .= ' is now following you at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate</a>.';
			$message .= ' <br /><br />Please follow  <a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $friendid; 
			$message .= '">'; 
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' by visiting your profile at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate.</a><br /><br />';
			$message .= ' <br />To learn about ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $friendid; 
			$message .= '">'; 
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' please visit the profile at <a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $friendid; 
			$message .= '">'; 
			$message .= $irow['NAME'];
			$message .= '</a>';
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
		}
		else if($email_type == 'friend_request_broadcast')
		{
			$profileid = $param['profileid'];
			$email = $param['email'];
			$name = $param['name'];
			$subject='Friend Requests';
			$message .= 'Hi '.$name.',<br />';
			$message .= 'The following people are now following you at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate</a>. Please follow them as by visiting your profile at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate.</a>-<br /><br />'; 
			global $database;
			$result = $database->friend_invite_select($profileid);
			while($row =$result->fetch_array())
			{
				$friendid = $row['FRIENDID'];
				$message .='<div style=""><a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
				$message .= $friendid; 
				$message .= '">'; 
				$irow = $database->get_image($friendid);
				$file = $irow['CDN'].$irow['FILENAME'];
				$file = $file;
				$message .='<img style="border:none;" src="';
				$message .= $file; 
				$message .= '" width="80" height="80" />'; 
				$message .= '</a>';
				$message .='<div style="position:relative;top:10px;">';
				$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
				$message .= $friendid; 
				$message .= '">'; 
				$irow = $database->get_name($friendid);
				$message .= $irow['NAME'];
				$message .= '</a>';
				$message .='</div>';
				$message .='</div>';
			} 
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
		}      
		else if($email_type == 'sample_friend_request_email')
		{
			$email = $param['email']; 
			$profileid = $param['profileid'];
			$name = $param['name'];
			$subject='Friend Requests';
			$message .= 'Hi '.$name.',<br />';
			$message .= 'The following people are now following you at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate</a>. Please follow them by visiting your profile at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate.</a>-<br /><br />'; 
			global $database;
			$result = $database->friend_invite_select($profileid);
			while($row =$result->fetch_array())
			{
				$friendid = $row['FRIENDID'];
				$message .='<div style=""><a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
				$message .= $friendid; 
				$message .= '">'; 
				$irow = $database->get_image($friendid);
				$file = $irow['CDN'].$irow['FILENAME'];
				$file = $file;
				$message .='<img style="border:none;" src="';
				$message .= $file; 
				$message .= '" width="80" height="80" />'; 
				$message .= '</a>';
				$message .='<div style="position:relative;top:10px;">';
				$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
				$message .= $friendid; 
				$message .= '">'; 
				$irow = $database->get_name($friendid);
				$message .= $irow['NAME'];
				$message .= '</a>';
				$message .='</div>';
				$message .='</div>';
				$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>\r\n';
			}
		}
		else if ($email_type == 'praised')
		{
			$profileid = $param['profileid'];
			$actionby = $param['actionby']; 
			$actionid = $param['actionid']; 
			$brow = $database->bio_complete_select($profileid);
			$email = $brow['EMAIL'];
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br /><br />';
			$message .='<div style=""><a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_image($actionby);
			$file = $irow['CDN'].$irow['FILENAME'];
			$file = $file;
			$message .='<img style="border:none;" src="';
			$message .= $file; 
			$message .= '" width="80" height="80" />'; 
			$message .= '</a>';
			$message .='<div style="position:relative;top:10px;">';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$subject='Praised by '.$irow['NAME'];
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .='</div>'; 
			$message .='</div>';
			$message .= ' has praised you at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate</a>.';
			$message .= ' <br /><br />To respond to <a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' please visit the profile at ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$message .= $irow['NAME'];
			$message .= '</a>';
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
		}
		else if ($email_type == 'direct_letter')
		{
			$profileid = $param['profileid'];
			$actionby = $param['actionby'];
			$actionid = $param['actionid'];
			$direct_letter = $param['direct_letter'];
			$subject = $direct_letter.' Sent you a direct letter at Quipmate';
			$brow = $database->bio_complete_select($profileid);
			$email = $brow['EMAIL']; 
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br />';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' sent you a direct letter at <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate </a>.<br /><br />';
			// $irow = $database->get_image($actionby);
			$file = $irow['CDN'].$irow['FILENAME']; 
			$file = $file;
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$message .='<img style="border:none;" src="';
			$message .= $file; 
			$message .= '" width="40" height="40" />'; 
			$message .= '</a>';
			$message .= '<span style="margin-left:20px;">'.$gift.'</span><br /><br />';
			$message .= '<a style="text-decoration:none;" href="https://www.quipmate.com/?hl=inbox">To give </a>a return gift to ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' please click ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
		}
		else if($email_type == 'Answered_Question')
		{
			$profileid = $param['profileid']; 
			$actionby = $param['actionby']; 
			//$actionid = $param['actionid']; 
			//$comment = $param['comment']; 
			//$actiontype = $param['actiontype'];
			//$subject= $comment;
			$brow = $database->bio_complete_select($profileid);
			$email = $brow['EMAIL'];
			$name = $brow['NAME'];
			$message .= 'Hi ';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $profileid; 
			$message .= '">'; 
			$message .= $name.'</a>,<br />';
			$message .='<a style="text-decoration:none;" href="https://www.quipmate.com/profile.php?id=';
			$message .= $actionby; 
			$message .= '">'; 
			$irow = $database->get_name($actionby);
			$message .= $irow['NAME'];
			$message .= '</a>';
			$message .= ' has answered your question ';
			$additionalHeaders .= 'From:'.$irow['NAME'].'<member@quipmate.com>';
		}
		else if($email_type == 'password_recover')
	    {
			$email = $param['email'];
			$id = $param['uniqueid'];
			$subject='Recover Your Password';
			$message .= 'Hi,<br /><br />';
			$message .= 'Please click the following link to recover your password'."\n\n<br/>";
			$message .= '<a style="text-decoration:none;" href=';
			$message .= "https://www.quipmate.com/welcome.php?click=recover_password&id=$id&email=$email";
			$message .= '>Recover Password</a>';
			$message .= '<div>or copy & paste this link in your browser address bar'."\n\n<br/>";
			$message .= "https://www.quipmate.com/welcome.php?click=recover_password&id=$id&email=$email</div>";
			$message .= '<br /><div>If you didn\'t initiate the password recovery process, please ignore this email.</div>';
			$additionalHeaders .= 'From: "Quipmate"<share@quipmate.com>';
		}
		$mes .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
		$mes .= '<html xmlns="https://www.w3.org/1999/xhtml">';
		$mes .= '<head>';
		$mes .= '<meta https-equiv="Content-Type" content="text/html; charset=utf-8" />';
		$mes .= '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
		$mes .= '<style  type="text/css">
 pre{
 white-space: pre-wrap;       /* css-3 */
 white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
 white-space: -pre-wrap;      /* Opera 4-6 */
 white-space: -o-pre-wrap;    /* Opera 7 */
 word-wrap: break-word;       /* Internet Explorer 5.5+ */
 display:inline;
 border:none;margin:0;padding:0;background:none !important;
 font-family: "Helvetica Neue",Helvetica,Arial,sans-serif !important;
}
#outlook a { padding: 0; }
body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
.ExternalClass {width:100%;}
.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
a img {border:none;}
.image_fix {display:block;}
p {margin: 1em 0;}
h1, h2, h3, h4, h5, h6 {color: black !important;}
h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}
h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
color: red !important; }
h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
color: purple !important; }
table td {border-collapse: collapse;}
a {color: #336699;}
@media only screen and (max-device-width: 480px) {
			a[href^="tel"], a[href^="sms"] {
						text-decoration: none;
						color: black;
						pointer-events: none;
						cursor: default;
					}
			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
						text-decoration: default;
						color: #336699 !important;
						pointer-events: auto;
						cursor: default;
					}
		}
@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
			a[href^="tel"], a[href^="sms"] {
						text-decoration: none;
						color: blue;
						pointer-events: none;
						cursor: default;
					}
			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
						text-decoration: default;
						color: #336699 !important;
						pointer-events: auto;
						cursor: default;
					}
		}

		@media only screen and (-webkit-min-device-pixel-ratio: 2) {
		}
		/* Following Android targeting from:
		https://developer.android.com/guide/webapps/targeting.html
		https://pugetworks.com/2011/04/css-media-queries-for-targeting-different-mobile-devices/  */
		@media only screen and (-webkit-device-pixel-ratio:.75){
			/* Put CSS for low density (ldpi) Android layouts in here */
		}
		@media only screen and (-webkit-device-pixel-ratio:1){
			/* Put CSS for medium density (mdpi) Android layouts in here */
		}
		@media only screen and (-webkit-device-pixel-ratio:1.5){
			/* Put CSS for high density (hdpi) Android layouts in here */
		}
</style>';
		$mes .= '<title>';
		if(strlen($subject)>50)
		{
			$subject = substr($subject,0,49).'...';
		}
		$mes .= $subject;
		$mes .= '</title>';
		$mes .= '</head>';
		$mes .= '<body>';
		$mes .= '<table width="100%" style="width:100%;padding:15px 15px 5px 40px;background:#f5f5f5;text-align:left" border="0" cellspacing="0" cellpadding="0" id="backgroundTable">';
		$mes .= '<tbody><tr style="text-align:right;">';
		$mes .= '<td><a href="https://www.quipmate.com/"><img style="border:none;" src="https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com/quipmate-logo.png" alt="Quipmate" /></a></td></tr><tr><td>';
		$mes .= $message;
		$mes .= '</td></tr><tr><td style="padding:20px 0px 20px 0px;">';
		$mes .= 'Happy Quipping'.'<br />'.'Thank You'.'<br />'.'<a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate</a>';
		$mes .= '</td></tr>'; 
		$mes .= '<tr><td style="height:25px;text-align:right;border-top:1px dashed #cccccc;"><a style="text-decoration:none;font-size:11px;" href="https://www.quipmate.com/settings.php?hl=email_settings">Email Settings</a>&middot;<a style="text-decoration:none;font-size:11px;" href="https://www.quipmate.com/settings.php?hl=notification_settings">Notification Settings</a></td></tr>';
		$mes .= '</tbody></table></body>';
		$mes .= '</html>';
		if($email_type == 'page_post')
		{
			return $database->broadcast_email_insert($subject,$mes,$additionalHeaders);	
		}
        else
        {
            
            return $database->email_insert($email,$subject,$mes,$additionalHeaders);
        }
		
	}
}
?>