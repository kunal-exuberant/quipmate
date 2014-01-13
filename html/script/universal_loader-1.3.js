$(function(){
var profileid = $('#profileid_hidden').val();
var myprofileid = $('#myprofileid_hidden').attr('value');
var page = $('#page_hidden').attr('value');
var load = false;                     
var param = {};
var	url = 'ajax/write.php';
var increment = 0;
param.start = 0;
param.action = '';
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
	param.profileid = profileid;
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
	param.profileid = profileid;
	param.myprofileid = myprofileid;
	increment = 50;
	var profile_name = $('#profilename_hidden').attr('value');
	$('#center').append('<div id="prev"></div>');
	$('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Friends" />');
	$('#prev').append('<h1 class="page_title">'+profile_name+' - Friends</h1>');
}
else if(page == 'member')
{
	param.action = 'member_load';
	param.groupid = profileid;
	increment = 50;
	var profile_name = $('#profilename_hidden').attr('value');
	$('#center').append('<div id="prev"></div>');
	$('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Members" />');
	$('#prev').append('<h1 class="page_title">Group Members</h1>');
}
else if(page == 'guest')
{
	param.action = 'guest_load';
	param.eventid = profileid;
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
	if(profileid == myprofileid)
	{
			var showuser ;
			param.profileid = profileid;
			$('#center').append('<div id="inbox_container"></div>');
				$.getJSON('ajax/write.php',{action:'message_recent_fetch'},function(data){
				if(data.ack != 0)
				{
					$('#session_name_hidden').attr('value', JSON.stringify(data.name));
					$('#session_pimage_hidden').attr('value', JSON.stringify(data.pimage));
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
					 $('#'+showuser).append('<div style="margin-left:6em;margin-top:.15em;color:gray;"><img src="http://icon.qmcdn.net/clock.png" width="6" /><span style="color:gray;" data="'+value.time+'">'+time_difference(value.time)+'</span></a></div>');
					if(index == 0)
					{
							$('#inbox_container').html('');
							user = showuser;
							$('#inbox_container').append('<h1 id="message_user_name">'+data.name[user]+'</h1>');
							createMessageUI(user, name);
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
								createMessageUI(user, name);
								previous_talk_message(user, 0, 1);
					   });
						  $('.sendbox').live('keypress',function(event){
							var user = $(this).parent().children().eq(0).attr('value');
							var name = $('#myprofilename_hidden').attr('value'); 
							if(event.which == 13 && $.trim($(this).val()))
							{ 
								typing = true;
								var me = $(this);
								var message = $(this).val();
								var photo = $('#myprofileimage_hidden').attr('value'); 
								me.attr('value','');
								var database = $('#database_hidden').attr('value');
								var param = {"profileid":profileid,"userid":user,"message":message,"name":name,"photo":photo,"database":database}
								$.postJSON('/chat/chat_new',param,function(data){
									me.parent().children().eq(3).append('<div class="message_each"><img class="message_each_photo" title="'+name+'" height="50" width=50 src="'+photo+'"><div class="message_each_message"><pre>'+ui.get_smiley(ui.link_highlight(message))+'</pre></div><div style="text-align:right;color:gray;"><img width="6" src="http://icon.qmcdn.net/clock.png"><span style="color:gray;">now</span></div></div>');
									me.parent().children().eq(3).scrollTop($('.inboxui_msg').get(0).scrollHeight);
								});
							
							}
				   });
				});
	}	
	else
	{
		param.profileid = profileid;
		increment = 10;
		$('#center').append('<div id="prev"></div>');
		$('#center').prepend('<h1 class="page_title">All Messages between '+profileid_name+' and you</h1>');
		$('#center').prepend('<div id="message_container"><h1 style="padding:1em;">Drop a Message For '+profileid_name+'</h1><div><textarea id="message_textarea"></textarea><input id="drop_button" type="submit" value="Drop" onclick="action.message_drop(this)"></div><div style="color:gray;margin-top:15px;margin-bottom:-10px;">( The message will also be sent to '+profileid_name+' \'s email )</div></div>');
	}
}
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
		case 'diary_entry': deploy.entry_deploy(data,'#prev'); break;
		case 'action': feed.news_deploy(data,'#prev'); break;
		case 'profile_json': feed.news_deploy(data,'#prev'); break;
		case 'group_json': feed.news_deploy(data,'#prev'); break;
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
			$('#prev').append('<p align="center">No more feed available !</p>');
	}
}
});
}                              
$(window).scroll(function(){
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
		case 'admin_json': feed.news_deploy(data,'#prev'); break;
		case 'quip': feed.news_deploy(data,'#prev'); break;
		case 'notice_json': deploy.notice_deploy(data,'#prev'); break;
		case 'diary_entry': deploy.entry_deploy(data,'#prev'); break;
		case 'action': feed.news_deploy(data,'#prev'); break;
		case 'profile_json': feed.news_deploy(data,'#prev'); break;
		case 'group_json': feed.news_deploy(data,'#prev'); break;
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
			$('#prev').append('<p align="center">No more feed available !</p>');
	}
}
});
}
}
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
		case 'diary_entry': deploy.entry_deploy(data,'#prev'); break;
		case 'action': feed.news_deploy(data,'#prev'); break;
		case 'profile_json': feed.news_deploy(data,'#prev'); break;
		case 'group_json': feed.news_deploy(data,'#prev'); break;
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
			$('#prev').append('<p align="center">No more feed available !</p>');
	}
}
});
}

}  
});

/*
$('.ajax_nav').click(function()
{	
		page = $(this).attr('id');
		$('#page_hidden').attr('value',page);
		load = false;                     
		param = {};
		url = '';
		increment = 0;
		param.start = 0;
		if(page == 'news_json')
		{
			if(window.history)
			{
				window.history.pushState('http://www.quipmate.com/','HTML5','?hl=update');
			}
			else
			{
				window.location.hash = 'update';
			}
			url = 'ajax/write.php';
			increment = 10;
			$('#center').append('<div id="news_poll"></div>');
			$('#center').append('<div id="prev"></div>');
			$('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Updates" />');
		}
		else if(page == 'inbox')
		{
			if(window.history)
			{
				window.history.pushState('http://www.quipmate.com/','HTML5','?hl=inbox');
			}
			else
			{
				window.location.hash = 'inbox';
			} 
			var profileid = $('#profileid_hidden').attr('value');
			var myprofileid = $('#myprofileid_hidden').attr('value');
			var profileid_name = $('#profilename_hidden').attr('value');
			var myprofileid = $('#myprofileid_hidden').attr('value');
			var myprofileid_name = $('#myprofilename_hidden').attr('value');
			var myprofileid_image = $('#myprofileimage_hidden').attr('value');
			url = 'ajax/message_json.php';
			param.profileid = profileid;
			increment = 10;
			$('#center').append('<div id="prev"></div>');
			if(myprofileid != profileid) 
			{
				$('#center').prepend('<h1 class="page_title">All Messages between '+profileid_name+' and you</h1>');
				$('#center').prepend('<div id="message_container"><h1>Drop a Message For '+profileid_name+'</h1><div style="position:relative;left:5em;"><textarea id="message_textarea"></textarea><input id="drop_button" type="submit" value="Drop"></div><div style="color:gray;margin-top:15px;margin-bottom:-10px;">( The message will also be sent to '+profileid_name+' \'s email )</div></div>');
			}
			else
			{
				$('#center').prepend('<h1 style="margin-bottom:-35px;">All Messages</h1>');
			}
		}
		else if(page == 'photo')
		{
			if(window.history)
			{
				window.history.pushState('http://www.quipmate.com/','HTML5','?hl=photo');
			}
			else
			{
				window.location.hash = 'photo';
			}
			url = 'ajax/photo_json.php';
			param.myprofileid = myprofileid;
			increment = 25;
			var profile_name = $('#myprofilename_hidden').attr('value');
			$('#center').append('<div id="prev"></div>');
			$('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Photo" />');
			$('#prev').html('<h1 style="font-size:16pt;">'+profile_name+' -> Friends -> Photo</h1>');
			$('#prev').append('<table></table>');
		}
		else if(page == 'college_mate')
		{
			if(window.history)
			{
				window.history.pushState('http://www.quipmate.com/','HTML5','?hl=college_mate');
			}
			else
			{
				window.location.hash = 'college_mate';
			}
			url = 'ajax/photo_json.php';
			param.myprofileid = myprofileid;
			increment = 25;
			var profile_name = $('#myprofilename_hidden').attr('value');
			$('#center').append('<div id="prev"></div>');
			$('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Photo" />');
			$('#prev').html('<h1 style="font-size:16pt;">'+profile_name+' -> Friends -> Photo</h1>');
			$('#prev').append('<table></table>');
		} 
		else if(page == 'new_user')
		{
			if(window.history)
			{
				window.history.pushState('http://www.quipmate.com/','HTML5','?hl=new_user');
			}
			else
			{
				window.location.hash = 'new_user';
			}
			url = 'ajax/photo_json.php';
			param.myprofileid = myprofileid;
			increment = 25;
			var profile_name = $('#myprofilename_hidden').attr('value');
			$('#center').append('<div id="prev"></div>');
			$('#center').append('<input type="submit" id="load_more" style="height:30px;width:150px;margin-left:200px;display:none;" value="Show More Photo" />');
			$('#prev').html('<h1 style="font-size:16pt;">'+profile_name+' -> Friends -> Photo</h1>');
			$('#prev').append('<table></table>');
		}    		
		
		$.getJSON(url,param,function(data){
			if($.trim(data)!='')
			{
				load = true;    
				$("#loading").remove();
				var oldh = $("#center").height();
				switch(page)   
				{
					case 'news_json': news_deploy(data,'#prev'); break;
					case 'photo': photo_deploy(data); break;
					case 'inbox': $("#upload_box").remove(); $('#prev').html(""); message_deploy(data); break;
					default: $("#prev").append(data); break;
				}
				var oldh = $("#prev").height();
				oldh = parseInt(oldh) + 300;
				$("#center").height(oldh);
				param.start +=increment;
				$('#load_more').show();
			}
			else
			{
				load = false;
				$('#loading').remove();
				$('#prev').append('<p align="center">No More Updates From Your Friends</p>');
			}
		});
	return false;	
});

*/


}); // jquery dom closed
function createMessageUI(user, name)
{
	$('#inbox_container').append('<div id="inbox_'+user+'" class="inboxui" ><input type="hidden" value="'+user+'"/><span ></span><div class="inboxui_title"><span><a href="profile.php?id='+user+' ">'+name+'</a></span></div><div class="inboxui_msg"></div><input class="sendbox" type="text"/><input type="hidden" value="10"/></div>');
	$('.inboxui_msg').css('height',$(window).height()-150);
	$('.inboxui_msg').css('overflow','auto');
	$('#inbox_'+user).children().eq(4).focus();
	$('#inbox_'+user).children().eq(3).scroll(function(){messagebox_scroll(user)});
}
function messagebox_scroll(user)
{ 
		var chat_start = parseInt($('#inbox_'+user).children().eq(5).attr('value'));
		if($('#inbox_'+user).children().eq(3).get(0).scrollTop  < $('#inbox_'+user).children().eq(3).get(0).scrollHeight * 0.1 && chat_load)
		{
				chat_load = false;
				previous_talk_message(user, chat_start, 0);
				chat_start += 10;
				$('#inbox_'+user).children().eq(5).attr('value',chat_start);
		}
}
function previous_talk_message(user, chat_start, opening)
{
        $.getJSON('ajax/write.php',{action:'message_fetch',profileid:user,start:chat_start},function(data){
        $.each(data.action,function(index,value){
			$('#inbox_'+user).children().eq(3).prepend('<div class="message_each"><img class="message_each_photo" title="'+data.name[value.actionby]+'" height="50" width="50" src="'+data.pimage[value.actionby]+'"><div class="message_each_message">'+ui.get_smiley(ui.link_highlight(value.message))+'</div><div style="text-align:right;color:gray;"><img src="png/clock.png" width="6" /><span style="color:gray;">'+value.time+'</span></a></div></div>'); 
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
function entry_deploy(data)
{
	$.each(data.entry,function(index,value){
		$('#prev').append('<div id="'+value.actionid +'" style="border-bottom:.2em solid #f8f8f8;padding:.5em;"><div style="float:left;background:#336699;color:#ffffff;font-weight:bold;width:4em;height:3em;padding:1em;border:.1em solid gray;margin:.2em;">'+value.day+','+value.month+'<br /> '+value.year+'</div></div>');
		$('#'+value.actionid).append('<div style="display:block;margin-left:7em;width:42em;padding-top:.5em;">'+value.entry+'</div><div style="clear:both;"></div>');
	});
}

