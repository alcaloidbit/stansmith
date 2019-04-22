<?php


namespace StanSmith\HTTPResponse;

class HTTPResponse
{
	protected $page;


	public function  addHeader( $header )
	{
		header( $header);
	}

	public function redirect( $location )
	{
		header('Location:'.$location );
		exit;
	}

	public function setPage( $page )
	{
		$this->page = $page;
	}

	public function send()
	{
		exit( $this->page->getGeneratedPage());
	}

}
