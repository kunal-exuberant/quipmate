<?php
require_once('/var/www/common/secret.php');
class Help
{ 
	function checkPrivacy($item,$profileid)
	{
		$myprofileid = $_SESSION['USERID'];
		$database = new Database();
		if($myprofileid == $profileid) 
		{
			return 1;
		}
		$itemval = $database->privacy_item_select($item,$profileid);
		if($itemval == 0)
		{
			return 1;
		}
		$relation = $database->relation_check($profileid);
		if($relation >= $itemval)
		{
			return 1;	
		}
		else
		{
			return 0;
		}
	}
	function assign_database($email,$database)
	{
		$flag = 0;
		$public_email = array("gmail","yahoo","outlook","hotmail","rediffmail","facebook","fb","inbox","mail","shortmail","live","yandex","hushmail","zoho");
		$arr = explode('@',$email);
		$ar = explode('.',$arr[1]);
		$dbname = $ar[0];
		$result = $database->get_database_list();
		while ($res = $result->fetch_array())
		{
			if ($dbname == $res[0])
			{
				$flag = 1;
				break;
			}
		}
		if($flag == 1)
		{
			$_SESSION['database'] =  $dbname;
		}
		else if (in_array($dbname,$public_email))
		{
			$_SESSION['database'] =  'profile';
		}
		else
		{
		 $this->create_database($dbname);
		 $_SESSION['database'] =  $dbname;
		}
	
	}
	function get_database_from_email($email,$database)
	{
		$public_email = array("gmail","yahoo","outlook","hotmail","rediffmail","inbox","mail","shortmail","live","yandex","hushmail","zoho");
		$arr = explode('@',$email);
		$ar = explode('.',$arr[1]);
		$dbname = $ar[0];
		$result = $database->get_database_list();
		while ($res = $result->fetch_array())
		{
			if ($dbname == $res[0])
			{
				$flag = 1;
				break;
			}
		}
		if($flag == 1)
		{
			return $dbname;
		}
		else if (in_array($dbname,$public_email))
		{
			$dbname =  'profile';
			return $dbname;
		}
		else
		$dbname = 'invalid';
		return $dbname;	
	}
	function create_database($db_name)
	{
		global $DB_IP;
		global $DB_USER;
		global $DB_PASSWORD;
		global $DB_NAME;
		$DB_SRC_HOST=$DB_IP;
		$DB_SRC_USER=$DB_USER;
		$DB_SRC_PASS=$DB_PASSWORD;
		$DB_SRC_NAME='profile';
		$DB_DST_NAME=$db_name;

		$db1 = mysql_connect($DB_SRC_HOST,$DB_SRC_USER,$DB_SRC_PASS) or die(mysql_error());
		mysql_select_db($DB_SRC_NAME, $db1) or die(mysql_error());
		$master_tables = array("actiontype","info","mood","gift","feature");
		$reset_identity_tables = array("globalid","log","page_view","virtual","option","moment","signup");
		$result = mysql_query("show tables from ". $DB_SRC_NAME.";",$db1) or die(mysql_error());
		$buf="set foreign_key_checks = 0;\n";
		$constraints='';
		$data='';
		$reset_identity='';
		$i=0;
		while($row = mysql_fetch_array($result))
		{
			$table = $row[0];
			$row[0] = "`".$row[0]."`";
				$result2 = mysql_query("SHOW CREATE TABLE ".$row[0].";",$db1) or die(mysql_error());
				$res = mysql_fetch_array($result2);
				if(preg_match_all("/[ ]*CONSTRAINT[ ]+.*\n/",$res[1],$matches))
				{
				$i=0;
				foreach ($matches as $a)
					{
						if (is_array($a))
						{
						foreach ($a as $value) 
							{
							//echo $value;	
							$value  =  str_replace(",","",$value);
							$res[1] = preg_replace("/,\n[ ]*CONSTRAINT[ ]+.*\n/","\n",$res[1]);
							$res[1] = preg_replace("/\n[ ]*CONSTRAINT[ ]+.*\n/","\n",$res[1]);
							$constraints.="ALTER TABLE ".$row[0]." ADD ".trim($value).";\n";
							}
						}
					}
				}
				if(in_array($table,$master_tables))
				{
					$data.="Insert into ".$DB_DST_NAME.".".$row[0]." select * from ".$DB_SRC_NAME.".".$row[0].";\n";
				}
				if(in_array($table,$reset_identity_tables))
				{
					if ($table == "signup")
					{
					$reset_identity.="ALTER TABLE ".$row[0]." AUTO_INCREMENT = 1000000000;\n";
					}
					else
					{
					$reset_identity.="ALTER TABLE ".$row[0]." AUTO_INCREMENT = 1;\n";
					}
				}
				$buf.=$res[1].";\n";
		}
		$buf.=$constraints;
		$buf.=$data;
		$buf.=$reset_identity;
		$buf.="set foreign_key_checks = 1";

		/**************** CREATE NEW DB ***************************/
		$sql = "CREATE DATABASE ".$DB_DST_NAME.";";
		if(!mysql_query($sql, $db1)) die(mysql_error());
		mysql_select_db($DB_DST_NAME, $db1) or die(mysql_error());
		$queries = explode(';',$buf);
		foreach($queries as $query)
				if(!mysql_query($query, $db1)) die(mysql_error());
		return true;

	}
	
	function generate_image_thumbnail($source_image_path, $THUMBNAIL_IMAGE_MAX_WIDTH,$THUMBNAIL_IMAGE_MAX_HEIGHT)
	{
		list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);
		switch ($source_image_type) {
			case IMAGETYPE_GIF:
				$source_gd_image = imagecreatefromgif($source_image_path);
				break;
			case IMAGETYPE_JPEG:
				$source_gd_image = imagecreatefromjpeg($source_image_path);
				break;
			case IMAGETYPE_PNG:
				$source_gd_image = imagecreatefrompng($source_image_path);
				break;
		}
		if ($source_gd_image === false) {
			return false;
		}
		$source_aspect_ratio = $source_image_width / $source_image_height;
		$thumbnail_aspect_ratio = $THUMBNAIL_IMAGE_MAX_WIDTH / $THUMBNAIL_IMAGE_MAX_HEIGHT;
		if ($source_image_width <= $THUMBNAIL_IMAGE_MAX_WIDTH && $source_image_height <= $THUMBNAIL_IMAGE_MAX_HEIGHT) {
			$thumbnail_image_width = $source_image_width;
			$thumbnail_image_height = $source_image_height;
		} elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
			$thumbnail_image_width = (int) ($THUMBNAIL_IMAGE_MAX_HEIGHT * $source_aspect_ratio);
			$thumbnail_image_height = $THUMBNAIL_IMAGE_MAX_HEIGHT;
		} else {
			$thumbnail_image_width = $THUMBNAIL_IMAGE_MAX_WIDTH;
			$thumbnail_image_height = (int) ($THUMBNAIL_IMAGE_MAX_WIDTH / $source_aspect_ratio);
		}
		$thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
		imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);
		chmod($source_image_path, 0777);
		imagejpeg($thumbnail_gd_image, $source_image_path, 90);
		imagedestroy($source_gd_image);
		imagedestroy($thumbnail_gd_image);
		return true;
	}
	
	
	function cdn_upload($file_to_be_uploaded, $cdn, $filename)
	{
		require_once('../../include/cloudfiles.php');
					
		$rackspace_user = "kunalexuberant";
		$rackspace_api_key = "08e53e9faf3013004eb92dc00611e690";
		$authentication = new CF_Authentication($rackspace_user, $rackspace_api_key);
		$authentication->authenticate();
		$connection = null;
		try {
			$connection = new CF_Connection($authentication);    
		}
		catch(AuthenticationException $e) {
			echo "Unable to authenticate ".$e->getMessage();
			die(0);
		}
		
		$container = null;  
		try
		{
			$container = $connection->get_container($cdn);
			$container->make_public();
		}
		catch(NoSuchContainerException $e) {
		   $container= $connection->create_container($cdn);
		}
		catch(InvalidResponseException $res) {
			// let your users know or try again or just store the file locally and try again later to push it to the Cloud
		}
		$object = $container->create_object($filename);
		$object->load_from_filename($file_to_be_uploaded);
		//echo $object->public_uri();
		return $filename;
	}

	function error_description($code)
	{
		switch($code)
		{
			case 0:  $error['code'] = 0;
					 $error['message'] = 'Permission denied !'; 
					 $error['type'] = 'UnauthorisedAccessException';
					 break;
			case 1:  $error['code'] = 1;
					 $error['message'] = 'Not a friend'; 
					 $error['type'] = 'NotAFriendException';
					 break;
		    case 2:  $error['code'] = 2;
					 $error['message'] = 'This action cannot be performed on self'; 
					 $error['type'] = 'ActionOnSelfException';
					 break;		 
		    case 4:  $error['code'] = 4;
					 $error['message'] = 'Authentication failure'; 
					 $error['type'] = 'AuthenticationException';
					 break;
			case 5:	 $error['code'] = 5;
					 $error['message'] = 'Unknown method used'; 
					 $error['type'] = 'MethodException';
					 break;
			case 6:	 $error['code'] = 6;
					 $error['message'] = 'No specific api call aimed at'; 
					 $error['type'] = 'ApiCallException';	
                     break;	
			case 7:	 $error['code'] = 7;
					 $error['message'] = 'Specified action does not match any api calls'; 
				     $error['type'] = 'GetApiCallException';		
                     break;						 
			case 8:  $error['code'] = 8;
					 $error['message'] = 'Specified action does not match any api calls'; 
				     $error['type'] = 'PostApiCallException';		
                     break;					 
			case 9:  $error['code'] = 9;
					 $error['message'] = 'Insufficient Parameters'; 
					 $error['type'] = 'GetApiCallException';
                     break;
			case 10: $error['code'] = 10;
					 $error['message'] = 'Length of comment cannot cannot be more than 6072 letters.'; 
					 $error['type'] = 'SizeException';
                     break;								 
			case 11: $error['code'] = 11;
				     $error['message'] = 'Post has been deleted'; 
					 $error['type'] = 'PostDeleteException';
                     break;								 
			case 12: $error['code'] = 12;
					 $error['message'] = 'You don\'t have sufficient permission to perform this action'; 
					 $error['type'] = 'PermissionException';	
                     break;								 
            case 13: $error['code'] = 13;
					 $error['message'] = 'Your response to this post has ready been recorded'; 
				     $error['type'] = 'RepeatedResponseException';					 
		             break;	
            case 14: $error['code'] = 14;
					 $error['message'] = 'You have not responded to this post or it may already has been deleted'; 
				     $error['type'] = 'NoneResponseException';
		             break;			
            case 15: $error['code'] = 15;
					 $error['message'] = 'Unable to reach database now. Please try again'; 
				     $error['type'] = 'UnreachableDatabaseException';
		             break;	
            case 16: $error['code'] = 16;
					 $error['message'] = 'User does not exist. Invalid request.'; 
				     $error['type'] = 'NoSuchUserException';					 
		             break;					
            case 17: $error['code'] = 17;
					 $error['message'] = 'Unable to send email. Please try again.'; 
				     $error['type'] = 'EmailSendFailureException';					 
		             break;	
            case 18: $error['code'] = 18;
					 $error['message'] = 'Please fill all the details.'; 
				     $error['type'] = 'EmptyParametersException';				 
		             break;		
			case 19: $error['code'] = 19;
					 $error['message'] = 'Not a real web address or the resource has been moved.'; 
				     $error['type'] = 'WebAddressException';				 
		             break;	
			case 20: $error['code'] = 20;
					 $error['message'] = 'Friend request already exchanged'; 
				     $error['type'] = 'FriendRequestAlreadyExchangedException';				 
		             break;	 
			case 21: $error['code'] = 21;
					 $error['message'] = 'You have not received friend request from this person'; 
				     $error['type'] = 'FriendRequestNotReceivedException';
		             break;		
			case 22: $error['code'] = 22;
					 $error['message'] = 'Numeric Parameters Expected'; 
				     $error['type'] = 'NonNumericParameterException';
		             break;
            case 23: $error['code'] = 23;
					 $error['message'] = 'Not a valid email'; 
				     $error['type'] = 'InvalidEmailException';
					 break;							 
			case 24: $error['code'] = 24;
					 $error['message'] = 'There is no response to this post till now'; 
				     $error['type'] = 'NoResponseException';
					 break;		
			case 25: $error['code'] = 25;
					 $error['message'] = 'Passwords do not match'; 
				     $error['type'] = 'PasswodMismatchException';
					 break;				
			case 26: $error['code'] = 26;
					 $error['message'] = 'Length of password must be atleast 6 characters long'; 
				     $error['type'] = 'MinLengthException';
					 break;		
			case 27: $error['code'] = 27;
					 $error['message'] = 'Life is not always fun :)'; 
				     $error['type'] = 'LifeIsFunException';
					 break;	
			case 28: $error['code'] = 28;
					 $error['message'] = 'Invalid Date'; 
				     $error['type'] = 'InvalidDateException';
					 break;
			case 29: $error['code'] = 29;
					 $error['message'] = 'Invalid Time'; 
				     $error['type'] = 'InvalidTimeException';
					 break;
			case 30: $error['code'] = 30;
					 $error['message'] = 'Old and new password cannot be same'; 
				     $error['type'] = 'SamePasswordException';
					 break;				
			case 31: $error['code'] = 31;
					 $error['message'] = 'Incorrect password'; 
				     $error['type'] = 'IncorrectPasswordException';
					 break;		 
			case 32: $error['code'] = 32;
					 $error['message'] = 'Is not group admin'; 
				     $error['type'] = 'NotGroupAdminException';
					 break;
			case 33: $error['code'] = 33;
					 $error['message'] = 'This person is already a member of this group'; 
				     $error['type'] = 'AlreadyMemberException';
		             break;		
			case 34: $error['code'] = 34;
					 $error['message'] = 'This person has alreay been invited'; 
				     $error['type'] = 'AlreadyinvitedException';
		             break;
			case 35: $error['code'] = 35;
					 $error['message'] = 'Invalid Name'; 
				     $error['type'] = 'InvalidNameException';
					 break;		
			case 36: $error['code'] = 36;
					 $error['message'] = 'You cannot invite people from other network'; 
				     $error['type'] = 'PermissionException';
					 break;	
			case 37: $error['code'] = 37;
					 $error['message'] = 'Incorrect email or password'; 
				     $error['type'] = 'IncorrectEmailPasswordException';
					 break;			
			case 38: $error['code'] = 38;
					 $error['message'] = 'This person is already a guest of this event'; 
				     $error['type'] = 'AlreadyGuestException';
		             break;
			case 39: $error['code'] = 39;
					 $error['message'] = 'This person is not a guest of this event'; 
				     $error['type'] = 'NotAGuestException';
		             break;
			case 40: $error['code'] = 40;
					 $error['message'] = 'This person is not a member of this group'; 
				     $error['type'] = 'NotAMemberException';
		             break;			
			case 41: $error['code'] = 41; 
					 $error['message'] = 'You cannot invite a person to group event'; 
				     $error['type'] = 'GroupEventInviteException';
		             break;
			case 42: $error['code'] = 42; 
					 $error['message'] = 'This link is invalid or it has expired'; 
				     $error['type'] = 'InvalidLinkException';
		             break;					 
			case 43: $error['code'] = 43; 
					 $error['message'] = 'Size of useful links cannot be more than 500.'; 
				     $error['type'] = 'SizeException';
		             break;		
			case 44: $error['code'] = 44; 
					 $error['message'] = 'Size of contribution cannot be more than 500.'; 
				     $error['type'] = 'SizeException';
		             break;		
			default: $error['code'] = -1;
					 $error['message'] = 'Unknown error Occured'; 
				     $error['type'] = 'UnknownException';	 
		}
	    $data['error'] = $error; 
		echo json_encode($data);
	} 
	
	function image_url()
	{
		$url[1]  = '3a0b71f34f2493f1be4f629245bc26863ffa9f12/';
		$url[2]  = '7f17396dda86e45d95fefb81820dcda5676572a4/';
		$url[3]  = '25dee70c79d43de5da24644dc125705778a080bd/';
		$url[4]  = '196ca8b6ba10279ff91e5c831c80469633699ef6/';
		$url[5]  = '714a3a3d81de67883576195d16e68da9d5b1cc43/';
		$url[6]  = '30706f0d8a3bfe4dc99b8a9670629af77c2f4641/';
		$url[7]  = '97372938f60569adae2dfe7046c615269eefb36f/';
		$url[8]  = '65743192518060c0336cbc79fb19d02b674fbfe7/';
		$url[9]  = 'b6a804b1b63472de7af1673cda5b5e1ba11d37b0/';
		$url[10] = 'c2334c1134e644d26e8ec98092423626bbdaec93/';
		$r1 = rand(1,10);
		$file = $url[$r1];
		$r2 = rand(1,10);
		if($r1==$r2)
		{
		 if($r2 > 5)
			$r2 = rand(1,5);  
		 else
			$r2 = rand(6,10);	
		}
		$file = $file.$url[$r2];
		return $file;
	}
	
	function photo_name($ext)
	{
		return $_SESSION['database'].'_'.$_SESSION['userid'].'_'.time().'.'.$ext;
	}

	function image_name()
	{
		$name = $_COOKIE['PHPSESSID'].time();
		$diff = rand(10000000000,99999999999);
		$name = $name.$diff;
		$diff = rand(10000000000,99999999999);
		$name = $name.$diff;
		$diff = rand(10000000000,99999999999);
		$name = $name.$diff;
		return $name;
	}	
	
	function pimage_memcache_update($profileid, $pimage, $memcache)
	{
		$value = $memcache->get($_SESSION['database'].'_pimage_'.$profileid);
		if($value)
		{
			$memcache->set($_SESSION['database'].'_pimage_'.$profileid, $pimage);	
		}
	}
	
	function name_memcache_update($profileid, $name, $memcache)
	{
		$value = $memcache->get($_SESSION['database'].'_name_'.$profileid);
		if($value)
		{
			$memcache->set($_SESSION['database'].'_name_'.$profileid, $name);	
		}
	}
	
	function friend_memcache_update($profileid, $database, $memcache)
	{
		$friend = array();
		$value = $memcache->get($_SESSION['database'].'_friend_'.$profileid);
		if($value)
		{
			$res = $database->message_order($profileid);
			while($NROW =$res->fetch_array())
			{		
				if($NROW['ACTIONBY'] == $profileid)
				{
					if(!in_array($NROW['ACTIONON'], $friend))
					{
						if($database->check_friendship($profileid,$NROW['ACTIONON']) == 2)
						{
							$friend[] = $NROW['ACTIONON'];
						}
					}	
				}
				else if($NROW['ACTIONON'] == $profileid)
				{
					if(!in_array($NROW['ACTIONBY'], $friend))
					{
						if($database->check_friendship($profileid,$NROW['ACTIONBY']) == 2)
						{
							$friend[] = $NROW['ACTIONBY'];
						}
					}	
				}
			}
			$res = $database->friend_select($profileid);
			while($NROW =$res->fetch_array())
			{	
				if(!in_array($NROW['FRIENDID'], $friend))
				{
					$friend[] = $NROW['FRIENDID'];
				}
			}
		}
		$memcache->set($_SESSION['database'].'_friend_'.$profileid, $friend);	
	}
	
	function session_init($row,$prow,$imgrow,$email,$pri,$database)
	{
		$_SESSION['auth'] = $row['USERID'];
		$_SESSION['EMAIL'] = $email;
		$_SESSION['NAME'] = $prow['NAME'];
		$_SESSION['FNAME'] = $prow['FNAME'];
		$_SESSION['MNAME'] = $prow['MNAME'];
		$_SESSION['LNAME'] = $prow['LNAME'];
		$_SESSION['userid'] = $_SESSION['USERID']=$row['USERID'];
		$_SESSION['visible'] = $pri['profile_post_next'];
		$_SESSION['pimage'] = $imgrow['CDN'].$imgrow['FILENAME']; 
		$_SESSION['profile_imageid'] = $imgrow['IMAGEID'];
		$_SESSION['SEX'] = $prow['SEX']; 
		$_SESSION['STEP'] = $row['STEP']; 
		$_SESSION['SCHOOL'] = $prow['SCHOOL']; 
		$_SESSION['COLLEGE'] = $prow['COLLEGE']; 
		$_SESSION['CITY'] = $prow['CITY']; 
		if($database->moderator_check($row['USERID']))
		{
			$_SESSION['admin'] =1;
		}
		else
		{
			$_SESSION['admin'] =0;
		}
		$name  = array();
		$name[$row['USERID']]= $prow['NAME'];
		$_SESSION['name_json'] = $name; 
		
		
		$pimage  = array();
		$pimage[$row['USERID']] = $imgrow['FILENAME']; 
		$_SESSION['pimage_json'] = $pimage;
		
		$_SESSION['tag_json'] = array();
        $_SESSION['skillname_json'] =array();
        $_SESSION['groupname_json'] =array();
	}
	
	function name_fetch($key, $memcache, $database)
	{
		$value = $memcache->get($_SESSION['database'].'_name_'.$key);
		if($value)
		{
			return $value;
		}
		else
		{
			$row = $database->get_name($key); 
			$memcache->set($_SESSION['database'].'_name_'.$key, $row['NAME']);
			return $row['NAME'];
		}
	}
	function skill_fetch($key, $memcache, $database)
	{
		$value = $memcache->get($_SESSION['database'].'_skill_');
		if($value)
		{
			return $value;
		}
		else
		{
		/*	$row = $database->get_name($key); 
			$memcache->set($_SESSION['database'].'_skill_'.$key, $row['NAME']);
			return $row['NAME']; */
            return ;
		}
	}
    function skill_update($memcache,$database,$db_name)
	{
          $fres = $database->bio_skill_all_select($db_name);
          $k = 0;
          $j = 0;
          $i = 0;
          while ($frow = $fres->fetch_array())
          {
    		$value = $memcache->get($db_name.'_name_'.$frow['profileid']);
            if($value)
            {
            	break ;
            }
            else
            {
            	$memcache->set($db_name.'_name_'.$frow['profileid'],$frow['name']);
            }
             $k++;
          }
          while ($frow = $fres->fetch_array())
          {
            $skill[$frow['profileid']] = $frow['skill'];
            
          } 
          $memcache->set($db_name.'_skill',$skill);
            
	}
	function moderator_status($key, $memcache, $database,$set=0)
	{
		$value = $memcache->get($_SESSION['database'].'_admin_'.$key);
		if($value && $set==0) // Passing 1 to $set when I want to toggle the flag value.
		{
			return $value;
		}
		else
		{
			$result = $database->moderator_check($key);
			$memcache->set($_SESSION['database'].'_admin_'.$key,$result);
			return $result;
		}
	}
	function feature_fetch($key, $memcache, $database,$set=0)
	{
		$value = $memcache->get($_SESSION['database'].'_feature_'.$key);
		if($value && $set==0) // Passing 1 to $set when I want to toggle the flag value.
		{
			return $value;
		}
		else
		{
			$row = $database->setting_feature_field_select($key); 
			$memcache->set($_SESSION['database'].'_feature_'.$key, $row['flag']);
			return $row['flag'];
		}
	}
	
	function pimage_fetch($key, $memcache, $database)
	{
		$value = $memcache->get($_SESSION['database'].'_pimage_'.$key);
		if($value)
		{
			return $value; 
		}
		else
		{
			$sex = $database->sex_select($key);
			$row = $database->get_image($key,$sex); 
			$memcache->set($_SESSION['database'].'_pimage_'.$key, $row['CDN'].$row['FILENAME']);
			return $row['CDN'].$row['FILENAME'];
		}
	}
	
	function diary_name_fetch($key, $memcache, $database)
	{
		$value = $memcache->get($_SESSION['database'].'_name_'.$key);
		if($value)
		{
			return $value;
		}
		else
		{
			$row = $database->get_diary_name($key); 
			$memcache->set($_SESSION['database'].'_name_'.$key, $row['NAME']);
			return $row['NAME'];
		}
	}
	
	function feed_privacy_filter($action, $myprofileid, $database)
	{
		$return = array();
		foreach($action as $act)
		{
			if($act['visible'] == 0 || $act['visible'] == 5 || $act['visible'] == 6)
			{
				$return[] = $act;
			}
			else
			{
				$relation = $database->relation_check($act['postby']);
				if($relation >= $act['visible'])
				{
					$return[] = $act;
				}
			}
		} 
				
		function cmp_by_time($a, $b) 
		{
			return $b['time'] - $a['time'];
		}
		
		usort($return, "cmp_by_time");
		
		return $return;
	}
	
	
	 function link_highlight($str)
	 {	
	    $pattern = '`.*?((www\.|https?:\/\/)[\w#$&+,\/:;=?@.-]+)[^\w#$&+,\/:;=?@.-]*?`i';
		preg_match_all($pattern, $str, $match, PREG_PATTERN_ORDER);
		
		foreach($match[1] as $m) 
		{
		    if(preg_match("/^http:\/\//", $m) || preg_match("/^https:\/\//", $m))
			{
				$str = str_replace($m, "<a href='$m' target='_blank'>$m</a>", $str);
			}
			else
			{
			    $href = 'https://'.$m;
				$str = str_replace($m, "<a href='$href' target='_blank'>$m</a>", $str);	
			}
		}
		return $str;
	 }
	 
	function get_smiley($message)
	{
		$smiley = array(
		':)' => '<img title="Smile" class="smiley_chat" src="//icon.qmcdn.net/smile.png" />', 
		':P' => '<img title="Tongue" class="smiley_chat" src="//icon.qmcdn.net/tongue.png" />',
		';)' => '<img title="Wink" class="smiley_chat" src="//icon.qmcdn.net/wink.png" />',
		':3' => '<img title="Curly Lips" class="smiley_chat" src="//icon.qmcdn.net/curlylips.png" />',
		':*' => '<img  title="Kiss" class="smiley_chat" src="//icon.qmcdn.net/kiss.png" />',
		'>:(' => '<img title="Grumpy" class="smiley_chat" src="//icon.qmcdn.net/grumpy.png" />',
		'8)' => '<img title="Glasses" class="smiley_chat" src="//icon.qmcdn.net/glasses.png" />',
		'8|' => '<img title="Sun Glasses" class="smiley_chat" src="//icon.qmcdn.net/sunglasses.png" />',
		'>:o' => '<img title="Upset" class="smiley_chat" src="//icon.qmcdn.net/upset.png" />',
		'o.O|' => '<img title="Confused" class="smiley_chat" src="//icon.qmcdn.net/confused.png" />',
		':v' => '<img title="Packman" class="smiley_chat" src="//icon.qmcdn.net/pacman.png" />',
		'o:)' => '<img title="Angel" class="smiley_chat" src="//icon.qmcdn.net/angel.png" />',
		'3:)' => '<img title="Devil" class="smiley_chat" src="//icon.qmcdn.net/devil.png" />',
		'<3' => '<img title="Heart" class="smiley_chat" src="//icon.qmcdn.net/heart.png" />'
		);
	
		$m = explode(' ', $message);
		foreach($m as $a)
		{
			if(isset($smiley[$a]))
			{
				$message = str_replace($a,$smiley[$a],$message);
			}
		}
		return $message;
	}
	
	function is_valid_email($str)
	{
		if((preg_match("/^[a-zA-Z0-9]+[a-zA-Z0-9(\.|\_)]*@[a-zA-Z]\w{2,30}(\.[a-zA-Z]{2,30}[\.][a-zA-Z]{2,30})$/", $str)) || (preg_match("/^[a-zA-Z0-9]+[a-zA-Z0-9(\.|\_)]*@[a-zA-Z]\w{2,30}(\.[a-zA-Z]{2,30})$/", $str)) || (preg_match("/^[a-zA-Z0-9]+[a-zA-Z0-9(\.|\_)]*@[a-zA-Z]\w{2,30}(\.[a-zA-Z]+[\.][a-zA-Z]{2,30}[\.][a-zA-Z]{2,30})$/", $str)))
		{
			return true;
		}
        return false;		
	}
	
	function name_split($name)
	{
		$result = array();
		$mpos=strpos($name," ");
		$temp=trim(substr($name,$mpos));
		$lpos=strpos($temp," ");
		$fname=substr($name,0,$mpos);
		$mname=substr($name,$mpos+1,$lpos);
		$lname=substr($temp,$lpos);
		if($mpos==0)
		{
			$fname=$lname;
			$lname="";
		}
		$result[0] = $fname;
		$result[1] = $mname;
		$result[2] = $lname;
		return $result;
	}
	
	function get_utc($time)
	{
		return strtotime($time);
	}
	
	function get_time($time)
	{
		$now = time();
		if($now < $time + 2)
			return ' '.'two seconds ago';
		else if($now < $time + 3)
			return ' '.'three seconds ago';
		else if($now < $time + 4)
			return ' '.'four seconds ago';
		else if($now < $time + 5)
			return ' '.'five seconds ago';
		else if($now < $time + 10)
			return ' '.'ten seconds ago';
		else if($now < $time + 15)
			return ' '.'fifteen seconds ago';
		else if($now < $time + 30)
			return ' '.'fifteen seconds ago';
		else if($now < $time + 45)
			return ' '.'half a minute ago';
		else if($now < $time + 60)
			return ' '.' one minute ago';
		else if($now < $time + 120)
			return ' '.' two minute ago';
		else if($now < $time + 180)
			return ' '.' three minute ago';
		else if($now < $time + 240)
			return ' '.' four minute ago';
		else if($now < $time + 300)
			return ' '.' five minute ago';
		else if($now < $time + 600)
			return ' '.' ten minute ago';
		else if($now < $time + 900)
			return ' '.' fifteen minutes ago';
		else if($now < $time + 1200)
			return ' '.' twenty minute ago';
		else if($now < $time + 1500)
			return ' '.' twenty-five minute ago';
		else if($now < $time + 1800)
			return ' '.' half an hour ago';
		else if($now < $time + 3600)
			return ' '.' an hour ago';
		else if($now < $time + 7200)
			return ' '.'two hour ago';
		else if($now < $time + 10800)
			return ' '.'three hour ago';
		else if($now < $time + 14400)
			return ' '.'four hour ago';
		else if($now < $time + 18000)
			return ' '.'five hour ago';
		else if($now < $time + 21600)
			return ' '.'six hour ago';
		else if($now < $time + 25200)
			return ' '.'seven hour ago';
		else if($now < $time + 28800)
			return ' '.'eight hour ago';
		else if($now < $time + 32400)
			return ' '.'nine hour ago';
		else if($now < $time + 36000)
			return ' '.'ten hour ago';
		else if($now < $time + 43200)
			return ' '.'eleven hour ago';
		else if($now < $time + 46800)
			return ' '.'twelve hour ago';
		else if($now < $time + 50400)
			return ' '.'thirteen hour ago';
		else if($now < $time + 54000)
			return ' '.'fourteen hour ago';
		else if($now < $time + 57600)
			return ' '.'fifteen hour ago';
		else if($now < $time + 61200)
			return ' '.'sixteen hour ago';
		else if($now < $time + 64800)
			return ' '.'seventeen hour ago';
		else if($now < $time + 68400)
			return ' '.'eighteen hour ago';
		else if($now < $time + 72000)
			return ' '.'nineteen hour ago';
		else if($now < $time + 75600)
			return ' '.'twenty hour ago';
		else if($now < $time + 79200)
			return ' '.'twentyone hour ago';
		else if($now < $time + 82800)
			return ' '.'twentytwo hour ago';
		else if($now < $time + 86400)
			return ' '.'twentythree hour ago';
		else if($now < $time + 90000)
			return ' '.'tonight';
		else if($now < $time + 93600)
			return ' '.'yesterday';
		else if($now < $time + 604800)
			return ' on '.date('l',$time);
		else if($now < $time + 1209600)
			return ' last week';
		else if($now < $time + 1814400)
			return ' two weeks ago';
		else if($now < $time + 2419200)
			return ' three weeks ago';
		else if($now < $time + 3024000)
			return ' one month ago';
		else if($now < $time + 6048000)
			return ' two months ago';
		else if($now < $time + 9072000)
			return ' three months ago';
		else if($now < $time + 12096000)
			return ' four months ago';
		else if($now < $time + 15120000)
			return ' five months ago';
		else if($now < $time + 18144000) 
			return ' six months ago';
		else if($now < $time + 21168000)
			return ' seven months ago';
		else if($now < $time + 24192000)
			return ' eight months ago';
		else if($now < $time + 27216000)
			return ' nine months ago';
		else if($now < $time + 30240000)
			return ' ten months ago';
		else if($now < $time + 33264000)
			return ' eleven months ago';
		else if($now < $time + 362888000)
			return '  a year ago';
	}
	
	function permission_check($myprofileid, $profileid, $visible)
	{
		if($myprofileid == $profileid || $visible == 0 || $visible == 6)
		{
			return 1;
		}
		else if($visible == 5)
		{
			$database = new Database();
			$result =  $database->is_member($profileid, $myprofileid);
			if($result->num_rows)
			{
				return 1;
			}
			return 0;	
		}
		else
		{
			$database = new Database();
			if($database->relation_check($profileid) >= $visible)
			{
				return 1;
			}
			return 0;
		}
	}
	
	function setting_checkbox($name,$level,$notice=1)
	{ 
		if($notice == 1)
		{
			$fun = "action.notification_setting_update(this)";
		}
		else if($notice == 2)
		{
			$fun = "action.feature_setting_update(this)";	
		}
		else
		{
			$fun = "action.email_setting_update(this)";	
		}
		if($level == 1)
		{
			?>
			<input type="checkbox" data = "<?php echo $name ?>" class="privacy_drop" onchange="<?php echo $fun?>" checked />  
			<?php
		}
		else
		{
			?>
			<input type="checkbox" data = "<?php echo $name ?>" class="privacy_drop" onchange="<?php echo $fun?>" />  
			<?php
		}
	}
	
	
	function notification_drop($name,$level)
	{
		if($level == 1)
		{
			?>
			<input type="checkbox" data = "<?php echo $name ?>" class="privacy_drop" onchange="action.notification_setting_update(this)" checked />  
			<?php
		}
		else
		{
			?>
			<input type="checkbox" data = "<?php echo $name ?>" class="privacy_drop" onchange="action.notification_setting_update(this)" />  
			<?php
		}
	}
	
	function notification_drop_old($name,$level)
	{
		?>
		<select data = "<?php echo $name ?>" class="privacy_drop" onchange="action.notification_setting_update(this)" >  
		<?php 
		$arr[0] = "Both";
		$arr[1] = "Quipmate";
		$arr[2] = "Email";
		for($i=0; $i < 3; $i++)
		{
			if($i==$level)
			echo "<option value=".$i." "."selected".">".$arr[$i]."</option>";
			else
			echo "<option value=".$i.">".$arr[$i]."</option>";
		}
		?>
		</select>
		<?php
	}
	
	
	function privacy_level($name,$level)
	{
		?>
		<select data = "<?php echo $name ?>" class="privacy_drop" onchange="action.profile_privacy_update(this)" >  
		<?php 
		$arr[0] = "Everyone on network";
		$arr[2] = "Followers";
		for($i=0; $i < 3; $i++)
		{
			if($i==$level)
			echo "<option value=".$i." "."selected".">".$arr[$i]."</option>";
			else
			echo "<option value=".$i.">".$arr[$i]."</option>";
		}
		?>
		</select>
		<?php
	}
	
	function response_type_fetch($pagetype)
	{
		if($pagetype > 200 && $pagetype < 300)
		{
			$rtype = 13;
		}
		else if(($pagetype >= 300 && $pagetype < 400) && $pagetype != 302)
		{
			$rtype = 311;
		}
		else if(($pagetype >= 400 && $pagetype < 500) && $pagetype != 402)
		{
			$rtype = 411;
		}
		else if(($pagetype >= 2900 && $pagetype < 3000) && $pagetype != 2902)
		{
			$rtype = 2911;
		}
		else
		{
			switch($pagetype)
			{
				case '1': $rtype = '11'; break;
				case '10': $rtype = '11'; break;
				case '5': $rtype = '12'; break;		
				case '6': $rtype = '15'; break;
				case '8': $rtype = '17'; break;
				case '50': $rtype = '16'; break;
				case '51': $rtype = '15'; break;
				case '99': $rtype = '91'; break;
				case '501': $rtype = '511'; break;
				case '600': $rtype = '611'; break;
				case '700': $rtype = '711'; break;
				case '800': $rtype = '811'; break;		
				case '1101': $rtype = '1111'; break;
				case '1102': $rtype = '1113'; break;
				case '1201': $rtype = '1211'; break;
				case '1401': $rtype = '1411'; break;
				case '1600': $rtype = '1611'; break;
				case '1900': $rtype = '1911'; break;
				case '2000': $rtype = '2011'; break;
				case '2100': $rtype = '2111'; break;
				case '2400': $rtype = '2411'; break;
				case '2500': $rtype = '2511'; break;
				case '2600': $rtype = '2611'; break;
				case '2800': $rtype = '2811'; break;
				default : $rtype = '63'; 
			}
		}
		return $rtype;
	}
	
	function actiontype_fetch($type)
	{
		if($type == 'city')
		{
			$actiontype = 201;
		}
		else if($type == 'company')
		{
			$actiontype = 205;
		}
		else if($type == 'school')
		{
			$actiontype = 204;
		}
		else if($type == 'school')
		{
			$actiontype = 203;
		}
		else if($type == 'music')
		{
			$actiontype = 206;
		}
		else if($type == 'movie')
		{
			$actiontype = 207;
		}
		else if($type == 'sports')
		{
			$actiontype = 209;
		}
		else if($type == 'hobby')
		{
			$actiontype = 211;
		}
		return $actiontype;
	}
	
	function comment_type_fetch($pagetype)
	{
		if($pagetype > 200 && $pagetype < 300)
		{
			$ctype = 3;
		}
		else if($pagetype >= 300 && $pagetype < 400)
		{
			$ctype = 302;
		}
		else if($pagetype >= 400 && $pagetype < 500)
		{
			$ctype = 402;
		}
		else if($pagetype >= 2900 && $pagetype < 3000)
		{
			$ctype = 2902;
		}
		else
		{
			switch($pagetype)
			{
				case '1': $ctype = '2'; break;
				case '10': $ctype = '2'; break;
				case '5': $ctype = '23'; break;
				case '6': $ctype = '24'; break;
				case '8': $ctype = '26'; break;
				case '50': $ctype = '25'; break;
				case '51': $ctype = '24'; break;
				case '99': $ctype = '92'; break;
				case '501': $ctype = '503'; break;
				case '600': $ctype = '602'; break;
				case '700': $ctype = '702'; break;
				case '800': $ctype = '802'; break;
				case '1101': $ctype = '1103'; break;
				case '1102': $ctype = '1104'; break;
				case '1201': $ctype = '1202'; break;
				case '1401': $ctype = '1402'; break;
				case '1600': $ctype = '1602'; break;
				case '1900': $ctype = '1902'; break;
				case '2000': $ctype = '2002'; break;
				case '2100': $ctype = '2102'; break;
				case '2400': $ctype = '2402'; break;
				case '2500': $ctype = '2502'; break;
				case '2600': $ctype = '2602'; break;
				case '2800': $ctype = '2802'; break;
			}
		}	
		return $ctype;
	}
	
	function getHeight($image) 
	{
		$size = getimagesize($image);
		$height = $size[1];
		return $height;
	}

	function getWidth($image) 
	{
		$size = getimagesize($image);
		$width = $size[0];
		return $width;
	}
	
	function resizeImage($image,$width,$height,$scale) 
	{
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$imageType = image_type_to_mime_type($imageType);
		$newImageWidth = ceil($width * $scale);
		$newImageHeight = ceil($height * $scale);
		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		switch($imageType) 
		{
			case "image/gif":
				$source=imagecreatefromgif($image); 
				break;
			case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				$source=imagecreatefromjpeg($image); 
				break;
			case "image/png":
			case "image/x-png":
				$source=imagecreatefrompng($image); 
				break;
		}
		imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
		switch($imageType) 
		{
			case "image/gif":
				imagegif($newImage,$image); 
				break;
			case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				imagejpeg($newImage,$image,90); 
				break;
			case "image/png":
			case "image/x-png":
				imagepng($newImage,$image);  
				break;
		}
		chmod($image, 0777);
		return $image;
	}
	
	
	function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale)
	{
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$imageType = image_type_to_mime_type($imageType);
		
		$newImageWidth = ceil($width * $scale);
		$newImageHeight = ceil($height * $scale);
		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		switch($imageType) {
			case "image/gif":
				$source=imagecreatefromgif($image); 
				break;
			case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				$source=imagecreatefromjpeg($image); 
				echo $source;
				break;
			case "image/png":
			case "image/x-png":
				$source=imagecreatefrompng($image); 
				break;
		}
		echo imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
		switch($imageType) {
			case "image/gif":
				imagegif($newImage,$thumb_image_name); 
				break;
			case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				echo imagejpeg($newImage,$thumb_image_name,90); 
				break;
			case "image/png":
			case "image/x-png":
				imagepng($newImage,$thumb_image_name);  
				break;
		}
		chmod($thumb_image_name, 0777);
		return $thumb_image_name;
	}
	
	
	function register_user_mobile($email,$identifier,$name,$password,$gender,$day,$month,$year)
	{
		$email = strtolower($email);
		$name = ucwords(strtolower($name));
		$password = strtolower($password);
		$database = new Database();
		$memcache = new Memcached();
		$this->assign_database($email,$database);
		$database =null;
		$database = new Database();
		//$row = $database->user_exists($email);
		$row = $database->is_already_user($email);
		if($row['EMAIL']!=$email)
		{

			$row = $database->virtual_select_mobile($email,$identifier);
			
			if($row != 0 && $email == $row['EMAIL'] && $identifier == $row['code'] )
			{		
				$virtualid = $row['VIRTUALID'];
				$password = sha1($email.$password);
				$sess_quip = rand(1000000000,9999999999);
				$uniqueid = sha1($email.$password."pass1reset!");
				$profileid = $database->signup_insert($email,$password,$sess_quip,$uniqueid);
				if($profileid)
				{
					setcookie("quip_i",$sess_quip,time()+3600000,'/','.quipmate.com');
					setcookie("quip_p",$profileid,time()+3600000,'/','.quipmate.com');
					setcookie("quip_e",$email,time()+3600000,'/','.quipmate.com');
					$result = array();
					$birthday = "$year"."-"."$month"."-"."$day";	
					$n = $this->name_split($name);
					$fname = $n[0];
					$mname = $n[1];
					$lname = $n[2];
					$result = $database->bio_insert($profileid,$email,$name,$fname,$mname,$lname,$gender,$birthday);
					if($result)
					{ 
						$_SESSION['EMAIL'] = $email;
						$_SESSION['auth'] = $profileid;
						$_SESSION['NAME'] = $name;
						$_SESSION['FNAME'] = $fname;  
						$_SESSION['MNAME'] = $mname;
						$_SESSION['LNAME'] = $lname;
						$_SESSION['USERID']= $_SESSION['userid'] = $profileid;
						$_SESSION['SEX']= $gender;
						$_SESSION['SCHOOL']=0;
						$_SESSION['COLLEGE']=0;
						$_SESSION['STEP']=1;
						$actionid = $database->get_actionid($profileid,99);						
						$database->virtual_to_real($email,$profileid);
						$ri = $database->inviter_select($virtualid);
						while($frw = $ri->fetch_array())
						{ 
							$fid = $frw['ACTIONBY'];
							$actionid = $database->get_actionid($fid,'8');
							$r = $database->invited_friend_insert($fid,$profileid);
							$this->friend_memcache_update($fid, $database, $memcache);
							$this->friend_memcache_update($profileid, $database, $memcache);
						}
						$image = $this->pimage_fetch($profileid, $memcache, $database);
						$_SESSION['pimage'] = $image;
						$data['ack']=1;
						echo json_encode($data);
					}
					else
					{
						$data['ack']=7;
						echo json_encode($data);
					}
				}
				else
				{
					$data['ack']=8;
					echo json_encode($data);
				}	
				
			}
			
			else
			{
				$data['ack']=9;
				echo json_encode($data);
			}
		}
		else
		{
			$data['ack']=10;
			echo json_encode($data);
		}
	}
	
	
	
	function register_user($email,$identifier,$name,$password,$gender,$day,$month,$year)
	{
		$email = strtolower($email);
	
		$identifier = strtolower($identifier);
		$name = ucwords(strtolower($name));
		$password = strtolower($password);
		$database = new Database();
		$memcache = new Memcached();
		//$row = $database->user_exixts($email);
		$row = $database->is_already_user($email);
		if($row['EMAIL']!=$email)
		{
			$row = $database->virtual_select($email,$identifier);
			
			if($row != 0 && $email == $row['EMAIL'] && $identifier == $row['UNIQUEID'] )
			{		
				$virtualid = $row['VIRTUALID'];
				$password = sha1($email.$password);
				$sess_quip = rand(1000000000,9999999999);
				$uniqueid = sha1($email.$password."pass1reset!");
				$profileid = $database->signup_insert($email,$password,$sess_quip,$uniqueid);
				if($profileid)
				{
					setcookie("quip_i",$sess_quip,time()+3600000,'/','.quipmate.com');
					setcookie("quip_p",$profileid,time()+3600000,'/','.quipmate.com');
					setcookie("quip_e",$email,time()+3600000,'/','.quipmate.com');
					$result = array();
					$birthday = "$year"."-"."$month"."-"."$day";	
					$n = $this->name_split($name);
					$fname = $n[0];
					$mname = $n[1];
					$lname = $n[2];
					$result = $database->bio_insert($profileid,$email,$name,$fname,$mname,$lname,$gender,$birthday);
					if($result)
					{ 
						$_SESSION['EMAIL'] = $email;
						$_SESSION['auth'] = $profileid;
						$_SESSION['NAME'] = $name;
						$_SESSION['FNAME'] = $fname;  
						$_SESSION['MNAME'] = $mname;
						$_SESSION['LNAME'] = $lname;
						$_SESSION['USERID']= $_SESSION['userid'] = $profileid;
						$_SESSION['SEX']= $gender;
						$_SESSION['SCHOOL']=0;
						$_SESSION['COLLEGE']=0;
						$_SESSION['STEP']=1;
						$actionid = $database->get_actionid($profileid,99);						
						$database->virtual_to_real($email,$profileid);
						$ri = $database->inviter_select($virtualid);
						while($frw = $ri->fetch_array())
						{ 
							$fid = $frw['ACTIONBY'];
							$actionid = $database->get_actionid($fid,'8');
							$r = $database->invited_friend_insert($fid,$profileid);
							$this->friend_memcache_update($fid, $database, $memcache);
							$this->friend_memcache_update($profileid, $database, $memcache);
						}
						$image = $this->pimage_fetch($profileid, $memcache, $database);
						$_SESSION['pimage'] = $image;
						$data['ack']=1;
						echo json_encode($data);
					}
					else
					{
						$data['ack']=7;
						echo json_encode($data);
					}
				}
				else
				{
					$data['ack']=8;
					echo json_encode($data);
				}	
			}
			else
			{
				$data['ack']=9;
				echo json_encode($data);
			}
		}
		else
		{
			$data['ack']=10;
			echo json_encode($data);
		}
	}
	
	
	
	function validate()
	{
	if(isset($_GET['name']) && isset($_GET['password']) && isset($_GET['gender']) && isset($_GET['day']) && isset($_GET['month']) && isset($_GET['year']))
{
	$name = trim($_GET['name']);
	$password = trim($_GET['password']);
	$gender = trim($_GET['gender']);
	$day = trim($_GET['day']);
	$month = trim($_GET['month']);
	$year = trim($_GET['year']);
	if($name != '' && $password != '' && $gender != -1 && $day != -1 && $month != -1 && $year != -1)
	{
		if(preg_match("/^[[:space:]]*[a-zA-Z]+[[:space:]]*[a-zA-Z]*[[:space:]]*[a-zA-Z]*$/", $name))
		{
			if(strlen($password)>5) 
			{ 
				if($gender == 0 || $gender == 1)
				{
					if($day==31)
					{
						switch($month)
						{
							case 2:  echo json_encode(4); exit;
							case 1:
							case 3:
							case 5:
							case 7:
							case 8:
							case 10:
							case 12: echo json_encode(5); exit;
							default: echo json_encode(4); exit; 
						}
					}
					else if($day==30)  
					{
						switch($month)
						{
							case 2: echo json_encode(4); exit;
							default: echo json_encode(5); exit;
						}
							
					}
					else if($day==29)
					{
						switch($month)
						{
							case 2: 
								if($year%400==0)
								{
									echo json_encode(5); exit;
								}
								else if($year%100 == 0)
								{
									echo json_encode(4); exit;
								}	
								else if($year%4 == 0)
								{
									echo json_encode(5); exit;
								}
								else
								{	
									echo json_encode(4); exit;
								}	
							default: echo json_encode(5); exit;
						}
					}
					else
					{
					    echo json_encode(5); exit;
					}
				}
				else
				{
					echo json_encode(3);
				}
			} 
			else
			{
				echo json_encode(2);
			}
		}
		else
		{
			echo json_encode(1);
		}
	}
	else
	{
		echo json_encode(0);
	}
}
	}
	
	function validate_bday($day,$month,$year)
	{
		$flag = 0;
			if($day == -1 || $month == -1 || $year == -1)
		{
			return $flag;
		}
		if($day==31)
		{
			switch($month)
			{
				case 2:  return $flag;
				case 1:
				case 3:
				case 5:
				case 7:
				case 8:
				case 10:
				case 12: $flag = 1; return $flag;
				default: return $flag; 
			}
				
		} 
		else if($day==30)
		{
			switch($month)
			{
				case 2: return $flag;
				default: $flag = 1; return $flag; 
			}
				
		} 
		else if($day==29)
		{
			switch($month)
			{
				case 2: 
					if($year%400==0)
					{
						$flag = 1;
						return $flag;
					}
					else if($year%100 == 0)
					{
						return $flag;
					}	
					else if($year%4 == 0)
					{
						$flag = 1;
						return $flag;
					}
					else 
						return $flag;
				default: $flag = 1; return $flag;
			}
				
		}
		else 
		{
			$flag=1; 
			return $flag;
		}
	}
	
	function validate_time($time)
	{
		if($time >= 0000 && $time < 2400)
		{
			return 1;
		}
		return 0;
	}
	
	function validate_email($email)
	{
		$flag = 0;
		if(($email == 'you@example.com') || ($email == 'me@example.com'))
		{
				return $flag;
		}
		if($this->is_email($email))
		{ 
			$flag = 1;
		}
		$database = new Database();
		$result = $database->is_already_user($email);
		if($email==$result['EMAIL'] && $email != '')
		{
			$flag = 2;
		}
		return $flag;	
	}
	
	function is_email($email)
	{
		$flag = 0;
		if((preg_match("/^[a-zA-Z0-9]+[a-zA-Z0-9(\.|\_)]*@[a-zA-Z]\w{1,30}(\.[a-zA-Z]{2,30}[\.][a-zA-Z]{2,30})$/", $email)) || (preg_match("/^[a-zA-Z0-9]+[a-zA-Z0-9(\.|\_)]*@[a-zA-Z]\w{1,30}(\.[a-zA-Z]{2,30})$/", $email)) || (preg_match("/^[a-zA-Z0-9]+[a-zA-Z0-9(\.|\_)]*@[a-zA-Z]\w{1,30}(\.[a-zA-Z]+[\.][a-zA-Z]{2,30}[\.][a-zA-Z]{2,30})$/", $email)))
		{ 
			$flag = 1;
		}
		return $flag;	
	}
	
	function validate_name($name)
	{
		$flag = 0;
		if(($name == 'Your Full Name') || ($name == 'My Full Name'))
		{
				return $flag;
		}
		if (preg_match("/^[[:space:]]*[a-zA-Z]+[[:space:]]*[a-zA-Z]*[[:space:]]*[a-zA-Z]*$/", $name)) 
		{ 
			$flag = 1;
		}
		return $flag;	
	}
	
	function validate_password($pass)
	{
		$flag = 0;
		if (strlen($pass)>5) 
		{ 
			$flag = 1;
		} 
		return $flag;	
	}

	function validate_sex($sex)
	{
		$flag = 0;
		if($sex==0 || $sex==1){ 
			$flag = 1;
		} 
		return $flag;	
	}
	 
	function validate_school($school)
	{
		return json_encode(1);
	}
	
	function validate_year($year)
	{
		if($year == '-1')
		{
			return 0;
		}
		return 1;
	}
	 
}
?>
