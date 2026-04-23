<!DOCTYPE html>
<html>

    <head>
      <meta charset="UTF-8">
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
    </head>
<body>
        <!--<tr>
            <td colspan="4">
                <img src="images/sys/logo1.gif" height="100%">
            </td>
            <td colspan="4">
                <img src="images/sys/sayhuite.png" height="100%">
            </td>
            <td colspan="4">
                <img src="images/sys/slogan2.gif" height="100%">
            </td>
        </tr-->
<table>
        <tr id="header">
            <td class="header" width="95">Identificador</td>
            <td class="header" width="250">Nombre</td>
            <td class="header" width="150">Provincia</td>
            <td class="header" width="150">Distrito</td>
            <td class="header" width="95">Monto Ejecutado</td>
            <td class="header" width="95">Meta Programada Año</td>
            <td class="header" width="95">Meta Ejecutada Año</td>
            <td class="header" width="95">Meta por Ejecutar Año</td>
            <td class="header" width="95">Avance de Ejecución Año</td>
            <td class="header" width="95">Meta Programada Total</td>
            <td class="header" width="95">Meta Ejecutada Total</td>
            <td class="header" width="95">Meta por Ejecutar Total</td>
            <td class="header" width="95">Avance de Ejecución Total</td>
            <td class="header" width="95">Beneficiarios</td>
            <td class="header" width="120">Estado</td>
            <td class="header" width="95">Hectareas Bajo Riego</td>
            <td class="header" width="120">Cemento Entregado</td>
            <td class="header" width="95">Año</td>
            <td class="header" width="95">Fotografía</td>
            <td class="header" width="95">Convenio/Expediente (PDF)</td>            
            <td class="header" width="95">Latitud</td>
            <td class="header" width="95">Longitud</td>
        </tr>

        @foreach($data as $row)
        <tr>
            <td class="center">{{ $row->id }}</td>
            <td class="left">{{ $row->nombre }}</td>
            <td class="center">{{ $row->nom_prov }}</td>
            <td class="center">{{ $row->nom_dist }}</td>
            <td class="right">{{ $row->monto_ejec }}</td>
            <!-- META AÑO -->
            <td class="right">{{ $row->meta_programada }}</td>
            <td class="right">{{ $row->meta_ejec }}</td>
            <td class="right">{{ $row->meta_porejec }}</td>
            <td class="right">{{ $row->avance_ejec }}</td>
            <!-- META TOTAL -->
            <td class="right">{{ $row->meta_progtotal }}</td>
            <td class="right">{{ $row->meta_ejectotal }}</td>
            <td class="right">{{ $row->meta_porejectotal }}</td>
            <td class="right">{{ $row->avance_ejec_total }}</td>

            <td class="right">{{ $row->beneficiarios }}</td>
            <td class="center">{{ $row->estado }}</td>
            <td class="right">{{ $row->hect_riego }}</td>
            <td class="right">{{ $row->cemento_entreg }}</td>
            <td class="center">{{ $row->anio }}</td>
            @if($row->ffoto != '')
            <td class="center" style="background-color: #3bcc44">{{ $row->ffoto }}</td>
            @else
            <td class="center" style="background-color:#f4f442;">Pendiente</td>
            @endif
            @if($row->nro_conv != '')
            <td class="center" style="background-color: #3bcc44">{{ $row->nro_conv }}</td>
            @else
            <td class="center" style="background-color:#f4f442;">Pendiente</td>
            @endif
            <td class="center">{{ $row->latitud }}</td>
            <td class="center">{{ $row->longitud }}</td>
        </tr>
        @endforeach
</table>

</body>
</html>
