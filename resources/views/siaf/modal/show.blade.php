<span class="cabecera">
    <h3 class="text-center"><b>DEVENGADOS 001-1027: REGION LIMA</b></h3>
    <h4 class="text-center"><b>({{$fecha}})</b></h4>
</span>
<div id="container" >
    <div class="modal-body">
        <div class="row">
            @php
                $mes=array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
            @endphp
            @foreach($data_pry as $proyecto)   
                @php
                    $cod_unif = $proyecto->cod_unif;
                    $result = array_filter($data_dev, function ($var) use ($cod_unif) {
                        return ($var['cod_unif'] == $cod_unif);
                    });
                @endphp
                @if (count($result)>0) 
                    @php
                        $result_a = json_encode($result); 
                        $result_a = json_decode($result_a);  
                        $data =[];
                        foreach($result_a as $r){
                            $sec_func_f = $r->sec_func;
                            $result_sec_func = array_filter($result, function ($var) use ($sec_func_f) {
                                return ($var['sec_func'] == $sec_func_f);
                            });
                            $data[$sec_func_f] = $result_sec_func;
                        }
                        $data = json_encode($data); 
                        $data = json_decode($data);  
                        $monto_total = 0;
                        $t_1 = 0;
                        $t_2 = 0;
                        $t_3 = 0;
                        $t_4 = 0;
                        $t_5 = 0;
                        $t_6 = 0;
                        $t_7 = 0;
                        $t_8 = 0;
                        $t_9 = 0;
                        $t_10 = 0;
                        $t_11 = 0;
                        $t_12 = 0;
                        $row = 0;
                        $sec_func = 0;
                    @endphp
                    
                    <div class="col-md-12">
                        <div class="box box-default box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"><a title="Ir a SSI" target="_blank" href="http://ofi5.mef.gob.pe/ssi/ssi/Index?codigo={{ $proyecto->cod_unif }}&tipo=2" >{{ $proyecto->cod_unif }}</a> -> {{ $proyecto->nom_proyec }}</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body" style="">
                                <div class="box">
                                    <div class="box-body table-responsive no-padding">
                                        <div class="table  table-responsive" >
                                            <table class="table table-striped">
                                                <thead>
                                                    <th>#</th>
                                                    <th width="7%"> Año</th>
                                                    <th width="7%">Funcion</th>
                                                    <th width="7%"> Ene</th>
                                                    <th width="7%"> Feb</th>
                                                    <th width="7%"> Mar</th>
                                                    <th width="7%"> Abr</th>
                                                    <th width="7%"> May</th>
                                                    <th width="7%"> Jun</th>
                                                    <th width="7%"> Jul</th>
                                                    <th width="7%"> Ago</th>
                                                    <th width="7%"> Set</th>
                                                    <th width="7%"> Oct</th>
                                                    <th width="7%"> Nov</th>
                                                    <th width="7%"> Dic </th>
                                                    <th width="7%"> Total </th>
                                                </thead>
                                                <tbody>
                                                @foreach($data as $index=>$sec_func_a ) 
                                                    @php
                                                        $row += 1;
                                                        $array_dev = [1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0,13=>0];
                                                        foreach($sec_func_a as $devengado){                                                   
                                                            if($devengado->mes == 1){
                                                                $array_dev[1] = $devengado->monto;
                                                                $t_1 = $devengado->monto;
                                                            }elseif($devengado->mes == 2){
                                                                $array_dev[2] = $devengado->monto;
                                                                $t_2 = $devengado->monto;
                                                            }elseif($devengado->mes == 3){
                                                                $array_dev[3] = $devengado->monto;
                                                                $t_3 = $devengado->monto;
                                                            }elseif($devengado->mes == 4){
                                                                $array_dev[4] = $devengado->monto;
                                                                $t_4 = $devengado->monto;
                                                            }elseif($devengado->mes == 5){
                                                                $array_dev[5] = $devengado->monto;
                                                                $t_5 = $devengado->monto;
                                                            }elseif($devengado->mes == 6){
                                                                $array_dev[6] = $devengado->monto;
                                                                $t_6 = $devengado->monto;
                                                            }elseif($devengado->mes == 7){
                                                                $array_dev[7] = $devengado->monto;
                                                                $t_7 = $devengado->monto;
                                                            }elseif($devengado->mes == 8){
                                                                $array_dev[8] = $devengado->monto;
                                                                $t_8 = $devengado->monto;
                                                            }elseif($devengado->mes == 9){
                                                                $array_dev[9] = $devengado->monto;
                                                                $t_9 = $devengado->monto;
                                                            }elseif($devengado->mes == 10){
                                                                $array_dev[10] = $devengado->monto;
                                                                $t_10 = $devengado->monto;
                                                            }elseif($devengado->mes == 11){
                                                                $array_dev[11] = $devengado->monto;
                                                                $t_11 = $devengado->monto;
                                                            }elseif($devengado->mes == 12){
                                                                $array_dev[12] = $devengado->monto;
                                                                $t_12 = $devengado->monto;
                                                            }
                                                            $array_dev[13] += $devengado->monto;
                                                            $monto_total += $devengado->monto;
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $row }}</td>
                                                        <td>2021</td>
                                                        <td>{{ $index }}</td>
                                                        @foreach($array_dev as $dev)
                                                            <td>{{ number_format($dev,2) }}</td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr style="background-color: #808080a6;"> 
                                                        <th style="text-align: center;font-size: larger;font-weight: bold;" colspan="3">Total</th>
                                                        <th style="font-size: larger;font-weight: bold;">{{ number_format($t_1,2) }}</th>
                                                        <th style="font-size: larger;font-weight: bold;">{{ number_format($t_2,2) }}</th>
                                                        <th style="font-size: larger;font-weight: bold;">{{ number_format($t_3,2) }}</th>
                                                        <th style="font-size: larger;font-weight: bold;">{{ number_format($t_4,2) }}</th>
                                                        <th style="font-size: larger;font-weight: bold;">{{ number_format($t_5,2) }}</th>
                                                        <th style="font-size: larger;font-weight: bold;">{{ number_format($t_6,2) }}</th>
                                                        <th style="font-size: larger;font-weight: bold;">{{ number_format($t_7,2) }}</th>
                                                        <th style="font-size: larger;font-weight: bold;">{{ number_format($t_8,2) }}</th>
                                                        <th style="font-size: larger;font-weight: bold;">{{ number_format($t_9,2) }}</th>
                                                        <th style="font-size: larger;font-weight: bold;">{{ number_format($t_10,2) }}</th>
                                                        <th style="font-size: larger;font-weight: bold;">{{ number_format($t_11,2) }}</th>
                                                        <th style="font-size: larger;font-weight: bold;">{{ number_format($t_12,2) }}</th>
                                                        <th style="font-size: larger;font-weight: bold;">{{ number_format($monto_total,2) }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

        </div>
    </div>
</div>
<div class="pie">
</div>