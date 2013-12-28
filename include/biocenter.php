<?php
require_once('../include/diary_info.php');
require_once('../include/Help.php');
$database = new Database();
$help = new Help();
$newrow = $database->bio_complete_select($profileid);
$res = $database->bio_select_new($profileid);
$company = array(); $team = array(); $major = array(); $skill = array(); $tool = array(); $mobile = array();  $extension = array(); $certificate = array(); $project = array(); $award = array(); $college = array(); $school = array(); $music = array(); $movie = array(); $sports = array(); $book = array(); $city = array(); $hobby = array();
while($brow = $res->fetch_array())
{
	if($brow['type'] == 205)
	{
		$company[] = $brow['name'];
		$companyid[] = $brow['actionid'];
	}
	else if($brow['type'] == 202)
	{
		$profession = $brow['name'];
		$professionid = $brow['actionid'];		
	}
	else if($brow['type'] == 204)
	{
		$college[] = $brow['name'];
		$collegeid[] = $brow['actionid'];		
	}
	else if($brow['type'] == 203)
	{
		$school[] = $brow['name'];
		$schoolid[] = $brow['actionid'];		
	}
	else if($brow['type'] == 206)
	{
		$music[] = $brow['name'];
		$musicid[] = $brow['actionid'];
	}
	else if($brow['type'] == 209)
	{
		$sports[] = $brow['name'];
		$sportsid[] = $brow['actionid'];
	}
	else if($brow['type'] == 208)
	{
		$book[] = $brow['name'];
		$bookid[] = $brow['actionid'];
	}
	else if($brow['type'] == 201)
	{
		$city[] = $brow['name'];
		$cityid[] = $brow['actionid'];
	}
	else if($brow['type'] == 207)
	{
		$movie[] = $brow['name'];
		$movieid[] = $brow['actionid'];
	}
	else if($brow['type'] == 211)
	{
		$hobby[] = $brow['name'];
		$hobbyid[] = $brow['actionid'];     
	}
	else if($brow['type'] == 215)
	{
		$mobile[] = $brow['name'];
		$mobileid[] = $brow['actionid'];     
	}
	else if($brow['type'] == 230)
	{
		$skill[] = $brow['name'];
		$skillid[] = $brow['actionid'];
	}
	else if($brow['type'] == 231)
	{
		$project[] = $brow['name'];
		$projectid[] = $brow['actionid'];     
	}
	else if($brow['type'] == 232)
	{
		$certificate[] = $brow['name'];
		$certificateid[] = $brow['actionid'];
	}
	else if($brow['type'] == 233)
	{
		$award[] = $brow['name'];
		$awardid[] = $brow['actionid'];     
	}
	else if($brow['type'] == 234)
	{
		$team[] = $brow['name'];
		$teamid[] = $brow['actionid'];		
	}
	else if($brow['type'] == 235)
	{
		$major[] = $brow['name'];
		$majorid[] = $brow['actionid'];		
	}
	else if($brow['type'] == 236)
	{
		$tool[] = $brow['name'];
		$toolid[] = $brow['actionid'];		
	}
	else if($brow['type'] == 237)
	{
		$extension[] = $brow['name'];
		$extensionid[] = $brow['actionid'];		
	}
}
$row=$database->privacy_select($myprofileid);

$name = $newrow['NAME'];
$tagline = $newrow['TAGLINE'];
$sex = $newrow['SEX'];
$email = $newrow['EMAIL'];
$bday = $newrow['BIRTHDAY'];
$nickname = $newrow['NICKNAME'];
$relation = $newrow['RELATION'];

?>
<div style="padding:1em 4em 2em 1em;"><span style="font-size:1.8em;font-weight:bold;"><?php echo $name; 
if(isset($nickname))
{
if($help->checkPrivacy('NICKNAME',$profileid) == 1 && $nickname != ""){
			echo '('.$nickname.')'; 
}
}		
?>
</span>
<?php
if(isset($tagline))
{
?>
	<div id="bio_tagline" style="margin:1em 0 0 0;color:#336699;">
	<h1 style="font-size:1.3em;"><?php echo '"'.stripslashes($tagline).'"'; ?></h1> 
	</div>
<?php
}
echo '<div class="items">'.$database->get_age($profileid).' years old'.'</div>';	
	?>
		<div class="bio_ceach">
			<div class="bio_each_title" style="margin:1.5em 0em 0em 0em;">Profession</div>
			<?php
					bio_item_deploy($profile_relation, 234, 'Team', $team, $teamid, 'team_edit_link', $help, $row['team']);
					bio_single_deploy($profile_relation, 202, 'Profession', $profession, $professionid, 'profession_edit_link', $help, $row['profession']);
					bio_item_deploy($profile_relation, 235, 'Major', $major, $majorid, 'major_edit_link', $help, $row['major']);
					bio_item_deploy($profile_relation, 230, 'Skill', $skill, $skillid, 'skill_edit_link', $help, $row['skill']);
					bio_item_deploy($profile_relation, 236, 'Tools worked on', $tool, $toolid, 'tool_edit_link', $help, $row['Tools worked on']);
					bio_item_deploy($profile_relation, 231, 'Project', $project, $projectid, 'project_edit_link', $help, $row['project']);
					bio_item_deploy($profile_relation, 232, 'Certificate', $certificate, $certificateid, 'certificate_edit_link', $help, $row['certificate']);
					bio_item_deploy($profile_relation, 233, 'Award', $award, $awardid, 'award_edit_link', $help, $row['award']);
			?>
		</div>
		<div class="bio_ceach">
			<div class="bio_each_title">Background</div>
			<?php
					bio_item_deploy($profile_relation, 205, 'Company', $company, $companyid, 'company_edit_link', $help, $row['company']);
					bio_item_deploy($profile_relation, 204, 'College', $college, $collegeid, 'college_edit_link', $help, $row['college']);
					bio_item_deploy($profile_relation, 203, 'School', $school, $schoolid, 'school_edit_link', $help, $row['school']);
					bio_item_deploy($profile_relation, 201, 'City', $city, $cityid, 'city_edit_link', $help, $row['city']);
					bio_item_deploy($profile_relation, 211, 'Hobby', $hobby, $hobbyid, 'hobby_edit_link', $help, $row['hobby']);
			?>
		</div>
		<div class="bio_ceach">
			<div class="bio_each_title">Personal</div>
			<?php
					bio_item_deploy($profile_relation, 206, 'Music', $music, $musicid, 'music_edit_link', $help, $row['music']);
					bio_item_deploy($profile_relation, 207, 'Movie', $movie, $movieid, 'movie_edit_link', $help, $row['movie']);
					bio_item_deploy($profile_relation, 208, 'Book', $book, $bookid, 'book_edit_link', $help, $row['book']);
					bio_item_deploy($profile_relation, 209, 'Sports', $sports, $sportsid, 'sports_edit_link', $help, $row['sports']);
			?>
		</div>
		<div class="bio_ceach">
			<div class="bio_each_title">Contact</div>
			<?php
					if(isset($email))
					{
						if($help->checkPrivacy('EMAIL',$profileid) == 1)
							echo "<div class='item_title'>Email</div> ".'<div class="items">'.$email.'</div>';
					}
					bio_item_deploy($profile_relation, 237, 'Office Extension', $extension, $extensionid, 'extension_edit_link', $help, $row['extension']);
					bio_item_deploy($profile_relation, 215, 'Mobile', $mobile, $mobileid, 'mobile_edit_link', $help, $row['mobile']);
			?>
		</div>
	<?php	
	
	if(isset($bday))
	{
			if($help->checkPrivacy('BIRTHDAY',$profileid) == 1 && $bday !="")
				echo "<div class='item_title'>Birthday</div>".'<div class="items">'.date('j M,Y',strtotime($bday)).'</div>'; 		
	}
	
	function bio_single_deploy($profile_relation, $code, $key, $value, $valueid, $id, $help, $privacy)
	{	
		if($profile_relation == 0)
		{
			if(isset($value))
			{
				echo "<div class='item_title'><span class='item_title_text'>$key</span><span class='item_edit_link' id='$id' onclick='item_single_edit($id,$code,\"$value\", $privacy)'>Edit</span></div>";
				echo "<div class='items'>";
				$k = 0;
				echo "<div class='item_each'>".$value."<span class='item_edit_remove' onclick='action.bio_item_remove(this, $valueid[$k])'>Remove<span></div>";
				$k++;
				echo "</div>";
			}
		}
		else
		{
			if(!empty($value))
			{
				if($help->checkPrivacy($key,$profileid) == 1 )
				{
					echo "<div class='item_title'><span class='item_title_text'>$key</span></div>";
					echo "<div class='items'>";
					echo "<div class='item_each'>".$value."</div>";
					echo "</div>";
				}
			}
		}
	}
	
	
	function bio_item_deploy($profile_relation, $code, $key, $value, $valueid, $id, $help, $privacy)
	{	
		if($profile_relation == 0)
		{
			if(isset($value))
			{
				echo "<div class='item_title'><span class='item_title_text'>$key</span><span class='item_edit_link' id='$id' onclick='item_edit($id,$code,\"$key\", $privacy)'>Edit</span></div>";
				echo "<div class='items'>";
				$k = 0;
				foreach($value as $s)
				{	
					echo "<div class='item_each'>".$s."<span class='item_edit_remove' onclick='action.bio_item_remove(this, $valueid[$k])'>Remove<span></div>";
					$k++;
				}
				echo "</div>";
			}
		}
		else
		{
			if(!empty($value))
			{
				if($help->checkPrivacy($key,$profileid) == 1 )
				{
					echo "<div class='item_title'><span class='item_title_text'>$key</span></div>";
					echo "<div class='items'>";
					foreach($value as $s)
					{	
						echo "<div class='item_each'>".$s."</div>";
					}
					echo "</div>";
				}
			}
		}
	}
?>
</div>
<script type="text/javascript" >
	function item_edit(container,code,key,privacy)
	{
		$('.item_edit_remove').show();
		var placeholder ='';
		switch(code)
		{
			case 205 : placeholder = 'Add your company'; break;
			case 204 : placeholder = 'Add your college'; break;
			case 203 : placeholder = 'Add your School'; break;
			case 211 : placeholder = 'Add your hobby'; break;
			case 230 : placeholder = 'Add a skill'; break;
			case 231 : placeholder = 'Add a project'; break;
			case 232 : placeholder = 'Add a certificate'; break;
			case 233 : placeholder = 'Add an award'; break;
			default : placeholder = '';
		}
		$('.profile_edit_each').remove();
		if(privacy == 0)
		{
			$(container).parent().next().prepend('<div class="profile_edit_each  bgcolor"><input style="margin-left:.5em;" onkeyup="ui.diary_suggest(this,'+code+')" type="text" placeholder="'+placeholder+'" class="profile_edit_textbox" value = "" size="40"/><span id="profile_post_privacy_link" onclick="ui.bio_privacy(this,event,\''+key+'\')" style="margin-left:1.5em;cursor:pointer;"><img title="Privacy" src="http://icon.qmcdn.net/global.png" height="20" width="20" /></span></div>');
		}
		else if(privacy == 1)
		{
			$(container).parent().next().prepend('<div class="profile_edit_each  bgcolor"><input style="margin-left:.5em;" onkeyup="ui.diary_suggest(this,'+code+')" type="text" placeholder="'+placeholder+'" class="profile_edit_textbox" value = "" size="40"/><span id="profile_post_privacy_link" onclick="ui.bio_privacy(this,event,\''+key+'\')" style="margin-left:1.5em;cursor:pointer;"><img title="Privacy" src="http://icon.qmcdn.net/meeting.png" height="20" width="20" /></span></div>');
		}
		else if(privacy == 2)
		{
			$(container).parent().next().prepend('<div class="profile_edit_each  bgcolor"><input style="margin-left:.5em;" onkeyup="ui.diary_suggest(this,'+code+')" type="text" placeholder="'+placeholder+'" class="profile_edit_textbox" value = "" size="40"/><span id="profile_post_privacy_link" onclick="ui.bio_privacy(this,event,\''+key+'\')" style="margin-left:1.5em;cursor:pointer;"><img title="Privacy" src="http://icon.qmcdn.net/friend.png" height="20" width="20" /></span></div>');
		}	
	}
	
	function item_single_edit(container,code,value,privacy)
	{
		$('.item_edit_remove').show();
		var placeholder ='';
		switch(code)
		{
			case 205 : placeholder = 'Add your company'; break;
			case 204 : placeholder = 'Add your college'; break;
			case 203 : placeholder = 'Add your School'; break;
			case 211 : placeholder = 'Add your hobby'; break;
			case 230 : placeholder = 'Add a skill'; break;
			case 231 : placeholder = 'Add a project'; break;
			case 232 : placeholder = 'Add a certificate'; break;
			case 233 : placeholder = 'Add an award'; break;
			default : placeholder = '';
		}
		$('.profile_edit_each').remove();
		$(container).parent().next().prepend('<div class="profile_edit_each  bgcolor"><input style="margin-left:.5em;" onkeyup="ui.diary_suggest(this,'+code+')" type="text" placeholder="'+placeholder+'" class="profile_edit_textbox" value ="'+value+'" size="40"/><input type="submit" value="Save" onclick=""></div>');
	}
</script>