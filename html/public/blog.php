<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>Quipmate Blog</title>
<style>
*{font-size:11px;margin:0em;padding:0em;}
body{font-family:verdana;}
#header{position:fixed;top:0em;left:0em;width:100%;height:4em;background-color:#003153;color:#ffffff;z-index:10;}
#header-wrapper{text-align:left;padding-left:10em;width:86em;margin-top:0.9em;}
#website_logo{border:none;text-decoration:none;cursor:pointer;color:#cccccc;font-family:arial;font-size:1.8em;text-shadow: 0.1em 0.15em #000000;}
#wrapper{width:77.8em;margin:0 auto;position:relative;}
#main_content{margin:5em 0em 0em 2em;}
#developer{margin:6em 0em 0em 0em;border:0.1em solid #336699;}
#kunal{border-bottom:0.1em solid #dddddd;padding:1.5em;}
#brijesh{padding:1.5em;}
.name{color:#336699;font-size:1.3em;margin:0em 1em 0em 1em;text-decoration:none;}
.mobile{color:#336699;font-size:1.3em;margin:0em 1em 0em 1em;}
.email{color:#336699;font-size:1.3em;margin:0em 1em 0em 1em;}
.technology_each{padding:1.5em;border:0.1em solid #dddddd;border-top:none;color:#336699;}
.feature_each{padding:1.5em;border:0.1em solid #dddddd;border-top:none;color:#336699;clear:left;}
.feature_title{font-size:1.2em;}
.feature_title:hover{text-decoration:underline;cursor:pointer;}
.feature_detail{font-size:1.1em;color:#444444;display:none;padding:1.5em;}
.lfloat{float:left;margin-right:2em;width:300px;}
.text_500{font-size:1.1em;}
</style>
<meta name="quipmate founder" content="Kunal Singh, Brijesh Kushwaha" />
</head>
<body>
<?php
	require_once('../../include/File.php');
	$file = new File();
	$file->script_jquery_public();
?>
<script>
	function feature_toggle(me)
	{
		$('.feature_detail').hide();
		$(me).next().toggle();
	}
</script>
	<div id="header">
		<div id="header-wrapper">
				<a id="website_logo" href="/" title="Your Online Identity">Quipmate Blog</a>
		</div>
	</div>
	<div id="wrapper">	
		<div id="main_content">
			<div id="technologies">
			
				<div style="background-color:#336699;padding:0.5em 0.5em 0.5em 1.5em;color:#ffffff;font-size:2em;">Quipmate Feature List</div>
				<div class="feature_each">	
					<div class="feature_title" onclick="feature_toggle(this)">
						1.	Direct to MD
					</div>
					<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/direct-to-md-1.png" />
						<div class="text_500">
							Write an open/close letter to the managing director of the company. The associate writing the letter can chose if the letter is open/close. In case of an open letter it goes to the feed of all associates, who can put their opinions regarding the content of the letter. In case of a close letter the letter is received only by the managing director in their inbox and the rest of the person do not come to know about the letter.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						2.	Director’s Blog
					</div>
					<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/blog-2.png" />
						<div class="text_500">
							Directors/senior management of the organization can write blogs on significant issues concerning the organization. This blog is viewed by all the associates of the organization and they can pitch they views on them.
						</div>	
					</div>
				</div>		
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						3.	Group for each team/technical/non-technical groups
					</div>
					<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/group-3.png" />
						<div class="text_500">
							Each team in the organization has a group associated with it. Each member of the team joins this group by default as soon as he/she signs up for Quipmate.
							Two kinds of group can be created for interest based sharing technical and non-technical. Groups provide features for sharing like discussion/doc/photo/video/question.
						</div>
					</div>
				</div>
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						4.	Profile
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/profile-21.png" />
						<div class="text_500">
						Contains history of everything shared by you on Quipmate.
						</div>
					</div>
				</div>					
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						5.	Praise a fellow associate publicly
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/praise-4.png" />
						<div class="text_500">
						Managers/ any associate can praise their fellow employee for any good work they have done in any area.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						6.	Poll/ Question
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/question-5.png" />
						<div class="text_500">
							Poll/Question can be used take opinion as technical queries. They provide percentage-wise list of people who voted for a particular answer.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						7.	Events
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/event-6.png" />
						<div class="text_500">
							Events are useful for gathing and inviting people to any organizational gathering.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						8.	Moderation
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/moderation-7.png" />
						<div class="text_500">
							Quipmate provides moderation to people from the organization. Moderators will be chosen by the organization. 
							Moderators get the ability to remove any content/post posted by any user which they find non-legitimate or in conflict with the interest of the organization.
							They also can remove associates form the network who resined the organization.
						</div>	
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						9.	News Feed
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/news-feed-8.png" />
						<div class="text_500">
							News feed comes on the landing page once the user logs in. News feed brings any happening in the organization directly to the home page of associates. 
							They get updates about the groups they have joined, from people they have subscribed to, any broadcast content to all associates.
						</div>	
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						10.	Live Feed
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/live-feed-9.png" />
						<div class="text_500">
							Live feed provides live update on all the activity done on any subscribed content.
						</div>	
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						11.	Bio/Resume Sharing
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/bio-10.png" />
						<div class="text_500">
							Every associate can share thier skills, projects, tools, certificates, awards etc.
						</div>	
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						12.	Event/Birthday reminders
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/event-reminder-11.png" />
						<div class="text_500">
							You get update on all events on your home page.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						13.	Link sharing 
					</div>	
						<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/link-sharing-12.png" />
						<div class="text_500">
							Any link on web can be shared using link sharing which brings a short description of the shared content including title, meta, description.
						</div>	
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						14.	Photo/album/doc/video sharing
					</div>	
						<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/photo-13.png" />
						<div class="text_500">
							Photos of company event, get togethers can be shared with associates in the organization. Doc like pdf, ppt, doc, txt can be shared with associates. Share video with associates
						</div>	
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						15.	Broadcast news to all employees
					</div>	
						<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/news-feed-8.png" />
						<div class="text_500">
						Moderators can broadcast content to all associates in the company.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						16.	Personal messaging/chat
					</div>	
						<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/chat-14.png" />
						<div class="text_500">
						Talk with any associate in the company using messaging/chat.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						17.	Miss U
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/missu-15.png" />
						<div class="text_500">
						This is personal networking feature using which any associate can miss any other associate in the company.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						18.	Mood sharing
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/mood-16.png" />
						<div class="text_500">
						Associate can share their mood using a smiley icon describing how they feel on any particular day.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						19.	Notification on mail/website (configurable by user)
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/notification-17.png" />
						<div class="text_500">
						One can chose which notification they want any which they don't want can opt out from them.
						One can chose to subscribe/unsubscribe for emails from any updates.
						</div>
					</div>
				</div>
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						20.	Exciting/ comment on all features
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/comment-response-23.png" />
						<div class="text_500">
						Using comments any post can be turned into a discussion and people can chose to say exciting on any post.
						</div>
					</div>
				</div>				
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						21.	Sending virtual gifts
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/gift-22.png" />
						<div class="text_500">
						One can send gifts to other associate.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						22.	Search(skill, projects, tools including complete bio etc)
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/search-19.png" />
						<div class="text_500">
						Search for people with specific skill sets, tools they have worked, ant project they have worked on.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						23.	Privacy
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="http://icon.qmcdn.net/privacy-20.png" />
						<div class="text_500">
						Privacy control on everything that is shared including status, photo, link, items on bio.
						</div>
					</div>
				</div>					
			
				<div style="background-color:#336699;padding:0.5em 0.5em 0.5em 3.5em;color:#ffffff;font-size:2em;">How Quipmate helps in employee engagement?</div>
				<div class="technology_each">
					<img src="http://icon.qmcdn.net/title-1.png" />
				</div>				
				<div class="technology_each">
					<img src="http://icon.qmcdn.net/goal-2.png" />
				</div>
				<div class="technology_each">
					<img src="http://icon.qmcdn.net/why-3.png" />
				</div>
				<div class="technology_each">
					<img src="http://icon.qmcdn.net/ee-feature-4.png" />
				</div>
				<div class="technology_each">
					<img src="http://icon.qmcdn.net/model-5.png" />
				</div><div class="technology_each">
					<img src="http://icon.qmcdn.net/one-one--6.png" />
				</div><div class="technology_each">
					<img src="http://icon.qmcdn.net/one-group-7.png" />
				</div>
				<div class="technology_each">
					<img src="http://icon.qmcdn.net/group-one-8.png" />
				</div>
				<div class="technology_each">
					<img src="http://icon.qmcdn.net/group-group-9.png" />
				</div>
				<div class="technology_each">
					<img src="http://icon.qmcdn.net/benefits-10.png" />
				</div>
				<div class="technology_each">
					<img src="http://icon.qmcdn.net/outcome-11.png" />
				</div>
				<div class="technology_each">
					<img src="http://icon.qmcdn.net/sales-12.png" />
				</div>
				<div style="background-color:#336699;text-align:center;padding:0.5em;"><a target="_blank" style="text-decoration:none;color:#ffffff;" href="http://doc.qmcdn.net/How%20Quipmate%20helps%20in%20employee%20engagement.pdf">Download a copy</a></div>				
			</div>
		</div>
	</div>
</body>
</html>
