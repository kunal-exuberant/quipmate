<?php 
//require_once($_SERVER['DOCUMENT_ROOT'].'/../common/secret.php');
class Database 
{
	public $con = '';
	function __construct()
	{ 
	  global $DB_IP;
	  global $DB_USER;
	  global $DB_PASSWORD;
	  global $DB_NAME;
	  if(isset($_SESSION['database']))
	  {
		  $db_name = $_SESSION['database'];
	  }
	  else
	  {
		  $db_name = 'mysql';
	  }
	  $this->con = new mysqli('localhost', 'root', 'Quip4mate$@@OwesomE', $db_name);
	}
	
	function __destruct()
	{
	    $this->con->close();
	}
	
	function get_globalid()
	{
		$query = "REPLACE INTO globalid (stub) VALUES ('a');";
		$query .="SELECT LAST_INSERT_ID() as id ";
		$this->con->multi_query($query);
		$this->con->next_result();
		$res1 =$this->con->store_result();
		$fn =  $res1->fetch_row();
		return $fn[0];
	} 
	function get_database_list()
	{
	 return $this->con->query("show databases");
	}
	function user_delete($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$this->con->query("DELETE FROM `signup` Where USERID ='$profileid' ");
		$this->con->query("DELETE FROM `action` Where ACTIONBY ='$profileid' OR PROFILEID ='$profileid'");
		$this->con->query("DELETE FROM `notice` Where ACTIONBY ='$profileid' OR PROFILEID ='$profileid'");
		$this->con->query("DELETE FROM `subscribe` Where FRIENDID ='$profileid' OR PROFILEID ='$profileid'");
		$result=$this->con->query("DELETE FROM `inbox` Where Where ACTIONBY ='$profileid' OR ACTIONON ='$profileid'");
		return $result;
	}
	function photo_friend_select($profileid,$limit,$count)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$limit = $this->con->real_escape_string($limit);
		$count = $this->con->real_escape_string($count);
		$result= $this->con->query("SELECT IMAGEID,CDN,FILENAME,image.PROFILEID as PROFILEID,ACTIONBY FROM image INNER JOIN friend ON image.ACTIONBY=friend.FRIENDID OR image.PROFILEID = friend.FRIENDID WHERE friend.PROFILEID='$profileid' ORDER BY IMAGEID DESC LIMIT $limit,$count");
		return $result; 
	}
	function page_view_insert($actionby,$profileid,$referer,$page,$time)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$actionby = $this->con->real_escape_string($actionby);
		$referer = $this->con->real_escape_string($referer);
		$page = $this->con->real_escape_string($page);
		$time = $this->con->real_escape_string($time);
		return $this->con->query("INSERT INTO `page_view`(`actionby`, `profileid`, `referer`, `page`, `time`) VALUES ('$actionby','$profileid','$referer','$page','$time')");
	}
	
	function get_event_members($eventid)
	{ 
		$eventid = $this->con->real_escape_string($eventid); 
		return $this->con->query("SELECT gp.profileid AS PROFILEID FROM guest AS gp INNER JOIN setting_email AS sm ON gp.profileid = sm.profileid AND sm.event_post =1 WHERE gp.eventid ='$eventid'");
	}
	
	function top_influencer_select($groupid)
	{
		$eventid = $this->con->real_escape_string($eventid); 
		return $this->con->query("select actionby as profileid,count(*) as count from action where profileid ='$groupid' group by profileid,actionby order by count desc limit 5");
	}
	
	function photo_json($profileid,$limit,$count)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$limit = $this->con->real_escape_string($limit);
		$count = $this->con->real_escape_string($count);
		$result= $this->con->query("SELECT DISTINCT IMAGEID,CDN,FILENAME,image.PROFILEID as PROFILEID,ACTIONBY FROM image WHERE PROFILEID='$profileid' ORDER BY IMAGEID DESC LIMIT $limit,$count");
		return $result; 
	}
	
	function bio_field_match($field,$profileid1, $profileid2)
	{
		$profileid1 = $this->con->real_escape_string($profileid1);
		$profileid2 = $this->con->real_escape_string($profileid2);
		$field = $this->con->real_escape_string($field);
		$bio1 = $this->bio_singlefield_select($field,$profileid1);
		$bio2 = $this->bio_singlefield_select($field,$profileid2);
		//require_once  "diary_info.php";
		if(!is_null($bio1))
		{
			if(trim($bio1) != "")
			{
				$info1 = splitcolon($bio1);
			}
			else 
				return "none";
		}
		else		
		{
			return "none";
		}
		
		if(!is_null($bio2))
		{
			if(trim($bio2) != "")
			{
				$info2 = splitcolon($bio2);
			}
			else 
				return "none";
		}
		else		
		{
			return "none";
		}
		$len1 = count($info1);
		$len2 = count($info2);
		$i1 = 0;
		$i2 = 0;

		$common = "";
		if($len1 <= $len2)
		{
			$j = $len1;
			$k = $len2;
			while($i1 < $j)
			{
				$item = $info1[$i1];
				$i2 = 0;
				while($i2 < $k)
				{
					if(trim($item) == trim($info2[$i2]))
					{
						if(trim($common) != "")
						{
							$common = $common.":".trim($item);
						}
						else
						{
							$common = trim($item);
						}	
					}
					$i2++;
				}
				$i1++;
			}
		}
		else 
		{
			$j = $len2;
			$k = $len1;
			while($i1 < $j)
			{
				$item = $info2[$i1];
				$i2 = 0;
				while($i2 < $k)
				{
					if(trim($item) == trim($info1[$i2]))
					{
						if(trim($common) != "")
						{
							$common = $common.":".trim($item);
						}
						else
						{
							$common = trim($item);
						}	
					}
					$i2++;
				}
				$i1++;
			}
		}
		
		if(trim($common) != "")
			return $common;
		else
			return "none";
	}
	function bio_singlefield_select($field,$profileid)  //for all.
	{
		$profileid = $this->con->real_escape_string($profileid);
		$field =  $this->con->real_escape_string($field);
		$result = $this->con->query("SELECT `$field` FROM bio_history WHERE PROFILEID = '$profileid' order by actionid desc limit 1");
		$res = $result->fetch_array();
		return $res[$field];
	}
	
	function invite_insert($virtualid,$profileid)
	{
		$virtualid = $this->con->real_escape_string($virtualid);
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("INSERT INTO invite(VIRTUALID,ACTIONBY) VALUES('$virtualid','$profileid') ");
		return $result; 
	}
	
	function invite_select($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("SELECT * FROM invite WHERE VIRTUALID = '$profileid' "); 
		return $result->fetch_array();
	}
	
	function inviter_select($virtualid)
	{
		$virtualid = $this->con->real_escape_string($virtualid);
		$result = $this->con->query("SELECT * FROM invite WHERE VIRTUALID = '$virtualid' ");
		return $result;
	}
	
	function virtual_to_real($email,$myprofileid)
	{
		$email = $this->con->real_escape_string($email);
		$myprofileid = $this->con->real_escape_string($myprofileid);
		$result = $this->con->query("update action set PROFILEID='$myprofileid',ACTIONTYPE='1101' where PROFILEID in(select VIRTUALID from virtual where EMAIL='$email') and ACTIONTYPE='1151' ");
		$result = $this->con->query("update notice set PROFILEID='$myprofileid',ACTIONTYPE='1101' where PROFILEID in(select VIRTUALID from virtual where EMAIL='$email') and ACTIONTYPE='1151' ");
		return $result; 
	}
	
	function virtual_delete($email)
	{
		$email = $this->con->real_escape_string($email);
		$result = $this->con->query("delete from virtual where EMAIL='$email' ");
		return $result; 
	}
	
	
	function virtual_select($email,$identifier)
	{
		$email = $this->con->real_escape_string($email);
		$identifier = $this->con->real_escape_string($identifier);
		$result = $this->con->query("SELECT * from virtual WHERE EMAIL = '$email' AND UNIQUEID = '$identifier' ");
		return $result->fetch_array();
	}
	
	function v_select($virtualid)
	{
		$virtualid = $this->con->real_escape_string($virtualid);
		$result = $this->con->query("SELECT * from virtual WHERE VIRTUALID = '$virtualid' ");
		return $result->fetch_array();
	}
	
	function virtual_create($email)
	{
		$email = $this->con->real_escape_string($email);
		$uniqueid = sha1($email.'pass1reset!');
		$result = $this->con->query("INSERT INTO virtual(EMAIL,UNIQUEID) VALUES('$email','$uniqueid') ");
		if($result)
		{
			$res = $this->con->query("SELECT VIRTUALID from virtual WHERE EMAIL = '$email' ");
			$row =  $res->fetch_array();
			return $row['VIRTUALID']; 
		}	
	}
	
	function message_order($profileid)
	{    
	     $profileid = $this->con->real_escape_string($profileid);
		 return $this->con->query("select ACTIONBY, ACTIONON from inbox where ACTIONON > '999999999' and (ACTIONBY = '$profileid' OR ACTIONON = '$profileid') order by ACTIONID desc");
	}
	
	function message_order_inbox($profileid)
	{    
	     $profileid = $this->con->real_escape_string($profileid);
		 return $this->con->query("select ACTIONBY, ACTIONON, MESSAGE from inbox where ACTIONBY = '$profileid' OR ACTIONON = '$profileid' order by ACTIONID desc");
	}
	function get_last_message_exchanged($profileid)
	{    
	     $profileid = $this->con->real_escape_string($profileid);
		 return $this->con->query("SELECT A.* FROM inbox AS A JOIN (SELECT MAX(B.ACTIONID) AS ACTIONID FROM(SELECT ACTIONID,
									CASE ACTIONBY WHEN $profileid THEN ACTIONBY ELSE ACTIONON END AS ACTIONBY,
									CASE ACTIONON WHEN $profileid THEN ACTIONBY ELSE ACTIONON END AS ACTIONON
									FROM inbox WHERE ACTIONON > '999999999' AND (ACTIONBY =$profileid OR ACTIONON =$profileid)) AS B
									GROUP BY B.ACTIONBY,B.ACTIONON ) AS C ON A.ACTIONID= C.ACTIONID ORDER BY A.ACTIONID DESC");
	}
	
	function update_message_readbit($profileid,$college)
	{
	      $profileid = $this->con->real_escape_string($profileid);
		  $college = $this->con->real_escape_string($college);
		  $result = $this->con->query("update notice set READBIT='1' where ( PROFILEID='$profileid' or PROFILEID='$college') AND ACTIONTYPE IN('401','1101','1105') AND ACTIONBY !='$profileid' AND READBIT='0' ");
	}
	function inbox_update_readbit($profileid)
	{
		  $profileid = $this->con->real_escape_string($profileid);
		  $result = $this->con->query("update inbox set READBIT='1' where ACTIONON ='$profileid' AND READBIT='0' ");
	}
	function reply_select($actionid)
	{
	    $actionid = $this->con->real_escape_string($actionid);
		$result = $this->con->query("select * from inbox INNER JOIN action on inbox.ACTIONID = action.ACTIONID where action.ACTIONID > '$actionid' and action.PAGEID='$actionid' ORDER BY action.ACTIONID ");
		return $result;
	}
	function message_insert($actionid, $actionby, $actionon, $message, $time)
	{    
	     $actionid = $this->con->real_escape_string($actionid);
		 $actionby = $this->con->real_escape_string($actionby);
	     $actionon = $this->con->real_escape_string($actionon);
		 $message = $this->con->real_escape_string($message);
		 $time = $this->con->real_escape_string($time);
		 $result =$this->con->query("insert into inbox(ACTIONID, ACTIONBY, ACTIONON, MESSAGE, TIME) values('$actionid', '$actionby', '$actionon', '$message', '$time') ");
		 return $result;
	}
	function unread_message_select($profileid,$college)
	{
	      $profileid = $this->con->real_escape_string($profileid);
		  $college = $this->con->real_escape_string($college);
		  $result = $this->con->query("select COUNT(*) from notice where ( PROFILEID='$profileid' or PROFILEID='$college') AND ACTIONTYPE IN('401','1101','1105') AND ACTIONBY !='$profileid' AND READBIT='0' ");
		  $res = $result->fetch_array();
		  return $res['COUNT(*)'];
	}
	
	function inbox_mutual_select($myprofileid,$profileid,$start)
	{    
	    $myprofileid = $this->con->real_escape_string($myprofileid);
		$profileid = $this->con->real_escape_string($profileid);
		$start = $this->con->real_escape_string($start);
		return $this->con->query("select * from inbox where (ACTIONBY = '$profileid' AND ACTIONON = '$myprofileid') OR (ACTIONBY = '$myprofileid' AND ACTIONON = '$profileid') AND CASE WHEN ACTIONBY = '$myprofileid' THEN flag_by ELSE flag_on END  ='1' order by ACTIONID desc LIMIT $start,20");
	}
	
	function inbox_select($profileid,$college,$start)
	{    
	    $profileid = $this->con->real_escape_string($profileid);
		$start = $this->con->real_escape_string($start);
		$college = $this->con->real_escape_string($college);
		return $this->con->query("select * from inbox where ACTIONBY = '$profileid' OR ACTIONON = '$profileid' OR ACTIONON = '$college' order by ACTIONID desc LIMIT $start,20");
	}
	
	function crushlist_select($email)
	{
		$email = $this->con->real_escape_string($email);
		$result = $this->con->query("select * from crush where EMAILBY = '$email' ");
		return $result;
	}
	
	function crushmatch_select($email)
	{
		$email = $this->con->real_escape_string($email);
		$result = $this->con->query("select * from crush where EMAILBY = '$email' || EMAILTO = '$email' ");
		return $result;
	}
	
	function crush_select($email,$actionid,$uniqueid)
	{
		$email = $this->con->real_escape_string($email);
		$actionid = $this->con->real_escape_string($actionid);
		$uniqueid = $this->con->real_escape_string($uniqueid);
		$result = $this->con->query("select * from crush where ACTIONID='$actionid' AND UNIQUEID ='$uniqueid' AND EMAILTO = '$email' ");
		if($result->num_rows)
		{
		    $row = $result->fetch_array();
			if($row['EMAILBY']==$myemail)
			{
				$data = array();
				$data['status'] = $row['STATUS'];
				$data['crushby'] = $row['EMAILBY'];
				$data['crushat'] = $row['EMAILTO'];
			    return $data;
			}
		}
		else
		{
		    return -1;
		}
	}
	
	function crush_status($email,$myemail)
	{
		$email = $this->con->real_escape_string($email);
		$myemail = $this->con->real_escape_string($myemail);
		$result = $this->con->query("select * from crush where (EMAILBY = '$myemail' AND EMAILTO='$email') OR (EMAILBY ='$email' AND EMAILTO='$myemail')");
		if($result->num_rows)
		{
		    $row = $result->fetch_array();
			if($row['EMAILTO']==$myemail)
			{
				$data = array();
				$data['status'] = $row['STATUS'];
				$data['actionid'] = $row['ACTIONID'];
				$data['crushby'] = $row['EMAILBY'];
				$data['crushat'] = $row['EMAILTO'];
			    return $data;
			}
		}
		else
		{
		    return -1;
		}
	}
	
	function crush_insert($actionid,$email,$myemail)
	{
		$email = $this->con->real_escape_string($email);
		$myemail = $this->con->real_escape_string($myemail);
		$uniqueid = sha1($email.$myemail);
		$result = $this->con->query("insert into crush(ACTIONID,EMAILTO,EMAILBY,UNIQUEID) VALUES('$actionid','$email','$myemail','$uniqueid')");
		return $result;
	}
	
	function crush_update($email1,$email2,$status)
	{
		$email1 = $this->con->real_escape_string($email1);
		$email2 = $this->con->real_escape_string($email2);
		$status = $this->con->real_escape_string($status);
		$result = $this->con->query("update crush set STATUS = '$status' where EMAILTO = '$email1' AND EMAILBY ='$email2' ");
		return $result;
	}
	
	function event_exists($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT * FROM `event` WHERE eventid='$profileid'");
		$row = $result->fetch_array();
		$profileid = $row['eventid'];
		if($profileid)
		{
            return $profileid;	
		}
	}
	
	function event_select($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT * FROM `event` WHERE eventid='$profileid'");
		return $result->fetch_array();
	}
	function event_active_select($profileid,$time)
	{
		$time = $this->con->real_escape_string($time);
		$profileid = $this->con->real_escape_string($profileid);
		$v_date = date('Y-m-d H:i:s',$time);	
		$result=$this->con->query("SELECT * FROM `event` WHERE eventid='$profileid' and cancel='0' and CONCAT(`date`,' ',`timing`) >= '$v_date'");
		return $result->fetch_array();
	}
	function myevent_select($profileid,$time)
	{
		$time = $this->con->real_escape_string($time);
		$profileid = $this->con->real_escape_string($profileid);
		$v_date = date('Y-m-d H:i:s',$time);	
		$result=$this->con->query("SELECT e.eventid as eventid,e.name as name FROM `event` as e inner join guest as g on e.eventid = g.eventid	Where g.profileid = '$profileid' and e.cancel='0' and g.priviledge <>'2' and CONCAT(e.`date`,' ',e.`timing`) >= '$v_date' order by e.eventid desc" );
		return $result;		
	}
	
	function event_cancel($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		return $this->con->query("update `event` set cancel='1' WHERE eventid='$profileid'");
	}
	
	function group_exists($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT groupid FROM `group` WHERE groupid='$profileid'");
		$row = $result->fetch_array();
		$profileid = $row['groupid'];
		if($profileid)
		{
            return $profileid;	
		}
	}
	function group_name_exists($groupname)
	{
		$groupname = $this->con->real_escape_string($groupname);
		$result=$this->con->query("SELECT groupid FROM `group` WHERE name='$groupname'");
		$row = $result->fetch_array();
		$groupid = $row['groupid'];
		if($groupid)
		{
            return $groupid;	
		}
	}
	function page_exists($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT * FROM `page` WHERE pageid='$profileid'");
		$row = $result->fetch_array();
		return $row;
	}
	
	function group_select($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT * FROM `group` WHERE groupid='$profileid'");
		return $result->fetch_array();
	}
	function page_select($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT * FROM `page` WHERE pageid='$profileid'");
		return $result->fetch_array();
	}
	function page_select_all()
	{
		//$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT * FROM `page` ");
		return $result;
	}
	function member_insert($actionid, $groupid, $profileid, $priviledge)
	{	
		$actionid = $this->con->real_escape_string($actionid);
		$groupid = $this->con->real_escape_string($groupid);
		$profileid = $this->con->real_escape_string($profileid);
		$priviledge = $this->con->real_escape_string($priviledge);		
		$result= $this->con->query("insert into member(actionid, groupid, profileid, priviledge) values('$actionid','$groupid', '$profileid','$priviledge')");
		return $this->con->query("insert into subscribe(profileid,friendid) values('$profileid','$groupid')");
	}
	function subscriber_insert($actionid, $pageid, $profileid2, $priviledge)
	{	
		$actionid = $this->con->real_escape_string($actionid);
		$pageid = $this->con->real_escape_string($pageid);
		$profileid2 = $this->con->real_escape_string($profileid2);
		$priviledge = $this->con->real_escape_string($priviledge);		
		$result= $this->con->query("insert into `subscriber`(actionid,pageid,priviledge,profileid) select '$actionid','$pageid','0',USERID from `signup` ");
		$result= $this->con->query("insert into `subscribe`(friendid,profileid) select '$pageid',USERID from `signup` ");
		$result= $this->con->query("update `subscriber` SET priviledge= '$priviledge' Where pageid ='$pageid' and profileid IN(select profileid from `moderator`)");
		return $result;
	}
	
	function guest_insert($actionid, $profileid1, $profileid2, $priviledge)
	{	
		$actionid = $this->con->real_escape_string($actionid);
		$profileid1 = $this->con->real_escape_string($profileid1);
		$profileid2 = $this->con->real_escape_string($profileid2);
		$priviledge = $this->con->real_escape_string($priviledge);		
		$result = $this->con->query("insert into guest(actionid, eventid, profileid, priviledge) values('$actionid','$profileid1', '$profileid2','$priviledge')");
		return $this->con->query("insert into subscribe(profileid,friendid) values('$profileid2','$profileid1')");
	}
	
	function guest_count($eventid)
	{
		$eventid = $this->con->real_escape_string($eventid);
		$result=$this->con->query("SELECT COUNT(*) FROM guest WHERE eventid = '$eventid'");
		$res =  $result->fetch_array();
		return $res['COUNT(*)'];
	}
	
	function guest_delete($profileid1, $profileid2)
	{	
		$profileid1 = $this->con->real_escape_string($profileid1);
		$profileid2 = $this->con->real_escape_string($profileid2);		
		$result = $this->con->query("delete FROM guest WHERE profileid = '$profileid2' and eventid = '$profileid1' ");
		return $this->con->query("delete FROM subscribe WHERE profileid = '$profileid2' and friendid = '$profileid1' ");
		
	}
	
	function member_count($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT COUNT(*) FROM member WHERE groupid = '$profileid'");
		$res =  $result->fetch_array();
		return $res['COUNT(*)'];
	}
	function follower_count($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT COUNT(*) FROM subscriber WHERE pageid = '$profileid'");
		$res =  $result->fetch_array();
		return $res['COUNT(*)'];
	}
	
	function member_delete($profileid1,$profileid2)
	{	
		$profileid1 = $this->con->real_escape_string($profileid1);
		$profileid2 = $this->con->real_escape_string($profileid2);		
		$result= $this->con->query("delete FROM member WHERE profileid = '$profileid2' and groupid = '$profileid1' ");
		return $this->con->query("delete FROM subscribe WHERE profileid = '$profileid2' and friendid = '$profileid1' ");
	}
	function unsubscribe($profileid1,$profileid2)
	{
		$profileid1 = $this->con->real_escape_string($profileid1);
		$profileid2 = $this->con->real_escape_string($profileid2);		
		return $this->con->query("delete FROM subscribe WHERE profileid = '$profileid2' and friendid = '$profileid1' ");	
	}
	
	function member_request_insert($actionid, $groupid, $profileid, $time)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$profileid = $this->con->real_escape_string($profileid);
		$groupid = strip_tags($this->con->real_escape_string($groupid));
		return $this->con->query("INSERT INTO member_request(actionid, groupid, profileid, time) VALUES('$actionid','$groupid','$profileid', '$time')");
	}
		
	function member_request_select($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		return $this->con->query("SELECT profileid FROM member_request WHERE groupid = '$profileid' ORDER BY time DESC");
	}
	
	function member_request_actionid_select($groupid, $profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$groupid = $this->con->real_escape_string($groupid);
		$result = $this->con->query("SELECT actionid FROM member_request WHERE groupid = '$groupid' and profileid='$profileid' ORDER BY time DESC");
		return $result->fetch_array();
	}
	
	function member_select($groupid, $limit=0, $count=50)
	{
		$groupid = $this->con->real_escape_string($groupid);
		return $this->con->query("SELECT * FROM member WHERE groupid = '$groupid' order by actionid limit $limit, $count");
	}
	function follower_select($groupid, $limit=0, $count=50)
	{
		$groupid = $this->con->real_escape_string($groupid);
		return $this->con->query("SELECT * FROM subscriber WHERE pageid = '$groupid' order by actionid limit $limit, $count");
	}
	function member_select_profileid($groupid, $profileid)
	{
		$groupid = $this->con->real_escape_string($groupid);
		$profileid = $this->con->real_escape_string($profileid);		
		$result = $this->con->query("SELECT * FROM member WHERE groupid = '$groupid' and profileid = '$profileid'");
		return $result->fetch_array();
	}
	function guest_select_profileid($eventid, $profileid)
	{
		$eventid = $this->con->real_escape_string($eventid);
		$profileid = $this->con->real_escape_string($profileid);		
		$result = $this->con->query("SELECT * FROM guest WHERE eventid = '$eventid' and profileid = '$profileid'");
		return $result->fetch_array();
	}
	
	function member_select_actionid($groupid)
	{
		$groupid = $this->con->real_escape_string($groupid);
		$result = $this->con->query("SELECT * FROM member WHERE actionid = '$groupid'");
		return $result->fetch_array();
	}
	
	function guest_select_actionid($groupid)
	{
		$groupid = $this->con->real_escape_string($groupid);
		$result = $this->con->query("SELECT * FROM guest WHERE actionid = '$groupid'");
		return $result->fetch_array();
	}
	
	function event_request_select($groupid)
	{
		$groupid = $this->con->real_escape_string($groupid);
		return $this->con->query("SELECT * FROM guest WHERE profileid = '$groupid' and priviledge = '0' ");
	}
	
	function guest_select($groupid, $limit=0, $count=50)
	{
		$groupid = $this->con->real_escape_string($groupid);
		return $this->con->query("SELECT * FROM guest WHERE eventid = '$groupid' order by actionid limit $limit, $count");
	}
	
	function guest_update($groupid, $profileid, $priviledge)
	{
		$groupid = $this->con->real_escape_string($groupid);
		$profileid = $this->con->real_escape_string($profileid);
		$priviledge = $this->con->real_escape_string($priviledge);		
		return $this->con->query("update guest set priviledge = '$priviledge' where eventid = '$groupid' and profileid = '$profileid'");
	}
	
	function mygroup_select($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		return $this->con->query("SELECT groupid FROM member WHERE profileid = '$profileid' order by actionid desc");
	}
	
	function is_member($profileid1, $profileid2)
	{	
		$profileid1 = $this->con->real_escape_string($profileid1);
		$profileid2 = $this->con->real_escape_string($profileid2);		
		return $this->con->query("SELECT * FROM member WHERE profileid = '$profileid2' and groupid = '$profileid1' ");
	}
	function is_follower($profileid1, $profileid2)
	{	
		$profileid1 = $this->con->real_escape_string($profileid1);
		$profileid2 = $this->con->real_escape_string($profileid2);		
		return $this->con->query("SELECT * FROM subscriber WHERE profileid = '$profileid2' and pageid = '$profileid1' ");
	}
	function group_priviledge_update($profileid1, $profileid2, $priviledge)
	{	
		$profileid1 = $this->con->real_escape_string($profileid1);
		$profileid2 = $this->con->real_escape_string($profileid2);	
		$priviledge = $this->con->real_escape_string($priviledge);			
		return $this->con->query("update member set priviledge = '$priviledge' WHERE profileid = '$profileid2' and groupid = '$profileid1' ");
	}
	
	function is_group_admin($profileid1, $profileid2)
	{	
		$profileid1 = $this->con->real_escape_string($profileid1);
		$profileid2 = $this->con->real_escape_string($profileid2);		
		$result = $this->con->query("SELECT * FROM member WHERE profileid = '$profileid2' and groupid = '$profileid1' ");
		return $result->fetch_array();
	} 
	function is_page_admin($profileid1, $profileid2)
	{	
		$profileid1 = $this->con->real_escape_string($profileid1);
		$profileid2 = $this->con->real_escape_string($profileid2);		
		$result = $this->con->query("SELECT * FROM subscriber WHERE profileid = '$profileid2' and pageid = '$profileid1' ");
		return $result->fetch_array();
	} 
	function is_host($profileid1, $profileid2)
	{	
		$profileid1 = $this->con->real_escape_string($profileid1);
		$profileid2 = $this->con->real_escape_string($profileid2);		
		$result = $this->con->query("SELECT * FROM `guest` WHERE profileid = '$profileid2' and `eventid` = '$profileid1' ");
		return $result->fetch_array();
	}
	
	function is_guest($profileid1, $profileid2)
	{	
		$profileid1 = $this->con->real_escape_string($profileid1);
		$profileid2 = $this->con->real_escape_string($profileid2);		
		return $this->con->query("SELECT profileid FROM guest WHERE profileid = '$profileid2' and eventid = '$profileid1' ");
	}
	
	
	function missu_status($myprofileid,$profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$myprofileid = $this->con->real_escape_string($myprofileid);
		$result = $this->con->query("select * from missu where (ACTIONBY = '$myprofileid' AND PROFILEID='$profileid') OR (ACTIONBY ='$profileid' AND PROFILEID='$myprofileid')");
		$data = array();
		if($result->num_rows)
		{
		    $row = $result->fetch_array();
			if($row['ACTIONBY']==$myprofileid)
			{
				$data['status'] = 1;
				$data['pageid'] = $row['ACTIONID'];
			    return $data;
			}
			else if($row['ACTIONBY'] == $profileid)
			{
			   $data['status'] = 2;
			   $data['pageid'] = $row['ACTIONID'];
			   return $data;
			}
		}
		else
		{
			$data['status'] = 0;
		    return $data;
		}
	}
	
	function missu_actionid_select($myprofileid,$profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$myprofileid = $this->con->real_escape_string($myprofileid);
		$result = $this->con->query("select ACTIONID from missu where (ACTIONBY = '$profileid' AND PROFILEID='$myprofileid') ");
		$row = $result->fetch_array();
		return $row['ACTIONID'];
	}
	
	function missu_select($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT * FROM missu WHERE PROFILEID = '$profileid' ORDER BY ACTIONID DESC");
		return $result;
	}
	
	function missu_insert($actionid,$myprofileid,$profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$myprofileid = $this->con->real_escape_string($myprofileid);
		$result = $this->con->query("insert into missu(ACTIONID,ACTIONBY,PROFILEID) VALUES('$actionid','$myprofileid','$profileid')");
		return $result;
	}
	
	function missu_delete($myprofileid,$profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$myprofileid = $this->con->real_escape_string($myprofileid);
		$result = $this->con->query("delete from missu where PROFILEID = '$myprofileid' AND ACTIONBY ='$profileid' ");
		return $result;
	}
	
	function missu_outsource_status($myprofileid,$profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$myprofileid = $this->con->real_escape_string($myprofileid);
		$result = $this->con->query("select * from missu_outsource where ACTIONBY = '$myprofileid' AND VIRTUALID='$profileid' ");
		$data = array();
		if($result->num_rows)
		{
		    $row = $result->fetch_array();
			if($row['ACTIONBY']==$myprofileid)
			{
				$data['status'] = 1;
			    return $data;
			}
		}
		else
		{
			$data['status'] = 0;
		    return $data;
		}
	}
	
	function missu_outsource_insert($actionid,$myprofileid,$profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$myprofileid = $this->con->real_escape_string($myprofileid);
		$result = $this->con->query("insert into missu_outsource(ACTIONID,ACTIONBY,VIRTUALID) VALUES('$actionid','$myprofileid','$profileid')");
		return $result;
	}
	
	function missu_outsource_delete($myprofileid,$profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$myprofileid = $this->con->real_escape_string($myprofileid);
		$result = $this->con->query("delete from missu_outsource where VIRTUALID = '$myprofileid' AND ACTIONBY ='$profileid' ");
		return $result;
	}
	
	function college_select_alphabet($alphabet)
	{
		$alphabet = strip_tags($this->con->real_escape_string($alphabet));
		$result = $this->con->query("select NAME,DIARYID from info where TYPE='204' AND NAME REGEXP '^$alphabet'");
		return $result;
	}
	
	function college_mate_select($college)
	{
		$result=$this->con->query("SELECT b.PROFILEID,b.NAME FROM bio as b INNER JOIN bio_history AS bh on b.PROFILEID = bh.profileid WHERE bh.diaryid = '$college' ORDER BY bh.end");
		return $result;
	}
	
	function photo_select($actionid)
	{	
        $actionid = strip_tags($this->con->real_escape_string($actionid));
		$result = $this->con->query("SELECT * FROM image WHERE imageid = '$actionid' ");
		return $result->fetch_array();
	}
	
	function photo_insert($actionid)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$result = $this->con->query("INSERT INTO photo(actionid) VALUES('$actionid')");
		return $result;
	}
	
	function get_diary_name($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT NAME FROM info WHERE DIARYID ='$profileid'");
		 return $result->fetch_array();
	}
	
	function get_diary_image($type=1)
	{	
		$result=$this->con->query("SELECT FILENAME FROM diary_image WHERE TYPE='$type' ORDER BY TIMESTAMP DESC LIMIT 1");
		 return $result->fetch_array();
	}
	
	function get_diary_image_from_diaryid($diaryid)
	{	
		$result=$this->con->query("SELECT FILENAME FROM diary_image  WHERE TYPE=(SELECT TYPE from info where DIARYID = '$diaryid') ");
		$res =  $result->fetch_array();
		return $res['FILENAME'];
	}
	
	function data_retrieve($id)
	{
		if($id != NULL)
		{
			$id = $this->con->real_escape_string($id);
			$result=$this->con->query("SELECT NAME FROM info WHERE DIARYID = '$id'");
			$res = $result->fetch_array();
			return $res;
		}
		return 0;
	}
	
	function check_fan($diaryid,$profileid)
	{	
		$profileid = $this->con->real_escape_string($profileid);
		$diaryid = $this->con->real_escape_string($diaryid);
		$result=$this->con->query("SELECT PROFILEID FROM fan WHERE PROFILEID = '$profileid' AND DIARYID = '$diaryid'");
                $value = $result->fetch_array();
		if($value['PROFILEID']==$profileid)
		{
			return 0;
		}
		else
		{
			return 1;
		}
	}	
	
	function fan_insert($diaryid,$profileid)
	{
		$status = $this->check_fan($diaryid,$profileid);
        $diaryid = strip_tags($this->con->real_escape_string($diaryid));
        $profileid = strip_tags($this->con->real_escape_string($profileid));
		if($status==1)
		{
			$name = $_SESSION['NAME'];
			$result = $this->con->query("INSERT INTO fan(DIARYID,PROFILEID,NAME) VALUES('$diaryid','$profileid','$name')");
			return $result;
		}
		else
		{
			return $status;
		}		
	}
	
	function data_select($type,$k)
	{
		$type = $this->con->real_escape_string($type);
        $k = $this->con->real_escape_string($k);
		$result=$this->con->query("SELECT DIARYID AS ID,NAME FROM info WHERE TYPE = '$type' AND NAME REGEXP '^$k' LIMIT 5");
		return $result;
	}
	
	function group_settings_save($groupid, $invite, $privacy, $link, $desc)
	{
		$groupid = strip_tags($this->con->real_escape_string($groupid));
		$invite = strip_tags($this->con->real_escape_string($invite));
		$privacy = strip_tags($this->con->real_escape_string($privacy));
		$link = strip_tags($this->con->real_escape_string($link));		
		$description = strip_tags($this->con->real_escape_string($desc));
		return $this->con->query("update `group` set invite='$invite', visible='$privacy', link='$link', description='$description' where groupid='$groupid'");
	}
	
	function event_settings_save($eventid, $invite, $privacy, $desc, $date, $timing, $venue)
	{
		$eventid = strip_tags($this->con->real_escape_string($eventid));
		$invite = strip_tags($this->con->real_escape_string($invite));
		$privacy = strip_tags($this->con->real_escape_string($privacy));		
		$description = strip_tags($this->con->real_escape_string($desc));
		$date = strip_tags($this->con->real_escape_string($date));
		$timing = strip_tags($this->con->real_escape_string($timing));
		$venue = strip_tags($this->con->real_escape_string($venue));
		
		return $this->con->query("update `event` set `invite`='$invite', `privacy`='$privacy',`description`='$description',`date`='$date',`timing`='$timing',`venue`='$venue' where eventid = '$eventid' ");	
	}
	function team_member_add($actionid,$myprofileid,$value)
	{
		$actionid = strip_tags($this->con->real_escape_string($actionid));
		$myprofileid = strip_tags($this->con->real_escape_string($myprofileid));
		$value = strip_tags($this->con->real_escape_string($value));
		if($groupid = $this->group_name_exists($value))
		{
		 return $this->member_insert($actionid, $groupid, $myprofileid,0);
		}
		else
		{
		 $time = time();
		 $desc='This group is for team '.$value;
		 return $this->group_create($actionid,0,0,$value, $desc, $myprofileid, $time);
		}
	}
	
	function group_create($actionid, $type, $visible, $name, $desc, $createdby, $time)
	{
		$actionid = strip_tags($this->con->real_escape_string($actionid));
		$type = strip_tags($this->con->real_escape_string($type));
		$visible = strip_tags($this->con->real_escape_string($visible));		
		$name = strip_tags($this->con->real_escape_string($name));
		$description = strip_tags($this->con->real_escape_string($desc));
		$createdby = strip_tags($this->con->real_escape_string($createdby));
		$time = strip_tags($this->con->real_escape_string($time));
		
		$result = $this->con->query("INSERT INTO `group`(groupid,type, visible, name,description, createdby, time) VALUES('$actionid','$type','$visible','$name','$description','$createdby','$time')");
		
		if($result)
		{
			$result = $this->member_insert($actionid,$actionid,$createdby,1);
			return $actionid;
		} 
		return 0;	
	}
	function page_create($actionid, $name, $description, $createdby, $time)
	{
		$actionid = strip_tags($this->con->real_escape_string($actionid));		
		$name = strip_tags($this->con->real_escape_string($name));
		$description = strip_tags($this->con->real_escape_string($description));
		$createdby = strip_tags($this->con->real_escape_string($createdby));
		$time = strip_tags($this->con->real_escape_string($time));
		
		$result = $this->con->query("INSERT INTO `page`(pageid,name,description,createdby, time) VALUES('$actionid','$name','$description','$createdby','$time')");
		
		if($result)
		{
			$result = $this->subscriber_insert($actionid,$actionid, $createdby,1);
			return $actionid;
		} 
		return 0;	
	}
	function event_create($actionid, $invite, $privacy, $name, $desc, $date, $timing, $venue, $createdby, $time,$groupid=0)
	{
		$actionid = strip_tags($this->con->real_escape_string($actionid));
		$invite = strip_tags($this->con->real_escape_string($invite));
		$privacy = strip_tags($this->con->real_escape_string($privacy));		
		$name = strip_tags($this->con->real_escape_string($name));
		$description = strip_tags($this->con->real_escape_string($desc));
		$date = strip_tags($this->con->real_escape_string($date));
		$timing = strip_tags($this->con->real_escape_string($timing));
		$venue = strip_tags($this->con->real_escape_string($venue));
		$createdby = strip_tags($this->con->real_escape_string($createdby));
		$time = strip_tags($this->con->real_escape_string($time));
		$groupid = strip_tags($this->con->real_escape_string($groupid));
		
		$result = $this->con->query("INSERT INTO `event`(`eventid`,`invite`,`privacy`,`name` ,`description`,`date`,`timing`,`venue`,`host`,`time`,`groupid`) VALUES('$actionid', '$invite','$privacy','$name','$description','$date','$timing','$venue','$createdby','$time','$groupid')");
		
		if($groupid != 0)
		{
			$this->con->query("INSERT INTO `guest`(`actionid`, `eventid`, `profileid`, `priviledge`) SELECT '$actionid',e.eventid,m.profileid,'0' from `event` as e inner join `member` as m on e.groupid = m.groupid where e.groupid = '$groupid' and m.profileid <> '$createdby' and e.eventid ='$actionid' ");
		}
		if($result)
		{
			$result = $this->guest_insert($actionid,$actionid,$createdby, 1);
			return $actionid;
		}
		return 0;	
	}
	function id_retrieve($value,$type)
	{
		$id = '';
		$result = 0;
		
                $type = $this->con->real_escape_string($type);
                $value = $this->con->real_escape_string($value);
		if($value != '')
		{
			$res = $this->con->query("SELECT DIARYID FROM info WHERE TYPE = '$type' AND NAME = '$value' ORDER BY TIMESTAMP DESC LIMIT 1");	
			$num = $res->num_rows;
			if($num != 0)
			{
				$result = $res->fetch_array();
				$id = $result['DIARYID'];
			}	
			else			
			{ 
				$id = $this->mydiary_create_wo_admin($type,$value);
			}
		}
		return $id;
	}
	
	function mydiary_create_wo_admin($type,$name)
	{
		
		$name = strip_tags($this->con->real_escape_string($name));
                $type = strip_tags($this->con->real_escape_string($type));
		$result = $this->con->query("INSERT INTO `info`(TYPE,NAME) VALUES('$type','$name')");
		if($result)
		{
			$result = $this->con->query("SELECT DIARYID FROM info WHERE NAME = '$name' AND TYPE='$type' ORDER BY TIMESTAMP DESC LIMIT 1");
			$res = $result->fetch_array();
			return $res['DIARYID'];
		}
		return 0;	
	}
	function diary_exists($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("SELECT DIARYID from info WHERE DIARYID = $profileid");
		return $result->fetch_array();
	}
	
	function diary_type_exists($profileid, $type)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("SELECT DIARYID from info WHERE DIARYID = $profileid and TYPE=$type");
		return $result->fetch_array();
	}
	function diaryid_select($type,$name)
	{
		$type = $this->con->real_escape_string($type);
		$name = $this->con->real_escape_string($name);
		$result = $this->con->query("SELECT DIARYID from `info` WHERE NAME =TRIM('$name') and TYPE='$type'");
		$ret = $result->fetch_array();
		return $ret['DIARYID'];
	} 

    function profile_exists($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT USERID FROM signup WHERE USERID='$profileid'");
		$row = $result->fetch_array();
		$profileid = $row['USERID'];
		if($profileid)
		{
            return $profileid;	
		}
	}
	
	function password_select($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT PASSWORD FROM signup WHERE USERID='$profileid'");
		$row = $result->fetch_array();
		return $row['PASSWORD'];
	}
	
	function login_user($email,$password)
	{
		$email = $this->con->real_escape_string($email);
		$password = $this->con->real_escape_string($password);
		$result=$this->con->query("SELECT * FROM signup where EMAIL='$email'");
		return $result->fetch_array();	
	}
  
	function cook_login_user($quip_p,$quip_i)
	{
		$quip_p = $this->con->real_escape_string($quip_p);
		$quip_i = $this->con->real_escape_string($quip_i);
		$result=$this->con->query("SELECT USERID,SESS_QUIP,STEP,EMAIL FROM signup WHERE USERID = '$quip_p' AND SESS_QUIP = '$quip_i'");
		return $result->fetch_array();
	}
	
	function is_already_user($email)
	{
		$email = $this->con->real_escape_string($email);
		$result=$this->con->query("SELECT * FROM signup WHERE EMAIL='$email'");
		return $result->fetch_array();
	}
	
	function is_user($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT * FROM signup WHERE USERID='$profileid'");
		return $result->fetch_array();
	}
	
	function is_virtual_user($email)
	{
		$email = $this->con->real_escape_string($email);
		$data = array();
		$result=$this->con->query("SELECT EMAIL,VIRTUALID FROM virtual WHERE EMAIL='$email'");
		$row = $result->fetch_array();
		if($row['EMAIL'] == $email)
		{
			$data['virtualid'] = $row['VIRTUALID'];
			$data['uniqueid'] = $row['UNIQUEID'];
			$data['ack'] = 1;
			return $data;
		}
		else
		{
			$data['ack'] = 0;
			return $data;
		}
	}
	
	function check_email($email)
	{
		$email = $this->con->real_escape_string($email);
		$result=$this->con->query("SELECT EMAIL FROM signup WHERE EMAIL='$email'");
		$num = mysqli_num_rows($result);
		 return $num;
		
	}

	function update_uniqueid($email,$uniqueid)
	{
		$email = $this->con->real_escape_string($email);
		$uniqueid = $this->con->real_escape_string($uniqueid);
		$result=$this->con->query("UPDATE signup SET UNIQUEID='$uniqueid' WHERE EMAIL='$email' ");
	    return $result;	
	}
	
	function select_uniqueid($email)
	{
	    $email = $this->con->real_escape_string($email);
		$result=$this->con->query("SELECT UNIQUEID FROM signup WHERE EMAIL = '$email'");
		$num = $result->num_rows;
		if($num != 0 )
		{
			$res = $result->fetch_array();
			$uniqueid = $res['UNIQUEID'];
		}
		else
		{
			$uniqueid = "invalid";
		}
		return $uniqueid;
	}
	
	function password_gain($crypt,$crypt2,$email)
	{
			$crypt = $this->con->real_escape_string($crypt);
			$crypt2 = $this->con->real_escape_string($crypt2);
			$email = $this->con->real_escape_string($email);
			$result= $this->con->query("UPDATE signup SET PASSWORD = '$crypt' , UNIQUEID = '$crypt2', VERIFY = '1' WHERE EMAIL = '$email'");
			return $result;
	}		
	
	function verify_check($email)
	{
			$email = $this->con->real_escape_string($email);
			$result= $this->con->query("SELECT VERIFY FROM signup WHERE EMAIL = '$email'");
			$result = $result->fetch_array();
			return $result['VERIFY'];
	}
	
	function email_verified($email)
	{
			$email = $this->con->real_escape_string($email);
			$result= $this->con->query("UPDATE signup SET VERIFY = '1' WHERE EMAIL = '$email'");
			return $result;
	}
	
	function email_name_select($email)
	{
			$email = $this->con->real_escape_string($email);
			$result= $this->con->query("SELECT NAME FROM bio WHERE EMAIL = '$email'");
			$res =  $result->fetch_array();
			return $res['NAME'];
	}
	
	function email_id_select($low,$high)
	{
			$result= $this->con->query("SELECT EMAIL,UNIQUEID FROM signup WHERE VERIFY = '0' ORDER BY USERID LIMIT $low,$high");
			return $result;
	}
	
    function stepup($step,$myprofileid)
    {
		$step = strip_tags($this->con->real_escape_string($step));
		$_SESSION['STEP'] = $step;
		$myprofileid = strip_tags($this->con->real_escape_string($myprofileid));
		$result = $this->con->query("UPDATE signup SET STEP='$step' WHERE USERID = '$myprofileid'");
		return $result;
    }
	
	function visible_check($actionid)
	{
		$myprofileid = $_SESSION['USERID'];
		$actionid = $this->con->real_escape_string($actionid);
		$result=$this->con->query("SELECT * FROM action WHERE ACTIONID = '$actionid' ");
		$res = $result->fetch_array();
		if($res['VISIBLE'] == 0 || $res['VISIBLE'] == -1 || $res['VISIBLE'] == -2 )
		{
			 return $res;
		}
		else if(($_SESSION['SEX'] == 1 && $res['VISIBLE']== -3) || ($_SESSION['SEX'] == 0 && $res['VISIBLE']== -4))
		{
			 return $res;
		}
		else if($res['VISIBLE'] == -5 && $myprofileid ==$res['ACTIONBY'])
		{
			 return $res;
		}
		else 
				 return 0;
	}
	
	function visible_set($visible)
	{
	    $myprofileid = $_SESSION['USERID'];
	    $visible = $this->con->real_escape_string($visible);
		$result = $this->visible_get($myprofileid);
		if($result['PROFILEID'] == $myprofileid)
		{
			$result = $this->con->query("UPDATE visible SET visible = '$visible' WHERE PROFILEID = '$myprofileid' ");
			 return $result;
		}
			$result = $this->con->query("INSERT INTO visible(PROFILEID,visible) VALUES('$myprofileid','$visible') ");
			 return $result;
	}
	
	function visible_get($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("SELECT * FROM visible WHERE PROFILEID = '$profileid' ");
		 return $result->fetch_array();
	}
	
	function get_this_page($actionid)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$result = $this->con->query("SELECT * FROM diary WHERE ACTIONID='$actionid'");
		 return $result->fetch_array();
	}
	
	function get_tag($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("SELECT TAGLINE FROM bio WHERE PROFILEID = '$profileid'");
		 return $result->fetch_array();
	}
	
    function set_tag($tagline)
	{	
		$myprofileid = $_SESSION['USERID'];
		$tagline = strip_tags($this->con->real_escape_string($tagline));
		$result = $this->con->query("UPDATE bio SET TAGLINE = '$tagline' WHERE PROFILEID = '$myprofileid'");
		 return $result;
	}

/*	function get_actionid($diaryid,$actiontype,$pageid=0,$visible_id=0,$readbit=0)
	{
		$myprofileid = $_SESSION['USERID'];
		$diaryid = strip_tags($this->con->real_escape_string($diaryid));
		$actiontype = $this->con->real_escape_string($actiontype);
		$pageid = $this->con->real_escape_string($pageid);
		$visible_id = $this->con->real_escape_string($visible_id);
		
			$result = $this->con->query("INSERT INTO action(ACTIONBY,PROFILEID,PAGEID,ACTIONTYPE,visible,READBIT) VALUES('$myprofileid','$diaryid','$pageid','$actiontype','$visible_id','$readbit')");
			$result_notice = $this->con->query("INSERT INTO notice(ACTIONBY,PROFILEID,PAGEID,ACTIONTYPE,READBIT) VALUES('$myprofileid','$diaryid','$pageid','$actiontype','$readbit')");
			if($result)
			{
				$res = $this->con->query("SELECT ACTIONID FROM action WHERE ACTIONBY = '$myprofileid' ORDER BY ACTIONID DESC LIMIT 1");
				$row = $res -> fetch_array();
				$actionid=$row['ACTIONID'];
				if($pageid=='0')
				{
					$res=$this->con->query("UPDATE action SET PAGEID = ACTIONID WHERE ACTIONID='$actionid'");
				}
				return $row['ACTIONID'];
			}
	}
*/

	function get_actionid($diaryid,$actiontype,$pageid=0,$visible_id=0,$readbit=0)
	{
		$myprofileid = $_SESSION['USERID'];
		$diaryid = strip_tags($this->con->real_escape_string($diaryid));
		$actiontype = $this->con->real_escape_string($actiontype);
		$pageid = $this->con->real_escape_string($pageid);
		$visible_id = $this->con->real_escape_string($visible_id);
		$actionid =$this->get_globalid();
		if($pageid == 0)
		{
			$pageid = $actionid;
		}
		$this->con->query("INSERT INTO action(ACTIONID,ACTIONBY,PROFILEID,PAGEID,ACTIONTYPE,visible,READBIT) VALUES('$actionid','$myprofileid','$diaryid','$pageid','$actiontype','$visible_id','$readbit')");
		return $actionid;
	} 

	function notice_insert($actionid,$diaryid,$actiontype,$pageid)
	{
		$myprofileid = $_SESSION['USERID'];
		$actionid = strip_tags($this->con->real_escape_string($actionid));
		$diaryid = strip_tags($this->con->real_escape_string($diaryid));
		$pageid = $this->con->real_escape_string($pageid);
		$actiontype = $this->con->real_escape_string($actiontype);
		$this->con->query("INSERT INTO notice(ACTIONID,ACTIONBY,PROFILEID,PAGEID,ACTIONTYPE) VALUES('$actionid','$myprofileid','$diaryid','$pageid','$actiontype')");
	}
	
	function get_action($actionid)
	{
		$res = $this->con->query("SELECT * FROM action WHERE ACTIONID = '$actionid'");
		return $res -> fetch_array();
	}
	
	function parent_select($actionid,$prtype)  //prtype = actiontype of parent
	{
        $pageid = $this->con->real_escape_string($pageid);
		$rtype = $this->con->real_escape_string($rtype);
		$result=$this->con->query("SELECT * FROM action INNER JOIN action ON action.actionid = action.pageid WHERE action.ACTIONID = '$actionid' AND action.ACTIONTYPE = '$prtype'");
		return $result->fetch_array();
	}
	function moderator_select()
	{
		return $this->con->query("Select * from moderator");
	}
	function moderator_check($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("SELECT IF( EXISTS( SELECT * FROM `moderator` WHERE profileid = '$profileid'),1, 0) as result");
		$ret = $result->fetch_array();
		return $ret['result'];
	}
	function make_moderator($profileid)
	{ 
		$profileid = $this->con->real_escape_string($profileid);
		return $this->con->query("Insert into moderator(profileid) values('$profileid')");
	
	}
	function moderator_remove($profileid)
	{ 
		$profileid = $this->con->real_escape_string($profileid);
		return $this->con->query("Delete from moderator where profileid = '$profileid'");
	
	}
	
    function update_extra($actionid, $extra)
	{	
		$res = $this->con->query("UPDATE action SET EXTRA= '$extra' WHERE ACTIONID = '$actionid'");
		return $res;
	}
	
	function actiontype_select($profileid,$actiontype,$limit=0,$count=6)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$actiontype = $this->con->real_escape_string($actiontype);
		$limit = $this->con->real_escape_string($limit);
		$count = $this->con->real_escape_string($count);
		
		$result= $this->con->query("SELECT DISTINCT ACTIONID,ACTIONBY,ACTIONTYPE,PAGEID,action.PROFILEID AS PROFILEID,action.TIMESTAMP AS TIMESTAMP FROM action INNER JOIN friend ON action.ACTIONBY=friend.FRIENDID OR action.PROFILEID = friend.FRIENDID WHERE friend.PROFILEID='$profileid' AND action.ACTIONTYPE = '$actiontype' AND action.PROFILEID <> '$profileid' ORDER BY action.ACTIONID DESC LIMIT $limit,$count");
		return $result; 
	}
	
	function pin_select($profileid,$limit=0,$count=25)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$limit = $this->con->real_escape_string($limit);
		$count = $this->con->real_escape_string($count);
		$result= $this->con->query("SELECT DISTINCT ACTIONID,ACTIONBY,ACTIONTYPE,PAGEID,action.PROFILEID AS PROFILEID,action.TIMESTAMP AS TIMESTAMP FROM action INNER JOIN friend ON action.ACTIONBY=friend.FRIENDID OR action.PROFILEID = friend.FRIENDID WHERE friend.PROFILEID='$profileid' AND action.ACTIONTYPE IN('5','6','50') group by PAGEID ORDER BY action.ACTIONID DESC LIMIT $limit,$count");
		return $result; 
	}
	
	function new_friend_action_select($profileid,$limit,$count)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$limit = $this->con->real_escape_string($limit);
		$count = $this->con->real_escape_string($count);
		$result= $this->con->query("SELECT  A.ACTIONID,A.ACTIONBY,A.ACTIONTYPE,A.PAGEID,A.VISIBLE,A.PROFILEID,A.TIMESTAMP 
FROM action as A INNER JOIN (SELECT  MAX(ACTIONID) as ACTIONID FROM action INNER JOIN subscribe as sub ON CASE WHEN action.profileid <1000000000 THEN action.PROFILEID ELSE action.ACTIONBY END = sub.FRIENDID INNER JOIN actiontype on actiontype.actiontypeid = action.ACTIONTYPE WHERE sub.PROFILEID='$profileid' AND actiontype.news_feed ='1' group by pageid ORDER BY action.ACTIONID DESC LIMIT $limit,$count) AS B  ON A.ACTIONID = B.ACTIONID "); 
		return $result; 
	}
	function action_select($actionid)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$result = $this->con->query("select * from action where ACTIONID = '$actionid'");
		return $result->fetch_array();
	}
	function max_action_select($pageid)
	{
		$pageid = $this->con->real_escape_string($pageid);
		$result = $this->con->query("SELECT  A.ACTIONID,A.ACTIONBY,A.ACTIONTYPE,A.PAGEID,A.VISIBLE,A.PROFILEID,A.TIMESTAMP 
FROM action as A INNER JOIN (SELECT  MAX(ACTIONID) as ACTIONID FROM action INNER JOIN subscribe as sub ON CASE WHEN action.profileid <1000000000 THEN action.PROFILEID ELSE action.ACTIONBY END = sub.FRIENDID where pageid ='$pageid' group by pageid ) AS B  ON A.ACTIONID = B.ACTIONID");
		return $result->fetch_array();
	} 
	function friend_action_select($profileid,$limit,$count=10)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$limit = $this->con->real_escape_string($limit);
		$count = $this->con->real_escape_string($count);
		$result= $this->con->query("SELECT  A.ACTIONID,A.ACTIONBY,A.ACTIONTYPE,A.PAGEID,A.VISIBLE,A.PROFILEID,A.TIMESTAMP 
FROM action as A INNER JOIN (SELECT  MAX(ACTIONID) as ACTIONID FROM action INNER JOIN subscribe as sub ON CASE WHEN action.profileid <1000000000 THEN action.PROFILEID ELSE action.ACTIONBY END = sub.FRIENDID INNER JOIN actiontype on actiontype.actiontypeid = action.ACTIONTYPE WHERE sub.PROFILEID='$profileid' AND actiontype.live_feed ='1' group by pageid ORDER BY action.ACTIONID DESC LIMIT $limit,$count) AS B  ON A.ACTIONID = B.ACTIONID");
		return $result; 
	}
	function get_profile_post($profileid,$limit,$count=10)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$limit = $this->con->real_escape_string($limit);
		$count = $this->con->real_escape_string($count);
		$result=$this->con->query("SELECT A.* FROM action as A INNER JOIN(SELECT MAX(a.actionid) as actionid FROM action as a inner join actiontype on actiontype.actiontypeid = a.ACTIONTYPE WHERE (a.PROFILEID ='$profileid') AND actiontype.profile_feed ='1' GROUP BY PAGEID ORDER BY a.ACTIONID DESC LIMIT $limit,$count) AS B ON A.ACTIONID = B.ACTIONID"); 
		return $result;
	} 	
	function everything_select($limit,$count=10)
	{
		$limit = $this->con->real_escape_string($limit);
		$count = $this->con->real_escape_string($count);
		$result=$this->con->query("SELECT A.* FROM action as A INNER JOIN(SELECT MAX(a.actionid) as actionid FROM action as a inner join actiontype on actiontype.actiontypeid = a.ACTIONTYPE WHERE actiontype.profile_feed ='1' GROUP BY PAGEID ORDER BY a.ACTIONID DESC LIMIT $limit,$count) AS B ON A.ACTIONID = B.ACTIONID"); 
		return $result;
	} 
	
	function group_feed_select($profileid,$limit,$count=10)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$limit = $this->con->real_escape_string($limit);
		$count = $this->con->real_escape_string($count);
		$result=$this->con->query("SELECT A.* FROM action as A INNER JOIN (SELECT MAX(ACTIONID) AS ACTIONID FROM action as a INNER JOIN actiontype on actiontype.actiontypeid = a.ACTIONTYPE WHERE (PROFILEID ='$profileid') AND actiontype.group_feed ='1' GROUP BY PAGEID ORDER BY a.ACTIONID DESC LIMIT $limit,$count) AS B ON A.ACTIONID = B.ACTIONID"); 
		return $result;
	}
	function page_feed_select($profileid,$limit,$count=10)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$limit = $this->con->real_escape_string($limit);
		$count = $this->con->real_escape_string($count);
		$result=$this->con->query("SELECT A.* FROM action as A INNER JOIN (SELECT MAX(ACTIONID) AS ACTIONID FROM action as a INNER JOIN actiontype on actiontype.actiontypeid = a.ACTIONTYPE WHERE (PROFILEID ='$profileid') AND actiontype.page_feed ='1' GROUP BY PAGEID ORDER BY a.ACTIONID DESC LIMIT $limit,$count) AS B ON A.ACTIONID = B.ACTIONID"); 
		return $result;
	}
	
	function event_feed_select($profileid,$limit,$count=10)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$limit = $this->con->real_escape_string($limit);
		$count = $this->con->real_escape_string($count);
		$result=$this->con->query("SELECT A.* FROM action as A INNER JOIN (SELECT MAX(ACTIONID) AS ACTIONID FROM action as a INNER JOIN actiontype on actiontype.actiontypeid = a.ACTIONTYPE WHERE (PROFILEID ='$profileid') AND actiontype.event_feed ='1' GROUP BY PAGEID ORDER BY a.ACTIONID DESC LIMIT $limit,$count) AS B ON A.ACTIONID = B.ACTIONID"); 
		return $result;
	}
	function tech_feed_select($profileid,$limit,$count=10)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$limit = $this->con->real_escape_string($limit);
		$count = $this->con->real_escape_string($count);
		$result=$this->con->query("SELECT A.* FROM action as A INNER JOIN (SELECT MAX(a.ACTIONID) AS ACTIONID FROM action as a inner join `group` as gp on gp.groupid = a.profileid inner join member as mem on gp.groupid =  mem.groupid inner join actiontype as at on at.actiontypeid = a.actiontype where gp.type=1 and at.group_feed ='1' and mem.profileid='$profileid' group by PAGEID order by a.ACTIONID DESC LIMIT $limit,$count) AS B ON A.ACTIONID = B.ACTIONID");
		return $result;
		
	}
	
	function news_poll($profileid,$time)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$time = $this->con->real_escape_string($time);
		$result= $this->con->query("SELECT  A.ACTIONID,A.ACTIONBY,A.ACTIONTYPE,A.PAGEID,A.VISIBLE,A.PROFILEID,A.TIMESTAMP 
FROM action as A INNER JOIN (SELECT MAX(ACTIONID)  AS ACTIONID FROM action INNER JOIN subscribe as sub ON CASE WHEN action.PROFILEID <1000000000 THEN action.PROFILEID ELSE action.ACTIONBY END = sub.FRIENDID INNER JOIN actiontype on actiontype.actiontypeid = action.ACTIONTYPE WHERE sub.PROFILEID='$profileid' AND actiontype.poll_feed ='1' AND UNIX_TIMESTAMP(action.TIMESTAMP) > '$time'  GROUP BY PAGEID ORDER BY ACTIONID DESC) AS B ON A.ACTIONID = B.ACTIONID ");
		return $result; 
	}
	
	function actionid_select($actionid)
	{
        $actionid = $this->con->real_escape_string($actionid);
		$result= $this->con->query("SELECT * FROM action where ACTIONID = '$actionid' ");
		return $result;
	}
	
	function action_update($actionid, $groupid)
	{
	    $actionid = $this->con->real_escape_string($actionid);
        $groupid = $this->con->real_escape_string($groupid);
		$res = $this->con->query("update notice set PROFILEID = '$groupid' where ACTIONID = '$actionid' ");
		return $this->con->query("update action set PROFILEID = '$groupid' where ACTIONID = '$actionid' ");
	}
	
	function link_insert($actionid,$title,$link,$meta,$page,$file)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$title = $this->con->real_escape_string($title);
		$link = $this->con->real_escape_string($link);
		$meta = $this->con->real_escape_string($meta);
		$page = $this->con->real_escape_string($page);
		$file = $this->con->real_escape_string($file);
		$result = $this->con->query("INSERT INTO link(ACTIONID,TITLE,LINK,META,PAGE,FILENAME) VALUES('$actionid','$title','$link','$meta','$page','$file')");
		return $result;
	}
	
	function link_select($actionid)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$res = $this->con->query("SELECT * from link where ACTIONID = '$actionid'");
		return $res->fetch_array();
	}
	
	function diary_insert($actionid,$page)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$page = strip_tags($this->con->real_escape_string($page));
		$result = $this->con->query("INSERT INTO diary(ACTIONID,PAGE) VALUES('$actionid','$page')");
		return $result;
	}
	
	function option_insert($questionid,$option)
	{
		$questionid = $this->con->real_escape_string($questionid);
		$option = strip_tags($this->con->real_escape_string($option));
		return $this->con->query("INSERT INTO `option`(questionid,`option`) VALUES('$questionid','$option')");
	}
	
	function option_select($questionid)
	{
		$questionid = $this->con->real_escape_string($questionid);
		return $this->con->query("select * from `option` where questionid = '$questionid' ");
	}
	
	function optionid_select($questionid,$option) 
	{
		$questionid = $this->con->real_escape_string($questionid);
		$option = $this->con->real_escape_string($option);
		$result = $this->con->query("select `optionid` from `option` where questionid = '$questionid' and `option`= '$option' ");
		$orow = $result->fetch_array();
		return $orow['optionid'];
	}
	
	function answer_insert($questionid,$answerid,$optionid,$profileid)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$optionid = $this->con->real_escape_string($optionid);
		$profileid = $this->con->real_escape_string($profileid);
		return $this->con->query("INSERT INTO `answer`(`questionid`,`answerid`, `optionid`, `profileid`) VALUES ('$questionid','$answerid','$optionid','$profileid')");
		
	}
	function answer_mine_check($optionid,$profileid)
	{
		$optionid = $this->con->real_escape_string($optionid);
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("SELECT IF( EXISTS( SELECT * FROM `answer` WHERE optionid ='$optionid' AND profileid = '$profileid'),1, 0) as result");
		$ret = $result->fetch_array();
		return $ret['result'];
	}
	function answer_count_select($questionid,$optionid)
	{
		$questionid = $this->con->real_escape_string($questionid);
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("SELECT COUNT(profileid) as answer_count from `answer` where questionid='$questionid' and optionid ='$optionid' ");
		$ret = $result->fetch_array();
		return $ret['answer_count'];
	}
	
	function answer_select($optionid)
	{ 
		$profileid = $this->con->real_escape_string($profileid);
		return $this->con->query("SELECT profileid from `answer` where optionid ='$optionid' ");
	}
	
	function myanswer_select($optionid,$profileid)
	{
		$optionid = $this->con->real_escape_string($optionid);
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("SELECT * FROM `answer` WHERE optionid ='$optionid' AND profileid = '$profileid'");
		return $result->fetch_array();
	}
	
	function answer_total_select($questionid)
	{
		$questionid = $this->con->real_escape_string($questionid);
		$result = $this->con->query("SELECT COUNT(distinct(profileid)) as answer_total from `answer` where questionid='$questionid' ");
		$ret = $result->fetch_array();
		return $ret['answer_total'];
	}
	
	function song_select($actionid)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$res = $this->con->query("SELECT song.SONG as SONG,song.FILENAME as FILENAME,diary.PAGE as PAGE FROM action inner join diary on action.ACTIONID = diary.ACTIONID inner join map on action.ACTIONID = map.ACTIONID  inner join song on map.MAPID = song.SONGID WHERE action.ACTIONID = '$actionid'");
		$row = $res -> fetch_array();
		return $row;
	}
	
	function songid_exists($songid)
	{
		$songid = $this->con->real_escape_string($songid);
		$res = $this->con->query("SELECT SONGID from song where SONGID = '$songid'");
		return $res -> fetch_array();
	}
	
	function mood_exists($moodid)
	{
		$moodid = $this->con->real_escape_string($moodid);
		$res = $this->con->query("SELECT MOODID from mood where MOODID = '$moodid'");
		return $res->fetch_array();
	}
	
	function mood_select($actionid)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$res = $this->con->query("SELECT mood.MOOD as MOOD,mood.FILENAME as FILENAME,diary.PAGE as PAGE FROM action inner join diary on action.ACTIONID = diary.ACTIONID inner join map on action.ACTIONID = map.ACTIONID  inner join mood on map.MAPID = mood.MOODID WHERE action.ACTIONID = '$actionid'");
		$row = $res -> fetch_array();
		return $row;
	}
	
	function gift_select($actionid)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$res = $this->con->query("SELECT gift.GIFT as GIFT,gift.FILENAME as FILENAME,diary.PAGE as PAGE FROM action inner join diary on action.ACTIONID = diary.ACTIONID inner join map on action.ACTIONID = map.ACTIONID  inner join gift on map.MAPID = gift.GIFTID WHERE action.ACTIONID = '$actionid'");
		$row = $res -> fetch_array();
		return $row;
	}
	
	function giftid_exists($actionid)
	{
		$giftid = $this->con->real_escape_string($giftid);
		$res = $this->con->query("SELECT GIFTID FROM gift WHERE GIFTID = '$giftid'");
		return $res -> fetch_array();
	}
	
	function map_insert($actionid,$mapid)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$mapid = strip_tags($this->con->real_escape_string($mapid));
		$result = $this->con->query("INSERT INTO map(ACTIONID,MAPID) VALUES('$actionid','$mapid')");
		return $result;
	}
	
	function diary_select($actionid)
	{	
		$actionid = $this->con->real_escape_string($actionid);
		$result=$this->con->query("SELECT * FROM diary WHERE ACTIONID = '$actionid' ");
		return $result->fetch_array();
	}
	
	function entry_status($profileid,$date)
	{	
		$profileid = $this->con->real_escape_string($profileid);
		$date = $this->con->real_escape_string($date);
		$result=$this->con->query("SELECT * FROM entry WHERE PROFILEID = '$profileid' AND DATE ='$date' ");
		return $result->fetch_array();
	}
	
	function entry_select($profileid,$limit=0,$count=10)
	{	
		$profileid = $this->con->real_escape_string($profileid);
		$limit = $this->con->real_escape_string($limit);
		$count = $this->con->real_escape_string($count);
		$result=$this->con->query("SELECT * FROM entry WHERE PROFILEID = '$profileid' ORDER BY ACTIONID desc LIMIT $limit,$count ");
		return $result;
	}
	
	function comment_insert($actionid,$comment)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$comment = strip_tags($this->con->real_escape_string($comment));
		$result = $this->con->query("INSERT INTO comment(ACTIONID,COMMENT) VALUES('$actionid','$comment')");
		return $result;
	}
	
	function comment_count($pageid,$actiontype)
	{	
		$pageid = $this->con->real_escape_string($pageid);
		$actiontype = $this->con->real_escape_string($actiontype);
		$result=$this->con->query("SELECT COUNT(*) FROM action WHERE PAGEID='$pageid' AND ACTIONTYPE='$actiontype' ");
		return $result->fetch_array();
	}
	
	function comment_select_actionid_of_third($pageid,$actiontype)
	{	
		$pageid = $this->con->real_escape_string($pageid);
		$actiontype = $this->con->real_escape_string($actiontype);
		$res=$this->con->query("SELECT ACTIONID FROM action WHERE PAGEID='$pageid' AND ACTIONTYPE='$actiontype' ORDER BY ACTIONID DESC LIMIT 2,1");
		$result = $res->fetch_array();
		return $result['ACTIONID'];
	}
	
	function page_comment_select($actionid) 
	{
		$actionid = $this->con->real_escape_string($actionid);
		$result=$this->con->query("SELECT COMMENT from comment where ACTIONID='$actionid' ");
		return $result->fetch_array();
	}
	
	function comment_select($pageid,$limit=0,$count=1)
	{
		$pageid = $this->con->real_escape_string($pageid);
		$result=$this->con->query("SELECT * FROM comment INNER JOIN action ON action.ACTIONID = comment.ACTIONID WHERE action.ACTIONID > '$pageid' AND action.PAGEID='$pageid' ORDER BY action.ACTIONID ");
		return $result;
	}
        
    function comment_select_three($pageid,$limit=0,$count=1)
	{   
		$pageid = $this->con->real_escape_string($pageid);
		$result=$this->con->query("SELECT * FROM comment INNER JOIN action ON action.ACTIONID = comment.ACTIONID WHERE action.ACTIONID > '$pageid' AND action.PAGEID='$pageid' ORDER BY action.ACTIONID LIMIT $limit,$count ");
		return $result;
	}
	
	function comment_select_all($pageid,$actionid_third) 
	{
		$pageid = $this->con->real_escape_string($pageid);
		$actionid_third = $this->con->real_escape_string($actionid_third);
		$result=$this->con->query("SELECT * FROM comment INNER JOIN action ON action.ACTIONID = comment.ACTIONID WHERE action.ACTIONID > '$pageid' AND action.PAGEID='$pageid' AND action.ACTIONID < '$actionid_third' ORDER BY action.ACTIONID DESC");
		return $result;
	}
	
	function comment_select_recent($actionid)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$result=$this->con->query("SELECT * FROM comment INNER JOIN action ON comment.ACTIONID = action.ACTIONID WHERE action.ACTIONID='$actionid' ");
		return $result;
	}
	
	function response_select_count($pageid,$rtype)
	{
        $pageid = $this->con->real_escape_string($pageid);
		$rtype = $this->con->real_escape_string($rtype);
		$result=$this->con->query("SELECT COUNT(*) FROM action WHERE PAGEID = '$pageid' AND ACTIONTYPE = '$rtype'");
		return $result->fetch_array();
	}
	

	function response_select($pageid,$rtype,$limit=0,$count=1)
	{
		$pageid = $this->con->real_escape_string($pageid);
		$rtype = $this->con->real_escape_string($rtype);
		$result=$this->con->query("SELECT ACTIONBY FROM action WHERE ACTIONID > '$pageid' AND PAGEID = '$pageid' AND ACTIONTYPE = '$rtype' ORDER BY TIMESTAMP DESC");
		return $result;
	}
        
    function response_mine_check($pageid,$rtype)
	{
		$myprofileid = $_SESSION['USERID'];
		$pageid = $this->con->real_escape_string($pageid);
		$rtype = $this->con->real_escape_string($rtype);
		$result=$this->con->query("SELECT ACTIONBY FROM action WHERE ACTIONID > '$pageid' AND PAGEID = '$pageid' AND ACTIONTYPE = '$rtype' AND ACTIONBY= '$myprofileid' ");
		return $result->fetch_array();
	}
    
	function response_select_recent($pageid,$rtype)
	{   
		$myprofileid = $_SESSION['USERID'];
		$pageid = $this->con->real_escape_string($pageid);
		$rtype = $this->con->real_escape_string($rtype);
		$result=$this->con->query("SELECT ACTIONBY FROM action WHERE ACTIONID > '$pageid' AND PAGEID = '$pageid' AND ACTIONTYPE = '$rtype' AND ACTIONBY = '$myprofileid' ");
		return $result->fetch_array();
	}

	function mate_select($start,$limit=0,$count=1)
	{
		$myschool = $_SESSION['SCHOOL'];
		$mycollege = $_SESSION['COLLEGE'];	
		$result=$this->con->query("SELECT b.PROFILEID,b.NAME,bh.end AS CYEAR FROM bio AS b INNER JOIN bio_history as bh on b.PROFILEID = bh.profileid WHERE bh.diaryid = '$mycollege' ORDER BY bh.end LIMIT $start, 10");
		return $result;
	}
	
	function suggest_select($profileid, $limit)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$limit = $this->con->real_escape_string($limit);
		$result=$this->con->query("SELECT PROFILEID FROM bio WHERE PROFILEID NOT IN ( SELECT FRIENDID FROM friend WHERE PROFILEID ='$profileid' UNION SELECT PROFILEID FROM friend_request WHERE FRIENDID ='$profileid') AND PROFILEID <>'$profileid' ORDER BY RAND() LIMIT $limit");
		return $result;
	}
	function event_suggest($profileid,$limit)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$limit = $this->con->real_escape_string($limit);
		$result=$this->con->query("select e.eventid as eventid,e.name as eventname from event as e where privacy='0' and cancel='0' and eventid not in(select eventid from guest where profileid =$profileid) ORDER BY RAND() LIMIT $limit");
		return $result;
	}
	function group_suggest($profileid,$limit) 
	{
		$profileid = $this->con->real_escape_string($profileid);
		$limit = $this->con->real_escape_string($limit);
		$result=$this->con->query("select g.groupid as groupid ,g.name as groupname from `group` as g where visible ='0' and groupid not in(select groupid from member where profileid ='$profileid' union select groupid from member_request where profileid ='$profileid') ORDER BY RAND() LIMIT $limit");
		return $result; 
	}
	
	function register_user($name,$email,$password)
	{
		$sess_quip = rand(1000000000,9999999999);
		$password = sha1($email.$password);
        $uniqueid = sha1($email.$password."pass1reset!");
		$name = strip_tags($this->con->real_escape_string($name));
		$email = strip_tags($this->con->real_escape_string($email));
		$password = strip_tags($this->con->real_escape_string($password));
		$result = $this->con->query("INSERT INTO signup(EMAIL,PASSWORD,SESS_QUIP,UNIQUEID) VALUES('$email','$password','$sess_quip','$uniqueid')");
		if($result)
		{
			$result=$this->con->query("SELECT USERID,SESS_QUIP FROM signup WHERE EMAIL='$email'");
			$row = $result->fetch_array();
			$profileid = $row['USERID'];
			$quip_i = $row['SESS_QUIP'];
			setcookie("quip_i",$quip_i,time()+3600000,'/','.quipmate.com');
			setcookie("quip_p",$profileid,time()+3600000,'/','.quipmate.com'); 
			if($result)
			{
				$result = array();
				$result = name_split(ucwords(strtolower($name)));
				$fname = $result[0];
				$mname = $result[1];
				$lname = $result[2];
				$result[3] = $profileid;
				
				$res = $this->con->query("INSERT INTO bio(PROFILEID,FNAME,MNAME,LNAME,NAME,EMAIL) VALUES('$profileid','$fname','$mname','$lname','$name','$email')");
				return $result;
			}	
		}
	}
	
	function signup_insert($email,$password,$sess_quip,$uniqueid)
	{
		$email = $this->con->real_escape_string($email);
		$password = $this->con->real_escape_string($password);
		$uniqueid = $this->con->real_escape_string($uniqueid);
		$sess_quip = $this->con->real_escape_string($sess_quip);
		$result = $this->con->query("INSERT INTO signup(EMAIL,PASSWORD,SESS_QUIP,UNIQUEID) VALUES('$email','$password','$sess_quip','$uniqueid')");
		if($result)
		{
			$result=$this->con->query("SELECT USERID FROM signup WHERE EMAIL='$email'");
			$row = $result->fetch_array();
			return $row['USERID'];
		}
	}
	
	function bio_insert($profileid,$email,$name,$fname,$mname,$lname,$gender,$birthday)
	{ 
		$profileid = $this->con->real_escape_string($profileid);
		$email = $this->con->real_escape_string($email);
		$name = $this->con->real_escape_string($name);
		$fname = $this->con->real_escape_string($fname);
		$mname = $this->con->real_escape_string($mname);
		$lname = $this->con->real_escape_string($lname);
		$gender = $this->con->real_escape_string($gender);
		$birthday = $this->con->real_escape_string($birthday);
		$result = $this->con->query("INSERT INTO bio(PROFILEID,FNAME,MNAME,LNAME,NAME,EMAIL,SEX,BIRTHDAY) VALUES('$profileid','$fname','$mname','$lname','$name','$email','$gender','$birthday')");
		if($result)
		{
			$result = $this->con->query("INSERT INTO profile_privacy(PROFILEID) VALUES('$profileid')");
			$result = $this->con->query("INSERT INTO setting_email(PROFILEID) VALUES('$profileid')");
			$result = $this->con->query("INSERT INTO setting_notice(PROFILEID) VALUES('$profileid')");
			return $result;
		}
	}
	
	function school_update($column1,$column2,$school,$year)
	{
		$myprofileid = $_SESSION['USERID'];
		$column1 = $this->con->real_escape_string($column1);
		$column2 = $this->con->real_escape_string($column2);
		$school = $this->con->real_escape_string($school);
		$year = $this->con->real_escape_string($year);
		$result = $this->con->query("UPDATE bio SET `$column1`='$school',`$column2`='$year' WHERE PROFILEID = '$myprofileid'");
		return $result;
	}
	
	function school_mate_count($profileid,$school,$college)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$school = $this->con->real_escape_string($school);
		$college = $this->con->real_escape_string($college);
		$result = $this->con->query("SELECT COUNT(bh.profileid) AS count FROM bio AS b INNER JOIN bio_history AS bh  ON b.PROFILEID = bh.PROFILEID WHERE bh.diaryid='$myschool' OR bh.diaryid = '$mycollege'");
		return $result->fetch_array();
	}
	
	function bio_update($sex,$bday,$city)
	{
		$myprofileid = $_SESSION['USERID'];
		$sex = $this->con->real_escape_string($sex);
		$bday = $this->con->real_escape_string($bday);
		$city = $this->con->real_escape_string($city);
		$result = $this->con->query("UPDATE bio SET SEX = '$sex', BIRTHDAY = '$bday', CITY = '$city' WHERE PROFILEID = '$myprofileid'");
		$result = $this->con->query("INSERT INTO profile_privacy(PROFILEID) VALUES('$myprofileid')");
		return $result;
	}
	
	
	function bio_select($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("SELECT NAME,FNAME,MNAME,LNAME,SEX,DATE_FORMAT(BIRTHDAY,'%a %b,%D %Y') AS BIRTHDAY FROM bio WHERE PROFILEID = '$profileid'");
		return $result->fetch_array();
	}
	
	function bio_complete_select_object($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("SELECT * FROM bio WHERE PROFILEID = '$profileid'");
		$res = $result->fetch_row();
        return $res;
	}
	
	function bio_complete_select($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("SELECT * FROM bio WHERE PROFILEID = '$profileid'");
		$res = $result->fetch_array();
        return $res;
	}
	function bio_select_new($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("SELECT bh.type as type,bh.actionid as actionid,i.name as name FROM info AS i INNER JOIN bio_history AS bh ON i.diaryid = bh.diaryid WHERE bh.profileid ='$profileid' order by actionid desc");
		return $result;
	}
	
	function bio_history_select($actionid)
	{  
		$actionid = $this->con->real_escape_string($actionid);
		$result = $this->con->query("SELECT bh.type as type,bh.actionid as actionid,i.name as name FROM info AS i INNER JOIN bio_history AS bh ON i.diaryid = bh.diaryid WHERE bh.actionid ='$actionid'");
		return $result->fetch_array();
	}
	
	function bio_item_remove($actionid)
	{
		$actionid = strip_tags($this->con->real_escape_string($actionid));	
		return $this->con->query("DELETE FROM action where actionid ='$actionid'");
	}
	
	function bio_field_select($profileid,$field,$actiontype)
	{	
		$profileid = $this->con->real_escape_string($profileid);
		$field = $this->con->real_escape_string($field);
		$actiontype = $this->con->real_escape_string($actiontype);
		$result = $this->con->query("SELECT `$field` FROM bio WHERE PROFILEID = '$profileid'");
		$row = $result->fetch_array();
		return $row[$field];
	}
	
	function bio_item_add($actionid,$myprofileid,$type,$diaryid)/// 201  212
	{
		$myprofileid = strip_tags($this->con->real_escape_string($myprofileid));
		$type = strip_tags($this->con->real_escape_string($type));
		$actionid = strip_tags($this->con->real_escape_string($actionid));
		$diaryid = strip_tags($this->con->real_escape_string($diaryid));
		return $this->con->query("INSERT INTO `bio_history`(`actionid`, `profileid`, `type`, `diaryid`) VALUES ('$actionid','$myprofileid','$type','$diaryid')");	
	}
	
	function update_insert($key,$value)
	{
		$key = strip_tags($this->con->real_escape_string($key));
		$value = strip_tags($this->con->real_escape_string($value));
		$result = $this->con->query("insert into `update`(`key`,value) values('$key', '$value')");	
		return $result;
	}
	
	function update_select($key)
	{ 
		$key = strip_tags($this->con->real_escape_string($key));
		$result = $this->con->query("select value from `update` where `key` = '$key'");
		$row = $result->fetch_array();
		return $row['value'];
	}
	function bio_fielddirect_update($profileid,$field,$value)/// 201  212
	{
		$profileid = $this->con->real_escape_string($profileid);
		$field = strip_tags($this->con->real_escape_string($field));
		$field = strip_tags($this->con->real_escape_string($field));
		$value = strip_tags($this->con->real_escape_string($value));
		$result = $this->con->query("UPDATE bio SET ".$field." = '$value' WHERE PROFILEID = '$profileid'");	
		return $result;
	}
        
	function bio_multi_update($profileid,$field,$value_id,$type)
	{
		$bio = $this->bio_complete_select($profileid);
		$field_value = $bio[$field];
		$update_value = "";
		if($field_value != "" || $field_value != NULL)
		{		
			if(strpos($field_value,$value_id))
				$update_value = $field_value;
			else 
				$update_value = $field_value.":".$value_id;
		}
		else
		{
			$update_value = $value_id;
		}
		
		$result = $this->con->query("UPDATE bio SET ".$field." = '$update_value' WHERE PROFILEID = '$profileid'");	
		return $result;
    }
		
	function user_select($start)
	{
		$result = $this->con->query("SELECT * FROM bio ORDER BY PROFILEID DESC LIMIT $start,10");
		return $result;
	}
	function user_select_all_at_once()
	{
		$result = $this->con->query("SELECT PROFILEID FROM bio" );
		return $result;
	}
	
	function name_update($name,$fname,$mname,$lname,$profileid)
	{
		$name = $this->con->real_escape_string($name);
		$mname = $this->con->real_escape_string($mname);
		$lname = $this->con->real_escape_string($lname);
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("update bio set NAME = '$name',FNAME='$fname',MNAME='$mname',LNAME='$lname' where PROFILEID ='$profileid' ");
		return $result;
	}
	
	function profile_image_insert($actionid,$type,$file,$cdn)
	{
		$myprofileid = $_SESSION['USERID'];
		$type = $this->con->real_escape_string($type);
		$file = $this->con->real_escape_string($file);
		$result = $this->con->query("INSERT INTO `profile_image`(`PROFILEID`, `IMAGEID`, `TYPE`,`CDN`, `FILENAME`) VALUES('$myprofileid','$actionid','$type','$cdn','$file')");
		return $result;
	}
	
	function moment_insert($profileid,$actionid,$count,$name,$desc)
	{
		$myprofileid = $_SESSION['USERID'];
		$profileid = $this->con->real_escape_string($profileid);
		$actionid = $this->con->real_escape_string($actionid);
		$count = $this->con->real_escape_string($count);
		$name = strip_tags($this->con->real_escape_string($name));
		$desc = strip_tags($this->con->real_escape_string($desc));
		$caption = $_SESSION['NAME'];
		$result = $this->con->query("INSERT INTO moment(PROFILEID,ACTIONID,ACTIONBY,COUNT,NAME,DESCRIPTION) VALUES('$profileid','$actionid','$myprofileid','$count','$name','$desc')");
		if($result)
		{
			$res = $this->con->query("SELECT MOMENTID FROM moment WHERE ACTIONBY='$myprofileid' ORDER BY ACTIONID DESC LIMIT 1 ");
			$mres = $res->fetch_array();
			return $mres['MOMENTID'];
		}
		return 0;
	}
	
	function moment_info($momentid)
	{
		$momentid = $this->con->real_escape_string($momentid);
		$result = $this->con->query("SELECT * FROM moment WHERE MOMENTID = '$momentid' ");
		return $result->fetch_array();
	}
	
	function moment_load($profileid,$limit,$count=4)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("SELECT * FROM moment WHERE PROFILEID = '$profileid' ORDER BY TIMESTAMP DESC LIMIT $limit,$count ");
		return $result;
	}
	
	function moment_cover_select($momentid)
	{	
		$momentid = $this->con->real_escape_string($momentid);
		$result = $this->con->query("SELECT * FROM image WHERE MOMENTID = '$momentid' ORDER BY TIMESTAMP DESC LIMIT 1 ");
		return $result->fetch_array();
	}
	
	function moment_select($actionid)
	{	
		$actionid = $this->con->real_escape_string($actionid);
		$result = $this->con->query("SELECT * FROM moment WHERE actionid = '$actionid' ");
		return $result->fetch_array();
	}
	
	function moment_image_select($momentid)
	{	
		$momentid = $this->con->real_escape_string($momentid);
		return $this->con->query("SELECT * FROM image WHERE momentid = '$momentid' ");
	}
	
	function image_insert($profileid,$actionid,$file,$momentid=0,$cdn=1)
	{
		$myprofileid = $_SESSION['USERID'];
		$file = $this->con->real_escape_string($file);
		$profileid = $this->con->real_escape_string($profileid);
		$actionid = $this->con->real_escape_string($actionid);
		$result = $this->con->query("INSERT INTO `image`(`profileid`, `imageid`, `actionby`, `cdn`, `momentid`, `filename`) VALUES('$profileid','$actionid','$myprofileid','$cdn','$momentid','$file')");
		return $result;
	}
	function video_insert($profileid,$videoid,$file,$cdn,$thumbnail='')
	{
		$myprofileid = $_SESSION['USERID'];
		$file = $this->con->real_escape_string($file);
		$profileid = $this->con->real_escape_string($profileid);
		$videoid = $this->con->real_escape_string($videoid);
		$thumbnail = $this->con->real_escape_string($thumbnail);
		$result = $this->con->query("INSERT INTO video(profileid,videoid,actionby,cdn,filename,thumbnail) VALUES('$profileid','$videoid','$myprofileid','$cdn','$file','$thumbnail')");
		return $result;
	}
	function doc_insert($profileid,$docid,$file,$caption,$cdn)
	{
		$myprofileid = $_SESSION['USERID'];
		$file = $this->con->real_escape_string($file);
		$profileid = $this->con->real_escape_string($profileid);
		$actionid = $this->con->real_escape_string($actionid);
		$result = $this->con->query("INSERT INTO `document`(`profileid`, `docid`, `actionby`, `cdn`, `filename`, `caption`) VALUES('$profileid','$docid','$myprofileid','$cdn','$file','$caption')");
		return $result;
	}
	function video_select($actionid)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$result = $this->con->query("SELECT * FROM video WHERE videoid = '$actionid' ");
		return $result->fetch_array();
	}
	function doc_select($actionid)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$result = $this->con->query("SELECT * FROM document WHERE docid = '$actionid' ");
		return $result->fetch_array();
	}
	function image_load($profileid,$limit,$count=4)
	{	
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("SELECT * FROM image WHERE PROFILEID = '$profileid' ORDER BY TIMESTAMP DESC LIMIT $limit,$count ");
		return $result;
	}
	
	function image_view($profileid,$actionid)
	{	
		$profileid = $this->con->real_escape_string($profileid);
		$actionid = $this->con->real_escape_string($actionid);
		$result = $this->con->query("SELECT * FROM image WHERE imageid = '$actionid' ");
		return $result->fetch_array();
	}
	
	function image_select($actionid)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$result = $this->con->query("SELECT * FROM image WHERE imageid = '$actionid' ");
		return $result->fetch_array();
	}
	
	function friend_select($profileid)
	{	
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT FRIENDID FROM friend WHERE PROFILEID = '$profileid'");
		return $result;
	}
	
	function is_friend($profileid1, $profileid2)
	{	
		$profileid1 = $this->con->real_escape_string($profileid1);
		$profileid2 = $this->con->real_escape_string($profileid2);		
		return $this->con->query("SELECT FRIENDID FROM friend WHERE PROFILEID = '$profileid1' and FRIENDID = '$profileid2' ");
	}

    function friend_count($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT COUNT(*) FROM friend WHERE PROFILEID = '$profileid'");
		$res =  $result->fetch_array();
		return $res['COUNT(*)'];
	}

    function friend_match($myprofileid,$profileid,$limit=0,$count=16)
	{	
		$profileid = $this->con->real_escape_string($profileid);
		$myprofileid = $this->con->real_escape_string($myprofileid);
		$result=$this->con->query("SELECT FRIENDID FROM friend WHERE PROFILEID = '$profileid' AND FRIENDID IN (SELECT FRIENDID FROM friend WHERE PROFILEID = '$myprofileid') ORDER BY FRIENDID LIMIT $limit,$count");
		return $result;
	}
	
	function friend_match_count($myprofileid,$profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$myprofileid = $this->con->real_escape_string($myprofileid);
		$result=$this->con->query("SELECT count(*) FROM friend WHERE PROFILEID = '$profileid' AND FRIENDID IN (SELECT FRIENDID FROM friend WHERE PROFILEID = '$myprofileid') ORDER BY FRIENDID ");
		$res =  $result->fetch_array();
		return $res['count(*)'];
	}
        
    function friend_non_match($myprofileid,$profileid,$limit=0,$count=16)
	{	
		$myprofileid = $this->con->real_escape_string($myprofileid);
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT FRIENDID FROM friend WHERE PROFILEID = '$profileid' AND FRIENDID NOT IN (SELECT FRIENDID FROM friend WHERE PROFILEID = '$myprofileid') AND FRIENDID <> '$myprofileid' ORDER BY FRIENDID LIMIT $limit,$count");
		return $result;
	}
		
	function friend_non_match_count($myprofileid,$profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$myprofileid = $this->con->real_escape_string($myprofileid);
		$result=$this->con->query("SELECT count(*) FROM friend WHERE PROFILEID = '$profileid' AND FRIENDID NOT IN(SELECT FRIENDID FROM friend WHERE PROFILEID = '$myprofileid') ORDER BY FRIENDID ");
		$res =  $result->fetch_array();
		return $res['count(*)'] -1;
	}
	
	function friend_select_incremental($profileid,$limit,$count=15)
	{	
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT FRIENDID FROM friend WHERE PROFILEID = '$profileid' ORDER BY TIMESTAMP DESC LIMIT $limit,$count ");
		 return $result;
	}
	
	function invited_friend_insert($profileid,$friendid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$friendid = $this->con->real_escape_string($friendid);
		$result1 = $this->con->query("INSERT INTO friend(PROFILEID,FRIENDID) VALUES('$profileid','$friendid')");
		$result1 = $this->con->query("INSERT INTO friend(PROFILEID,FRIENDID) VALUES('$friendid','$profileid')");
		$result1 = $this->con->query("INSERT INTO subscribe(PROFILEID,FRIENDID) VALUES('$profileid','$friendid')");
		$result1 = $this->con->query("INSERT INTO subscribe(PROFILEID,FRIENDID) VALUES('$friendid','$profileid')");
		return $result1;
	}
	
	function friend_insert($profileid,$friendid)
	{
		
		$profileid = $this->con->real_escape_string($profileid);
		$friendid = $this->con->real_escape_string($friendid);
		$status = $this->check_friendship($profileid,$friendid);
		if($status=='1' || $status == '-1')
		{
			$result1 = $this->con->query("INSERT INTO friend(PROFILEID,FRIENDID) VALUES('$profileid','$friendid')");
			$result1 = $this->con->query("INSERT INTO friend(PROFILEID,FRIENDID) VALUES('$friendid','$profileid')");
			$result1 = $this->con->query("INSERT INTO subscribe(PROFILEID,FRIENDID) VALUES('$profileid','$friendid')");
			$result1 = $this->con->query("INSERT INTO subscribe(PROFILEID,FRIENDID) VALUES('$friendid','$profileid')");
			 return $result1;
		}
		else
		{
			 return $status;
		}		
	}

    function friend_delete($friendid)
	{
	    $myprofileid = $_SESSION['USERID'];
		$friendid = $this->con->real_escape_string($friendid);
		$myprofileid = $this->con->real_escape_string($myprofileid);	
		$result1 = $this->con->query("DELETE FROM friend WHERE PROFILEID='$myprofileid' AND FRIENDID='$friendid' ");
		$result1 = $this->con->query("DELETE FROM friend WHERE PROFILEID='$friendid' AND FRIENDID='$myprofileid'");
		$result1 = $this->con->query("DELETE FROM subscribe WHERE PROFILEID='$myprofileid' AND FRIENDID='$friendid' ");
		$result1 = $this->con->query("DELETE FROM subscribe WHERE PROFILEID='$friendid' AND FRIENDID='$myprofileid'");
		return $result1;
	}
	
	function action_ownership_check($actionid, $profileid)
	{
        $actionid= $this->con->real_escape_string($actionid);
        $profileid= $this->con->real_escape_string($profileid);		
		$result=$this->con->query("SELECT count(ACTIONID) from action WHERE (ACTIONID ='$actionid' and PROFILEID ='$profileid') OR (ACTIONID ='$actionid' and ACTIONBY ='$profileid') ");
		$row = $result->fetch_array();
		return $row['count(ACTIONID)'];
	}
	function action_ownership_check_inbox($actionid, $profileid)
	{
        $actionid= $this->con->real_escape_string($actionid);
        $profileid= $this->con->real_escape_string($profileid);		
		$result=$this->con->query("SELECT count(ACTIONID) from inbox WHERE (ACTIONID ='$actionid' and ACTIONON ='$profileid') OR (ACTIONID ='$actionid' and ACTIONBY ='$profileid') ");
		$row = $result->fetch_array();
		return $row['count(ACTIONID)'];
	}
	
    function action_delete($actionid)
	{
        $actionid= $this->con->real_escape_string($actionid);
		$result=$this->con->query("DELETE FROM action WHERE ACTIONID ='$actionid' OR PAGEID ='$actionid'");
		return $result;
	}
	function message_delete($actionid,$myprofileid)
	{
		$actionid= $this->con->real_escape_string($actionid);
		$myprofileid= $this->con->real_escape_string($myprofileid);
		$result=$this->con->query("update inbox set flag_by = CASE WHEN ACTIONBY ='$myprofileid' THEN '0' ELSE '1' END, flag_on = CASE WHEN ACTIONON = '$myprofileid' THEN '0' ELSE '1' END Where ACTIONID='$actionid' ");
		return $result;
	}
	
	function response_delete($pageid,$rtype,$profileid)
	{
        $pageid= $this->con->real_escape_string($pageid);
		$profileid= $this->con->real_escape_string($profileid);
        $rtype= $this->con->real_escape_string($rtype);
		$result=$this->con->query("DELETE FROM action WHERE PAGEID ='$pageid' AND ACTIONBY ='$profileid' AND ACTIONTYPE='$rtype' ");
		return $result;
	}
	
    function get_excited_action($actionid,$actiontype)
	{
        $actionid= $this->con->real_escape_string($actionid);
        $actiontype= $this->con->real_escape_string($actiontype);
		$res = $this->con->query("SELECT ACTIONBY FROM action WHERE ACTIONID > '$actionid' AND PAGEID = '$actionid' AND ACTIONTYPE = '$actiontype' ORDER BY TIMESTAMP DESC");
		return $res;
	}	
	
	function friend_invite_insert($actionid,$profileid,$myprofileid)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$profileid = $this->con->real_escape_string($profileid);
		$myprofileid = strip_tags($this->con->real_escape_string($myprofileid));
		return $this->con->query("INSERT INTO friend_request(ACTIONID,PROFILEID,FRIENDID) VALUES($actionid,'$profileid','$myprofileid')");
	}
	
	function friend_invite_delete($profileid,$frndreq)
	{
			$profileid = $this->con->real_escape_string($profileid);
			$frndreq = $this->con->real_escape_string($frndreq);
			$result = $this->con->query("DELETE FROM friend_request WHERE PROFILEID='$profileid' AND FRIENDID ='$frndreq'");
			 return $result;
	}
	
	function friend_check($profileid1,$profileid2)
	{
	
		if($profileid1 == $profileid2)
		{
			return -1;
		}
		$fresult= $this->friend_select($profileid1);
		while($row=$fresult->fetch_array())
		{
			if($profileid2== $row['FRIENDID'])
			{
				return 1;
			}
		}
			return 0;
	}
	
	function guest_status($profileid1,$profileid2)
	{
		$profileid1 = $this->con->real_escape_string($profileid1);
		$profileid2 = $this->con->real_escape_string($profileid2);
		$n = $this->event_select($profileid1);
		if($n['host'] == $profileid2)
		{
			return 0;
		}
		$frow = $this->is_host($profileid1, $profileid2);
		if($frow)
		{
			if($frow['priviledge'] == 1)
			{
				return 1;
			}
			else if($frow['priviledge'] == 0)
			{
				return 2;
			}
			else if($frow['priviledge'] == 2)
			{
				return 3;
			}
		}
	    return 4;
	}
	function follower_status($profileid1,$profileid2)
	{
		$frow = $this->is_page_admin($profileid1, $profileid2);
		if($frow)
		{
			if($frow['priviledge'] == 1)
			{
				return 0;
			}
			else if($frow['priviledge'] == 0)
			{
				return 1;
			}
		}
		else
		{
			return 3;
		}
	}	
	function membership_status($profileid1,$profileid2)
	{
		$frow = $this->is_group_admin($profileid1, $profileid2);
		if($frow)
		{
			if($frow['priviledge'] == 1)
			{
				return 0;
			}
			else if($frow['priviledge'] == 0)
			{
				return 1;
			}
		}
		else
		{
			$fresult = $this->member_request_select($profileid1, $profileid2);
			$row=$fresult->fetch_array();
			{
				if($profileid2 == $row['profileid'])
				{
					return 2;
				}
			}
			return 3;
		}
	}
			
	/*
	 1 , -1  request exchanged
	 2  friend 
	 3 same
	 0 no relationship
	*/
	function check_friendship($profileid1,$profileid2)
	{
	
	if($profileid1 == $profileid2)
	{
		return 3;
	}
		$status = 0;
		$fresult= $this->friend_select($profileid1);
		while($row=$fresult->fetch_array())
		{
			if($profileid2== $row['FRIENDID'])
			{
				$status = 2;
				break;
			}
		}
	$fresult = $this->friend_invite_select($profileid1);
		while($row=$fresult->fetch_array())
		{
			if($profileid2 == $row['FRIENDID'])
			{
				$status = 1;
				break;
			}
			
		}	
		
	$fresult = $this->friend_invite_select($profileid2);
		while($row=$fresult->fetch_array())
		{
			if($profileid1 == $row['FRIENDID'])
			{
				$status = -1;
				break;
			}
			
		}
	       return $status;
	}
	
	function relation_check($profileid)
	{
	
		$myprofileid = $_SESSION['USERID'];
		if($profileid == $myprofileid)
		{
			 return 3;
		}
		
		$profileid = $this->con->real_escape_string($profileid);
		$res=$this->con->query("SELECT FRIENDID FROM friend WHERE PROFILEID = '$myprofileid' AND FRIENDID = '$profileid' ");
		$result = $res->fetch_array();
		if($profileid == $result['FRIENDID'])
		{
			return 2;
		}
		else
		{
			$res = $this->friend_select($myprofileid);
			while($result = $res->fetch_array())
			{
				 $fres = $this->friend_select($result['FRIENDID']);
				 while($fresult = $fres->fetch_array())
				 {
					if($profileid == $fresult['FRIENDID'])
					{
						 return 1;
					}
				 }
			}
			return 0;
		}
	}
	
	
	function privacy_select($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT * FROM profile_privacy WHERE PROFILEID ='$profileid' ");
		$result = $result->fetch_array();
		return $result;
	}
	
	function setting_notice_field_select($field, $myprofileid)
	{
		$field = $this->con->real_escape_string($field);
		$myprofileid = $this->con->real_escape_string($myprofileid);
		$result = $this->con->query("select `$field` from setting_notice WHERE PROFILEID = '$myprofileid'");
		return $result->fetch_array();
	}
	function setting_feature_field_select($field)
	{
		$field = $this->con->real_escape_string($field);
		$result = $this->con->query("select flag from feature WHERE name = '$field'");
		return $result->fetch_array();
	}
	
	function setting_notice_update($field, $privacy, $myprofileid)
	{
		$field = $this->con->real_escape_string($field);
		$privacy = $this->con->real_escape_string($privacy);
		$myprofileid = $this->con->real_escape_string($myprofileid);
		return $this->con->query("UPDATE setting_notice SET `$field` = '$privacy' WHERE PROFILEID = '$myprofileid'");
	}
	function setting_feature_update($field,$flag)
	{
		$field = $this->con->real_escape_string($field);
		$flag = $this->con->real_escape_string($flag);
		return $this->con->query("UPDATE feature SET flag = '$flag' where name='$field'");
	}
	
	function setting_email_field_select($field, $myprofileid)
	{
		$field = $this->con->real_escape_string($field);
		$myprofileid = $this->con->real_escape_string($myprofileid);
		$result = $this->con->query("select `$field` from setting_email WHERE PROFILEID = '$myprofileid'");
		return $result->fetch_array();
	}
	
	function setting_email_update($field, $privacy, $myprofileid)
	{
		$field = $this->con->real_escape_string($field);
		$privacy = $this->con->real_escape_string($privacy);
		$myprofileid = $this->con->real_escape_string($myprofileid);
		return $this->con->query("UPDATE setting_email SET `$field` = '$privacy' WHERE PROFILEID = '$myprofileid'");
	}
	
	function profile_privacy_update($field, $privacy, $myprofileid)
	{
		$field = $this->con->real_escape_string($field);
		$privacy = $this->con->real_escape_string($privacy);
		$myprofileid = $this->con->real_escape_string($myprofileid);
		return $this->con->query("UPDATE profile_privacy SET `$field` = '$privacy' WHERE PROFILEID = '$myprofileid'");
	}
	
	function privacy_item_select($item,$profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$item = $this->con->real_escape_string($item);
		$result=$this->con->query("SELECT `$item` FROM profile_privacy WHERE PROFILEID ='$profileid' ");
		$result = $result->fetch_array();
		 return $result[$item];
	}
	
	function get_age($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(BIRTHDAY)),'%y') AS AGE FROM bio WHERE PROFILEID = '$profileid'");
		$result= $result->fetch_array();
		return $result['AGE'];
	}
	
	function friend_invite_select($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT FRIENDID FROM friend_request WHERE PROFILEID = '$profileid' ORDER BY TIMESTAMP DESC");
		return $result;
	}
	
	function profile_friend_invite_select()
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT PROFILEID FROM friend_request GROUP BY PROFILEID");
		return $result;
	}
	
	function birthday_bomb_select_actionid($actionid)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$result=$this->con->query("SELECT * FROM birthday_bomb WHERE ACTIONID ='$actionid' ");
		return $result->fetch_array();
	}
	
	function birthday_bomb_select($profileid,$date)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$date = $this->con->real_escape_string($date);
		$result=$this->con->query("SELECT * FROM birthday_bomb WHERE PROFILEID ='$profileid' AND DATE = '$date' ");
		return $result;
	}
	
	function birthday_bomb_insert($actionid,$profileid,$actionby,$date)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$profileid = $this->con->real_escape_string($profileid);
		$actionby = $this->con->real_escape_string($actionby);
		$date = $this->con->real_escape_string($date);
		$result=$this->con->query("INSERT INTO birthday_bomb(ACTIONID,PROFILEID,ACTIONBY,DATE) VALUES('$actionid','$profileid','$actionby','$date') ");
		return $result;
	}
	
	function entry_insert($actionid,$profileid,$date,$entry)
	{
		$actionid = $this->con->real_escape_string($actionid);
		$profileid = $this->con->real_escape_string($profileid);
		$date = $this->con->real_escape_string($date);
		$entry = $this->con->real_escape_string($entry);
		$result=$this->con->query("INSERT INTO entry(ACTIONID,PROFILEID,ENTRY,DATE) VALUES('$actionid','$profileid','$entry','$date') ");
		return $result;
	}
	
	function get_name($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT NAME FROM bio WHERE PROFILEID ='$profileid'");
		 return $result->fetch_array();
	}
	function get_group($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT NAME FROM `group` WHERE groupid ='$profileid'");
		 return $result->fetch_array();
	}
	function get_group_members($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT gp.profileid AS PROFILEID FROM member AS gp INNER JOIN setting_email AS sm ON gp.profileid = sm.profileid AND sm.group_post =1 WHERE gp.groupid ='$profileid'");
		return $result;
	} 
	function sex_select($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT SEX FROM bio WHERE PROFILEID ='$profileid'");
		$r = $result->fetch_array();
		return $r['SEX'];
	}
	
	function get_image($profileid,$sex=1,$type=1) 
	{ 		
		$profileid = $this->con->real_escape_string($profileid); 		
		$result=$this->con->query("SELECT CDN,FILENAME,IMAGEID FROM profile_image WHERE PROFILEID = '$profileid' ORDER BY IMAGEID DESC LIMIT 1"); 	
		if(!$result->num_rows)
		{		
			if($sex)
			{
				$result = $this->con->query("SELECT 'http://profile-1.qmcdn.net/' as CDN,'male.png' AS FILENAME"); 		 
			}
			else
			{
				$result = $this->con->query("SELECT 'http://profile-1.qmcdn.net/' as CDN,'female.png' AS FILENAME");
			}	
		}
		return $result->fetch_array(); 		
	}
	
	function log()
	{
		$myprofileid = $_SESSION['USERID'];
		$browser = $_SERVER['HTTP_USER_AGENT'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$result = $this->con->query("INSERT INTO log(PROFILEID,IP,BROWSER) VALUES('$myprofileid','$ip','$browser')");
		return $result;
	}
	
	function sneaker_insert($profileid)
	{
		$myprofileid = $_SESSION['USERID'];
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("INSERT INTO sneaker(PROFILEID,SNEAKER) VALUES('$profileid','$myprofileid')");
		return $result;
	}
	
	function sneaker_select($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result=$this->con->query("SELECT COUNT(SNEAKER),SNEAKER,DATE_FORMAT(TIMESTAMP,'%b,%d') AS DATE, DATE_FORMAT(TIMESTAMP,'%l:%i %p') AS TIME FROM sneaker WHERE PROFILEID = '$profileid' GROUP BY SNEAKER ORDER BY TIMESTAMP DESC");
		return $result;
	}
	
	function profile_search($k,$start)
	{
		$k = $this->con->real_escape_string($k);
		$result = $this->con->query("SELECT PROFILEID,NAME FROM bio WHERE NAME REGEXP '^$k' OR LNAME REGEXP '^$k' LIMIT $start,10");
		return $result;
	}
	
	function group_search($k,$start)
	{
		$k = $this->con->real_escape_string($k);
		return $this->con->query("SELECT * FROM `group` WHERE (name REGEXP '^$k') OR (description REGEXP '^$k') LIMIT $start,10");
	}
	
	function event_search($k,$start)
	{
		$k = $this->con->real_escape_string($k);
		return $this->con->query("SELECT * FROM `event` WHERE ((name REGEXP '^$k') OR (description REGEXP '^$k')) AND cancel='0' LIMIT $start,10");
	}

	function post_search($k,$start)
	{
		$k = $this->con->real_escape_string($k);
		return $this->con->query("SELECT * FROM action inner join diary on action.actionid = diary.actionid WHERE page like '%$k%' LIMIT $start,10");
	}
	function bio_history_search($type,$k,$start)
	{
		$k = $this->con->real_escape_string($k);
		$type = $this->con->real_escape_string($type);
		return $this->con->query("SELECT i.name as skill,bh.profileid as profileid FROM `info` as i INNER JOIN bio_history as bh on i.DIARYID = bh.diaryid WHERE i.type='$type' and (i.name REGEXP '^$k') LIMIT $start,10 ");
	}
	
	function comment_search($k,$start)
	{
		$k = $this->con->real_escape_string($k);
		return $this->con->query("SELECT * FROM action inner join comment on action.actionid = comment.actionid WHERE comment like '%$k%' LIMIT $start,10");
	}
	
	function song_search($k,$limit,$count)
	{
		$k = $this->con->real_escape_string($k);
		$limit = $this->con->real_escape_string($limit);
		$result = $this->con->query("SELECT * FROM song WHERE SONG REGEXP '^$k' LIMIT $limit,$count");
		return $result;
	}
	
	function friend_search($profileid,$k,$limit=5)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$k = $this->con->real_escape_string($k);
		$limit = $this->con->real_escape_string($limit);
		$result = $this->con->query("SELECT friend.FRIENDID AS PROFILEID FROM friend inner join bio on friend.FRIENDID = bio.PROFILEID WHERE friend.PROFILEID ='$profileid' AND ( bio.NAME REGEXP '^$k' OR bio.LNAME REGEXP '^$k') LIMIT $limit");
		return $result;
	}
	
	function profile_full_search($k)
	{
		$k = $this->con->real_escape_string($k);
		$result = $this->con->query("SELECT PROFILEID,NAME FROM bio WHERE FNAME REGEXP '^$k' OR LNAME REGEXP '^$k' ");
		return $result;
	}
	
	function profile_email_search($k)
	{
		$k = $this->con->real_escape_string($k);
		$result = $this->con->query("SELECT PROFILEID,NAME FROM bio WHERE EMAIL = '$k' LIMIT 7");
		return $result;
	}

	function diary_search($k)
	{
		$k = $this->con->real_escape_string($k);
		$result = $this->con->query("SELECT DIARYID FROM info WHERE NAME REGEXP '^$k' LIMIT 3");
		return $result;
	}
	function privacy_profile_update($post,$see,$photo,$friendlist)
	{
		$myprofileid = $_SESSION['USERID'];
		$post = $this->con->real_escape_string($post);
		$see = $this->con->real_escape_string($see);
		$photo = $this->con->real_escape_string($photo);
		$friendlist = $this->con->real_escape_string($friendlist);
		$result = $this->con->query("UPDATE profile_privacy SET POST='$post',POST_SEE='$see',PHOTO = '$photo',FRIEND_LIST='$friendlist' WHERE PROFILEID = '$myprofileid'");
		return $result;
	}
	
	function notice_unread_count($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("SELECT COUNT(*) FROM notice WHERE READBIT ='0' AND PROFILEID = '$profileid' AND ACTIONBY <> '$profileid' ");
		$num = $result->fetch_array();
		return $num['COUNT(*)'];
	}
	
	function notice_read($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		return $this->con->query("UPDATE notice SET READBIT = '1' WHERE PROFILEID = '$profileid' AND READBIT = '0'");
	}
	
	function noofallnotices($profileid)
	{	
		$profileid = $this->con->real_escape_string($profileid);
		$result = $this->con->query("SELECT COUNT(*) FROM notice WHERE PROFILEID = '$profileid' AND ACTIONBY != '$profileid' AND READBIT = '0' ");
		$num = $result->fetch_array();
	    return $num['COUNT(*)'];
	}
	
	function notice_select($profileid,$limit=0,$count=10)
	{	
		$profileid = $this->con->real_escape_string($profileid);
		$limit = $this->con->real_escape_string($limit);
		$count = $this->con->real_escape_string($count);
		$result = $this->con->query("SELECT MAX(ACTIONID) AS ACTIONID,PROFILEID,GROUP_CONCAT(DISTINCT ACTIONBY) ACTIONBY,PAGEID,ACTIONTYPE,MAX(TIMESTAMP) as TIMESTAMP FROM notice INNER JOIN actiontype on actiontype.actiontypeid = notice.actiontype  WHERE PROFILEID = '$profileid' AND ACTIONBY != '$profileid'and actiontype.notice_feed ='1'	GROUP BY PAGEID,ACTIONTYPE ORDER BY ACTIONID DESC LIMIT $limit,$count");
		return $result;
	} 
	
	function retrievenotices_all($profileid,$start)
	{	
		$profileid = $this->con->real_escape_string($profileid);
		$start = $this->con->real_escape_string($start);
		$result = $this->con->query("SELECT * FROM notice WHERE PROFILEID = '$profileid' AND ACTIONBY != '$profileid' ORDER BY TIMESTAMP DESC LIMIT $start,30");
		return $result;
	}
	
	function update_readbit($actionid)
	{
		$actionid = $this->con->real_escape_string($actionid);
		return $this->con->query("UPDATE notice SET READBIT = '1' WHERE ACTIONID = '$actionid'");
	}
	
	function update_friend_request_readbit()
	{
		$myprofileid=$_SESSION['USERID'];
		 return $this->con->query("UPDATE notice SET READBIT = '1' WHERE PROFILEID='$myprofileid' AND READBIT='0' ORDER BY ACTIONID DESC LIMIT 10");
	}
	
    function birthday_select($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result= $this->con->query("SELECT NAME,bio.PROFILEID,BIRTHDAY FROM friend INNER JOIN bio ON
	      friend.FRIENDID = bio.PROFILEID
		WHERE friend.PROFILEID='$profileid'
AND DATE_FORMAT(bio.BIRTHDAY,'%m,%d') BETWEEN DATE_FORMAT(NOW(),'%m,%d') AND DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 8 WEEK),'%m,%d') ORDER BY DATE_FORMAT(BIRTHDAY,'%m,%d')");
		 return $result;
	}

	function birthday_select_prev($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result= $this->con->query("SELECT bio.PROFILEID,NAME,DATE_FORMAT(BIRTHDAY,'%b,%d') AS BIRTHDAY FROM friend INNER JOIN bio ON
	      friend.FRIENDID = bio.PROFILEID
		WHERE friend.PROFILEID='$profileid'
AND DATE_FORMAT(BIRTHDAY,'%m,%d') < DATE_FORMAT(NOW(),'%m,%d') ORDER BY DATE_FORMAT(BIRTHDAY,'%m,%d')");
		 return $result;
	}
	
	function birthday_select_next($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$result= $this->con->query("SELECT bio.PROFILEID,NAME,DATE_FORMAT(BIRTHDAY,'%b,%d') AS BIRTHDAY FROM friend INNER JOIN bio ON
	      friend.FRIENDID = bio.PROFILEID
		WHERE friend.PROFILEID='$profileid'
AND DATE_FORMAT(BIRTHDAY,'%m,%d') >= DATE_FORMAT(NOW(),'%m,%d') ORDER BY DATE_FORMAT(BIRTHDAY,'%m,%d')");
		 return $result;
	}
	
	function setting_email_select($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$res= $this->con->query("SELECT * from setting_email where profileid='$profileid'");
		return $res->fetch_array();
	}
	
	function setting_notice_select($profileid)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$res= $this->con->query("SELECT * from setting_notice where profileid='$profileid'");
		return $res->fetch_array();
	}
	function setting_feature_select()
	{
		$res= $this->con->query("SELECT * from feature where flag='1'");
		return $res;
	}
	
	function setting_email_complete_update($profileid, $friend_request, $profile_post, $post_comment, $message, $missu)
	{
		$profileid = $this->con->real_escape_string($profileid);
		$friend_request = $this->con->real_escape_string($friend_request);
		$profile_post = $this->con->real_escape_string($profile_post);	
		$post_comment = $this->con->real_escape_string($post_comment);		
		$message = $this->con->real_escape_string($message);
		$missu = $this->con->real_escape_string($missu);
		$result = $this->con->query("update setting_email set FRIEND_REQUEST = '$friend_request', PROFILE_POST='$profile_post', POST_COMMENT='$post_comment', MESSAGE='$message', MISSU='$missu' where PROFILEID='$profileid' ");
		return $result;
	}
		
	function setting_email_json_select($key)
	{
		$key = $this->con->real_escape_string($key);
		$res= $this->con->query("select * from setting_email_json where `key` ='$key' ");
		return $res->fetch_array();
	}
	
	function setting_email_json_update($key, $value)
	{
		$key = $this->con->real_escape_string($key);
		$value = $this->con->real_escape_string($value);
		$result = $this->con->query("update setting_email_json set value='$value' where `key` ='$key' ");
		return $result;
	}
	
	function session_read($sessionid)
	{
		$sessionid = $this->con->real_escape_string($sessionid);
		$result= $this->con->query("select data from session where sessionid='$sessionid' ");
		$row = $result->fetch_array();
		return $row['data'];
	}
	
	function session_write($sessionid, $profileid, $time, $ip, $user_agent, $data)
	{
		$sessionid = $this->con->real_escape_string($sessionid);
		return $this->con->query("replace into session(sessionid, profileid, time, ip, user_agent, data) values('$sessionid', '$profileid', '$time', '$ip', '$user_agent', '$data') ");
	}
	
	function session_destroy($sessionid)
	{
		$sessionid = $this->con->real_escape_string($sessionid);
		return $this->con->query("delete from ssssion where sessionid='$sessionid' ");
	}
}
?>