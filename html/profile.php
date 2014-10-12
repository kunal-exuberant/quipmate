<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<?php
require_once '../include/header.php';
?>
<div class="container">
  <div class="row" >
   <div class="col-md-2 left" id="left">
   <div class="panel panel-default">
    <div class="panel-body">
		<ul  class=" nav nav-pills nav-stacked"> 
			<li class="links" <?php if($page == 'profile_json') echo 'style="background:#ddd;"'; ?>><a class="ajax_nav" id="profile_json" href="profile.php?id=<?php echo $profileid.'&hl=diary'?>" title="Your activities"><span >Diary</span></a></li>
			
			<li class="links" <?php if($page == 'bio') echo 'style="background:#ddd;"'; ?>><a  class="ajax_nav" id="bio" href="profile.php?id=<?php echo $profileid.'&hl=bio'?>" title="Your Bio"><span >Bio</span></a></li>
			
					 
			 <li class="links" <?php if($page == 'praise') echo 'style="background:#ddd;"'; ?>><a class="ajax_nav" id="pphoto" href="profile.php?id=<?php echo $profileid.'&hl=praise'?>" title="Your Praises"><span >Praises</span></a></li>
			 
		    <li class="links" <?php if($page == 'pphoto') echo 'style="background:#ddd;"'; ?>><a class="ajax_nav" id="pphoto" href="profile.php?id=<?php echo $profileid.'&hl=image'?>" title="Your Photos"><span >Photos</span></a></li>
			<li class="links" <?php if($page == 'following') echo 'style="background:#ddd;"'; ?>><a  class="ajax_nav" id="following" href="profile.php?id=<?php echo $profileid.'&hl=following'?>" title="You are following"><span >Following (<?php echo $database->following_count($profileid); ?>)</span></a></li>
			<li class="links" <?php if($page == 'followers') echo 'style="background:#ddd;"'; ?>><a  class="ajax_nav" id="followers" href="profile.php?id=<?php echo $profileid.'&hl=followers'?>" title="Your Followers"><span >Followers (<?php echo $database->followers_count($profileid); ?>)</span></a></li>
		</ul>
		<?php
	if($profile_relation == 1)
	{
	?>
		<div style="margin-top:2em;text-align:center;">
			<a style="color:#003399;" href="#" onclick="ui.unfriend(this) " >Unfollow <?php echo ' '.$profile_name; ?></a>
		</div>
	<?php
	}
	$page == 'bio';
	?>	
    </div>
    </div>
</div> <!-- Left ends -->
	<?php
			if($page == 'bio')
			{
				echo '<div id="center" class="col-md-8 center" >';
				require('../include/biocenter.php');
				echo '</div>';
			}
			else
             if($page == 'profile_json')
			{
				echo '<div id="center" class="col-md-8 center" >';
				require('../include/actions.php');
				echo '</div>';
			}
			else
			{
				echo '<div id="center" class="col-md-8 center" ></div>';
			}

 ?>
 </div> <!---row closed -->	
</div> <!---Container closed -->
<?php require_once('../include/footer.php'); ?>
</body>
</html>



