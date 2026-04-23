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
                background-color: #D9E1F2;
                font-weight: bold;
                text-align: center;
            }

            .header_form {
                border-top: 1pt solid #000;
                border-bottom: 1pt solid #000;
                font-size: 11pt;
                background-color: #E2EFDA;
                font-weight: bold;
                text-align: center;
            }

            .celd{
                font-weight: bold;
                text-align: center;
            }

            .celd_num{
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

            .subtotal_ger {
                background-color: #DDEBF7;  
                font-size: 13pt;
                font-weight: bold;
            }

            .total {
                background-color: #f1e31a;  
                font-size: 14pt;
                font-weight: bold;
                text-align: right;
            }

            .total_text {
                background-color: #f1e31a;  
                font-size: 13pt;
                font-weight: bold;
                text-align: center;
            }

            .total_num {
                background-color: #f1e31a;  
                font-size: 14pt;
                font-weight: bold;
                text-align: center;
            }

        </style>
        @php
            $year = date("Y");
            $mes =  date("M");
            $mes_nombre="";
            $meta_certificado= 238081559;
            $meta_devengado= $data->m_abril;
            $meta_mes = 0;
            $lunes = 0;
            $martes = 0;
            $miercoles = 0;
            $jueves = 0;
            $viernes = 0;
            $total_semana = 0;
            $dev_mes_acum = 0;
            //Variables por Gerencias
            $t_1_meta_mes = 0;
            $t_1_devengado_mes = 0;
            $t_1_certificado_mes = 0;
            $total_pen_dev_acu_2 = 0;
            $t_1_cantidad = 0;
            $cod_unif = 0;
            $meta_mes_2 = 0;
            $dev_mes_2 = 0;
            $certificado_mes_2 = 0;
            $pen_dev_acu_2 = 0;
            $total_meta = 0;

            if($mes == 1){
                $mes_nombre = "ENERO";
            }elseif($mes == 2){
                $mes_nombre = "FEBRERO";
            }elseif($mes == 3){
                $mes_nombre = "MARZO";
            }elseif($mes == 4){
                $mes_nombre = "ABRIL";
            }elseif($mes == 5){
                $mes_nombre = "MAYO";
            }elseif($mes == 6){
                $mes_nombre = "JUNIO";
            }elseif($mes == 7){
                $mes_nombre = "JULIO";
            }elseif($mes == 8){
                $mes_nombre = "AGOSTO";
            }elseif($mes == 9){
                $mes_nombre = "SEPTIEMBRE";
            }elseif($mes == 10){
                $mes_nombre = "OCTUBRE";
            }elseif($mes == 11){
                $mes_nombre = "NOVIEMBRE";
            }elseif($mes == 12){ 
                $mes_nombre = "DICIEMBRE";
            }

            foreach($data_metas as $key => $row ){
                if($mes == 1){
                    $t_1_meta_mes += $row->m_enero;
                    $t_1_cantidad += $row->cant_enero;
                    $t_1_devengado_mes+= $row->enero;
                    $t_1_certificado_mes+= $row->enero_certificado;
                }elseif($mes == 2){
                    $t_1_meta_mes += $row->m_febrero;
                    $t_1_cantidad += $row->cant_febrero;
                    $t_1_devengado_mes+= $row->febrero;
                    $t_1_certificado_mes+= $row->febrero_certificado;
                }elseif($mes == 3){
                    $t_1_meta_mes += $row->m_marzo;
                    $t_1_cantidad += $row->cant_marzo;
                    $t_1_devengado_mes+= $row->marzo;
                    $t_1_certificado_mes+= $row->marzo_certificado;
                }elseif($mes == 4){
                    $t_1_meta_mes += $row->m_abril;
                    $t_1_cantidad += $row->cant_abril;
                    $t_1_devengado_mes+= $row->abril;
                    $t_1_certificado_mes+= $row->abril_certificado;
                }elseif($mes == 5){
                    $t_1_meta_mes += $row->m_mayo;
                    $t_1_cantidad += $row->cant_mayo;
                    $t_1_devengado_mes+= $row->mayo;
                    $t_1_certificado_mes+= $row->mayo_certificado;
                }elseif($mes == 6){
                    $t_1_meta_mes += $row->m_junio;
                    $t_1_cantidad += $row->cant_junio;
                    $t_1_devengado_mes+= $row->junio;
                    $t_1_certificado_mes+= $row->junio_certificado;
                }elseif($mes == 7){
                    $t_1_meta_mes += $row->m_julio;
                    $t_1_cantidad += $row->cant_julio;
                    $t_1_devengado_mes+= $row->julio;
                    $t_1_certificado_mes+= $row->julio_certificado;
                }elseif($mes == 8){
                    $t_1_meta_mes += $row->m_agosto;
                    $t_1_cantidad += $row->cant_agosto;
                    $t_1_devengado_mes+= $row->agosto;
                    $t_1_certificado_mes+= $row->agosto_certificado;
                }elseif($mes == 9){
                    $t_1_meta_mes += $row->m_setiembre;
                    $t_1_cantidad += $row->cant_setiembre;
                    $t_1_devengado_mes+= $row->septiembre;
                    $t_1_certificado_mes+= $row->septiembre_certificado;
                }elseif($mes == 10){
                    $t_1_meta_mes += $row->m_octubre;
                    $t_1_cantidad += $row->cant_octubre;
                    $t_1_devengado_mes+= $row->octubre;
                    $t_1_certificado_mes+= $row->octubre_certificado;
                }elseif($mes == 11){
                    $t_1_meta_mes += $row->m_noviembre;
                    $t_1_cantidad += $row->cant_noviembre;
                    $t_1_devengado_mes+= $row->noviembre;
                    $t_1_certificado_mes+= $row->noviembre_certificado;
                }elseif($mes == 12){ 
                    $t_1_meta_mes += $row->m_diciembre;
                    $t_1_cantidad += $row->cant_diciembre;
                    $t_1_devengado_mes+= $row->diciembre;
                    $t_1_certificado_mes+= $row->diciembre_certificado;
                }
            }

            $uei = [
                'ESTUDIOS DE PRE-INVERSION',
                'GERENCIA REGIONAL DE INFRAESTRUCTURA',
                'DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES',
                'GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE',
                'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                'GERENCIA REGIONAL DE DESARROLLO SOCIAL',
                'DIRECCION REGIONAL DE AGRICULTURA',
                'GERENCIA SUB REGIONAL LIMA SUR',
                'SIN UEI'
            ];

            $t_cantidad = 0;
            $t_programacion = 0;
            $t_ejecucion = 0;
            $t_mes_acumalativo = 0;
            $t_lunes = 0;
            $t_martes = 0;
            $t_miercoles = 0;
            $t_jueves = 0;
            $t_viernes = 0;
            $t_semana_total = 0;

            $meta_f12b = 0;
            foreach($mefvs_formato12b->where('info','FORMATO 12-B') as $key => $row ){
                if($mes == 1){
                    $meta_f12b = $row->a_enero;
                }elseif($mes == 2){
                    $meta_f12b = $row->a_febrero;
                }elseif($mes == 3){
                    $meta_f12b = $row->a_marzo;
                }elseif($mes == 4){
                    $meta_f12b = $row->a_abril;
                }elseif($mes == 5){
                    $meta_f12b = $row->a_mayo;
                }elseif($mes == 6){
                    $meta_f12b = $row->a_junio;
                }elseif($mes == 7){
                    $meta_f12b = $row->a_julio;
                }elseif($mes == 8){
                    $meta_f12b = $row->a_agosto;
                }elseif($mes == 9){
                    $meta_f12b = $row->a_setiembre;
                }elseif($mes == 10){
                    $meta_f12b = $row->a_octubre;
                }elseif($mes == 11){
                    $meta_f12b = $row->a_noviembre;
                }elseif($mes == 12){ 
                    $meta_f12b = $row->a_diciembre;
                }
            }

        @endphp
        
        <tr>
            <td style="border: none;" colspan='15'></td>
        </tr>
        <tr>
            <td style="border: none;width:67px"></td>
            <td style="border: none;width:142px"></td>
            <td style="border: none;width:245px"></td>
            <td style="border: none;width:259px"></td>
            <td style="border: none;width:202px"></td>
            <td style="border: none;width:211px"></td>
            <td style="border: none;width:256px"></td>
            <td style="border: none;width:256px"></td>
            <td style="border: none;width:225px"></td>
            <td style="border: none;width:245px"></td>
            <td style="border: none;width:245px"></td>
            <td style="border: none;width:245px"></td>
            <td style="border: none;width:255px"></td>
            <td style="border: none;width:184px"></td>
            <td style="border: none;width:365px"></td>
        </tr>
        <tr>
            <td rowspan="2" colspan="2" style="border: none;text-align:center"><img src="{{ asset('logo_opmi.png') }}"></td>
            <td colspan="2" class="celd" style="font-size: 26pt;background-color:#A9D08E;">ACTUALIZADO AL</td>
            <td rowspan="2" style="border: none;"></td>
            <td rowspan="2" style="border: none;"></td>
            <td rowspan="2" colspan="9" class="celd" style="border: none;font-size: 72pt;text-align:left">SEGUIMIENTO DE INVERSIONES {{$year}}</td>
        </tr>
        <tr>
            <td colspan="2" class="celd" style="font-size: 48pt;background-color:#A9D08E;">{{$fecha->fecha}}</td>
        </tr>
        <tr>
            <td colspan="15" style="border: none"></td>
        </tr>
        <tr>
            <td colspan="15" class="celd" style="font-size: 48pt;background-color:#A9D08E;">RESUMEN GORE LIMA</td>
        </tr>
        <tr>
            <td colspan="15" style="border: none"></td>
        </tr>
        <!-- CUADRO N° 1 -->
        <tr>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td class="celd" style="font-size: 24pt;background-color:#A9D08E;">N°</td>
            <td class="celd" colspan="4" style="font-size: 24pt;background-color:#A9D08E;">UNIDADES EJECUTORAS</td>
            <td class="celd" style="font-size: 24pt;background-color:#A9D08E;">PIM</td>
            <td class="celd" style="font-size: 24pt;background-color:#A9D08E;">DEVENGADO</td>
            <td class="celd" style="font-size: 24pt;background-color:#A9D08E;">PENDIENTE DEVENGADO</td>
            <td class="celd" style="font-size: 24pt;background-color:#A9D08E;">DEVENGADO AVANCE(%)</td>
            <td class="celd" style="font-size: 24pt;background-color:#A9D08E;">CERTIFICADO</td>
            <td class="celd" style="font-size: 24pt;background-color:#A9D08E;">AVANCE CERTIFICADO(%)</td>
            <td style="border: none"></td>
            <td class="celd" style="font-size: 24pt;background-color:#A9D08E;">PIM</td>
        </tr>
        @foreach($resumen_pliego as $key => $row )
            <tr>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td class="celd" style="font-size: 24pt;">{{ $row->cantidad }}</td>
                <td class="celd" colspan="4" style="font-size: 24pt;text-align:left;">{{$row->ger_direc }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($row->pim,0) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($row->dev_dia,0) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($row->pim - $row->dev_dia,0) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($row->avance,2) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($row->certificado,0) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($row->avance_certificado,2) }}</td>
                <td style="border: none"></td>
                @if($key == 0)
                    <td class="celd" style="font-size: 28pt;">{{ number_format($resumen_pliego_total->pim,0) }}</td>
                @elseif($key == 1)
                    <td style="border: none"></td>
                @elseif($key == 2)
                    <td class="celd"style="font-size: 24pt;background-color:#A9D08E;">DEVENGADO ACTUAL</td>
                @elseif($key == 3)
                    <td class="celd" style="font-size: 28pt;">{{ number_format($resumen_pliego_total->dev_dia,0) }}</td>
                @elseif($key == 4)
                    <td style="border: none"></td>
                @elseif($key == 5)
                    <td class="celd"style="font-size: 24pt;background-color:#A9D08E;">DEVENGADO AVANCE(%)</td>
                @elseif($key == 6)
                    <td class="celd" style="font-size: 28pt;">{{ number_format($resumen_pliego_total->avance,2) }}</td>
                @else
                    <td style="border: none"></td>
                @endif
            </tr>
        @endforeach
        <tr>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td class="celd" style="font-size: 26pt;background-color:#A9D08E;">{{ $resumen_pliego_total->total_pry }}</td>
            <td class="celd" colspan="4" style="font-size: 28pt;background-color:#A9D08E;">TOTAL</td>
            <td class="celd" style="font-size: 26pt;background-color:#A9D08E;">{{ number_format($resumen_pliego_total->pim,0) }}</td>
            <td class="celd" style="font-size: 26pt;background-color:#A9D08E;">{{ number_format($resumen_pliego_total->dev_dia,0) }}</td>
            <td class="celd" style="font-size: 26pt;background-color:#A9D08E;">{{ number_format($resumen_pliego_total->pim - $resumen_pliego_total->dev_dia,0) }}</td>
            <td class="celd" style="font-size: 26pt;background-color:#A9D08E;">{{ number_format($resumen_pliego_total->avance,2) }}</td>
            <td class="celd" style="font-size: 26pt;background-color:#A9D08E;">{{ number_format($resumen_pliego_total->certificado,0) }}</td>
            <td class="celd" style="font-size: 26pt;background-color:#A9D08E;">{{ number_format($resumen_pliego_total->avance_certificado,0) }}</td>
            <td style="border: none"></td>
            <td class="celd" style="font-size: 24pt;background-color:#A9D08E;">PENDIENTE DEVENGADO A 31 DICIEMBRE</td>
        </tr>
        <tr>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td class="celd" style="font-size: 28pt;">{{ number_format($resumen_pliego_total->pim - $resumen_pliego_total->dev_dia,2) }}</td>
        </tr>
        <tr>
            <td colspan="15" style="border: none"></td>
        </tr>
        <tr>
            <td colspan="15" class="celd" style="font-size: 48pt;background-color:#A9D08E;">RESUMEN DE EJECUCION POR UNIDAD EJECUTORA AL MES DE {{ $mes_nombre}} - MEF</td>
        </tr>
        <tr>
            <td colspan="15" style="border: none"></td>
        </tr>
        <!-- CUADRO N° 2 -->
        <tr>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td class="celd" style="font-size: 24pt;background-color:#A9D08E;">N°</td>
            <td class="celd" colspan="3" style="font-size: 24pt;background-color:#A9D08E;">UNIDADES EJECUTORAS</td>
            <td class="celd" style="font-size: 24pt;background-color:#A9D08E;">PROGRAMACION</td>
            <td class="celd" style="font-size: 24pt;background-color:#A9D08E;">EJECUCION</td>
            <td class="celd" style="font-size: 24pt;background-color:#A9D08E;">PENDIENTE DEVENGADO</td>
            <!-- <td class="celd" style="font-size: 24pt;background-color:#A9D08E;">PENDIENTE DEVENGADO ACUMULADO</td> -->
            <td class="celd" style="font-size: 24pt;background-color:#A9D08E;">DEVENGADO AVANCE(%)</td>
            <td class="celd" style="font-size: 24pt;background-color:#A9D08E;">CERTIFICADO</td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td class="celd" style="font-size: 24pt;background-color:#A9D08E;">PROGRAMACION {{ $mes_nombre}} - MEF</td>
        </tr>
        @foreach($data_metas as $key => $row )
            @php
                $meta_mes_2 = 0;
                $dev_mes_2  = 0;
                $pen_dev_acu_2 = 0;
                $cantidad = 0;
                $certificado_mes_2 = 0;
                if($mes == 1){
                    $meta_mes_2 = $row->m_enero;
                    $dev_mes_2 = $row->enero;
                    $certificado_mes_2 = $row->enero_certificado;
                    $pen_dev_acu_2 = 0;
                }elseif($mes == 2){
                    $meta_mes_2 = $row->m_febrero;
                    $cantidad = $row->cant_febrero;
                    $dev_mes_2 = $row->febrero;
                    $certificado_mes_2 = $row->febrero_certificado;
                    $pen_dev_acu_2 = $row->pen_enero;
                }elseif($mes == 3){
                    $meta_mes_2 = $row->m_marzo;
                    $cantidad = $row->cant_marzo;
                    $dev_mes_2 = $row->marzo;
                    $certificado_mes_2 = $row->marzo_certificado;
                    $pen_dev_acu_2 = $row->pen_enero + $row->pen_febrero;
                }elseif($mes == 4){
                    $meta_mes_2 = $row->m_abril;
                    $cantidad = $row->cant_abril;
                    $dev_mes_2 = $row->abril;
                    $certificado_mes_2 = $row->abril_certificado;
                    $pen_dev_acu_2 = $row->pen_enero + $row->pen_febrero + $row->pen_marzo;
                }elseif($mes == 5){
                    $meta_mes_2 = $row->m_mayo;
                    $cantidad = $row->cant_mayo;
                    $dev_mes_2 = $row->mayo;
                    $certificado_mes_2 = $row->mayo_certificado;
                    $pen_dev_acu_2 = $row->pen_enero + $row->pen_febrero + $row->pen_marzo + $row->pen_abril;
                }elseif($mes == 6){
                    $meta_mes_2 = $row->m_junio;
                    $cantidad = $row->cant_junio;
                    $dev_mes_2 = $row->junio;
                    $certificado_mes_2 = $row->junio_certificado;
                    $pen_dev_acu_2 = $row->pen_enero + $row->pen_febrero + $row->pen_marzo + $row->pen_abril + $row->pen_mayo;
                }elseif($mes == 7){
                    $meta_mes_2 = $row->m_julio;
                    $cantidad = $row->cant_julio;
                    $dev_mes_2 = $row->julio;
                    $certificado_mes_2 = $row->julio_certificado;
                    $pen_dev_acu_2 = $row->pen_enero + $row->pen_febrero + $row->pen_marzo + $row->pen_abril + $row->pen_mayo + $row->pen_junio;
                }elseif($mes == 8){
                    $meta_mes_2 = $row->m_agosto;
                    $cantidad = $row->cant_agosto;
                    $dev_mes_2 = $row->agosto;
                    $certificado_mes_2 = $row->agosto_certificado;
                    $pen_dev_acu_2 = $row->pen_enero + $row->pen_febrero + $row->pen_marzo + $row->pen_abril + $row->pen_mayo + $row->pen_junio + $row->pen_julio;
                }elseif($mes == 9){
                    $meta_mes_2 = $row->m_setiembre;
                    $cantidad = $row->cant_setiembre;
                    $dev_mes_2 = $row->septiembre;
                    $certificado_mes_2 = $row->septiembre_certificado;
                    $pen_dev_acu_2 = $row->pen_enero + $row->pen_febrero + $row->pen_marzo + $row->pen_abril + $row->pen_mayo + $row->pen_junio + $row->pen_julio  + $row->pen_agosto;
                }elseif($mes == 10){
                    $meta_mes_2 = $row->m_octubre;
                    $cantidad = $row->cant_octubre;
                    $dev_mes_2 = $row->octubre;
                    $certificado_mes_2 = $row->octubre_certificado;
                    $pen_dev_acu_2 = $row->pen_enero + $row->pen_febrero + $row->pen_marzo + $row->pen_abril + $row->pen_mayo + $row->pen_junio + $row->pen_julio  + $row->pen_agosto  + $row->pen_setiembre;
                }elseif($mes == 11){
                    $meta_mes_2 = $row->m_noviembre;
                    $cantidad = $row->cant_noviembre;
                    $dev_mes_2 = $row->noviembre;
                    $certificado_mes_2 = $row->noviembre_certificado;
                    $pen_dev_acu_2 = $row->pen_enero + $row->pen_febrero + $row->pen_marzo + $row->pen_abril + $row->pen_mayo + $row->pen_junio + $row->pen_julio  + $row->pen_agosto  + $row->pen_setiembre  + $row->pen_octubre;
                }elseif($mes == 12){ 
                    $meta_mes_2 = $row->m_diciembre;
                    $cantidad = $row->cant_diciembre;
                    $dev_mes_2 = $row->diciembre;
                    $certificado_mes_2 = $row->diciembre_certificado;
                    $pen_dev_acu_2 = $row->pen_enero + $row->pen_febrero + $row->pen_marzo + $row->pen_abril + $row->pen_mayo + $row->pen_junio + $row->pen_julio  + $row->pen_agosto  + $row->pen_setiembre  + $row->pen_octubre  + $row->pen_noviembre;
                }
                $total_pen_dev_acu_2 += $pen_dev_acu_2;
            @endphp
            <tr>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td class="celd" style="font-size: 24pt;">{{ $cantidad }}</td>
                <td class="celd" colspan="3" style="font-size: 24pt;text-align:left;">{{$row->ger_direc }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($meta_mes_2,0) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($dev_mes_2,0) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($meta_mes_2 - $dev_mes_2,0) }}</td>
                <!-- <td class="celd" style="font-size: 24pt;">{{ number_format($pen_dev_acu_2,0) }}</td> -->
                @if($meta_mes_2 == 0)
                    <td class="celd" style="font-size: 24pt;">0.00</td>
                @else
                    <td class="celd" style="font-size: 24pt;">{{ number_format($dev_mes_2*100/$meta_mes_2,2) }}</td>
                @endif
                <td class="celd" style="font-size: 24pt;">{{ number_format($certificado_mes_2,0) }}</td>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none"></td>
                @if($key == 0)
                    <td class="celd" style="font-size: 28pt;">{{ number_format($t_1_meta_mes,0) }}</td>
                @elseif($key == 1)
                    <td style="border: none"></td>
                @elseif($key == 2)
                    <td class="celd"style="font-size: 24pt;background-color:#A9D08E;">EJECUCION {{ $mes_nombre}}</td>
                @elseif($key == 3)
                    <td class="celd" style="font-size: 28pt;">{{ number_format($t_1_devengado_mes,0) }}</td>
                @elseif($key == 4)
                    <td style="border: none"></td>
                @elseif($key == 5)
                    <td class="celd"style="font-size: 24pt;background-color:#A9D08E;">DEVENGADO AVANCE(%)</td>
                @elseif($key == 6)
                    @if($t_1_meta_mes != 0 )
                        <td class="celd" style="font-size: 28pt;">{{ number_format($t_1_devengado_mes*100/$t_1_meta_mes,2) }}</td>
                    @else
                        <td class="celd" style="font-size: 28pt;">0</td>
                    @endif
                @else
                    <td style="border: none"></td>
                @endif
            </tr>
        @endforeach
        <tr>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td class="celd" style="font-size: 26pt;background-color:#A9D08E;">{{ $t_1_cantidad }}</td>
            <td class="celd" style="font-size: 28pt;background-color:#A9D08E;" colspan="3">TOTAL</td>
            <td class="celd" style="font-size: 26pt;background-color:#A9D08E;">{{ number_format($t_1_meta_mes,0) }}</td>
            <td class="celd" style="font-size: 26pt;background-color:#A9D08E;">{{ number_format($t_1_devengado_mes,0) }}</td>
            <td class="celd" style="font-size: 26pt;background-color:#A9D08E;">{{ number_format($t_1_meta_mes - $t_1_devengado_mes,0) }}</td>
            <!-- <td class="celd" style="font-size: 26pt;background-color:#A9D08E;">{{ number_format($total_pen_dev_acu_2,0) }}</td> -->
            @if($t_1_meta_mes != 0 )
                <td class="celd" style="font-size: 26pt;background-color:#A9D08E;">{{ number_format($t_1_devengado_mes*100/$t_1_meta_mes,2) }}</td>
            @else
                <td class="celd" style="font-size: 26pt;background-color:#A9D08E;">0</td>
            @endif
            <td class="celd" style="font-size: 26pt;background-color:#A9D08E;">{{ number_format($t_1_certificado_mes,0) }}</td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td class="celd" style="font-size: 24pt;background-color:#A9D08E;">PENDIENTE DEVENGADO {{ $mes_nombre}} - MEF</td>
        </tr>
        <tr>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td class="celd"  style="font-size: 28pt;">{{ number_format($t_1_meta_mes - $t_1_devengado_mes,0) }}</td>
        </tr>
        <tr>
            <td colspan="13" style="border: none"></td>
        </tr>
        <tr>
            <td colspan="15" class="celd" style="font-size: 48pt;background-color:#A9D08E;">HISTORIAL DE DEVENGADOS</td>
        </tr>
        <tr>
            <td colspan="13" style="border: none"></td>
        </tr>
        <!-- CUADRO N° 3 -->
        <tr>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td rowspan="2" class="celd" style="font-size: 22pt;background-color:#D9D9D9;">ENERO</td>
            <td class="celd" style="font-size: 22pt;">DEVENGADO</td>
            <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual->enero,0)}}</td>
            <td style="border: none;"></td>
            <td rowspan="2" class="celd" style="font-size: 22pt;background-color:#D9D9D9;">FEBRERO</td>
            <td class="celd" style="font-size: 22pt;">DEVENGADO</td>
            <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual->febrero,0)}}</td>
            <td style="border: none;"></td>
            <td rowspan="2" class="celd" style="font-size: 22pt;background-color:#D9D9D9;">MARZO</td>
            <td class="celd" style="font-size: 22pt;">DEVENGADO</td>
            <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual->marzo,0)}}</td>
        </tr>
        <tr>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td class="celd" style="font-size: 22pt;">PROGRAMACION</td>
            <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual_meta->m_enero,0)}}</td>
            <td style="border: none;"></td>
            <td class="celd" style="font-size: 22pt;">PROGRAMACION</td>
            <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual_meta->m_febrero,0)}}</td>
            <td style="border: none;"></td>
            <td class="celd" style="font-size: 22pt;">PROGRAMACION</td>
            <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual_meta->m_marzo,0)}}</td>
        </tr>
        <tr>
            <td colspan="13" style="border: none"></td>
        </tr>
        <tr>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td rowspan="2" class="celd" style="font-size: 22pt;background-color:#D9D9D9;">ABRIL</td>
            <td class="celd" style="font-size: 22pt;">DEVENGADO</td>
            <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual->abril,0)}}</td>
            <td style="border: none;"></td>
            <td rowspan="2" class="celd" style="font-size: 22pt;background-color:#D9D9D9;">MAYO</td>
            <td class="celd" style="font-size: 22pt;">DEVENGADO</td>
            <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual->mayo,0)}}</td>
            <td style="border: none;"></td>
            <td rowspan="2" class="celd" style="font-size: 22pt;background-color:#D9D9D9;">JUNIO</td>
            <td class="celd" style="font-size: 22pt;">DEVENGADO</td>
            <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual->junio,0)}}</td>
        </tr>
        <tr>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td class="celd" style="font-size: 22pt;">PROGRAMACION</td>
            <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual_meta->m_abril,0)}}</td>
            <td style="border: none;"></td>
            <td class="celd" style="font-size: 22pt;">PROGRAMACION</td>
            <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual_meta->m_mayo,0)}}</td>
            <td style="border: none;"></td>
            <td class="celd" style="font-size: 22pt;">PROGRAMACION</td>
            <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual_meta->m_junio,0)}}</td>
        </tr>
        <tr>
            <td colspan="13" style="border: none"></td>
        </tr>
        @if($mes > 6)
            <tr>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td rowspan="2" class="celd" style="font-size: 16pt;background-color:#D9D9D9;">JULIO</td>
                <td class="celd" style="font-size: 22pt;">DEVENGADO</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual->julio,0)}}</td>
                <td style="border: none;"></td>
                <td rowspan="2" class="celd" style="font-size: 22pt;background-color:#D9D9D9;">AGOSTO</td>
                <td class="celd" style="font-size: 22pt;">DEVENGADO</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual->agosto,0)}}</td>
                <td style="border: none;"></td>
                <td rowspan="2" class="celd" style="font-size: 22pt;background-color:#D9D9D9;">SEPTIEMBRE</td>
                <td class="celd" style="font-size: 22pt;">DEVENGADO</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual->septiembre,0)}}</td>
            </tr>
            <tr>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td class="celd" style="font-size: 22pt;">PROGRAMACION</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual_meta->m_julio,0)}}</td>
                <td style="border: none;"></td>
                <td class="celd" style="font-size: 22pt;">PROGRAMACION</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual_meta->m_agosto,0)}}</td>
                <td style="border: none;"></td>
                <td class="celd" style="font-size: 22pt;">PROGRAMACION</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual_meta->m_setiembre,0)}}</td>
            </tr>
            <tr>
                <td colspan="13" style="border: none"></td>
            </tr>
            <tr>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td rowspan="2" class="celd" style="font-size: 22pt;background-color:#D9D9D9;">OCTUBRE</td>
                <td class="celd" style="font-size: 22pt;">DEVENGADO</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual->octubre,0)}}</td>
                <td style="border: none;"></td>
                <td rowspan="2" class="celd" style="font-size: 22pt;background-color:#D9D9D9;">NOVIEMBRE</td>
                <td class="celd" style="font-size: 22pt;">DEVENGADO</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual->noviembre,0)}}</td>
                <td style="border: none;"></td>
                <td rowspan="2" class="celd" style="font-size: 22pt;background-color:#D9D9D9;">DICIEMBRE</td>
                <td class="celd" style="font-size: 22pt;">DEVENGADO</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual->diciembre,0)}}</td>
            </tr>
            <tr>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td class="celd" style="font-size: 22pt;">PROGRAMACION</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual_meta->m_octubre,0)}}</td>
                <td style="border: none;"></td>
                <td class="celd" style="font-size: 22pt;">PROGRAMACION</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual_meta->m_noviembre,0)}}</td>
                <td style="border: none;"></td>
                <td class="celd" style="font-size: 22pt;">PROGRAMACION</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($historial_mensual_meta->m_diciembre,0)}}</td>
            </tr>
            <tr>
                <td colspan="13" style="border: none"></td>
            </tr>
        @endif
        <tr>
            <td colspan="15" class="celd" style="font-size: 48pt;background-color:#A9D08E;">PROGRAMACION MEF vs FORMATO 12-B</td>
        </tr>
        <tr>
            <td colspan="13" style="border: none"></td>
        </tr>
        <tr>
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td class="celd" style="font-size: 20pt;background-color:#BDD7EE;">ENERO</td>
            <td class="celd" style="font-size: 20pt;background-color:#BDD7EE;">FEBRERO</td>
            <td class="celd" style="font-size: 20pt;background-color:#BDD7EE;">MARZO</td>
            <td class="celd" style="font-size: 20pt;background-color:#BDD7EE;">ABRIL</td>
            <td class="celd" style="font-size: 20pt;background-color:#BDD7EE;">MAYO</td>
            <td class="celd" style="font-size: 20pt;background-color:#BDD7EE;">JUNIO</td>
            <td class="celd" style="font-size: 20pt;background-color:#BDD7EE;">JULIO</td>
            <td class="celd" style="font-size: 20pt;background-color:#BDD7EE;">AGOSTO</td>
            <td class="celd" style="font-size: 20pt;background-color:#BDD7EE;">SEPTIEMBRE</td>
            <td class="celd" style="font-size: 20pt;background-color:#BDD7EE;">OCTUBRE</td>
            <td class="celd" style="font-size: 20pt;background-color:#BDD7EE;">NOVIEMBRE</td>
            <td class="celd" style="font-size: 20pt;background-color:#BDD7EE;">DICIEMBRE</td>
            <td class="celd" style="font-size: 20pt;background-color:#BDD7EE;">TOTAL</td>
        </tr>
        @foreach($mefvs_formato12b as $row)
            @php
                $total_meta = $row->a_enero + $row->a_febrero + $row->a_marzo + $row->a_abril + $row->a_mayo + $row->a_junio + $row->a_julio + $row->a_agosto + $row->a_setiembre + $row->a_octubre + $row->a_noviembre + $row->a_diciembre;
            @endphp
            <tr>
                <td colspan="2" class="celd" style="font-size: 20pt;">{{ $row->info }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($row->a_enero,0) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($row->a_febrero,0) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($row->a_marzo,0) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($row->a_abril,0) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($row->a_mayo,0) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($row->a_junio,0) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($row->a_julio,0) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($row->a_agosto,0) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($row->a_setiembre,0) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($row->a_octubre,0) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($row->a_noviembre,0) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($row->a_diciembre,0) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($total_meta,0) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="13" style="border: none"></td>
        </tr>
        <tr>
            <td colspan="15" class="celd" style="font-size: 48pt;background-color:#A9D08E;">RESUMEN DE EJECUCION POR PROYECTO AL MES DE {{ $mes_nombre}}</td>
        </tr>
        <tr>
            <td colspan="13" style="border: none"></td>
        </tr>
        <!-- CUADRO N° 4 -->
        <tr>
            <td class="celd" rowspan="2" style="font-size: 20pt;background-color:#D3EBF7;">N°</td>
            <td class="celd" rowspan="2" style="font-size: 20pt;background-color:#D3EBF7;">CUI</td>
            <td class="celd" rowspan="2" colspan="3" style="font-size: 20pt;background-color:#D3EBF7;">PROYECTO</td>
            <td class="celd" colspan="3" style="font-size: 20pt;background-color:#D3EBF7;">EJECUCION REAL</td>
            <!-- <td class="celd" rowspan="2" style="font-size: 20pt;background-color:#D3EBF7;">DEVENGADO MES ACUMULADO {{$fecha_acu->fecha}}</td> -->
            <td class="celd" colspan="6" style="font-size: 20pt;background-color:#D3EBF7;">DEVENGADO AL {{$fecha->fecha}}</td>
        </tr>
        <tr>
            <td class="celd" style="font-size: 20pt;background-color:#D3EBF7;">PROGRAMACION</td>
            <td class="celd" style="font-size: 20pt;background-color:#D3EBF7;">EJECUCION</td>
            <td class="celd" style="font-size: 20pt;background-color:#D3EBF7;">AVANCE(%)</td>
            <td class="celd" style="font-size: 20pt;background-color:#D3EBF7;">LUN</td>
            <td class="celd" style="font-size: 20pt;background-color:#D3EBF7;">MAR</td>
            <td class="celd" style="font-size: 20pt;background-color:#D3EBF7;">MIE</td>
            <td class="celd" style="font-size: 20pt;background-color:#D3EBF7;">JUE</td>
            <td class="celd" style="font-size: 20pt;background-color:#D3EBF7;">VIE</td>
            <td class="celd" style="font-size: 20pt;background-color:#D3EBF7;">DEVENGADO SEMANAL</td>
        </tr>
        @foreach($uei as $item )
            @php
                $data_hoy_a = $data_hoy->where('ger_direc','=',$item);
                $data_hoy_meta = $data_hoy->where('ger_direc','=',$item)->where('meta_mes','!=',0);
                $data_hoy_adicional = $data_hoy->where('ger_direc','=',$item)->where('meta_mes','=',0);
                $i = 0;
                $total_pry_ger = 0;
                $total_semana_t = 0;
                $lunes_t = 0;
                $martes_t = 0;
                $miercoles_t = 0;
                $jueves_t = 0;
                $viernes_t = 0;
                $dev_mes_acum_t = 0;
                $programacion_t = 0;
                $ejecucion_t = 0;
            @endphp
            @if(count($data_hoy_a) > 0)
                @foreach($data_hoy_a as $key => $row )
                    @php
                        $cod_unif = $row->cod_unif;
                        $total_pry_ger = count($data_hoy_meta);
                        $total_semana_t = 0;
                        $programacion_t +=  $row->meta_mes;
                        $ejecucion_t += $row->dev_mes;
                        $lunes = $data_dia->where('cod_unif','=',$cod_unif)->where('dia','=','2')->first();
                        $martes = $data_dia->where('cod_unif','=',$cod_unif)->where('dia','=','3')->first();
                        $miercoles = $data_dia->where('cod_unif','=',$cod_unif)->where('dia','=','4')->first();
                        $jueves = $data_dia->where('cod_unif','=',$cod_unif)->where('dia','=','5')->first();
                        $viernes = $data_dia->where('cod_unif','=',$cod_unif)->where('dia','=','6')->first();
                        $dev_mes_acum = $data_dev_acum->where('cod_unif','=',$cod_unif)->first();
                        
                        $lunes_t += count($lunes) > 0 ? $lunes->dif_dev_dia : 0;
                        $martes_t += count($martes) > 0 ? $martes->dif_dev_dia : 0;
                        $miercoles_t += count($miercoles) > 0 ? $miercoles->dif_dev_dia : 0;
                        $jueves_t += count($jueves) > 0 ? $jueves->dif_dev_dia : 0;
                        $viernes_t += count($viernes) > 0 ? $viernes->dif_dev_dia : 0;
                        $dev_mes_acum_t += count($dev_mes_acum) > 0 ? $dev_mes_acum->dev_mes_acu : 0;
                        $total_semana_t +=  $lunes_t;
                        $total_semana_t +=  $martes_t;
                        $total_semana_t +=  $miercoles_t;
                        $total_semana_t +=  $jueves_t;
                        $total_semana_t +=  $viernes_t;
                    @endphp
                @endforeach
                @php
                    
                    $t_programacion += $programacion_t;
                    $t_ejecucion += $ejecucion_t;
                    $t_mes_acumalativo += $dev_mes_acum_t;
                    $t_lunes += $lunes_t;
                    $t_martes += $martes_t;
                    $t_miercoles += $miercoles_t;
                    $t_jueves += $jueves_t;
                    $t_viernes += $viernes_t;
                    $total_semana_t = $total_semana_t;
                    $t_semana_total += $total_semana_t;
                @endphp
                <tr>
                    <td class="celd" style="font-size: 18pt;background-color:#9BC2E6;">{{ $total_pry_ger }}</td>
                    <td colspan="4" class="celd" style="font-size: 16pt;background-color:#9BC2E6;">{{$item}}</td>
                    <td class="celd" style="font-size: 18pt;background-color:#9BC2E6;">{{ number_format($programacion_t,2) }}</td>
                    <td class="celd" style="font-size: 18pt;background-color:#9BC2E6;">{{ number_format($ejecucion_t,2) }}</td>
                    @if($programacion_t > 0)
                        <td class="celd" style="font-size: 18pt;background-color:#9BC2E6;">{{ number_format($ejecucion_t*100/$programacion_t,2) }}</td>
                    @else
                        <td class="celd" style="font-size: 18pt;background-color:#9BC2E6;">0.00</td>
                    @endif
                    <!-- <td class="celd" style="font-size: 18pt;background-color:#9BC2E6;">{{ number_format($dev_mes_acum_t,2) }}</td> -->
                    <td class="celd" style="font-size: 18pt;background-color:#9BC2E6;">{{ number_format($lunes_t,2) }}</td>
                    <td class="celd" style="font-size: 18pt;background-color:#9BC2E6;">{{ number_format($martes_t,2) }}</td>
                    <td class="celd" style="font-size: 18pt;background-color:#9BC2E6;">{{ number_format($miercoles_t,2) }}</td>
                    <td class="celd" style="font-size: 18pt;background-color:#9BC2E6;">{{ number_format($jueves_t,2) }}</td>
                    <td class="celd" style="font-size: 18pt;background-color:#9BC2E6;">{{ number_format($viernes_t,2) }}</td>
                    <td class="celd" style="font-size: 18pt;background-color:#9BC2E6;">{{ number_format($total_semana_t,2) }}</td>
                </tr>
                @foreach($data_hoy_meta as $key => $row )
                    @php
                        $i += 1;
                        $total_semana = 0;
                        $cod_unif = $row->cod_unif;
                        $meta_mes =  $row->meta_mes;
                        $lunes = $data_dia->where('cod_unif','=',$cod_unif)->where('dia','=','2')->first();
                        $martes = $data_dia->where('cod_unif','=',$cod_unif)->where('dia','=','3')->first();
                        $miercoles = $data_dia->where('cod_unif','=',$cod_unif)->where('dia','=','4')->first();
                        $jueves = $data_dia->where('cod_unif','=',$cod_unif)->where('dia','=','5')->first();
                        $viernes = $data_dia->where('cod_unif','=',$cod_unif)->where('dia','=','6')->first();
                        $dev_mes_acum = $data_dev_acum->where('cod_unif','=',$cod_unif)->first();
                    @endphp
                    <tr>
                        <td class="celd_num" style="font-size: 18pt;">{{ $i }}</td>
                        <td class="celd_num" style="font-size: 18pt;">{{ $cod_unif }}</td>
                        <td class="celd_num" colspan="3" style="text-align:left;font-size: 12pt;">{{$row->nom_proyec}}</td>
                        <td class="celd_num" style="font-size: 18pt;">{{ number_format($meta_mes,2) }}</td>
                        <td class="celd_num" style="font-size: 18pt;">{{ number_format($row->dev_mes,2) }}</td>
                        @if($meta_mes > 0)
                            <td class="celd_num" style="font-size: 18pt;">{{ number_format($row->dev_mes*100/$meta_mes,2) }}</td>
                        @else
                            <td class="celd_num" style="font-size: 18pt;">0.00</td>
                        @endif
                        <!-- @if(count($dev_mes_acum) > 0)
                            <td class="celd_num" style="font-size: 18pt;">{{ number_format($dev_mes_acum->dev_mes_acu,2) }}</td>
                        @else
                            <td class="celd_num" style="font-size: 18pt;">0</td>
                        @endif -->
                        @if(count($lunes) > 0)
                            <td class="celd_num" style="font-size: 18pt;">{{ number_format($lunes->dif_dev_dia,2) }}</td>
                            @php
                                $total_semana += $lunes->dif_dev_dia;
                            @endphp
                        @else
                            <td class="celd_num" style="font-size: 18pt;">0</td>
                        @endif
                        @if(count($martes) > 0)
                            <td class="celd_num" style="font-size: 18pt;">{{ number_format($martes->dif_dev_dia,2) }}</td>
                            @php
                                $total_semana += $martes->dif_dev_dia;
                            @endphp
                        @else
                            <td class="celd_num" style="font-size: 18pt;">0</td>
                        @endif
                        @if(count($miercoles) > 0)
                            <td class="celd_num" style="font-size: 18pt;">{{ number_format($miercoles->dif_dev_dia,2) }}</td>
                            @php
                                $total_semana += $miercoles->dif_dev_dia;
                            @endphp
                        @else
                            <td class="celd_num" style="font-size: 18pt;">0</td>
                        @endif
                        @if(count($jueves) > 0)
                            <td class="celd_num" style="font-size: 18pt;">{{ number_format($jueves->dif_dev_dia,2) }}</td>
                            @php
                                $total_semana += $jueves->dif_dev_dia;
                            @endphp
                        @else
                            <td class="celd_num" style="font-size: 18pt;">0</td>
                        @endif
                        @if(count($viernes) > 0)
                            <td class="celd_num" style="font-size: 18pt;">{{ number_format($viernes->dif_dev_dia,2) }}</td>
                            @php
                                $total_semana += $viernes->dif_dev_dia;
                            @endphp
                        @else
                            <td class="celd_num" style="font-size: 18pt;">0</td>
                        @endif
                        <td class="celd_num" style="font-size: 18pt;">{{ number_format($total_semana,2) }}</td>
                    </tr>
                @endforeach
            @endif
            @if(count($data_hoy_adicional) > 0)
                <tr>
                    <td class="celd" colspan='14' style="font-size: 18pt;background-color:#9BC2E6;">DEVENGADOS NO PROGRAMADOS</td>
                </tr>
                @foreach($data_hoy_adicional as $key => $row )
                    @php
                        
                        $total_semana = 0;
                        $cod_unif = $row->cod_unif;
                        $meta_mes =  $row->meta_mes;
                        $lunes = $data_dia->where('cod_unif','=',$cod_unif)->where('dia','=','2')->first();
                        $martes = $data_dia->where('cod_unif','=',$cod_unif)->where('dia','=','3')->first();
                        $miercoles = $data_dia->where('cod_unif','=',$cod_unif)->where('dia','=','4')->first();
                        $jueves = $data_dia->where('cod_unif','=',$cod_unif)->where('dia','=','5')->first();
                        $viernes = $data_dia->where('cod_unif','=',$cod_unif)->where('dia','=','6')->first();
                        $dev_mes_acum = $data_dev_acum->where('cod_unif','=',$cod_unif)->first();
                    @endphp
                    <tr>
                        <td class="celd_num" style="font-size: 18pt;"></td>
                        <td class="celd_num" style="font-size: 18pt;">{{ $cod_unif }}</td>
                        <td class="celd_num" colspan="3" style="text-align:left;font-size: 12pt;">{{$row->nom_proyec}}</td>
                        <td class="celd_num" style="font-size: 18pt;">{{ number_format($meta_mes,2) }}</td>
                        <td class="celd_num" style="font-size: 18pt;">{{ number_format($row->dev_mes,2) }}</td>
                        @if($meta_mes > 0)
                            <td class="celd_num" style="font-size: 18pt;">{{ number_format($row->dev_mes*100/$meta_mes,2) }}</td>
                        @else
                            <td class="celd_num" style="font-size: 18pt;">0.00</td>
                        @endif
                        <!-- @if(count($dev_mes_acum) > 0)
                            <td class="celd_num" style="font-size: 18pt;">{{ number_format($dev_mes_acum->dev_mes_acu,2) }}</td>
                        @else
                            <td class="celd_num" style="font-size: 18pt;">0</td>
                        @endif -->
                        @if(count($lunes) > 0)
                            <td class="celd_num" style="font-size: 18pt;">{{ number_format($lunes->dif_dev_dia,2) }}</td>
                            @php
                                $total_semana += $lunes->dif_dev_dia;
                            @endphp
                        @else
                            <td class="celd_num" style="font-size: 18pt;">0</td>
                        @endif
                        @if(count($martes) > 0)
                            <td class="celd_num" style="font-size: 18pt;">{{ number_format($martes->dif_dev_dia,2) }}</td>
                            @php
                                $total_semana += $martes->dif_dev_dia;
                            @endphp
                        @else
                            <td class="celd_num" style="font-size: 18pt;">0</td>
                        @endif
                        @if(count($miercoles) > 0)
                            <td class="celd_num" style="font-size: 18pt;">{{ number_format($miercoles->dif_dev_dia,2) }}</td>
                            @php
                                $total_semana += $miercoles->dif_dev_dia;
                            @endphp
                        @else
                            <td class="celd_num" style="font-size: 18pt;">0</td>
                        @endif
                        @if(count($jueves) > 0)
                            <td class="celd_num" style="font-size: 18pt;">{{ number_format($jueves->dif_dev_dia,2) }}</td>
                            @php
                                $total_semana += $jueves->dif_dev_dia;
                            @endphp
                        @else
                            <td class="celd_num" style="font-size: 18pt;">0</td>
                        @endif
                        @if(count($viernes) > 0)
                            <td class="celd_num" style="font-size: 18pt;">{{ number_format($viernes->dif_dev_dia,2) }}</td>
                            @php
                                $total_semana += $viernes->dif_dev_dia;
                            @endphp
                        @else
                            <td class="celd_num" style="font-size: 18pt;">0</td>
                        @endif
                        <td class="celd_num" style="font-size: 18pt;">{{ number_format($total_semana,2) }}</td>
                    </tr>
                @endforeach
            @endif
        @endforeach
        <!-- TOTAL DE PROYECTO PROGRAMADOS -->
        @php
            $t_cantidad = count($data_hoy->where('meta_mes','!=',0));
        @endphp
        <tr>
            <td class="celd" style="font-size: 20pt;background-color:#A9D08E;">{{ $t_cantidad }}</td>
            <td colspan="4" class="celd" style="font-size: 20pt;background-color:#A9D08E;">TOTAL</td>
            <td class="celd" style="font-size: 20pt;background-color:#A9D08E;">{{ number_format($t_programacion,2) }}</td>
            <td class="celd" style="font-size: 20pt;background-color:#A9D08E;">{{ number_format($t_ejecucion,2) }}</td>
            @if($t_programacion > 0)
                <td class="celd" style="font-size: 20pt;background-color:#A9D08E;">{{ number_format($t_ejecucion*100/$t_programacion,2) }}</td>
            @else
                <td class="celd" style="font-size: 20pt;background-color:#A9D08E;">0.00</td>
            @endif
            <!-- <td class="celd" style="font-size: 20pt;background-color:#A9D08E;">{{ number_format($t_mes_acumalativo,2) }}</td> -->
            <td class="celd" style="font-size: 20pt;background-color:#A9D08E;">{{ number_format($t_lunes,2) }}</td>
            <td class="celd" style="font-size: 20pt;background-color:#A9D08E;">{{ number_format($t_martes,2) }}</td>
            <td class="celd" style="font-size: 20pt;background-color:#A9D08E;">{{ number_format($t_miercoles,2) }}</td>
            <td class="celd" style="font-size: 20pt;background-color:#A9D08E;">{{ number_format($t_jueves,2) }}</td>
            <td class="celd" style="font-size: 20pt;background-color:#A9D08E;">{{ number_format($t_viernes,2) }}</td>
            <td class="celd" style="font-size: 20pt;background-color:#A9D08E;">{{ number_format($t_semana_total,2) }}</td>
        </tr>
    </table>
</html>
