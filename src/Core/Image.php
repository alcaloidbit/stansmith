<?php


namespace StanSmith\Core;
use \StanSmith\Core\ObjectModel;

class Image extends ObjectModel
{
	public $id;

	public $id_album;

	public $extension;

	public $width;

	public $height;

	public  $date_add;

	public $date_upd;


	public static $definition = array(
		'table' => 'image',
		'primary' => 'id_image',
		'fields' => array(
			'id_album' => array('type' => self::TYPE_INT, 'required' => false, 'validate' => 'isUnsignedId' ),
			'extension' => array('type' => self::TYPE_STRING, 'required' => true, 'validate' => 'isString' ),
			'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat' ),
			'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat' )
		));


	public function __construct( $id_image = null  )
	{
		parent::__construct( $id_image );
	}

	public function delete()
	{
		$this->deleteImage();
		parent::delete();
	}



	public function add( $autodate = true )
	{
		parent::add( $autodate );
	}

	public function setId( $id_image )
	{
		$this->id = $id_image;

	}
	public function setIdAlbum( $id_album )
	{
		$this->id_album = $id_album;
	}

	public function setExtension( $extension )
	{
		$this->extension = $extension;
	}
	public function setWidth( $width )
	{
		$this->width = $width;
	}
	public function setHeight( $height )
	{
		$this->height = $height;
	}
	/*
	*	Return all available Images
	*/
	public function getImages()
	{
		$res = Db::getInstance()->select( 'SELECT * FROM `image`');
	}


	public function deleteImage()
	{
		unlink( _IMAGE_.'/'.$this->id.$this->extension.'');
		unlink( _IMAGE_.'/small/'.$this->id.'_small'.$this->extension.'');
	}
}
