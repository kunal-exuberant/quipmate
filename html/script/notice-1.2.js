$(function(){
// Content of this file are no longer in use . Please delete this file from git too .	

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


});

