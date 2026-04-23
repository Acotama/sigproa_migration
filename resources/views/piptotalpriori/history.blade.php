@extends('starter')

@section('body')
    
    {{-- dd($proyecto) --}}
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
            <div class="pull-left">
                <a href="/piptotalpriori/pdfExportHistory/{{ $proyecto->id }}" class="btn btn-default"><i class="fa fa-print"></i></a>
            </div>
        </div>
        <br>
        <div class="row">
            <ul class="timeline">            
                <!-- timeline time label -->
                @foreach($proyecto['timeline'] as $p)
                    <li class="time-label">
                        <span class="bg-green">
                            {{ $p->fecha_estado }}
                        </span>
                    </li>
                    <!-- /.timeline-label -->

                    @if ( count($p->obra_estado) > 0 )
                    @foreach( $p->obra_estado as $oe )
                    <!-- META ESTADO ITEM -->
                    <li>
                        <!-- timeline icon -->
                        <i class="fa fa-flag bg-blue"></i>
                        <div class="timeline-item text-center">                            
                            <h3 class="timeline-header"><a href="#"></a> 
                                <b>{{ $oe->nro_meta == 0 ? '' : $oe->nom_meta }}</b>                                
                            </h3>
                            <div class="text-center">                                
                                <div class="timeline-body">
                                    <p><b>{{ $oe->etapa }}</b></p>
                                    <p>
                                        <label class="label label-default">
                                            {{ $oe->sub_etapa}}
                                        </label> 
                                        &nbsp&nbsp {{ $oe->est_situ }}
                                    </p>
                                    <p>
                                        Avance Fisico de Obra: <label class="label label-warning">{{ $oe->a_fisico }} %</label>
                                    </p>
                                </div>
                                <br>
                            </div>

                            <div class="timeline-footer">
                                @foreach( $oe->obra_estado_img as $oeimg )
                                     <a class="fancybox" rel="group" href="{{ asset( $oeimg->url.'/'.$oeimg->nombre ) }}"><img src="{{ asset( 'images'.$oeimg->url.'/'.$oeimg->nombre ) }}" width="150px;" height="150px;"></a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                    <!-- END META ESTADO ITEM-->
                    @endforeach
                    @endif

                    <!-- ESTADO ITEM -->                    
                    @if ($p->proyecto_estado)
                    <li>
                        <!-- timeline icon -->
                        <i class="fa fa-university bg-blue"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header text-center"><a href="#"></a> 
                                <b> {{ $p->proyecto_estado->etapa  }}</b>
                            </h3>

                            <div class="timeline-body text-center">
                                <label class="label label-default">
                                 {{  $p->proyecto_estado->sub_etapa  }}  </label>
                                 &nbsp&nbsp {{ $p->proyecto_estado->est_situ  }}
                            </div>                            
                        </div>
                    </li>
                    @endif
                    <!-- END ESTADO ITEM-->
                    
                    @if ( count($p->proyecto_img) > 0 )
                    <!-- IMAGEN SOLA ITEM -->
                    <li>
                        <!-- timeline icon -->
                        <i class="fa fa-image bg-red"></i>
                        <div class="timeline-item text-center">                            
                            <!--h3 class="timeline-header"><a href="#"></a> 
                                
                            </h3-->
                            <div class="text-center">                                
                                <div class="timeline-body">
                                    <br>
                                    @foreach($p->proyecto_img as $pimg)
                                        <a class="fancybox" rel="group" href="{{ asset( $pimg->url.'/'.$pimg->nombre ) }}"><img src="{{ asset( $pimg->url.'/'.$pimg->nombre ) }}" width="150px;" height="150px;"></a>
                                    @endforeach
                                </div>
                                <br>

                            </div>

                            <div class="timeline-footer text-center">
                                <b><i>{{ $p->proyecto_img[0]->tiempo }}</i></b>
                                <p>{{ $p->proyecto_img[0]->descripcion }}</p>
                            </div>
                        </div>
                    </li>
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
            </ul>
        </div>
    </div>

@section('script')
<script type="text/javascript">
     //FANCYBOX INIT
    $(function () {
        $(".fancybox").fancybox();
    });
</script>
@endsection



@endsection
