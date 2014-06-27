        <form action="/index.php/Modulos/guardar" title="Administrar Cargos" method="post" id="cargosform" class="formulario ">

            <table style="width: 100%">
                <tr>
                    <td>
                        <label class="required" for="descripcion">Descripcion</label>
                        <br/>
                        <input type="text" name="descripcion" id="descripcion" class="text ui-widget-content ui-corner-all" style="width: 100%"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="required" for="id_oficina">Dependencia:</label><br/>
                        <select name="id_oficina" id="id_oficina" title="Seleccione una dependencia" style="width: 100%">
                            {foreach from=$oficina item="o"}
                                <option value="{$o['id_oficina']}" >{$o['nombre']|replace:"=":"&nbsp;"}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="required" for="id_perfil">Perfil:</label><br/>
                        <select name="id_perfil" id="id_perfil" title="Seleccione un perfil" style="width: 100%">
                            {foreach from=$perfil item="p"}
                                <option value="{$p->id_perfil}" >{$p->descripcion}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
            </table>
            
            <input type="hidden" name="id_cargo" id="id_cargo" value ="-1"/>
            
        </form>