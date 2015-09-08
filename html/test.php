<?php
session_start();
$_SESSION['userid'] = rand(100000,999999);
?>
<!Doctype>
<html>
<head>
<title>
	Capture User Clicks
</title>
<style>
	
</style>
<script text="text/javascript" src="script/jquery-1.8.2.min.js"></script>
<script type="text/javascript">
	
$(function(){
	
	var clickCapture = [];
	
	var http_request = new XMLHttpRequest();	
	$('body').live('click',function(event){

			console.log(event.pageX);
			console.log(event.pageY);
			
			clickCapture.push(event.pageX);
			clickCapture.push(event.pageY);
	});
	
	setInterval(ajax_call, 3000);
	
	function ajax_call()
	{
		console.log("hello");
		console.log(clickCapture);
			$.getJSON('ajax/capture_click.php',{'clickCapture':clickCapture},function(){
			
				console.log('clicks captures - update send to server');
				clickCapture = [];
			
			});
	}
});
	
</script>
</head>
<body bgcolor="gray" height="100%"width="100%">

</body>
</html>	
<?php

		


?>