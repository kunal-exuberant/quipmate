<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
<?php require_once('../include/header.php');?>
<style type="text/css">
textarea
{   
    resize:none;
	width:35.5em;
	height:7em;
	color:gray;
	padding:5 5 5 5;
	border:2px solid #66aacc;
	border-radius:5px;
	position:relative;
	margin:0 0 0 0;
}
a{text-decoration:none;}
.college:hover{color:#990000;}
img{border:none;}
h1{font-size:14pt;margin:20 20 20 20;}
#college_name{margin:10 10 10 0;}
.alphabet{margin:2 2 2 2;padding:0px;height:35px;width:35px;border:1px solid #019ee8;}
#message_all_button{display:none;margin:2 2 10 2;padding:0px;height:35px;width:200px;border:border:1px solid #000;background:#003153;color:#fff;font-size:11pt;}
</style>
<script type="text/javascript">
$(function(){
$('.alphabet').click(function(){
$('#college_list').html('<img id="loading" src="png/loading.gif" />');
var alphabet = $(this).attr('id');
$.getJSON('ajax/write.php',{action:'college_select',alphabet:alphabet},function(data){
$('#loading').remove();
$.each(data,function(index,value){
$('#college_list').append('<div id="'+index+'" class="college" style="width:27em;color:#003399;cursor:pointer;font-size:11pt;">'+value+'</div>');
});
});
});

$('.college').live('click',function(){
$('#message_all_button').show();
$('#warning').show();
var college = ($(this).attr('id'));
$('#college_hidden').attr('value',college);
$('#college_name').html('<h1>'+$(this).html()+'</h1>');
$('#mate_list').html('<img id="loading" src="png/loading.gif" />');
$.getJSON('ajax/write.php',{action:'college_student_select',college:college},function(data){
$('#loading').remove();
$.each(data.user,function(index,value){
$('#mate_list').append('<div id="'+value.profileid+'" style="position:relative;color:#003399;width:200px;height:100px;"><a href="profile.php?id='+value.profileid+'"><img src="'+value.image+'" width="80" height="80"></a><div style="position:relative;top:-80px;left:85px;font-size:9pt;">'+value.name+'</div><div style="position:relative;top:-80px;left:85px;font-size:9pt;">Passing Year:'+value.cyear+'</div></div>');
if(value.profession != null)
{
   $('#'+value.profileid).append('<div style="position:relative;top:-80px;left:85px;font-size:9pt;">'+value.profession+'</div>');
}
if(value.company != null)
{
   $('#'+value.profileid).append('<div style="position:relative;top:-80px;left:85px;font-size:9pt;">'+value.company+'</div>');
}
if(value.status == 0 )
{
  $('#'+value.profileid).append('<div style="position:relative;top:-90px;left:215px;"><input class="add_friend" style="border:1px solid #000;background:#11648f;color:#fff;font-size:11pt;" type="submit" value="+Friend" /></div>');
}  
else if(value.status == -1 )
{
  $('#'+value.profileid).append('<div style="position:relative;top:-90px;left:215px;"><input type="submit" style="border:1px solid #000;background:#11648f;color:#fff;font-size:11pt;" value="Waiting for confirmation" /></div>');
}
else if(value.status == 1 )
{
  $('#'+value.profileid).append('<div style="position:relative;top:-90px;left:215px;"><input type="submit" style="border:1px solid #000;background:#11648f;color:#fff;font-size:11pt;" value="Accept Request" /></div>');
}
});
});

});

});
</script>
<script type="text/javascript">
$(".add_friend").live('click',function(){
var profileid = $(this).parent().parent().attr("id");
var name = "#" + profileid;
$(this).attr("value",'Inviting...');
var me = $(this);
$.get("ajax/add_friend.php",{profileid:profileid,msg:'hi'},function(data){
me.attr("value",data);
});
});
$(function(){

$('#message_all_button').click(function(){
$('#message_container').remove();
$('body').append('<div id="message_container" style="position:absolute;left:40em;top:15em;border:10px solid #557799;background:white;width:400px;height:200px;padding:5px;"></div>');
			$('#message_container').html('<div style="position:relative;color:#fff;font-size:20pt;height:30px;background:gray;padding:5px;">Write a Message</div>');
			$('#message_container').append('<div style="font-size:12pt;position:relative;padding:5px;"><textarea id="message_textarea"></textarea></div>');
			$('#message_container').append('<div style="position:absolute;left:16em;bottom:10px;"><input style="width:50px;height:25px;background:#557799;color:#fff;font-size:12pt;cursor:pointer;" type="submit" value="OK" id="message_ok" /><input style="margin-left:100px;width:60px;height:25px;background:#557799;color:#fff;font-size:12pt;cursor:pointer;" type="submit" value="CLOSE" id="message_close" /></div>');
			});	
			
			$('#message_ok').live('click',function(){
		   var message=$.trim($('#message_textarea').val());
			$('#message_textarea').val('');
			if(message !='')
			{
			$('#message_ok').hide();
			$('#message_container').html('<span>Sending...</span>');
			var college=$('#college_hidden').attr('value');
			$.getJSON('ajax/write.php',{action:'message_college',college:college,message:message},function(data){
			if(data.ack){
			$('#message_container').html('<span>The message has been sent.</span>');
				$('#message_container').fadeOut(2000);
			        }
			});	
			}  
			
			});
			$('#message_close').live('click',function(){
		      $('#message_container').remove();
				});
  
});

</script>
<div id="wrapper">
<div style="position:relative;left:100px;width:45em;top:5em;text-align:left;">
<h1>Select the first letter of college</h1>
<div id="alphabets">
<input class="alphabet" type="submit" id="a" value="A" />
<input class="alphabet" type="submit" id="b" value="B" />
<input class="alphabet" type="submit" id="c" value="C" />
<input class="alphabet" type="submit" id="d" value="D" />
<input class="alphabet" type="submit" id="e" value="E" />
<input class="alphabet" type="submit" id="f" value="F" />
<input class="alphabet" type="submit" id="g" value="G" />
<input class="alphabet" type="submit" id="h" value="H" /> 
<input class="alphabet" type="submit" id="i" value="I" />
<input class="alphabet" type="submit" id="j" value="J" />
<input class="alphabet" type="submit" id="k" value="K" />
<input class="alphabet" type="submit" id="l" value="L" />
<input class="alphabet" type="submit" id="m" value="M" />
<input class="alphabet" type="submit" id="n" value="N" />
<input class="alphabet" type="submit" id="o" value="O" />
<input class="alphabet" type="submit" id="p" value="P" />
<input class="alphabet" type="submit" id="q" value="Q" />
<input class="alphabet" type="submit" id="r" value="R" />
<input class="alphabet" type="submit" id="s" value="S" />
<input class="alphabet" type="submit" id="t" value="T" />
<input class="alphabet" type="submit" id="u" value="U" />
<input class="alphabet" type="submit" id="v" value="V" />
<input class="alphabet" type="submit" id="w" value="W" />
<input class="alphabet" type="submit" id="x" value="X" />
<input class="alphabet" type="submit" id="y" value="Y" />
<input class="alphabet" type="submit" id="z" value="Z" />
</div>
<div id="college_list" style="width:28em;">
</div>
</div>
<div style="position:absolute;left:52em;top:4em;text-align:left;">
<input type="hidden" id="college_hidden" value="" />
<div id="college_name"></div>
<input type="submit" id="message_all_button" value="Send Message To All" />
<div id="warning" style="margin-bottom:10px;display:none;color:gray;font-size:7.5pt;width:45em;">(The message will be sent to each member of this college.An email will also be sent to them.Please put legitimate content only!)</div>
<div id="mate_list" style="padding-left:20px;border-left:1px solid gray;"></div>
</div>
</div>
<?php require_once('../include/footer.php'); ?>
</body>
</html>