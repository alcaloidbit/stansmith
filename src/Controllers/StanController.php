<?php

namespace StanSmith\Controllers;

use \StanSmith\Core\Controller;
use \StanSmith\Core\Repository\AlbumRepository;


class StanController extends Controller
{
    public function __construct()
    {
    }
    
    public function display()
    {
        $albumRepo = new AlbumRepository();
        $albums = $albumRepo->findAll();
        $this->renderView(array('albums' => $albums));
    }
}
