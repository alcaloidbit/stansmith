<?php

class Managers
{
	protected $dao; // Data Access Object -> Objet Db
	protected $api; // Quelle API pour l'acces au données ( PDO, MY SQL ) ?


	protected $managers = array();

	public function __construct($api, $dao)
	{
		$this->api = $api;
		$this->dao = $dao;
	}


	public function getManagerOf( $entity )
	{
		if(!is_string($entity) || empty( $entity ) )
		{
			throw new \InvalidArgumentException( 'The Entity is invalid ' );
		}
		if( !isset( $this->managers[$entity] ))
		{
			$manager = $manager.'Manager';
		}
		return $this->managers[ $entity ];
	}
}