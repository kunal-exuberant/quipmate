
	var callback = (function(){
	
		function add_friend(me, data)
		{
			if(data.ack ==1)
			{
				$(me).attr('value',data.message);
			}
		}
		
		function missu(me, data)
		{
			if(data.ack ==1)
			{
				$(me).attr('value',data.message);
				$(me).attr('class','missed_back');
			}
		}
		
		function group_join(me, data)
		{
			if(data.ack ==1)
			{
				$(me).attr('value', 'Requested');
			}
		}
		
		function event_join(me, data)
		{
			if(data.ack ==1)
			{
				$(me).attr('value', 'Going');
			}
		}
		
		function birthday_bomb(me, data)
		{
			if($.trim(data)==1)
			{
				$('#birthday_wish_container').html('You have successfully sent the birthday wish along with the birthday bomb.');
				$('.right_pointer_container').fadeOut(2000);
			}	
		}
		
		function birthday_all(me, data)
		{
			$('#center').html('<div class="right_item" ><div class="subtitle" style="">Friend\'s Birthday</div></div>');
			$('#center').append('<table></table>');
			var i = 0;
			$.each(data.event,function(index,value){
				if(i%4==0)
				{
					$('table').append('<tr></tr>');
				}
				$('tr:last').append('<td style="color:blue;padding:2em;"><a style="color:#336699;" href="profile.php?id='+value.profileid+'&pl=diary"><img class="lfloat" src="'+data.pimage[value.profileid]+'" height="60" width="60" /></a><br /><a style="color:#336699;" href="profile.php?id='+value.profileid+'&pl=diary">'+data.name[value.profileid]+'<br />'+value.birthday+' </a></td>');
				i++;
			});
		}
		
		function comment(me, data)
		{
			var myprofileid = $('#myprofileid_hidden').attr('value');
			var myname = $('#myprofilename_hidden').attr('value');
			var myphoto = $('#myprofileimage_hidden').attr('value');
			var pageid = $(me).parent().parent().parent().attr('data');
			if(data.ack)
			{
				$(me).append('<div class="cclass_json" data="'+ data.actionid +'" id="nf_post_'+data.actionid+'"><a href="profile.php?id=' +myprofileid+ '"><img class="lfloat" src =' +myphoto+ ' height="32" width="32" /></a><div class="name_35"><div><a class="bold" style="margin-right:0.4em;" href="profile.php?id=' +myprofileid+ '" >' +myname+ '</a><pre>'+ui.get_smiley(ui.link_highlight(data.comment))+'</pre></div><div><a class="comment_time_json" href="action.php?actionid='+pageid+'&life_is_fun='+data.life_is_fun+'"><img src="http://icon.qmcdn.net/clock.png" width="6" /><span class="time" data="'+Math.floor((new Date()).getTime()/1000)+'">'+time_difference(Math.floor((new Date()).getTime()/1000))+'</span></a><span data=' +myprofileid+ ' class = "comment_excite_json" onclick="action.response(this)">Exciting</span><span class="more_excite_json" data="0"></span></div></div><span class="comment_setting" onclick="ui.post_delete(this)" >x</span></div>');
			}		
			me.attr('value','');
		}
		
		function question(me, data)
		{
			var postid = $('#'+dom_id);
			var myprofileid = $('#myprofileid_hidden').attr('value');
			var profileid = $('#profileid_hidden').attr('value');
			var myphoto = $('#myprofileimage_hidden').attr('value');
			var myname = $('#myprofilename_hidden').attr('value');
			$('#prev').prepend('<div class="nf_post" data="'+data.actionid+'" id="nf_post_'+data.actionid+'"><div class="name_50"></div><div data=' +data.actionid+ ' class="pageclass_json"><input type="hidden" value=' +profileid+ ' /> <input type="hidden" value="2800"/><a href="profile.php?id='+myprofileid+'"><img class="lfloat" src =' +myphoto+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id='+myprofileid+'">'+myname+'</a> asked a question<div class="pclass_json"><pre style="margin-bottom:0.6em;">'+ui.get_smiley(ui.link_highlight(data.question))+'</pre></div><div class="time_tag_json"><img src="http://icon.qmcdn.net/clock.png" width="6" />Now</div><div class="likeclass_json"><span class="response" style="color:blue;" onclick="action.response(this)">Exciting: </span><span class="excited_people"></span><span class="post_pointer"></span></div><div></div><div class="cclass_box" ><a href="profile.php?id=' +myprofileid+ '"><img class="lfloat" src="'+myphoto+'"  width="35" height="36"/></a><textarea class="commentbox" style="margin:0em 0em 0em 0.5em;" placeholder="Add a comment..." onkeydown="action.comment(this, event)"></textarea></div></div></div><span onclick="ui.post_delete(this)" class="post_setting"></span></div>');
			$.each(data.option,function(i,v){
			$('#nf_post_'+data.actionid).children().eq(1).children().eq(3).children().eq(1).append('<div class="option"><input type="checkbox" style="margin-right:0.5em" onchange="action.answer(this, '+data.actionid+', '+v.optid+')"/>'+v.opt+'<span class="rfloat tcolor"></span></div>');
			});	
			$('#uploader').html('<input type="text" id="status_box" value="" placeholder="What \'s going in your life?"/><input id="link_button" type="submit" value="Share">');
		}
		
		function comment_excite(me, data)
		{
			if($.trim(data) != "")
		   {
				obj.after("");
				obj.after(data);
		   }
		}
		
		function answer(me, data)
		{
			if($.trim(data) != "")
		   {
		   }
		}
		
		function comment_excite_show(me, data)
		{
			$("#more_excite_people").remove();
			$('body').append('<div id="more_excite_people" style="position:fixed;top:18.2em;left:36em;overflow:auto;"></div>');
			$('#more_excite_people').append(data);
			$('#more_excite_people').append('<span id="diary_close" style="position:absolute;top:1em;right:1em;cursor:pointer;">x</span>');
		}
		
		function crush_match_preview(me, data)
		{
			if(data)
			{
				$('#right').append('<div id="crush_match_recent" class="right_item"></div>');
				$('#crush_match_recent').html('<div class="subtitle" >Crush Match</div>');
				$.each(data.action,function(index,value){ 
				$('#crush_match_recent').append('<div class="container_32"><a href="profile.php?id='+value.actionon+'&pl=diary"><img title="'+data.name[value.actionon]+'" class="lfloat" src="'+data.pimage[value.actionon]+'" height="32" width="32" /></a><img class="lfloat" style="margin:1em;" src="http://icon.qmcdn.net/heart.png" /><a href="profile.php?id='+value.actionby+'&pl=diary"><img title="'+data.name[value.actionby]+'" class="lfloat" style="margin-right:0.6em;" src="'+data.pimage[value.actionby]+'" height="32" width="32" /></a><div class="name_32"><a style="color:#336699;font-weight:bold;" href="profile.php?id='+value.actionby+'&pl=diary">'+data.name[value.actionby]+'</a></div></div>');
				});
			} 
			else
			{
				$('#crush_match_recent').remove();
			}
		}
		
		function crush_preview(me, data)
		{
			if(data)
			{
				$('#right').append('<div id="crush_at_recent" class="right_item"></div>');
				$('#crush_at_recent').html('<div class="subtitle" >Friends Added As Crush</div>');
				$.each(data.action,function(index,value){ 
				$('#crush_at_recent').append('<div class="container_32"><a style="color:#336699;" href="profile.php?id='+value.actionon+'&pl=diary"><img class="lfloat" src="'+data.pimage[value.actionon]+'" height="32" width="32" /></a><div class="name_32"><a style="color:#336699;font-weight:bold;" href="profile.php?id='+value.actionon+'&pl=diary">'+data.name[value.actionon]+'</a> </div></div>');
				});
			} 
			else
			{ 
				$('#crush_at_recent').remove();
			}
		}
		
		function forgot_password(me, data)
		{						
			if(data.ack == 1)
			{
				$('#forgot_password_info').html('A link to recover your password has been sent to your email account.');
			}
			else if(data.error.code == 16)
			{	
				$('#forgot_password_info').html('Sorry, you are not a member of <big>Q</big>uipmate.');
			}
			else if(data.ack == 15)
			{
				$('#forgot_password_info').html('Unable to reach database');
			}
			else if(data.ack == 17)
			{
				$('#forgot_password_info').html('Sorry, an error occured while sending the email.');
			}
			else
			{
				$('#forgot_password_info').html('Please try again.');
			}
		}
		
		function friend_accept(me, data)
		{
			$(me).remove();
		}
		
		function member_accept(me, data)
		{
			$(me).remove();
		}
		function guest_accept(me, data)
		{
			$(me).remove();
		}
		
		function bio_item_remove(me, data)
		{
			$(me).remove();
		}

		function group_invite(me, data)
		{
			if(data.ack)
			{
				$('#group_invite_info').html(data.message);	
				$(me).remove();
			}
			else if(data.error)
			{
				$('#group_invite_info').html(data.error.message);	
				$(me).remove();		
			}
		}
		
		function friend_event(me, data)
		{
			if(data)
			{
				$('#friend_event').html('<div class="subtitle">Upcoming Birthdays<span id="bday_more" style="float:right;cursor:pointer;font-size:.8em;margin:0.3em 1.5em 0 0;color:#336688;">More</span></div>');
				var count = 0;
				$.each(data.event,function(index,value){
				var birthday = new Date(value.birthday * 1000);
				var today =  new Date();
				birthday = birthday.toString();
				today = today.toString();
				var bday = birthday.substring(4,birthday.length-45);
				var tday = today.substring(4,today.length-45);
				if(tday == bday)
				{
					$('#birthday_today').append('<div class="container_32_35" id="'+value.profileid+'"><input type="hidden" value="'+value.profileid+'" /><input type="hidden" value="'+value.b+'" /><input type="hidden" value="'+value.pageid+'" /><div><a style="color:#336699;" href="profile.php?id='+value.profileid+'&pl=diary"><img class="lfloat" src="'+data.pimage[value.profileid]+'" height="35" width="32" /></a></div><div class="name_32"><a style="color:#336699;font-weight:bold;" href="profile.php?id='+value.profileid+'&pl=diary">'+data.name[value.profileid]+'</a></div></div>');
					if(value.bomb_status)
					{
						$('#'+value.profileid).append('<div class="name_32">birthday-bomb<span class="birthday_bomb_count" title="Number of people who birthday-bombed">' +value.bomb_count+'</span></div>');
					}
					else
					{
						$('#'+value.profileid).append('<div class="birthday_bomb name_32" style="cursor:pointer;"  title="Click to add a birthday wish">+birthday-bomb<span class="birthday_bomb_count" title="Number of people who birthday-bombed">' +value.bomb_count+'</span></div>');
					}
					count++;
				}
				else
				{
					$('#friend_event').append('<div class="container_32_35"><a style="color:#336699;" href="profile.php?id='+value.profileid+'&pl=diary"><img class="lfloat" src="'+data.pimage[value.profileid]+'" height="35" width="32" /></a><div class="name_32"><a style="color:#336699;font-weight:bold;" href="profile.php?id='+value.profileid+'&pl=diary">'+data.name[value.profileid]+'</a><div>'+bday+'</div></div></div>');
				}
				});
				if(count)
				{
					$('#birthday_today').prepend('<div class="subtitle">Birthday Today('+count+')</div>');
				}
			}	
			else
			{
				$('#friend_event').remove();
			}
		}
		
		function friend_match(me, data)
		{
			if(data.count > 0 )
			{
				$('#friend_match').html('<div class="subtitle" >FRIEND MATCH('+data.count+')</div>');
				$.each(data.match,function(index,value){
				$('#friend_match').append('<span class="friend_match_class"><a href="profile.php?id='+value.profileid+'"><img src="'+data.pimage[value.profileid]+'" height="30" width="30" title="'+data.name[value.profileid]+'"></a></span>');
				});
			}
			if(data.ncount > 0)
			{
				$('#friend_non_match').html('<div class="subtitle" >FRIEND NON-MATCH('+data.ncount+')</div>');
				$.each(data.non_match,function(index,value){
				$('#friend_non_match').append('<span class="friend_match_class"><a href="profile.php?id='+value.profileid+'"><img src="'+data.pimage[value.profileid]+'" height="30" width="30" title="'+data.name[value.profileid]+'"></a></span>');
				});
			}
		}
		
		function friend_invite(me, data)
		{
			$('#inviting').attr('id','invite_button');
			$('#invite_button').attr('value','Invite');
			$('#invite_box').attr('value',''); 
			$('html').append('<div id="bg_first" style="position:absolute;top:0em;left:0em;width:100%;height:190em;background:gray;opacity:0.5;filter:alpha(opacity=80);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=80)"; filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=80);"></div>');
			$('html').append('<div id="invite_popup_container" style="position:absolute;top:10em;left:38em;border:.5em solid gray;width:35em;height:12em;background:white;"></div>');
			$('#invite_popup_container').html('<div id="invite_popup_title" style="border-bottom:.1em solid gray;height:1.5em;background:#336699;color:#ffffff;font-weight:bold;padding:.5em;font-size:1.4em;">Invite Prompt</div>');
			$('#invite_popup_container').append('<div style="color:black;font-size:1.4em;padding:.5em;" id="invite_prompt_text"></div>');
			$('#invite_popup_container').append('<div style="position:relative;left:20em;top:0em;"><input type="submit" id="invite_song_ok_button" style="margin-left:.5em;background:#336699;height:3em;width:4em;font-weight:bold;color:white;padding:.5em;cursor:pointer;" value="Ok" ></div>');
			if(data.ack == 0)
			{
				$('#invite_prompt_text').html('Ohhh come on! You cannot invite yourself. Try a different email address.');
			}
			else if(data.ack == 1)
			{
				$('#invite_prompt_text').html('Your friend having this email address has already joined Quipmate.');
			}
			else if(data.ack == 2)
			{
				$('#invite_prompt_text').html('You have successfully invited your friend to join Quipmate.');
			}
			else if(data.ack == 3)
			{
				$('#invite_prompt_text').html('Sorry this email address seems to be invalid. Please check for any possible mistake.');
			}
			else if(data.error)
			{
				$('#invite_prompt_text').html(data.error.message);
			}
			$('#invite_song_ok_button').live('click',function(){
				$('#invite_popup_container').remove();
				$('#bg_first').remove();
			});
		}
		
		function friend_request_fetch(me, data)
		{
			if(data.count > 0)
			{
				$('#friend_request').html('<div class="subtitle" >Friend Requests('+data.count+')</div>');
				$.each(data.friend,function(index,value){
					$('#friend_request').append('<div data="'+value.profileid+'" class="friend_request_class"><a href="profile.php?id='+value.profileid+'"><img class="lfloat" style="margin-right:1em;" src="'+data.pimage[value.profileid]+'" height="50" width="50"></a><div><a class="bold" href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a><div><input type="submit" class="frequest" id="1" value="Accept" onclick="action.friend_accept(this, 1)" /><input type="submit" class="frequest" style="margin-left:0.5em;" id="0" value="Deny" onclick="action.friend_accept(this, 0)" /></div></div></div>');
				});
			}	
			else
			{
				$('#friend_request').remove();
			}
		}
		
		function member_request_fetch(me, data)
		{
			if(data.count > 0)
			{
				$('#member_request').html('<div class="subtitle" >Member Requests('+data.count+')</div>');
				$.each(data.member,function(index,value){
					$('#member_request').append('<div data="'+value.profileid+'" class="friend_request_class"><a href="profile.php?id='+value.profileid+'"><img class="lfloat" style="margin-right:1em;" src="'+data.pimage[value.profileid]+'" height="50" width="50"></a><div><a class="bold" href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a><div><input type="submit" class="frequest" id="1" value="Add" onclick="action.member_accept(this, 1)" /><input type="submit" class="frequest" style="margin-left:0.5em;" id="0" value="Ignore" onclick="action.member_accept(this, 0)" /></div></div></div>');
				});
			}	
			else
			{
				$('#friend_request').remove();
			}
		}
		
			
		function friend_load(me, data)
		{
			if(data.ack)
			{
				$('#session_name_hidden').attr('value', JSON.stringify(data.name));
				$('#session_pimage_hidden').attr('value', JSON.stringify(data.pimage));
				$.each(data.friend,function(index,value){
					id = "friend_"+value;
				if($('#'+id).length == 0)
				{	
				  $(me).append('<div class="chat_user" data="'+value+'" id="'+id+'"><img class="online_photo" height="30" width="30" src="'+data.pimage[value]+'" /><span class="online_name">'+data.name[value]+'</span><input type="hidden" value="'+data.name[value]+'" /></div>');
				}  
				});
			}
			else
			{
				$(me).append('<div>Nobody is available at chat</div>');
			}
		}		
		
		function friend_suggest(me, data)
		{
			$('#right').append('<div id="friend_suggest" class="right_item"></div>'); 
			$('#friend_suggest').html('<div class="subtitle">Friend Suggestions<img title="Show different suggestions" style="float:right;height:1em;cursor:pointer;margin:0.2em 1em 0em 0em;" id="refresh" src="http://icon.qmcdn.net/refresh.jpg" onclick="action.suggest_refresh(this)"/></div><div class="suggest_container" id="suggest_container1"></div><div class="suggest_container" id="suggest_container2"></div><div class="suggest_container" id="suggest_container3"></div><div class="suggest_container" id="suggest_container4"></div><div class="suggest_container" id="suggest_container5"></div><div class="suggest_container" id="suggest_container6"></div>');
			ui.suggest_deploy(me, data);
		}
		
		function friend_suggest_page(me, data)
		{
			$('#right').append('<div id="friend_suggest" class="right_item"></div>'); 
			$('#friend_suggest').html('<div class="suggest_container" id="suggest_container1"></div><div class="suggest_container" id="suggest_container2"></div><div class="suggest_container" id="suggest_container3"></div><div class="suggest_container" id="suggest_container4"></div><div class="suggest_container" id="suggest_container5"></div><div class="suggest_container" id="suggest_container6"></div><div class="suggest_container" id="suggest_container7"></div><div class="suggest_container" id="suggest_container8"></div><div class="suggest_container" id="suggest_container9"></div><div class="suggest_container" id="suggest_container10"></div><div class="suggest_container" id="suggest_container11"></div><div class="suggest_container" id="suggest_container12"></div><div class="suggest_container" id="suggest_container13"></div><div class="suggest_container" id="suggest_container14"></div><div class="suggest_container" id="suggest_container15"></div><div class="suggest_container" id="suggest_container16"></div><div class="suggest_container" id="suggest_container17"></div><div class="suggest_container" id="suggest_container18"></div><div class="suggest_container" id="suggest_container19"></div><div class="suggest_container" id="suggest_container20"><div class="suggest_container" id="suggest_container21"></div></div>');
			ui.suggest_deploy_page(me, data);
		}
		
		function group_suggest_page(me, data)
		{
			$('#right').append('<div id="group_suggest" class="right_item"></div>'); 
			$('#group_suggest').html('<div class="group_suggest_container" id="group_suggest_container1"></div><div class="group_suggest_container" id="group_suggest_container2"></div><div class="group_suggest_container" id="group_suggest_container3"></div><div class="group_suggest_container" id="group_suggest_container4"></div><div class="group_suggest_container" id="group_suggest_container5"></div><div class="group_suggest_container" id="group_suggest_container6"></div><div class="group_suggest_container" id="group_suggest_container6"></div><div class="group_suggest_container" id="group_suggest_container7"></div><div class="group_suggest_container" id="group_suggest_container8"></div><div class="group_suggest_container" id="group_suggest_container9"></div><div class="group_suggest_container" id="group_suggest_container10"></div><div class="group_suggest_container" id="group_suggest_container11"></div><div class="group_suggest_container" id="group_suggest_container12"></div><div class="group_suggest_container" id="group_suggest_container13"></div><div class="group_suggest_container" id="group_suggest_container14"></div><div class="group_suggest_container" id="group_suggest_container15"></div><div class="group_suggest_container" id="group_suggest_container16"></div><div class="group_suggest_container" id="group_suggest_container17"></div><div class="group_suggest_container" id="group_suggest_container18"></div><div class="group_suggest_container" id="group_suggest_container19"></div><div class="group_suggest_container" id="group_suggest_container20"></div><div class="group_suggest_container" id="group_suggest_container21"></div>');
			ui.group_suggest_page_deploy(me, data);
		}
		
		function group_suggest(me, data)
		{
			$('#right').append('<div id="group_suggest" class="right_item"></div>'); 
			$('#group_suggest').html('<div class="subtitle">Group Suggestions<img title="Show different suggestions" style="float:right;height:1em;cursor:pointer;margin:0.2em 1em 0em 0em;" id="refresh" src="http://icon.qmcdn.net/refresh.jpg" onclick="action.group_suggest_refresh(this)"/></div><div class="group_suggest_container" id="group_suggest_container1"></div><div class="group_suggest_container" id="group_suggest_container2"></div><div class="group_suggest_container" id="group_suggest_container3"></div><div class="group_suggest_container" id="group_suggest_container4"></div><div class="group_suggest_container" id="group_suggest_container5"></div><div class="group_suggest_container" id="group_suggest_container6"></div>');
			ui.group_suggest_deploy(me, data);
		}
		
		function event_suggest(me, data)
		{
			$('#right').append('<div id="event_suggest" class="right_item"></div>'); 
			$('#event_suggest').html('<div class="subtitle">Event Suggestions<img title="Show different suggestions" style="float:right;height:1em;cursor:pointer;margin:0.2em 1em 0em 0em;" id="refresh" src="http://icon.qmcdn.net/refresh.jpg" onclick="action.event_suggest_refresh(this)"/></div><div class="event_suggest_container" id="event_suggest_container1"></div><div class="event_suggest_container" id="event_suggest_container2"></div><div class="event_suggest_container" id="event_suggest_container3"></div><div class="event_suggest_container" id="event_suggest_container4"></div><div class="event_suggest_container" id="event_suggest_container5"></div><div class="event_suggest_container" id="event_suggest_container6"></div>');
			ui.event_suggest_deploy(me, data);
		}
		
		function friendship_preview(me, data)
		{
			if(data)
			{
				$('#friendship_recent').html('<div class="subtitle" >Recent Friendships</div>');
				$.each(data.action,function(index,value){ 
				$('#friendship_recent').append('<div class="container_32"><a style="color:#336699;" href="profile.php?id='+value.actionon+'&pl=diary"><img class="lfloat" src="'+data.pimage[value.actionon]+'" height="32" width="32" /></a><div class="name_32"><a style="color:#336699;font-weight:bold;" href="profile.php?id='+value.actionon+'&pl=diary">'+data.name[value.actionon]+'</a> with <a style="color:#336699;" href="profile.php?id='+value.actionby+'&pl=diary">'+data.name[value.actionby]+'</a></div><div style="position:relative;top:-3em;left:4.5em;"></div></div>');
				});
			} 
			else
			{
				$('#friendship_recent').remove();
			}
		}
		
		function gift(me, data)
		{
			if(data.ack)
			{
				$('#gift_container').html('<span>Your gift has been sent to your friend.</span>');
				$('#gift_container').fadeOut(2000);
			}
		}
		
		function gift_preview(me, data)
		{
			if(data)
			{
				$('#right').append('<div id="gift_recent" class="right_item"></div>');
				$('#gift_recent').html('<div class="subtitle" >Who Sent Gift To Whom</div>');
				$.each(data.action,function(index,value){ 
				$('#gift_'+value.actionby).remove();
				$('#gift_recent').append('<div class="container_32_35" id="gift_'+value.actionby+'"><a style="color:#336699;" href="profile.php?id='+value.actionby+'&pl=diary"><img class="lfloat" src="'+data.pimage[value.actionby]+'" height="35" width="32" /></a><div class="name_32_35"><a style="color:#336699;font-weight:bold;" href="profile.php?id='+value.actionby+'&pl=diary">'+data.name[value.actionby]+'</a> To <a style="color:#336699;" href="profile.php?id='+value.actionon+'&pl=diary">'+data.name[value.actionon]+'</a>: '+value.gift+'<div>'+value.page+'</div></div></div>');
				});
			} 
			else
			{
				$('#gift_recent').remove();
			}
		}
		
		function group_create(me, data)
		{	
			if(data.error)
			{
				$('#group_info').html(data.error.message);
			}
			else
			{
				window.location = 'group.php?id='+data.groupid;
			}	
		}
		
		function group_settings_save(me, data)
		{	
			if(data.error)
			{
				$('#group_info').html(data.error.message);
			}
			else
			{
				$('#group_info').html("Settings Saved Successfully !");
			}	
		}
		
		function event_create(me, data)
		{	
			if(data.error)
			{
				$('#group_info').html(data.error.message);
			}
			else
			{
				window.location = 'event.php?id='+data.eventid;
			}	
		}
		
		function message(me, data)
		{
			if(data.ack)
			{
				$('#message_container').html('<span>The message has been sent.</span>');
				$('#message_container').fadeOut(2000);
				ui.bg_hide()
			}
		}
		
		function message_drop(me, data)
		{
			var myprofileid = $('#myprofileid_hidden').attr('value');
			var myprofileid_image=$('#myprofileimage_hidden').attr('value');
			var myprofileid_name=$('#myprofilename_hidden').attr('value');
			if(data.ack) 
			{				
				$('#prev').prepend('<div id="'+data.actionid+'" data="'+data.actionid+'" class="message_each"><input type="hidden" value="'+myprofileid+'" /><input type="hidden" value="'+data.actionon+'" /><input type="hidden" value="'+data.actiontype+'" /><a href="profile.php?id='+myprofileid+'" ><img class="lfloat" src =' +myprofileid_image+ ' height="50" width="50" /></a><div class="name_50"><a href="profile.php?id='+myprofileid+'">'+myprofileid_name+'</a> to <a href="profile.php?id='+myprofileid+'">'+myprofileid_name+'</a><div class="pclass_json"><pre>'+data.message+'</pre></div></div></div>');
				$('#'+data.actionid).append('<span class="time_tag_json"><img src="http://icon.qmcdn.net/clock.png" width="10" />Now</span><span class="reply" >Reply</span>');
			}
		}
		
		function message_recent_fetch(me, data, container)
		{
			if(data.ack)
			{
				$('#session_name_hidden').attr('value', JSON.stringify(data.name));
				$('#session_pimage_hidden').attr('value', JSON.stringify(data.pimage));
				var myprofileid = $('#myprofileid_hidden').attr('value');
				$.each(data.action,function(index,value){
				if(value.actionby == myprofileid)
				{	
					showuser = value.actionon; 
					showimage ='http://icon.qmcdn.net/out.png'
				}
				else 
				{
					showuser = value.actionby;
					showimage ='http://icon.qmcdn.net/in.png'
				}
				if((value.message).length > 30) value.message = (value.message).slice(0,27)+'...';
				
				  $(container).append('<div class="inbox_user" data="'+showuser+'" id="'+showuser+'" onclick=ui.redirect_to_inbox()><img class="online_photo" height="40" width="40" src="'+data.pimage[showuser]+'" /><span class="online_name" style="font-weight:bold;">'+data.name[showuser]+'</span><div><img height="20" width="20" src="'+showimage+'"/>'+value.message+'</div></div>');
				if(index == 0)
				{
					$('#inbox_container').html('');
					user = showuser;
					createMessageUI(user, name);
					previous_talk_message(user, 0, 1);
				}
				});
			}
		}
		
		function missu_fetch(me, data)
		{ 
			if(data.count)
			{
				$('#text').html('<div class="subtitle" >Friends Missing You('+data.count+')</div>');
				$.each(data.missu,function(index,value){
				$('#text').append('<div class="missu_reminder_class" data="'+value.profileid+'"><a href="profile.php?id='+value.profileid+'"><img class="lfloat" src="'+data.pimage[value.profileid]+'" height="50" width="50"></a><div class="name_50"><a class="bold" href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a><div><input type="submit" class="miss_back" data="'+value.profileid+'" onclick="action.missu(this)" value="Miss Back" /></div></div></div>'); 
				}); 
			}
			else
			{
				$('#text').remove();
			}
		}
		
		function request_fetch(me, data)
		{
			if(data.missu)
			{
				$('#text').html('<div class="subtitle" >Friends Missing You('+data.missu_count+')</div>');
				$.each(data.missu,function(index,value){
				$('#text').append('<div class="missu_reminder_class" data="'+value.profileid+'"><a href="profile.php?id='+value.profileid+'"><img class="lfloat" src="'+data.pimage[value.profileid]+'" height="50" width="50"></a><div class="name_50"><a class="bold" href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a><div><input type="submit" class="miss_back" data="'+value.profileid+'" onclick="action.missu(this)" value="Miss Back" /></div></div></div>');
				}); 
			}
			else
			{
				$('#text').append('<div class="missu_reminder_class">No MissU</div>');
			}
			if(data.friend)
			{
				$('#text').append('<div class="subtitle" >Friend Requests('+data.friend_request_count+')</div>');
				$.each(data.friend,function(index,value){
					$('#text').append('<div data="'+value.profileid+'" class="friend_request_class"><a href="profile.php?id='+value.profileid+'"><img class="lfloat" style="margin-right:1em;" src="'+data.pimage[value.profileid]+'" height="50" width="50"></a><div><a class="bold" href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a><div><input type="submit" class="frequest" id="1" value="Accept" onclick="action.friend_accept(this, 1)" /><input type="submit" class="frequest" style="margin-left:0.5em;" id="0" value="Deny" onclick="action.friend_accept(this, 0)" /></div></div></div>');
				});
			}
			else
			{
				$('#text').append('<div class="missu_reminder_class">No Friend Request</div>');
			}
			if(data.event)
			{
				$('#text').append('<div class="subtitle" >Event Requests('+data.event_request_count+')</div>');
				$.each(data.event,function(index,value){
					$('#text').append('<div data="'+value.eventid+'" class="friend_request_class"><a href="event.php?id='+value.eventid+'"><img class="lfloat" style="margin-right:1em;" src="http://icon.qmcdn.net/event.png" height="50" width="50"></a><div><a class="bold" href="event.php?id='+value.eventid+'">'+value.event_name+'</a><div><input type="submit" class="frequest" id="1" value="Going" data="'+value.eventid+'" onclick="action.guest_accept(this, 1)" /><input type="submit" class="frequest"  data="'+value.eventid+'"  style="margin-left:0.5em;" id="0" value="Decline" onclick="action.guest_accept(this, 0)" /></div></div></div>');
				});
			}
			else
			{
				$('#text').append('<div class="missu_reminder_class">No Event Request</div>');
			}
		}
		
		function missu_preview(me, data)
		{
			if(data)
			{
				$('#right').append('<div id="missu_recent" class="right_item"></div>');
				$('#missu_recent').html('<div class="subtitle" >Friends Being Missed</div>');
				$.each(data.action,function(index,value){ 
				$('#missu_'+value.actionon).remove();
				$('#missu_recent').append('<div class="container_32" id="missu_'+value.actionon+'"><a style="color:#336699;" href="profile.php?id='+value.actionon+'&pl=diary"><img class="lfloat" src="'+data.pimage[value.actionon]+'" height="32" width="32" /></a><div class="name_32"><a style="color:#336699;font-weight:bold;" href="profile.php?id='+value.actionon+'&pl=diary">'+data.name[value.actionon]+'</a></div></div>');
				});
			} 
			else
			{
				$('#missu_recent').remove();
			}
		}
		
		function mood(me, data)
		{
			if(data.ack)
			{
				$('#mood_container').html('<span>Your new mood has been set and your friends have been informed about your new mood.</span>');
				$('#mood_container').fadeOut(2000);
			}
		}				
		
		function mood_preview(me, data)
		{
			if(data)
			{
				$('#right').append('<div id="mood_recent" class="right_item"></div>');
				$('#mood_recent').html('<div class="subtitle" >Friend\'s Mood</div>');
				$.each(data.action,function(index,value){ 
				$('#mood_'+value.actionby).remove();
				$('#mood_recent').append('<div class="container_32_35" id="mood_'+value.actionby+'"><a style="color:#336699;" href="profile.php?id='+value.actionby+'&pl=diary"><img class="lfloat" src="'+data.pimage[value.actionby]+'" height="35" width="32" /></a><div class="name_32_35"><a style="color:#336699;font-weight:bold;" href="profile.php?id='+value.actionby+'&pl=diary">'+data.name[value.actionby]+'</a> is '+value.mood+'<div>'+value.page+'</div></div></div>');
				});
			} 
			else
			{
				$('#mood_recent').remove();
			}
		}
		
		function profile_update(me, data)
		{ 
			$("#save").html("Changes have been saved.");
			$('#loader2').html("");
			me.show();
		}
		
		function response(me, data)
		{
			if(data.ack == 1)
			{
				if(data.actiontype != 63)
				{
					me.parent().next().children().eq(0).prepend('<span>You,</span> ');
				}
				else
				{
					var excited_count = parseInt($(me).next().attr('data'))+1;
					me.next().attr('data',excited_count);
					me.next().html(excited_count+' excited');
				}	
			}	
		}
		
		function response_fetch(me, data)
		{
			$('#more_excite_people').remove();
			$('.bg_hide_cover').remove();
			$('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
			$('body').append('<div id="more_excite_people" class="container" style="position:fixed;top:18.2em;left:36em;overflow:auto;">Retreiving data</div>');
			$('#more_excite_people').append('<span onclick="ui.close()" class="container" style="position:absolute;top:1em;right:1em;cursor:pointer;">x</span>');
			$("#more_excite_people").remove();
			$('body').append('<div id="more_excite_people" class="container" style="background-color:#ffffff;left:50%;margin-left:-24em;overflow:auto;position:fixed;top:9em;width:26em;z-index:100;"><div style="font-weight:bold;color:#ffffff;font-size:1.3em;padding:0.5em 0em;background-color:#336699;text-align:center;" id="mood_title">People who responded to this<div onclick="ui.close()" style="float:right;cursor:pointer;margin-right:0.5em;">x</div></div></div>');
			$.each(data.excited,function(index,value){
			
				$('#more_excite_people').append('<div style="border-bottom:0.1em solid #cccccc;clear:both;height:5em;padding:1.5em;"><a href="profile.php?id='+value.profileid+'"><img class="lfloat" src="'+data.pimage[value.profileid]+'" alt="" height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a></div></div>');
			
			});
		}
		
		function responsed(me, data)
		{
			if(data=='1')
			{

			}	
			
			if(data.ack == 1)
			{
				if(data.actiontype != 63)
				{
					me.parent().next().children().eq(0).children().eq(0).remove();
				}
				else
				{
					var excited_count = parseInt($(me).next().attr('data'))-1;
					if(excited_count != 0)
					{
						me.next().attr('data',excited_count);
						me.next().html(excited_count+' excited');
					}	
					else
					{
						me.next().attr('data',excited_count);
						me.next().html('');
					}
				}	
			}
		}
		
		function show_all_comments(me, data)
		{
			var myprofileid = $('#myprofileid_hidden').attr('value');
			$.each(data.com,function(index,com){  
				var com_id = 'nf_post_'+com.com_actionid;
				var exciting = 'Exciting';
				var fun = 'action.response(this)';
				if(com.com_excited_mine)
				{ 
					exciting = 'Unexciting'; 
					fun = 'action.responsed(this)';
				}
				$(me).parent().after('<div class="cclass_json" id="'+com_id+'" data="'+ com.com_actionid +'"><a href="profile.php?id=' +com.commentby+ '"><img class="lfloat" src ="' +data.pimage[com.commentby]+ '" height="32" width="32" /></a><div class="name_35"><div><a class="bold" style="margin-right:0.4em;" href="profile.php?id=' +com.commentby+ '">' +data.name[com.commentby]+ '</a><pre>'+ui.get_smiley(ui.link_highlight(com.comment)) +'</pre></div><div><a class="comment_time_json" href="action.php?actionid='+com.com_pageid+'&life_is_fun='+data.life_is_fun+'"><img src="http://icon.qmcdn.net/clock.png" width="6" /><span class="time" data="'+com.com_time+'">'+time_difference(com.com_time)+'</span></a><span data=' +com.commentby+ ' class = "comment_excite_json" onclick="'+fun+'">'+exciting+'</span></div></div></div>');
				if(com.com_excited)
				{
					$("#"+com_id).children().eq(1).children().eq(1).append('<span style="margin-left:0.5em;font-size:0.9em;cursor:pointer;" data="'+ com.com_excited +'" onclick="action.response_fetch(this)" >'+ com.com_excited +' excited</span>');
				}
				else 
				{
					$("#"+com_id).children().eq(1).children().eq(1).append('<span style="margin-left:0.5em;font-size:0.9em;cursor:pointer;" data="0" class="more_excite_json" onclick="action.response_fetch(this)"></span>');
				}
				if(com.postby==myprofileid || com.commentby==myprofileid)
				{
					$("#"+com_id).append('<span class="del_post comment_setting" onclick="ui.post_delete(this)">x</span>');
				}
			});
			$(me).parent().remove(); 
		}
		
		function song_dedicate_preview(me, data)
		{
			if(data)
			{
				$('#right').append('<div id="dedicate_song" class="right_item"></div>');
				$('#dedicate_song').html('<div class="subtitle" >Recent Song-Dedications</div>');
				$.each(data.action,function(index,value){ 
				var file = 'http://song.qmcdn.net/'+value.file;
				$('#dedicate_song').append('<div class="container_32_35"><a style="color:#336699;" href="profile.php?id='+value.actionon+'&pl=diary"><img class="lfloat" src="'+data.pimage[value.actionon]+'" height="35" width="32" /></a><div class="name_32"><a style="color:#336699;font-weight:bold;" href="profile.php?id='+value.actionon+'&pl=diary">'+data.name[value.actionon]+'</a> from <a style="color:#336699;" href="profile.php?id='+value.actionby+'&pl=diary">'+data.name[value.actionby]+'</a><div style="color:#000000;">'+value.song+'</div></div></div>');
				});
			} 
			else
			{
				$('#dedicate_song').remove();
			}
		}
		
		function status_song_preview(me, data)
		{
			if(data)
			{
				$('#right').append('<div id="status_song" class="right_item"></div>');
				$('#status_song').html('<div class="subtitle" >Recent Status-Songs</div>');
				$.each(data.action,function(index,value){ 
				var file = 'http://song.qmcdn.net/'+value.file;
				$('#status_song').append('<div class="container_32_35"><a style="color:#336699;" href="profile.php?id='+value.actionby+'&pl=diary"><img class="lfloat" src="'+data.pimage[value.actionby]+'" height="35" width="32" /></a><div class="name_32_35"><a style="color:#336699;font-weight:bold;" href="profile.php?id='+value.actionby+'&pl=diary">'+data.name[value.actionby]+'</a><div style="color:#000000;">'+value.song+'</div></div></div>');
				});
			} 
			else
			{
				$('#status_song').remove();
			}
		}
		
		function status_song_set(me, data)
		{
			if(data.ack)
			{
				$('#song_status_popup_container').html('<span>This song has been set as your status.</span>');
				$('#bg_hide').remove();
				$('#song_status_popup_container').fadeOut(2000);
			}
		}
		
		function search(me, data)
		{
			if(data.count >= 0)
			{
				if(data.count > 1)
				{
					$('#search_count').html('Search results : '+data.count+' matches');
				}
				else
				{
					$('#search_count').html('Search result : '+data.count+' match');					
				}
				$('#search_result').html('');
				$.each(data.action, function(index, value)
				{
				if(data.filter == 'people')
				{
					$('#search_result').append('<div class="people_each"><a href="profile.php?id='+value.profileid+'"><img class="lfloat" src="'+data.pimage[value.profileid]+'" height="80" width="80" /></a><div class="name_80"><a class="bold" href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a></div></div>');
				}
				else if(data.filter == 'group')
				{
					$('#search_result').append('<div class="people_each"><a href="group.php?id='+value.profileid+'"><img class="lfloat" src="'+data.pimage[value.profileid]+'" height="80" width="80" /></a><div class="name_80"><a class="bold" href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a><div>'+data.description[value.profileid]+'</div></div></div>');
				}
				else if(data.filter == 'event')
				{
					$('#search_result').append('<div class="people_each"><a href="event.php?id='+value.profileid+'"><img class="lfloat" src="'+data.pimage[value.profileid]+'" height="80" width="80" /></a><div class="name_80"><a class="bold" href="event.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a><div>'+data.description[value.profileid]+'</div></div></div>');
				}
				else if(data.filter == 'post' || data.filter == 'comment')
				{
					$('#search_result').append('<div class="people_each"><a href="profile.php?id='+value.profileid+'"><img class="lfloat" src="'+data.pimage[value.profileid]+'" height="80" width="80" /></a><div class="name_80"><a class="bold" href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a><div>'+value.page+'</div></div></div>');
				}
				});
			}
			else
			{
				$('#search_count').html('Please enter a search string');
			}
		}
		
		function song_load_more(me, data)
		{
			if(data)
			{	
				$.each(data.song,function(index,value){
				var file = 'http://song.qmcdn.net/'+value.file;
					$('#song_search_callback').append('<div id="'+value.songid+'" style="position:relative;height:7em;"><div style="display:block;margin:.5em 0em 1em 0em;color:#336699;font-weight:bold;">'+value.song+'</div><div style="position:absolute;top:0em;right:12.1em;"><input type="submit" class="song_status_button" style="margin-left:.5em;background:#336699;height:2em;width:9em;font-weight:bold;color:white;cursor:pointer;" value="Set as Status" ></div><div style="margin-right:1em;"><embed type="application/x-shockwave-flash" flashvars="audioUrl='+file+'" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="400" height="27" quality="best" wmode="transparent"></embed></div></div>');
				});
			}
		}
		
		function song_search(me, data)
		{
			if(data)
			{	
				$('#song_search_callback').html('');
				$.each(data.song,function(index,value){
					var file = 'http://song.qmcdn.net/'+value.file;
					$('#song_search_callback').append('<div id="'+value.songid+'" style="position:relative;height:7em;"><div style="display:block;margin:.5em 0em 1em 0em;color:#336699;font-weight:bold;">'+value.song+'</div><div style="position:absolute;top:0em;right:12.1em;"><input type="submit" class="song_status_button" style="margin-left:.5em;background:#336699;height:2em;width:9em;font-weight:bold;color:white;cursor:pointer;" value="Set as Status" onclick="ui.status_song_button_click(this,'+value.songid+')"></div><div style="margin-right:1em;"><audio src="'+file+'" preload="auto" /><div class="track-details">'+value.song+'</div></div></div>');
				});
			}	
		}
		
		function tagline_preview(me, data)
		{
			if(data)
			{
				$('#right').append('<div id="tagline_recent" class="right_item"></div>');
				$('#tagline_recent').html('<div class="subtitle" >Friend\'s Tagline</div>');
				$.each(data.action,function(index,value){ 
				$('#tagline_'+value.actionby).remove();
				$('#tagline_recent').append('<div class="container_32_35" id="tagline_'+value.actionby+'"><a style="color:#336699;" href="profile.php?id='+value.actionby+'&pl=diary"><img class="lfloat" src="'+data.pimage[value.actionby]+'" height="35" width="32" /></a><div class="name_32"><a style="color:#336699;font-weight:bold;" href="profile.php?id='+value.actionby+'&pl=diary">'+data.name[value.actionby]+'</a><div>'+value.tagline+'</div></div></div>'); 
				});
			} 
			else
			{
				$('#tagline_recent').remove();
			}
		}
		
		function postDelete(me,data)
		{
			if(data.ack)
			{
				$('#nf_post_'+data.actionid).remove();
				$('#nf_post_'+data.pageid+'_'+data.actionid).remove();
				$('#if_post_'+data.pageid+'_'+data.actionid).remove();
				$('.prompt_container').remove();
				$('.prompt_content').html('Action successfully performed');
				$('.prompt_button').html('<input id="prompt_ok" class="prompt_positive" type="submit" value="Ok" onClick='+ui.bg_hide(this)+' />');
			}
			else
			{
				$('.prompt_content').html('Error performing the action, please try again');
			}
		}
		function bio_update(me,data)
		{
			$("#save").html("Changes have been saved."); 
			$(me).show();
		}
		function recover_password(me,data)
		{
			if(data == 2)
			{
				$('#recover_password_info').html('Your password has been updated successfully.<h3><span style="color:#000000"> Login to Quipmate</span></h3>');
			}
			else 
			{
				$('#recover_password_info').html(data.error.message);
			}	
		}
		
		function change_password(me,data)
		{
			if(data == 2)
			{
				$('#change_password_info').html('Your password has been updated successfully');
			}
			else 
			{
				$('#change_password_info').html(data.error.message);
			}	
		}
		
		function self_invite(me, data)
		{
			if(data.ack)
			{
				$('#signup_info').html(data.message);
				$('#signup_email').val('');
			}
			else 
			{
				$('#signup_info').html(data.error.message);
			}	
		}
		
		
		
		function register(me, data)
		{
			if($.trim(data.ack)==1)
			{
				$('#info').html("<span style=color:#00ff00>Fine</span>");	
				window.location ='/';
			}	
			else
			{
				$('#info').html(data.error.message);
				$("#loading").remove();
				$(me).show();
			}
		}

		function group_leave(me,data)
		{
			var profileid = $('#profileid_hidden').attr('value');
			if(data.ack)
			{
				$('.prompt_content').html('You have successfully left the group');
				$('.prompt_button').html('<input class="prompt_positive" type="submit" value="Ok" onClick='+ui.goBacktoProfile(profileid)+'/>');
			}
			else
			{
				$('.prompt_content').html('Error performing the action, please try again');
			}

		}		
		
		function unfriend(me,data)
		{
			var profileid = $('#profileid_hidden').attr('value');
			var profile_name = $('#profilename_hidden').attr('value');
			if(data.ack)
			{
				$('.prompt_content').html(profile_name+ ' has been successfully removed from your friend list');
				$('.prompt_button').html('<input class="prompt_positive" type="submit" value="Ok" onClick='+ui.goBacktoProfile(profileid)+'/>');
			}
			else
			{
				$('.prompt_content').html('Error performing the action, please try again');
			}

		}
		
		function profile_privacy_update(me, data)
		{
			if(data.ack)
			{
				if(data.privacy == 0)
				{
					$(profile_post_privacy_link).html('<img title="Your next post will be shared with everyone on Quipmate" src="http://icon.qmcdn.net/global.png" height="20" width="20" />');
				}
				else if(data.privacy == 1)
				{
					$(profile_post_privacy_link).html('<img title="Your next post will be shared with your friends of friends" src="http://icon.qmcdn.net/meeting.png" height="20" width="20" />');
				}
				else if(data.privacy == 2)
				{
					$(profile_post_privacy_link).html('<img title="Your next post will be shared only with your friends" src="http://icon.qmcdn.net/friend.png" height="20" width="20" />');
				}
					
			}
			
		}
		
		function notification_setting_update(me)
		{
			
		}
		
		function tagline(me, data)
		{
			if($.trim(data)=='1')
			{
				$('#tagline_con').html('Your tagline has been successfully set.');
				$('#tagline_container').fadeOut(2000);
			}
		}
		function song_dedicate(me,data)
		{
			if(data.ack)
			{
				$('#song_dedicate_popup_container').html('<span>The song has been dedicated.</span>');
				$('#bg_hide').remove();
				$('#song_dedicate_popup_container').fadeOut(2000);
			}
		}
		
	return {
		
		    answer : answer,
			add_friend : add_friend,
			birthday_all : birthday_all,
			bio_update : bio_update,
			bio_item_remove : bio_item_remove,
			change_password : change_password,
			comment : comment,
			comment_excite : comment_excite,
			comment_excite_show : comment_excite_show,
			crush_preview : crush_preview,
			crush_match_preview : crush_match_preview,
			event_create : event_create,
			event_join : event_join,
			event_suggest : event_suggest,
			group_suggest : group_suggest,
			group_suggest_page : group_suggest_page,
			forgot_password : forgot_password,
			friend_accept : friend_accept,
			friend_event : friend_event,
			friend_match : friend_match,
			friend_invite : friend_invite,
			friend_suggest : friend_suggest,
			friend_suggest_page : friend_suggest_page,
			friend_request_fetch : friend_request_fetch,
			friendship_preview : friendship_preview,
			gift : gift,
			gift_preview : gift_preview,
			group_create : group_create,
			group_invite : group_invite,
			group_join : group_join,
			group_leave : group_leave,
			group_settings_save : group_settings_save,
			guest_accept : guest_accept,
			message : message,
			member_accept : member_accept,
			message_drop : message_drop,
			member_request_fetch : member_request_fetch,
			message_recent_fetch : message_recent_fetch,
			missu : missu,
			missu_fetch : missu_fetch,
			missu_preview : missu_preview,
			mood : mood, 
			mood_preview : mood_preview,
			postDelete : postDelete,
			profile_update : profile_update,
			profile_privacy_update : profile_privacy_update,
			question : question,
			notification_setting_update : notification_setting_update,
			recover_password : recover_password,
			register : register,
			request_fetch : request_fetch,
			response : response,
			response_fetch : response_fetch,
			responsed : responsed,
			self_invite : self_invite,
			search : search,
			show_all_comments : show_all_comments,
			song_dedicate_preview : song_dedicate_preview,
			status_song_preview : status_song_preview,
			status_song_set : status_song_set,
			song_load_more : song_load_more,
			song_search : song_search,
			tagline : tagline,
			tagline_preview : tagline_preview,
			unfriend : unfriend
			
			}
	})();