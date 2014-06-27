<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pdf
 *
 * @author jorge
 */

include_once 'jqUtils.php';

class pdf {
    protected $PDF = array(
        "page_orientation" => "P", 
        "unit" => "mm", 
        "page_format" => "A4", 
        "creator" => "Descubre Texto", 
        "author" => "Descubre Texto", 
        "title" => "Reporte PDF", 
        "subject" => "Subject", 
        "keywords" => "table, grid", 
        "margin_left" => 15, 
        "margin_top" => 7, 
        "margin_right" => 15, 
        "margin_bottom" => 25, 
        "margin_header" => 5, 
        "margin_footer" => 10, 
        "font_name_main" => "helvetica", 
        "font_size_main" => 8, 
        
        
        "header_logo" => "", 
        "header_logo_width" => 0, 
        "header_title" => "", 
        "header_string" => "", 
        "header" => false, 
        
        
        "footer" => true, 
        "font_monospaced" => "courier", 
        "font_name_data" => "helvetica", 
        "font_size_data" => 6, 
        "image_scale_ratio" => 1.25, 
        "grid_head_color" => "#c4c4c4", 
        "grid_head_text_color" => "#4F4F4F", 
        "grid_draw_color" => "#5c9ccc", 
        "grid_header_height" => 6, 
        "grid_row_color" => "#ffffff", 
        "grid_row_text_color" => "#000000", 
        "grid_row_height" => 5, 
        "grid_alternate_rows" => false, 
        "path_to_pdf_class" => "tcpdf/tcpdf.php", 
        "shrink_cell" => true,
        "reprint_grid_header" => false, 
        "shrink_header" => true);
    
    protected $gSQLMaxRows = 1000;
    protected $dbdateformat = 'Y-m-d';
    protected $dbtimeformat = 'Y-m-d H:i:s';
    protected $userdateformat = 'd/m/Y';
    protected $usertimeformat = 'd/m/Y H:i:s';
    protected $tmpvar = false;
    
    public function setPdfOptions($apdf) {
        if (is_array($apdf) and count($apdf) > 0) {
            $this->PDF = jqGridUtils::array_extend($this->PDF, $apdf);
        }
    }
    
    public function exportToPdf($modelo,array $colmodel=null, $filename='exportdata.pdf') {

        if ($modelo) {
            $pd = $this->PDF;
            try {
                include($pd['path_to_pdf_class']);
                $pdf = new TCPDF($pd['page_orientation'], $pd['unit'], $pd['page_format'], true, 'UTF-8', false);
                $pdf->SetCreator($pd['creator']);
                $pdf->SetAuthor($pd['author']);
                $pdf->SetTitle($pd['title']);
                $pdf->SetSubject($pd['subject']);
                $pdf->SetKeywords($pd['keywords']);
                $pdf->SetMargins($pd['margin_left'], $pd['margin_top'], $pd['margin_right']);
                $pdf->SetHeaderMargin($pd['margin_header']);
                $pdf->setHeaderFont(Array($pd['font_name_main'], '', $pd['font_size_main']));
                if ($pd['header'] === true) {
                    $pdf->SetHeaderData($pd['header_logo'], $pd['header_logo_width'], $pd['header_title'], $pd['header_string']);
                } else {
                    $pdf->setPrintHeader(false);
                } 
                $pdf->SetDefaultMonospacedFont($pd['font_monospaced']);
                $pdf->setFooterFont(Array($pd['font_name_data'], '', $pd['font_size_data']));
                $pdf->SetFooterMargin($pd['margin_footer']);
                if ($pd['footer'] !== true) {
                    $pdf->setPrintFooter(false);
                } 
                $pdf->setImageScale($pd['image_scale_ratio']);
                $pdf->SetAutoPageBreak(TRUE, 17);
                
                global $l;
                
                $pdf->setLanguageArray($l);
                $pdf->AddPage();
                $pdf->SetFont($pd['font_name_data'], '', $pd['font_size_data']);
                
                $this->rs2pdf($modelo, $pdf, $colmodel);
                
                $pdf->Output($filename, 'D');
                exit();
            } catch (Exception $e) {
                return false;
            }
        } else {
            return "Error:Could not execute the query";
        }
    }
    
    protected function   rs2pdf($modelo, &$pdf, $colmodel=false) {
        
        $s = '';
        $rows = 0;
        $gSQLMaxRows = $this->gSQLMaxRows;
        if (!$modelo) {
            printf('Bad Record set rs2pdf');
            return false;
        }
        
        $typearr = array();
        $ncols = count($colmodel);
        $model = false;
        $nmodel = is_array($colmodel) ? count($colmodel) : -1;
        if ($nmodel > 0) {
            for ($i = 0; $i < $nmodel; $i++) {
                if ($colmodel[$i]['Nombre'] == 'actions') {
                    array_splice($colmodel, $i, 1);
                    $nmodel--;
                    break;
                }
            }
        } 
        if ($colmodel && $nmodel == $ncols) {
            $model = true;
        } 
        $ahidden = array();
        $aselect = array();
        $totw = 0;
        $pw = $pdf->getPageWidth();
        $margins = $pdf->getMargins();
        $pw = $pw - $margins['left'] - $margins['right'];
        for ($i = 0; $i < $ncols; $i++) {
            $ahidden[$i] = ($model && isset($colmodel[$i]["hidden"])) ? $colmodel[$i]["hidden"] : false;
            $colwidth[$i] = ($model && isset($colmodel[$i]["width"])) ? (int) $colmodel[$i]["width"] : 150;
            if ($ahidden[$i])
                continue; 
            $totw = $totw + $colwidth[$i];
        } 
        $pd = $this->PDF;
        $pdf->SetLineWidth(0.2);
        $field = array();
        $fnmkeys = array();

        function printTHeader($ncols, $maxheigh, $awidth, $aname, $ahidden, $pdf, $pd) {
            $pdf->SetFillColorArray($pdf->convertHTMLColorToDec($pd['grid_head_color']));
            $pdf->SetTextColorArray($pdf->convertHTMLColorToDec($pd['grid_head_text_color']));
            $pdf->SetDrawColorArray($pdf->convertHTMLColorToDec($pd['grid_draw_color']));
            $pdf->SetFont('', 'B');
            for ($i = 0; $i < $ncols; $i++) {
                if ($ahidden[$i]) {
                    continue;
                } if (!$pd['shrink_header']) {
                    $pdf->MultiCell($awidth[$i], $maxheigh, $aname[$i], 1, 'C', true, 0, '', '', true, 0, true, true, 0, 'B', false);
                } else {
                    $pdf->Cell($awidth[$i], $pd['grid_header_height'], $aname[$i], 1, 0, 'C', 1, '', 1);
                }
            }
        }

        $maxheigh = $pd['grid_header_height'];
        for ($i = 0; $i < $ncols; $i++) {
            $aselect[$i] = false;
            if ($model && isset($colmodel[$i]["formatter"])) {
                if ($colmodel[$i]["formatter"] == "select") {
                    $asl = isset($colmodel[$i]["formatoptions"]) ? $colmodel[$i]["formatoptions"] : $colmodel[$i]["editoptions"];
                    if (isset($asl["value"]))
                        $aselect[$i] = $asl["value"];
                }
            } 
            $fnmkeys[$i] = "";
            if ($ahidden[$i]) {
                continue;
            } 
            if ($model) {
                $fname[$i] = isset($colmodel[$i]["Titulo"]) ? $colmodel[$i]["Titulo"] : $colmodel[$i]["name"];
                $typearr[$i] = isset($colmodel[$i]["Ordenado"]) ? $colmodel[$i]["Ordenado"] : '';
                $align[$i] = isset($colmodel[$i]["align"]) ? strtoupper(substr($colmodel[$i]["align"], 0, 1)) : "L";
            } else {
//                $field = jqGridDB::getColumnMeta($i, $rs);
//                $fname[$i] = $field["name"];
//                $typearr[$i] = jqGridDB::MetaType($field, $this->dbtype);
//                $align[$i] = "L";
            } 
            
            $fname[$i] = htmlspecialchars($fname[$i]);
            $fnmkeys[$i] = $model ? $colmodel[$i]["Nombre"] : $fname[$i];
            $colwidth[$i] = ($colwidth[$i] / $totw) * 100;
            $colwidth[$i] = ($pw / 100) * $colwidth[$i];
            if (strlen($fname[$i]) == 0)
                $fname[$i] = ''; if (!$pd['shrink_header']) {
                $maxheigh = max($maxheigh, $pdf->getStringHeight($colwidth[$i], $fname[$i], false, true, '', 1));
            }
        } 
        printTHeader($ncols, $maxheigh, $colwidth, $fname, $ahidden, $pdf, $pd);
        $pdf->Ln();

        $datefmt = $this->userdateformat;
        $timefmt = $this->usertimeformat;
        $pdf->SetFillColorArray($pdf->convertHTMLColorToDec($pd['grid_row_color']));
        $pdf->SetTextColorArray($pdf->convertHTMLColorToDec($pd['grid_row_text_color']));
        $pdf->SetFont('');
        $fill = false;
        if (!$pd['shrink_cell']) {
            $dimensions = $pdf->getPageDimensions();
        }
//        
//        foreach ($modelo as $row) {
//            
//        }
        
        foreach ($modelo as $r){
            $varr = array();
            $maxh = $pd['grid_row_height'];
            for ($i = 0; $i < $ncols; $i++) {
                if (isset($ahidden[$i]) && $ahidden[$i])
                    continue; 
                $v = $r[$i];
                if (is_array($aselect[$i])) {
                    if (isset($aselect[$i][$v])) {
                        $v1 = $aselect[$i][$v];
                        if ($v1)
                            $v = $v1;
                    } 
                    $typearr[$i] = 'string';
                } 
                $type = $typearr[$i];
                switch ($type) {
                    case 'date': $v = $datefmt != $this->dbdateformat ? jqGridUtils::parseDate($this->dbdateformat, $v, $datefmt) : $v;
                        break;
                    case 'datetime': $v = $timefmt != $this->dbtimeformat ? jqGridUtils::parseDate($this->dbtimeformat, $v, $timefmt) : $v;
                        break;
                    case 'numeric': case 'int': $v = trim($v);
                        break;
                    default: $v = htmlspecialchars(trim($v));
                        if (strlen($v) == 0)
                            $v = '';
                } if (!$pd['shrink_cell']) {
                    $varr[$i] = $v;
                    $maxh = max($maxh, $pdf->getStringHeight($colwidth[$i], $v, false, true, '', 1));
                } else {
                    $pdf->Cell($colwidth[$i], $pd['grid_row_height'], $v, 1, 0, $align[$i], $fill, '', 1);
                }
            } if (!$pd['shrink_cell']) {
                $startY = $pdf->GetY();
                if (($startY + $maxh) + $dimensions['bm'] > ($dimensions['hk'])) {
                    $pdf->AddPage();
                    if ($pd['reprint_grid_header']) {
                        printTHeader($ncols, $maxheigh, $colwidth, $fname, $ahidden, $pdf, $pd);
                        $pdf->Ln();
                        $pdf->SetFillColorArray($pdf->convertHTMLColorToDec($pd['grid_row_color']));
                        $pdf->SetTextColorArray($pdf->convertHTMLColorToDec($pd['grid_row_text_color']));
                        $pdf->SetFont('');
                    }
                } for ($i = 0; $i < $ncols; $i++) {
                    if (isset($ahidden[$i]) && $ahidden[$i])
                        continue; $pdf->MultiCell($colwidth[$i], $maxh, $varr[$i], 1, $align[$i], $fill, 0, '', '', true, 0, true, true, 0, 'T', false);
                }
            } if ($pd['grid_alternate_rows']) {
                $fill = !$fill;
            } 
            $pdf->Ln();
            $rows += 1;
            if ($rows >= $gSQLMaxRows) {
                break;
            }
        } 
        
        if ($this->tmpvar) {
            $pdf->SetFont('', 'B');
            for ($i = 0; $i < $ncols; $i++) {
                
                if (isset($ahidden[$i]) && $ahidden[$i])
                    continue; 
                
                foreach ($this->tmpvar as $key => $v) {
                    if ($fnmkeys[$i] == $key) {
                        $vv = $v;
                        break;
                    } else {
                        $vv = '';
                    }
                }
                
                $pdf->Cell($colwidth[$i], $pd['grid_row_height'], $vv, 1, 0, $align[$i], $fill, '', 1);
                
            }
        }
        
    }
    
}

?>
