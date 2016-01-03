$(function(){
	$(window).resize(function(e){
		if($(this).width() > 760){
			$('.list-collapse').each(function(){
				$(this).show();
			})
		}
	})
})
