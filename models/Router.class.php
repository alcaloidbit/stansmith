<?php



class Router {

  public function route()
  {
    try {
          $request = new HttpRequest( array_merge( $_GET, $_POST ));
          $controller = $this->getController( $request );         // Get Controller according to 'controller' param
          $action = $this->getAction( $request );                 // Get Action according to 'action' param
          $controller->executeAction( $action );                  // Run Action
      }
      catch (Exception $e) {
          $this->handleError($e);
      }
  }

  /**
   * getController, setting default Controller if no param
   *
   */
  private function getController( HttpRequest $request)
  {
      $controller = 'index'; // Default controller

      if( $request->paramExists('controller') )
      {
          $controller = $request->getValue('controller');
      }

      $controller = ucfirst(strtolower($controller) );
      $controllerClass = $controller .'Controller' ;   // Build Controller Class Name


      $controllerFile = _CONTROLLERS_ . $controllerClass . '.class.php';  // Build Controller File ( autoload )

      if (file_exists($controllerFile))
      {
        $controller = new $controllerClass();
        $controller->setRequest( $request );
        return $controller;
      }
      else
        throw new Exception('Fichier '.$controllerFile.' introuvable');
  }

  /**
   * getAction, setting default Action if no param
   * return action
   */
  private function getAction( HttpRequest $request )
  {
    $action = 'display';
    if ( $request->paramExists('action') ) {
      $action = $request->getValue('action' );
    }
    return $action;
  }


  private function handleError(Exception $exception)
  {
      d( $exception );
  }
}