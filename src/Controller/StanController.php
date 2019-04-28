<?php

namespace StanSmith\Controller;

use \StanSmith\Core\Controller;
use \StanSmith\Core\Repository\AlbumRepository;


class StanController extends Controller
{
    public function __construct()
    {
    }

    public function display()
    {
        $repo = new AlbumRepository();
        $albums = $repo->findAll();

        $this->renderView(array('albums' => $albums)); 
    }
}
