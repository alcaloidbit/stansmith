<?php

namespace StanSmith\Core\Model;

use \StanSmith\Core\Db;
use \StanSmith\Core\Image;

class AlbumModel
{
    public $id_album;

    public $title;

    public $dirname;

    public $id_artist;

    public $meta_year;

    public $songs = array();

    public $images = array();
     
    public $artist_name;

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
            $this->artist_name = $data['artist_name'];
            $this->meta_year = $data['meta_year'];
            $this->deleted = $data['deleted'];
            $this->date_add = $data['date_add'];
            $this->date_upd = $data['date_upd'];
            $this->songs = $data['songs'];

        }
    }

    public function setSongs()
    {
        $data = Db::getInstance()->select('SELECT * FROM `song` WHERE `id_album` = '.$this->id_album.' ORDER BY `meta_track_number`, `title` ');

        foreach($data as &$item)
            $item['path'] = substr( $item['path'], strlen(_ROOT_)+1);

        $this->songs = $data;
    }

    public function setImages()
    {
        $id_image = Db::getInstance()->getValue('SELECT `id_image` FROM `image` WHERE `id_album` = '.$this->id_album.' LIMIT 0,1  '); 
        $this->images = new Image($id_image);
    }
     
    public function setArtistName()
    {
        
        $this->artistName = Db::getInstance()->getValue('SELECT `name` FROM `artist` WHERE `id_artist` = '.(int)$this->id_artist.'');
    }


    public function getTitle()
    {

            $this->setSongs();
        }
    }

    public function setSongs()
    {
        $data = Db::getInstance()->select('SELECT * FROM `song` WHERE `id_album` = '.$this->id.' ORDER BY `meta_track_number`, `title` ');

        foreach($data as &$item)
            $item['path'] = substr( $item['path'], strlen(_ROOT_)+1);

        $this->songs = $data;
    }


    public function getTitle()
    {
        return $this->title;
    }
}
