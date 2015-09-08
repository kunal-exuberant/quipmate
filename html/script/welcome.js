/*************************************************** Sliding Navigation in new welcome UI ******************/
jQuery(function($) {

	$(function(){
		$('#main-slider.carousel').carousel({
			interval: 10000,
			pause: false
		});
	});
/*

 	//Ajax contact
 	var form = $('.contact-form');
 	form.submit(function () {
 		$this = $(this);
 		$.post($(this).attr('action'), function(data) {
 			$this.prev().text(data.message).fadeIn().delay(3000).fadeOut();
 		},'json');
 		return false;
 	});
 */
	//smooth scroll
	$('.navbar-nav > li').click(function(event) {
		event.preventDefault();
		var target = $(this).find('>a').prop('hash');
		$('html, body').animate({
			scrollTop: $(target).offset().top
			//scrollTop: $(target).offset().top - $(this).height()
		}, 500);
	});
$('#contact_form')[0].reset();    
$('#contact_form').ajaxForm(function(){});
$('#contact_send').live('click',function(){
   $('#contact_form').ajaxSubmit(
   {
    type:'post',
    dataType:'json',
    success:function(data)
    {
        if(data.ack == 1)
        {
            $('#contact_info').html('<div class="alert alert-success" role="alert">Thanks for contacting us ! </div>');
            $('#contact_form')[0].reset();
        }
        else
        {
            $('#contact_info').html('<div class="alert alert-warning" role="alert">'+data.error['message']+'</div>');
            console.log(data.error['message']);
        }    
    }
    
    
   }); 
    return false;
});


	//scrollspy
	$('[data-spy="scroll"]').each(function () {
		var $spy = $(this).scrollspy('refresh')
	})
   $('#login_form').ajaxForm(function(){  });
  $('#login_button').live('click', function()
   {
      $("#login_form").ajaxSubmit(
      {
         type: 'post',
         dataType: 'json',
         success:function(data)
         {
            if(data.ack == 1 )
            {
                $('#login_response').html('<div class="alert alert-success" role="alert">'+data.message+'</div>');
                window.location=data.redirect;
            }
            else   
            {
                $('#login_response').html('<div class="alert alert-warning" role="alert">'+data.error['message']+'</div>');
            }
         }
         
      }); 
      return false;  
});
});