<?php

namespace StanSmith\Controller;

use \StanSmith\Core\Controller;
use \StanSmith\Core\Repository\AlbumRepository;
use \StanSmith\Core\Link;


class StanController extends Controller
{
    public function __construct()
    {
    }

    public function display()
    {
        $link = new Link();
        $repo = new AlbumRepository();
        $albums = $repo->findAll();

        $this->renderView(array('link' => $link, 'albums' => $albums)); 
    }

    public function updateAlbum() 
    {
        $repository = new AlbumRepository();
        $album = $repository->find($this->request->getValue('id_album'));
        // d($album);
        $this->renderView(array('album'=>$album));

    }
}
