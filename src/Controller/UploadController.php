<?php 

namespace StanSmith\Controller;

use \StanSmith\Core\Controller;
use \StanSmith\Core\Album;
use \StanSmith\Core\Link;
use \StanSmith\Core\UploadHandler;



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

    public function import() 
    {
        $path = $this->request->getValue('add_artist_name'). '/' . $this->request->getValue('add_album_title');  

        $upload_dir = _AUDIO_.'/'.$path.'/';
        $upload_url = _BASE_URI_ .'/music/'.$path.'/';

        $options = array('upload_dir'=>$upload_dir, 'upload_url' => $upload_url );

        $upload_handle = new UploadHandler($options);
    }

    public function logResults() 
    {
      $this->renderView($this->data); 
    }
        
}
