$(function(){
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