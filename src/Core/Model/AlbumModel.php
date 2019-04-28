<?php

namespace StanSmith\Core\Model;

class AlbumModel
{
    public $id_album;

    public $title;

    public $dirname;

    public $id_artist;

    public $meta_year;

    public $songs = array();

    public $images = array();

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
