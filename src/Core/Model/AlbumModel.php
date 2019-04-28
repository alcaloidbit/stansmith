<?php

namespace StanSmith\Core\Model;

class AlbumModel
{
    public $id_album;

    public $title;

    public $dirname;

    public $id_artist;

    public $meta_year;

    public $deleted;

    public $date_add;

    public $date_upd;

    public function __construct($data=null)
    {
        if(is_array($data))
        {
            if(isset($data['id_album']))
                $this->id_album = $data['id_album'];            
            
            $this->title = $data['title'];
            $this->dirname = $data['dirname'];
            $this->id_artist = $data['id_artist'];
            $this->meta_year = $data['meta_year']; 
            $this->deleted = $data['deleted'];
            $this->date_add = $data['date_add'];
            $this->date_upd = $data['date_upd'];
        }
    } 


    public function getTitle()
    { 
        return $this->title;
    }

    public function getCover()
    {
                
    }
    
}
