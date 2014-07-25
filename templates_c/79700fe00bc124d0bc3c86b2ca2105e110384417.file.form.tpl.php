<?php /* Smarty version 3.0rc1, created on 2014-07-03 11:11:59
         compiled from "./templates/permisos/form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:100042852353b580cf907a57-42534233%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '79700fe00bc124d0bc3c86b2ca2105e110384417' => 
    array (
      0 => './templates/permisos/form.tpl',
      1 => 1403824735,
    ),
  ),
  'nocache_hash' => '100042852353b580cf907a57-42534233',
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
js/jquery.jstree.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/grid.locale-es.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/util.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/config.js"></script>

 
<script type="text/javascript">

    
    jQuery(document).ready(function(){
        
        jQuery('#lsperfil').jqGrid({
        url:URLINDEX + '/perfil/lista',
        height:'350',
        datatype: 'json',
        colNames:['Descripcion'],
        colModel:[
            { name:'descripcion',index:'descripcion',width:'150',sortable:'false',search:'true',align:'left'}
        ],
        rowNum:20,
        rowList:[10,20,30],
        forceFit:false,
        pager:'#pgperfil',
        sortname:'descripcion',
        autowidth:true,
        viewrecords:true,
        multiselect:false,
        sortorder:'asc',
        rownumbers:true,
        caption:'Perfil',
        onSelectRow: function(ids) {
            if(ids == null) {
                                        $("#tree").jstree({
                                                plugins : [ "themes", "json_data", "checkbox","sort", "ui" ],
                                                themes : {
                                                        theme : "apple",
                                                        url : URLHOST + 'css/apple/style.css'
                                                    },
                                                json_data : {
                                                    ajax : {
                                                        url : URLINDEX + "/modulos/getPermisos",
                                                        data : {
                                                               id_cargo : 0
                                                            }
                                                        }
                                                    }
                                        });
            } else {

                                    $("#tree").jstree({
                                            plugins : [ "themes", "json_data", "checkbox","sort", "ui" ],
                                            themes : {
                                                    theme : "apple",
                                                    url : URLHOST + 'css/apple/style.css'
                                                },
                                            json_data : {
                                                ajax : {
                                                    url : URLINDEX + "/modulos/getPermisos",
                                                    data : {
                                                           id_cargo : ids
                                                        }
                                                    }
                                                }
                                    });

            }
         },
         gridComplete:function(){
                $("#tree").jstree({
                            plugins : [ "themes", "json_data", "checkbox","sort", "ui" ],
                            themes : {
                                    theme : "apple",
                                    url : URLHOST + 'css/apple/style.css'
                                },
                            json_data : {
                                ajax : {
                                    url : URLINDEX + "/modulos/getPermisos",
                                    data : {
                                           id_cargo : 0
                                        }
                                    }
                                }
                    });
            }
    });
    
    jQuery('#lsperfil').jqGrid('navGrid','#pgperfil',{ edit:false,add:false,del:false,search:false});jQuery('#lsperfil').jqGrid('filterToolbar',{ stringResult: true,searchOnEnter : true});
    
	$("#tree").jstree({
		plugins : [ "themes", "json_data", "checkbox","sort", "ui" ],
                themes : {
                        theme : "apple",
                        url : URLHOST + 'css/apple/style.css'
                    },
                json_data : {
                    ajax : {
                        url : URLINDEX + "/modulos/getPermisos",
                        data : {
                               id_cargo : 0
                            }
                        }
                    }
	});
        
        
        $( "#actualizar_perfil" ).button()
            .click(function() {
                
                var aPermisos = [];
                var p;
                
                $('#tree').find('li').each(function(i, element){


                    if($(element).hasClass("jstree-checked") || $(element).hasClass("jstree-undetermined")){
                        p = 'A';
                    }else{
                        p = 'I';
                    }

                    aPermisos.push({ id:this.id,val:p}); 

                });
                
                if (aPermisos.length > 0){

                            $.get(
                                URLINDEX + '/modulos/actualizarPermisos',
                                {
                                    ajax:'ajax',
                                    permisos:aPermisos
                                },

                                function(response){

                                    Mensaje('Permisos actualizados','Mensaje');

                                },
                                'json'
                            );
                                
                }else{
                    Mensaje('Carge los permisos','Error');
                }
                
            });
        
    });

</script>

<div style="width: 100%">
    
    <div style="width: 410px;float: left">
        
        <table id="lsperfil"></table>
        <div id="pgperfil"></div>
        
    </div>
    
    <div style="width: 400px;float: left" >
        
    <fieldset class="ui-widget ui-widget-content"> 
      <legend class="ui-widget-header ui-corner-all">Permisos</legend>
        
    <div id="tree" style="font-size: 12px;overflow: auto;height: 360px">

    </div>
      
        <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
            <legend class="ui-widget-header ui-corner-all">Confirmar</legend>

            <input type="button" id="actualizar_perfil" value="Actualizar Permisos" />
            <span id="load"></span>
        </fieldset>
        
    </fieldset>
    
    </div>
    
</div>


