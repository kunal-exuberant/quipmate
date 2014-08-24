var ui = (function()
{
   var icon_cdn = $('#icon_cdn').attr('value');
   var image_cdn = $('#image_cdn').attr('value');
   var chat_notify = true;
   bring = true;

   function page_call(page)
   {
      if (page == 'search')
      {
         action.search();
         action.friend_suggest(this, 6);
         //	action.friend_fetch();
      }
      else if (page == 'analytics')
      {
         action.getanalyticdetails(this, 'daily');
         //	action.friend_fetch();
      }
      else if (page == 'group_json' || page == 'member' || page == 'group_about' || page == 'group_settings')
      {
         action.group_suggest(this, 6);
         action.member_request_fetch();
         action.group_top_influencer(this);
         //	action.friend_fetch();
         var profileid = $('#profileid_hidden').attr('value');
         var groupid = profileid;
         action.doc_load(this, groupid);
      }
      else if (page == 'page_json' || page == 'Followers' || page == 'page_about' || page == 'page_settings')
      {
         //action.page_suggest(this,6);
         //	action.friend_fetch();
      }
      else if (page == 'friend_suggest')
      {
         action.friend_suggest_page(this, 16);
         //	action.friend_fetch();
      }
      else if (page == 'group_suggest')
      {
         action.group_suggest_page(this, 16);
         //	action.friend_fetch();
      }
      else if (page == 'event_json' || page == 'guest' || page == 'event_about' || page == 'event_settings')
      {
         action.event_suggest(this, 6);
         //	action.friend_fetch();
      }
      else if (page == 'inbox')
      {
         $('.right_item').remove();
         $('html').css('overflow', 'hidden')
         $('#left').html('');
         $('#left').css('top', 'auto');
         $('#left').append('<h1 style="color:gray;">Messages</h1>');
         $('#left').append('<div id="show_inbox"></div>');
         $('#show_inbox').css('height', $(window).height() - 100);
         $('#left').css('width', '206');
         $('#show_inbox').css('overflow', 'auto');
         action.message_recent_fetch();
         action.actiontype_preview();
         //	action.friend_fetch();
      }
      else if (page == 'friend' || page == 'bio' || page == 'pphoto' || page == 'profile_json')
      {
         action.friend_match();
         action.friend_suggest(this, 6);
         action.actiontype_preview();
         //	action.friend_fetch();
      }
      else if (page == 'news_json' || page == 'photo' || page == 'new_user' || page == 'college_mate' || page == 'notice_json')
      {
         action.pro_stat(this);
         action.friend_suggest(this, 6);
         ui.friend_invite();
         action.actiontype_preview();
         action.usefullinks_load();
        // action.flash_board_fetch();
         action.birthday_fetch(this);
         //	action.friend_fetch();
         action.star_of_the_week_fetch();
         action.csv_fetch();
      }
/*	else if(page == 'admin_json' || page == 'admin' || page == 'invite' || page == 'remove_user' || page == 'analytics' || page == 'feature' || page == 'account' || page == 'privacy' || page == 'email_settings' || page == 'notification' || page =='profile_picture' || page=='action')
				{
					action.friend_fetch();
				}  */
      //Calling it for all the pages .
      else if (page == 'usefullinks')
      {
         action.usefullinks_fetch();
      }
      else if (page == 'designation')
      {
         action.designation_fetch();
      }
      else if (page == 'team')
      {
         action.team_fetch();
      }
      else if (page == 'sotw')
      {
         action.sotw_load();
      }
      else if (page == 'flashboard')
      {
       //  action.flash_board_fetch();
      }
      action.friend_fetch(); // Getting called for all the pages 
   }

   function preview_doc(file)
   {
      window.location = "https://docs.google.com/" + file;
   }

   function share_modal()
   {
      $('body').append();
   }

   function birthday_bomb(me, profileid, birthday, event)
   {
      if (navigator.appName == 'Microsoft Internet Explorer')
      {
         event.cancelBubble = true
      }
      else
      {
         event.stopPropagation();
      }
      var date = $(me).parent().children().eq(1).attr('value');
      var wish = $('#birthday_wish_box').val();
      $('.right_pointer_container').remove();
      $('body').append('<div class="right_pointer_container"><div class="right_item_pointer"></div></div>');
      $('.right_pointer_container').css('top', $(me).parent().position().top + 50 + 'px');
      $('.right_pointer_container').append('<div id="birthday_wish_container"><input type="hidden" id="birthday_wish_profileid_hidden" value=""/></div>');
      $('#birthday_wish_container').append('<div class="right_pointer_title">Send Birthday Wish with Birthday Bomb</div>');
      $('#birthday_wish_container').append('<div style="margin-top:1em;"><input style="padding:0.5em;width:26em;" id="birthday_wish_box" type="text" placeholder="Write birthday wish"/></div>');
      $('#birthday_wish_container').append('<div style="margin-top:0.8em;"><input class="prompt_positive theme_button"  type="submit" value="Wish" id="wish_ok"/><input class="prompt_negative theme_button" type="submit" value="Cancel" id="birthday_wish_close" /></div>');
      $('#birthday_wish_box').focus();
      $('#birthday_wish_close').live('click', function()
      {
         $('.right_pointer_container').remove();
      });
      $('#wish_ok').live('click', function()
      {
         var wish = $('#birthday_wish_box').val();
         if (wish != '')
         {
            $('#wish_ok').hide();
            $('#birthday_wish_container').html('<span>Wishing...</span>');
            $.getJSON('ajax/write.php', {
               action: 'birthday_bomb',
               profileid: profileid,
               wish: wish,
               date: date
            }, function(data)
            {
               if ($.trim(data) == 1)
               {
                  $('#birthday_wish_container').html('You have successfully sent the birthday wish.');
                  $('.right_pointer_container').fadeOut(2000);
               }
            });
         }
      });
   }

   function birthday_wish_close()
   {
      $('.right_pointer_container').remove();
   }

   function disable_upload_area()
   {
      var nodes = document.getElementById("upload_box").getElementsByTagName('*');
      for (var i = 0; i < nodes.length; i++)
      {
         nodes[i].disabled = true;
      }
   }

   function enable_upload_area()
   {
      var nodes = document.getElementById("upload_box").getElementsByTagName('*');
      for (var i = 0; i < nodes.length; i++)
      {
         nodes[i].disabled = false;
      }
   }

   function group_question()
   {
      $('#uploader').html('<textarea id="question_box" placeholder="Ask your question"/></textarea><input id="question_button" type="submit" value="Ask" class="theme_button" onclick="action.group_question_button(this)"><div class="option_container"><input type="text" placeholder="+Add option by pressing enter" value="" class="option_add" onkeydown="action.option(this,event)"><div>');
      $('#question_box').focus();
   }
   $('#vish_Btn').live("click", function()
   {
      $('#html_btn').click();
   });

   function redirect_friend_suggest()
   {
      window.location = 'register.php?hl=friend_suggest';
   }

   function redirect_group_suggest()
   {
      window.location = 'register.php?hl=group_suggest';
   }

   function redirect_to_action(actionid, life_is_fun)
   {
      window.location = 'action.php?actionid=' + actionid + '&life_is_fun=' + life_is_fun;
   }

   function close()
   {
      //$('.container').remove();
      $('#more_excite_people').remove();
      $('.bg_hide_cover').remove();
   }

   function friend_invite()
   {
      $('#friend_invite_heading').append('<div class="panel_heading" >Invite a colleague to join Quipmate</div>');
      $('#friend_invite_body').append('<div><input type="text" id="invite_box" value="" placeholder="Enter an email address" /><input type="submit" title="Invite A Friend" id="invite_button" class="theme_button" value="Invite" onclick="action.friend_invite(this)" /></div>');
   }

   function page_init(page, param)
   {
      if (page == 'news_json')
      {
         param.action = 'news_feed';
         increment = 10;
         $('#center').append('<div id="news_poll"></div>');
         $('#center').append('<div id="prev"></div>');
         $('#center').append('<input type="submit" class="load_more" style="height:30px;width:150px;margin-left:200px;display:none;"  value="Show More Updates" />');
      }
      else if (page == 'admin_json')
      {
         param.action = 'admin_feed';
         increment = 10;
         $('#center').append('<div id="news_poll"></div>');
         $('#center').append('<div id="prev"></div>');
         $('#center').append('<input type="submit" class="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Updates" />');
      }
      else if (page == 'tech_json')
      {
         param.action = 'technical_feed_fetch';
         increment = 10;
         $('#center').append('<div id="news_poll"></div>');
         $('#center').append('<div id="prev"></div>');
         $('#center').append('<input type="submit" class="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Updates" />');
      }
      else if (page == 'notice_json')
      {
         param.action = 'notice_fetch';
         increment = 10;
         $('#center').append('<div id="prev"><h1 class="page_title">All Notifications</h1></div>');
         $('#center').append('<input type="submit" class="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Notices" />');
      }
      else if (page == 'action')
      {
         param.action = 'action_fetch';
         param.actionid = $('#actionid_hidden').attr('value');
         param.life_is_fun = $('#life_is_fun_hidden').attr('value');
         increment = 10;
         $('#center').append('<div id="prev"></div>');
      }
      else if (page == 'profile_json')
      {
         param.action = 'profile_feed';
         param.profileid = $('#profileid_hidden').attr('value');
         increment = 10;
         $('#center').append('<div id="prev"></div>');
         $('#center').append('<input type="submit" class="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Diary Entry" />');
      }
      else if (page == 'group_json')
      {
         param.action = 'group_feed';
         param.groupid = $('#profileid_hidden').attr('value');
         increment = 10;
         $('#center').append('<div id="prev"></div>');
         $('#center').append('<input type="submit" class="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Group Posts" />');
      }
      else if (page == 'page_json')
      {
         param.action = 'page_feed';
         param.pageid = $('#profileid_hidden').attr('value');
         increment = 10;
         $('#center').append('<div id="prev"></div>');
         $('#center').append('<input type="submit" class="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Page Posts" />');
      }
      else if (page == 'event_json')
      {
         param.action = 'event_feed';
         param.eventid = $('#profileid_hidden').attr('value');
         increment = 10;
         $('#center').append('<div id="prev"></div>');
         $('#center').append('<input type="submit" class="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Event Posts" />');
      }
      else if (page == 'album')
      {
         param.action = 'pin_fetch';
         increment = 10;
         var profile_name = $('#myprofilename_hidden').attr('value');
         $('#center').remove();
         $('#left').remove();
         $('#right').remove();
         $('body').css('background', '#E7EBF2');
         $('body').append('<div style="position:absolute;left:2em;top:5em;width:21em" id="tr0"></div><div style="position:absolute;left:24em;top:5em;width:21em" id="tr1"></div><div style="position:absolute;left:46em;top:5em;width:21em" id="tr2"></div><div style="position:absolute;left:68em;top:5em;width:21em" id="tr3"></div><div style="position:absolute;left:90em;top:5em;width:21em" id="tr4"></div>');
      }
      else if (page == 'photo')
      {
         param.action = 'photo_friend_fetch';
         increment = 25;
         var profile_name = $('#myprofilename_hidden').attr('value');
         $('#center').append('<div id="prev"></div>');
         $('#center').append('<input type="submit" class="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Photo" />');
         $('#prev').append('<h1 class="page_title">' + profile_name + ' - Friends - Photo</h1>');
         $('#prev').append('<table style="padding:1.5em;"></table>');
      }
      else if (page == 'pphoto')
      {
         param.action = 'photo_fetch';
         param.profileid = $('#profileid_hidden').attr('value');
         increment = 25;
         var profile_name = $('#profilename_hidden').attr('value');
         $('#center').append('<div id="prev"></div>');
         $('#center').append('<input type="submit" class="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Photo" />');
         $('#prev').append('<h1 class="page_title">' + profile_name + ' - Photo</h1>');
         $('#prev').append('<table style="padding:1.5em;"></table>');
      }
      else if (page == 'praise')
      {
         profileid = $('#profileid_hidden').attr('value');
         var profile_name = $('#profilename_hidden').attr('value');
         $('#center').html('<h1 class="page_title">' + profile_name + ' - Praises/Recommendations</h1>');
         action.praise_fetch(this, profileid);
      }
      else if (page == 'file')
      {
         param.action = 'file_fetch';
         param.profileid = $('#profileid_hidden').attr('value');
         increment = 25;
         var profile_name = $('#profilename_hidden').attr('value');
         $('#center').append('<div id="prev"></div>');
         $('#center').append('<input type="submit" class="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Files" />');
         $('#prev').append('<h1 class="page_title">' + profile_name + ' - Files</h1>');
         $('#prev').append('<table style="padding:1.5em;"></table>');
      }
      else if (page == 'video')
      {
         param.action = 'video_fetch';
         param.profileid = $('#profileid_hidden').attr('value');
         increment = 25;
         var profile_name = $('#profilename_hidden').attr('value');
         $('#center').append('<div id="prev"></div>');
         $('#center').append('<input type="submit" class="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Videos" />');
         $('#prev').append('<h1 class="page_title">' + profile_name + ' - Videos</h1>');
         $('#prev').append('<table style="padding:1.5em;"></table>');
      }
      else if (page == 'college_mate')
      {
         param.action = 'people_fetch';
         param.college = 'college';
         increment = 10;
         $('#center').append('<h1 class="page_title">People having same college as you</h1>');
      }
      else if (page == 'new_user')
      {
         param.action = 'people_fetch';
         param.new_user = 'new_user';
         increment = 10;
         $('#center').html('<div id="prev"></div>');
         $('#prev').html('<h1 class="page_title">People Who Recently Joined Quipmate</h1>');
         $('#center').append('<input type="submit" class="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Photo" />');
      }
      else if (page == 'search')
      {
         param.action = 'search';
         param.filter = $('#search_filter_hidden').attr('value');
         param.q = $('#search_key_hidden').attr('value');
         increment = 10;
      }
      else if (page == 'following')
      {
         param.action = 'following_load';
         param.profileid = $('#profileid_hidden').attr('value');
         increment = 50;
         var profile_name = $('#profilename_hidden').attr('value');
         $('#center').append('<div id="prev"></div>');
         $('#center').append('<input type="submit" class="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Following" />');
         $('#prev').append('<h1 class="page_title">' + profile_name + ' - Following</h1>');
      }
      else if (page == 'followers')
      {
         param.action = 'followers_load';
         param.profileid = $('#profileid_hidden').attr('value');
         increment = 50;
         var profile_name = $('#profilename_hidden').attr('value');
         $('#center').append('<div id="prev"></div>');
         $('#center').append('<input type="submit" class="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Followers" />');
         $('#prev').append('<h1 class="page_title">' + profile_name + ' - Followers</h1>');
      }
      else if (page == 'member')
      {
         param.action = 'member_load';
         param.groupid = $('#profileid_hidden').attr('value');
         increment = 50;
         var profile_name = $('#profilename_hidden').attr('value');
         $('#center').append('<div id="prev"></div>');
         $('#center').append('<input type="submit" class="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Members" />');
         $('#prev').append('<h1 class="page_title">Group Members</h1>');
      }
      else if (page == 'guest')
      {
         param.action = 'guest_load';
         param.eventid = $('#profileid_hidden').attr('value');
         increment = 50;
         var profile_name = $('#profilename_hidden').attr('value');
         $('#center').append('<div id="prev"></div>');
         $('#center').append('<input type="submit" class="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Guests" />');
         $('#prev').append('<h1 class="page_title">Guests</h1>');
      }
      else if (page == 'inbox')
      {
         param.action = 'message_fetch';
         param.profileid = $('#profileid_hidden').attr('value');
         var profileid = $('#profileid_hidden').attr('value');
         var myprofileid = $('#myprofileid_hidden').attr('value');
         var profileid_name = $('#profilename_hidden').attr('value');
         var myprofileid = $('#myprofileid_hidden').attr('value');
         var myprofileid_name = $('#myprofilename_hidden').attr('value');
         var myprofileid_image = $('#myprofileimage_hidden').attr('value');
         var showuser;
         param.profileid = profileid;
         $('#center').append('<div id="inbox_container"></div>');
      }
   }

 /*  function praise(me)
   {
      $('.right_pointer_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div class="right_pointer_container"><div class="right_item_pointer"></div></div>');
      $('.right_pointer_container').css('top', $(me).parent().position().top + 54 + 'px');
      $('.right_pointer_container').css('left', $('#search_form').position().left + 'px');
      $('.right_pointer_container').append('<div id="direct_to_md_container" style="width:45em;min-height:32em;"><input type="hidden" id="birthday_wish_profileid_hidden" value=""/></div>');
      $('#direct_to_md_container').append('<div class="right_pointer_title">Publically praise for outstanding work</div>');
      $('#direct_to_md_container').append('<div style="margin-top:1em;"><input style="padding:0.5em;width:32em;" id="letter_title" type="text" placeholder="What is the outstanding contribution?"/></div><div style="margin-top:1em;"><textarea placeholder="Word of applause" id="letter_content" style="padding:0.5em;height:16em;width:32em;resize:none;"></textarea></div>');
      $('#direct_to_md_container').append('<div style="margin-top:0.8em;"><input class="prompt_negative" type="submit" value="Cancel" id="birthday_wish_close" /><input class="group_create_positive theme_button" type="submit" value="Praise" id="letter_send" onclick="action.praise_send(this)" /></div>');
      $('#birthday_wish_box').focus();
      $('#birthday_wish_close').live('click', function()
      {
         $('.right_pointer_container').remove();
         $('.bg_hide_cover').remove();
      });
   } */ // Changed to modal

   function direct_to_md(me)
   {
      $('.right_pointer_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div class="right_pointer_container"><div class="right_item_pointer"></div></div>');
      $('.right_pointer_container').css('top', $(me).parent().position().top + 54 + 'px');
      $('.right_pointer_container').css('left', $('#search_form').position().left + 'px');
      $('.right_pointer_container').append('<div id="direct_to_md__container" style="width:45em;height:32em;"><input type="hidden" id="birthday_wish_profileid_hidden" value=""/></div>');
      $('#direct_to_md__container').append('<div class="right_pointer_title">Direct Letter to the Managing Director</div>');
      $('#direct_to_md__container').append('<div style="margin-top:1em;"><input style="padding:0.5em;width:32em;" id="letter_title" type="text" placeholder="What is this letter about?"/></div><div style="margin-top:1em;"><textarea placeholder="Letter Content" id="letter_content" style="padding:0.5em;height:16em;width:32em;resize:none;"></textarea></div><div style="margin-top:1em;"><input id="letter_open" type="checkbox" checked/>Open Letter</div>');
      $('#direct_to_md__container').append('<div style="margin-top:0.8em;"><input class="prompt_negative theme_button" type="submit" value="Cancel" id="birthday_wish_close" /><input class="group_create_positive theme_button" type="submit" value="Send Letter" id="letter_send" onclick="action.direct_to_md_send(this)" /></div>');
      $('#birthday_wish_box').focus();
      $('#birthday_wish_close').live('click', function()
      {
         $('.right_pointer_container').remove();
         $('.bg_hide_cover').remove();
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
      if (q != '')
      {
         $.each(global_name, function(index, value)
         {
            if (value != null)
            {
               if (q.indexOf(' ') == -1)
               {
                  var search_name = value.toLowerCase().split(" ");
                  for (var i = 0; i < search_name.length; i++)
                  {
                     if ((count < 5) && (search_name[i].toLowerCase().search('^' + q.toLowerCase()) != -1))
                     {
                        $('#group_invite_' + index).remove();
                        $('#group_friend_invite').append('<div class="container_50" onclick="action.group_invite(this)" id="group_invite_' + index + '" data="' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="50" height="50" /><div class="name_50">' + global_name[index] + '</div></div>');
                        $('.search_items:first').css('background', '#336699');
                        $('.search_items:first .name_50 a').css('color', 'white');
                        count++;
                     }
                  }
               }
               else
               {
                  if ((count < 5) && (value.toLowerCase().search('^' + q.toLowerCase()) != -1))
                  {
                     $('#group_invite_' + index).remove();
                     $('#group_friend_invite').append('<div class="container_50" onclick="action.group_invite(this)" id="group_invite_' + index + '" data="' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="50" height="50" /><div class="name_50">' + global_name[index] + '</div></div>');
                     $('.search_items:first').css('background', '#336699');
                     $('.search_items:first .name_50 a').css('color', 'white');
                     count++;
                  }
               }
            }
         });
      }
   }

   function createMessageUI(user, name)
   {
      $('#inbox_container').append('<div id="inbox_' + user + '" class="inboxui" ><input type="hidden" value="' + user + '"/><span ></span><div class="inboxui_title"></div><div class="inboxui_msg"></div><textarea class="sendbox" onkeypress="action.message_send(this,event)"></textarea><input type="hidden" value="10"/></div>');
      $('.inboxui_msg').css('height', $(window).height() - 165);
      $('.inboxui_msg').css('overflow', 'auto');
      $('#inbox_' + user).children().eq(4).focus();
      //lastScrollTopinbox = $('#inbox_'+user).children().eq(3).get(0).scrollTop;
      $('#inbox_' + user).children().eq(3).scroll(function()
      {
         messagebox_scroll(user)
      });
   }

   function messagebox_scroll(user)
   {
      var chat_start = parseInt($('#inbox_' + user).children().eq(5).attr('value'));
      if ($('#inbox_' + user).children().eq(3).get(0).scrollTop < $('#inbox_' + user).children().eq(3).get(0).scrollHeight * 0.1 && chat_load)
      {
         var st = $('#inbox_' + user).children().eq(3).get(0).scrollTop;
         if (st < lastScrollTopinbox)
         {
            chat_load = false;
            action.previous_talk_message(user, chat_start, 0);
            chat_start += 10;
            $('#inbox_' + user).children().eq(5).attr('value', chat_start);
         }
      }
      lastScrollTopinbox = st;
   }

   function message_leave_shrink()
   {
      var icon_cdn = 'https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com/';
      $('#message_leave').html('<div id="message_leave_title" onclick="ui.message_leave_grow(this)"  style="cursor:pointer;font-size:1.2em;padding:0.5em;background-color:#ebebeb;color:#333333;font-weight:bold;">Leave a message<img src="' + icon_cdn + '/downarrow.gif" style="float:right;" /></div>');
   }

   function message_leave_grow()
   {
      var icon_cdn = 'https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com/';
      $('#message_leave').css('width', '24em');
      $('#message_leave').html('<div id="message_leave_title" onclick="ui.message_leave_shrink(this)" style="cursor:pointer;font-size:1.2em;padding:0.5em;background-color:#ebebeb;color:#333333;font-weight:bold;">Leave a message<img src="' + icon_cdn + '/downarrow.gif" style="float:right;" /></div>');
      $('#message_leave').append('<div style="padding:1em;"><input style="border:0.1em solid #cccccc;height:2em;padding:0.4em;width:20em;" placeholder="Name"  id="contact_name" type="text" value=""/></div>');
      $('#message_leave').append('<div style="padding:1em;"><input style="border:0.1em solid #cccccc;height:2em;padding:0.4em;width:20em;"  placeholder="Email" id="contact_email" type="text" value=""/></div>');
      $('#message_leave').append('<div style="padding:1em;"><input style="border:0.1em solid #cccccc;height:2em;padding:0.4em;width:20em;"  placeholder="Contact No" id="contact_mobile" maxlength="13" type="text" value=""/></div>');
      $('#message_leave').append('<div style="padding:1em;"><textarea style="border:0.1em solid #cccccc;height:6em;padding:0.4em;width:20em;" placeholder="Message"  id="contact_message" ></textarea></div>');
      $('#message_leave').append('<div style="padding:1em 2em 2em 0em;float:right;"><input style="border:0.1em solid #cccccc;background-color:#cccccc;color:#ffffff;font-weight:bold;height:3em;padding:0.4em;width:6em;cursor:pointer;" type="submit" class ="theme_button" onclick="action.contact(this)" value="Send"/></div>');
   }

   function event_friend_invite(me)
   {
      $('#group_invite_info').html('');
      $('#group_friend_invite').html('');
      var global_name = JSON.parse($('#myfriends_name_hidden').attr('value'));
      var global_pimage = JSON.parse($('#myfriends_pimage_hidden').attr('value'));
      var count = 0;
      var q = $.trim($(me).val());
      if (q != '')
      {
         $.each(global_name, function(index, value)
         {
            if (value != null)
            {
               if (q.indexOf(' ') == -1)
               {
                  var search_name = value.toLowerCase().split(" ");
                  for (var i = 0; i < search_name.length; i++)
                  {
                     if ((count < 5) && (search_name[i].toLowerCase().search('^' + q.toLowerCase()) != -1))
                     {
                        $('#event_invite_' + index).remove();
                        $('#group_friend_invite').append('<div class="container_50" onclick="action.event_invite(this)" id="event_invite_' + index + '" data="' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="50" height="50" /><div class="name_50">' + global_name[index] + '</div></div>');
                        $('.search_items:first').css('background', '#ebebeb');
                        $('.search_items:first .name_50 a').css('color', '#333333');
                        count++;
                     }
                  }
               }
               else
               {
                  if ((count < 5) && (value.toLowerCase().search('^' + q.toLowerCase()) != -1))
                  {
                     $('#event_invite_' + index).remove();
                     $('#group_friend_invite').append('<div class="container_50" onclick="action.event_invite(this)"  id="event_invite_' + index + '" data="' + index + '"><img class="lfloat" src=' + global_pimage[index] + ' width="50" height="50" /><div class="name_50">' + global_name[index] + '</div></div>');
                     $('.search_items:first').css('background', '#ebebeb');
                     $('.search_items:first .name_50 a').css('color', '#333333');
                     count++;
                  }
               }
            }
         });
      }
   }

   function suggest_deploy(me, data)
   {
      var i = 1;
      var con_name;
      $.each(data.action, function(index, value)
      {
         con_name = '#' + 'suggest_container' + i;
         $(con_name).html('<div class="people" id="suggest_' + value.profileid + '" data="' + value.profileid + '" ><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" src=' + data.pimage[value.profileid] + ' height="35" width="35" /></a><div class="name_35"><a style="font-weight:bold;"  class="ajax_nav" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_add_friend" onclick="action.really_add_friend(this)" >+Follow </span></div></div></div>');
         i++;
      });
   }

   function suggest_deploy_page(me, data)
   {
      var i = 1;
      var con_name;
      if (data.action.length > 0)
      {
         $.each(data.action, function(index, value)
         {
            con_name = '#' + 'suggest_container' + i;
            $(con_name).html('<div class="people" id="suggest_' + value.profileid + '" data="' + value.profileid + '" ><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" src=' + data.pimage[value.profileid] + ' height="80" width="80" /></a><div class="name_80"><a style="font-weight:bold;" class="ajax_nav" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_add_friend" onclick="action.really_add_friend_page(this)" >+Follow </span></div></div></div>');
            i++;
         });
      }
      else
      {
         $('#friend_suggest').html('<div style="text-align:center;margin-top:2em;">No suggestions to show ! Please Invite a colleague to join the network .</div><div class="panel panel-default"><div class="panel-heading">Invite A Friend To Join Quipmate</div><div class="panel-body"><input type="text" id="invite_box" value="" placeholder="Enter an email address" /><input type="submit" title="Invite A Friend" id="invite_button" class="theme_button" value="Invite" onclick="action.friend_invite(this)" /></div></div>');
      }
   }

   function group_suggest_page_deploy(me, data)
   {
      var i = 1;
      var con_name;
      if (data.action.length > 0)
      {
         $.each(data.action, function(index, value)
         {
            con_name = '#' + 'group_suggest_container' + i;
            $(con_name).html('<div class="people" id="group_suggest_' + value.profileid + '" data="' + value.profileid + '" ><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" src=' + data.pimage[value.profileid] + ' height="80" width="80" /></a><div class="name_80"><a class="ajax_nav" style="font-weight:bold;"href="group.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_group_join" onclick="action.really_group_join_page(this)" >+Join Group</span></div></div></div>');
            i++;
         });
      }
      else
      {
         $('#group_suggest').html('<div style="text-align:center;margin-top:4em;">No suggestions to show ! <input type="submit" class-="theme_button" onclick="ui.group_create(this)" title="Create a group for people with a specific interest" value="Create group" /></div>');
      }
   }

   function group_suggest_deploy(me, data)
   {
      var i = 1;
      var con_name;
      $.each(data.action, function(index, value)
      {
         con_name = '#' + 'group_suggest_container' + i;
         $(con_name).html('<div class="people" id="group_suggest_' + value.profileid + '" data="' + value.profileid + '" ><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" src=' + data.pimage[value.profileid] + ' height="35" width="35" /></a><div class="name_35"><a class="ajax_nav" style="font-weight:bold;"href="group.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_group_join" onclick="action.really_group_join(this)" >+Join Group</span></div></div></div>');
         i++;
      });
   }

   function event_suggest_deploy(me, data)
   {
      var i = 1;
      var con_name;
      $.each(data.action, function(index, value)
      {
         con_name = '#' + 'event_suggest_container' + i;
         $(con_name).html('<div class="people" id="event_suggest_' + value.profileid + '" data="' + value.profileid + '" ><a class="ajax_nav" href="event.php?id=' + value.profileid + '"><img class="lfloat" src=' + data.pimage[value.profileid] + ' height="35" width="35" /></a><div class="name_35"><a class="ajax_nav" style="font-weight:bold;"href="event.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_going_event" onclick="action.really_going_event(this)" >+Going</span></div></div></div>');
         i++;
      });
   }

   function upload_default_state()
   {
      $('#uploader').html('');
      ui.enable_upload_area();
   }

   function upload_active_state()
   {
      $('#uploader').html('<div><textarea id="link_box" placeholder="What are you working on today?" style="cursor:nw-resize;"></textarea></div><div><input id="link_button" type="submit" class="theme_button" value="Share"><input id="link_button" type="submit" value="Cancel" class="theme_button left4" onclick="ui.upload_default_state()" ></div> ');
      ui.enable_upload_area();
   }

   function response_comment(container, actionid, life_is_fun, time, myprofileid, myphoto)
   {
      var icon_cdn = $('#icon_cdn').attr('value');
      $(container).children().eq(1).children().eq(3).append('<div class="time_tag_json"><span onclick="action.response(this)" class="response" style="color:#336699;">Exciting: </span><a href="action.php?actionid=' + actionid + '&life_is_fun=' + life_is_fun + '"><img src="' + icon_cdn + '/clock.png" width="6" /><span class="time" data="' + time + '">' + ui.time_difference(time) + '</span></a></div><div class="likeclass_json"><span class="excited_people"></span><span class="post_pointer"></span></div><div></div><div class="cclass_box" ><textarea class="commentbox" style="margin:0em 0em 0em 0.5em;" placeholder="Add a comment..." onkeyup="action.comment(this, event)"></textarea></div></div></div>');
      $(container).append('<span onclick="ui.post_delete(this)" class="post_setting"></span>');
   }

   function suggest_single_deploy(me, data)
   {
      $.each(data.action, function(index, value)
      {
         $(me).html('<div class="people" id="suggest_' + value.profileid + '" data="' + value.profileid + '" ><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" src=' + data.pimage[value.profileid] + ' height="35" width="35" /></a><div class="name_35"><a style="font-weight:bold;" class="ajax_nav" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_add_friend" onclick="action.really_add_friend(this)" >+Follow </span></div></div></div>');
      });
   }

   function file_upload(profileid, action)
   {
      $('#uploader').html('<div id="main_div"><input type="hidden" value="6"/><div></div><div style="margin:0.5em;"><Strong>Select a file on your computer</strong></div><div style="margin-top:15px 0 20 0px;"><div id="photo_preview"></div><form id="pform" method="post" enctype="multipart/form-data" action="/ajax/write.php"><textarea type="text" placeholder="Say something about this file" id="photo_description" name="photo_description"/></textarea><input  size="30" type="file" name="photo_box" id="photo_box" class="file_inline" /><div class="top1"><input type="submit" name="upload" id="photo_upload_button" class="theme_button" value="Upload"><input type="button" name="cancel" class="theme_button left4" value="Cancel" onclick="ui.upload_default_state()"></div><input type="hidden" id="photo_hidden_profileid" name="photo_hidden_profileid" value="' + profileid + '"/><input type="hidden" name="action" value="' + action + '"/></form></div></div>');
      ui.enable_upload_area();
   }

   function OnProgress(event, position, total, percentComplete)
   {
    if($("#main_div").length)
    {
      $("#main_div").html('<div id="progressbox" style="display:none;"><div id="progressbar"></div ><div id="statustxt">0%</div></div><div id="output"></div>');
    }
    else if ($('#upload_progress').length)
    {
        $("#upload_progress").html('<div id="progressbox" style="display:none;"><div id="progressbar"></div ><div id="statustxt">0%</div></div><div id="output"></div>');    
    }
      //Progress bar
      $('#progressbox').css(
      {
         "display": "block"
      });
      $('#progressbar').css(
      {
         "display": "block",
         "width": percentComplete + '%',
         "background": "#cccccc"
      });
      console.log(percentComplete);
      $('#statustxt').html('' + percentComplete + '%');
      if (percentComplete > 50)
      {
         $('#statustxt').css(
         {
            "color": "#fff"
         }); //change status text to white after 50%
      }
   }

   function album_upload(profileid)
   {
      $('#uploader').html('<div id="main_div"><input type="hidden" value="5"/><div></div><div style="margin:0.5em;"><Strong>Add multiple photo from your computer in an album</strong></div><div style="margin-top:15px 0 20 0px;"><div id="moment_preview"></div><form id="mform" method="post" enctype="multipart/form-data" action="/ajax/write.php"><textarea placeholder="Enter album name" id="moment_name" name="moment_name"></textarea><div style="display:inline;" id="moment_photo_browser"><input size="40" type="file" class="mom file_inline" name="photo_box[]" id="photo_box" /></div><div class="top1"><input  type="submit" name="upload" id="moment_upload_button" class="theme_button" value="Upload"><input type="button" name="cancel" class="theme_button left4" value="Cancel" onclick="ui.upload_default_state()"></div><input type="hidden" id="moment_hidden_profileid" name="moment_hidden_profileid" value="' + profileid + '"/><input type="hidden" id="moment_photo_count" name="moment_photo_count" value=""/><input type="hidden" name="action" value="album_upload"/></form></div></div>');
      ui.enable_upload_area();
   }

   function restore_action_field()
   {
      $('#uploader').html('<input type="text" id="status_box" value="" /><input id="link_button" class="theme_button" type="submit" value="Share">');
   }

   function suggest_single_deploy_page(me, data)
   {
      $.each(data.action, function(index, value)
      {
         $(me).html('<div class="people" id="suggest_' + value.profileid + '" data="' + value.profileid + '" ><a class="ajax_nav" href="profile.php?id=' + value.profileid + '"><img class="lfloat" src=' + data.pimage[value.profileid] + ' height="80" width="80" /></a><div class="name_80"><a style="font-weight:bold;" class="ajax_nav" href="profile.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_add_friend" onclick="action.really_add_friend_page(this)" >+Follow </span></div></div></div>');
      });
   }

   function group_suggest_single_deploy(me, data)
   {
      $.each(data.action, function(index, value)
      {
         $(me).html('<div class="people" id="suggest_' + value.profileid + '" data="' + value.profileid + '" ><a class="ajax_nav" href="group.php?id=' + value.profileid + '"><img class="lfloat" src=' + data.pimage[value.profileid] + ' height="35" width="35" /></a><div class="name_35"><a class="ajax_nav" style="font-weight:bold;"href="group.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_add_friend" onclick="action.really_group_join(this)" >+Join Group</span></div></div></div>');
      });
   }

   function group_suggest_single_deploy_page(me, data)
   {
      $.each(data.action, function(index, value)
      {
         $(me).html('<div class="people" id="suggest_' + value.profileid + '" data="' + value.profileid + '" ><a class="ajax_nav" href="group.php?id=' + value.profileid + '"><img class="lfloat" src=' + data.pimage[value.profileid] + ' height="80" width="80" /></a><div class="name_80"><a class="ajax_nav" style="font-weight:bold;"href="group.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_add_friend" onclick="action.really_group_join_page(this)" >+Join Group</span></div></div></div>');
      });
   }

   function event_suggest_single_deploy(me, data)
   {
      $.each(data.action, function(index, value)
      {
         $(me).html('<div class="people" id="suggest_' + value.profileid + '" data="' + value.profileid + '" ><a class="ajax_nav" href="event.php?id=' + value.profileid + '"><img class="lfloat" src=' + data.pimage[value.profileid] + ' height="35" width="35" /></a><div class="name_35"><a class="ajax_nav" style="font-weight:bold;"href="event.php?id=' + value.profileid + '">' + data.name[value.profileid] + '</a><div  style="cursor:pointer;padding:0.2em 0em 0em 0em;"><span class="really_add_friend" onclick="action.really_going_event(this)" >+Going</span></div></div></div>');
      });
   }

   function friend_suggest_close()
   {
      $('html').not('#friend_req').click(function()
      {
         $('#friend_req').remove();
         $('#center, #right , #left , #header').css("opacity", "1");
      });
   }

   function feedback(me)
   {
      $('.group_create_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div class="group_create_container"><div class="group_create_title">Submit your feedback</div><div class="group_create_content"><div id="group_info"></div><div><input type="text" id="group_name" style="margin: 1em 0em;padding:0.5em;width:24em;" placeholder="What is the feedback for?" value=""></div><div><textarea style="margin: 1em 0em;padding:0.5em;" id="group_description" placeholder="Add few more words"></textarea></div><div class="group_create_button" style="margin-left:5em;"><input type="submit" onclick="ui.bg_hide()" value="Cancel" class="group_create_negative theme_button"><input style="margin:0em 1em" type="submit" onclick="action.feedback(this)" value="Submit" class="group_create_positive theme_button"></div></div>');
      return false;
   }

   function group_create(me)
   {
      $('.group_create_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div class="group_create_container"><div class="group_create_title">Create a group</div><div class="group_create_content"><div id="group_info"></div><div><input type="text" id="group_name" style="margin: 1em 0em;padding:0.5em;" placeholder="Group name" value=""></div><div><textarea style="margin: 1em 0em;padding:0.5em;" id="group_description" placeholder="What is this group about ?"></textarea> </div><div style="margin:2em 0em;text-align:left;margin-left:15em;"><div style="margin:1em 0em;">Privacy: <select id="group_privacy"><option value="0">Public</option><option value="1">Private</option></select></div><div style="margin:1em 0em"><input type="checkbox" id="group_technical"> Technical</div></div><div class="group_create_button" style="margin-left:5em;"><input type="submit" onclick="ui.bg_hide()" value="Cancel" class="group_create_negative theme_button"><input style="margin:0em 1em" type="submit" onclick="action.group_create(this)" value="Create Group" class="group_create_positive theme_button"></div></div>');
   }

   function page_create(me)
   {
      $('.group_create_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div class="group_create_container"><div class="group_create_title">Create a new Page</div><div class="group_create_content"><div id="page_info"></div><div><input type="text" id="page_name" style="margin: 1em 0em;padding:0.5em;" placeholder="Page name" value=""></div><div><textarea style="margin: 1em 0em;padding:0.5em;" id="page_description" placeholder="What is this page about ?"></textarea> </div><div class="group_create_button" style="margin-left:5em;"><input type="submit" onclick="ui.bg_hide()" value="Cancel" class="group_create_negative theme_button"><input style="margin:0em 1em" type="submit" onclick="action.page_create(this)" value="Create Page" class="group_create_positive theme_button"></div></div>');
   }

   function group_event_create(me)
   {
      $('.group_create_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div class="group_create_container"><div class="group_create_title">Create event for this group</div><div class="group_create_content"><div id="group_info"></div><div><input type="text" id="event_name" style="margin: 1em 0em;padding:0.5em;width:20em;border:0.1em solid #aaaaaa;" placeholder="Event name" value=""></div><div><textarea style="margin: 1em 0em;padding:0.5em;" id="event_description" placeholder="Describe the event in few more words"></textarea></div><div style="margin:2em 0em;">When : <select id="event_day" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Day</option><option value="01">1</option><option value="02">2</option><option value="03">3</option><option value="04">4</option><option value="05">5</option><option value="06">6</option><option value="07">7</option><option value="08">8</option><option value="09">9</option><option value="10">10</option> <option value="11">11</option><option value="12">12</option><option value="01">13</option><option value="02">14</option><option value="03">15</option><option value="04">16</option><option value="05">17</option><option value="06">18</option><option value="07">19</option><option value="08">20</option><option value="09">21</option> <option value="10">22</option><option value="11">23</option><option value="12">24</option><option value="01">25</option><option value="02">26</option> <option value="03">27</option><option value="04">28</option> <option value="05">29</option><option value="04">30</option><option value="05">31</option></select><select id="event_month" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Month</option> <option value="01">JAN</option><option value="02">FEB</option><option value="03">MAR</option><option value="04">APR</option><option value="05">MAY</option><option value="06">JUN</option> <option value="07">JUL</option><option value="08">AUG</option> <option value="09">SEP</option><option value="10">OCT</option><option value="11">NOV</option> <option value="12">DEC</option></select><select id="event_year" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Year</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option></select><select id="event_time" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Time</option><option value="09:00:00">09:00 am</option><option value="09:30:00">09:30 am</option><option value="10:00:00">10:00 am</option><option value="10:30:00">10:30 am</option><option value="11:30:00">11:30 am</option><option value="12:00:00">12:00 pm</option><option value="12:30:00">12:30 pm</option><option value="13:00:00">01:00 pm</option><option value="13:30:00">01:30 pm</option><option value="14:00:00">02:00 pm</option><option value="14:30:00">02:30 pm</option><option value="15:00:00">03:00 pm</option><option value="15:30:00">03:30 pm</option><option value="16:00:00">04:00 pm</option><option value="16:30:00">04:30 pm</option><option value="17:00:00">05:00 pm</option><option value="17:30:00">05:30 pm</option><option value="18:00:00">06:00 pm</option><option value="18:30:00">06:30 pm</option><option value="19:00:00">07:00 pm</option><option value="19:30:00">07:30 pm</option><option value="20:00:00">08:00 pm</option><option value="20:30:00">08:30 pm</option><option value="21:00:00">09:00 pm</option><option value="21:30:00">09:30 pm</option><option value="22:00:00">10:00 pm</option><option value="22:30:00">10:30 pm</option><option value="23:00:00">11:00 pm</option><option value="23:30:00">11:30 pm</option><option value="00:00:00">12:00 am</option><option value="00:30:00">12:30 am</option><option value="01:00:00">01:00 am</option><option value="01:30:00">01:30 am</option><option value="02:00:00">02:00 am</option><option value="02:30:00">02:30 am</option><option value="03:00:00">03:00 am</option><option value="03:30:00">03:30 am</option><option value="01:00:00">01:00 am</option><option value="01:30:00">01:30 am</option><option value="02:00:00">02:00 am</option><option value="02:30:00">02:30 am</option><option value="03:00:00">03:00 am</option><option value="03:30:00">03:30 am</option><option value="04:00:00">04:00 am</option><option value="04:30:00">04:30 am</option><option value="05:00:00">05:00 am</option><option value="05:30:00">05:30 am</option><option value="06:00:00">06:00 am</option><option value="06:30:00">06:30 am</option><option value="07:00:00">07:00 am</option><option value="07:30:00">07:30 am</option><option value="08:00:00">08:00 am</option><option value="08:30:00">08:30 am</option></select></div><div>Where: <input type="text" id="event_where" value="" placeholder="Venue of this event" style="padding:0.5em;width:22em"/></div><div style="margin:2em 0em;"><div style="margin:1em 0em;">Privacy: Only for members of this group</div></div><div class="group_create_button" style="margin-left:5em;"><input type="submit" onclick="ui.bg_hide()" value="Cancel" class="group_create_negative theme_button"><input style="margin:0em 1em" type="submit" onclick="action.group_event_create(this)" value="Create Event" class="group_create_positive theme_button"></div></div>');
   }

   function event_create(me)
   {
      $('.group_create_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div class="group_create_container"><div class="group_create_title">Create Event</div><div class="group_create_content"><div id="group_info"></div><div><input type="text" id="event_name" style="margin: 1em 0em;padding:0.5em;width:20em;border:0.1em solid #aaaaaa;" placeholder="Event name" value=""></div><div><textarea style="margin: 1em 0em;padding:0.5em;" id="event_description" placeholder="Describe the event in few more words"></textarea></div><div style="margin:2em 0em;">When : <select id="event_day" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Day</option><option value="01">1</option><option value="02">2</option><option value="03">3</option><option value="04">4</option><option value="05">5</option><option value="06">6</option><option value="07">7</option><option value="08">8</option><option value="09">9</option><option value="10">10</option> <option value="11">11</option><option value="12">12</option><option value="01">13</option><option value="02">14</option><option value="03">15</option><option value="04">16</option><option value="05">17</option><option value="06">18</option><option value="07">19</option><option value="08">20</option><option value="09">21</option> <option value="10">22</option><option value="11">23</option><option value="12">24</option><option value="01">25</option><option value="02">26</option> <option value="03">27</option><option value="04">28</option> <option value="05">29</option><option value="04">30</option><option value="05">31</option></select><select id="event_month" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Month</option> <option value="01">JAN</option><option value="02">FEB</option><option value="03">MAR</option><option value="04">APR</option><option value="05">MAY</option><option value="06">JUN</option> <option value="07">JUL</option><option value="08">AUG</option> <option value="09">SEP</option><option value="10">OCT</option><option value="11">NOV</option> <option value="12">DEC</option></select><select id="event_year" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Year</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option></select><select id="event_time" style="margin:0em 0.2em;height:2.6em;padding:0.5em;"><option value="-1">Time</option><option value="09:00:00">09:00 am</option><option value="09:30:00">09:30 am</option><option value="10:00:00">10:00 am</option><option value="10:30:00">10:30 am</option><option value="11:30:00">11:30 am</option><option value="12:00:00">12:00 pm</option><option value="12:30:00">12:30 pm</option><option value="13:00:00">01:00 pm</option><option value="13:30:00">01:30 pm</option><option value="14:00:00">02:00 pm</option><option value="14:30:00">02:30 pm</option><option value="15:00:00">03:00 pm</option><option value="15:30:00">03:30 pm</option><option value="16:00:00">04:00 pm</option><option value="16:30:00">04:30 pm</option><option value="17:00:00">05:00 pm</option><option value="17:30:00">05:30 pm</option><option value="18:00:00">06:00 pm</option><option value="18:30:00">06:30 pm</option><option value="19:00:00">07:00 pm</option><option value="19:30:00">07:30 pm</option><option value="20:00:00">08:00 pm</option><option value="20:30:00">08:30 pm</option><option value="21:00:00">09:00 pm</option><option value="21:30:00">09:30 pm</option><option value="22:00:00">10:00 pm</option><option value="22:30:00">10:30 pm</option><option value="23:00:00">11:00 pm</option><option value="23:30:00">11:30 pm</option><option value="00:00:00">12:00 am</option><option value="00:30:00">12:30 am</option><option value="01:00:00">01:00 am</option><option value="01:30:00">01:30 am</option><option value="02:00:00">02:00 am</option><option value="02:30:00">02:30 am</option><option value="03:00:00">03:00 am</option><option value="03:30:00">03:30 am</option><option value="01:00:00">01:00 am</option><option value="01:30:00">01:30 am</option><option value="02:00:00">02:00 am</option><option value="02:30:00">02:30 am</option><option value="03:00:00">03:00 am</option><option value="03:30:00">03:30 am</option><option value="04:00:00">04:00 am</option><option value="04:30:00">04:30 am</option><option value="05:00:00">05:00 am</option><option value="05:30:00">05:30 am</option><option value="06:00:00">06:00 am</option><option value="06:30:00">06:30 am</option><option value="07:00:00">07:00 am</option><option value="07:30:00">07:30 am</option><option value="08:00:00">08:00 am</option><option value="08:30:00">08:30 am</option></select></div><div>Where: <input type="text" id="event_where" value="" placeholder="Venue of this event" style="padding:0.5em;width:22em"/></div><div style="margin:2em 0em;"><div style="margin:1em 0em;">Privacy: <select id="event_privacy" style="height:2.6em;padding:0.5em;width:23.4em;"><option value="0">Public</option><option value="1">Private</option></select></div><div style="margin:2em 5em 0 0em;">Invite: <input type="checkbox" id="event_invite" checked> Guests can invite their friends</div></div><div class="group_create_button" style="margin-left:5em;"><input type="submit" onclick="ui.bg_hide()" value="Cancel" class="group_create_negative theme_button"><input style="margin:0em 1em" type="submit" onclick="action.event_create(this)" value="Create Event" class="group_create_positive theme_button"></div></div>');
   }

   function notice_scroll()
   {
      if ($('#text').get(0).scrollTop > $('#text').get(0).scrollHeight * 0.1 && notice_load)
      {
         var st = $('#text').get(0).scrollTop;
         if (st > lastScrollTop)
         {
            notice_load = false;
            $.getJSON('ajax/write.php', {
               action: 'notice_fetch',
               start: notice_start
            }, function(data)
            {
               notice_start += 10;
               notice_load = true;
               deploy.notice_deploy(data, '#text');
            });
         }
      }
      lastScrollTop = st;
   }

   function notice_fetch(me, event)
   {
      var icon_cdn = $('#icon_cdn').attr('value');
      $(document).attr('title', 'Quipmate');
      $('#notice_container').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div id="notice_container" data="notice"></div>');
      $('#notice_container').css('left', $('#search_form').position().left + 391 + 'px');
      notice_start = 0;
      notice_load = true;
      $('#text').remove();
      $("#numnotice").html("");
      $('#notice_container').append('<div id="notice_icon_pointer"></div><div id="notice_container_title" style = "background:#f5f5f5;cursor:pointer;font-weight:bold;color:#000000;font-size:1.1em;padding-left:1em;height: 1.4em;"><span>Top Notifications</span><span class= "seeall" style = "margin-right:0.5em;float:right;">See All</span></div><div id="text"><img id="loading" src="' + icon_cdn + '/loading.gif" alt="Loading..."></div><div class = "seeall" style = "background:#f5f5f5;color:#000000;cursor:pointer;font-weight:bold;height: 1.4em;" align ="center">See All Notifications</div>');
      $.getJSON('ajax/write.php', {
         action: 'notice_fetch',
         start: '0'
      }, function(data)
      {
         notice_start = 10;
         $('#loading').remove();
         deploy.notice_deploy(data, '#text');
         $('.notice_drop').live('mouseover', function()
         {
            var actionid = $(this).attr('id');
         });
         var lastScrollTop = $('#text').get(0).scrollTop;
         $('#text').scroll(notice_scroll);
      });
   }

   function message_fetch(me, event)
   {
      var icon_cdn = $('#icon_cdn').attr('value');
      $(document).attr('title', 'Quipmate');
      $('#text').remove();
      $("#message_count").html("");
      $('#notice_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div id="notice_container" data="message"></div>');
      $('#notice_container').css('left', $('#search_form').position().left + 355 + 'px');
      $('#notice_container').append('<div id="notice_icon_pointer"></div><div id="notice_container_title" style = "background:#f5f5f5;cursor:pointer;font-weight:bold;color:#000000;font-size:1.1em;padding-left:1em;"><span>All Messages</span><span class= "message_seeall" style = "margin-right:0.5em;float:right;">See All</span></div><div id="text"><img id="loading" src="' + icon_cdn + '/loading.gif" alt="Loading..."></div><div class = "message_seeall" style = "background:#f5f5f5;color:#000000;cursor:pointer;font-weight:bold;" align ="center">See All Messages</div>');
      $.getJSON('ajax/write.php', {
         action: 'message_recent_fetch',
         start: '0'
      }, function(data)
      {
         $('#loading').remove();
         callback.message_recent_fetch('#bring_message', data, '#text');
         $('.notice_drop').live('mouseover', function()
         {
            var actionid = $(this).attr('id');
         });
      });
   }

   function request_fetch(me, event)
   {
      var icon_cdn = $('#icon_cdn').attr('value');
      $(document).attr('title', 'Quipmate');
      $('#text').remove();
      $("#request_count").html("");
      $('#notice_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div id="notice_container" data="fr_missu_ei"></div>');
      $('#notice_container').css('left', $('#search_form').position().left + 318 + 'px');
      $('#notice_container').append('<div id="notice_icon_pointer"></div><div id="notice_container_title" style = "background:#f5f5f5;cursor:pointer;font-weight:bold;color:#000000;font-size:1.1em;padding-left:1em;"><span>All Requests</span></div><div id="text"><img id="loading" src="' + icon_cdn + '/loading.gif" alt="Loading..."></div>');
      $.getJSON('ajax/write.php', {
         action: 'request_fetch',
         start: '0'
      }, function(data)
      {
         $('#loading').remove();
         callback.request_fetch('#bring_friend_request', data);
         $('.notice_drop').live('mouseover', function()
         {
            var actionid = $(this).attr('id');
         });
      });
   }
/*		function menu(me,event,admin)
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
				$('#account').append('<div id="menu_pointer"></div><div class="menu_each"><a class="menu_each_a ajax_nav"  href="profile.php?hl=bio">Edit Profile</a></div><div class="menu_each"><a class="menu_each_a"  href="register.php?hl=profile_picture">Change Profile Picture</a></div><div class="menu_each"><a class="menu_each_a" href="settings.php">Account Settings</a></div><div class="menu_each"><a class="menu_each_a" href="logout.php">Logout</a></div>');
				if(admin ==1)
				{
				$('#account').append('<div class="menu_each"><a class="menu_each_a ajax_nav"  href="admin.php">Use as Admin</a></div>')
				}
				
			} */
   // Function not in use

   function profile_post_privacy(me, event)
   {
      if (navigator.appName == 'Microsoft Internet Explorer')
      {
         event.cancelBubble = true
      }
      else
      {
         event.stopPropagation();
      }
      $('#profile_post_privacy_drop').remove();
      var pleft = event.pageX - 101 + 'px';
      var ptop = event.pageY + 17 + 'px';
      $('body').append('<div id ="profile_post_privacy_drop" style="position:absolute;background-color:#ffffff;border:0.1em solid #cccccc;"><div id="menu_pointer"></div><div class="menu_each"><a class="menu_each_a" value="0" data="profile_post_next" onclick="action.profile_privacy_update(this)">Public</a></div><div class="menu_each"><a class="menu_each_a"  value="2" data="profile_post_next" onclick="action.profile_privacy_update(this)">Followers</a></div></div>');
      $('#profile_post_privacy_drop').css('left', pleft);
      $('#profile_post_privacy_drop').css('top', ptop);
   }

   function bio_privacy(me, event, key)
   {
      if (navigator.appName == 'Microsoft Internet Explorer')
      {
         event.cancelBubble = true
      }
      else
      {
         event.stopPropagation();
      }
      $('#profile_post_privacy_drop').remove();
      var pleft = $(me).position().left + 20 + 'px';
      var ptop = $(me).position().top + 70 + 'px';
      $(me).parent().append('<div id ="profile_post_privacy_drop" style="position:absolute;background-color:#ffffff;border:0.1em solid #cccccc;"><div id="menu_pointer"></div><div class="menu_each"><a class="menu_each_a" value="0" data="' + key + '" onclick="action.profile_privacy_update(this)">Public</a></div><div class="menu_each"><a class="menu_each_a"  value="2" data="' + key + '" onclick="action.profile_privacy_update(this)">Followers</a></div></div>');
      $('#profile_post_privacy_drop').css('left', '24em');
      $('#profile_post_privacy_drop').css('top', '5em');
   }

   function gift_close()
   {
      $('#gift_container').remove();
      $('.bg_hide_cover').remove();
   }

   function gift_ui_create(me)
   {
      var image_cdn = $('#image_cdn').attr('value');
      $('#gift_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div id="gift_container" class="popup_container" style="position:fixed;left:50%;margin-left:-29em;top:9em;background-color:#ffffff;width:38em;z-index:100;overflow:auto;"></div>');
      $('#gift_container').html('<div id="gift_title" style="font-weight:bold;color:#333333;font-size:1.3em;padding:0.5em 0em;background-color:#ebebeb;text-align:center;">Chose a gift you like to send</div>');
      $('#gift_title').append('<div style="float:right;cursor:pointer;margin-right:0.5em;" class="closex" onClick = "ui.gift_close()">x</div>');
      $('#gift_container').append('<div id="gift_subpart" style="height:400px;scroll:auto;text-align:center;"><table><tr><td><img class="gift" onclick="ui.gift(this)" title="Holi Pichkari" id="30"src="' + image_cdn + '/holi_pichkari.gif"></td><td><img class="gift" onclick="ui.gift(this)" title="Holi Colors" id="31"src="' + image_cdn + '/holi_colors.jpg"></td><td><img class="gift" onclick="ui.gift(this)" title="Holi Gujiya" id="32"src="' + image_cdn + '/holi_gujiya.jpg"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)" title="Banana" id="1"src="' + image_cdn + '/banana.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Bangles" id="2"src="' + image_cdn + '/bangles.jpg"></td><td><img class="gift" onclick="ui.gift(this)" title="Beer" id="3"src="' + image_cdn + '/beer.jpg"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)" title="Bell" id="4"src="' + image_cdn + '/bell.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Bomb" id="5"src="' + image_cdn + '/bomb.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Cheeseburger" id="6"src="' + image_cdn + '/cheeseburger.png"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)" title="Chocolate" id="7"src="' + image_cdn + '/chocolate.jpg"></td><td><img class="gift" onclick="ui.gift(this)" title="Coffee" id="8"src="' + image_cdn + '/coffee.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Toothpaste" id="9"src="' + image_cdn + '/toothpaste.jpg"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)" title="Deodorant" id="10"src="' + image_cdn + '/deodorant.jpg"></td><td><img class="gift" onclick="ui.gift(this)" title="Dust bin" id="11"src="' + image_cdn + '/dust_bin.png"></td><td><img class="gift" onclick="ui.gift(this)"  id="12" title="	Fair and handsome"src="' + image_cdn + '/fair_and_handsome.jpg"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)" title="Fair and Lovely.jpg" id="13"src="' + image_cdn + '/fair_and_lovely.jpg"></td><td><img class="gift" onclick="ui.gift(this)" title="Guitar" id="14"src="' + image_cdn + '/guitar.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Gun" id="15"src="' + image_cdn + '/gun.png"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)" title="Ice Cream" id="16"src="' + image_cdn + '/ice_cream.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Island" id="17"src="' + image_cdn + '/island.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Island with penguins" id="18"src="' + image_cdn + '/island_with_penguins.png"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)"  id="19" title="Lip stick"src="' + image_cdn + '/lip_stick.png"></td><td><img title="Makeup kit" class="gift" onclick="ui.gift(this)" id="20"src="' + image_cdn + '/makeup_kit.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Milk" id="21"src="' + image_cdn + '/milk.png"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)" title="Movie Ticket" id="22"src="' + image_cdn + '/movie_ticket.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Package" id="23"src="' + image_cdn + '/package.png"></td><td><img class="gift" onclick="ui.gift(this)"  title="Room cleaner" id="24"src="' + image_cdn + '/room_cleaner.png"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)"  id="25" title="Rose"src="' + image_cdn + '/rose.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Smile" id="26"src="' + image_cdn + '/smile.gif"></td><td><img class="gift" onclick="ui.gift(this)" title="Soap" id="27"src="' + image_cdn + '/soap.png"></td></tr><tr><td><img class="gift" onclick="ui.gift(this)" title="Toast" id="28"src="' + image_cdn + '/toast.png"></td><td><img class="gift" onclick="ui.gift(this)" title="Taj Mahal" id="29"src="' + image_cdn + '/taj_mahal.jpg"></td></tr></table></div>');
   }

   function mood(me)
   {
      var image_cdn = $('#image_cdn').attr('value');
      $('#mood_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div id="mood_container" class="popup_container" style="position:fixed;left:50%;margin-left:-29em;top:9em;background-color:#ffffff;width:38em;z-index:100;overflow:auto;"></div>');
      $('#mood_container').html('<div id="mood_title" style="font-weight:bold;color:#333333;font-size:1.3em;padding:0.5em 0em;background-color:#ebebeb;text-align:center;">How are you feeling?</div>');
      $('#mood_title').append('<div style="float:right;cursor:pointer;margin-right:0.5em;" onClick ="ui.mood_close()">x</div>');
      $('#mood_container').append('<div id="mood_subpart" style="height:400px;scroll:auto;overflow-y:scroll;text-align:center;"><table><tr><td><img onclick="ui.mood_click(this,1)" title="Angry" id="1"src="' + image_cdn + '/angry.png"></td><td><img onclick="ui.mood_click(this,2)" title="Big Smile" id="2"src="' + image_cdn + '/big_smile.png"></td><td><img onclick="ui.mood_click(this,3)" title="Chatty" id="3"src="' + image_cdn + '/chatty.png"></td></tr><tr><td><img onclick="ui.mood_click(this,4)" title="Dangerous" id="4"src="' + image_cdn + '/dangerous.png"></td><td><img onclick="ui.mood_click(this,5)" title="Devil" id="5"src="' + image_cdn + '/devil.png"></td><td><img onclick="ui.mood_click(this,6)" title="Doubtful" id="6"src="' + image_cdn + '/doubtful.png"></td></tr><tr><td><img onclick="ui.mood_click(this,7)" title="Dribbling" id="7"src="' + image_cdn + '/dribbling.png"></td><td><img onclick="ui.mood_click(this,8)" title="Exhausted" id="8"src="' + image_cdn + '/exhausted.png"></td><td><img onclick="ui.mood_click(this,9)" title="Feared" id="9"src="' + image_cdn + '/feared.png"></td></tr><tr><td><img onclick="ui.mood_click(this,10)" title="Foxy Lady" id="10"src="' + image_cdn + '/foxy_lady.png"></td><td><img onclick="ui.mood_click(this,11)" title="Green Bug" id="11"src="' + image_cdn + '/green_bug.png"></td><td><img onclick="ui.mood_click(this,12)" id="12" title="Happy"src="' + image_cdn + '/happy.png"></td></tr><tr><td><img onclick="ui.mood_click(this,13)" title="Hell Boy" id="13"src="' + image_cdn + '/hell_boy.png"></td><td><img onclick="ui.mood_click(this,14)" title="Hey Baby" id="14"src="' + image_cdn + '/hey_baby.png"></td><td><img onclick="ui.mood_click(this,15)" title="Kiss Me" id="15"src="' + image_cdn + '/kiss_me.png"></td></tr><tr><td><img onclick="ui.mood_click(this,16)" title="Naughty" id="16"src="' + image_cdn + '/naughty.png"></td><td><img onclick="ui.mood_click(this,17)" title="Ohhhhhh" id="17"src="' + image_cdn + '/ohhhhh.png"></td><td><img onclick="ui.mood_click(this,18)" title="Playing in Money" id="18"src="' + image_cdn + '/playing_in_money.png"></td></tr><tr><td><img title="Rapper" onclick="ui.mood_click(this,19)"  id="19"src="' + image_cdn + '/rapper.png"></td><td><img onclick="ui.mood_click(this,20)"  id="20" title="Sad"src="' + image_cdn + '/sad.png"></td><td><img onclick="ui.mood_click(this,21)" title="Shameful" id="21"src="' + image_cdn + '/shameful.png"></td></tr><tr><td><img onclick="ui.mood_click(this,22)" title="Smiling" id="22"src="' + image_cdn + '/smile.png"></td><td><img onclick="ui.mood_click(this,23)" title="Speaking" id="23"src="' + image_cdn + '/speaking.png"></td><td><img onclick="ui.mood_click(this,24)"  title="Surprised" id="24"src="' + image_cdn + '/surprised.png"></td></tr><tr><td><img onclick="ui.mood_click(this,25)"  id="25" title="Surrender"src="' + image_cdn + '/surrender.png"></td><td><img onclick="ui.mood_click(this,26)" title="Sweet Kiss" id="26"src="' + image_cdn + '/sweet_kiss.png"></td><td><img onclick="ui.mood_click(this,27)" title="Teasing" id="27"src="' + image_cdn + '/teasing.png"></td></tr><tr><td><img onclick="ui.mood_click(this,28)" title="Terrorist" id="28"src="' + image_cdn + '/terrorist.png"></td><td><img onclick="ui.mood_click(this,29)" title="Sad" id="29"src="' + image_cdn + '/sad.png"></td></tr></table></div>');
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
      $('#message_container').html('<div id="message_title" style="font-weight:bold;color:#333333;font-size:1.3em;padding:0.5em 0em;background-color:#ebebeb;text-align:center;">Write a Message</div>');
      $('#message_title').append('<div style="float:right;cursor:pointer;margin-right:0.5em;" onClick ="ui.message_close()">x</div>');
      $('#message_container').append('<div style="font-size:1.1em;padding:0.5em;"><textarea id="message_textarea" placeholder="Write a message ..." style="border:0.1em solid #cccccc;color:#808080;height:5em;padding:0.5em;resize:none;width:28em;"></textarea></div>');
      $('#message_container').append('<div style="margin: 1em 0em;"><input style="width:6.5em;height:3em;font-weight:bold;background-color:#ebebeb;color:#333333;cursor:pointer;border: 0.1em solid #FFFFFF;" type="submit" value="Cancel" class="message_ok theme_button" onclick="ui.message_close(this)" /><input style="margin-left:2em;font-weight:bold;width:6em;height:3em;background-color:#ebebeb;color:#333333;cursor:pointer;border: 0.1em solid #FFFFFF;" type="submit" value="Send" class="theme_button" id="mood_done" onclick="action.message(this)"/></div>');
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
      $('body').append('<div id="tagline_container" class="popup_container" ></div>');
      $('#tagline_container').html('<div id="tagline_title" class="prompt_title">What drives you today?</div>');
      $('#tagline_title').append('<div style="float:right;cursor:pointer;margin-right:0.5em;" onClick ="ui.tagline_close()">x</div>');
      $('#tagline_container').append('<div style="height:9em;scroll:auto;"><input style="margin-top:2em;padding:.5em;border:0.1em solid #cccccc;height:2.5em;width:29em;" id="tagline_box" type="text" maxlength="50" placeholder="Write your tagline" /></div>');
      $('#tagline_container').append('<div style="margin: 1em 0em;"><input type="submit" value="Cancel" class="mood_button prompt_negative theme_button" onclick="ui.tagline_close(this)" /><input class="prompt_positive theme_button" type="submit" value="Set My Tagline" id="mood_done" onclick="action.tagline(this)"/></div>');
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
      $('#gift_container').css('overflow', 'hidden');
      $('#gift_subpart').css('height', '13em');
      $('#gift_subpart').html('<div><textarea id="gift_desc" style="margin:10px;padding:5px;height:5em;color:#333333; width:32em;resize:none;border-radius:0.2em;border:0.1em solid #cccccc;" placeholder="Add a gift message"></textarea></div>');
      $('#gift_subpart').append('<div style="margin-top:0.5em;"><input style="width:6.5em;height:3em;font-weight:bold;background-color:#ebebeb;color:#333333;cursor:pointer;" type="submit" value="Cancel" class="gift_button theme_button" onclick="ui.gift_close(this)" /><input style="margin-left:2em;font-weight:bold;width:10em;height:3em;background-color:#ebebeb;color:#333333;cursor:pointer;" type="submit" value="Send My Gift" id="gift_done" class="theme_button" onclick="action.gift(this,' + gift_id + ')"/></div>');
      $('#gift_desc').live('focus', function()
      {
         if ($(this).attr('value') == "Add a gift message")
         {
            $(this).attr('value', '');
         }
      });
   }

   function mood_click(me, mood)
   {
      $('#mood_container').css('overflow', 'hidden');
      $('#mood_subpart').css('height', '13em');
      $('#mood_subpart').html('<div><textarea id="mood_desc" style="margin:10px;padding:5px;height:5em;color:#333333; width:32em;resize:none;border-radius:0.2em;border:0.1em solid #cccccc;" placeholder="Describe your feelings"></textarea></div>');
      $('#mood_subpart').append('<div style="margin-top:0.5em;"><input style="width:6.5em;height:3em;font-weight:bold;background-color:#ebebeb;color:#333333;cursor:pointer;" type="submit" value="Cancel" class="mood_button theme_button" onclick="ui.mood_close(this)" /><input style="margin-left:2em;font-weight:bold;width:10em;height:3em;background-color:#ebebeb;color:#333333;cursor:pointer;" type="submit" value="Set My Mood" id="mood_done" class="theme_button" onclick="action.mood_done(this,' + mood + ')"/></div>');
      $('#mood_desc').live('focus', function()
      {
         if ($(this).attr('value') == "Add few more words")
         {
            $(this).attr('value', '');
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
      $('#uploader').html('<div id="main_div"><input type="hidden" value="6"/><div></div><div style="margin:0.5em;"><Strong>Select a photo on your computer</strong></div><div style="margin-top:15px 0 20 0px;"><div id="photo_preview"></div><form id="pform" method="post" enctype="multipart/form-data" action="/ajax/write.php"><input  size="30" type="file" name="photo_box" id="photo_box" /><input style="background-color:#ebebeb;color:#333333;height:2.4em;width:5em;cursor:pointer;padding:0.2em;" type="submit" name="upload" value="Upload" class="theme_button" onclick="action.photo_upload()" ><input type="hidden" id="photo_hidden_profileid" name="photo_hidden_profileid" value="' + profileid + '"/><input type="hidden" id="action" name="action" value="photo_upload"/></form></div></div>');
   }

   function popup_close(me)
   {
      $(me).remove();
   }

   function search(me)
   {
      $('body').append('<div id="search_container"></div>');
      $('#search_container').css('left', $('#search_form').position().left + 10 + 'px');
      $(window).resize(function()
      {
         $('#search_container').css('left', $('#search_form').position().left + 10 + 'px');
      });
      $('#to').focus(function()
      {
         $('.search_items').show();
      });
   }

   function search(me)
   {
      $('.search_items').live('click', function()
      {
         window.location = "/profile.php?id=" + $(this).attr('data');
      });
      $('#center, #left, #right').click(function()
      {
         $('.search_items').hide();
      });
      $('.search_items').live('mouseover', function()
      {
         $(this).css('background', '#336699');
         $(this).children().eq(1).children().eq(0).css('color', '#ffffff');
      });
      $('.search_items').live('mouseleave', function()
      {
         $(this).css('background', '#ffffff');
         $(this).children().eq(1).children().eq(0).css('color', '#336699');
      });
      $('#chat_search_box').keyup(function(event)
      {
         var pattern = $(this).val();
         $('.chat_user').each(function(index)
         {
            var search_name = $(this).children().eq(1).html().toLowerCase().split(" ");
            for (var i = 0; i < search_name.length; i++)
            {
               if ($(this).children().eq(1).html().toLowerCase().search($.trim('^' + pattern).toLowerCase()) != -1 || search_name[i].search($.trim('^' + pattern).toLowerCase()) != -1)
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
      $('body').append('<iframe id="video_playing" style="position:fixed;top:8em;left:30%;top:10%;z-index:999999" width="400" height="300" src="https://www.youtube.com/embed/' + videoid + '?autoplay=1" frameborder="0"></iframe>');
   }

   function video_shadow_click(me)
   {
      $(this).remove();
      $('#video_playing').remove();
   }

   function link_highlight(text)
   {
      if (text)
      {
         var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
         return text.replace(exp, "<a href='$1' target='_blank'>$1</a>");
      }
      return text;
   }

   function escape_tags(str)
   {
      var tags =
      {
         '&': '&amp;',
         '<': '&lt;',
         '>': '&gt;'
      };
      $.each(tags, function(index, value)
      {
         str = str.split(index).join(value);
      });
      return str;
   }

   function get_smiley(message)
   {
      var icon_cdn = $('#icon_cdn').attr('value');
      smiley =
      {
         ':)': '<img title="Smile" class="smiley_chat" src="' + icon_cdn + '/smile.png" />',
         ':D': '<img title="Laughing" class="smiley_chat" src="' + icon_cdn + '/laughing.png" />',
         ':(': '<img title="Sad" class="smiley_chat" src="' + icon_cdn + '/sad.png" />',
         ':P': '<img title="Tongue" class="smiley_chat" src="' + icon_cdn + '/tongue.png" />',
         ';)': '<img title="Wink" class="smiley_chat" src="' + icon_cdn + '/wink.png" />',
         /*':3' : '<img title="Curly Lips" class="smiley_chat" src="'+icon_cdn+'/curlylips.png" />',*/
         ':*': '<img  title="Kiss" class="smiley_chat" src="' + icon_cdn + '/kiss.png" />',
         '>:(': '<img title="Grumpy" class="smiley_chat" src="' + icon_cdn + '/grumpy.png" />',
         '8)': '<img title="Glasses" class="smiley_chat" src="' + icon_cdn + '/glasses.png" />',
         '8|': '<img title="Sun Glasses" class="smiley_chat" src="' + icon_cdn + '/sunglasses.png" />',
         '>:o': '<img title="Upset" class="smiley_chat" src="' + icon_cdn + '/upset.png" />',
         'o.O|': '<img title="Confused" class="smiley_chat" src="' + icon_cdn + '/confused.png" />',
         ':v': '<img title="Packman" class="smiley_chat" src="' + icon_cdn + '/pacman.png" />',
         'o:)': '<img title="Angel" class="smiley_chat" src="' + icon_cdn + '/angel.png" />',
         /*'3:)' : '<img title="Devil" class="smiley_chat" src="'+icon_cdn+'/devil.png" />',*/
         '<3': '<img title="Heart" class="smiley_chat" src="' + icon_cdn + '/heart.png" />'
      };
      $.each(smiley, function(index, value)
      {
         if (message) message = message.split(index).join(value);
      });
      return message;
   }

   function post_delete(me)
   {
      var del_actionid = $(me).parent().attr('data');
      $('.prompt_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div class="prompt_container"><div class="prompt_title">Please confirm your action</div><div class="prompt_content">Do you want to delete?</div><div class="prompt_button"><input class="prompt_positive theme_button" type="submit" value="Sure" onClick="action.post_delete_positive(this, ' + del_actionid + ')"/><input class="prompt_negative theme_button" type="submit" value="Cancel" onclick="ui.bg_hide()"/></div></div>');
      $('body').css('overflow', 'hidden');
   }

   function message_delete(me, actionid)
   {
      $('.prompt_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div class="prompt_container"><div class="prompt_title">Please confirm your action</div><div class="prompt_content ">Do you want to delete this message?</div><div class="prompt_button"><input class="prompt_positive theme_button" type="submit" value="Sure" onClick="action.message_delete_positive(this, ' + actionid + ')"/><input class="prompt_negative theme_button" type="submit" value="Cancel" onclick="ui.bg_hide()"/></div></div>');
      $('body').css('overflow', 'hidden');
   }

   function designation_delete(me, actionid)
   {
      $('.prompt_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div class="prompt_container"><div class="prompt_title">Please confirm your action</div><div class="prompt_content">Do you want to delete this designation?</div><div class="prompt_button"><input class="prompt_positive theme_button" type="submit" value="Sure" onClick="action.designation_delete_positive(this, ' + actionid + ')"/><input class="prompt_negative theme_button" type="submit" value="Cancel" onclick="ui.bg_hide()"/></div></div>');
      $('body').css('overflow', 'hidden');
   }

   function team_delete(me, actionid)
   {
      $('.prompt_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div class="prompt_container"><div class="prompt_title">Please confirm your action</div><div class="prompt_content">Do you want to delete this team?</div><div class="prompt_button"><input class="prompt_positive theme_button" type="submit" value="Sure" onClick="action.team_delete_positive(this, ' + actionid + ')"/><input class="prompt_negative theme_button" type="submit" value="Cancel" onclick="ui.bg_hide()"/></div></div>');
      $('body').css('overflow', 'hidden');
   }

   function usefullinks_delete(me, actionid)
   {
      $('.prompt_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div class="prompt_container"><div class="prompt_title">Please confirm your action</div><div class="prompt_content">Do you want to delete this link?</div><div class="prompt_button"><input class="prompt_positive theme_button" type="submit" value="Sure" onClick="action.usefullinks_delete_positive(this, ' + actionid + ')"/><input class="prompt_negative theme_button" type="submit" value="Cancel" onclick="ui.bg_hide()"/></div></div>');
      $('body').css('overflow', 'hidden');
   }

   function share_post(lifeisfun, actionid)
   {
      //var del_actionid=$(me).parent().attr('data');
      ui.upload_default_state(); // in case share-area was open in page 
      $('#share_content').html('');
      $('.bg_hide_cover').remove();
      $.getJSON('ajax/write.php', {
         action: 'action_fetch',
         actionid: actionid,
         life_is_fun: lifeisfun
      }, function(data)
      {
         feed.news_deploy(data, '#share_content', 99);
      });
      $('#share_actionid').attr('data', actionid);
      //feed.news_deploy(data,'#share_content');
   }

   function group_leave(me)
   {
      var profile_name = $('#profilename_hidden').attr('value');
      $('.prompt_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div class="prompt_container"><div class="prompt_title">Please confirm your action</div><div class="prompt_content">Leave group ' + profile_name + '</div><div class="prompt_button"><input class="prompt_positive theme_button" type="submit" value="Sure" onClick ="action.group_leave_positive(this)"/><input class="prompt_negative theme_button" type="submit" value="Cancel" onClick ="ui.bg_hide()"/></div></div>');
      $('body').css('overflow', 'hidden');
   }

   function event_leave(me)
   {
      var profile_name = $('#profilename_hidden').attr('value');
      $('.prompt_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div class="prompt_container"><div class="prompt_title">Please confirm your action</div><div class="prompt_content">Leave event ' + profile_name + '</div><div class="prompt_button"><input class="prompt_positive theme_button" type="submit" value="Sure" onClick ="action.event_leave(this)"/><input class="prompt_negative theme_button" type="submit" value="Cancel" onClick ="ui.bg_hide()"/></div></div>');
      $('body').css('overflow', 'hidden');
   }

   function event_cancel(me)
   {
      var profile_name = $('#profilename_hidden').attr('value');
      $('.prompt_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div class="prompt_container"><div class="prompt_title">Please confirm your action</div><div class="prompt_content">Cancel event ' + profile_name + '</div><div class="prompt_button"><input class="prompt_positive theme_button"  type="submit" value="Sure" onClick ="action.event_cancel_positive(this)"/><input class="prompt_negative theme_button" type="submit" value="Cancel" onClick ="ui.bg_hide()"/></div></div>');
      $('body').css('overflow', 'hidden');
   }

   function unfriend(me)
   {
      var profile_name = $('#profilename_hidden').attr('value');
      $('.prompt_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div class="prompt_container"><div class="prompt_title">Please confirm your action</div><div class="prompt_content">Unfollow ' + profile_name + '</div><div class="prompt_button"><input class="prompt_positive theme_button" type="submit" value="Sure" onClick ="action.unfriend_positive(this)"/><input class="prompt_negative theme_button" type="submit" value="Cancel" onClick ="ui.bg_hide()"/></div></div>');
      $('body').css('overflow', 'hidden');
   }

   function popup_error_prompt(error)
   {
      var profile_name = $('#profilename_hidden').attr('value');
      $('.prompt_container').remove();
      $('.bg_hide_cover').remove();
      $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
      $('body').append('<div class="prompt_container"><div class="prompt_title">Error performing the action</div><div class="prompt_content">' + error + '</div><div class="prompt_button"><input class="prompt_negative theme_button" type="submit" value="Fine" onClick ="ui.bg_hide()"/></div></div>');
      $('body').css('overflow', 'hidden');
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
      $('body').css('overflow', 'auto');
   }

   function goBacktoProfile(profileid)
   {
      window.location = 'profile.php?id=' + profileid;
   }

   function removeContainerbyId(id)
   {
      $('#' + id).remove();
   }

   function diary_suggest(me, type, event)
   {
      if (navigator.appName == 'Microsoft Internet Explorer')
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
      var val = $(me).val();
      if (val != '')
      {
         $.getJSON('ajax/write.php', {
            action: 'callback',
            type: type,
            k: val
         }, function(data)
         {
            if (data)
            {
               $('.callback_con').html('');
               $.each(data, function(index, value)
               {
                  $('.callback_con').append('<div data="' + type + '" id="' + value.id + '" class="callback_class callback_class_click" style="min-height:25px;border-bottom:1px solid #eeeeee;cursor:pointer;padding:0px;">' + value.school + '</div>');
               });
            }
            $('.callback_con').append('<div id=""  data="' + type + '" class="callback_class_new_item callback_class_click" style="min-height:25px;border-bottom:1px solid #eeeeee;cursor:pointer;padding:0px;background:#cccccc;color:#ffffff;font-weight:bold">' + $(me).val() + '</div>');
         });
      }
      else
      {
         $('.callback_con').hide('');
      }
   }

   function redirect_to_inbox(user)
   {
      window.location = "/?hl=inbox&id=" + user;
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
      var left, right, pos, pos1;
      if (page.length > 153)
      {
         right = page.substr(150, page.length - 1);
         pos = right.indexOf(' ');
         pos1 = right.indexOf('\n');
         if (pos > pos1) pos = pos1;
         if (pos + 150 > 153)
         {
            left = page.substr(0, 150 + pos);
            right = ' ' + page.substr(150 + pos + 1, page.length - 1);
            return left + '<div onclick="ui.show_more(this)" style="margin-top:0.5em;color:#336699;cursor:pointer;font-size:0.9em;">See more</div><span class="see_more" style="display:none;">' + right + '</span><div onclick="ui.show_less(this)" style="margin-top:0.5em;color:#336699;cursor:pointer;display:none;font-size:0.9em;">See less</div>';
         }
      }
      return page;
   }

   function time_difference(time)
   {
      now = Math.floor((new Date()).getTime() / 1000);
      if (now == time) return ' ' + 'now';
      else if (now - 1 < time) return ' ' + 'a second ago';
      else if (now - 2 < time) return ' ' + 'two seconds ago';
      else if (now - 3 < time) return ' ' + 'three seconds ago';
      else if (now - 4 < time) return ' ' + 'four seconds ago';
      else if (now - 5 < time) return ' ' + 'five seconds ago';
      else if (now - 10 < time) return ' ' + 'ten seconds ago';
      else if (now - 15 < time) return ' ' + 'fifteen seconds ago';
      else if (now - 30 < time) return ' ' + 'half a minute ago';
      else if (now - 45 < time) return ' ' + 'forty-five seconds ago';
      else if (now - 60 < time) return ' ' + ' one minute ago';
      else if (now - 120 < time) return ' ' + ' two minutes ago';
      else if (now - 180 < time) return ' ' + ' three minutes ago';
      else if (now - 240 < time) return ' ' + ' four minutes ago';
      else if (now - 300 < time) return ' ' + ' five minutes ago';
      else if (now - 600 < time) return ' ' + ' ten minutes ago';
      else if (now - 900 < time) return ' ' + ' fifteen minutes ago';
      else if (now - 1200 < time) return ' ' + ' twenty minutes ago';
      else if (now - 1500 < time) return ' ' + ' twenty-five minutes ago';
      else if (now - 1800 < time) return ' ' + ' half an hour ago';
      else if (now - 3600 < time) return ' ' + ' an hour ago';
      else if (now - 7200 < time) return ' ' + 'two hours ago';
      else if (now - 10800 < time) return ' ' + 'three hours ago';
      else if (now - 14400 < time) return ' ' + 'four hours ago';
      else if (now - 18000 < time) return ' ' + 'five hours ago';
      else if (now - 21600 < time) return ' ' + 'six hours ago';
      else if (now - 25200 < time) return ' ' + 'seven hours ago';
      else if (now - 28800 < time) return ' ' + 'eight hours ago';
      else if (now - 32400 < time) return ' ' + 'nine hours ago';
      else if (now - 36000 < time) return ' ' + 'ten hours ago';
      else if (now - 36900 < time) return ' ' + 'eleven hours ago';
      else if (now - 43200 < time) return ' ' + 'twelve hours ago';
      else if (now - 46800 < time) return ' ' + 'thirteen hours ago';
      else if (now - 50400 < time) return ' ' + 'fourteen hours ago';
      else if (now - 50400 < time) return ' ' + 'fifteen hours ago';
      else if (now - 57600 < time) return ' ' + 'sixteen hours ago';
      else if (now - 61200 < time) return ' ' + 'seventeen hours ago';
      else if (now - 64800 < time) return ' ' + 'eighteen hours ago';
      else if (now - 68400 < time) return ' ' + 'nineteen hours ago';
      else if (now - 72000 < time) return ' ' + 'twenty hours ago';
      else if (now - 75600 < time) return ' ' + 'twentyone hours ago';
      else if (now - 79200 < time) return ' ' + 'twentytwo hours ago';
      else if (now - 82800 < time) return ' ' + 'twentythree hours ago';
      else if (now - 86400 < time) return ' ' + ' yesterday';
      else if (now - 172800 < time) return ' ' + 'two days ago';
      else if (now - 259200 < time) return ' ' + 'three days ago';
      else if (now - 345600 < time) return ' ' + 'four days ago';
      else if (now - 432000 < time) return ' ' + 'five days ago';
      else if (now - 518400 < time) return ' ' + 'six days ago';
      else if (now - 604800 < time) return ' last week';
      else if (now - 1209600 < time) return ' two weeks ago';
      else if (now - 1814400 < time) return ' three weeks ago';
      else if (now - 2419200 < time) return ' four weeks ago';
      else if (now - 2592000 < time) return ' a month ago';
      else if (now - 5184000 < time) return ' two months ago';
      else if (now - 7776000 < time) return ' three months ago';
      else if (now - 10368000 < time) return ' four months ago';
      else if (now - 12960000 < time) return ' five months ago';
      else if (now - 15552000 < time) return ' six months ago';
      else if (now - 18144000 < time) return ' seven months ago';
      else if (now - 20736000 < time) return ' eight months ago';
      else if (now - 23328000 < time) return ' nine months ago';
      else if (now - 25920000 < time) return ' ten months ago';
      else if (now - 28512000 < time) return ' eleven months ago';
      else if (now - 31104000 < time) return '  a year ago';
      else
      return ' over a year ago';
   }

   function bio_item_edit(container, code, key, privacy)
   {
      var icon_cdn = $('#icon_cdn').attr('value');
      $('.item_edit_remove').show();
      var placeholder = '';
      switch (code)
      {
      case 205:
         placeholder = 'Add your company';
         break;
      case 204:
         placeholder = 'Add your college';
         break;
      case 203:
         placeholder = 'Add your School';
         break;
      case 211:
         placeholder = 'Add your hobby';
         break;
      case 230:
         placeholder = 'Add a skill';
         break;
      case 231:
         placeholder = 'Add a project';
         break;
      case 232:
         placeholder = 'Add a certificate';
         break;
      case 233:
         placeholder = 'Add an award';
         break;
      default:
         placeholder = '';
      }
      $('.profile_edit_each').remove();
      if (privacy == 1)
      {
         $(container).parent().next().prepend('<div class="profile_edit_each  bgcolor"><input style="margin-left:.5em;" onkeyup="ui.diary_suggest(this,' + code + ',event)" type="text" placeholder="' + placeholder + '" class="profile_edit_textbox" value = "" size="40"/></div>');
      }
      else if (privacy == 2)
      {
         $(container).parent().next().prepend('<div class="profile_edit_each  bgcolor"><input style="margin-left:.5em;" onkeyup="ui.diary_suggest(this,' + code + ',event)" type="text" placeholder="' + placeholder + '" class="profile_edit_textbox" value = "" size="40"/></div>');
      }
      else
      {
         $(container).parent().next().prepend('<div class="profile_edit_each  bgcolor"><input style="margin-left:.5em;" onkeyup="ui.diary_suggest(this,' + code + ',event)" type="text" placeholder="' + placeholder + '" class="profile_edit_textbox" value = "" size="40"/></div>');
      }
   }

   function bio_item_single_edit(container, code, value, privacy)
   {
      $('.item_edit_remove').show();
      var placeholder = '';
      switch (code)
      {
      case 205:
         placeholder = 'Add your company';
         break;
      case 204:
         placeholder = 'Add your college';
         break;
      case 203:
         placeholder = 'Add your School';
         break;
      case 211:
         placeholder = 'Add your hobby';
         break;
      case 230:
         placeholder = 'Add a skill';
         break;
      case 231:
         placeholder = 'Add a project';
         break;
      case 232:
         placeholder = 'Add a certificate';
         break;
      case 233:
         placeholder = 'Add an award';
         break;
      default:
         placeholder = '';
      }
      $('.profile_edit_each').remove();
      $(container).parent().next().prepend('<div class="profile_edit_each  bgcolor"><input style="margin-left:.5em;" onkeyup="ui.diary_suggest(this,' + code + ',event)" type="text" placeholder="' + placeholder + '" class="profile_edit_textbox" value ="' + value + '" size="40"/></div>');
   }

   function real_time_deploy_append(data)
   {
      if (data)
      {
         $.each(data.action, function(index, value)
         {
            var dom_id = 'lf_' + value.pageid;
            deploy.action_decode('live_feed', value, data.name, data.photo, '#rtm_container', dom_id, 1, 1);
         });
      }
      else
      {
         $('#rtm_container').append('<div>No Real Time Update</div>');
      }
   }

   function chat_time_hide(me)
   {
      $('.chat_time').hide();
   }

   function chat_time_show(me)
   {
      $('.chat_time').show();
   }

   function timerIncrement()
   {
      idleTime = idleTime + 1;
      if (idleTime > 5)
      { // 1 minutes
         sound_flag = 1; // set the flag after 1 min of inactivity
      }
   }

   function createChatBoxUI(user, name, is_online)
   {
      var icon_cdn = $('#icon_cdn').attr('value');
      $('#chatbox_container').append('<div id="chatbox_' + user + '" class="chatboxui" ><input type="hidden" value="' + user + '"/><span class="chatbox_close">x</span><div class="chatboxui_title"><span><a class="ajax_nav" href="profile.php?id=' + user + ' ">' + name + '</a></span></div><div class="chatboxui_msg"></div><textarea class="chatbox"></textarea><input type="hidden" value="10"/></div>');
      $('#chatbox_' + user).children().eq(4).focus();
      if (is_online) $('#chatbox_' + user).children().eq(2).prepend('<img class="chatbox_online_icon" src="' + icon_cdn + '/online.png" />');
      var lastScrollTopchat = $('#chatbox_' + user).children().eq(3).get(0).scrollTop;
      $('#chatbox_' + user).children().eq(3).scroll(function()
      {
         ui.chatbox_scroll(user)
      });
   }

   function chatbox_scroll(user)
   {
      var chat_start = parseInt($('#chatbox_' + user).children().eq(5).attr('value'));
      if ($('#chatbox_' + user).children().eq(3).get(0).scrollTop < $('#chatbox_' + user).children().eq(3).get(0).scrollHeight * 0.1 && chat_load)
      {
         var st = $('#chatbox_' + user).children().eq(3).get(0).scrollTop;
         if (st < lastScrollTopchat)
         {
            chat_load = false;
            action.previous_talk(user, chat_start, 0);
            chat_start += 10;
            $('#chatbox_' + user).children().eq(5).attr('value', chat_start);
         }
      }
      lastScrollTopchat = st;
   }

   function chat_sound_play()
   {
      var icon_cdn = $('#icon_cdn').attr('value');
      var audioElement = document.createElement('audio');
      audioElement.setAttribute('src', icon_cdn + '/chat_sound.mp3');
      audioElement.play();
      return false;
   }

   function chat_new_notify(name, message,chat_notify)
   {
      $(document).attr('title', message + ' :' + name);
      if (chat_notify)
      {
         setTimeout(function()
         {
            ui.title_restore(name, message,chat_notify);
         }, 1000);
      }
      else
      {
         $(document).attr('title', 'Quipmate');
      }
   }

   function title_restore(name, message,chat_notify)
   {
      if (chat_notify)
      {
         setTimeout(function()
         {
            ui.chat_new_notify(name, message,chat_notify);
         }, 1000);
      }
      else
      {
         $(document).attr('title', 'Quipmate');
      }
   }

   function chat_unread(userid)
   {
      $('#chatbox_' + userid).children().eq(2).addClass('chat_unread');
   }

   function parentRemove(me)
   {
      $(me).parent().remove();
   }
   return {
      popup_close: popup_close,
      share_post: share_post,
      parentRemove: parentRemove,
      escape_tags: escape_tags,
      chat_unread: chat_unread,
      chat_sound_play: chat_sound_play,
      chat_new_notify: chat_new_notify,
      title_restore: title_restore,
      chatbox_scroll: chatbox_scroll,
      createChatBoxUI: createChatBoxUI,
      timerIncrement: timerIncrement,
      chat_time_show: chat_time_show,
      chat_time_hide: chat_time_hide,
      real_time_deploy_append: real_time_deploy_append,
      bio_item_edit: bio_item_edit,
      bio_item_single_edit: bio_item_single_edit,
      OnProgress: OnProgress,
      page_create: page_create,
      message_delete: message_delete,
      designation_delete: designation_delete,
      team_delete: team_delete,
      birthday_bomb: birthday_bomb,
      createMessageUI: createMessageUI,
      messagebox_scroll: messagebox_scroll,
      redirect_to_inbox: redirect_to_inbox,
      redirect_friend_suggest: redirect_friend_suggest,
      redirect_group_suggest: redirect_group_suggest,
      redirect_to_action: redirect_to_action,
      message_leave_grow: message_leave_grow,
      message_leave_shrink: message_leave_shrink,
      album_upload: album_upload,
      bg_hide: bg_hide,
      bio_privacy: bio_privacy,
      close: close,
      disable_upload_area: disable_upload_area,
      direct_to_md: direct_to_md,
      diary_suggest: diary_suggest,
      enable_upload_area: enable_upload_area,
      event_cancel: event_cancel,
      event_create: event_create,
      event_leave: event_leave,
      event_friend_invite: event_friend_invite,
      friend_invite: friend_invite,
      file_upload: file_upload,
      feedback: feedback,
      get_smiley: get_smiley,
      gift: gift,
      gift_close: gift_close,
      gift_ui_create: gift_ui_create,
      group_friend_invite: group_friend_invite,
      group_event_create: group_event_create,
      goBacktoProfile: goBacktoProfile,
      group_question: group_question,
      group_create: group_create,
      group_leave: group_leave,
      group_suggest_deploy: group_suggest_deploy,
      group_suggest_page_deploy: group_suggest_page_deploy,
      event_suggest_deploy: event_suggest_deploy,
      event_suggest_single_deploy: event_suggest_single_deploy,
      group_suggest_single_deploy: group_suggest_single_deploy,
      group_suggest_single_deploy_page: group_suggest_single_deploy_page,
      link_highlight: link_highlight,
      //menu : menu, not in use
      message: message,
      message_close: message_close,
      mood: mood,
      mood_click: mood_click,
      message_fetch: message_fetch,
      notice_fetch: notice_fetch,
      page_init: page_init,
      photo_upload: photo_upload,
      post_delete: post_delete,
      profile_post_privacy: profile_post_privacy,
      popup_error_prompt: popup_error_prompt,
     // praise: praise,
      removeContainerbyId: removeContainerbyId,
      request_fetch: request_fetch,
      response_comment: response_comment,
      search: search,
      see_more: see_more,
      show_less: show_less,
      show_more: show_more,
      search: search,
      suggest_deploy: suggest_deploy,
      suggest_deploy_page: suggest_deploy_page,
      suggest_single_deploy: suggest_single_deploy,
      suggest_single_deploy_page: suggest_single_deploy_page,
      time_difference: time_difference,
      page_call: page_call,
      tagline: tagline,
      tagline_close: tagline_close,
      upload_active_state: upload_active_state,
      upload_default_state: upload_default_state,
      unfriend: unfriend,
      video_play_click: video_play_click,
      video_shadow_click: video_shadow_click,
      mood_close: mood_close,
      usefullinks_delete: usefullinks_delete,
      restore_action_field: restore_action_field
   }
})();