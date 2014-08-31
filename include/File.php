<?php
//-----------------CDN urls-----------------------------------------------
//$script_cdn='https://cb1c99c599f84e82bc6c-9f7d7d8a0bec2e21a1a6ea697d537f8d.ssl.cf2.rackcdn.com/';
//$style_cdn='https://7f0cf736abbdd4f83d8b-475de27d87a6fd312d1dd9701d87a2a9.ssl.cf2.rackcdn.com/';
//--------------------------------------------------------------------------------------
class File
{
	public $script_cdn = 'script/';
	public $style_cdn = 'style/';	

	
	function style_header()
	{
	?>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->style_cdn.'bootstrap.min.css'; ?>" charset="utf-8"/>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->style_cdn.'jquery-ui.css'; ?>" charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $this->style_cdn.'boot-1.6.css'; ?>" charset="utf-8"/>
		
	<?php	
	} 
	
	function style_welcome()
	{
		?>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->style_cdn.'bootstrap.min.css'; ?>" charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->style_cdn.'welcome-1.5.css'; ?>" charset="utf-8" />
		<?php
	}
	
	function script_header()
	{
		?>
		    <script type="text/javascript" src="<?php echo $this->script_cdn.'jquery-1.8.2.min.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'bootstrap.min.js'; ?>" charset="utf-8"></script>
		<?php	
	}
	 
	function script_footer()
	{
		?>
        	<script type="text/javascript" src="<?php echo $this->script_cdn.'global-2.3.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'action-2.5.js'; ?>" charset="utf-8"></script>
            <script type="text/javascript" src="<?php echo $this->script_cdn.'ajax-1.0.js'; ?>" charset="utf-8"></script>
            <script type="text/javascript" src="<?php echo $this->script_cdn.'feed-2.3.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'callback-2.5.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'ui-2.4.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'deploy-2.6.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'jquery.form.min.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'eigonFGtEeONACIACqoGtw.js'; ?>" charset="utf-8"></script>
            <script type="text/javascript" src="<?php echo $this->script_cdn.'jquery-ui-1.10.4.min.js'; ?>" charset="utf-8"></script>
            <script type="text/javascript" src="<?php echo $this->script_cdn.'highcharts.js'; ?>" charset="utf-8"></script>
            <script type="text/javascript" src="<?php echo $this->script_cdn.'exporting.js'; ?>" charset="utf-8"></script>  			
		<?php
	}
	
	function script_welcome()
	{		
		?>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'jquery-1.8.2.min.js'; ?>" charset="utf-8"></script>
            <script type="text/javascript" src="<?php echo $this->script_cdn.'bootstrap.min.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'action-2.5.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'callback-2.5.js'; ?>" charset="utf-8"></script>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'ui-2.4.js'; ?>" charset="utf-8"></script> 
			<script type="text/javascript" src="<?php echo $this->script_cdn.'ajax-1.0.js'; ?>" charset="utf-8"></script>	
		<?php
	}	
	
	function script_jquery() 
	{	
		?>
			<script type="text/javascript" src="<?php echo $this->script_cdn.'jquery-1.8.2.min.js'; ?>" charset="utf-8"></script>
		<?php			
	}
	
	function script_jquery_public()  /*  remember to remove '..' below for this, before moving to production, else blog will not work !   ******/
	{	 
		?>
			<script type="text/javascript" src="<?php echo '../'.$this->script_cdn.'jquery-1.8.2.min.js'; ?>" charset="utf-8"></script>
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