<?php
	
class ORMException extends Exception
{
    public $message = 'Unknown exception';
    public $code = ORMException::NoError;
    
    const NoError					= 0;
    const RecordNotFound 		= 1;
    const MissingPrimaryKey 	= 2;
    const PropertyNotValid	 	= 4;
    const InvalidDataType	 	= 8;
    const NullObject				= 16;
    const NotNullObject		 	= 32;
	 const ConnectionError		= 64;
}

class ORMConnectionError extends ORMException{	 
	public $message;
	public $code = ORMException::ConnectionError;
}

class ORMRecordNotFound extends ORMException
{
	public $message;
	public $code = ORMException::RecordNotFound;
}

class ORMMissingPrimaryKey extends ORMException
{
	public $message;
	public $code = ORMException::MissingPrimaryKey;
}

class ORMPropertyNotValid extends ORMException
{
	public $message;
	public $code = ORMException::PropertyNotValid;
}

class ORMInvalidDataType extends ORMException
{
	public $message;
	public $code = ORMException::InvalidDataType;
}

class ORMNullObject extends ORMException
{
	public $message;
	public $code = ORMException::NullObject;
}

class ORMNotNullObject extends ORMException
{
	public $message;
	public $code = ORMException::NotNullObject;
}

?>
