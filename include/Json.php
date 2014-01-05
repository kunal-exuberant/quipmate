<?php
class Json
{
	function __construct()
	{
		
	}
	function json_tag($profileid,$database)
	{
		$tag = $_SESSION['tag_json'];
		if(!array_key_exists($profileid,$tag))
		{
			$row = $database->get_tag($profileid);
			if($row['TAGLINE'] == null)
			{	
				$tag[$profileid] = "";
			}
			else
			{
				$tag[$profileid] = $row['TAGLINE'];				
			}	
			$_SESSION['tag_json'] = $tag;
		}
	}
     
	function json_name($profileid,$database)
	{ 
		$name = $_SESSION['name_json'];
		if(!array_key_exists($profileid,$name))
		{
			$row = $database->get_name($profileid); 
			$name[$profileid] = $row['NAME'];	
			$_SESSION['name_json'] = $name;
		}
	}
	function json_diary_name($profileid,$database)
	{ 
		$name = $_SESSION['name_json'];
		if(!array_key_exists($profileid,$name))
		{
			$row = $database->get_diary_name($profileid); 
			$name[$profileid] = $row['NAME'];	
			$_SESSION['name_json'] = $name;
		}
	}
                 
	function json_pimage($profileid,$database)
	{	
		$pimage = $_SESSION['pimage_json'];
		if(!array_key_exists($profileid,$pimage))
		{ 
			$row = $database->get_image($profileid); 
			$pimage[$profileid] = $row['FILENAME'];
			$_SESSION['pimage_json'] = $pimage;
		}
	}
}
?>