<div class="col l6 s12">
  <div class="container">
    <div class="card">
      <div class="card-image waves-effect waves-block waves-light">
        <img class="activator" src="<?php echo $link->getImageLink($album->images->id, $album->images->extension);?>" alt="">
      </div>   
      <div class="card-content">
        <div class="card-title activator">
          <h4 class="card-title activator"> <?php echo $album->title; ?></h4>
        </div>
        <p><?php echo $album->artistName; ?></p>
          <p><?php echo $album->meta_year;?></p>

      </div><!--/.card-content-->
      <div class="card-reveal">

        <div class="row">
        <span class="card-title"><?php echo $album->title;?> <i class="material-icons right">close</i></span>
        <form class="col s12" method="POST" action="http://local.stansmith.io/index.php?controller=stan&action=updateAlbum&id_album=<?php echo $album->id;?>">
            <div class="row">
              <div class="input-field col s12">
                <input class="validate" id="album_title" type="text" name="album_title" value="<?php echo $album->title; ?>">
                <label class="active"  for="album-title">Title</label>
              </div>
            </div>

            <div class="row">
              <div class="input-field col s12">
                <input class="validate" id="artist_name" name="album_artist_name" type="text" value="<?php echo $album->artistName; ?>">
                <label class="active"  for="artist_name">Artist</label>
              </div>
            </div>

            <div class="row">
              <div class="input-field col s12">
                <input class="validate" name="album_meta_year" id="album_meta_year" type="text" value="<?php echo $album->meta_year; ?>">
                <label class="active" for="album_meta_year" for="album_meta_year">Year</label>
              </div>
            </div>

            <button type="submit" value="1" class="btn waves-effect waves-light" name="updateAlbum" >Submit
            <i class="material-icons right">send</i></button>
          </form>
        </div><!--/.row-->
      </div><!--/.card-reveal-->
    </div><!--/.card-->
  </div><!--/.container-->
</div><!--/.col.s12 -->
<div class="col l6 s12">
  <div class="container">
    <div class="card card-discogs light-blue">
      <form action="http://local.stansmith.io/index.php?controller=stan&action=search" method="post">
        <div class="card-content white-text">
          <img src="https://s.discogs.com/images/discogs-white.png?" alt="">
            <div class="row">
              <div class="input-field col s12">
                <input value="<?php echo $album->title?>" id="ds_album_title" class="validate" type="text" name="ds_release_title">
                <label for="ds_album-title" class="active">Title</label>
              </div><!--/.input-field-->
            </div><!--/.row-->
            <div class="row">
              <div class="input-field col s12">
                <input class="validate" id="ds_artist_name" name="ds_artist_name" type="text" value="<?php echo $album->artistName; ?>">
                <label class="active"  for="ds_artist_name">Artist</label>
              </div><!--/.input-field-->
            </div><!--/.row-->
        </div><!--/.card-content-->
        <div class="card-action"><button type="submit" class="btn waves-effect waves-light" href="">Search</a></div>
      </form><!--/.form-->
    </div><!--/.card-->
  </div><!--/.container-->
</div><!--/.col.s12-->

<?php
// d($album);

