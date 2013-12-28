<?php
include '../include/Session.php';
include '../include/Email_new.php';
include '../include/Database.php';

$session = new Session();
$session->start();
$database = new Database();
$email1 = new Email();
$param = array();
echo '<br />'.$_SESSION['database'].'<br />';
$param['type'] = 'group_admin';
$param['friendid'] = '1000000002';
$param['profileid'] = '1000000001'; 
$param['groupid'] = '398';
echo '<br />'.$email1->email_sample($param).'<br />'; 

$param['type'] = 'event_invite';
$param['friendid'] = '1000000002';
$param['profileid'] = '1000000001'; 
$param['eventid'] = '1267';
echo '<br />'.$email1->email_sample($param).'<br />'; 

/*
if ($handle = opendir('/var/www/html/upload_pic/')) {
    echo "Directory handle: $handle\n";
    echo "Entries:\n";

    /* This is the correct way to loop over the directory. 
	$i = 0;
    while (false !== ($entry = readdir($handle))) {
        echo "\n$entry\n"; 
		echo "\r\n";
		if($i > 3921)      
		{
				echo cdn_upload('upload_pic/'.$entry,'profile',$entry);	
		}	
		echo "\r\n";
		$i++;
    }

    closedir($handle);
} 
 
	echo cdn_upload('sound/chat_sound.mp3','png', 'chat_sound.mp3');
		
	function cdn_upload($file_to_be_uploaded, $cdn, $filename)
	{
		require_once('../include/cloudfiles.php');
					
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

?>

*/