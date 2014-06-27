<form action="index.php/Modulos/guardar" title="Administrar Modulos" method="post" id="frm_Modulos" class="formulario ">

            <table style="width: 100%">
                <tr>
                    <td>
                        <label class="required" for="descripcion">Descripcion</label>
                        <br/>
                        <input type="text" name="descripcion" id="descripcion" class="text ui-widget-content ui-corner-all" style="text-transform: none;width: 100%"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label  class="required"  for="url">Url</label>
                        <br/>
                        <input type="text" name="url" id="url" class="text ui-widget-content ui-corner-all" style="text-transform: none;width: 100%" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label  class="required"  for="url">Orden</label>
                        <br/>
                        <input type="text" name="orden" id="orden" class="text ui-widget-content ui-corner-all" style="text-transform: none;width: 100%" onkeypress="return validarNumeros(event);" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label  class="required" for="descripcion">Dependencia</label>
                        <br/>
                        <select name="id_padre" id="id_padre" style="width: 100%" title="Seleccione dependencia">
                            <option value="0" >Ninguno</option>
                            {foreach from=$dependencias item="d"}
                                <option value="{$d->id_modulos}" >{$d->descripcion}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
            </table>
            
            <input type="hidden" name="id_modulos" id="id_modulos" value ="-1"/>
</form>


