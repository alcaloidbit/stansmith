<?php

namespace StanSmith\Controller;

use \StanSmith\Core\Controller;
use \StanSmith\Core\Repository\AlbumRepository;
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
        $this->data['albums'] = $repo->findAll(); 

        $this->renderView($this->data); 
    }

    public function updateAlbum() 
    {
        $repository = new AlbumRepository();
        $album = $repository->find($this->request->getValue('id_album'));
        $this->data['album'] = $album;
            
        $this->renderView($this->data);
    }
}
