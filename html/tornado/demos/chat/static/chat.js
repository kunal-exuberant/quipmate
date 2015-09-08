$(function() {
    var random = Math.random();
     $('#random_hidden').attr('value',random);
    if (!window.console) window.console = {};
    if (!window.console.log) window.console.log = function() {};

    var profileid = $('#profileid_hidden').attr('value');
    var name = $('#name_hidden').attr('value');
    var param = {"profileid":profileid,"name":name}
	$.postJSON('/friend_select',param,function(data){
                $('#online_user').html('')
                if(data.ack)
                {
			$.each(data.friend,function(index,value){
                              id = "friend_"+value;
			      $('#online_user').append('<div class="chat_user" data="'+value+'" id="'+id+'"><img style="cursor:pointer;" height="30" src="'+data.photo[value]+'" /><span class="online_name">'+data.name[value]+'</span><input type="hidden" value="'+data.name[value]+'" /></div>');
			});
                }
                else
                {
                   	$('#online_user').append('<div>Nobody is available at chat</div>');
                }
		
	});

   
   onlineUser();
   individualChat();	
   real_time();	
	
   $('.chat_user').live('click',function(){
	user = $(this).attr('data');
	alert(user)
        name = $(this).children().eq(2).attr('value');
		alert(name)
	$('#'+user).remove();
        if($(this).children().eq(3))
        var is_online = false;
        if($('#friend_'+user).children().eq(3).length > 0)
              is_online = true;
	createChatBoxUI(user, name, is_online);
        previous_talk(user);
   });

   $('.chatbox').live('keypress',function(event)
   {
	var kcode = event.which;
        var me = $(this);
		var profileid = $('#profileid_hidden').attr('value');
		var name = $('#name_hidden').attr('value');
		var user = $(this).parent().children().eq(0).attr('value');
        if(kcode == 13 && event.shiftKey)
        {
          me.val(me.val()+ "\n");
        }
	else if(kcode == 13 && $.trim($(this).val()))
	{
		var message = $(this).val();
		me.attr('value','');
		var param = {"profileid":profileid,"name":name,"userid":user,"message":message,"typing":0}
		$.postJSON('a/message/chat_new',param,function(data){
			me.parent().children().eq(3).append('<div class="chat_each"><img style="cursor:pointer;" title="'+data.name[data.sentby]+'" height="30" src="'+data.photo[data.sentby]+'"><span class="chat_each_message">'+data.message+'</span></div>')
			me.parent().children().eq(3).scrollTop(me.parent().children().eq(3)[0].scrollHeight);
		});
	}
	else
	{
	        var user = $(this).parent().children().eq(0).attr('value');
		var param = {"profileid":profileid,"name":name,"userid":user,"message":"typing","typing":1};
		$.postJSON('/a/message/chat_new',param,function(data){
		});
	}
   });
	
   $('.chatbox_close').live('click',function(){
	$(this).parent().remove();	
   });	

   
   $('.rtm_each').live('mouseover',function(){
         var chatid = $(this).children().eq(2).attr('value');
         var me = $(this);
                var profileid = $('#profileid_hidden').attr('value');
		var name = $('#name_hidden').attr('value');
		var param = {"profileid":profileid,"name":name,"chatid":chatid}
	 $.postJSON('/instant',param,function(data){
		 $('#rtm_popup').remove();
		 var top = me.position().top+'px';
		 $('body').append('<div id="rtm_popup" style="position:fixed;top:'+top+';right:22em;width:20em;border:0.1em solid gray;padding:1em;background:white;"></div>');
                 $('#rtm_popup').append('<div class=""><img style="cursor:pointer;" height="30" src="'+data.photo[data.action['actionby']]+'" /><span style="vertical-align:1.4em;margin-left:0.2em;"><b>'+data.name[data.action['actionby']]+'</b>:'+data.action['msg']+'</span><input type="hidden" value="'+data.action['actionid']+'" /></div>');
         });
   });

      $('.rtm_each').live('mouseleave',function(){
         $('#rtm_popup').remove();   
      });

});

function individualChat()
{
        var random =  $('#random_hidden').attr('value');
                var profileid = $('#profileid_hidden').attr('value');
		var name = $('#name_hidden').attr('value');
		var param = {"profileid":profileid,"name":name,"random":random}
	$.postJSON('/a/message/chat_update',param,function(data){
	    if(data.typing==0)
	    {
		if($('#'+data.sentby).length == 0)
                {	
			var is_online = false;
                        if($('#friend_'+data.sentby).children().eq(3).length > 0)
                           is_online = true;
 			createChatBoxUI(data.sentby, data.name[data.sentby], is_online);
                        previous_talk(data.sentby);	
                }
                else
		{
			$('#'+data.sentby).children().eq(2).html(data.name[data.sentby]);
			$('#'+data.sentby).children().eq(3).append('<div class="chat_each"><img style="cursor:pointer;" title="'+data.name[data.sentby]+'" height="30" src="'+data.photo[data.sentby]+'"><span class="chat_each_message">'+data.message+'</span></div>')
			$('#'+data.sentby).children().eq(3).scrollTop($('#'+data.sentby).children().eq(3)[0].scrollHeight);
		}
            }
            else
            {
                if($('#'+data.sentby).length == 1)
                {
			$(document).attr('title',data.name[data.sentby]+' is typing');
			$('#'+data.sentby).children().eq(2).html(data.name[data.sentby]+' is typing');
                }
            }
	    setTimeout(individualChat,0);
	});
}

function createChatBoxUI(user, name, is_online)
{
$('#chatbox_container').append('<div id="'+user+'" class="chatboxui" ><input type="hidden" value="'+user+'"/><span class="chatbox_close">x</span><div class="chatboxui_title"><span>'+name+'</span></div><div class="chatboxui_msg"></div><input class="chatbox" type="text"/></div>');
    if(is_online)
	$('#'+user).children().eq(2).prepend('<img style="margin-right:0.5em;" src="http://localhost/online.png" />');
}

function previous_talk(user)
{
                var profileid = $('#profileid_hidden').attr('value');
		var name = $('#name_hidden').attr('value');
		var param = {"profileid":profileid,"name":name,"sentby":user}
        $.postJSON('/update_chatbox',param,function(data){
        var i = 0
        $.each(data.message,function(index,value){
		$('#'+user).children().eq(3).prepend('<div class="chat_each"><img style="cursor:pointer;" title="'+data.name[data.sentby[i]]+'" height="30" src="'+data.photo[data.sentby[i]]+'"><span class="chat_each_message">'+data.message[i]+'</span></div>');
		$('#'+user).children().eq(3).scrollTop($('#'+user).children().eq(3)[0].scrollHeight);
        i++;
        });
        });
}

function real_time()
{
        var chatid_max =  $('#chatid_hidden').attr('value');
                var profileid = $('#profileid_hidden').attr('value');
		var name = $('#name_hidden').attr('value');
		var param = {"profileid":profileid,"name":name,"chatid_max":chatid_max}
	$.postJSON('/real_time',param,function(data){
                if(data)
                {
                   var i =0
                   $.each(data.msg,function(index,value){
	           $('#rtm_container').prepend('<div class="rtm_each"><img style="cursor:pointer;" height="30" src="'+data.photo[data.actionby[i]]+'" /><span style="vertical-align:1.4em;margin-left:0.2em;"><b>'+data.name[data.actionby[i]]+'</b>:'+data.msg[i]+'</span><input type="hidden" value="'+data.actionid[i]+'" /></div>');
                   $('#chatid_hidden').attr('value',data.actionid[i]);
                   i = i +1
                   });
                }
                else
                {
                   	$('#rtm_container').append('<div>No Real Time Update</div>');
                }
	        setTimeout(real_time,0);
	});
}

function onlineUser()
{
        var random =  $('#random_hidden').attr('value');
                var profileid = $('#profileid_hidden').attr('value');
		var name = $('#name_hidden').attr('value');
		var param = {"profileid":profileid,"name":name,"random":random}
	$.postJSON('/a/message/online',param,function(data){
                $('.online_icon').remove();
                if(data.ack)
                {
			$.each(data.user,function(index,value){
		            var id = 'friend_'+value;
		             $('#'+id).remove();
                             $('#online_user').prepend('<div class="chat_user" data="'+value+'" id="'+id+'"><img style="cursor:pointer;" height="30" src="'+data.photo[value]+'" /><span class="online_name"><b>'+data.name[value]+'</b></span><input type="hidden" value="'+data.name[value]+'" /><img class="online_icon" src="http://localhost/online.png" /></div>');
			});
                }
	        setTimeout(onlineUser,0);
	});
}

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
