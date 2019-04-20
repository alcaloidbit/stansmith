(function(){


	$('.songs li').each(function(){
		$(this).on('click', function(e){
			e.preventDefault();
			var item = $(this).find('a');
			// alert(item);


		});
	});

})();