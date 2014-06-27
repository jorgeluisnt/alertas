<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class jsGrid{

    var $url =''; //ulr de php para cargar datos
    var $datatype ='json';//tipo de datos a cargar
    var $rowNum =20; //numero de filas por a mostrar
    var $pager = ''; //div de la grilla
    var $tabla = ''; //tabla de la grilla
    var $alto = 200; //tabla de la Heigth
    var $sortname =null; //columna para ordenar por defecto
    var $viewrecords ='true'; //ver registros
    var $multiselect ='false'; //seleccion multiple
    var $sortorder ='asc'; //metodo de ordenacion por defecto
    var $width = 500; //ancho de la grilla
    var $caption ='Titulo'; //titulo de la grilla

    var $rowList = "10,20,30"; //lista de cuantas filas de deben mostrar

    var $columnas = array();//columnas de la base datos
    var $columnasView = array();//columnas a ver en las cabeceras

    var $conBusqueda = true;
    var $fullwidth = true;
    
    var $FnSelect = null;
    var $FnCarga = null;
    
    protected $expoptions = array("excel" => array("caption" => "", "title" => "Exporar a Excel", "buttonicon" => "ui-icon-newwin"), "pdf" => array("caption" => "", "title" => "Exportar a Pdf", "buttonicon" => "ui-icon-print"), "csv" => array("caption" => "", "title" => "Exportar a CSV", "buttonicon" => "ui-icon-document"), "columns" => array("caption" => "", "title" => "Visible Columns", "buttonicon" => "ui-icon-calculator", "options" => array()));

    public function getAlto() {
        return $this->alto;
    }

    public function setAlto($alto) {
        $this->alto = $alto;
    }

    public function getFullwidth() {
        return $this->fullwidth;
    }

    public function setFullwidth($fullwidth) {
        $this->fullwidth = $fullwidth;
    }
    
    public function setFnSelect($nombre_funcion){
        $this->FnSelect = $nombre_funcion;
    }
    public function setFnCargaCompleta($nombre_funcion){
        $this->FnCarga = $nombre_funcion;
    }

//name=sss, width:150, sortable:false}index:'id_marca'
//search:true,align:"right",forceFit : true,autowidth: true,

    private function crearGrilla(){

        $colN = $this->getColNames();
        $colM = $this->getColModel();
        $cadena = "jQuery('#$this->tabla').jqGrid({\n";
        $cadena .="url:'$this->url',\n";
        $cadena .="height:'$this->alto',\n";
        $cadena .="datatype: '$this->datatype',\n";
        $cadena .="colNames:[$colN],";
        $cadena .="colModel:[$colM],";
        $cadena .="rowNum:$this->rowNum,\n";
        $cadena .="rowList:[$this->rowList],\n";
        $cadena .="forceFit:false,\n";
        $cadena .="pager:'#$this->pager',\n";
        $cadena .="sortname:'$this->sortname',\n";
        
        if ($this->fullwidth){
            $cadena .="autowidth:true,\n";
        }else{
            $cadena .="width:$this->width,\n";
        }
        
        if ($this->FnSelect != null){
            $cadena .="onSelectRow: function(ids) {if($.isFunction(".$this->FnSelect."))".$this->FnSelect."(ids);},\n";
        }
        if ($this->FnCarga != null){
            $cadena .="gridComplete: function() {if($.isFunction(".$this->FnCarga."))".$this->FnCarga."();},\n";
        }
        $cadena .="viewrecords:$this->viewrecords,\n";
        $cadena .="multiselect:$this->multiselect,\n";
        $cadena .="sortorder:'$this->sortorder',\n";
        $cadena .="rownumbers:true,\n";
        $cadena .="caption:'$this->caption'\n";
        $cadena .="});\n";

        return $cadena;

    }

    private function getColModel(){
        $cadena = "";

        foreach ($this->columnas as $value) {
            
            $so = $value['sortable'];
            $s = $value['search'];
            $a = $value['align'];
            
            $cadena .="{";
            $cadena .="name:'".$value['name']."',";
            $cadena .="index:'".$value['index']."',";
            $cadena .="width:'".$value['width']."',";
            $cadena .="sortable:$so,";
            $cadena .="search:$s,";
            $cadena .="align:'$a'";
            $cadena .="},";
        }

        $cadena = substr($cadena,0,strlen($cadena)-1);

        return $cadena;
        
    }

    private function getColNames(){
        $cadena = "";

        foreach ($this->columnasView as $value) {
            $cadena .="'".$value."',";
        }

        $cadena = substr($cadena,0,strlen($cadena)-1);

        return $cadena;
    }

    public function buildJsGrid(){
        
                    $exexcel = <<<EXCELE
onClickButton : function(e)
{
    try {
        jQuery('#$this->tabla').jqGrid('excelExport',{tag:'excel', url:jQuery('#$this->tabla').jqGrid('getGridParam','url')});
    } catch (e) {
        window.location= jQuery('#$this->tabla').jqGrid('getGridParam','url') + '?oper=excel';
    }
}
EXCELE;
                    
                    $expdf = <<<PDFE
onClickButton : function(e)
{
    try {
        jQuery('#$this->tabla').jqGrid('excelExport',{tag:'pdf', url:jQuery('#$this->tabla').jqGrid('getGridParam','url')});
    } catch (e) {
        window.location= jQuery('#$this->tabla').jqGrid('getGridParam','url')+ '?oper=pdf';
    }
}
PDFE;
        
        $cadena = "jQuery(document).ready(function(){\n";
        $cadena .= $this->crearGrilla();
        $cadena .= "jQuery('#$this->tabla').jqGrid('navGrid','#$this->pager',{edit:false,pdf:true,excel:true,add:false,del:false,search:false,columns:false});";
        $cadena .= "jQuery('#$this->tabla').jqGrid('navButtonAdd','#$this->pager',{id:'" . $this->pager . "_excel', caption:'" . $this->expoptions['excel']['caption'] . "',title:'" . $this->expoptions['excel']['title'] . "'," . $exexcel . ",buttonicon:'" . $this->expoptions['excel']['buttonicon'] . "'});";
        $cadena .= "jQuery('#$this->tabla').jqGrid('navButtonAdd','#$this->pager',{id:'" . $this->pager . "_pdf',caption:'" . $this->expoptions['pdf']['caption'] . "',title:'" . $this->expoptions['pdf']['title'] . "'," . $expdf . ", buttonicon:'" . $this->expoptions['pdf']['buttonicon'] . "'});";
        
        if ($this->conBusqueda == true)
            $cadena .= "jQuery('#$this->tabla').jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});";
        
        
        $cadena .= "});";

        return $cadena;

    }

    public function addColumnas($nombre,$nombreView,$width=150,$sortable='true',$search='true',$align='left'){
        $this->columnasView[] = $nombreView;
        $this->columnas[] = array(
            'name'=>$nombre,
            'index'=>$nombre,
            'width'=>$width,
            'sortable'=>$sortable,
            'search'=>$search,
            'align'=>$align
            );

    }
    
    public function getConBusqueda() {
        return $this->conBusqueda;
    }

    public function setConBusqueda($conBusqueda) {
        $this->conBusqueda = $conBusqueda;
    }

    
    public function getTabla() {
        return $this->tabla;
    }

    public function setTabla($tabla) {
        $this->tabla = $tabla;
    }

        public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getDatatype() {
        return $this->datatype;
    }

    public function setDatatype($datatype) {
        $this->datatype = $datatype;
    }

    public function getRowNum() {
        return $this->rowNum;
    }

    public function setRowNum($rowNum) {
        $this->rowNum = $rowNum;
    }

    public function getPager() {
        return $this->pager;
    }

    public function setPager($pager) {
        $this->pager = $pager;
    }

    public function getSortname() {
        return $this->sortname;
    }

    public function setSortname($sortname) {
        $this->sortname = $sortname;
    }

    public function getViewrecords() {
        return $this->viewrecords;
    }

    public function setViewrecords($viewrecords) {
        $this->viewrecords = $viewrecords;
    }

    public function getMultiselect() {
        return $this->multiselect;
    }

    public function setMultiselect($multiselect) {
        $this->multiselect = $multiselect;
    }

    public function getSortorder() {
        return $this->sortorder;
    }

    public function setSortorder($sortorder) {
        $this->sortorder = $sortorder;
    }

    public function getWidth() {
        return $this->width;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function getCaption() {
        return $this->caption;
    }

    public function setCaption($caption) {
        $this->caption = $caption;
    }
    
    public function getRowList() {
        return $this->rowList;
    }

    public function setRowList($rowList) {
        $this->rowList = $rowList;
    }

    var $includeJsPatch="js/";
    var $includeCssPatch="js/";

    public function getIncludeJsPatch() {
        return $this->includeJsPatch;
    }

    public function setIncludeJsPatch($includeJsPatch) {
        $this->includeJsPatch = $includeJsPatch;
    }

    public function getIncludeCssPatch() {
        return $this->includeCssPatch;
    }

    public function setIncludeCssPatch($includeCssPatch) {
        $this->includeCssPatch = $includeCssPatch;
    }


}

?>
