<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
<?php
require_once '../include/header.php';
$profileid = $myprofileid;
?>
<div class="container">
<div class="row" >
<input type="hidden" value="<?php if(isset($_GET['actionid'])) echo $_GET['actionid']; ?>" id="actionid_hidden" />
<input type="hidden" value="<?php if(isset($_GET['life_is_fun'])) echo $_GET['life_is_fun']; ?>" id="life_is_fun_hidden" />
<?php
if(isset($_GET['hl']))
{
	?>
	<div class="main-content" style="margin:4em 20em 0em 0em;">	
		<h1 class="page_title">Write a blog</h1>
		<div id="main_div" style="padding:2em;">
			<form id="blog_publish_form" method="post" enctype="multipart/form-data" action="/ajax/write.php">
				<input style="border:1px solid #cccccc;width:40em;padding:0.5em;margin:0.5em;" type="text" placeholder="What this blog is about?" maxlength="200" id="blog_title" name="blog_title"/>
				<div style="margin:2em 0em;">
					<span style="margin:0.5em;">Chose a photo for the blog</span>
					<input  size="30" type="file" name="photo_box" id="photo_box" />
				</div> 
				<textarea style="resize:none;height:20em;width:60em;" name="blog_content" id="blog_content" placeholder="Write the bolg content here"></textarea>
				<div style="margin:2em 0em;">
					<input class="group_create_positive" type="submit" name="blog_publish" id="blog_publish" value="Publish Blog" />
				</div>
				<input type="hidden" id="photo_hidden_profileid" name="photo_hidden_profileid" value="<?php echo $profileid; ?>"/><input type="hidden" name="action" value="blog_publish"/>
			</form>
		</div>
	</div>
	<?php	
}
else if(isset($_GET['fine']))
{
	echo time();
}
else
{
	?>
	<div class="col-xs-6 col-md-1 " id="left"></div>
	<div id="center" class="col-md-8 center"></div>
	<div id="right" class="col-md-3 right"></div> 
<?php
}
?>
</div>
</div>
</body> 
</html>
<?php
require_once('../include/footer.php'); ?>

