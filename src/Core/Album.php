<?php 

namespace StanSmith\Core; 

use \StanSmith\Core\ObjectModel;
use \StanSmith\Core\Validate;

class Album extends ObjectModel
{
    /** @var string Title */
    public $title;

    /** @var int id_artist */
    public $id_artist;

    /** @var string dirname */
    public $dirname;

    public $songs = array();

    public $images = array();

    public $meta_year;

    public $date_add;

    public $date_upd;

    public static $definition = array(
        'table' => 'album',
        'primary' => 'id_album',
        'fields' => array(
            'title' => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 128, 'validate' => 'isString' ),
            'dirname' => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 128, 'validate' => 'isString' ),
            'id_artist' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'  ),
            'meta_year' => array('type' => self::TYPE_INT, 'required' => 'false', 'size' => 8, 'validate' => 'isYear' ),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat' ),
            'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat' )
        )
    );

    public function __construct( $id_album = null , $name = null)
    {
        parent::__construct( $id_album );

        if( Validate::isLoadedObject( $this ))
        {
            $this->setArtistName();
            $this->setSongs();
            $this->setImages();
        }
    }

    /**
     * setArtistName
     *
     */
    public function setArtistName()
    {
        $this->artistName = Db::getInstance()->getValue('SELECT `name` FROM `artist` WHERE `id_artist` = '.(int)$this->id_artist.'');
    }

    public function setSongs()
    {
        $data = Db::getInstance()->select('SELECT * FROM `song` WHERE `id_album` = '.$this->id.' ORDER BY `meta_track_number`, `title` ');

        foreach($data as &$item)
        {
            $item['path'] = substr( $item['path'], strlen(_ROOT_)+1);
        }

        $this->songs = $data;
    }

    public function setImages()
    {
        $data = Db::getInstance()->getValue('SELECT `id_image` FROM `image` WHERE `id_album` = '.$this->id.' LIMIT 0,1 ');
        $this->images = new Image($data);
    }

    public static function getAlbumProperties(&$row)
    {
        $row['artist_name'] = Album::getArtistName($row['id_artist']);
        $row['image'] = Album::getCoverImage($row['id_album']);
        return $row;
    } 

    public static function getArtistName($id_artist)
    {
        return Db::getInstance()->getValue('SELECT `name` FROM `artist` WHERE `id_artist` = '.$id_artist.'');
    }


    public static function getCoverImage($id_album)
    {
        return Db::getInstance()->getRow('SELECT `id_image`, `extension` FROM `image` WHERE `id_album` = '.$id_album.'');
    }

    /**
     * getAlbums
     *
     * @param int $start Start number
     * @param int $limit Number of Album to return
     * @param string $order_by Field for ordering
     * @param string $order_way Way for ordering
     * @param int $id_artist Only artist's albums
     * @return array Albums Details 
     */
    public static function getAlbums($start, $limit, $order_by = 'id_album' , $order_way = 'DESC', $id_artist = false)
    {
        $results = Db::getInstance()->select(
            'SELECT * FROM `album` WHERE `deleted` IS NULL 
            AND `id_album` IN (SELECT `id_album` FROM `image`)'.
            ( $id_artist ? 'AND `id_artist` = '.$id_artist.'' : '' )
            .' ORDER BY `'.$order_by.'` '. $order_way .
            ( $limit > 0 ? ' LIMIT '.(int)($start).','.(int)($limit) : '') .''
        );

        foreach($results as &$album) {
            Album::getAlbumProperties($album);
        }

        return $results;
    }

    public static function getAlbum($id_album)
    {
        $results = Db::getInstance()->select('SELECT * FROM `album` WHERE `id_album` = '.$id_album.' ');
        return $results;
    }

    public static function getAlbumsNbr()
    {
        $results = Db::getInstance()->getValue('SELECT count(*) FROM `album` WHERE `deleted` IS NULL');
        return $results;
    }

    public static function getIdImage($id_album)
    {
        $results =  Db::getInstance()->getValue('SELECT `id_image` FROM `image` WHERE `id_album` = '.$id_album.'' );
        return $results;
    }


    public static function getalbumswithoutimage()
    {
        $res = Db::getInstance()->select('SELECT * FROM album a
            LEFT JOIN artist b ON a.id_artist = b.id_artist
            WHERE a.id_album not in (select id_album from image)' );
        foreach( $res as &$ent )
            $ent['songs'] = Db::getInstance()->select('SELECT * FROM song WHERE id_album = '.$ent['id_album'].'');

        return $res;
    }

    public function add( $autodate = true )
    {
        parent::add( $autodate );
    }


    public static function getAlbumsFull()
    {
        $res = Db::getInstance()->select('SELECT a.id_album, a.title, a.dirname, a.id_artist, b.name  FROM album a
            LEFT JOIN artist b ON a.id_artist = b.id_artist
            WHERE a.id_album NOT IN (SELECT `id_album` FROM `image` )
            ' );
        // foreach( $res as &$ent )
        // $ent['songs'] = Db::getInstance()->select('SELECT * FROM song WHERE id_album = '.$ent['id_album'].'');

        return $res;
    }

    public static function existsInDB($dirname, $id_artist)
    {
        $row = Db::getInstance()->getValue('SELECT `id_album` FROM `album` WHERE `dirname` = \''.mysql_real_escape_string($dirname).'\' AND `id_artist`= '.(int)$id_artist.'' );
        return $row;
    }


    public static function getAlbumIdByDirName( $title )
    {
        $res  = Db::getInstance()->getValue('SELECT `id_album` FROM `album` WHERE `dirname`  = \''.mysql_real_escape_string($title).'\' ');
        return $res;
    }


    public function getImage()
    {
        $res = Db::getInstance()->getValue('SELECT * FROM `image` WHERE `id_album` = '.$this->id.'');
        return $res;
    }


    public function delete()
    {
        $artist = new Artist($this->id_artist);
        $path = _AUDIO_ .'/' .$artist->dirname.'/'.$this->dirname;

        Tools::deleteDirectory($path, true);

        $image = new Image($this->getImage());
        $image->delete();

        parent::delete();
    } 
}


