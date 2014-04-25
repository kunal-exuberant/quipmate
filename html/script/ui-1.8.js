		
var ui = (function(){
	
			bring = true;
			function page_call(page)
			{
				if(page == 'search') 
				{
					action.search();
					action.friend_suggest(this,6);
				}
				else if(page=='analytics')
				{
				
				action.getanalyticdetails(this,'daily');
				}
				else if(page == 'group_json' || page == 'member' || page == 'group_about' || page == 'group_settings')
				{
					action.group_suggest(this,6);
					action.member_request_fetch();
					action.group_top_influencer(this);
				}
				else if(page == 'page_json' || page == 'Followers' || page == 'page_about' || page == 'page_settings')
				{
					//action.page_suggest(this,6);
				}
				else if(page == 'friend_suggest')
				{ 
					action.friend_suggest_page(this,16);
				}
				else if(page == 'group_suggest')
				{
					action.group_suggest_page(this,16);
				}
				else if(page == 'event_json' || page == 'guest' || page == 'event_about' || page == 'event_settings')
				{
					action.event_suggest(this,6);
				}
				else if(page == 'inbox')
				{
					$('.right_item').remove();
					$('html').css('overflow','hidden')
					$('#left').html('');
					$('#left').css('top','auto');
					$('#left').append('<h1 style="color:gray;">Messages</h1>');
					$('#left').append('<div id="show_inbox"></div>');
					$('#show_inbox').css('height',$(window).height()-100);
					$('#left').css('width','206');
					$('#show_inbox').css('overflow','auto');
					action.message_recent_fetch();
					action.actiontype_preview();
				} 
				else if(page == 'friend' || page == 'bio' || page == 'pphoto' || page == 'profile_json')
				{
					action.friend_match();
					action.friend_suggest(this,6);
					action.actiontype_preview();
				}
				else if(page == 'news_json' || page == 'photo' || page == 'new_user' || page == 'college_mate' || page == 'notice_json')
				{
					action.friend_suggest(this,6);
					ui.friend_invite();
					action.actiontype_preview();
					action.birthday_fetch(this);
				}
				else if(page=='analytics')
				{
					//alert('analytics');
					action.analytics();
				}
				else
				{
				
				}
			}
			
			function preview_doc(file)
			{
				window.location = "http://docs.google.com/"+file;
			}
	
			function birthday_bomb(me, profileid, date, pageid,event)
			{
				if(navigator.appName == 'Microsoft Internet Explorer')
				{
					event.cancelBubble = true
				}
				else
				{
					event.stopPropagation();
				}
				$('.right_pointer_container').remove();
		$('body').append('<div class="right_pointer_container"><div class="right_item_pointer"></div></div>');
			$('.right_pointer_container').css('top',$(this).parent().position().top+50+'px');
			$('.right_pointer_container').css('left',$('#search_form').position().left+285+'px');			
			$('.right_pointer_container').append('<div id="birthday_wish_container"><input type="hidden" id="birthday_wish_profileid_hidden" value=""/></div>');
			$('#birthday_wish_container').append('<div class="right_pointer_title">Send Birthday Wish with Birthday Bomb</div>');
		$('#birthday_wish_container').append('<div style="margin-top:1em;"><input style="padding:0.5em;height:1.4em;width:26em;" id="birthday_wish_box" type="text" placeholder="Write birthday wish"/></div>');
		$('#birthday_wish_container').append('<div style="margin-top:0.8em;"><input style="width:6em;height:2em;background:#336699;color:#ffffff;cursor:pointer;" type="submit" value="Wish" id="wish_ok" /><input style="margin-left:100px;width:6em;height:2em;background:#336699;color:#fff;cursor:pointer;" type="submit" value="Cancel" id="birthday_wish_close" /></div>');
		$('#birthday_wish_box').focus();
			}
			
			function birthday_wish_close()
			{
				$('.right_pointer_container').remove();
			}

			function disable_upload_area()
			{
				var nodes = document.getElementById("upload_box").getElementsByTagName('*');
				for(var i = 0; i < nodes.length; i++)
				{
					nodes[i].disabled = true;
				}
			}

			function enable_upload_area()
			{
				var nodes = document.getElementById("upload_box").getElementsByTagName('*');
				for(var i = 0; i < nodes.length; i++)
				{
					nodes[i].disabled = false;
				}
			}	
			
			function group_question()
			{
				$('#uploader').html('<textarea id="question_box" placeholder="Ask your question"/></textarea><input id="question_button" type="submit" value="Ask" onclick="action.group_question_button(this)"><div class="option_container"><input type="text" placeholder="+Add option by pressing enter" value="" class="option_add" onkeydown="action.option(this,event)"><div>'); 
				$('#question_box').focus();
			}
			
			function redirect_friend_suggest()
			{
				window.location = 'register.php?hl=friend_suggest';
			}
			
			function redirect_group_suggest()
			{
				window.location = 'register.php?hl=group_suggest';
			}
			
			function redirect_to_action(actionid,life_is_fun)
			{
				window.location = 'action.php?actionid='+actionid+'&life_is_fun='+life_is_fun;
			}
			
			function close()
			{
				$('.container').remove();
				$('.bg_hide_cover').remove(); 
			}
	
			function friend_invite()
			{
				$('#friend_invite').html('<div class="subtitle" >Invite A Friend To Join Quipmate</div>');
				$('#friend_invite').append('<div><input type="text" style="border:0.1em solid #aaaaaa;width:14.6em;height:1.2em;padding:0.5em;margin-right:0.2em;" id="invite_box" value="" placeholder="Enter an email address" /><input type="submit" title="Invite A Friend" id="invite_button" value="Invite" onclick="action.friend_invite(this)" /></div>');
			}
			
			function page_init(page,param)
			{
				if(page == 'news_json')
				{
					param.action = 'news_feed';
					increment = 10;
					$('#center').append('<div id="news_poll"></div>');
					$('#center').append('<div id="prev"></div>');
					$('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Updates" />');
				} 
				else if(page == 'admin_json')
				{
					param.action = 'admin_feed';
					increment = 10;
					$('#center').append('<div id="news_poll"></div>');
					$('#center').append('<div id="prev"></div>');
					$('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Updates" />');
				}
				else if(page == 'tech_json')
				{
					param.action = 'technical_feed_fetch';
					increment = 10;
					$('#center').append('<div id="news_poll"></div>');
					$('#center').append('<div id="prev"></div>');
					$('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Updates" />');
				}
				else if(page == 'notice_json')
				{
					param.action = 'notice_fetch';
					increment = 10;
					$('#center').append('<div id="prev"><h1 class="page_title">All Notifications</h1></div>');
					$('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Notices" />');
				}
				else if(page == 'action')
				{ 
					param.action = 'action_fetch';
					param.actionid = $('#actionid_hidden').attr('value');
					param.life_is_fun = $('#life_is_fun_hidden').attr('value');
					increment = 10;
					$('#center').append('<div id="prev"></div>');
				}
				else if(page == 'profile_json')
				{
					param.action = 'profile_feed';
					param.profileid = $('#profileid_hidden').attr('value');
					increment = 10;
					$('#center').append('<div id="prev"></div>');
					$('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Diary Entry" />');
				}
				else if(page == 'group_json')
				{
					param.action = 'group_feed';
					param.groupid = $('#profileid_hidden').attr('value');
					increment = 10;
					$('#center').append('<div id="prev"></div>');
					$('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Group Posts" />');
				}
				else if(page == 'page_json')
				{
					param.action = 'page_feed';
					param.pageid = $('#profileid_hidden').attr('value');
					increment = 10;
					$('#center').append('<div id="prev"></div>');
					$('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Page Posts" />');
				}
				else if(page == 'event_json')
				{
					param.action = 'event_feed';
					param.eventid = $('#profileid_hidden').attr('value');
					increment = 10;
					$('#center').append('<div id="prev"></div>');
					$('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Event Posts" />');
				}
				else if(page == 'album')
				{
					param.action = 'pin_fetch';
					increment = 10;
					var profile_name = $('#myprofilename_hidden').attr('value');
					$('#center').remove();
					$('#left').remove();
					$('#right').remove();
					$('body').css('background','#E7EBF2');
					$('body').append('<div style="position:absolute;left:2em;top:5em;width:21em" id="tr0"></div><div style="position:absolute;left:24em;top:5em;width:21em" id="tr1"></div><div style="position:absolute;left:46em;top:5em;width:21em" id="tr2"></div><div style="position:absolute;left:68em;top:5em;width:21em" id="tr3"></div><div style="position:absolute;left:90em;top:5em;width:21em" id="tr4"></div>');
				}
				else if(page == 'photo')
				{
					param.action = 'photo_friend_fetch';
					increment = 25;
					var profile_name = $('#myprofilename_hidden').attr('value');
					$('#center').append('<div id="prev"></div>');
					$('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Photo" />');
					$('#prev').append('<h1 class="page_title">'+profile_name+' - Friends - Photo</h1>');
					$('#prev').append('<table style="padding:1.5em;"></table>');
				}  
				else if(page == 'pphoto')
				{
					param.action = 'photo_fetch';
					param.profileid = $('#profileid_hidden').attr('value');
					increment = 25;
					var profile_name = $('#profilename_hidden').attr('value');
					$('#center').append('<div id="prev"></div>');
					$('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Photo" />');
					$('#prev').append('<h1 class="page_title">'+profile_name+' - Photo</h1>');
					$('#prev').append('<table style="padding:1.5em;"></table>');
				}
				else if(page == 'college_mate')
				{
					param.action = 'people_fetch';
					param.college = 'college';
					increment = 10;
					$('#center').append('<h1 class="page_title">People having same college as you</h1>');	
				}
				else if(page == 'new_user')
				{
					param.action = 'people_fetch';
					param.new_user = 'new_user';
					increment = 10;
					$('#center').append('<h1 class="page_title">People Who Recently Joined Quipmate</h1>');	
				}
				else if(page == 'friend')
				{
					param.action = 'friend_load';
					param.profileid = $('#profileid_hidden').attr('value');
					increment = 50;
					var profile_name = $('#profilename_hidden').attr('value');
					$('#center').append('<div id="prev"></div>');
					$('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Friends" />');
					$('#prev').append('<h1 class="page_title">'+profile_name+' - Friends</h1>');
				}
				else if(page == 'member')
				{
					param.action = 'member_load';
					param.groupid = $('#profileid_hidden').attr('value');
					increment = 50;
					var profile_name = $('#profilename_hidden').attr('value');
					$('#center').append('<div id="prev"></div>');
					$('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Members" />');
					$('#prev').append('<h1 class="page_title">Group Members</h1>');
				}
				else if(page == 'guest')
				{
					param.action = 'guest_load';
					param.eventid = $('#profileid_hidden').attr('value');
					increment = 50;
					var profile_name = $('#profilename_hidden').attr('value');
					$('#center').append('<div id="prev"></div>');
					$('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Guests" />');
					$('#prev').append('<h1 class="page_title">Guests</h1>');
				}
				else if(page == 'inbox')
				{
					param.action = 'message_fetch';
					param.profileid = $('#profileid_hidden').attr('value');
					var profileid = $('#profileid_hidden').attr('value');
					var myprofileid = $('#myprofileid_hidden').attr('value');
					var profileid_name = $('#profilename_hidden').attr('value');
					var myprofileid = $('#myprofileid_hidden').attr('value');
					var myprofileid_name = $('#myprofilename_hidden').attr('value');
					var myprofileid_image = $('#myprofileimage_hidden').attr('value');
					var showuser ;
					param.profileid = profileid;
					$('#center').append('<div id="inbox_container"></div>');
				}
			}
			
			
			function praise(me)
			{	
				$('.right_pointer_container').remove();
				$('body').append('<div class="right_pointer_container"><div class="right_item_pointer"></div></div>');	
				$('.right_pointer_container').css('top',$(me).parent().position().top+54+'px');
				$('.right_pointer_container').css('left',$('#search_form').position().left+110+'px');					
				$('.right_pointer_container').append('<div id="direct_to_md__container" style="width:45em;height:32em;"><input type="hidden" id="birthday_wish_profileid_hidden" value=""/></div>');
				$('#direct_to_md__container').append('<div class="right_pointer_title">Publically praise for outstanding work</div>');
				$('#direct_to_md__container').append('<div style="margin-top:1em;"><input style="padding:0.5em;height:1.4em;width:32em;" id="letter_title" type="text" placeholder="What is the outstanding contribution?"/></div><div style="margin-top:1em;"><textarea placeholder="Word of applause" id="letter_content" style="padding:0.5em;height:16em;width:32em;resize:none;"></textarea></div>');
				$('#direct_to_md__container').append('<div style="margin-top:0.8em;"><input class="prompt_negative" type="submit" value="Cancel" id="birthday_wish_close" /><input class="group_create_positive" type="submit" value="Praise" id="letter_send" /></div>');
				$('#birthday_wish_box').focus();
				$('#birthday_wish_close').live('click',function(){
					$('.right_pointer_container').remove();
				});		

				$('#letter_send').live('click',function(){
					var wish = $('#birthday_wish_box').val();
					if(wish !='')
					{
						$('#letter_send').hide();
						var letter_title = $('#letter_title').attr('value');
						var letter_content = $('#letter_content').val();
						$('#direct_to_md__container').html('<span>Sending...</span>');	
						var profileid = $('#profileid_hidden').attr('value');
						$.getJSON('ajax/write.php',{action:'praise',letter_title:letter_title,letter_content:letter_content,profileid:profileid},function(data){
						if(data.ack) 
						{
							$('#direct_to_md__container').html('Your have successfully priased !');
							$('.right_pointer_container').fadeOut(2000);
						}	
						});
					}	
				});						
			}
			
			
			function direct_to_md(me)
			{	
				$('.right_pointer_container').remove();
				$('body').append('<div class="right_pointer_container"><div class="right_item_pointer"></div></div>');
				$('.right_pointer_container').css('top',$(me).parent().position().top+54+'px');
				$('.right_pointer_container').css('left',$('#search_form').position().left+110+'px');			
				$('.right_pointer_container').append('<div id="direct_to_md__container" style="width:45em;height:32em;"><input type="hidden" id="birthday_wish_profileid_hidden" value=""/></div>');
				$('#direct_to_md__container').append('<div class="right_pointer_title">Direct Letter to the Managing Director</div>');
				$('#direct_to_md__container').append('<div style="margin-top:1em;"><input style="padding:0.5em;height:1.4em;width:32em;" id="letter_title" type="text" placeholder="What is this letter about?"/></div><div style="margin-top:1em;"><textarea placeholder="Letter Content" id="letter_content" style="padding:0.5em;height:16em;width:32em;resize:none;"></textarea></div><div style="margin-top:1em;"><input id="letter_open" type="checkbox" checked/>Open Letter</div>');
				$('#direct_to_md__container').append('<div style="margin-top:0.8em;"><input class="prompt_negative" type="submit" value="Cancel" id="birthday_wish_close" /><input class="group_create_positive" type="submit" value="Send Letter" id="letter_send" /></div>');
				$('#birthday_wish_box').focus();
				$('#birthday_wish_close').live('click',function(){
					$('.right_pointer_container').remove();
				});		

				$('#letter_send').live('click',function(){
					var wish = $('#birthday_wish_box').val();
					if(wish !='')
					{
						$('#letter_send').hide();
						var letter_title = $.trim($('#letter_title').attr('value'));
						var letter_content = $.trim($('#letter_content').val());
						var letter_open = 0;
						if($('#letter_open:checked').length == 1)
							letter_open = 1;
						if(letter_content != '' && letter_title != '')
						{	
							$('#direct_to_md__container').html('<span>Sending...</span>');	
							$.getJSON('ajax/write.php',{action:'direct_letter',letter_title:letter_title,letter_content:letter_content,letter_open:letter_open},function(data){
							if(data.ack) 
							{
								$('#direct_to_md__container').html('Letter has been sent to the Managaing director.');
								$('.right_pointer_container').fadeOut(2000);
							}	
							});
						}
					}	
				});						
			}
			
			function group_friend_invite(me)
			{
				$('#group_invite_info').html('');
				$('#group_friend_invite').html('');
				var global_name = JSON.parse($('#myfriends_name_hidden').attr('value'));
				var global_pimage = JSON.parse($('#myfriends_pimage_hidden').attr('value'));
				var count = 0;
				var q = $.trim($(me).val());
				if(q != '')
				{
					$.each(global_name,function(index,value){
					   if(value != null)
					   {
							if(q.indexOf(' ') == -1)
							{
								var search_name = value.toLowerCase().split(" ");
								for(var i=0;i<search_name.length;i++)
								{		
									if((count < 5) && (search_name[i].toLowerCase().search('^'+q.toLowerCase()) != -1)) 
									{
										$('#group_invite_'+index).remove();
										$('#group_friend_invite').append('<div class="container_50" onclick="action.group_invite(this)" id="group_invite_'+index+'" data="'+index+'"><img class="lfloat" src='+global_pimage[index]+' width="50" height="50" /><div class="name_50">'+global_name[index]+'</div></div>');
										$('.search_items:first').css('background','#336699');
										$('.search_items:first .name_50 a').css('color','white');
										count++;
									}

								}
							}
							else
							{
								if((count < 5) && (value.toLowerCase().search('^'+q.toLowerCase()) != -1)) 
								{
									$('#group_invite_'+index).remove();
									$('#group_friend_invite').append('<div class="container_50" onclick="action.group_invite(this)" id="group_invite_'+index+'" data="'+index+'"><img class="lfloat" src='+global_pimage[index]+' width="50" height="50" /><div class="name_50">'+global_name[index]+'</div></div>');
									$('.search_items:first').css('background','#336699');
									$('.search_items:first .name_50 a').css('color','white');
									count++;
								}
							}	
						}		
					});
				}
			}
			
			
		function createMessageUI(user, name)
		{
			$('#inbox_container').append('<div id="inbox_'+user+'" class="inboxui" ><input type="hidden" value="'+user+'"/><span ></span><div class="inboxui_title"></div><div class="inboxui_msg"></div><textarea class="sendbox" onkeypress="action.message_send(this,event)"></textarea><input type="hidden" value="10"/></div>');
			$('.inboxui_msg').css('height',$(window).height()-150);
			$('.inboxui_msg').css('overflow','auto');
			$('#inbox_'+user).children().eq(4).focus();
			lastScrollTopinbox = $('#inbox_'+user).children().eq(3).get(0).scrollTop;
			$('#inbox_'+user).children().eq(3).scroll(function(){messagebox_scroll(user)});
		}
		
		function messagebox_scroll(user)
		{ 
			var chat_start = parseInt($('#inbox_'+user).children().eq(5).attr('value'));
			if($('#inbox_'+user).children().eq(3).get(0).scrollTop  < $('#inbox_'+user).children().eq(3).get(0).scrollHeight * 0.1 && chat_load)
			{
				var st=$('#inbox_'+user).children().eq(3).get(0).scrollTop;
				if(st < lastScrollTopinbox)
				{
					chat_load = false;
					action.previous_talk_message(user, chat_start, 0);
					chat_start += 10;
					$('#inbox_'+user).children().eq(5).attr('value',chat_start);
				}
			}
			lastScrollTopinbox = st;
		}
		
		function message_leave_shrink()
		{
			$('#message_leave').html('<div id="message_leave_title" onclick="ui.message_leave_grow(this)"  style="height:1.5em;cursor:pointer;font-size:1.2em;padding:0.5em;background-color:#336699;color:#ffffff;font-weight:bold;">Leave a message<img src="http://icon.qmcdn.net/downarrow.gif" style="float:right;" /></div>');
		}
		
		function message_leave_grow()
		{
			$('#message_leave').css('width','24em');
			$('#message_leave').html('<div id="message_leave_title" onclick="ui.message_leave_shrink(this)" style="height:1.5em;cursor:pointer;font-size:1.2em;padding:0.5em;background-color:#336699;color:#ffffff;font-weight:bold;">Leave a message<img src="http://icon.qmcdn.net/downarrow.gif" style="float:right;" /></div>');
			$('#message_leave').append('<div style="padding:1em;"><input style="border:0.1em solid #cccccc;height:2em;padding:0.4em;width:20em;" placeholder="Name" type="text" value=""/></div>');
			$('#message_leave').append('<div style="padding:1em;"><input style="border:0.1em solid #cccccc;height:2em;padding:0.4em;width:20em;"  placeholder="Email"  type="text" value=""/></div>');
			$('#message_leave').append('<div style="padding:1em;"><input style="border:0.1em solid #cccccc;height:2em;padding:0.4em;width:20em;"  placeholder="Contact No"  type="text" value=""/></div>');
			$('#message_leave').append('<div style="padding:1em;"><textarea style="border:0.1em solid #cccccc;height:6em;padding:0.4em;width:20em;" placeholder="Message" ></textarea></div>');
			$('#message_leave').append('<div style="padding:1em;"><input style="border:0.1em solid #cccccc;background-color:#336699;color:#ffffff;font-weight:bold;height:3em;padding:0.4em;width:6em;" type="submit" value="Send"/></div>');
		}
			
			function event_friend_invite(me)
			{
				$('#group_invite_info').html('');
				$('#group_friend_invite').html('');
				var global_name = JSON.parse($('#myfriends_name_hidden').attr('value'));
				var global_pimage = JSON.parse($('#myfriends_pimage_hidden').attr('value'));
				var count = 0;
				var q = $.trim($(me).val());
				if(q != '')
				{
					$.each(global_name,function(index,value){
					   if(value != null)
					   {
							if(q.indexOf(' ') == -1)
							{
								var search_name = value.toLowerCase().split(" ");
								for(var i=0;i<search_name.length;i++)
								{		
									if((count < 5) && (search_name[i].toLowerCase().search('^'+q.toLowerCase()) != -1)) 
									{
										$('#event_invite_'+index).remove();
										$('#group_friend_invite').append('<div class="container_50" onclick="action.event_invite(this)" id="event_invite_'+index+'" data="'+index+'"><img class="lfloat" src='+global_pimage[index]+' width="50" height="50" /><div class="name_50">'+global_name[index]+'</div></div>');
										$('.search_items:first').css('background','#336699');
										$('.search_items:first .name_50 a').css('color','white');
										count++;
									}

								}
							}
							else
							{
								if((count < 5) && (value.toLowerCase().search('^'+q.toLowerCase()) != -1)) 
								{
									$('#event_invite_'+index).remove();
									$('#group_friend_invite').append('<div class="container_50" onclick="action.event_invite(this)"  id="event_invite_'+index+'" data="'+index+'"><img class="lfloat" src='+global_pimage[index]+' width="50" height="50" /><div class="name_50">'+global_name[index]+'</div></div>');
									$('.search_items:first').css('background','#336699');
									$('.search_items:first .name_50 a').css('color','white');
									count++;
								}
							}	
						}		
					});
				}
			}
			
			function suggest_deploy(me, data)
			{
				var i =1;
				var con_name;
				$.each(data.action,function(index,value){
				con_name = '#'+'suggest_container'+i;
				$(con_name).html('<div class="people" id="suggest_'+value.profileid+'" data="'+value.profileid+'" ><a href="profile.php?id='+value.profileid+'"><img class="lfloat" src='+data.pimage[value.profileid]+' height="35" width="35" /></a><div class="name_35"><a style="font-weight:bold;"href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_add_friend" onclick="action.really_add_friend(this)" >+Friend</span></div></div></div>');
				i++;
				});
			}
			
			function suggest_deploy_page(me, data)
			{
				var i =1;
				var con_name;
				if(data.action.length > 0)
				{
					$.each(data.action,function(index,value){
						con_name = '#'+'suggest_container'+i;
						$(con_name).html('<div class="people" id="suggest_'+value.profileid+'" data="'+value.profileid+'" ><a href="profile.php?id='+value.profileid+'"><img class="lfloat" src='+data.pimage[value.profileid]+' height="80" width="80" /></a><div class="name_80"><a style="font-weight:bold;"href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_add_friend" onclick="action.really_add_friend_page(this)" >+Friend</span></div></div></div>');
						i++;
					});
				}
				else
				{
					$('#friend_suggest').html('<div style="text-align:center;margin-top:5em;">No suggestions to show !</div>');
				}
			}
			
			function group_suggest_page_deploy(me, data)
			{
				var i =1;
				var con_name;
				if(data.action.length > 0)
				{
					$.each(data.action,function(index,value){
					con_name = '#'+'group_suggest_container'+i;
					$(con_name).html('<div class="people" id="group_suggest_'+value.profileid+'" data="'+value.profileid+'" ><a href="profile.php?id='+value.profileid+'"><img class="lfloat" src='+data.pimage[value.profileid]+' height="80" width="80" /></a><div class="name_80"><a style="font-weight:bold;"href="group.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_group_join" onclick="action.really_group_join(this)" >+Join Group</span></div></div></div>');
					i++;
					});
				}
				else
				{
					$('#group_suggest').html('<div style="text-align:center;margin-top:4em;">No suggestions to show !</div>');
					$('#group_suggest').append('<div style="text-align:center;margin-top:1em;">Create a group to get started !</div>');
				}
			}
			
			function group_suggest_deploy(me, data)
			{
				var i =1;
				var con_name;
				$.each(data.action,function(index,value){
				con_name = '#'+'group_suggest_container'+i;
				$(con_name).html('<div class="people" id="group_suggest_'+value.profileid+'" data="'+value.profileid+'" ><a href="profile.php?id='+value.profileid+'"><img class="lfloat" src='+data.pimage[value.profileid]+' height="35" width="35" /></a><div class="name_35"><a style="font-weight:bold;"href="group.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_group_join" onclick="action.really_group_join(this)" >+Join Group</span></div></div></div>');
				i++;
				});
			}
			
			function event_suggest_deploy(me, data)
			{
				var i =1;
				var con_name;
				$.each(data.action,function(index,value){
				con_name = '#'+'event_suggest_container'+i;
				$(con_name).html('<div class="people" id="event_suggest_'+value.profileid+'" data="'+value.profileid+'" ><a href="event.php?id='+value.profileid+'"><img class="lfloat" src='+data.pimage[value.profileid]+' height="35" width="35" /></a><div class="name_35"><a style="font-weight:bold;"href="event.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_going_event" onclick="action.really_going_event(this)" >+Going</span></div></div></div>');
				i++;
				});
			}
			
			function upload_default_state()
			{
				$('#uploader').html('<input type="text" id="status_box" value="" placeholder="What \'s going in your life?"/><input id="link_button" type="submit" value="Share">');
				ui.enable_upload_area();
			}
			
			function response_comment(container,actionid,life_is_fun,time,myprofileid,myphoto)
			{
				$(container).children().eq(1).children().eq(3).append('<div class="time_tag_json"><span onclick="action.response(this)" class="response" style="color:#336699;">Exciting: </span><a href="action.php?actionid='+actionid+'&life_is_fun='+life_is_fun+'"><img src="http://icon.qmcdn.net/clock.png" width="6" /><span class="time" data="'+time+'">'+ui.time_difference(time)+'</span></a></div><div class="likeclass_json"><span class="excited_people"></span><span class="post_pointer"></span></div><div></div><div class="cclass_box" ><a href="profile.php?id=' +myprofileid+ '"><img class="lfloat" src="'+myphoto+'"  width="35" height="36"/></a><textarea class="commentbox" style="margin:0em 0em 0em 0.5em;" placeholder="Add a comment..." onkeyup="action.comment(this, event)"></textarea></div></div></div>');
				$(container).append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
			} 
			
			
			function suggest_single_deploy(me, data)
			{
				$.each(data.action,function(index,value){
				$(me).html('<div class="people" id="suggest_'+value.profileid+'" data="'+value.profileid+'" ><a href="profile.php?id='+value.profileid+'"><img class="lfloat" src='+data.pimage[value.profileid]+' height="35" width="35" /></a><div class="name_35"><a style="font-weight:bold;"href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_add_friend" onclick="action.really_add_friend(this)" >+Friend</span></div></div></div>');
				});
			}
			
			function file_upload(profileid, action)
			{
				$('#uploader').html('<div id="main_div"><input type="hidden" value="6"/><div></div><div style="margin:0.5em;"><Strong>Select a file on your computer</strong></div><div style="margin-top:15px 0 20 0px;"><div id="photo_preview"></div><form id="pform" method="post" enctype="multipart/form-data" action="/ajax/write.php"><textarea style="border:1px solid #cccccc;height:2.7em;padding:0.5em;margin:0.5em;" type="text" placeholder="Say something about this file" maxlength="200" id="photo_description" name="photo_description"/></textarea><input  size="30" type="file" name="photo_box" id="photo_box" /><input type="submit" name="upload" id="photo_upload_button" value="Upload"><input type="hidden" id="photo_hidden_profileid" name="photo_hidden_profileid" value="'+profileid+'"/><input type="hidden" name="action" value="'+action+'"/></form></div></div>');
				ui.enable_upload_area();
			}
			function OnProgress(event, position, total, percentComplete)
			{
				$("#main_div").html('<div id="progressbox" style="display:none;"><div id="progressbar"></div ><div id="statustxt">0%</div></div><div id="output"></div>');
				//Progress bar
				$('#progressbox').css({"display":"block"});
				$('#progressbar').css({"display":"block","width":percentComplete+'%',"background":"#4C66A4"});
				$('#statustxt').html(''+percentComplete+'%');
				if(percentComplete>50)
					{
						$('#statustxt').css({"color":"#fff"}); //change status text to white after 50%
					}
			}
			
			function album_upload(profileid)
			{
				$('#uploader').html('<div id="main_div"><input type="hidden" value="5"/><div></div><div style="margin:0.5em;"><Strong>Add multiple photo from your computer in an album</strong></div><div style="margin-top:15px 0 20 0px;"><div id="moment_preview"></div><form id="mform" method="post" enctype="multipart/form-data" action="/ajax/write.php"><input style="border:1px solid #cccccc;width:30em;height:1.5em;padding:0.5em;margin:0.5em;" type="text" value="" placeholder="Enter album name" maxlength="100" id="moment_name" name="moment_name"/><div  style="display:inline;" id="moment_photo_browser"><input size="40" type="file" class="mom" name="photo_box[]" id="photo_box" /></div><input  type="submit" name="upload" id="moment_upload_button" value="Upload"><input type="hidden" id="moment_hidden_profileid" name="moment_hidden_profileid" value="'+profileid+'"/><input type="hidden" id="moment_photo_count" name="moment_photo_count" value=""/><input type="hidden" name="action" value="album_upload"/></form></div></div>');
				ui.enable_upload_area();
			}
			function restore_action_field()
			{
				$('#uploader').html('<input type="text" id="status_box" value="" /><input id="link_button" type="submit" value="Share">');
			}
			function suggest_single_deploy_page(me, data)
			{
				$.each(data.action,function(index,value){
				$(me).html('<div class="people" id="suggest_'+value.profileid+'" data="'+value.profileid+'" ><a href="profile.php?id='+value.profileid+'"><img class="lfloat" src='+data.pimage[value.profileid]+' height="80" width="80" /></a><div class="name_80"><a style="font-weight:bold;"href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_add_friend" onclick="action.really_add_friend_page(this)" >+Friend</span></div></div></div>');
				});
			}
			
			function group_suggest_single_deploy(me, data)
			{ 
				$.each(data.action,function(index,value){
				$(me).html('<div class="people" id="suggest_'+value.profileid+'" data="'+value.profileid+'" ><a href="group.php?id='+value.profileid+'"><img class="lfloat" src='+data.pimage[value.profileid]+' height="35" width="35" /></a><div class="name_35"><a style="font-weight:bold;"href="group.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_add_friend" onclick="action.really_group_join_page(this)" >+Join Group</span></div></div></div>');
				});
			}
			
			function group_suggest_single_deploy_page(me, data)
			{

				$.each(data.action,function(index,value){
				$(me).html('<div class="people" id="suggest_'+value.profileid+'" data="'+value.profileid+'" ><a href="group.php?id='+value.profileid+'"><img class="lfloat" src='+data.pimage[value.profileid]+' height="80" width="80" /></a><div class="name_80"><a style="font-weight:bold;"href="group.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_add_friend" onclick="action.really_group_join_page(this)" >+Join Group</span></div></div></div>');
				});
			}
			
			function event_suggest_single_deploy(me, data)
			{
				$.each(data.action,function(index,value){
				$(me).html('<div class="people" id="suggest_'+value.profileid+'" data="'+value.profileid+'" ><a href="event.php?id='+value.profileid+'"><img class="lfloat" src='+data.pimage[value.profileid]+' height="35" width="35" /></a><div class="name_35"><a style="font-weight:bold;"href="event.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_add_friend" onclick="action.really_going_event(this)" >+Going</span></div></div></div>');
				});
			}
			
			function friend_suggest_close()
			{
				$('html').not('#friend_req').click(function(){
				$('#friend_req').remove();
				$('#center, #right , #left , #header').css("opacity","1");
				});
			}

			function group_create(me)
			{
				$('.group_create_container').remove();     
				$('.bg_hide_cover').remove();
				$('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
				$('body').append('<div class="group_create_container"><div class="group_create_title">Create a group</div><div class="group_create_content"><div id="group_info"></div><div><input type="text" id="group_name" style="margin: 1em 0em;padding:0.5em;" placeholder="Group name" value=""></div><div><textarea style="margin: 1em 0em;padding:0.5em;" id="group_description" placeholder="What is this group about ?"></textarea> </div><div style="margin:2em 0em;text-align:left;margin-left:15em;"><div style="margin:1em 0em;">Privacy: <select id="group_privacy"><option value="0">Public</option><option value="1">Private</option></select></div><div style="margin:1em 0em"><input type="checkbox" id="group_technical"> Technical</div></div><div class="group_create_button" style="margin-left:5em;"><input type="submit" onclick="ui.bg_hide()" value="Cancel" class="group_create_negative"><input style="margin:0em 1em" type="submit" onclick="action.group_create(this)" value="Create Group" class="group_create_positive"></div></div>');
			}
			function page_create(me)
			{
				$('.group_create_container').remove();     
				$('.bg_hide_cover').remove();
				$('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
				$('body').append('<div class="group_create_container"><div class="group_create_title">Create a new Page</div><div class="group_create_content"><div id="page_info"></div><div><input type="text" id="page_name" style="margin: 1em 0em;padding:0.5em;" placeholder="Page name" value=""></div><div><textarea style="margin: 1em 0em;padding:0.5em;" id="page_description" placeholder="What is this page about ?"></textarea> </div><div class="group_create_button" style="margin-left:5em;"><input type="submit" onclick="ui.bg_hide()" value="Cancel" class="group_create_negative"><input style="margin:0em 1em" type="submit" onclick="action.page_create(this)" value="Create Page" class="group_create_positive"></div></div>');
			}
			
			function group_event_create(me)
			{
				$('.group_create_container').remove();     
				$('.bg_hide_cover').remove();
				$('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
				$('body').append('<div class="group_create_container"><div class="group_create_title">Create event for this group</div><div class="group_create_content"><div id="group_info"></div><div><input type="text" id="event_name" style="margin: 1em 0em;padding:0.5em;width:20em;border:0.1em solid #aaaaaa;" placeholder="Event name" value=""></div><div><textarea style="margin: 1em 0em;padding:0.5em;" id="event_description" placeholder="Describe the event in few more words"></textarea></div><div style="margin:2em 0em;">When : <select id="event_day" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Day</option><option value="01">1</option><option value="02">2</option><option value="03">3</option><option value="04">4</option><option value="05">5</option><option value="06">6</option><option value="07">7</option><option value="08">8</option><option value="09">9</option><option value="10">10</option> <option value="11">11</option><option value="12">12</option><option value="01">13</option><option value="02">14</option><option value="03">15</option><option value="04">16</option><option value="05">17</option><option value="06">18</option><option value="07">19</option><option value="08">20</option><option value="09">21</option> <option value="10">22</option><option value="11">23</option><option value="12">24</option><option value="01">25</option><option value="02">26</option> <option value="03">27</option><option value="04">28</option> <option value="05">29</option><option value="04">30</option><option value="05">31</option></select><select id="event_month" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Month</option> <option value="01">JAN</option><option value="02">FEB</option><option value="03">MAR</option><option value="04">APR</option><option value="05">MAY</option><option value="06">JUN</option> <option value="07">JUL</option><option value="08">AUG</option> <option value="09">SEP</option><option value="10">OCT</option><option value="11">NOV</option> <option value="12">DEC</option></select><select id="event_year" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Year</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option></select><select id="event_time" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Time</option><option value="09:00:00">09:00 am</option><option value="09:30:00">09:30 am</option><option value="10:00:00">10:00 am</option><option value="10:30:00">10:30 am</option><option value="11:30:00">11:30 am</option><option value="12:00:00">12:00 pm</option><option value="12:30:00">12:30 pm</option><option value="13:00:00">01:00 pm</option><option value="13:30:00">01:30 pm</option><option value="14:00:00">02:00 pm</option><option value="14:30:00">02:30 pm</option><option value="15:00:00">03:00 pm</option><option value="15:30:00">03:30 pm</option><option value="16:00:00">04:00 pm</option><option value="16:30:00">04:30 pm</option><option value="17:00:00">05:00 pm</option><option value="17:30:00">05:30 pm</option><option value="18:00:00">06:00 pm</option><option value="18:30:00">06:30 pm</option><option value="19:00:00">07:00 pm</option><option value="19:30:00">07:30 pm</option><option value="20:00:00">08:00 pm</option><option value="20:30:00">08:30 pm</option><option value="21:00:00">09:00 pm</option><option value="21:30:00">09:30 pm</option><option value="22:00:00">10:00 pm</option><option value="22:30:00">10:30 pm</option><option value="23:00:00">11:00 pm</option><option value="23:30:00">11:30 pm</option><option value="00:00:00">12:00 am</option><option value="00:30:00">12:30 am</option><option value="01:00:00">01:00 am</option><option value="01:30:00">01:30 am</option><option value="02:00:00">02:00 am</option><option value="02:30:00">02:30 am</option><option value="03:00:00">03:00 am</option><option value="03:30:00">03:30 am</option><option value="01:00:00">01:00 am</option><option value="01:30:00">01:30 am</option><option value="02:00:00">02:00 am</option><option value="02:30:00">02:30 am</option><option value="03:00:00">03:00 am</option><option value="03:30:00">03:30 am</option><option value="04:00:00">04:00 am</option><option value="04:30:00">04:30 am</option><option value="05:00:00">05:00 am</option><option value="05:30:00">05:30 am</option><option value="06:00:00">06:00 am</option><option value="06:30:00">06:30 am</option><option value="07:00:00">07:00 am</option><option value="07:30:00">07:30 am</option><option value="08:00:00">08:00 am</option><option value="08:30:00">08:30 am</option></select></div><div>Where: <input type="text" id="event_where" value="" placeholder="Venue of this event" style="height:1.6em;padding:0.5em;width:22em"/></div><div style="margin:2em 0em;"><div style="margin:1em 0em;">Privacy: Only for members of this group</div></div><div class="group_create_button" style="margin-left:5em;"><input type="submit" onclick="ui.bg_hide()" value="Cancel" class="group_create_negative"><input style="margin:0em 1em" type="submit" onclick="action.group_event_create(this)" value="Create Event" class="group_create_positive"></div></div>');
			}
			
			function event_create(me)
			{
				$('.group_create_container').remove();     
				$('.bg_hide_cover').remove();
				$('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
				$('body').append('<div class="group_create_container"><div class="group_create_title">Create Event</div><div class="group_create_content"><div id="group_info"></div><div><input type="text" id="event_name" style="margin: 1em 0em;padding:0.5em;width:20em;border:0.1em solid #aaaaaa;" placeholder="Event name" value=""></div><div><textarea style="margin: 1em 0em;padding:0.5em;" id="event_description" placeholder="Describe the event in few more words"></textarea></div><div style="margin:2em 0em;">When : <select id="event_day" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Day</option><option value="01">1</option><option value="02">2</option><option value="03">3</option><option value="04">4</option><option value="05">5</option><option value="06">6</option><option value="07">7</option><option value="08">8</option><option value="09">9</option><option value="10">10</option> <option value="11">11</option><option value="12">12</option><option value="01">13</option><option value="02">14</option><option value="03">15</option><option value="04">16</option><option value="05">17</option><option value="06">18</option><option value="07">19</option><option value="08">20</option><option value="09">21</option> <option value="10">22</option><option value="11">23</option><option value="12">24</option><option value="01">25</option><option value="02">26</option> <option value="03">27</option><option value="04">28</option> <option value="05">29</option><option value="04">30</option><option value="05">31</option></select><select id="event_month" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Month</option> <option value="01">JAN</option><option value="02">FEB</option><option value="03">MAR</option><option value="04">APR</option><option value="05">MAY</option><option value="06">JUN</option> <option value="07">JUL</option><option value="08">AUG</option> <option value="09">SEP</option><option value="10">OCT</option><option value="11">NOV</option> <option value="12">DEC</option></select><select id="event_year" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Year</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option></select><select id="event_time" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Time</option><option value="09:00:00">09:00 am</option><option value="09:30:00">09:30 am</option><option value="10:00:00">10:00 am</option><option value="10:30:00">10:30 am</option><option value="11:30:00">11:30 am</option><option value="12:00:00">12:00 pm</option><option value="12:30:00">12:30 pm</option><option value="13:00:00">01:00 pm</option><option value="13:30:00">01:30 pm</option><option value="14:00:00">02:00 pm</option><option value="14:30:00">02:30 pm</option><option value="15:00:00">03:00 pm</option><option value="15:30:00">03:30 pm</option><option value="16:00:00">04:00 pm</option><option value="16:30:00">04:30 pm</option><option value="17:00:00">05:00 pm</option><option value="17:30:00">05:30 pm</option><option value="18:00:00">06:00 pm</option><option value="18:30:00">06:30 pm</option><option value="19:00:00">07:00 pm</option><option value="19:30:00">07:30 pm</option><option value="20:00:00">08:00 pm</option><option value="20:30:00">08:30 pm</option><option value="21:00:00">09:00 pm</option><option value="21:30:00">09:30 pm</option><option value="22:00:00">10:00 pm</option><option value="22:30:00">10:30 pm</option><option value="23:00:00">11:00 pm</option><option value="23:30:00">11:30 pm</option><option value="00:00:00">12:00 am</option><option value="00:30:00">12:30 am</option><option value="01:00:00">01:00 am</option><option value="01:30:00">01:30 am</option><option value="02:00:00">02:00 am</option><option value="02:30:00">02:30 am</option><option value="03:00:00">03:00 am</option><option value="03:30:00">03:30 am</option><option value="01:00:00">01:00 am</option><option value="01:30:00">01:30 am</option><option value="02:00:00">02:00 am</option><option value="02:30:00">02:30 am</option><option value="03:00:00">03:00 am</option><option value="03:30:00">03:30 am</option><option value="04:00:00">04:00 am</option><option value="04:30:00">04:30 am</option><option value="05:00:00">05:00 am</option><option value="05:30:00">05:30 am</option><option value="06:00:00">06:00 am</option><option value="06:30:00">06:30 am</option><option value="07:00:00">07:00 am</option><option value="07:30:00">07:30 am</option><option value="08:00:00">08:00 am</option><option value="08:30:00">08:30 am</option></select></div><div>Where: <input type="text" id="event_where" value="" placeholder="Venue of this event" style="height:1.6em;padding:0.5em;width:22em"/></div><div style="margin:2em 0em;"><div style="margin:1em 0em;">Privacy: <select id="event_privacy" style="height:2.6em;padding:0.5em;width:23.4em;"><option value="0">Public</option><option value="1">Private</option></select></div><div style="margin:2em 5em 0 0em;">Invite: <input type="checkbox" id="event_invite" checked> Guests can invite their friends</div></div><div class="group_create_button" style="margin-left:5em;"><input type="submit" onclick="ui.bg_hide()" value="Cancel" class="group_create_negative"><input style="margin:0em 1em" type="submit" onclick="action.event_create(this)" value="Create Event" class="group_create_positive"></div></div>');
			}
			
			function notice_scroll()
			{ 
				if($('#text').get(0).scrollTop > $('#text').get(0).scrollHeight * 0.1 && notice_load)
				{
					var st = $('#text').get(0).scrollTop;
					if (st > lastScrollTop)
					{
					notice_load = false;
					$.getJSON('ajax/write.php',{action:'notice_fetch',start:notice_start},function(data){
						notice_start += 10;
						notice_load = true;
						deploy.notice_deploy(data, '#text');
					});
					}
			    } 
				lastScrollTop = st;
			}

			function notice_fetch(me,event)
			{
				$(document).attr('title','Quipmate');
				$('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
				$('body').append('<div id="notice_container" data="notice"></div>');
				$('#notice_container').css('left',$('#search_form').position().left+391+'px');
				notice_start = 0;
				notice_load = true;
				$('#text').remove();
				$("#numnotice").html("");	
				$('#notice_container').append('<div id="notice_icon_pointer"></div><div id="notice_container_title" style = "background:#f5f5f5;cursor:pointer;font-weight:bold;color:#000000;font-size:1.1em;padding-left:1em;height: 1.4em;"><span>Top Notifications</span><span class= "seeall" style = "margin-right:0.5em;float:right;">See All</span></div><div id="text"><img id="loading" src="http://icon.qmcdn.net/loading.gif" alt="Loading..."></div><div class = "seeall" style = "background:#f5f5f5;color:#000000;cursor:pointer;font-weight:bold;height: 1.4em;" align ="center">See All Notifications</div>');
				$.getJSON('ajax/write.php',{action:'notice_fetch',start:'0'},function(data){
					notice_start = 10;
					$('#loading').remove();
					deploy.notice_deploy(data,'#text');
					$('.notice_drop').live('mouseover',function(){
					  var actionid = $(this).attr('id');
					});
				var lastScrollTop = $('#text').get(0).scrollTop;
					$('#text').scroll(notice_scroll);
				});				
			}
			function message_fetch(me,event)
			{
				$(document).attr('title','Quipmate');
				$('#text').remove();
				$("#message_count").html("");
				$('#notice_container').remove();	
				$('.bg_hide_cover').remove();
				$('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
				$('body').append('<div id="notice_container" data="message"></div>');
				$('#notice_container').css('left',$('#search_form').position().left+355+'px');
				$('#notice_container').append('<div id="notice_icon_pointer"></div><div id="notice_container_title" style = "background:#f5f5f5;cursor:pointer;font-weight:bold;color:#000000;font-size:1.1em;padding-left:1em;"><span>All Messages</span><span class= "message_seeall" style = "margin-right:0.5em;float:right;">See All</span></div><div id="text"><img id="loading" src="http://icon.qmcdn.net/loading.gif" alt="Loading..."></div><div class = "message_seeall" style = "background:#f5f5f5;color:#000000;cursor:pointer;font-weight:bold;" align ="center">See All Messages</div>');				
				$.getJSON('ajax/write.php',{action:'message_recent_fetch',start:'0'},function(data){
					$('#loading').remove();
					callback.message_recent_fetch('#bring_message',data,'#text');
					$('.notice_drop').live('mouseover',function(){
					  var actionid = $(this).attr('id');
					});
				});	
			}
			
			function request_fetch(me,event)
			{
				$(document).attr('title','Quipmate');
				$('#text').remove();
				$("#request_count").html("");
				$('#notice_container').remove();	
				$('.bg_hide_cover').remove();
				$('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
				$('body').append('<div id="notice_container" data="fr_missu_ei"></div>');
				$('#notice_container').css('left',$('#search_form').position().left+318+'px');
				$('#notice_container').append('<div id="notice_icon_pointer"></div><div id="notice_container_title" style = "background:#f5f5f5;cursor:pointer;font-weight:bold;color:#000000;font-size:1.1em;padding-left:1em;"><span>All Requests</span></div><div id="text"><img id="loading" src="http://icon.qmcdn.net/loading.gif" alt="Loading..."></div>');	
				$.getJSON('ajax/write.php',{action:'request_fetch',start:'0'},function(data){
					$('#loading').remove();
					callback.request_fetch('#bring_friend_request',data);
					$('.notice_drop').live('mouseover',function(){
					  var actionid = $(this).attr('id');
					});
				});	 
			}
			
			function menu(me,event)
			{				 
				if(navigator.appName == 'Microsoft Internet Explorer')
				{
					event.cancelBubble = true
				}
				else
				{
					event.stopPropagation();
				} 
				$('#account').remove();
				$('body').append('<div id="account" ></div>');
				$('#account').css('left',$('#search_form').position().left+661+'px');
				$('#account').append('<div id="menu_pointer"></div><div class="menu_each"><a class="menu_each_a"  href="profile.php?hl=bio">Edit Profile</a></div><div class="menu_each"><a class="menu_each_a"  href="register.php?hl=profile_picture">Change Profile Picture</a></div><div class="menu_each"><a class="menu_each_a" href="settings.php">Account Settings</a></div><div class="menu_each"><a class="menu_each_a" href="logout.php">Logout</a></div>'); 
			}
			
			function profile_post_privacy(me,event) 
			{ 
				if(navigator.appName == 'Microsoft Internet Explorer')
				{
					event.cancelBubble = true
				}
				else
				{
					event.stopPropagation();
				}
				 $('#profile_post_privacy_drop').remove();
				 var pleft = event.pageX-101+'px';
				 var ptop = event.pageY+17+'px';
				 $('body').append('<div id ="profile_post_privacy_drop" style="position:absolute;background-color:#ffffff;border:0.1em solid #cccccc;"><div id="menu_pointer"></div><div class="menu_each"><a class="menu_each_a" value="0" data="profile_post_next" onclick="action.profile_privacy_update(this)">Public</a></div><div class="menu_each"><a class="menu_each_a" value="1" data="profile_post_next" onclick="action.profile_privacy_update(this)">Friends of friends</a></div><div class="menu_each"><a class="menu_each_a"  value="2" data="profile_post_next" onclick="action.profile_privacy_update(this)">Friends</a></div></div>'); 
				 $('#profile_post_privacy_drop').css('left',pleft);
				 $('#profile_post_privacy_drop').css('top',ptop);
			}
			
			function bio_privacy(me,event,key)
			{
				if(navigator.appName == 'Microsoft Internet Explorer')
				{
					event.cancelBubble = true
				}
				else
				{
					event.stopPropagation();
				}
				 $('#profile_post_privacy_drop').remove();
				 var pleft = $(me).position().left+20+'px';
				 var ptop = $(me).position().top+70+'px';
				 $(me).parent().append('<div id ="profile_post_privacy_drop" style="position:absolute;background-color:#ffffff;border:0.1em solid #cccccc;"><div id="menu_pointer"></div><div class="menu_each"><a class="menu_each_a" value="0" data="'+key+'" onclick="action.profile_privacy_update(this)">Public</a></div><div class="menu_each"><a class="menu_each_a" value="1" data="'+key+'" onclick="action.profile_privacy_update(this)">Friends of friends</a></div><div class="menu_each"><a class="menu_each_a"  value="2" data="'+key+'" onclick="action.profile_privacy_update(this)">Friends</a></div></div>'); 
				 $('#profile_post_privacy_drop').css('left','24em');
				 $('#profile_post_privacy_drop').css('top','5em');
			}
			
			function gift_close(me)
			{
				$('#gift_container').remove();
			}			
			
			function gift_ui_create(rhis)
			{
				$('#gift_container').remove();
				$('.bg_hide_cover').remove();
				$('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
				$('body').append('<div id="gift_container" class="container" style="position:fixed;left:50%;margin-left:-29em;top:9em;background-color:#ffffff;width:38em;z-index:100;overflow:auto;"></div>');
				$('#gift_container').html('<div id="gift_title" style="font-weight:bold;color:#ffffff;font-size:1.3em;padding:0.5em 0em;background-color:#336699;text-align:center;">Chose a gift you like to send</div>');
				$('#gift_title').append('<div style="float:right;cursor:pointer;margin-right:0.5em;" class="close" onClick = "ui.close()">x</div>');
				$('#gift_container').append('<div id="gift_subpart" style="height:400px;scroll:auto;"><table><tr><td><img class="gift" onclick="ui.gift(this)" title="Holi Pichkari" id="30"src="http://image.qmcdn.net/holi_pichkari.gif"></td><td><img class="gift" onclick="ui.gift(this)" title="Holi Colors" id="31"src="http://image.qmcdn.net/holi_colors.jpg"></td><td><img class="gift" onclick="ui.gift(this)" title="Holi Gujiya" id="32"src="http://image.qmcdn.net/holi_gujiya.jpg"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)" title="Banana" id="1"src="http://image.qmcdn.net/banana.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Bangles" id="2"src="http://image.qmcdn.net/bangles.jpg"></td><td><img class="gift" onclick="ui.gift(this)" title="Beer" id="3"src="http://image.qmcdn.net/beer.jpg"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)" title="Bell" id="4"src="http://image.qmcdn.net/bell.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Bomb" id="5"src="http://image.qmcdn.net/bomb.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Cheeseburger" id="6"src="http://image.qmcdn.net/cheeseburger.png"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)" title="Chocolate" id="7"src="http://image.qmcdn.net/chocolate.jpg"></td><td><img class="gift" onclick="ui.gift(this)" title="Coffee" id="8"src="http://image.qmcdn.net/coffee.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Toothpaste" id="9"src="http://image.qmcdn.net/toothpaste.jpg"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)" title="Deodorant" id="10"src="http://image.qmcdn.net/deodorant.jpg"></td><td><img class="gift" onclick="ui.gift(this)" title="Dust bin" id="11"src="http://image.qmcdn.net/dust_bin.png"></td><td><img class="gift" onclick="ui.gift(this)"  id="12" title="	Fair and handsome"src="http://image.qmcdn.net/fair_and_handsome.jpg"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)" title="Fair and Lovely.jpg" id="13"src="http://image.qmcdn.net/	fair_and_lovely.jpg"></td><td><img class="gift" onclick="ui.gift(this)" title="Guitar" id="14"src="http://image.qmcdn.net/guitar.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Gun" id="15"src="http://image.qmcdn.net/gun.png"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)" title="Ice Cream" id="16"src="http://image.qmcdn.net/ice_cream.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Island" id="17"src="http://image.qmcdn.net/island.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Island with penguins" id="18"src="http://image.qmcdn.net/island_with_penguins.png"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)"  id="19" title="Lip stick"src="http://image.qmcdn.net/lip_stick.png"></td><td><img title="Makeup kit" class="gift" onclick="ui.gift(this)" id="20"src="http://image.qmcdn.net/makeup_kit.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Milk" id="21"src="http://image.qmcdn.net/milk.png"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)" title="Movie Ticket" id="22"src="http://image.qmcdn.net/movie_ticket.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Package" id="23"src="http://image.qmcdn.net/package.png"></td><td><img class="gift" onclick="ui.gift(this)"  title="Room cleaner" id="24"src="http://image.qmcdn.net/room_cleaner.png"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)"  id="25" title="Rose"src="http://image.qmcdn.net/rose.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Smile" id="26"src="http://image.qmcdn.net/smile.gif"></td><td><img class="gift" onclick="ui.gift(this)" title="Soap" id="27"src="http://image.qmcdn.net/soap.png"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)" title="Toast" id="28"src="http://image.qmcdn.net/toast.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Taj Mahal" id="29"src="http://image.qmcdn.net/taj_mahal.jpg"></td></tr></table></div>');
			}
					
			function mood(me)
			{
				$('#mood_container').remove();
				$('.bg_hide_cover').remove();
				$('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
				$('body').append('<div id="mood_container" class="container" style="position:fixed;left:50%;margin-left:-29em;top:9em;background-color:#ffffff;width:38em;z-index:100;overflow:auto;"></div>');
				$('#mood_container').html('<div id="mood_title" style="font-weight:bold;color:#ffffff;font-size:1.3em;padding:0.5em 0em;background-color:#336699;text-align:center;">How are you feeling?</div>');
				$('#mood_title').append('<div style="float:right;cursor:pointer;margin-right:0.5em;" onClick ="ui.mood_close()">x</div>');
				$('#mood_container').append('<div id="mood_subpart" style="height:400px;scroll:auto;overflow-y:scroll;"><table><tr><td><img onclick="ui.mood_click(this,1)" title="Angry" id="1"src="http://image.qmcdn.net/angry.png"></td><td><img onclick="ui.mood_click(this,2)" title="Big Smile" id="2"src="http://image.qmcdn.net/big_smile.png"></td><td><img onclick="ui.mood_click(this,3)" title="Chatty" id="3"src="http://image.qmcdn.net/chatty.png"></td></tr><tr><td><img onclick="ui.mood_click(this,4)" title="Dangerous" id="4"src="http://image.qmcdn.net/dangerous.png"></td><td><img onclick="ui.mood_click(this,5)" title="Devil" id="5"src="http://image.qmcdn.net/devil.png"></td><td><img onclick="ui.mood_click(this,6)" title="Doubtful" id="6"src="http://image.qmcdn.net/doubtful.png"></td></tr><tr><td><img onclick="ui.mood_click(this,7)" title="Dribbling" id="7"src="http://image.qmcdn.net/dribbling.png"></td><td><img onclick="ui.mood_click(this,8)" title="Exhausted" id="8"src="http://image.qmcdn.net/exhausted.png"></td><td><img onclick="ui.mood_click(this,9)" title="Feared" id="9"src="http://image.qmcdn.net/feared.png"></td></tr><tr><td><img onclick="ui.mood_click(this,10)" title="Foxy Lady" id="10"src="http://image.qmcdn.net/foxy_lady.png"></td><td><img onclick="ui.mood_click(this,11)" title="Green Bug" id="11"src="http://image.qmcdn.net/green_bug.png"></td><td><img onclick="ui.mood_click(this,12)" id="12" title="Happy"src="http://image.qmcdn.net/happy.png"></td></tr><tr><td><img onclick="ui.mood_click(this,13)" title="Hell Boy" id="13"src="http://image.qmcdn.net/hell_boy.png"></td><td><img onclick="ui.mood_click(this,14)" title="Hey Baby" id="14"src="http://image.qmcdn.net/hey_baby.png"></td><td><img onclick="ui.mood_click(this,15)" title="Kiss Me" id="15"src="http://image.qmcdn.net/kiss_me.png"></td></tr><tr><td><img onclick="ui.mood_click(this,16)" title="Naughty" id="16"src="http://image.qmcdn.net/naughty.png"></td><td><img onclick="ui.mood_click(this,17)" title="Ohhhhhh" id="17"src="http://image.qmcdn.net/ohhhhh.png"></td><td><img onclick="ui.mood_click(this,18)" title="Playing in Money" id="18"src="http://image.qmcdn.net/playing_in_money.png"></td></tr><tr><td><img title="Rapper" onclick="ui.mood_click(this,19)"  id="19"src="http://image.qmcdn.net/rapper.png"></td><td><img onclick="ui.mood_click(this,20)"  id="20" title="Sad"src="http://image.qmcdn.net/sad.png"></td><td><img onclick="ui.mood_click(this,21)" title="Shameful" id="21"src="http://image.qmcdn.net/shameful.png"></td></tr><tr><td><img onclick="ui.mood_click(this,22)" title="Smiling" id="22"src="http://image.qmcdn.net/smile.png"></td><td><img onclick="ui.mood_click(this,23)" title="Speaking" id="23"src="http://image.qmcdn.net/speaking.png"></td><td><img onclick="ui.mood_click(this,24)"  title="Surprised" id="24"src="http://image.qmcdn.net/surprised.png"></td></tr><tr><td><img onclick="ui.mood_click(this,25)"  id="25" title="Surrender"src="http://image.qmcdn.net/surrender.png"></td><td><img onclick="ui.mood_click(this,26)" title="Sweet Kiss" id="26"src="http://image.qmcdn.net/sweet_kiss.png"></td><td><img onclick="ui.mood_click(this,27)" title="Teasing" id="27"src="http://image.qmcdn.net/teasing.png"></td></tr><tr><td><img onclick="ui.mood_click(this,28)" title="Terrorist" id="28"src="http://image.qmcdn.net/terrorist.png"></td><td><img onclick="ui.mood_click(this,29)" title="Sad" id="29"src="http://image.qmcdn.net/sad.png"></td></tr></table></div>');
			}
			
			function message()
			{
				var profileid = $('#profileid_hidden').attr('value');
				var myname = $('#myprofilename_hidden').attr('value');
				var myprofileid = $('#myprofileid_hidden').attr('value');
				var myphoto = $('#myprofileimage_hidden').attr('value');
				$('#message_container').remove();
				$('.bg_hide_cover').remove();
				$('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
				$('body').append('<div id="message_container" style="position:fixed;left:50%;margin-left:-29em;top:9em;background-color:#ffffff;width:34em;z-index:100;overflow:auto;"></div>');
				$('#message_container').html('<div id="message_title" style="font-weight:bold;color:#ffffff;font-size:1.3em;padding:0.5em 0em;background-color:#4C66A4;text-align:center;">Write a Message</div>');
				$('#message_title').append('<div style="float:right;cursor:pointer;margin-right:0.5em;" onClick ="ui.message_close()">x</div>');
				$('#message_container').append('<div style="font-size:1.1em;padding:0.5em;"><textarea id="message_textarea" placeholder="Write a message ..." style="border:0.1em solid #cccccc;color:#808080;height:5em;padding:0.5em;resize:none;width:28em;"></textarea></div>');
				$('#message_container').append('<div style="margin: 1em 0em;"><input style="width:6.5em;height:3em;font-weight:bold;background-color:#4C66A4;color:#ffffff;cursor:pointer;border: 0.1em solid #FFFFFF;" type="submit" value="Cancel" class="message_ok" onclick="ui.message_close(this)" /><input style="margin-left:2em;font-weight:bold;width:6em;height:3em;background-color:#4C66A4;color:#ffffff;cursor:pointer;border: 0.1em solid #FFFFFF;" type="submit" value="Send" id="mood_done" onclick="action.message(this)"/></div>');
			}
			
			function message_close()
			{
				$('.bg_hide_cover').remove();
				$('#message_container').remove();
			}
			
			function tagline(me)
			{
				$('#tagline_container').remove();
				$('.bg_hide_cover').remove();
				$('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
				$('body').append('<div id="tagline_container" class="container" style="position:fixed;left:50%;margin-left:-29em;top:9em;background-color:#ffffff;width:38em;z-index:100;overflow:auto;"></div>');
				$('#tagline_container').html('<div id="tagline_title" style="font-weight:bold;color:#ffffff;font-size:1.3em;padding:0.5em 0em;background-color:#4C66A4;text-align:center;">What drives you today?</div>');
				$('#tagline_title').append('<div style="float:right;cursor:pointer;margin-right:0.5em;" onClick ="ui.tagline_close()">x</div>');
				$('#tagline_container').append('<div style="height:9em;scroll:auto;"><input style="margin-top:2em;padding:.5em;border:0.1em solid #cccccc;height:2.5em;width:29em;" id="tagline_box" type="text" maxlength="50" style="resize:none;height:30px;" placeholder="Write your tagline" /></div>');
				$('#tagline_container').append('<div style="margin: 1em 0em;"><input style="width:6.5em;height:3em;font-weight:bold;background-color:#4C66A4;color:#ffffff;cursor:pointer;border: 0.1em solid #FFFFFF;" type="submit" value="Cancel" class="mood_button" onclick="ui.tagline_close(this)" /><input style="margin-left:2em;font-weight:bold;width:12em;height:3em;background-color:#4C66A4;color:#ffffff;cursor:pointer;border: 0.1em solid #FFFFFF;" type="submit" value="Set My Tagline" id="mood_done" onclick="action.tagline(this)"/></div>');
				$('#tagline_box').focus();
			} 
			
			function tagline_close(me)
			{
				$('.bg_hide_cover').remove();
				$('#tagline_container').remove();
			}
			
			function gift(me)
			{
				var gift_id = $(me).attr('id');
				$('#gift_container').css('overflow','hidden');
				$('#gift_subpart').css('height','13em');
				$('#gift_subpart').html('<div><textarea id="gift_desc" style="margin:10px;padding:5px;height:5em;color:#333333; width:32em;resize:none;border-radius:0.2em;border:0.1em solid #cccccc;" placeholder="Add a gift message"></textarea></div>');
				$('#gift_subpart').append('<div style="margin-top:0.5em;"><input style="width:6.5em;height:3em;font-weight:bold;background-color:#336699;color:#ffffff;cursor:pointer;" type="submit" value="Cancel" class="gift_button" onclick="ui.gift_close(this)" /><input style="margin-left:2em;font-weight:bold;width:10em;height:3em;background-color:#336699;color:#ffffff;cursor:pointer;" type="submit" value="Send My Gift" id="gift_done" onclick="action.gift(this,'+gift_id+')"/></div>'); 
				
				$('#gift_desc').live('focus',function(){
					if($(this).attr('value') == "Add a gift message" )
					{
						$(this).attr('value','');
					}
				});
			}
			
			function mood_click(me, mood)
			{
				$('#mood_container').css('overflow','hidden');
				$('#mood_subpart').css('height','13em');
				$('#mood_subpart').html('<div><textarea id="mood_desc" style="margin:10px;padding:5px;height:5em;color:#333333; width:32em;resize:none;border-radius:0.2em;border:0.1em solid #cccccc;" placeholder="Describe your feelings"></textarea></div>');
				
				$('#mood_subpart').append('<div style="margin-top:0.5em;"><input style="width:6.5em;height:3em;font-weight:bold;background-color:#336699;color:#ffffff;cursor:pointer;" type="submit" value="Cancel" class="mood_button" onclick="ui.mood_close(this)" /><input style="margin-left:2em;font-weight:bold;width:10em;height:3em;background-color:#336699;color:#ffffff;cursor:pointer;" type="submit" value="Set My Mood" id="mood_done" onclick="action.mood_done(this,'+mood+')"/></div>'); 
				
				$('#mood_desc').live('focus',function(){
					if($(this).attr('value') == "Add few more words" )
					{
						$(this).attr('value','');
					}
				});
			}
				
			function mood_close()
			{
				$('#mood_container').remove();
				$('.bg_hide_cover').remove();
			}
			
			function photo_upload(me)
			{
				var profileid = $('#profileid_hidden').attr('value');
				$('#uploader').html('<div id="main_div"><input type="hidden" value="6"/><div></div><div style="margin:0.5em;"><Strong>Select a photo on your computer</strong></div><div style="margin-top:15px 0 20 0px;"><div id="photo_preview"></div><form id="pform" method="post" enctype="multipart/form-data" action="/ajax/write.php"><input  size="30" type="file" name="photo_box" id="photo_box" /><input style="background-color:#336699;color:#ffffff;height:2.4em;width:5em;cursor:pointer;padding:0.2em;" type="submit" name="upload" value="Upload" onclick="action.photo_upload()" ><input type="hidden" id="photo_hidden_profileid" name="photo_hidden_profileid" value="'+profileid+'"/><input type="hidden" id="action" name="action" value="photo_upload"/></form></div></div>');
			}
			
			function popup_close(me)
			{
				$(me).remove();
			}
			
			function song_dedicate_create_ui(me)
			{
				profileid = $(this).parent().children().eq(0).attr('value');
				$('body').append('<div id="bg_first" style="position:absolute;top:0em;left:0em;width:100%;height:190em;background:gray;opacity:0.5;filter:alpha(opacity=80);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=80)"; filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=80);"></div>');
				$('body').append('<div id="song_search_container" style="position:absolute;text-align:left;top:3.5em;left:28.5em;border:.5em solid gray;width:51.5em;height:55em;background:white;"></div>');
				$('#song_search_container').html('<div id="song_search_title" style="border-bottom:.1em solid gray;height:1.5em;background:#336699;color:#ffffff;font-weight:bold;padding:.5em;font-size:1.4em;">Search a song to dedicate</div>');
				$('#song_search_title').append('<span id="song_search_close" style="position:absolute;top:.5em;right:.5em;color:white;cursor:pointer;">x</span>');
				$('#song_search_container').append('<div id="song_search_box" style="position:relative;top:1em;left:2em;"><input id="song_dedicate_search_textbox" style="border:.1em solid #336699;height:2em;width:40em;padding:.5em;" type="text" value="Start typing any song..." onkeyup="action.song_search(this)"/><input type="submit" style="margin-left:.5em;background:#336699;height:3em;width:5em;font-weight:bold;color:white;padding:.5em;" value="Search"></div>');
				$('#song_search_container').append('<div id="song_search_callback" style="position:relative;top:2em;left:2em;height:44em;width:49em;overflow-y:scroll;"></div>');
				$('#song_search_container').append('<div id="song_search_more" style="position:relative;top:2em;left:12em;"><input style="cursor:pointer;background:#336699;color:#ffffff;" id="song_load_more" type="submit" value="Load More"/></div>');
			}
			
			$('#song_search_close').live('click',function(){ 
				$('#song_search_container').remove();
				$('#bg_first').remove();
			});

			$('#song_dedicate_popup_close').live('click',function(){
				$('#song_dedicate_popup_container').remove();
				$('#bg_hide').remove();
			});

			$('#song_dedicate_search_textbox').live('focus',function(e){
				if($(this).attr('value') == "Start typing any song...")
				{
					$(this).attr('value','');
				}
			});
			
			function song_dedicate(me)
			{
					$('body').append('<div id="bg_hide" style="position:absolute;top:0em;left:0em;width:100%;height:190em;background:gray;opacity:0.5;filter:alpha(opacity=80);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=80)"; filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=80);"></div>');
					songid = $(this).parent().parent().attr('id');
					$('body').append('<div id="song_dedicate_popup_container" style="position:absolute;top:13.5em;left:38.5em;border:.5em solid gray;width:30em;height:24em;background:white;"></div>');
					$('#song_dedicate_popup_container').html('<div id="song_dedicate_popup_title" style="border-bottom:.1em solid gray;height:1.5em;background:#336699;color:#ffffff;font-weight:bold;padding:.5em;font-size:1.4em;">Add Few Lines From The Song</div>');
					$('#song_dedicate_popup_title').append('<div id="song_dedicate_popup_close" style="position:absolute;top:.5em;right:.5em;color:white;cursor:pointer;">x</div>');
					$('#song_dedicate_popup_container').append('<div style="margin:2em;"><textarea id="song_dedicate_popup_textarea" style="width:23em;height:10em;border:.1em solid #336699;resize:none;padding:1em"></textarea></div>');
					$('#song_dedicate_popup_container').append('<div style="position:relative;left:20em;top:0em;"><input type="submit" id="song_dedicate_done_button" style="margin-left:.5em;background:#336699;height:3em;width:8em;font-weight:bold;color:white;padding:.5em;cursor:pointer;" value="Done" ></div>');
			}
			
			function search(me)
			{
				$('body').append('<div id="search_container"></div>');
				$('#search_container').css('left',$('#search_form').position().left+10+'px');
				$(window).resize(function(){
					$('#search_container').css('left',$('#search_form').position().left+10+'px');
				});
				
				$('#to').focus(function(){
					$('.search_items').show();
				}); 
			}
			
			function song_link_click(me)
			{
				$('html').append('<div id="bg_first" style="position:absolute;top:0em;left:0em;width:100%;height:80em;background:gray;opacity:0.5;filter:alpha(opacity=80);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=80)"; filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=80);"></div>');
				$('html').append('<div id="song_search_container" style="position:absolute;top:3.5em;left:28.5em;border:.5em solid gray;width:51.5em;height:55em;background:white;"></div>');
				$('#song_search_container').html('<div id="song_search_title" style="border-bottom:.1em solid gray;height:1.5em;background:#336699;color:#ffffff;font-weight:bold;padding:.5em;font-size:1.4em;">Search a song and set as your status</div>');
				$('#song_search_title').append('<span id="song_search_close" style="position:absolute;top:.5em;right:.5em;color:white;cursor:pointer;">x</span>');
				$('#song_search_container').append('<div id="song_search_box" style="position:relative;top:1em;left:2em;"><input id="song_search_textbox" style="border:.1em solid #336699;height:2em;width:40em;padding:.5em;" type="text" value="Start typing any song..." onkeyup="action.song_search(this)"/><input type="submit" style="margin-left:.5em;background:#336699;height:3em;width:5em;font-weight:bold;color:white;padding:.5em;" value="Search"></div>');
				$('#song_search_container').append('<div id="song_search_callback" style="position:relative;top:2em;left:2em;height:44em;width:49em;overflow-y:scroll;"></div>');
				$('#song_search_container').append('<div id="song_search_more" style="position:relative;top:2em;left:12em;"><input style="cursor:pointer;background:#336699;color:#ffffff;" id="song_load_more" type="submit" value="Load More"/></div>');
			}
			
			function song_search_close_click(me)
			{
				$('#song_search_close').live('click',function(){
					$('#song_search_container').remove();
					$('#bg_first').remove();
				});
			}	

			function song_status_popup_close_click(me)
			{
				$('#song_status_popup_close').live('click',function(){
				$('#song_status_popup_container').remove();
				$('#bg_hide').remove();
				});
			}

			function song_search_textbox_click(me)
			{	
				$('#song_search_textbox').live('focus',function(e){
					if($(this).attr('value') == "Start typing any song...")
					{
						$(this).attr('value','');
					}
				});
			}
			
			function status_song_button_click(me, songid)
			{	
				$('html').append('<div id="bg_hide" style="position:absolute;top:0em;left:0em;width:100%;height:190em;background:gray;opacity:0.6;filter:alpha(opacity=80);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=80)"; filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=80);"></div>');
				$('html').append('<div id="song_status_popup_container" style="position:absolute;top:13.5em;left:38.5em;border:.5em solid gray;width:30em;height:24em;background:white;"></div>');
				$('#song_status_popup_container').html('<div id="song_status_popup_title" style="border-bottom:.1em solid gray;height:1.5em;background:#336699;color:#ffffff;font-weight:bold;padding:.5em;font-size:1.4em;">Add Few Lines From The Song</div>');
				$('#song_status_popup_title').append('<div id="song_status_popup_close" style="position:absolute;top:.5em;right:.5em;color:white;cursor:pointer;">x</div>');
				$('#song_status_popup_container').append('<div style="margin:2em;"><textarea id="song_status_popup_textarea" style="width:23em;height:10em;border:.1em solid #336699;resize:none;padding:1em"></textarea></div>');
				$('#song_status_popup_container').append('<div style="position:relative;left:20em;top:0em;"><input type="submit" id="song_status_done_button" style="margin-left:.5em;background:#336699;height:3em;width:8em;font-weight:bold;color:white;padding:.5em;cursor:pointer;" value="Done" onclick="action.song_status_done_button_click(this,'+songid+')"></div>');
			}
			
			function search(me)
			{
				$('.search_items').live('click',function(){
					window.location = "/profile.php?id="+$(this).attr('data');
				});

				$('#center, #left, #right').click(function(){
					$('.search_items').hide();
				}); 

				$('.search_items').live('mouseover',function(){
					$(this).css('background','#336699');
					$(this).children().eq(1).children().eq(0).css('color','#ffffff'); 
				});

				$('.search_items').live('mouseleave',function(){
					$(this).css('background','#ffffff');
					$(this).children().eq(1).children().eq(0).css('color','#336699'); 
				});
				
				
				$('#chat_search_box').keyup(function(event){

					var pattern = $(this).val(); 
					$('.chat_user').each(function(index){
						var search_name = $(this).children().eq(1).html().toLowerCase().split(" ");
						for(var i=0;i<search_name.length;i++)
						{
							if($(this).children().eq(1).html().toLowerCase().search($.trim('^'+pattern).toLowerCase()) != -1 || search_name[i].search($.trim('^'+pattern).toLowerCase()) != -1)
							{
							   $(this).show();
							   break;
							}
							else
							{
								$(this).hide();
							}
						}
					});
				});
			}
			
			function video_play_click()
			{	
				var videoid = $(this).parent().children().eq(0).attr('value');
				$('body').append('<div id="video_shadow" style="position:fixed;top:0em;left:0em;width:100%;height:100%;background-color:#eeeeee;z-index:99999;"></div>');
				$('body').append('<iframe id="video_playing" style="position:fixed;top:8em;left:30%;top:10%;z-index:999999" width="400" height="300" src="http://www.youtube.com/embed/'+videoid+'?autoplay=1" frameborder="0"></iframe>');	
			}
			
			function video_shadow_click(me)
			{
				$(this).remove();
				$('#video_playing').remove();
			}
			
			function link_highlight(text)
			{
				if(text)
				{
					var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
					return text.replace(exp,"<a href='$1' target='_blank'>$1</a>"); 
			    }
				return text;
			}
			
			function get_smiley(message)
			{	  	
				smiley = {
				':)' : '<img title="Smile" class="smiley_chat" src="//icon.qmcdn.net/smile.png" />', 
				':D' : '<img title="Laughing" class="smiley_chat" src="//icon.qmcdn.net/laughing.png" />', 
				':(' : '<img title="Sad" class="smiley_chat" src="//icon.qmcdn.net/sad.png" />', 
				':P' : '<img title="Tongue" class="smiley_chat" src="//icon.qmcdn.net/tongue.png" />',
				';)' : '<img title="Wink" class="smiley_chat" src="//icon.qmcdn.net/wink.png" />',
				':3' : '<img title="Curly Lips" class="smiley_chat" src="//icon.qmcdn.net/curlylips.png" />',
				':*' : '<img  title="Kiss" class="smiley_chat" src="//icon.qmcdn.net/kiss.png" />',
				'>:(' : '<img title="Grumpy" class="smiley_chat" src="//icon.qmcdn.net/grumpy.png" />',
				'8)' : '<img title="Glasses" class="smiley_chat" src="//icon.qmcdn.net/glasses.png" />',
				'8|' : '<img title="Sun Glasses" class="smiley_chat" src="//icon.qmcdn.net/sunglasses.png" />',
				'>:o' : '<img title="Upset" class="smiley_chat" src="//icon.qmcdn.net/upset.png" />',
				'o.O|' : '<img title="Confused" class="smiley_chat" src="//icon.qmcdn.net/confused.png" />',
				':v' : '<img title="Packman" class="smiley_chat" src="//icon.qmcdn.net/pacman.png" />',
				'o:)' : '<img title="Angel" class="smiley_chat" src="//icon.qmcdn.net/angel.png" />',
				'3:)' : '<img title="Devil" class="smiley_chat" src="//icon.qmcdn.net/devil.png" />',
				'<3' : '<img title="Heart" class="smiley_chat" src="//icon.qmcdn.net/heart.png" />'
				};

				$.each(smiley,function(index,value){
					if(message)
						message = message.replace(index,value);
				});
			  	return message; 
			}
		
		function post_delete(me)
		{
				var del_actionid=$(me).parent().attr('data');
				$('.prompt_container').remove();     
				$('.bg_hide_cover').remove();
				$('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
				$('body').append('<div class="prompt_container"><div class="prompt_title">Please confirm your action</div><div class="prompt_content">Do you want to delete?</div><div class="prompt_button"><input class="prompt_positive" type="submit" value="Sure" onClick="action.post_delete_positive(this, '+del_actionid+')"/><input class="prompt_negative" type="submit" value="Cancel" onclick="ui.bg_hide()"/></div></div>');
				$('body').css('overflow','hidden');
		}
		function message_delete(me,actionid)
		{
				$('.prompt_container').remove();     
				$('.bg_hide_cover').remove();
				$('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
				$('body').append('<div class="prompt_container"><div class="prompt_title">Please confirm your action</div><div class="prompt_content">Do you want to delete this message?</div><div class="prompt_button"><input class="prompt_positive" type="submit" value="Sure" onClick="action.message_delete_positive(this, '+actionid+')"/><input class="prompt_negative" type="submit" value="Cancel" onclick="ui.bg_hide()"/></div></div>');
				$('body').css('overflow','hidden');
		}
		function group_leave(me)
		{
				var profile_name = $('#profilename_hidden').attr('value');	
				$('.prompt_container').remove();     
				$('.bg_hide_cover').remove();
				$('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
				$('body').append('<div class="prompt_container"><div class="prompt_title">Please confirm your action</div><div class="prompt_content">Leave group '+profile_name+'</div><div class="prompt_button"><input class="prompt_positive" type="submit" value="Sure" onClick ="action.group_leave_positive(this)"/><input class="prompt_negative" type="submit" value="Cancel" onClick ="ui.bg_hide()"/></div></div>');
				$('body').css('overflow','hidden');
		}
		function event_leave(me)
		{
				var profile_name = $('#profilename_hidden').attr('value');	
				$('.prompt_container').remove();     
				$('.bg_hide_cover').remove();
				$('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
				$('body').append('<div class="prompt_container"><div class="prompt_title">Please confirm your action</div><div class="prompt_content">Leave event '+profile_name+'</div><div class="prompt_button"><input class="prompt_positive" type="submit" value="Sure" onClick ="action.event_leave(this)"/><input class="prompt_negative" type="submit" value="Cancel" onClick ="ui.bg_hide()"/></div></div>');
				$('body').css('overflow','hidden');
		}
		function event_cancel(me)
		{
				var profile_name = $('#profilename_hidden').attr('value');	
				$('.prompt_container').remove();     
				$('.bg_hide_cover').remove();
				$('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
				$('body').append('<div class="prompt_container"><div class="prompt_title">Please confirm your action</div><div class="prompt_content">Cancel event '+profile_name+'</div><div class="prompt_button"><input class="prompt_positive" type="submit" value="Sure" onClick ="action.event_cancel_positive(this)"/><input class="prompt_negative" type="submit" value="Cancel" onClick ="ui.bg_hide()"/></div></div>');
				$('body').css('overflow','hidden');
		}
		function unfriend(me)
		{
				var profile_name = $('#profilename_hidden').attr('value');	
				$('.prompt_container').remove();     
				$('.bg_hide_cover').remove();
				$('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
				$('body').append('<div class="prompt_container"><div class="prompt_title">Please confirm your action</div><div class="prompt_content">Unfriend '+profile_name+'</div><div class="prompt_button"><input class="prompt_positive" type="submit" value="Sure" onClick ="action.unfriend_positive(this)"/><input class="prompt_negative" type="submit" value="Cancel" onClick ="ui.bg_hide()"/></div></div>');
				$('body').css('overflow','hidden');
		}
		function popup_error_prompt(error)
		{
			var profile_name = $('#profilename_hidden').attr('value');	
			$('.prompt_container').remove();     
			$('.bg_hide_cover').remove();
			$('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
			$('body').append('<div class="prompt_container"><div class="prompt_title">Error performing the action</div><div class="prompt_content">'+error+'</div><div class="prompt_button"><input class="prompt_negative" type="submit" value="Fine" onClick ="ui.bg_hide()"/></div></div>');
			$('body').css('overflow','hidden');
		}
		function bg_hide(me)
		{
			$('#message_container').remove();
			$('.prompt_container').remove();
			$('#notice_container').remove();
			$('#mood_container').remove();
			$('#gift_container').remove();
			$('#more_excite_people').remove();
			$('#tagline_container').remove();
			$('.group_create_container').remove();
			$('.bg_hide_cover').remove();
			$('body').css('overflow','auto');

		}
		function goBacktoProfile(profileid)
		{
				window.location = 'profile.php?id='+profileid;
		}
		function removeContainerbyId(id)
		{
			$('#'+id).remove();
		}
		
		function diary_suggest(me, type,event)
		{
			if(navigator.appName == 'Microsoft Internet Explorer')
			{
				event.cancelBubble = true
			}
			else
			{
				event.stopPropagation();
			} 
			$(me).parent().append('<div class="callback_con"></div>');
			/*if(bring)
			{
				$('.callback_con').remove();
				$(me).parent().append('<div class="callback_con"></div>');
				bring = false;
			} */
			var val =$(me).val();
			if(val !='')
			{
				$.getJSON('ajax/write.php',{action:'callback',type:type,k:val},function(data){
				if(data)
				{
					$('.callback_con').html('');
					$.each(data, function(index,value){
						$('.callback_con').append('<div data="'+type+'" id="'+value.id+'" class="callback_class callback_class_click" style="min-height:25px;border-bottom:1px solid #eeeeee;cursor:pointer;padding:0px;">'+value.school+'</div>');
					});
				}
					$('.callback_con').append('<div id=""  data="'+type+'" class="callback_class_new_item callback_class_click" style="min-height:25px;border-bottom:1px solid #eeeeee;cursor:pointer;padding:0px;background:#4C66A4;color:#ffffff;font-weight:bold">'+$(me).val()+'</div>');
				});  
			}
			else 
			{
				$('.callback_con').hide('');
			}
		}	
		function redirect_to_inbox(user)
		{
			window.location="/?hl=inbox&id="+user;
		}
		
		function show_more(me)
		{
			$(me).next().show();
			$(me).next().next().show();
			$(me).hide();
		}
		
		function show_less(me)
		{
			$(me).prev().prev().show();
			$(me).prev().hide();
			$(me).hide();
		}

		function see_more(page)
		{	  	
			var left,right,pos,pos1;
			if(page.length > 153)
			{
				 right = page.substr(150,page.length-1);
				 pos = right.indexOf(' ');
				 pos1 = right.indexOf('\n');
				 if(pos > pos1) pos = pos1;
				 if(pos+150 > 153)
				 {
					 left = page.substr(0,150+pos);
					 right = ' '+page.substr(150+pos+1,page.length-1);
					 return left+'<div onclick="ui.show_more(this)" style="margin-top:0.5em;color:#336699;cursor:pointer;font-size:0.9em;">See more</div><span class="see_more" style="display:none;">'+right+'</span><div onclick="ui.show_less(this)" style="margin-top:0.5em;color:#336699;cursor:pointer;display:none;font-size:0.9em;">See less</div>';
				 }
			} 
			return page;
		}
		
		function time_difference(time)
		{
			now = Math.floor((new Date()).getTime() / 1000);
			if(now == time)
				return ' '+'now';
			else if(now - 1 < time)
				return ' '+'a second ago';
			else if(now - 2 < time)
				return ' '+'two seconds ago'; 
			else if(now - 3 < time)
				return ' '+'three seconds ago';
			else if(now - 4 < time)
				return ' '+'four seconds ago';
			else if(now - 5 < time)
				return ' '+'five seconds ago';
			else if(now - 10 < time)
				return ' '+'ten seconds ago';
			else if(now - 15 < time)
				return ' '+'fifteen seconds ago';
			else if(now - 30 < time)
				return ' '+'half a minute ago';
			else if(now - 45 < time)
				return ' '+'forty-five seconds ago';
			else if(now - 60 < time)
				return ' '+' one minute ago';
			else if(now - 120 < time)
				return ' '+' two minutes ago';
			else if(now - 180 < time)
				return ' '+' three minutes ago';
			else if(now - 240 < time)
				return ' '+' four minutes ago';
			else if(now - 300 < time)
				return ' '+' five minutes ago';
			else if(now - 600 < time)
				return ' '+' ten minutes ago';
			else if(now - 900 < time)
				return ' '+' fifteen minutes ago';
			else if(now - 1200 < time)
				return ' '+' twenty minutes ago';
			else if(now - 1500 < time)
				return ' '+' twenty-five minutes ago';
			else if(now - 1800 < time)
				return ' '+' half an hour ago';
			else if(now - 3600 < time)
				return ' '+' an hour ago';
			else if(now - 7200 < time)
				return ' '+'two hours ago';
			else if(now - 10800 < time)
				return ' '+'three hours ago';
			else if(now - 14400 < time)
				return ' '+'four hours ago';
			else if(now - 18000 < time)
				return ' '+'five hours ago';
			else if(now - 21600 < time)
				return ' '+'six hours ago';
			else if(now - 25200 < time)
				return ' '+'seven hours ago';
			else if(now - 28800 < time)
				return ' '+'eight hours ago';
			else if(now - 32400 < time)
				return ' '+'nine hours ago';
			else if(now - 36000 < time)
				return ' '+'ten hours ago';
			else if(now - 36900 < time)
				return ' '+'eleven hours ago';		
			else if(now - 43200 < time)
				return ' '+'twelve hours ago';
			else if(now - 46800 < time)
				return ' '+'thirteen hours ago';
			else if(now - 50400 < time)
				return ' '+'fourteen hours ago';
			else if(now - 50400 < time)
				return ' '+'fifteen hours ago';
			else if(now - 57600 < time)
				return ' '+'sixteen hours ago';
			else if(now - 61200 < time)
				return ' '+'seventeen hours ago';
			else if(now - 64800 < time)
				return ' '+'eighteen hours ago';
			else if(now - 68400 < time)
				return ' '+'nineteen hours ago';
			else if(now - 72000 < time)
				return ' '+'twenty hours ago';
			else if(now - 75600 < time)
				return ' '+'twentyone hours ago';
			else if(now - 79200 < time)
				return ' '+'twentytwo hours ago';
			else if(now - 82800 < time)
				return ' '+'twentythree hours ago';
			else if(now - 86400 < time)
				return ' '+' yesterday';
			else if(now - 172800 < time)
				return ' '+'two days ago';
			else if(now - 259200 < time)
				return ' '+'three days ago';
			else if(now - 345600 < time)
				return ' '+'four days ago';
			else if(now - 432000 < time)
				return ' '+'five days ago';
			else if(now - 518400 < time)
				return ' '+'six days ago';		
			else if(now - 604800 < time)
				return ' last week';
			else if(now - 1209600 < time)
				return ' two weeks ago';
			else if(now - 1814400 < time)
				return ' three weeks ago';
			else if(now - 2419200 < time)
				return ' four weeks ago';
			else if(now - 2592000 < time)
				return ' a month ago';		
			else if(now - 5184000 < time)
				return ' two months ago';
			else if(now - 7776000 < time)
				return ' three months ago';
			else if(now - 10368000 < time)
				return ' four months ago';
			else if(now - 12960000 < time)
				return ' five months ago';
			else if(now - 15552000 < time) 
				return ' six months ago';
			else if(now - 18144000 < time)
				return ' seven months ago';
			else if(now - 20736000 < time)
				return ' eight months ago';
			else if(now - 23328000 < time)
				return ' nine months ago';
			else if(now - 25920000 < time)
				return ' ten months ago';
			else if(now - 28512000 < time)
				return ' eleven months ago';
			else if(now - 31104000 < time)
				return '  a year ago';
			else
				return ' over a year ago';	
		}
		
			return {
				OnProgress:OnProgress,
				page_create:page_create,
				message_delete:message_delete,
				birthday_bomb:birthday_bomb,
				createMessageUI : createMessageUI,
				messagebox_scroll : messagebox_scroll,
				redirect_to_inbox:redirect_to_inbox,
				redirect_friend_suggest : redirect_friend_suggest,
				redirect_group_suggest : redirect_group_suggest,
				redirect_to_action : redirect_to_action,
				message_leave_grow : message_leave_grow, 
				message_leave_shrink : message_leave_shrink, 
				album_upload: album_upload,
				bg_hide : bg_hide,
				bio_privacy : bio_privacy,
				close : close,
				disable_upload_area : disable_upload_area,
				direct_to_md : direct_to_md,
				diary_suggest : diary_suggest,
				enable_upload_area : enable_upload_area,
				event_cancel : event_cancel,
				event_create : event_create,
				event_leave : event_leave,
				event_friend_invite : event_friend_invite,
				friend_invite : friend_invite,
				file_upload : file_upload,
				get_smiley : get_smiley,
				gift : gift,
				gift_ui_create : gift_ui_create,
				group_friend_invite : group_friend_invite,
				group_event_create : group_event_create,
				goBacktoProfile : goBacktoProfile,
				group_question : group_question,
				group_create : group_create,
				group_leave : group_leave,
				group_suggest_deploy : group_suggest_deploy,
				group_suggest_page_deploy : group_suggest_page_deploy,
				event_suggest_deploy : event_suggest_deploy,
				event_suggest_single_deploy : event_suggest_single_deploy,
				group_suggest_single_deploy : group_suggest_single_deploy,
				group_suggest_single_deploy_page:group_suggest_single_deploy_page,
				link_highlight : link_highlight,
				menu : menu,
				message : message,
				message_close : message_close,
				mood : mood,
				mood_click : mood_click,
				message_fetch : message_fetch,
				notice_fetch : notice_fetch,
				page_init : page_init,
				photo_upload : photo_upload,
				post_delete : post_delete,
				profile_post_privacy : profile_post_privacy,
				popup_error_prompt : popup_error_prompt,
				praise : praise,
				removeContainerbyId : removeContainerbyId,
				request_fetch : request_fetch,
				response_comment : response_comment,
				search : search,
				see_more : see_more,
				show_less : show_less,
				show_more : show_more,
				status_song_button_click : status_song_button_click,
				song_dedicate_create_ui : song_dedicate_create_ui,
				song_dedicate : song_dedicate,
				song_link_click : song_link_click,
				search : search,
				suggest_deploy : suggest_deploy,
				suggest_deploy_page : suggest_deploy_page,
				suggest_single_deploy : suggest_single_deploy,
				suggest_single_deploy_page:suggest_single_deploy_page,
				time_difference : time_difference,
				page_call : page_call,
				tagline : tagline,
				tagline_close : tagline_close,
				upload_default_state : upload_default_state,
				unfriend : unfriend,
				video_play_click : video_play_click,
				video_shadow_click : video_shadow_click,
				mood_close :mood_close,
				restore_action_field:restore_action_field
			}
			})();