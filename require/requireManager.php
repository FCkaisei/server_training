<?php
class DBRequire{
	public static function connect_db(){
		include("../baseDB/connect_db.php");
	}
}
class DebugRequire{
		public static function errorReport(){
			include("../debug/debug.php");
		}
		public static function chromeConsole(){
			include('../chromephp/ChromePhp.php');
		}
	}
?>
