<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style>

        </style>
    </head>
        <tr class="rowHeader">
            <td class="xs" colspan="6">General</td>
        </tr>
        <tr class="rowHeader">
            <td class="xxs">ID</td>
            <td class="md">Nombre Proyecto</td>
            <td class="xs">Snip</td>
            <td class="xs">Unificado</td>
            <td class="xs">Provincia</td>
            <td class="xs">Código Provincia</td>
            <td class="sm">Unidad Formuladora</td>
            <td class="sm">Unidad Ejecutora</td>
            <td class="sm">Gerencia/Dirección</td>
            <td class="sm">Tipo</td>
            <td class="sm">Año PIC</td>
            <td class="sm">Sector</td>
            <td class="sm">Programa</td>
            <td class="sm">Subprograma</td>
            <td class="xs">Monto PIP</td>
            <td class="xs">Monto Viable</td>
            <td class="xs">Monto del Expediente Técnico</td>

            <td class="xs">Monto PIM</td>
            <td class="xs">Monto PIM Acumulado Gob. Reg</td>
            <td class="xs">Monto PIM Acumulado Total</td>
            <td class="xs">Monto Devengado</td>
            <td class="xs">Monto Devengado Acumulado Gob. Reg</td>
            <td class="xs">Monto Devengado Acumulado Total</td>
            <td class="xs">Avance Financiero Proyecto Gob. Reg</td>
            <td class="xs">Avance Financiero Proyecto Total</td>
            <td class="xs">Fecha de Actualización Financiera</td>

            <td class="xs">Estado del Proyecto</td>
            <td class="sm">Etapa</td>
            <td class="sm">Sub Etapa</td>
            <td class="lg">Descripción de estado</td>
            <td class="xs">Fecha de actualización de estado</td>
            <td class="lg">Contrataciones</td>
        </tr>

    @foreach($data as $row)
        <tr class="rowContent">
			<td class="center">
				{{ $row->id }}
			</td>
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
				{{ $row->nom_prov }}
			</td>
			<td class="center">
				{{ $row->cod_prov }}
			</td>
			<td class="center">
				{{ $row->u_formul }}
			</td>
			<td class="center">
				{{ $row->u_ejec }}
			</td>
			<td class="center">
				{{ $row->ger_direc }}
			</td>
            <td class="center">
                {{ $row->tipo_pry }}
            </td>
            <td class="center">
                {{ $row->anio_pic }}
            </td>
			<td class="center">
				{{ $row->sector }}
			</td>
			<td class="center">
				{{ $row->progr }}
			</td>
            <td class="center">
                {{ $row->sub_progr }}
            </td>
            <!-- FINANCIERA -->
            <td class="right">
                {{ $row->m_pip }}
            </td>
			<td class="right">
                {{ $row->m_viab }}
            </td>
            <td class="right">
                {{ $row->m_exptec }}
            </td>
            <td class="right">
                {{ $row->m_pim }}
            </td>
            <td class="right">
                {{ $row->m_pim_acu }}
            </td>
            <td class="right">
                {{ $row->m_pim_a_todas_ue }}
            </td>
            <td class="right">
                {{ $row->m_deveng }}
            </td>
            <td class="right">
                {{ $row->m_deveng_a }}
            </td>
            <td class="right">
                {{ $row->m_deveng_a_todas_ue }}
            </td>
            <td class="right">
                {{ $row->a_financ }}
            </td>
            <td class="right">
                {{ $row->a_financ_a }}
            </td>
            <td class="right">
                {{ $row->f_deveng_a }}
            </td>
            <!-- FINANCIERA #end -->
            <td class="center">
                {{ $row->est_pry }}
            </td>
            <td class="center">
                {{ $row->etapa }}
            </td>
            <td class="center">
                {{ $row->sub_etapa }}
            </td>
            <td class="justify">
                <?php
                    foreach ($row->obras as $obra) {
                        echo $obra['nom_meta'] .': ';
                        echo $obra['estado']['etapa'] .' - ';
                        echo $obra['estado']['sub_etapa'].' ';
                        echo $obra['estado']['fecha_act'].', ';
                        echo $obra['estado']['est_situ'];
                        echo ' || ';
                    }
                ?>
            </td>
            <td class="center">
                {{ $row->f_etapsub }}
            </td>

            <td class="justify">
                <?php
                    foreach ($row->contrataciones as $contrato) {
                        echo $contrato->contrato_nro. ': ';
                        echo $contrato->contrato_fecha . ' - ';
                        echo $contrato->contrato_moneda.' '.$contrato->contrato_monto .', ';
                        echo $contrato->tipo_proceso.', ';
                        echo $contrato->descripcion;
                        echo ' || ';
                    }
                ?>
            </td>
        </tr>
        @endforeach

</html>
