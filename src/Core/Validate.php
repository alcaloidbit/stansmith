<?php



namespace StanSmith\Core;

class Validate
{
	public static function isUnsignedId( $value )
	{
		return ( preg_match('#^[0-9]+$#', (string)$value) && $value < 4294967296 && $value >= 0 );
	}

	public static function isBool( $bool )
	{
		return $bool === null || is_bool( $bool ) || preg_match( '/^0|1$/', $bool);
	}

	public static function isDateFormat( $date )
	{
		return (bool)preg_match('/^([0-9]{4})-((0?[0-9])|(1[0-2]))-((0?[0-9])|([1-2][0-9])|(3[01]))( [0-9]{2}:[0-9]{2}:[0-9]{2})?$/', $date);

	}

	public static function isYear($year)
	{
		return (bool)preg_match('/^[12][0-9]{3}$/', $year);
	}

	public static function isString( $data )
	{
		return is_string($data);
	}


	public static function isLoadedObject($object)
	{
		return is_object($object) && $object->id;
	}


}
