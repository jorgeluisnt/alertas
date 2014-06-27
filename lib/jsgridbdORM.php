<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class jsGridBdORM{
    
    var $pagina;
    var $countRows;
    var $totalPaginas;
    var $numRowsPagina;
    var $condicionGrilla;
    var $coneccion;
    var $sql;
    var $sqlCount;
    var $paginacion;
    var $resultado;
    var $start;

    var $tabla;
    var $Modelo = null;
    var $all = false;
    var $columnas = array();
    var $columnaId;

    var $exporOper = null;
    
    var $opcionesPdf = null;
    
    var $ValCell = array();
    
    /*
        Paramcell array('nom_col'=>'estado','valores'=>array('A'=>'Activo','I'=>'Inactivo'))
     
     */
    
    public function valCell($Paramcell){
        $this->ValCell[] = $Paramcell;
    }
    
    public function setOpcionesPdf($parametros){
        $this->opcionesPdf = $parametros;
    }
    
//    	$grid->setPdfOptions(array(
//		"header"=>true,
//		"margin_top"=>27,
//		"page_orientation"=>"P",
//		"header_logo"=>"logo.gif",
//		// set logo image width
//		"header_logo_width"=>30,
//		//header title
//		"header_title"=>"jqGrid pdf table"
//	));
        
        
    public function setParametros($parametros){

        if(!$parametros['sidx']) $parametros['sidx'] =1;
        
        $this->pagina = $parametros['page'];
        $this->numRowsPagina = $parametros['rows'];
        $this->condicionGrilla = $this->getCondicion($parametros['_search'],$parametros);
        $this->addOrderBy($parametros['sidx'], $parametros['sord']=='asc');

        if (isset ($parametros['oper'])){
            $this->exporOper = $parametros['oper'];
        }else{
            $this->exporOper = null;
        }
        
        
    }

    function prepareJSON($input) {

        //This will convert ASCII/ISO-8859-1 to UTF-8.
        //Be careful with the third parameter (encoding detect list), because
        //if set wrong, some input encodings will get garbled (including UTF-8!)
        $imput = mb_convert_encoding($input, 'UTF-8', 'ASCII,UTF-8,ISO-8859-1');

        //Remove UTF-8 BOM if present, json_decode() does not like it.
        if(substr($input, 0, 3) == pack("CCC", 0xEF, 0xBB, 0xBF)) $input = substr($input, 3);

        return $input;
    }
    
    private function getCondicion($search,$params){

        if ($search == 'true'){

            if(!isset ($params['filters'])){

                return $this->AgregarCondicion($params['searchField'],$params['searchString'],$params['searchOper'],'AND');
                
            }else{
                
                if(get_magic_quotes_gpc()){
                    $d = stripslashes($params['filters']);
                }else{
                    $d = $params['filters'];
                }
                
                $filtro = json_decode($this->prepareJSON($d));
                
                $and_or = $filtro->groupOp;
                
                $reglas = $filtro->rules;
                
                foreach ($reglas as $value ) {
                    $this->AgregarCondicion($value->field,$value->data,$value->op,$and_or);
                }
                
            }
        }
        
    }
    
    private function AgregarCondicion($campo,$dato,$operacion,$tipo){
        $wh = "";
                
        $qopers = array(
                          'eq'=>" = ",
                          'ne'=>" <> ",
                          'lt'=>" < ",
                          'le'=>" <= ",
                          'gt'=>" > ",
                          'ge'=>" >= ",
                          'bw'=>" like ",
                          'bn'=>" not like ",
                          'in'=>" in ",
                          'ni'=>" not in ",
                          'ew'=>" like ",
                          'en'=>" not like ",
                          'cn'=>" like " ,
                          'nc'=>" not like " );
        
//        $field = "upper(".$params['searchField'].")";
//        $op = $params['searchOper'];
//        $text = strtoupper($params['searchString']);
        
        $text = strtoupper($dato);
        if (is_date($text)  || es_numero($text,$campo)){
            $field = $campo;
            $operacion = "eq";
        }else{
            $field = "upper(".$campo.")";
        }
        
        $op = $operacion;
        $cond = $qopers[$op];
        
        switch ($op) {
            case 'bw':
            case 'bn':
                $text = es_numero($text,$campo)?$text:"%".$text."%";
                $wh = $field.$cond.$text;
                break;
            case 'ew':
            case 'en':
                $text = es_numero($text,$campo)?$text:"%".$text."";
                $wh = $field.$cond.$text;
                break;
            case 'cn':
            case 'nc':
                $text = es_numero($text,$campo)?$text:"%".$text."%";
                $wh = $field.$cond.$text;
                break;
            case 'in':
            case 'ni':
                $text = es_numero($text,$campo)?$text:" (".$text.")";
                $wh = $field.$cond.$text;
                break;
            default:
                $text = es_numero($text,$campo)?$text:"'".$text."'";
                $wh = $field.$cond.$text;
                break;
        }
        
        if ($tipo == 'AND')
            $this->addWhereAnd($field.$cond, $text);
        else
            $this->addWhereOr($field.$cond, $text);
        
        return $wh;
    }

    public function setColumnaId($columnaId){
        $this->columnaId = $columnaId;
    }

    public function setTabla($Tabla,$prefijo=null){
        
        $this->tabla = $Tabla;

        $mod = strtolower($Tabla);

        include_once "models/$mod.php";

        $this->Modelo = new $mod;
        
    }

    public function addColumna($columna){
        $col;
        $index = -1;
        
        if (is_array($columna)){
            $col = $columna;
        }else{
            $col = array('Titulo'=>$columna,'Nombre'=>$columna,'Ordenado'=>'');
        }
        
        
        
        for ($i =0 ; $i < count($this->columnas);$i++){
            if ($this->columnas[$i]['Nombre']==$col['Nombre']){
                $index = $i;
                break;
            }
        }
        
        if ($index >= 0){
            $this->columnas[$index]['Titulo'] = $col['Titulo'];
        }
        else
            $this->columnas[] = $col;
        
        
    }

    public function addWhereAnd($property,$value=null)
    {
        if ($this->all == false){
            $this->Modelo = $this->Modelo->getAll();
            $this->all = true;
        }

        $this->Modelo = $this->Modelo->WhereAnd($property,$value);
    }

    public function addWhereOr($property,$value=null)
    {
        if ($this->all == false){
            $this->Modelo = $this->Modelo->getAll();
            $this->all = true;
        }

        $this->Modelo = $this->Modelo->WhereOr($property,$value);
    }

    public function addOrderby($property,$asc=null)
    {
        if ($this->all == false){
            $this->Modelo = $this->Modelo->getAll();
            $this->all = true;
        }

        $this->Modelo = $this->Modelo->Orderby($property,$asc);
        
        $ord = $asc==true?'asc':'desc';
        
//        $this->addColumna(array('Titulo'=>$property,'Nombre'=>$property,'Ordenado'=>$ord));
        
    }

    public function addGroupBy($property){

        if ($this->all == false){
            $this->Modelo = $this->Modelo->getAll();
            $this->all = true;
        }

        $this->Modelo = $this->Modelo->GroupBy($property);
    }

    private function getValor($vall,$col){

        $listacol = explode('->', $col);

        $long = count($listacol);

        $res = $vall;

        for ($i = 0 ; $i < $long ; $i++)
            $res = $res->$listacol[$i];

        return $res;

    }

    public function to_json(){
        
        if ($this->all == false){
            $this->Modelo = $this->Modelo->getAll();
            $this->all = true;
        }

        if ($this->exporOper == null){
        
            $this->countRows = $this->Modelo->count();

            if( $this->countRows >0 ) {
                $this->totalPaginas = ceil($this->countRows/$this->numRowsPagina);
            } else {
                $this->totalPaginas = 0;
            }
            
            include_once 'lib/grilla.php';
            
            $responce = new grilla();
            
            $responce->page = $this->pagina;
            $responce->total = $this->totalPaginas;
            $responce->records = "".$this->countRows."";

            $this->Modelo = $this->Modelo->getDatos($this->numRowsPagina,$this->pagina);

            $i=0;

            foreach ($this->Modelo as $key){

                $idT = $this->columnaId;

                $responce->rows[$i]['id']=$key->$idT;

                $data = array();

                foreach ($this->columnas as $c) {
                    
                    if (is_array($c))
                        $c = $c['Nombre'];
                    
                    $index = $this->existeValue($c);
                    
                    if ($index >= 0){
                        $data[] = $this->getValuesEq($index, $this->getValor($key,$c));
                    }else{
                        $data[] = $this->getValor($key,$c);
                    }

                }

                $responce->rows[$i]['cell']=$data;
                $i++;

            }

            // return the formated data
            return json_encode($responce);
            
        }else{
            
            $responce = array();
            
            foreach ($this->Modelo as $key){
                
                $data = array();

                foreach ($this->columnas as $c) {
                    
                    if (is_array($c))
                        $c = $c['Nombre'];
                    
                    $index = $this->existeValue($c);
                    
                    if ($index >= 0){
                        $data[] = $this->getValuesEq($index, $this->getValor($key,$c));
                    }else{
                        $data[] = $this->getValor($key,$c);
                    }
                }

                $responce[] = $data;
            }
            
            switch ($this->exporOper){
                case 'pdf':
                    
                    include_once 'pdf.php';

                    $pdf = new pdf();
                    
                    if ($this->opcionesPdf != null){
                        $pdf->setPdfOptions($this->opcionesPdf);
                    }
                    
                    
                    
                    $pdf->exportToPdf($responce, $this->columnas);
                    break;
                    
                case 'excel':
                    
                    include_once 'excel.php';
                    
                    $excel = new excel();
                    
                    $excel->exportToExcel($responce, $this->columnas);
                    break;
                    
            }
            return false;
        }
    }

    private function getValuesEq($idx,$val){
        
        $values = $this->ValCell[$idx]['valores'];
        
        $result = $val;
        
        foreach ($values as $key => $value) {
            if ($key == $val){
                $result = $value;
                break;
            }
        }
        
        return $result;
    }


    private function existeValue($col){
        $long = count($this->ValCell);
        
        $result = -1;
        
        for ($index = 0 ; $index < $long ; $index++){            
            if ($this->ValCell[$index]['nom_col'] == $col){                
                $result = $index;
                break;
            }
        }
        
        return $result;
    }
}

?>
