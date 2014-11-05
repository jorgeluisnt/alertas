<?php /* Smarty version 3.0rc1, created on 2014-08-07 15:20:23
         compiled from "./templates/login.html" */ ?>
<?php /*%%SmartyHeaderCode:196149968953e3df87931ea9-86328866%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '35d625b9220e24ba6b4c2233dd9c8efe5682c791' => 
    array (
      0 => './templates/login.html',
      1 => 1403824737,
    ),
  ),
  'nocache_hash' => '196149968953e3df87931ea9-86328866',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<style>
    /* http://meyerweb.com/eric/tools/css/reset/ 
       v2.0 | 20110126
       License: none (public domain)
    */
    * { margin:0; padding:0 ; border:0; }

    html, body, div, span, applet, object, iframe,
    h1, h2, h3, h4, h5, h6, p, blockquote, pre,
    a, abbr, acronym, address, big, cite, code,
    del, dfn, em, img, ins, kbd, q, s, samp,
    small, strike, strong, sub, sup, tt, var,
    b, u, i, center,
    dl, dt, dd, ol, ul, li,
    fieldset, form, label, legend,
    table, caption, tbody, tfoot, thead, tr, th, td,
    article, aside, canvas, details, embed, 
    figure, figcaption, footer, header, hgroup, 
    menu, nav, output, ruby, section, summary,
    time, mark, audio, video {
        margin: 0;
        padding: 0;
        border: 0;
        font-size: 100%;
        font: inherit;
        vertical-align: baseline;


    }
    /* HTML5 display-role reset for older browsers */
    article, aside, details, figcaption, figure, 
    footer, header, hgroup, menu, nav, section {
        display: block;
    }

    #sfondo-css{
        position:absolute;
        height:100%;
        width: 100%;
        margin: 0;
        padding: 0;
        z-index: 1;
    }





    ol, ul {
        list-style: none;
    }
    blockquote, q {
        quotes: none;
    }
    blockquote:before, blockquote:after,
    q:before, q:after {
        content: '';
        content: none;
    }
    table {
        border-collapse: collapse;
        border-spacing: 0;
    }

    h1 { font-size:26px;}
    h2 { font-size:20px;}
    h3 { font-size:16px;}
    h4 { font-size:14px;}
    h5 { font-size:12px;}
    h6 { font-size:10px;}

    li { list-style:none;}
    a { text-decoration:none;}
    a:hover { text-decoration:underline;}


    #css{
        position: absolute;
        z-index: 2;
        height: 100%;
        width: 100%;
        line-height:1;
    }

    #middiv { position: absolute; left: 50%; top: 50%; width: 470px; height: 270px; margin-left: -235px; margin-top: -135px; overflow: auto; z-index:4; }
    #login {	background:url(images/logingbg.png) no-repeat; height:270px; width:470px;   position:absolute;	}
    #derechalog { float:left; width:300px; display:inline; overflow:hidden;   word-wrap: break-word;}
    #izquierdalog { float:right; width:160px; text-align:right; display:inline; overflow:hidden;   word-wrap: break-word;}
    #titlog {	 height:38px;   margin:10px;   	}
    #camposlog { margin:10px 25px 10px 25px; }
    #pielog { font-size:13px; color:#666666; font-weight:700; margin-left:25px; }
    #recordarlog { float:left; padding-top:5px;}
    #camposlog label{ display:block; font-family:Arial, Helvetica, sans-serif;   font-weight:bold; color:#747474; }

    .txtlogin {

        margin: 5px 40px 5px 0px;
        padding: 5px 10px 5px 10px;
        width: 250px;
        vertical-align: middle;
        border: 1px solid #B5B5B5 !important;
        cursor: pointer;
        cursor: hand;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        box-shadow: 0px 0px 2px 1px #999999;
        background-color: #cccccc;
        color: #666;
        font-weight: bold;
    }

    .login_error {
        margin: 5px 40px 5px 0px;
        padding: 5px 10px 5px 10px;
        width: 250px;
        vertical-align: middle;
        border: 2px solid #f00 !important;
        cursor: pointer;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        border-radius: 10px;
        box-shadow: 0px 0px 2px 1px #c00;
        background-color: #cccccc;
        color: #666;
        font-weight: bold;
    }


    #txtuno { color:#FFFFFF; font-size:15px; margin-top:85px; font-family:Arial, Helvetica, sans-serif;  margin-right:26px; }
    #txtuno a{ color:#FFFFFF; }
    #txtuno span { color:#FFFFFF; font-size:20px; font-weight:bold; margin-top:80px; font-family:Arial, Helvetica, sans-serif;  }
    #txtdos { color:#FFFFFF; font-size:15px; margin-top:25px; font-family:Arial, Helvetica, sans-serif; margin-right:26px;}
    #txtdos a{ color:#FFFFFF; }
    #txtdos span { color:#FFFFFF; font-size:20px; font-weight:bold; margin-top:80px; font-family:Arial, Helvetica, sans-serif;  }
    #txttres { color:#FFFFFF; font-size:15px; margin-top:25px; font-family:Arial, Helvetica, sans-serif; margin-right:26px;}
    #txttres a{ color:#FFFFFF; }
    #txttres span { color:#FFFFFF; font-size:20px; font-weight:bold; margin-top:80px; font-family:Arial, Helvetica, sans-serif;  }

    .btnloggin{
        background: white url(images/iniciarbtn.png) no-repeat top;
        width: 110px;
        height: 29px;
        background-position:0 0;
        color:white;
        float:right;
        margin-right:27px;
    }

    .btnloggin:hover
    {
        background: white url(images/iniciarbtn.png) no-repeat top;
        width: 110px;
        height: 29px;
        background-position:-110 0;
        color:white;
        cursor:hand;
    }


    .alertared {
        margin:0 auto 8px auto;
        padding: 4px;
        color: #993333;
        border-top: 1px solid #600;
        border-bottom: 1px solid #600;
        background: #fdd2d2 url("images/action_stop.gif") no-repeat 8px 50%;
        width:87%;
        text-align:center;
        font-family:Helvetica,Arial;
        font-size: 11px
    }




</style>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/login.js"></script>

<body>    
    <div id='css'>
        <div>
            <img id="sfondo-css" src="images/03.png" alt="css sfondo" />
        </div>
        <div id="middiv">
            <div id='login'>
                <div id='derechalog'>
                    <form action='<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
index.php/login' method='post' id="logeouser23129042">
                        <div id='titlog'>
                        </div> <!-- end of titlog-->

                        <?php if ($_smarty_tpl->getVariable('mensaje')->value!=''){?>
                            <div class="alertared"><?php echo $_smarty_tpl->getVariable('mensaje')->value;?>
</div>
                        <?php }?>
                        
                        <div id='camposlog'>
                            <label>Usuario:</label>
                            <input type="text" name='usuario' id='usuario'  class="txtlogin" >
                            <label>Contrase&ntilde;a:</label>
                            <input type="password" name='clave' id='clave' class="txtlogin" >      
                        </div> <!-- end of camposlog-->
                        <div id='pielog'>
                            <input type="checkbox" name="recordar" class="chkrecordar">
                            <small style="font-family:Helvetica,Arial;font-size: 11px">&nbsp;&nbsp;Recordar mi sesi&oacute;n</small>
                            <input type="submit" value="" id="hola" class="btnloggin" title="iniciar sesion" >
                        </div>
                    </form>
                </div> <!-- end of derecha-->
                <div id="izquierdalog"> 
                    <div id='txtuno'><a href='#'>Olvido su <br/><span>Contrase&ntilde;a</span></a></div>
                    <div id='txtdos'><a href='#'>Olvido su <br/><span>Usuario</span></a></div>
                    <div id='txttres'><a href='#'>Solicitar una <br/><span>Nueva cuenta</span></a></div>    
                </div> <!-- end of izquierda-->
            </div> <!-- end of login-->
        </div><!-- end of middiv-->
    </div><!-- end of css-->
</body>