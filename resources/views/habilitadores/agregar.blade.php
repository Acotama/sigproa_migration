<span class="cabecera">
    @if(isset($anulacion) || isset($credito))
        <h3 class="text-center"><b>EDITAR</b></h3>
    @else
        <h3 class="text-center"><b>AGREGAR</b></h3>
    @endif
</span>
<div id="container" >
    <div class="modal-body">
        <div id="cargando_modal" class="loading" style="display: none;"></div>
        <div  class="col-md-12">
            <div  class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border" style="border-bottom: 1px solid #00a65a;">
                        <i class="fa fa-plus"></i>
                        <h3 class="box-title bold"><strong>Agregar Habilitador</strong></h3>
                    </div>
                    <div class="box-body">
                        <div class="table  table-responsive" >
                            <table id="agregar_habilitador" class="table table-striped table-bordered table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="vertical-align: middle;" class="text-center">COD. UNIF.</th>
                                        <th style="vertical-align: middle;" class="text-center">S/ ANULADO</th>
                                        <th style="vertical-align: middle;" class="text-center">N° SALDO</th>
                                        <th style="vertical-align: middle;" class="text-center"><i class="fa fa-plus"></i></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
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
                        <div class="table  table-responsive" >
                            <table id="agregar_habilitados" class="table table-striped table-bordered table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="vertical-align: middle;" class="text-center">COD. UNIF.</th>
                                        <th style="vertical-align: middle;" class="text-center">S/ CREDITO</th>
                                        <th style="vertical-align: middle;" class="text-center">S/ SALDO BALANCE</th>
                                        <th style="vertical-align: middle;" class="text-center">N° CREDITO</th>
                                        <th style="vertical-align: middle;" class="text-center"><i class="fa fa-plus"></i></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div  class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border" style="border-bottom: 1px solid #00a65a;" id="documento">
                    <span style="color:red;display:none" id="msg_documento">Nombre del Documento ya existe.</span>
                    <input type="text" id="nombre_documento" style="font-weight: bold;" class="form-control" placeholder="Ingresar Nombre de Documento" onchange="nombre_documento()" value = "{{ isset($documento) ? $documento->nombre_documento : '' }}" required>
                </div>
                <div class="box-body">
                    <div  class="col-md-12 text-center">
                        <div  class="col-md-5">
                            <caption style="color: #000 !important;text-align: center !important;"><strong>HABILITADOR</strong></caption>
                        </div>
                        <div  class="col-md-2">
                            <i class="glyphicon glyphicon-arrow-right" style="font-size: 25px;"></i>
                        </div>
                        <div  class="col-md-5">
                            <caption style="color: #000 !important;text-align: center !important;"><strong>HABILITADOS</strong></caption>
                        </div>
                    </div>
                    <div  class="col-md-6">
                        <div class="table  table-responsive" >
                            <table id="lista_habilitador" class="table table-striped table-bordered table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="vertical-align: middle;" class="text-center" width="5px"><i class='fa fa-trash'></i></th>
                                        <th style="vertical-align: middle;" class="text-center">COD. UNIF.</th>
                                        <th style="vertical-align: middle;" class="text-center">S/ ANULADO</th>
                                        <th style="vertical-align: middle;" class="text-center">N° SALDO</th>
                                    </tr>
                                </thead>
                                <tbody id="lista_cuerpo_habilitador">
                                    @php
                                        $totalhabilitador = 0
                                    @endphp
                                    @if(isset($anulacion))
                                        @foreach($anulacion as $row)
                                            <tr>
                                                <td style='text-align:center;vertical-align: middle'><button type='button' class='btn btn-danger btn-xs b_habilitador'><i class='fa fa-trash'></i></button></td>
                                                <td style='text-align:center;vertical-align: middle;cursor:pointer;' class='tooltip_nombrepry' title='{{ $row->nom_proyec }}'>{{ $row->cod_uni }}</td>
                                                <td style='text-align:center;vertical-align: middle' >{{ number_format($row->saldo_anulado,0) }}</td>
                                                <td style='text-align:center;vertical-align: middle'>{{ $row->n_anulacion }}</td>
                                            </tr>
                                            @php
                                                $totalhabilitador += $row->saldo_anulado
                                            @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot style="background-color:#72ca70c7">
                                        <th style="vertical-align: middle;" colspan="2" class="text-center">SALDO TOTAL</th>
                                        <th style="vertical-align: middle;" class="text-center" id="totalhabilitador">{{ $totalhabilitador == 0 ? "0.00" : number_format($totalhabilitador,0) }}</th>
                                        <th style="vertical-align: middle;" class="text-center"></th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div  class="col-md-6">
                        <div class="table  table-responsive" >
                            <table id="lista_habilitados" class="table table-striped table-bordered table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="vertical-align: middle;" class="text-center" width="5px"><i class='fa fa-trash'></i></th>
                                        <th style="vertical-align: middle;" class="text-center">COD. UNIF.</th>
                                        <th style="vertical-align: middle;" class="text-center">S/ CREDITO</th>
                                        <th style="vertical-align: middle;" class="text-center">S/ SALDO BALANCE</th>
                                        <th style="vertical-align: middle;" class="text-center">N° CREDITO</th>
                                    </tr>
                                </thead>
                                <tbody id="lista_cuerpo_habilitados">
                                    @php
                                        $totalhabilitados = 0
                                    @endphp
                                    @if(isset($credito))
                                        @foreach($credito as $row)
                                            <tr>
                                                <td style='text-align:center;vertical-align: middle'><button type='button' class='btn btn-danger btn-xs b_habilitados'><i class='fa fa-trash'></i></button></td>
                                                <td style='text-align:center;vertical-align: middle;cursor:pointer;' class='tooltip_nombrepry' title='{{ $row->nom_proyec }}'>{{ $row->cod_uni }}</td>
                                                <td style='text-align:center;vertical-align: middle' >{{ number_format($row->credito,0) }}</td>
                                                <td style='text-align:center;vertical-align: middle' >{{ number_format($row->saldo_balance,0) }}</td>
                                                <td style='text-align:center;vertical-align: middle'>{{ $row->n_credito }}</td>
                                            </tr>
                                            @php
                                                $totalhabilitados += $row->credito
                                            @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot style="background-color:#72ca70c7">
                                    <th style="vertical-align: middle;" colspan="2" class="text-center">CREDITO TOTAL</th>
                                    <th style="vertical-align: middle;" class="text-center" id="totalhabilitados">{{ $totalhabilitados == 0 ? "0.00" : number_format($totalhabilitados,0) }}</th>
                                    <th colspan="2" style="vertical-align: middle;" class="text-center"></th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-center" style="margin-bottom:5px;">
            @if(isset($documento))
                <button type="submit" class="btn btn-primary" id="btn_agregar" onclick='agregar(1,{{ $documento->id_documento }})'><i class="fa fa-save"> ACTUALIZAR</i></button>
                <button type="submit" class="btn btn-danger" id="btn_eliminar" onclick='eliminar(2,{{ $documento->id_documento }})'><i class="fa fa-trash"> ELIMINAR</i></button>
            @else
                <button type="submit" class="btn btn-primary" id="btn_agregar" onclick='agregar(0,null)'><i class="fa fa-save"> AGREGAR</i></button>
            @endif
            
        </div>
    </div>
</div>

<div class="pie">
