
(function(){

  /**
   * Handle search discogs query */
  window.addEventListener('load', function () {

    function sendData() {
      const XHR = new XMLHttpRequest();
      const FD = new FormData(form);

      XHR.addEventListener('load', function(event) {
        displayResults(JSON.parse(event.target.responseText), 'search_discogs_results' );
      });

      XHR.addEventListener('error', function(event) {
        console.log('Oups ! Something bab happened ... '); 
      });

      const url = 'http://local.stansmith.io/index.php?controller=stan&action=search&ajax=1';
      XHR.open('POST', url);

      XHR.send(FD);
    } 

    const displayResults = function  (json, output) {

      let res = '';
      json.results.forEach(function(item) {
        res += '<div class="s12 col">' +
          '<div class="card"> ' +
          '<div class="card-image waves-effect waves-block waves-light">' +
          '<img class="" src="' +item.cover_image+ '" alt=""></div>' +
          '<div class="card-content">' +
          '<h5 class="cart-title  grey-text text-darken-4">' +item.title+'</h5>' +
          '<p>' +item.year+'</p>' +
          '<p>' + item.format.join(',')+'<p/>' +
          '<p>'+item.resource_url+'</p>' +
          '<p>'+item.master_url+'</p>' +
          '</div>' +
          '</div>' +
          '</div>';
      }) 
      const wrapper = document.getElementById(output)
      wrapper.innerHTML = res;
    }

    const form = document.getElementById('search_discogs_form');

    if(form){
      form.addEventListener('submit', function (event) {
        event.preventDefault();
        sendData();
      });
    }

  });
})()

$(function(){

  var ul = $('#upload ul');

  $('#drop a').click(function() {
    $(this).parent().find('input').click();
  });

  $('#upload').fileupload({

    dropzone: $('#drop'),

    add: function (e, data) {

      var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"' +
        ' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');

      tpl.find('p').text(data.files[0].name)
        .append('<i>' + formatFileSize(data.files[0].size) + ' </i>');

      data.context = tpl.appendTo(ul);

      tpl.find('input').knob();


      tpl.find('span').click(function(){

        if(tpl.hasClass('working')){
          jqXHR.abort();
        }

        tpl.fadeOut(function(){
          tpl.remove(); 
        });
      });

      var jqXHR = data.submit();
    },
    progress: function(e, data) {

      var progress = parseInt(data.loaded / data.total * 100, 10);

      data.context.find('input').val(progress).change();

      if(progress == 100) {
        data.context.removeClass('working'); 
      }
    },

    fail : function(e, data){
      data.context.addClass('error');
    }
  });
  $(document).on('drop dragover', function (e) {
    e.preventDefault();
  });

  function formatFileSize(bytes) {
    if( typeof bytes !== 'number') {
      return '';
    }

    if (bytes >= 1000000000) {
      return(bytes / 1000000000).toFixed(2) + ' GB';
    }

    if (bytes >= 1000000) {
      return (bytes / 1000000).toFixed(2) + ' MB';

    }
    return (bytes / 1000).toFixed(2) + ' KB';
  }
});
