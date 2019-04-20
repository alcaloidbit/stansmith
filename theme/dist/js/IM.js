
$(function(){
	$('#sendIM').submit(function(evt){
			evt.preventDefault()
			var $that = $(this);
			var data  = $that.serialize();
			var $target = $('.direct-chat-messages');

			$.ajax({
				url: $(this).attr('action'),
				data: data,
				type: 'POST',
				dataType: 'json',
				success : function(result, status ){
					$target.append(createMsg(result));
					$that.find('input:text').val('');

				}
			});
	});


	/**
	 * TODO: Handle user image AND MSG DIRECTION
	 */
	function createMsg( message )
	{
		// console.log(message);
		var img;
		switch(message.pseudo){
			case 'fred':
				img = 'user2-160x160.jpg';
			break;
			case 'patrick':
				img ='user3-160x160.jpg';
			break;
			case 'roger':
				img = 'user4-200x200.jpg'
			break;

		}
		var direction = message.direction || '';
			var result = '<div id="'+message.id_message+'" class="direct-chat-msg '+direction+'">' +
                '<div class="direct-chat-info clearfix">'+
                    '<span class="direct-chat-name pull-left">'+message.pseudo+'</span>'+
                    '<span class="direct-chat-timestamp pull-right">'+message.date_add+'</span>'+
                  '</div>'+
                  '<!-- /.direct-chat-info -->'+
                  '<img class="direct-chat-img" src="theme/dist/img/'+img+'" alt="Message User Image"><!-- /.direct-chat-img -->'+
                  '<div class="direct-chat-text">'+
                    	message.msg+
                  '</div>'+
                '</div>';

            return result;
	}

	setInterval(function(){
		var $target = $('.direct-chat-messages');
		var html = '';
		var id_message = $('.direct-chat-msg:last-child').attr('id');
	// console.log(id_message);
		$.ajax({
			url: 'http://176.31.245.123/stansmith/?controller=admin&action=getLastMessages&ajax=true',
			data: {'id_message' : id_message},
			type: 'GET',
			dataType: 'json',
			success: function(results, status){
				$(results).each(function(i){
					// console.log(this);
					$target.append(	createMsg(this) );
				});
			}
		});
	}, 10000);
});
