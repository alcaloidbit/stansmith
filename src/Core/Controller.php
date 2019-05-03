<?php

namespace StanSmith\Core;
use \StanSmith\Core\View;
use \StanSmith\Core\HttpRequest;

abstract Class Controller
{
    private $action;

    protected $request;

    protected $view;

    public function setRequest( \StanSmith\Core\HttpRequest $request )
    {
        $this->request = $request;
    }

    public function executeAction(  $action )
    {
        if(method_exists( $this, $action ))
        {
            $this->action = $action;
            $this->{$this->action}();
        }
        else
        {
            $controllerClass = get_class( $this );
            throw new \Exception( 'Action '.$action.' non définie dans la classe '.$controllerClass.'' );
        }
    }

    public abstract function display();


    protected function renderView( $data = array() )
    {
        $controllerClass = get_Class( $this );
        $path = explode( '\\', $controllerClass);
        $controllerClass = array_pop($path);
        $controller = str_replace( 'Controller', '', $controllerClass );

        $this->view = new View( $this->action,  $controller );

        foreach ( $data as $key => $value )
            $this->view->assign( $key, $value );

        $this->view->generate();
    }
}
