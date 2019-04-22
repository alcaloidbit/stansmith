<?php


namespace StanSmith\User;

class User extends ObjectModel
{
	public $name;
	public $password;
	public $email;
	
	public static $definition = array(
		'table' => 	'user',
		'primary' => 'id_user',
		'fields' => array(
			'name' => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 128, 'validate' => 'isString' ),
			'email' => array('type' => self::TYPE_STRING, 'required' => true, 'size' => 128, 'validate' => 'isString' ),
			'pasword' => array('type' => self::TYPE_STRING,'required' => true, 'size' => 128, 'validate' => 'isSTring' )
		)
	);


	public function __construct( $id_user = null )
	{
		session_start();
		parent::__construct( $id_user );

		// if( Validate::isLoadedObject( $this ))
		// {
			

		// }
	}

	public function add( $autodate = true )
	{
		parent::add( $autodate );
	}

		

}
