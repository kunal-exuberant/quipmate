<?php
require_once('/var/www/include/Database.php');
require_once('/var/www/include/Email.php');
$database = new Database();
$email_object = new Email();
$presult = $database->profile_friend_invite_select();
while($prow=$presult->fetch_array())
{	
	$profileid = $prow['PROFILEID'];
	$brow = $database->bio_complete_select($profileid);
	$email = $brow['EMAIL'];
	$name = $brow['NAME'];
	$result = 0;
	$param = array();
	$param['type'] = 'friend_request_broadcast';
	$param['email'] = $email;
	$param['name'] = $name;
	$result = $email_object->email_sample($param);
	echo $result;
}
?> 
