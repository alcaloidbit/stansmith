
$(function(){
	var container = $('#main ul');

	var $playlist_toggler = $('.btn-toggle-playlist');
	var $playlist_container = $('div.jp-playlist');

	container.imagesLoaded(function(){
		$('.mask').fadeOut(2000);
			container.isotope({
				  itemSelector: '.item',
			  	  transitionDuration : '0.2s',
				  layoutMode: 'masonry',

				  masonry: {
						gutter: 30,
					 	isFitWidth : true
				  }
			});
	});



	var next = $('.pagination a.next');

	$(window).scroll(function(){
		if($(window).scrollTop() + $(window).height() == $(document).height()){
			//TEMP
			next.click();
		}
	})


	var loader = $('#preloader');

	/**** GET NEXT ALBUMS ( Using Json Response) ****/
	$('.pagination a.next').on('click', function(evt){
		evt.preventDefault();
		var url = $(this).attr('href');

		$.ajax({
				url: url,
				beforeSend: function(){
					loader.show();
					
				},
				complete:function(){
					var reg = /(\d)*$/i;
					var match = parseInt($('.pagination a.next').attr('href').match(reg));
					$('.pagination a').attr('href', 'http://176.31.245.123/stansmith/?controller=x&action=ajaxGetNextJson&p='+ (match+1 )+'');
				
				},
				type: 'GET',
				dataType: 'json',

				success : function(json, status){
					if($(json.theEnd)){
						loader.replaceWith('<p>No More Results, Sorry :/</p>')	
					}
				
						$(json.albums).each(function(){
							var $item = jsonToHtml(this);
							$item.imagesLoaded()
							.always( function(instance){
								
							})
							.done( function(instance){
								loader.hide();
								container.append($item);
								container.isotope('appended', $item);
							})
							.fail(function(){
								console.log('all images loaded, at  least one image is broken');
							})
							.progress(function(instance, image){
								var result = image.isLoaded ? 'loaded' : 'broken';
								console.log('image is '+ result + 'for ' + image.img.src );
							});
						})
					
				},
				done : function(){
					loader.hide();
				}
		})
	});


	function jsonToHtml(jsonitem){
		var html = $('<li class="'+jsonitem.id_artist+' item">'+
						'<div class="_thumbl"  rel="album_'+jsonitem.id+'">'+
		             				'<img src="images/'+jsonitem.images[0].id_image+jsonitem.images[0].extension+'">'+
									'<div class="caption glass">'+
										'<span class="info info-album">'+jsonitem.title+'</span>'+
										'<span class="info info-artist" data-id_artist="'+jsonitem.id_artist+'">'+jsonitem.artistName+'</span>'+
										'<button class="utils utils-right play " rel="album_'+jsonitem.id+'"><i class="md-icon md-36 md-light ">play_arrow</i></button>'+
										'<!-- <span class=" utils utils-left label label-success see" rel="album_'+jsonitem.id+'"><i class="fa-info-circle fa "></i>More</span> -->'+
									'</div>'+
						'</div>'+
				  '</li>');
		return html;
	}




	/* Filtering Albums on artist name */
	$('#wrapper').on('click', '.sel a, .info-artist', function(evt){
		evt.preventDefault();
		var id_artist = $(this).data('id_artist');
		var url = 'http://176.31.245.123/stansmith/index.php?controller=x&action=getAlbumsbyArtist';
		var data = {'id_artist': id_artist};

		$.ajax({
			url: url,
			data: data,
			type: 'GET',
			dataType: 'json',
			beforeSend: function(){
				loader.show();
				container
				.isotope('destroy')
				.empty();
			},
			success: function(json,status){

				$(json.albums).each(function(){

					var $item = jsonToHtml(this);

					$item.imagesLoaded()
					.always( function(instance){

					})
					.done( function(instance){
						container.isotope({
							 itemSelector: '.item',
						  	  transitionDuration : '0.2s',
							  layoutMode: 'masonry',

							  masonry: {
									gutter: 30,
								 	isFitWidth : true
							  }
						})
						.append($item)
						.isotope('appended', $item);

						loader.hide();

					})
					.fail(function(){
					})
					.progress(function(instance, image){
						var result = image.isLoaded ? 'loaded' : 'broken';
					});


				});
			},
			done : function(){

				console.log('ajax done');
			}
		});

	});


	$('.see-all').on('click', function(){
		container.isotope({
			filter: '*'
		})
	});


	/** Toggling Lateral Menu **/
 	$("#menu-toggle").click(function(e) {
 		$(this).toggleClass('btn-primary btn-default');
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        setTimeout(function(){
        	container.isotope()
        }, 750 );
    });


	/* Update Dom with Album Content  */
	$('body').on(  'click', '.see', function(e){

		// $(this).parent().parent().parent().addClass('hovered');
	});


	/* Get Songs Using Ajax and populate playlist  */
	$('body').on( 'click', '.play', function(e){

		var text = $(this).attr('rel');
		var match = text.match(/album_(\d+)/) // On recupere l id album

		console.log(match);
		$.ajax({
			url: 'index.php?controller=test&action=detail',
			type: 'GET',
			data: {id_album: match[1]},
			dataType: 'json',
			success : function(json, status ){
				console.log(json);
				var object = [];
				var artist = json.album.artistName;
				$.each(json.album.songs, function(i, song){
					if( null === song.meta_title || null === song.meta_artist ){
						object.push({
							title: song.title,
							artist: song.artist,
							m4a: song.path
						})
					}else{
						object.push({
					 		title: '<span class="track_number">'+song.meta_track_number+'</span>' + ' ' +song.meta_title,
					 		artist: song.meta_artist,
					 		m4a: song.path
					 	})
					 }
				});
				myPlaylist.options.playlistOptions.autoPlay = true;
				myPlaylist.setPlaylist( object );

			}
		})
	});


	function getMetaTags(songs, artist, callback){
		var object  = []; //  Javascript Array / Object
		$.each(songs, function(i, song){
			ID3.loadTags(song.path, function(){
				var tags = ID3.getAllTags(song.path);
				if(!$.isEmptyObject(tags)){
					object.push({
						title : tags.track +' '+tags.title,
						artist: tags.artist,
						m4a: song.path
					});
				}else{
					object.push({
						title: song.title,
						artist: artist,
						m4a:song.path
					});
				}
				callback(object);
			});
		});
	}

	/* Show / Hide Playlist */
	$playlist_toggler.click(function(){
		if(!$playlist_container.hasClass('visible')){
			$playlist_container.show({ duration: 600,  easing: 'easeOutCirc' }).addClass('visible');
		}else if($playlist_container.hasClass('visible')){
			$playlist_container.hide({duration : 400, easing: 'easeInCirc'}).removeClass('visible');
		}
	});

	/* Handle Back btn click, perform an ajax Call */
	$('.back').on('click', function(e){
			$('.mask').show('fast');
			e.preventDefault();
			$.ajax({
				url: 'index.php?controller=test&action=ajax',
				type: 'GET',
				dataType : 'json',
				success : function( data, status ){
					var dom = '<div class="container-fluid" id="main"><ul>';


					$.each( data['albums'], function(i, album )
					{
						dom +=  '<li class="item">'+
								 		'<div class="thumbnail" >' +
											'<a class="ajax" title="' + album.title + '"  rel="album_'+ album.id +'" >';

							if( album.images.length !== 0 )
								dom += 			'<img  src="images/' + album.images[0]['id_image'] + album.images[0]['extension'] + '" />';

								dom +=      	'<div class="caption glass" >'+
													'<span class="artist-name">' +album.title+'</span>'+
													'<span class="album-title">'+ album.artistName+'</span>'+
												'</div>'+
											'</a>'+
									'</div>' +
								'</li>';
					});


					dom += '</ul></div>';
					$('#main').replaceWith(dom);
					$(window).scrollTop(0);
					var container = $('#main');

					container.imagesLoaded( function(){
						container.masonry({
							itemSelector: '.item'
						});
					});

					$('.mask').fadeOut(1000);
				}
			})
	});

	/* instantiate Player */
	function js_audioPlayer(file,location){
		$("#jquery_jplayer_" + location).jPlayer( {
		  	ready: function () {
            $(this).jPlayer("setMedia", {
				m4a: file
	          });
	        },
	        cssSelectorAncestor: "#jp_container_" + location,
	        swfPath: "js/jQuery.jPlayer.2.3.0",
			supplied: "m4a"
	    });
	    return;
	}

	/* instantiate playlist,  and set up options  */
	myPlaylist = new jPlayerPlaylist({
						jPlayer: "#jquery_jplayer_1",
						cssSelectorAncestor: "#jp_container_1"
						}, [], {
						playlistOptions: {
							enableRemoveControls: true,
							autoPlay:false
						},

						swfPath: "js/jPlayer-2.9.0",
						supplied: "m4a, mp3, ogg",
						smoothPlayBar: true,
						keyEnabled: true,
				});


	/* removing song from playlist */
	$('.jp-playlist').delegate('.jp-playlist-item-remove', 'click', function(){
		var nbr = parseInt( $('.badge').text() );
		$('.badge').text( nbr - 1);

		nbr  = $('.jp-playlist ul li').length - 1;
		if( nbr == 0 ){
			$('.badge').hide();
			// $('.jp-title').hide();
		}
	});



	/* add song to playlist */
	$('body').delegate(  '.addtoplaylist', 'click' , function(){
			title = $(this).find('span.title').text();
			artist = $(this).attr('data-artist');
			src = $(this).attr('href');

					myPlaylist.add({
					title: title,
					artist: artist,
					m4a:  src

					});

			notify( title );
			$('.badge').text( parseInt( $('.badge').text() ) + 1 ).show();
		});


	/* notification when a song is added */
	var notify = function( title ){
		var elem = '<h2><span class="notice label label-info" >'+ title + ' successfully added to the playlist :)</span></h2>';
		$('.details').append( elem );
		setTimeout(function(){
			$('.notice').fadeOut('fast');
		}, 2000);
		$('.mask').hide('fast');
	}



	/* empty playlist */
	$('.btn-empty-playlist').click(function(){
		myPlaylist.remove();
		$('.jp-title').hide();
	});
});

/* Set Page scroll position at the top of page */
$(window).on('beforeunload', function(){
		$(window).scrollTop(0);
});

$(function(){
	$('.sidebar-nav').mCustomScrollbar({
		mouseWheel: true,
		scrollButtons: {enable:true},
		theme: "minimal-dark"  /* minimal-dark */
		// theme: "rounded-dark"  /* minimal-dark */

	});


});

/* prevent parent scrolling while scrolling playlist */
$(document).on('DOMMouseScroll mousewheel', '.Scrollable', function(ev) {
    var $this = $(this),
        scrollTop = this.scrollTop,
        scrollHeight = this.scrollHeight,
        height = $this.height(),
        delta = (ev.type == 'DOMMouseScroll' ?
            ev.originalEvent.detail * -40 :
            ev.originalEvent.wheelDelta),
        up = delta > 0;

    var prevent = function() {
        ev.stopPropagation();
        ev.preventDefault();
        ev.returnValue = false;
        return false;
    }

    if (!up && -delta > scrollHeight - height - scrollTop) {
        // Scrolling down, but this will take us past the bottom.
        $this.scrollTop(scrollHeight);
        return prevent();
    } else if (up && delta > scrollTop) {
        // Scrolling up, but this will take us past the top.
        $this.scrollTop(0);
        return prevent();
    }
});



