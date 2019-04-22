<?php

namespace StanSmith\Core;

use \StanSmith\Core\ObjectModel;
use \StanSmith\Core\Validate;

class Album extends ObjectModel
{
	/** @var string Title */
	public $title;

	/**@var int Id_artist */
	public $id_artist;

	/** @var string dirname */
	public $dirname;

	public $songs = array();

	public $images = array();

	public $meta_year;

	/** @var string Object creation date */
	public $date_add;

	/** @var string Object last modification date */
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
		$data = Db::getInstance()->select('SELECT * FROM `image` WHERE `id_album` = '.$this->id.'');
		$this->images = $data;
	}

	/**
	 *  9 sept 2016 ajout de l'attribut deleted dans la Classe Album
	 */
	public static function getAlbums( $start, $limit, $order_by = 'id_album' , $order_way = 'DESC', $id_artist = false)
	{
		return Db::getInstance()->select('SELECT * FROM `album` WHERE `deleted` IS NULL AND `id_album` IN (SELECT `id_album` FROM `image`)'.
											( $id_artist ? 'AND `id_artist` = '.$id_artist.'' : '' )
											.' ORDER BY `'.$order_by.'` '. $order_way .
										  ( $limit > 0 ? ' LIMIT '.(int)($start).','.(int)($limit) : '') .'');
	}

	// VERY TEMPORARY
	public static function getAlbum($id_album)
	{
		return Db::getInstance()->select('SELECT * FROM `album` WHERE `id_album` = '.$id_album.' ');

	}

	public static function getAlbumsNbr()
	{
		return Db::getInstance()->getValue('SELECT count(*) FROM `album` WHERE `deleted` IS NULL');
	}

	public static function getIdImage($id_album)
	{
		return Db::getInstance()->getValue('SELECT `id_image` FROM `image` WHERE `id_album` = '.$id_album.'' );
	}


	public static function getAlbumsWithoutImage()
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


// home/stansmith/public/BHC_test.m4a
