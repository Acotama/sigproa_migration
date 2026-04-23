<!DOCTYPE html>
<html>

	 <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
  <style type="text/css">
      .fa {
        display: inline;
        font-style: normal;
        font-variant: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 1;
        font-family: FontAwesome;
        font-size: inherit;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
      }

      .timeline-date {
      	background-color: #00a65a;
      	color:white;
      	font-size: 14px;
      	font-weight: bold;
      	border-radius: 50%;
      	padding: 4px;
      	margin-top: 12px;
      	margin-bottom: 12px;
      }


	/*li {
		page-break-before: always;
	}*/
	section {
            page-break-after: avoid;
    }

  </style>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="icon" href="http://sayhuite.regionlima.gob.pe/sisgeolima/security/auth/images/ico.png">
<head>
	<title></title>
</head>
<body>
	<div class="container">
        <header class="container-fluid" style="background-color: white;text-align: center;">
            <img src="images/sys/logo1.gif" width="40%">
        </header>

		<section>
		<br>
		<br>
		<div class="col-md-12 main">
        <div class="row">
            <div class="box box-primary">
              <div class="box-header with-border text-center">
                <h2 class="box-title"><strong>{{ $proyecto->nom_proyec }}</strong></h2>
                <br>
                <p>
                    <b>Codigo Unificado:</b> {{ $proyecto->cod_unif }}
                    - <b>Codigo Snip:</b> {{ $proyecto->cod_snip }}</p>

                <!-- /.box-tools -->
              </div>
            </div>
            <!-- /.box -->

        </div>
        <div class="row">
            <div class="container">
                <!-- timeline time label -->
                @foreach($proyecto['timeline'] as $p)
                    <section class="timeline-date">
                        <span>
                            {{ $p->fecha_estado }}
                        </span>
                    </section>
                    <!-- /.timeline-label -->

                    @if ( count($p->obra_estado) > 0 )
                    @foreach( $p->obra_estado as $oe )
                    <!-- META ESTADO ITEM -->
                    <section class="jtimeline-item text-justify">
                        <h4 class="jtimeline-header"><a href="#"></a>
                            <b>{{ $oe->nro_meta == 0 ? '' : $oe->nom_meta }}</b>
                        </h4>
                        <div class="text-center">
                            <div class="jtimeline-body">
                                <p><b>{{ $oe->etapa }}</b></p>
                                <p>
                                    <strong style="font-size: 10px;">{{ $oe->sub_etapa }}</strong> &nbsp&nbsp {{ $oe->est_situ }}
                                </p>
                                <p>
                                    Avance Fisico de Obra: {{ $oe->a_fisico }} %
                                </p>
                            </div>
                            <br>
                        </div>

                        <div class="jtimeline-footer text-center">
                            @foreach( $oe->obra_estado_img as $oeimg )
                                 <img src="{{ asset($oeimg->url. '/' . $oeimg->nombre) }} " width="200px;" height="200px;">
                            @endforeach
                        </div>
                    </section>
                    <!-- END META ESTADO ITEM-->
                    @endforeach
                    @endif

                    <!-- ESTADO ITEM -->
                    @if ($p->proyecto_estado)
                    <section>
                        <div class="jtimeline-item text-justify">
                            <h5 class="jtimeline-header"><a href="#"></a>
                                {{ $p->proyecto_estado->etapa  }} : {{  $p->proyecto_estado->sub_etapa  }}
                            </h5>

                            <div class="jtimeline-body">
                                {{ $p->proyecto_estado->est_situ  }}
                            </div>

                            <div class="jtimeline-footer">
                                <p>Avance Fisico Obra: {{ $p->proyecto_estado->a_fisico or 0}}</p>
                            </div>
                        </div>
                    </section>
                    @endif
                    <!-- END ESTADO ITEM-->

                    @if ( count($p->proyecto_img) > 0 )
                    <!-- IMAGEN SOLA ITEM -->
                    <section>
                        <div class="jtimeline-item text-justify">
                            <!--h3 class="timeline-header"><a href="#"></a>

                            </h3-->
                            <div class="text-center">
                                <div class="jtimeline-body text-center">
                                    <br>
                                    @foreach($p->proyecto_img as $pimg)
                                        <img src="{{ $pimg->url }}/{{ $pimg->nombre }}" width="200px;" height="200px;">
                                    @endforeach
                                </div>
                                <br>

                            </div>

                            <div class="jtimeline-footer text-center">
                                <p><b><i>{{ $p->proyecto_img[0]->tiempo }}</i></b></p>
                                <p><b><i>{{ $p->proyecto_img[0]->descripcion }}</i></b></p>
                            </div>
                        </div>
                    </section>
                    <!-- END IMAGEN SOLA ITEM-->
                    @endif


                    <!-- MONEY -->
                    <!--li>
                        < timeline icon >
                        <i class="fa fa-money bg-red"></i>
                        <div class="timeline-item">
                            <div class="timeline-body">

                            </div>

                            <div class="timeline-footer">

                            </div>
                        </div>
                    </li-->
                    <!-- FIN MONEY -->
                @endforeach
            </div>
        </div>
    </div>


		</section>



	</div>
</body>
</html>
