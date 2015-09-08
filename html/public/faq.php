<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>Quipmate | FAQs</title>
<style>
*{font-size:11px;margin:0em;padding:0em;}
body{font-family:tahoma;verdana;background-color:#ededed}
#header{position:fixed;top:0em;left:0em;width:100%;height:4em;background-color:#003153;color:#ffffff;z-index:10;}
#header-wrapper{text-align:left;padding-left:10em;width:86em;margin-top:0.9em;}
#website_logo{border:none;text-decoration:none;cursor:pointer;color:#cccccc;font-family:arial;font-size:1.8em;text-shadow: 0.1em 0.15em #000000;}
#wrapper{width:77.8em;margin:0 auto;position:relative;}
#main_content{margin:5em 0em 0em 2em;background-color:#ffffff;}
#developer{margin:6em 0em 0em 0em;border:0.1em solid #336699;}
#kunal{border-bottom:0.1em solid #dddddd;padding:1.5em;}
#brijesh{padding:1.5em;}
.name{color:#336699;font-size:1.3em;margin:0em 1em 0em 1em;text-decoration:none;}
.mobile{color:#336699;font-size:1.3em;margin:0em 1em 0em 1em;}
.email{color:#336699;font-size:1.3em;margin:0em 1em 0em 1em;}
.technology_each{padding:1.5em;border:0.1em solid #dddddd;border-top:none;color:#336699;}
.feature_each{padding:1.5em;border:0.1em solid #dddddd;border-top:none;color:#336699;clear:left;overflow:hidden;}
.feature_title{font-size:1.2em;}
.feature_title:hover{text-decoration:underline;cursor:pointer;}
.feature_detail{font-size:1.1em;color:#444444;display:none;padding:1.5em;}
.lfloat{float:left;margin-right:2em;width:300px;}
.text_500{font-size:1.1em;}
.faq_each{padding:1.5em;border:0.1em solid #dddddd;border-top:none;color:#336699;clear:left;overflow:hidden;}
.faq_title{font-size:1.2em;}
.faq_title:hover{text-decoration:underline;cursor:pointer;}
.faq_detail{font-size:1.1em;color:#444444;display:none;padding:1.5em;}
.subtitle{margin:0.8em 0em;color:#336699;}
li{margin-left:2em;}
</style>
<meta name="quipmate founder" content="Kunal Singh, Brijesh Kushwaha" />
</head>
<body>
<?php
	require_once('../../include/File.php');
	$file = new File();
	$file->script_jquery_public();
    $icon_cdn ='https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com';
?>
<script>
	function feature_toggle(me)
	{
		$(me).next().toggle();
	}
</script>
	<div id="header">
		<div id="header-wrapper">
				<a id="website_logo" href="/" title="Your Online Identity">Quipmate FAQs</a>
		</div>
	</div>
	<div id="wrapper">	
		<div id="main_content">
			<div id="technologies">
			
				<div style="background-color:#336699;padding:0.5em 0.5em 0.5em 1.5em;color:#ffffff;font-size:2em;">Frequently Asked Questions</div>
				<div class="faq_each">	
					<div class="faq_title" onclick="feature_toggle(this)">
						1.	What is Quipmate ?
					</div>
					<div class="faq_detail" style="display:block;">
						<div class="text_500">
							Quipmate is private social network for your company. So the content that you share will be visible only to people in your company. Although you can decide for each post the audience that you want to share it with. The content is not available to search engines.
						</div>
					</div>
				</div>
				<div class="faq_each">	
					<div class="faq_title" onclick="feature_toggle(this)">
						2.	Is Quipmate secure ?
					</div>
					<div class="faq_detail">
						<div class="text_500">
							Quipmate is hosted at Rackspace cloud. Following are the key points why it is most secure and ideal for hosting such solutions.
							<ul>
							<div class="text_500 subtitle">Physical Security</div>
								<li class="text_500">Data center access limited to Rackspace data center technicians</li>
								<li class="text_500">Biometric scanning for controlled data center access</li>
								<li class="text_500">Security camera monitoring at all data center locations</li>
								<li class="text_500">24x7 onsite staff provides additional protection against unauthorized entry</li> 
								<li class="text_500">Physical security audited by an independent firm</li>
							</ul>
							<ul>
							<div class="text_500 subtitle">System Security</div>
								<li class="text_500">System installation using hardened, patched OS</li>
								<li class="text_500">System patching configured by Rackspace to provide ongoing protection from exploits</li>
								<li class="text_500">Dedicated firewall and VPN services to help block unauthorized system access</li>
								<li class="text_500">Optional, dedicated intrusion detection devices to provide an additional layer of protection against unauthorized system access</li> 
								<li class="text_500">Distributed Denial of Service (DDoS) mitigation services based on proprietary Rackspace PrevenTier system</li>
								<li class="text_500">Risk assessment and security consultation by Rackspace professional services teams</li>
							</ul>
							<ul>
							<div class="text_500 subtitle">Operational Security - Infrastructure</div>
								<li class="text_500">ISO17799-based policies and procedures, regularly reviewed as part of their SAS70 Type II audit process</li>
								<li class="text_500">All employees trained on documented information security and privacy procedures</li>
								<li class="text_500">Access to confidential information restricted to authorized personnel only, according  to documented processes</li>
								<li class="text_500">Systems access logged and tracked for auditing purposes</li> 
								<li class="text_500">Secure document-destruction policies for all sensitive information</li>
								<li class="text_500">Fully documented change-management procedures</li>
								<li class="text_500">Independently audited disaster recovery and business continuity plans in place for Rackspace headquarters and support services</li>
							</ul>
							<ul>
							<div class="text_500 subtitle">Operational Security - Customer's Application Environment</div>
								<li class="text_500">Best practices used in the random generation of initial passwords</li>
								<li class="text_500">All passwords encrypted during transmission and while in storage at Rackspace</li>
								<li class="text_500">Secure media handling and destruction procedures for all customer data</li>
								<li class="text_500">Support-ticket history available for review via the My Rackspace  customer portal</li> 
								<li class="text_500">Help available from Rackspace in configuring system logging to create a system audit trail</li>
								<li class="text_500">Rackspace Security Services can provide guidance in developing security processes for compliance programs</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="faq_each">	
					<div class="faq_title" onclick="feature_toggle(this)">
						3.  How Quipmate helps me with my work ?
					</div>
					<div class="faq_detail">
						<div class="text_500">
							Quipmate has default group for the team that you belong to in your organization. So just post any problem that you are stuck with in that group before even starting to solve that problem. And it may turn out that one of your collegue who has already solved that problem, answers your questions in no time. And you are spared from re-inventing the solution to an already solved problem. 
							Also you can just search your entire organization feed which has been shared with you for any any problem that you face, it could have already been solved.
							You are manager of a team and is looking for a people with specific skill set ?
							Just type the skill say php in the Quipmate search box and you have the list of all the people in the organization having that skill. View the profile of that person and look for his/her work extension and pick your phone, call that person.
							You are HR guy and want to broadcast a company wide news ?
							Just create an alias and broadcast news to everyone in the organization.
						</div>
					</div>
				</div>
				<div class="faq_each">	
					<div class="faq_title" onclick="feature_toggle(this)">
						4.  How Quipmate helps in technical sharing ?
					</div>
					<div class="faq_detail">
						<div class="text_500">
							You can create technical groups say "python" and add people who work on this technology to this group. Technical filter helps you filter our all non-technical content from your feed and focus only on technical content. This enhances the technical knowledge of people in your organization. 
						</div>
					</div>
				</div>
				<div class="faq_each">	
					<div class="faq_title" onclick="feature_toggle(this)">
						5.  How Quipmate helps in quickly training new recruits ?
					</div>
					<div class="faq_detail">
						<div class="text_500">
							Suppose a new recruit is hired for mobile team to work on android. His hiring manager introduces him to mobile and android group. These groups have the list of all discussion that has ever happened about mobile and android. Plus they also lists the link to training materials and relevant online resources. He can go through these materials to learn about the technology and the product. He can also clearify his doubts by asking any question in the group itself.
						</div>
					</div>
				</div>
				<div class="faq_each">	
					<div class="faq_title" onclick="feature_toggle(this)">
						6.  How long any data is stored on Quipmate?
					</div>
					<div class="faq_detail">
						<div class="text_500">
							Quipmate by its own does not delete any data. Although person who post the data can delete the content at any point of time. Also moderators of the organization can delete any content.
						</div>
					</div>
				</div>
				
			
				<div style="background-color:#336699;padding:0.5em 0.5em 0.5em 1.5em;color:#ffffff;font-size:2em;">Quipmate Feature List</div>
                
                <!--<div class="feature_each">	
					<div class="feature_title" onclick="feature_toggle(this)">
						1.	Direct to MD
					</div>
					<div class="feature_detail" style="display:block;">
						<img class="lfloat" src="<?php //echo $icon_cdn?>/direct-to-md-1.png" />
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
						<img class="lfloat" src="<?php// echo $icon_cdn?>/blog-2.png" />
						<div class="text_500">
							Directors/senior management of the organization can write blogs on significant issues concerning the organization. This blog is viewed by all the associates of the organization and they can pitch they views on them.
						</div>	
					</div>
				</div>		
				-->
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						1.	Group for each team/technical/non-technical groups
					</div>
					<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/group-3.png" />
						<div class="text_500">
							Each team in the organization has a group associated with it. Each member of the team joins this group by default as soon as he/she signs up for Quipmate.
							Two kinds of group can be created for interest based sharing technical and non-technical. Groups provide features for sharing like discussion/doc/photo/video/question.
						</div>
					</div>
				</div>
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						2.	Profile
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/profile-21.png" />
						<div class="text_500">
						Contains history of everything shared by you on Quipmate.
						</div>
					</div>
				</div>					
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						3.	Praise a fellow associate publicly
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/praise-4.png" />
						<div class="text_500">
						Managers/ any associate can praise their fellow employee for any good work they have done in any area.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						4.	Poll/ Question
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/question-5.png" />
						<div class="text_500">
							Poll/Question can be used take opinion as technical queries. They provide percentage-wise list of people who voted for a particular answer.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						5.	Events
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/event-6.png" />
						<div class="text_500">
							Events are useful for gathing and inviting people to any organizational gathering.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						6.	Moderation
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/moderation-7.png" />
						<div class="text_500">
							Quipmate provides moderation to people from the organization. Moderators will be chosen by the organization. 
							Moderators get the ability to remove any content/post posted by any user which they find non-legitimate or in conflict with the interest of the organization.
							They also can remove associates form the network who resined the organization.
						</div>	
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						7.	News Feed
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/news-feed-8.png" />
						<div class="text_500">
							News feed comes on the landing page once the user logs in. News feed brings any happening in the organization directly to the home page of associates. 
							They get updates about the groups they have joined, from people they have subscribed to, any broadcast content to all associates.
						</div>	
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						8.	Live Feed
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/live-feed-9.png" />
						<div class="text_500">
							Live feed provides live update on all the activity done on any subscribed content.
						</div>	
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						9.	Bio/Resume Sharing
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/bio-10.png" />
						<div class="text_500">
							Every associate can share thier skills, projects, tools, certificates, awards etc.
						</div>	
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						10.	Event/Birthday reminders
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/event-reminder-11.png" />
						<div class="text_500">
							You get update on all events on your home page.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						11.	Link sharing 
					</div>	
						<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/link-sharing-12.png" />
						<div class="text_500">
							Any link on web can be shared using link sharing which brings a short description of the shared content including title, meta, description.
						</div>	
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						12.	Photo/album/doc/video sharing
					</div>	
						<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/photo-13.png" />
						<div class="text_500">
							Photos of company event, get togethers can be shared with associates in the organization. Doc like pdf, ppt, doc, txt can be shared with associates. Share video with associates
						</div>	
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						13.	Broadcast news to all employees
					</div>	
						<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/news-feed-8.png" />
						<div class="text_500">
						Moderators can broadcast content to all associates in the company.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						14.	Personal messaging/chat
					</div>	
						<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/chat-14.png" />
						<div class="text_500">
						Talk with any associate in the company using messaging/chat.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						15.	Miss U
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/missu-15.png" />
						<div class="text_500">
						This is personal networking feature using which any associate can miss any other associate in the company.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						16.	Mood sharing
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/mood-16.png" />
						<div class="text_500">
						Associate can share their mood using a smiley icon describing how they feel on any particular day.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						17.	Notification on mail/website (configurable by user)
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/notification-17.png" />
						<div class="text_500">
						One can chose which notification they want any which they don't want can opt out from them.
						One can chose to subscribe/unsubscribe for emails from any updates.
						</div>
					</div>
				</div>
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						18.	Exciting/ comment on all features
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/comment-response-23.png" />
						<div class="text_500">
						Using comments any post can be turned into a discussion and people can chose to say exciting on any post.
						</div>
					</div>
				</div>				
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						19.	Sending virtual gifts
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/gift-22.png" />
						<div class="text_500">
						One can send gifts to other associate.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						20.	Search(skill, projects, tools including complete bio etc)
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/search-19.png" />
						<div class="text_500">
						Search for people with specific skill sets, tools they have worked, ant project they have worked on.
						</div>
					</div>
				</div>	
				<div class="feature_each">
					<div class="feature_title" onclick="feature_toggle(this)">
						21.	Privacy
					</div>	
					<div class="feature_detail">
						<img class="lfloat" src="<?php echo $icon_cdn?>/privacy-20.png" />
						<div class="text_500">
						Privacy control on everything that is shared including status, photo, link, items on bio.
						</div>
					</div>
				</div>					
			
				<div style="background-color:#336699;text-align:center;padding:0.5em;"><a target="_blank" style="text-decoration:none;color:#ffffff;" href="<?php echo $doc_cdn;?>/How%20Quipmate%20helps%20in%20employee%20engagement.pdf">Download a copy</a></div>				
			</div>
		</div>
	</div>
</body>
</html>