@extends('starter')
@section('htmlhead')
    <!-- D3 JS -->
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"  rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css"  rel="stylesheet" type="text/css">
    <link href="{{ asset('tooltip/css/tooltipster.bundle.min.css') }}" rel="stylesheet" type="text/css"/>

    <style type="text/css">
        .verticalText {
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        }

        .vcenter {
            text-align: center;
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
        setlocale(LC_TIME, "spanish");
        $year= date("Y");
        $dia= date("d");
    @endphp
    <div class="well">
        <div class="text-center">
            <span style="font-weight: bold;font-size: 22px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-transform: uppercase;">MODIFICACION PRESUPUESTARIA ENTRE INVERSIONES</span>
        </div>
    </div>
    <div id="cargando" class="loading" style="display: none;"></div>
    <div class="row">
        <form action="{{URL::to('modificacion_presupuestal/exportar')}}" method="GET" class="form-horizontal" id="frm_habilitador">
            <div class="row">
                <div class="col-md-12">
                    <div class=" margin">
                        <input type="text" class="form-control" name="nombre_informe" placeholder="Nombre Informe" value="" required />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Habilitadores</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="field_wrapper">
                                <div class="margin">
                                    <input type="text" class="form-control field_name" name="field_name[]" placeholder="Ingrese Codigo" value="" pattern="[0-9]+" minlength="7" maxlength="7" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field_wrapper_anulacion">
                                <div class="margin input-group">
                                    <input type="text" class="form-control field_name_anulacion" name="field_name_anulacion[]" onchange="MASK(this,this.value,'##,###,##0.00',1)" placeholder="Ingrese Monto Anulación" value="" required/>
                                    <span class="input-group-btn">
                                        <button type="button" class="add_button btn btn-info btn-flat"><i class="fa fa-plus"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Habilitados</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="field_wrapper_credito">
                                <div class="margin">
                                    <input type="text" class="form-control field_name_credito" name="field_name_credito[]" placeholder="Ingrese Codigo" value="" pattern="[0-9]+" minlength="7" maxlength="7" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field_wrapper_monto_credito">
                                <div class="margin input-group">
                                    <input type="text" class="form-control field_name_monto_credito" name="field_name_monto_credito[]" onchange="MASK(this,this.value,'##,###,##0.00',1)" placeholder="Ingrese Monto de Credito" value="" required/>
                                    <span class="input-group-btn">
                                        <button type="button" class="add_button_credito btn btn-info btn-flat"><i class="fa fa-plus"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="row">
                <!--<div class="col-md-5"></div>-->
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-info btn-flat">Enviar</button>
                </div>
                <!--<div class="col-md-5"></div>-->
            </div>
        </form>

    </div>
    <br>
    <div class="row" id="error" style="display:none">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i>!Alerta</h4>
                <ul id="error_ul">
                </ul>
            </div>
        </div>
    </div>

    <div class="row" id="exito" style="display:none">
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i>!Generando Excel...</h4>

            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="{{ asset('tooltip/js/tooltipster.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mask/jquery.mask.min.js') }}"></script>

<script type="text/javascript">
    $(function(){
        // Agregar inputs

        var x = 1; //Initial field counter is 1
        var y = 1;
        var addButton = $('.add_button'); //Add button selector
        var addButton_credito = $('.add_button_credito'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var wrapper_anulacion = $('.field_wrapper_anulacion'); //Input field wrapper
        var wrapper_credito = $('.field_wrapper_credito'); //Input field wrapper
        var wrapper_monto_credito = $('.field_wrapper_monto_credito'); //Input field wrapper
        $(addButton).click(function(){ //Once add button is clicked
            var fieldHTML = '<div class="margin add' + x + '"><input type="text" class="form-control field_name" name="field_name[]" value="" placeholder="Ingrese Codigo" pattern="[0-9]+" minlength="7" maxlength="7" required /></div>'; //New input field html 
            var fieldHTML_anulacion = '<div class="margin input-group add' + x + '"><input type="text" class="form-control field_name_anulacion" name="field_name_anulacion[]" onchange="MASK(this,this.value,\'##,###,##0.00\',1)" value="" placeholder="Ingrese Monto Anulación" required /><span class="input-group-btn"><button type="button" onclick="remove(' + x +')" class="btn btn-danger btn-flat"><i class="fa fa-trash-o"></i></button></span></div>'; //New input field html 
             x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
            $(wrapper_anulacion).append(fieldHTML_anulacion); // Add field html

        });

        $(addButton_credito).click(function(){ //Once add button is clicked
            var fieldHTML_credito = '<div class="margin add_c' + y + '"><input type="text" class="form-control field_name_credito" name="field_name_credito[]" value="" placeholder="Ingrese Codigo" pattern="[0-9]+" minlength="7" maxlength="7" required /></div>'; //New input field html 
            var fieldHTML_monto_credito = '<div class="margin input-group add_c' + y + '"><input type="text" class="form-control field_name_monto_credito" name="field_name_monto_credito[]"  onchange="MASK(this,this.value,\'##,###,##0.00\',1)" value="" placeholder="Ingrese Monto de Credito" required /><span class="input-group-btn"><button type="button" onclick="remove_credito(' + y +')" class="btn btn-danger btn-flat"><i class="fa fa-trash-o"></i></button></span></div>'; //New input field html 
            y++; //Increment field counter
            $(wrapper_credito).append(fieldHTML_credito); // Add field html
            $(wrapper_monto_credito).append(fieldHTML_monto_credito); // Add field html

        });

        remove = function(x){
            console.log(x);
            $(".add"+x).remove();
        }

        remove_credito = function(y){
            console.log(y);
            $(".add_c"+y).remove();
        }
        // Fin Agregar inputs

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

        $("#frm_habilitador").submit(function( event ) {
            event.preventDefault();
            //Validacion
            $form = this;
            $("#error").hide();
            $("#error_ul").empty();
            $("#exito").hide();
            $anulado=[];
            $pry=[];
            $('.field_name').each(function () {               
                if($.inArray(this.value,['2001621','2016766']) != -1) {
                    $anulado.push(this.value);
                }
                $pry.push(this.value);
            });
            $credito=[];
            $('.field_name_credito').each(function () {
                if($.inArray(this.value,['2001621','2016766']) != -1) {
                    $credito.push(this.value);
                }
                $pry.push(this.value);
            });
            $.ajax({
                type:"GET",
                url: '{{ url("/modificacion_presupuestal/data_analisis") }}',
                data: {id :$pry},
                beforeSend: function() {
                $("#cargando").show();
                }
            })
            .done(function(response) {
                if((response.ssi).length > 0){
                    $("#error").show();
                    $("#error_ul").append("<li>Inversion no encontrada en el SSI: "+ (response.ssi).join("-") + "</li>");
                }

                if($credito.length > 0 || $anulado.length > 0){
                    $data_anulado = $anulado.join("-");
                    if($anulado.length > 0){
                        $("#error").show();
                        $("#error_ul").append("<li>Codigo Unificado para Habilitador no permitidos: "+ $data_anulado + "</li>");
                    }
                    $data_credito = $credito.join("-");
                    if($credito.length > 0){
                        $("#error").show();
                        $("#error_ul").append("<li>Codigo Unificado para Habilitados no permitidos: "+ $data_credito + "</li>");
                    }
                }
                else{
                    $total_anulado = 0;
                    $('.field_name_anulacion').each(function () {
                        $total_anulado += parseInt((this.value).replace(/,/g, ""));
                    });
                    $total_credito = 0;
                    $('.field_name_monto_credito').each(function () {
                        $total_credito += parseInt((this.value).replace(/,/g, ""));
                    });
                    if($total_anulado == $total_credito) {
                        $form.submit();
                        $("#error").hide();
                        $("#exito").show();
                    }else{
                        $("#error").show();
                        $("#error_ul").append("<li>El monto total del Habilitador a de ser igual que el Habilitado</li>");
                    }
                }
            })
            .fail(function() {
                console.log( "error" );
            })
            .always(function(response) {
                $("#cargando").hide();
            });
        });
        
        //Mascara
        MASK = function(form, n, mask, format) {
            if (format == "undefined") format = false;
            if (format || NUM(n)) {
                dec = 0, point = 0;
                x = mask.indexOf(".")+1;
                if (x) { dec = mask.length - x; }

                if (dec) {
                n = NUM(n, dec)+"";
                x = n.indexOf(".")+1;
                if (x) { point = n.length - x; } else { n += "."; }
                } else {
                n = NUM(n, 0)+"";
                } 
                for (var x = point; x < dec ; x++) {
                n += "0";
                }
                x = n.length, y = mask.length, XMASK = "";
                while ( x || y ) {
                if ( x ) {
                    while ( y && "#0.".indexOf(mask.charAt(y-1)) == -1 ) {
                    if ( n.charAt(x-1) != "-")
                        XMASK = mask.charAt(y-1) + XMASK;
                    y--;
                    }
                    XMASK = n.charAt(x-1) + XMASK, x--;
                } else if ( y && "$0".indexOf(mask.charAt(y-1))+1 ) {
                    XMASK = mask.charAt(y-1) + XMASK;
                }
                if ( y ) { y-- }
                }
            } else {
                XMASK="";
            }
            if (form) { 
                form.value = XMASK;
                if (NUM(n)<0) {
                form.style.color="#FF0000";
                } else {
                form.style.color="#000000";
                }
            }
            return XMASK;
        }

        function NUM(s, dec) {
            for (var s = s+"", num = "", x = 0 ; x < s.length ; x++) {
                c = s.charAt(x);
                if (".-+/*".indexOf(c)+1 || c != " " && !isNaN(c)) { num+=c; }
            }
            if (isNaN(num)) { num = eval(num); }
            if (num == "")  { num=0; } else { num = parseFloat(num); }
            if (dec != undefined) {
                r=.5; if (num<0) r=-r;
                e=Math.pow(10, (dec>0) ? dec : 0 );
                return parseInt(num*e+r) / e;
            } else {
                return num;
            }
        }
    });
</script>

@endsection
