<?php
session_start();
define(FILENAME, 'capture_click.txt');
if(isset($_GET['clickCapture']))
{
	$userid = $_SESSION['userid']; 
	$click_capture = $_GET['clickCapture'];
	$data = '';
	print_r($click_capture);
	if(file_exists(FILENAME))
	{
		$handle = fopen(FILENAME, 'a');
		$each = '';
		foreach($click_capture as $e);
		{
			$each = $e.',';
		}
		$data = "\n".$userid.':'.$each;
		fwrite($handle, $data);
		fclose($handle);
		$result['ack'] = 1;
		echo json_encode($result);
	}
	else
	{
		$handle = fopen(FILENAME,'w');
		$each = '';
		foreach($click_capture as $e);
		{
			$each = $e.',';
		}
		$data = "\n".$userid.':'.$each;
		fwrite($handle, $data);
		fclose($handle);
		$result['ack'] = 1;
		echo json_encode($result);
	}
}
?>