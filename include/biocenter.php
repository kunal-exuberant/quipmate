<?php

require_once ('../include/diary_info.php');
require_once ('../include/Help.php');
$database = new Database();
$help = new Help();
$newrow = $database->bio_complete_select($profileid);
$res = $database->bio_select_new($profileid);
$company = array();
$team = array();
$major = array();
$skill = array();
$tool = array();
$mobile = array();
$extension = array();
$certificate = array();
$project = array();
$award = array();
$college = array();
$school = array();
$music = array();
$movie = array();
$sports = array();
$book = array();
$city = array();
$hobby = array();
$flag_des = 0;
$flag = 0;
$profession = '';
$designation = '';
while ($brow = $res->fetch_array())
{
   if ($brow['type'] == 205)
   {
      $company[] = $brow['name'];
      $companyid[] = $brow['actionid'];
   }
   else
      if ($brow['type'] == 202)
      {
         if ($flag == 0)
         {
            $profession = $brow['name'];
            $professionid = $brow['actionid'];
            $flag = 1;
         }
      }
      else
         if ($brow['type'] == 239)
         {
            if ($flag_des == 0)
            {
               $designation = $brow['name'];
               $designationid = $brow['actionid'];
               $flag_des = 1;
            }
         }
         else
            if ($brow['type'] == 204)
            {
               $college[] = $brow['name'];
               $collegeid[] = $brow['actionid'];
            }
            else
               if ($brow['type'] == 203)
               {
                  $school[] = $brow['name'];
                  $schoolid[] = $brow['actionid'];
               }
               else
                  if ($brow['type'] == 206)
                  {
                     $music[] = $brow['name'];
                     $musicid[] = $brow['actionid'];
                  }
                  else
                     if ($brow['type'] == 209)
                     {
                        $sports[] = $brow['name'];
                        $sportsid[] = $brow['actionid'];
                     }
                     else
                        if ($brow['type'] == 208)
                        {
                           $book[] = $brow['name'];
                           $bookid[] = $brow['actionid'];
                        }
                        else
                           if ($brow['type'] == 201)
                           {
                              $city[] = $brow['name'];
                              $cityid[] = $brow['actionid'];
                           }
                           else
                              if ($brow['type'] == 207)
                              {
                                 $movie[] = $brow['name'];
                                 $movieid[] = $brow['actionid'];
                              }
                              else
                                 if ($brow['type'] == 211)
                                 {
                                    $hobby[] = $brow['name'];
                                    $hobbyid[] = $brow['actionid'];
                                 }
                                 else
                                    if ($brow['type'] == 215)
                                    {
                                       $mobile[] = $brow['name'];
                                       $mobileid[] = $brow['actionid'];
                                    }
                                    else
                                       if ($brow['type'] == 230)
                                       {
                                          $skill[] = $brow['name'];
                                          $skillid[] = $brow['actionid'];
                                       }
                                       else
                                          if ($brow['type'] == 231)
                                          {
                                             $project[] = $brow['name'];
                                             $projectid[] = $brow['actionid'];
                                          }
                                          else
                                             if ($brow['type'] == 232)
                                             {
                                                $certificate[] = $brow['name'];
                                                $certificateid[] = $brow['actionid'];
                                             }
                                             else
                                                if ($brow['type'] == 233)
                                                {
                                                   $award[] = $brow['name'];
                                                   $awardid[] = $brow['actionid'];
                                                }
                                                else
                                                   if ($brow['type'] == 234)
                                                   {
                                                      $team[] = $brow['name'];
                                                      $teamid[] = $brow['actionid'];
                                                   }
                                                   else
                                                      if ($brow['type'] == 235)
                                                      {
                                                         $major[] = $brow['name'];
                                                         $majorid[] = $brow['actionid'];
                                                      }
                                                      else
                                                         if ($brow['type'] == 236)
                                                         {
                                                            $tool[] = $brow['name'];
                                                            $toolid[] = $brow['actionid'];
                                                         }
                                                         else
                                                            if ($brow['type'] == 237)
                                                            {
                                                               $extension[] = $brow['name'];
                                                               $extensionid[] = $brow['actionid'];
                                                            }
}
$row = $database->privacy_select($myprofileid);

$name = $newrow['NAME'];
$tagline = $newrow['TAGLINE'];
$sex = $newrow['SEX'];
$email = $newrow['EMAIL'];
$bday = $newrow['BIRTHDAY'];
$nickname = $newrow['NICKNAME'];
$relation = $newrow['RELATION'];

?>
<div class="row">
<div style="padding:1em 1em 1em 2em; background-image:linear-gradient(to bottom, #FFFFFF 0%, #ccc 100%), linear-gradient(to bottom, #Fff 0%, #Fff 100%);
    background-clip: content-box, padding-box;" class="col-md-12">	
    <input type="hidden" value="<?php echo $profileid; ?>" />
    <input type="hidden" value="50" />
    <img id="<?php echo $profile_imageid; ?>" data="<?php echo $profile_image; ?>" class="img-thumbnail lfloat" src="thumbnail.php?file=<?php echo $profile_image; ?>&height=150&width=150" onclick="action.image_viewer(this)" />
	<span class="bold left1"><a  href="profile.php?id=<?php echo $profileid; ?>" style="font-size:1.5em;"><?php echo $profile_name; ?></a></span>
    <div style="margin-top:6em;margin-left:14em;">
     <div><span class="glyphicon glyphicon-envelope "></span>:<a href=mailto:<?php echo $email; ?> ><?php echo $email; ?></a></div>
    <?php

    if (isset($tagline))
    {
    ?>
    	<div><span class="glyphicon glyphicon-tags"></span>:<?php echo '"' . stripslashes($tagline) . '"';?></div>
    <?php
    }
    ?>
     <?php if($myprofileid == $profileid) 
	{ 
	?>
		<div><span class="glyphicon glyphicon-camera"></span>:<a href="register.php?hl=profile_picture" >Change Profile Picture</a></div>
	<?php
	}
	?>
    </div>
</div>
<div class="bio_indiv_container">
		<div class="bio_each col-md-6 panel panel-default">
			<div class="bio_each_title" >Profession</div>
			<?php

bio_item_deploy($profile_relation, 234, 'Team', $team, $teamid, 'team_edit_link', $help, $row['team']);
bio_single_deploy($profile_relation, 239, 'Designation', $designation, $designationid,'designation_edit_link', $help, $row['designation']);
bio_item_deploy($profile_relation, 235, 'Major', $major, $majorid,'major_edit_link', $help, $row['major']);
bio_item_deploy($profile_relation, 230, 'Skill', $skill, $skillid,'skill_edit_link', $help, $row['skill']);
bio_item_deploy($profile_relation, 236, 'Tools worked on', $tool, $toolid,'tool_edit_link', $help, $row['Tools worked on']);
bio_item_deploy($profile_relation, 231, 'Project', $project, $projectid,'project_edit_link', $help, $row['project']);
bio_item_deploy($profile_relation, 232, 'Certificate', $certificate, $certificateid,'certificate_edit_link', $help, $row['certificate']);
bio_item_deploy($profile_relation, 233, 'Award', $award, $awardid,'award_edit_link', $help, $row['award']);

?>
		</div>
		<div class="bio_each col-md-6 panel panel-default">
			<div class="bio_each_title ">Background</div>
			<?php

bio_item_deploy($profile_relation, 205, 'Company', $company, $companyid,'company_edit_link', $help, $row['company']);
bio_item_deploy($profile_relation, 204, 'College', $college, $collegeid,'college_edit_link', $help, $row['college']);
bio_item_deploy($profile_relation, 203, 'School', $school, $schoolid,'school_edit_link', $help, $row['school']);
bio_item_deploy($profile_relation, 201, 'City', $city, $cityid, 'city_edit_link',$help, $row['city']);

?>
		</div>
		<div class="bio_each col-md-6 panel panel-default">
			<div class="bio_each_title ">Contact</div>
			<?php

if (isset($email))
{
   if ($help->checkPrivacy('EMAIL', $profileid) == 1)
      echo "<div class='panel panel-default'><div class='panel-heading'>Email</div> " . '<div class="panel-body">' . $email .
         '</div></div>';
}
bio_item_deploy($profile_relation, 237, 'Office Extension', $extension, $extensionid,
   'extension_edit_link', $help, $row['office extension']);
bio_item_deploy($profile_relation, 215, 'Mobile', $mobile, $mobileid,
   'mobile_edit_link', $help, $row['mobile']);

?>
		</div>
</div>
</div>

	<?php

function bio_single_deploy($profile_relation, $code, $key, $value, $valueid, $id,
   $help, $privacy)
{
   if ($profile_relation == 0)
   {
      if (isset($value))
      {
         echo "<div class='panel panel-default'><div class='panel-heading'>$key<span class='item_edit_link' id='$id' onclick='item_single_edit($id,$code,\"$value\", $privacy)'>Edit</span></div>";
         echo "<div class='panel-body'>";
         $k = 0;
         echo "<div class='item_each'>" . $value .
            "<span class='item_edit_remove' onclick='action.bio_item_remove(this, $valueid[$k])'>Remove<span></div>";
         $k++;
         echo "</div></div>";
      }
   }
   else
   {
      if (!empty($value))
      {
         if ($help->checkPrivacy($key, $profileid) == 1)
         {
            echo "<div class='panel panel-default'><div class='panel-heading'>$key</div>";
            echo "<div class=''panel-body'>";
            echo "<div class='item_each'>" . $value . "</div>";
            echo "</div></div>";
         }
      }
   }
}


function bio_item_deploy($profile_relation, $code, $key, $value, $valueid, $id,
   $help, $privacy)
{
   if ($profile_relation == 0)
   {
      if (isset($value))
      {
         echo "<div class='panel panel-default'><div class='panel-heading'>$key<span class='item_edit_link' id='$id' onclick='item_edit($id,$code,\"$key\", $privacy)'>Edit</span></div>";
         echo "<div class='panel-body'>";
         $k = 0;
         foreach ($value as $s)
         {
            echo "<div class='item_each'>" . $s .
               "<span class='item_edit_remove' onclick='action.bio_item_remove(this, $valueid[$k])'>Remove<span></div>";
            $k++;
         }
         echo "</div></div>";
      }
   }
   else
   {
      if (!empty($value))
      {
         if ($help->checkPrivacy($key, $profileid) == 1)
         {
            echo "<div class='panel panel-default'><div class='panel-heading'>$key</div>";
            echo "<div class='panel-body'>";
            foreach ($value as $s)
            {
               echo "<div class='item_each'>" . $s . "</div>";
            }
            echo "</div></div>";
         }
      }
   }
}

?>
</div>