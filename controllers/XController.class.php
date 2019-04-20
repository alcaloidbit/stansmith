<?php


class XController extends Controller
{
	public function  __construct()
	{


	}

	public function display()
	{
		if($this->request->paramExists('id_album'))
		{
			// VERY TEMPORARY
			$data['albums'] = Album::getAlbum($this->request->getValue('id_album'));
		}
		else
		{
			$total_releases = Album::getAlbumsNbr();
			$nb_pages = ceil($total_releases / 12);

			$p = 0;
			if($this->request->paramExists('p'))
				$p = $this->request->getValue('p');

			$data['next_page'] = $p + 1;
			$data['albums'] =  Album::getAlbums( 0, 12 ,'id_album', 'DESC');
		}
		$this->renderView( $data );
	}


	public function test()
	{
		$id_album = $this->request->getValue('id_album');
		$data['album'] = new Album( $id_album );
		$this->renderView( $data );

	}

	public function ajax()
	{
		$albums = Album::getAlbums();
		foreach( $albums as $a ){
			$album = new Album( $a['id_album']);
			$data['albums'][] = $album;
		}
		die(json_encode($data));
	}

	public function detail()
	{
		$id_album = $this->request->getValue('id_album');
		$data['album'] = new Album( $id_album );

		die(json_encode($data));
	}



	public function getArtistsList()
	{
		$artists = Artist::getArtists();

		$artistsList = array();

		foreach( $artists as $a )
		{
			$artist = new Artist( $a['id_artist'] );
			$artistsList[$artist->id] = $artist->name;
		}

		return $artistsList;
	}

	public function getAlbumsbyArtist()
	{
		$id_artist = $this->request->getValue('id_artist');
		$albums = Album::getAlbums(0, 1000, 'id_album', 'DESC', $id_artist);

		foreach($albums as $a)
		{
			$album = new Album($a['id_album']);
			$album->title = Tools::truncate($album->title, 40, '...');
			$album->artistName = Tools::truncate($album->artistName, 40, '...');
			$data['albums'][] = $album;
			
		}
		die(json_encode($data));
	}


	public function ajaxGetNextHtml()
	{
		// HTML DATA
		$html = '';
		$p = $this->request->getValue('p');
		$albums = Album::getAlbums( $p*12, 12 );
		foreach( $albums as $a )
		{
			$album = new Album( $a['id_album']);
			$html .= '<li class="'.$album->id_artist.' item">
								<div class="thumbnail">
								<a class=" ajax" title="'.$album->title.'"  rel="album_'.$album->id.'" >
				             				<img src="images/'.$album->images[0]['id_image'].$album->images[0]['extension'].'" />
											<div class="caption glass">
												<span class="info">'.$album->artistName.'</span>
												<span class="info">'.Tools::truncate($album->title, 40, '...').'</span>
												<span class="utils utils-left play"  rel="album_'.$album->id.'" ><i class="fa-play-circle-o fa fa-3x"></i></span>
												<span class="utils utils-right see"  rel="album_'.$album->id.'" ><i class="fa-info-circle fa fa-3x"></i></span>
											</div>
								</a>
								</div>
						  </li>';
		}
		echo $html;
		exit;
	}

	public function ajaxGetNextJson()
	{
		$p = $this->request->getValue('p');
		if( $albums = Album::getAlbums( $p*12, 12 )){

			foreach ($albums as $a)
			{
				$album = new Album($a['id_album']);
				$album->title = Tools::truncate($album->title, 40, '...');
				$album->artistName = Tools::truncate($album->artistName, 40, '...');
				$data['albums'][] = $album;
			}

			die(json_encode($data));
		}
		else
		{
			die(json_encode(array('theEND')));
		}
	}
}