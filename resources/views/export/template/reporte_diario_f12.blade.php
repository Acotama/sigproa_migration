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
            $mes = date("m");
            $mes_nombre = "";
            $t_1_meta_f12 = 0;
            $t_1_devengado_mes = 0;
            $t_1_cantidad = 0;

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

            foreach($data as $key => $row ){
                if($mes == 1){
                    $t_1_meta_f12 += $row->a_enero;
                    $t_1_devengado_mes+= $row->enero;
                    $t_1_cantidad += $row->can_enero;
                }elseif($mes == 2){
                    $t_1_meta_f12 += $row->a_febrero;
                    $t_1_devengado_mes+= $row->febrero;
                    $t_1_cantidad += $row->can_febrero;
                }elseif($mes == 3){
                    $t_1_meta_f12 += $row->a_marzo;
                    $t_1_devengado_mes+= $row->marzo;
                    $t_1_cantidad += $row->can_marzo;
                }elseif($mes == 4){
                    $t_1_meta_f12 += $row->a_abril;
                    $t_1_devengado_mes+= $row->abril;
                    $t_1_cantidad += $row->can_abril;
                }elseif($mes == 5){
                    $t_1_meta_f12 += $row->a_mayo;
                    $t_1_devengado_mes+= $row->mayo;
                    $t_1_cantidad += $row->can_mayo;
                }elseif($mes == 6){
                    $t_1_meta_f12 += $row->a_junio;
                    $t_1_devengado_mes+= $row->junio;
                    $t_1_cantidad += $row->can_junio;
                }elseif($mes == 7){
                    $t_1_meta_f12 += $row->a_julio;
                    $t_1_devengado_mes+= $row->julio;
                    $t_1_cantidad += $row->can_julio;
                }elseif($mes == 8){
                    $t_1_meta_f12 += $row->a_agosto;
                    $t_1_devengado_mes+= $row->agosto;
                    $t_1_cantidad += $row->can_agosto;
                }elseif($mes == 9){
                    $t_1_meta_f12 += $row->a_setiembre;
                    $t_1_devengado_mes+= $row->septiembre;
                    $t_1_cantidad += $row->can_setiembre;
                }elseif($mes == 10){
                    $t_1_meta_f12 += $row->a_octubre;
                    $t_1_devengado_mes+= $row->octubre;
                    $t_1_cantidad += $row->can_octubre;
                }elseif($mes == 11){
                    $t_1_meta_f12 += $row->a_noviembre;
                    $t_1_devengado_mes+= $row->noviembre;
                    $t_1_cantidad += $row->can_noviembre;
                }elseif($mes == 12){ 
                    $t_1_meta_f12 += $row->a_diciembre;
                    $t_1_devengado_mes+= $row->diciembre;
                    $t_1_cantidad += $row->can_diciembre;
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

            $t_programacion = 0;
            $t_ejecucion = 0;
            $t_mes_acumalativo = 0;
            $t_lunes = 0;
            $t_martes = 0;
            $t_miercoles = 0;
            $t_jueves = 0;
            $t_viernes = 0;
            $t_semana_total = 0;

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
            <td style="border: none;width:205px"></td>
            <td style="border: none;width:225px"></td>
            <td style="border: none;width:205px"></td>
            <td style="border: none;width:184px"></td>
            <td style="border: none;width:225px"></td>
        </tr>
        <tr>
            <td rowspan="2" colspan="2" style="border: none;text-align:center"><img src="{{ asset('logo_opmi.png') }}"></td>
            <td colspan="2" class="celd" style="font-size: 26pt;background-color:#A9D08E;">ACTUALIZADO AL</td>
            <td rowspan="2" colspan="11" class="celd" style="border: none;font-size: 72pt;text-align:center">SEGUIMIENTO DE INVERSIONES (FORMATO 12 - B)</td>
        </tr>
        <tr>
            <td colspan="2" class="celd" style="font-size: 48pt;background-color:#A9D08E;">{{$fecha->fecha}}</td>
        </tr>
        <tr>
            <td colspan="15" style="border: none"></td>
        </tr>
        <tr>
            <td colspan="15" class="celd" style="font-size: 48pt;background-color:#A9D08E;">META ACTUALIZADA {{ $mes_nombre }}</td>
        </tr>
        <tr>
            <td colspan="15" style="border: none"></td>
        </tr>
        <!-- CUADRO N° 1 -->
        <tr style="height:60px">
            <td style="border: none;"></td>
            <td style="border: none;"></td>
            <td class="celd" style="font-size: 28pt;background-color:#A9D08E;">N°</td>
            <td class="celd" colspan="4" style="font-size: 28pt;background-color:#A9D08E;">UNIDADES EJECUTORAS</td>
            <td class="celd" style="font-size: 28pt;background-color:#A9D08E;">PROGRAMADO</td>
            <td class="celd" style="font-size: 28pt;background-color:#A9D08E;">DEVENGADO</td>
            <td class="celd" style="font-size: 28pt;background-color:#A9D08E;">AVANCE(%)</td>
            <td class="celd" colspan="2" style="font-size: 28pt;background-color:#A9D08E;">SALDO POR DEVENGAR</td>
            <td class="celd" colspan="2"style="font-size: 28pt;background-color:#A9D08E;">AVANCE TOTAL</td>
        </tr>
        @foreach($data as $key => $row )
            @php
                $meta_f12 = 0;
                $devengado_mes = 0;
                $cantidad = 0;

                if($mes == 1){
                    $meta_f12 = $row->a_enero;
                    $devengado_mes= $row->enero;
                    $cantidad = $row->can_enero;
                }elseif($mes == 2){
                    $meta_f12 = $row->a_febrero;
                    $devengado_mes= $row->febrero;
                    $cantidad = $row->can_febrero;
                }elseif($mes == 3){
                    $meta_f12 = $row->a_marzo;
                    $devengado_mes= $row->marzo;
                    $cantidad = $row->can_marzo;
                }elseif($mes == 4){
                    $meta_f12 = $row->a_abril;
                    $devengado_mes= $row->abril;
                    $cantidad = $row->can_abril;
                }elseif($mes == 5){
                    $meta_f12 = $row->a_mayo;
                    $devengado_mes= $row->mayo;
                    $cantidad = $row->can_mayo;
                }elseif($mes == 6){
                    $meta_f12 = $row->a_junio;
                    $devengado_mes= $row->junio;
                    $cantidad = $row->can_junio;
                }elseif($mes == 7){
                    $meta_f12 = $row->a_julio;
                    $devengado_mes= $row->julio;
                    $cantidad = $row->can_julio;
                }elseif($mes == 8){
                    $meta_f12 = $row->a_agosto;
                    $devengado_mes= $row->agosto;
                    $cantidad = $row->can_agosto;
                }elseif($mes == 9){
                    $meta_f12 = $row->a_setiembre;
                    $devengado_mes= $row->septiembre;
                    $cantidad = $row->can_setiembre;
                }elseif($mes == 10){
                    $meta_f12 = $row->a_octubre;
                    $devengado_mes= $row->octubre;
                    $cantidad = $row->can_octubre;
                }elseif($mes == 11){
                    $meta_f12 = $row->a_noviembre;
                    $devengado_mes= $row->noviembre;
                    $cantidad = $row->can_noviembre;
                }elseif($mes == 12){ 
                    $meta_f12 = $row->a_diciembre;
                    $devengado_mes= $row->diciembre;
                    $cantidad = $row->can_diciembre;
                }
            @endphp
            <tr>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
                <td class="celd" style="font-size: 24pt;">{{ $cantidad }}</td>
                <td class="celd" colspan="4" style="font-size: 24pt;text-align:left;">{{ $row->ger_direc }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($meta_f12,2) }}</td>
                <td class="celd" style="font-size: 24pt;">{{ number_format($devengado_mes,2) }}</td>
                @if($meta_f12 != 0 )
                    <td class="celd" style="font-size: 24pt;">{{ number_format($devengado_mes*100/$meta_f12,2) }}</td>
                @else
                    <td class="celd" style="font-size: 24pt;"></td>
                @endif
                @if($key ==0 )
                    <td class="celd" colspan="2" rowspan="9" style="font-size: 48pt;">{{ number_format($t_1_meta_f12 - $t_1_devengado_mes,2) }}</td>
                    @if($t_1_meta_f12 != 0 )
                        <td class="celd" colspan="2" rowspan="9" style="font-size: 72pt;">{{ number_format($t_1_devengado_mes*100/$t_1_meta_f12,1) }}%</td>
                    @else
                        <td class="celd" colspan="2" rowspan="9" style="font-size: 72pt;">0.0%</td>
                    @endif
                @endif
            </tr>
        @endforeach
        <tr>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td class="celd" style="font-size: 26pt;background-color:#A9D08E;">{{ $t_1_cantidad }}</td>
            <td class="celd" style="font-size: 28pt;background-color:#A9D08E;" colspan="4">TOTAL</td>
            <td class="celd" style="font-size: 26pt;background-color:#A9D08E;">{{ number_format($t_1_meta_f12,2) }}</td>
            <td class="celd" style="font-size: 26pt;background-color:#A9D08E;">{{ number_format($t_1_devengado_mes,2) }}</td>
            <td class="celd" style="font-size: 26pt;background-color:#A9D08E;"></td>
        </tr>
        
        <tr>
            <td colspan="13" style="border: none"></td>
        </tr>
        <tr>
            <td colspan="15" class="celd" style="font-size: 48pt;background-color:#A9D08E;">SEGUIMIENTO DE INVERSIONES (ACTUALIZACION DIARIA)</td>
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
            <td class="celd" style="font-size: 20pt;background-color:#D3EBF7;">TOTAL DEVENGADO</td>
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
