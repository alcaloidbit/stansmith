<?php


class DiscogsRelease extends ObjectModel
{
	public $id_album;

	public $catno;

	public $genre;

	public $style;

	public $title;

	public $year;

	public $label;


	/** @var string Object creation date */
	public $date_add;

	/** @var string Object last modification date */
	public $date_upd;

	public static $definition = array(
		'table' => 'discogs_release',
		'primary' => 'id_discogs_release',
		'fields' => array(
			'id_album' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'  ),
			'catno' => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 64, 'validate' => 'isString' ),
			'genre' => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 256, 'validate' => 'isString' ),
			'style' => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 256, 'validate' => 'isString' ),
			'title' => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 256, 'validate' => 'isString' ),
			'year' => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 4,  'validate' => 'isYear' ),
			'label' => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 256, 'validate' => 'isString' ),

			'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat' ),
			'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat' )
		)
	);



	public function __construct( $id_discogs_release = null )
	{
		parent::__construct( $id_discogs_release);

		if( Validate::isLoadedObject( $this ))
		{

		}
	}

	public function add($autodate=true)
	{
		return parent::add($autodate);
	}
}