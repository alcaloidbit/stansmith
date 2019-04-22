<?php

abstract class EntityManager
{
	protected $_db;

	public function __construct($dao)
	{
		$this->$_db = $dao;
	}

	public function add()
	{

	}

	public function delete()
	{

	}

	public function update()
	{

	}

	public function get()
	{

	}

	abstract public function getList();


	public function setDb( PDO $db )
	{
		$this->_db = $db;
	}

}