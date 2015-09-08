<?php
$info = array();
function splitcolon($info)

{
	$arr = Array();
	$pat = ":";
	if($info != "")
	{
		$arr = explode($pat,$info);
		return $arr;
	}
	else 
	{
		return "blank";
	}
}

function name_retrieve($val,$key)
{
	static $index=0;
	global $info;
	$database = new Database();
	$diary_name = $database->data_retrieve($val);
	$name = $diary_name['NAME'];
	$info[$index] = $name;
	$index++;
}

function get_diary($field_value)
{
	$ids = splitcolon($field_value);
	global $info;
	$info = array();
	if(is_array($ids))
	{
		array_walk($ids,'name_retrieve');
	}
	else  
	{
		$info = $ids;		
	}
	return $info;
}
?>