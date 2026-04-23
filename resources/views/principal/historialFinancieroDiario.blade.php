<style>
    .right {
        text-align: right;
        vertical-align: middle !important;
    }

    .left {
        text-align: left;
        vertical-align: middle !important;
    }

    .center {
        text-align: center;
        vertical-align: middle !important;
    }

    .justify {
        text-align: justify;
        vertical-align: middle !important;
    }

    #container {
        height: 350px;
    }

    .justificar {
        text-align: justify;
        ;
    }

    #nuevo-proyecto {
        color: white;
        text-decoration: underline;
        /* Elimina el subrayado */
    }

    #nuevo-proyecto:hover {
        color: #ece7e7;
        /* Cambia el color al pasar el mouse (opcional) */
        text-decoration: underline;
        /* Agrega subrayado al pasar el mouse (opcional) */
    }

    .modal-dialog-custom {
        width: 90%;
        /* Ancho al 90% del viewport */
        max-width: 90%;
        /* Limitar el ancho máximo */
        margin: 30px auto;
        /* Centrar el modal */
    }
</style>

<!-- TABLA -->
<link href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.dataTables.min.css" rel="stylesheet"
    type="text/css">
<link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/fixedcolumns/3.2.4/css/fixedColumns.bootstrap.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">

<div class="alert alert-danger" id="error-message" style="display: none;"></div>
<div class="col-md-12">
    <div style="text-align: center" class="row">
        @php
            $fecha = date('Y-m-d');
        @endphp
        <form method="GET" action="{{ route('finance.export') }}">
            <input type="date" name="fecha" id="fecha" value="{{ $fecha }}" min="2015-01-01"
                max="{{ $fecha }}">
            <button type="submit" class="btn btn-success">Exportar a Excel</button>
        </form>
    </div>
    <div class="row">
        <div class="table  table-responsive">
            <table id="finance-diario" class="table table-striped table table-bordered table-hover" st-sticky-header="">
                <thead style="background: #3c8dbc;color: white;">
                    <tr style="background-color:#5aa4cf;color:white;font-size:14px;" id ="finance-diario-headers1">
                    </tr>
                    <tr style="background-color:#3c8dbc;color:white;width:100%" id ="finance-diario-headers2">
                        <th width="33%" class="center">Proyecto</th>
                        <th width="8%" class="center">PIA</th>
                        <th width="8%" class="center">PIM</th>
                        <th width="8%" class="center">Certificado</th>
                        <th width="8%" class="center">Compromiso Anual</th>
                        <th width="8%" class="center">Atención de compromiso Anual</th>
                        <th width="8%" class="center">Devengado</th>
                        <th width="8%" class="center">Girado</th>
                        <th width="8%" class="center">Avance %</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <span><b>Fecha de actualización: <span id="fecha_act"></span></b></span>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

<script>
    function number_format(amount, decimals) {
        amount += ''; // por si pasan un numero en vez de un string
        amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto
        decimals = decimals || 0; // por si la variable no fue fue pasada

        if (isNaN(amount) || amount === 0)
            return parseFloat(0).toFixed(decimals);

        amount = '' + amount.toFixed(decimals);
        var amount_parts = amount.split(','),
            regexp = /(\d+)(\d{3})/;

        while (regexp.test(amount_parts[0]))
            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

        return amount_parts.join('.');
    }

    $(document).ready(function() {

        $.fn.dataTable.ext.order['nuevos-primero'] = function(settings, col) {
            return this.api()
                .rows({
                    order: 'index'
                }) // Obtén todas las filas en el orden actual
                .data() // Obtén los datos completos de las filas
                .map(function(row) {
                    return row.primera_aparicion === '1' ? 0 : 1; // Proyectos nuevos primero
                });
        };


        // Inicializar DataTable
        var table = $('#finance-diario').DataTable({
            processing: true,
            scrollY: "500px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            order: [
                [0, "asc"]
            ], // Orden inicial por la columna "Proyecto"
            ajax: {
                url: '{{ url('/principal/finance-diario') }}',
                type: 'GET',
                data: function(d) {
                    d.fecha = $('#fecha').val(); // Agregar el valor de fecha al request
                },
                dataSrc: function(json) {
                    // Manejo de encabezado dinámico y datos JSON
                    updateTableHeaders(json);
                    return json.data || [];
                },
                error: function(xhr) {
                    // Manejo de errores
                    handleAjaxError(xhr);
                    table.clear().draw(); // Limpiar tabla en caso de error
                }
            },
            columnDefs: [{
                    className: "dt-right",
                    targets: [1, 2, 3, 4, 5, 6, 7, 8]
                },
                {
                    className: "dt-justify",
                    targets: 0, // Columna "Proyecto"
                    render: function(data, type, full) {
                        // Agregar indicador visual de proyectos nuevos
                        var label = full.primera_aparicion === '1' ?
                            '<label class="label label-success">Nuevo</label>' : '';
                        return `<b>${full.cod_unif}: </b>${full.nom_proyec} ${label}`;
                    },
                    orderDataType: 'nuevos-primero' // Usar el tipo de orden personalizado
                },
                {
                    targets: [1, 2, 3, 4, 5, 6, 7, 8],
                    render: function(data, type, full, meta) {
                        // Formatear valores y mostrar cambios
                        var columnIndex = meta.col;
                        var columnName = meta.settings.aoColumns[columnIndex].data;
                        var difName = `dif_${columnName}`;
                        var cambName = `camb_${columnName}`;
                        if (full[cambName] === '1') {
                            if (full[difName] > 0) {
                                return `<span style="color:green;font-weight:bold;">+ ${number_format(full[difName], 2)}</span><br>${data}`;
                            }
                            if (full[difName] < 0) {
                                return `<span style="color:red;font-weight:bold;">- ${number_format(full[difName], 2)}</span><br>${data}`;
                            }
                        }
                        return data;
                    }
                }
            ],
            language: {
                "sProcessing": "<img src='/images/sys/pplp.gif' width='70px' height='70px'>",
                "sLengthMenu": "Mostrar _MENU_",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando _START_ al _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Vacío",
                "sInfoFiltered": "(filtrado de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                }
            },
            columns: [{
                    data: 'nom_proyec',
                    name: 'nom_proyec',
                    width: '20%'
                },
                {
                    data: 'pia_dia',
                    name: 'pia_dia',
                    width: '7%'
                },
                {
                    data: 'pim_dia',
                    name: 'pim_dia',
                    width: '7%'
                },
                {
                    data: 'certificacion_dia',
                    name: 'certificacion_dia',
                    width: '5%'
                },
                {
                    data: 'comp_anual_dia',
                    name: 'comp_anual_dia',
                    width: '8%'
                },
                {
                    data: 'ate_comp_anual_dia',
                    name: 'ate_comp_anual_dia',
                    width: '8%'
                },
                {
                    data: 'dev_dia',
                    name: 'dev_dia',
                    width: '5%'
                },
                {
                    data: 'girado_dia',
                    name: 'girado_dia',
                    width: '5%'
                },
                {
                    data: 'a_financ_dia',
                    name: 'a_financ_dia',
                    width: '5%'
                }
            ]
        });

        // Evento para recargar la tabla al cambiar la fecha
        $('#fecha').on('change', function() {
            table.ajax.reload(); // Recargar datos con el nuevo filtro
        });

        // Ajustar columnas después de la carga
        setTimeout(function() {
            table.columns.adjust();
        }, 10);

        // Función para actualizar encabezados dinámicos
        function updateTableHeaders(json) {
            var rank = json.rank ? json.rank.puesto : 'Sin datos';
            var headers = json.headers || {
                cant_proyectos: 0,
                nuevos: 0,
                pia_dia: '0.00',
                pim_dia: '0.00',
                certificacion_dia: '0.00',
                comp_anual_dia: '0.00',
                ate_comp_anual_dia: '0.00',
                dev_dia: '0.00',
                girado_dia: '0.00',
                avance_total: 0,
                fecha: 'Fecha no disponible'
            };

            var html1 = `
            <th class="center">Ranking : ${rank}<br>${headers.cant_proyectos} proyectos 
            <br>${headers.nuevos} nuevos</th>
            <th class="right">${headers.pia_dia}</th>
            <th class="right">${headers.pim_dia}</th>
            <th class="right">${headers.certificacion_dia}</th>
            <th class="right">${headers.comp_anual_dia}</th>
            <th class="right">${headers.ate_comp_anual_dia}</th>
            <th class="right">${headers.dev_dia}</th>
            <th class="right">${headers.girado_dia}</th>
            <th class="right">${parseFloat(headers.avance_total).toFixed(2)} %</th>
        `;
            $("#finance-diario-headers1").html(html1);
            $("#fecha_act").html(headers.fecha);
        }

        // Manejo de errores en la solicitud AJAX
        function handleAjaxError(xhr) {
            let errorMessage = "Ocurrió un error al cargar los datos. Inténtelo de nuevo.";
            if (xhr.status === 404) {
                errorMessage = "No se encontró la información solicitada.";
            } else if (xhr.status === 500) {
                errorMessage = "Error interno del servidor. Por favor, contacte al soporte.";
            }
            $('#error-message').text(errorMessage).show();
        }

        $('#finance-diario-headers2').on('click', 'th', function() {
            var colIndex = $(this).index(); // Índice de la columna clickeada
            var colName = table.settings().init().columns[colIndex]?.name; // Nombre de la columna

            if (!colName) {
                console.log('Columna no configurada');
                return;
            }

            // console.log(`Clic en columna: ${colName}`);

            // Separar la lógica para "Proyectos Nuevos"
            if (colName === 'nom_proyec') {
                handleProjectOrder(colIndex); // Orden específico para proyectos nuevos
            } else if (['pia_dia', 'pim_dia', 'certificacion_dia', 'comp_anual_dia',
                    'ate_comp_anual_dia', 'dev_dia', 'girado_dia', 'a_financ_dia'
                ].includes(colName)) {
                handleNumericOrder(colIndex); // Orden específico para columnas numéricas
            } else {
                console.log('Columna no manejada');
            }
        });

        // Función para manejar el orden de "Proyectos Nuevos"
        function handleProjectOrder(colIndex) {
            var currentOrder = table.order();
            var isSameColumn = currentOrder.length > 0 && currentOrder[0][0] === colIndex;
            var nextOrderDir = isSameColumn && currentOrder[0][1] === 'desc' ? 'asc' : 'desc';
            table.order([colIndex, nextOrderDir]).draw();
        }

        // Función para manejar el orden de columnas numéricas
        function handleNumericOrder(colIndex) {
            var currentOrder = table.order();
            var isSameColumn = currentOrder.length > 0 && currentOrder[0][0] === colIndex;
            var nextOrderDir = isSameColumn && currentOrder[0][1] === 'asc' ? 'desc' : 'asc';
            table.order([colIndex, nextOrderDir]).draw();
        }


    });
</script>
<!-- Fin tabla  -->
