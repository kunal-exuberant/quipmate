$(function()
{
	var profileid = $('#profileid_hidden').attr('value');
	var myprofileid = $('#myprofileid_hidden').attr('value');
	var myphoto = $('#myprofileimage_hidden').attr('value');
	var myname = $('#myprofilename_hidden').attr('value');


$('#status_link').click(function(){
	ui.upload_default_state();
	$('#status_box').focus();
});		

$('#question_link').click(function(){
      $('#uploader').html('<textarea id="question_box" placeholder="Ask your question"/></textarea><input id="question_button" type="submit" value="Ask" onclick="action.question_button(this)"><div class="option_container"><input type="text" placeholder="+Add option" value="" class="option_add" onkeydown="action.option_add(this,event)"><div>'); 
	$('#question_box').focus();
});	

	var action = 'photo_upload';
	var page = $('#page_hidden').attr('value');
	if(page == 'event_json')
	{
		action = 'event_photo_upload';						
	}
	else if(page == 'group_json')
	{
		action = 'group_photo_upload';						
	} 	

$('#photo_link').live('click',function(){
		ui.file_upload(profileid, action);
});  

$('#moment_link').live('click',function(){
	ui.album_upload(profileid);
});


$('.video_play').live('click',function(){

	var videoid = $(this).parent().children().eq(0).attr('value');
	$('body').append('<div id="video_shadow" style="position:fixed;top:0em;left:0em;width:100%;height:100%;background-color:#eeeeee;z-index:99999;"></div>');
	$('body').append('<iframe id="video_playing" style="position:fixed;top:8em;left:30%;top:10%;z-index:999999" width="400" height="300" src="http://www.youtube.com/embed/'+videoid+'?autoplay=1" frameborder="0"></iframe>');
	console.log("playing") 
});

$('#video_shadow').live('click',function(){
	
	$(this).remove();
	$('#video_playing').remove();

});


     $('#blog_publish_form').ajaxForm(function() { 
            });  
		$('#blog_publish').live('click', function()
		{
			$(this).remove();
			$("#photo_preview").html('<img src="http://icon.qmcdn.net/upload.gif" alt="Uploading...."/>');
			$("#blog_publish_form").ajaxSubmit(
			{
				type:'json',
				success: function(response){
				var data = $.parseJSON(response);	
					if(data.ack == 1)
					{	
						var url = 'action.php?actionid='+data.actionid+'&life_is_fun='+data.life_is_fun;
						window.location  = url;
					}
					else if(data.ack == '2')
					{
						$('#photo_preview').html('Unable to upload image. Please try again.');
					}
					else if(data.ack == '3')
					{
						$('#photo_preview').html('Image size is more than 10Mb. Please compress this image and try again.');
					}
					else if(data.ack == '4')
					{
						$('#photo_preview').html('Please upload an image of jpg/jpeg, png, gif, bmp type only. Please change the image type and try again.');
					}
					else if(data.ack == '5')
					{
						$('#photo_preview').html('Please chose a photo to upload');
					}						
				}
			});
			return false;
		}); 


     $('#pform').ajaxForm(function() { 
            });  
		$('#photo_upload_button').live('click', function()
		{
			$(this).remove();
			$("#photo_preview").html('<img src="http://icon.qmcdn.net/upload.gif" alt="Uploading...."/>');
			$("#pform").ajaxSubmit(
			{
				type:'json',
				success: function(response){
				var data = $.parseJSON(response);
					if(data.ack == '1')
					{	
						var postid = $('#'+dom_id);
						var file = data.file; 
						var myprofileid = $('#myprofileid_hidden').attr('value');
						var profileid = $('#profileid_hidden').attr('value');						
						$('#prev').prepend('<div id="nf_post_'+data.actionid+'" data="'+data.actionid+'" class="nf_post"><div class="name_50"></div><div data=' +data.actionid+ ' class="pageclass_json"><input type="hidden" value=' +profileid+ ' /><input type="hidden" value="6"/><a href="profile.php?id=' +myprofileid+' "><img class="lfloat" src =' +myphoto+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +myprofileid+' " >' +myname+ '</a><div><input type="hidden" value="'+data.life_is_fun+'"/><div style="margin:0.5em 0em;">'+data.page+'</div></div></div>');
						ui.response_comment('#nf_post_'+data.actionid, data.actionid, data.life_is_fun, data.time, myprofileid, myphoto);
						if(data.actiontype == 6 || data.actiontype == 306 || data.actiontype == 406)
						{
							$('#nf_post_'+data.actionid).children().eq(1).children().eq(3).children().eq(1).append('<img src ="thumbnail.php?file='+file+'&maxw=368&maxh=400" style="max-width:33.5em;margin-bottom:1em;cursor:pointer;border:0.1em solid #aaaaaa;" data="'+file+'" class="viewable" id="'+data.actionid+' " />');
						}
						else if(data.actiontype == 2600 || data.actiontype == 326 || data.actiontype == 426)
						{
							$('#nf_post_'+data.actionid).children().eq(1).children().eq(3).children().eq(1).append('<a target="_blank" data="'+data.file+'" href="'+data.file+'">'+data.caption+'</a>');
						}
						else if(data.actiontype == 2500  || data.actiontype == 325 || data.actiontype == 425)
						{
							$('#nf_post_'+data.actionid).children().eq(1).children().eq(3).children().eq(1).append('<div id="video_'+data.actionid+'">');
							jwplayer("video_"+data.actionid).setup({file:data.file,title:data.page,width: "100%",aspectratio: "16:9",fallback:"false",primary:"flash"});
						}						
						ui.upload_default_state();
					}
					else
					{
						if(data.ack == '2')
						{
							ui.popup_error_prompt('Unable to upload image. Please try again.');
						}
						else if(data.ack == '3')
						{
							ui.popup_error_prompt('Image size is more than 10Mb. Please compress this image and try again.');
						}
						else if(data.ack == '4')
						{
							ui.popup_error_prompt('Please upload an image of jpg/jpeg, png, gif, bmp type only. Please change the image type and try again.');
						}
						else if(data.ack == '5')
						{
							ui.popup_error_prompt('Please chose a photo to upload');
						}
						ui.file_upload(profileid, action);
					}					
				}
			});
			return false;
		}); 
		
		
		var num = -1;
		$('.mom').live('change',function(){
		$(this).removeClass();
		$("#moment_photo_browser").append("<div><input class='mom' size='40' type='file' name='photo_box[]'></div>");
		num++;
		$("#moment_photo_count").attr("value",num);
		});
		
		$('#moment_name').live('focus',function(){
			if($(this).attr('value')=="Enter album name")
			{
				$(this).attr('value','');
			}
		});
		
		$('#mform').ajaxForm(function() {
            });  
		$('#moment_upload_button').live('click', function()
		{
			var moment_name = $.trim($('#moment_name').attr('value'));
				$("#moment_preview").html('<img src="http://icon.qmcdn.net/upload.gif" alt="Uploading...."/>');
				$("#mform").ajaxSubmit(
				{
					type:'json',
					success: function(response){
						var data = $.parseJSON(response);
						var dom_id = 'nf_post_'+data.actionid;
							$('#prev').prepend('<div class="nf_post" data="'+data.actionid+'" id="'+dom_id+'"><div class="name_50"></div><div data=' +data.actionid+ ' class="pageclass_json"><input type="hidden" value=' +profileid+ ' /><input type="hidden" value="5"/><a href="profile.php?id='+myprofileid+'"><img class="lfloat" src =' +myphoto+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id=' +myprofileid+' " >' +myname+ '</a> added '+data.count+' photo to the album '+data.mname+'<div class="pclass_json"><div>'+data.desc+'</div></div></div>');
							ui.response_comment('#nf_post_'+data.actionid, data.actionid, data.life_is_fun, data.time, myprofileid, myphoto);
							var file = data.photo;
							$.each(data.photo,function(i,v)
							{       
								var f = v.file;  
								$('#'+dom_id).children().eq(1).children().eq(3).children().eq(1).append('<img class="viewable" data="'+f+'"src ="thumbnail.php?file='+f+'&maxh=150&maxw=150" style="margin-bottom:1.5em;cursor:pointer;border:1px solid #f6f6f6;padding:.3em;" class="thumb" id="'+v.actionid+' " />');
							});							
							ui.upload_default_state();
					}
				});
			return false;
		}); 
		
var executed = false;
$('#status_box').live('focus',function(){
    $('#uploader').html('<textarea id="link_box" placeholder="What \'s going in your life?"/></textarea><input id="link_button" type="submit" value="Share">'); 
if(!executed)
{
    executed = true;
	var i = 0, request = [],actiontype=1, video, meta, path, title, host, src = [],	thumb_index=0,link;
			var text_change = $.trim($('#link_box').val());
		$('#link_box').live('keyup mousedown input',function(e){
		if(text_change != $.trim($('#link_box').val()))
		{
			for(i = 0; i < request.length; i++)
			{
				request[i].abort();
			}
			text_change = $.trim($('#link_box').val());
			link = $.trim($('#link_box').val());
			request.push($.getJSON('ajax/write.php',{action:'link_details_fetch',link:link},function(data){
				actiontype = data.actiontype;
				video = data.video;
				meta = data.meta;
				path = data.path;
				title = data.title;
				host = data.host;
				src = data.src;
			    link = data.link;
			if(actiontype == 1600)
			{
				$('#link_callback').remove();
				$('#uploader').append('<div id="link_callback" style="margin:1em;height:auto;width:48em;"></div>');
				if(video)
				{
					$('#link_callback').html('<iframe width="400" height="300" src="http://www.youtube.com/embed/'+path+'" frameborder="0"></iframe><div style="display:block;margin:1em 0em 0em 1em;">'+title+'<br /><a href="'+host+'">'+host+'</a><br />'+meta+'</div><div style="clear:left;"></div>');
				}
				else
				{
					$('#link_callback').html('<div id="link_thumb_container" style="float:left;margin-right:1em;"><img style="max-height:25em;max-width:25em;" src="'+src[thumb_index]+'" ></div><div style="display:block;margin:1em 0em 0em 1em;">'+title+'<br /><a href="'+host+'">'+host+'</a><br />'+meta+'</div><div style="clear:left;"></div>');
					$('#link_callback').append('<input type="submit" id="thumb_prev" title ="select previous thumbnail" style="cursor:pointer;width:1.5em;height:1.5em;background:#336699;color:white;font-weight:bold;" value="<"><input type="submit" id="thumb_next" title ="select next thumbnail" style="margin-left:2em;cursor:pointer;width:1.5em;height:1.5em;background:#336699;color:white;font-weight:bold;" value=">">');
				}
			
				$('#thumb_next').live('click',function(){
					thumb_index++;
					$('#link_thumb_container').html('<img style="max-height:25em;max-width:25em;" src="'+src[thumb_index]+'" >');
				});
				
				$('#thumb_prev').live('click',function(){
					thumb_index--;
					$('#link_thumb_container').html('<img style="max-height:25em;max-width:25em;" src="'+src[thumb_index]+'" >');
				});
			}
		}));
		}
	});	
	
			var myprofileid = $('#myprofileid_hiddden').attr('value');
			var profileid = $('#profileid_hidden').val();
			var myphoto = $('#myprofileimage_hidden').attr('value');
			var myname = $('#myprofilename_hidden').attr('value');
		
			$('#link_button').live('click',function(){
			$(this).hide();
			if(actiontype == 1)
			{
				var profileid = $('#profileid_hidden').val();
				var entry = $('#link_box').val();
				if(entry != "")
				{
					$('#link_box').html('');
					var page = $('#page_hidden').attr('value');
					var action = 'post_status';
					if(page == 'news_json' || page == 'profile_json')
					{
						action = 'post_status';
					}
					else if(page == 'group_json')
					{
						action = 'group_status';
					}
					else if(page == 'event_json')
					{
						action = 'event_status';						
					}	
					$.getJSON('ajax/write.php',{action:action,profileid:profileid,page:entry},function(data){
					if(data.ack)
					{
						$('#prev').prepend('<div class="nf_post" data="'+data.actionid+'" id="nf_post_'+data.actionid+'"><div class="name_50"></div><div data='+data.actionid+' class="pageclass_json"><input type="hidden" value=' +profileid+ ' /> <input type="hidden" value="'+actiontype+'"/><a href="profile.php?id='+myprofileid+'"><img class="lfloat" src =' +myphoto+ ' height="50" width="50" /></a><div class="name_50"><a class="bold" href="profile.php?id='+myprofileid+'">'+myname+'</a><div class="pclass_json"><pre>'+ui.see_more(ui.get_smiley(ui.link_highlight(data.page)))+'</pre></div></div>');
						ui.response_comment('#nf_post_'+data.actionid, data.actionid, data.life_is_fun, data.time, myprofileid, myphoto);
					}

						 ui.upload_default_state();
					});	
				}
			}
			else if(actiontype == 1600)
			{
				var file = '';		
				if(video)
				{
					file = '';
				}
				else
				{
					file = src[thumb_index];
					if(src[thumb_index] === undefined)
						file = '';	
				}
				var profileid = $('#profileid_hidden').val();
				var page = $('#link_box').val();
				$('#link_box').html('')
				if(meta === undefined)
					meta = '';
				var action = 'post_link';
                var ppage = $('#page_hidden').attr('value'); 				
				if(ppage == 'news_json' || ppage == 'profile_json')
				{
					action = 'post_link';
				}
				else if(ppage == 'group_json')
				{
					action = 'group_post_link';
				}
				else if(ppage == 'event_json')
				{
					action = 'event_post_link';						
				}
				$.getJSON('ajax/write.php',{action:action,profileid:profileid,title:title,link:link,meta:meta,page:page,file:file},function(data){
					if(data.ack)
					{
						$('#prev').prepend('<div class="nf_post" data="'+data.actionid+'" id="nf_post_'+data.actionid+'"><div class="name_50"></div><div data='+data.actionid+' class="pageclass_json"><input type="hidden" value=' +profileid+ ' /> <input type="hidden" value="'+actiontype+'"/><a href="profile.php?id='+myprofileid+'"><img class="lfloat" src =' +myphoto+ ' height="50" width="50" /></a><div class="name_50"><div><a class="bold" href="profile.php?id='+myprofileid+'">'+myname+'</a> shared <a href="'+link+'">'+title+'</a></div><div style="position:relative;"></div></div>');
						ui.response_comment('#nf_post_'+data.actionid, data.actionid, data.life_is_fun, data.time, myprofileid, myphoto);
						if(video)
						{ 
							$('#nf_post_'+data.actionid).children().eq(1).children().eq(3).children().eq(1).append('<input type="hidden" value="'+path+'" /><img class="video_play lfloat" style="margin:0em 1em 1em 0em;cursor:pointer;" src="http://img.youtube.com/vi/'+path+'/default.jpg" /><img class="video_play" style="position:absolute;left:4em;top:3em;cursor:pointer;" src="http://icon.qmcdn.net/video_play_icon.png" /><div style="margin:2em 0em 0em 0em;"><div>'+title+'</div><a href="'+host+'" target="_blank">'+host+'</a><div>'+meta+'</div><div>'+ui.see_more(ui.get_smiley(ui.link_highlight(page)))+'</div></div><br style= "clear:both;"/></div>');
						} 
						else
						{
							$('#nf_post_'+data.actionid).children().eq(1).children().eq(3).children().eq(1).append('<img class="lfloat" style="max-height:8.2em;max-width:11em;margin-right:1em;" src="'+file+'" ><div style="margin:2em 0em 0em 0em;">'+title+'<br /><a href="'+host+'"  target="_blank">'+host+'</a><br />'+meta+'<br />'+ui.see_more(ui.get_smiley(ui.link_highlight(data.page)))+'</div><div style="clear:left;"></div>');
						}
					}
					 ui.upload_default_state();
					$('#link_callback').remove();
				
				});	

			}
			});
}		
}); // option link closes

});