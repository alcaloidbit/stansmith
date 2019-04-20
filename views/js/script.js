


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



$(function(){
	/* Ajax */

	var loader = "images/fbload.gif";
	$('div.artist-container h5').each(function(i){

		$(this).click(function(){
				$('#modal').show();
				$('#modal').html('').html('<img src="' + loader + '" alt="#" />');

				centerElem($('#modal img'));

				var ajaxURI = '/stansmith?controller=index&action=getAlbums';

				var output = '<ul class="albums">';
				$.getJSON( ajaxURI,{
					id_artist: $(this).attr('id')
				})
				.done(function( data ){
					c = data.length;
					for( i=0; i< c; i++)
					{
						if(data[i].images.length){
							$.each(data[i].images, function(i, image){
								output += '<li class="album"><div class="img-container" ><img src="images/small/'+
								image.id_image+'_small'+image.extension+'" class="img-polaroid" /></div>';
							})
						}else{
							output += '<li class="album">';
						}
						artist = data[i].artist;
						output += '<div class="album-content" ><h3>'+data[i].album +'</h3><ul class="songs">';
						$.each(data[i].songs, function(i, song){
							output += '<li><a href="'+(song.path)+'" class="track" data-artist ="'+artist+
										'" onclick="return false;"><span class="title">'+song.title+
										'</span><span title="Add to Playlist" class="icone-list-add"> </span></a></li>';
						})
						output +=  '</ul></div>';
					}
					output += '</ul>';

						$('#classic-use-response').html('').html(output);
						$('#modal').hide();

				});

		})
	});



	/*******************************************************************/

	$('div.togglestate').each(  function(){
			$(this).click(function(){
				element = $(this).nextAll('ul');

				if( element.hasClass('hidden')){
					element.fadeIn('fast' );
					element.removeClass('hidden');
				}
				else{
					element.fadeOut('fast');
					element.addClass('hidden');
				}
		});
	});


	/*******************************************************************/




	myPlaylist = new jPlayerPlaylist({
				jPlayer: "#jquery_jplayer_1",
				cssSelectorAncestor: "#jp_container_1"
			}, [], {
					playlistOptions: {
					enableRemoveControls: true,
					autoPlay:true
					},
					swfPath: "js/jQuery.jPlayer.2.3.0",
					supplied: "m4a",
					smoothPlayBar: true,
					keyEnabled: true,
				});


$('body').delegate( 'span.icone-list-add', 'hover', function(){

				console.log($(this));
				$('span.icone-list-add').tooltipster({
					animation: 'fade',
					position: 'bottom',
					arrow: false,
					delay: 10
				});
	});
	$('body').delegate( 'span.icone-list-add','click' , function(){

			title = $(this).parent().find('span.title').text();
			artist = $(this).parent().attr('data-artist');
			console.log(artist);
			src = $(this).parent().attr('href');
		console.log(src);
					myPlaylist.add({
					title: title,
					artist: artist,
					m4a:  src,
					autoPlay: false
					});
		});

	$('body').delegate('.img-container img', 'click', function(){
			$(this).parent().next('.album-content').slideToggle();
		})

/*******************************************************************/

	$('.btn-toggle-playlist').click(function(){
		$('div.jp-playlist ul').slideToggle()
		if($(this).hasClass('btn-inverse')){
			$(this).removeClass('btn-inverse');
			$(this).attr('title', 'Show Playlist') ;

		}else{
			$(this).addClass('btn-inverse');
			$(this).attr('title', 'Hide Playlist') ;
		}
	});

	$('.btn-empty-playlist').click(function(){
		myPlaylist.remove();
		$('.jp-title').hide();
	});



	$('.sidebar .wrapper').mCustomScrollbar({
				mouseWheel: true,
				scrollButtons: {enable:true}

	});
	$('#mCSB_1').removeClass('mCS-light').addClass('mCS-dark-thick');
});


