{include file=$links}
<script type="text/javascript" src="{$HOST}js/modulos/perfil.js"></script>
<script type="text/javascript">

        {$grilla}

</script>

    <fieldset class="ui-widget ui-widget-content" style="width: 80%;float: left;">
        <legend class="ui-widget-content ui-widget-header">Administraci&oacute;n Tipos de Servicios</legend>
        <table id="TTabla"></table>
        <div id="DTabla"></div>
    </fieldset>

        <div id="botones" style="width: 15%;float:left;">
            <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
                <legend class="ui-widget-header ui-corner-all">Operaciones</legend>

                <button id="nuevo" >Nuevo Perfil</button>
                <button id="modificar" >Modificar Perfil</button>
                <button id="eliminar" >Eliminar Perfil</button>


            </fieldset>
        </div>

        
{include file=$datos}