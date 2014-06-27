<?php

    function is_date($str) {
        $stamp = strtotime($str);
        if(strlen($str)<2) return FALSE;
        if (!is_numeric($stamp)) {
            return FALSE;
        }
        $month = date('m', $stamp);
        $day = date('d', $stamp);
        $year = date('Y', $stamp);
        
        if (checkdate($month, $day, $year)) {
            return TRUE;
        }

        return FALSE;
    }

    function getFechaLarga($fecha,$tipo=1){

        $stamp = strtotime($fecha);

        $month = date('m', $stamp);
        $day = date('d', $stamp);
        $year = date('Y', $stamp);
        
        if ($tipo==1)
            $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre');
        if ($tipo==2)
            $meses = array('ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SET','OCT','NOV','DIC');
        if ($tipo==3)
            $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre');
        
        if($tipo==1)
            return $day.' de '.$meses[$month-1].' del '.$year;
        if($tipo==2)
            return $day.$meses[$month-1].$year;
        if($tipo==3)
            return $meses[$month-1];   
    }


    function es_numero($var, $campo) {

        if (stristr($campo, 'num_documento') || stristr($campo, 'dni') || stristr($campo, 'ruc')|| stristr($campo, 'b_codigopatrimonio')|| stristr($campo, 'tb_id')|| stristr($campo, 'f_nrodoc')) {
            return false;
        } else {
            return is_numeric($var);
        }
    }

    function Get_Edad($date) {
        // Si no es una marca de tiempo intentamos convertirla 
        if (!is_integer($date)) {
            if (strtotime($date) <> -1) { // Si es diferente a -1 convertimos la fecha 
                $date = strtotime($date);
            } else { // No parece ser una fecha válida 
                return 0;
            }
        }

        // Procesamos la marca de tiempo 
        $ano = date("Y", $date);
        $mes = date("m", $date);
        $dia = date("d", $date);

        // Calculamos los años que tiene 
        $anos = date("Y") - $ano;

        if (date("m") > $mes) { // Si el mes es superior, tenemos los años calculados anteriormente 
            return $anos;
        } elseif (date("m") < $mes) { // Si el mes es inferior tenemos tenemos un año menos 
            return $anos - 1;
        } else { // Este mes es su cumpleaños 
            if (date("d") > $dia) { // Si el día es superior tenemos los años calculados anteriormente 
                return $anos;
            } elseif (date("d") < $dia) { // Si el día es inferior tenemos  un año menos 
                return $anos - 1;
            } else { // Hoy es su cumpleaños 
                return $anos;
            }
        }
    }
    
    
    function thumbnail($img_origen, $nueva_anchura, $nueva_altura,$tras = false){  
        $extension = explode(".",$img_origen);  
        $ext = count($extension)-1;  
            if($extension[$ext] == "jpg" || $extension[$ext] == "jpeg")  
            {  
                $image = ImageCreateFromJPEG($img_origen);  
                $tipo=1; 
            }  
            else if($extension[$ext] == "gif"){  
                $image = ImageCreateFromGIF($img_origen);  
                $tipo=2; 
            }  
            else if($extension[$ext] == "png"){  
                $image = ImageCreateFromPNG($img_origen);  
                $tipo=3; 
            }  
            else  
            {  
                return FALSE; 
            }
            
            $width  = imagesx($image); 
            $height = imagesy($image);
            
            if ($nueva_anchura == null)
                $nueva_anchura = $width;
            
            if ($nueva_altura == null)
                $nueva_altura = $height;
            
            if (function_exists("imagecreatetruecolor"))  
            {  
               $thumb = ImageCreateTrueColor($nueva_anchura, $nueva_altura); 
            }  


            if (!$thumb) $thumb = ImageCreate($nueva_anchura, $nueva_altura); 
            
//            $colorTransparancia = imagecolortransparent($image);// devuelve el color usado como transparencia o -1 si no tiene transparencias
            
            if($tras == true){
                imagealphablending($thumb, false);
                imagesavealpha($thumb, true);
                $transparente = imagecolorallocate($thumb, 255, 255, 255); 
                imagefill($thumb, 0, 0, $transparente); 
                imagecolortransparent($thumb, $transparente); 
            } 

            imagecopyresampled($thumb, $image, 0, 0, 0, 0, $nueva_anchura, $nueva_altura, $width, $height);       
            
            return $thumb;  
    }//thumbnail  
    
    function crearCodigoBarrasEan8($texto){
        // Including all required classes
        require_once('barras/BCGFontFile.php');
        require_once('barras/BCGColor.php');
        require_once('barras/BCGDrawing.php');

        // Including the barcode technology
        require_once('barras/BCGean8.barcode.php');

        // Loading Font
        $font = new BCGFontFile('./barras/font/Arial.ttf', 9);

        // The arguments are R, G, B for color.
        $color_black = new BCGColor(0, 0, 0);
        $color_white = new BCGColor(255, 255, 255);

        $drawException = null;
        try {
                $code = new BCGean8();
                $code->setScale(1); // Resolution
                $code->setThickness(30); // Thickness
                $code->setForegroundColor($color_black); // Color of bars
                $code->setBackgroundColor($color_white); // Color of spaces
                
                $code->setFont($font); // Font (or 0)
                $code->parse($texto); // Text
                
        } catch(Exception $exception) {
                $drawException = $exception;
        }

        /* Here is the list of the arguments
        1 - Filename (empty : display on screen)
        2 - Background color */
        $drawing = new BCGDrawing('', $color_white);
        if($drawException) {
                $drawing->drawException($drawException);
        } else {
                $drawing->setBarcode($code);
                $drawing->setRotationAngle(270);
                $drawing->setFilename('barras/codigoEan8.png');

                $drawing->draw();
                
                
        }

        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
    }
    
    function crearCodigoBarrasCode11($texto){
        // Including all required classes
        require_once('barras/BCGFontFile.php');
        require_once('barras/BCGColor.php');
        require_once('barras/BCGDrawing.php');

        // Including the barcode technology
        require_once('barras/BCGcode11.barcode.php');

        // Loading Font
        $font = new BCGFontFile('./barras/font/Arial.ttf', 9);

        // The arguments are R, G, B for color.
        $color_black = new BCGColor(0, 0, 0);
        $color_white = new BCGColor(255, 255, 255);

        $drawException = null;
        try {
                $code = new BCGcode11();
                $code->setScale(1); // Resolution
                $code->setThickness(10); // Thickness
                $code->setForegroundColor($color_black); // Color of bars
                $code->setBackgroundColor($color_white); // Color of spaces
                
                $code->setFont($font); // Font (or 0)
                $code->parse($texto); // Text
                
        } catch(Exception $exception) {
                $drawException = $exception;
        }

        /* Here is the list of the arguments
        1 - Filename (empty : display on screen)
        2 - Background color */
        $drawing = new BCGDrawing('', $color_white);
        if($drawException) {
                $drawing->drawException($drawException);
        } else {
                $drawing->setBarcode($code);
                $drawing->setRotationAngle(270);
                $drawing->setFilename('barras/codigoCode11.png');

                $drawing->draw();
                
                
        }

        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
    }
?>