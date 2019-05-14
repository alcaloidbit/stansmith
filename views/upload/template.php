<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0, minimal-ui"/>
  <title>Stansmith</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli">
  <link rel="stylesheet" href="skin/materialize/css/materialize.min.css" type="text/css" media="screen,projection"/>
  <link rel="stylesheet" href="skin/style.css" media="screen, projection"/>
</head>
<body>
  <header class="top-bar">
    <div class="navbar navbar-fixed">
      <nav class="navbar-main no-shadow gradient-45deg-indigo-purple">
        <div class="nav-wrapper">
          <div class="header-search-wrapper"></div>
            <ul class="navbar-list right">
            <li><a class="showfront waves-effect waves-block" href="<?php echo $link->getPageLink(array('controller'=>'index'));?>" ><i class="material-icons">exit_to_app</i></a></li>
            </ul>
        </div>
      </nav>
    </div>
  </header>
  <aside class="sidenav-main">
    <div class="brand-sidebar">
      <h1 class="logo-wrapper">
        <a class="brand-logo" href="<?php echo $link->getBaseLink() ?>">
          <img src="http://176.31.245.123/stansmith/skin/S.png" alt="">
          <span class="logo-text">Stansmith</span>
        </a>
      </h1>
    </div>
    <ul class="sidenav sidenav-fixed">
      <li><a class="waves-effect waves-cyan" href="<?php echo $link->getPageLink(array('controller' => 'stan', 'action' => 'display' ));?>">
        <i class="material-icons">album</i>
        <span class="menu-title">Albums</span>
        <span class="badge pill light-blue darken-5 float-right"><?php echo $totalReleases;?></span>
        </a>
      </li>
      <li><a class="waves-effect waves-cyan" href="">
        <i class="material-icons">face</i>
        <span class="menu-title">Artists</span>
        </a>
      </li>
      <li><a class="waves-effect waves-cyan" href="<?php echo $link->getPageLink(array('controller'=>'upload','action'=>'display'));?>">
        <i class="material-icons">cloud_upload</i>
        <span class="menu-title">Import</span>
        </a>
        </li>
    </ul>
  </aside>
  <div id="main">
    <div class="row">
      <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12">
              <a href="<?php echo $link->getPageLink(array('controller'=>'stan', 'action'=>'display'))?>" class="breadcrumb">Home</a>
              <a href="#!" class="breadcrumb"><?php echo $page_name?></a>
              </div>
            </div>
          </div>
        </div>

        <?php echo $content;?>

    </div>
  </div>
  <footer>
  </footer>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" crossorigin="anonymous"></script> 
  <script src="skin/materialize/js/materialize.min.js"></script>
  <script src="skin/jQuery-File-Upload-9.30.0/js/vendor/jquery.ui.widget.js"></script>
  <script src="skin/jQuery-File-Upload-9.30.0/js/jquery.iframe-transport.js"></script>
  <script src="skin/jQuery-File-Upload-9.30.0/js/jquery.fileupload.js"></script>
  <script src="skin/jQuery-File-Upload-9.30.0/js/jquery.fileupload-ui.js"></script>
  <script src="skin/jQuery-File-Upload-9.30.0/js/jquery.fileupload-process.js"></script>
  <script src="skin/jQuery-File-Upload-9.30.0/js/jquery.fileupload-audio.js"></script>
  <script src="skin/jQuery-File-Upload-9.30.0/js/jquery.fileupload-validate.js"></script>
  <script src="skin/mini-upload-form/assets/js/jquery.knob.js"></script>
  <script src="skin/ui.js"></script>
  </body></html>
