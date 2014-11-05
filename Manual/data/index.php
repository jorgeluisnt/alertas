<?php 
	ob_start(); 
	include_once 'data.html'; 
	$outputHtml = ob_get_clean(); 
	ini_set("memory_limit","1024M"); 
	set_time_limit(0); 
	include_once 'mpdf/mpdf.php'; 
	$mpdf = new mPDF("C", "A4", 0, '', 8,8,1,4,9,9, 'P');//left right top inferior 
	$mpdf->list_indent_first_level = 0; // 
	$mpdf->SetDisplayMode('fullpage'); 
	$stylesheet = file_get_contents("estilos.css"); 
	$mpdf->WriteHTML($stylesheet,1); 
	$mpdf->WriteHTML($outputHtml); 
	$mpdf->Output(); 
	exit;
 ?>