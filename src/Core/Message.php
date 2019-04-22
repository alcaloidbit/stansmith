<?php


namespace StanSmith\Core;

use \StanSmith\Core\ObjectModel;
use \StanSmith\Core\Validate;

class Message extends ObjectModel
{
	public $content;
	public $pseudo;
	public $date_add;

	public static $definition = array(
		'table' => 	'IM_message',
		'primary' => 'id_message',
		'fields' => array(
			'content' => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 128, 'validate' => 'isString' ),
			'pseudo' => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 128, 'validate' => 'isString' ),
			'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat' )
		)
	);


	public function __construct( $id_message = null )
	{
		parent::__construct( $id_message );
	}

	public static function getTenLastMessage( )
	{

		$res = Db::getInstance()->select('SELECT * FROM `IM_message` WHERE `date_add` BETWEEN DATE_ADD(NOW(), INTERVAL -4 DAY) and NOW() ORDER BY `id_message` ASC LIMIT 0,10' );

		return $res;
	}

	public static function getLastMsgAfterId( $id )
	{
		$res = Db::getInstance()->select('SELECT `id_message`, `content` as `msg`, `pseudo` , `date_add` FROM `IM_message` WHERE `id_message` > '.$id.' ORDER BY `id_message` ASC ');
		return $res;
	}


	public function add( $autodate = true )
	{
		parent::add( $autodate );
	}



}
