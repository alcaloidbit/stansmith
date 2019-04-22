<?php


/**
 *  To prevent SQL Injection, do 'NEVER TRUST USER INPUT' !!
 *  - Cast any user entry with (int) $_GET['id'] or intval( $_GET['id'] )
 *
 * **/

namespace StanSmith\Core;

class Db {

	protected static $instance;
	private  $link;

	private $stmt;
	private $error;

	public function __construct()
	{
            $this->link = $this->connect();

	}

	protected function connect()
	{
		try
		{
			$options = array(
			\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
			);

			$connexion = new \PDO( 'mysql:host='._DB_HOST_.';dbname='._DB_NAME_.'', _DB_USER_, _DB_PASSWD_, $options );

		}
		catch( \PDOException $e )
		{
			 $this->error = $e->getMessage();
			
		}
		return $connexion;
	}

	public static function getInstance()
	{
		if( !isset( self::$instance ) )
			self::$instance = new Db();
		return self::$instance;
	}

	protected function _escape( $str )
	{
		$search = array("\\", "\0", "\n", "\r", "\x1a", "'");
		$replace = array("\\\\", "\\0", "\\n", "\\r", "\Z", "\'" );
		return str_replace($search, $replace, $str);
	}

	public function getRow( $sql )
	{
		$sql .= ' LIMIT 0,1';
		// d($sql);
		$result = $this->link->query( $sql );
		return $result->fetch(\PDO::FETCH_ASSOC);
	}

	public function select( $query, $fetchMode = \PDO::FETCH_ASSOC )
	{
		$results = $this->link->query( $query  );
		return $results->fetchAll($fetchMode) ;
	}

	public function bind($param, $value, $type = null)
	{
     	if (is_null($type)) {
        	switch (true) {
            	case is_int($value):
                	$type = \PDO::PARAM_INT;
                	break;
            	case is_bool($value):
                	$type = \PDO::PARAM_BOOL;
                	break;
            	case is_null($value):
                	$type = \PDO::PARAM_NULL;
                	break;
            	default:
                	$type = \PDO::PARAM_STR;
        	}	
    	}
    	$this->stmt->bindValue($param, $value, $type);
	}

	public function execute()
	{
		return $this->stmt->execute();
	}
	

	public function query($query){
		$this->stmt = $this->link->prepare($query);
	}

	public function	Insert_ID()
	{
		return $this->link->lastInsertId();
	}


	public function getValue($query, $fetchMode = \PDO::FETCH_ASSOC)
	{
		$resource = $this->link->query( $query );
		$result = $resource->fetch($fetchMode);
		if(!$result)
			return false;
		return array_shift($result);
	}


	public function insert( $table,  $data)
	{
		
		list( $fields, $placeholders, $values ) = Db::getInstance()->prep_query($data);

		$this->stmt = $this->link->prepare("INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})");

		foreach($values as $k =>$v){
			$this->bind(':'.$k, $v );
		}
	
		$this->stmt->execute();

		// Check for successful insertion
		if ( $this->stmt->rowCount() ) {
			return true;
		}
			
		return false;
	}

	private function ref_values($array) {
			$refs = array();
			foreach ($array as $key => $value) {
				$refs[$key] = &$array[$key]; 
			}
			return $refs; 
		}

	public function prep_query(array $data , $type = 'UPDATE')
	{
			$fields = '';
			$placeholders = '';
			$values = array();
			
			// Loop through $data and build $fields, $placeholders, and $values			
			foreach ( $data as $field => $value ) {
				$fields .= "{$field},";
				$values[$field] = $value;				
				if ( $type == 'UPDATE') {
					$placeholders .= ':'. $field . ',';
				} else {
					$placeholders .= '?,';
				}
			}

			// Normalize $fields and $placeholders for inserting
			$fields = substr($fields, 0, -1);
			$placeholders = substr($placeholders, 0, -1);


 			return array( $fields, $placeholders, $values );
	}

	// public function insert( $table, array $data)
	// {
		// $req = 'INSERT INTO `'.$table.'` (';

		// foreach( $data as $key => $value )
		// {
		// 	$keys[]	= '`'.$key.'`';
		// 	$values[] = '\''.stripslashes(mysql_real_escape_string($value)).'\'';
		// }
		// $req .= implode( $keys, ',') .') VALUES ('.implode($values, ',').')';

		// try{
		// // d($req);
		// 	$this->link->exec($req);
		// }catch(Exception $e){
		// 	echo 'Erreur :'.$e->getMessage().'<br />';
		// 	echo 'N°:' .$e->getCode();
		// }
		// return true;

		//
	// }


	public function update($table, $data, $where = '', $limit = 0)
	{
		if (!$data)
			return true;
		// the table name should be protected ( see bsSQL in PrestaShop )
		$sql = 'UPDATE `'.bqSQL($table).'` SET ';
		foreach ($data as $key => $value)
		{
			if (!is_array($value))
				$value = array('type' => 'text', 'value' => $value);
			if ($value['type'] == 'sql')
				$sql .= '`'.bqSQL($key)."` = {$value['value']},";
			else
				$sql .= ($value['value'] === '' || is_null($value['value'])) ? '`'.bqSQL($key).'` = NULL,' : '`'.bqSQL($key).'` = \''.mysql_real_escape_string($value['value']).'\',';
		}
		$sql = rtrim($sql, ',');

		if ($where)
			$sql .= ' WHERE '.$where;
		if ($limit)
			$sql .= ' LIMIT '.(int)$limit;


		return  (bool)$this->link->query($sql);
	}

	public function exec( $sql )
	{
		$this->link->exec( $sql );
	}

	public function q($sql)
	{
		return $this->link->query($sql);
	}


	/**
	 * Execute a DELETE query
	 *
	 * @param string $table Name of the table to delete
	 * @param string $where WHERE clause on query
	 * @param int $limit Number max of rows to delete
	 * @return bool
	 */
	public function delete($table, $where = '', $limit = 0 )
	{
		$sql = 'DELETE FROM `'.$table.'`'.($where ? ' WHERE '.$where : '').($limit ? ' LIMIT '.(int)$limit : '');
		$res = $this->link->query($sql);
		return (bool)$res;
	}



	/**
	 * Execute a prepared DELETE Query
	 * @param  string $table  table name on witch we make the Query
	 * @param  string $param  name of the field
	 * @param  string $value value WHERE CLAUSE
	 * @param  string $param_type  \PDO::PARAM_TYPE
	 * @return  boolean false if request fails
	 */
	public function delete_( $table,  $param , $value, $param_type )
	{
		$stmt = $this->link->prepare('DELETE FROM `'.$table.'` WHERE `'.$param.'` = :value');
		$stmt->bindParam( ':value', $value, $param_type );
		if( !$stmt->execute() )
			return false;
		return true;
	}


	public function selectAll( $table )
	{
		$stmt = $this->link->prepare('SELECT * FROM `'.$table.'` ');
		$stmt->execute();
		$results = $stmt->fetchAll();
		return $results;
	}

	/**
	 * get a single Value
	 * @return value
	 */
	public function getValue_()
	{

	}

	/**
	 * Perform a Count Query
	 * see http://stackoverflow.com/questions/883365/row-count-with-pdo
	 */
	public function getNumRows()
	{

	 	Db::getInstance()->q('SELECT count(*) FROM album WHERE id_album BETWEEN 450 AND 636')->fetchColumn();
	}


	/**
	 * Sanitize data which will be injected into SQL query
	 *
	 * @param string $string SQL data which will be injected into SQL query
	 * @param boolean $html_ok Does data contain HTML code ? (optional)
	 * @return string Sanitized data
	 */
	public function escape($string, $html_ok = false)
	{
		if (_MAGIC_QUOTES_GPC_)
			$string = stripslashes($string);
		if (!is_numeric($string))
		{
			$string = $this->_escape($string);
			if (!$html_ok)
				$string = strip_tags(Tools::nl2br($string));
		}

		return $string;
	}
}
