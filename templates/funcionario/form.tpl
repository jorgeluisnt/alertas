{include file=$links}
<script type="text/javascript" src="{$HOST}js/modulos/funcionario.js"></script>
<script type="text/javascript">

        {$grilla}

</script>

    <fieldset class="ui-widget ui-widget-content" style="width: 80%;float: left;">
        <legend class="ui-widget-content ui-widget-header">Administraci&oacute;n de Funcionarios</legend>
        <table id="TTabla"></table>
        <div id="DTabla"></div>
    </fieldset>

        <div id="botones" style="width: 15%;float:left;">
            {if $activo eq 'A'}
            <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
                <legend class="ui-widget-header ui-corner-all">Operaciones</legend>

                <button id="nuevo" >Nuevo Personal</button>
                <button id="modificar" >Modificar Personal</button>
                <button id="eliminar" >Eliminar Personal</button>


            </fieldset>
            {/if}
             <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
                  <legend class="ui-widget-header ui-corner-all">Habilitar</legend>
             {if $activo eq 'A'}
                <button id="inactivo_btn">Inactivos</button>
            {else}
                <button id="habilitar_btn">Habilitar</button>
                <button id="atras">Atras</button>

            {/if}
             </fieldset>
        </div>

        
{include file=$datos}

