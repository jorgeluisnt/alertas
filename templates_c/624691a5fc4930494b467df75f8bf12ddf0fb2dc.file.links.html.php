<?php /* Smarty version 3.0rc1, created on 2014-06-26 19:18:19
         compiled from "./templates/links.html" */ ?>
<?php /*%%SmartyHeaderCode:189564804753acb84b943056-93535244%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '624691a5fc4930494b467df75f8bf12ddf0fb2dc' => 
    array (
      0 => './templates/links.html',
      1 => 1403824737,
    ),
  ),
  'nocache_hash' => '189564804753acb84b943056-93535244',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
css/style.css"/>
<link type="text/css" rel="stylesheet" media="screen" href="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
css/theme/jquery-ui.custom.css"/>
<link type="text/css" rel="stylesheet" media="screen" href="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
css/ui.jqgrid.css"/>


<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/grid.locale-es.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/jquery.validate_pack.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/jquery.backgroundalert.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/config.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/util.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/required.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/ubigeo.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/jquery.comboedit.js"></script>
<style type="text/css">
    .focus_campo{
        background:#E7FFE7;
    }
    .parameters_overlay {
        position: absolute;
        text-align: center;
        left: 0px;
        top: 0;
        background: url(<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
images/overlay.png);
        z-index: 11000;
        -moz-border-radius: 5px;
        -khtml-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
    }
    .loader {
        background-color: #ffffff;
        margin: 0 auto 0 auto;
        margin-top: 5px;
        height: 60px;
        width: 200px;
        -moz-border-radius: 5px;
        -khtml-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        font-size: 12px;
        font-family: Helvetica, Arial, sans-serif;
        font-weight: bold;
         color: red;
    }
</style>
<script type="text/javascript">
    $(function(){
        $("select,input,input[type=text],input[type=password],textarea").addClass("text ui-widget-content ui-corner-all"); 
        $("select,input,input[type=text],input[type=password],textarea").focus(function(){
            $(this).addClass("focus_campo");
        });
        $("select,input,input[type=text],input[type=password],textarea").blur(function(){
            $(this).removeClass("focus_campo");
        });
    });
</script>

 <script type="text/javascript">
        
        var w = 0;
        var h = 0;
        $(function(){
            w = $('body').width();
            h = $('body').height();
        });
        
        var __USE_GENERIC_LOADING__ = true;

        $(document).ajaxSend(function(evt, request, settings) {
            
            $("#contentLoading").css('width', w);
            $("#contentLoading").css('height', h);
            
            if (__USE_GENERIC_LOADING__)
                $("#contentLoading").show();
        });

        $(document).ajaxStop(function(r, s) {
           if (__USE_GENERIC_LOADING__)
                $("#contentLoading").fadeOut("fast");
        });
  
      function invalidateGenericLoading() {
             __USE_GENERIC_LOADING__ = false;
         }
 </script>
 
 <div class="parameters_overlay" id="contentLoading">
     <div style="width: 100%;">
         <div class="loader">
             Procesando operacion...
             <div id="loaderImage" style="margin: 0 auto 0 auto;width: 50px;"></div>
         </div>
     </div>
 </div>

<script type="text/javascript">
	var cSpeed=6;
	var cWidth=40;
	var cHeight=40;
	var cTotalFrames=25;
	var cFrameWidth=40;
	var cImageSrc='<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
images/sprites.gif';
	
	var cImageTimeout=false;
	var cIndex=0;
	var cXpos=0;
	var SECONDS_BETWEEN_FRAMES=0;
	
	function startAnimation(){
		
		document.getElementById('loaderImage').style.backgroundImage='url('+cImageSrc+')';
		document.getElementById('loaderImage').style.width=cWidth+'px';
		document.getElementById('loaderImage').style.height=cHeight+'px';
		
		//FPS = Math.round(100/(maxSpeed+2-speed));
		FPS = Math.round(100/cSpeed);
		SECONDS_BETWEEN_FRAMES = 1 / FPS;
		
		setTimeout('continueAnimation()', SECONDS_BETWEEN_FRAMES/1000);
		
	}
	
	function continueAnimation(){
		
		cXpos += cFrameWidth;
		//increase the index so we know which frame of our animation we are currently on
		cIndex += 1;
		 
		//if our cIndex is higher than our total number of frames, we're at the end and should restart
		if (cIndex >= cTotalFrames) {
			cXpos =0;
			cIndex=0;
		}
		
		document.getElementById('loaderImage').style.backgroundPosition=(-cXpos)+'px 0';
		
		setTimeout('continueAnimation()', SECONDS_BETWEEN_FRAMES*1000);
	}
	
	function imageLoader(s, fun)//Pre-loads the sprites image
	{
		clearTimeout(cImageTimeout);
		cImageTimeout=0;
		genImage = new Image();
		genImage.onload=function (){ cImageTimeout=setTimeout(fun, 0) };
		genImage.onerror=new Function('alert(\'Could not load the image\')');
		genImage.src=s;
	}
	
	//The following code starts the animation
	new imageLoader(cImageSrc, 'startAnimation()');
</script>