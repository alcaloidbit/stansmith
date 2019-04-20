
<!-- <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-folder"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Artists</span>
                  <span class="info-box-number"><?php //echo $artist_nbr;?></span>
                </div>
            </<div></div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-folder"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Releases</span>
                  <span class="info-box-number"><?php //echo $albums_nbr;?></span>
                </div>
            </div>
        </div>
</div> -->
<div class="row">
  <div class="col-md-10">
  <div class="box collapsed-box">
      <div class="box-header with-border">
          <i class="fa fa-fw fa-wikipedia-w"></i>
              <h3 class="box-title"></h3>
               <div class="box-tools pull-right">
                 <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <blockquote>
                <h3><span class="mw-headline" id="Aristote">Aristote</span></h3>
                    <p><a href="https://fr.wikipedia.org/wiki/Aristote" title="Aristote">Aristote</a> distinguait trois sortes d'amitié (<i><span class="lang-grc-latn" lang="grc-latn"><a href="https://fr.wikipedia.org/wiki/Philia" title="Philia">philia</a></span></i>)&#160;:</p>
                    <ul>
                    <li>l'amitié en vue du plaisir&#160;;</li>
                    <li>l'amitié en vue de l'intérêt&#160;;</li>
                    <li>l'amitié des hommes de bien, semblables par la <a href="https://fr.wikipedia.org/wiki/Vertu" title="Vertu">vertu</a>.</li>
                    </ul>
                    <p>Pour <a href="https://fr.wikipedia.org/wiki/Aristote" title="Aristote">Aristote</a>, la seule véritable amitié est l'amitié <a href="https://fr.wikipedia.org/wiki/Vertueuse" class="mw-redirect" title="Vertueuse">vertueuse</a>. Cette dernière est recherchée par tout homme, même si tout homme ne la rencontre pas nécessairement. Elle peut naître entre deux individus d'«&#160;égale vertu&#160;» selon le philosophe et se distingue de l'<a href="https://fr.wikipedia.org/wiki/Amour" title="Amour">amour</a> en cela que l'amour crée une dépendance entre les individus. Toujours selon <a href="https://fr.wikipedia.org/wiki/Aristote" title="Aristote">Aristote</a>, l'ami vertueux («&#160;véritable&#160;») est le seul qui permet à un homme de progresser car l'ami vertueux est en réalité le <a href="https://fr.wikipedia.org/wiki/Miroir" title="Miroir">miroir</a> dans lequel il est possible de se voir tel que l'on est. Cette situation idéale permet alors aux amis de voir leur vertu progresser, leur donnant ainsi accès au <a href="https://fr.wikipedia.org/wiki/Bonheur" title="Bonheur">bonheur</a>, notion évoquée dans le dernier livre de l’<i><a href="https://fr.wikipedia.org/wiki/%C3%89thique_%C3%A0_Nicomaque" title="Éthique à Nicomaque">Éthique à Nicomaque</a></i> et qui est, pour Aristote, la plus importante<sup id="cite_ref-2" class="reference"><a href="#cite_note-2"><span class="cite_crochet">[</span>2<span class="cite_crochet">]</span></a></sup>.</p>
                    <p>Aristote pose ainsi l'amitié (véritable) comme pré-requis indispensable pour accéder au bonheur.</p>
                <small>Wikipédia  <cite title="Source Title"><a href="https://fr.wikipedia.org/wiki/Amitié">https://fr.wikipedia.org/wiki/Amitié</a></cite></small>
              </blockquote>
            </div>
            <!-- /.box-body -->
          </div>
      </div>
  </div>


<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-6">
          <div class="box-primary box box-solid">
              <div class="box-header">
                  <h4 class="box-title">
                  <span class="icon"><i class="ion ion-ios-cloud-upload"></i></span>
                  </h4>
              </div>
              <div class="box-body">
                  <form id="upload" method="POST" action="index.php?controller=admin&action=ajaximport" enctype="multipart/form-data">


                      <p class="margin">
                      <div class="input-group ">
                          <span class="input-group-addon"><i class="ion ion-person"></i></span>
                          <input type="text" id="artist" name="artist" class="form-control" placeholder="Artist">
                         <div class="instantresult"></div>
                      </div>

                      <p class="margin">

                      <div class="input-group ">
                      <span class="input-group-addon"><i class="ion ion-disc"></i></span>
                          <input type="text" id="album" name="album" placeholder="Album" class="form-control">
                          <div class="instantresult"></div>
                      </div>

                      <div id="drop">
                      Drop Here
                      <a>Browse</a>
                          <input type="file" name="files[]" multiple />
                          <input type="hidden" id="path"  name="path" value=""/>
                      </div>

                      <ul>
                      <!-- The file uploads will be shown here -->
                      </ul>
                  </form>
              </div>
              <div class="box-footer">
                  <a href="http://176.31.245.123/stansmith/index.php?controller=admin&action=scan" class="btn btn-primary">Scan</a>
              </div>
          </div>
      </div>
      <div class="col-md-4">
           <div class="box box-primary direct-chat direct-chat-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Asynchronous Communication</h3>

              <div class="box-tools pull-right">
                <!-- TODO GET NBR OF MESSAGE -->
                <span data-toggle="tooltip" title="" class="badge bg-light-blue"></span>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                  <i class="fa fa-comments"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- Conversations are loaded here -->

                <div class="direct-chat-messages">
<?php


      if(count($messages)){
        foreach( $messages as $k => $msg){
          $classname = ( $_SESSION['user']['name'] == $msg['pseudo'] ) ? 'right' : '';
          $html = '<div id='.$msg['id_message'].' class="direct-chat-msg '.$classname.'">
                    <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left">'.$msg['pseudo'].'</span>
                      <span class="direct-chat-timestamp pull-right">'.$msg['date_add'].'</span>
                    </div>
                    <!-- /.direct-chat-info -->';

                if($msg['pseudo'] == 'fred')
                    $html .= '<img class="direct-chat-img" src="theme/dist/img/user2-160x160.jpg" alt="Message User Image"><!-- /.direct-chat-img -->';
                else if($msg['pseudo'] == 'patrick')
                    $html .= '<img class="direct-chat-img" src="theme/dist/img/user3-160x160.jpg" alt="Message User Image"><!-- /.direct-chat-img -->';
                else if($msg['pseudo'] == 'roger')
                    $html .= '<img class="direct-chat-img" src="theme/dist/img/user4-200x200.jpg" alt="Message User Image"><!-- /.direct-chat-img -->';

                    $html .= '<div  class="direct-chat-text">'
                     .$msg['content'].
                    '</div>
                    <!-- /.direct-chat-text -->
                  </div>';
            echo $html;

        }
      }
?>



                </div>



              <!--/.direct-chat-messages-->

              <!-- Contacts are loaded here -->

              <!-- /.direct-chat-pane -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <form action="http://176.31.245.123/stansmith/index.php?controller=admin&action=postIM_message" id="sendIM" method="post">
                <input type="hidden" name="pseudo" value="<?php echo $_SESSION['user']['name'] ;?>"/>
                <div class="input-group">
                  <input type="text" name="message" id="sendIMInput" placeholder="Type Message ..." class="form-control">
                      <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-flat" >Send</button>
                      </span>
                </div>
              </form>
            </div>
            <!-- /.box-footer-->
          </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-md-10">
        <div class="box box-primary collapsed-box">
            <div class="box-header">
                <h4 class="box-title"><span class="icon"><i class="ion ion-ios-cloud"></i></span></h4>
                <div class="box-tools pull-right">
                 <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
            </div>
            <div class="box-body items_list">
            <?php
                 echo $tree;
            ?>
            </div>
            <div class="box-footer"></div>
        </div>
    </div>
</div>
<div class="row">

<!--      <div class="col-md-6">
         <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title"></h3>
                </div>
                <form class="form-horizontal" id="submitAlternateInfo" action="http://176.31.245.123/stansmith/?controller=admin&action=searchDiscogs" method="POST">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="inputReleasetitle" class="col-sm-2 control-label">Release title</label>
                      <div class="col-sm-10">
                        <input type="test" class="form-control" name="release_title" id="inputReleasetitle" placeholder="Release title">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputArtist" class="col-sm-2 control-label">Artist</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputArtist" name="artist" placeholder="Artist">
                      </div>
                    </div>
                  </div><
                  <div class="box-footer">
                    <button type="submit" class="btn btn-default">Cancel</button>
                    <button type="submit"  id="AlternateInfo" class="btn btn-info pull-right">Search Discogs</button>
                  </div>
                </form>
          </div>
    </div>

</div>
<div  id="discogs_results" class="table-responsive no-padding">

</div>  -->

</div>