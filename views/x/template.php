<!DOCTYPE html>
<html lang="fr"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" href="../../favicon.ico"> -->

    <title></title>

    <!-- Bootstrap core CSS -->
    <link href="./views/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="./views/bootstrap/css/sticky-footer.css" rel="stylesheet">

    <link rel="stylesheet" href="views/css/player.css" media="all" type="text/css"/>
    <link rel="stylesheet" href="views/css/ui.css" media="all" type="text/css"/>
    <link rel="stylesheet" href="views/css/sidebar.css" media="all" type="text/css"/>

    <link rel="stylesheet" href="views/js/scrollbar-plugin-master/jquery.mCustomScrollbar.css">

    <link href="./views/bootstrap/font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet">
       <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>

  <body>
  <div class="mask">
      <div class="centered">
      <section class="main">
        <!-- the component -->
        <ul class="bokeh">
          <li></li>
          <li></li>
          <li></li>
          <li></li>
        </ul>

       <h1></h1>
      </section>
      </div>
  </div>
  <!-- Fixed navbar -->
 <!-- <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="back btn btn-info navbar-brand" href="#">Back</a>

        </div>
      </div>
  </nav>
-->
<div class="col-md-12">

        <?php echo $content ?>
</div>

  </div>
  <footer class="footer">
    <div class="container-fluid ">
      <div id="jp_container_1" class="ui-widget-content jp-audio">
        <div class="interface"></div>
        <div class="jp-type-playlist">
          <div id="jquery_jplayer_1" class="jp-jplayer"></div>
           <div class="jp-playlist">
             <ul class="scrollable">
            <!-- The method Playlist.displayPlaylist() uses this unordered list -->
              <li></li>
            </ul>
          </div>

            <div class="jp-gui">
              <div class="jp-interface">
                <div class="jp-title">
                  <ul>
                    <li></li>
                  </ul>
                </div>

                <div class="jp-current-time"></div>
                <div class="jp-duration"></div>


                <div class="jp-controls-holder">
                  <ul class="jp-controls">
                    <li><a href="javascript:;" class="jp-previous" tabindex="1"><button class="btn  btn-default btn-small"><i class="fa fa-step-backward"></i></button></a></li>
                    <li><a href="javascript:;" class="jp-play" tabindex="1"><button class="btn btn-default  btn-small"><i class="fa fa-play"></i></button></a></li>
                    <li><a href="javascript:;" class="jp-pause" tabindex="1"><button class="btn  btn-default btn-small"><i class="fa fa-pause"></i></button></a></li>
                    <li><a href="javascript:;" class="jp-next" tabindex="1"><button class="btn  btn-default btn-small"><i class="fa fa-step-forward"></i></button></a></li>
                    <li><a href="javascript:;" class="jp-stop" tabindex="1"><button class="btn  btn-default btn-small"><i class="fa fa-stop"></i></button></a></li>
                     <li class="floatr"><span class="badge">0</span><button class="btn  btn-mini btn-default btn-toggle-playlist" title="Hide Playlist"><i class="fa fa-list"></i></button></li>
                    <!-- <li><button class="btn  btn-mini btn-empty-playlist" title="Empty Playlist"><i class="fa fa-trash-o"></i></button></li> -->
                    <!--<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute"><i class="fa fa-volume-off"></i></a></li>
                    <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute"><i class="fa fa-volume-down"></i></a></li>
                    <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume"><i class="fa fa-volume-up"></i></a></li>-->
                  </ul>
              <!--    <div class="jp-volume-bar">
                    <div class="jp-volume-bar-value"></div>
                  </div> -->
         <!--         <ul class="jp-toggles">
                    <li><button class="btn  btn-mini btn-toggle-playlist" title="Hide Playlist"><i class="fa fa-list"></i></button></li>
                    <li><button class="btn  btn-mini btn-empty-playlist" title="Empty Playlist"><i class="fa fa-trash-o"></i></button></li>
                    <li><a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle"><button class="btn  btn-mini"><i class="fa fa-random"></i></button></a></li>
                    <li><a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off"><button class="btn  btn-mini"><i class="fa fa-random"></i></button></a></li>
                    <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat"><button class="btn   btn-mini"><i class="fa fa-repeat"></i></button></a></li>
                    <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off"><button class="btn  btn-mini"><i class="fa fa-repeat"></i></button></a></li>

                  </ul>-->
                  <ul class="toggle-playlist">

                    <!--<li><button class="btn  btn-mini btn-empty-playlist" title="Empty Playlist"><span class="icone-trash"></span></button></li>-->
                  </ul>
                </div>
                  <div class="jp-progress">
                  <div class="jp-seek-bar">
                    <div class="jp-play-bar"></div>
                  </div>
                </div>
              </div>
            </div>


          <div class="jp-no-solution">
          <span>Update Required</span>
          To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
          </div>
        </div>
      </div>
    </div>

    </div>
  </footer>

<script src="views/bootstrap/js/jquery-1.11.0.js"></script>
<script type="text/javascript" src="views/bootstrap/js/bootstrap.min.js"></script>
<script src="views/js/jquery.easing.1.3.js"></script>

<script src="views/js/imagesloaded.min.js"></script>
<script src="views/js/masonry.min.js"></script>
<script src="views/js/isotope.min.js"></script>



<script type"text/javascript" src="views/js/JavaScript-ID3-Reader-master/dist/id3-minimized.js"></script>
<script type="text/javascript" src="views/js/jPlayer-2.9.0/src/javascript/jplayer/jquery.jplayer.js"></script>
<script type="text/javascript" src="views/js/jPlayer-2.9.0/src/javascript/add-on/jplayer.playlist.js"></script>
<script src="views/js/scrollbar-plugin-master/js/uncompressed/jquery.mousewheel.js"></script>
<script src="views/js/scrollbar-plugin-master/js/uncompressed/jquery.mCustomScrollbar.js"></script>
<!-- <script src="views/js/id3.js"></script> -->
<script src="views/js/ui.js"></script>

</body></html>




