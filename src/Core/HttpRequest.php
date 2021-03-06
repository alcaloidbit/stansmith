<?php


namespace StanSmith\Core;

class HTTPRequest
{
    private $params;

    public $request_uri;

    public function __construct( $params )
    {
        $this->params = $params;
    }
    /**
     *  Get a value from $_POST / $_GET
     * @param  string $key key Value
     * @return  mixed Value
     */
    public function getValue( $key )
    {
        if (!isset($key) || empty($key) || !is_string($key))
            return false;

        return isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : null ) ;

    }

    public function getParams()
    {
        return $this->params;
    }

    /**
     * Check if a param exist in $_POST / $_GET
     * @param  string $key param Name
     * @return bool true or false
     */
    public function paramExists( $key )
    {
        // return isset($_POST[$key]) ? true : (isset($_GET[$key]) ? true : false);
        return array_key_exists($key, $_POST) ? true : (array_key_exists($key, $_GET) ? true : false);
    }



    public function setRequestUri()
    {
        $this->request_uri = $_SERVER['REQUEST_Uri'];
    }




}
