<div class="col l6 s12">
  <div class="container">
    <div class="card">
      <div class="card-image waves-effect waves-block waves-light">
        <img src="<?php echo $link->getImageLink($album->images->id, $album->images->extension);?>" alt="">
      </div>   
      <div class="card-content">
        <div class="card-title">
          <h4 class="card-title"> <?php echo $album->title; ?></h4>
        </div>

        <div class="row">
          <form class="col s12" action="">

            <div class="row">
              <div class="input-field col s12">
                <input class="validate" id="album_title" type="text" value="<?php echo $album->title; ?>">
                <label class="active" for="title" for="album-title">Title</label>
              </div>
            </div>

            <div class="row">
              <div class="input-field col s12">
                <input class="validate" id="album_year" type="text" value="<?php echo $album->year; ?>">
                <label class="active" for="year" for="album_year">Year</label>
              </div>
            </div>

          </form>
        </div>

      </div><!--/.card-content-->
    </div><!--/.card-->
  </div><!--/.container-->
</div><!--/.col.s12 -->


<?php
// d($album);

