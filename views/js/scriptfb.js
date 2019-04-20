
function centerElem( element )
{
	var viewportwidth = $(window).width();
	var viewportheight = $(window).height();
	var top_ = ( viewportheight / 2) - ( element.height() / 2 );
	var left_ = ( viewportwidth / 2) - ( element.width() / 2 );
	element.css({position: 'fixed', top: top_, left :left_});
}


$(function(){
	centerElem($('#loader'));
});

window.onload = function(){
	$('#modal').fadeOut();
};


$(function(){
	$('.fancybox').on('click', function(){
		var text = $(this).attr('rel');
		var match = text.match(/album_(\d+)/) // On recupere l id album

			$.ajax({
				type: "GET",
				url: "/stansmith/?controller=index&action=getAlbum",
				data: { id_album : match[1] },
				dataType: "json",
				success: function( results ){

					output = '<div class="album-content" >';
					output += '<h1>' + results[0].album + ' ' +results[0].artist+ '</h1>';
					output += '<img src="images/' + results[0].images[0].id_image + results[0].images[0].extension +' " alt="" />';
					output += '<ul class="songs">';
					$.each( results[0].songs, function(i, song){
						output += '<li><a href="'+(song.path)+'" class="track" data-artist ="'+results[0].artist+'" onclick="return false;"><span class="title">'+song.title+'</span><span title="Add to Playlist" class="icone-list-add"> </span></a></li>';
					})
					output += '</ul>';
					output += '</div>';
			console.log( this );
					$.fancybox( output, {

						beforeLoad: function() {
							this.title = $(this.element).attr('title');
						},
						openEffect	: 'elastic',
						closeEffect	: 'elastic',

						helpers		:{
								overlay: {
									showEarly: false
								},

								title: {

								}
						}
					});
				}

			});
	});
});

























