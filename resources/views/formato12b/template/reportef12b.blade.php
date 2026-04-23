<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <table>
        <style>
            table {
            border-collapse: collapse;
            }
            table, th, td {
            border: 0.5pt solid #000;
            font-size: 10pt;
            vertical-align: middle;
            }

            .header {
            border-top: 1pt solid #000;
            border-bottom: 1pt solid #000;
            font-size: 11pt;
            background-color: #0070C0;
            color: white;
            font-weight: bold;
            text-align: center;
            }

            .center {
            text-align: center;
            vertical-align: middle;
            }

            .left {
            text-align: left;
            vertical-align: middle;
            }

            .right {
            text-align: right;
            vertical-align: middle;
            }

            .subtotal {
                background-color: #f1e31a;  
                font-size: 13pt;
                font-weight: bold;
            }

            .total_text {
                background-color: #f1e31a;  
                font-size: 13pt;
                font-weight: bold;
                text-align: center;
            }

            .total_num {
                background-color: #f1e31a;  
                font-size: 12pt;
                font-weight: bold;
                text-align: center;
            }

        </style>
        @php
            $year= date("Y");
        @endphp
        <thead>
            <tr height="40">
                <td colspan="38" style="font-size:28px;font-weight:bold;text-align:center;">REPORTE DE LOS PROYECTOS CON FORMATO N° 12-B ACTUALIZADO AL ({{$fecha->fecha}})</td>
            </tr>
            <tr>
                <td colspan="38"></td>
            </tr>
            <tr id="header">
                <td class="header" width="100">CODIGO UNICO</td>
                <td class="header" width="450">NOMBRE PIP</td>
                <td class="header" width="100">UEI</td>
                <td class="header" width="110">DESC. FUNCION</td>
                <td class="header" width="110">COSTO TOTAL DE INVERSIÓN (D)</td>
                <td class="header" width="110">DEVENGADO ACUMULADO {{$year - 1}}</td>
                <td class="header" width="110">PIM {{$year}}</td>
                <td class="header" width="110">CERTIF {{$year}}</td>
                <td class="header" width="110">COMP. ANUAL {{$year}}</td>
                <td class="header" width="110">DEVENGADO {{$year}}</td>
                <td class="header" width="110">DEVENGADO ACUMULADO {{$year}} (E)</td>
                <td class="header" width="110">AVANCE FINANCIERO (E/D)</td>
                <td class="header" width="110">TIENE REGISTRO DEL FORMATO 12-B</td>
                <td class="header" width="110">ACTUALIZA F12B EN EL MES</td>
                <td class="header" width="110">FEC. ULT. ACT. F12B</td>
                <td class="header" width="110">REGISTRA SITUACIÓN GENERAL</td>
                <td class="header" width="110">ACTUALIZA SITUACIÓN GENERAL EN EL MES</td>
                <td class="header" width="110">FECHA DE ULTIMA SITUACIÓN GENERAL</td>
                <td class="header" width="400">DESCRIPCIÓN DE LA SITUACION GENERAL</td>
                <td class="header" width="110">FACTIBLE DE REGISTRO DEL AVANCE DE EJECUCIÓN</td>
                <td class="header" width="110">REGISTRA AVANCE DE EJECUCIÓN</td>
                <td class="header" width="110">AVANCE_EJECUCION_INVERSION</td>
                <td class="header" width="110">AVANCE_FISICO</td>
                <td class="header" width="110">ACTUALIZA AVANCE DE EJECUCIÓN DE INVERSIÓN EN EL MES</td>
                <td class="header" width="110">FECHA DE ULTIMA DECLARACIÓN DEL AVANCE DE EJECUCIÓN DE INVERSIÓN</td>
                <td class="header" width="110">¿EXISTE DIFERENCIA MAYOR AL 60% ENTRE EL AVANCE FINANCIERO ACUMULADO Y EL AVANCE DE EJECUCIÓN DE LA INVERSIÓN?</td>
                <td class="header" width="110">DIFERENCIA ENTRE EL AVANCE FINANCIERO ACUMULADO Y EL AVANCE DE LA EJECUCIÓN DE LA INVERSIÓN</td>
                <td class="header" width="110">ESTADO</td>
                <td class="header" width="110">SITUACION</td>
                <td class="header" width="110">REGISTRO ET</td>
                <td class="header" width="110">REGISTRADO EN EL PMI</td>
                <td class="header" width="110">PMI_{{$year}}</td>
                <td class="header" width="110">PMI_{{$year + 1}}</td>
                <td class="header" width="110">PMI_{{$year + 2}}</td>
                <td class="header" width="110">PMI_{{$year + 3}}</td>
                <td class="header" width="110">PROGRAM ACTUAL 2022</td>
                <td class="header" width="110">FEC. INI EJEC.</td>
                <td class="header" width="110">FEC. FIN EJEC.</td>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr style="white-space: nowrap;">
                <td>{{$row->cod_unif}}</td>
                <td>{{$row->nom_proyec}}</td>
                <td>{{$row->ger_direc}}</td>
                <td>{{$row->funcion}}</td>
                <td>{{ number_format($row->m_pip,2)}}</td>
                <td>{{ number_format($row->dev_acu_ant,2)}}</td>
                <td>{{ number_format($row->pim_dia,2)}}</td>
                <td>{{ number_format($row->certificacion_dia,2)}}</td>
                <td>{{ number_format($row->comp_anual_dia,2)}}</td>
                <td>{{ number_format($row->dev_dia,2)}}</td>
                <td>{{ number_format($row->m_deveng_a,2)}}</td>
                <td>{{ number_format($row->a_financ_a,2)}}</td>
                <td>{{$row->registro_f12b}}</td>
                <td>{{$row->actualizacion_f12b}}</td>
                <td>{{$row->fecha_actual}}</td>
                <td>{{$row->reg_situacion}}</td>
                <td>{{$row->act_situacion}}</td>
                <td>{{$row->fecha_actual_situacion}}</td>
                <td >{{$row->desc_situacion}}</td>
                <td>{{$row->factible_reg}}</td>
                <td>{{$row->reg_ava_eje}}</td>
                <td>{{$row->avance_ejecucion}}</td>
                <td>{{$row->avance_fisico}}</td>
                <td>{{$row->act_ava_ejec}}</td>
                <td>{{$row->fec_declara_estim}}</td>
                <td>{{$row->dif_a_fin_a_afis}}</td>
                <td>{{$row->dif_a_fin_a_afis_pro}}</td>
                <td>{{$row->estado}}</td>
                <td>{{$row->est_pry}}</td>
                <td>{{$row->resgistro_et}}</td>
                <td>{{$row->reg_pmi}}</td>
                <td>{{ number_format($row->monto_1,2)}}</td>
                <td>{{ number_format($row->monto_2,2)}}</td>
                <td>{{ number_format($row->monto_3,2)}}</td>
                <td>{{ number_format($row->monto_4,2)}}</td>
                <td>{{ number_format($row->total_actualizado,2)}}</td>
                <td>{{$row->fec_ini_ejec}}</td>
                <td>{{$row->fec_fin_ejec}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</html>
