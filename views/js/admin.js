(function(){
	$(function(){

		$('.askdiscogs').on('click', function(e){
			e.preventDefault();
			var l = Ladda.create(this);
			l.start();
			var id_album = $(this).attr('data-id_album');
			var ajaxURI = 'http://176.31.245.123/stansmith/index.php?controller=admin&action=askdiscogsforimages';
			$.ajax({
				type: 'POST',
				url :ajaxURI,
				data : { id_album : id_album },
				dataType : 'html',
				success: function( data, status, jqXHR ){
					console.log(data);
					$('.discogs-resp').replaceWith(data);
				},
				error: function( data, status, jqXHR ){
					console.log( status );
				}
			}).always(function(){
				l.stop();
			});
			return false;
		});


		$( 'div.delegater').on( 'click', 'button.confimg',  function(e){
			e.preventDefault();
			var l = Ladda.create(this);
			l.start();
			var ajaxURI = 'http://176.31.245.123/stansmith/index.php?controller=admin&action=addAlbumCover';
			$.ajax({
				type: "POST",
				url: ajaxURI,
				data: $('#form-imgdata').serialize(),
				dataType : 'json',
				success: function( data, status, jqXHR ){
					$('div.release').prepend('<div class="img-wrapper col-lg-6"><img src="images/small/'+ data.id_image +'_small'+ data.ext +'"/></div>').fadeIn();
					$('div.discogs-resp').fadeOut().remove();
				}
			}).always(function(){l.stop();});
			return false;
		});


		$( 'div.delegater').on( 'click', 'button#changequery', function(e){
			e.preventDefault();
			$('button.close').click();
			var l = Ladda.create(this);
			l.start();
			var ajaxURI = 'http://176.31.245.123/stansmith/index.php?controller=admin&action=askdiscogsforimages';
			$.ajax({
				type: "POST",
				url : ajaxURI,
				data: $('#change_query_params').serialize(),
				dataType: 'html',
				success: function(data, status, jqXHR ){
					$('.discogs-resp').replaceWith(data);
				},
				error: function( data, status, jqXHR ){
					console.log( status );
				}
			}).always(function(){
				l.stop();
			})
			return false;
		});


		$('div.delegater').on('click', '.imguri', function(e){
				e.preventDefault();
				$('.mask').css('opacity', 1 );
				$('.ajax-load').css('display', 'block');
				var img_uri = $(this).attr('href');
           		var ajaxURI = 'http://176.31.245.123/stansmith/index.php?controller=admin&action=getImageByURI';
           		var that = $(this);
           		$.ajax({
           			type: "POST",
           			url : ajaxURI,
           			data:{ img_uri: img_uri },
           			dataType : 'json',
           			success: function( data, status, jqXHR ){
           				$('.ajax-load').css('display', 'none');
           				$('.mask').css('opacity', 0 );

           				that.parent().parent().find('.active').removeClass('active');
           				that.parent().addClass('active');
           				$('.discogs-resp .panel-heading h3').text( img_uri + data.dimension.width + 'px * '+ data.dimension.height +'px');
           				$('input[name=rawimgdata]').val(data.rawimgdata);
           				$('input[name=extension]').val(data.ext);
           				$('.effect').attr('style', 'width:' + data.dimension.width + 'px;height:'+data.dimension.height +'px;' );
           				$('.mask').attr('style', 'width:' + data.dimension.width + 'px;height:'+data.dimension.height +'px;' );
           				$('.cover-img').fadeOut().attr('src', 'data:image/'+data.ext+';base64,' + data.rawimgdata ).fadeIn();
           			}
				});
		});



		$('.panel-heading a').on('click', function(){
			$(this).find('i').toggleClass('fa-minus fa-plus');
		});

	});
})();





