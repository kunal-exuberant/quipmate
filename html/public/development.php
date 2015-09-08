<?php 
    $style_cdn='https://7f0cf736abbdd4f83d8b-475de27d87a6fd312d1dd9701d87a2a9.ssl.cf2.rackcdn.com/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="<?php echo $style_cdn.'bootstrap.min.css'; ?>" charset="utf-8"/>
<style>
#header{width:100%;height:4em;background-color:#003153;color:#ffffff;z-index:10;padding:0 !important;}
#header-wrapper{text-align:center;margin:0em auto;}
#website_logo{border:none;text-decoration:none;cursor:pointer;color:#cccccc;font-family:arial;font-size:2.2em;text-shadow: 0.1em 0.15em #000000;}
.center{padding: 2em; border-left: 1px solid gray; border-right: 1px solid gray;word-break: break-all;}
</style>
</head>
<body>
    <div class="container">  
    <div class="row">
    <div class="col-md-12 " id="header">
		<div id="header-wrapper">
				<a id="website_logo" href="/" title="Your Online Identity">Quipmate - API</a>
		</div>
    </div>
    <div class="col-md-12 center">   

<p>
    Baseurl =50.57.224.99/ajax/write.php
</p>
<p>
    <strong>1.<u>TO ACCEPT REQUEST FROM A MEMBER </u></strong>
</p>
<p>
    <strong><u> </u></strong>
</p>
<p>
    url=baseurl? action=member_request_accept&amp;groupid=groupid&amp;profileid=profileid&amp;flag=flag
</p>
<p>
    e.g- 
    <a href="http://50.57.224.99/ajax/write.php?action=member_request_accept&amp;groupid=20492&amp;profileid=1000002567&amp;flag=1">
        http://50.57.224.99/ajax/write.php?action=member_request_accept&amp;groupid=20492&amp;profileid=1000002567&amp;flag=1
    </a>
</p>
<p>
    <strong><u> </u></strong>
</p>
<p>
    request method - GET
</p>
<p>
    <strong> </strong>
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "response": 0,
</p>
<p>
    "message": "Member request rejected"
</p>
<p>
    }
</p>
<p>
    <strong><u>2.TO ACCEPT A FRIEND REQUEST</u></strong>
</p>
<p>
    url=baseurl?action=friend_request_accept&amp;profileid=profileid&amp;flag=flag
</p>
<p>
    e.g- 50.57.224.99/ajax/write.php?action=_request_accept&amp;profileid=1000002567 &amp;flag=1
</p>
<p>
    flag=1 (to accept)
</p>
<p>
    flag=0 (to reject)
</p>
<p>
    profileid= friend’s profileid
</p>
<p>
    request method - GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "response": 1,
</p>
<p>
    "message": "Friend request accpted"
</p>
<p>
    }
</p>
<p>
    Or
</p>
<p>
    {"error":{"code":16,"message":"User does not exist. Invalid request.","type":"NoSuchUserException"}}
</p>
<p>
    <strong><u>3.TO WISH A FRIEND ON HIS BIRTHDAY</u></strong>
</p>
<p>
    url=baseurl? action=birthday_bomb&amp;profileid=profileid&amp;wish=wish&amp;date=date
</p>
<p>
    e.g- 50.57.224.99/ajax/write.php?action=birthday_bomb&amp;profileid=1000000351&amp;wish=happy+bday&amp;date=1991-06-23
</p>
<p>
    request method - GET
</p>
<p>
    response-
</p>
<p>
    1
</p>
<p>
    <strong><u>4.TO SELECT COLLEGE</u></strong>
</p>
<p>
    url=baseurl? action=college_select&amp;alphabet=alphabet
</p>
<p>
    e.g- 
    <a href="http://50.57.224.99/ajax/write.php?action=college_select&amp;alphabet=a">
        http://50.57.224.99/ajax/write.php?action=college_select&amp;alphabet=a
    </a>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "1830": "AGRA COLLEGE ,AGRA",
</p>
<p>
    "2148": "Anand Engineering College Agra",
</p>
<p>
    "2257": "Amity University Lucknow"
</p>
<p>
    }
</p>
<p>
    <strong><u>5.TO COMMENT ON A POST</u></strong>
</p>
<p>
    url=baseurl? action=comment&amp;pageid=pageid&amp;comment=comment&amp;tag_name=tag_name&amp;tag_index=tag_index
</p>
<p>
    e.g- 
    <a
        href="http://50.57.224.99/ajax/write.php?action=comment&amp;profileid=1000002567&amp;count=6&amp;actiontype=1201&amp;flag=1&amp;pageid=217765&amp;comment=goooooooooood"
    >
        http://50.57.224.99/ajax/write.php?action=comment&amp;profileid=1000002567&amp;count=6&amp;actiontype=1201&amp;flag=1&amp;pageid=217765&amp;comment=goooooooooood
    </a>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": true,
</p>
<p>
    "actionid": "217767",
</p>
<p>
    "name": [],
</p>
<p>
    "life_is_fun": "bf7246ce41f41f804d6824cc6565f06f021a03a3",
</p>
<p>
    "comment": "goooooooooood",
</p>
<p>
    "length": 13
</p>
<p>
    }
</p>
<p>
    <strong><u>6.TO SHOW ALL COMMENTS</u></strong>
</p>
<p>
    url=baseurl?action=show_all_comments&amp;pageid=pageid&amp;page=page
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=show_all_comments&amp;profileid=1000002567&amp;count=6&amp;actiontype=1201&amp;flag=1&amp;pageid=217765&amp;comment=woooooow&amp;del_actionid=217766&amp;page=news_json
</p>
<p>
    request method – GET
</p>
<p>
    Response-
</p>
<p>
    {
</p>
<p>
    "life_is_fun": "bf7246ce41f41f804d6824cc6565f06f021a03a3",
</p>
<p>
    "com": [
</p>
<p>
    {
</p>
<p>
    "com_actionid": "217775",
</p>
<p>
    "postby": "198333",
</p>
<p>
    "com_time": 1403514508,
</p>
<p>
    "commentby": "1000000122",
</p>
<p>
    "remove": 1,
</p>
<p>
    "com_pageid": "217765",
</p>
<p>
    "comment": "u r awwwwwwuuuuuuuuuuummmmmmm",
</p>
<p>
    "com_excited_mine": 0,
</p>
<p>
    "com_excited": 0
</p>
<p>
    },
</p>
<p>
    {
</p>
<p>
    "com_actionid": "217774",
</p>
<p>
    "postby": "198333",
</p>
<p>
    "com_time": 1403514368,
</p>
<p>
    "commentby": "1000000122",
</p>
<p>
    "remove": 1,
</p>
<p>
    "com_pageid": "217765",
</p>
<p>
    "comment": "keep up the godoooooddddddd workkkkk",
</p>
<p>
    "com_excited_mine": 0,
</p>
<p>
    "com_excited": 0
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "name": {
</p>
<p>
    "1000000122": "Kunal Singh",
</p>
<p>
    "": null
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "1000000122": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png
    </a>
    "
</p>
<p>
    }
</p>
<p>
    }
</p>
<p>
    <strong><u>7.TO INVITE AN EMPLOYEE</u></strong>
</p>
<p>
    url=baseurl? action=employee_invite&amp;email=email&amp;myphoto=myphoto
</p>
<p>
    e.g- 50.57.224.99/ajax/write.php?action=employee_invite&amp;profileid=1000002567&amp;count=6&amp;actiontype=8&amp;flag=1&amp;pageid=217765&amp;comment=woooooow&amp;del_actionid=217779&amp;page=news_json&amp;email=coolvisshu%40yahoo.com
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "invalid": [],
</p>
<p>
    "invited": [
</p>
<p>
    "coolvisshu@yahoo.com"
</p>
<p>
    ],
</p>
<p>
    "existing": [],
</p>
<p>
    "ack": 1
</p>
<p>
    }
</p>
<p>
    <strong><u>8.TO SET STAR OF THE WEEK</u></strong>
</p>
<p>
    url=baseurl? action=star_of_the_week&amp;profilid=profileid&amp;contribution=contribution
</p>
<p>
    e.g- 50.57.224.99/ajax/write.php?action=star_of_the_week&amp;profileid=1000000366&amp;count=6&amp;actiontype=8&amp;flag=1&amp;pageid=217765&amp;comment=woooooow&amp;del_actionid=217779&amp;page=news_json&amp;email=coolvisshu%40yahoo.com&amp;contribution=good+work+in+android
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {"ack":1}
</p>
<p>
    <strong><u>9.TO CREATE A GROUP</u></strong>
</p>
<p>
    url=baseurl?action=group_create&amp;name=name&amp;description=description&amp;privacy=privacy&amp;technical=technical
</p>
<p>
    e.g- 50.57.224.99/ajax/write.php?action=group_create&amp;name=check2&amp;description=blahblah&amp;privacy=privacy&amp;technical=technical
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "groupid": "217785"
</p>
<p>
    }
</p>
<p>
    <strong><u>10.TO CREATE A PAGE</u></strong>
</p>
<p>
    url=baseurl? action=page_create&amp;name=name&amp;description=description
</p>
<p>
    e.g- 50.57.224.99/ajax/write.php?action=page_create&amp;name=snstrrocks&amp;description=devil%20unleashed
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "pageid": "217786"
</p>
<p>
    }
</p>
<p>
    <strong><u>11.TO CREATE AN EVENT</u></strong>
</p>
<p>
    url=baseurl?
    action=event_create&amp;name=name&amp;description=description&amp;privacy=privacy&amp;invite=invite&amp;day=day&amp;month=month&amp;year=year&amp;time=time&amp;venue=venue
</p>
<p>
    e.g- 
    50.57.224.99/ajax/write.php?action=event_create&amp;name=masti%202&amp;description=same%20as%20mstiii&amp;privacy=privacy&amp;invite=invite&amp;day=24&amp;month=JUN&amp;year=2014&amp;time=10:30%20a.m&amp;venue=rohit%20sir%27s%20flat
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "eventid": "217794"
</p>
<p>
    }
</p>
<p>
    <strong><u>12.TO CREATE EVENT IN A GROUP</u></strong>
</p>
<p>
    url=baseurl?
    action=group_event_create&amp;groupid&amp;name=name&amp;description=description&amp;day=day&amp;month=month&amp;year=year&amp;time=time&amp;venue=venue
</p>
<p>
    e.g- 
    <a
        href="http://50.57.224.99/ajax/write.php?action=group_event_create&amp;groupid=204928&amp;name=masti&amp;description=paarttttttttttyyyyyyyy&amp;day=24&amp;month=JUN&amp;year=2014&amp;time=10:30%20a.m&amp;venue=rohit%20sir%27s%20flat"
    >
        http://50.57.224.99/ajax/write.php?action=group_event_create&amp;groupid=204928&amp;name=masti&amp;description=paarttttttttttyyyyyyyy&amp;day=24&amp;month=JUN&amp;year=2014&amp;time=10:30%20a.m&amp;venue=rohit%20sir%27s%20flat
    </a>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "eventid": "217796"
</p>
<p>
    }
</p>
<p>
    <strong><u>13.TO SAVE SETTINGS OF AN EVENT</u></strong>
</p>
<p>
    url=baseurl?
    action=event_settings_save&amp;eventid=eventid&amp;description=description&amp;privacy=privacy&amp;invite=invite&amp;day=day&amp;month=month&amp;year=year&amp;venue=venue
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=event_settings_save&amp;count=6&amp;groupid=204928&amp;profileid=204928&amp;eventid=217796&amp;day=04&amp;month=06&amp;year=2014&amp;time=10%3A30%3A00&amp;venue=rohit+sir%27s+flat&amp;description=paarttttttttttyyyyyyyy&amp;privacy=0&amp;invite=1
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "eventid": true
</p>
<p>
    }
</p>
<p>
    <strong><u>14.TO SAVE GROUP SETTINGS</u></strong>
</p>
<p>
    url=baseurl?
    action=event_settings_save&amp;eventid=eventid&amp;description=description&amp;privacy=privacy&amp;invite=invite&amp;day=day&amp;month=month&amp;year=year&amp;venue=venue
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=group_settings_save&amp;count=6&amp;groupid=217783&amp;profileid=217783&amp;eventid=217796&amp;day=04&amp;month=06&amp;year=2014&amp;time=10%3A30%3A00&amp;venue=rohit+sir%27s+flat&amp;description=devils+are+everywhere&amp;privacy=0&amp;invite=1&amp;actiontype=1201&amp;link=
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "groupid": "217783"
</p>
<p>
    }
</p>
<p>
    <strong><u>15.TO MAKE GROUP ADMIN</u></strong>
</p>
<p>
    url=baseurl? action=group_admin_make&amp;groupid=groupid&amp;profileid=profileid
</p>
<p>
    e.g- 
    <a href="http://50.57.224.99/ajax/write.php?action=group_admin_make&amp;count=6&amp;actiontype=8&amp;profileid=1000001370&amp;groupid=204928">
        http://50.57.224.99/ajax/write.php?action=group_admin_make&amp;count=6&amp;actiontype=8&amp;profileid=1000001370&amp;groupid=204928
    </a>
</p>
<p>
    or
</p>
<p>
    <a href="http://50.57.224.99/ajax/write.php?action=group_admin_make&amp;profileid=1000000009&amp;groupid=204928">
        http://50.57.224.99/ajax/write.php?action=group_admin_make&amp;profileid=1000000009&amp;groupid=204928
    </a>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "message": "Admin"
</p>
<p>
    }
</p>
<p>
    <strong><u>16.TO REMOVE GROUP ADMIN</u></strong>
</p>
<p>
    url=baseurl? action=group_admin_remove&amp;groupid=groupid&amp;profileid=profileid
</p>
<p>
    e.g- 
    <a href="http://50.57.224.99/ajax/write.php?action=group_admin_remove&amp;profileid=1000000009&amp;groupid=204928">
        http://50.57.224.99/ajax/write.php?action=group_admin_remove&amp;profileid=1000000009&amp;groupid=204928
    </a>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "message": "Admin Removed"
</p>
<p>
    }
</p>
<p>
    <strong><u>17.TO REMOVE GROUP MEMBER</u></strong>
</p>
<p>
    url=baseurl? action=group_member_remove&amp;groupid=groupid&amp;profileid=profileid
</p>
<p>
    e.g- 
    <a href="http://50.57.224.99/ajax/write.php?action=group_admin_remove&amp;profileid=1000000073&amp;groupid=204928">
        http://50.57.224.99/ajax/write.php?action=group_admin_remove&amp;profileid=1000000073&amp;groupid=204928
    </a>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "message": "Removed"
</p>
<p>
    }
</p>
<p>
    <strong><u>17.TO SEND MESSAGE TO A FRIEND</u></strong>
</p>
<p>
    url=baseurl? action=message&amp;message=message&amp;profileid=profileid
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=message&amp;message=hiiiii&amp;profileid=1000002567
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": true,
</p>
<p>
    "actionid": "217818",
</p>
<p>
    "message": "hiiiii"
</p>
<p>
    }
</p>
<p>
    <strong><u>18.TO SET MOOD</u></strong>
</p>
<p>
    url=baseurl? action=mood&amp;mood=mood&amp;mood_desc=mood_desc
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=mood&amp;mood=12&amp;mood_desc=lucky
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": true
</p>
<p>
    }
</p>
<p>
    <strong><u>19.TO MISS SOMEBODY</u></strong>
</p>
<p>
    url=baseurl? action=missu&amp;profileid=profileid
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=missu&amp;profileid=1000002567
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "result": true,
</p>
<p>
    "actionid": "217820",
</p>
<p>
    "message": "Missed"
</p>
<p>
    }
</p>
<p>
    <strong><u>20.TO GET GROUP TOP INFLUENCER</u></strong>
</p>
<p>
    url=baseurl? action=group_top_influencer_fetch&amp;profileid=profileid
</p>
<p>
    e.g- 
    <a href="http://50.57.224.99/ajax/write.php?action=group_top_influencer_fetch&amp;profileid=204928">
        http://50.57.224.99/ajax/write.php?action=group_top_influencer_fetch&amp;profileid=204928
    </a>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "match": [
</p>
<p>
    {
</p>
<p>
    "profileid": "1000000122"
</p>
<p>
    },
</p>
<p>
    {
</p>
<p>
    "profileid": "1000002084"
</p>
<p>
    },
</p>
<p>
    {
</p>
<p>
    "profileid": "1000000002"
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "count": 3,
</p>
<p>
    "name": {
</p>
<p>
    "1000000002": "Brijesh Kushwaha",
</p>
<p>
    "1000000122": "Kunal Singh",
</p>
<p>
    "1000002084": "Yogendra"
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "1000000002": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000002_1402161888.jpg">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000002_1402161888.jpg
    </a>
    ",
</p>
<p>
    "1000000122": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png
    </a>
    ",
</p>
<p>
    "1000002084": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000002084_1388493166.JPG">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000002084_1388493166.JPG
    </a>
    "
</p>
<p>
    }
</p>
<p>
    }
</p>
<p>
    <strong><u>21.TO GET MUTUAL FRIENDS</u></strong>
</p>
<p>
    url=baseurl? action=mutual_friend&amp;profileid=profileid
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=mutual_friend&amp;profileid=1000002567
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "count": "2",
</p>
<p>
    "ncount": 2,
</p>
<p>
    "match": [
</p>
<p>
    {
</p>
<p>
    "profileid": "1000000002"
</p>
<p>
    },
</p>
<p>
    {
</p>
<p>
    "profileid": "1000000005"
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "non_match": [
</p>
<p>
    {
</p>
<p>
    "profileid": "1000000714"
</p>
<p>
    },
</p>
<p>
    {
</p>
<p>
    "profileid": "1000002703"
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "name": {
</p>
<p>
    "1000000002": "Brijesh Kushwaha",
</p>
<p>
    "1000000005": "Shobhit",
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "1000000002": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000002_1402161888.jpg">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000002_1402161888.jpg
    </a>
    ",
</p>
<p>
    "1000000005": "
    <a
        href="https://17ba44c6e294ab81f639-55f93745d66bc3cab58e675e4895e5a0.ssl.cf2.rackcdn.com/cdti7pb0cjmsivii5nfu39psa21382881677678382647872131328538076722443238_t.jpg"
    >
        https://17ba44c6e294ab81f639-55f93745d66bc3cab58e675e4895e5a0.ssl.cf2.rackcdn.com/cdti7pb0cjmsivii5nfu39psa21382881677678382647872131328538076722443238_t.jpg
    </a>
    ",
</p>
<p>
    }
</p>
<p>
    }
</p>
<p>
    <strong><u>21.TO MAKE MODERATOR</u></strong>
</p>
<p>
    url=baseurl? action=make_moderator&amp;profileid=profileid
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=make_moderator&amp;profileid=1000002567
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1
</p>
<p>
    }
</p>
<p>
    <strong><u>22.TO REMOVE MODERATOR</u></strong>
</p>
<p>
    url=baseurl? action=moderator_remove&amp;profileid=profileid
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=moderator_remove&amp;profileid=1000002567
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1
</p>
<p>
    }
</p>
<p>
    <strong><u>23.TO FETCH USER DETAILS</u></strong>
</p>
<p>
    url=baseurl? action=user_details_fetch&amp;email=email
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=user_details_fetch&amp;email=rajatasthana91@gmail.com
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "profileid": "1000002567",
</p>
<p>
    "name": "Rajat Asthana",
</p>
<p>
    "pimage": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000002567_1401361030.jpg">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000002567_1401361030.jpg
    </a>
    "
</p>
<p>
    }
</p>
<p>
    <strong><u>23.TO GET ADMIN FEED</u></strong>
</p>
<p>
    url=baseurl? action=admin_feed&amp;start=start
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=admin_feed&amp;start=102
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "action": [
</p>
<p>
    {
</p>
<p>
    "actionid": "217073",
</p>
<p>
    "pageid": "217073",
</p>
<p>
    "life_is_fun": "8aefd2274e6bc0c30ea21697a27f200a91ad982e",
</p>
<p>
    "postby": "1000000122",
</p>
<p>
    "time": 1401889014,
</p>
<p>
    "actiontype": "600",
</p>
<p>
    "visible": "0",
</p>
<p>
    "actionby": "1000000122",
</p>
<p>
    "actionon": "1000000122",
</p>
<p>
    "blog_title": "New B;log ",
</p>
<p>
    "blog_content": "New blog !!!",
</p>
<p>
    "file": "
    <a href="https://becda623bf8870bb68df-da0c8a7673dba397789e9545fd410b00.ssl.cf2.rackcdn.com/1000000122_1401889010.png">
        https://becda623bf8870bb68df-da0c8a7673dba397789e9545fd410b00.ssl.cf2.rackcdn.com/1000000122_1401889010.png
    </a>
    ",
</p>
<p>
    "excited": [
</p>
<p>
    "1000000122"
</p>
<p>
    ],
</p>
<p>
    "comment_count": "1",
</p>
<p>
    "com": [
</p>
<p>
    {
</p>
<p>
    "com_time": 1401889045,
</p>
<p>
    "commentby": "1000000122",
</p>
<p>
    "remove": 1,
</p>
<p>
    "com_pageid": "217073",
</p>
<p>
    "com_actionid": "217075",
</p>
<p>
    "comment": "works",
</p>
<p>
    "com_excited_mine": 0,
</p>
<p>
    "com_excited": 0
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "admin_feed": 1
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "myprofileid": "1000000122",
</p>
<p>
    "name": {
</p>
<p>
    "217057": null,
</p>
<p>
    "1000000122": "Kunal Singh",
</p>
<p>
    "": null
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "217057": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/female.png">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/female.png
    </a>
    ",
</p>
<p>
    "1000000122": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png
    </a>
    "
</p>
<p>
    },
</p>
<p>
    "tag": []
</p>
<p>
    }
</p>
<p>
    <strong><u>24.TO GET TECHNICAL FEED</u></strong>
</p>
<p>
    url=baseurl? action=technical_feed_fetch&amp;start=start
</p>
<p>
    e.g- 
    <a href="http://50.57.224.99/ajax/write.php?action=technical_feed_fetch&amp;start=0">
        http://50.57.224.99/ajax/write.php?action=technical_feed_fetch&amp;start=0
    </a>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "action": [
</p>
<p>
    {
</p>
<p>
    "actionid": "203001",
</p>
<p>
    "pageid": "203001",
</p>
<p>
    "life_is_fun": "93ef1e661c142d9f688c76beacaa64e557215690",
</p>
<p>
    "postby": "1000000122",
</p>
<p>
    "time": 1386330411,
</p>
<p>
    "actiontype": "300",
</p>
<p>
    "visible": "0",
</p>
<p>
    "actionby": "1000000122",
</p>
<p>
    "actionon": "203001",
</p>
<p>
    "groupid": "203001",
</p>
<p>
    "group_name": "Bally",
</p>
<p>
    "group_description": "ahsdk",
</p>
<p>
    "excited": [],
</p>
<p>
    "comment_count": "0",
</p>
<p>
    "com": []
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "myprofileid": "1000000122",
</p>
<p>
    "name": {
</p>
<p>
    "203001": null,
</p>
<p>
    "217783": null,
</p>
<p>
    "1000000122": "Kunal Singh",
</p>
<p>
    "": null
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "203001": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/female.png">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/female.png
    </a>
    ",
</p>
<p>
    "217783": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/female.png">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/female.png
    </a>
    ",
</p>
<p>
    "1000000122": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png
    </a>
    "
</p>
<p>
    },
</p>
<p>
    "tag": []
</p>
<p>
    }
</p>
<p>
    <strong><u>25.TO GET NEWS FEED</u></strong>
</p>
<p>
    url=baseurl? action=news_feed&amp;start=start
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=news_feed&amp;start=0
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    Similar to admin feed except for no "admin_feed": 1
</p>
<p>
    }
</p>
<p>
    <strong><u>26.TO FETCH NOTICE</u></strong>
</p>
<p>
    url=baseurl? action=notice_fetch&amp;start=start
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=notice_fetch&amp;start=0
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "action": [
</p>
<p>
    {
</p>
<p>
    "actionid": "217335",
</p>
<p>
    "pageid": "217335",
</p>
<p>
    "life_is_fun": "cb868e0efabe859b4f2b926a97e7ccb540049a5c",
</p>
<p>
    "postby": "1000000122",
</p>
<p>
    "time": 1403438064,
</p>
<p>
    "actiontype": "15",
</p>
<p>
    "visible": "0",
</p>
<p>
    "actionby": "1000000002,1000001548",
</p>
<p>
    "actionon": "1000000122",
</p>
<p>
    "parenttype": "6",
</p>
<p>
    "page": "",
</p>
<p>
    "file": "
    <a href="https://becda623bf8870bb68df-da0c8a7673dba397789e9545fd410b00.ssl.cf2.rackcdn.com/1000000122_1402841121.jpg">
        https://becda623bf8870bb68df-da0c8a7673dba397789e9545fd410b00.ssl.cf2.rackcdn.com/1000000122_1402841121.jpg
    </a>
    ",
</p>
<p>
    "excited": [
</p>
<p>
    "1000001548",
</p>
<p>
    "1000000002",
</p>
<p>
    "1000000122"
</p>
<p>
    ],
</p>
<p>
    "comment_count": "0",
</p>
<p>
    "com": []
</p>
<p>
    },
</p>
<p>
    ],
</p>
<p>
    "name": {
</p>
<p>
    "1000000002": "Brijesh Kushwaha",
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "1000000002": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000002_1402161888.jpg">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000002_1402161888.jpg
    </a>
    ",
</p>
<p>
    }
</p>
<p>
    }
</p>
<p>
    <strong><u>27.TO PRAISE A FRIEND</u></strong>
</p>
<p>
    url=baseurl? action=praise&amp;letter_title=letter_title&amp;letter_content=letter_content&amp;profileid=profileid
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=praise&amp;letter_title=hardwork&amp;letter_content=kamaal%20kar%20ditta%20tussi&amp;profileid=1000002567
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": true,
</p>
<p>
    "actionid": "217824",
</p>
<p>
    "letter_title": "hardwork",
</p>
<p>
    "letter_content": "kamaal kar ditta tussi"
</p>
<p>
    }
</p>
<p>
    <strong><u>28.TO DIRECT A LETTER</u></strong>
</p>
<p>
    url=baseurl? action=direct_letter&amp;letter_title=letter_title&amp;letter_content=letter_content&amp;letter_open=letter_open
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=direct_letter&amp;letter_title=threat&amp;letter_content=20%20lakh%20do%20nahi%20to...&amp;letter_open=1
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": true,
</p>
<p>
    "actionid": "217826",
</p>
<p>
    "letter_title": "threat",
</p>
<p>
    "letter_content": "20 lakh do nahi to..."
</p>
<p>
    }
</p>
<p>
    <strong><u>28.TO POST A QUESTION ON FRIEND’S PROFILE</u></strong>
</p>
<p>
    url=baseurl? action=post_question&amp;question=question&amp;profileid=profileid&amp;option=option
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=post_question&amp;question=is%20rajat%20a%20great%20guy..??&amp;profileid=1000002567&amp;option[]=1&amp;option[]=2
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": true,
</p>
<p>
    "actionid": "217827",
</p>
<p>
    "question": "is rajat a great guy..??",
</p>
<p>
    "life_is_fun": "3b589b18885b3a89e22fdc843718f7ee86db5209",
</p>
<p>
    "time": 1403529208,
</p>
<p>
    "option": [
</p>
<p>
    {
</p>
<p>
    "opt": "1",
</p>
<p>
    "optid": "46"
</p>
<p>
    },
</p>
<p>
    {
</p>
<p>
    "opt": "2",
</p>
<p>
    "optid": "47"
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    }
</p>
<p>
    <strong><u>29.TO ANSWER A QUESTION</u></strong>
</p>
<p>
    url=baseurl? action=answer&amp;pageid=pageid&amp;optionid=optionid
</p>
<p>
    e.g- 
    <a href="http://50.57.224.99/ajax/write.php?action=answer&amp;profileid=1000002567&amp;optionid=48&amp;pageid=217829">
        http://50.57.224.99/ajax/write.php?action=answer&amp;profileid=1000002567&amp;optionid=48&amp;pageid=217829
    </a>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "action": [
</p>
<p>
    {
</p>
<p>
    "actionid": "217829",
</p>
<p>
    "pageid": "217829",
</p>
<p>
    "life_is_fun": "c566d368a24eefc36410112199504f1ba36fb0d8",
</p>
<p>
    "postby": "1000000122",
</p>
<p>
    "time": 1403529554,
</p>
<p>
    "actiontype": "2800",
</p>
<p>
    "visible": "2",
</p>
<p>
    "actionby": "1000000122",
</p>
<p>
    "actionon": "1000002567",
</p>
<p>
    "question": "is rajat a great guy..??",
</p>
<p>
    "option": [
</p>
<p>
    {
</p>
<p>
    "opt": "1",
</p>
<p>
    "optid": "48",
</p>
<p>
    "mine": "0",
</p>
<p>
    "count": "0",
</p>
<p>
    "percent": 0
</p>
<p>
    },
</p>
<p>
    {
</p>
<p>
    "opt": "2",
</p>
<p>
    "optid": "49",
</p>
<p>
    "mine": "0",
</p>
<p>
    "count": "0",
</p>
<p>
    "percent": 0
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "excited": [],
</p>
<p>
    "comment_count": "0",
</p>
<p>
    "com": []
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "myprofileid": "1000000122",
</p>
<p>
    "name": {
</p>
<p>
    "1000000122": "Kunal Singh",
</p>
<p>
    "1000002567": "Rajat Asthana"
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "1000000122": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png
    </a>
    ",
</p>
<p>
    "1000002567": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000002567_1401361030.jpg">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000002567_1401361030.jpg
    </a>
    "
</p>
<p>
    },
</p>
<p>
    "tag": []
</p>
<p>
    }
</p>
<p>
    <strong><u>30.TO POST ON FRIEND’S PROFILE</u></strong>
</p>
<p>
    url=baseurl? action=post_status&amp;page=page&amp;profileid=profileid
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=post_status&amp;page=u%20r%20awssssssuuuuuuuuuuummmm..:)&amp;profileid=1000002567
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": true,
</p>
<p>
    "actionid": "217833",
</p>
<p>
    "life_is_fun": "20895622d25e2897595465fb7c1036db9ecff773",
</p>
<p>
    "time": 1403530381,
</p>
<p>
    "page": "u r awssssssuuuuuuuuuuummmm..:)"
</p>
<p>
    }
</p>
<p>
    <strong><u>31.TO POST STATUS IN A GROUP</u></strong>
</p>
<p>
    url=baseurl? action=group_status&amp;page=page&amp;profileid=profileid
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=group_status&amp;page=this%20is%20mmmec&amp;profileid=204928
</p>
<p>
    <em>here profileid=groupid</em>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "actionid": "217837",
</p>
<p>
    "life_is_fun": "a30f8bd2686a593e7ac0a55c8989f903d290834d",
</p>
<p>
    "time": 1403530837,
</p>
<p>
    "page": "this is mmmec"
</p>
<p>
    }
</p>
<p>
    <strong><u>32.TO POST STATUS ON A PAGE</u></strong>
</p>
<p>
    url=baseurl? action=page_status&amp;page=page&amp;profileid=profileid
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=page_status&amp;page=u%20r%20awssssssssuuuuuummmm..:)%20again&amp;profileid=217834
</p>
<p>
    <em>here profileid=pageid</em>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "actionid": "217836",
</p>
<p>
    "actiontype": 2901,
</p>
<p>
    "page_name": "snstr-rocks",
</p>
<p>
    "page_pageid": "217834",
</p>
<p>
    "life_is_fun": "faddaa0bced642ef6b839774b1e685d3ebcc2222",
</p>
<p>
    "time": 1403530841,
</p>
<p>
    "page": "u r awssssssssuuuuuummmm..:) again"
</p>
<p>
    }
</p>
<p>
    <strong><u>33.TO POST STATUS IN A EVENT</u></strong>
</p>
<p>
    url=baseurl? action=event_status&amp;page=page&amp;profileid=profileid
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=event_status&amp;page=%20grand%20masti%20grand%20mastii%20pe%20pe%20pe%20pe%20pein&amp;profileid=198333
</p>
<p>
    <em>here profileid=eventid</em>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "actionid": "217838",
</p>
<p>
    "life_is_fun": "80e375e97aca34d2fcfa7b959c5af11381a943a6",
</p>
<p>
    "time": 1403531265,
</p>
<p>
    "page": " grand masti grand mastii pe pe pe pe pein"
</p>
<p>
    }
</p>
<p>
    <strong><u>34.TO POST LINK IN A EVENT</u></strong>
</p>
<p>
    url=baseurl? action=event_post_link&amp;profileid=profileid&amp;title=title&amp;link=link&amp;meta=meta&amp;page=page&amp;file=file
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=event_post_link&amp;profileid=198333&amp;title=Google&amp;link=http%3A%2F%2Fwww.google.com&amp;meta=Search+the+world%27s+information%2C+including+webpages%2C+images%2C+videos+and+more.+Google+has+many+special+features+to+help+you+find+exactly+what+you%27re+looking+for.&amp;page=www.google.com&amp;file=http%3A%2F%2Fwww.google.com%2F%2Flogos%2Fdoodles%2F2014%2Fworld-cup-2014-27-5917140490125312-hp.gif
</p>
<p>
    <em>here profileid=eventid</em>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": true,
</p>
<p>
    "actionid": "217843",
</p>
<p>
    "life_is_fun": "68f20974fba9bd4347d9f8cfbe0ddd8bb6dcacbb",
</p>
<p>
    "time": 1403531497,
</p>
<p>
    "page": "<a href="http://www.google.com/">www.google.com</a>"
</p>
<p>
    }
</p>
<p>
    <strong><u>35.TO POST LINK IN A GROUP</u></strong>
</p>
<p>
    url=baseurl? action=group_post_link&amp;profileid=profileid&amp;title=title&amp;link=link&amp;meta=meta&amp;page=page&amp;file=file
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=group_post_link&amp;profileid=204928&amp;title=Google&amp;link=http%3A%2F%2Fwww.google.com&amp;meta=Search+the+world%27s+information%2C+including+webpages%2C+images%2C+videos+and+more.+Google+has+many+special+features+to+help+you+find+exactly+what+you%27re+looking+for.&amp;page=www.google.com%0A&amp;file=http%3A%2F%2Fwww.google.com%2F%2Flogos%2Fdoodles%2F2014%2Fworld-cup-2014-27-5917140490125312-hp.gif
</p>
<p>
    <em>here profileid=groupid</em>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": true,
</p>
<p>
    "actionid": "217845",
</p>
<p>
    "life_is_fun": "29980119b530feaf0937ad73d9fb9c40602fed4a",
</p>
<p>
    "time": 1403531670,
</p>
<p>
    "page": "<a href="http://www.google.com/n">www.google.com\n</a>"
</p>
<p>
    }
</p>
<p>
    <strong><u>36.TO POST LINK IN A PAGE</u></strong>
</p>
<p>
    url=baseurl? action=page_post_link&amp;profileid=profileid&amp;title=title&amp;link=link&amp;meta=meta&amp;page=page&amp;file=file
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=page_post_link&amp;profileid=217834&amp;title=Google&amp;link=http%3A%2F%2Fwww.google.com&amp;meta=Search+the+world%27s+information%2C+including+webpages%2C+images%2C+videos+and+more.+Google+has+many+special+features+to+help+you+find+exactly+what+you%27re+looking+for.&amp;page=www.google.com%0A&amp;file=http%3A%2F%2Fwww.google.com%2F%2Flogos%2Fdoodles%2F2014%2Fworld-cup-2014-27-5917140490125312-hp.gif
</p>
<p>
    <em>here profileid=pageid</em>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": true,
</p>
<p>
    "actionid": "217846",
</p>
<p>
    "actiontype": 2916,
</p>
<p>
    "page_name": "snstr-rocks",
</p>
<p>
    "page_pageid": "217834",
</p>
<p>
    "life_is_fun": "92a57ff9e1c446ef9a67d220eeb6e2e75a0543f2",
</p>
<p>
    "time": 1403531905,
</p>
<p>
    "page": "<a href="http://www.google.com/n">www.google.com\n</a>"
</p>
<p>
    }
</p>
<p>
    <strong><u>36.TO FETCH FRIEND PHOTOS</u></strong>
</p>
<p>
    url=baseurl? action=photo_friend_fetch&amp;start=start
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=photo_friend_fetch&amp;start=0
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "name": {
</p>
<p>
    "1000000002": "Brijesh Kushwaha",
</p>
<p>
    "1000000174": "Gaurav Mishra",
</p>
<p>
    },
</p>
<p>
    "action": [
</p>
<p>
    {
</p>
<p>
    "file": "
    <a href="https://becda623bf8870bb68df-da0c8a7673dba397789e9545fd410b00.ssl.cf2.rackcdn.com/1000000002_1402250341.jpg">
        https://becda623bf8870bb68df-da0c8a7673dba397789e9545fd410b00.ssl.cf2.rackcdn.com/1000000002_1402250341.jpg
    </a>
    ",
</p>
<p>
    "profileid": "217008",
</p>
<p>
    "actionby": "1000000002",
</p>
<p>
    "actionid": "217186",
</p>
<p>
    "life_is_fun": "b9678d52c616772e9a2db39d62679e0f9a93fe5c"
</p>
<p>
    },
</p>
<p>
    {
</p>
<p>
    "file": "
    <a href="https://17ba44c6e294ab81f639-55f93745d66bc3cab58e675e4895e5a0.ssl.cf2.rackcdn.com/1000000174_1398702031.jpg">
        https://17ba44c6e294ab81f639-55f93745d66bc3cab58e675e4895e5a0.ssl.cf2.rackcdn.com/1000000174_1398702031.jpg
    </a>
    ",
</p>
<p>
    "profileid": "1000000174",
</p>
<p>
    "actionby": "1000000174",
</p>
<p>
    "actionid": "216158",
</p>
<p>
    "life_is_fun": "e5cd244f8472398cde5bbd9607269ad21d056d0d"
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    }
</p>
<p>
    <strong><u>37.TO DELETE A MESSAGE</u></strong>
</p>
<p>
    url=baseurl? action=message_delete&amp;del_actionid=del_actionid
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=message_delete&amp;actiontype=8&amp;del_actionid=216955
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "actionid": "216955"
</p>
<p>
    }
</p>
<p>
    <strong><u>38.TO DELETE A POST</u></strong>
</p>
<p>
    url=baseurl? action=post_delete&amp;del_actionid=del_actionid
</p>
<p>
    e,g-http://50.57.224.99/ajax/write.php?action=post_delete&amp;actiontype=8&amp;del_actionid=217839
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "actionid": "217839",
</p>
<p>
    "pageid": "217839"
</p>
<p>
    }
</p>
<p>
    <strong><u>39.TO GET PAGE FEED</u></strong>
</p>
<p>
    url=baseurl? action=page_feed&amp;start=start&amp;pageid=pageid
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=page_feed&amp;start=0&amp;pageid=217834
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "action": [
</p>
<p>
    {
</p>
<p>
    "actionid": "217836",
</p>
<p>
    "pageid": "217836",
</p>
<p>
    "life_is_fun": "faddaa0bced642ef6b839774b1e685d3ebcc2222",
</p>
<p>
    "postby": "1000000122",
</p>
<p>
    "time": 1403530694,
</p>
<p>
    "actiontype": "2901",
</p>
<p>
    "visible": "0",
</p>
<p>
    "actionby": "1000000122",
</p>
<p>
    "actionon": "217834",
</p>
<p>
    "page_pageid": "217834",
</p>
<p>
    "page_name": "snstr-rocks",
</p>
<p>
    "page": "u r awssssssssuuuuuummmm..:) again",
</p>
<p>
    "remove": "1",
</p>
<p>
    "excited": [],
</p>
<p>
    "comment_count": "0",
</p>
<p>
    "com": []
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "myprofileid": "1000000122",
</p>
<p>
    "name": {
</p>
<p>
    "217834": null,
</p>
<p>
    "1000000122": "Kunal Singh"
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "217834": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/female.png">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/female.png
    </a>
    ",
</p>
<p>
    "1000000122": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png
    </a>
    "
</p>
<p>
    },
</p>
<p>
    "tag": []
</p>
<p>
    }
</p>
<p>
    <strong><u>40.TO GET GROUP FEED</u></strong>
</p>
<p>
    url=baseurl? action=group_feed&amp;start=start&amp;groupid=groupid
</p>
<p>
    e,g-http://50.57.224.99/ajax/write.php?action=group_feed&amp;start=0&amp;groupid=217783
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "action": [
</p>
<p>
    {
</p>
<p>
    "actionid": "217783",
</p>
<p>
    "pageid": "217783",
</p>
<p>
    "life_is_fun": "3f54d41740345c964d265efd52e1bd033dc5e213",
</p>
<p>
    "postby": "1000000122",
</p>
<p>
    "time": 1403521031,
</p>
<p>
    "actiontype": "300",
</p>
<p>
    "visible": "0",
</p>
<p>
    "actionby": "1000000122",
</p>
<p>
    "actionon": "217783",
</p>
<p>
    "groupid": "217783",
</p>
<p>
    "group_name": "snstr",
</p>
<p>
    "group_description": "devils are everywhere",
</p>
<p>
    "excited": [],
</p>
<p>
    "comment_count": "0",
</p>
<p>
    "com": []
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "myprofileid": "1000000122",
</p>
<p>
    "name": {
</p>
<p>
    "217783": null,
</p>
<p>
    "1000000122": "Kunal Singh"
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "217783": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/female.png">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/female.png
    </a>
    ",
</p>
<p>
    "1000000122": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png
    </a>
    "
</p>
<p>
    },
</p>
<p>
    "tag": []
</p>
<p>
    }
</p>
<p>
    <strong><u>41.TO GET EVENT FEED</u></strong>
</p>
<p>
    url=baseurl? action=event_feed&amp;start=start&amp;eventid=eventid
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=event_feed&amp;start=0&amp;eventid=217806
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "action": [
</p>
<p>
    {
</p>
<p>
    "actionid": "217806",
</p>
<p>
    "pageid": "217806",
</p>
<p>
    "life_is_fun": "d643e91395d9cd9a2053dc8c39e3e1b258588467",
</p>
<p>
    "postby": "1000000122",
</p>
<p>
    "time": 1403523186,
</p>
<p>
    "actiontype": "400",
</p>
<p>
    "visible": "0",
</p>
<p>
    "actionby": "1000000122",
</p>
<p>
    "actionon": "217806",
</p>
<p>
    "eventid": "217806",
</p>
<p>
    "event_name": "masti",
</p>
<p>
    "event_description": "paarttttttttttyyyyyyyy",
</p>
<p>
    "venue": "rohit sir's flat",
</p>
<p>
    "date": "30 Nov,-0001",
</p>
<p>
    "timing": "10:30:00",
</p>
<p>
    "excited": [],
</p>
<p>
    "comment_count": "0",
</p>
<p>
    "com": []
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "myprofileid": "1000000122",
</p>
<p>
    "name": {
</p>
<p>
    "217806": null,
</p>
<p>
    "1000000122": "Kunal Singh"
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "217806": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/female.png">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/female.png
    </a>
    ",
</p>
<p>
    "1000000122": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png
    </a>
    "
</p>
<p>
    },
</p>
<p>
    "tag": []
</p>
<p>
    }
</p>
<p>
    <strong><u>42.TO GET PROFILE FEED</u></strong>
</p>
<p>
    url=baseurl? action=profile_feed&amp;start=start&amp;profieid=profileid
</p>
<p>
    e.g- 
    <a
        href="http://50.57.224.99/ajax/write.php?start=0&amp;action=profile_feed&amp;profileid=1000001867&amp;page=profile_json&amp;lastScrollTopfeed=0&amp;groupid=204928&amp;eventid=217806"
    >
        http://50.57.224.99/ajax/write.php?start=0&amp;action=profile_feed&amp;profileid=1000001867&amp;page=profile_json&amp;lastScrollTopfeed=0&amp;groupid=204928&amp;eventid=217806
    </a>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "action": [
</p>
<p>
    {
</p>
<p>
    "actionid": "25096",
</p>
<p>
    "pageid": "25096",
</p>
<p>
    "life_is_fun": "ea6031dd5613c8075d0380be9de576eb46c905f6",
</p>
<p>
    "postby": "1000001867",
</p>
<p>
    "time": 1325319719,
</p>
<p>
    "actiontype": "50",
</p>
<p>
    "visible": "0",
</p>
<p>
    "actionby": "1000001867",
</p>
<p>
    "actionon": "1000001867",
</p>
<p>
    "sex": "1",
</p>
<p>
    "file": "
    <a
        href="https://17ba44c6e294ab81f639-55f93745d66bc3cab58e675e4895e5a0.ssl.cf2.rackcdn.com/2ba2133350fe0c8c9ed7970fcb51494e1319309320134773884212496637551227415076.jpg"
    >
        https://17ba44c6e294ab81f639-55f93745d66bc3cab58e675e4895e5a0.ssl.cf2.rackcdn.com/2ba2133350fe0c8c9ed7970fcb51494e1319309320134773884212496637551227415076.jpg
    </a>
    ",
</p>
<p>
    "excited": [],
</p>
<p>
    "comment_count": "0",
</p>
<p>
    "com": []
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "myprofileid": "1000000122",
</p>
<p>
    "name": {
</p>
<p>
    "1000001867": "Rajat Kumar Gupta"
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "1000000122": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png
    </a>
    ",
</p>
<p>
    "1000001867": "
    <a
        href="https://17ba44c6e294ab81f639-55f93745d66bc3cab58e675e4895e5a0.ssl.cf2.rackcdn.com/2ba2133350fe0c8c9ed7970fcb51494e1319309320134773884212496637551227415076_t.jpg"
    >
        https://17ba44c6e294ab81f639-55f93745d66bc3cab58e675e4895e5a0.ssl.cf2.rackcdn.com/2ba2133350fe0c8c9ed7970fcb51494e1319309320134773884212496637551227415076_t.jpg
    </a>
    "
</p>
<p>
    },
</p>
<p>
    "tag": []
</p>
<p>
    }
</p>
<p>
    <strong><u>43.FOR FEATURE SETTINGS UPDATE</u></strong>
</p>
<p>
    url=baseurl? action=feature_setting_update&amp;field=field
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=feature_setting_update&amp;actiontype=1201&amp;del_actionid=217846&amp;count=6&amp;profileid=1000001867&amp;groupid=204928&amp;field=missu
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1
</p>
<p>
    }
</p>
<p>
    <strong><u>44.FOR NOTIFICATIONS SETTINGS UPDATE</u></strong>
</p>
<p>
    url=baseurl? action=notification_setting_update&amp;field=field
</p>
<p>
    e.g- 
    <a href="http://50.57.224.99/ajax/write.php?action=notification_setting_update&amp;field=direct_letter">
        http://50.57.224.99/ajax/write.php?action=notification_setting_update&amp;field=direct_letter
    </a>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1
</p>
<p>
    }
</p>
<p>
    <strong><u>45.FOR EMAIL SETTINGS UPDATE</u></strong>
</p>
<p>
    url=baseurl? action=email_setting_update&amp;field=field
</p>
<p>
    e.g- 
    <a href="http://50.57.224.99/ajax/write.php?action=email_setting_update&amp;field=post_comment">
        http://50.57.224.99/ajax/write.php?action=email_setting_update&amp;field=post_comment
    </a>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1
</p>
<p>
    }
</p>
<p>
    <strong><u>46.FOR PROFILE PRIVACY UPDATE</u></strong>
</p>
<p>
    url=baseurl? action=profile_privacy_update&amp;field=field&amp;privacy=privacy
</p>
<p>
    e.g- 
    <a href="http://50.57.224.99/ajax/write.php?action=profile_privacy_update&amp;privacy=1&amp;field=profile_post_next">
        http://50.57.224.99/ajax/write.php?action=profile_privacy_update&amp;privacy=1&amp;field=profile_post_next
    </a>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "privacy": "1"
</p>
<p>
    }
</p>
<p>
    <strong><u>47.TO REMOVE BIO ITEM</u></strong>
</p>
<p>
    url=baseurl? action=bio_item_remove&amp;diaryid=diaryid
</p>
<p>
    e.g- 
</p>
<p>
    <a href="http://50.57.224.99/ajax/write.php?action=bio_item_remove&amp;count=6&amp;actiontype=8&amp;diaryid=217069">
        http://50.57.224.99/ajax/write.php?action=bio_item_remove&amp;count=6&amp;actiontype=8&amp;diaryid=217069
    </a>
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "message": "Removed"
</p>
<p>
    }
</p>
<p>
    <strong><u>48.TO REMOVE MD</u></strong>
</p>
<p>
    url=baseurl? action=md_remove&amp;profileid=profileid
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=md_remove&amp;profileid=profileid
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    No MD so far so… cant say… maybe
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "message": "Removed"
</p>
<p>
    }
</p>
<p>
    <strong><u>49.TO FETCH STAR OF THE WEEK</u></strong>
</p>
<p>
    url=baseurl? action=star_of_the_week_fetch
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php? action=star_of_the_week_fetch
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "pimage": {
</p>
<p>
    "1000000001": "
    <a
        href="https://17ba44c6e294ab81f639-55f93745d66bc3cab58e675e4895e5a0.ssl.cf2.rackcdn.com/r6fu25es684qir5d4bulq169u11342415703438132988756291696906041512574749_t.jpg"
    >
        https://17ba44c6e294ab81f639-55f93745d66bc3cab58e675e4895e5a0.ssl.cf2.rackcdn.com/r6fu25es684qir5d4bulq169u11342415703438132988756291696906041512574749_t.jpg
    </a>
    ",
</p>
<p>
    "1000000002": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000002_1402161888.jpg">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000002_1402161888.jpg
    </a>
    ",
</p>
<p>
    "1000000366": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000366_1396442406.JPG">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000366_1396442406.JPG
    </a>
    ",
</p>
<p>
    "1000001370": "
    <a
        href="https://17ba44c6e294ab81f639-55f93745d66bc3cab58e675e4895e5a0.ssl.cf2.rackcdn.com/2fp4v05ksvenqok0nil0f2ir561330443452848817506385333824608057605128111_t.jpg"
    >
        https://17ba44c6e294ab81f639-55f93745d66bc3cab58e675e4895e5a0.ssl.cf2.rackcdn.com/2fp4v05ksvenqok0nil0f2ir561330443452848817506385333824608057605128111_t.jpg
    </a>
    "
</p>
<p>
    },
</p>
<p>
    "name": {
</p>
<p>
    "1000000001": "hELL kEEpeR",
</p>
<p>
    "1000000002": "Brijesh Kushwaha",
</p>
<p>
    "1000000366": "Akash Singh",
</p>
<p>
    "1000001370": "Brajesh Kumar"
</p>
<p>
    },
</p>
<p>
    "star": [
</p>
<p>
    {
</p>
<p>
    "profileid": "1000000001",
</p>
<p>
    "contribution": "he is good at work"
</p>
<p>
    },
</p>
<p>
    {
</p>
<p>
    "profileid": "1000001370",
</p>
<p>
    "contribution": "project Z"
</p>
<p>
    },
</p>
<p>
    {
</p>
<p>
    "profileid": "1000000002",
</p>
<p>
    "contribution": "mentor"
</p>
<p>
    },
</p>
<p>
    {
</p>
<p>
    "profileid": "1000000366",
</p>
<p>
    "contribution": "good work in android"
</p>
<p>
    },
</p>
<p>
    {
</p>
<p>
    "profileid": "1000000366",
</p>
<p>
    "contribution": "good work in android"
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    }
</p>
<p>
    <strong><u>50.TO FETCH PINNED GROUP DOCUMENT</u></strong>
</p>
<p>
    url=baseurl? action=group_pinned_doc_fetch&amp;groupid=groupid
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=group_pinned_doc_fetch&amp;groupid=217065
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "pinned_doc": [
</p>
<p>
    {
</p>
<p>
    "filename": "
    <a href="https://33b933d2350357486cc1-d29c0c794c48ec4a25d5921c354b372e.ssl.cf2.rackcdn.com/1000000122_1402745464.txt">
        https://33b933d2350357486cc1-d29c0c794c48ec4a25d5921c354b372e.ssl.cf2.rackcdn.com/1000000122_1402745464.txt
    </a>
    ",
</p>
<p>
    "caption": "issues.txt",
</p>
<p>
    "description": "check"
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    }
</p>
<p>
    <strong><u>51.TO FETCH FLASHBOARD</u></strong>
</p>
<p>
    url=baseurl? action=flash_board_fetch
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php? action=flash_board_fetch
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "flash": [
</p>
<p>
    {
</p>
<p>
    "image": "
    <a href="https://becda623bf8870bb68df-da0c8a7673dba397789e9545fd410b00.ssl.cf2.rackcdn.com/1000000002_1402851520.jpg">
        https://becda623bf8870bb68df-da0c8a7673dba397789e9545fd410b00.ssl.cf2.rackcdn.com/1000000002_1402851520.jpg
    </a>
    ",
</p>
<p>
    "description": "DSDDFDF"
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    }
</p>
<p>
    <strong><u>52.TO REMOVE STAR</u></strong>
</p>
<p>
    url=baseurl? action=star_remove&amp;profileid=profileid
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=star_remove&amp;profileid=1000000001
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1
</p>
<p>
    }
</p>
<p>
    <strong><u>53.TO FETCH PRAISE </u></strong>
</p>
<p>
    url=baseurl? action=praise_fetch&amp;profileid=profileid
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php? action=praise_fetch&amp;profileid=1000000001
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "action": [
</p>
<p>
    {
</p>
<p>
    "actionby_profileid": "1000000122",
</p>
<p>
    "actionon": "Rajat Asthana",
</p>
<p>
    "actionby": "Kunal Singh",
</p>
<p>
    "title": "hardwork",
</p>
<p>
    "comment": "kamaal kar ditta tussi"
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "pimage": {
</p>
<p>
    "1000000122": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png
    </a>
    "
</p>
<p>
    }
</p>
<p>
    }
</p>
<p>
    <strong><u>54.TO FETCH VIDEO</u></strong>
</p>
<p>
    url=baseurl? action=video_fetch&amp;profileid=profileid&amp;start=start
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=video_fetch&amp;profileid=1000000002&amp;start=0
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "name": {
</p>
<p>
    "1000000002": "Brijesh Kushwaha"
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "1000000002": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000002_1402161888.jpg">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000002_1402161888.jpg
    </a>
    "
</p>
<p>
    },
</p>
<p>
    "action": [
</p>
<p>
    {
</p>
<p>
    "file": "
    <a href="https://d3e2cb1ca268cb3294f9-0fef5c8c1028eda88d7042156742e54b.ssl.cf2.rackcdn.com/1000000002_1403350417.flv">
        https://d3e2cb1ca268cb3294f9-0fef5c8c1028eda88d7042156742e54b.ssl.cf2.rackcdn.com/1000000002_1403350417.flv
    </a>
    ",
</p>
<p>
    "profileid": "1000000002",
</p>
<p>
    "actionby": "1000000002",
</p>
<p>
    "actionid": "217566",
</p>
<p>
    "caption": "Chek video",
</p>
<p>
    "thumbnail": "
    <a href="https://d3e2cb1ca268cb3294f9-0fef5c8c1028eda88d7042156742e54b.ssl.cf2.rackcdn.com/1000000002_1403350417.jpg">
        https://d3e2cb1ca268cb3294f9-0fef5c8c1028eda88d7042156742e54b.ssl.cf2.rackcdn.com/1000000002_1403350417.jpg
    </a>
    ",
</p>
<p>
    "life_is_fun": "4ef822fe40a997f67b4ac9f6b09c698f8d47ccee"
</p>
<p>
    },
</p>
<p>
    {
</p>
<p>
    "file": "<a href="http://video.qmcdn.net/1000000002_1386444828.flv">http://video.qmcdn.net/1000000002_1386444828.flv</a>",
</p>
<p>
    "profileid": "1000000002",
</p>
<p>
    "actionby": "1000000002",
</p>
<p>
    "actionid": "203955",
</p>
<p>
    "caption": "Testing...",
</p>
<p>
    "thumbnail": "<a href="http://video.qmcdn.net/">http://video.qmcdn.net/</a>",
</p>
<p>
    "life_is_fun": "531c55e8a4c0abd08c6564e8b9763a80b44951ea"
</p>
<p>
    },
</p>
<p>
    {
</p>
<p>
    "file": "<a href="http://video.qmcdn.net/1000000002_1385297708.flv">http://video.qmcdn.net/1000000002_1385297708.flv</a>",
</p>
<p>
    "profileid": "1000000002",
</p>
<p>
    "actionby": "1000000002",
</p>
<p>
    "actionid": "201442",
</p>
<p>
    "caption": "",
</p>
<p>
    "thumbnail": "<a href="http://video.qmcdn.net/">http://video.qmcdn.net/</a>",
</p>
<p>
    "life_is_fun": "6cc2f1a99279c490996d986ee8435a502c84faf7"
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    }
</p>
<p>
    <strong><u>55.TO FETCH FILE</u></strong>
</p>
<p>
    url=baseurl?action=file_fetch&amp;profileid=profileid&amp;start=start
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=video_fetch&amp;profileid=10000002826&amp;start=0
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "name": {
</p>
<p>
    "1000002826": "Vishal Malik"
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "1000002826": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000002826_1397305369.jpg">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000002826_1397305369.jpg
    </a>
    "
</p>
<p>
    },
</p>
<p>
    "action": [
</p>
<p>
    {
</p>
<p>
    "file": "
    <a href="https://33b933d2350357486cc1-d29c0c794c48ec4a25d5921c354b372e.ssl.cf2.rackcdn.com/1000002826_1403608476.txt">
        https://33b933d2350357486cc1-d29c0c794c48ec4a25d5921c354b372e.ssl.cf2.rackcdn.com/1000002826_1403608476.txt
    </a>
    ",
</p>
<p>
    "profileid": "1000002826",
</p>
<p>
    "actionby": "1000002826",
</p>
<p>
    "actionid": "217860",
</p>
<p>
    "caption": "steps.txt",
</p>
<p>
    "life_is_fun": "56f8369116dcb87d96dd42f9e40f6f164e2c0b6a"
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    }
</p>
<p>
    }
</p>
<p>
    <strong><u>56.TO SHOW PROFILE COMPLETION</u></strong>
</p>
<p>
    url=baseurl? action=bio_percentage
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php? action=bio_percentage
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "bio_perc": 84,
</p>
<p>
    "profileid": "1000000122"
</p>
<p>
    }
</p>
<p>
    <strong><u>57.TO SET MD</u></strong>
</p>
<p>
    url=baseurl? action=set_MD&amp;id=id&amp;value=value
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=set_MD&amp;id=1000000122&amp;value=Kunal+Singh
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 2(incase invititation is sent to MD else ack 1)
</p>
<p>
    }
</p>
<p>
    <strong><u>58.TO LOAD MD</u></strong>
</p>
<p>
    url=baseurl? action=md_load
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php? action=md_load
</p>
<p>
    request method – GET
</p>
<p>
    response-
</p>
<p>
    Cant say NO MD
</p>
<p>
    <strong><u>59.TO INVIE SELF</u></strong>
</p>
<p>
    url=baseurl?action=self_invite_mobile&amp;email=email
</p>
<p>
    e.g- http://50.57.224.99/ajax/write.php?action=self_invite_mobile&amp;email=coolvisshu@yahoo.com
</p>
<p>
    request method – GET
</p>
<p>
    <strong><u>60.TO FETCH USEFULLINK</u></strong>
</p>
<p>
    url=baseurl?action=usefullinks_fetch
</p>
<p>
    e.g- 
    <a
        href="http://50.57.224.99/ajax/write.php?action=usefullinks_fetch&amp;count=6&amp;actiontype=8&amp;infotype=239&amp;id=1000000122&amp;value=Kunal+Singh&amp;link_id=6"
    >
        http://50.57.224.99/ajax/write.php?action=usefullinks_fetch&amp;count=6&amp;actiontype=8&amp;infotype=239&amp;id=1000000122&amp;value=Kunal+Singh&amp;link_id=6
    </a>
</p>
<p>
    request method – POST
</p>
<p>
    respose-
</p>
<p>
    [
</p>
<p>
    {
</p>
<p>
    "link_id": "10",
</p>
<p>
    "link": "<a href="http://www.quipmate.com/">http://www.quipmate.com</a>",
</p>
<p>
    "title": "Welcome To Quipmate | Enterprise Social Network"
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    <strong><u>61.TO FETCH EVENTS AND BIRTHDAYS</u></strong>
</p>
<p>
    url=baseurl? action=birthday_bomb_fetch
</p>
<p>
e.g-     <a href="http://50.57.224.99/ajax/write.php?action=action=birthday_bomb_fetch">http://50.57.224.99/ajax/write.php?action=action=birthday_bomb_fetch</a>
</p>
<p>
    request method – POST
</p>
<p>
    respose-
</p>
<p>
    {
</p>
<p>
    "aevent": [
</p>
<p>
    {
</p>
<p>
    "name": "Thanks giving",
</p>
<p>
    "eventid": "203002",
</p>
<p>
    "date": "2015-04-04",
</p>
<p>
    "display_image": "
    <a href="https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com/event.png">
        https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com/event.png
    </a>
    "
</p>
<p>
    },
</p>
<p>
    ],
</p>
<p>
    "action": [
</p>
<p>
    {
</p>
<p>
    "profileid": "1000000000",
</p>
<p>
    "bomb_count": 0,
</p>
<p>
    "bomb_status": 0,
</p>
<p>
    "b": "1966-06-26",
</p>
<p>
    "birthday": -111024000
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "name": {
</p>
<p>
    "1000000000": "J P Saini",
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "1000000000": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/male.png">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/male.png
    </a>
    ",
</p>
<p>
    }
</p>
<p>
    }
</p>
<p>
    <strong><u>62.TO CHANGE PASSWORD</u></strong>
</p>
<p>
    url=baseurl? action=change_password&amp;old_password=old_password&amp;new_password=new_password&amp;confirm_password=confirm_password
</p>
<p>
    request method – POST
</p>
<p>
    respose-
</p>
<p>
    2
</p>
<p>
    <strong><u>63.TO FETCH RECENT MESSAGES</u></strong>
</p>
<p>
    url=baseurl? action=message_recent_fetch
</p>
<p>
    request method – POST
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "action": [
</p>
<p>
    {
</p>
<p>
    "actionon": "1000002826",
</p>
<p>
    "actionby": "1000000122",
</p>
<p>
    "message": "go pg back today at 6. i will be late today. give the keys to security guard.",
</p>
<p>
    "time": "1403608629"
</p>
<p>
    },
</p>
<p>
    {
</p>
<p>
    "actionon": "1000002826",
</p>
<p>
    "actionby": "1000000002",
</p>
<p>
    "message": "yaar thik hai fir aaj itna hi rehne do\ntum log try karna ye network service chalane ka ... this should be running for connecting fedora to
    internet\ntum search karna kal din me ki kya problem hai ... and jo solution mile usse implement karna\nOur very first goal is to connect this fedora to
    internet",
</p>
<p>
    "time": "1399921123"
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "name": {
</p>
<p>
    "1000000002": "Brijesh Kushwaha",
</p>
<p>
    "1000000122": "Kunal Singh"
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "1000000002": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000002_1402161888.jpg">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000002_1402161888.jpg
    </a>
    ",
</p>
<p>
    "1000000122": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000000122_1401384369.png
    </a>
    "
</p>
<p>
    }
</p>
<p>
    }
</p>
<p>
    <strong><u>64.TO FETCH REQUESTS</u></strong>
</p>
<p>
    url=baseurl? action=request_fetch
</p>
<p>
    request method – POST
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "friend_request_count": 1,
</p>
<p>
    "friend": [
</p>
<p>
    {
</p>
<p>
    "profileid": "1000000005"
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "name": {
</p>
<p>
    "1000000005": "Shobhit"
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "1000000005": "
    <a
        href="https://17ba44c6e294ab81f639-55f93745d66bc3cab58e675e4895e5a0.ssl.cf2.rackcdn.com/cdti7pb0cjmsivii5nfu39psa21382881677678382647872131328538076722443238_t.jpg"
    >
        https://17ba44c6e294ab81f639-55f93745d66bc3cab58e675e4895e5a0.ssl.cf2.rackcdn.com/cdti7pb0cjmsivii5nfu39psa21382881677678382647872131328538076722443238_t.jpg
    </a>
    "
</p>
<p>
    },
</p>
<p>
    "count": 0,
</p>
<p>
    "message": "Opps ! No event requests !"
</p>
<p>
    }
</p>
<p>
    <strong><u>65.TO FETCH MISSU</u></strong>
</p>
<p>
    url=baseurl? action=missu_fetch
</p>
<p>
    request method – POST
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "count": 0,
</p>
<p>
    "message": "Opps ! Nobody's missing you !"
</p>
<p>
    }
</p>
<p>
    <strong><u>66.TO BROADCAST SELECTED PAGES</u></strong>
</p>
<p>
    url=baseurl? action=broadcast_pages_select
</p>
<p>
    request method – POST
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "info": [
</p>
<p>
    {
</p>
<p>
    "pageid": "217786",
</p>
<p>
    "pagename": "snstrrocks"
</p>
<p>
    },
</p>
<p>
    {
</p>
<p>
    "pageid": "217834",
</p>
<p>
    "pagename": "snstr-rocks"
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    }
</p>
<p>
    <strong><u>67.FOR NOTICE COUNT</u></strong>
</p>
<p>
    url=baseurl? action=notice_count
</p>
<p>
    request method – POST
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "count": "0"
</p>
<p>
    }
</p>
<p>
    <strong><u>68.TO UPLOAD ALBUM</u></strong>
</p>
<p>
    url=baseurl? action=album_upload&amp;moment_hidden_profileid=moment_hidden_profileid&amp;moment_name=moment_name&amp;moment_photo_count=moment_photo_count
</p>
<p>
    $name = $_FILES['photo_box']['name'];
</p>
<p>
    $size = $_FILES['photo_box']['size'];
</p>
<p>
    request method – POST
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "actionid": "217877",
</p>
<p>
    "life_is_fun": "56fe81fd382f7c9242d13687e935a6bb975fa7b0",
</p>
<p>
    "time": 1403617880,
</p>
<p>
    "mname": "",
</p>
<p>
    "count": 2,
</p>
<p>
    "desc": "",
</p>
<p>
    "ack": 1,
</p>
<p>
    "photo": [
</p>
<p>
    {
</p>
<p>
    "file": "
    <a href="https://becda623bf8870bb68df-da0c8a7673dba397789e9545fd410b00.ssl.cf2.rackcdn.com/1000000122_1403617880.gif">
        https://becda623bf8870bb68df-da0c8a7673dba397789e9545fd410b00.ssl.cf2.rackcdn.com/1000000122_1403617880.gif
    </a>
    ",
</p>
<p>
    "actionid": "217878"
</p>
<p>
    },
</p>
<p>
    {
</p>
<p>
    "file": "
    <a href="https://becda623bf8870bb68df-da0c8a7673dba397789e9545fd410b00.ssl.cf2.rackcdn.com/1000000122_1403617886.gif">
        https://becda623bf8870bb68df-da0c8a7673dba397789e9545fd410b00.ssl.cf2.rackcdn.com/1000000122_1403617886.gif
    </a>
    ",
</p>
<p>
    "actionid": "217879"
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    }
</p>
<p>
    <strong><u>69.TO UPLOAD NEW VERSION</u></strong>
</p>
<p>
    url=baseurl? action=new_version_upload&amp;name=name&amp;size=size&amp;photo_hidden_profileid=photo_hidden_profileid&amp;pageid=pageid
</p>
<p>
    request method – POST
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "actiontype": 327,
</p>
<p>
    "profileid": "213505",
</p>
<p>
    "actionid": "217880",
</p>
<p>
    "time": 1403618218,
</p>
<p>
    "life_is_fun": "b298ad65117f93e66aeab35b26708c5b6d157f1c",
</p>
<p>
    "file": "
    <a href="https://33b933d2350357486cc1-d29c0c794c48ec4a25d5921c354b372e.ssl.cf2.rackcdn.com/1000000122_1403618192.txt">
        https://33b933d2350357486cc1-d29c0c794c48ec4a25d5921c354b372e.ssl.cf2.rackcdn.com/1000000122_1403618192.txt
    </a>
    ",
</p>
<p>
    "caption": "steps.txt"
</p>
<p>
    }
</p>
<p>
    <strong><u>70.TO UPLOAD PROFILE PICTURE </u></strong>
</p>
<p>
    url=baseurl? action=profile_picture_upload
</p>
<p>
    $name = $_FILES['photo_box']['name'];
</p>
<p>
    $size = $_FILES['photo_box']['size'];
</p>
<p>
    $tmp = $_FILES['photo_box']['tmp_name'];
</p>
<p>
    request method – POST
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "profileid": "1000002826",
</p>
<p>
    "actionid": "217881",
</p>
<p>
    "photo": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000002826_1403618347.jpg">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000002826_1403618347.jpg
    </a>
    ",
</p>
<p>
    "thumb": "
    <a href="https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000002826_1403618347.jpg">
        https://ebdd192075d95c350eef-28241eefd51f43f0990a7c61585ebde0.ssl.cf2.rackcdn.com/1000002826_1403618347.jpg
    </a>
    "
</p>
<p>
    }
</p>
<p>
    <strong><u>71.TO UPLOAD PHOTO IN A GROUP</u></strong>
</p>
<p>
    url=baseurl? action=group_photo_upload&amp;photo_description=photo_description&amp;photo_hidden_profileid=photo_hidden_profileid
</p>
<p>
    $name = $_FILES['photo_box']['name'];
</p>
<p>
    $size = $_FILES['photo_box']['size'];
</p>
<p>
    $tmp = $_FILES['photo_box']['tmp_name'];
</p>
<p>
    request method – POST
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "actiontype": 306,
</p>
<p>
    "profileid": "217783",
</p>
<p>
    "actionid": "217884",
</p>
<p>
    "time": 1403618764,
</p>
<p>
    "page": "",
</p>
<p>
    "life_is_fun": "a7086b995efe02f180fada649f6fdda3f7f553e8",
</p>
<p>
    "file": "
    <a href="https://becda623bf8870bb68df-da0c8a7673dba397789e9545fd410b00.ssl.cf2.rackcdn.com/1000000122_1403618759.jpg">
        https://becda623bf8870bb68df-da0c8a7673dba397789e9545fd410b00.ssl.cf2.rackcdn.com/1000000122_1403618759.jpg
    </a>
    ",
</p>
<p>
    "caption": "BqhcDRvCcAA1t5h.jpg"
</p>
<p>
    }
</p>
<p>
    <strong><u>72.TO UPLOAD PINNED DOCUMENT IN A GROUP</u></strong>
</p>
<p>
    url=baseurl? action=group_pinned_doc_upload&amp;doc_description=doc_description&amp;doc_hidden_profileid=doc_hidden_profileid
</p>
<p>
    $name = $_FILES['doc']['name'];
</p>
<p>
    $size = $_FILES['doc']['size'];
</p>
<p>
    $description = $_POST['doc_description'];
</p>
<p>
    $profileid = $_POST['doc_hidden_profileid'];
</p>
<p>
    request method – POST
</p>
<p>
    response-
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "actiontype": 326,
</p>
<p>
    "profileid": "204928",
</p>
<p>
    "actionid": "217886",
</p>
<p>
    "time": 1403619047,
</p>
<p>
    "page": "check",
</p>
<p>
    "life_is_fun": "03c0105cc36eb59859931322b124e18732af47cb",
</p>
<p>
    "file": "
    <a href="https://33b933d2350357486cc1-d29c0c794c48ec4a25d5921c354b372e.ssl.cf2.rackcdn.com/">
        https://33b933d2350357486cc1-d29c0c794c48ec4a25d5921c354b372e.ssl.cf2.rackcdn.com/
    </a>
    ",
</p>
<p>
    "caption": "steps.txt"
</p>
<p>
    }
</p>
<p>
    73. <strong>Login </strong>
</p>
<p>
    URL == base url?action=login&amp;email=email&amp;password=password
</p>
<p>
    request method- POST
</p>
<p>
    <strong><u>post data</u></strong>
</p>
<p>
    {"email":
</p>
<p>
    "password":
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack":1
</p>
<p>
    "message":Login successfull
</p>
<p>
    "myprofileid":
</p>
<p>
    "database":
</p>
<p>
    "sessionid":
</p>
<p>
    "name":
</p>
<p>
    "photo":
</p>
<p>
    "session_name":
</p>
<p>
    }
</p>
<p>
    <strong>74. Actiontype_preview</strong>
</p>
<p>
    URL ==base url?action=actiontype_preview&amp;actiontype=actiontype
</p>
<p>
    request method - GET
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "actiontype": refers to type of action(integer value), for eg. actiontype for team is 234).
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
    <u></u>
</p>
<p>
    {
</p>
<p>
    "action":[]
</p>
<p>
    "myprofileid": profileid of the user
</p>
<p>
    "name" : name of user
</p>
<p>
    "pimage" : profileimage of user
</p>
<p>
    "tag" :[]
</p>
<p>
    }
</p>
<p>
    <strong>75.action_fetch_life_is_not_always_fun</strong>
</p>
<p>
    <strong></strong>
</p>
<p>
    URL ==base url?action=action_fetch_life_is_not_always_fun&amp;actionid=actionid&amp;life_is_fun=life_is_fun
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "actionid": id of the action performed by the user"
</p>
<p>
    "life_is_fun":
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "action":[]
</p>
<p>
    "myprofileid": profileid of the user
</p>
<p>
    "name" : name of user
</p>
<p>
    "pimage" : profileimage of user
</p>
<p>
    "tag" :[]
</p>
<p>
    }
</p>
<p>
    <strong>76.action_fetch</strong>
</p>
<p>
    URL == base url?action=action_fetch&amp;actionid=actionid&amp;life_is_fun=life_is_fun
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "actionid": id of the action performed by the user
</p>
<p>
    "life_is_fun":
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "action":[]
</p>
<p>
    "myprofileid": profileid of the user
</p>
<p>
    "name" : name of user
</p>
<p>
    "pimage" : profileimage of user
</p>
<p>
    "tag" :[]
</p>
<p>
    }
</p>
<p>
    <strong>77.group_join</strong>
</p>
<p>
    URL == base url? action=group_join&amp;groupid=groupid
</p>
<p>
    <strong><u>get data</u></strong>
    <strong></strong>
</p>
<p>
    {
</p>
<p>
    "groupid": id of the group user requests to join
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    ack: 1,message: Requested
</p>
<p>
    status=2,ack: 0,message:You have already requested to join this group
</p>
<p>
    ack=0,message:You have already a member of this group
</p>
<p>
    }
</p>
<p>
    <strong> </strong>
</p>
<p>
    <strong>78.event_join</strong>
</p>
<p>
    URL == base url? action=event_join&amp;eventid=eventid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "eventid": id of the event
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    ack: 1,message Going
</p>
<p>
    }
</p>
<p>
    <strong>79.add_friend</strong>
</p>
<p>
    URL == base url?action=add_friend&amp;profileid=profileid&amp;msg=msg
</p>
<p>
    <strong><u>get</u></strong>
    <u> <strong>data</strong></u>
</p>
<p>
    {
</p>
<p>
    "profileid": profileid of user you request to be your friend
</p>
<p>
    "msg": some text
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    ack: 1,message:Invited
</p>
<p>
    status:-1,ack:0,message:You have already send a friend request
</p>
<p>
    status:1,ack:0,message:Friend request pending with you
</p>
<p>
    status:2,ack:0,message:You are already friends
</p>
<p>
    status:3,ack:0,message:Are you crazy? You want to be friends with yourself ! Well you already are!
</p>
<p>
    }
</p>
<p>
    <strong>80.album_fetch</strong>
</p>
<p>
    URL == base url?action=album_fetch&amp;start=start
</p>
<p>
    <u>get data</u>
</p>
<p>
    {
</p>
<p>
    "start": it is the limit of number of items you want to show
</p>
<p>
    }
</p>
<p>
    <u>response</u>
</p>
<p>
    {
</p>
<p>
    name:
</p>
<p>
    pimage:
</p>
<p>
    action:[{
</p>
<p>
    file:
</p>
<p>
    profileid:
</p>
<p>
    actionby:
</p>
<p>
    actionid:
</p>
<p>
    }]
</p>
<p>
    }
</p>
<p>
    <strong> </strong>
</p>
<p>
    <strong>81.member_load</strong>
</p>
<p>
    URL == base url?action=member_load&amp;groupid=groupid&amp;start=start
</p>
<p>
    <u>get data</u>
</p>
<p>
    {
</p>
<p>
    "start": to show (total users in group - start number of users in group)...(set start=0 to show all the members).
</p>
<p>
    "groupid": id of the group whoose member you want to load
</p>
<p>
    }
</p>
<p>
    <u>response</u>
</p>
<p>
    {
</p>
<p>
    "count": number of users in group
</p>
<p>
    "action":
</p>
<p>
    [{
</p>
<p>
    "profileid":
</p>
<p>
    "priviledge":
</p>
<p>
    }]
</p>
<p>
    "name":name of member
</p>
<p>
    "pimage":profile image of member
</p>
<p>
    }
</p>
<p>
    <strong>82. guest_load</strong>
</p>
<p>
    URL == base url?action=guest_load&amp;eventid=eventid&amp;start=start
</p>
<p>
    <u>get data</u>
</p>
<p>
    {
</p>
<p>
    "start": index from which you want to show the list
</p>
<p>
    "eventid": id of the event whoose member you want to load
</p>
<p>
    }
</p>
<p>
    <u>response</u>
</p>
<p>
    {
</p>
<p>
    "action":
</p>
<p>
    {
</p>
<p>
    "going" [
</p>
<p>
    {
</p>
<p>
    profileid: profileid of guest
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    "declined": [{profileid:}]
</p>
<p>
    "no resonse": [{profileid:}]
</p>
<p>
    }
</p>
<p>
    "name":
</p>
<p>
    { profileid:name(profileid and name of user)
</p>
<p>
    }
</p>
<p>
    "pimage"
</p>
<p>
    { profileid:profileimage(profileid and profileimage of user)
</p>
<p>
    }
</p>
<p>
    <strong>83. friend_load(to load friends of a user)</strong>
</p>
<p>
    URL == base url? action=friend_load&amp;profileid=profileid&amp;start=start
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "profileid": profileid of user whoose friends you want to see
</p>
<p>
    "start" : number of friends you want to see at once
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "name":
</p>
<p>
    "pimage":
</p>
<p>
    "action":[
</p>
<p>
    { "profileid":
</p>
<p>
    "status":
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    }
</p>
<p>
    <strong>84.friend_fetch</strong>
</p>
<p>
    URL == base url?action=friend_fetch&amp;profileid=profileid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "profileid":
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {ack:1
</p>
<p>
    "action":[
</p>
<p>
    profileid: profileid of friends
</p>
<p>
    ]<strong><u></u></strong>
</p>
<p>
    "friend_count": number of friends
</p>
<p>
    "name":
</p>
<p>
    { profileid:name(profileid and name of friend)
</p>
<p>
    }
</p>
<p>
    "pimage":
</p>
<p>
    { profileid:profileimage(profileid and profileimage of friend)
</p>
<p>
    }
</p>
<p>
    <strong>85.friend_fetch_incremental</strong>
</p>
<p>
    URL == base url?action=friend_fetch_incremental&amp;profileid=profileid&amp;start=start
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "profileid":
</p>
<p>
    "start":
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {"count": number of friends
</p>
<p>
    "action":[
</p>
<p>
    profileid: profileid of friends
</p>
<p>
    ]<strong><u></u></strong>
</p>
<p>
    "name":
</p>
<p>
    { profileid:name(profileid and name of friend)
</p>
<p>
    }
</p>
<p>
    "pimage":
</p>
<p>
    { profileid:profileimage(profileid and profileimage of friend)
</p>
<p>
    }
</p>
<p>
    <strong>86.admin_usefullink(ADD usefullink)</strong>
</p>
<p>
    URL == base url?action=usefullinks&amp;links=links&amp;title=title
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "links": link admin wants to add
</p>
<p>
    "title":title of the link
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "link_id":
</p>
<p>
    "ack":1
</p>
<p>
    }
</p>
<p>
    <strong> </strong>
</p>
<p>
    <strong>87.info_update(Adding team &amp; designation)</strong>
</p>
<p>
    URL == base url?action=info_update&amp;infoadd=infoadd&amp;infotype=infotype
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "infoadd": info(name of designation or team)
</p>
<p>
    "infotype": actiontype of(team or designation)
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "info_id":
</p>
<p>
    "ack":1
</p>
<p>
    "infoadd":
</p>
<p>
    }
</p>
<p>
    <strong>88.info_fetch(To fetch all existing teams or designations)</strong>
</p>
<p>
    URL == base url?action=info_fetch&amp;infotype=infotype
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "infotype": actiontype of(team or designation)
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "info":
</p>
<p>
    [
</p>
<p>
    { "info_id":
</p>
<p>
    "name":
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    }
</p>
<p>
    <strong>89.info_delete(To delete a existing designation or team)</strong>
</p>
<p>
    URL == base url?action=info_delete&amp;info_id=info_id
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "info_id": id at which info is stored
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack":1
</p>
<p>
    "info_id":
</p>
<p>
    }
</p>
<p>
    <strong> </strong>
</p>
<p>
    <strong>90.event_invite(Invite people to an event)</strong>
</p>
<p>
    URL == base url?action=event_invite&amp;evengid=eventid&amp;profileid=profileid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "eventid":
</p>
<p>
    "profileid": profileid of user to be invited
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack":1
</p>
<p>
    "response":1
</p>
<p>
    "message":Friend invited to the event
</p>
<p>
    }
</p>
<p>
    <strong>91.group_invite(Add members to a group)</strong>
</p>
<p>
    URL == base url?
</p>
<p>
    action=group_invite&amp;groupid=groupid&amp;profileid=profileid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "groupid": id of group
</p>
<p>
    "profileid": profileid of member to be added
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack":1
</p>
<p>
    "response":1
</p>
<p>
    "message":Member added to the group
</p>
<p>
    }
</p>
<p>
    <strong>92.guest_accept(Guest accepts request for an event or not)</strong>
</p>
<p>
    URL == base url?action=guest_accept&amp;eventid=eventid&amp;flag=flag
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "eventid": id of event
</p>
<p>
    "flag":
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack":1
</p>
<p>
    "response":1
</p>
<p>
    "message":Event request accepted
</p>
<p>
    "ack":1
</p>
<p>
    "response":0
</p>
<p>
    "message":Event request declined
</p>
<p>
    }
</p>
<p>
    <strong>93.member_request_accept(A person request to join a group is accepted or rejected)</strong>
</p>
<p>
    URL == base url?action=member_request_accept&amp;groupid=groupid&amp;profileid=profileid&amp;flag=flag
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "groupid": id of group
</p>
<p>
    "profileid":
</p>
<p>
    "flag":
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack":1
</p>
<p>
    "response":0
</p>
<p>
    "message":Member request rejected
</p>
<p>
    "ack":1
</p>
<p>
    "response":1
</p>
<p>
    "message":Member request accepted
</p>
<p>
    }
</p>
<p>
    <strong> </strong>
</p>
<p>
    <strong>94.friend_request_accept</strong>
</p>
<p>
    URL == base url?action=friend_request_accept&amp;profileid=profileid&amp;flag=flag
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "profileid":profileid of the request maker
</p>
<p>
    "flag": 1 for accept &amp; 0 for delete the invite
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack":1
</p>
<p>
    "response":0
</p>
<p>
    "message":Friend request rejected
</p>
<p>
    "ack":1
</p>
<p>
    "response":1
</p>
<p>
    "message":Friend request accepted
</p>
<p>
    }
</p>
<p>
    <strong>95.birthday_bomb</strong>
</p>
<p>
    URL == base url?action=birthday_bomb&amp;profileid=profileid&amp;wish=wish&amp;date=date
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "profileid":profileid of user whoose bday it is
</p>
<p>
    "wish": bday wish msg
</p>
<p>
    "date":bday date
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    1
</p>
<p>
    }
</p>
<p>
    96.callback()
</p>
<p>
    URL == base url?action=callback&amp;type=type&amp;k=k
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "type":actiontype
</p>
<p>
    "k":(character or string ) for expression matching
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    [
</p>
<p>
    {
</p>
<p>
    "id": "4100",
</p>
<p>
    "school": "Computer Science" (if k= c%)
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    <strong>97*.callback_not_found(Database function not defined)</strong>
</p>
<p>
    action=callback_not_found&amp;type=type&amp;name=name
</p>
<p>
    <strong>98.chat_email( To send a chat email)</strong>
</p>
<p>
    action=chat_email&amp;message=message&amp;profileid=profileid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "profileid": profileid of user whom to send the mail
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack":1
</p>
<p>
    }
</p>
<p>
    <strong>99.college_student_select</strong>
</p>
<p>
    <strong>(To select students studying in a particular college)</strong>
</p>
<p>
    URL == base url?action=college_student_select&amp;college=college
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {"college": college name
</p>
<p>
    }
</p>
<p>
    <strong><u>response </u></strong>
</p>
<p>
    {
</p>
<p>
    [
</p>
<p>
    "profileid":
</p>
<p>
    "name":
</p>
<p>
    "image":
</p>
<p>
    "cyear":
</p>
<p>
    "email"
</p>
<p>
    "profession":
</p>
<p>
    "company":
</p>
<p>
    "status":
</p>
<p>
    ]
</p>
<p>
    }
</p>
<p>
    <strong>100*.diary_create(Database function not defined)</strong>
</p>
<p>
    action=diary_create&amp;type=type&amp;name=name&amp;desc=desc
</p>
<p>
    <strong>101.answer_people_fetch()</strong>
</p>
<p>
    URL == base url?action=answer_people_fetch&amp;optionid=optionid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "optionid":
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "excited": [
</p>
<p>
    {
</p>
<p>
    "profileid": ""
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "name": {
</p>
<p>
    "profileid": "name",
</p>
<p>
    (ex:) "1000000458": "Ankit Singh"
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "profileid": "imagelink"
</p>
<p>
    }
</p>
<p>
    }
</p>
<p>
    <strong>102.response_fetch</strong>
</p>
<p>
    URL == base url?action=response_fetch&amp;pageid=pageid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "pageid":
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "excited":'profileid'
</p>
<p>
    "name":
</p>
<p>
    "pimage":
</p>
<p>
    }
</p>
<p>
    <strong>103.forgot_password(To recover password)</strong>
</p>
<p>
    URL == base url?action=forgot_password&amp;email=email
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    { "email": emailid of user
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "message": "A link has been sent to this email address. Please click at the link or paste the link in the browser to recover your password."
</p>
<p>
    }
</p>
<p>
    <strong>104.friend_invite( To invite a friend)</strong>
</p>
<p>
    URL == base url?action=friend_invite&amp;email=email
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "email": emailid of friend
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    ack:2 (if all ok)
</p>
<p>
    ack:3 (if string entered is not an email)
</p>
<p>
    (if already a user)
</p>
<p>
    ack:1 "profileid":
</p>
<p>
    }
</p>
<p>
    <strong>105.self_invite(To register yourself)</strong>
</p>
<p>
    URL == base url?action=self_invite&amp;email=email
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "email": emailid entered by user to connect to network
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack": 1
</p>
<p>
    "message": "This email is already registered with Quipmate. Please login to continue."
</p>
<p>
    "ack": 2,
</p>
<p>
    "message": "A link has been sent to your email. Please click that link to register for Quipmate."
</p>
<p>
    }
</p>
<p>
    <strong>106.member_request_fetch(List of users who request to join agroup)</strong>
</p>
<p>
    URL == base url?action=member_request_fetch&amp;groupid=groupid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "groupid":
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "count": (integer value depicting number of requsts),
</p>
<p>
    "member": [
</p>
<p>
    {
</p>
<p>
    "profileid": ""
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "name": {
</p>
<p>
    "1000002567": "name"
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "1000002567": "imagelink"
</p>
<p>
    }
</p>
<p>
    }
</p>
<p>
    <strong>107*.friend_details_fetch(to fetch details of friend)</strong>
</p>
<p>
    <strong></strong>
</p>
<p>
    URL == base url?action=friend_details_fetch&amp;profileid=profileid<strong></strong>
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "profileid": profileid of friend
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "info": [
</p>
<p>
    {
</p>
<p>
    "profileid": "",
</p>
<p>
    "age": "",
</p>
<p>
    "city":"" ,
</p>
<p>
    "profession":"" ,
</p>
<p>
    "school": ,
</p>
<p>
    "college": ""
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "name": {
</p>
<p>
    "profileid": "name"
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "profileid": "profileimage"
</p>
<p>
    }
</p>
<p>
    }
</p>
<p>
    <strong>108.friend_search</strong>
</p>
<p>
    <strong>(to search friends starting with a particular string)</strong>
</p>
<p>
    URL == base url?action=friend_search&amp;q=q&amp;profilid=profileid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "profileid": profileid of user whoose friends you want to search
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "friend": [
</p>
<p>
    {
</p>
<p>
    "profileid": ""
</p>
<p>
    },
</p>
<p>
    ],
</p>
<p>
    "name": {
</p>
<p>
    "profileid": "name",
</p>
<p>
    (ex) "1000000714": "Ankit Shrivastava",
</p>
<p>
    "1000002703": "Ashutosh pandey"
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "1000000366": "imagelink",
</p>
<p>
    }
</p>
<p>
    }
</p>
<p>
    <strong> </strong>
</p>
<p>
    <strong>109.gift</strong>
</p>
<p>
    URL == base url?action=gift&amp;profileid=profileid&amp;gift=gift&amp;gift_desc=gift_desc
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "profileid" : profileid of person you want to send gift to
</p>
<p>
    "gift": string
</p>
<p>
    "gift_desc": gift description
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack":true
</p>
<p>
    }
</p>
<p>
    <strong> </strong>
</p>
<p>
    <strong>110.live_feed</strong>
</p>
<p>
    URL == base url?action=live_feed&amp;start=start
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "start" :limit
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "action": [
</p>
<p>
    {
</p>
<p>
    "actionid": "",
</p>
<p>
    "pageid": "",
</p>
<p>
    "life_is_fun": "# value",
</p>
<p>
    "actiontype": "",
</p>
<p>
    "actionby": "",
</p>
<p>
    "actionon": ""
</p>
<p>
    },
</p>
<p>
    ],
</p>
<p>
    "name": {
</p>
<p>
    "profileid" : "name"
</p>
<p>
    "1000000122": "Kunal Singh",
</p>
<p>
    "1000000366": "Akash Singh",
</p>
<p>
    },
</p>
<p>
    "photo": {
</p>
<p>
    "1000000122": "image link",
</p>
<p>
    }
</p>
<p>
    }
</p>
<p>
    111.<strong>message_fetch</strong>
</p>
<p>
    action=message_fetch&amp;start=start&amp;profileid=profileid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {"start": limit
</p>
<p>
    "profileid": profileid of friend
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "myprofileid": "",
</p>
<p>
    "action": [
</p>
<p>
    {
</p>
<p>
    "profileid": "",
</p>
<p>
    "actionid": "",
</p>
<p>
    "pageid": "",
</p>
<p>
    "actionby": "",
</p>
<p>
    "actionon": "",
</p>
<p>
    "actiontype": 401,
</p>
<p>
    "time": "",
</p>
<p>
    "message": "msg"
</p>
<p>
    },
</p>
<p>
    ],
</p>
<p>
    "name": {
</p>
<p>
    "profileid" : "name"
</p>
<p>
    "1000000122": "Kunal Singh",
</p>
<p>
    "1000002567": "Rajat Asthana"
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "profileid": "imagelink"
</p>
<p>
    "profileid": "imagelink"
</p>
<p>
    }
</p>
<p>
    }
</p>
<p>
    <strong>112.message(TO send a message)</strong>
</p>
<p>
    URL == base url?action=message&amp;message=message&amp;profileid=profileid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {"profileid": profileid of friend whom you want to send message
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack": true,
</p>
<p>
    "actionid": "",
</p>
<p>
    "message": ""
</p>
<p>
    }
</p>
<p>
    <strong></strong>
</p>
<p>
    <strong>113*.message_college(To message a colleague)</strong>
</p>
<p>
    URL == base url?action=message_college&amp;message=message&amp;college=college
</p>
<p>
    <strong>114.make_moderator(To make someone admin)</strong>
</p>
<p>
    URL == base url?action=make_moderator&amp;profileid=profileid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "profileid": profileid of person whom admin wants to make moderator
</p>
<p>
    }
</p>
<p>
    <strong><u>reaponse</u></strong>
</p>
<p>
    {"ack":1
</p>
<p>
    }
</p>
<p>
    <strong>115.moderator_remove(To remove aa admin)</strong>
</p>
<p>
    URL == base url?action=moderator_remove&amp;profileid=profileid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "profileid": profileid of moderator whom admin wants to remove
</p>
<p>
    }
</p>
<p>
    <strong><u>reaponse</u></strong>
</p>
<p>
    {"ack":1
</p>
<p>
    }
</p>
<p>
    <strong>116.user_delete(To remove a user from network)</strong>
</p>
<p>
    URL == base url?action=user_delete&amp;profileid=profileid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "profileid": profileid of user whom admin wants to remove
</p>
<p>
    }
</p>
<p>
    <strong><u>reaponse</u></strong>
</p>
<p>
    {"ack":1
</p>
<p>
    }
</p>
<p>
    <strong>117*.people_fetch</strong>
</p>
<p>
    action=people_fetch&amp;start=start&amp;college=college&amp;new_user=new_user
</p>
<p>
    <strong>118*.pin_fetch</strong>
</p>
<p>
    action=pin_fetch&amp;start=start
</p>
<p>
    <strong>119.poll</strong>
</p>
<p>
    URL == base url?action=poll&amp;last_poll_time=last_poll_time
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "last_poll_time":
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "action":
</p>
<p>
    "myprofileid":
</p>
<p>
    "name":
</p>
<p>
    "pimage":
</p>
<p>
    "tag":
</p>
<p>
    }
</p>
<p>
    <strong>120.option_add(adding an option)</strong>
</p>
<p>
    URL == base url?action=option_add&amp;pageid=pageid&amp;option=option<strong><u></u></strong>
</p>
<p>
    <strong><u></u></strong>
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "option":
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "message": "answered",
</p>
<p>
    "actionid": "",
</p>
<p>
    "optionid": "",
</p>
<p>
    "option": "option_value"
</p>
<p>
    }
</p>
<p>
    <strong>121.photo_fetch(to retrieve the photos of a user)</strong>
</p>
<p>
    URL == base url?action=photo_fetch&amp;start=start&amp;profileid=profileid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "profileid": profileid of user whoose photo's you want to see
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "name": {
</p>
<p>
    "profileid": "name"
</p>
<p>
    },
</p>
<p>
    "action": [
</p>
<p>
    {
</p>
<p>
    "file": "imagelink",
</p>
<p>
    "profileid": "",
</p>
<p>
    "actionby": "",
</p>
<p>
    "actionid": "",
</p>
<p>
    "life_is_fun": "#value"
</p>
<p>
    },
</p>
<p>
    ]
</p>
<p>
    }
</p>
<p>
    <strong>122.feedback</strong>
</p>
<p>
    URL == base url?action=feedback&amp;name=name&amp;description=description
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "name":
</p>
<p>
    "description":
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack":1
</p>
<p>
    "message":Feedack sent
</p>
<p>
    }
</p>
<p>
    <strong>123.bio_item_add(Adding details to bio)</strong>
</p>
<p>
    URL == base url?action=bio_item_add&amp;item=item&amp;name=name&amp;diaryid=diaryid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "item":
</p>
<p>
    "name":
</p>
<p>
    "diaryid":
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack":1
</p>
<p>
    "message":Added
</p>
<p>
    }
</p>
<p>
    <strong>124.bio_percentage(To show profile completion %)</strong>
</p>
<p>
    URL == base url?action =bio_percentage
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "bio_perc": integer value depicting the % of profile completion
</p>
<p>
    "profileid": of user
</p>
<p>
    }
</p>
<p>
    <strong>125.recently_talked_people</strong>
</p>
<p>
    URL == base url?action=recently_talked_people&amp;start=start
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "start": limit
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "inbox":
</p>
<p>
    [
</p>
<p>
    {"friend":
</p>
<p>
    "message":
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    "name":{profileid:name}
</p>
<p>
    "pimage":{profileid:pimage}
</p>
<p>
    }
</p>
<p>
    <strong>126.response</strong>
</p>
<p>
    URL == base url?action=response&amp;pageid=pageid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "pageid":
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    ack:1
</p>
<p>
    "actiontype": response type
</p>
<p>
    }
</p>
<p>
    <strong>127.response_delete(for deleting a response)</strong>
</p>
<p>
    URL == base url?action=response_delete&amp;pageid=pageid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "pageid":
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    ack:1
</p>
<p>
    "actiontype": response type
</p>
<p>
    }
</p>
<p>
    <strong>128.search(For searching any query (search box))</strong>
</p>
<p>
    URL == base url?action=search&amp;q=q&amp;filter=filter&amp;start=start
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "q": search query or string
</p>
<p>
    "filter": people or group or other types
</p>
<p>
    "start":limit
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "key": (query you searched for)
</p>
<p>
    "count": total number of relevant results for your query
</p>
<p>
    "filter": filterwhich you have selected
</p>
<p>
    "action":
</p>
<p>
    [
</p>
<p>
    { "profileid":
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    "name":{profileid:name}
</p>
<p>
    "pimage":{profileid:pimage}
</p>
<p>
    }
</p>
<p>
    <strong>129.search_people(searching for a person)</strong>
</p>
<p>
    URL == base url?action=search_people&amp;q=q
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    { "q": search query(name of a person)
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "action":
</p>
<p>
    [
</p>
<p>
    { "profileid":
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    "name":{profileid:name}
</p>
<p>
    "pimage":{profileid:pimage}
</p>
<p>
    }
</p>
<p>
    <strong>130*.setting_save</strong>
</p>
<p>
    URL == base url?action=setting_save&amp;key=key&amp;value=value
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "key":
</p>
<p>
    "value":
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    }
</p>
<p>
    <strong></strong>
</p>
<p>
    <strong>131.friend_suggest(Suggesting friends to user)</strong>
</p>
<p>
    URL == base url?action=friend_suggest&amp;count=count
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "count": number of suggestions
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "action":
</p>
<p>
    [
</p>
<p>
    { "profileid":
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    "name":{profileid:name}
</p>
<p>
    "pimage":{profileid:pimage}
</p>
<p>
    }
</p>
<p>
    <strong>132.event_suggest(Suggesting events)</strong>
</p>
<p>
    URL == base url?action=event_suggest&amp;count=count
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "count": number of suggestions
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "action":
</p>
<p>
    [
</p>
<p>
    { "profileid": eventid
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    "name":{profileid:eventname}
</p>
<p>
    "pimage":{profileid:"/event.png"}
</p>
<p>
    }
</p>
<p>
    <strong>133.group_fetch(Fetching list of all groups )</strong>
</p>
<p>
    URL == base url?action=group_fetch
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "action":
</p>
<p>
    [
</p>
<p>
    { "groupid":
</p>
<p>
    "description":
</p>
<p>
    "show":
</p>
<p>
    "name":
</p>
<p>
    "pimage":
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    }
</p>
<p>
    <strong>134.group_add_fetch(show already added groups)</strong>
</p>
<p>
    URL == base url?action=group_add_fetch
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "action":
</p>
<p>
    [
</p>
<p>
    { "groupid":
</p>
<p>
    "description":
</p>
<p>
    "name":
</p>
<p>
    "pimage":
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    }
</p>
<p>
    <strong>135.group_suggest_add(Adding a group in suggested group list)</strong>
</p>
<p>
    URL == base url?action=group_suggest_add&amp;groupid=groupid
</p>
<p>
    <strong><u></u></strong>
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "groupid": id of group to be added
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack":1
</p>
<p>
    }
</p>
<p>
    <strong>136.group_remove(Removing a group from suggested group list)</strong>
</p>
<p>
    URL == base url?action=group_remove&amp;groupid=groupid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "groupid": id of group to be added
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack":1
</p>
<p>
    }
</p>
<p>
    <strong>137.group_suggest(Suggesting groups to user)</strong>
</p>
<p>
    <strong></strong>
</p>
<p>
    URL == base url?action=group_suggest&amp;count=count
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "count": limit
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "action":
</p>
<p>
    [
</p>
<p>
    { "profileid": groupid
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    "name":{profileid:groupname}
</p>
<p>
    "pimage":{profileid:groupimage}
</p>
<p>
    }
</p>
<p>
    <strong>138.stepup(Updating stepup in signup table)</strong>
</p>
<p>
    URL == base url?action=stepup
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {"ack":1
</p>
<p>
    }
</p>
<p>
    <strong>139*.school_update(Update School/college , column not present in database table)</strong>
</p>
<p>
    URL == base url?action=school_update&amp;school=school&amp;syear=syear&amp;cyear=cyear
</p>
<p>
    <strong>140.tagline_set(To set tagline)</strong>
</p>
<p>
    URL == base url?action=tagline_set&amp;tagline=tagline
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {"tagline":
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    1
</p>
<p>
    }
</p>
<p>
    <strong>141.event_cancel(To cancel an event)</strong>
</p>
<p>
    <strong></strong>
</p>
<p>
    URL == base url?action=event_cancel&amp;eventid=eventid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {"eventid": Id of the event to be canceled
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack":1
</p>
<p>
    }
</p>
<p>
    <strong>142.event_leave(to leave an event)</strong>
</p>
<p>
    URL == base url?action=event_leave&amp;eventid=eventid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {"eventid":
</p>
<p>
    }
</p>
<p>
    <strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "actionid":,
</p>
<p>
    "ack": 1
</p>
<p>
    }
</p>
<p>
    <strong>143.group_leave(To leave a group)</strong>
</p>
<p>
    URL == base url?action=group_leave&amp;groupid=groupid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {"groupid": Id of group user wishes to leave.
</p>
<p>
    }
</p>
<p>
    <strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "actionid": ,
</p>
<p>
    "ack": 1
</p>
<p>
    }
</p>
<p>
    <strong>144.unfriend(To unfriend someone)</strong>
</p>
<p>
    URL == base url?action=unfriend&amp;profileid=profileid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {"profileid": profileid of person users want to unfriend
</p>
<p>
    }
</p>
<p>
    <strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack": 1
</p>
<p>
    }
</p>
<p>
    <strong>145.validate</strong>
</p>
<p>
    URL == base url?action=validate&amp;name=name&amp;password=password&amp;gender=gender&amp;day=day&amp;month=month&amp;year=year
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {"name":
</p>
<p>
    "password": needs to be more than 5 characters long
</p>
<p>
    "gender": 1-Male &amp; 0-Female
</p>
<p>
    "day":
</p>
<p>
    "month":
</p>
<p>
    "year":
</p>
<p>
    }
</p>
<p>
    <strong><u></u></strong>
</p>
<p>
    <strong>146.validate_email(To validate email)</strong>
</p>
<p>
    URL == base url?action=validate_email&amp;email=email
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "email": emailid to be verified
</p>
<p>
    }
</p>
<p>
    <strong>147.validate_name(To validate a name)</strong>
</p>
<p>
    URL == base url?action=validate_name&amp;name=name
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "name": string to be verified
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    0: if not all aphabets
</p>
<p>
    1: if all characters in string entered are alphabets
</p>
<p>
    }
</p>
<p>
    <strong>148*.validate_password</strong>
</p>
<p>
    URL == base url?action=validate_password&amp;password=password
</p>
<p>
    <strong>149.validate_school</strong>
</p>
<p>
    URL == base url?action=validate_school&amp;school=school
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "school": school name
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    1
</p>
<p>
    }
</p>
<p>
    <strong>150.validate_year</strong>
</p>
<p>
    URL == base url?action=validate_year&amp;year=year
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "year":
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    if(year == -1)
</p>
<p>
    then 0
</p>
<p>
    else
</p>
<p>
    1
</p>
<p>
    }
</p>
<p>
    <strong>151.login_get</strong>
</p>
<p>
    URL == base url?action=login_get&amp;email=email&amp;password=password
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "email": emailid of user
</p>
<p>
    "password": password
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "ack": 1,
</p>
<p>
    "message": "Login Successful",
</p>
<p>
    "myprofileid": "profileid of user",
</p>
<p>
    "sessionid": "",
</p>
<p>
    "database": "db_name",
</p>
<p>
    "name": "name of user"
</p>
<p>
    "photo": image link,
</p>
<p>
    "session_name": "PHPSESSID"
</p>
<p>
    }
</p>
<p>
    <strong>152*.analytics(POST METHOD)</strong>
</p>
<p>
    URL == base url?action=analytics
</p>
<p>
    <strong>153*.daily_report(missing database function)</strong>
</p>
<p>
    URL == base url?action=daily_report
</p>
<p>
    <strong>154*.weekly_report(missing database function)</strong>
</p>
<p>
    URL == base url?action=weekly_report
</p>
<p>
    <strong>155*.monthly_report(missing database function</strong>
    )
</p>
<p>
    URL == base url?action=monthly_report
</p>
<p>
    <strong>156*.actions_load(No json data)</strong>
</p>
<p>
    URL == base url?action=actions_load&amp;page=page&amp;profile_relation=profile_relation
</p>
<p>
    <strong>157.page_details_fetch(to fetch the details of a page)</strong>
</p>
<p>
    URL == base url?action=page_details_fetch&amp;pageid=pageid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "pageid": Id of page whoose detail user wants to fetch
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "info": {
</p>
<p>
    "pagename": "",
</p>
<p>
    "page_description": ""
</p>
<p>
    }
</p>
<p>
    }
</p>
<p>
    158.setting_feature_select
</p>
<p>
    URL == base url?action=setting_feature_select
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "info": {
</p>
<p>
    "missu": "checked/unchecked",
</p>
<p>
    "gift": "checked/unchecked",
</p>
<p>
    "mood": "checked/unchecked",
</p>
<p>
    "birthday": "checked/unchecked",
</p>
<p>
    "actiontype_preview": "checkedunchecked",
</p>
<p>
    "invite_friend": "checked/unchecked"
</p>
<p>
    }
</p>
<p>
    }
</p>
<p>
    159.<strong>profile_details_fetch(To retrieve the details of someone's profile)</strong>
</p>
<p>
    URL == base url?action=profile_details_fetch&amp;profileid=profileid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "profileid": profileid of user whoose details you want to fetch
</p>
<p>
    }
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "info": {
</p>
<p>
    "name": "",
</p>
<p>
    "fname": "",
</p>
<p>
    "mname": "",
</p>
<p>
    "lname": "",
</p>
<p>
    "sex": "0/1",
</p>
<p>
    "birthday": "Thu Oct,24th 1991",
</p>
<p>
    "friendship_status": 3,
</p>
<p>
    "friend_count": "",
</p>
<p>
    "profile_relation": 0,
</p>
<p>
    "profile_image": "image link",
</p>
<p>
    "profile_imageid": "",
</p>
<p>
    "missu": "integer value",
</p>
<p>
    "gift": "integer value",
</p>
<p>
    "mood": "integer value"
</p>
<p>
    }
</p>
<p>
    }
</p>
<p>
    160.<strong>event_details_fetch</strong>
</p>
<p>
    URL == baseurl?action=event_details_fetch&amp;eventid=eventid
</p>
<p>
    <strong><u>get data</u></strong>
    <strong></strong>
</p>
<p>
    {
</p>
<p>
    "eventid":
</p>
<p>
    }
</p>
<p>
    <strong><u>example response</u></strong>
</p>
<p>
    {
</p>
<p>
    "info": {
</p>
<p>
    "eventid": "198355",
</p>
<p>
    "eventname": "Christmas day celeberation",
</p>
<p>
    "description": "let's celebrate",
</p>
<p>
    "invite": "1",
</p>
<p>
    "privacy": "0",
</p>
<p>
    "date": "1 Dec,2013",
</p>
<p>
    "time": "22:00:00",
</p>
<p>
    "venue": "venue of event",
</p>
<p>
    "cancel": "0",
</p>
<p>
    "priviledge": 4,
</p>
<p>
    "guest_count": "5",
</p>
<p>
    "groupid": "0",
</p>
<p>
    "event_photo": "imagelink"
</p>
<p>
    },
</p>
<p>
    "host": "profileid of host",
</p>
<p>
    "name": {
</p>
<p>
    "1000000002": "host name"
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "1000000002": "imagelink"
</p>
<p>
    }
</p>
<p>
    }
</p>
<p>
    161<strong>.group_details_fetch(to fetch details of a group)</strong>
</p>
<p>
    URL == base url?action=group_details_fetch&amp;groupid=groupid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "groupid":Id of the group
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "info": {
</p>
<p>
    "groupname": "Bangalore MMM",
</p>
<p>
    "groupid": "202429",
</p>
<p>
    "priviledge": 3,
</p>
<p>
    "description": "MMMEC alumni in bangalore",
</p>
<p>
    "link": "",
</p>
<p>
    "createdby": "1000000727",
</p>
<p>
    "type": "0",
</p>
<p>
    "invite": "0",
</p>
<p>
    "technical": "0",
</p>
<p>
    "member_count": "10",
</p>
<p>
    "group_photo": "imagelink"
</p>
<p>
    },
</p>
<p>
    "top_influencer": {
</p>
<p>
    "1": "1000000002",
</p>
<p>
    "2": "1000000727"
</p>
<p>
    },
</p>
<p>
    "count": 0,
</p>
<p>
    "name": {
</p>
<p>
    "1000000727": "Pawan Pundir",
</p>
<p>
    "1000000002": "Brijesh Kushwaha"
</p>
<p>
    },
</p>
<p>
    "pimage": {
</p>
<p>
    "1000000727": "imagelink",
</p>
<p>
    "1000000002": "imagelink"
</p>
<p>
    }
</p>
<p>
    }
</p>
<p>
    162.<strong>group_and_event_select(To select groups and event of a particular user)</strong>
</p>
<p>
    URL == base url?action=group_and_event_select<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "group": [
</p>
<p>
    {
</p>
<p>
    "groupid": "",
</p>
<p>
    "groupname": ""
</p>
<p>
    }
</p>
<p>
    ],
</p>
<p>
    "event": [
</p>
<p>
    {
</p>
<p>
    "eventid": "",
</p>
<p>
    "eventname": ""
</p>
<p>
    }
</p>
<p>
    ]
</p>
<p>
    }
</p>
<p>
    163.<strong>bio_fetch</strong>
</p>
<p>
    URL == base url?action=bio_fetch&amp;profileid=profileid
</p>
<p>
    <strong><u>get data</u></strong>
</p>
<p>
    {
</p>
<p>
    "profileid":
</p>
<p>
    }<strong><u></u></strong>
</p>
<p>
    <strong><u>response</u></strong>
</p>
<p>
    {
</p>
<p>
    "company": [{name:,
</p>
<p>
    id:
</p>
<p>
    }],
</p>
<p>
    "profession": [{name:,
</p>
<p>
    id:
</p>
<p>
    }],
</p>
<p>
    "designation": "",
</p>
<p>
    "college": [{name:,
</p>
<p>
    id:
</p>
<p>
    }],
</p>
<p>
    ],
</p>
<p>
    "school": [{name:,
</p>
<p>
    id:
</p>
<p>
    }],
</p>
<p>
    "music": [{name:,
</p>
<p>
    id:
</p>
<p>
    }],
</p>
<p>
    "sports": [{name:,
</p>
<p>
    id:
</p>
<p>
    }],
</p>
<p>
    "book": [{name:,
</p>
<p>
    id:
</p>
<p>
    }],
</p>
<p>
    "city": [{name:,
</p>
<p>
    id:
</p>
<p>
    ` }],
</p>
<p>
    "movie": [{name:,
</p>
<p>
    id:
</p>
<p>
    }],
</p>
<p>
    "hobby": [{name:,
</p>
<p>
    id:
</p>
<p>
    }],
</p>
<p>
    "mobile": [{name:,
</p>
<p>
    id:
</p>
<p>
    }],
</p>
<p>
    "skill": [{name:,
</p>
<p>
    id:
</p>
<p>
    }],
</p>
<p>
    "project": [{name:,
</p>
<p>
    id:
</p>
<p>
    }],
</p>
<p>
    "certificate": [{name:,
</p>
<p>
    id:
</p>
<p>
    }],
</p>
<p>
    "award": [{name:,
</p>
<p>
    id:
</p>
<p>
    }],
</p>
<p>
    "team": [{name:,
</p>
<p>
    id:
</p>
<p>
    }],
</p>
<p>
    "major": [{name:,
</p>
<p>
    id:
</p>
<p>
    }],
</p>
<p>
    "tool": [{name:,
</p>
<p>
    id:
</p>
<p>
    }],
</p>
<p>
    "extesnion": [{name:,
</p>
<p>
    id:
</p>
<p>
    }],
</p>
<p>
    "privacy": {
</p>
<p>
    "company": "0",
</p>
<p>
    "designation": "0",
</p>
<p>
    "college": "0",
</p>
<p>
    "school": "0",
</p>
<p>
    "music": "0",
</p>
<p>
    "sports": "0",
</p>
<p>
    "book": "0",
</p>
<p>
    "city": "0",
</p>
<p>
    "movie": "0",
</p>
<p>
    "hobby": "0",
</p>
<p>
    "mobile": "0",
</p>
<p>
    "skill": "0",
</p>
<p>
    "project": "0",
</p>
<p>
    "certificate": "0",
</p>
<p>
    "award": "0",
</p>
<p>
    "team": "0",
</p>
<p>
    "major": "0",
</p>
<p>
    "tool": null,
</p>
<p>
    "extesnion": null
</p>
<p>
    },
</p>
<p>
    "sex": "0 or 1",
</p>
<p>
    "name": "",
</p>
<p>
    "tagline": "",
</p>
<p>
    "age": "22 years old",
</p>
<p>
    "email": "email@email.com",
</p>
<p>
    "birthday": "24 Oct,1991",
</p>
<p>
    "edit": 1,
</p>
<p>
    "action": "brijesh"
</p>
<p>
    }
</p>
<p>
    164*.<strong>visitor_group_show(Not called in write.php)</strong>
</p>
<p>
    action=visitor_group_show&amp;profileid=profileid
</p>
<p>
    165*.<strong>analytics_details_post(POST DATA)</strong>
</p>
<p>
    action=analytics_details_post&amp;startdate=startdate&amp;enddate=enddate
</p>
<p>
    147*.<strong>analytics_details_joined("typedata")</strong>
</p>
<p>
    action=analytics_details_joined&amp;startdate=startdate&amp;enddate=enddate
</p>
<p>
    166*.<strong>analytics_details_comment("typedata")</strong>
</p>
<p>
    action=analytics_details_comment&amp;startdate=startdate&amp;enddate=enddate
</p>
<p>
    167*.<strong>analytics_details_view("typedata")</strong>
</p>
<p>
    action=analytics_details_view&amp;startdate=startdate&amp;enddate=enddate
</p>
<p>
    168*.<strong>analytics_details_visit("typedata")</strong>
</p>
<p>
    action=analytics_details_visit&amp;startdate=startdate&amp;enddate=enddate
</p>
</div>
</div>
</div>
</body>
</html>
   <?php 
   ?>