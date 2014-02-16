<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
<?php
	require('../include/header.php');
	$file = new File();
	$file->script_register();
?>
<style>
body{background:#ededed;}
</style>
</head>
<body>
<div id="wrapper">
	<div id="center" style="margin:6em 0em 0em 16em;padding:2em 5em 2em 5em;position:relative;min-height:16em;border:none;">
	<?php 
		if($page == 'friend_suggest')
		{
	?>
	<h1 class="page_title"><?php echo $_SESSION['NAME']; ?>, let's add some friends to get started</h1>
	<div id="friend_suggest"></div>
	<?php
		}
		else if($page == 'group_suggest')
		{
	?>
	<h1 class="page_title"><?php echo $_SESSION['NAME']; ?>, let's join some group to get started</h1>
	<div id="group_suggest"></div>
	<?php
		}
		else if($page == 'profile_picture')
		{
			?>
			<h1 class="page_title"><?php echo $_SESSION['NAME']; ?>, let's upload a profile picture</h1>
			<div id="main_div" style="text-align:center;margin-top:4em;">
			<div id="photo_preview" style="text-align:center;margin:0em 0em 1em 0em;"></div>	
			
					<form id="pform" method="post" enctype="multipart/form-data" action="/ajax/write.php">
						<div style="">
							<input type="file" id="photo_box" name="photo_box" />
						<button type="button" id="photo_upload_button">Upload</button>
						</div>
						<input type="hidden" name="action" value="profile_picture_upload"/>
					</form>
			</div>
			<?php
		}
	?>
	<a id="next" href="#" style="position:absolute;bottom:1em;right:1em">Next</a>
	</div>
</div>
<input type="hidden" id="step_hidden" value="<?php echo $_SESSION['STEP']; ?>"/>
<?php require_once('../include/footer.php'); ?>
</body>
<script type="text/javascript">
	$(function(){
		$("#next").live('click',function(){
			$.getJSON("ajax/write.php",{action:'stepup',step:'2'},function(data){
				window.location = '/';
			});
		});
		
		$('#pform').ajaxForm(function(){});  
		$('#photo_upload_button').click(function()
		{
			$("#photo_preview").html('<img src="http://icon.qmcdn.net/upload.gif" alt="Uploading...."/>');
			$("#pform").ajaxSubmit(
			{
				type:'json',
				success: function(response){ 
				var data = $.parseJSON(response);
					if(data.ack == '1')
					{					
						$('#main_div').html('<img src ="'+data.thumb+'" style="max-width:33.5em;margin-bottom:1em;cursor:pointer;border:0.1em solid #aaaaaa;" data="'+data.thumb+'" class="viewable" id="'+data.actionid+' " />');
					}
					else if(data.ack == '2')
					{
						$('#photo_preview').html('Unable to upload image. Please try again.');
					}
					else if(data.ack == '3')
					{
						$('#photo_preview').html('Image size is more than 10Mb. Please compress this image and try again.');
					}
					else if(data.ack == '4')
					{
						$('#photo_preview').html('Please upload an image of jpg/jpeg, png, gif, bmp type only. Please change the image type and try again.');
					}
					else if(data.ack == '5')
					{
						$('#photo_preview').html('Please chose a photo to upload');
					}						
				}
			});
			return false;
		}); 
	});	
	
	function chooseFile() 
	{
		$("#photo_box").click();
	}
	</script>
</html>