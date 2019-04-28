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
      <nav class="navbar-main no-shadow">
      </nav>
    </div>
  </header>
  <aside class="sidenav-main">
    <div class="brand-sidebar">
      <h1 class="logo-wrapper">
        <a class="brand-logo" href="#">
          <img src="skin/S.png" alt="">
          <span class="logo-text ">Stansmith</span>
        </a>
      </h1>
    </div>
    <ul class="sidenav sidenav-fixed">
      <li><a class="wave" href="">
        <i class="material-icons">album</i>
        <span class="menu-title">Albums</span>
        <span class="badge pill orange float-right">43</span>
        </a>
      </li>
      <li><a class="wave" href="">
        <i class="material-icons">face</i>
        <span class="menu-title">Artists</span>
        </a>
      </li>
    </ul>
  </aside>
  <div id="main">
    <div class="row">
      <div class="nav-wrapper">
        <div class="col s12">
           <a href="#!" class="breadcrumb">Home</a>
           <a href="#!" class="breadcrumb">Albums</a>
        </div>
      </div>
    </div>
    <div class="row">
        <div class="col s12 m8">
          <table>
            <thead>
              <tr>
                <th>Title</th>
                <th>Artist</th>
                <th>Cover</th>
                <th>Year</th>
                <th>Date Add</th>
              </tr>
            </thead>
            <?php echo $content;?>
          </table>
        </div>
    </div>
  </div>
  <footer>
  </footer>
<script src="skin/materialize/js/materialize.min.js></script>
</body>
</html>
