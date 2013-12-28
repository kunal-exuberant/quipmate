<?php
require('../../include/Session.php');
require('../../include/Database.php');
$session = new Session();
$session->start();
require_once '../../include/diary_info.php';
$database = new Database();
$myprofileid = $_SESSION['USERID'];
$profileid = $_GET['id'];

$arr = Array("School","College");
$arr2 = Array("City","Company","Profession","Hobby","Music","Movie","Book","Sports","Rolemodel","People");
$ret = Array();
$ret2 = Array();
while(list($key,$value) = each($arr))
{
	$field = $value;
	$ret[$field] = $database->bio_field_match($field,$myprofileid,$profileid);
}
while(list($key,$value) = each($arr2))
{
	$field = $value;
	$ret2[$field] = $database->bio_field_match($field,$myprofileid,$profileid);
}

$cyear = $syear = 0;

while(list($key,$value) = each($ret))
{
	if(trim($value) != "none")
	{
		if($key == 'School')
		{
			$info = get_diary($value);
			if(is_array($info))
			{
					$syear1 = $database->bio_singlefield_select('SYEAR',$myprofileid);
					$syear2 = $database->bio_singlefield_select('SYEAR',$profileid);
					echo "<div class='subtitle'><b>".strtoupper($key)." "."MATCH".'</b><br></div>';
						while(list($key2,$value2) = each($info))
						{
							echo "<div class='bio_match_field'>".$value2."<br /><br /></div>";
							if($syear1 == $syear2)
								echo "<div class='subtitle'>SCHOOLMATE OF ".$syear2." class</div>";
							else if($syear1 > $syear2)	
								echo "<div class='subtitle'>SCHOOL SENIOR OF ".$syear2." class</div>";
							else if($syear1 < $syear2)	
								echo "<div class='subtitle'>SCHOOL JUNIOR OF ".$syear2." class</div>";	
					    }
			}
		}
		if($key == 'College')
		{
			$info = get_diary($value);
			if(is_array($info))
			{
				$cyear1 = $database->bio_singlefield_select('CYEAR',$myprofileid);
				$cyear2 = $database->bio_singlefield_select('CYEAR',$profileid);
				echo "<div class='subtitle'><b>".strtoupper($key)." "."MATCH".'</b><br></div>';
						while(list($key2,$value2) = each($info))
						{
							echo "<div>".$value2."<br /><br /></div>";
							if($cyear1 == $cyear2)
								echo "<div class='subtitle'>BATCHMATE OF ".$cyear2." Batch</div>";
							else if($cyear1 > $cyear2)	
								echo "<div class='subtitle'>BATCH SENIOR OF ".$cyear2." Batch</div>";
							else if($cyear1 < $cyear2)	
								echo "<div class='subtitle'>BATCH JUNIOR OF ".$cyear2." Batch</div>";	
						}					
			}
		}
	}
}

while(list($key,$value) = each($ret2))
{
	if(trim($value) != "none")
	{
		$info = get_diary($value);
		if(is_array($info))
		{
			echo "<div class='subtitle'>".strtoupper($key)." "."MATCH".'</div>';
			while(list($key2,$value2) = each($info))
			{
				echo "<div class='bio_match_field'>".$value2."</div>";
			}
		}
		echo "<br>";
	}
}
?>