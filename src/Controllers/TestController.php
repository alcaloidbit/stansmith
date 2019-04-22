<?php


namespace StanSmith\Controllers;

use \StanSmith\Core\Controller;
use \StanSmith\Core\Album;

class TestController extends Controller
{
	public function  __construct()
        {
        }
        
        public function display()
	{
            $data['albums'] = Album::getAlbums();
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
            foreach( $Albums as $a ){
                $album = new Album($a['id_album']);
                $data['albums'][] = $album;
            }
            die(json_encode($data));
        }
	public function detail()
	{
            $id_album = $this->request->getValue('id_album');
            $album = new Album($id_album);

            $data['album'] = $album;

            die(json_encode($data));
	}

}

