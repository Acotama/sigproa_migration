<span class="cabecera">
    <h3 class="text-center"><b>{{ $filtro }}</b></h3>
    <h4 class="text-center"><b>(PROYECTOS DEVENGADOS)</b></h4>
</span>

<div id="container">

    <div class="modal-body">
        <div class="tab-pane" id="tab_4">
            <div class="col-md-12" style="margin-top: 15px;">
                <div class="row">
                    <table class="table table-bordered " id="proyecto" width="100%" cellspacing="0"
                        class="form-control">
                        <thead>
                            <tr>
                                <th class="text-center" style="vertical-align: middle">PROYECTOS</th>
                                <th class="text-center" style="vertical-align: middle">MONTO INV. ACT.</th>
                                <th class="text-center" style="vertical-align: middle">DEVEN. ACUM. ACT.</th>
                                <th class="text-center" style="vertical-align: middle">AVANCE. ACUM. ACT.</th>
                                <th class="text-center" style="vertical-align: middle">PIM {{ $anio }}</th>
                                <th class="text-center" style="vertical-align: middle">CERTIF {{ $anio }}</th>
                                <th class="text-center" style="vertical-align: middle">DEVENGADO {{ $anio }}
                                </th>
                                <th class="text-center hidden" style="vertical-align: middle">DEVENGADO
                                    {{ strtoupper(date('M')) }}</th>
                                <th class="text-center " style="vertical-align: middle">DEVENGADO
                                    {{ strtoupper(date('M')) }}</th>
                                <th class="text-center " style="vertical-align: middle">META MEF
                                    {{ strtoupper(date('M')) }}</th>
                                <th class="text-center" style="vertical-align: middle">AVANCE {{ $anio }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $gob_reg)
                                @php
                                    $anio_actual = date('Y');
                                    $mes_actual = date('n');

                                    $ajuste = 0;

                                    if ($anio_actual == 2026) {
                                        if ($mes_actual == 1) {
                                            if ($gob_reg->cod_unif == 2482109) {
                                                $ajuste = -1910523;
                                            } elseif ($gob_reg->cod_unif == 2647878) {
                                                $ajuste = -823375;
                                            }
                                        } elseif ($mes_actual == 2) {
                                            if ($gob_reg->cod_unif == 2482109) {
                                                $ajuste = 1910523;
                                            } elseif ($gob_reg->cod_unif == 2647878) {
                                                $ajuste = 823375;
                                            }
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td style='text-align:center;vertical-align: middle'>{{ $gob_reg->cod_unif }} :
                                        {{ $gob_reg->nom_proyec }}</td>
                                    <td style='text-align:center;vertical-align: middle'>
                                        {{ number_format($gob_reg->m_pip, 0, '.', ',') }}</td>
                                    <td style='text-align:center;vertical-align: middle'>
                                        {{ number_format($gob_reg->m_deveng_a, 0, '.', ',') }}</td>
                                    @if ($gob_reg->m_pip == 0)
                                        <td style='text-align:center;vertical-align: middle'>0.00%</td>
                                    @else
                                        <td style='text-align:center;vertical-align: middle'>
                                            {{ number_format(($gob_reg->m_deveng_a / $gob_reg->m_pip) * 100, 2, '.', ',') }}%
                                        </td>
                                    @endif
                                    <td style='text-align:center;vertical-align: middle'>
                                        {{ number_format($gob_reg->pim_dia, 0, '.', ',') }}</td>
                                    <td style='text-align:center;vertical-align: middle'>
                                        {{ number_format($gob_reg->certificacion_dia, 0, '.', ',') }}</td>
                                    <td class='text-center' style='vertical-align:middle;'>
                                        {{ number_format($gob_reg->dev_dia, 0, '.', ',') }}</td>
                                    <th class='text-center hidden' style='vertical-align:middle;'>
                                        {{ number_format($gob_reg->dev_mensual, 0, '.', ',') }}</th>
                                    @if ($gob_reg->dif_dev_dia > 0)
                                        <td class='text-center seleccion' style='vertical-align:middle;'><span
                                                style='color:green;font-weight:bold;'>+
                                                {{ number_format(abs($gob_reg->dif_dev_dia), 0, '.', ',') }}</span><br>{{ number_format($gob_reg->dev_mensual, 0, '.', ',') }}
                                        </td>
                                    @elseif($gob_reg->dif_dev_dia < 0)
                                        <td class='text-center seleccion' style='vertical-align:middle;'><span
                                                style='color:red;font-weight:bold;'>-
                                                {{ number_format(abs($gob_reg->dif_dev_dia), 0, '.', ',') }}</span><br>{{ number_format($gob_reg->dev_mensual, 0, '.', ',') }}
                                        </td>
                                    @else
                                        <td class='text-center seleccion' style='vertical-align:middle;'>
                                            {{ number_format($gob_reg->dev_mensual + $ajuste, 0, '.', ',') }}
                                        </td>
                                    @endif
                                    <th class='text-center' style='vertical-align:middle;'>
                                        {{ number_format($gob_reg->meta_mensual, 0, '.', ',') }}</th>
                                    @if ($gob_reg->pim_dia == 0)
                                        <td style='text-align:center;vertical-align: middle'>0%</td>
                                    @else
                                        <td style='text-align:center;vertical-align: middle'>
                                            {{ number_format(($gob_reg->dev_dia / $gob_reg->pim_dia) * 100, 2, '.', ',') }}%
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            @foreach ($Headers as $Headers)
                                @php
                                    $anio_actual = date('Y');
                                    $mes_actual = date('n');

                                    $ajuste = 0;

                                    if ($anio_actual == 2026) {
                                        if ($mes_actual == 1) {
                                            if ($filtro == 'GERENCIA REGIONAL DE INFRAESTRUCTURA') {
                                                $ajuste = -1910523;
                                            } elseif ($filtro == 'DIRECCION REGIONAL DE AGRICULTURA') {
                                                $ajuste = -823375;
                                            }
                                        } elseif ($mes_actual == 2) {
                                            if ($filtro == 'GERENCIA REGIONAL DE INFRAESTRUCTURA') {
                                                $ajuste = 1910523;
                                            } elseif ($filtro == 'DIRECCION REGIONAL DE AGRICULTURA') {
                                                $ajuste = 823375;
                                            }
                                        }
                                    }
                                @endphp
                                <tr style="background-color:#3c8dbc9c">
                                    <th style='text-align:center;vertical-align: middle'>TOTAL:
                                        [{{ $Headers->cantidad }}]</th>
                                    <th style='text-align:center;vertical-align: middle'>
                                        {{ number_format($Headers->m_pip, 0, '.', ',') }}</th>
                                    <th style='text-align:center;vertical-align: middle'>
                                        {{ number_format($Headers->m_deveng_a, 0, '.', ',') }}</th>
                                    @if ($Headers->m_pip == 0)
                                        <th style='text-align:center;vertical-align: middle'>0.00%</th>
                                    @else
                                        <th style='text-align:center;vertical-align: middle'>
                                            {{ round(($Headers->m_deveng_a / $Headers->m_pip) * 100, 2) }}%</th>
                                    @endif
                                    <th style='text-align:center;vertical-align: middle'>
                                        {{ number_format($Headers->pim_dia, 0, '.', ',') }}</th>
                                    <th style='text-align:center;vertical-align: middle'>
                                        {{ number_format($Headers->certificacion_dia, 0, '.', ',') }}</th>
                                    <th class='text-center' style='vertical-align:middle;'>
                                        {{ number_format($Headers->dev_dia, 0, '.', ',') }}</th>
                                    <th class='text-center hidden' style='vertical-align:middle;'>
                                        {{ number_format($Headers->dev_mensual , 0, '.', ',') }}</th>
                                    @if ($Headers->dif_dev_dia > 0)
                                        <td class='text-center seleccion' style='vertical-align:middle;'><span
                                                style='color:green;font-weight:bold;'>+
                                                {{ number_format(abs($Headers->dif_dev_dia), 0, '.', ',') }}</span><br>{{ number_format($Headers->dev_mensual, 0, '.', ',') }}
                                        </td>
                                    @elseif($Headers->dif_dev_dia < 0)
                                        <td class='text-center seleccion' style='vertical-align:middle;'><span
                                                style='color:red;font-weight:bold;'>-
                                                {{ number_format(abs($Headers->dif_dev_dia), 0, '.', ',') }}</span><br>{{ number_format($Headers->dev_mensual, 0, '.', ',') }}
                                        </td>
                                    @else
                                        <td class='text-center seleccion' style='vertical-align:middle;'>
                                            {{ number_format($Headers->dev_mensual + $ajuste, 0, '.', ',') }}</td>
                                    @endif
                                    <th class='text-center' style='vertical-align:middle;'>
                                        {{ number_format($Headers->meta_mensual, 0, '.', ',') }}</th>
                                    @if ($Headers->pim_dia == 0)
                                        <th style='text-align:center;vertical-align: middle'>0.00%</th>
                                    @else
                                        <th style='text-align:center;vertical-align: middle'>
                                            {{ number_format(($Headers->dev_dia / $Headers->pim_dia) * 100, 2, '.', ',') }}%
                                        </th>
                                    @endif
                                </tr>
                            @endforeach
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="pie">
    <script type="text/javascript">
        $(function() {

            tabla = function(id, orden, panel, titulo, columnas) {
                var oTable = $(id).DataTable({
                    processing: true,
                    dom: 'B<"clear">lfrtip',
                    buttons: {
                        orientation: 'landscape',
                        color: '#008d4c',
                        buttons: [{
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o"> Exportar Excel</i>',
                            titleAttr: 'Excel',
                            autoFilter: false,
                            sheetName: panel,
                            title: titulo,
                            exportOptions: {
                                columns: columnas
                            },
                        }]
                    },
                    bSort: true,
                    bInfo: true,
                    bAutoWidth: true,
                    responsive: true,
                    scrollY: '350px',
                    scrollCollapse: true,
                    paging: false,
                    order: orden,
                    language: {
                        "sLengthMenu": "Mostrar _MENU_",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "_START_ al _END_ de _TOTAL_ Registros",
                        "sInfoEmpty": "Vacio",
                        "sInfoFiltered": "(filtrado de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sSearch": "Buscar:",
                        "sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
                        "processing": "Cargando...",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": ">",
                            "sPrevious": "<"
                        },
                        "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    }
                });
                oTable.buttons().container()
                    .appendTo($('.col-sm-6:eq(0)', oTable.table().container()));
                setTimeout(function() {
                    $($.fn.dataTable.tables(true)).DataTable().columns.adjust().draw();
                }, 200);
            }

            tabla("#proyecto", [], "PROYECTOS", "{{ $filtro }}-PROYECTOS", [0, 1, 2, 3, 4, 5, 6, 7, 9, 10]);

        });
    </script>
</div>
