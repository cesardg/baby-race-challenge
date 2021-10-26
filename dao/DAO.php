<?php

class DAO
{

	// Properties
	/*
  	private static $dbHost = "mysql";
	private static $dbName = "int2";
	private static $dbUser = "root";
	private static $dbPass = "devine4life";
	private static $sharedPDO;
	protected $pdo;
	*/

	private static $dbHost = "ID310293_20192020.db.webhosting.be";
	private static $dbName = "ID310293_20192020";
	private static $dbUser = "ID310293_20192020";
	private static $dbPass = "myfirstdb2020";
	private static $sharedPDO;
	protected $pdo;



	// Constructor
	function __construct()
	{

		if (empty(self::$sharedPDO)) {
			self::$sharedPDO = new PDO("mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName, self::$dbUser, self::$dbPass);
			self::$sharedPDO->exec("SET CHARACTER SET utf8");
			self::$sharedPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$sharedPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		}

		$this->pdo = &self::$sharedPDO;
	}

	// Methods

}
