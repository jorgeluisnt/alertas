<?php
$url=$_POST['url'];
if(!isset($_REQUEST['width']))$width="100%";
else $width=$_REQUEST['width'];
if(!isset($_REQUEST['height']))$height="500px";
else $height=$_REQUEST['height'];
?>
<iframe 
    name="ventanaFrame" 
    id="ventanaFrame" 
    src="<?php echo $url;?>" 
    width="<?php echo $width; ?>" 
    height="<?php echo $height; ?>" 
    border='0' 
    frameborder='0'>
</iframe>