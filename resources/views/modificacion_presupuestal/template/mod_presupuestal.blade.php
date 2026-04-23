<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <style>
        table {
            border-collapse: collapse;
        }
        .bordeceld {
            border: 0.5pt solid #000;
            font-size: 10pt;
            vertical-align: middle;
        }
        .headproyecto{
            border: 0.5pt solid #000;
            background:"#BDD7EE";
            vertical-align: middle;
        }
        .headdetalleproyecto{
            border: 0.5pt solid #000;
            background:"#A9D08E";
            vertical-align: middle;
        }
        .proyecto{
            border: 0.5pt solid #000;
            vertical-align: middle;
            text-align: center;
        }
    </style>
@php
    $year = date('Y');
    $monto_total_anulado = 0;
    $monto_total_credito = 0;
@endphp
<table>
    <tr>
        <td colspan="11" style="border: none;"></td>
    </tr>
    <tr>
        <td colspan="11" style="font-weight: bold;font-size: 24pt;text-align: center;border: 2pt solid #000;">MODIFICACION PRESUPUESTAL</td>
    </tr>
    <tr>
        <td style="border: none;width:45px"></td>
        <td style="border: none;width:84px"></td>
        <td style="border: none;width:84px"></td>
        <td style="border: none;width:70px"></td>
        <td style="border: none;width:410px"></td>
        <td style="border: none;width:160px"></td>
        <td style="border: none;width:160px"></td>
        <td style="border: none;width:160px"></td>
        <td style="border: none;width:160px"></td>
        <td style="border: none;width:160px"></td>
        <td style="border: none;width:160px"></td>
    </tr>
    @foreach($inversion as $key => $row_pry)
        @php
            $anulacion_mod = $anulacion->where('cui_a','=',$row_pry->cod_unif);
            $credito_mod = $credito->where('cui_c','=',$row_pry->cod_unif);
            $monto_total_anulado = 0;
            $monto_total_credito = 0;
            foreach($anulacion_mod as $row){
                $monto_total_anulado += intval($row->saldo_anu_a);
            }

            foreach($credito as $row){
                $monto_total_credito += intval($row->saldo_anu_a);
            }
        @endphp
        <tr>
            <th class="headproyecto" style="background:#FFD966;font-size: 16pt">{{ $key + 1 }}</th>
            <th class="headproyecto" rowspan="2">COD. UNIF.</th>
            <th class="headproyecto" rowspan="2">TIPO</th>
            <th class="headproyecto" rowspan="2">UEI</th>
            <th class="headproyecto" rowspan="2">NOMBRE DE PROYECTO</th>
            <th class="headproyecto" rowspan="2">COSTO ACTUALIZADO</th>
            <th class="headproyecto" rowspan="2">DEVENGADO ACUMULADO AL {{ $year - 1 }}</th>
            <th class="headproyecto">PIA</th>
            @if(count($anulacion_mod) > 0)
                <th class="headproyecto">MONTO TOTAL DE ANULACION</th>
            @endif
            @if(count($credito_mod) > 0)
                <th class="headproyecto">MONTO TOTAL DE CREDITO</th>
            @endif
            <th class="headproyecto">PIM ACTUAL</th>
        </tr>
        <tr>
            <th style="border: none;"></th>
            <th class="headproyecto">A</th>
            @if(count($anulacion_mod) > 0)
                <th class="headproyecto">B=SUMA(E)</th>
            @endif
            @if(count($credito_mod) > 0)
                <th class="headproyecto">C=SUMA(F)</th>
            @endif
            @if(count($anulacion_mod) > 0 && count($credito_mod) > 0)
                <th class="headproyecto">D=(A-B+C)</th>
            @elseif(count($anulacion_mod) > 0)
                <th class="headproyecto">D=(A-B)</th>
            @elseif(count($credito_mod) > 0)
                <th class="headproyecto">D=(A+C)</th>
            @endif
        </tr>
        <tr>
            <th style="border: none;"></th>
            <th class="proyecto">{{ $row_pry->cod_unif }}</th>
            <th class="proyecto">{{ $row_pry->tipo_proyecto }}</th>
            <th class="proyecto">{{ $row_pry->uei }}</th>
            <th class="proyecto" style="text-align:left;">{{ $row_pry->nom_proyec }}</th>
            <th class="proyecto">{{ number_format($row_pry->m_pip,2) }}</th>
            <th class="proyecto">{{ number_format($row_pry->m_deveng_a,2) }}</th>
            <th class="proyecto">{{ number_format($row_pry->pia_dia,2) }}</th>
            @if(count($anulacion_mod) > 0)
                <th class="proyecto">{{ number_format($monto_total_anulado,2) }}</th>
            @endif
            @if(count($credito_mod) > 0)
                <th class="proyecto">{{ number_format($monto_total_credito,2) }}</th>
            @endif
            <th class="proyecto">{{ number_format(intval($row_pry->pia_dia) - $monto_total_anulado + $monto_total_credito,2) }}</th>
        </tr>
        <!-- Anulacion -->
        @if(count($anulacion_mod) > 0)
            <tr>
                <th style="border: none;"></th>
                <th class="headdetalleproyecto" colspan="7" style="font-size: 14pt;">PROYECTOS AL CUAL SE HA DADO CREDITO</th>
            </tr>
            <tr>
                <th style="border: none;"></th>
                <th class="headdetalleproyecto" rowspan="2">COD. UNIF.</th>
                <th class="headdetalleproyecto" rowspan="2">TIPO</th>
                <th class="headdetalleproyecto" rowspan="2">UEI</th>
                <th class="headdetalleproyecto" rowspan="2">NOMBRE DE PROYECTO</th>
                <th class="headdetalleproyecto">MONTO ANULADO</th>
                <th class="headdetalleproyecto" rowspan="2">FECHA</th>
                <th class="headdetalleproyecto" rowspan="2">DOCUMENTO</th>
            </tr>
            <tr>
                <th style="border: none;"></th>
                <th class="headdetalleproyecto" style="vertical-align: middle;">E</th>
            </tr>
            @foreach($anulacion_mod as $row)
                <tr>
                    <th style="border: none;"></th>
                    <td class="proyecto">{{ $row->cui_c }}</td>
                    <td class="proyecto">{{ $row->tipo_c }}</td>
                    <td class="proyecto">{{ $row->ue_c }}</td>
                    <td class="proyecto" style="text-align:left;">{{ $row->nombre_pry_c }}</td>
                    <td class="proyecto">{{ number_format($row->saldo_anu_a,2) }}</td>
                    <td class="proyecto">{{ $row->fecha_doc }}</td>
                    <td class="proyecto">{{ $row->doc_opmi }}</td>
                </tr>
            @endforeach
        @endif
        <!-- Credito -->
        @if(count($credito_mod) > 0)
            <tr>
                <th style="border: none;"></th>
                <th class="headdetalleproyecto" colspan="7" style="font-size: 14pt;">PROYECTOS AL CUAL SE HA DADO COMO ANULACION</th>
            </tr>
            <tr>
                <th style="border: none;"></th>
                <th class="headdetalleproyecto" rowspan="2">COD. UNIF.</th>
                <th class="headdetalleproyecto" rowspan="2">TIPO</th>
                <th class="headdetalleproyecto" rowspan="2">UEI</th>
                <th class="headdetalleproyecto" rowspan="2">NOMBRE DE PROYECTO</th>
                <th class="headdetalleproyecto">MONTO CREDITO</th>
                <th class="headdetalleproyecto" rowspan="2">FECHA</th>
                <th class="headdetalleproyecto" rowspan="2">DOCUMENTO</th>
            </tr>
            <tr>
                <th style="border: none;"></th>
                <th class="headdetalleproyecto" style="vertical-align: middle;">F</th>
            </tr>
            @foreach($credito_mod as $row)
                <tr>
                    <th style="border: none;"></th>
                    <td class="proyecto">{{ $row->cui_a }}</td>
                    <td class="proyecto">{{ $row->tipo_a }}</td>
                    <td class="proyecto">{{ $row->ue_a }}</td>
                    <td class="proyecto" style="text-align:left;">{{ $row->nombre_pry_a }}</td>
                    <td class="proyecto">{{ number_format($row->saldo_anu_a,2) }}</td>
                    <td class="proyecto">{{ $row->fecha_doc }}</td>
                    <td class="proyecto">{{ $row->doc_opmi }}</td>
                </tr>
            @endforeach
        @endif
        <tr>
            <td colspan="11" style="border: none;"></td>
        </tr>
    @endforeach
</table>
</html>