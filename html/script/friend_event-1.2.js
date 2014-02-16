$(function(){
//This complete code has beed moved to action.js,callback.js and global.js ... but not working from there
var myprofileid = $('#myprofileid_hidden').attr('value');
$.getJSON('ajax/write.php',{action:'birthday_bomb_fetch'},function(data){
callback.birthday_select(data);
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
		$('#birthday_wish_container').append('<div style="margin-top:0.8em;"><input class="prompt_positive"  type="submit" value="Wish" id="wish_ok" /><input class="prompt_negative" type="submit" value="Cancel" id="birthday_wish_close" /></div>');
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
					$('#birthday_wish_container').html('You have successfully sent the birthday wish.');
					$('.right_pointer_container').fadeOut(2000);
				}	
				});
			}	
});						
});
});