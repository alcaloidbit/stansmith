

$(window).load(function(){

	$('.mask').fadeOut(2000);

	$('.container-fluid').on(  'click', '.ajax', function(e){
		e.preventDefault();
		
		var text = $(this).attr('rel');
		var match = text.match(/album_(\d+)/) // On recupere l id album
		$.ajax({
			url: 'index.php?controller=test&action=detail',
			type: 'GET',
			data: {id_album: match[1]},
			dataType: 'json',
			success : function(json, status ){
				var  dom = '<div class="row details"><img src="images/' +
				json.album.images[0].id_image+json.album.images[0].extension+'" class="img-thumbnail">' +
				'<ul class="list-unstyled songs">';
				$.each(json.album.songs, function(i, song){
					dom +='<li><a class="addtoplaylist" href="'+ song.path +'">'+ song.title +'</a></li>';
				});
				dom += '</ul></div>';

				$('#classic-use-response').replaceWith( dom );
			}
		})
	});

	$('.container-fluid').on(  'click', '.addtoplaylist', function(e){
		e.preventDefault();
		var playlist = $('.sm2-playlist-wrapper .sm2-playlist-bd');

		playlist.append('<li><a href="#removeFromPlaylist" class="remove-t"><i class="fa fa-trash-o"></i></a><a href="'+$(this).attr('href')+'" >'+
			$(this).text()+'</a></li>');

		$('.sm2-bar-ui').addClass('playlist-open');
		$('.sm2-playlist-drawer').height( $('.sm2-playlist-drawer').prop('scrollHeight') + 'px');
	});

	$('.back').on('click', function(e){
		e.preventDefault();
		$.ajax({
			url: 'index.php?controller=test&action=ajax',
			type: 'GET',
			dataType : 'json',
			success : function( data, status ){
				var dom ='<div class="albums-container row" id="classic-use-response">';
				$.each( data['albums'], function(i, album )
				{
					dom += '<div class="img-container col-xs-6 col-sm-3 col-lg-3">'+
								 '<a class="various fancybox ajax" title="' + album.title + '"  rel="album_'+ album.id +'" >';

					if( album.images.length !== 0 )
						dom += '<img  src="images/' + album.images[0]['id_image'] + album.images[0]['extension'] + '" class="img-thumbnail"/></a>';

					dom += '</a></div>' ;
				});


				dom += '</div>';
				$('.details').replaceWith(dom);

			}
		})
	});


	// $('#submitDirectory').on('submit', function(event){
	// 		event.preventDefault();	
	// 		var data = $(this).serialize();
	// 		$.ajax({
	// 			url: 'index.php?controller=admin&action=createdirectory',
	// 			type: 'POST', 
	// 			data : data,
	// 			success: function( json, status ){
					
	// 				var dom = '<div class="alert alert-success alert-dismissable">'+
 //                   '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
 //                    '<h4><i class="icon fa fa-check">Bravo! </i></h4>'+
 //                  '</div>';
 //                  var obj = $.parseJSON( json )
 //                  var path = obj.artist+'/'+obj.album;
 //                  $('#path').val( path );
 //                  $('.main').prepend( dom );
	// 			}	

	// 		});
	// 		return false;
	// });
});

