<?php

namespace StanSmith\Controller;

use \StanSmith\Core\Controller;
use \StanSmith\Core\Repository\AlbumRepository;
use \StanSmith\Core\Album;
use \StanSmith\Core\Link;


class StanController extends Controller
{
    public $data = array();

    public function __construct()
    {
        $this->data['link'] = new Link();
    }

    public function display()
    {
        $repo = new AlbumRepository();
        $albums = $repo->findAll(); 

        $this->data['albums'] = Album::getAlbums(0, 100);
        $this->renderView($this->data); 
    }

    public function updateAlbum() 
    {
        $album = new Album($this->request->getValue('id_album'));
//        d($album);
        $this->data['album'] = $album;
        $this->renderView($this->data);
    }
}
