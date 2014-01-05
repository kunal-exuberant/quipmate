$(function(){
var profileid;
$('.viewable').live('click',function(){
	var actionid = $(this).attr('id');
	var life_is_fun = $(this).parent().children().eq(0).attr('value');
	var page = $('')
	if($(this).parent().attr('class') == 'photo_feed')
	{
		var profileid = $(this).parent().children().eq(0).attr('value');
		var actiontype = $(this).parent().children().eq(1).attr('value');
	}
	else
	{
		var profileid = $(this).parent().parent().parent().children().eq(0).attr('value');
		var actiontype = $(this).parent().parent().parent().children().eq(1).attr('value');	
	}
	if(actiontype == 5) actiontype = 6; // if it is an album, comment and exciting as if doing on a normal photo
	var file = $(this).attr('data');
	var maxw = $(window).width() - 387;
	var maxh = $(window).height() - 20;
	var myphoto = $('#myprofileimage_hidden').attr('value');
	$('body').css('overflow','hidden');
	$('body').append('<div id="bg_first" style="position:fixed;top:0em;left:0em;width:100%;height:100%;background-color:black;opacity:0.9;filter:alpha(opacity=80);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=80)"; filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=80);z-index:99;"></div>');
	$('body').append('<div id="image_con" style="background-color:#000000;position:fixed;left:0em;top:0em;height:100%;width:100%;z-index:1000;display:table;"><div id="container_for_image" style="height:'+maxh+'px;width:'+maxw+'px;display:table-cell;vertical-align:middle;padding:1em 0em 2em 0em;"><img src="thumbnail.php?file='+file+'&maxw='+maxw+'&maxh='+maxh+'"/></div><div style="text-align:left;padding:0em 0em 0em 0em;width:36em;overflow-y:auto;overflow-x:hidden;height:'+maxh+'px;float:right;background-color:#ffffff;margin:1em 1em 2em 0em;"><div data='+actionid+' id="viweable_sidebar" style="width:33.7em;padding:0.5em 2em 0em 0.5em;"><input type="hidden" value="'+profileid+'"/><input type="hidden" value="'+actiontype+'"/></div></div></div>'); 
	
	$.getJSON('ajax/write.php',{action:'action_fetch_life_is_not_always_fun',actionid:actionid,life_is_fun:life_is_fun},function(data){
	
		$.each(data.action,function(index,value){
			if(!value.page) value.page = ''; 
			
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
			
			$('#viweable_sidebar').append('<a href="profile.php?id='+value.actionby+' " ><img style="margin-right:0.7em;" class="lfloat" src ='+data.pimage[value.actionby]+ ' height="50" width="50" /></a><div class="name_50_viewable"><a class="bold" href="profile.php?id=' +value.actionby+' " >' +data.name[value.actionby]+ '</a><div style="margin:0.5em 0em;">'+value.page+'</div><div class="time_tag_json"><span onclick="'+fun+'" class="'+class_type+'" style="color:blue;">'+exciting+': </span><a href="action.php?actionid='+value.pageid+'&life_is_fun='+value.life_is_fun+'"><img src="png/clock.png" width="6" /><span class="time" data="'+value.time+'">'+time_difference(value.time)+'</span></a></div></div>');
			$('#viweable_sidebar').children().eq(3).append('<div class="likeclass_json" style="margin-top:3em;"><span id="viewable_sidebar_response" class="excited_people"></span><span class="post_pointer"></span></div>');
			
		var excited_count = 0;
		if( pos != -1)
		{
			value.excited.splice(pos, 1);
			if(value.excited.length > 1)
			{
				$('#viewable_sidebar_response').append('You, ');
			}
			else if(value.excited.length == 1)
			{
				$('#viewable_sidebar_response').append('You and ');
			}
			else
			{
				$('#viewable_sidebar_response').append('You');		
			}		
		}
		excited_count = value.excited.length - 3;
		$.each(value.excited,function(index,v){
			if(index < 3)
			{
				$('#viewable_sidebar_response').append('<a href="profile.php?id='+v+'">'+data.name[v]+'</a>');			
				if(index == value.excited.length-2 && index < 2)
				{
					$('#viewable_sidebar_response').append(' and ');
				}
				else if(value.excited.length > 2 && index != value.excited.length-2 && index < 1)
				{
					$('#viewable_sidebar_response').append(', ');
				}
				else if(index < value.excited.length-2 && index == 1)
				{
					$('#viewable_sidebar_response').append(', ');
				}
			}
			else if(excited_count == 1)
			{
				$('#viewable_sidebar_response').append(' and <a href="profile.php?id='+v+'">'+data.name[v]+'</a>');	
			}
		});		
		if(excited_count > 1)
		{
			$('#viewable_sidebar_response').append(' and ' +excited_count+ ' more');
		}
		
		if(value.comment_count > 3)
		{
			$('#viweable_sidebar').children().eq(3).append('<div class="comments_show"><input type="hidden" value="'+value.actionid_third+'" /><span class="show_all_comments" onclick="action.show_all_comments(this)" >Show all '+ value.comment_count+' comments</span></div>');
		}
		$.each(value.com,function(index,com){
		
			var comid = 'pf_'+value.actionid+'_'+ com.com_actionid;
			var exciting = 'Exciting';
			var fun = 'action.response(this)';
			if(com.com_excited_mine)
			{ 
				exciting = 'Unexciting'; 
				fun = 'action.responsed(this)';
			}  
			$('#viweable_sidebar').children().eq(3).append('<div class="cclass_json" id="'+comid+'" data="'+ com.com_actionid +'" ><a href="profile.php?id=' +com.commentby+ '" target="_parent"><img class="lfloat" src =' +data.pimage[com.commentby]+ ' height="32" width="32" /></a><div class="name_35"><div><a class="bold" href="profile.php?id=' +com.commentby+ '" target="_parent">' +data.name[com.commentby]+ '</a> '+ui.see_more(ui.get_smiley(ui.link_highlight(com.comment)))+'</div><div><a class="comment_time_json" href="action.php?actionid='+value.pageid+'&life_is_fun='+value.life_is_fun+'"><img src="png/clock.png" width="6" /><span class="time" data="'+com.com_time+'">'+time_difference(com.com_time)+'</span></a><span data=' +com.commentby+ ' class = "comment_excite_json" onclick="'+fun+'">'+exciting+'</span></div></div></div>');
		
			if(com.com_excited)
			{
				$("#"+comid).children().eq(1).children().eq(1).append('<span style="margin-left:0.5em;font-size:0.9em;cursor:pointer;" data="'+ com.com_excited +'" onclick="action.response_fetch(this)" >'+ com.com_excited +' excited</span>');
			}
			else 
			{
				$("#"+comid).children().eq(1).children().eq(1).append('<span style="margin-left:0.5em;font-size:0.9em;cursor:pointer;" data="0" class="more_excite_json" onclick="action.response_fetch(this)"></span>');
			}
			
			if(value.postby==myprofileid || com.commentby==myprofileid)
			{
				$('#viweable_sidebar').children().eq(1).append('<span onclick="ui.post_delete(this)" class="comment_setting">x</span>');
			}
		});
		
			$('#viweable_sidebar').children().eq(3).append('<div></div><div class="cclass_box" ><a href="profile.php?id=' +myprofileid+ '"><img class="lfloat" src="'+myphoto+'"  width="32" height="32"/></a><input style="margin:0em 0em 0em 0.5em;"class="commentbox" onkeydown="action.comment(this,event)" type="text" value="" placeholder="Add a comment..." /></div>'); 
		
	});
	});
	
	$('#image_con').append('<div id="image_con_close" style="position:fixed;top:0.1em;right:1.3em;color:#aaaaaa;font-size:2em;background-color:#f9f9f9;cursor:pointer;">x</div>');
});




$('#image_con_close').live('click',function(){
	$('#bg_first').remove();
	$('#image_con').remove();
	$('body').css('overflow','auto');	
});
});