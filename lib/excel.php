<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of excel
 *
 * @author jorge
 */

include_once 'jqUtils.php';

class excel {
    
    protected $gSQLMaxRows = 1000;
    protected $dbdateformat = 'Y-m-d';
    protected $dbtimeformat = 'Y-m-d H:i:s';
    protected $userdateformat = 'd/m/Y';
    protected $usertimeformat = 'd/m/Y H:i:s';
    public $encoding = "utf-8";
    protected $tmpvar = false;
    
    public function exportToExcel(array $modelo=null, array $colmodel=null, $echo = true, $filename='exportdata.xml') {

        if ($modelo) {
            $ret = $this->rs2excel($modelo, $colmodel, $echo, $filename);
            return $ret;
        } else
            return "Error:Could not execute the query";
    }
    
    protected function rs2excel($modelo, $colmodel=false, $echo = true, $filename='exportdata.xls') {
        $s = '';
        $rows = 0;
        $gSQLMaxRows = $this->gSQLMaxRows;
        if (!$modelo) {
            printf('Bad Record set rs2excel');
            return false;
        } 
        $typearr = array();
        $ncols = count($colmodel);
        $hdr = '<?xml version="1.0" encoding="' . $this->encoding . '"?>';
        $hdr .='<?mso-application progid="Excel.Sheet"?>';
        $hdr .= '<ss:Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" xmlns:html="http://www.w3.org/TR/REC-html40">';
        $hdr .= '<ss:Styles>' . '<ss:Style ss:ID="1"><ss:Font ss:Bold="1"/></ss:Style>' . '<ss:Style ss:ID="sd"><NumberFormat ss:Format="Short Date"/></ss:Style>' . '<ss:Style ss:ID="ld"><NumberFormat ss:Format="General Date"/></ss:Style>' . '<ss:Style ss:ID="nmb"><NumberFormat ss:Format="General Number"/></ss:Style>' . '</ss:Styles>';
        $hdr .= '<ss:Worksheet ss:Name="Sheet1">';
        $hdr .= '<ss:Table>';
        $model = false;
        if ($colmodel && is_array($colmodel) && count($colmodel) == $ncols) {
            $model = true;
        } 
        
        $hdr1 = '<ss:Row ss:StyleID="1">';
        $aSum = array();
        $aFormula = array();
        $ahidden = array();
        $aselect = array();
        $hiddencount = 0;
        for ($i = 0; $i < $ncols; $i++) {
            $ahidden[$i] = ($model && isset($colmodel[$i]["hidden"])) ? $colmodel[$i]["hidden"] : false;
            $aselect[$i] = false;
            if ($model && isset($colmodel[$i]["formatter"])) {
                if ($colmodel[$i]["formatter"] == "select") {
                    $asl = isset($colmodel[$i]["formatoptions"]) ? $colmodel[$i]["formatoptions"] : $colmodel[$i]["editoptions"];
                    if (isset($asl["value"]))
                        $aselect[$i] = $asl["value"];
                }
            } if ($ahidden[$i]) {
                $hiddencount++;
                continue;
            } $column = ($model && isset($colmodel[$i]["width"])) ? (int) $colmodel[$i]["width"] : 0;
            if ($column > 0) {
                $column = $column * 72 / 96;
                $hdr .= '<ss:Column ss:Width="' . $column . '"/>';
            } else
                $hdr .= '<ss:Column ss:AutoFitWidth="1"/>'; $field = array();
            if ($model) {
                $fname = isset($colmodel[$i]["Titulo"]) ? $colmodel[$i]["Titulo"] : $colmodel[$i]["Nombre"];
                $field["name"] = $colmodel[$i]["Nombre"];
                $typearr[$i] = isset($colmodel[$i]["Ordenado"]) ? $colmodel[$i]["Ordenado"] : '';
            } else {
//                $field = jqGridDB::getColumnMeta($i, $rs);
//                $fname = $field["name"];
//                $typearr[$i] = jqGridDB::MetaType($field, $this->dbtype);
            }  
            $fname = htmlspecialchars($fname);
            if (strlen($fname) == 0)
                $fname = ''; $hdr1 .= '<ss:Cell><ss:Data ss:Type="String">' . $fname . '</ss:Data></ss:Cell>';
        } $hdr1 .= '</ss:Row>';
        if (!$echo)
            $html = $hdr . $hdr1; 

        foreach ($modelo as $r) {

            $s .= '<ss:Row>';
            for ($i = 0; $i < $ncols; $i++) {
                if (isset($ahidden[$i]) && $ahidden[$i])
                    continue; $v = $r[$i];
                if (is_array($aselect[$i])) {
                    if (isset($aselect[$i][$v])) {
                        $v1 = $aselect[$i][$v];
                        if ($v1)
                            $v = $v1;
                    } $typearr[$i] = 'string';
                } $type = $typearr[$i];
                switch ($type) {
                    case 'date': if (substr($v, 0, 4) == '0000' || empty($v) || $v == 'NULL') {
                            $v = '1899-12-31T00:00:00.000';
                            $s .= '<ss:Cell ss:StyleID="sd"><ss:Data ss:Type="DateTime">' . $v . '</ss:Data></ss:Cell>';
                        } else if (!strpos($v, ':')) {
                            $v .= "T00:00:00.000";
                            $s .= '<ss:Cell ss:StyleID="sd"><ss:Data ss:Type="DateTime">' . $v . '</ss:Data></ss:Cell>';
                        } else {
                            $thous = substr($v, -4);
                            if (strpos($thous, ".") === false && strpos($v, ".") === false)
                                $v .= ".000"; $s .= '<ss:Cell ss:StyleID="sd"><ss:Data ss:Type="DateTime">' . str_replace(" ", "T", trim($v)) . '</ss:Data></ss:Cell>';
                        } break;
                    case 'datetime': if (substr($v, 0, 4) == '0000' || empty($v) || $v == 'NULL') {
                            $v = '1899-12-31T00:00:00.000';
                            $s .= '<ss:Cell ss:StyleID="ld"><ss:Data ss:Type="DateTime">' . $v . '</ss:Data></ss:Cell>';
                        } else {
                            $thous = substr($v, -4);
                            if (strpos($thous, ".") === false && strpos($v, ".") === false)
                                $v .= ".000"; $s .= '<ss:Cell ss:StyleID="ld"><ss:Data ss:Type="DateTime">' . str_replace(" ", "T", trim($v)) . '</ss:Data></ss:Cell>';
                        } break;
                    case 'numeric': case 'int': $s .= '<ss:Cell ss:StyleID="nmb"><ss:Data ss:Type="Number">' . stripslashes((trim($v))) . '</ss:Data></ss:Cell>';
                        break;
                    default: $v = htmlspecialchars(trim($v));
                        if (strlen($v) == 0)
                            $v = ''; $s .= '<ss:Cell><ss:Data ss:Type="String">' . stripslashes($v) . '</ss:Data></ss:Cell>';
                }
            } $s .= '</ss:Row>';
            $rows += 1;
            if ($rows >= $gSQLMaxRows) {
                break;
            }
        } if (count($aSum) > 0 && $rows > 0) {
            $s .= '<Row>';
            foreach ($aSum as $ind => $ival) {
                $s .= '<Cell ss:StyleID="1" ss:Index="' . ($ival + 1) . '" ss:Formula="=' . $aFormula[$ind] . '(R[-' . ($rows) . ']C:R[-1]C)"><Data ss:Type="Number"></Data></Cell>';
            } $s .= '</Row>';
        } if ($echo) {
            header('Content-Type: application/ms-excel;');
            header("Content-Disposition: attachment; filename=" . $filename);
            echo $hdr . $hdr1;
            echo $s . '</ss:Table></ss:Worksheet></ss:Workbook>';
        } else {
            $html .= $s . '</ss:Table></ss:Worksheet></ss:Workbook>';
            return $html;
        }
    }
}

?>
