<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<?php
require_once '../include/header.php';
?>
<div class="container-fluid">
  <div class="row" >
  <div class="col-md-10">
    <div class="row home_row left1">
    <div class="col-md-2 left" id="left">
			<a class="ajax_nav" href="page.php?id=<?php echo $profileid ?>"><img class="img-thumbnail" src="<?php echo $profile_image; ?>" /></a>
			
			<div class="text-center">
				<a  class="ajax_nav" href="page.php?id=<?php echo $profileid; ?>" class="ellipsis"><?php echo $profile_name; ?></a>
			</div>
			<ul class=" nav nav-pills nav-stacked"> 
				<li class="links" <?php if($page == 'page_json') echo 'style="background:#ddd;"'; ?>><a class="ajax_nav" id="page_json" href="page.php?id=<?php echo $profileid.'&hl=post'?>" title="Your activities"><span class="name_20">Page Feed</span></a></li>
				
				<li class="links" <?php if($page == 'page_about') echo 'style="background:#ddd;"'; ?>><a  class="ajax_nav" id="about" href="page.php?id=<?php echo $profileid.'&hl=about'?>" title="Your Bio"><span class="name_20">About</span></a></li>

			</ul>
	</div>	
	<?php
			if($page == 'page_about')
			{
				echo '<div id="center" class="col-md-6 center" >';
				echo '<div style="padding:1em;font-size:1.6em;font-weight:bold">'.$profile_name.'</div>';
				echo '<div style="padding:1em;font-size:1.4em;">'.$n['description'].'</div>';
				echo '</div>';
			}
			else if($page == 'page_json')
			{
				echo '<div id="center" class="col-md-6 center">';
				require('../include/actions.php');
				echo '</div>';
			}
			else if($page == 'page_settings')
			{
				echo '<div id="center" style="text-align:center" class="col-md-6 center">';
				?>
				<h1 class="page_title">Page Settings</h1>
					<div id="group_info"></div>
					<div>
						<span style="margin:1em 0em;padding:0.5em;">Page Name :</span>
						<span style="margin:1em 0em;padding:0.5em;"><?php echo $n['name']; ?></span>
					</div>
					<div>
						<textarea style="margin: 1em 0em;padding:0.5em;" id="group_description" placeholder="What is this group about ?"><?php echo $n['description']; ?></textarea>
					</div>
					<div class="group_create_button">
						<input style="margin:0em 1em" type="submit" onclick="action.group_settings_save(this)" value="Save" class="group_create_positive">
					</div>
				<?php
				echo '</div>';
			}
			else
			{
				echo '<div id="center" class="col-md-6 center"></div>';
			}
	?>
		
	<div id="right" class="col-md-3 right">

		<div class="right_item" id="group_description">
			<div class="subtitle">Page Description</div>
			<div><?php echo $n['description'];?></div>
		</div>

	</div>
</div>
</div>
<div class="col-md-2">
<?php require_once('../include/footer.php'); ?>
</div>
</div>
</div>
</body>
</html>