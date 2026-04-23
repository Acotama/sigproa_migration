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
            <td class="header" width="100">Código Mantenimiento</td>
            <td class="header" width="250">Nombre</td>
            <td class="header" width="120">Código de Ruta</td>
            <td class="header" width="120">Año de Ejecución</td>
            <td class="header" width="100">Provincia</td>
            <td class="header" width="100">Distrito</td>
            <td class="header" width="200">Tipo Actividad</td>
            <td class="header" width="200">Tipo Mantenimiento</td>
            <td class="header" width="100">Meta Física Programada</td>
            <td class="header" width="100">Ejecución Física</td>
            <td class="header" width="100">Unidad de Medida</td>
            <td class="header" width="100">Avance Físico</td>
            <td class="header" width="100">Meta Financiera Programada</td>
            <td class="header" width="100">Devengado Financiero</td>
            <td class="header" width="100">Avance Financiero</td>
            <td class="header" width="100">Estado</td>
            <td class="header" width="100">Estado Actualizado al</td>
            <td class="header" width="100">Modalidad de Ejecución</td>
            <td class="header" width="100">Beneficiarios</td>
            <td class="header" width="100">Foto Antes</td>
            <td class="header" width="100">Foto Despues</td>
          </tr>

        @foreach($data as $row)
        <tr>
            <td class="center">{{ $row->id }}</td>
            <td class="left">{{ $row->activ }}</td>
            <td class="center">{{ $row->cod_ruta }}</td>
            <td class="center">{{ $row->anio }}</td>
            <td class="center">{{ $row->prov }}</td>
            <td class="center">{{ $row->dist }}</td>

            <td class="center">{{ $row->tip_activ }}</td>
            <td class="center">{{ $row->tip_mant }}</td>
            <td class="right">{{ $row->mfis_pro }}</td>
            <td class="right">{{ $row->ejec_fisico }}</td>

            <td class="center">{{ $row->u_medida }}</td>
            <td class="right">{{ $row->av_fisico }}</td>
            <td class="right">{{ $row->mfin_pro }}</td>
            <td class="right">{{ $row->deven_finan }}</td>
            <td class="right">{{ $row->av_finan }}</td>

            <td class="center">{{ $row->est }}</td>
            <td class="center">{{ $row->f_estado }}</td>
            <td class="center">{{ $row->mod_ejec }}</td>
            <td class="right">{{ $row->n_benef }}</td>
            @if($row->ffoto_antes != '')
            <td class="center" style="background-color:#3bcc44;">{{ $row->ffoto_antes }}</td>
            @else
            <td class="center" style="background-color:#FFC7CE;">Pendiente</td>
            @endif
            @if($row->ffoto_despues != '')
            <td class="center" style="background-color:#3bcc44;">{{ $row->ffoto_despues }}</td>
            @else
            <td class="center" style="background-color:#FFC7CE;">Pendiente</td>
            @endif
        </tr>
        @endforeach
</table>

</body>
</html>
