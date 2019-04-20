<?php

abstract class Application
{
	protected $httpRequest;
	protected $httpResponse;
	protected $name;


	public function __construct()
	{
		$this->httpRequest = new HTTPRequest;
		$this->httpResponse = new HTTPResponse;

	}

	abstract public function run();
}