
	var ajax = (function(){
	
		function getJSON_ajax(url, param, me, callback)
		{
			$.getJSON(url, param, function(data){
				callback(me, data);
			});
		}

		function postJSON_ajax(url, param, me, callback)
		{
			$.post(url,param, function(data){
				callback(me, data);
			},'json');
		}

		return {
			getJSON_ajax : getJSON_ajax,
			postJSON_ajax : postJSON_ajax
		}	
		
	})();