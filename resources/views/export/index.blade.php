@extends('starter')
@section('htmlhead')
    <!-- JqueryUI -->
    <link rel="stylesheet" href="{{ asset('librerias/jquery-ui/themes/redmond/jquery-ui.min.css') }}">
    <!-- DROPZONE -->
    <link rel="stylesheet" href="{{ asset('librerias/dropzone/dropzone.min.css') }}">

    <link href="{{ asset('plugins/multiselect/css/multi-select.css') }}" media="screen" rel="stylesheet" type="text/css">
    <script src="{{ asset('plugins/multiselect/js/jquery.multi-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/quicksearch/jquery.quicksearch.js') }}" type="text/javascript"></script>
    <style>
        .dt-button {
            background-color: red !important;
        }

        .buttons-print {
            background-image: linear-gradient(to bottom, #e9e9e9 0%, #e9e9e9 100%) !important;
            color: black !important;
        }

        .buttons-excel {
            background-image: linear-gradient(to bottom, #e9e9e9 0%, #e9e9e9 100%) !important;
            background-color: blue !important;
            color: black !important;
        }

        .dtcolunm-search {
            padding: 0 !important;
            background-color: #f8fff9;
        }

        .table-stripedd>tbody>tr:nth-child(odd)>td,
        .table-stripedd>tbody>tr:nth-child(odd)>th {
            background-color: rgb(181, 212, 230);
        }

        .table-hoverr tbody tr:hover td,
        .table-hoverr tbody tr:hover th {
            background-color: rgba(38, 255, 47, 0.11);
        }

        .custon {
            width: 300px;
        }

        #grl_pip_total_priori-table thead tr th {
            text-align: center;
            vertical-align: middle;
        }

        .sortable {
            list-style-type: none;
            margin: 0;
            padding: 0;
            width: 100%;
            font-size: 9px
        }

        .sortable li {
            margin: 0 3px 3px 3px;
            padding: 0.4em;
            padding-left: 1.5em;
            font-size: 1.4em;
            height: 40px;
        }

        .sortable li span {
            position: absolute;
            margin-left: -1.3em;
        }
    </style>
@endsection
@section('body')

    <div class="col-md-12 main text-center">
        <h3> Exportar </h3>
        <br>
        <div class="row">
            <!--<form action="/exportar/piptotalpriori/">
                    <button class="btn btn-block btn-primary btn-flat">Proyectos de Inversión <i class="fa fa-file"></i></button>
                </form>-->
            <!--<form action="/exportar/piptotalpriori_obras/">
                    <button class="btn btn-block btn-primary btn-flat">Proyectos de Inversión con estado<i class="fa fa-file"></i></button>
                </form>-->
            {{-- <form action="{{ asset('/exportar/piptotalpriori_obras_reporte/') }}">
                <button class="btn btn-block btn-primary btn-flat">RESUMEN PROYECTOS CON OBRAS/ACTIVIDADES<i
                        class="fa fa-file"></i></button>
            </form>

            <form action="{{ asset('/exportar/piptotalpriori_priorizados/') }}">
                <button class="btn btn-block btn-primary btn-flat">RESUMEN PROYECTOS PRIORIZADOS ACTUALIZADOS<i
                        class="fa fa-file"></i></button>
            </form>

            <form action="{{ asset('/exportar/procompite') }}">
                <button class="btn btn-block btn-primary btn-flat">PROCOMPITE <i class="fa fa-file"></i></button>
            </form>
            <form action="{{ asset('/exportar/canales') }}">
                <button class="btn btn-block btn-primary btn-flat">MANTENIMIENTO DE CANALES<i
                        class="fa fa-file"></i></button>
            </form>
            <form action="{{ asset('/exportar/vias') }}">
                <button class="btn btn-block btn-primary btn-flat">MANTENIMIENTODE DE VIAS<i
                        class="fa fa-file"></i></button>
            </form> --}}
            <form action="{{ asset('/exportar_proyecto') }}">
                <div
                    style="display: flex; justify-content: center;height:50px;align-items: center; background-color: #3c8dbc;margin-top: 2px;">
                    <div>
                        <span style="font-weight: bold;color: white;padding-right: 4px">PROYECTOS
                            :</span>
                    </div>
                    <div style="padding-right: 4px">
                        <select name="anio" required>
                            <option value="2025" selected>2025</option>
                            <option value="2024">2024</option>
                        </select>
                    </div>
                    <div style="padding-right: 4px">
                        <select name="filtro" required>
                            <option value="ger_direc" selected>UEI</option>
                            <option value="nom_prov">PROVINCIA</option>
                            <option value="sector">SECTOR</option>
                        </select>
                    </div>
                    <div>
                        <button class="btn btn-block btn-success btn-flat"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
            <form action="{{ asset('/exportar_pmi') }}">
                <div
                    style="display: flex; justify-content: center;height:50px;align-items: center; background-color: #3c8dbc;margin-top: 2px;">
                    <div>
                        <span style="font-weight: bold;color: white;padding-right: 4px">CARTERA PMI {{ date('Y') }}
                            :</span>
                    </div>
                    <div style="padding-right: 4px">
                        <select name="filtro" required>
                            <option value="ger_direc" selected>UEI</option>
                            <option value="nom_prov">PROVINCIA</option>
                            <option value="funcion">SECTOR</option>
                        </select>
                    </div>
                    <div>
                        <button class="btn btn-block btn-success btn-flat"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
            <form action="{{ asset('/exportar_proyecto_ff') }}">
                <button class="btn btn-block btn-primary btn-flat"
                    style="font-weight: bold;color: white;padding-right: 4px">INVERSIONES POR FUENTE DE FINANCIAMIENTO <i
                        class="fa fa-download"></i></button>
            </form>
            <form action="{{ asset('/reporte_diario') }}">
                <button class="btn btn-block btn-primary btn-flat"
                    style="font-weight: bold;color: white;padding-right: 4px">REPORTE DIARIO <i
                        class="fa fa-download"></i></button>
            </form>
            {{-- <form action="{{asset('/reporte_diario_f12')}}">
                <button class="btn btn-block btn-primary btn-flat" style="font-weight: bold;color: white;padding-right: 4px">REPORTE DIARIO FORMATO 12-B <i class="fa fa-download"></i></button>
            </form> --}}
            {{-- <form action="{{asset('/reporte_prueba')}}">
                <button class="btn btn-block btn-primary btn-flat" style="font-weight: bold;color: white;padding-right: 4px">REPORTE PRUEBA <i class="fa fa-download"></i></button>
            </form> --}}
            @php
                $mes_actual = date('n'); // Número del mes actual
            @endphp

            @if ($mes_actual != 1)
                {{-- Si no es enero, muestra el formulario --}}
                <form action="{{ asset('/reporte_fin_mes') }}" method="GET">
                    <div
                        style="display: flex; justify-content: center; height: 50px; align-items: center; background-color: #3c8dbc; margin-top: 2px;">
                        <div>
                            <span style="font-weight: bold; color: white; padding-right: 4px;">REPORTE DE CIERRE DE MES
                                {{ date('Y') }} :</span>
                        </div>
                        <div style="padding-right: 4px;">
                            <select name="mes" id="mes" class="form-select" style="width: 150px;">
                                @php
                                    $meses = [
                                        1 => 'Enero',
                                        2 => 'Febrero',
                                        3 => 'Marzo',
                                        4 => 'Abril',
                                        5 => 'Mayo',
                                        6 => 'Junio',
                                        7 => 'Julio',
                                        8 => 'Agosto',
                                        9 => 'Septiembre',
                                        10 => 'Octubre',
                                        11 => 'Noviembre',
                                        12 => 'Diciembre',
                                    ];
                                    $currentYear = date('Y'); // Año actual
                                @endphp
                                @foreach ($meses as $numero => $nombre)
                                    @if ($numero < $mes_actual)
                                        <option value="{{ $numero }}">{{ $nombre }} {{ $currentYear }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button class="btn btn-block btn-success btn-flat"><i class="fa fa-download"></i></button>
                        </div>
                    </div>
                </form>
            @endif


        </div>
    </div>


@endsection

@section('script')
@endsection
