<?php

class pdo_oauth_client_class extends database_oauth_client_class
{

    const TYPE_INT = 1;
    const TYPE_BOOL = 2;
    const TYPE_STRING = 3;
    const TYPE_FLOAT = 4;
    const TYPE_DATE = 5;
    const TYPE_HTML = 6;
    const TYPE_NOTHING = 7;


	var $db;
 	var $stmt;
    var $database = array(
        'host'=> _DB_HOST_,
        'user'=> _DB_USER_,
        'password'=> _DB_PASSWD_,
        'name'=> _DB_NAME_,
        'options' => array(
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			)
    );

    Function Initialize()
    {
	    if(!parent::Initialize())
            return false;

		try{
	   		 $this->db = new PDO( 'mysql:host='.$this->database['host'].';dbname='. $this->database['name'].'', $this->database['user'], $this->database['password'], $this->database['options']);
		}
		catch( PDOException $e )
		{
            $this->SetError( $e->getCode() );
            $this->db = null;
            return false;
        }
        return true;
    }

    Function Finalize($success)
    {
        if(IsSet($this->db))
        {
            $this->db = null;
        }
        return parent::Finalize($success);
    }


	Function Bind ($parameter, $value, $var_type = null){
        if (is_null($var_type)) {
            switch (true) {
                case is_bool($value):
                    $var_type = PDO::PARAM_BOOL;
                    break;
                case is_int($value):
                    $var_type = PDO::PARAM_INT;
                    break;
            case is_null($value):
                    $var_type = PDO::PARAM_NULL;
                    break;
                default:
                    $var_type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindParam( $parameter, $value, $var_type);
    }

// PDO::PARAM_NULL = 0
// PDO::PARAM_INT = 1
// PDO::PARAM_STR = 2
// PDO::PARAM_BOOL = 5


    Function Query($sql, $parameters, &$results, $result_types = null)
    {
      if($this->debug)
            $this->OutputDebug('Query: '.$sql);

        $results = array();

        if(!$this->stmt = $this->db->prepare($sql))
            return $this->SetError($this->stmt->errorCode());

        foreach( $parameters as $k => &$p )
        {
            $this->Bind( $k+1, $p );
        }

        if( !$this->stmt->execute() )
        {
            $this->db = null;
            return $this->setError( $this->stmt->ErrorCode() );
        }

        $fields = $this->stmt->columnCount();

        if( $fields )
        {
            $results['rows'] =  $this->stmt->fetchAll( PDO::FETCH_NUM );
        }
        elseif(strlen($error = $this->stmt->errorCode() === FALSE ))
        {
            $statement->close();
            return $this->SetError($error);
        }
        else
        {
            $results['insert_id'] = $this->db->lastInsertId();
            $results['affected_rows'] = $this->stmt->rowCount();


        }
        $this->stmt->closeCursor();
        return true;
    }


}
