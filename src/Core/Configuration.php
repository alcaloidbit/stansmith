<?php

class Configuration
{
	private static $parameters;


	private static function getParameters()
	{
		if( self::$parameters == null )
		{
			$filePath = 'config/prod.ini';
			if( !file_exists( $filePath )  )
				$filePath = 'config/dev.ini';

			if( !file_exists( $filePath ) )
				throw new Exception( 'Aucun Fichier de Configuration trouvé ');
			else
				self::$parameters = parse_ini_file( $filePath );
		}
		return self::$parameters;
	}


	public static function get($key, $default = null)
	{
		if ( isset(self::$parameters[$key] ) )
			return self::$parameters[$key];
		else
		return $default;
	}

}