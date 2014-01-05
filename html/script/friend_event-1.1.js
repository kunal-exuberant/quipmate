$(function(){
var myprofileid = $('#myprofileid_hidden').attr('value');
$.getJSON('ajax/write.php',{action:'birthday_bomb_fetch'},function(data){
if(data)
{
	var count = 0, upcoming_count = 0;
	$.each(data.action,function(index,value){
	var birthday = new Date(value.birthday * 1000);
	var today =  new Date();
	birthday = birthday.toString();
	today = today.toString();
	var bday = birthday.substring(4,birthday.length-45);
	var tday = today.substring(4,today.length-45);
	if(tday == bday)
	{
		$('#birthday_today').append('<div class="container_32_35" id="'+value.profileid+'"><input type="hidden" value="'+value.profileid+'" /><input type="hidden" value="'+value.b+'" /><input type="hidden" value="'+value.pageid+'" /><div><a style="color:#336699;" href="profile.php?id='+value.profileid+'&pl=diary"><img class="lfloat" src="'+data.pimage[value.profileid]+'" height="35" width="32" /></a></div><div class="name_32"><a style="color:#336699;font-weight:bold;" href="profile.php?id='+value.profileid+'&pl=diary">'+data.name[value.profileid]+'</a></div></div>');
		if(value.bomb_status)
		{
			$('#'+value.profileid).append('<div class="name_32">birthday-bomb<span class="birthday_bomb_count" title="Number of people who birthday-bombed">' +value.bomb_count+'</span></div>');
		}
		else
		{
			$('#'+value.profileid).append('<div class="birthday_bomb name_32" style="cursor:pointer;"  title="Click to add a birthday wish">+birthday-bomb<span class="birthday_bomb_count" title="Number of people who birthday-bombed">' +value.bomb_count+'</span></div>');
		}
		count++;
	}
	else
	{
		$('#friend_event').append('<div class="container_32_35"><a style="color:#336699;" href="profile.php?id='+value.profileid+'&pl=diary"><img class="lfloat" src="'+data.pimage[value.profileid]+'" height="35" width="32" /></a><div class="name_32"><a style="color:#336699;font-weight:bold;" href="profile.php?id='+value.profileid+'&pl=diary">'+data.name[value.profileid]+'</a><div>'+bday+'</div></div></div>');
		upcoming_count = 1;
	}
	});
	if(count)
	{
		$('#birthday_today').prepend('<div class="subtitle">Birthday Today('+count+')</div>');
	}
	if(upcoming_count)
	{
		$('#friend_event').prepend('<div class="subtitle">Upcoming Birthdays<span id="bday_more" style="float:right;cursor:pointer;font-size:.8em;margin:0.3em 1.5em 0 0;color:#336688;">More</span></div>');
	}
}	
else
{
	$('#friend_event').remove();
}
});

$('#bday_more').live('click',function(){
location.hash = '/birthday';
$.getJSON('ajax/write.php',{action:'birthday_select_all'},function(data){
$('#center').html('<div class="right_item" ><div class="subtitle" style="">Friend\'s Birthday</div></div>');
$('#center').append('<table></table>');
var i = 0;
$.each(data.event,function(index,value){
if(i%4==0)
{
	$('table').append('<tr></tr>');
}
$('tr:last').append('<td style="color:blue;padding:2em;"><a style="color:#336699;" href="profile.php?id='+value.profileid+'&pl=diary"><img class="lfloat" src="'+data.pimage[value.profileid]+'" height="60" width="60" /></a><br /><a style="color:#336699;" href="profile.php?id='+value.profileid+'&pl=diary">'+data.name[value.profileid]+'<br />'+value.birthday+' </a></td>');
i++;
});
}); 
});

var date;
var pageid;

$(window).resize(function(){

	//$('.right_pointer_container').css('top',$(this).parent().position().top+50+'px');
	$('.right_pointer_container').css('left',$('#search_form').position().left+285+'px');
});

$('.birthday_bomb').live('click',function(){ 
profileid = $(this).parent().children().eq(0).attr('value');
date = $(this).parent().children().eq(1).attr('value');
pageid = $(this).parent().children().eq(2).attr('value');
		$('.right_pointer_container').remove();
		$('body').append('<div class="right_pointer_container"><div class="right_item_pointer"></div></div>');
			$('.right_pointer_container').css('top',$(this).parent().position().top+50+'px');
			$('.right_pointer_container').css('left',$('#search_form').position().left+285+'px');			
			$('.right_pointer_container').append('<div id="birthday_wish_container"><input type="hidden" id="birthday_wish_profileid_hidden" value=""/></div>');
			$('#birthday_wish_container').append('<div class="right_pointer_title">Send Birthday Wish with Birthday Bomb</div>');
		$('#birthday_wish_container').append('<div style="margin-top:1em;"><input style="padding:0.5em;height:1.4em;width:26em;" id="birthday_wish_box" type="text" placeholder="Write birthday wish"/></div>');
		$('#birthday_wish_container').append('<div style="margin-top:0.8em;"><input style="width:6em;height:2em;background:#336699;color:#ffffff;cursor:pointer;" type="submit" value="Wish" id="wish_ok" /><input style="margin-left:100px;width:6em;height:2em;background:#336699;color:#fff;cursor:pointer;" type="submit" value="Cancel" id="birthday_wish_close" /></div>');
		$('#birthday_wish_box').focus();
$('#birthday_wish_close').live('click',function(){
		      $('.right_pointer_container').remove();
			});		

$('#wish_ok').live('click',function(){
		var wish = $('#birthday_wish_box').val();
			if(wish !='')
			{
				$('#wish_ok').hide();
				$('#birthday_wish_container').html('<span>Wishing...</span>');
				$.getJSON('ajax/write.php',{action:'birthday_bomb',profileid:profileid,wish:wish,date:date},function(data){
				if($.trim(data)==1)
				{
					$('#birthday_wish_container').html('You have successfully sent the birthday wish along with the birthday bomb.');
					$('.right_pointer_container').fadeOut(2000);
				}	
				});
			}	
});						
});
});