jQuery.postJSON = function(url, args, callback)
{
   args._xsrf = getCookie("_xsrf");
   $.ajax(
   {
      url: url,
      data: $.param(args),
      dataType: "text",
      type: "POST",
      success: function(response)
      {
         if (callback) callback(eval("(" + response + ")"));
      },
      error: function(response)
      {
         console.log("ERROR:", response);
      }
   });
};

var last_poll_time_rt = -1;
var global_time = Math.floor((new Date()).getTime() / 1000);
var icon_cdn = $('#icon_cdn').attr('value');
$(function()
{      
   if (window.location.hash) // when the user's browser does not support the html5 it will fall back to hash
   { //in that case when fresh page will load this code will revert browser to non-hash euivalent of the page
      var hash_part = window.location.hash.substring(1);
      var pathname = window.location.pathname;
      window.location = pathname + '?hl=' + hash_part;
   }
   window.addEventListener('popstate', function(event)
   {
   if(event.state != null)
       {
          var st =
          {
             url: event.state.url,
             page: event.state.page,
             param: event.state.param,
             me: "object",
             pop: 1
          };
          deploy.ajax_navigation(st, event.state.param, 0);
       }  
   });
   var width = $(window).width();
   if (width < 1180)
   {
      $('#bottombar').show();
      $('#sidebar').hide();
      $('#right').hide();
   }
   else
   {
      $('#bottombar').hide();
   }
   $(window).focus(function()
   {
      ui.chat_notify = false;
   });
   $(window).resize(function()
   {
      if (width != $(window).width())
      {
         width = $(window).width();
         if (width < 1180)
         {
            $('#bottombar').show();
            $('#sidebar').hide();
            $('#right').hide();
         }
         else if (width >= 1180)
         {
            $('#sidebar').show();
            $('#bottombar').hide();
            $('#right').show();
         }
      }
      var container_value = $('#notice_container').attr('data');
      var database = $('#database_hidden').attr('value');
      if (container_value == 'notice')
      {
         $('#notice_container').css('left', $('#search_form').position().left + 291 + 'px');
      }
      else if (container_value == 'message')
      {
         $('#notice_container').css('left', $('#search_form').position().left + 255 + 'px');
      }
      else if (container_value == 'fr_missu_ei')
      {
         $('#notice_container').css('left', $('#search_form').position().left + 218 + 'px');
      }
      $('#account').css('left', $('#search_form').position().left + 561 + 'px');
      $('#show_inbox').css('height', $(window).height() - 100);
      $('.inboxui_msg').css('height', $(window).height() - 150);
      $('.right_pointer_container').css('left', $('#search_form').position().left + 285 + 'px');
      $('#search_container').css('left', $('#search_form').position().left + 'px');
    var page = $('#page_hidden').attr('value').trim();
    if(page == 'bio' || page == 'file' || page == 'group_file' || page == 'event_file' || page == 'video' || page == 'group_video' || page == 'event_video')
    {
        $('#right').hide();
    }
      ui.adjustLayout(page);
   });
   //Chat after windows minimised 	
   $('.friend_status_small').live('click', function()
   {
      if ($('.friend_status_small').height() < 50)
      {
         $('.friend_status_small').css(
         {
            "height": "60%"
         });
      }
      else
      {
         $('.friend_status_small').css(
         {
            "height": "5%"
         });
      }
   });
   // auto update value of feed time************************

   action.individualChat();
   action.real_time();
   setInterval(function()
   {
      $('.time').each(function()
      {
         var time = $(this).attr('data');
         $(this).html(ui.time_difference(parseInt(time)));
      });
      now = Math.floor((new Date()).getTime() / 1000);
      if (now > global_time + 70)
      {
         global_time = Math.floor((new Date()).getTime() / 1000);
         action.individualChat();
         action.real_time();
      }
   }, 60000);
   //*******************************************************
   var profileid = $('#profileid_hidden').val();
   var myprofileid = $('#myprofileid_hidden').attr('value').trim();
   var page = $('#page_hidden').attr('value').trim();
   window.load = false;
   var param =
   {
   };
   var url = 'ajax/write.php';
   var increment = 0;
   param.start = 0;
   param.action = '';
   ui.page_init(page, param);
   action.first_loader(page, param);
   ui.page_call(page);
   var profile_relation = $('#profile_relation_hidden').attr('value').trim(); /***************************** Window scroll ******************************************/
   var lastScrollTopfeed = 0;
   window.load = true;
   $(window).scroll(function()
   {
    var page = $('#page_hidden').attr('value').trim();
      if (page != 'bio')
      {
         var st = $(this).scrollTop();
         if (st > lastScrollTopfeed)
         {
            // downscroll code
            var scroll_size = $(document).height() - $(window).height();
            scroll_size = scroll_size * 0.6;
            if (($(window).scrollTop() > scroll_size) && window.load)
            {
               window.load = false;
               $('.load_more').hide();
               var icon_cdn = $('#icon_cdn').attr('value');
               $("#prev").append('<p align="center"><img src="' + icon_cdn + '/loading.gif" id="loading" /></p>');
               action.first_loader(page, param);
               $('#loading').remove();
               $('.load_more').show();
               lastScrollTopfeed = st;
            }
         }
      }
   ui.adjustLayout(page);
   });
   var rtm_load = true;
   var start = 0;
   $.getJSON('ajax/write.php', {
      action: 'live_feed',
      start: start
   }, function(data)
   {
      if (data.ack)
      {
         start += 20;
         ui.real_time_deploy_append(data);
         scrollToprtm = $('#rtm_container').get(0).scrollTop;
      }
   });
   $('#rtm_container').bind('scroll', function()
   {
      if ($('#rtm_container').get(0).scrollTop > $('#rtm_container').get(0).scrollHeight * 0.2 && rtm_load)
      {
         var st = $('#rtm_container').get(0).scrollTop;
         if (st > scrollToprtm)
         {
            rtm_load = false;
            $.getJSON('ajax/write.php', {
               action: 'live_feed',
               start: start
            }, function(data)
            {
               if (data.ack)
               {
                  start += 20;
                  rtm_load = true;
                  ui.real_time_deploy_append(data);
               }
            });
         }
      }
      scrollToprtm = st;
   });
   var open_chatbox = [];
   $('.chat_user').live('click', function()
   {
      allow_typing = false;
      user = $(this).attr('data');
      if (open_chatbox.length > 2)
      {
         $('#chatbox_' + open_chatbox[0]).remove();
         open_chatbox.splice(0, 1);
      }
      if ($.inArray(user, open_chatbox) == -1)
      {
         open_chatbox.push(user);
         name = $(this).children().eq(2).attr('value');
         $('#chatbox_' + user).remove();
         if ($(this).children().eq(3)) var is_online = false;
         if ($('#friend_' + user).children().eq(3).length > 0) is_online = true;
         ui.createChatBoxUI(user, name, is_online);
         action.previous_talk(user, 0, 1);
      }
      action.createCookie('chatbox', user);
      action.createCookie('name', name);
/*
			if(!action.getCookie('chatbox'))
			{
				var root = [], nm = [], pr = [];
				nm.push(name);
				pr.push(user);
				root.name = nm;
				root.profileid = pr;
				cookieStr = JSON.stringify(root);		
				action.createCookie('chatbox',cookieStr);
			}
			else
			{
				root = action.getCookie('chatbox');
				root.name.push(name);
				root.profileid.push(user);
				cookieStr = JSON.stringify(root);		
				action.createCookie('chatbox',cookieStr);
			}
			*/
   });
   $('.chat_user').live('mouseover', function()
   {
      var profileid = $(this).attr('data');
      var pname = JSON.parse($('#session_name_hidden').attr('value'));
      var pphoto = JSON.parse($('#session_pimage_hidden').attr('value'));
      var ptagline = JSON.parse($('#session_tagline_hidden').attr('value'));
      var pic = pphoto[profileid];
      var nm = pname[profileid];
      var tag = ptagline[profileid];
      if (!ptagline[profileid])
      {
         tag = "";
      }
      me = $(this);
      $('.people_status').remove();
      $('body').append('<div class="people_status"><div class="people_pointer"></div><a class="ajax_nav" href="profile.php?id=' + profileid + '"><img class="lfloat" src="' + pic + '" height="80" width="80"/></a><div class="left7"><a class="bold ajax_nav" href="profile.php?id=' + profileid + '">' + nm + '</a><div>' + tag + '</div></div></div>');
      $('.people_status').css('top', me.position().top);
      $('.people_status').css('right', me.position().right);
   });
   $('#left,#center,#right,#chatbox_container,#rtm_container').live('mouseover', function()
   {
      $('.people_status').remove();
   });
   $('#search_button_header').click(function()
   {
      var q = $('#to').attr('value');
      var filter = $('#search_filter_hidden').attr('value');
      $('#left').html('<div class="panel  panel-default"><div class="panel-heading">Search for :</div><div class="panel-body" id="search_left"><input type="hidden" id="search_key_hidden" value="'+q+'"><input type="hidden" id="filter_hidden" value="'+filter+'"></div></div>');
        ui.search_left_option('people',q);
        ui.search_left_option('post',q);
        ui.search_left_option('comment',q);
        ui.search_left_option('group',q);
        ui.search_left_option('event',q);
        ui.search_left_option('skill',q);
        ui.search_left_option('project',q);
        ui.search_left_option('tool',q);
        ui.search_left_option('major',q);
        ui.search_left_option('certificate',q);
        ui.search_left_option('award',q);
        ui.search_left_option('company',q);
        ui.search_left_option('college',q);
        ui.search_left_option('school',q);
        ui.search_left_option('profession',q);
        ui.search_left_option('city',q);
      $('#'+filter).addClass('selected');  
      $('#center').html('<h1 class="page_title" id="search_count">Search results</h1><div id="search_result"></div>'); 
      action.search();
      window.location.hash = 'search.php?filter=' + filter + '&q='+q;
      return false;
   });
   $('body').append('<div id="search_container"></div>');
   $('#search_container').css('left', $('#search_form').position().left);
   $('#to').focus(function()
   {
      $('.search_items').show();
   });
   var request = []
   var q = $.trim($('#to').attr('value'));
   $('#to').bind('keyup mousedown input', function()
   {
    
      filter = $('#search_filter_hidden').attr('value');
      if (filter == '') filter = 'search_everything';
      $('#search_container').show();
      action.global_search(filter, q, request);
   });
   $('#hso').focus(function()
   {
      $('.search_items').show();
   });
   var request = []
   var q = $.trim($('#hso').attr('value'));
   $('#hso').live('keyup mousedown input', function()
   {
      action.star_search('search_people', q, request);
   });
 /*
    $('#mdadd').focus(function()
   {
      $('.search_items').show();
   });

   var request = []
   var q = $.trim($('#mdadd').attr('value'));
 
    $('#mdadd').live('keyup mousedown input', function()
      {
         action.md_search('search_people', q, request);
      });
   */
   $('#search_result').click(function()
   {
      var pname = $.trim($('#search_result').attr('pname'));
      var pid = $.trim($('#search_result').attr('data'));
      $('#hso').attr('value', 'pname');
      $('#hso').attr('pid', 'pid');
      $('#star_container').hide();
      $('#star_co').append('<br><textarea id="star_c"  autocomplete="off" style="width:20em;height:7em;" class="form-control" >Add Contribution</textarea><input type="submit" style="margin-top:-64px;" onclick="action.addstar(this)" value="Add Star" id="add_star_button" title="Add Star" />');
      $('#hso').keyup(function()
      {
         $('#star_c').remove();
         $('br').remove();
         $('#add_star_button').remove();
         $('#star_container').show();
      });
   });
 /*  $('.search_items').live('click', function()
   {
      if ($(this).attr('data') == 'group')
      {
         $('#search_filter_hidden').attr('value', 'group_search');
      }
      else if ($(this).attr('data') == 'event')
      {
         $('#search_filter_hidden').attr('value', 'event_search');
      }
      else if ($(this).attr('data') == 'skill')
      {
         $('#search_filter_hidden').attr('value', 'skill_search');
      }
      else if ($(this).attr('data') == 'post')
      {
         $('#search_filter_hidden').attr('value', 'post_search');
      }
      else if ($(this).attr('data') == 'comment')
      {
         $('#search_filter_hidden').attr('value', 'comment_search');
      }
      else if ($(this).attr('data') == 'people')
      {
         $('#search_filter_hidden').attr('value', 'search_people');
      }
      $('#search_container').hide();
      $('#to').attr('value','');
   }); */
   $('#center, #left, #right').live('click', function()
   {
      $('#search_container').hide();
   });
   $('.search_items').live('mouseover', function()
   {
      $(this).css('background-color', '#f5f5f5');
      //$(this).children().eq(1).children().eq(0).css('color','#ffffff'); 
   });
   $('.search_items').live('mouseleave', function()
   {
      $(this).css('background', '#ffffff');
      $('.search_items:first').css('background', '#cccccc');
      $('.search_items:first .name_50 a').css('color', 'white');
      //$(this).children().eq(1).children().eq(0).css('color','#336699'); 
   });
   var pattern_next = $('#chat_search_box').val();
   var requestt = [];              
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
             //  action.colleague_search('search_people',pattern,requestt);
            }
         }
      });
      var visible_elem = $('.chat_user').filter(function() {return $(this).css('display') !== 'none';}).length ;
     // console.log(visible_elem);                  
      if( visible_elem <= 2)
      {
        action.colleague_search('search_people',pattern_next,requestt);
              
      }                  
                        
   }); /***************************** Load more click ******************************************/
   $('.load_more').live('click', function()
   {
      $('.load_more').hide();
      var icon_cdn = $('#icon_cdn').attr('value');
      $("#prev").append('<p align="center"><img src="' + icon_cdn + '/loading.gif" id="loading"></p>');
      action.first_loader(page, param);
   });
   //******************************** supporting code for event.stopPropagation**************
   $('html').click(function()
   {
      $('#profile_post_privacy_drop').hide();
      $('#account').hide();
      $('.callback_con').hide();
   });
   //*******************************************
   $('.ajax_nav').live('click', function()
   {
      var url = $(this).attr('href');
      var st =
      {
         url: url,
         page: page,
         param: param,
         me: this,
         pop: 0
      };
      var return_value = deploy.ajax_navigation(st, param, lastScrollTopfeed);
      page = param.page;
      lastScrollTopfeed = param.lastScrollTopfeed
      return return_value;
   });
   //  changes mouse cursor when highlighting loawer right of box
   $("textarea").live('mousemove', function(e)
   {
      var myPos = $(this).offset();
      myPos.bottom = $(this).offset().top + $(this).outerHeight();
      myPos.right = $(this).offset().left + $(this).outerWidth();
      if (myPos.bottom > e.pageY && e.pageY > myPos.bottom - 16 && myPos.right > e.pageX && e.pageX > myPos.right - 16)
      {
         $(this).css(
         {
            cursor: "nw-resize"
         });
      }
      else
      {
         $(this).css(
         {
            cursor: ""
         });
      }
   })
   //  the following simple make the textbox "Auto-Expand" as it is typed in
   .live('keyup', function(e)
   {
      //  the following will help the text expand as typing takes place
      while ($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth")))
      {
         $(this).height($(this).height() + 1);
      };
   });
   //*****************************************************
   $('.seeall').live('click', function()
   {
      window.location = "/?hl=notice_all";
   });
   $('.message_seeall').live('click', function()
   {
      window.location = "/?hl=inbox";
   });
   $('.notice_drop').live('click', function()
   {
      var life_is_fun = $(this).children().eq(0).attr('value');
      var actionid = $(this).children().eq(0).attr('id');
      if ($(this).attr('data') == 'group')
      {
         var groupid = $(this).children().eq(0).attr('id');
         window.location = 'group.php?id=' + groupid;
      }
      else
      window.location = 'action.php?actionid=' + actionid + '&life_is_fun=' + life_is_fun;
   });
   var random = Math.random();
   $('#random_hidden').attr('value', random);
   if (!window.console) window.console =
   {
   };
   if (!window.console.log) window.console.log = function()
   {
   };
   var profileid = $('#myprofileid_hidden').attr('value');
   var name = $('#myprofilename_hidden').attr('value');
   var photo = $('#myprofileimage_hidden').attr('value');
   //Fetch friends list--************************************************************
   //*****************************************************************************************	
   chat_load = true;
   var typing = true;
   var allow_typing = true;;
   var cook = action.getCookie('chatbox')
   if (cook != '')
   {
      var is_online = false;
      if ($('#friend_' + cook).children().eq(3).length > 0) is_online = true;
      var name = action.getCookie('name');
      ui.createChatBoxUI(cook, name, is_online);
      action.previous_talk(cook, 0, 1);
      allow_typing = false;
      typing = false;
   }
/*
   
   var root = $.parseJSON(action.getCookie('chatbox'));
   $.each(root, function(index,value){
		var is_online = false;
		if($('#friend_'+value.profileid).children().eq(3).length > 0)
			is_online = true;
		ui.createChatBoxUI(value.profileid, value.name, is_online);
		action.previous_talk(value.profileid, 0,1);
		allow_typing = false;
		typing = false; 
   }); 
   */
   $('.chatbox').live('focus', function(event)
   {
      if (!typing && allow_typing) typing = true;
   });
   $('.chatbox').live('keyup', function(event)
   {
      var user = $(this).parent().children().eq(0).attr('value');
      var name = $('#myprofilename_hidden').attr('value');
      var profileid = $('#myprofileid_hidden').attr('value');
      var myprofileid = $('#myprofileid_hidden').attr('value');
      var myname = $('#myprofilename_hidden').attr('value');
      var myphoto = $('#myprofileimage_hidden').attr('value');
      var chat_sent_time = new Date().getTime();
      if (event.which == 13 && $.trim($(this).val()) && profileid != user)
      {
         typing = true;
         var me = $(this);
         var message = ui.escape_tags($(this).val());
         if (message.substr(message.length - 1) == '\\')
         {
            message = message + '\\';
         }
         me.attr('value', '');
         var database = $('#database_hidden').attr('value');
         var param =
         {
            "profileid": profileid,
            "userid": user,
            "message": message,
            "name": name,
            "photo": photo,
            "database": database,
            "chat_sent_time": chat_sent_time
         }
         //Append the chat before ack comes from server .
         me.parent().children().eq(3).append('<div class="chat_each" id="chat_' + chat_sent_time + '" onmouseover="ui.chat_time_show(this)" onmouseleave="ui.chat_time_hide(this)"><div class="chat_each_message chat_actionbyme"><pre>' + ui.get_smiley(ui.link_highlight(message)) + '</pre></div><span class="time chat_time" id="chat_time_' + chat_sent_time + '" data="' + chat_sent_time + '"></span><span id="' + chat_sent_time + '" class="glyphicon glyphicon-time rfloat" style="color:#ccc;"></span></div>');
         $('.chatboxui_msg').scrollTop($('.chatboxui_msg').get(0).scrollHeight);
         $.postJSON('/chat/chat_new', param, function(data)
         {
            $.each(data.action, function(index, value)
            {
               action.last_chat_time = value.time;
               $('#chat_' + value.actionid).remove();
               $('.chatbox').css(
               {
                  "height": "2.7em"
               });
               $('#chat_' + value.chat_sent_time).attr('id', "chat_" + value.actionid);
               $('#chat_time_' + value.chat_sent_time).attr('data', value.time);
               $('#chat_time_' + value.chat_sent_time).html('' + ui.time_difference(value.time) + '');
               $('#' + value.chat_sent_time).removeClass('glyphicon-time');
               $('#' + value.chat_sent_time).addClass('glyphicon-ok');
            });
         });
         me.focus();
         if ($.inArray(parseInt(user), JSON.parse($('#online_hidden').attr('value'))) == -1)
         {
            $.getJSON('ajax/write.php', {
               action: 'chat_email',
               profileid: user,
               message: message
            }, function(data)
            {
            });
         }
      }
      else
      {
         if (typing)
         {
            typing = false;
            var database = $('#database_hidden').attr('value');
            var param =
            {
               "profileid": profileid,
               "userid": user,
               "name": name,
               "database": database
            };
            $.postJSON('/chat/typing_new', param, function(data)
            {
            });
         }
      }
   });
   $('.chatbox_close').live('click', function()
   {
      var user = $(this).parent().parent().children().eq(0).attr('value');
      $('#chatbox_' + user).remove();
      $('#chatbox_' + user).children().eq(3).unbind('scroll');
      open_chatbox.splice($.inArray(user, open_chatbox), 1);
      action.cookie_delete('chatbox');
      action.cookie_delete('name');
   });
   var request = [],
       present = false;
   $('.rtm_each').live('mouseenter', function()
   {
      window.me_live = this;
      window.pic_live = $("img:first", window.me_live).attr("src");
      $("img:first", window.me_live).attr("src", "https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com/loading.gif");
      $(this).removeClass('chat_unread');
      var id = this;
      if (!present)
      {
         var pageid = $(this).children().eq(0).attr('value');
         var life_is_fun = $(this).children().eq(1).attr('value');
         var me = $(this);
         for (var i = 0; i < request.length; i++)
         {
            request[i].abort();
            $("img:first", window.me_live).attr("src", window.pic_live);
         }
         request.length = 0;
         request.push($.getJSON('ajax/write.php', {
            action: 'action_fetch',
            actionid: pageid,
            life_is_fun: life_is_fun
         }, function(data)
         {
            $('.if_post').remove();
            $('body').append('<div class="if_post" id="if_container"><div class="rtm_pointer"></div></div>');
            $('#if_container').css('top', me.position().top);
            var dom_id = 'if_post_' + data.actionid;
            $("img:first", window.me_live).attr("src", window.pic_live);
            feed.news_deploy(data, '#if_container', 1);
            if ($('#if_container').height() + me.position().top > $(window).height())
            {
               $('#if_container').css('top', 0);
               $('.rtm_pointer').css('top', me.position().top + 11 + 'px');
            }
         }));
      }
   });
   $('.rtm_each').live('click', function()
   {
      var pageid = $(this).children().eq(0).attr('value');
      var life_is_fun = $(this).children().eq(1).attr('value');
      var me = $(this);
      for (var i = 0; i < request.length; i++)
      {
         request[i].abort();
      }
      request.length = 0;
      request.push($.getJSON('ajax/write.php', {
         action: 'action_fetch',
         actionid: pageid,
         life_is_fun: life_is_fun
      }, function(data)
      {
         $('.if_post').remove();
         $('body').append('<div class="if_post" id="if_container"><div class="rtm_pointer"></div></div>');
         $('#if_container').css('top', me.position().top);
         var dom_id = 'if_post_' + data.actionid;
         $("img:first", window.me_live).attr("src", window.pic_live);
         feed.news_deploy(data, '#if_container', 1);
         if ($('#if_container').height() + me.position().top > $(window).height())
         {
            $('#if_container').css('top', 0);
            $('.rtm_pointer').css('top', me.position().top + 11 + 'px');
         }
      }));
   });
   $('.rtm_each').live('mouseleave', function()
   {
      if (!present)
      {
         $('.if_post').remove();
         for (var i = 0; i < request.length; i++)
         {
            request[i].abort();
            $("img:first", window.me_live).attr("src", window.pic_live);
         }
         request.length = 0;
      }
   });
   $('.rtm_each, .if_post').live('click', function()
   {
      present = true;
   });
   $('#left,#center,#right,#chatbox_container,#friend_status,.online_user,.chat_toolbar').live('mouseover', function()
   {
      if (!present)
      {
         $('.if_post').remove();
         for (var i = 0; i < request.length; i++)
         {
            request[i].abort();
            $("img:first", window.me_live).attr("src", window.pic_live);
         }
         request.length = 0;
      }
   });
   $('.container,#header,#chatbox_container,#friend_status,.online_user,.chat_toolbar').live('click', function()
   {
      present = false;
      $('.if_post').remove();
      for (var i = 0; i < request.length; i++)
      {
         request[i].abort();
         $("img:first", window.me_live).attr("src", window.pic_live);
      }
      request.length = 0;
   });
   $('.chatboxui_title').live('click', function()
   {
      $(this).next().toggle();
      $(this).next().next().toggle();
   }); 
   
});
$('.chatboxui').live('mousedown keydown input', function()
{
   if ($(this).children().eq(2).attr('class') == 'chatboxui_title chat_unread')
   {
      $(this).children().eq(2).removeClass('chat_unread');
      var userid = $(this).children().eq(0).attr('value');
      var profileid = $('#myprofileid_hidden').attr('value');
      var name = $('#myprofilename_hidden').attr('value');
      var database = $('#database_hidden').attr('value');
      var param =
      {
         "profileid": userid,
         "userid": profileid,
         "name": name,
         "database": database
      }; // sentby(userid) and sentto(profileid) are swapped here
      $.postJSON('/chat/chat_seen', param, function(data)
      {
      });
   }
});
//########################## Logic to play sound after 1 minute of inactivity ################################
idleTime = 0;
sound_flag = 0;
$(function()
{
   //Increment the idle time counter every 10 sec.
   var idleInterval = setInterval(ui.timerIncrement, 10000); // 
   //Zero the idle timer on mouse movement.
   $(this).mousemove(function(e)
   {
      idleTime = 0;
   });
   $(this).keypress(function(e)
   {
      idleTime = 0;
   });
});

function getCookie(name)
{
   var r = document.cookie.match("\\b" + name + "=([^;]*)\\b");
   return r ? r[1] : undefined;
}
jQuery.postJSON = function(url, args, callback)
{
   args._xsrf = getCookie("_xsrf");
   $.ajax(
   {
      url: url,
      data: $.param(args),
      dataType: "text",
      type: "POST",
      success: function(response)
      {
         if (callback) callback(eval("(" + response + ")"));
      },
      error: function(response)
      {
         console.log("ERROR:", response)
      }
   });
};
$(function()
{
   var profileid;
   $('#image_con_close').live('click', function()
   {
      $('.prompt_container').remove();
      $('#more_excite_people').remove();
      $('#bg_hide').remove();
      $('#bg_first').remove();
      $('.bg_hide_cover').remove();
      $('#image_con').remove();
      $('.img_viewer_bg').remove();      
      $('body').css('overflow', 'auto');
            
   });
   $('.callback_class').live('mouseover', function()
   {
      $(this).css('background', '#ccdcff');
   });
   $('.callback_class').live('mouseleave', function()
   {
      $(this).css('background', '#fff')
   });
   $('.callback_class_click').live('click', function()
   {
      var diaryid = $(this).attr('id');
      var name = $.trim($(this).html());
      var type = $(this).attr('data');
      var me = $(this);
      $('.profile_edit_textbox').attr('value', '');
      $.getJSON('ajax/write.php', {
         action: 'bio_item_add',
         diaryid: diaryid,
         item: type,
         name: name
      }, function()
      {
      });
      me.parent().parent().parent().append('<div class="item_each">' + name + '<span class="item_edit_remove" onclick="action.bio_item_remove(this,\'' + diaryid + '\')">Remove<span></div>');
      $('.callback_con').remove();
      bring = true;
   });
//-------------------------Below section handles the parent actions like posting status,question,photo,album 
   var profileid = $('#profileid_hidden').attr('value').trim();
   var myprofileid = $('#myprofileid_hidden').attr('value');
   var myphoto = $('#myprofileimage_hidden').attr('value');
   var myname = $('#myprofilename_hidden').attr('value');
   $('#status_link').live('click', function()
   {
      ui.upload_active_state();
      $('#link_box').focus();
   });
   $('#question_link').live('click', function()
   {
      $('#uploader').html('<div style="text-align: left;margin-left: 2.4em;"><textarea id="question_box" placeholder="Ask your question"/></textarea></div><div class="option_container"><input type="text" placeholder="+Add option by pressing enter" value="" class="option_add" onkeydown="action.option(this,event)"></div><div style="text-align: right;"><input id="question_button" type="submit" value="Ask" class="theme_button" onclick="action.question_button(this)" style="margin-right: 0em; "><input type="submit" value="Cancel" class="theme_button left4" onclick="ui.upload_default_state()" style="margin-right: 1em; "></div>');
      $('#question_box').focus();
   });
   var action = 'photo_upload';
   var page = $('#page_hidden').attr('value');
   if (page == 'event_json')
   {
      action = 'event_photo_upload';
   }
   else if (page == 'group_json')
   {
      action = 'group_photo_upload';
   }
   else if (page == 'page_json')
   {
      action = 'page_photo_upload';
   }
   $('#photo_link').live('click', function()
   {
      var profileid = $('#profileid_hidden').attr('value').trim();
      var action = 'photo_upload';
      var page = $('#page_hidden').attr('value');
      if (page == 'event_json')
      {
         action = 'event_photo_upload';
      }
      else if (page == 'group_json')
      {
         action = 'group_photo_upload';
      }
      else if (page == 'page_json')
      {
         action = 'page_photo_upload';
         profileid = $('#page_pageid_hidden').attr('value').trim();
      }
      ui.file_upload(profileid, action);
   });
   $('#moment_link').live('click', function()
   {
      var profileid = $('#profileid_hidden').attr('value').trim();
      ui.album_upload(profileid);
   });
   $('#blog_publish_form').ajaxForm(function()
   {
   });
   $('#blog_publish').live('click', function()
   {
      var icon_cdn = $('#icon_cdn').attr('value');
      $(this).remove();
      $("#photo_preview").html('<img src="' + icon_cdn + '/upload.gif" alt="Uploading...."/>');
      $("#blog_publish_form").ajaxSubmit(
      {
         type: 'post',
         success: function(response)
         {
            var data = $.parseJSON(response);
            if (data.ack == 1)
            {
               var url = 'action.php?actionid=' + data.actionid + '&life_is_fun=' + data.life_is_fun;
               window.location = url;
            }
            else if (data.ack == '2')
            {
               $('#photo_preview').html('Unable to upload image. Please try again.');
            }
            else if (data.ack == '3')
            {
               $('#photo_preview').html('Image size is more than 10Mb. Please compress this image and try again.');
            }
            else if (data.ack == '4')
            {
               $('#photo_preview').html('Please upload an image of jpg/jpeg, png, gif, bmp type only. Please change the image type and try again.');
            }
            else if (data.ack == '5')
            {
               $('#photo_preview').html('Please chose a photo to upload');
            }
         }
      });
      return false;
   });
   $('#pform').ajaxForm(function()
   {
   });
   $('#photo_upload_button').live('click', function()
   {
      $("#pform").ajaxSubmit(
      {
         type: 'post',
         uploadProgress: ui.OnProgress,
         success: function(response)
         {
            var data = $.parseJSON(response);
            var page = $('#page_hidden').attr('value');
            if (data.ack == '1' && page != 'file' && page != 'group_file' && page != 'event_file' && page != 'video' && page != 'group_video' && page != 'event_video')
            { 
              
               var postid = $('#' + dom_id);
               var file = data.file;
               var myprofileid = $('#myprofileid_hidden').attr('value');
               var profileid = $('#profileid_hidden').attr('value').trim();
               var icon_cdn = $('#icon_cdn').attr('value');
               if (data.actiontype == 2906 || data.actiontype == 2926 || data.actiontype == 2925)
               {
                  var page_image = icon_cdn + '/broadcast.png';
                  $('#prev').prepend('<div id="nf_post_' + data.actionid + '" data="' + data.actionid + '" class="nf_post"><div class="name_50"></div><div data=' + data.actionid + ' class="pageclass_json"><input type="hidden" value=' + profileid + ' /><input type="hidden" value="6"/><a class="ajax_nav"  href="page.php?id=' + data.page_pageid + ' "><img class="lfloat" src =' + page_image + ' height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="page.php?id=' + data.page_pageid + ' " >' + data.page_name + '</a><div><input type="hidden" value="' + data.life_is_fun + '"/><div style="margin:0.5em 0em;">' + data.page + '</div></div></div>');
               }
               else
               {
                  $('#prev').prepend('<div id="nf_post_' + data.actionid + '" data="' + data.actionid + '" class="nf_post"><div class="name_50"></div><div data=' + data.actionid + ' class="pageclass_json"><input type="hidden" value=' + profileid + ' /><input type="hidden" value="6"/><a class="ajax_nav" href="profile.php?id=' + myprofileid + ' "><img class="lfloat" src =' + myphoto + ' height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + myprofileid + ' " >' + myname + '</a><div><input type="hidden" value="' + data.life_is_fun + '"/><div style="margin:0.5em 0em;">' + data.page + '</div></div></div>');
               }
               ui.response_comment('#nf_post_' + data.actionid, data.actionid, data.life_is_fun, data.time, myprofileid, myphoto);
               if (data.actiontype == 6 || data.actiontype == 306 || data.actiontype == 406 || data.actiontype == 2906)
               {
                  $('#nf_post_' + data.actionid).children().eq(1).children().eq(3).children().eq(1).append('<img src ="thumbnail.php?file=' + file + '&maxw=368&maxh=400" style="max-width:33.5em;margin-bottom:1em;cursor:pointer;border:0.1em solid #aaaaaa;" data="' + file + '"  onclick="action.image_viewer(this)" id="' + data.actionid + ' " />');
               }
               else if (data.actiontype == 2600 || data.actiontype == 326 || data.actiontype == 426 || data.actiontype == 2926)
               {
                  var ext = data.caption.split('.').pop();
                  var fileimage = icon_cdn + '/' + ext.toLowerCase() + '.ico';
                  $('#nf_post_' + data.actionid).children().eq(1).children().eq(3).children().eq(1).append('<img class="lfloat" src=' + fileimage + ' height="50" width="50" /><div id="doc_name"><a href=' + data.file + ' data="' + data.file + '" target="_blank">' + data.caption + '</a></div>');
               }
               else if (data.actiontype == 2500 || data.actiontype == 325 || data.actiontype == 425 || data.actiontype == 2925)
               {
                  $('#nf_post_' + data.actionid).children().eq(1).children().eq(3).children().eq(1).append('<div id="video_' + data.actionid + '">');
                  jwplayer("video_" + data.actionid).setup(
                  {
                     file: data.file,
                     image: data.caption,
                     title: data.page,
                     width: "100%",
                     aspectratio: "16:9",
                     fallback: "false",
                     primary: "flash"
                  });
               }
               ui.upload_default_state();
            }
            else
            {
               if (data.ack == '2')
               {
                  ui.popup_error_prompt('Unable to upload image. Please try again.');
               }
               else if (data.ack == '3')
               {
                  ui.popup_error_prompt('Image size is more than 10Mb. Please compress this image and try again.');
               }
               else if (data.ack == '4')
               {
                  ui.popup_error_prompt('Please upload an image of jpg/jpeg, png, gif, bmp type only. Please change the image type and try again.');
               }
               else if (data.ack == '5')
               {
                  ui.popup_error_prompt('Please chose a photo to upload');
               }
               var profileid = $('#profileid_hidden').attr('value').trim();
               ui.file_upload(profileid, action);
            }
         }
      });
      return false;
   });
   $('#new_version_upload_button').live('click', function()
   {
      var me = $(this);
      $("#pform").ajaxSubmit(
      {
         type: 'post',
         uploadProgress: ui.OnProgress,
         success: function(response)
         {
            var icon_cdn = $('#icon_cdn').attr('value');
            var data = $.parseJSON(response);
            if (data.ack == '1')
            {
               if (data.actiontype == 2600 || data.actiontype == 326 || data.actiontype == 327 || data.actiontype == 426 || data.actiontype == 2926)
               {
                  var ext = data.caption.split('.').pop();
                  var fileimage = icon_cdn + '/' + ext.toLowerCase() + '.ico';
                  me.parent().parent().parent().append('<img class="lfloat" src=' + fileimage + ' height="50" width="50" /><div id="doc_name"><a href=' + data.file + ' data="' + data.file + '" target="_blank">' + data.caption + '</a></div>');
               }
            }
            else
            {
               if (data.ack == '2')
               {
                  ui.popup_error_prompt('Unable to upload image. Please try again.');
               }
               else if (data.ack == '3')
               {
                  ui.popup_error_prompt('Image size is more than 10Mb. Please compress this image and try again.');
               }
               else if (data.ack == '4')
               {
                  ui.popup_error_prompt('Please upload an image of jpg/jpeg, png, gif, bmp type only. Please change the image type and try again.');
               }
               else if (data.ack == '5')
               {
                  ui.popup_error_prompt('Please chose a photo to upload');
               }
            }
            me.parent().remove();
         }
      });
      return false;
   });
   /*#########################################################################*/
   $('#csvform').ajaxForm(function()
   {
   });
   $('#csv_upload_button').live('click', function()
   {
    var me = $(this);
      $("#csvform").ajaxSubmit(
      {
         type: 'post',
         uploadProgress: ui.OnProgress,
         success: function(response)
         {
            var data = $.parseJSON(response);
            $('#upload_progress').hide();
            callback.employee_invite(me,data);
         }
      });
      return false;
   });
   /*#########################################################################*/
   $('#flashform').ajaxForm(function()
   {
   });
   $('#flash_upload_button').live('click', function()
   {
      var obj = document.getElementById('flash_upload_button');
      obj.className = 'imghide';
      var obj = document.getElementById('uploading');
      obj.className = 'imgshow';
      $("#flashform").ajaxSubmit(
      {
         type: 'post',
         uploadProgress: ui.OnProgress,
         success: function(response)
         {
            var data = $.parseJSON(response);
            if (data.ack == '1')
            {
               var obj = document.getElementById('uploading');
               obj.className = 'imghide';
               var obj = document.getElementById('flash_upload_button');
               obj.className = 'imgshow'
               var postid = $('#' + dom_id);
               var file = data.file;
               var myprofileid = $('#myprofileid_hidden').attr('value');
               var profileid = $('#profileid_hidden').attr('value').trim();
               $('body').append('<div class="bg_hide_cover" onClick="ui.bg_hide()"></div>');
               $('body').append('<div class="prompt_container"><div class="prompt_title">Post Prompt</div><div class="prompt_content" id="post_prompt_text"></div><div class="prompt_button"><input class="prompt_positive" type="submit" value="OK" onclick="ui.bg_hide()" /></div></div>');
               $('body').css('overflow', 'hidden');
               $('#post_prompt_text').append(' Updated !.See details on page.');
               $('.prompt_positive').live('click', function()
               {
                  $('.prompt_container').remove();
                  $('.bg_hide_cover').remove();
               });
               if (data.ack == '2')
               {
                  var obj = document.getElementById('uploading');
                  obj.className = 'imghide';
                  var obj = document.getElementById('flash_upload_button');
                  obj.className = 'imgshow'
                  ui.popup_error_prompt('Unable to upload image. Please try again.');
               }
               else if (data.ack == '3')
               {
                  var obj = document.getElementById('uploading');
                  obj.className = 'imghide';
                  var obj = document.getElementById('flash_upload_button');
                  obj.className = 'imgshow'
                  ui.popup_error_prompt('Image size is more than 10Mb. Please compress this image and try again.');
               }
               else if (data.ack == '4')
               {
                  var obj = document.getElementById('uploading');
                  obj.className = 'imghide';
                  var obj = document.getElementById('flash_upload_button');
                  obj.className = 'imgshow'
                  ui.popup_error_prompt('Please upload an image of jpg/jpeg, png, gif, bmp type only. Please change the image type and try again.');
               }
               else if (data.ack == '5')
               {
                  var obj = document.getElementById('uploading');
                  obj.className = 'imghide';
                  var obj = document.getElementById('flash_upload_button');
                  obj.className = 'imgshow'
                  ui.popup_error_prompt('Please chose a photo to upload');
               }
               ui.file_upload(profileid, action);
            }
         }
      });
      return false;
   });
   $('.mom').live('change', function()
   {
      $(this).removeClass('mom');
      $("#moment_photo_browser").append("<div><input class='mom file_inline' size='40' type='file' name='photo_box[]'></div>");
   });
   $('#moment_name').live('focus', function()
   {
      if ($(this).attr('value') == "Enter album name")
      {
         $(this).attr('value', '');
      }
   });
   $('#mform').ajaxForm(function()
   {
   });
   $('#moment_upload_button').live('click', function()
   {
      var icon_cdn = $('#icon_cdn').attr('value');
      var moment_name = $.trim($('#moment_name').attr('value'));
      var photo_count = $('.file_inline').length - 3; // Reducing by 2 because count was taken from 0 and we have one extra input type where file was not selected .
      $("#moment_photo_count").attr("value", photo_count);
      $("#mform").ajaxSubmit(
      {
         type: 'post',
         uploadProgress: ui.OnProgress,
         success: function(response)
         {
            var data = $.parseJSON(response);
            var profileid = $('#profileid_hidden').attr('value').trim();
            if (data.ack == '1')
            {
               var dom_id = 'nf_post_' + data.actionid;
               $('#prev').prepend('<div class="nf_post" data="' + data.actionid + '" id="' + dom_id + '"><div class="name_50"></div><div data=' + data.actionid + ' class="pageclass_json"><input type="hidden" value=' + profileid + ' /><input type="hidden" value="5"/><a class="ajax_nav" href="profile.php?id=' + myprofileid + '"><img class="lfloat" src =' + myphoto + ' height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + myprofileid + ' " >' + myname + '</a> added ' + data.count + ' photo to the album ' + data.mname + '<div class="pclass_json"><div>' + data.desc + '</div></div></div>');
               ui.response_comment('#nf_post_' + data.actionid, data.actionid, data.life_is_fun, data.time, myprofileid, myphoto);
               var file = data.photo;
               $.each(data.photo, function(i, v)
               {
                  var f = v.file;
                  $('#' + dom_id).children().eq(1).children().eq(3).children().eq(1).append('<img onclick="action.image_viewer(this)" data="' + f + '"src ="thumbnail.php?file=' + f + '&maxh=150&maxw=150" style="margin-bottom:1.5em;cursor:pointer;border:1px solid #f6f6f6;padding:.3em;" class="thumb" id="' + v.actionid + ' " />');
               });
               num = -1;
               ui.upload_default_state();
            }
            else
            {
               if (data.ack == '2')
               {
                  num = -1;
                  ui.popup_error_prompt('Unable to upload image. Please try again.');
               }
               else if (data.ack == '3')
               {
                  num = -1;
                  ui.popup_error_prompt('Image size is more than 10Mb. Please compress this image and try again.');
               }
               else if (data.ack == '4')
               {
                  num = -1;
                  ui.popup_error_prompt('Please upload an image of jpg/jpeg, png, gif, bmp type only. Please change the image type and try again.');
               }
               else if (data.ack == '5')
               {
                  num = -1;
                  ui.popup_error_prompt('Please chose a photo to upload');
               }
               num = -1;
               ui.album_upload(profileid, action);
            }
         }
      });
      return false;
   });
   var executed = false;
   $('#link_box').live('focus', function()
   {
      if (!executed)
      {
         executed = true;
         var i = 0,
             request = [],
             actiontype = 1,
             video, meta, path, title, host, src = [],
             thumb_index = 0,
             link;
         var text_change = $.trim($('#link_box').val());
         $('#link_box').live('keyup mousedown input', function(e)
         {
            if (text_change != $.trim($('#link_box').val()))
            {
               for (i = 0; i < request.length; i++)
               {
                  request[i].abort();
               }
               text_change = $.trim($('#link_box').val());
               link = $.trim($('#link_box').val());
               request.push($.getJSON('ajax/write.php', {
                  action: 'link_details_fetch',
                  link: link
               }, function(data)
               {
                  actiontype = data.actiontype;
                  video = data.video;
                  meta = data.meta;
                  path = data.path;
                  title = data.title;
                  host = data.host;
                  src = data.src;
                  link = data.link;
                  var page = $('#page_hidden').attr('value');
                 if( actiontype == 1600 && (page == 'usefullinks')) 
                  {  
                     $('#link_callback').remove();
                     $('#center').append('<div id="link_callback" style="margin:1em;height:auto;width:45em;"></div>');
                     if (video)
                     {
                        $('#link_callback').html('<iframe style="margin-top: 1em;float: left;margin-left:2em;" width="400" height="300" src="https://www.youtube.com/embed/' + path + '" frameborder="0"></iframe><div style="display:block;margin:1em 0em 0em 1em;float:right;margin-right:8em;">' + title + '<br /><a href="' + host + '">' + host + '</a><br />' + meta + '</div><div style="clear:left;"></div>');
                     }
                     else
                     {
                        $('#link_callback').html('<div id="link_thumb_container" ><img style="max-height:25em;max-width:25em;" src="' + src[thumb_index] + '" ></div><div style="display:block;margin-left: 0.5em;">' + title + '<br /><a href="' + host + '">' + host + '</a><br />' + meta + '</div><div style="clear:left;"></div>');
                     }
                  }
                  else if (actiontype == 1600)
                  {
                     $('#link_callback').remove();
                     $('#link_box').attr('placeholder','Say something about this ...');
                     $('#uploader').append('<div id="link_callback" style="margin:1em;height:auto;width:48em;"></div>');
                     if (video)
                     {
                        $('#link_callback').html('<iframe style="margin-top: 1em;float: left;margin-left:2em;" width="400" height="300" src="https://www.youtube.com/embed/' + path + '" frameborder="0"></iframe><div style="display:block;margin:1em 0em 0em 1em;float:right;margin-right:8em;" class="link_title">' + title + '</div><div><a href="' + host + '">' + host + '</a></div><div class="link_meta">' + meta + '</div><div style="clear:left;"></div>');
                     }
                     else
                     {
                        $('#link_callback').html('<div id="link_thumb_container" ><img style="max-height:25em;max-width:25em;" src="' + src[thumb_index] + '" ></div><div style="display:block;margin-left: 0.5em;" class="link_title">' + title + '</div><div><a href="' + host + '">' + host + '</a></div><div class="link_meta">' + meta + '</div><div style="clear:left;"></div>');
                        $('#link_callback').append('<div class="text-left"><input type="submit" id="thumb_prev" title ="select previous thumbnail" value="<"><input type="submit" id="thumb_next" title ="select next thumbnail" value=">"></div>');
                     }
                     $('#thumb_next').live('click', function()
                     {
                        thumb_index++;
                        $('#link_thumb_container').html('<img style="max-height:25em;max-width:25em;" src="' + src[thumb_index] + '" >');
                     });
                     $('#thumb_prev').live('click', function()
                     {
                        thumb_index--;
                        $('#link_thumb_container').html('<img style="max-height:25em;max-width:25em;" src="' + src[thumb_index] + '" >');
                     });
                  }
               }));
            }
         });
/*********************** Add link Admin **************************************/         
         $('#ullink_button').live('click', function()
         {
            var profileid = $('#profileid_hidden').attr('value').trim();
            if ($.trim($('#link_box').val()) != '')
            {
               var action = 'usefullinks';
               $.getJSON('ajax/write.php', {
                  action: action,
                  profileid: profileid,
                  title: title,
                  links: link
               }, function(data)
               {
                  if (data.ack == 1)
                  {
                     $('#usefullinks_box').append('<div id="' + data.link_id + '" class="dsgn" style="position:relative;border-bottom: 0.1em solid rgb(221, 221, 221);clear: both;cursor: pointer;min-height: 2.5em;padding: 0.5em 0px 0.5em 0.4em;">' + title + '<span  onclick="ui.usefullinks_delete(this,' + data.link_id + ')" class="dsgn_setting"></span></div>');
                  }
                  else if (data.ack == 2)
                  {
                     $('body').append('<div class="prompt_container"><div class="prompt_title">Post Prompt</div><div class="prompt_content" id="post_prompt_text"></div><div class="prompt_button"><input class="prompt_positive theme_button" type="submit" value="OK" onclick="ui.bg_hide()" /></div></div>');
                     $('body').css('overflow', 'hidden');
                     $('#post_prompt_text').append("Entry Already Exists..!");
                  }
                  $('#link_callback').remove();
               });
            }
         });  
         
/*********************************************************************************/         
         var myprofileid = $('#myprofileid_hidden').attr('value');
         var profileid = $('#profileid_hidden').attr('value').trim();
         var myphoto = $('#myprofileimage_hidden').attr('value');
         var myname = $('#myprofilename_hidden').attr('value');
         $('#link_button').live('click', function()
         {
            var icon_cdn = $('#icon_cdn').attr('value');
            var profileid = $('#profileid_hidden').attr('value').trim();
            if ($.trim($('#link_box').val()) != '')
            {
               if (actiontype == 1)
               {
                  var entry = $('#link_box').val();
                  if (entry != "")
                  {
                     $('#link_box').html('');
                     var page = $('#page_hidden').attr('value');
                     var action = 'post_status';
                     if (page == 'news_json' || page == 'profile_json')
                     {
                        action = 'post_status';
                     }
                     else if (page == 'group_json')
                     {
                        action = 'group_status';
                     }
                     else if (page == 'page_json')
                     {
                        profileid = $('#page_pageid_hidden').attr('value').trim();
                        action = 'page_status';
                     }
                     else if (page == 'event_json')
                     {
                        action = 'event_status';
                     }
                     $.getJSON('ajax/write.php', {
                        action: action,
                        profileid: profileid,
                        page: entry
                     }, function(data)
                     {
                        if (data.ack)
                        {
                           //variale problem in case of multitab
                           if (page == 'page_json')
                           {
                              pphoto = icon_cdn + '/broadcast.png';
                              $('#prev').prepend('<div class="nf_post" data="' + data.actionid + '" id="nf_post_' + data.actionid + '"><div class="name_50"></div><div data=' + data.actionid + ' class="pageclass_json"><input type="hidden" value=' + profileid + ' /> <input type="hidden" value="' + actiontype + '"/><a class="ajax_nav"  href="page.php?id=' + data.page_pageid + '"><img class="lfloat" src =' + pphoto + ' height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="page.php?id=' + data.page_pageid + '">' + data.page_name + '</a><div class="pclass_json"><pre>' + ui.see_more(ui.get_smiley(ui.link_highlight(data.page))) + '</pre></div></div>');
                              ui.response_comment('#nf_post_' + data.actionid, data.actionid, data.life_is_fun, data.time, myprofileid, myphoto);
                           }
                           else
                           {
                              $('#prev').prepend('<div class="nf_post" data="' + data.actionid + '" id="nf_post_' + data.actionid + '"><div class="name_50"></div><div data=' + data.actionid + ' class="pageclass_json"><input type="hidden" value=' + profileid + ' /> <input type="hidden" value="' + actiontype + '"/><a class="ajax_nav" href="profile.php?id=' + myprofileid + '"><img class="lfloat" src =' + myphoto + ' height="50" width="50" /></a><div class="name_50"><a class="bold ajax_nav" href="profile.php?id=' + myprofileid + '">' + myname + '</a><div class="pclass_json"><pre>' + ui.see_more(ui.get_smiley(ui.link_highlight(data.page))) + '</pre></div></div>');
                              ui.response_comment('#nf_post_' + data.actionid, data.actionid, data.life_is_fun, data.time, myprofileid, myphoto);
                           }
                        }
                        ui.upload_default_state();
                     });
                  }
               }
               else if (actiontype == 1600)
               {
                  var file = '';
                  if (video)
                  {
                     file = '';
                  }
                  else
                  {
                     file = src[thumb_index];
                     if (src[thumb_index] === undefined) file = '';
                  }
                  var profileid = $('#profileid_hidden').val();
                  var page = $('#link_box').val();
                  $('#link_box').html('')
                  if (meta === undefined) meta = '';
                  var action = 'post_link';
                  var ppage = $('#page_hidden').attr('value').trim();
                  if (ppage == 'news_json' || ppage == 'profile_json')
                  {
                     action = 'post_link';
                  }
                  else if (ppage == 'group_json')
                  {
                     action = 'group_post_link';
                  }
                  else if (ppage == 'event_json')
                  {
                     action = 'event_post_link';
                  }
                  else if (ppage == 'page_json')
                  {
                     action = 'page_post_link';
                     profileid = $('#page_pageid_hidden').attr('value').trim();
                  }
                  $.getJSON('ajax/write.php', {
                     action: action,
                     profileid: profileid,
                     title: title,
                     link: link,
                     meta: meta,
                     page: page,
                     file: file
                  }, function(data)
                  {
                     var icon_cdn = $('#icon_cdn').attr('value');
                     if (data.ack)
                     {
                        if (data.actiontype == 2916)
                        {
                           var page_image = icon_cdn + '/broadcast.png';
                           $('#prev').prepend('<div class="nf_post" data="' + data.actionid + '" id="nf_post_' + data.actionid + '"><div class="name_50"></div><div data=' + data.actionid + ' class="pageclass_json"><input type="hidden" value=' + profileid + ' /> <input type="hidden" value="' + actiontype + '"/><a class="ajax_nav"  href="page.php?id=' + data.page_pageid + '"><img class="lfloat" src =' + page_image + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="page.php?id=' + page_pageid + '">' + data.page_name + '</a> shared <a href="' + link + '">' + title + '</a></div><div style="position:relative;"></div></div>');
                        }
                        else
                        {
                           $('#prev').prepend('<div class="nf_post" data="' + data.actionid + '" id="nf_post_' + data.actionid + '"><div class="name_50"></div><div data=' + data.actionid + ' class="pageclass_json"><input type="hidden" value=' + profileid + ' /> <input type="hidden" value="' + actiontype + '"/><a class="ajax_nav" href="profile.php?id=' + myprofileid + '"><img class="lfloat" src =' + myphoto + ' height="50" width="50" /></a><div class="name_50"><div><a class="bold ajax_nav" href="profile.php?id=' + myprofileid + '">' + myname + '</a> shared <a href="' + link + '">' + title + '</a></div><div style="position:relative;"></div></div>');
                        }
                        ui.response_comment('#nf_post_' + data.actionid, data.actionid, data.life_is_fun, data.time, myprofileid, myphoto);
                        if (video)
                        {
                           $('#nf_post_' + data.actionid).children().eq(1).children().eq(3).children().eq(1).append('<input type="hidden" value="' + path + '" /><img class="video_play lfloat"  onclick="action.image_viewer(this)" style="margin:0em 1em 1em 0em;cursor:pointer;" id="' + data.actionid + '" src="https://img.youtube.com/vi/' + path + '/default.jpg" /><img class="video_play"  onclick="action.image_viewer(this)" style="position:absolute;left:4em;top:3em;cursor:pointer;" id="' + data.actionid + '" src="' + icon_cdn + '/video_play_icon.png" /><div style="margin:2em 0em 0em 0em;"><div>' + title + '</div><a href="' + host + '" target="_blank">' + host + '</a><div>' + meta + '</div><div>' + ui.see_more(ui.get_smiley(ui.link_highlight(page))) + '</div></div><br style= "clear:both;"/></div>');
                        }
                        else
                        {
                           $('#nf_post_' + data.actionid).children().eq(1).children().eq(3).children().eq(1).append('<img class="lfloat" style="max-height:8.2em;max-width:11em;margin-right:1em;" src="' + file + '" ><div style="margin:2em 0em 0em 0em;">' + title + '<br /><a href="' + host + '"  target="_blank">' + host + '</a><br />' + meta + '<br />' + ui.see_more(ui.get_smiley(ui.link_highlight(data.page))) + '</div><div style="clear:left;"></div>');
                        }
                     }
                     ui.upload_default_state();
                     $('#link_callback').remove();
                  });
               }
            }
         });
      }
   }); // option link closes
          
});
$(function()
{
   $("#startdate").datepicker();
   $("#enddate").datepicker();
});

$('.badge_chooser').click(function(){
 badgeid = $(this).attr('data-badge-id');
  $('#praisemodalbadge').modal('hide');
  $('#praisemodal').modal('show');
  $('#badge_id').attr('value',badgeid);
  me_badge=this;
  $("img:first",'#praisebody').html('');
  $('#badge_image').html(($("img:first",me_badge).clone().addClass('lfloat')));
});  
  //*************************Group chat
$('.chat_add').live('mouseover',function(){
    $('.chat_add_select').remove();
    $(this).append('<input type="submit" class="chat_add_select theme_button" value="Add" />');
});
/*$('.chat_add').mouseout(function(){
    $('.chat_add_select').remove();
});
*/

//********************************************    


