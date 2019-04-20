	 <?php



class AdminController extends Controller
{

	public $html = '';
	public function __construct()
	{
		session_start();
		// d($_SESSION);
	}


	public function addDiscogsRelease()
	{
		$params = $this->request->getParams();
		$obj = new DiscogsRelease();

		foreach($params as $key => $value)
		{
			if(property_exists($obj, $key ))
				$obj->{$key} = $value;
		}

		if($obj->add())
			echo '{"status": "success"}';
		else
			echo '{"status": "fail"}';
		exit;

	}
	public function deleteAlbum()
	{
		$id_album = $this->request->getValue('id_album');
		$album = new Album($id_album);
		$album->delete();
		echo '{"status" : "done"}';
		exit;
	}

	public function deleteSong()
	{
		$id_song = $this->request->getValue('id_song');
		$song = new Song($id_song);
		$song->delete();
		echo '{"status" : "done"}';
		exit;
	}

	/**
	 * cleanSymLinks Delete Broken Symlinks From the Public Dir
	 *
	 */
	public function cleanSymLinks()
	{
		$handle = opendir( _AUDIO_PUBLIC_ );
		while(( $entry=readdir($handle)) !== FALSE )
		{
			if(  $entry !== '.' && $entry !== '..')
			{
				$q = 'select * from song where path = "'._AUDIO_PUBLIC_.'/'.$entry.'"';
				$res = Db::getInstance()->getValue($q);
					if(!$res)
						unlink( _AUDIO_PUBLIC_.'/'.$entry);
			}
		}
	}
	/**
	 * On parcours le dossier image, le nom du fichier correspond a l'identifiant de l'image dans la
	 * BDD.
	 * */
	public function cleanImageDir()
	{
		$handle = opendir( _IMAGE_ );
		$i = 0;
		while(($entry=readdir( $handle)) !== FALSE )
 		{
 			if( !is_dir(_IMAGE_.'/'.$entry) && $entry != '.' && $entry != '..' )
 			{
 				$i++;
 				preg_match( '/^(\d*)/', $entry, $match );
				$id_image = $match[1];

				$req = 'SELECT `id_image` FROM `image` WHERE `id_image` = '.(int)$id_image.'';
				$res = Db::getInstance()->getValue($req);
				if($res)
					echo $i. '- id_image = '.$res .' - Nom du fichier = '.$entry.'<br />';
					// unlink(_IMAGE_.'/'.$entry);

 			}
 		}
	}


	public function getLastMessages()
	{
		if($this->request->getValue('ajax')){
			$id = $this->request->getValue('id_message');
			$results = Message::getLastMsgAfterId( $id );

			foreach( $results as &$msg ){
				if($_SESSION['user']['name'] == $msg['pseudo'])
						$msg['direction'] = 'right';
				else
						$msg['direction'] = 'left';

			}
			die(json_encode($results));

		}
		else{
			$messages = Message::getTenLastMessage();
			return  $messages;
		}
	}

	public function dataToTree()
	{
		$artists = Artist::getArtists();
		$this->html  .='<ul class="main-tree">';

		foreach($artists as $a)
		{
			$artist = new Artist($a['id_artist']);
			$this->html .= '<li data-id_artist = "'.$artist->id.'" class="artist">
								<div class="trigger ">
									<span class="ion-ios-folder-outline "></span>'.$artist->name.
								'</div>';
		$releases = $artist->getAlbums();

		$this->html .= '<ul class="subtree">';
			foreach ($releases as $key => $album) {
				$album = new Album($album['id_album']);
				$this->html .= '<li  data-id_album = "'.$album->id.'"  class="album">
									<div class="trigger">
										<img src="http://176.31.245.123/stansmith/images/thumbnails/'.$album->images[0]['id_image'].'_thumb'.$album->images[0]['extension'].'" />'.$album->title.'
									</div>
									<div class="action">
										<span  data-id_album="'.$album->id.'" class="delete ion-ios-trash-outline"></span>
										<span data-artist="'.$artist->name.'" data-id_album="'.$album->id.'" data-release_title ="'.$album->title.'" class="discogs-search"></span>
                  						<input type="text"  name="meta_year" value="' .$album->meta_year.'" class="form-control" >
										<button class="btn btn-info btn-flat update_meta_year" data-id_album = "'.$album->id.'" type="button"><i class="fa fa-refresh"></i></button>
                					</div>';

				$this->html .= '<ul class="subtree">';
					foreach($album->songs as $s)
						$this->html .= '<li data-id_song="'.$s['id_song'].'" class="song"><span class="ion-ios-musical-note"></span>'.$s['title'].'<span class="delete ion-ios-trash-outline"></span></li>';
				$this->html .= '</ul></li>';
			}
			$this->html .= '</ul></li>';
		}
		$this->html .= '</ul>';

		return $this->html;
	}

	public function display()
	{
			if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == true) 
			{

				$data['albums'] = $this->getList();
				$data['artist_nbr'] = Artist::getArtistsNbr();
				$data['albums_nbr'] = Album::getAlbumsNbr();

				$data['tree'] = $this->dataToTree();


				$data['messages']  = Message::getTenLastMessage();


				$this->renderView( $data );

			} else {

				header('Location: http://176.31.245.123/stansmith/index.php?controller=login');
				// return  false;
			}


	}

	public function edit()
	{
		$id_album = $this->request->getValue( 'id_album' );
		$data['album'] =  new Album( $id_album );
		$this->renderView( $data );
	}

	public function getList()
	{
		$data = Album::getAlbumsFull();
		return $data;
	}

	public function addImage()
	{
		$allowed = array('.png', '.jpg', '.gif','.zip', '.jpeg');

		if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0)
		{
		 	$extension = '.'.pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
		 	$filename = $_FILES['upl']['name'];

		 	if(!in_array(strtolower($extension), $allowed))
		 	{
		 		echo '{"status":"error"}';
		 		exit;
		 	}

		 	if(move_uploaded_file($_FILES['upl']['tmp_name'], 'uploads/'.$filename))
		 	{
		 		$id_album = $this->request->getValue('id_album');

		 		$image = new Image( );
		 		$image->extension = $extension;
		 		$image->id_album = (int) $id_album;
		 		$image->add();

		 		if(!rename(  'uploads/'.$filename, _IMAGE_.'/'.$image->id.$image->extension))
		 			d('<h1>Probleme Copying Image</h1>');
		 		else{
					 ImageManager::resize(_IMAGE_.'/'.$image->id.$image->extension, _IMAGE_.'/small/'.$image->id.'_small'.$image->extension, 200, null);
					 ImageManager::resize(_IMAGE_.'/'.$image->id.$image->extension, _IMAGE_.'/thumbnails/'.$image->id.'_thumb'.$image->extension, 75, null);

		 		}
				 @unlink( 'uploads/'.$filename );

				$data['id_image'] = $image->id;
				$data['id_album'] = $id_album;
				$data['ext']      = $extension;
				die(json_encode( $data ));
			}
			else
		 	{
		 		echo '{"status":"error"}';
		 		exit;
		 	}
		}
	}


	public function addAlbumCover( )
	{
		$id_album = $this->request->getValue('id_album');
		$imgdata  = $this->request->getValue('rawimgdata');
		$ext      = $this->request->getValue('extension');

		$tmpname = tempnam( _IMAGE_, 'tmp' );
		@chmod( $tmpname, 0777);
		$imgURI  = Tools::base64_to_jpeg( $imgdata, $tmpname );

		$image = new Image( );
		$image->extension = $ext;
		$image->id_album = (int) $id_album;
		$image->add();

		if(!rename( $imgURI, _IMAGE_.'/'.$image->id.$image->extension))
			d('<h1>Probleme Copying Image</h1>');
		else
			ImageManager::resize(_IMAGE_.'/'.$image->id.$image->extension, _IMAGE_.'/small/'.$image->id.'_small'.$image->extension, 200, null);
		@unlink( $tmpname );

		$data['id_image'] = $image->id;
		$data['id_album'] = $id_album;
		$data['ext']      = $ext;
		die(json_encode( $data ));
	}


	public function askdiscogsforimages()
	{
		$id_album = $this->request->getvalue( 'id_album' );
		$album    =  new album( $id_album );

		if(  $this->request->getvalue('release') && $this->request->getvalue( 'artist' ) )
		{
			$album_query = $this->request->getvalue('release');
			$artist_query = $this->request->getvalue('artist');
		}
		else
		{
			$album_query = $album->title;
			$artist_query = $album->artistname;
		}


		$html = '<div class="col-lg-6 discogs-resp">';

		$service = new discogsservice();

		// search ne renvoi false que si erreur oauth
		if( !$response = $service->search( $artist_query, $album_query ) )
		{
			// erreur oauth
		}
		elseif( $response->pagination->items === 0 ) // gestion no results
		{
				$html .=  '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> no results for this query : '.$artist_query .' + '.$album_query .'</div>';
				$html .=  '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>you should try with others params</div>
							<div class="panel panel-default">
								<div class="panel-body">
									<form action="index.php?controller=admin&action=askdiscogs" method="post" id="change_query_params">
										<div class="form-group">
											<label for="release">release title</label>
											<input name="release" type="text" class="form-control">
											<p class="help-block">entrez le nom d un album, release ...</p>
										</div>
										<div class="form-group">
											<label for="artist">artist name</label>
											<input name="artist" type="text" class="form-control">
											<p class="help-block">entrez le nom d un artist ...</p>
										</div>
										<input type="hidden" name="id_album" value="'.$album->id.'"/>
									</form>
									<button class="ladda-button btn  btn-block btn-lg btn-sky" id="changequery" data-style="zoom-in"><span class="ladda-label">valider</span></button>
								</div>
							</div>
					</div><!-- ./ discogs-resp -->';
			die($html);
		}
		else
		{
			$releases = array();
			foreach( $response->results as $res )
				$releases[ $res->id ] = $res->resource_url;

			$imgs_uris = array();
			foreach( $releases as $id => $rel_url )
			{
				$release = $service->getrelease( $id );
				if( $image = $service->getimageurifromrelease( $release ) )
					$imgs_uris[ ] = $image;
			}

			$imgdata   = $service->getrawimagedata( $imgs_uris[0] );
			$extension = Tools::getextension( $imgs_uris[0] );
			$dimension = $service->getimagedimension( $imgdata );

			$html .='<div class="panel panel-default">
					<div class="panel-heading"><h3>'.
					$imgs_uris[0] .' - '. $dimension['width'].'px * '.$dimension['height'].'px '
					.'</h3></div>
						<div class="panel-body " style="position:relative;">
							<div style="width: '.$dimension['width'].'px; height:'.$dimension['height'].'px" class="view effect">
								<img class="img-responsive cover-img" src="data:image/jpeg;base64,'.$imgdata.'"/>
								<div class="mask"  style="width: '.$dimension['width'].'px; height:'.$dimension['height'].'px">
									<button data-style="zoom-in" data-size="medium" class="ladda-button btn btn-lg btn-fresh confimg" type="submit" name="submitrawimg" ><span class="ladda-label">valider</span></button>
									<img class="ajax-load" src="http://176.31.245.123/stansmith/views/ajax-loader.gif"/>
								</div>

							</div>
						</div>
						<div class="panel-footer">

						<ul class="pagination">';
						foreach( $imgs_uris as $k => $uri )
						{
							if(  $k == 0){
								$html .= '<li class="active"><a class="imguri " href="'.$uri.'" >'.$k.'</a></li>';
								continue;
							}
							$html .= '<li><a class="imguri" href="'.$uri.'" >'.$k.'</a></li>';
						}
						$html.='
						</ul>
						<form id="form-imgdata" role="form" enctype="multipart/form-data" method="post" action="index.php?controller=admin&action=addalbumcover">
								<input type="hidden"  value="'.$imgdata.'" name="rawimgdata" />
								<input type="hidden" value="'.$album->id.'" name="id_album" />
								<input type="hidden" value="'.$extension.'" name="extension" />
							</form>
						</div>
				</div>
			</div><!-- ./ discogs-resp -->';
			die( $html );
		}
	}


	public function getImageByURI()
	{
		$service = new DiscogsService();
		$img_uri = $this->request->getValue('img_uri');

		$data['rawimgdata'] = $service->getRawImageData( $img_uri );
		$data['ext']        =  Tools::getExtension( $img_uri );
		$data['dimension']  = $service->getImageDimension( $data['rawimgdata'] );
		die(json_encode( $data ));
	}

	public function postIM_message()
	{
		// Verif a faire
		$msg = $this->request->getValue( 'message' );
		$pseudo = $this->request->getValue('pseudo');
		$message = new Message();
		$message->pseudo =  $pseudo;
		$message->content = $msg;
		$message->add();
		$res = array('id_message' => $message->id	 ,'msg' => $message->content, 'pseudo' => $message->pseudo, 'date_add' => $message->date_add );

		if($_SESSION['user']['name'] == $res['pseudo'])
					$res['direction'] = 'right';
				else
					$res['direction'] = 'left';
		die(json_encode($res));

	}

	public function makeThumbnails()
	{

		$results = Album::getAlbums(0, 100);
		 foreach($results as $a)
		 {
		 	$album = new Album($a['id_album']);
		 	$image = new Image($album->images[0]['id_image']);

		 	if(ImageManager::resize(_IMAGE_.'/'.$image->id.$image->extension,
		 					_IMAGE_.'/thumbnails/'.$image->id.'_thumb'.$image->extension, 75, null) )
		 			echo 'image thumbnails créé <br />';
		 }
	}

	
	public function recursiveScanning( $dirname, $levelDepth = 0, $id_parent = 0 )
	{
		$maxDepth = 3;
		$dir_handle = opendir($dirname) OR die("impossible d' ouvrir le répertoire");
		while( ($entry = readdir( $dir_handle )) && $levelDepth < $maxDepth  )
		{
			if(!in_array( $entry, array('.', '..')) && substr($entry, 0, 1) != '.'  )
			{
				if(is_dir($dirname.'/'.$entry ))
				{
					if( $levelDepth === 0 )
					{
						if( !$id_entity = Artist::getArtistIdByName( $entry ) ) // id_entity est un artist qui existe ( on le recupere ou on le crée )
						{
							$artist = new Artist();
							$artist->name = $entry;
							$artist->dirname = $entry;
							$artist->add(); // AJOUTE ARTIST
							$id_entity = $artist->id;
						}
					}
					else
					{
						$id_artist = ( $id_parent !== 0 ) ? $id_parent : Artist::getArtistIdByName( substr( $dirname, strlen(_AUDIO_) +1 ) );
						if( !$id_entity = Album::existsInDB( $entry, $id_artist  ) )
						{
							$album = new Album();
							$album->title = $entry;
							$album->id_artist = (int)$id_artist;
							$album->dirname = $entry;
							$album->add(); // AJOUTE ALBUM
							$id_entity = $album->id;
						}
					}
					$this->recursiveScanning( $dirname.'/'. $entry, $levelDepth +1, $id_entity );
				}
				else
				{
					if(!Tools::excludeExtension( $entry ))
					{

					}
					else
					{
						$id_album = ( $id_parent !== 0 ) ? $id_parent : Album::getAlbumIdByDirName(substr( $dirname, strrpos($dirname, '/')+1));
						if( !Song::existsInDB( $entry, $id_album  ) ) // Checke si le nom du fichier existe et est lié a l id album
						{
							$src = $dirname .'/'. $entry;
							$info = pathinfo( $dirname .'/'. $entry);
							$dst = _AUDIO_PUBLIC_.'/'.Tools::randGen(3).'_'.Tools::str2url( $info['filename'] ).'.'.$info['extension'];
							if( !symlink( $src, $dst ) )
								d('Fatal Error: Impossible de créer le lien pour '.$dirname.'/'.$entry.'');
							else
							{
								$song = new Song();
								$song->title = $info['filename'];
								$song->id_album = $id_album;
								$song->filename = $info['basename'];
								$song->path = $dst;
								$song->setMetaInformation();
								$song->add(); // AJOUTE SONG
							}

						}
					}
				}
			}
		}
		closedir($dir_handle);

	}

	public function scan()
	{
		$this->recursiveScanning( _AUDIO_ );
		$this->display();
	}

	/**
	 * TO IMPLEMENT
	 * @return [type] [description]
	 */
	public function deleteArtistFull()
	{
		$id_album = Album::getAlbumIdByDirName( 'TestAlbum' );
		$album = new Album($id_album);

		foreach( $album->songs as $song )
		{
			$song = new Song( $song['id_song'] );
			$song->delete();
		}

		$artist = new Artist( $album->id_artist );

		$artist->delete();
		$album->delete();

		$path = _AUDIO_.'/TestAdd';
		$this->deleteDirectory($path) && $this->removeSymLink( );
	}

	/**
	 *  Remove a symlink
	 * @param  string $symlink
	 * @return
	 */
	public function removeSymLink($symlink)
	{

		unlink(_AUDIO_PUBLIC_.'/'.$symlink );
	}


	public function checkalbum()
	{
		$value = $this->request->getValue( 'term' );
		$res = Tools::instantSearch( 'album', 'title', $value );

		die(json_encode($res));
	}

	public function checkartist()
	{
		$value = $this->request->getValue( 'term' );
		$res = Tools::instantSearch( 'artist', 'name', $value );

		die(json_encode($res));
	}

	public function createdirectory()
	{
		$artist = $this->request->getValue('artist');
		$album = $this->request->getValue('album');
		if(Tools::makedir( _AUDIO_TMP_.'/'.$artist, $album ))
			die(json_encode(array('status'=>'success', 'artist' => $artist, 'album' => $album )));
		else
			die(json_encode(array( 'status' => 'error' )));
	}

	public function dirToTree($dir, $recursion = 0)
	{
	   $result = array();
	   $cdir = scandir($dir);
	   $class='';
	   if( $recursion == 1 )
			$class = 'artist';
		elseif( $recursion == 2)
			$class = 'album';

	   $this->html .= '<ul class="'.$class.'">';
	   foreach ($cdir as $key => $value)
	   {
	      if (!in_array($value,array(".","..")))
	      {
	         if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
	         {
	         	$this->html .= '<li class=""><span class="trigger"><span class="ion-ios-folder-outline "></span>'.$value.'</span>';
	           	$this->dirToTree($dir . DIRECTORY_SEPARATOR . $value, $recursion+1);
	         }
	         else
	         {
	            $this->html .= '<li><span class="ion ion-ios-musical-note"></span>' . $value;
	         }
	         $this->html .=   '</li>';
	      }
	   }

		$this->html .= '</ul>';

		return $this->html;
	}


	public function getTree( $dir,  $levelDepth = 0)
	{
		$class='';
		$dirhandle = opendir($dir);
		if( $levelDepth == 1 )
			$class = 'artist';
		elseif( $levelDepth == 2)
			$class = 'album';

		$this->html .= '<ul class="'.$class.'">';
		while( ($entry = readdir( $dirhandle )) )
		{
		 	if( $entry != '.' && $entry != '..' && $levelDepth < 3)
			{
				if( is_dir( $dir.'/'.$entry )){
					$this->html .= '<li class=""><span class="trigger"><span class="ion-ios-folder-outline "></span>'.$entry.'</span>';
					$this->getTree( $dir .'/'. $entry,  $levelDepth+1 );
				}else{
					$this->html .= '<li><span class="ion ion-ios-musical-note"></span>' . $entry;
				}
				$this->html .=   '</li>';
			}
		}

		$this->html .= '</ul>';

		return $this->html;
	}

	public function ajaximport()
	{
		$path = $_POST['artist'] . '/' . $_POST['album'];

		$upload_dir =  _AUDIO_ .'/'. $path.'/';
		$upload_url = 'http://176.31.245.123/stansmith/music/'.$path.'/';
		$options = array('upload_dir'=> $upload_dir, 'upload_url' => $upload_url );

		$upload_handler = new UploadHandler( $options );
		// $this->scan();
	}


	/**
	 *
	 * @param  [type] $dir [description]
	 * @return multidimensionnal
	 */
	public function dirToArray($dir)
	{
	   $result = array();


	   $cdir = scandir($dir);
	   foreach ($cdir as $key => $value)
	   {
	      if (!in_array($value,array(".","..")))
	      {
	         if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
	         {
	            $result[$value] = $this->dirToArray($dir . DIRECTORY_SEPARATOR . $value);
	         }
	         else
	         {
	            $result[] = $value;
	         }
	      }
	   }

	   return $result;
	}

	public function updateMetaYear()
	{
		$id_album  = $this->request->getValue('id_album');
		$meta_year = $this->request->getValue('meta_year');

		$album = new Album($id_album);
		$album->meta_year  = $meta_year;

		if($album->update()){
			echo json_encode(array('id_album'=> $id_album, 'meta_year' => $meta_year));
		}else{
			echo json_encode(array('id_album'=> $id_album, 'meta_year' => $meta_year));
		}
		exit;
	}



	public function searchDiscogs()
	{
		$data = array( 'release_title' => $this->request->getValue('release_title'),
					   'artist'        => $this->request->getValue('artist') );

		$query_str = http_build_query($data);
		$uri = 'https://api.discogs.com/database/search?'.$query_str;
		$client = new DiscogsClient();
		$json = $client->search($uri);

		echo $json;
		exit;
	}
}



