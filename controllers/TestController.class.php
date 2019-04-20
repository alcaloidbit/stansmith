<?php


class TestController extends Controller
{
	public function  __construct()
	{
		// $alb = Db::getInstance()->select('SELECT `id_album` FROM  `album` ');

		// $ignore = array(597, 524, 151, 119, 105, 405, 575, 319, 55, 36, 206 );
		// foreach($alb as $a)
		// {
		// 	if(!in_array($a['id_album'], $ignore))
		// 	{
		// 	    $res = Db::getInstance()->getValue('select `meta_year` from song where id_album = '.$a['id_album'].' ');

		// 		$album = new Album($a['id_album']);
		// 		$album->meta_year = $res;
		// 		$album->update();
		// 		// d($album);
		// 	}
		// }

		// die('here');
	}

	public function display()
	{
		$data['albums'] =   Album::getAlbums();
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
		$album = new Album( $id_album );

		$data['album'] = $album;

		die(json_encode($data));
	}

}

