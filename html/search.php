<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
<script type="text/javascript">
</script>
<?php
require_once '../include/header.php';
?>		
<div id="wrapper">
<input type="hidden" id="search_key_hidden" value="<?php if(isset($_GET['q'])) echo $_GET['q']; ?>">
<input type="hidden" id="filter_hidden" value="<?php if(isset($_GET['filter'])) echo $_GET['filter']; ?>">
<?php 
$filter = ''; 
if(isset($_GET['filter']))
{
	$filter = $_GET['filter']; 
}
	function link_echo($type)
	{
		?>
		<div class="links">
			<a class="<?php if($type == $filter) echo ' selected'; ?>" href="search.php?filter=<?php echo $type; ?><?php if(isset($_GET['q'])) echo '&q='.$_GET['q']; ?>" title="Search for <?php echo $type; ?>"><img class="lfloat" src="http://icon.qmcdn.net/search_icon.png" height="18" width="18" /><span class="name_20"><?php echo $type; ?></span></a>
		</div>
		<?php
	}
?>
	<div id="left" style="padding:2em 0em 2em 0em;">
		
		<h1>Search for :</h1>
		<?php
		
		link_echo('people');
		link_echo('post');
		link_echo('comment');
		link_echo('group');
		link_echo('event');
		link_echo('skill');
		link_echo('project');
		link_echo('tool');
		link_echo('major');
		link_echo('certificate');
		link_echo('award');
		link_echo('hobby');
		link_echo('sport');
		link_echo('book');
		link_echo('movie');
		link_echo('music');
		link_echo('company');
		link_echo('college');
		link_echo('school');
		link_echo('profession');
		link_echo('city');
		?>
		
	</div>
	<div id="center" style="height:auto;">
	<h1 class="page_title" id="search_count">Search results</h1>
	<div id="search_result"></div>
	</div>
	<div id="right" ></div>
</div>
<?php require_once('../include/footer.php'); ?>
</body>
</html>