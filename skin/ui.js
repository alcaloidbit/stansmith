
(function(){
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
    form.addEventListener('submit', function (event) {
      event.preventDefault();
      sendData();
    });

  });
})()
