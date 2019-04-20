<?php

class Song extends ObjectModel
{
	/** @var string Title */
	public $title;

	/** @var int Id_album */
	public $id_album;

	/** @var string filename with extension */
	public $filename;

	/** @var string Path */
	public $path;

	public $meta_title;

	public $meta_artist;

	public $meta_album;

	public $meta_track_number;

	public $meta_year;

	/** @var string Object creation date */
	public $date_add;

	/** @var string Object last modification date */
	public $date_upd;

	public static $definition = array(
		'table' => 'song',
		'primary' => 'id_song',
		'fields' => array(
			'title'    => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 128, 'validate' => 'isString' ),
			'filename' => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 128, 'validate' => 'isString' ),


			'meta_title' => array('type' => self::TYPE_STRING, 'required' => false, 'size' => 128, 'validate' => 'isString' ),
			'meta_artist' => array('type' => self::TYPE_STRING, 'required' => false, 'size' => 128, 'validate' => 'isString' ),
			'meta_album' => array('type' => self::TYPE_STRING, 'required' => false, 'size' => 128, 'validate' => 'isString' ),
			'meta_track_number' => array('type' => self::TYPE_INT, 'required' => 'false', 'size' => 7, 'validate' => 'isUnsignedId' ),
			'meta_year' => array('type' => self::TYPE_INT, 'required' => 'false', 'size' => 8, 'validate' => 'isYear' ),


			'path'     => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 128, 'validate' => 'isString' ), // TODO : Change Validation  Rule to isPath()

			'id_album' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId' ),
			'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat' ),
			'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat')

		)
	);


	public function __construct( $id_song = null , $name = null)
	{
		parent::__construct( $id_song );

	}


	/** FOR USE WITH OBJECT MODEL HYDRATE FUNCTION  */
	public function setId( $id_song )
	{
		$this->id = $id_song;
	}

	/** FOR USE WITH OBJECT MODEL HYDRATE FUNCTION  */
	public function setFileName( $filename )
	{
		$this->filename = $filename;
	}

	/** FOR USE WITH OBJECT MODEL HYDRATE FUNCTION  */
	public function setName( $title )
	{
		$this->title = $title;
	}

	/** FOR USE WITH OBJECT MODEL HYDRATE FUNCTION  */
	public function setPath( $path )
	{
		$this->path = $path;
	}

	/** FOR USE WITH OBJECT MODEL HYDRATE FUNCTION  */
	public function setIdAlbum( $id_album )
	{
		$this->id_album = $id_album;
	}



	/** Use this tool when importing new Songs */
	public function setMetaInformation()
	{
		$obj = new AudioInfo();
		$infos = $obj->Info($this->path);

		if( array_key_exists( 'format_name', $infos ))
		{
			switch($infos['format_name'])
			{
				case 'MP3' :
					$data = $infos['tags']['id3v2'];
					break;
				case 'Ogg Vorbis' :
					$data = $infos['tags']['vorbiscomment'];
					break;
				case 'mp4/mp4/quicktime':
					$data = $infos['tags']['quicktime'];
					break;
			}

			$this->meta_title        =  array_key_exists('title', $data) ? $data['title'][0] : '';
			$this->meta_artist       =  array_key_exists('artist', $data) ? $data['artist'][0] : '';
			$this->meta_album        =  array_key_exists('album', $data) ? $data['album'][0] : '';
			$this->meta_track_number =  Tools::formatTrackNumber($data);
			$year = Tools::formatTrackYear($data);
			if(!$year)
				$this->meta_year  = 0;
			else
				$this->meta_year = $year;
		}


	}


	public function add( $autodate = true )
	{
		parent::add( $autodate );

	}

	public function update()
	{
		return parent::update();
	}

	public static function existsInDB($filename , $id_album)
	{
		$row = Db::getInstance()->getValue('SELECT `id_song` FROM `song` WHERE `filename` = \''.mysql_real_escape_string($filename).'\' AND `id_album` = '.(int)$id_album.'');
		return $row;
	}

	public function getPath()
	{
		return $this->path;
	}

	public function delete()
	{
		$path = $this->getPath();
		$target = readlink($path);
		unlink($target);
		unlink($path);
		parent::delete();
	}

}
