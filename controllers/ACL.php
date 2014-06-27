<?php

class ACL{

	public static $default = true;

	public static function access($controller, $action, $cController){
		$methodName = $controller."_".$action;
		$acl = new ACL();
		if ( method_exists($acl,$methodName) ){
			return $acl->$methodName();
		}else{
			return $cController->rights();
		}
		return self::$default;
	}


}

?>
