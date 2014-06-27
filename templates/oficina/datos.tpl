<form action="/index.php/Modulos/guardar" title="Administrar Oficinas" method="post" id="oform" class="formulario ">

    <table style="width: 100%">
        <tr>
            <td>
                <label class="required" for="nombre">Nombre</label>
                <br/>
                <input type="text" name="nombre" id="nombre" class="text ui-widget-content ui-corner-all" style="width: 100%"/>
            </td>
        </tr>
        <tr>
            <td>
                <label class="required" for="telefono">Telefono</label>
                <br/>
                <input type="text" name="telefono" id="telefono" class="text ui-widget-content ui-corner-all" style="width: 100%" onkeypress="return validarNumeros(event);"/>
            </td>
        </tr>
        <tr>
            <td>
                <label class="required" for="abreviatura">Abreviatura</label>
                <br/>
                <input type="text" name="abreviatura" id="abreviatura" class="text ui-widget-content ui-corner-all" style="width: 100%"/>
            </td>
        </tr>
        <tr>
            <td>
                <label class="required" for="id_tipo_oficina">Tipo Oficina:</label><br/>
                <select name="id_tipo_oficina" id="id_tipo_oficina" class="full"  title="Seleccione un tipo oficina" style="width: 100%">
                    {foreach from=$tipo item="to"}
                        <option value="{$to->id_tipo_oficina}" >{$to->descripcion}</option>
                    {/foreach}
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label class="required" for="id_municipalidad">Entidad::</label><br/>
                <select name="id_municipalidad" id="id_municipalidad" class="full"  title="Seleccione una municipalidad" style="width: 100%">
                    {foreach from=$entidad item="m"}
                        <option value="{$m->id_municipalidad}" >{$m->razon_social}</option>
                    {/foreach}
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label class="required" for="padre">Dependencia:</label><br/>
                <select name="padre" id="padre" class="full"  title="Seleccione una dependencia" style="width: 100%">
                    <option value="0">NINGUNA</option>
                    {foreach from=$padre item="p"}
                        <option value="{$p['id_oficina']}" >{$p['nombre']|replace:"=":"&nbsp;"}</option>
                    {/foreach}
                </select>
            </td>
        </tr>
    </table>

    <input type="hidden" name="id_oficina" id="id_oficina" value ="-1"/>

</form>