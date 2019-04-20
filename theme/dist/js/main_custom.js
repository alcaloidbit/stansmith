(function(){
	$('.trigger').each(function(){
		$(this).on('click', function(event){
			$(this).parent().children('ul').slideToggle();
		});

	});

	$('.album .action > .delete').on('click',function(){
		if (window.confirm("Are you sure?")) {
			console.log('delete album');
			var $that = $(this);
			var id_album = $that.data('id_album');
			var data =  {'id_album': id_album};

			$.ajax({
				url: 'http://176.31.245.123/stansmith/index.php?controller=admin&action=deleteAlbum',
				type : 'GET',
				data : data,
				dataType: 'json',

				success : function(data, status ){
					// console.log(data);
					$that.remove();
				}
			});
		}
	});

	$('.song > .delete').on('click', function(){
    	if (window.confirm("Are you sure?")) {
			var $that = $(this).parent();
			var id_song = $that.data('id_song');
			var data =  {'id_song': id_song};
			$.ajax({
				url: 'http://176.31.245.123/stansmith/index.php?controller=admin&action=deleteSong',
				type : 'GET',
				data : data,
				dataType: 'json',

				success : function(data, status ){
					// console.log(data);
					$that.remove();
				}
			})
		}


	});

	$('.discogs-search').on('click', function(){
		var data  = $(this).data();
		var id_album = data.id_album;

		$.ajax({
			url: 'http://176.31.245.123/stansmith/index.php?controller=admin&action=searchDiscogs',
			type: 'GET',
			data: data,
			dataType:'json',
			success: function(json, status){


					var html = '<span class="close fa fa-times"></span>'+
								'<table class="table table-hover table-bordered">'+
								'<tbody><tr>'+
								'<th >#</th>'+
								// '<th>barcode</th>'+
								'<th>catno</th>'+
								// '<th >community</th>'+
								'<th>country</th>'+
								'<th>format</th>'+
								'<th >genre</th>'+
								// '<th>id</th>'+
								'<th>label</th>'+
								'<th >resource_url</th>'+
								'<th>style</th>'+
								'<th>thumb</th>'+
								'<th >title</th>'+
								'<th>type</th>'+
								'<th>uri</th>'+
								'<th >year</th>'+
								'<th>Action</th>'+
								'</tr>';

					$(json.results).each(function(i){
						html += searchJsonToHTML(this, id_album, i+1);
					});

					html +=  '</tbody></table>';

     			$('#discogs_results').append(html).show();
			}
		})
	});

	var searchJsonToHTML = function(jsonitem, id_album, i){

		var html = '<tr><td>'+i+'</td>';

		// $(jsonitem.barcode).each(function(){
		// 	html+=this;
		// 	html+='<br/>';
		// });

		html +=   '<td>'+jsonitem.catno+'</td>'+
		  '<td>'+jsonitem.country+'</td><td>';

		$(jsonitem.format).each(function(){
			html+=this;
			html+=',';
		});
		html += '</td><td>';
		$(jsonitem.genre).each(function(){
			html+=this;
			html+=',';
		});
	  html +='</td><td>';

		$(jsonitem.label).each(function(){
			html+=this;
			html+=',';
		});

		html +='</td><td><a class="discogs-resource" href="'+jsonitem.resource_url+'">'+jsonitem.resource_url+'</a></td><td>';

		$(jsonitem.style).each(function(){
			html+=this;
			html+=',';
		});

		html +='</td><td data-thumb_uri="'+jsonitem.thumb+'"><img src="'+jsonitem.thumb+'"/></td>'+
		  '<td>'+jsonitem.title+'</td>'+
		  '<td>'+jsonitem.type+'</td>'+
		  '<td><a href="http://www.discogs.com'+jsonitem.uri+'">'+jsonitem.uri+'</a></td>'+
		  '<td>'+jsonitem.year+'</td>'+
		  '<td><a href="http://176.31.245.123/stansmith/index.php?controller=admin&action=addDiscogsRelease" data-id_album = "'+id_album+'" class="add-discogs-release btn btn-primary">Add Infos</a></td></tr>';
		return html;
	}



	$('#submitAlternateInfo').on('submit', function(evt){
		evt.preventDefault();
	
		var datastring = $(this).serialize();
		$.ajax({
            type: "POST",
            url: "http://176.31.245.123/stansmith/?controller=admin&action=searchDiscogs",
            data: datastring,
            dataType: "json",
         success: function(json, status){

         		if(json.results.length){


					var html = '<span class="close fa fa-times"></span>'+
								'<table class="table table-hover table-bordered">'+
								'<tbody><tr>'+
								'<th >#</th>'+
								// '<th>barcode</th>'+
								'<th>catno</th>'+
								// '<th >community</th>'+
								'<th>country</th>'+
								'<th>format</th>'+
								'<th >genre</th>'+
								// '<th>id</th>'+
								'<th>label</th>'+
								'<th >resource_url</th>'+
								'<th>style</th>'+
								'<th>thumb</th>'+
								'<th >title</th>'+
								'<th>type</th>'+
								'<th>uri</th>'+
								'<th >year</th>'+
								'<th>Action</th>'+
								'</tr>';

					$(json.results).each(function(i){
						html += searchJsonToHTML(this, id_album, i+1);
					});

					html +=  '</tbody></table>';

     				$('#discogs_results').append(html).show();

         		}else{

         			$('#discogs_results').append('<div class="alert alert-danger alert-dismissible">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
                    '<h4><i class="icon fa fa-ban"></i> No results :(</h4>'+
                  '</div>').show();
         		}
			},
            error: function(){
                 console.log('Error Handling Here');
            }
        });


	});



	$('#discogs_results').on('click', '.close', function(){
		$('#discogs_results').empty().hide();
	});

	$('#discogs_results').on('click', '.discogs-resource', function(evt){
		evt.preventDefault();
		var url = $(this).attr('href');

		$.ajax({
			url: url,
			type:'GET',
			dataType: 'json',
			success : function(data,status){
				console.log(data);
				// $('#discogs_results').empty();

				var html = '<span class="close fa fa-times"></span>'+'<table class="table table-hover table-bordered">'+
							'<tbody><tr>'+'<th >artists</th>'+
							'<th>genre</th>'+'<th>images</th>'+
							'<th>main_release</th>'+'<th >main_release_url</th>'+
							'<th>styles</th>'+'<th >title</th>'+'<th>tracklist</th>'+'<th>uri</th>'+
							'<th >versions_url</th>'+'<th>videos</th>'+'<th >year</th>'+
							'</tr>';
					html += '<tr><td>';
					$(data.artists).each(function(){
						for(prop in this)
							html+=prop + ':' +this[prop]+'<br />';
					});
				html+'</td>';

				// html += '<td>'+data.data_quality+'</td>';

				html += '<td>';
				$(data.genres).each(function(){
						html+=this;
						html+='<br/>';
					});
				html += '</td>';
				// html += '<td>'+data.id+'</td>';
				html += '<td>'+'images arrayofObject'+'</td>';
				html += '<td>'+data.main_release+'</td>';
				html += '<td>'+data.main_release_url+'</td>';
				// html += '<td>'+data.resource_url+'</td>';

				html += '<td>';
				$(data.styles).each(function(){
						html+=this;
						html+='<br/>';
					});
				html += '</td>';

				html += '<td>'+data.title+'</td>';
				html += '<td>';

				$(data.tracklist).each(function(){
						for(prop in this)
							html+=prop + ':' +this[prop]+'<br />';
					});
				html+'</td>';

				html += '<td>'+data.uri+'</td>';
				html += '<td>'+data.versions_url+'</td>';

				html += '<td>'+'videos arrayofObject'+'</td>';
				html += '<td>'+data.year+'</td>';


				html += '</tr>';
				html +=  '</tbody></table>';

             	$('#discogs_results').empty().append(html).show();
			}
		})

	});

	// $('.main-tree').listnav({

	// 		includeAll: false,
 //    		noMatchText: 'There are no matching entries.'
	// });


var trunc = function(string){
	 var str = string.substring(0, string.length-1);
	 return str;
}


$('#discogs_results').on('click', '.add-discogs-release',function(evt){
		evt.preventDefault();
		var $that = $(this);
		var data = {};
		data.id_album = $that.data('id_album');

		var rows = $that.parent().parent().find('td');

		rows.each(function(i, element){
				switch(i){
					case 1:
						data.catno = $(element).text();
					break;
					case 2:
						data.country = $(element).text();
					break;
					case 3:
						data.format = trunc($(element).text());
					break;
					case 4:
						data.genre = trunc($(element).text());
					break;
					case 5:
						data.label = trunc($(element).text());
					break;
					case 6:
						data.resource_url = $(element).text();
					break;
					case 7:
						data.style = trunc($(element).text());
					break;
					case 8:
						data.thumb = $(element).text();
					break;
					case 9:
						data.title = $(element).text();
					break;
					case 10:
						data.type = $(element).text();
					break;
					case 11:
						data.url = $(element).text();
					break;
					case 12:
						data.year = $(element).text();
					break;
					default :
						break;
				}
		});


		var url = $that.attr('href');

		var $display = $('#discogs_results');

		$.ajax({
			url: url,
			type:'POST',
			dataType: 'json',
			data: data,

			success: function(json, status){
				$display.find('.close').click();
				$display.append('<div class="alert alert-success alert-dismissible">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4>	<i class="icon fa fa-check"></i>Success !</h4></div>').show();

			},
			fail: function(json, status){
				$display.find('.close').click();
				$display.append('<div class="alert alert-danger alert-dismissible">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
                    '<h4><i class="icon fa fa-ban"></i> Fail !</h4>'+
                  '</div>').show();
			}

		})
;});


	$('.update_meta_year').on('click', function(){
		$that = $(this);
		var $input = $that.parent().find('input[name=meta_year]');
		var val = $input.val();
		var id_album = $that.data('id_album');

		$.ajax({
			url: 'http://176.31.245.123/stansmith/index.php?controller=admin&action=updateMetaYear',
			type: 'GET',
			data: {'id_album': id_album, 'meta_year': val},
			dataType: 'json',

			success: function(json, status){
				$input.val(json.meta_year);
				$that.find('i').toggleClass('fa-refresh fa-check');
				$that.toggleClass('btn-info btn-success');
			}

		})
	});

})($);

