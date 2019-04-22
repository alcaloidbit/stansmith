<?php


class Request
{
	private $params;

	public function __construct( $params )
	{
		$this->params = $params;
	}


	public function paramExists( $name )
	{
		return (isset( $this->params[ $name ] ) && $this->params[$name] );
	}

	public function getParam( $name )
	{
		if( $this->paramExists( $name ) )
			return $this->params[$name];
		else
			throw new Exception( 'Parametre '.$name.' absent de la requete ');
	}
}