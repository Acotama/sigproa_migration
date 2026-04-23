<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style>

        </style>
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
        <tr class="rowHeader">
            <td class="md">Nombre Proyecto</td>
            <td class="xs">Snip</td>
            <td class="xs">Unificado</td>
            
            <td class="sm">Gerencia/Dirección</td>
            <td class="sm">Tipo</td>
            <td class="sm">Etapa</td>
            <td class="sm">Sub Etapa</td>
            <td class="lg">Avance Fisico</td>
            <td class="lg">Descripción de estado</td>
            <td class="xs">Fecha de actualización de estado</td>
            <td class="lg">Imagen Durante</td>
            <td class="lg">Imagen Despues</td>
        </tr>

    @foreach($data as $row)
        <tr class="rowContent">
			<td class="left">
				{{ $row->nom_proyec }}
			</td>
			<td class="center">
				{{ $row->cod_snip }}
			</td>
			<td class="center">
				{{ $row->cod_unif }}
			</td>			
			<td class="center">
				{{ $row->ger_direc }}
			</td>
            <td class="center">
                {{ $row->tipo_pry }}
            </td>
            <td class="center">
                {{ $row->etapa }}
            </td>
			<td class="center">
				{{ $row->sub_etapa }}
			</td>
            <td class="center">
                {{ $row->a_fisico }}
            </td>
			<td class="center">
				{{ $row->situa_pro }}
			</td>
			<td class="center">
				{{ $row->f_etapsub }}
			</td>
			<td class="center">
				{{ $row->ffoto_durante }}
			</td>
			<td class="center">
				{{ $row->ffoto_despues }}
			</td>
          
        </tr>
        @endforeach

</table>
</html>
