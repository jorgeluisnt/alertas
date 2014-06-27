<?php

    function ImprimirValeCombustible($datos){
        
        $numalet= new CNumeroaletra;
        $numalet->setNumero(floatval($datos['cantidad']));
        $numalet->setMayusculas(1);
        //cambia a femenino
        $numalet->setGenero(0);
        //cambia moneda
        $numalet->setMoneda("");
        //cambia prefijo
        $numalet->setPrefijo("");
        //cambia sufijo
        $numalet->setSufijo("");
        
        $html = '

            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Documento sin título</title>
            </head>

            <body>

            <table width="560"  border="0" style="border: 1 solid #000000">
                  <tr>
                    <td width="135" height="102">&nbsp;</td>
                    <td width="205" align="center"><h3> REGIÒN </h3>
                    <h3>AMAZONAS</h3></td>
                    <td width="204"><table width="200"border="0" style="border: 1 solid #000000">
                      <tr>
                        <td colspan="3" align="center">FECHA</td>
                      </tr>
                      <tr>
                        <td border="0" width="65" style="border: 1 solid #000000">'.$datos['dia'].'</td>
                        <td border="0" width="65" style="border: 1 solid #000000">'.$datos['mes'].'</td>
                        <td border="0" width="65" style="border: 1 solid #000000">'.$datos['anio'].'</td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
            <table width="560" border="0" style="border: 1 solid #000000">
                    <tr>
                      <td width="390" align="center">VALE DE COMBUSTIBLE - '.$datos['combustible'].'</td>
                      <td width="26">Nº</td>
                      <td width="128" border="0" style="border: 1 solid #000000">'.$datos['numero_vale'].'</td>
                    </tr>
                  </table>
            <table   bgcolor="#CCCCCC" width="560" border="0" style="border: 1 solid #000000">
              <tr>
                <td width="93">GRIFO</td>
                <td width="167" border="0" style="border: 1 solid #000000">'.$datos['grifo'].'</td>
                <td width="123" align="right">'.$datos['documento'].' Nº</td>
                <td width="156" border="0" style="border: 1 solid #000000">'.$datos['numero_documento'].'</td>
              </tr>
            </table>
            <table width="560" border="0" style="border: 1 solid #000000">
              <tr>
                <td width="123" valign="top"  bgcolor="#CCCCCC">Servirse atender al </td>
                <td colspan="5" border="0" style="border: 1 solid #000000"><p>'.$datos['conductor'].'</p>
                <p>&nbsp;</p></td>
              </tr>
              <tr>
                <td  bgcolor="#CCCCCC">Con:</td>
                <td colspan="4" border="0" style="border: 1 solid #000000">'.$datos['cantidad'].' - '.$numalet->letra().'</td>
                <td width="101"  bgcolor="#CCCCCC">Glns</td>
              </tr>
              <tr>
                <td  bgcolor="#CCCCCC">Kilometraje</td>
                <td colspan="5" border="0" style="border: 1 solid #000000">'.$datos['kilometraje'].'</td>
              </tr>
              <tr>
                <td  bgcolor="#CCCCCC">Para la Unidad</td>
                <td colspan="5" border="0" style="border: 1 solid #000000">'.$datos['unidad'].'</td>
              </tr>
              <tr>
                <td  bgcolor="#CCCCCC">Placa</td>
                <td colspan="2" border="0" style="border: 1 solid #000000">'.$datos['nro_placa'].'</td>
                <td width="83"  bgcolor="#CCCCCC">Registro</td>
                <td colspan="2" border="0" style="border: 1 solid #000000">'.$datos['registro'].'</td>
              </tr>
              <tr>
                <td  bgcolor="#CCCCCC">Entrada</td>
                <td width="79" border="0" style="border: 1 solid #000000">'.$datos['entrada'].'</td>
                <td width="75"  bgcolor="#CCCCCC">Salida </td>
                <td border="0" style="border: 1 solid #000000">'.$datos['salida'].'</td>
                <td width="57"  bgcolor="#CCCCCC">Saldo</td>
                <td border="0" style="border: 1 solid #000000">'.$datos['saldo'].'</td>
              </tr>
              <tr>
                <td valign="top"  bgcolor="#CCCCCC">Motivo</td>
                <td colspan="5"><p>'.$datos['motivo'].'</p></td>
              </tr>
            </table>
            <table width="560"border="0" style="border: 1 solid #000000">
              <tr>
                <td width="133">&nbsp;</td>
                <td width="92">Chachapoyas</td>
                <td width="89" border="0" style="border: 1 solid #000000">'.$datos['dia'].'</td>
                <td width="24">de</td>
                <td width="94" border="0" style="border: 1 solid #000000">'.getFechaLarga($datos['fecha'],3).'</td>
                <td width="45">del </td>
                <td width="78" border="0" style="border: 1 solid #000000">'.$datos['anio'].'</td>
              </tr>
            </table>
            <table width="560" height="103" border="0" style="border: 1 solid #000000">
                <tr>
                  <td height="23" colspan="2" align="left" valign="bottom">Autorizado por: '.$datos['funcionario'].'</td>
                </tr>
                <tr>
                  <td width="255" height="72" align="center" valign="bottom">Abastecimiento </td>
                  <td width="293" align="center" valign="bottom">Solicitante</td>
                </tr>
              </table>
            </body>
            </html>';
        
        return $html;
    }

    function ImprimirPapeletaLocal($datos){
        $html='

            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Documento sin título</title>
            </head>

            <body>

            <table width="759"  border="0" style="border: 1 solid #000000">
                  <tr>
                    <td width="114" height="135">&nbsp;</td>
                    <td width="262" align="center"><h3>GOBIERNO REGIONAL DE AMAZONAS</h3>JR. ORTIZ ARRIETA Nº 1250          CHACHAPOYAS - AMAZONAS - PERÙ          TELEF. 041-478131</td>
                    <td width="367"><table width="363" border="0" style="border: 1 solid #000000">
                      <tr>
                        <td width="92" align="right">VALE:</td>
                        <td width="240" border="0" style="border: 1 solid #000000">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="right">Nº GALONES:</td>
                        <td border="0" style="border: 1 solid #000000">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="right">GASOLINA:</td>
                        <td border="0" style="border: 1 solid #000000">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="right">PETROLEO:</td>
                        <td border="0" style="border: 1 solid #000000">&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
            <table width="760" bgcolor="#999999" border="0" style="border: 1 solid #000000">
              <tr>
                <td align="center">PAPELETA DE SALIDA DE VEHICULOS </td>
              </tr>
            </table>
            <table width="760" border="0" style="border: 1 solid #000000">
                    <tr>
                      <td width="529" align="center">SERVICIO LOCAL</td>
                      <td width="27">Nº</td>
                      <td width="182" border="0" style="border: 1 solid #000000">'.$datos['nro_papeleta'].'</td>
                    </tr>
                  </table>
            <table width="760" border="0" style="border: 1 solid #000000">
              <tr>
                <td width="145" bgcolor="#CCCCCC">SOLICITANTE:</td>
                <td width="599" border="0" style="border: 1 solid #000000">'.$datos['funcionario'].'</td>
              </tr>
              <tr>
                <td bgcolor="#CCCCCC">VEHICULO:</td>
                <td border="0" style="border: 1 solid #000000">'.$datos['unidad'].'</td>
              </tr>
              <tr>
                <td bgcolor="#CCCCCC">CHOFER:</td>
                <td border="0" style="border: 1 solid #000000">'.$datos['conductor'].'</td>
              </tr>
              <tr>
                <td bgcolor="#CCCCCC">FECHA:</td>
                <td border="0" style="border: 1 solid #000000">'.$datos['fecha'].'</td>
              </tr>
              <tr>
                <td bgcolor="#CCCCCC">MOTIVO:</td>
                <td border="0" style="border: 1 solid #000000">'.$datos['motivo'].'</td>
              </tr>
            </table>
            <table width="760"border="0" style="border: 1 solid #000000">';
           
        foreach ($datos['detalle'] as $value) {
            $html = $html.'
              <tr>
                <td width="144" bgcolor="#CCCCCC">HORA SALIDA</td>
                <td width="232" border="0" style="border: 1 solid #000000">'.$value['hora_salida'].'</td>
                <td width="135" bgcolor="#CCCCCC">RETORNO</td>
                <td width="221" border="0" style="border: 1 solid #000000">'.$value['hora_retorno'].'</td>
              </tr>       
            ';
        }
              
       $html = $html.'<tr>
                <td bgcolor="#CCCCCC">KM INICIAL</td>
                <td border="0" style="border: 1 solid #000000">'.$datos['km_inicial'].'</td>
                <td  bgcolor="#CCCCCC">KM FINAL </td>
                <td border="0" style="border: 1 solid #000000">'.$datos['km_final'].'</td>
              </tr>
            </table>
            <table width="760" border="0" style="border: 1 solid #000000">
                    <tr>
                      <td width="360" height="119" align="center" valign="bottom">Solicitante </td>
                      <td width="388" align="center" valign="bottom">Sub Gerencia de abastecimiento </td>
                    </tr>
                  </table>
            </body>
            </html>

        ';
        return $html;
    }
    
    function ImprimirPapeletaNacional($datos){
        $html='

        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Documento sin título</title>
        </head>

        <body>
        <table width="760" height="560" style="border: 1 solid #000000" border="0">
          <tr>
            <td height="554"><table width="760">
              <tr>
                <td width="113" height="135">&nbsp;</td>
                <td width="259" align="center"><h3>GOBIERNO REGIONAL DE AMAZONAS</h3>JR. ORTIZ ARRIETA Nº 1250          CHACHAPOYAS - AMAZONAS - PERÙ          TELEF. 041-478131</td>
                <td width="363"><table width="363" border="0" style="border: 1 solid #000000">
                  <tr>
                    <td width="92" align="right">VALE:</td>
                    <td width="240" border="0" style="border: 1 solid #000000">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right">Nº GALONES:</td>
                    <td border="0" style="border: 1 solid #000000">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right">GASOLINA:</td>
                    <td border="0" style="border: 1 solid #000000">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right">PETROLEO:</td>
                    <td border="0" style="border: 1 solid #000000">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table>
              <table width="760" border="0" style="border: 1 solid #000000">
                <tr>
                  <td width="529" align="center">PAPELETA DE SALIDA DE VEHICULOS </td>
                  <td width="27">Nº</td>
                  <td width="182" border="0" style="border: 1 solid #000000">'.$datos['num_papeleta'].'</td>
                </tr>
              </table>
              <table width="760" >
                <tr></tr>
                <tr>
                  <td colspan="2" align="center" border="0" style="border: 1 solid #000000" bgcolor="#999999">Solicitud de Vahiculo</td>
                  <td colspan="5" align="center" border="0" style="border: 1 solid #000000" bgcolor="#999999">Control</td>
                </tr>
                <tr>
                  <td width="157" bgcolor="#CCCCCC">1.- Solicitante</td>
                  <td width="200" border="0" style="border: 1 solid #000000">'.$datos['funcionario'].'</td>
                  <td width="116" bgcolor="#CCCCCC">Vehiculo / Placa</td>
                  <td colspan="4" border="0" style="border: 1 solid #000000">'.$datos['unidad'].'</td>
                </tr>
                <tr>
                  <td bgcolor="#CCCCCC">2. Unidad Operativa </td>
                  <td border="0" style="border: 1 solid #000000">'.$datos['oficina'].'</td>
                  <td bgcolor="#CCCCCC">Conductor</td>
                  <td colspan="4" border="0" style="border: 1 solid #000000">'.$datos['conductor'].'</td>
                </tr>
                <tr>
                  <td bgcolor="#CCCCCC">3.- Solicitud del Vahiculo </td>
                  <td border="0" style="border: 1 solid #000000">'.$datos['solicitud'].'</td>
                  <td bgcolor="#CCCCCC">Km. Inicial </td>
                  <td width="66" border="0" style="border: 1 solid #000000">'.$datos['km_inicial'].'</td>
                  <td width="66">Km. Final </td>
                  <td width="88" colspan="2" border="0" style="border: 1 solid #000000">'.$datos['km_final'].'</td>
                </tr>
                <tr>
                  <td rowspan="2" valign="top" bgcolor="#CCCCCC">4.- Motivo</td>
                  <td rowspan="2" border="0" style="border: 1 solid #000000">'.$datos['motivo'].'</td>
                  <td bgcolor="#CCCCCC">Total Recorrido</td>
                  <td colspan="4" border="0" style="border: 1 solid #000000">'.$datos['total_recorrido'].'</td>
                </tr>
                <tr>
                  <td bgcolor="#CCCCCC" >Hora de Retorno</td>
                  <td colspan="4" border="0" style="border: 1 solid #000000">'.$datos['hora_retorno'].'</td>
                </tr>
              </table>
              <table width="760" >
                <tr>
                  <td width="368">&nbsp;</td>
                  <td width="117" bgcolor="#CCCCCC">Chachapoyas </td>
                  <td width="59" border="0" style="border: 1 solid #000000">'.$datos['dia_retorno'].'</td>
                  <td width="27" bgcolor="#CCCCCC">De </td>
                  <td width="82" border="0" style="border: 1 solid #000000">'.$datos['mes_retorno'].'</td>
                  <td width="44" bgcolor="#CCCCCC">Del</td>
                  <td width="31" border="0" style="border: 1 solid #000000">'.$datos['anio_retorno'].'</td>
                </tr>
              </table>
              <table width="761" >
                <tr>
                  <td colspan="2">&nbsp;</td>
                  <td width="134" rowspan="2" valign="top" bgcolor="#CCCCCC">Servidores</td>
                  <td width="247" rowspan="2" border="0" style="border: 1 solid #000000">'.$datos['integrantes'].'</td>
                </tr>
                <tr>
                  <td width="124" bgcolor="#CCCCCC">Hora de Salida</td>
                  <td width="236" border="0" style="border: 1 solid #000000">'.$datos['hora_salida'].'</td>
                </tr>
              </table>
              <table width="760" border="0" style="border: 1 solid #000000">
                <tr>
                  <td width="90" bgcolor="#CCCCCC">Chachapoyas </td>
                  <td width="60" border="0" style="border: 1 solid #000000">'.$datos['dia_salida'].'</td>
                  <td width="30" bgcolor="#CCCCCC">De</td>
                  <td width="88" border="0" style="border: 1 solid #000000">'.$datos['mes_salida'].'</td>
                  <td width="43" bgcolor="#CCCCCC">Del</td>
                  <td width="30" border="0" style="border: 1 solid #000000">'.$datos['anio_salida'].'</td>
                  <td width="382">&nbsp;</td>
                </tr>
              </table>
              <table width="760" style="font-size:11px;">
                <tr>
                  <td height="119" align="center" valign="bottom" style="border-bottom:1px solid #000"></td>
                  <td align="center" valign="bottom" style="border-bottom:1px solid #000"></td>
                  <td align="center" valign="bottom" style="border-bottom:1px solid #000"></td>
                  <td align="center" valign="bottom" style="border-bottom:1px solid #000"></td>
                </tr>
                <tr>
                  <td height="0" align="center" valign="bottom">Gerente General Regional </td>
                  <td align="center" valign="bottom">Director Regional de Administracion </td>
                  <td align="center" valign="bottom">Director Oficina Abastecimiento y Pat.</td>
                  <td align="center" valign="bottom">Conductor</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        </body>
        </html>

        ';
        return $html;
    }
?>
