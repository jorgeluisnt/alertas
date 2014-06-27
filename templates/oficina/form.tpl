 {include file=$links}
 
 <script type="text/javascript" src="{$HOST}js/modulos/oficina.js"></script>
 
<script type="text/javascript">

{$grilla}


</script>

<div style="width: 100%">
    
    <div style="width: 410px;float: left">
        
        <table id="TTabla"></table>
        <div id="DTabla"></div>
        
        
        <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
            <legend class="ui-widget-header ui-corner-all">Operaciones</legend>
            
            <button id="nuevo">Nuevo</button>
            <button id="modificar" >Modificar</button>
            <button id="eliminar" >Eliminar</button>
            <span id="load"></span>
        </fieldset>
        
    </div>
    
    <div style="width: 400px;float: left" >
        
    <fieldset class="ui-widget ui-widget-content"> 
      <legend class="ui-widget-header ui-corner-all">Datos</legend>
        
        {include file=$datos}
      
        <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
            <legend class="ui-widget-header ui-corner-all">Confirmar</legend>

            <button id="guardar" >Guardar</button>
            <button id="cancelar" >Cancelar</button>
        </fieldset>
        
    </fieldset>
    
    </div>
    
</div>
