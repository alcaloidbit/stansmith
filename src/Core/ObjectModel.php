<?php


namespace StanSmith\Core;

abstract class ObjectModel
{
	/** @var int Object id */
	public $id;

	/** @var Db An instance of db in order to avoid calling Db::getInstance() thousands of time */
	protected static $db = false;

	protected static $fieldsRequiredDatabase = null;

	/**
	 *
	 * List of field types
	 */
	const TYPE_INT = 1;
	const TYPE_BOOL = 2;
	const TYPE_STRING = 3;
	const TYPE_FLOAT = 4;
	const TYPE_DATE = 5;
	const TYPE_HTML = 6;
	const TYPE_NOTHING = 7;


	public function __construct( $id = null, array $data = array() )
	{
		if( !ObjectModel::$db )
			ObjectModel::$db = Db::getInstance();

		$this->def = ObjectModel::getDefinition( $this ); //getDefinition uses Reflexion Mechanism

		if( $id )
		{
			$sql = ' SELECT * FROM `'.$this->def['table'].'` a WHERE a.`'.$this->def['primary'].'` = '.$id.'' ;
			if( $object_datas = ObjectModel::$db->getRow( $sql ))
			{
				$this->id = (int)$id;
				foreach ($object_datas as $key => $value)
					if (property_exists( $this, $key ))
						$this->{$key} = $value;
			}
		}
	}

	protected function hydrate( array $data )
	{
		foreach( $data as $key => $val )
		{
			$method = 'set'.ucfirst( $key );
			if( method_exists( $this, $method ) )
			{
				$this->$method( $val );
			}
		}
	}

	public function delete()
	{
		if( !ObjectModel::$db )
			ObjectModel::$db = Db::getInstance();

		$result = true;
		$result &= ObjectModel::$db->delete( $this->def['table'], '`'.$this->def['primary'].'` = '.(int) $this->id );
	}

	public function add( $autodate = true )
	{
		if($autodate && property_exists( $this, 'date_add' ) )
			$this->date_add = date('Y-m-d H:i:s');
		if($autodate && property_exists( $this, 'date_upd') )
			$this->date_upd = date('Y-m-d H:i:s');

		if( isset( $this->id ) )
			unset( $this->id );

		if ( !$result = ObjectModel::$db->insert( $this->def['table'], $this->getFields() ))
			return false;
		// Get object id in database
		$this->id = ObjectModel::$db->Insert_ID();
		return $result;
	}

	public function update()
	{
		if (!ObjectModel::$db)
			ObjectModel::$db = Db::getInstance();

		// Automatically fill dates
		if (array_key_exists('date_upd', $this))
		{
			$this->date_upd = date('Y-m-d H:i:s');
			if (isset($this->update_fields) && is_array($this->update_fields) && count($this->update_fields))
				$this->update_fields['date_upd'] = true;
		}

				// Database update
		if (!$result = ObjectModel::$db->update($this->def['table'], $this->getFields(), '`'.$this->def['primary'].'` = '.(int)$this->id, 0))
			return false;


		return $result;
	}
	public static function getDefinition( $class )
	{
		if(is_object( $class ))
			$class = get_class( $class );

		$reflection = new \reflectionClass( $class );
		$definition = $reflection->getStaticPropertyValue('definition');

		$definition['classname'] = $class;

		return $definition;
	}

	/**
	 * Format a data
	 *
	 * @param mixed $value
	 * @param int $type
	 */
	public static function formatValue($value, $type, $with_quotes = false)
	{
		switch ($type)
		{
			case self::TYPE_INT :
				return (int)$value;

			case self::TYPE_BOOL :
				return (int)$value;

			case self::TYPE_FLOAT :
				return (float)str_replace(',', '.', $value);

			case self::TYPE_DATE :
				if (!$value)
					return '0000-00-00';
				return  $value;

			case self::TYPE_HTML :
				return $value;

			case self::TYPE_NOTHING :
				return $value;

			case self::TYPE_STRING :
			default :
				return $value;
		}
	}

	/**
	 * check object's properties
	 * @return array array of object's properties
	 */
	public function formatFields()
	{
		$fields = array();
		// Set primary key in fields
		if (isset($this->id))
			$fields[$this->def['primary']] = $this->id;

		foreach ($this->def['fields']  as $field => $data )
		{
			$value = $this->$field;

			$fields[$field] = ObjectModel::formatValue( $value, $data['type'] );
		}
		return $fields;
	}

	public 	function getFields()
	{
		$this->validateFields();
		$fields = $this->formatFields( );

		// Ensure that we get something to insert
		if (!$fields && isset($this->id) )
			$fields[$this->def['primary']] = $this->id;

		return $fields;
	}


	public function validateFields( $error_return = true )
	{
		foreach($this->def['fields'] as $field => $data )
		{
			$message =  $this->validateField( $field, $this->$field );
			if( $message !== true )
			{
				return $error_return ? $message : false;
			}
		}
	}

	public function validateField( $field, $value )
	{
		$data = $this->def['fields'][$field];

		// Ici on  gère Required et Size
		if( (!empty($data['required'])) )
			if( Tools::isEmpty( $value ) )
				return 'Property '.get_class($this).'->'.$field.' is empty';

		if( !empty( $data['size'] ))
		{
			$size = $data['size'];
			if ( !is_array($data['size']))
				$size = array('min' => 0, 'max' => $data['size']);
					$length = strlen( $value );
			if ($length < $size['min'] || $length > $size['max'])
			{
				return 'Property '.get_class( $this ). '->' .$field.' length ('.$length.') must be between '.$size['min'].' and '.$size['max'] ;
			}
		}

		if( !empty($data['validate'] ) )
		{
			if( !method_exists( 'Validate', $data['validate'] ))
				throw new Exception( 'Methode  '.$data['validate'].' non trouvé dans la classe ' );

			if( !empty( $value ) )
			{
				$res = true;
				if( !call_user_func( array( 'Validate', $data['validate'] ), $value ))
					$res = false;
				if( !$res )
					return 'Property'.get_class( $this ).' -> '.$field.' is not Valid';
			}
		}
		return true;
	}
}
