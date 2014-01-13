$(function() {
    var random = Math.random();
     $('#random_hidden').attr('value',random);
    if (!window.console) window.console = {};
    if (!window.console.log) window.console.log = function() {};
	
	var profileid = $('#myprofileid_hidden').attr('value'); 
	var name = $('#myprofilename_hidden').attr('value'); 
	var photo = $('#myprofileimage_hidden').attr('value'); 
	
	$.getJSON('ajax/write.php',{action:'friend_fetch',profileid:profileid},function(data){
		if(data.ack)
		{
			$('#myfriends_name_hidden').attr('value', JSON.stringify(data.name));
			$('#myfriends_pimage_hidden').attr('value', JSON.stringify(data.pimage));
			var global_name = JSON.parse($('#session_name_hidden').attr('value'));
			var global_pimage = JSON.parse($('#session_pimage_hidden').attr('value'));
			var friend_name = JSON.parse($('#myfriends_name_hidden').attr('value'));
			var friend_pimage = JSON.parse($('#myfriends_pimage_hidden').attr('value'));
			$('#session_name_hidden').attr('value', JSON.stringify($.extend(global_name,friend_name)));
			$('#session_pimage_hidden').attr('value', JSON.stringify($.extend(global_pimage,friend_pimage)));
			
			$.each(data.action,function(index,value){
				id = "friend_"+value;
				if($('#'+id).length == 0)
				{	
					$('.online_user').append('<div class="chat_user" data="'+value+'" id="'+id+'"><img class="online_photo" height="30" width="30" src="'+data.pimage[value]+'" /><span class="online_name">'+data.name[value]+'</span><input type="hidden" value="'+data.name[value]+'" /></div>');
				}  
			});
		}
		else
		{
			$('.online_user').append('<div>Nobody is available at chat</div>');
		}
	});

	
	var rtm_load = true;
	var start = 0;
	$.getJSON('ajax/write.php',{action:'live_feed',start:start},function(data){
		if(data.ack)
		{
			start += 20;
			real_time_deploy_append(data);
		}	
	});
	$('#rtm_container').bind('scroll',function(){ 
		if($('#rtm_container').get(0).scrollTop > $('#rtm_container').get(0).scrollHeight * 0.2 && rtm_load)
		{
			rtm_load = false;
			$.getJSON('ajax/write.php',{action:'live_feed',start:start},function(data){
			if(data.ack)
			{
				start += 20;
				rtm_load = true;
				real_time_deploy_append(data);
			}	
			});
		}
	});
	
	chat_load = true;
   onlineUser();
   //typing_listen(); 
   individualChat();	
   real_time();	
   var typing = true;
   var allow_typing = true;;
   var cook = action.getCookie('chatbox')
   if(cook != '')
   {
		var is_online = false;
		if($('#friend_'+cook).children().eq(3).length > 0)
			is_online = true;
		var name = action.getCookie('name');
		createChatBoxUI(cook, name, is_online);
		previous_talk(cook, 0,1);
		allow_typing = false;
		typing = false;
   } 
   
	var open_chatbox = [];
   $('.chat_user').live('click',function(){
		allow_typing = false;
		user = $(this).attr('data');
		if(open_chatbox.length > 2)
		{
			$('#chatbox_'+open_chatbox[0]).remove();
			open_chatbox.splice(0, 1);
		}
		if($.inArray(user,open_chatbox) == -1)
		{
			open_chatbox.push(user);
			name = $(this).children().eq(2).attr('value');
			$('#chatbox_'+user).remove();
			if($(this).children().eq(3))
			var is_online = false;
			if($('#friend_'+user).children().eq(3).length > 0)
				  is_online = true;
			createChatBoxUI(user, name, is_online);
			previous_talk(user, 0, 1);
		}
		action.createCookie('chatbox',user);
		action.createCookie('name',name);
   });
   
   $('.chatbox').live('focus',function(event)
   {
		if(!typing && allow_typing) typing = true;
   });

   
   $('.chatbox').live('keypress',function(event)
   {
	var user = $(this).parent().children().eq(0).attr('value');
	var name = $('#myprofilename_hidden').attr('value'); 
	if(event.which == 13 && $.trim($(this).val()))
	{ 
		typing = true;
		var me = $(this);
		var message = $(this).val();
		if(message.substr(message.length-1) == '\\')
		{
			message = message+'\\';
		}
		me.attr('value','');
		var database = $('#database_hidden').attr('value');
		var param = {"profileid":profileid,"userid":user,"message":message,"name":name,"photo":photo,"database":database}
		$.postJSON('/chat/chat_new',param,function(data){
			$.each(data.action,function(index,value){
			    last_chat_time = value.time;
				$('#chat_'+value.actionid).remove();
				me.parent().children().eq(3).append('<div class="chat_each" id="chat_'+value.actionid+'" onmouseover="chat_time_show(this)" onmouseleave="chat_time_hide(this)"><img class="chat_each_photo" title="'+data.name[value.sentby]+'" height="25" width="25" src="'+data.photo[value.sentby]+'"><div class="chat_each_message"><pre>'+ui.get_smiley(ui.link_highlight(value.message))+'</pre></div><span class="chat_time">Now</span></div>');
				me.parent().children().eq(3).scrollTop($('.chatboxui_msg').get(0).scrollHeight);
			});
		});
		
		me.focus();
		
		if($.inArray(parseInt(user), JSON.parse($('#online_hidden').attr('value'))) == -1)
		{
			$.getJSON('ajax/write.php',{action:'chat_email',profileid:user,message:message},function(data){});
		}
	}
	else
	{
	    if(typing)
		{
		    typing = false;
			var database = $('#database_hidden').attr('value');
			var param = {"profileid":profileid,"userid":user,"name":name,"database":database};
			$.postJSON('/chat/typing_new',param,function(data){});	
		}
	}
   });
	
   $('.chatbox_close').live('click',function(){
	$(this).parent().remove();	
	var user = $(this).parent().children().eq(0).attr('value');
	$('#chatbox_'+user).children().eq(3).unbind('scroll');
	open_chatbox.splice($.inArray(user,open_chatbox), 1);
	action.cookie_delete('chatbox');
	action.cookie_delete('name');
   });	
   var request = [], present = false;
   $('.rtm_each').live('mouseover', function(){
		$(this).removeClass('chat_unread');
        if(!present)
		{
		var pageid = $(this).children().eq(0).attr('value');
		var life_is_fun = $(this).children().eq(1).attr('value');
		var me = $(this);
		for(var i = 0; i < request.length; i++)
		{
				request[i].abort();
		}
		request.push($.getJSON('ajax/write.php',{action:'action_fetch',actionid:pageid,life_is_fun:life_is_fun},function(data){
			$('.if_post').remove();
			$('body').append('<div class="if_post" id="if_container"><div class="rtm_pointer"></div></div>');
			$('#if_container').css('top',me.position().top);
			var dom_id = 'if_post_'+data.actionid;
			feed.news_deploy(data, '#if_container', 1);
			if($('#if_container').height() + me.position().top > $(window).height())
			{
				$('#if_container').css('top',0);	
				$('.rtm_pointer').css('top',me.position().top+11+'px'); 				
			}	
		}));
		}
	});
	
	$('.rtm_each').live('click', function(){
		var pageid = $(this).children().eq(0).attr('value');
		var life_is_fun = $(this).children().eq(1).attr('value');
		var me = $(this);
		for(var i = 0; i < request.length; i++)
		{
				request[i].abort();
		}
		request.push($.getJSON('ajax/write.php',{action:'action_fetch',actionid:pageid,life_is_fun:life_is_fun},function(data){
			$('.if_post').remove();
			$('body').append('<div class="if_post" id="if_container"><div class="rtm_pointer"></div></div>');
			$('#if_container').css('top',me.position().top);
			var dom_id = 'if_post_'+data.actionid;
			feed.news_deploy(data, '#if_container', 1);
			if($('#if_container').height() + me.position().top > $(window).height())
			{
				$('#if_container').css('top',0);	
				$('.rtm_pointer').css('top',me.position().top+11+'px'); 				
			}	
		}));
	});
	
	$('.rtm_each').live('mouseleave', function(){
		
		if(!present)
		{
			$('.if_post').remove(); 
			for(var i = 0; i < request.length; i++)
			{
				request[i].abort();
			} 
		}
	
	});
	
	  $('.rtm_each, .if_post').live('click', function(){
			present = true;
	  });
	
	$('#left,#center,#right,#chatbox_container,#friend_status,.online_user,.chat_toolbar').live('mouseover', function(){
	    if(!present)
		{
			$('.if_post').remove(); 
			for(var i = 0; i < request.length; i++)
			{
				request[i].abort();
			} 
		}
	});
	
	$('#wrapper,#header,#chatbox_container,#friend_status,.online_user,.chat_toolbar').live('click', function(){
	    present = false;
		$('.if_post').remove(); 
		for(var i = 0; i < request.length; i++)
		{
			request[i].abort();
		}
	});
	
	$('.chat_user').live('mouseover',function(){		
		var profileid = $(this).attr('data');
		var pname = JSON.parse($('#myfriends_name_hidden').attr('value'));
		var pphoto = JSON.parse($('#myfriends_pimage_hidden').attr('value'));
		var ptagline = JSON.parse($('#session_tagline_hidden').attr('value'));
		var pic = pphoto[profileid];
		var nm = pname[profileid];
		var tag = ptagline[profileid];;
		if(!ptagline[profileid])
		{
			tag = "";
		}
		me = $(this);
		$('.people_status').remove(); 
		$('body').append('<div class="people_status"><div class="people_pointer"></div><a href="profile.php?id='+profileid+'"><img class="lfloat" src="'+pic+'" height="80" width="80"/></a><div class="name_80"><a class="bold" href="profile.php?id='+profileid+'">'+nm+'</a><div>'+tag+'</div></div></div>');
		$('.people_status').css('top',me.position().top); 
		$('.people_status').css('right',me.position().right); 
	});
	
	$('#left,#center,#right,#chatbox_container,#rtm_container').live('mouseover', function(){
	    $('.people_status').remove(); 
	});
	
	$('.chatboxui_title').live('click', function(){
		$(this).next().toggle();
		$(this).next().next().toggle();
	});
	

});

function chatbox_scroll(user)
{ 
		var chat_start = parseInt($('#chatbox_'+user).children().eq(5).attr('value'));
		if($('#chatbox_'+user).children().eq(3).get(0).scrollTop  < $('#chatbox_'+user).children().eq(3).get(0).scrollHeight * 0.1 && chat_load)
		{
				chat_load = false;
				previous_talk(user, chat_start, 0);
				chat_start += 10;
				$('#chatbox_'+user).children().eq(5).attr('value',chat_start);
		}
}

function chat_sound_play()
{
		var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', 'http://icon.qmcdn.net/chat_sound.mp3');
		audioElement.play();
		return false;
}

var chat_notify = true;

function chat_new_notify(name, message)
{
	$(document).attr('title',message+' :'+name);
	if(chat_notify)
	{
		setTimeout(function(){
			title_restore(name, message);
		}, 1000);
	}
	else
	{
		$(document).attr('title','Quipmate');
	}	
}

function title_restore(name, message)
{
	$(document).attr('title','Quipmate');
	if(chat_notify)
	{
		setTimeout(function(){
			chat_new_notify(name, message);
		}, 1000);	
	}
	else
	{
		$(document).attr('title','Quipmate');
	}
}

$(window).focus(function(){
    chat_notify = false;
});

function chat_unread(userid)
{
	$('#chatbox_'+userid).children().eq(2).addClass('chat_unread');
}

$('.chatboxui').live('mousedown keydown input',function(){
    if($(this).children().eq(2).attr('class') == 'chatboxui_title chat_unread')
	{
		$(this).children().eq(2).removeClass('chat_unread');
		var userid = $(this).children().eq(0).attr('value');
		var profileid = $('#myprofileid_hidden').attr('value'); 
		var name = $('#myprofilename_hidden').attr('value'); 
		var database = $('#database_hidden').attr('value');
		var param = {"profileid":userid,"userid":profileid,"name":name,"database":database}; // sentby(userid) and sentto(profileid) are swapped here
		$.postJSON('/chat/chat_seen',param,function(data){});
	}		
});

		var last_chat_time = -1;
function individualChat()
{
        var random =  $('#random_hidden').attr('value');
		var profileid = $('#myprofileid_hidden').attr('value'); 
		var database = $('#database_hidden').attr('value');
		var param = {"profileid":profileid,"random":random,"database":database,"last_chat_time":last_chat_time}
		$.postJSON('/chat/chat_update',param,function(data){
			$.each(data.action,function(index,value)
			{
					if(value.type == 1)
					{
						if($('#chatbox_'+value.sentto).length != 0)
						{
							$('#chatbox_'+value.sentto).children().eq(2).html('<img class="chatbox_online_icon" src="http://icon.qmcdn.net/online.png" /><a href="profile.php?id='+value.sentby+' ">'+data.name[value.sentby]+'</a> saw your message');
						}	
					}
					else if(value.type == 2)
					{
						if($('#chatbox_'+value.sentby).length != 0)
						{
							if(!$('#chatbox_'+value.sentby).is(':focus')) $(document).attr('title',data.name[value.sentby] +' is typing');
							$('#chatbox_'+value.sentby).children().eq(2).html('<img class="chatbox_online_icon" src="http://icon.qmcdn.net/online.png" /><a href="profile.php?id='+value.sentby+' ">'+data.name[value.sentby]+'</a> is typing');
						}
					}	 
					else if(value.type == 3)
					{			
						if(!document.hasFocus())
						{
							chat_notify = true;
							chat_new_notify(data.name[value.sentby], value.message)
							chat_sound_play(); 
						}
						var you = value.sentby,unread = 1;
						if(value.sentby == profileid)
						{
							you = value.sentto;
							unread = 0;
						}
						if($('#chatbox_'+you).length == 0)
						{	
							var is_online = false;
							if($('#friend_'+you).children().eq(3).length > 0)
								is_online = true;
							createChatBoxUI(you, data.name[you], is_online);
							previous_talk(you, 0, 1);
							if(!$('#chatbox_'+you).is(':focus') && unread == 1) chat_unread(you); 						
						}
						else
						{
							$(document).attr('title','Quipmate');
							$('#chatbox_'+value.you).children().eq(2).html('<img class="chatbox_online_icon" src="http://icon.qmcdn.net/online.png" /><a href="profile.php?id='+you+' ">'+data.name[you]+'</a>');
							$('#chat_'+value.actionid).remove();
							$('#chatbox_'+you).children().eq(3).append('<div class="chat_each" id="chat_'+value.actionid+'" onmouseover="chat_time_show(this)" onmouseleave="chat_time_hide(this)"><img class="chat_each_photo" title="'+data.name[value.sentby]+'" height="25" width="25" src="'+data.photo[value.sentby]+'"><div class="chat_each_message"><pre>'+ui.get_smiley(ui.link_highlight(value.message))+'</pre></div><span class="chat_time">Now</span></div>');
							$('#chatbox_'+you).children().eq(3).scrollTop($('.chatboxui_msg').get(0).scrollHeight);	
							if(!$('#chatbox_'+you).is(':focus') && unread == 1) chat_unread(you); 
						}
						last_chat_time = value.time;
					}
			});			
			setTimeout(individualChat,0);
		});
}

function typing_listen()
{
        var random =  $('#random_hidden').attr('value');
        var profileid = $('#myprofileid_hidden').attr('value');
		var database = $('#database_hidden').attr('value');
		var param = {"profileid":profileid,"random":random,"database":database}
	$.postJSON('/chat/typing_listen',param,function(data){
		if(data.s)
		{
			$('#chatbox_'+data.sentto).children().eq(2).html('<img class="chatbox_online_icon" src="http://icon.qmcdn.net/online.png" /><a href="profile.php?id='+data.name+' ">'+data.name+'</a> saw your message');
		}
		else
		{
			if($('#chatbox_'+data.sentby).length == 1)
			{
				$(document).attr('title',data.name +' is typing');
				$('#chatbox_'+data.sentby).children().eq(2).html('<img class="chatbox_online_icon" src="http://icon.qmcdn.net/online.png" /><a href="profile.php?id='+data.name+' ">'+data.name+'</a> is typing');
			}
			else
			{
				// Nothing happens to corresponding user when his friends starts typing for him fisrt time !
			}
		}	
	    setTimeout(typing_listen,0);
	});
}

function createChatBoxUI(user, name, is_online)
{
	$('#chatbox_container').append('<div id="chatbox_'+user+'" class="chatboxui" ><input type="hidden" value="'+user+'"/><span class="chatbox_close">x</span><div class="chatboxui_title"><span><a href="profile.php?id='+user+' ">'+name+'</a></span></div><div class="chatboxui_msg"></div><input class="chatbox" type="text"/><input type="hidden" value="10"/></div>');
	$('#chatbox_'+user).children().eq(4).focus();
    if(is_online)
	$('#chatbox_'+user).children().eq(2).prepend('<img class="chatbox_online_icon" src="http://icon.qmcdn.net/online.png" />');
	
	$('#chatbox_'+user).children().eq(3).scroll(function(){chatbox_scroll(user)});
}

function chat_time_hide(me)
{
	$(me).children().eq(2).hide();
}

function chat_time_show(me)
{
	$(me).children().eq(2).show();
}

function previous_talk(user, chat_start, opening)
{
		var myprofileid = $('#myprofileid_hidden').attr('value'); 
        $.getJSON('ajax/write.php',{action:'message_fetch',profileid:user,start:chat_start},function(data){
        $.each(data.action,function(index,value){
			$('#chat_'+value.actionid).remove();
			$('#chatbox_'+user).children().eq(3).prepend('<div class="chat_each" id="chat_'+value.actionid+'" onmouseover="chat_time_show(this)" onmouseleave="chat_time_hide(this)"><img class="chat_each_photo" title="'+data.name[value.actionby]+'" height="25" width="25" src="'+data.pimage[value.actionby]+'"><div class="chat_each_message"><pre>'+ui.get_smiley(ui.link_highlight(value.message))+'</pre></div><span class="chat_time">'+value.time+'</span></div>'); 
        });
		if(opening)
		{
			$('#chatbox_'+user).children().eq(3).scrollTop($('.chatboxui_msg').get(0).scrollHeight);
		}	
			chat_load = true;
        });
}

		var last_poll_time_rt = -1;

function real_time()
{
    var profileid = $('#myprofileid_hidden').attr('value');
	var database = $('#database_hidden').attr('value');
	var param = {"profileid":profileid,"last_poll_time":last_poll_time_rt,"database":database}
	$.postJSON('/chat/real_time',param,function(data){
		
		if(data.count != $('#numnotice').attr('data'))
		{ 
				if(data.count == 0)
				{	
					$('#numnotice').html('');
				}
				else
				{	
					$('#numnotice').attr('data',data.count);
					$('#numnotice').html(data.count);
				}	
		}
		if(data.message_count != $('#message_count').attr('data'))
		{ 
				if(data.message_count == 0)
				{	
					$('#message_count').html('');
				}
				else
				{
					$('#message_count').attr('data',data.message_count);
					$('#message_count').html(data.message_count);
				}	
		}
		if(data.request_count != $('#request_count').attr('data'))
		{ 
				if(data.request_count == 0)
				{	
					$('#request_count').html('');
				}
				else
				{
					$('#request_count').attr('data',data.request_count);
					$('#request_count').html(data.request_count);
				}	
		}
		var total_count = parseInt(data.count) + parseInt(data.message_count) + parseInt(data.request_count);
		if(total_count) $(document).attr('title','('+total_count+') Quipmate');
		//deploy.real_time_deploy(data); 
		$.each(data.action,function(index,value){
			var dom_id = 'lf_'+value.pageid;
			deploy.action_decode('live_feed',value,data.name,data.photo,'#rtm_container',dom_id,1,0);
	   });
		var response = jQuery.parseJSON(data.response);
		if(response) feed.news_deploy(response,'#prev', 0, 0); 		
		last_poll_time_rt = data.last_poll_time	
		setTimeout(real_time,0);
	});
}

function real_time_deploy_append(data)
{
	if(data)
	{
	   $.each(data.action,function(index,value){
			var dom_id = 'lf_'+value.pageid;
			deploy.action_decode('live_feed', value, data.name, data.photo, '#rtm_container', dom_id, 1, 1);
	   });
	}
	else
	{
		$('#rtm_container').append('<div>No Real Time Update</div>');
	}
	
}


function onlineUser()
{
        var random =  $('#random_hidden').attr('value');
        var profileid = $('#myprofileid_hidden').attr('value');
		var name = $('#myprofilename_hidden').attr('value');
		var database = $('#database_hidden').attr('value');
		var param = {"profileid":profileid,"name":name,"random":random,"database":database}
	$.postJSON('/chat/online',param,function(data){
				$('#online_hidden').attr('value', JSON.stringify(data.user));
                $('.online_icon').remove();
				$('.chatbox_online_icon').remove();
                if(data.ack)
                {
			$.each(data.user,function(index,value){
			       if(value != profileid)
				   {
		             var id = 'friend_'+value;
					 $('#'+id).remove();
					  $('.'+id).remove();
                     $('.online_user').prepend('<div class="chat_user iamonline '+id+'" data="'+value+'" id="'+id+'"><img class="online_photo" height="30" width="30" src="'+data.photo[value]+'" /><span class="online_name">'+data.name[value]+'</span><input type="hidden" value="'+data.name[value]+'" /><img class="online_icon" src="http://icon.qmcdn.net/online.png" /></div>');
					 $('#chatbox_'+value).children().eq(2).html('<img class="chatbox_online_icon" src="http://icon.qmcdn.net/online.png" /><a href="profile.php?id='+value+' ">'+data.name[value]+'</a>');
				  } 
			});
                }
	        setTimeout(onlineUser,0);
	});
}

		var last_action_time = -1;


var last_poll_time_news  = -1;


function getCookie(name) {
    var r = document.cookie.match("\\b" + name + "=([^;]*)\\b");
    return r ? r[1] : undefined;
}

 jQuery.postJSON = function(url, args, callback) {
    args._xsrf = getCookie("_xsrf");
    $.ajax({url: url, data: $.param(args), dataType: "text", type: "POST",
            success: function(response) {
        if (callback) callback(eval("(" + response + ")"));
    }, error: function(response) {
        console.log("ERROR:", response)
    }});
};
