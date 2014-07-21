<?php
require_once('/var/www/include/Database.php');
$database = new Database();
$csv_id =0;
$presult = $database->pending_email_select();
while($prow=$presult->fetch_array())
{	
	$id = $prow['id'];
	$email = $prow['email'];
	$subject = $prow['subject'];
	$mes = $prow['body'];
	$additionalHeaders = $prow['headers'];
	$result = mail($email,$subject,$mes,$additionalHeaders);
	$csv_id .= ','.$id;
	//echo $result;
}
//echo $csv_id ;
$database->sent_email_delete($csv_id);

?> 
