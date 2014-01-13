$(function(){

	$(window).resize(function(){
		var container_value = $('#notice_container').attr('value');
		if(container_value == 'notice')
		{
			$('#notice_container').css('left',$('#search_form').position().left+416+'px');
		}
		else if (container_value == 'message')
		{
			$('#notice_container').css('left',$('#search_form').position().left+382+'px');
		}
		else if (container_value == 'fr_missu_ei')
		{
			$('#notice_container').css('left',$('#search_form').position().left+345+'px');
		}
		$('#account').css('left',$('#search_form').position().left+670+'px'); 
	});
		myprofileid = $('#myprofileid_hidden').attr('value');
		var nflag = 1;
		var notice_start = 0;
		var notice_load = true;
		$('#center, #right , #left').click(function()
		{
			if(nflag==0)
			{
				$('#notice_container').remove();
				$('.bg_hide_cover').remove();
				nflag = 1;
			}
		});
	
$('.seeall').live('click',function(){
	window.location = "/?hl=notice_all";
});

$('.message_seeall').live('click',function(){
	window.location = "/?hl=inbox";
});

$('.notice_drop').live('click',function(){
var life_is_fun = $(this).children().eq(0).attr('value');
var actionid = $(this).children().eq(0).attr('id');
window.location = 'action.php?actionid='+actionid+'&life_is_fun='+life_is_fun;
}); 


function notice_scroll()
{ 
	if($('#text').get(0).scrollTop > $('#text').get(0).scrollHeight * 0.1 && notice_load)
	{
		notice_load = false;
		$.getJSON('ajax/write.php',{action:'notice_fetch',start:notice_start},function(data){
			notice_start += 10;
			notice_load = true;
			deploy.notice_deploy(data, '#text');
		});
	}
}


});

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