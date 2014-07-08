<div id="frm_funcionario" title="Administrar Funcionario">
    

    <form id="oform" method="post" action="#" >


                    <table width="100%">
                        <tr>
                            <td>
                                <label class="required" for="nombres">Nombres:</label><br/>
                                <input type="text" id="nombres" class="text ui-widget-content ui-corner-all" style="width: 250px" value="" name="nombres"/>
                                <input type="hidden" id="id_funcionario" class="full" value="-1" name="id_funcionario"/>
                            </td>
                            <td>
                                <label class="required" for="apellidos">Apellidos:</label><br/>
                                <input type="text" id="apellidos" class="text ui-widget-content ui-corner-all" style="width: 250px" value="" name="apellidos"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="required" for="direccion">Direccion:</label><br/>
                                <input type="text" id="direccion" class="text ui-widget-content ui-corner-all" style="width: 100%" value="" name="direccion"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="required" for="dni">Dni:</label><br/>
                                <input type="text" id="dni" value="" class="text ui-widget-content ui-corner-all" style="width: 250px" name="dni" onkeypress="return validarNumeros(event);" maxlength="8"/>
                            </td>
                            <td>
                                <label for="email">Email:</label><br/>
                                <input type="text" id="email" class="text ui-widget-content ui-corner-all" value="" style="width: 250px;text-transform: lowercase;" name="email" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="required" for="id_oficina">Dependencia:</label><br/>
                                <select name="id_oficina" id="id_oficina" style="width: 500px;" title="Seleccione una oficina" onchange="cargarCargos();">
                                    {foreach from=$oficina item="p"}
                                        <option value="{$p['id_oficina']}" >{$p['nombre']|replace:"=":"&nbsp;"}</option>
                                    {/foreach}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="required" for="id_cargo">Cargo:</label><br/>
                                <select name="id_cargo" id="id_cargo" style="width: 500px;" title="Seleccione un cargo">
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="required" for="id_funcionario_jefe">Jefe:</label><br/>
                                <select name="id_funcionario_jefe" id="id_funcionario_jefe" style="width: 500px;" title="Seleccione una jefe">
                                    <option value="0" >NINGUNO</option>
                                    {foreach from=$funcionarios item="p"}
                                        <option value="{$p['id_funcionario']}" >{$p['funcionario']}</option>
                                    {/foreach}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="checkbox" name="es_usuario" id="es_usuario" value="ON" /><label class="required" for="usuario">¿Es Usuario del sistema?</label><br/>
                            </td>
                        </tr>
                         {if $perfil eq 1}
                             <tr id="trUsuario" style="display: none;">
                                <td>

                                    <label class="required" for="usuario">Usuario:</label><br/>
                                    <input type="text" id="usuario" class="text ui-widget-content ui-corner-all" value="" style="width: 250px;text-transform: lowercase;" name="usuario"/>
                                </td>
                                <td>
                                    <label class="required" for="clave">Clave:</label><br/>
                                    <input type="password" id="clave" class="text ui-widget-content ui-corner-all" value="" style="width: 250px" name="clave"/>
                                </td>
                            </tr>
                        {/if}
                    </table>

        </form>
    </div>