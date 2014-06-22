<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
<script type="text/javascript">
</script>
<?php
require_once '../include/header.php';
?>		
<div class="container">
  <div class="row" >
<input type="hidden" id="search_key_hidden" value="<?php if(isset($_GET['q'])) echo $_GET['q']; ?>">
<input type="hidden" id="filter_hidden" value="<?php if(isset($_GET['filter'])) echo $_GET['filter']; ?>">
<?php 
$filter = ''; 
if(isset($_GET['filter']))
{
	$filter = $_GET['filter']; 
}
	function link_echo($filter, $type)
	{
		?>
		<div class="links">
			<a class="ajax_nav <?php if($type == $filter) echo ' selected'; ?>" href="search.php?filter=<?php echo $type; ?><?php if(isset($_GET['q'])) echo '&q='.$_GET['q']; ?>" title="Search for <?php echo $type; ?>"><img class="lfloat" src="http://icon.qmcdn.net/search_icon.png" height="18" width="18" /><span class="name_20"><?php echo $type; ?></span></a>
		</div>
		<?php
	}
?>
	<div class="col-md-2 left" id="left">
		
		<h1>Search for :</h1>
		<?php
		
		link_echo($filter,'people');
		link_echo($filter,'post');
		link_echo($filter,'comment');
		link_echo($filter,'group');
		link_echo($filter,'event');
		link_echo($filter,'skill');
		link_echo($filter,'project');
		link_echo($filter,'tool');
		link_echo($filter,'major');
		link_echo($filter,'certificate');
		link_echo($filter,'award');
		link_echo($filter,'hobby');
		link_echo($filter,'sport');
		link_echo($filter,'book');
		link_echo($filter,'movie');
		link_echo($filter,'music');
		link_echo($filter,'company');
		link_echo($filter,'college');
		link_echo($filter,'school');
		link_echo($filter,'profession');
		link_echo($filter,'city');
		?>
		
	</div>
	<div id="center" class="col-md-6 center" >
	<h1 class="page_title" id="search_count">Search results</h1>
	<div id="search_result"></div>
	</div>
	<div id="right" class="col-md-3 right"></div>
</div>
</div>
<?php require_once('../include/footer.php'); ?>
</body>
</html>