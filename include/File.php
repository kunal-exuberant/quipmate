<?php
class File
{
	public $script_cdn = 'script/';
	public $style_cdn = 'style/';		
	function style_header()
	{
	?>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->style_cdn.'pageclass1-1.1.css'; ?>" charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->style_cdn.'layout-1.1.css'; ?>" charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->style_cdn.'notice-1.0.css'; ?>" charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->style_cdn.'menu-1.0.css'; ?>" charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->style_cdn.'actiontype-1.0.css'; ?>" charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->style_cdn.'inbox-1.0.css'; ?>" charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->style_cdn.'news-1.0.css'; ?>" charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->style_cdn.'chat-1.0.css'; ?>" charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->style_cdn.'profile_edit-1.0.css'; ?>" charset="utf-8" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->style_cdn.'bio_match-1.0.css'; ?>" charset="utf-8" media = "screen"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->style_cdn.'action-1.0.css'; ?>" charset="utf-8" media = "screen"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->style_cdn.'bio-1.0.css'; ?>" charset="utf-8" />
	<?php	
	}
	
	function style_welcome()
	{
		?>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->style_cdn.'welcome-1.0.css'; ?>" />
		<?php
	}
	
	function script_header()
	{
		?>
		    <script type="text/javascript" src="<?php echo $this->script_cdn.'jquery-1.8.2.min.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'universal_loader-1.2.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'global-1.1.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'notice-1.0.js'; ?>" charset="utf-8"></script> 
			<script type="text/javascript" src="<?php echo $this->script_cdn.'action1-1.2.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'callback-1.3.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'ajax-1.0.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'ui-1.2.js'; ?>" charset="utf-8"></script>
		<?php	
	}
	 
	function script_footer()
	{
		?>
	   <script type="text/javascript" src="<?php echo $this->script_cdn.'chat-1.1.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'friend_event-1.1.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'search-1.1.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'action-1.0.js'; ?>" charset="utf-8"></script> 
			<script type="text/javascript" src="<?php echo $this->script_cdn.'feed-1.1.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'deploy-1.2.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'jquery.form.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'image-1.1.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'profile_edit_callback-1.0.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'eigonFGtEeONACIACqoGtw.js'; ?>" charset="utf-8"></script>			
		<?php
	}
	
	function script_welcome()
	{		
		?>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'jquery-1.8.2.min.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'action1-1.2.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'callback-1.3.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'ui-1.2.js'; ?>" charset="utf-8"></script> 
			<script type="text/javascript" src="<?php echo $this->script_cdn.'ajax-1.0.js'; ?>" charset="utf-8"></script>	
		<?php
	}	
	
	function script_jquery()
	{	
		?>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'jquery-1.8.2.min.js'; ?>" charset="utf-8"></script>
		<?php			
	}
	
	function script_jquery_public()
	{	
		?>
			<script type="text/javascript" src="<?php echo '../'.$this->script_cdn.'jquery-1.8.2.min.js'; ?>" charset="utf-8"></script>
		<?php			
	}

	function script_register()
	{
		?>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'jquery-1.8.2.min.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'jquery.form.js'; ?>" charset="utf-8"></script>
		<?php
	}
	
	function google_analytics()
	{
		echo "<script type='text/javascript'>
			  var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', 'UA-28382594-1']);
			  _gaq.push(['_trackPageview']);

			  (function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			  })();
			</script>";
	}
}
?>