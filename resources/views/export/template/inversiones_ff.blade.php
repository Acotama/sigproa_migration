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

            .title{
                font-size: 18pt;
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

            .subtotal_ger {
                background-color: #DDEBF7;  
                font-size: 13pt;
                font-weight: bold;
            }

            .total {
                background-color: #f1e31a;  
                font-size: 12pt;
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
                font-size: 12pt;
                font-weight: bold;
                text-align: center;
            }

        </style>
         @php
            $year= date("Y");
        @endphp
        <tr>
            <td colspan="21" class="title" style="border: none">PROYECTOS DE INVERSION PUBLICA {{$year}}</td>
        </tr>
        <tr> 
            <td colspan="21" class="title" style="border: none">GOBIERNO REGIONAL DEL DEPARTAMENTO DE LIMA</td>
        </tr>
        <tr>
            <td colspan="21" class="title" style="border: none"></td>
        </tr>
        <tr id="header">
            <td rowspan="4" class="header" width="100">CODIGO UNICO DE INVERSION</td>
            <td rowspan="4" class="header" width="500">DENOMINACION DEL PROYECTO</td>
            <td rowspan="4" class="header" width="80">FF</td>
            <td rowspan="3" class="header" width="100">PIA</td>
            <td rowspan="3" class="header" width="100">PIM</td>
            <td rowspan="3" class="header" width="100">Certificación</td>
            <td rowspan="3" class="header" width="100">Compromiso Anual</td>
            <td colspan="3" class="header" width="100">Ejecución </td>
            <td rowspan="3" class="header" width="100">SALDOS (Devengado)</td>
            <td rowspan="3" class="header" width="100">Avance % (Devengado)</td>
            <td class="header" width="100" style="background: white;border: none"></td>
            <td rowspan="2" colspan="2" class="header_form" width="250">PIM vs Certificado (Por Certificar)</td>
            <td rowspan="2" colspan="2" class="header_form" width="100">PIM vs Compromiso Anual (Por Compremeter 1)</td>
            <td rowspan="2" colspan="2" class="header_form" width="100">Certificado vs Compromiso Anual (Por Compremeter 2)</td>
            <td rowspan="2" colspan="2" class="header_form" width="100">Compromiso Anual vs Devengado (Por Devengar)</td>
        </tr>
        <tr>
            <td rowspan="2" class="header" width="100">Atencion de Compromiso de Mensual</td>
            <td rowspan="2" class="header" width="100">Devengado</td>
            <td rowspan="2" class="header" width="100">Girado</td>
            <td class="header" width="100" style="background: white;border: none"></td>
        </tr>
        <tr>
            <td class="header_form" width="100" style="background: white;border: none"></td>
            <td class="header_form" width="100">Monto</td>
            <td class="header_form" width="100">%</td>
            <td class="header_form" width="100">Monto</td>
            <td class="header_form" width="100">%</td>
            <td class="header_form" width="100">Monto</td>
            <td class="header_form" width="100">%</td>
            <td class="header_form" width="100">Monto</td>
            <td class="header_form" width="100">%</td>
        </tr>
        <tr>
            <td class="header" width="100">( a )</td>
            <td class="header" width="100">( b )</td>
            <td class="header" width="100">( c )</td>
            <td class="header" width="100">( d )</td>
            <td class="header" width="100">( e )</td>
            <td class="header" width="100">( f )</td>
            <td class="header" width="100">( g )</td>
            <td class="header" width="100">( h = b - f )</td>
            <td class="header" width="100">i = (f*100/b)</td>
            <td class="header" width="100" style="background: white;border: none"></td>
            <td class="header_form" width="100">( j = b - c )</td>
            <td class="header_form" width="100">k = (c*100/b)</td>
            <td class="header_form" width="100">( l = b-d )</td>
            <td class="header_form" width="100">m = (d*100/b)</td>
            <td class="header_form" width="100">( n = c - d )</td>
            <td class="header_form" width="100">o = (d*100/c)</td>
            <td class="header_form" width="100">( p = d - f )</td>
            <td class="header_form" width="100">q = (f*100/d)</td>
        </tr>
        <tr>
            <td colspan="21" class="title" style="border: none"></td>
        </tr>
        @php
            $uei = [
                'ESTUDIOS DE PRE-INVERSION',
                'DIRECCION REGIONAL DE AGRICULTURA',
                'DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES',
                'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                'GERENCIA REGIONAL DE DESARROLLO SOCIAL',
                'GERENCIA REGIONAL DE INFRAESTRUCTURA',
                'GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE',
                'GERENCIA SUB REGIONAL LIMA SUR',
                'SIN UEI'
            ]; 
        @endphp
        @foreach($uei as $item )
            @if(count($data->where('ger_direc','=',$item)) > 0)
                @php 
                $cant_proyectos =0; 
                $PIA =0;
                $PIM =0;
                $certificacion =0;
                $compromiso_anual =0;
                $aten_com_men =0;
                $devengado =0;
                $girado =0;
                $saldos =0;
                $avance =0;
                $pimvscert =0;
                $porpimvscert =0;
                $pimvscompanual =0;
                $porpimvscompanual =0;
                $certvscompanual =0;
                $porcertvscompanual =0;
                $companualvsdev =0;
                $porcompanualvsdev =0;
                @endphp
                @foreach($data->where('ger_direc','=',$item) as $key => $row )
                    @php
                        $cant_proyectos +=  1;
                        $PIA += $row->pia_dia;
                        $PIM += $row->pim_dia;
                        $certificacion += $row->certificacion_dia;
                        $compromiso_anual += $row->comp_anual_dia;
                        $aten_com_men += $row->ate_comp_anual_dia;
                        $devengado += $row->dev_dia;
                        $girado += $row->girado_dia;
                    @endphp
                @endforeach
                    @php
                        $saldos = $PIM - $devengado;
                        if($PIM == 0){
                            $avance = 0.00;
                        }else{
                            $avance = ($devengado * 100)/$PIM;
                        }
                        $pimvscert = $PIM - $certificacion;
                        if($PIM == 0){
                            $porpimvscert = 0.00;
                        }else{
                            $porpimvscert = ($certificacion * 100)/$PIM;
                        }
                        $pimvscompanual = $PIM - $compromiso_anual;
                        if($PIM == 0){
                            $porpimvscompanual = 0.00;
                        }else{
                            $porpimvscompanual = ($compromiso_anual * 100)/$PIM;
                        }
                        $certvscompanual = $certificacion - $compromiso_anual;
                        if($certificacion == 0){
                            $porcertvscompanual = 0.00;
                        }else{
                            $porcertvscompanual = ($compromiso_anual * 100)/$certificacion;
                        }
                        $companualvsdev = $compromiso_anual - $devengado;
                        if($compromiso_anual == 0){
                            $porcompanualvsdev = 0.00;
                        }else{
                            $porcompanualvsdev = ($devengado * 100)/$compromiso_anual;
                        }                        
                    @endphp
                    <td class="subtotal" style="text-align: center;">{{ $cant_proyectos }}</td>
                    <td colspan="2" class="subtotal">{{$item}}</td>
                    <td class="subtotal" style="text-align: right;font-size: 11pt;">{{ number_format($PIA,2) }}</td>
                    <td class="subtotal" style="text-align: right;font-size: 11pt;">{{ number_format($PIM,2) }}</td>
                    <td class="subtotal" style="text-align: right;font-size: 11pt;">{{ number_format($certificacion,2) }}</td>
                    <td class="subtotal" style="text-align: right;font-size: 11pt;">{{ number_format($compromiso_anual,2) }}</td>
                    <td class="subtotal" style="text-align: right;font-size: 11pt;">{{ number_format($aten_com_men,2) }}</td>
                    <td class="subtotal" style="text-align: right;font-size: 11pt;">{{ number_format($devengado,2) }}</td>
                    <td class="subtotal" style="text-align: right;font-size: 11pt;">{{ number_format($girado,2) }}</td>
                    <td class="subtotal" style="text-align: right;font-size: 11pt;">{{ number_format($saldos,2) }}</td>
                    <td class="subtotal" style="text-align: right;font-size: 11pt;">{{ number_format($avance,2) }}</td>
                    <td style="background: white;border: none"></td>
                    <td class="subtotal" style="text-align: right;font-size: 11pt;">{{ number_format($pimvscert,2) }}</td>
                    <td class="subtotal" style="text-align: right;font-size: 11pt;">{{ number_format($porpimvscert,2) }}</td>
                    <td class="subtotal" style="text-align: right;font-size: 11pt;">{{ number_format($pimvscompanual,2) }}</td>
                    <td class="subtotal" style="text-align: right;font-size: 11pt;">{{ number_format($porpimvscompanual,2) }}</td>
                    <td class="subtotal" style="text-align: right;font-size: 11pt;">{{ number_format($certvscompanual,2) }}</td>
                    <td class="subtotal" style="text-align: right;font-size: 11pt;">{{ number_format($porcertvscompanual,2) }}</td>
                    <td class="subtotal" style="text-align: right;font-size: 11pt;">{{ number_format($companualvsdev,2) }}</td>
                    <td class="subtotal" style="text-align: right;font-size: 11pt;">{{ number_format($porcompanualvsdev,2) }}</td>  
                @foreach($data->where('ger_direc','=',$item) as $key => $row )
                    <tr>
                        <td class="center">{{ $row->cod_unif }}</td>
                        <td class="left">{{ $row->nom_proyec }}</td>
                        <td class="center">{{ $row->ff }}</td>
                        <td class="right">{{ number_format($row->pia_dia,2) }}</td>
                        <td class="right">{{ number_format($row->pim_dia,2) }}</td>
                        <td class="right">{{ number_format($row->certificacion_dia,2) }}</td>
                        <td class="right">{{ number_format($row->comp_anual_dia,2) }}</td>
                        <td class="right">{{ number_format($row->ate_comp_anual_dia,2) }}</td>
                        <td class="right">{{ number_format($row->dev_dia,2) }}</td>
                        <td class="right">{{ number_format($row->girado_dia,2) }}</td>
                        <td class="right">{{ number_format(($row->pim_dia - $row->dev_dia),2) }}</td>
                        @if($row->pim_dia == 0)
                            <td class="right">0.00</td>
                        @else
                            <td class="right">{{ number_format((($row->dev_dia * 100)/($row->pim_dia)),2) }}</td>
                        @endif
                        <td style="background: white;border: none"></td>
                        <td class="right">{{ number_format(($row->pim_dia - $row->certificacion_dia),2) }}</td>
                        @if($row->pim_dia == 0)
                            <td class="right">0.00</td>
                        @else
                            <td class="right">{{ number_format((($row->certificacion_dia * 100)/($row->pim_dia)),2) }}</td>
                        @endif
                        <td class="right">{{ number_format(($row->pim_dia - $row->comp_anual_dia),2) }}</td>
                        @if($row->pim_dia == 0)
                            <td class="right">0.00</td>
                        @else
                            <td class="right">{{ number_format((($row->comp_anual_dia * 100)/($row->pim_dia)),2) }}</td>
                        @endif
                        <td class="right">{{ number_format(($row->certificacion_dia - $row->comp_anual_dia),2) }}</td>
                        @if($row->certificacion_dia == 0)
                            <td class="right">0.00</td>
                        @else
                            <td class="right">{{ number_format((($row->comp_anual_dia * 100)/($row->certificacion_dia)),2) }}</td>
                        @endif
                        <td class="right">{{ number_format(($row->comp_anual_dia - $row->dev_dia),2) }}</td>
                        @if($row->comp_anual_dia == 0)
                            <td class="right">0.00</td>
                        @else
                            <td class="right">{{ number_format((($row->dev_dia * 100)/($row->comp_anual_dia)),2) }}</td>
                        @endif
                    </tr>
                @endforeach
            @endif
        @endforeach
        <tr>
            <td colspan="21" class="title" style="border: none"></td>
        </tr>
        <tr> 
            <td colspan="21" class="title" style="border: none"></td>
        </tr>
        @foreach($uei as $item )
            @if(count($data_ff->where('ger_direc','=',$item)) > 0)
                @php 
                    $cant_proyectos =0; 
                    $PIA =0;
                    $PIM =0;
                    $certificacion =0;
                    $compromiso_anual =0;
                    $aten_com_men =0;
                    $devengado =0;
                    $girado =0;
                    $saldos =0;
                    $avance =0;
                    $pimvscert =0;
                    $porpimvscert =0;
                    $pimvscompanual =0;
                    $porpimvscompanual =0;
                    $certvscompanual =0;
                    $porcertvscompanual =0;
                    $companualvsdev =0;
                    $porcompanualvsdev =0;
                @endphp
                @foreach($data_ff->where('ger_direc','=',$item) as $key => $row )
                    @php
                        $cant_proyectos +=  1;
                        $PIA += $row->pia_dia;
                        $PIM += $row->pim_dia;
                        $certificacion += $row->certificacion_dia;
                        $compromiso_anual += $row->comp_anual_dia;
                        $aten_com_men += $row->ate_comp_anual_dia;
                        $devengado += $row->dev_dia;
                        $girado += $row->girado_dia;
                    @endphp
                @endforeach
                    @php
                        $saldos = $PIM - $devengado;
                        if($PIM == 0){
                            $avance = 0.00;
                        }else{
                            $avance = ($devengado * 100)/$PIM;
                        }
                        $pimvscert = $PIM - $certificacion;
                        if($PIM == 0){
                            $porpimvscert = 0.00;
                        }else{
                            $porpimvscert = ($certificacion * 100)/$PIM;
                        }
                        $pimvscompanual = $PIM - $compromiso_anual;
                        if($PIM == 0){
                            $porpimvscompanual = 0.00;
                        }else{
                            $porpimvscompanual = ($compromiso_anual * 100)/$PIM;
                        }
                        $certvscompanual = $certificacion - $compromiso_anual;
                        if($certificacion == 0){
                            $porcertvscompanual = 0.00;
                        }else{
                            $porcertvscompanual = ($compromiso_anual * 100)/$certificacion;
                        }
                        $companualvsdev = $compromiso_anual - $devengado;
                        if($compromiso_anual == 0){
                            $porcompanualvsdev = 0.00;
                        }else{
                            $porcompanualvsdev = ($devengado * 100)/$compromiso_anual;
                        }                        
                    @endphp
                    <td colspan="3" class="subtotal_ger">{{$item}}</td>
                    <td class="subtotal_ger" style="text-align: right;font-size: 11pt;">{{ number_format($PIA,2) }}</td>
                    <td class="subtotal_ger" style="text-align: right;font-size: 11pt;">{{ number_format($PIM,2) }}</td>
                    <td class="subtotal_ger" style="text-align: right;font-size: 11pt;">{{ number_format($certificacion,2) }}</td>
                    <td class="subtotal_ger" style="text-align: right;font-size: 11pt;">{{ number_format($compromiso_anual,2) }}</td>
                    <td class="subtotal_ger" style="text-align: right;font-size: 11pt;">{{ number_format($aten_com_men,2) }}</td>
                    <td class="subtotal_ger" style="text-align: right;font-size: 11pt;">{{ number_format($devengado,2) }}</td>
                    <td class="subtotal_ger" style="text-align: right;font-size: 11pt;">{{ number_format($girado,2) }}</td>
                    <td class="subtotal_ger" style="text-align: right;font-size: 11pt;">{{ number_format($saldos,2) }}</td>
                    <td class="subtotal_ger" style="text-align: right;font-size: 11pt;">{{ number_format($avance,2) }}</td>
                    <td style="background: white;border: none"></td>
                    <td class="subtotal_ger" style="text-align: right;font-size: 11pt;">{{ number_format($pimvscert,2) }}</td>
                    <td class="subtotal_ger" style="text-align: right;font-size: 11pt;">{{ number_format($porpimvscert,2) }}</td>
                    <td class="subtotal_ger" style="text-align: right;font-size: 11pt;">{{ number_format($pimvscompanual,2) }}</td>
                    <td class="subtotal_ger" style="text-align: right;font-size: 11pt;">{{ number_format($porpimvscompanual,2) }}</td>
                    <td class="subtotal_ger" style="text-align: right;font-size: 11pt;">{{ number_format($certvscompanual,2) }}</td>
                    <td class="subtotal_ger" style="text-align: right;font-size: 11pt;">{{ number_format($porcertvscompanual,2) }}</td>
                    <td class="subtotal_ger" style="text-align: right;font-size: 11pt;">{{ number_format($companualvsdev,2) }}</td>
                    <td class="subtotal_ger" style="text-align: right;font-size: 11pt;">{{ number_format($porcompanualvsdev,2) }}</td>  
                @foreach($data_ff->where('ger_direc','=',$item) as $key => $row )
                    <tr>
                        <td class="center"></td>
                        <td class="left">{{ $row->fuente_financiamiento }}</td>
                        <td class="center">{{ $row->ff }}</td>
                        <td class="right">{{ number_format($row->pia_dia,2) }}</td>
                        <td class="right">{{ number_format($row->pim_dia,2) }}</td>
                        <td class="right">{{ number_format($row->certificacion_dia,2) }}</td>
                        <td class="right">{{ number_format($row->comp_anual_dia,2) }}</td>
                        <td class="right">{{ number_format($row->ate_comp_anual_dia,2) }}</td>
                        <td class="right">{{ number_format($row->dev_dia,2) }}</td>
                        <td class="right">{{ number_format($row->girado_dia,2) }}</td>
                        <td class="right">{{ number_format(($row->pim_dia - $row->dev_dia),2) }}</td>
                        @if($row->pim_dia == 0)
                            <td class="right">0.00</td>
                        @else
                            <td class="right">{{ number_format((($row->dev_dia * 100)/($row->pim_dia)),2) }}</td>
                        @endif
                        <td style="background: white;border: none"></td>
                        <td class="right">{{ number_format(($row->pim_dia - $row->certificacion_dia),2) }}</td>
                        @if($row->pim_dia == 0)
                            <td class="right">0.00</td>
                        @else
                            <td class="right">{{ number_format((($row->certificacion_dia * 100)/($row->pim_dia)),2) }}</td>
                        @endif
                        <td class="right">{{ number_format(($row->pim_dia - $row->comp_anual_dia),2) }}</td>
                        @if($row->pim_dia == 0)
                            <td class="right">0.00</td>
                        @else
                            <td class="right">{{ number_format((($row->comp_anual_dia * 100)/($row->pim_dia)),2) }}</td>
                        @endif
                        <td class="right">{{ number_format(($row->certificacion_dia - $row->comp_anual_dia),2) }}</td>
                        @if($row->certificacion_dia == 0)
                            <td class="right">0.00</td>
                        @else
                            <td class="right">{{ number_format((($row->comp_anual_dia * 100)/($row->certificacion_dia)),2) }}</td>
                        @endif
                        <td class="right">{{ number_format(($row->comp_anual_dia - $row->dev_dia),2) }}</td>
                        @if($row->comp_anual_dia == 0)
                            <td class="right">0.00</td>
                        @else
                            <td class="right">{{ number_format((($row->dev_dia * 100)/($row->comp_anual_dia)),2) }}</td>
                        @endif
                    </tr>
                @endforeach
            @endif
        @endforeach
        @foreach($data_total as $key => $row )
            <tr>
                <td class="total" style="text-align: center" colspan="3">TOTAL</td>
                <td class="total">{{ number_format($row->pia_dia,2) }}</td>
                <td class="total">{{ number_format($row->pim_dia,2) }}</td>
                <td class="total">{{ number_format($row->certificacion_dia,2) }}</td>
                <td class="total">{{ number_format($row->comp_anual_dia,2) }}</td>
                <td class="total">{{ number_format($row->ate_comp_anual_dia,2) }}</td>
                <td class="total">{{ number_format($row->dev_dia,2) }}</td>
                <td class="total">{{ number_format($row->girado_dia,2) }}</td>
                <td class="total">{{ number_format(($row->pim_dia - $row->dev_dia),2) }}</td>
                @if($row->pim_dia == 0)
                    <td class="total">0.00</td>
                @else
                    <td class="total">{{ number_format((($row->dev_dia * 100)/($row->pim_dia)),2) }}</td>
                @endif
                <td style="background: white;border: none"></td>
                <td class="total">{{ number_format(($row->pim_dia - $row->certificacion_dia),2) }}</td>
                @if($row->pim_dia == 0)
                    <td class="total">0.00</td>
                @else
                    <td class="total">{{ number_format((($row->certificacion_dia * 100)/($row->pim_dia)),2) }}</td>
                @endif
                <td class="total">{{ number_format(($row->pim_dia - $row->comp_anual_dia),2) }}</td>
                @if($row->pim_dia == 0)
                    <td class="total">0.00</td>
                @else
                    <td class="total">{{ number_format((($row->comp_anual_dia * 100)/($row->pim_dia)),2) }}</td>
                @endif
                <td class="total">{{ number_format(($row->certificacion_dia - $row->comp_anual_dia),2) }}</td>
                @if($row->certificacion_dia == 0)
                    <td class="total">0.00</td>
                @else
                    <td class="total">{{ number_format((($row->comp_anual_dia * 100)/($row->certificacion_dia)),2) }}</td>
                @endif
                <td class="total">{{ number_format(($row->comp_anual_dia - $row->dev_dia),2) }}</td>
                @if($row->comp_anual_dia == 0)
                    <td class="total">0.00</td>
                @else
                    <td class="total">{{ number_format((($row->dev_dia * 100)/($row->comp_anual_dia)),2) }}</td>
                @endif
            </tr>
        @endforeach
    </table>
</html>
