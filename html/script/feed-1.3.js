	
   var feed = (function(){	
			
			function news_deploy(data,container,instant,append)
			{
				var myprofileid = data.myprofileid;
				if(data.action.length > 0)
				{
					$.each(data.action,function(index,value)
					{		
						if(instant == 1)
						{
							dom_id = 'if_post_'+value.actionid;
						}
						else
						{
							dom_id = 'nf_post_'+value.actionid;			
						}	
						deploy.action_decode('news_feed',value,data.name,data.pimage,container,dom_id,instant,append);
						if(value.actiontype == 1 || value.actiontype == 2 || value.actiontype == 11)
						{
							page_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 3 || value.actiontype == 13 || (value.actiontype >= 200 && value.actiontype < 300))
						{
							profile_edit_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 5 || value.actiontype == 12 || value.actiontype == 23)
						{
							moment_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 6 || value.actiontype == 24 || value.actiontype == 15)
						{
							image_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 8)
						{
							friendship_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 16 || value.actiontype == 50 || value.actiontype == 25)
						{
							profile_image_decode(value,data.name,data.pimage,container,dom_id);	
						}
						else if(value.actiontype == 17 || value.actiontype == 26)
						{
							friendship_decode(value,data.name,data.pimage,container,dom_id);	
						}
						else if(value.actiontype == 99 || value.actiontype == 91 || value.actiontype == 92)
						{
							quipmate_joined_decode(value,data.name,data.pimage,container,dom_id);	
						}
						else if(value.actiontype == 300)
						{
							group_created_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 301)
						{
							group_page_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 306)
						{
							group_image_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 308)
						{
							group_joined_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 316)
						{
							group_link_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 325)
						{
							group_video_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 326)
						{
							group_doc_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 328)
						{
							group_question_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 330)
						{
							group_event_created_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 400)
						{
							event_created_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 403)
						{
							event_page_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 406)
						{
							event_image_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 408)
						{
							event_joined_decode(value,data.name,data.pimage,container,dom_id);	
						}
						else if(value.actiontype == 410)
						{
							event_cancelled_decode(value,data.name,data.pimage,container,dom_id);	
						}
						else if(value.actiontype == 416)
						{
							event_link_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 425)
						{
							event_video_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 426)
						{
							event_doc_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 501 || value.actiontype == 503 || value.actiontype == 511)
						{
							missu_decode(value,data.name,data.pimage,container,dom_id);		
						}
						else if(value.actiontype == 600 || value.actiontype == 602 || value.actiontype == 611)
						{
							blog_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 700 || value.actiontype == 702 || value.actiontype == 711 )
						{
							direct_letter_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 800 || value.actiontype == 802 || value.actiontype == 811)
						{
							tagline_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 1201 || value.actiontype == 1202 || value.actiontype == 1211)
						{
							mood_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 1401 || value.actiontype == 1402 || value.actiontype == 1411)
						{
							gift_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 1600 || value.actiontype == 1602 || value.actiontype == 1611)
						{
							link_decode(value,data.name,data.pimage,container,dom_id);	
						}
						else if(value.actiontype == 1900 || value.actiontype == 1902 || value.actiontype == 1911)
						{
							birthday_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 2000 || value.actiontype == 2002 || value.actiontype == 2011)
						{ 
							status_song_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 2100 || value.actiontype == 2102 || value.actiontype == 2111)
						{
							song_dedication_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 2400 || value.actiontype == 2402 || value.actiontype == 2411 )
						{
							praise_decode(value,data.name,data.pimage,container,dom_id);	
						}
						else if(value.actiontype == 2500 || value.actiontype == 2511 || value.actiontype == 2502)
						{
							video_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 2600 || value.actiontype == 2611 || value.actiontype == 2602)
						{
							doc_decode(value,data.name,data.pimage,container,dom_id);
						}
						else if(value.actiontype == 2800 || value.actiontype == 2801 || value.actiontype == 2811 || value.actiontype == 2802)
						{
							question_decode(value,data.name,data.pimage,container,dom_id);
						}
							time_tag_decode(value,data.tag,dom_id);
							response_decode(value,data.name,dom_id);
							comment_decode(value,data.name,data.pimage,myprofileid,dom_id);
							comment_box(value,data.pimage,myprofileid,dom_id);
					});
				}
                else
				{
					$('#prev').append('<div style="text-align:center;">No Posts to show</div>');
					$('#prev').append('<div style="border-bottom: 0.1em solid #CCCCCC;border-top: 0.1em solid #CCCCCC; height: 4em;padding: 4em 0;text-align:center;"><input type="submit" style="height:4em;width:20em;" value="Find friends" onclick="ui.redirect_friend_suggest()"/></div>');
					$('#prev').append('<div style="border-bottom: 0.1em solid #CCCCCC;border-top: 0.1em solid #CCCCCC; height: 4em;padding: 4em 0;text-align:center;"><input type="submit" style="height:4em;width:20em;" value="Join Group" onclick="ui.redirect_group_suggest()"/></div>');
				}	
			}
			
			function page_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value');
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="1"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id='+value.postby+'"><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id='+value.postby+'">'+name[value.postby]+'</a><div class="pclass_json"><pre>'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</pre></div></div>');
				if(value.postby == myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}

			function profile_edit_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value');
				var pronoun = 'his';
				if(value.sex == 0) pronoun = 'her';
				var str = 'changed ' +pronoun+' '+value.edit_field+' to '+value.edit_value;
				if(value.actiontype == 206 || value.actiontype == 207 || value.actiontype == 208 || value.actiontype == 209 || value.actiontype == 211 || value.actiontype == 235 || value.actiontype == 230 || value.actiontype == 231 || value.actiontype == 232 || value.actiontype == 233 || value.actiontype == 235 || value.actiontype == 235 || value.actiontype == 236)
				{
					str = 'added '+value.edit_value+' to ' +pronoun+' '+value.edit_field;
				}	
				else if(value.actiontype == 234)
				{
					str = 'joined  '+value.edit_value+' '+value.edit_field;
				}				
				postid.append('<div data="'+value.actionid+'" class="pageclass_json"><input type="hidden" value="'+value.actionon+'" /><input type="hidden" value="'+value.parenttype+'"/><a href="profile.php?id=' +value.postby+' " ><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> '+str+'<div class="pclass_json"></div></div></div>');
			
				if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}	
			
			function birthday_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value');
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="1900"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id='+value.actionon+'"><img class="lfloat" src =' +pimage[value.actionon]+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id='+value.actionon+'">'+name[value.actionon]+'</a> was birthday-bombed by <a href="profile.php?id='+value.postby+'">' +name[value.postby]+'</a></div><div class="pclass_json"><pre>'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</pre></div></div>');
				if(value.actionby == myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}
			
			function friendship_decode(value,name,pimage,container,dom_id)
			{ 
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value');	
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="8"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id=' +value.postby+' "><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> is now <a href="profile.php?id=' +value.postby+'&pl=friend " >friend</a> with <a href="profile.php?id=' +value.actionon+' " >' +name[value.actionon]+ '</a></div><div></div></div>');
				if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}
			
			function group_created_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value');	
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="300"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id=' +value.postby+' "><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> created the group <a href="group.php?id='+value.groupid+'">'+value.group_name+'</a></div><div><div style="margin:0.5em 0em">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.group_description)))+'</div></div></div>');
			}
			
			function quipmate_joined_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value');	
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="99"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id=' +value.postby+' "><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id='+value.postby+'">'+name[value.postby]+'</a> joined <a href="/">Quipmate</a></div></div>');
			}
			
			function group_joined_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value');	
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="308"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id=' +value.actionon+' "><img class="lfloat" src =' +pimage[value.actionon]+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id='+value.actionon+'">'+name[value.actionon]+'</a> was invited by <a href="profile.php?id='+value.postby+'">' +name[value.postby]+ '</a> to <a href="group.php?id='+value.groupid+'">' +value.group_name+ '</a></div></div>');
			}
			
			function event_cancelled_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value');	
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="400"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id=' +value.postby+' "><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> cancelled the event <a href="event.php?id='+value.eventid+'">'+value.event_name+'</a></div><div><div style="margin:0.5em 0em">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.event_description)))+'</div><div style="margin:0.5em 0em">'+value.date+' '+value.timing+'</div><div style="margin:0.5em 0em">'+value.venue+'</div></div></div>');
			}
			
			function group_event_created_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value');	
				postid.append('<div data=' +value.pageid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="400"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id=' +value.postby+' "><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> invited group <a href="group.php?id='+value.groupid+'">'+value.group_name+'</a> to the event <a href="event.php?id='+value.eventid+'">'+value.event_name+'</a></div><div><div style="margin:0.5em 0em">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.event_description)))+'</div><div style="margin:0.5em 0em">'+value.date+' '+value.timing+'</div><div style="margin:0.5em 0em">'+value.venue+'</div></div></div>'); 
			}
			
			function event_created_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value');	
				postid.append('<div data=' +value.pageid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="400"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id=' +value.postby+' "><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> created the event <a href="event.php?id='+value.eventid+'">'+value.event_name+'</a></div><div><div style="margin:0.5em 0em">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.event_description)))+'</div><div style="margin:0.5em 0em">'+value.date+' '+value.timing+'</div><div style="margin:0.5em 0em">'+value.venue+'</div></div></div>');
			}
			
			function event_joined_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value');	
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="408"/></div>');
				if(value.postby != value.actionon)
				{
					postid.children().eq(1).append('<a href="profile.php?id=' +value.postby+' "><img class="lfloat" src =' +pimage[value.actionon]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +value.actionon+' " >' +name[value.actionon]+ '</a> was invited by <a href="profile.php?id='+value.postby+'">' +name[value.postby]+ '</a> to <a href="event.php?id='+value.eventid+'">' +value.event_name+ '</a></div>');
				}
				else
				{
					postid.children().eq(1).append('<a href="profile.php?id=' +value.postby+' "><img class="lfloat" src =' +pimage[value.actionon]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +value.actionon+' " >' +name[value.actionon]+ '</a> joined <a href="event.php?id='+value.eventid+'">' +value.event_name+ '</a></div>');
				}
			} 

			function status_song_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);	
				var myprofileid = $('#myprofileid_hidden').attr('value');
				var file = 'http://c11295425.r25.cf2.rackcdn.com/'+value.file;	
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="2000"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id=' +value.postby+' " ><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> set a new status song<div class="pclass_json">'+value.song+'<pre>'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</pre></div></div>');
				if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}
			
			function song_dedication_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);	
				var myprofileid = $('#myprofileid_hidden').attr('value');
				var file = 'http://c11295425.r25.cf2.rackcdn.com/'+value.file;	
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="2100"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id=' +value.actionon+' " ><img class="lfloat" src =' +pimage[value.actionon]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +value.actionon+' " >' +name[value.actionon]+ '</a> was dedicated a song by <a href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a><div class="pclass_json">'+value.song+'<pre>'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</pre></div></div>');
				if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}

			function crush_match_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);	
				postid.append('<div data="'+value.actionid+'" class="pageclass_json"><input type="hidden" value="'+value.actionon+'" /><input type="hidden" value="1102"/><a href="profile.php?id=' +value.postby+' " ><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> has a crush match with <a style="color:#003399" href="profile.php?id='+value.actionon+'">' +name[value.actionon]+ '</a></div></div>');
			}

			function crush_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);	
				postid.append('<div data="'+value.actionid+'" class="pageclass_json"><input type="hidden" value="'+value.actionon+'" /><input type="hidden" value="1101"/><a href="profile.php?id=' +value.actionon+' " ><img class="lfloat" src =' +pimage[value.actionon]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +value.actionon+' " >' +name[value.actionon]+ '</a> has been added as crush by <a style="color:#003399" href="#">someone</a></div></div>');
			}
			
			function missu_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);	
				postid.append('<div data="'+value.actionid+'" class="pageclass_json"><input type="hidden" value="'+value.actionon+'" /><input type="hidden" value="501"/><a href="profile.php?id=' +value.actionon+' " ><img class="lfloat" src =' +pimage[value.actionon]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +value.actionon+' " >' +name[value.actionon]+ '</a> is being missed by <a style="color:#003399" href="#">someone</a></div></div>');
			}	
			
			function gift_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);	
				var myprofileid = $('#myprofileid_hidden').attr('value');
				var file = 'http://image.qmcdn.net/'+value.file; 
				postid.append('<div data="'+value.actionid+'" class="pageclass_json"><input type="hidden" value="'+value.actionon+'" /><input type="hidden" value="1401"/><a href="profile.php?id=' +value.actionon+' " ><img class="lfloat" src =' +pimage[value.actionon]+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id=' +value.actionon+' " >' +name[value.actionon]+ '</a> received '+value.gift+' as gift from <a style="color:#003399" href="profile.php?id='+value.postby+'">' +name[value.postby]+ '</a></div><div><div class="pclass_json">Gift message: '+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</div><img src="'+file+'" /></div></div></div>');
				if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}
			
			function mood_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);	
				var myprofileid = $('#myprofileid_hidden').attr('value');
				var file = 'http://image.qmcdn.net/'+value.file; 
				var pronoun = 'his';
				if(value.sex == 0) pronoun = 'her';	
				postid.append('<div data="'+value.actionid+'" class="pageclass_json"><input type="hidden" value="'+value.actionon+'" /><input type="hidden" value="1201"/><a href="profile.php?id=' +value.postby+' " ><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> changed '+pronoun+' mood to '+value.mood+'</div><div><div style="margin-top:0.5em;">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</div><img src="'+file+'" /></div></div></div>');
			
			if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}
			
			function moment_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value');
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /><input type="hidden" value="5"/><a href="profile.php?id='+value.postby+'"><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> added '+value.count+' photo to the album '+value.mname+'<div class="pclass_json"><input type="hidden" value=' +value.life_is_fun+ ' /><div>'+ui.see_more(ui.get_smiley(ui.link_highlight(value.desc)))+'</div></div></div></div>');
				$.each(value.photo,function(i,v)
				{
					var f = v.file; 
					postid.children().eq(1).children().eq(3).children().eq(1).append('<img class="viewable" data="'+f+'"src ="thumbnail.php?file='+f+'&maxw=180&maxh=180" style="margin:0em 0.25em 0em 0em;cursor:pointer;height:15em;max-width:16.6em;" id="'+v.actionid+' " />');
				});
				if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}
			
			function blog_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var file = value.file; 
				var myprofileid = $('#myprofileid_hidden').attr('value');
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="6"/><a href="profile.php?id=' +value.postby+' " ><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> published a blog<div><input type="hidden" value="'+value.life_is_fun+'" /><div style="margin:0.5em 0em;">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.blog_title)))+'</div><img src ="thumbnail.php?file='+file+'&maxw=368&maxh=400" style="max-width:33.5em;margin-bottom:1em;cursor:pointer;border:0.1em solid #aaaaaa;" data="'+file+'" class="viewable" id="'+value.pageid+' " /><div class="pclass_json"><pre>'+ui.see_more(ui.get_smiley(ui.link_highlight(value.blog_content)))+'</pre></div></div></div></div>');
				if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				} 
			} 
			
			function group_image_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var file = value.file; 
				var myprofileid = $('#myprofileid_hidden').attr('value');
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="6"/><a href="profile.php?id=' +value.postby+' " ><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> added a photo in the group <a href="group.php?id=' +value.groupid+' " >' +value.group_name+ '</a></div><div><input type="hidden" value="'+value.life_is_fun+'" /><div style="margin:0.5em 0em;">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</div><img src ="thumbnail.php?file='+file+'&maxw=368&maxh=400" style="max-width:33.5em;margin-bottom:1em;cursor:pointer;border:0.1em solid #aaaaaa;" data="'+file+'" class="viewable" id="'+value.pageid+' " /></div></div></div>');
				if(value.postby == myprofileid || value.remove == 1)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}
			
			function group_doc_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value'); 
				var ext = value.caption.split('.').pop();
				var fileimage ='http://icon.qmcdn.net/'+ext+'.ico';
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="2600"/><a href="profile.php?id=' +value.postby+' " ><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> added a doc in the group <a href="group.php?id=' +value.groupid+' " >' +value.group_name+ '</a><div><input type="hidden" value="'+value.life_is_fun+'" /><div style="margin:0.5em 0em;">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</div><img class="lfloat" src='+fileimage+' height="50" width="50" /><div id="doc_name"><a href='+value.file+' data="'+value.file+'" target="_blank">'+value.caption+'</a></div></div></div></div>');
				if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				} 
			}
			
			
			function group_video_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var file = value.file; 
				var myprofileid = $('#myprofileid_hidden').attr('value'); 
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="2500"/><a href="profile.php?id=' +value.postby+' " ><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> added a video in the group <a href="group.php?id=' +value.groupid+' " >' +value.group_name+ '</a><div><input type="hidden" value="'+value.life_is_fun+'" /><div style="margin:0.5em 0em;">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</div><div id="'+dom_id+'video_'+value.actionid+'"></div></div></div></div>');
				jwplayer(dom_id+"video_"+value.actionid).setup({file:value.file,title:value.page,width: "100%",aspectratio: "16:9",fallback:"false",primary:"flash"});
				if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				} 
			}
			
			function event_doc_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value'); 
				var ext = value.caption.split('.').pop();
				var fileimage ='http://icon.qmcdn.net/'+ext+'.ico';
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="2600"/><a href="profile.php?id=' +value.postby+' " ><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> added a doc in the event <a href="event.php?id=' +value.eventid+' " >' +value.event_name+ '</a><div><input type="hidden" value="'+value.life_is_fun+'" /><div style="margin:0.5em 0em;">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</div><img class="lfloat" src='+fileimage+' height="50" width="50" /><div id="doc_name"><a href='+value.file+' data="'+value.file+'" target="_blank">'+value.caption+'</a></div></div></div></div>');
				if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				} 
			}
			
			function event_image_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var file = value.file; 
				var myprofileid = $('#myprofileid_hidden').attr('value');
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="6"/><a href="profile.php?id=' +value.postby+' " ><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> added a photo in the event <a href="event.php?id=' +value.eventid+' " >' +value.event_name+ '</a></div><div><input type="hidden" value="'+value.life_is_fun+'" /><div style="margin:0.5em 0em;">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</div><img src ="thumbnail.php?file='+file+'&maxw=368&maxh=400" style="max-width:33.5em;margin-bottom:1em;cursor:pointer;border:0.1em solid #aaaaaa;" data="'+file+'" class="viewable" id="'+value.pageid+' " /></div></div></div>');
				if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				} 
			}
			
			function event_video_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var file = value.file; 
				var myprofileid = $('#myprofileid_hidden').attr('value'); 
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="2500"/><a href="profile.php?id=' +value.postby+' " ><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> added a video in the event <a href="event.php?id=' +value.eventid+' " >' +value.event_name+ '</a><div><input type="hidden" value="'+value.life_is_fun+'" /><div style="margin:0.5em 0em;">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</div><div id="'+dom_id+'video_'+value.actionid+'"></div></div></div></div>');
				jwplayer(dom_id+"video_"+value.actionid).setup({file:value.file,title:value.page,width: "100%",aspectratio: "16:9",fallback:"false",primary:"flash"});
				if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				} 
			}
		
			function video_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var file = value.file; 
				var myprofileid = $('#myprofileid_hidden').attr('value'); 
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="2500"/><a href="profile.php?id=' +value.postby+' " ><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> added a video<div><input type="hidden" value="'+value.life_is_fun+'" /><div style="margin:0.5em 0em;">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</div><div id="'+dom_id+'video_'+value.actionid+'"></div></div></div></div>');
				jwplayer(dom_id+"video_"+value.actionid).setup({file:value.file,title:value.page,width: "100%",aspectratio: "16:9",fallback:"false",primary:"flash"});
				if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				} 
			}
			
			function doc_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value'); 
				var ext = value.caption.split('.').pop();
				var fileimage ='http://icon.qmcdn.net/'+ext+'.ico';
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="2600"/><a href="profile.php?id=' +value.postby+' " ><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> added a doc<div><input type="hidden" value="'+value.life_is_fun+'" /><div style="margin:0.5em 0em;">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</div><img class="lfloat" src='+fileimage+' height="50" width="50" /><div id="doc_name"><a href='+value.file+' data="'+value.file+'" target="_blank">'+value.caption+'</a></div></div></div></div>');
				if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				} 
			}
			
			function image_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var file = value.file; 
				var myprofileid = $('#myprofileid_hidden').attr('value'); 
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="6"/><a href="profile.php?id=' +value.postby+' " ><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> added a photo<div><input type="hidden" value="'+value.life_is_fun+'" /><div style="margin:0.5em 0em;">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</div><img src ="thumbnail.php?file='+file+'&maxw=368&maxh=400" style="max-width:33.5em;margin-bottom:1em;cursor:pointer;border:0.1em solid #aaaaaa;" data="'+file+'" class="viewable" id="'+value.pageid+' " /></div></div></div>');
				if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				} 
			}
			
			function profile_image_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var file = value.file; 
				var pronoun = 'his';
				if(value.sex == 0) pronoun = 'her';
				var myprofileid = $('#myprofileid_hidden').attr('value');
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="50"/><a href="profile.php?id=' +value.postby+' " ><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> changed '+pronoun+' profile photo<div style="margin-top:1em;"><input type="hidden" value="'+value.life_is_fun+'" /><img src ="thumbnail.php?file='+file+'&maxw=368&maxh=400" style="max-width:33.5em;margin-bottom:1em;cursor:pointer;border:0.1em solid #aaaaaa;" data="'+file+'" class="viewable" id="'+value.pageid+' "/></div></div></div>');
				if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}	

			function tagline_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value');
				var file = 'http://icon.qmcdn.net/tag.gif'; 
				var pronoun = 'his';
				if(value.sex == 0) pronoun = 'her';		
				postid.append('<div data="'+value.actionid+'" class="pageclass_json"><input type="hidden" value="'+value.actionon+'" /><input type="hidden" value="800"/><a href="profile.php?id=' +value.postby+' " ><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> changed '+pronoun+' tagline <div class="pclass_json"><img src="'+file+'" /> '+ui.see_more(ui.get_smiley(ui.link_highlight(value.tagline)))+'</div></div></div>');
			
				if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}	
			
			function direct_letter_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value');
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="1"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id='+value.postby+'"><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id='+value.postby+'">'+name[value.postby]+'</a> wrote an open letter to the Managing Director<div class="pclass_json"><pre style="margin:0.5em 0em;">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.letter_title)))+'</pre><pre  style="margin:0.5em 0em;">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.letter_content)))+'</pre></div></div>');
				if(value.postby == myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}
			
			function praise_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value');
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="1"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id='+value.actionon+'"><img class="lfloat" src =' +pimage[value.actionon]+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id='+value.actionon+'">'+name[value.actionon]+'</a> was praised by <a href="profile.php?id='+value.postby+'">'+name[value.postby]+'</a></div><div class="pclass_json"><pre style="margin:0.5em 0em;">For: '+ui.see_more(ui.get_smiley(ui.link_highlight(value.letter_title)))+'</pre><pre  style="margin:0.5em 0em;display:block;">Praise: '+ui.see_more(ui.get_smiley(ui.link_highlight(value.letter_content)))+'</pre></div></div>');
				if(value.postby == myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}
			
			function group_page_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value');
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="1"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id='+value.postby+'"><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id='+value.postby+'">'+name[value.postby]+'</a> posted in the group <a href="group.php?id=' +value.groupid+' " >' +value.group_name+ '</a></div><div class="pclass_json"><pre>'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</pre></div></div>');
				if(value.postby == myprofileid || value.remove == 1)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}
			
			function group_question_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value');
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /><input type="hidden" value="2801"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id='+value.postby+'"><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id='+value.postby+'">'+name[value.postby]+'</a> asked a question to the group <a href="group.php?id=' +value.groupid+' " >' +value.group_name+ '</a></div><div class="pclass_json"><pre style="margin-bottom:0.6em;">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.question)))+'</pre></div></div>');
				$.each(value.option,function(i,v){
					if(v.mine == 1)
					{
						postid.children().eq(1).children().eq(3).children().eq(1).append('<div class="option"><input type="checkbox" style="margin-right:0.5em" onchange="action.answer(this, '+value.actionid+', '+v.optid+')" checked/>'+ui.see_more(ui.get_smiley(ui.link_highlight(v.opt)))+'<span class="rfloat tcolor" onclick="action.answer_people_fetch(this,'+v.optid+')">'+v.count+' vote, '+v.percent+'% </span></div>');
					}
					else
					{
						postid.children().eq(1).children().eq(3).children().eq(1).append('<div class="option"><input type="checkbox" style="margin-right:0.5em" onchange="action.answer(this, '+value.actionid+', '+v.optid+')"/>'+ui.see_more(ui.get_smiley(ui.link_highlight(v.opt)))+'<span class="rfloat tcolor" onclick="action.answer_people_fetch(this,'+v.optid+')">'+v.count+' vote, '+v.percent+'% </span></div>');
					}
				});	
				postid.children().eq(1).children().eq(3).children().eq(1).append('<div><input type="text" placeholder="+Add answer" value="" class="option" onkeydown="action.option_add(this,event)"><div>');
				if(value.postby == myprofileid || value.remove == 1)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}
			
			function event_page_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value');
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /><input type="hidden" value="1"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id='+value.postby+'"><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id='+value.postby+'">'+name[value.postby]+'</a> posted in the event <a href="event.php?id=' +value.eventid+' " >' +value.event_name+ '</a></div><div class="pclass_json"><pre>'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</pre></div></div>');
				if(value.postby == myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}
			
			function event_link_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);	
				var myprofileid = $('#myprofileid_hidden').attr('value');
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="1600"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id=' +value.postby+' " ><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> shared <a href="'+value.link+'" target="_blank">'+value.title+'</a> in the event <a href="event.php?id=' +value.eventid+' " > ' +value.event_name+ '</a></div></div>');
				if(value.video)
				{
					
					postid.children().eq(1).children().eq(3).append('<div style="position:relative;"><input type="hidden" value="'+value.file+'" /><img class="video_play viewable lfloat" style="margin:0em 1em 1em 0em;cursor:pointer;" id="'+value.actionid+'" src="http://img.youtube.com/vi/'+value.file+'/default.jpg" /><img class="video_play viewable" style="position:absolute;left:4em;top:3em;cursor:pointer;" id="'+value.actionid+'" src="http://icon.qmcdn.net/video_play_icon.png" /><div style="margin:2em 0em 0em 0em;"><div>'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</div><div>'+value.title+'</div><a href="'+value.link+'" target="_blank">'+value.host+'</a><div>'+value.meta+'</div></div><br style= "clear:both;"/></div>');	
					
				}
				else
				{
					postid.children().eq(1).children().eq(3).append('<div><img class="lfloat" style="max-height:8.2em;max-width:11em;margin-right:1em;" src="'+value.file+'" ><div style="margin:1em 0em 0em 0em;">'+value.title+'<br /><a href="'+value.link+'"  target="_blank">'+value.host+'</a><br />'+value.meta+'<br />'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</div><div style="clear:left;"></div></div>');
				}
				if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}
			
			function group_link_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);	
				var myprofileid = $('#myprofileid_hidden').attr('value');
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="1600"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id=' +value.postby+' " ><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> shared <a href="'+value.link+'" target="_blank">'+value.title+'</a> in the group <a href="group.php?id=' +value.groupid+' " >' +value.group_name+ '</a></div></div>');
				if(value.video)
				{ 
					postid.children().eq(1).children().eq(3).append('<div style="position:relative;"><input type="hidden" value="'+value.file+'" /><img class="video_play viewable lfloat" style="margin:0em 1em 1em 0em;cursor:pointer;" id="'+value.actionid+'" src="http://img.youtube.com/vi/'+value.file+'/default.jpg" /><img class="video_play viewable" style="position:absolute;left:4em;top:3em;cursor:pointer;" id="'+value.actionid+'" src="http://icon.qmcdn.net/video_play_icon.png" /><div style="margin:2em 0em 0em 0em;"><div>'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</div><div>'+value.title+'</div><a href="'+value.link+'" target="_blank">'+value.host+'</a><div>'+value.meta+'</div></div><br style= "clear:both;"/></div>');
				}
				else
				{
					postid.children().eq(1).children().eq(3).append('<div><img class="lfloat" style="max-height:8.2em;max-width:11em;margin-right:1em;" src="'+value.file+'" ><div style="margin:1em 0em 0em 0em;">'+value.title+'<br /><a href="'+value.link+'"  target="_blank">'+value.host+'</a><br />'+value.meta+'<br />'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</div><div style="clear:left;"></div></div>');
				}
				if(value.postby == myprofileid || value.remove == 1)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}
			
			function link_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);	
				var myprofileid = $('#myprofileid_hidden').attr('value');
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="1600"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id=' +value.postby+' " ><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id=' +value.postby+' " >' +name[value.postby]+ '</a> shared <a href="'+value.link+'" target="_blank">'+value.title+'</a></div></div>');
				if(value.video)
				{ 
					postid.children().eq(1).children().eq(3).append('<div style="position:relative;"><input type="hidden" value="'+value.file+'" /><img class="video_play viewable lfloat" style="margin:0em 1em 1em 0em;cursor:pointer;" id="'+value.actionid+'" src="http://img.youtube.com/vi/'+value.file+'/default.jpg" /><img class="video_play viewable" style="position:absolute;left:4em;top:3em;cursor:pointer;" id="'+value.actionid+'" src="http://icon.qmcdn.net/video_play_icon.png" /><div style="margin:2em 0em 0em 0em;"><div>'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'</div><div>'+value.title+'</div><a href="'+value.link+'" target="_blank">'+value.host+'</a><div>'+value.meta+'</div></div><br style= "clear:both;"/></div>');
				}
				else
				{
					postid.children().eq(1).children().eq(3).append('<div><img class="lfloat" style="max-height:8.2em;max-width:11em;margin-right:1em;" src="'+value.file+'" ><div style="margin:1em 0em 0em 0em;">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.page)))+'<br />'+value.title+'<br /><a href="'+value.link+'"  target="_blank">'+value.host+'</a><br />'+value.meta+'<br /></div><div style="clear:left;"></div></div>');
				}
				if(value.postby==myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}
			
			function question_decode(value,name,pimage,container,dom_id)
			{
				var postid = $('#'+dom_id);
				var myprofileid = $('#myprofileid_hidden').attr('value');
				postid.append('<div data=' +value.actionid+ ' class="pageclass_json"><input type="hidden" value=' +value.actionon+ ' /> <input type="hidden" value="2801"/></div>');
				postid.children().eq(1).append('<a href="profile.php?id='+value.postby+'"><img class="lfloat" src =' +pimage[value.postby]+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id='+value.postby+'">'+name[value.postby]+'</a> asked a question<div class="pclass_json"><pre style="margin-bottom:0.6em;">'+ui.see_more(ui.get_smiley(ui.link_highlight(value.question)))+'</pre></div></div>');
				$.each(value.option,function(i,v){
					if(v.mine == 1)
					{
						postid.children().eq(1).children().eq(3).children().eq(1).append('<div class="option"><input type="checkbox" style="margin-right:0.5em" onchange="action.answer(this, '+value.actionid+', '+v.optid+')" checked/>'+ui.see_more(ui.get_smiley(ui.link_highlight(v.opt)))+'<span class="rfloat tcolor" onclick="action.answer_people_fetch(this,'+v.optid+')">'+v.count+' vote, '+v.percent+'% </span></div>');
					}
					else
					{
						postid.children().eq(1).children().eq(3).children().eq(1).append('<div class="option"><input type="checkbox" style="margin-right:0.5em" onchange="action.answer(this, '+value.actionid+', '+v.optid+')"/>'+ui.see_more(ui.get_smiley(ui.link_highlight(v.opt)))+'<span class="rfloat tcolor" onclick="action.answer_people_fetch(this,'+v.optid+')">'+v.count+' vote, '+v.percent+'% </span></div>');
					}
				});	
				postid.children().eq(1).children().eq(3).children().eq(1).append('<div><input type="text" placeholder="+Add answer" value="" class="option" onkeydown="action.option_add(this,event)"><div>');
				if(value.postby == myprofileid)
				{
					postid.append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
				}
			}
			
			function time_tag_decode(value,tag,dom_id)
			{
				var postid = $('#'+dom_id);
				var exciting = 'Exciting';
				var class_type = 'response';
				var fun = 'action.response(this)';
				var pos = $.inArray(myprofileid, value.excited);
				if(value.actiontype == 50 || value.actiontype == 16 || value.actiontype == 25)
				{	
					exciting = 'New-Pinch';
				}
				if(pos != -1)
				{ 
					exciting = 'Unexciting'; 
					class_type = 'responsed';
					fun = 'action.responsed(this)';
					if(value.actiontype == 50 || value.actiontype == 16 || value.actiontype == 25)
					{
						exciting = 'Unpinch'; 					
					}	
				}
				postid.children().eq(1).children().eq(3).append('<div class="time_tag_json"><span onclick="'+fun+'" class="'+class_type+'" style="color:#336699;">'+exciting+' </span><a href="action.php?actionid='+value.pageid+'&life_is_fun='+value.life_is_fun+'"><img src="http://icon.qmcdn.net/clock.png" width="6" /><span class="time" data="'+value.time+'">'+time_difference(value.time)+'</span></a></div>');
				if(value.visible == 0)
				{
					postid.children().eq(1).children().eq(3).children().eq(2).append('<img style="margin:0em 0.5em;" src="http://icon.qmcdn.net/clock.png" width="6" /><span class="post_privacy_display"><img style="height:1em" title="Shared with Everyone" width="15" height="15" src="http://icon.qmcdn.net/global.png"/></span>');
				}
				else if(value.visible == 1)
				{
					postid.children().eq(1).children().eq(3).children().eq(2).append('<img style="margin:0em 0.5em;" src="http://icon.qmcdn.net/clock.png" width="6" /><span class="post_privacy_display"><img style="height:1em" title="Shared with friends of friends" src="http://icon.qmcdn.net/meeting.png"/></span>');
				}
				else if(value.visible == 2)
				{
					postid.children().eq(1).children().eq(3).children().eq(2).append('<img style="margin:0em 0.5em;" src="http://icon.qmcdn.net/clock.png" width="6" /><span class="post_privacy_display"><img  style="height:1em" title="Shared with friends" src="http://www.oorvalam.com/Images/friendIcon.png"/></span>');				
				}
				else if(value.visible == 5)
				{
					postid.children().eq(1).children().eq(3).children().eq(2).append('<img style="margin:0em 0.5em;" src="http://icon.qmcdn.net/clock.png" width="6" /><span class="post_privacy_display"><img  style="height:1em" title="Shared with this group" src="http://icon.qmcdn.net/group.png"/></span>');				
				}
				else if(value.visible == 6)
				{
					postid.children().eq(1).children().eq(3).children().eq(2).append('<img style="margin:0em 0.5em;" src="http://icon.qmcdn.net/clock.png" width="6" /><span class="post_privacy_display"><img  style="height:1em" title="Shared with this event" src="http://icon.qmcdn.net/event.png"/></span>');				
				}
			}
			
			function response_decode(value,name,dom_id)
			{ 
				var postid = $('#'+dom_id);	
				var myprofileid = $('#myprofileid_hidden').attr('value');
				var pos = $.inArray(myprofileid, value.excited);
				var exciting = 'Exciting';
				var class_type = 'response';
				var fun = 'action.response(this)';
				if(value.actiontype == 50 || value.actiontype == 16 || value.actiontype == 25)
				{	
					exciting = 'New-Pinch';
				}
				if(pos != -1)
				{ 
					exciting = 'Unexciting'; 
					class_type = 'responsed';
					fun = 'action.responsed(this)';
					if(value.actiontype == 50 || value.actiontype == 16 || value.actiontype == 25)
					{
						exciting = 'Unpinch'; 					
					}	
				}
				postid.children().eq(1).children().eq(3).append('<div class="likeclass_json"><span class="excited_people"></span><span class="post_pointer"></span></div>');		
				var excited_count = 0;
				var flag = 0;
				if( pos != -1)
				{
					value.excited.splice(pos, 1);
					if(value.excited.length > 1)
					{
						postid.children().eq(1).children().eq(3).children().eq(3).children().eq(0).append('<span>You, </span>');
					}
					else if(value.excited.length == 1)
					{
						postid.children().eq(1).children().eq(3).children().eq(3).children().eq(0).append('<span>You and </span>');
					}
					else
					{
						if(value.actiontype == 50 || value.actiontype == 16 || value.actiontype == 25)
						{
							postid.children().eq(1).children().eq(3).children().eq(3).children().eq(0).append('<span>You have new-pinched</span>');	
						}
						else
						{
							postid.children().eq(1).children().eq(3).children().eq(3).children().eq(0).append('<span>You are excited at this</span>');	
						}	
						flag = 1;	
					}		
				}
				excited_count = value.excited.length - 3;
				$.each(value.excited,function(index,v){
					if(index < 3)
					{
						postid.children().eq(1).children().eq(3).children().eq(3).children().eq(0).append('<a href="profile.php?id='+v+'">'+name[v]+'</a>');			
						if(index == value.excited.length-2 && index < 2)
						{
							postid.children().eq(1).children().eq(3).children().eq(3).children().eq(0).append(' and ');
							flag = 2;	
						}
						else if(value.excited.length > 2 && index != value.excited.length-2 && index < 1)
						{
							postid.children().eq(1).children().eq(3).children().eq(3).children().eq(0).append(', ');
							flag = 2;
						}
						else if(index < value.excited.length-2 && index == 1)
						{
							postid.children().eq(1).children().eq(3).children().eq(3).children().eq(0).append(', ');
							flag = 2;
						}
					}
					else if(excited_count == 1)
					{
						postid.children().eq(1).children().eq(3).children().eq(3).children().eq(0).append(' and <a href="profile.php?id='+v+'">'+name[v]+ '</a> are excited at this');
                        flag = 1;						
					}
				});
				if(flag == 0 && excited_count > -1) postid.children().eq(1).children().eq(3).children().eq(3).children().eq(0).append(' are excited at this');
                else if(flag == 2) postid.children().eq(1).children().eq(3).children().eq(3).children().eq(0).append(' are excited at this'); 	
			}
			
			function comment_decode(value,name,pimage,myprofileid,dom_id)
			{
				var postid = $('#'+dom_id);
				if(value.comment_count > 3)
				{
					postid.children().eq(1).children().eq(3).append('<div class="comments_show"><input type="hidden" value="'+value.actionid_third+'" /><span class="show_all_comments" onclick="action.show_all_comments(this)" >Show all '+ value.comment_count+' comments</span></div>');
				}
				$.each(value.com,function(index,com){
				
					var comid = dom_id+'_'+ com.com_actionid;
					var exciting = 'Exciting';
					var fun = 'action.response(this)';
					if(com.com_excited_mine)
					{ 
						exciting = 'Unexciting'; 
						fun = 'action.responsed(this)';
					} 
					postid.children().eq(1).children().eq(3).append('<div class="cclass_json" id="'+comid+'" data="'+ com.com_actionid +'" ><a href="profile.php?id=' +com.commentby+ '" target="_parent"><img class="lfloat" src =' +pimage[com.commentby]+ ' height="32" width="32" /></a><div class="name_35"><div><a class="bold" style="margin-right:0.4em;" href="profile.php?id=' +com.commentby+ '" target="_parent">' +name[com.commentby]+ '</a><pre>'+ui.see_more(ui.get_smiley(ui.link_highlight(com.comment)))+'</pre></div><div><a class="comment_time_json" href="action.php?actionid='+value.pageid+'&life_is_fun='+value.life_is_fun+'"><img src="http://icon.qmcdn.net/clock.png" width="6" /><span class="time" data="'+com.com_time+'">'+time_difference(com.com_time)+'</span></a><span data=' +com.commentby+ ' class = "comment_excite_json" onclick="'+fun+'">'+exciting+'</span></div></div></div>');
				
				
					if(com.com_excited)
					{
						$("#"+comid).children().eq(1).children().eq(1).append('<span style="margin-left:0.5em;font-size:0.9em;cursor:pointer;" data="'+ com.com_excited +'" onclick="action.response_fetch(this)" >'+ com.com_excited +' excited</span>');
					} 
					else 
					{
						$("#"+comid).children().eq(1).children().eq(1).append('<span style="margin-left:0.5em;font-size:0.9em;cursor:pointer;" data="0" class="more_excite_json" onclick="action.response_fetch(this)"></span>');
					}
					
					if(value.postby == myprofileid || com.remove == 1)
					{
						$("#"+comid).append('<span onclick="ui.post_delete(this)" class="comment_setting">x</span>');	
					}
				});
			}
			
			function comment_box(value,pimage,myprofileid,dom_id)
			{ 
				var postid = $('#'+dom_id);
				var myphoto = $('#myprofileimage_hidden').attr('value');
				postid.children().eq(1).children().eq(3).append('<div></div><div class="cclass_box" ><a href="profile.php?id=' +myprofileid+ '"><img class="lfloat" src="'+myphoto+'"  width="32" height="32"/></a><textarea class="commentbox" style="margin:0em 0em 0em 0.5em;" placeholder="Add a comment..." onkeydown="action.comment(this, event)"></textarea></div>');
			}
			
			return {
				news_deploy : news_deploy,
			}
			
		})();