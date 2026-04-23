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
        <tr id="header">
            <td class="header" width="100">COD. UNIF.</td>
            <td class="header" width="250">PROYECTOS</td>
            <td class="header" width="100">TIPO</td>
            <td class="header" width="120">MONTO INV. ACT.</td>
            <td class="header" width="110">DEVEN. ACUM. ACT.</td>
            <td class="header" width="110">AVANCE ACUM. ACT.</td>
            <td class="header" width="110">PIA {{$year}}</td>
            <td class="header" width="110">PIM {{$year}}</td>
            <td class="header" width="110">CERTIF {{$year}}</td>
            <td class="header" width="110">COMP. ANUAL {{$year}}</td>
            <td class="header" width="110">COMP. MENSUAL {{$year}}</td>
            <td class="header" width="110">DEVENGADO {{$year}}</td>
            <td class="header" width="110">DEVENGADO MES NOVIEMBRE</td>
            <td class="header" width="110">GIRADO {{$year}}</td>
            <td class="header" width="110">AVANCE {{$year}}</td>
            <td class="header" width="110">AVANCE FISICO</td>
            <td class="header" width="110">PROVINCIA</td>
            <td class="header" width="110">GERENCIA</td>
            <td class="header" width="110">SECTOR</td>
            <td class="header" width="400">SITUACION</td>
            <td class="header" width="110">EXPEDIENTE TECNICO</td>
            <td class="header" width="110">CIERRE</td>
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
            
            $provincia = [
                'HUARAL',
                'CAÑETE',
                'HUAURA',
                'HUAROCHIRI',
                'OYON',
                'YAUYOS',
                'BARRANCA',
                'CAJATAMBO',
                'CANTA',
                'MULTIPROVINCIAL',
                'OTROS',
                'SIN PROVINCIA'
            ];

            $sector = [
                'TRANSPORTE',
                'SALUD',
                'EDUCACIÓN',
                'AGROPECUARIA',
                'PLANEAMIENTO, GESTIÓN Y RESERVA DE CONTINGENCIA',
                'SANEAMIENTO',
                'AGRARIA',
                'ORDEN PÚBLICO Y SEGURIDAD',
                'PROCOMPITE',
                'SALUD Y SANEAMIENTO',
                'ENERGÍA',
                'AMBIENTE',
                'TURISMO',
                'PESCA',
                'COMUNICACIONES',
                'COMERCIO',
                'SIN SECTOR'
            ];

            $cant_proyectos =0; 
            $m_pip = 0;
            $m_deveng_a = 0;
            $pia_dia = 0;
            $pim_dia =0;
            $certificacion_dia =0;
            $comp_anual_dia =0;
            $ate_comp_anual_dia =0;
            $dev_dia =0;
            $mes_dev =0;
            $girado_dia =0;

            if ($filtro == 'ger_direc') {
                $tipo = $uei;
            }elseif ($filtro == 'nom_prov') {
                $tipo = $provincia;
            }elseif ($filtro == 'sector') {
                $tipo = $sector;
            }

        @endphp
        @foreach($tipo as $item )
            @if(count($data->where($filtro,'=',$item)) > 0)
            <td colspan="22" class="subtotal">{{$item}}</td>
                @foreach($data->where($filtro,'=',$item) as $key => $row )
                    @php
                        $cant_proyectos +=  1;
                        $m_pip += $row->m_pip;
                        $m_deveng_a += $row->m_deveng_a;
                        $pia_dia += $row->pia_dia;
                        $pim_dia += $row->pim_dia;
                        $certificacion_dia += $row->certificacion_dia;
                        $comp_anual_dia += $row->comp_anual_dia;
                        $ate_comp_anual_dia += $row->ate_comp_anual_dia;
                        $dev_dia += $row->dev_dia;
                        $mes_dev += $row->mes_dev;
                        $girado_dia += $row->girado_dia;
                    @endphp
                    <tr>
                        <td class="center">{{ $row->cant_proyectos}}</td>
                        <td class="left">{{ $row->nom_proyec}}</td>
                        <td class="center">{{ $row->tipo_pry}}</td>
                        <td class="center">{{ number_format($row->m_pip,2) }}</td>
                        <td class="center">{{ number_format($row->m_deveng_a,2) }}</td>
                        <td class="center">{{ number_format($row->a_financ_a,2) }}%</td>
                        <td class="center">{{ number_format($row->pia_dia,2) }}</td>
                        <td class="center">{{ number_format($row->pim_dia,2) }}</td>
                        <td class="center">{{ number_format($row->certificacion_dia,2) }}</td>
                        <td class="center">{{ number_format($row->comp_anual_dia,2) }}</td>
                        <td class="center">{{ number_format($row->ate_comp_anual_dia,2) }}</td>
                        <td class="center">{{ number_format($row->dev_dia,2) }}</td>
                        <td class="center">{{ number_format($row->mes_dev,2) }}</td>
                        <td class="center">{{ number_format($row->girado_dia,2) }}</td>
                        @if (number_format($row->pim_dia) == 0)
                            <td class="center">0%</td>
                        @else
                            <td class="center">{{ number_format(($row->dev_dia/$row->pim_dia) * 100,2)}}%</td>
                        @endif
                        <td class="center">{{ $row->a_fisico}}</td>
                        <td class="center">{{ $row->nom_prov}}</td>
                        <td class="center">{{ $row->ger_direc}}</td>
                        <td class="center">{{ $row->sector}}</td>
                        <td class="center">{{ $row->ult_est_situal}}</td>
                        <td class="center">{{ $row->expediente_c}}</td>
                        <td class="center">{{ $row->cierre}}</td>
                    </tr>
                @endforeach
            @endif
        @endforeach
        <tr>
            <td class="total_num">{{ $cant_proyectos}}</td>
            <td class="total_text" colspan="2">TOTAL</td>
            <td class="total_num">{{ number_format($m_pip,2) }}</td>
            <td class="total_num">{{ number_format($m_deveng_a,2) }}</td>
            <td class="total_num">{{ number_format( ($m_deveng_a/$m_pip)*100,2) }}%</td>
            <td class="total_num">{{ number_format($pia_dia,2) }}</td>
            <td class="total_num">{{ number_format($pim_dia,2) }}</td>
            <td class="total_num">{{ number_format($certificacion_dia,2) }}</td>
            <td class="total_num">{{ number_format($comp_anual_dia,2) }}</td>
            <td class="total_num">{{ number_format($ate_comp_anual_dia,2) }}</td>
            <td class="total_num">{{ number_format($dev_dia,2) }}</td>
            <td class="total_num">{{ number_format($mes_dev,2) }}</td>
            <td class="total_num">{{ number_format($girado_dia,2) }}</td>
            <td class="total_num">{{ number_format(($dev_dia/$pim_dia)* 100,2)}}%</td>
            <td class="total_text" colspan="7"></td>
        </tr>
    </table>
</html>
