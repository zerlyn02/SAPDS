<?php
class Database
{
	private static $dbName = 'sapds';
	private static $dbHost = 'sapds.c7y6kwyygqfb.ap-southeast-1.rds.amazonaws.com';
	private static $dbUsername = 'root';
	private static $dbUserPassword = 'zerlynfyp';
	private static $port = '3306';
	private static $cont = null;

	public function __construct() {
		die('Init function is not allowed');
	}

	public static function connect()
	{
		if (null == self::$cont) {     
			try {
				self::$cont = new PDO(
					"mysql:host=" . self::$dbHost . ";port=" . self::$port . ";dbname=" . self::$dbName . ";charset=utf8",
					self::$dbUsername,
					self::$dbUserPassword
				);
				self::$cont->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch(PDOException $e) {
				error_log($e->getMessage());
				die("Database connection error.");
			}
		}
		return self::$cont;
	}

	public static function disconnect()
	{
		self::$cont = null;
	}
}
?>
