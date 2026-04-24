@extends('starter')
@section('htmlhead')
    <!-- D3 JS -->
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"  rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css"  rel="stylesheet" type="text/css">
    <link href="{{ asset('tooltip/css/tooltipster.bundle.min.css') }}" rel="stylesheet" type="text/css"/>

    <style type="text/css">
        .form-control.is-invalid, .was-validated .form-control:invalid {
            border-color: #dc3545;
            padding-right: 2.25rem!important;
        }

        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            /* font-size: 80%; */
            color: #dc3545;
        }
        #proyectos_modificados.table.table-bordered{
            border:1px solid black;
            margin-top:20px;
        }
        #proyectos_modificados.table.table-bordered > tbody > tr > th{
            border:1px solid black;
        }
        #proyectos_modificados.table.table-bordered > tbody > tr > td{
            border:1px solid black;
        }

        .vcenter {
            vertical-align: middle !important;
        }

        /*Si el valor que el usuario escribe es valido, obtendra un color verde*/
        tr td input[type="text"]:required:valid{
            border:2px solid green;
        /* otras propiedades */
        }
        /*caso contrario, el color sera rojo*/
        tr td input[type="text"]:focus:required:invalid{
            border:2px solid red;
        /* otras propiedades */
        }
    
        #documento input[type="text"]:required:valid{
            border:2px solid green;
        /* otras propiedades */
        }
        /*caso contrario, el color sera rojo*/
        #documento input[type="text"]:focus:required:invalid{
            border:2px solid red;
        /* otras propiedades */
        }

        button.dt-button, div.dt-button, a.dt-button{
            background: #008d4c !important;
            color: #fff;
        }
        /* Absolute Center Spinner */
        .loading {
            position: fixed;
            z-index: 999;
            height: 2em;
            width: 2em;
            overflow: show;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

        /* Transparent Overlay */
        .loading:before {

            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.3);
        }

        /* :not(:required) hides these rules from IE9 and below */
        .loading:not(:required) {
            /* hide "loading..." text */
            font: 0/0 a;
            color: transparent;
            text-shadow: none;
            background-color: transparent;
            border: 0;
        }

        .loading:not(:required):after {
            content: '';
            display: block;
            font-size: 10px;
            width: 1em;
            height: 1em;
            margin-top: -0.5em;
            -webkit-animation: spinner 1500ms infinite linear;
            -moz-animation: spinner 1500ms infinite linear;
            -ms-animation: spinner 1500ms infinite linear;
            -o-animation: spinner 1500ms infinite linear;
            animation: spinner 1500ms infinite linear;
            border-radius: 0.5em;
            -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
            box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
        }

        /* Animation */
        @-webkit-keyframes spinner {
            0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
            }
            100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
            }
        }
        @-moz-keyframes spinner {
            0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
            }
            100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
            }
        }
        @-o-keyframes spinner {
            0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
            }
            100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
            }
        }
        @keyframes spinner {
            0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
            }
            100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
            }
        }

        .scrollbar
        {
            float: left;
            height: 300px;
            background: #F5F5F5;
            overflow-y: scroll;
            margin-bottom: 25px;
        }

        .force-overflow
        {
            min-height: 450px;
        }


        /*
        *  STYLE 3
        */

        #style-3::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            background-color: #F5F5F5;
        }

        #style-3::-webkit-scrollbar
        {
            width: 6px;
            background-color: #F5F5F5;
        }

        #style-3::-webkit-scrollbar-thumb
        {
            background-color: #000000;
        }


            .nav-side-menu {
            overflow: auto;
            font-family: verdana;
            font-size: 12px;
            font-weight: 200;
            background-color: #2e353d;
            position: fixed;
            top: 0px;
            width: 300px;
            height: 100%;
            color: #e1ffff;
            }
            .nav-side-menu .brand {
            background-color: #23282e;
            line-height: 50px;
            display: block;
            text-align: center;
            font-size: 14px;
            }
            .nav-side-menu .toggle-btn {
            display: none;
            }
            .nav-side-menu ul,
            .nav-side-menu li {
            list-style: none;
            padding: 0px;
            margin: 0px;
            line-height: 35px;
            cursor: pointer;
            /*
                .collapsed{
                .arrow:before{
                            font-family: FontAwesome;
                            content: "\f053";
                            display: inline-block;
                            padding-left:10px;
                            padding-right: 10px;
                            vertical-align: middle;
                            float:right;
                        }
                }
            */
            }
            .nav-side-menu ul :not(collapsed) .arrow:before,
            .nav-side-menu li :not(collapsed) .arrow:before {
            font-family: FontAwesome;
            content: "\f078";
            display: inline-block;
            padding-left: 10px;
            padding-right: 10px;
            vertical-align: middle;
            float: right;
            }
            .nav-side-menu ul .active,
            .nav-side-menu li .active {
            border-left: 3px solid #d19b3d;
            background-color: #4f5b69;
            }
            .nav-side-menu ul .sub-menu li.active,
            .nav-side-menu li .sub-menu li.active {
            color: #d19b3d;
            }
            .nav-side-menu ul .sub-menu li.active a,
            .nav-side-menu li .sub-menu li.active a {
            color: #d19b3d;
            }
            .nav-side-menu ul .sub-menu li,
            .nav-side-menu li .sub-menu li {
            background-color: #181c20;
            border: none;
            line-height: 28px;
            border-bottom: 1px solid #23282e;
            margin-left: 0px;
            }
            .nav-side-menu ul .sub-menu li:hover,
            .nav-side-menu li .sub-menu li:hover {
            background-color: #020203;
            }
            .nav-side-menu ul .sub-menu li:before,
            .nav-side-menu li .sub-menu li:before {
            font-family: FontAwesome;
            content: "\f105";
            display: inline-block;
            padding-left: 10px;
            padding-right: 10px;
            vertical-align: middle;
            }
            .nav-side-menu li {
            padding-left: 0px;
            border-left: 3px solid #2e353d;
            border-bottom: 1px solid #23282e;
            }
            .nav-side-menu li a {
            text-decoration: none;
            color: #e1ffff;
            }
            .nav-side-menu li a i {
            padding-left: 10px;
            width: 20px;
            padding-right: 20px;
            }
            .nav-side-menu li:hover {
            border-left: 3px solid #d19b3d;
            background-color: #4f5b69;
            -webkit-transition: all 1s ease;
            -moz-transition: all 1s ease;
            -o-transition: all 1s ease;
            -ms-transition: all 1s ease;
            transition: all 1s ease;
            }
            @media (max-width: 767px) {
            .nav-side-menu {
                position: relative;
                width: 100%;
                margin-bottom: 10px;
            }
            .nav-side-menu .toggle-btn {
                display: block;
                cursor: pointer;
                position: absolute;
                right: 10px;
                top: 10px;
                z-index: 10 !important;
                padding: 3px;
                background-color: #ffffff;
                color: #000;
                width: 40px;
                text-align: center;
            }
            .brand {
                text-align: left !important;
                font-size: 22px;
                padding-left: 20px;
                line-height: 50px !important;
            }
            }
            @media (min-width: 767px) {
            .nav-side-menu .menu-list .menu-content {
                display: block;
            }
            }
    </style>
@endsection

@section('body')
    @php
        $year = date('Y');
    @endphp
    <div class="well">
        <div class="text-center">
            <span style="font-weight: bold;font-size: 22px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-transform: uppercase;">INVERSIONES HABILITADORES Y SUJETOS DE ANULACION PRESUPUESTARIA</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3" style="border-color:#ddd;border-width: 1px;border-style: solid;padding: 20px 15px 15px;">
            <div class="row">
                <div class="col-md-12">
                    <select class="js-example-responsive" id="buscar_documento" style="width: 100%"></select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 text-center" style="margin-top:10px;">
                    <button type="button" class="btn btn-primary" onclick="agregar()"><i class="fa fa-plus"> AGREGAR</i></button>
                </div>
                <div class="col-md-6 text-center" style="margin-top:10px;">
                    <button type="button" class="btn btn-success" onclick="modalimportar()"><i class="fa fa-file-excel-o"> IMPORTAR DESDE EXCEL</i></button>
                </div>
            </div>
            
        </div> 
    </div>
    <div id="cargando" class="loading" style="display:none;"></div>
    <div id="mp" style="display:none;">
        <div class="row" style="margin-top:20px;">
            <div  class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border" style="border-bottom: 1px solid #00a65a;">
                        <i class="fa fa-plus"></i>
                        <h3 class="box-title bold"><strong>Agregar Habilitador</strong></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <form action="#" id="buscar_codigo_unif_a" novalidate="novalidate">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="codigo_unif_a" id="codigo_unif_a" class="form-control" placeholder="Codigo Unico">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 id="nombre_proyecto_a"></h4>
                            </div>
                        </div>
                        <form action="#" id="agregar_a" novalidate="novalidate" disabled>
                            <fieldset id="disabled_a" disabled>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="uei_a">Unidad Ejecutora</label>
                                            <select name="uei_a" class="form-control" id="uei_a">
                                                <option value="">Sel. UEI</option>
                                                <option value="DRAL">DRAL</option>
                                                <option value="DRTC">DRTC</option>
                                                <option value="GRDE">GRDE</option>
                                                <option value="GRDS">GRDS</option>
                                                <option value="GRI">GRI</option>
                                                <option value="GRRNYMA">GRRNYMA</option>
                                                <option value="GSLS">GSLS</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="ff_a">Fuente Financiamiento</label>
                                            <select name="ff_a" class="form-control" id="ff_a">
                                                <option value="">Sel. FF</option>
                                                <option value="RD">RD</option>
                                                <option value="ROOC">ROOC</option>
                                                <option value="RO">RO</option>
                                                <option value="RDR">RDR</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tipo_a">Tipo Inversion</label>
                                            <select name="tipo_a" class="form-control" id="tipo_a">
                                                <option value="">Sel. Tipo</option>
                                                <option value="PIP">PROYECTO</option>
                                                <option value="IOARR">IOARR</option>
                                                <option value="RCC">RCC</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="ca_a">Costo Actualizado</label>
                                            <input type="text" name="ca_a" id="ca_a" class="form-control numero"  placeholder="Costo Actualizado">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="da_a">Devengado Acumulado</label>
                                            <input type="text" name="da_a" id="da_a" class="form-control numero"  placeholder="Devengado Acumulado">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="saldo_a">Saldo por Ejecutar</label>
                                            <input type="text" name="saldo_a" id="saldo_a" class="form-control numero" disabled placeholder="Saldo por Ejecutar">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="pia_a">PIA</label>
                                            <input type="text" name="pia_a" id="pia_a" class="form-control numero" placeholder="PIA">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="pim_a">PIM</label>
                                            <input type="text" name="pim_a" id="pim_a" class="form-control numero" placeholder="PIM">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="anulado">Saldo Anulado*</label>
                                            <input type="text" name="anulado" id="anulado" class="form-control numero" placeholder="Saldo Anulado">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-md-offset-4 text-center">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div  class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border" style="border-bottom: 1px solid #00a65a;">
                        <i class="fa fa-plus"></i>
                        <h3 class="box-title bold"><strong>Agregar Habilitados</strong></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <form action="#" id="buscar_codigo_unif_c" novalidate="novalidate">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="codigo_unif_c" id="codigo_unif_c" class="form-control" placeholder="Codigo Unico">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 id="nombre_proyecto_c"></h4>
                            </div>
                        </div>
                        <form action="#" id="agregar_c" novalidate="novalidate">
                            <fieldset id="disabled_c" disabled>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="uei_c">Unidad Ejecutora</label>
                                            <select name="uei_c" class="form-control" id="uei_c">
                                                <option value="">Sel. UEI</option>
                                                <option value="DRAL">DRAL</option>
                                                <option value="DRTC">DRTC</option>
                                                <option value="GRDE">GRDE</option>
                                                <option value="GRDS">GRDS</option>
                                                <option value="GRI">GRI</option>
                                                <option value="GRRNYMA">GRRNYMA</option>
                                                <option value="GSLS">GSLS</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tipo_c">Tipo Inversion</label>
                                            <select name="tipo_c" class="form-control" id="tipo_c">
                                                <option value="">Sel. Tipo</option>
                                                <option value="PIP">PROYECTO</option>
                                                <option value="IOARR">IOARR</option>
                                                <option value="RCC">RCC</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="ca_c">Costo Actualizado</label>
                                            <input type="text" name="ca_c" id="ca_c" class="form-control numero"  placeholder="Costo Actualizado">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="da_c">Devengado Acumulado</label>
                                            <input type="text" name="da_c" id="da_c" class="form-control numero"  placeholder="Devengado Acumulado">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="saldo_c">Saldo por Ejecutar</label>
                                            <input type="text" name="saldo_c" id="saldo_c" class="form-control numero" disabled placeholder="Saldo por Ejecutar">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="pia_c">PIA</label>
                                            <input type="text" name="pia_c" id="pia_c" class="form-control numero" placeholder="PIA">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="pim_c">PIM</label>
                                            <input type="text" name="pim_c" id="pim_c" class="form-control numero" placeholder="PIM">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cp_c">Cert. Presupuestal</label>
                                            <input type="text" name="cp_c" id="cp_c" class="form-control numero"  placeholder="Cert. Presupuestal">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sb_c">Saldo Balance</label>
                                            <input type="text" name="sb_c" id="sb_c" class="form-control numero" placeholder="Saldo Balance">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="credito">Credito*</label>
                                            <input type="text" name="credito" id="credito" class="form-control numero" placeholder="Credito">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-md-offset-4 text-center">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <form action="#" id="agregar_documento" novalidate="novalidate">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="doc_OPMI">Nombre de Documento OPMI</label>
                                        <input type="text" name="doc_OPMI" id="doc_OPMI" class="form-control" placeholder="Ingresar Nombre de Documento">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="memo_GRPPAT">Nombre de MEMORANDO GRPPAT</label>
                                        <input type="text" name="memo_GRPPAT" id="memo_GRPPAT" class="form-control" placeholder="Ingresar MEMORANDO GRPPAT">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="memo_UEI">Nombre de MEMORANDO UEI</label>
                                        <input type="text" name="memo_UEI" id="memo_UEI" class="form-control" placeholder="Ingresar MEMORANDO UEI">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fecha">Fecha</label>
                                        <input type="date" name="fecha" id="fecha" class="form-control" placeholder="Ingresar Fecha">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="anio">Año</label>
                                        <select name="anio" class="form-control" id="anio">
                                            <option value="">Sel. Año</option>
                                            <option value="2025">2025</option>
                                            <option value="2024">2024</option>
                                            <option value="2023">2023</option>
                                            <option value="2022">2022</option>
                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                            <option value="2019">2019</option>
                                            <option value="2018">2018</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default">
                        <div class="box-body">
                            <div class="row">
                                <div  class="col-md-6">
                                    <div class="row text-center">
                                        <caption style="color: #000 !important;text-align: center !important;"><strong>HABILITADOR</strong></caption>
                                    </div>
                                    <div class="table  table-responsive" >
                                        <table id="lista_anulado" class="table table-striped table-bordered table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="vertical-align: middle;" class="text-center" width="5px"><i class='fa fa-trash'></i></th>
                                                    <th style="vertical-align: middle;" class="text-center">COD. UNIF.</th>
                                                    <th style="vertical-align: middle;" class="text-center">S/ ANULADO</th>
                                                    <th style="vertical-align: middle;" class="text-center">S/ PIM MODIFICADO</th>
                                                </tr>
                                            </thead>
                                            <tbody id="lista_cuerpo_anulado">
                                            </tbody>
                                            <tfoot style="background-color:#72ca70c7">
                                                    <th style="vertical-align: middle;" colspan="2" class="text-center">SALDO TOTAL</th>
                                                    <th style="vertical-align: middle;" class="text-center" id="total_anulado"></th>
                                                    <th style="vertical-align: middle;" class="text-center"></th>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div  class="col-md-6">
                                    <div class="row text-center">
                                        <caption style="color: #000 !important;text-align: center !important;"><strong>HABILITADOS</strong></caption>
                                    </div>
                                    <div class="table table-responsive" >
                                        <table id="lista_credito" class="table table-striped table-bordered table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="vertical-align: middle;" class="text-center" width="5px"><i class='fa fa-trash'></i></th>
                                                    <th style="vertical-align: middle;" class="text-center">COD. UNIF.</th>
                                                    <th style="vertical-align: middle;" class="text-center">S/ CREDITO</th>
                                                    <th style="vertical-align: middle;" class="text-center">S/ PIM MODIFICADO</th>
                                                </tr>
                                            </thead>
                                            <tbody id="lista_cuerpo_credito">
                                            </tbody>
                                            <tfoot style="background-color:#72ca70c7">
                                                <th style="vertical-align: middle;" colspan="2" class="text-center">CREDITO TOTAL</th>
                                                <th style="vertical-align: middle;" class="text-center" id="total_credito"></th>
                                                <th style="vertical-align: middle;" class="text-center"></th>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-4" style="margin-bottom:5px;">
                    <div class="row">
                        <div class="col-md-4 text-center" style="margin-bottom:5px;">
                            <button type="submit" class="btn btn-primary" id="btn_opcion"><i id="btn_icon" class="fa fa-save"> GUARDAR</i></button>
                        </div>
                        <div class="col-md-4 text-center" style="margin-bottom:5px;">
                            <button type="button" class="btn btn-danger" id="btn_eliminar"onclick="eliminar()"><i class="fa fa-trash"> ELIMINAR</i></button>
                        </div>
                        <div class="col-md-4 text-center" style="margin-bottom:5px;">
                            <button type="button" class="btn btn-warning" onclick="cancelar()"><i class="fa fa-mail-reply"> CANCELAR</i></button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </form>
    </div>
   
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="{{ asset('tooltip/js/tooltipster.bundle.min.js') }}"></script>
    <!-- <script type="text/javascript" src="{{ asset('mask/jquery.mask.min.js') }}"></script> -->
    <script type="text/javascript" src="{{ asset('mask/jquery.maskMoney.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>

<script type="text/javascript">
    $(function(){
        // Variables Globales
        $total_monto_anulado = 0;
        $data_anulado=[];
        $total_monto_credito = 0;
        $data_credito=[];
        $opcion = "GUARDAR";
        $id_documento = 0;

        function number_format(amount, decimals) {
            if (amount==null) {
            amount=0;
            }
            var sign = (amount.toString().substring(0, 1) == "-");
            amount += ''; // por si pasan un numero en vez de un string
            amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

            decimals = decimals || 0; // por si la variable no fue fue pasada

            // si no es un numero o es igual a cero retorno el mismo cero
            if (isNaN(amount) || amount === 0)
                return parseFloat(0).toFixed(decimals);

            // si es mayor o menor que cero retorno el valor formateado como numero
            amount = '' + amount.toFixed(decimals);

            var amount_parts = amount.split(','),
                regexp = /(\d+)(\d{3})/;

            while (regexp.test(amount_parts[0]))
                amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

            return sign ? '-' + amount_parts.join('.') : amount_parts.join('.');
        }

        function resetform($form) {
            $($form + " select").each(function() { this.selectedIndex = 0 });
            $($form + " input[type=text] ," + $form + " textarea ," + $form + " input[type=date]").each(function() { this.value = '' });
        }

        function limpiardata(){
            $("#lista_cuerpo_anulado").empty();
            $("#lista_cuerpo_credito").empty();
            $total_monto_anulado=0;
            $total_monto_credito=0;
            $data_credito=[];
            $data_anulado=[];
            $("#total_anulado").text(number_format(0,2));
            $("#total_credito").text(number_format(0,2));
            resetform("#buscar_codigo_unif_a");
            resetform("#agregar_a");
            resetform("#buscar_codigo_unif_c");
            resetform("#agregar_c");
            resetform("#agregar_documento");
            $("#disabled_c").attr("disabled","disabled");
            $("#disabled_a").attr("disabled","disabled");
        }
        // Select 2
        $('#buscar_documento').select2({
            ajax: {
                url: "{{asset('/modificacion_presupuestal/buscardocumento')}}",
                dataType: 'json',
                type: 'POST',
                contentType: "application/json",
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            placeholder: "Buscar Documento de OPMI",
            minimumInputLength: 2,
            language: {
                noResults: function() {
                    return "No hay resultado";        
                },
                searching: function() {
                    return "Buscando...";
                },
                inputTooShort: function() {
                    return "Por favor ingrese 2 o más caracteres";
                }
            }
        });

        $("#buscar_documento").change(function() {
            $id_documento = $(this).val();
            $("#btn_opcion").html("<i class='fa fa-refresh'> ACTUALIZAR");
            $opcion = "ACTUALIZAR";
            $("#btn_eliminar").show();
            $("#cargando").show();
            $.ajax({
                url: "{{asset('/modificacion_presupuestal/ver_modificacion')}}",
                type: 'POST',
                data: {id_doc:$id_documento},
                processData: true,
            }).done(function (response) {
                // Limpiar Tabla
                limpiardata();
                // $("#anio").removeAttr("selected");
                // Mostrar
                $("#mp").show();
                //Anulado
                html_anulado = "";
                $.each(response.anulacion,function(key,value){
                    html_anulado="";
                    html_anulado += "<tr>";
                    html_anulado += "<td style='text-align:center;vertical-align: middle'><button type='button' class='btn btn-danger btn-xs b_anulacion tooltip_accion' title='Eliminar'><i class='fa fa-trash'></i></button></td>";
                    html_anulado += "<td style='text-align:center;vertical-align: middle;cursor:pointer;' class='tooltip_nombrepry'>" + value['cui_a'] +"</td>";
                    html_anulado += "<td style='text-align:center;vertical-align: middle' class='numero'>" + number_format(value['saldo_anu_a'],2)  +"</td>";
                    html_anulado += "<td style='text-align:center;vertical-align: middle'>" + number_format(value['pim_modificado_a'],2) +"</td>";
                    html_anulado += "</tr>";
                    $total_monto_anulado = (parseFloat($total_monto_anulado) + parseFloat(value['saldo_anu_a'])).toFixed(2);
                    $tr_a = {
                        cui_c : value['cui_c'],
                        nombre_pry_a : value['nombre_pry_a'],
                        ue_a : value['ue_a'],
                        ff_a : value['ff_a'],
                        tipo_a : value['tipo_a'],
                        costo_actualizacion_a : value['costo_actualizacion_a'],
                        devengado_acu_a : value['devengado_acu_a'],
                        saldo_ejec_a : value['saldo_ejec_a'],
                        pia_a : value['pia_a'],
                        pim_a : value['pim_a'],
                        saldo_anu_a : value['saldo_anu_a'],
                        pim_modificado_a : value['pim_modificado_a']
                    };
                    $data_anulado.push($tr_a); 
                    $("#lista_cuerpo_anulado").append(html_anulado);
                });
                $("#total_anulado").text(number_format($total_monto_anulado,2));
                //Credito  
                html_credito = "";
                $.each(response.credito,function(key,value){
                    html_credito += "<tr>";
                    html_credito += "<td style='text-align:center;vertical-align: middle'><button type='button' class='btn btn-danger btn-xs b_credito tooltip_accion' title='Eliminar'><i class='fa fa-trash'></i></button></td>";
                    html_credito += "<td style='text-align:center;vertical-align: middle;cursor:pointer;' class='tooltip_nombrepry'>" + value['cui_c'] +"</td>";
                    html_credito += "<td style='text-align:center;vertical-align: middle' class='numero'>" + number_format(value['credito_c'],2)  +"</td>";
                    html_credito += "<td style='text-align:center;vertical-align: middle'>" + number_format(value['pim_modificado_c'],2) +"</td>";
                    html_credito += "</tr>";
                    $total_monto_credito = (parseFloat($total_monto_credito) + parseFloat(value['credito_c'])).toFixed(2);
                    $tr_c = {
                        cui_c : value['cui_c'],
                        nombre_pry_c : value['nombre_pry_c'],
                        ue_c : value['ue_c'],
                        tipo_c : value['tipo_c'],
                        costo_actualizacion_c : value['costo_actualizacion_c'],
                        devengado_acu_c : value['devengado_acu_c'],
                        saldo_ejec_c : value['saldo_ejec_c'],
                        pia_c : value['pia_c'],
                        pim_c : value['pim_c'],
                        credito_c : value['credito_c'],
                        pim_modificado_c : value['pim_modificado_c'],
                        certificacion_c : value['certificacion_c'],
                        saldo_balance_c : value['saldo_balance_c'] 
                    };
                    $data_credito.push($tr_c);  
                    $("#lista_cuerpo_credito").append(html_credito);
                });
                $("#total_credito").text(number_format($total_monto_credito,2));
                //Documento
                console.log(response.documento["anio"]);
                $("#doc_OPMI").val(response.documento["doc_opmi"]);
                $("#memo_GRPPAT").val(response.documento["memo_grppat"]);
                $("#memo_UEI").val(response.documento["memo_uei"]);
                $("#fecha").val(moment(response.documento["fecha"]).format('YYYY-MM-DD'));
                $("#anio").children().removeAttr("selected");
                $("#anio option[value='"+ response.documento["anio"] +"']").attr("selected",true);
            }).fail(function( jqXHR, textStatus ) {

            }).always(function() {
                $("#cargando").hide();
            });
        });

        agregar = function(){
            $("#btn_opcion").html("<i class='fa fa-save'> GUARDAR");
            $opcion = "GUARDAR";
            limpiardata();
            $("#buscar_documento").empty();
            $("#btn_eliminar").hide();
            $("#mp").show();
        }

        cancelar = function(){
            $("#btn_opcion").html("<i class='fa fa-save'> GUARDAR");
            $opcion = "GUARDAR";
            limpiardata();
            $("#buscar_documento").empty();
            $("#mp").hide();
        }

        modalimportar = function(){
            modaltype='modal_simple';
            $modal = $('#' + modaltype);
            $.ajax({
                url: '{{ asset("/modificacion_presupuestal/modal_importar") }}',
                type: 'POST',
                beforeSend: function () {
                    $("#cargando").show();
                },
                success: function (response) {
                    $('#' + modaltype + ' .modal-title').html($(response).filter('.cabecera'));
                    $('#' + modaltype + ' .modal-body').html($(response).filter('#container'));
                    $('#' + modaltype + ' .modal-footer').append($(response).filter('.pie'));
                    $('#' + modaltype).modal('show');
                },
                complete: function(response) {
                    $("#cargando").hide();
                },
            });
        }
        // Anulacion
        $('#buscar_codigo_unif_a').validate({
            rules: {
                codigo_unif_a: {
                    required: true,
                    number: true,
                }
            },
            messages: {
                codigo_unif_a: {
                    required: "Ingresar Codigo Unificado",
                    number: "Ingresar Solo Numero",
                },
            },
            errorElement: 'span',
            debug: false,
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form){
                var formData = new FormData();
                $codigo_unif_a = $('#codigo_unif_a').val();
                formData.append('codigo_unif',$codigo_unif_a);
                $.ajax({
                    url: "{{asset('/modificacion_presupuestal/buscarproyecto')}}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false, 
                }).done(function (response) {
                    resetform("#agregar_a");
                    if(response.proyecto != null){
                        $proyecto = response.proyecto;
                        $("#nombre_proyecto_a").html($proyecto["nom_proyec"]);
                        $("#uei_a option[value='"+ $proyecto["ger_direc"] +"']").attr("selected",true);
                        $("#tipo_a option[value='"+ $proyecto["tipo_inversion"] +"']").attr("selected",true);
                        $(".numero").maskMoney();
                        $("#ca_a").maskMoney('mask',parseFloat($proyecto["m_pip"]));
                        $("#da_a").maskMoney('mask',parseFloat($proyecto["m_deveng_a"]));
                        $("#saldo_a").maskMoney('mask',Math.round(parseFloat($proyecto["m_pip"]) - parseFloat($proyecto["m_deveng_a"]),2));
                        $("#pia_a").maskMoney('mask',parseFloat($proyecto["pia_dia"]));
                        $("#pim_a").maskMoney('mask',parseFloat($proyecto["pim_dia"]));
                        $("#disabled_a").removeAttr("disabled");
                    }
                });
                return false;
            }
        });
        
        $('#agregar_a').validate({
            rules: {
                uei_a: {
                    required: true,
                },
                ff_a: {
                    required: true,
                },
                tipo_a: {
                    required: true,
                },
                ca_a: {
                    required: true,
                },
                da_a: {
                    required: true,
                },
                saldo_a: {
                    required: true,
                },
                pia_a: {
                    required: true,
                },
                pim_a: {
                    required: true,
                },
                anulado: {
                    required: true,
                },
                pim_mod_a: {
                    required: true,
                },
            },
            messages: {
                uei_a: {
                    required: "Seleccionar UEI",
                },
                ff_a: {
                    required: "Seleccionar Fuente Financiamiento",
                },
                tipo_a: {
                    required: "Seleccionar Tipo Proyecto",
                },
                ca_a: {
                    required: "Ingresar Costo Actualizado",
                },
                da_a: {
                    required: "Ingresar Devengado Acumulado",
                },
                saldo_a: {
                    required: "Error...!",
                },
                pia_a: {
                    required: "Ingresar PIA",
                },
                pim_a: {
                    required: "Ingresar PIM",
                },
                anulado: {
                    required: "Ingresar Monto Anulado",
                },
                pim_mod_a: {
                    required: "Error...!",
                },
            },
            errorElement: 'span',
            debug: false,
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form){
                $tr_a = [];
                $codigo_unif_a = $('#codigo_unif_a').val();
                $nombre_proyecto_a = $('#nombre_proyecto_a').text();
                $uei_a = $("#uei_a option:selected").val();
                $ff_a = $("#ff_a option:selected").val();
                $tipo_a = $("#tipo_a option:selected").val();
                $ca_a = $('#ca_a').maskMoney('unmasked')[0];
                $da_a = $('#da_a').maskMoney('unmasked')[0];
                $saldo_a = $('#saldo_a').maskMoney('unmasked')[0];
                $pia_a = $('#pia_a').maskMoney('unmasked')[0];
                $pim_a = $('#pim_a').maskMoney('unmasked')[0];
                $anulado = $('#anulado').maskMoney('unmasked')[0];
                $pim_mod_a = (parseFloat($pim_a) - parseFloat($anulado));
                $total_monto_anulado = (parseFloat($total_monto_anulado) + parseFloat($anulado)).toFixed(2);
                html="";
                html += "<tr>";
                html += "<td style='text-align:center;vertical-align: middle'><button type='button' class='btn btn-danger btn-xs b_anulacion tooltip_accion' title='Eliminar'><i class='fa fa-trash'></i></button></td>";
                html += "<td style='text-align:center;vertical-align: middle;cursor:pointer;' class='tooltip_nombrepry'>" + $codigo_unif_a +"</td>";
                html += "<td style='text-align:center;vertical-align: middle' class='numero'>" + number_format($anulado,2)  +"</td>";
                html += "<td style='text-align:center;vertical-align: middle'>" + number_format($pim_mod_a,2) +"</td>";
                html += "</tr>";
                $("#lista_cuerpo_anulado").append(html);
                $tr_a = {
                    cui_a:$codigo_unif_a,
                    nombre_pry_a:$nombre_proyecto_a,
                    ue_a:$uei_a,
                    ff_a:$ff_a,
                    tipo_a:$tipo_a,
                    costo_actualizacion_a:$ca_a,
                    devengado_acu_a:$da_a,
                    saldo_ejec_a:$saldo_a,
                    pia_a:$pia_a,
                    pim_a:$pim_a,
                    saldo_anu_a:$anulado,
                    pim_modificado_a:$pim_mod_a,
                };
                $data_anulado.push($tr_a);  
                $("#total_anulado").text(number_format($total_monto_anulado,2));
            }
        });
        $(document).on('click', '.b_anulacion', function (event) {
            $monto_anulado = 0;  
            $tr_a =  $(this).parents('tr').index();
            $(this).parents("tr").find('td').each(function(index, element){
                if(index == 2){     
                    $monto_anulado = parseFloat($(this).html().replace(/,/g, ""));
                }           
            });    
            $total_monto_anulado = ($total_monto_anulado - $monto_anulado).toFixed(2);  
            $("#total_anulado").text(number_format($total_monto_anulado,2));
            $(this).closest('tr').remove();
            $data_anulado.splice($tr_a,1);
        });

        // Credito
        $('#buscar_codigo_unif_c').validate({
            rules: {
                codigo_unif_c: {
                    required: true,
                    number: true,
                }
            },
            messages: {
                codigo_unif_c: {
                    required: "Ingresar Codigo Unificado",
                    number: "Ingresar Solo Numero",
                },
            },
            errorElement: 'span',
            debug: false,
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form){
                var formData = new FormData();
                $codigo_unif_c = $('#codigo_unif_c').val();
                formData.append('codigo_unif',$codigo_unif_c);
                $.ajax({
                    url: "{{asset('/modificacion_presupuestal/buscarproyecto')}}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false, 
                }).done(function (response) {
                    resetform("#agregar_c");
                    if(response.proyecto != null){
                        $proyecto = response.proyecto;
                        $("#nombre_proyecto_c").html($proyecto["nom_proyec"]);
                        $("#uei_c option[value='"+ $proyecto["ger_direc"] +"']").attr("selected",true);
                        $("#tipo_c option[value='"+ $proyecto["tipo_inversion"] +"']").attr("selected",true);
                        $(".numero").maskMoney();
                        $("#ca_c").maskMoney('mask',parseFloat($proyecto["m_pip"]));
                        $("#da_c").maskMoney('mask',parseFloat($proyecto["m_deveng_c"]));
                        $("#saldo_c").maskMoney('mask',Math.round(parseFloat($proyecto["m_pip"]) - parseFloat($proyecto["m_deveng_c"]),2));
                        $("#pia_c").maskMoney('mask',parseFloat($proyecto["pia_dia"]));
                        $("#pim_c").maskMoney('mask',parseFloat($proyecto["pim_dia"]));
                        $("#cp_c").maskMoney('mask',parseFloat(0));
                        $("#sb_c").maskMoney('mask',parseFloat(0));
                        $("#disabled_c").removeAttr("disabled");
                    }
                });
                return false;
            }
        });
        
        $('#agregar_c').validate({
            rules: {
                uei_c: {
                    required: true,
                },
                tipo_c: {
                    required: true,
                },
                ca_c: {
                    required: true,
                },
                da_c: {
                    required: true,
                },
                saldo_c: {
                    required: true,
                },
                pia_c: {
                    required: true,
                },
                pim_c: {
                    required: true,
                },
                credito: {
                    required: true,
                },
                pim_mod_c: {
                    required: true,
                },
                // cp_c: {
                //     required: true,
                // },
                // sb_c: {
                //     required: true,
                // },
            },
            messages: {
                uei_c: {
                    required: "Seleccionar UEI",
                },
                tipo_c: {
                    required: "Seleccionar Tipo Proyecto",
                },
                ca_c: {
                    required: "Ingresar Costo Actualizado",
                },
                da_c: {
                    required: "Ingresar Devengado Acumulado",
                },
                saldo_c: {
                    required: "Error...!",
                },
                pia_c: {
                    required: "Ingresar PIA",
                },
                pim_c: {
                    required: "Ingresar PIM",
                },
                credito: {
                    required: "Ingresar Monto Credito",
                },
                pim_mod_c: {
                    required: "Error...!",
                },
                // cp_c: {
                //     required: "Ingresar Cred. Presupuestal",
                // },
                // sb_c: {
                //     required: "Ingresar Saldo Balance",
                // },
            },
            errorElement: 'span',
            debug: false,
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form){
                $tr_c = [];
                $codigo_unif_c = $('#codigo_unif_c').val();
                $nombre_proyecto_c = $('#nombre_proyecto_c').text();
                $uei_c = $("#uei_c option:selected").val();
                $tipo_c = $("#tipo_c option:selected").val();
                $ca_c = $('#ca_c').maskMoney('unmasked')[0];
                $da_c = $('#da_c').maskMoney('unmasked')[0];
                $saldo_c = $('#saldo_c').maskMoney('unmasked')[0];
                $pia_c = $('#pia_c').maskMoney('unmasked')[0];
                $pim_c = $('#pim_c').maskMoney('unmasked')[0];
                $cp_c = $('#cp_c').maskMoney('unmasked')[0];
                $sb_c = $('#sb_c').maskMoney('unmasked')[0];
                $credito = $('#credito').maskMoney('unmasked')[0];
                $pim_mod_c = (parseFloat($pim_c) + parseFloat($credito));
                $total_monto_credito = (parseFloat($total_monto_credito) + parseFloat($credito)).toFixed(2);
                html="";
                html += "<tr>";
                html += "<td style='text-align:center;vertical-align: middle'><button type='button' class='btn btn-danger btn-xs b_credito tooltip_accion' title='Eliminar'><i class='fa fa-trash'></i></button></td>";
                html += "<td style='text-align:center;vertical-align: middle;cursor:pointer;' class='tooltip_nombrepry'>" + $codigo_unif_c +"</td>";
                html += "<td style='text-align:center;vertical-align: middle' class='numero'>" + number_format($credito,2)  +"</td>";
                html += "<td style='text-align:center;vertical-align: middle'>" + number_format($pim_mod_c,2) +"</td>";
                html += "</tr>";
                $("#lista_cuerpo_credito").append(html);
                $tr_c = {
                    cui_c:$codigo_unif_c,
                    nombre_pry_c:$nombre_proyecto_c,
                    ue_c:$uei_c,
                    tipo_c:$tipo_c,
                    costo_actualizacion_c:$ca_c,
                    devengado_acu_c:$da_c,
                    saldo_ejec_c:$saldo_c,
                    pia_c:$pia_c,
                    pim_c:$pim_c,
                    credito_c:$credito,
                    pim_modificado_c:$pim_mod_c,
                    certificacion_c:$cp_c,
                    saldo_balance_c:$sb_c 
                };
                $data_credito.push($tr_c);  
                $("#total_credito").text(number_format($total_monto_credito,2));
            }
        });
        $(document).on('click', '.b_credito', function (event) {
            $monto_credito = 0;  
            $tr_a =  $(this).parents('tr').index();
            $(this).parents("tr").find('td').each(function(index, element){
                if(index == 2){     
                    $monto_credito = parseFloat($(this).html().replace(/,/g, ""));
                }           
            });    
            $total_monto_credito = ($total_monto_credito - $monto_credito).toFixed(2);  
            $("#total_credito").text(number_format($total_monto_credito,2));
            $(this).closest('tr').remove();
            $data_credito.splice($tr_a,1);
            // console.log($data_credito);
        });
        //Documento y Guardado
        $('#agregar_documento').validate({
            rules: {
                doc_OPMI: {
                    required: true,
                },
                memo_GRPPAT: {
                    required: true,
                },
                memo_UEI: {
                    required: true,
                },
                fecha: {
                    required: true,
                },
                anio: {
                    required: true,
                },
            },
            messages: {
                doc_OPMI: {
                    required: "Ingresar Documento OPMI",
                },
                memo_GRPPAT: {
                    required: "Ingresar Memorando GRPPAT",
                },
                memo_UEI: {
                    required: "Ingresar Memorando UEI",
                },
                fecha: {
                    required: "Ingresar Fecha",
                },
                anio: {
                    required: "Ingresar Año",
                }
            },
            errorElement: 'span',
            debug: false,
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form){
                var formData = new FormData();
                $doc_OPMI = $('#doc_OPMI').val();
                $memo_GRPPAT = $('#memo_GRPPAT').val();
                $memo_UEI = $('#memo_UEI').val();
                $fecha = $('#fecha').val();
                $anio = $('#anio').val();
                if($data_anulado.length == 0 || $data_credito.length == 0 ){
                    swal({
                        title: "Verificar",
                        text: "Tabla Habilitador o Habilitados Vacios",
                        type: "warning",
                        confirmButtonClass: 'btn btn-success',
                        confirmButtonText:'ok',
                    });
                }else if($total_monto_anulado != $total_monto_credito){
                    swal({
                        title: "Verificar",
                        text: "Saldo Total y Credito Total no coinciden",
                        type: "warning",
                        confirmButtonClass: 'btn btn-success',
                        confirmButtonText:'ok',
                    });
                }else{
                    formData.append('doc_OPMI',$doc_OPMI);
                    formData.append('memo_GRPPAT',$memo_GRPPAT);
                    formData.append('memo_UEI',$memo_UEI);
                    formData.append('fecha',$fecha);
                    formData.append('anio',$anio);
                    formData.append('data_anulado',JSON.stringify($data_anulado));
                    formData.append('data_credito',JSON.stringify($data_credito));
                    formData.append('opcion',$opcion);
                    formData.append('id_documento',$id_documento);
                    $.ajax({
                        url: "{{asset('/modificacion_presupuestal/guardar')}}",
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false, 
                    }).done(function (response) {
                        if($opcion == "GUARDAR"){
                            swal({
                                title: "Guardado!",
                                text: "Se registro correctamente",
                                type: "success",
                                    confirmButtonClass: 'btn btn-success',
                                    confirmButtonText:'ok',
                            });
                            limpiardata();
                        }else{
                            swal({
                                title: "Actualizado!",
                                text: "Se actualizo correctamente",
                                type: "success",
                                    confirmButtonClass: 'btn btn-success',
                                    confirmButtonText:'ok',
                            });
                            limpiardata();
                            $("#buscar_documento").empty();
                            $("#mp").hide();
                        }
                        
                    }).fail(function( jqXHR, textStatus ) {
                        if(jqXHR.status == 500){
                            swal({
                                    title: "Error!",
                                    text: jqXHR.responseJSON.msg,
                                    type: "error",
                                    confirmButtonText:'ok',
                            });
                        }else if(jqXHR.status == 400){
                            console.log("Error de Transaccion");
                        }else{
                            console.log("Error...");
                        }
                    }).always(function() {
                    });
                }
                return false;
            }
        });

        eliminar = function(){
            swal({
                    title: '¿Desea Eliminar?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminar',
                    cancelButtonText: 'Cancelar'
                }).then(function(result){
                    $("#cargando").show();
                    $.ajax({
                        url: "{{asset('/modificacion_presupuestal/eliminar')}}",
                        type: 'POST',
                        data: {id_doc:$id_documento},
                        processData: true,
                    }).done(function (response) {
                        // Limpiar Tabla
                        limpiardata();
                        $("#buscar_documento").empty();
                        // Ocultar
                        $("#mp").hide();
                    }).fail(function( jqXHR, textStatus ) {
                    }).always(function() {
                        $("#cargando").hide();
                    });
                    swal("Eliminar!", "Su información ha sido eliminada", "success");
                },function (dismiss) {
                    swal("Cancelado", "La eliminacion ha sido cancelado :)", "error");
                }).catch(swal.noop);            
        }
    });
</script>
@endsection
