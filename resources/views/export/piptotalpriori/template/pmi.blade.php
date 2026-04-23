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
                background-color: #A9D08E;  
                font-size: 13pt;
                font-weight: bold;
            }

            .total_text {
                background-color: #A9D08E;  
                font-size: 13pt;
                font-weight: bold;
                text-align: center;
            }

            .total_num {
                background-color: #A9D08E;  
                font-size: 12pt;
                font-weight: bold;
                text-align: center;
            }

        </style>
         @php
            $year= date("Y");
        @endphp
        <tr id="header">
            <td class="header" width="100">PRIORIDAD</td>
            <td class="header" width="100">ORDEN PRELACIÓN (*)</td>
            <td class="header" width="100">SECTOR</td>
            <td class="header" width="100">OPMI</td>
            <td class="header" width="100">UEI</td>
            <td class="header" width="100">PROVINCIA</td>
            <td class="header" width="100">FUNCION</td>
            <td class="header" width="100">CÓDIGO ÚNICO</td>
            <td class="header" width="100">CÓDIGO IDEA</td>
            <td class="header" width="100">TIPO DE INVERSIÓN</td>
            <td class="header" width="250">NOMBRE INVERSIÓN</td>
            <td class="header" width="100">COSTO ACTUALIZADO (S/)</td>
            <td class="header" width="100">DEVENGADO ACUMULADO (S/) (AL 31 DIC. {{$year - 1}})</td>
            <td class="header" width="100">PIM {{$year}} (S/)</td>
            <td class="header" width="100">MONTO  {{$year  }} (S/)</td>
            <td class="header" width="100">MONTO  {{$year + 1 }} (S/)</td>
            <td class="header" width="100">MONTO  {{$year + 2 }} (S/)</td>
            <td class="header" width="100">MONTO  {{$year + 3 }} (S/)</td>
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
                'SIN PROVINCIA'
            ];

            $sector = [
                'AGROPECUARIA',
                'PLANEAMIENTO, GESTION Y RESERVA DE CONTINGENCIA',
                'ENERGIA',
                'EDUCACION',
                'SANEAMIENTO',
                'TRANSPORTE',
                'AMBIENTE',
                'COMUNICACIONES',
                'CULTURA Y DEPORTE',
                'TURISMO',
                'VIVIENDA Y DESARROLLO URBANO',
                'SALUD',
                'ORDEN PUBLICO Y SEGURIDAD',
                'PESCA',
                'SIN SECTOR'
            ];

            $cant_proyectos =0; 
            $m_pip = 0;
            $m_deveng_a = 0;
            $pim_dia =0;
            $pim_1 =0;
            $pim_2 =0;
            $pim_3 =0;
            $pim_4 =0;

            if ($filtro == 'ger_direc') {
                $tipo = $uei;
            }elseif ($filtro == 'nom_prov') {
                $tipo = $provincia;
            }elseif ($filtro == 'funcion') {
                $tipo = $sector;
            }

        @endphp
        @foreach($tipo as $item )
            @if(count($data->where($filtro,'=',$item)) > 0)
            <td colspan="18" class="subtotal">{{$item}}</td>
                @foreach($data->where($filtro,'=',$item) as $key => $row )
                    @php
                        $cant_proyectos +=  1;
                        $m_pip += $row->costo_actualizado;
                        $m_deveng_a += $row->devengado_acumulado;
                        $pim_dia += $row->pim;
                        $pim_1 += $row->monto_1;
                        $pim_2 += $row->monto_2;
                        $pim_3 += $row->monto_3;
                        $pim_4 += $row->monto_4;
                    @endphp
                    <tr>
                        <td class="left">{{ $row->prioridad}}</td>
                        <td class="center">{{ $row->orden_prelacion}}</td>
                        <td class="center">{{ $row->sector}}</td>
                        <td class="center">{{ $row->opmi}}</td>
                        <td class="center">{{ $row->ger_direc}}</td>
                        <td class="center">{{ $row->nom_prov}}</td>
                        <td class="center">{{ $row->funcion}}</td>
                        <td class="center">{{ $row->codigo_unico}}</td>
                        <td class="center">{{ $row->codigo_idea}}</td>
                        <td class="center">{{ $row->tipo_inversion}}</td>
                        <td class="center">{{ $row->nombre_inversion}}</td>
                        <td class="center">{{ number_format($row->costo_actualizado,2) }}</td>
                        <td class="center">{{ number_format($row->devengado_acumulado,2) }}</td>
                        <td class="center">{{ number_format($row->pim,2) }}%</td>
                        <td class="center">{{ number_format($row->monto_1,2) }}</td>
                        <td class="center">{{ number_format($row->monto_2,2) }}</td>
                        <td class="center">{{ number_format($row->monto_3,2) }}</td>
                        <td class="center">{{ number_format($row->monto_4,2) }}</td>
                    </tr>
                @endforeach
            @endif
        @endforeach
        <tr>
            <td class="total_num">{{ $cant_proyectos}}</td>
            <td class="total_text" colspan="10">TOTAL</td>
            <td class="total_num">{{ number_format($m_pip,2) }}</td>
            <td class="total_num">{{ number_format($m_deveng_a,2) }}</td>
            <td class="total_num">{{ number_format($pim_dia,2) }}</td>
            <td class="total_num">{{ number_format($pim_1,2) }}</td>
            <td class="total_num">{{ number_format($pim_2,2) }}</td>
            <td class="total_num">{{ number_format($pim_3,2) }}</td>
            <td class="total_num">{{ number_format($pim_4,2) }}</td>
        </tr>
    </table>
</html>
