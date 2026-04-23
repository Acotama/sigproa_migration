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

        </style>

        <tr id="header">
            <td class="header" width="90">Identificador</td>
            <td class="header" width="250">Nombre Proyecto</td>
            <td class="header" width="160">Agente Economico Organizado</td>
            <td class="header" width="90">C. Unificado</td>
            <td class="header" width="100">Provincia</td>
            <td class="header" width="100">Distrito</td>
            <td class="header" width="100">Centro Poblado</td>
            <td class="header" width="90">Co-Financiamiento GRL</td>
            <td class="header" width="90">Contrapartida (AEO)</td>
            <td class="header" width="90">Monto Total Plan Negocio</td>
            <td class="header" width="90">Beneficiarios</td>
            <td class="header" width="90">Fecha de Adjudicación</td>
            <td class="header" width="90">Fecha Inicio</td>
            <td class="header" width="90">Fecha Fin</td>
            <td class="header" width="90">Tiempo ejecucion (días)</td>
            <td class="header" width="90">% Avance Físico</td>
            <!--<td>Cuenta con R.E.R</td>-->
            <!--<td>Fecha de R.E.R</td>-->
            <td class="header" width="90">Estado</td>
            <td class="header" width="90">Descripción</td>
            <td class="header" width="90">Fecha Estado</td>
            <td class="header" width="90">Año</td>
            <td class="header" width="90">Convenio (PDF)</td>
            <td class="header" width="90">Fotografía</td>
        </tr>

        @foreach($data as $row)
        <tr>
            <td class="center">{{ $row->id }}</td>
            <td class="center">{{ $row->nom_proyec }}</td>
            <td class="center">{{ $row->aeo }}</td>
            <td class="center">{{ $row->cod_unif }}</td>
            <td class="center">{{ $row->nom_prov }}</td>
            <td class="center">{{ $row->nom_dist }}</td>
            <td class="center">{{ $row->nom_cp }}</td>
            <td class="right">{{ $row->m_pip }}</td>
            <td class="right">{{ $row->contrapartida }}</td>
            <td class="right">{{ $row->m_pip + $row->contrapartida }}</td>
            <td class="right">{{ $row->beneficiarios }}</td>
            <td class="center">{{ $row->f_adjudica }}</td>
            <td class="center">{{ $row->f_inicio_obra }}</td>
            <td class="center">{{ $row->f_fin_obra }}</td>
            <td class="center">{{ $row->t_ejec_dia }}</td>
            <td class="center">{{ $row->a_fisico }}</td>
            <td class="center">{{ $row->est_proyec}}</td>
            <td class="center">{{ $row->situa_pro}}</td>
            <td class="center">{{ $row->fecha_situa}}</td>
            <td class="center">{{ $row->anio}}</td>
            @if( $row->nro_conv != '' )
            <td class="center">{{ $row->nro_conv}}</td>
            @else
            <td class="center" style="background-color:#f4f442;">Pendiente</td>
            @endif
            @if( $row->ffoto != '' )
            <td class="center" style="background-color:#3bcc44;">{{ $row->ffoto }}</td>
            @else
            <td class="center" style="background-color:#f4f442;">Pendiente</td>
            @endif
        </tr>
        @endforeach
</table>
</html>
