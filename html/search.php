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
	<div id="left">
		Filter Search
		<div class="links">
			<a  href="search.php?filter=people<?php if(isset($_GET['q'])) echo '&q='.$_GET['q']; ?>" title="Search for people">People</a>
		</div>
		<div class="links">
			<a  href="search.php?filter=post<?php if(isset($_GET['q'])) echo '&q='.$_GET['q']; ?>" title="Search for posts">Posts</a>
		</div>
		<div class="links">
			<a  href="search.php?filter=comment<?php if(isset($_GET['q'])) echo '&q='.$_GET['q']; ?>" title="Search for Comments">Comments</a>
		</div>
		<div class="links">
			<a  href="search.php?filter=group<?php if(isset($_GET['q'])) echo '&q='.$_GET['q']; ?>" title="Search for groups">Groups</a>
		</div>
		<div class="links">
			<a  href="search.php?filter=event<?php if(isset($_GET['q'])) echo '&q='.$_GET['q']; ?>" title="Search for events">Events</a>
		</div>
	
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