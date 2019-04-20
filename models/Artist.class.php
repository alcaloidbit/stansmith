<?php

class Artist extends ObjectModel
{


	/** @var string Name */
	public $name;

	/** @var string dirname */
	public $dirname;

	/** @var string Object creation date */
	public $date_add;

	/** @var string Object last modification date */
	public $date_upd;


	public static $definition = array(
		'table' => 'artist',
		'primary' => 'id_artist',
		'fields' => array(
			'name' => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 128 , 'validate' => 'isString' ),
			'dirname' => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 128 , 'validate' => 'isString'),
			'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat' ),
			'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat' )
		)
	);

	public function __construct( $id_artist = null , $name = null )
	{
		parent::__construct( $id_artist );

	}

	/**
	 * Get Artists List
	 * @return array Artists list
	 */
	public static function getArtists( )
	{
		$results = Db::getInstance()->select( 'SELECT a.* FROM `artist` a INNER JOIN `album` b 
												ON a.`id_artist` = b.`id_artist` WHERE b.`deleted` IS NULL GROUP BY a.`id_artist` ORDER BY a.`name`' );
		return $results;
	}	


	public static function getArtistsNbr()
	{
		$results = Db::getInstance()->getValue( 'SELECT count(*) FROM `artist` ' );
		return $results;
	}

	public function add( $autodate = true )
	{
		parent::add( $autodate );
	}


	public function update()
	{


	}


	public static function getArtistDirOnDisk()
	{
		$artist_list = array();
		$artists = scandir(_AUDIO_);

		foreach( $artists as $name )
		{
			if(is_dir(_AUDIO_.$name) && $name != '.' && $name != '..')
			{
				$artist_list[] = $name;
			}
		}
		return $artist_list;
	}


	public static function getArtistIdByName($name)
	{

		return Db::getInstance()->getValue('SELECT `id_artist` FROM `artist` WHERE `name`  = \''.mysql_real_escape_string($name).'\'');
	}


	public function getAlbums()
	{
		return Db::getInstance()->select('SELECT * FROM `album` WHERE `id_artist` = '.$this->id.' AND `deleted` IS NULL ORDER BY album.`title`' );
	}
}





