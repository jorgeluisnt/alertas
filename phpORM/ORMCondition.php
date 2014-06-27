<?php

/**
* Me permite definir condiciones logicas para las busquedas en la base de datos
* author: necudeco@necudeco.com
* web http://necudeco.com
*/
class ORMCondition 
{

	public $conditions = array();

	public function __construct($key=null,$value=null)
	{
                if ( $key == null ) return;
		$c = $this->createCondition($key,$value);
		$this->conditions = array($c);
	}
	
	private function createCondition($key,$value)
	{
		$condition = null;
		
		if ( is_a($key,"ORMCondition") )
		{
			$condition = $key;
		}else // falta verificar si es un in o es un between
		{
			$condition = array("op"=>null,"key"=>$key,"value"=>$value);
		}
		
		return $condition;
	}
	
	
	public function andCondition($key,$value=null)
	{
		$c = $this->createCondition($key,$value);
                if ( count($this->conditions) == 0 )
                    $this->conditions = array($c);
                else
                    $this->conditions[] = array("op"=>"and","cond"=>$c);
		return $this;
	}
	
	public function orCondition($key,$value=null)
	{
		$c = $this->createCondition($key,$value);
                if ( count($this->conditions) == 0 )
                    $this->conditions = array($c);
                else
                    $this->conditions[] = array("op"=>"or","cond"=>$c);
		return $this;
	}
}
/*
function iterCondition($cond)
{
	if ( is_a($cond,"ORMCondition")) return iterCondition($cond->conditions);

	if ( ! is_array($cond)) return "NULL ITER";

	$strcond = "";
	
	if ( ! array_key_exists("op",$cond) )
	{
		foreach( $cond as $c )
			$strcond .= iterCondition($c);
			
		return " ( $strcond ) ";
	}
	$op = $cond["op"]; // Operador
	if ( array_key_exists("cond",$cond))
		return "$op ".iterCondition($cond["cond"]);
	else
		return "$op $cond[key] $cond[value] ";
}

function SQL($cond)
{
	if ( $cond == null ) return "null";
	if ( ! is_a($cond,"ORMCondition")) return "NO CONDICION";
	
	$where = "WHERE ";
	$con = iterCondition($cond);
	
	return "WHERE $con";
}

$p = new ORMCondition("nombre like","pedro");
$p->orCondition("nombre like","juan")->orCondition(new ORMCondition("2 =",3));

$p2 = new ORMCondition("2 =",3);
$p2->andCondition("3 <> ",4)->andCondition("campo in",array(2,3,45))->andCondition("fecha between",array("fecha1","fecha2"));

$p->andCondition($p2);

echo SQL($p);
echo "<pre>";
print_r($p);
echo "</pre>";
*/
?>