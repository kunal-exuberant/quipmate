$(function(){

	$('#search_button_header').click(function(){
		
		var q = $('#to').attr('value');
		var filter = $('#search_filter_hidden').attr('value');
		window.location = 'search.php?q='+q+'&filter='+filter;
	    return false;
	});

       var request = [],i;
	$('body').append('<div id="search_container"></div>');
	$('#search_container').css('left',$('#search_form').position().left+78.2+'px');
	$(window).resize(function(){
		$('#search_container').css('left',$('#search_form').position().left+78.2+'px');
	});
	
	$('#to').focus(function(){
		$('.search_items').show();
	}); 
			var q = $.trim($('#to').attr('value'));
	$('#to').bind('keyup mousedown input',function(){
		if(q != $.trim($('#to').attr('value')))
		{ 
			for(i = 0; i < request.length; i++) 
			{
				request[i].abort();
			}
			q = $.trim($('#to').attr('value'));
			request.push($.getJSON('ajax/write.php',{action:'search_people',q:q},function(data){
				
				var global_name = JSON.parse($('#session_name_hidden').attr('value'));
				var global_pimage = JSON.parse($('#session_pimage_hidden').attr('value'));
				$('#session_name_hidden').attr('value', JSON.stringify($.extend(global_name, data.name)));
				$('#session_pimage_hidden').attr('value', JSON.stringify($.extend(global_pimage, data.pimage)));
				global_name = JSON.parse($('#session_name_hidden').attr('value'));
				global_pimage = JSON.parse($('#session_pimage_hidden').attr('value'));
				
							$('#search_container').html('');
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
								$('#search_'+index).remove();	
								$('#search_container').append('<div class="search_items container_50" id="search_'+index+'" data="'+index+'"><a href="profile.php?id='+index+'"><img class="lfloat" src='+global_pimage[index]+' width="50" height="50" /></a><div class="name_50"><a class="bold" href="profile.php?id='+index+'">'+global_name[index]+'</a></div></div>');
								$('.search_items:first').css('background','#4C66A4');
								$('.search_items:first .name_50 a').css('color','white');
								count++;
							}

						}
					}
					else
					{
						if((count < 9) && (value.toLowerCase().search('^'+q.toLowerCase()) != -1)) 
						{
								$('#search_'+index).remove();	
								$('#search_container').append('<div class="search_items container_50" id="search_'+index+'" data="'+index+'"><a href="profile.php?id='+index+'"><img class="lfloat" src='+global_pimage[index]+' width="50" height="50" /></a><div class="name_50"><a class="bold" href="profile.php?id='+index+'">'+global_name[index]+'</a></div></div>');
								$('.search_items:first').css('background','#4C66A4');
								$('.search_items:first .name_50 a').css('color','white');
								count++;
						}
					}	
				}		
			});
				
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
								$('#search_'+index).remove();	
								$('#search_container').append('<div class="search_items container_50" id="search_'+index+'" data="'+index+'"><a href="profile.php?id='+index+'"><img class="lfloat" src='+global_pimage[index]+' width="50" height="50" /></a><div class="name_50"><a class="bold" href="profile.php?id='+index+'">'+global_name[index]+'</a></div></div>');
								$('.search_items:first').css('background','#4C66A4');
								$('.search_items:first .name_50 a').css('color','white');
								count++;
							}

						}
					}
					else
					{
						if((count < 9) && (value.toLowerCase().search('^'+q.toLowerCase()) != -1)) 
						{
								$('#search_'+index).remove();	
								$('#search_container').append('<div class="search_items container_50" id="search_'+index+'" data="'+index+'"><a href="profile.php?id='+index+'"><img class="lfloat" src='+global_pimage[index]+' width="50" height="50" /></a><div class="name_50"><a class="bold" href="profile.php?id='+index+'">'+global_name[index]+'</a></div></div>');
								$('.search_items:first').css('background','#4C66A4');
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
		else if($.trim($('#to').attr('value'))== '')
		{
			$('#search_container').html('<div class="search_items container_50" data="people"><img class="lfloat" src="http://profile-1.qmcdn.net/male.png" width="50" height="50" /><div class="name_50"><a class="bold">Search People</a></div></div><div class="search_items container_50" data="group"><img class="lfloat" src="http://icon.qmcdn.net/group.png" width="50" height="50" /><div class="name_50"><a class="bold">Search Group</a></div></div><div class="search_items container_50" data="skill"><img class="lfloat" src="http://icon.qmcdn.net/skill.png" width="50" height="50" /><div class="name_50"><a class="bold">Search Skills</a></div></div><div class="search_items container_50" data="event"><img class="lfloat" src="http://icon.qmcdn.net/event.png" width="50" height="50" /><div class="name_50"><a class="bold">Search Event</a></div></div><div class="search_items container_50" data="post"><img class="lfloat" src="http://icon.qmcdn.net/post_icon.png" width="50" height="50" /><div class="name_50"><a class="bold">Search Post</a></div></div>');
		}
	});
	
		$('#search_container').keydown(function(){
			console.log("cool");
		});
	
	
	$('.search_items').live('click',function(){
		if($(this).attr('data') == 'group')
		{
			window.location = "/search.php?filter=group";
		}
		else if($(this).attr('data') == 'event')
		{
			window.location = "/search.php?filter=event";
		}
		else if($(this).attr('data') == 'skill')
		{
			window.location = "/search.php?filter=skill";
		}
		else if($(this).attr('data') == 'post')
		{
			window.location = "/search.php?filter=post";
		}
		else if($(this).attr('data') == 'comment')
		{
			window.location = "/search.php?filter=comment";
		}
		else if($(this).attr('data') == 'people')
		{
			window.location = "/search.php?filter=people";
		}
		else
		{
			window.location = "/profile.php?id="+$(this).attr('data');
		}
	});

	$('#center, #left, #right').click(function(){
		$('.search_items').hide();
	}); 

	$('.search_items').live('mouseover',function(){
		$(this).css('background','#4C66A4');
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
	
	
});