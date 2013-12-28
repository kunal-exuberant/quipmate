	
var action = (function(){
			
			var url = 'ajax/write.php';
			var param = {};
			var data = {};
			
			function actiontype_preview(me)
			{
				var rand = Math.random()*20;
				param.action = 'actiontype_preview';
				if(rand >= 10)
				{
					param.actiontype = 1201;
					ajax.getJSON_ajax(url, param, me, callback.mood_preview);
					param.actiontype = 501;
					ajax.getJSON_ajax(url, param, me, callback.missu_preview);
				}
				else
				{
					param.actiontype = 1401;
					ajax.getJSON_ajax(url, param, me, callback.gift_preview);
					param.actiontype = 800;
					ajax.getJSON_ajax(url, param, me, callback.tagline_preview);
					param.actiontype = 8;
					ajax.getJSON_ajax(url, param, me, callback.friendship_preview);
				}
			}
			
			function group_join(me)
			{
				$(me).attr("value",'Requesting...'); 
				param.action = 'group_join';
				param.groupid = $(me).attr('id');
				ajax.getJSON_ajax(url, param, me, callback.group_join);
			}
			
			function event_join(me)
			{
				$(me).attr("value",'Joining...'); 
				param.action = 'event_join';
				param.eventid = $(me).attr('id');
				ajax.getJSON_ajax(url, param, me, callback.event_join);
			}
			
			function add_friend(me, profileid)
			{
				$(me).attr("value",'Inviting...'); 
				param.action = 'add_friend';
				param.profileid = profileid;
				param.msg = 'Hi';
				ajax.getJSON_ajax(url, param, me, callback.add_friend);
			}
			
			function album_upload_button_click(me)
			{
				param.action = 'album_upload';
				$('#mform').ajaxForm(function() {
				});  
				$('#moment_upload_button').live('click', function()
				{
					var moment_name = $.trim($('#moment_name').attr('value'));
						$("#moment_preview").html('<img src="http://icon.qmcdn.net/loading.gif" alt="Uploading...."/>');
						$("#mform").ajaxSubmit(
						{
							type:'json',
							success: function(response){
								var data = $.parseJSON(response);
								callback.album_upload($('#prev'), data);
							}
						});
					return false;
				}); 
			}
			
			function birthday_bomb(me, profileid, wish, date)
			{
				$(me).hide();
				$('#birthday_wish_container').html('<span>Wishing...</span>');
				param.action = 'birthday_bomb';
				param.profileid = profileid;
				param.date = date;
				param.wish = wish;
				ajax.getJSON_ajax(url, param, me, callback.birthday_bomb);				
			}
			
			function birthday_fetch(me)
			{
				
			}
			
			function birthday_all(me)
			{
			
			}
			
			function comment(me, event)
			{
				var e = event.which;
				if(e==13)
				{
					param.action = 'comment';
					param.pageid = $(me).parent().parent().parent().attr('data');
					param.comment = $.trim($(me).val());
					$(me).val('');
					var me = $(me).parent().prev();
					ajax.getJSON_ajax(url, param, me, callback.comment);
				}	
			}
			
			function option_add(me, event)
			{
				var e = event.which;
				if(e==13)
				{
					$(me).parent().append('<div class="ask_option">'+$(me).attr('value')+'</div>');	
					$(me).attr('value','');
				}				
			}	

			function answer(me,pageid,optionid)
			{
				param.action = 'answer';
				param.optionid  = optionid;
				param.pageid = pageid;
				ajax.getJSON_ajax(url, param, me, callback.answer);
			}			
			
			function question_button(me)
			{
				var option = [];
				$('.ask_option').each(function(elem){
					option.push($(this).html());
				});
				param.action = 'post_question';
				param.question = $('#question_box').val();
				param.option = option;
				param.profileid = $('#profileid_hidden').attr('value');
				ajax.getJSON_ajax(url, param, me, callback.question);
			}
			
			function group_question_button(me)
			{
				var option = [];
				$('.ask_option').each(function(elem){
					option.push($(this).html());
				});
				param.action = 'group_post_question';
				param.question = $('#question_box').val();
				param.option = option;
				param.profileid = $('#profileid_hidden').attr('value');
				ajax.getJSON_ajax(url, param, me, callback.question);
			}
			
			function response_fetch(me)
			{
				param.action = 'response_fetch';
				param.pageid = $(me).parent().parent().parent().attr('data');
				$("#more_excite_people").remove(); 
				$('body').append('<div id="more_excite_people" style="position:fixed;top:18.2em;left:36em;overflow:auto;">Retreiving data</div>');
				$('#more_excite_people').append('<span id="diary_close" style="position:absolute;top:1em;right:1em;cursor:pointer;">x</span>');
				data = ajax.getJSON_ajax(url, param, me, callback.response_fetch);
			}
			
			function answer_people_fetch(me,optionid)
			{
				param.action = 'answer_people_fetch';
				param.optionid = optionid;
				$("#more_excite_people").remove(); 
				$('body').append('<div id="more_excite_people" style="position:fixed;top:18.2em;left:36em;overflow:auto;">Retreiving data</div>');
				$('#more_excite_people').append('<span id="diary_close" style="position:absolute;top:1em;right:1em;cursor:pointer;">x</span>');
				data = ajax.getJSON_ajax(url, param, me, callback.response_fetch);
			}
			
			function suggest_know(me)
			{
				$('#friend_req').remove();
				var profileid = $(me).parent().parent().parent().attr('data');
				$('#center, #right , #left , #header').css("opacity",".4");
				$('body').append('<div style="cursor:pointer;position:fixed;left:45em;top:20em;height:250px;width:36em;background:#f9f9f9;border:.4em solid #7090ab;border-radius:.2em;z-index:189;" id="friend_req"></div>');
				$('#friend_req').append('<span id="know_close" style="position:absolute;top:1em;right:1em;font-size:1.5em;color:black:font-weight:bold;">x</span>');
				$('#friend_req').append('<p align="center"><img src="http://icon.qmcdn.net/loading.gif" id="loading"></p>');
				$('#know_close').live('click',function(){
				$('#loading').remove();
				$('#center, #right , #left , #header').css("opacity","1");
				$('#friend_req').remove();
				});
				$.getJSON('ajax/write.php',{action:'friend_details_fetch',profileid:profileid},function(data){
				$('#loading').remove(); 
				$.each(data.info,function(index,value)
				{
				$('#friend_req').append('<div class="people" id="'+value.profileid+'" class=""><div style="position:relative;top:1em;left:2em;height:4em;"><div><a href="profile.php?id='+value.profileid+'"><img class="lfloat" src='+data.pimage[value.profileid]+' height="80" width="80" /></a></div><div style="position:relative;top:-7em;left:8.5em;"><a href="profile.php?id='+value.profileid+'">'+data.name[value.profileid]+'</a></div>');
				$('#friend_req').append('<div style="position:relative;top:-3em;left:8.5em;">'+value.age+' years</div>');
				if(value.city!=null)
				{
					$('#friend_req').append('<div style="position:relative;top:-2em;left:8.5em;">'+value.city+'</div>');
				}
				if(value.school!=null)
				{
					$('#friend_req').append('<div style="position:relative;top:-1em;left:8.5em;">'+value.school+'</div>');
				}	
				if(value.college!=null)
				{
					$('#friend_req').append('<div style="position:relative;top:-0em;left:8.5em;">'+value.college+'</div>');
				}
				if(value.profession!=null)
				{
					$('#friend_req').append('<div style="position:relative;top:1em;left:8.5em;">'+value.profession+'</div>');
				}
				});
		});
			}
			
			function createCookie(name, value, days) 
			{
				if (days) 
				{
					var date = new Date();
					date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
					var expires = "; expires=" + date.toGMTString();
				}
				else var expires = "";
				document.cookie = name + "=" + value + expires + "; path=/";
			}
			
			function getCookie(c_name) 
			{
				if (document.cookie.length > 0) 
				{
					c_start = document.cookie.indexOf(c_name + "=");
					if (c_start != -1) 
					{
						c_start = c_start + c_name.length + 1;
						c_end = document.cookie.indexOf(";", c_start);
						if (c_end == -1) 
						{
							c_end = document.cookie.length;
						}
						return unescape(document.cookie.substring(c_start, c_end));
					}
				}
				return "";
			}
			
			function cookie_delete(name) 
			{
				document.cookie = name + '=; Max-Age=0'
			}
			
			function forgot_password(me)
			{
				$('#forgot_password_info').html("Sending Email...");
				param.action = 'forgot_password';
				param.email = $("#forgot_password_email").attr("value");
				ajax.getJSON_ajax(url, param, me, callback.forgot_password);
			}
			
			function change_password(me)
			{
				$('#change_password_info').html("Updating...");
				param.action ='change_password';
				param.old_password = $('#old_password').val();
				param.new_password = $('#new_password').val();
				param.confirm_password = $('#confirm_password').val();
				data = ajax.postJSON_ajax(url, param, me, callback.change_password);
			}
			
			function self_invite(me)
			{
				$('#signup_info').html("Signing Up...");
				param.action ='self_invite';
				param.email = $('#signup_email').val();
				data = ajax.getJSON_ajax(url, param, me, callback.self_invite);
			}
			
			function recover_password(me)
			{
					$('#recover_password_info').html("Updating...");
					param.action ='recover_password';
					param.new_password = $("#pass").val();
					param.confirm_password = $("#confirmpass").val();
					param.email = $("#recover_password_email").val();
					param.id = $("#recover_password_uniqueid").val();
					data = ajax.postJSON_ajax(url, param, me, callback.recover_password);
			}
			
			function friend_invite(me)
			{
				$('#invite_button').attr('id','inviting');
				param.action = 'friend_invite';
				param.email = $('#invite_box').attr('value');
				if(param.email != '')
				{
					$(me).attr('value','Inviting');
					ajax.getJSON_ajax(url, param, me, callback.friend_invite);
				}
			}
			
			function friend_match(me)
			{
				var profileid=$('#profileid_hidden').attr('value');
				var myprofileid=$('#myprofileid_hidden').attr('value');
				if(profileid != myprofileid)
				{
					param.action = 'mutual_friend';
					param.profileid = profileid;
					
					
					ajax.getJSON_ajax(url, param, me, callback.friend_match);
				}
			}
			
			function friend_load(me)
			{
				param.action = 'friend_load';
				param.profileid = profileid;
				var data = ajax.getJSON_ajax(url, param, me, callback.friend_load);
			}
			
			function friend_request_fetch(me)
			{
				param.action = 'friend_request_fetch';
				ajax.getJSON_ajax(url, param, me, callback.friend_request_fetch);
			}
			
			function member_request_fetch(me)
			{
				param.action = 'member_request_fetch';
				param.groupid = $('#profileid_hidden').attr('value');
				ajax.getJSON_ajax(url, param, me, callback.member_request_fetch);
			}
			
			function friend_accept(me, flag)
			{
				$(me).html('<img src="http://icon.qmcdn.net/loading.gif" />');
				param.action = 'friend_request_accept';
				param.flag = flag;
				param.profileid = $(me).parent().parent().parent().attr('data');
				var me = $(me).parent().parent().parent();
				$(me).attr('class','accepted');
				ajax.getJSON_ajax(url, param, me, callback.friend_accept);
			}
			
			function group_invite(me, flag)
			{
				$(me).html('<img src="http://icon.qmcdn.net/loading.gif" />');
				param.action = 'group_invite';
				param.flag = flag;
				param.eventid = $('#profileid_hidden').attr('value');
				param.profileid = $(me).attr('data');
				ajax.getJSON_ajax(url, param, me, callback.group_invite);
			}
			
			function event_invite(me, flag)
			{
				$(me).html('<img src="http://icon.qmcdn.net/loading.gif" />');
				param.action = 'event_invite';
				param.flag = flag;
				param.eventid = $('#profileid_hidden').attr('value');
				param.profileid = $(me).attr('data');
				ajax.getJSON_ajax(url, param, me, callback.group_invite);
			}
			
			function member_accept(me, flag)
			{
				$(me).html('<img src="http://icon.qmcdn.net/loading.gif" />');
				param.action = 'member_request_accept';
				param.flag = flag;
				param.profileid = $(me).parent().parent().parent().attr('data');
				var me = $(me).parent().parent().parent();
				$(me).attr('class','accepted');
				ajax.getJSON_ajax(url, param, me, callback.member_accept);
			}
			function guest_accept(me, flag)
			{
				param.action = 'guest_accept';
				param.flag = flag;
				param.eventid = $(me).attr('data');
				var me = $(me).parent().parent().parent();
				$(me).attr('class','accepted');
				$(me).html('<img src="http://icon.qmcdn.net/loading.gif" />');
				ajax.getJSON_ajax(url, param, me, callback.guest_accept);
			}
			
			function friend_suggest(me,count)
			{
				param.action = 'friend_suggest';
				param.count = count;
				ajax.getJSON_ajax(url, param, me, callback.friend_suggest);
			}
			
			function friend_suggest_page(me,count)
			{
				param.action = 'friend_suggest';
				param.count = count;
				ajax.getJSON_ajax(url, param, me, callback.friend_suggest_page);
			}
			
			function group_suggest_page(me,count)
			{
				param.action = 'group_suggest';
				param.count = count;
				ajax.getJSON_ajax(url, param, me, callback.group_suggest_page);
			}
			
			function group_suggest(me,count)
			{
				param.action = 'group_suggest';
				param.count = count;
				ajax.getJSON_ajax(url, param, me, callback.group_suggest);
			}
			
			function event_suggest(me,count)
			{
				param.action = 'event_suggest';
				param.count = count;
				ajax.getJSON_ajax(url, param, me, callback.event_suggest);
			}
			
			function gift(me, gift)
			{
				param.action = 'gift';
				param.profileid = $('#profileid_hidden').attr('value');
				param.gift = gift;
				param.gift_desc = $.trim($('#gift_desc').attr('value'));
				$('#gift_done').hide();
				$('#gift_container').html('<span>Sending your gift...</span>');
				ajax.getJSON_ajax(url, param, me, callback.gift);
			}		
			
			function group_create(me)
			{
				param.action = 'group_create';
				param.name = $('#group_name').attr('value');
				param.description = $('#group_description').attr('value');
				param.privacy = $("#group_privacy").val();
				param.technical = 0;
				if($('#group_technical:checked').length == 1)
					param.technical = 1;
				ajax.getJSON_ajax(url, param, me, callback.group_create);
			}
			
				
			function group_admin_make(me,priviledge)
			{
				if(priviledge == 1)
				{	
					param.action = 'group_admin_make';
				}
				else if(priviledge == 0)
				{	
					param.action = 'group_admin_remove';
				}
				else if(priviledge == 2)
				{
					param.action = 'group_member_remove';					
				}
				param.profileid = $(me).parent().parent().attr('data');
				param.groupid = $('#profileid_hidden').attr('value');
				ajax.getJSON_ajax(url, param, me, callback.add_friend);
			}
			
			function group_settings_save(me)
			{
				param.action = 'group_settings_save';
				param.groupid = $('#profileid_hidden').attr('value');
				param.link = $('#group_link').val();
				param.description = $('#group_description').val();
				param.privacy = $("#group_privacy").val();
				param.invite = 0;
				if($('#group_invite:checked').length == 1)
					param.invite = 1;
				ajax.getJSON_ajax(url, param, me, callback.group_settings_save);
			}
			
			function event_settings_save(me)
			{
				param.action = 'event_settings_save';
				param.eventid = $('#profileid_hidden').attr('value');
				param.day = $('#event_day').val();
				param.month = $('#event_month').val();
				param.year = $('#event_year').val();
				param.time = $('#event_time').val();
				param.venue = $('#event_where').val();
				param.description = $('#group_description').val();
				param.privacy = $("#group_privacy").val();
				param.invite = 0;
				if($('#group_invite:checked').length == 1)
					param.invite = 1;
				ajax.getJSON_ajax(url, param, me, callback.group_settings_save);
			}
			
			function event_create(me)
			{
				param.action = 'event_create';
				param.name = $('#event_name').attr('value');
				param.description = $('#event_description').attr('value');
				param.privacy = $("#event_privacy").val();
				param.day = $("#event_day").val();
				param.month = $("#event_month").val();
				param.year = $("#event_year").val();
				param.time = $("#event_time").val();
				param.venue = $("#event_where").val();
				param.invite = 0;
				if($('#event_invite:checked').length == 1)
					param.invite = 1;
				ajax.getJSON_ajax(url, param, me, callback.event_create);
			}
			
			function profile_privacy_update(me)
			{
				param.action = 'profile_privacy_update';
				param.privacy = $(me).attr('value');
				param.field = $(me).attr('data');
				$('#profile_post_privacy_drop').remove();
				ajax.getJSON_ajax(url, param, me, callback.profile_privacy_update);
			}
			
			function notification_setting_update(me)
			{
				param.action = 'notification_setting_update';
				param.field = $(me).attr('data');
				ajax.getJSON_ajax(url, param, me, callback.notification_setting_update);
			}
			
			function email_setting_update(me)
			{
				param.action = 'email_setting_update';
				param.field = $(me).attr('data'); 
				ajax.getJSON_ajax(url, param, me, callback.notification_setting_update);
			}
			
			function message(me)
			{
				param.action = 'message';
				param.message = $.trim($('#message_textarea').val());
				if(param.message != '')
				{
					$('#message_textarea').val('');
					$('#message_ok').hide();
					$('#message_container').html('<span>Sending...</span>');
					ajax.getJSON_ajax(url, param, me, callback.message);
				}
			}
			
			function message_drop(me)
			{
				param.action = 'message';
				param.profileid = $('#profileid_hidden').attr('value');
				param.message = $.trim($('#message_textarea').val());
				$('#message_textarea').val('');
				ajax.getJSON_ajax(url, param, me, callback.message_drop);
			}
			
			function missu_fetch(me)
			{
				param.action = 'missu_fetch';
				ajax.getJSON_ajax(url, param, me, callback.missu_fetch);
			}
			
			function missu(me)
			{
				$(me).attr('class','missed_back'); 
				$(me).attr('value','Missing');
				param.profileid = $(me).attr('data');
				param.action = 'missu';
				ajax.getJSON_ajax(url, param, me, callback.missu);
			}
			
			function mood_done(me, mood)
			{			
				param.action = 'mood';
				param.mood_desc = $.trim($('#mood_desc').attr('value'));
				param.mood = mood;
				if(mood_desc !='' && mood_desc !="Add few more words" )
				{
					$('#mood_done').hide();
					$('#mood_container').html('<span>Setting your mood...</span>');
					var myprofileid = $('#myprofileid_hidden').attr('value');
					ajax.getJSON_ajax(url, param, me, callback.mood);
				}
			}
			
			function photo_upload()
			{
				$('#pform').ajaxForm(function(){ });  
				$("#photo_preview").html('<img src="http://icon.qmcdn.net/loading.gif" alt="Uploading...."/>');
				$("#pform").ajaxSubmit(
				{
					type:'json',
					success: function(response)
					{
						var data = $.parseJSON(response);
						callback.photo_upload(me, data);	
					}
				});
			}
			
			function register(me)
			{
				param.action = 'validate_user';
				param.email = $(me).parent().children(0).attr('value');
				param.identifier = $('#identifier_hidden').val();
				$(me).hide();
				$('#signup_button_container').append("<img src = 'http://icon.qmcdn.net/loading.gif' alt='signing up...' id = 'loading' />");
				param.name = $('#signup_name').val();
				param.password = $('#signup_password').val();
				param.gender = $('#signup_gender').val();
				param.day = $('#day').val();
				param.month = $('#month').val();
				param.year = $('#year').val(); 
				ajax.postJSON_ajax(url, param, me, callback.register);
			}
			
			
			function response(me)
			{ 
				var pagetype = $(me).parent().parent().parent().children().eq(1).attr('value');
				if(pagetype=='50')
					$(me).html('Unpinch ');
				else
					$(me).html('Unexciting ');
				$(me).attr('onclick', 'action.responsed(this)');
				$(me).parent().next().children().eq(0).focus();
				param.action = 'response';
				param.pageid = $(me).parent().parent().parent().attr('data');
				me = $(me).parent().children().eq(1);
				ajax.getJSON_ajax(url, param, me, callback.response);
			}
			
			function responsed(me)
			{	
				var pagetype = $(me).parent().parent().parent().children().eq(1).attr('value');
				if(pagetype=='50')
					$(me).html('New-Pinch ');
				else
					$(me).html('Exciting ');
				$(me).attr('onclick', 'action.response(this)');
				$(me).parent().next().children().eq(0).focus();
				param.action = 'responsed';
				param.pageid = $(me).parent().parent().parent().attr('data');
				me = $(me).parent().children().eq(1);
				ajax.getJSON_ajax(url, param, me, callback.responsed);
			}
			
			function rtm_load(me)
			{
				var rtm_load = true;
				var start = 50;
				$('#rtm_container').bind('scroll',function(){ 
					if($('#rtm_container').get(0).scrollTop > $('#rtm_container').get(0).scrollHeight * 0.6 && rtm_load)
					{
						rtm_load = false;
						
						$.getJSON('ajax/news_json.php',{profileid:profileid,start:start,real_time:'real_time'},function(data){
							start += 10;
							rtm_load = true;
							real_time_deploy_append(data);
						});
					}
				});
			}
			
			var request = [],i;
			
			function search(me)
			{
				param.action = 'search';
				param.q = $('#search_key_hidden').attr('value');
				param.filter = $('#filter_hidden').attr('value');
				ajax.getJSON_ajax(url, param, me, callback.search);
			}
			
			function search_ajax(me)
			{
				var q = $.trim($('#to').attr('value'));
				$('#to').bind('keyup mousedown input',function(){
					if(q != $.trim($('#to').attr('value')) && $.trim($('#to').attr('value')) != '')
					{ 
						for(i = 0; i < request.length; i++)
						{
							request[i].abort();
						}
						q = $.trim($('#to').attr('value'));
						request.push($.getJSON('ajax/search_ajax.php',{q:q},function(data){
							
							$('#session_name_hidden').attr('value', JSON.stringify(data.name));
							$('#session_pimage_hidden').attr('value', JSON.stringify(data.pimage));
							
						}));
						
						$('#search_container').html('');
						var global_name = JSON.parse($('#session_name_hidden').attr('value'));
						var global_pimage = JSON.parse($('#session_pimage_hidden').attr('value'));
						var count = 0;
						$.each(global_name,function(index,value){
						   if(value != null)
						   {
								if(q.indexOf(' ') == -1)
								{
									var search_name = value.toLowerCase().split(" ");
									for(var i=0;i<search_name.length;i++)
									{		
										if((count < 9) && (search_name[i].toLowerCase().search('^'+q.toLowerCase()) != -1)) 
										{
												$('#search_container').append('<div class="search_items container_50" data="'+index+'"><a href="profile.php?id='+index+'"><img class="lfloat" src='+global_pimage[index]+' width="50" height="50" /></a><div class="name_50"><a href="profile.php?id='+index+'">'+global_name[index]+'</a></div></div>');
												$('.search_items:first').css('background','#336699');
												$('.search_items:first .name_50 a').css('color','white');
												count++;
										}

									}
								}
								else
								{
									if((count < 9) && (value.toLowerCase().search('^'+q.toLowerCase()) != -1)) 
									{
											$('#search_container').append('<div class="search_items container_50" data="'+index+'"><a href="profile.php?id='+index+'"><img class="lfloat" src='+global_pimage[index]+' width="50" height="50" /></a><div class="name_50"><a href="profile.php?id='+index+'">'+global_name[index]+'</a></div></div>');
											$('.search_items:first').css('background','#336699');
											$('.search_items:first .name_50 a').css('color','white');
											count++;
									}
								}	
							}		
						});
						
						$('#to').keydown(function(e){
							if(e.keyCode == 40)
							{
								$('#search_conainer').focus();
							}
						});
					}
				});
			}
			
			function show_all_comments(me)
			{
				$(me).html('<span style="padding-left:10px;" id="loadtext">Loading...</span>');
				$(me).removeClass();
				param.action = 'show_all_comments';
				param.pageid = $(me).parent().parent().parent().attr('data');
				var t = $(me).parent();
				var data = ajax.getJSON_ajax(url, param, me, callback.show_all_comments);	
			}
			
			function song_dedicate_song_fetch(me)
			{
				var song_limit = 0;
				var q;
				$('#song_dedicate_search_textbox').live('keyup',function(e){
					song_limit = 0;
					if($(me).attr('value') == "Start typing any song...")
					{
						$(me).attr('value',''); 
					}
					q = $(me).val();
					$.getJSON('ajax/write.php',{action:'song_search',q:q,song_limit:song_limit},function(data){
					if(data)
					{	
					$('#song_search_callback').html('');
					$.each(data.song,function(index,value){
					var file = 'http://song.qmcdn.net/'+value.file;
						$('#song_search_callback').append('<div id="'+value.songid+'" style="position:relative;height:7em;"><div style="display:block;margin:.5em 0em 1em 0em;color:#336699;font-weight:bold;">'+value.song+'</div><div style="position:absolute;top:0em;right:15.1em;"><input type="submit" class="song_dedicate_button" style="margin-left:.5em;background:#336699;height:2em;width:9em;font-weight:bold;color:white;cursor:pointer;" value="Dedicate Song" ></div><div style="margin-right:1em;"><embed type="application/x-shockwave-flash" flashvars="audioUrl='+file+'" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="400" height="27" quality="best" wmode="transparent"></embed></div></div>');
					});
					}
					});
				});
			}
			
			function song_dedicate(me)
			{		
				$('#song_dedicate_done_button').live('click',function(data){ 
					$(me).hide();
					var song_line = $('#song_dedicate_popup_textarea').val();
					var profileid = $('#profileid_hidden').attr('value');
					$.getJSON('ajax/write.php',{profileid:profileid,songid:songid,song_line:song_line,action:'song_dedicate'},function(data){
						if(data.ack)
						{
							$('#song_dedicate_popup_container').html('<span>The song has been dedicated.</span>');
							$('#bg_hide').remove();
							$('#song_dedicate_popup_container').fadeOut(2000);
						}
					});
				});	
			}
			
			function song_status_done_button_click(me, songid)
			{
				$(me).hide();
				param.action = 'status_song';
				param.song_status = $('#song_status_popup_textarea').val();	
				param.songid = songid;
				var t = $(me).parent();
				ajax.getJSON_ajax(url, param, t, callback.status_song_set);	
			}
			
			function song_load_more_click(me)
			{
				$('#song_load_more').live('click',function(){
					song_limit +=6;
					param.song_status = song_status;
					param.songid = songid;
					var t = $(me).parent();
					var data = ajax.getJSON_ajax(url, param);	
					callback.status_song_set(t, data);
				});
			}
			
			function song_search(me,flag)
			{
				var song_limit = 0;
				var q = '';
				song_limit = 0;
				if($(me).attr('value') == "Start typing any song...")
				{
					$(me).attr('value','');
				}
				q = $(me).val();
				param.action = 'song_search';
				param.q = q;
				param.song_limit = song_limit;
				if(flag)
				{
					ajax.getJSON_ajax(url, param, me, callback.song_search);
				}
				else
				{
					ajax.getJSON_ajax(url, param, me, callback.song_search_);
				}	
			} 
			
			function suggest_refresh(me)
			{
				$('.suggest_container').remove();
				$('#friend_suggest').append('<div class="suggest_container" id="suggest_container1"></div><div class="suggest_container" id="suggest_container2"></div><div class="suggest_container" id="suggest_container3"></div><div class="suggest_container" id="suggest_container4"></div><div class="suggest_container" id="suggest_container5"></div><div class="suggest_container" id="suggest_container6"></div>');
				param.action = 'friend_suggest';
				param.count = 6;
				ajax.getJSON_ajax(url, param, me, ui.suggest_deploy);
			}
			
			function group_suggest_refresh(me)
			{
				$('.group_suggest_container').remove();
				$('#group_suggest').append('<div class="group_suggest_container" id="group_suggest_container1"></div><div class="group_group_suggest_container" id="group_suggest_container2"></div><div class="group_suggest_container" id="group_suggest_container3"></div><div class="group_suggest_container" id="group_suggest_container4"></div><div class="group_suggest_container" id="group_suggest_container5"></div><div class="group_suggest_container" id="group_suggest_container6"></div>');
				param.action = 'group_suggest';
				param.count = 6;
				ajax.getJSON_ajax(url, param, me, ui.suggest_deploy);
			}
			
			function event_suggest_refresh(me)
			{
				$('.event_suggest_container').remove();
				$('#event_suggest').append('<div class="event_suggest_container" id="event_suggest_container1"></div><div class="event_suggest_container" id="event_suggest_container2"></div><div class="event_suggest_container" id="event_suggest_container3"></div><div class="event_suggest_container" id="event_suggest_container4"></div><div class="event_suggest_container" id="event_suggest_container5"></div><div class="event_suggest_container" id="event_suggest_container6"></div>');
				param.action = 'event_suggest';
				param.count = 6;
				ajax.getJSON_ajax(url, param, me, ui.suggest_deploy);
			}

			function post_delete_positive(me, del_actionid)
			{
					$('.prompt_button').html('');
					param.action='post_delete';
					param.del_actionid =del_actionid;
					data = ajax.getJSON_ajax(url, param, me, callback.postDelete);
			}
			
			function profile_basic_update(me)
			{
				$('#loader2').html("");
				$('#loader2').html('<img src="script/loader.gif" alt="Saving">');	
				$(me).hide();
				param.action ='profile_edit_basic';
				param.nname = $("#nname").val();
				param.name = $("#name").val();
				param.city = $("#city").val();
				param.relation = $("#relation").val();
				param.hobby = $("#hobby").val();
				param.mobile = $("#mobile").val();
				data = ajax.getJSON_ajax(url, param, me, callback.bio_update);
			}
			
			function bio_item_remove(me, diaryid)
			{
				$(me).parent().remove();
				param.action = 'bio_item_remove';
				param.diaryid = diaryid;
				data = ajax.getJSON_ajax(url, param, me, callback.bio_item_remove);
			}
			
			function profile_academic_update(me)
			{
					$('#loader1').html("");
					$('#loader1').html('<img src="http://icon.qmcdn.net/loading.gif" alt="Saving">');	
					$(me).hide();
					var school = $("#school").val(); 
					var college = $("#college").val();
					var profession = $("#profession").val();
					var company = $("#company").val();
					var	syear = $("#syear").val();
					var	cyear = $("#cyear").val();
					param.action ='profile_edit_academic';
					param.school=school;
					param.college = college;
					param.profession = profession;
					param.company = company;
					param.syear = syear;
					param.cyear = cyear;
					data = ajax.getJSON_ajax(url, param, me, callback.bio_update);
			}			
			function profile_favorite_update(me)
			{
					$('#loader3').html("");
					$('#loader3').html('<img src="http://icon.qmcdn.net/loading.gif" alt="Saving">');	
					$(me).hide();
					var music = $("#music").val();
					var movie  = $("#movie").val();
					var book = $("#book").val();
					var sport = $("#sport").val();
					param.action ='profile_edit_favorite';
					param.music=music;
					param.movie = movie;
					param.book = book;
					param.sport = sport;
					data = ajax.getJSON_ajax(url, param, me, callback.bio_update);
			}			
			function profile_nature_update(me)
			{	
					$('#loader').html("");
					$('#loader').html('<img src="http://icon.qmcdn.net/loading.gif" alt="Saving">');	
					var aboutme = $("#aboutme").val(); 
					var rolemodel  = $("#rolemodel").val();
					var philosophy = $("#philosophy").val();
					var political = $("#political").val();
					param.action ='profile_edit_nature';
					param.aboutme=aboutme;
					param.rolemodel = rolemodel;
					param.philosophy = philosophy;
					param.political = political;
					data = ajax.getJSON_ajax(url, param, me, callback.bio_update);
			}
						
			function profile_life_style_update(me)
			{
				$('#loader4').html("");
				$('#loader4').html('<img src="script/loader.gif" alt="Saving">');	
				$(me).hide();
				var interest = $("#interestedin").val();
				var fcrush = $("#fcrush").val();
				var lcrush = $("#lcrush").val();
				var bestfriend = $("#bestfriend").val();
				param.action ='profile_edit_life_style';
				param.interest=interest;
				param.fcrush = fcrush;
				param.lcrush = lcrush;
				param.bestfriend = bestfriend;
				data = ajax.getJSON_ajax(url, param, me, callback.bio_update);
			}

			function really_add_friend(me)
			{
				var profileid = $(me).parent().parent().parent().attr('data');
				var me = $(me).parent().parent().parent().parent();
				$('#suggest_'+profileid).remove();
				param.action = 'add_friend';
				param.profileid = profileid;
				param.msg = 'Hi';
				ajax.getJSON_ajax(url, param, me, callback.add_friend);
				
				param.action = 'friend_suggest';
				param.count = 1;
				ajax.getJSON_ajax(url, param, me, ui.suggest_single_deploy);
			}
			
			function really_add_friend_page(me)
			{
				var profileid = $(me).parent().parent().parent().attr('data');
				var me = $(me).parent().parent().parent().parent();
				$('#suggest_'+profileid).remove();
				param.action = 'add_friend';
				param.profileid = profileid;
				param.msg = 'Hi';
				ajax.getJSON_ajax(url, param, me, callback.add_friend);
				
				param.action = 'friend_suggest';
				param.count = 1;
				ajax.getJSON_ajax(url, param, me, ui.suggest_single_deploy_page);
			}
			
			function really_going_event(me)
			{
				var eventid = $(me).parent().parent().parent().attr('data');
				var me = $(me).parent().parent().parent().parent();
				$('#suggest_'+eventid).remove();
				param.action = 'event_join';
				param.eventid = eventid;
				ajax.getJSON_ajax(url, param, me, callback.add_friend);
				
				param.action = 'event_suggest';
				param.count = 1;
				ajax.getJSON_ajax(url, param, me, ui.event_suggest_single_deploy);
			}
			
			function really_group_join(me)
			{
				var groupid = $(me).parent().parent().parent().attr('data');
				var me = $(me).parent().parent().parent().parent();
				$('#suggest_'+groupid).remove();
				param.action = 'group_join';
				param.groupid = groupid;
				ajax.getJSON_ajax(url, param, me, callback.add_friend);
				
				param.action = 'group_suggest';
				param.count = 1;
				ajax.getJSON_ajax(url, param, me, ui.group_suggest_single_deploy);
			}
			
			function really_group_join_page(me)
			{
				var groupid = $(me).parent().parent().parent().attr('data');
				var me = $(me).parent().parent().parent().parent();
				$('#suggest_'+groupid).remove();
				param.action = 'group_join';
				param.groupid = groupid;
				ajax.getJSON_ajax(url, param, me, callback.add_friend);
				
				param.action = 'group_suggest';
				param.count = 1;
				ajax.getJSON_ajax(url, param, me, ui.group_suggest_single_deploy_page);
			}
			
			function song_dedicate(me,profileid)
			{		
				$(me).hide();
				var song_line = $('#song_dedicate_popup_textarea').val();
				param.action='song_dedicate';
				param.profileid = profileid;
				param.songid = songid; //To be find 
				param.song_line = song_line;
				data = ajax.getJSON_ajax(url, param, me, callback.song_dedicate);
			}

			function tagline(me)
			{
				var tagline = $('#tagline_box').val();
				if(tagline !='')
				{
					$('#tagline_ok').hide();
					$('#message_container').html('<span>Setting your tagline...</span>');
					param.action='tagline_set';
					param.tagline=tagline;
					data = ajax.getJSON_ajax(url, param, me, callback.tagline);
				}

			}
			
			function group_leave_positive(me)
			{
				param.action = 'group_leave';
				param.groupid = $('#profileid_hidden').attr('value');
				data = ajax.getJSON_ajax(url, param, me, callback.group_leave);
			}
			
			function event_cancel_positive(me)
			{
				param.action = 'event_cancel';
				param.eventid = $('#profileid_hidden').attr('value');
				data = ajax.getJSON_ajax(url, param, me, callback.group_leave);
			}
			
			function unfriend_positive(me)
			{
				param.action = 'unfriend';
				param.profileid = $('#profileid_hidden').attr('value');
				data = ajax.getJSON_ajax(url, param, me, callback.unfriend);
			}

			
			
			return {
				answer_people_fetch : answer_people_fetch, 
				actiontype_preview : actiontype_preview,
				add_friend : add_friend,
				answer : answer,
				album_upload_button_click : album_upload_button_click,
				birthday_bomb : birthday_bomb,
				birthday_fetch : birthday_fetch,
				birthday_all : birthday_all,
				comment : comment,
				createCookie : createCookie,
				change_password : change_password,
				cookie_delete : cookie_delete,
				event_create : event_create,
				event_invite : event_invite, 
				event_join : event_join,
				event_cancel_positive : event_cancel_positive,
				event_suggest_refresh : event_suggest_refresh,
				group_suggest_refresh : group_suggest_refresh,
				group_suggest_page : group_suggest_page,
				group_question_button : group_question_button,
				event_suggest : event_suggest,
				group_suggest : group_suggest,
				event_settings_save : event_settings_save,
				email_setting_update : email_setting_update,
				forgot_password : forgot_password,
				friend_invite : friend_invite,
				friend_load : friend_load,
				friend_request_fetch : friend_request_fetch,
				friend_accept : friend_accept,
				friend_match : friend_match,
				friend_suggest : friend_suggest,
				friend_suggest_page : friend_suggest_page,
				getCookie : getCookie,
				gift : gift,
				guest_accept : guest_accept, 
				group_create : group_create,
				group_join : group_join,
				group_invite : group_invite, 
				group_admin_make : group_admin_make,
				group_leave_positive : group_leave_positive,
				group_settings_save : group_settings_save,
				message : message,
				message_drop : message_drop,
				member_accept : member_accept,
				member_request_fetch : member_request_fetch,
				missu : missu,
				missu_fetch : missu_fetch,
				mood_done : mood_done,
				notification_setting_update : notification_setting_update,
				photo_upload: photo_upload,
				bio_item_remove : bio_item_remove,
				option_add : option_add,
				post_delete_positive : post_delete_positive,
				profile_privacy_update : profile_privacy_update,
				profile_basic_update : profile_basic_update,
				profile_academic_update : profile_academic_update,
				profile_favorite_update : profile_favorite_update,
				profile_nature_update : profile_nature_update,
				profile_life_style_update : profile_life_style_update,
				question_button : question_button,
				really_add_friend : really_add_friend,
				really_add_friend_page : really_add_friend_page,
				really_going_event : really_going_event,
				really_group_join : really_group_join,
				really_group_join_page : really_group_join_page,
				recover_password : recover_password,
				register : register,
				response : response,
				response_fetch : response_fetch,
				responsed : responsed,
				rtm_load : rtm_load,
				self_invite : self_invite,
				search : search,
				show_all_comments : show_all_comments,
				suggest_refresh : suggest_refresh,
				suggest_know : suggest_know,
				song_search : song_search,
				song_status_done_button_click : song_status_done_button_click,
				tagline : tagline,
				unfriend_positive : unfriend_positive
			}
			
		})();
	