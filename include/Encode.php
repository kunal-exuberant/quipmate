<?php
class Encode
{ 
function reply_encode($actionid, $help, $database, $memcache)
	{
		$k=0;
		$reply=array();
		$result = $database->reply_select($actionid);
		$json = new Json();
		while($res =$result->fetch_array())
		{
		    $reply[$k]['actionid']=$res['ACTIONID'];
			$reply[$k]['actionby']=$res['ACTIONBY'];			
			$name[$reply[$k]['actionby']] = $help->name_fetch($reply[$k]['actionby'], $memcache, $database);
			$pimage[$reply[$k]['actionby']] = $help->pimage_fetch($reply[$k]['actionby'], $memcache, $database); 
			$reply[$k]['reply']=$res['MESSAGE'];
			$reply[$k]['time']= $help->get_time($res['TIMESTAMP']);
			$k++;
		}
		return $reply;
	}
	
	function birthday_encode($pageid,$database)
	{
			$return = array();
			$rw = $database->birthday_bomb_select_actionid($pageid);
			$return['date'] = $rw['DATE'];
			$rd = $database->diary_select($pageid);
			$return['page'] = $rd['PAGE'];
			return $return;
	}
	
	function song_encode($pageid,$database)
	{
			$return = array();
			$rw = $database->song_select($pageid);
			$return['song'] = $rw['SONG'];
			$return['file'] = $rw['FILENAME'];
			$return['page'] = $rw['PAGE'];
			return $return;
	}
	
	function link_encode($pageid,$database)
	{
			$return = array();
			$rw = $database->link_select($pageid);
			if(isset($rw['TITLE']))
			{
				$return['title'] = $rw['TITLE'];
			}
			else
			{
				$return['title'] = '';
			}
			if(isset($rw['META']))
			{
				$return['meta'] = $rw['META'];
			}
			else
			{
				$return['meta'] = '';
			}
			$return['link'] = $rw['LINK'];
			$parse = parse_url($return['link']);
			$return['host'] = $parse['host'];
			if($return['host'] == 'youtu.be')
			{
				$return['video'] = 1;
				$path = explode($return['host'],$return['link']);
				$return['file'] = $path[1];
			}
			else if($return['host'] == 'www.youtube.com')
			{
				$return['video'] = 1;
				$path = explode('v=',$return['link']);
				$path = explode('&',$path[1]);
				$return['file'] = $path[0];
			}
			else
			{
				$return['video'] = 0;
				if(isset($rw['FILENAME']))
				{
					$return['file'] = $rw['FILENAME'];
				}
				else
				{
					$return['file'] = '';
				}
			}
			$return['page'] = $rw['PAGE'];
			return $return;
	}

    function gift_encode($pageid,$database)
	{
			$return = array();
			$rw = $database->gift_select($pageid);
			$return['gift'] = $rw['GIFT'];
			$return['file'] = $rw['FILENAME'];
			$return['page'] = $rw['PAGE'];
			return $return;
	}   
	
	function mood_encode($pageid,$database)
	{
			$return = array();
			$rw = $database->mood_select($pageid);
			$return['mood'] = $rw['MOOD'];
			$return['file'] = $rw['FILENAME'];
			$return['page'] = $rw['PAGE'];
			return $return;
	}
	
	function profile_edit_encode($profileid,$actiontype,$actionid,$database)
	{
			$return = array(); 
			$field = '';
				switch($actiontype)
				{
					case 201: $field = 'CITY'; break;
					case 202: $field = 'PROFESSION';  break;
					case 203: $field = 'SCHOOL'; break;
					case 204: $field = 'COLLEGE';  break;
					case 205: $field = 'COMPANY'; break;
					case 206: $field = 'MUSIC'; break;
					case 207: $field = 'MOVIE'; break;
					case 208: $field = 'BOOK'; break;
					case 209: $field = 'SPORT'; break;
					case 211: $field = 'HOBBY';  break;
					case 213: $field = 'RELATION';  break;
					case 215: $field = 'MOBILE';  break;
					case 225: $field = 'NICKNAME';  break;
					case 230: $field = 'SKILL';  break;
					case 231: $field = 'PROJECT';  break;
					case 232: $field = 'CERTIFICATE';  break;	
					case 233: $field = 'AWARD';  break;
					case 234: $field = 'TEAM';  break;
					case 235: $field = 'MAJOR';  break;	
					case 236: $field = 'TOOL';  break;
					case 237: $field = 'EXTENSION';  break;
					case 238: $field = 'EXPERIENCE';  break;
					default : $field = 'farzi'; break;
				}
				$return['actionid'] = $actionid;
				$return['field'] = strtolower($field);
				if($actiontype == 201 || $actiontype == 202 || $actiontype == 203 || $actiontype == 204 || $actiontype == 205 || $actiontype == 206 || $actiontype == 207 || $actiontype == 208 || $actiontype == 209 || $actiontype == 211 || $actiontype == 215 || $actiontype == 230 || $actiontype == 231 || $actiontype == 232 || $actiontype == 233 || $actiontype == 234 || $actiontype == 235 || $actiontype == 236 || $actiontype == 237 || $actiontype == 238)
				{
					$res = $database->bio_history_select($actionid);
					$return['value'] = $res['name'];
				}
				else
				{	
					$return['value'] = $database->bio_field_select($profileid,$field,$actiontype);
				}	
				if($actiontype == 213)
				{
					$return['field'] = 'relationship status';	
					switch($return['value'])
					{
						case 0: $return['value'] = 'Single'; break;
						case 1: $return['value'] = 'Married'; break;
						case 2: $return['value'] = 'Divorced'; break;
						case 3: $return['value'] = 'Complicated'; break;
						case 4: $return['value'] = 'Reserved'; break;
						case 5: $return['value'] = 'Need a Life Partner'; break;						
					}
				}
				else if($actiontype == 222)
				{
					$return['field'] = 'interested in';	
					switch($return['value'])
					{
						case 1: $return['value'] = 'Male'; break;
						case 2: $return['value'] = 'Female'; break;
						case 3: $return['value'] = 'Male and Female'; break;
						case 4: $return['value'] = 'No Answer';
					}
				}
				else if($actiontype == 220)
				{
					$return['field'] = 'political view';	
					switch($return['value'])
					{
						case 1: $return['value'] = 'No Answer'; break;
						case 2: $return['value'] = 'Right Conservative'; break;
						case 3: $return['value'] = 'Centrirst'; break;
						case 4: $return['value'] = 'Left-liberal'; break;
						case 5: $return['value'] = 'Libertarian'; break;
						case 6: $return['value'] = 'Authoritarian'; break;
						case 7: $return['value'] = 'Depends'; break;
						case 8: $return['value'] = 'Not Political'; break;
					}
				}
				return json_encode($return);
	} 
	
	function tagline_encode($actionid,$database)
	{
			$return = array();
			$rw = $database->diary_select($actionid);		 
			$return['tagline'] = stripslashes($rw['PAGE']);
			return $return;
	}
   
	function parent_encode($pageid,$json,$help,$database)
	{
			$return = array();
			$rw = $database->get_action($pageid);
			$return['postby'] = $rw['ACTIONBY'];
			$return['visible'] = $rw['VISIBLE'];
			$return['parenttype'] = $rw['ACTIONTYPE'];
			$return['time'] =  $help->get_utc($rw['TIMESTAMP']);		
			$return['actionid'] = $rw['ACTIONID'];
			return $return;
	}
	
	function moment_encode($actionid,$help,$database)
	{
		$return = array();
		$rowid = $database->moment_select($actionid);
		$return['momentid'] = $rowid['MOMENTID'];
		$return['count'] = $rowid['COUNT'];
		$return['mname'] = $rowid['NAME'];
		$return['desc'] = $rowid['DESCRIPTION'];
		$ir = $database->moment_image_select($return['momentid']);
		$photo = array();
		$k = 0;
		while($row = $ir->fetch_array())
		{
			$photo[$k]['file'] = $row['cdn'].$row['filename'];
			$photo[$k]['actionid'] = $row['imageid'];
			$photo[$k]['life_is_fun'] = sha1($row['imageid'].'pass1reset!');
			$photo[$k]['actionon'] = $row['profileid'];
			$photo[$k]['actionby'] = $row['actionby'];	
			$photo[$k]['time'] = $help->get_time($row['timestamp']);		
			$k++;	
		}
		$return['photo'] = $photo;
		return $return;
	}
	
	function page_encode($pageid,$database)
	{
		$row = $database->diary_select($pageid);
		return stripslashes($row['PAGE']);		 
	}
	
	function question_encode($pageid,$database)
	{
		$return = array();
		$rw = $database->diary_select($pageid);
		$return['question'] = $rw['PAGE'];
		$rw = $database->option_select($pageid);
		$k = 0;
		$myprofileid = $_SESSION['userid'];
		$total = $database->answer_total_select($pageid);
		while($ow = $rw->fetch_array())
		{
			$option[$k]['opt'] = $ow['option'];
			$option[$k]['optid'] = $ow['optionid'];
			$option[$k]['mine'] = $database->answer_mine_check($ow['optionid'],$myprofileid);
			$option[$k]['count'] = $database->answer_count_select($pageid,$ow['optionid']);
			if($total != 0)
			{	
				$option[$k]['percent'] = ($option[$k]['count']*100)/$total;
			}
			else
			{
				$option[$k]['percent'] = 0;
			}	
			$k++;
		}  
		$return['option'] = $option;
		return $return;
	}
	
	function page_comment_encode($pageid,$database)
	{
		$row = $database->page_comment_select($pageid);
		return stripslashes($row['COMMENT']);		 
	}
	
	function image_encode($actionid,$database)
	{
		$row = $database->image_select($actionid);
		$file = $row['cdn'].$row['filename'];
		return $file;
	}
	
	function doc_encode($actionid,$database)
	{
		$row = $database->doc_select($actionid);
		$d['file'] = $row['cdn'].$row['filename'];
		$d['caption'] = $row['caption'];
		return $d;
	}
	
	function video_encode($actionid,$database)
	{
		$row = $database->video_select($actionid);
		$file = $row['cdn'].$row['filename'];
		return $file;
	}
	
	function response_encode($actionid,$rtype,$json,$help,$database,$memcache)
	{
	    global $name;
		$r = $database->response_select($actionid,$rtype);
		$excited = array();
		while($rs = $r->fetch_array())
		{
			$excited[] = $rs['ACTIONBY'];
			$name[$rs['ACTIONBY']] = $help->name_fetch($rs['ACTIONBY'], $memcache, $database);
		}
		return $excited;
	}
	
	function comment_count_encode($pageid,$actiontype,$database)
	{
		$row = $database->comment_count($pageid,$actiontype);
		return $row['COUNT(*)'];		 
	}
	
	function comment_actionid_of_third_encode($pageid,$actiontype,$database)
	{
		return $database->comment_select_actionid_of_third($pageid,$actiontype);
	}
	
	function comment_encode($actionid,$com_num,$json,$help,$database,$memcache)
	{
		global $name,$pimage;
		$myprofileid = $_SESSION['userid'];
		if($com_num > 3)
		{
			$comresult=$database->comment_select_three($actionid,$com_num-3,3);
		}	
		else
		{		
			$comresult=$database->comment_select($actionid);
		}	
		$com = array();
		$j=0;
		while($comrow = $comresult->fetch_array())
		{
			 $com[$j]['com_time'] = $help->get_utc($comrow['TIMESTAMP']);
			 $com[$j]['commentby'] = $comrow['ACTIONBY'];
			 $com[$j]['com_pageid'] = $comrow['PAGEID'];
			 $com_actionid = $com[$j]['com_actionid'] = $comrow['ACTIONID'];
			 $com[$j]['comment'] = stripslashes($comrow['COMMENT']);
			 $excited_action = $database->get_excited_action($com_actionid,'63');
			 $com[$j]['com_excited_mine'] = 0;
			 while($erow = $excited_action->fetch_array())
			 {
				if($erow['ACTIONBY'] == $myprofileid)
				{
					$com[$j]['com_excited_mine'] = 1;
				}
			 }
			 $com[$j]['com_excited'] = $excited_action->num_rows;
			 $name[$com[$j]['commentby']] = $help->name_fetch($com[$j]['commentby'], $memcache, $database);
			 $pimage[$com[$j]['commentby']] = $help->pimage_fetch($com[$j]['commentby'], $memcache, $database); 
			 $j++;
		}
			 return $com;
	}		
	
}	
?>