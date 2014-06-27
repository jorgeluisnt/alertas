<?php

require_once('adodb/adodb.inc.php');
include_once('adodb/adodb-exceptions.inc.php');

include_once("ORMException.php");


class ORMConnection{

	static protected $conn = null;

	public static function  getConnection(){

			include('config_db.php');

			//$config_db = $this->getConnectionParamaters(); 

			$conn = ADONewConnection($config_db["driver"]); 
			$conn->PConnect($config_db["server"],$config_db["user"],$config_db["password"],$config_db["database"]);
			if ( $conn == null)
			{
				throw new ORMConnectionError("Error de Conexion");
			}
			
			if ( ! isset($config_db["charset"]) ) $config_db["charset"] = "utf8";
			
			$conn->execute("SET NAMES '".$config_db["charset"]."'");
			

			global $phpORM_debug;
			$conn->debug = $phpORM_debug;
			$conn->SetFetchMode(ADODB_FETCH_ASSOC);

			return $conn; 
	}

	public static function debug($debug=true){
		if ( $debug != true ) $debug = false;

		global $phpORM_debug;
		$phpORM_debug = $debug;

	}

	public static  function Execute($sql, $params=array()){
		if ( self::$conn == null ) 
			self::$conn = self::getConnection();

		$rs = self::$conn->Execute($sql,$params);
                  $aux = array();
                  foreach ( $rs as $item ) $aux[] = $item;
                  return $aux;
	}

	public static  function getType($t){
		$orm = new ADORecordSet(null);

                return $orm->MetaType($t);
	}
}

?>