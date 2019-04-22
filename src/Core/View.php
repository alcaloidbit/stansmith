<?php

namespace StanSmith\Core;

class View
{
	private $contentFile;

	private $layout;

	protected $vars = array();


	public function __construct(  $action, $controller = '' )
	{
		$file = _VIEWS_;
		if( $controller != '' )
			$file = $file . strtolower($controller) .'/';

		$this->layout = $file.'template.php';
		$this->contentFile = $file . $action . '.php';

	}


	public function assign( $var, $value )
    {
	    if (!is_string($var) || is_numeric($var) || empty($var) )
	    {
	      throw new \InvalidArgumentException('Le nom de la variable doit être une chaine de caractère non nulle');
	    }

	    $this->vars[$var] = $value;
	}

	public function generate( )
	{
		$view = $this->generateFile();
		echo $view;
	}

	private function generateFile( )
	{
		if( file_exists( $this->contentFile ) )
		{
			extract ( $this->vars );
			ob_start();
			require $this->contentFile;
			$content  =  ob_get_clean();

			ob_start();
			require $this->layout;
			return ob_get_clean();
		}
		else
		{
			throw new \Exception( ' Fichier '. $this->contentFile .' introuvable');
		}
	}
}


