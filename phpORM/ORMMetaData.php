<?php

class ORMMetadata 
{
	
	static $__metadata=null;
	
	public static function getMetadata($obj)
	{	
		$className = get_class($obj); 

		if ( !isset(self::$__metadata[$className]))
		{
			self::$__metadata[$className] = $obj->_getMetadata();
		}

		return self::$__metadata[$className];		
	}
	
	
}

?>
