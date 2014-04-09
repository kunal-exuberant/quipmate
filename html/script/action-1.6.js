	
var action = (function(){
			
			var url = 'ajax/write.php';
			var param = {};
			var data = {};
			var tag_name = [];
			var tag_index = [];
			
			function universal_loader(page,param)
			{
				if(param.action !='')
				{
					$.getJSON(url,param,function(data){
					if(data.action.length > 0)
					{
					   load = true;  
						switch(page)
						{
							case 'news_json': feed.news_deploy(data,'#prev'); break;
							case 'admin_json': feed.news_deploy(data,'#prev'); break;
							case 'tech_json': feed.news_deploy(data,'#prev'); break;
							case 'quip': feed.news_deploy(data,'#prev'); break;
							case 'notice_json': deploy.notice_deploy(data,'#prev'); break;
							case 'action': feed.news_deploy(data,'#prev'); break;
							case 'profile_json': feed.news_deploy(data,'#prev'); break;
							case 'group_json': feed.news_deploy(data,'#prev'); break;
							case 'page_json': feed.news_deploy(data,'#prev'); break;
							case 'event_json': feed.news_deploy(data,'#prev'); break;
							case 'album': deploy.album_deploy(data); break;
							case 'photo': deploy.photo_deploy(data); break;
							case 'pphoto': deploy.photo_deploy(data); break;
							case 'college_mate':deploy.people_deploy(data); break;
							case 'new_user':deploy.people_deploy(data); break;
							case 'friend': deploy.friend_deploy(data); break;
							case 'member': deploy.member_deploy(data); break;
							case 'guest': deploy.guest_deploy(data,'#prev'); break;
							default: $("#prev").html(data); break;
						}
					var oldh = $("#prev").height();
					oldh = parseInt(oldh) + 500;
					$("#center").height(oldh);
					param.start += increment;
					$('#load_more').show();
					}
					else
					{
						load = false;    
						$('#loading').remove();
						if(page == 'news_json')	
						{
							$('#prev').append('<div style="border-bottom: 0.1em solid #CCCCCC;height: 4em;padding: 4em 0;text-align:center;"><input type="submit" style="background-color:#336699;color:#ffffff;cursor:pointer;font-size:1.6em;font-weight:bold;height:7em;width:30em;" value="Find friends" onclick="ui.redirect_friend_suggest()"/></div>');
							$('#prev').append('<div style="border-bottom: 0.1em solid #CCCCCC;height: 4em;padding: 4em 0;text-align:center;"><input type="submit" style="background-color:#336699;color:#ffffff;cursor:pointer;font-size:1.6em;font-weight:bold;height:7em;width:30em;" value="Join Groups" onclick="ui.redirect_group_suggest()"/></div>');
						}
						else
						{		
							$('#prev').append('<div style="text-align:center;"><img src="http://icon.qmcdn.net/feed.jpg" /></div><div style="margin-top:1em;text-align:center;">No more feed available !</div></div>');
						}
					}
					});
				}   
				var lastScrollTop = 0;                           
				$(window).scroll(function(){
				var st = $(this).scrollTop();
				if (st > lastScrollTop)
				{
				   // downscroll code

				var scroll_size = $(document).height() - $(window).height();
				scroll_size = scroll_size * 0.6;
				if(($(window).scrollTop() > scroll_size) && load)
				{
				   load = false;    
					$('#load_more').hide();
					$("#prev").append('<p align="center"><img src="png/loading.gif" id="loading"></p>');
					if(param.action !='')
					{
						$.getJSON(url,param,function(data){
						if(data.action.length > 0)
						{
						  load = true;    
						  $("#loading").remove();

							switch(page)   
							{
								case 'news_json': feed.news_deploy(data,'#prev'); break;
								case 'tech_json': feed.news_deploy(data,'#prev'); break;
								case 'admin_json': feed.news_deploy(data,'#prev'); break;
								case 'quip': feed.news_deploy(data,'#prev'); break;
								case 'notice_json': deploy.notice_deploy(data,'#prev'); break;
								case 'action': feed.news_deploy(data,'#prev'); break;
								case 'profile_json': feed.news_deploy(data,'#prev'); break;
								case 'group_json': feed.news_deploy(data,'#prev'); break;
								case 'page_json': feed.news_deploy(data,'#prev'); break;
								case 'event_json': feed.news_deploy(data,'#prev'); break;
								case 'album': deploy.album_deploy(data); break;
								case 'photo': deploy.photo_deploy(data); break;
								case 'pphoto': deploy.photo_deploy(data); break;
								case 'college_mate':deploy.people_deploy(data); break;
								case 'new_user':deploy.people_deploy(data); break;
								case 'friend': deploy.friend_deploy(data); break;
								case 'member': deploy.member_deploy(data); break;
								case 'guest': deploy.guest_deploy(data,'#prev'); break;
								default: $("#prev").html(data); break;
							}
							param.start += increment;
							$('#load_more').show();
							var oldh = $("#prev").height();
							oldh = parseInt(oldh) + 500;
							$("#center").height(oldh);
						}
						else
						{
							load = false;    
							$('#loading').remove();
							if(page == 'news_json')	
							{
								$('#prev').append('<div style="border-bottom: 0.1em solid #CCCCCC;height: 4em;padding: 4em 0;text-align:center;"><input type="submit" style="background-color:#336699;color:#ffffff;cursor:pointer;font-size:1.6em;font-weight:bold;height:7em;width:30em;" value="Find friends" onclick="ui.redirect_friend_suggest()"/></div>');
								$('#prev').append('<div style="border-bottom: 0.1em solid #CCCCCC;height: 4em;padding: 4em 0;text-align:center;"><input type="submit" style="background-color:#336699;color:#ffffff;cursor:pointer;font-size:1.6em;font-weight:bold;height:7em;width:30em;" value="Join Groups" onclick="ui.redirect_group_suggest()"/></div>');
							}
							else
							{
								$('#prev').append('<div style="text-align:center;"><img src="http://icon.qmcdn.net/feed.jpg" /></div><div style="margin-top:1em;text-align:center;">No more feed available !</div></div>');
							}
						}
						});
					}
				}
				}
				lastScrollTop = st;
				});

				$('#load_more').click(function(){
					$('#load_more').hide();
					if(load)
					{
						load = false; 
					$("#prev").append('<p align="center"><img src="png/loading.gif" id="loading"></p>');
					if(param.action !='')
					{
						$.getJSON(url,param,function(data){
							if(data.action.length > 0)
							{
							  load = true;    
							$("#loading").remove();
							var oldh = $("#center").height();
								switch(page)   
								{
									case 'news_json': feed.news_deploy(data,'#prev'); break;
									case 'tech_json': feed.news_deploy(data,'#prev'); break;
									case 'admin_json': feed.news_deploy(data,'#prev'); break;
									case 'quip': feed.news_deploy(data,'#prev'); break;
									case 'notice_json': deploy.notice_deploy(data,'#prev'); break;
									case 'action': feed.news_deploy(data,'#prev'); break;
									case 'profile_json': feed.news_deploy(data,'#prev'); break;
									case 'group_json': feed.news_deploy(data,'#prev'); break;
									case 'page_json': feed.news_deploy(data,'#prev'); break;
									case 'event_json': feed.news_deploy(data,'#prev'); break;
									case 'album': deploy.album_deploy(data); break;
									case 'photo': deploy.photo_deploy(data); break;
									case 'pphoto': deploy.photo_deploy(data); break;
									case 'college_mate':deploy.people_deploy(data); break;
									case 'new_user':deploy.people_deploy(data); break;
									case 'friend': deploy.friend_deploy(data); break;
									case 'member': deploy.member_deploy(data); break;
									case 'guest': deploy.guest_deploy(data,'#prev'); break;
									default: $("#prev").html(data); break;
								}
								var oldh = $("#prev").height();
								oldh = parseInt(oldh) + 500;
								$("#center").height(oldh);
								param.start +=increment;
								$('#load_more').show();
							}
							else
							{
								load = false;
								$('#loading').remove();
								if(page == 'news_json')	
								{
									$('#prev').append('<div style="border-bottom:0.1em solid #cccccc;height: 4em;padding: 4em 0;text-align:center;"><input type="submit" style="background-color:#336699;color:#ffffff;cursor:pointer;font-size:1.6em;font-weight:bold;height:7em;width:30em;" value="Find friends" onclick="ui.redirect_friend_suggest()"/></div>');
									$('#prev').append('<div style="border-bottom: 0.1em solid #cccccc;height: 4em;padding: 4em 0;text-align:center;"><input type="submit" style="background-color:#336699;color:#ffffff;cursor:pointer;font-size:1.6em;font-weight:bold;height:7em;width:30em;" value="Join Groups" onclick="ui.redirect_group_suggest()"/></div>');
								}
								else
								{
									$('#prev').append('<div style="text-align:center;"><img src="http://icon.qmcdn.net/feed.jpg" /></div><div style="margin-top:1em;text-align:center;">No more feed available !</div></div>');
								}
							}
						});
						}
					}  
				});
			}
			
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
			
			function new_version_upload(me)
			{
				$('#photo_box').click();
				$('#pform').show();
				$('#new_version_upload_button').show();
			}
			
			function user_details(me)
			{
				$(me).attr("value",'Requesting...'); 
				param.action = 'user_details_fetch';
				param.email = $('#remove_user_email').attr('value');
				ajax.getJSON_ajax(url, param, me, callback.user_details);
			}
			
			function user_delete(me,profileid)
			{
				$(me).attr("value",'Requesting...'); 
				param.action = 'user_delete';
				param.profileid = profileid;
				ajax.getJSON_ajax(url, param, me, callback.user_delete);
			}
			function make_moderator(me,profileid)
			{
				$(me).attr("value",'Requesting...'); 
				param.action = 'make_moderator';
				param.profileid = profileid;
				ajax.getJSON_ajax(url, param, me, callback.make_moderator);
			}
			function moderator_remove(me,profileid)
			{
				$(me).attr("value",'Requesting...'); 
				param.action = 'moderator_remove';
				param.profileid = profileid;
				ajax.getJSON_ajax(url, param, me, callback.moderator_remove);
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
				param.action='birthday_bomb_fetch';
				ajax.getJSON_ajax(url, param, me, callback.birthday_select);
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
					param.tag_index = tag_index;
					param.tag_name = tag_name; 
					$(me).val('');
					var me = $(me).parent().prev();
					ajax.getJSON_ajax(url, param, me, callback.comment);
				}
				else
				{
					// *********************
					
					var q = $.trim($(me).val());
		var me = $(me);
		if(q.indexOf('@') != '-1')
		{
			q = q.substring(1);
			var posx = $(me).parent().position().left;
			var posy = $(me).parent().position().top;
			$('#mention_container').remove();
			$(me).parent().append('<div id="mention_container" style="position:absolute;text-align:left;z-index:1;cursor:pointer;max-height:18em;width:20em;background-color:#ffffff;top:10em;left:10em;"></div>');
			$('#mention_container').css('left',50+posx);
			$('#mention_container').css('top',35+posy);
			var global_name = JSON.parse($('#myfriends_name_hidden').attr('value'));
			var global_pimage = JSON.parse($('#myfriends_pimage_hidden').attr('value'));
			var count = 0;
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
									$('#mention_container').append('<div class="con_32" id="group_invite_'+index+'" data="'+index+'"><img class="lfloat" src='+global_pimage[index]+' width="32" height="32" /><div class="name_35">'+global_name[index]+'</div></div>');
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
								$('#mention_container').append('<div class="con_32" id="group_invite_'+index+'" data="'+index+'"><img class="lfloat" src='+global_pimage[index]+' width="35" height="35" /><div class="name_35">'+global_name[index]+'</div></div>');
								$('.search_items:first').css('background','#336699');
								$('.search_items:first .name_50 a').css('color','white');
								count++;
							}
						}	
					}		
				});
				
					$('.con_32').live('click',function()
					{
						me.val('@'+global_name[$(this).attr("data")]+': ');
						tag_name = [];
						tag_index = [];
						tag_name.push('@'+global_name[$(this).attr('data')]+': ');
						tag_index.push($(this).attr('data'));
						console.log(tag_index+' '+tag_name);
					});
				
			}
					
					// ****************
				}	
			}
			
			function option(me, event)
			{
				var e = event.which;
				var opt = $.trim($(me).attr('value'));
				if(opt != '')
				{
					if(e==13)
					{
						$(me).parent().append('<div class="ask_option">'+opt+'</div>');	
						$(me).attr('value','');
					}
				}	
			}
			
			function option_add(me, event)
			{
				var e = event.which;
				var opt = $.trim($(me).attr('value'));
				if(opt != '')
				{
					if(e==13)
					{
						param.action = 'option_add';
						param.option  = opt;
						$(me).attr('value','');
						param.pageid = 	$(me).parent().parent().parent().parent().attr('data');
						ajax.getJSON_ajax(url, param, me, callback.option_add);
					}
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
				if($('#question_box').val() != '')
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
			}
			
			function group_question_button(me)
			{
				if($('#question_box').val() != '')
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
			}
			
			function response_fetch(me)
			{
				param.action = 'response_fetch';
				param.pageid = $(me).parent().parent().parent().attr('data');
				$("#more_excite_people").remove(); 
				$('body').append('<div id="more_excite_people" ">Retreiving data</div>');
				$('#more_excite_people').append('<span id="diary_close" style="position:absolute;top:1em;right:1em;cursor:pointer;">x</span>');
				data = ajax.getJSON_ajax(url, param, me, callback.response_fetch);
			}
			
			function answer_people_fetch(me,optionid)
			{
				param.action = 'answer_people_fetch';
				param.optionid = optionid;
				$("#more_excite_people").remove(); 
				$('body').append('<div id="more_excite_people" >Retreiving data</div>');
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
			function employee_invite(me)
			{
				param.action = 'employee_invite';
				param.email = $('#employee_invite_box').attr('value');
				if(param.email != '')
				{
					$(me).attr('value','Inviting');
					ajax.getJSON_ajax(url, param, me, callback.employee_invite);
				}
			}
			
			function group_top_influencer(me)
			{
				var profileid=$('#profileid_hidden').attr('value');
				param.action = 'group_top_influencer_fetch';
				param.profileid = profileid;
				ajax.getJSON_ajax(url, param, me, callback.group_top_influencer);
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
				param.action = 'friend_request_accept';
				param.flag = flag;
				param.profileid = $(me).parent().parent().parent().attr('data');
				var me = $(me).parent().parent().parent();
				$(me).html('<img src="http://icon.qmcdn.net/loading.gif" />');
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
				param.action = 'member_request_accept';
				param.flag = flag;
				param.profileid = $(me).parent().parent().parent().attr('data');
				var me = $(me).parent().parent().parent();
				$(me).html('<img src="http://icon.qmcdn.net/loading.gif" />');
				$(me).attr('class','accepted');
				ajax.getJSON_ajax(url, param, me, callback.member_accept);
			}
			function guest_accept(me, flag)
			{
				param.action = 'guest_accept';
				param.flag = flag;
				param.eventid = $(me).attr('data');
				var me = $(me).parent().parent().parent();
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
			function page_create(me)
			{
				param.action = 'page_create';
				param.name = $('#page_name').attr('value');
				param.description = $('#page_description').attr('value');
				ajax.getJSON_ajax(url, param, me, callback.page_create);
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
			
			function group_event_create(me)
			{ 
				param.action = 'group_event_create';
				param.groupid = $('#profileid_hidden').attr('value');
				param.name = $('#event_name').attr('value');
				param.description = $('#event_description').attr('value');
				param.day = $("#event_day").val();
				param.month = $("#event_month").val();
				param.year = $("#event_year").val();
				param.time = $("#event_time").val();
				param.venue = $("#event_where").val();
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
			function feature_setting_update(me)
			{
				param.action = 'feature_setting_update';
				param.field = $(me).attr('data');
				ajax.getJSON_ajax(url, param, me, callback.feature_setting_update);
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
			
			function message_send(me, event)
			{
				var user = $(me).parent().children().eq(0).attr('value');
				var name = $('#myprofilename_hidden').attr('value'); 
				var profileid = $('#profileid_hidden').attr('value');
				if(event.which == 13 && $.trim($(me).val()))
				{ 
					typing = true;
					var message = $(me).val();
					var photo = $('#myprofileimage_hidden').attr('value'); 
					$(me).attr('value','');
					var database = $('#database_hidden').attr('value');
					var param = {"profileid":profileid,"userid":user,"message":message,"name":name,"photo":photo,"database":database}
					$.postJSON('/chat/chat_new',param,function(data){
					
					    $.each(data.action,function(index,value){
						$('#chat_'+value.actionid).remove();
						$(me).parent().children().eq(3).append('<div class="message_each" id='+value.actionid+'><img class="message_each_photo" title="'+name+'" height="50" width=50 src="'+photo+'"><div class="message_each_message"><pre>'+ui.get_smiley(ui.link_highlight(message))+'</pre></div><div style="text-align:right;color:gray;"><img width="6" src="http://icon.qmcdn.net/clock.png"><span style="color:gray;" class="time" data="'+value.time+'">'+ui.time_difference(value.time)+'</span></div><span onclick="ui.message_delete(this,'+value.actionid+')" class="post_setting"></span></div>');
						});
						$(me).parent().children().eq(3).scrollTop($('.inboxui_msg').get(0).scrollHeight);
					});
				}
			}
			
			function message_recent_fetch()
			{
				var myprofileid = $('#myprofileid_hidden').attr('value');
				$.getJSON('ajax/write.php',{action:'message_recent_fetch'},function(data){
				if(data.ack != 0)
				{
					$('#session_name_hidden').attr('value', JSON.stringify(data.name));
					$('#session_pimage_hidden').attr('value', JSON.stringify(data.pimage));
					
					$('#inbox_container').html('');
					var redirecteduser = $('#profileid_hidden').attr('value');
					console.log(redirecteduser);
				/*	console.log(data.action);
					$('#inbox_container').append('<h1 id="message_user_name">'+data.name[user]+'</h1>');
					ui.createMessageUI(user, data.name[user]);
					previous_talk_message(user, 0, 1); */
					
					$.each(data.action,function(index,value){
						//id = "friend_"+value;
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
					if((value.message).length > 20) value.message = (value.message).slice(0,17)+'...';
					
					  $('#show_inbox').append('<div class="inbox_user" data="'+showuser+'" id="'+showuser+'"><img class="online_photo" height="50" width="50" src="'+data.pimage[showuser]+'" /><span class="online_name" style="font-weight:bold;">'+data.name[showuser]+'</span><div><img height="20" width="20" src="'+showimage+'"/>'+value.message+'</div></div>');
					 $('#'+showuser).append('<div style="margin-left:6em;margin-top:.15em;color:gray;"><img src="http://icon.qmcdn.net/clock.png" width="6" /><span style="color:gray;" data="'+value.time+'">'+ui.time_difference(value.time)+'</span></a></div>');
					if(index == 0 )
					{
							if(redirecteduser != myprofileid) 
							{
								user = redirecteduser;	
							}	
							else user = showuser;
							$('#inbox_container').html('');
							$('#inbox_container').append('<h1 id="message_user_name">'+data.name[user]+'</h1>');
							ui.createMessageUI(user, data.name[user]);
							previous_talk_message(user, 0, 1);
					}
					});
				}
				else
				{ 
					if(data.ack == 0)
					{
						$('#inbox_container').append('<h1 id="no_message">No message to show<h1>');
					}
				
				}
					   $('.inbox_user').live('click',function(){
						$('#inbox_container').html('');
						user = $(this).attr('data');
						$('#inbox_container').append('<h1 id="message_user_name">'+data.name[user]+'</h1>');
								ui.createMessageUI(user, name);
								previous_talk_message(user, 0, 1);
					   });
				});
			}
			
			function previous_talk_message(user, chat_start, opening)
			{
				$.getJSON('ajax/write.php',{action:'message_fetch',profileid:user,start:chat_start},function(data){
				$.each(data.action,function(index,value){
					$('#inbox_'+user).children().eq(3).prepend('<div class="message_each" id='+value.actionid+'><img class="message_each_photo" title="'+data.name[value.actionby]+'" height="50" width="50" src="'+data.pimage[value.actionby]+'"><div class="message_each_message">'+ui.get_smiley(ui.link_highlight(value.message))+'</div><div style="text-align:right;color:gray;"><img src="http://icon.qmcdn.net/clock.png" width="6" /><span style="color:gray;" class="time" data="'+value.time+'">'+ui.time_difference(value.time)+'</span></a></div><span onclick="ui.message_delete(this,'+value.actionid+')" class="post_setting"></span></div>'); 
				});
				if(opening)
				{ 
					if($('.inboxui_msg').length > 0)
					{
						$('#inbox_'+user).children().eq(3).scrollTop($('.inboxui_msg').get(0).scrollHeight);
					}	
				}	
					chat_load = true;
				}); 
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
				param.page = $('#page_hidden').attr('value');
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
				data = ajax.getJSON_ajax(url, param, me, callback.post_delete);
			}
			function message_delete_positive(me,actionid)
			{
				$('.prompt_button').html('');
				param.action='message_delete';
				param.del_actionid =actionid;
				data = ajax.getJSON_ajax(url, param, me, callback.message_delete);
			}
			
			function bio_item_remove(me, diaryid)
			{
				$(me).parent().remove();
				param.action = 'bio_item_remove';
				param.diaryid = diaryid;
				data = ajax.getJSON_ajax(url, param, me, callback.bio_item_remove);
			}

			function really_add_friend(me)
			{
				var profileid = $(me).parent().parent().parent().attr('data');
				var me = $(me).parent().parent().parent().parent();
				$('#suggest_'+profileid).remove();
				param.action = 'add_friend';
				param.profileid = profileid;
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
				ajax.getJSON_ajax(url, param, me, ui.group_suggest_single_deploy_page);
			}
			
			function really_group_join_page(me)
			{
				var groupid = $(me).parent().parent().parent().attr('data');
				var me = $(me).parent().parent().parent().parent();
				$('#suggest_'+groupid).remove();
				param.action = 'group_join';
				param.groupid = groupid;
				ajax.getJSON_ajax(url, param, me, callback.group_join);
				
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
			
			function event_leave(me)
			{
				param.action = 'event_leave';
				param.eventid = $('#profileid_hidden').attr('value');
				data = ajax.getJSON_ajax(url, param, me, callback.event_leave);
			}
			
			function event_cancel_positive(me)
			{
				param.action = 'event_cancel';
				param.eventid = $('#profileid_hidden').attr('value');
				data = ajax.getJSON_ajax(url, param, me, callback.event_cancel);
			}
			
			function unfriend_positive(me)
			{
				param.action = 'unfriend';
				param.profileid = $('#profileid_hidden').attr('value');
				data = ajax.getJSON_ajax(url, param, me, callback.unfriend);
			}

			function name_split(name,value)
			{
				var arr = value.split(',');
				var arrayofprofileid = [];
				var len = arr.length;
				//Taking Ids is another array in reverse order
				for (var j = 0 ; j < len ; j++)
				{ 
					arrayofprofileid.push(arr[len - 1 - j]);
				}
				var totalcount = arrayofprofileid.length;
				var count = 0;
				var names = "";
				for (var i = 0; i < totalcount ;i++) 
				{
					if (i == 0 && totalcount < 3)
					{
						names = '<span style="font-weight:bold;">'+name[arrayofprofileid[i]]+'</span>';
					}
					else if (i == 0 && totalcount > 2)
					{
						names =  '<span style="font-weight:bold;">'+name[arrayofprofileid[i]]+'</span>' + ', ';
					}
					else if (i == 1 && totalcount == 2)
					{
						names = names +' and '+ name[arrayofprofileid[i]];
					}
					else if (i == 1 && totalcount > 2)
					{
						names = names + name[arrayofprofileid[i]] ;
					}
					else if (i == 2 && totalcount == 3)
					{
						names = names +' and '+ name[arrayofprofileid[i]];
					}
					else count = count + 1;
				
				}
			if (totalcount <= 3)
			return names ;
			else return names+' and '+count+' more ';
			}
			function getanalyticdetails(me,value)
			{
			
			param.action = value;
			data = ajax.getJSON_ajax(url, param, me,callback.getanalyticdetails);
			
			}
			
			return {
			    getanalyticdetails:getanalyticdetails,
				employee_invite:employee_invite,
				moderator_remove:moderator_remove,
				make_moderator:make_moderator,
				feature_setting_update:feature_setting_update,
				page_create:page_create,
				message_delete_positive:message_delete_positive,
				name_split:name_split,
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
				event_leave : event_leave,
				event_cancel_positive : event_cancel_positive,
				event_suggest_refresh : event_suggest_refresh,
				group_suggest_refresh : group_suggest_refresh,
				group_suggest_page : group_suggest_page,
				group_question_button : group_question_button,
				event_suggest : event_suggest,
				group_event_create : group_event_create,
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
				group_top_influencer : group_top_influencer,
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
				message_send : message_send,
				member_request_fetch : member_request_fetch,
				message_recent_fetch : message_recent_fetch,
				missu : missu,
				missu_fetch : missu_fetch,
				mood_done : mood_done,
				new_version_upload : new_version_upload,
				notification_setting_update : notification_setting_update,
				photo_upload: photo_upload,
				bio_item_remove : bio_item_remove,
				option : option,
				option_add : option_add,
				post_delete_positive : post_delete_positive,
				profile_privacy_update : profile_privacy_update,
				previous_talk_message : previous_talk_message,
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
				user_details : user_details,
				user_delete : user_delete,
				unfriend_positive : unfriend_positive,
				universal_loader : universal_loader
			}
			
		})();
	