<?php

namespace StanSmith\Controller;

use \StanSmith\Core\Controller;
use \StanSmith\Core\Repository\AlbumRepository;
use \StanSmith\Core\Album;
use \StanSmith\Core\Link;
use \StanSmith\Core\DiscogsClient;


class StanController extends Controller
{
    public $data = array();

    public function __construct()
    {
        $this->data['link'] = new Link();
        $this->data['totalReleases'] = Album::getAlbumsNbr();
    }

    public function display()
    {
        $this->data['albums'] = Album::getAlbums(0, 100);
        $this->renderView($this->data); 
    }

    public function updateAlbum() 
    {
        $album = new Album($this->request->getValue('id_album'));

        if(isset($_POST['updateAlbum']))
        {
            if( $meta_year = $this->request->getValue('album_meta_year')){
                $album->meta_year = $meta_year;
                if($album->update())
                    $this->data['message'] = 'success';
                else
                    $this->data['message'] = 'error';
            }
        }

        $this->data['album'] = $album;
        $this->renderView($this->data);
    }

    public function search()
    {
        $data=array();
         
        $data['release_title']=$this->request->getValue('ds_release_title');
        $data['artist']=$this->request->getValue('ds_artist_name');
       //d($data);
        
        $result = $this->searchDiscogs($data);
        $this->data['discogs_results'] = json_decode($result);
        $this->renderView($this->data);

    }
    
    private function searchDiscogs($param)
    {
        $data = array( 'release_title' => $param['release_title'], 
            'artist' => $param['artist'] );

        $query_str = http_build_query($data);
        $uri = 'https://api.discogs.com/database/search?'.$query_str;
        $client = new DiscogsClient();
        $json = $client->search($uri);
        return $json;
    }
    
}
