<?php 

namespace StanSmith\Controller;

use \StanSmith\Core\Controller;
use \StanSmith\Core\Album;
use \StanSmith\Core\Link;


class UploadController extends Controller
{
    public function __construct() 
    {
        $this->data['link'] = new Link();
        $this->data['totalReleases'] = Album::getAlbumsNbr();
    }
    public function display()
    {
        $this->data['page_name'] = 'Upload';
        $this->renderView($this->data);
    }
        
}
