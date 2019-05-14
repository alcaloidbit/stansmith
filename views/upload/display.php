<div class="col l6 s12">
  <div class="container">
    <div class="card grey darken-4">
      <div class="card-content">
        <form id="upload" method="post" action="http://local.stansmith.io/index.php?controller=upload&action=import" enctype="multipart/form-data">
            <div class="row">
              <div class="input-field col s12">
                <i class="material-icons prefix">face</i>
                <input class="validate" id="add_artist" type="text" name="add_artist_name" value="">
                <label class="active"  for="add_artist">Artist Name</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <i class="material-icons prefix">album</i>
                <input class="validate" id="add_album_title" type="text" name="add_album_title" value="">
                <label class="active"  for="add_album_title">Album Title</label>
              </div>
            </div>
            <div id="drop">
            Drop Here 
            <a >Browse</a>
            <input type="file" name="files" multiple>
            </div>
            <ul>
            </ul>
        </form>
      </div>
    </div>
  </div>
</div>
