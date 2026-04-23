@extends('starter')
@section('htmlhead')

<!-- JqueryUI -->
<link rel="stylesheet" href="{{ asset('librerias/jquery-ui/themes/redmond/jquery-ui.min.css') }}">
<!-- DROPZONE -->
<link rel="stylesheet" href="{{ asset('librerias/dropzone/dropzone.min.css') }}">

@endsection
@section('body')
    <?php
    set_time_limit(700000);
    ?>
<div class="container-fluid">
    <div class="row">
      <div class="box box-default color-palette-bo">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i> Actualizar Proyecto de Inversión</h3>
          <a type="button" class="btn btn-danger pull-right" href="{{URL::to('/piptotalpriori')}}"><span class="glyphicon glyphicon-arrow-left"></span> VOLVER</a>
        </div>
        <div class="box-body">
            @if(Session::has('mensaje_error'))
            <div class="alert alert-danger">{!!Session::get('mensaje_error')!!}</div>
            <script>
              swal(
                'Error al guardar la información',
                'Revise los errores en la parte superior del formulario!',
                'error'
              );
            </script>
            @endif
            @if(Session::has('mensaje_exito'))
            <div class="alert alert-success">{!!Session::get('mensaje_exito')!!}</div>
            <script>
              swal(
                'Actualizado',
                'Los cambios se guardaron exitosamente!',
                'success'
              );
            </script>
            @endif
          <div class="row col-md-12">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Nombre del Proyecto</label>
                    <h4 style="text-align:center;font-weight:bold;"><?php echo $data['nom_proyec'] ?></h4>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group  pull-left">
                      <label for="cod_snip">Codigo Snip:</label>
                      <label for="cod_snip" class="col-md-4 form-control" readonly>{{ $data['cod_snip'] }}</label>
                  </div>
                  <div class="form-group pull-right">
                    <label for="cod_unif">Codigo Unificado:</label>
                    <label for="cod_unif" class="col-md-4 form-control" readonly>{{ $data['cod_unif'] }}</label>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Datos Generales</a></li>
          <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Evidencia Fotográfica</a></li>
          <li><a href="#tab_3" data-toggle="tab">Ubicación</a></li>
          <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
        </ul>
        <div class="tab-content" style="border: 2px solid #00a65a;border-radius: 3px;">
          <div class="tab-pane active" id="tab_1">
            <div class="row">
              <div class="col-md-12">
                <!-- collapse Datos Técnicos -->
                <div class="box box-success box-solid">
                  <div class="box-header with-border">
                    <h3 class="box-title">Datos Técnicos</h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                    <!-- /.box-tools -->
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    @if( Auth::user()->hasRole('admin') == true )
                      <form id="frm_datos" method="POST">
                        <div class="row col-md-12">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="sector">Sector:</label>
                              <input type="text" name="sector" class="form-control" value="{{ $data->sector }}">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="progr">Programa:</label>
                              <input type="text" name="progr" class="form-control" value="{{ $data->progr }}" readonly>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="sub_progr">Sub Programa:</label>
                              <input type="text" name="sub_progr" class="form-control" value="{{ $data->sub_progr }}" readonly>
                            </div>
                          </div>
                        </div>
                        <div class="row col-md-12">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="u_formul">Unidad Formuladora:</label>
                              <textarea name="u_formul" class="form-control" readonly rows="2">{{  $data->u_formul }}</textarea>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="u_ejec">Unidad Ejecutora:</label>
                              <input type="text" name="u_ejec" class="form-control" value="{{ $data->u_ejec }}" readonly>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                                <label for="ger_direc">Gerencia/Dirección:</label>
                                <select name="ger_direc" id="ger_direc" class="form-control">
                                    <option value="">Seleccione una opción</option>
                                    <option value="GERENCIA REGIONAL DE INFRAESTRUCTURA" {{ $data->ger_direc == 'GERENCIA REGIONAL DE INFRAESTRUCTURA' ? 'selected' : '' }}>GERENCIA REGIONAL DE INFRAESTRUCTURA</option>
                                    <option value="DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES" {{ $data->ger_direc == 'DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES' ? 'selected' : '' }}>DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES</option>
                                    <option value="DIRECCION REGIONAL DE AGRICULTURA" {{ $data->ger_direc == 'DIRECCION REGIONAL DE AGRICULTURA' ? 'selected' : '' }}>DIRECCION REGIONAL DE AGRICULTURA</option>
                                    <option value="GERENCIA SUB REGIONAL LIMA SUR" {{ $data->ger_direc == 'GERENCIA SUB REGIONAL LIMA SUR' ? 'selected' : '' }}>GERENCIA SUB REGIONAL LIMA SUR</option>
                                    <option value="GERENCIA REGIONAL DE DESARROLLO SOCIAL" {{ $data->ger_direc == 'GERENCIA REGIONAL DE DESARROLLO SOCIAL' ? 'selected' : '' }}>GERENCIA REGIONAL DE DESARROLLO SOCIAL</option>
                                    <option value="GERENCIA REGIONAL DE DESARROLLO ECONOMICO" {{ $data->ger_direc == 'GERENCIA REGIONAL DE DESARROLLO ECONOMICO' ? 'selected' : '' }}>GERENCIA REGIONAL DE DESARROLLO ECONOMICO</option>
                                    <option value="GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE" {{ $data->ger_direc == 'GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE' ? 'selected' : '' }}>GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE</option>
                                </select>
                            </div>
                        </div>                        
                        </div>
                          <input type="hidden" name="nom_dpto">
                          <input type="hidden" name="cod_dpto">

                          <input type="hidden" name="nom_prov">
                          <input type="hidden" name="cod_prov">

                          <input type="hidden" name="nom_dist">
                          <input type="hidden" name="cod_dist">
                        <div class="row col-md-12">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="cod_dpto">Nombre Departamento:</label>
                              <label class="form-control">LIMA</label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="cod_prov">Nombre Provincia:</label>
                              <select name="cod_prov" class="form-control" id="combo2">
                                @foreach($provCombo as $key => $item)
                                  @if($data->cod_prov == $key)
                                      <option value="{{ $key }}" selected>{{ $item }}</option>
                                  @else
                                      <option value="{{ $key }}" >{{ $item }}</option>
                                  @endif
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="cod_dist">Nombre Distrito:</label>
                              <select name="cod_dist" class="form-control" id="combo3">
                                @foreach($disCombo as $key => $item)
                                  @if($data->cod_dist == $key)
                                      <option value="{{ $key }}" selected>{{ $item }}</option>
                                  @else
                                      <option value="{{ $key }}" >{{ $item }}</option>
                                  @endif
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row col-md-12">
                          <div class="col-md-6">
                            <div class="form-group">                              
                              <label for="nom_cp">Nombre Centro Poblado:</label>
                              <input type="text" name="nom_cp" class="form-control" value="{{ $data->nom_cp }}" readonly>
                            </div>
                          </div>
                        </div>
                        <div class="row col-md-12 text-right">
                          <input type=hidden id="d_uid" name="d_uid" value="{{ $data['id'] }}"/>
                          <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span>GUARDAR</button>
                        </div>
                      </form> 
                    @else
                        <div class="row col-md-12">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="sector">Sector:</label>
                              <input type="text" name="sector" class="form-control" value="{{ $data->sector }}" readonly>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="progr">Programa:</label>
                              <input type="text" name="progr" class="form-control" value="{{ $data->progr }}" readonly>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="sub_progr">Sub Programa:</label>
                              <input type="text" name="sub_progr" class="form-control" value="{{ $data->sub_progr }}" readonly>
                            </div>
                          </div>
                        </div>
                        <div class="row col-md-12">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="u_formul">Unidad Formuladora:</label>
                              <textarea name="u_formul" class="form-control" rows="2" readonly>{{  $data->u_formul }}</textarea>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="u_ejec">Unidad Ejecutora:</label>
                              <input type="text" name="u_ejec" class="form-control" value="{{ $data->u_ejec }}" readonly>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="ger_direc">Gerencia/Direccion:</label>
                              <textarea name="ger_direc" class="form-control" rows="2" readonly>{{  $data->ger_direc }}</textarea>
                            </div>
                          </div>
                        </div>

                          <input type="hidden" name="nom_dpto">
                          <input type="hidden" name="cod_dpto">

                          <input type="hidden" name="nom_prov">
                          <input type="hidden" name="cod_prov">

                          <input type="hidden" name="nom_dist">
                          <input type="hidden" name="cod_dist">

                        <div class="row col-md-12">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="cod_dpto">Nombre Departamento:</label>
                              <label class="form-control" readonly>LIMA</label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="cod_prov">Nombre Provincia:</label>
                              <select name="cod_prov" class="form-control" id="combo2">
                                @foreach($provCombo as $key => $item)
                                  <option value="{{ $key }}" >{{ $item }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="cod_dist">Nombre Distrito:</label>
                              <select name="cod_dist" class="form-control" id="combo3">
                                @foreach($disCombo as $key => $item)
                                  <option value="{{ $key }}" >{{ $item }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row col-md-12">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="nom_cp">Nombre Centro Poblado:</label>
                              <input type="text" name="nom_cp" class="form-control" readonly>
                            </div>
                          </div>
                        </div>
                    @endif 
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- #end colapse Datos Técnicos -->
                <!-- collapse Datos Ejecución -->
                <div class="box box-success box-solid">
                  <div class="box-header with-border">
                    <h3 class="box-title">Datos de meta en ejecución</h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                    <!-- /.box-tools -->
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body" style="">
                    <div class="row">
                      <div class="col-md-12">
                        <button type="button" class="btn btn-success" onclick="loadModal('/piptotalpriori/ejecucion/obra/create','full-width','1', {{$data['id']}})"><i class="fa fa-plus"></i> Agregar Ejecución</button>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table id="obra-table" class="table table-hover table-stripped" cellspacing="0">
                            <thead style="background: #3c8dbc;color: white;">
                              <tr>
                                  <th style="text-align: center;vertical-align: middle">Acciones</th>
                                  <th style="text-align: center;vertical-align: middle">Orden de Ejecución / N° Meta</th>
                                  <th style="text-align: center;vertical-align: middle">Nombre de Meta</th>
                                  <th style="text-align: center;vertical-align: middle">Tipo de Ejecución</th>
                                  <th style="text-align: center;vertical-align: middle">Año de Ejecución</th>
                                  <th style="text-align: center;vertical-align: middle">Etapa</th>
                                  <th style="text-align: center;vertical-align: middle">Sub - Etapa</th>
                                  <th style="text-align: center;vertical-align: middle">Avance Fisico</th>
                                  <th style="text-align: center;vertical-align: middle">Total Obra</th>
                              </tr>
                            </thead>
                          </table>
                          <script>
                              var table;
                              $(document).ready(function () {
                                table = $('#obra-table').DataTable({
                                  lengthMenu: [[10, 25, 50,100], [10, 25, 50, 100]],
                                  processing: true,
                                  serverSide: true,
                                  orderCellsTop: true,
                                  autoWidth: false,
                                  stateSave: false,
                                  order: [[ 2, "desc" ]],
                                  dom: 'rt',
                                  responsive: {
                                      details: {
                                          type: 'column'
                                      }
                                  },
                                  ajax: {
                                      url: '{{ url("/piptotalpriori/ejecucion/obra/filter") }}',
                                      type: 'POST',
                                      data: function (d) {
                                            d.idproyecto = {{ $data['id'] }}
                                      }
                                  },
                                  columnDefs: [
                                      {
                                          className: "dt-center",
                                          targets: "_all"
                                      },
                                      {
                                          orderable: false,
                                          targets:   0,
                                          render: function (data, type, full, meta) {

                                              bEdit = "<button type='button' class='btn btn-primary' onclick='loadModal(\"/piptotalpriori/ejecucion/obra/edit\",\"full-width\",\"1\",\""+ data +"\")'\"><i id='E' class='fa fa-pencil' aria-hidden='true'></i></button> ";

                                              bList = "<button type='button' class='btn btn-info' onclick='loadModal(\"/piptotalpriori/ejecucion/estado/list\",\"modal_wide\",\"1\",\""+ data +"\");loadTableEstadoList(\""+data+"\")'><i id='S' class='fa fa-list' aria-hidden='true'></i></button> ";

                                              bAsignar = "<button type='button' class='btn btn-warning' onclick='loadModal(\"/piptotalpriori/ejecucion/obra/inspector/asignar\",\"full-width\",\"1\",\""+ data +"\")'\"><i id='S' class='fa fa-address-book' aria-hidden='true'></i></button> ";

                                              bDelete = "<button type='button' class='btn btn-danger' onclick='deleteEjecucion("+data+")'><i id='S' class='fa fa-trash' aria-hidden='true'></i></button>";

                                              return bEdit + bList + bAsignar + bDelete;
                                          }
                                      },
                                      {
                                          orderable: false,
                                          targets:   3,
                                          render: function (data, type, full, meta) {

                                              var str = '';
                                              switch (data) {
                                                case 'E':
                                                    str = '<label class="label label-success">EJECUCIÓN INTEGRAL</label>';
                                                  break;
                                                case 'M':
                                                    str = '<label class="label label-primary">META</label>';
                                                    break;
                                                case 'S':
                                                    str = '<label class="label label-warning">OTROS</label>';
                                                    break;
                                                default:

                                              }

                                              return str;
                                          }
                                      },
                                      {
                                          orderable: false,
                                          targets:   8,
                                          render: function (data, type, full, meta) {
                                              return "S/ " + number_format(data,2);
                                          }
                                      }

                                  ],
                                  language:{
                                      "sProcessing":     "<img src='/images/sys/pplp.gif' width='70px' height='70px'>",
                                      "sLengthMenu":     "Mostrar _MENU_",
                                      "sZeroRecords":    "No se encontraron resultados",
                                      "sEmptyTable":     "Ningún dato disponible en esta tabla",
                                      "sInfo":           "Mostrando _START_ al _END_ de _TOTAL_ registros",
                                      "sInfoEmpty":      "Vacio",
                                      "sInfoFiltered":   "(filtrado de _MAX_ registros)",
                                      "sInfoPostFix":    "",
                                      "sSearch":         "Buscar:",
                                      "sUrl":            "",
                                      "sInfoThousands":  ",",
                                      "sLoadingRecords": "Cargando...",
                                      "oPaginate": {
                                          "sFirst":    "Primero",
                                          "sLast":     "Último",
                                          "sNext":     "Siguiente",
                                          "sPrevious": "Anterior"
                                      },
                                      "oAria": {
                                          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                                      }
                                  }
                                  ,
                                  columns: [
                                      {data: 'id', name: 'accion', orderable: false, searchable: false, width: '10%'},
                                      {data: 'nro_meta', name: '', width: '8%'},
                                      {data: 'nom_meta', name: 'fecha', width: '7%', orderable: true},
                                      {data: 'tipo', name: 'tipo', width: '7%', orderable: true},
                                      {data: 'anio_ejec', name: 'anio_ejec', width: '5%'},
                                      {data: 'etapa', name: 'etapa', width: '8%'},
                                      {data: 'sub_etapa', name: 'sub_etapa', width: '8%'},
                                      {data: 'a_fisico', name: 'a_fisico', width: '10%'},
                                      {data: 'total', name: 'total', width: '10%'}
                                  ],
                                  initComplete: function (data) {

                                  }
                                });

                                deleteEjecucion = function($id){
                                    var id = $id;
                                    swal({
                                        title: '¿Estas seguro?',
                                        text: "Se eliminara la ejecucion registrada",
                                        type: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Si',
                                        cancelButtonText: 'No, cancelar!',
                                        confirmButtonClass: 'btn btn-success',
                                        cancelButtonClass: 'btn btn-danger',
                                        buttonsStyling: true
                                    }).then(function() {
                                        $.ajax({
                                            url: "/piptotalpriori/ejecucion/obra/delete",
                                            type: 'POST',
                                            data: {id: id},
                                            success: function (data) {
                                                swal(
                                                    'Listo',
                                                    'Se ha eliminado la Meta',
                                                    'success'
                                                )

                                                updateTables();
                                            },
                                            error: function(e){
                                                swal(
                                                'Error',
                                                'Error al eliminar la Meta',
                                                'error'
                                                )
                                            }
                                        });

                                    }, function(dismiss) {

                                        swal(
                                                'Cancelado',
                                                'Operación cancelada',
                                                'error'
                                        )

                                    }).catch(swal.noop);
                                }

                                $(".dateSearch").change(function (){
                                  reloadTable();
                                });

                                $("#cboEstado").change(function (){
                                  reloadTable();
                                });

                                $.fn.dataTable.ext.errMode = 'none';

                                //GERENCIA TEXT FORMATTER
                                function gerenciaTextFormatter(cellvalue, options, rowObject){
                                  var arrUE = {
                                    'DIRECCION REGIONAL DE AGRICULTURA' : 'DRA',
                                    'GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE': 'GRRNGMA',
                                    'GERENCIA SUB REGIONAL LIMA SUR' : 'GSRLS',
                                    'GERENCIA REGIONAL DE DESARROLLO ECONOMICO' :'GRDE',
                                    'GERENCIA REGIONAL DE DESARROLLO SOCIAL' : 'GRDS',
                                    'GERENCIA REGIONAL DE INFRAESTRUCTURA' : 'GRI',
                                    'DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES' : 'DRTC',
                                    'DIRECCION REGIONAL DE SALUD' : 'DIRESA',
                                    '' : ''
                                  };
                                  return arrUE[cellvalue];
                                }

                                var Inspector;
                                var IDObra;
                                searchUsuario = function(frm){
                                    event.preventDefault();

                                    $.ajax({
                                        url: '/getInspectorbyNomOrDNI',
                                        type: 'POST',
                                        data: $(frm).serialize(),
                                        beforeSend: function () {
                                            $("#loader").show();
                                            $('.modal-scrollable .btn').prop('disabled', true);

                                        },
                                        success: function (response) {

                                            var usuario = response.data;

                                            var found   = response.found;

                                            if(found){
                                                $(".modal-scrollable #lblNombre").text(usuario['apellidos'] + ", " + usuario['nombres']);
                                                $(".modal-scrollable #lblDependencia").text('GRL');
                                                $(".modal-scrollable #lblDNI").text(usuario['dni']);
                                                $(".modal-scrollable #lblCelular").text(usuario['celular']);

                                                $(".modal-scrollable #frmSearchUsuario #message").text("");

                                                Inspector = usuario

                                            } else {
                                                $(".modal-scrollable #lblNombre").text("");
                                                $(".modal-scrollable #lblDependencia").text("");
                                                $(".modal-scrollable #lblDNI").text("");
                                                $(".modal-scrollable #lblCelular").text("");

                                                $(".modal-scrollable #frmSearchUsuario #message").text("No se encontró resultado");

                                                Inspector = undefined;
                                            }

                                        },
                                        complete: function(response) {
                                            $("#loader").hide();
                                            $('.modal-scrollable .btn').prop('disabled', false);
                                        }
                                    });
                                }

                                asignarInspector = function () {
                                  if(Inspector){
                                    $.ajax({
                                      url: '/piptotalpriori/ejecucion/obra/inspector/vincular',
                                      type: 'POST',
                                      data: {idusuario:Inspector['idusuario'],idobra:$(".modal-scrollable #idobra").val()},
                                      beforeSend: function () {
                                          $("#loader").show();
                                          $('.modal-scrollable .btn').prop('disabled', true);
                                      },
                                      success: function (response) {

                                        $(".modal-scrollable #listResponsables").append('<a id = "'+ Inspector['idusuario'] +'" class="list-group-item"> '+ Inspector['apellidos'] +', '+ Inspector['nombres'] +' <i class="fa fa-user-times pull-right" aria-hidden="true" onclick="quitarInspector(this);"></i></a>');

                                      },
                                      complete: function(response) {
                                          $("#loader").hide();
                                          $('.modal-scrollable .btn').prop('disabled', false);
                                      }
                                    });

                                  }
                                }

                                quitarInspector = function (ele) {
                                  $.ajax({
                                    url: '/piptotalpriori/ejecucion/obra/inspector/desvincular',
                                    type: 'POST',
                                    data: {idusuario:$(ele).parent().attr("id"),idobra:$(".modal-scrollable #idobra").val()},
                                    beforeSend: function () {
                                        $("#loader").show();
                                        $('.modal-scrollable .btn').prop('disabled', true);
                                    },
                                    success: function (response) {
                                        $(ele).parent().remove();
                                    },
                                    complete: function(response) {
                                        $("#loader").hide();
                                        $('.modal-scrollable .btn').prop('disabled', false);
                                    }
                                  });
                                }
                              });
                          </script>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- #end colapse Datos Ejecucion -->
                <!-- collapse Datos Financieros -->
                <div class="box box-success box-solid">
                  <div class="box-header with-border">
                    <h3 class="box-title">Datos Financieros</h3>

                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                    <!-- /.box-tools -->
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body" style="">
                    <h5><b>Actualizado al: {{ $data['f_deveng_a'] }}</b></h5>
                    <div class="row col-md-12">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="m_pip">Monto de Inversión Total:</label>
                          <label class="form-control" >{{number_format($data['m_pip'],2)}}</label>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="m_viab">Monto Viable:</label>
                          <label class="form-control" >{{number_format($data['m_viab'],2)}}</label>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="m_exptec">Monto Exp. Tec.:</label>
                          <label class="form-control" >{{number_format($data['m_exptec'],2)}}</label>
                        </div>
                      </div>
                    </div>

                    <div class="row col-md-12">
                      <div class="table-responsive">
                        <table style="width: 100%; font-size:18px;border-color: black;text-align: left;font-size: 14px;" border="1" >
                             <thead style="background-color:#337ab7;color:white">
                                <tr>
                                    <th style="width: 1%;text-align:center;font-size: 15px;background-color: #3c8e3ac7;">AÑO</th>
                                    <th style="width: 1%;text-align:center;font-size: 15px;background-color: #3c8e3ac7;">PIM</th>
                                    <th style="width: 1%;text-align:center;font-size: 15px;background-color: #3c8e3ac7;">DEVENGADO</th>
                                    <th style="width: 1%;text-align:center;font-size: 15px;background-color: #3c8e3ac7;">% AVANCE FINANCIERO ANUAL</th>
                                    <!--<th style="width: 1%;text-align:center;font-size: 15px">PIM ACUMULADO</th>-->
                                    <th style="width: 1%;text-align:center;font-size: 15px">DEV. ACUMULADO</th>
                                    <th style="width: 1%;text-align:center;font-size: 15px">% AVANCE FINANCIERO TOTAL</th>
                                </tr>
                            </thead>
                            <tbody id='str' style="font-size:18px;">
                                <tr>
                                    <td  class="text-center" style="white-space: nowrap;">{{ $data['ult_anio_ejec_pry_financ'] }}</td>
                                    <td  class="text-center" style="white-space: nowrap;">{{ number_format($data['m_pim'],2) }}</td>
                                    <td  class="text-center" style="white-space: nowrap;">{{ number_format($data['m_deveng'],2) }}</td>
                                    <td  class="text-center" style="white-space: nowrap;">{{ number_format($data['a_financ'],2) }}</td>
                                    <!--<td  class="text-center" style="white-space: nowrap;">{{ number_format($data['m_pim_acu'],2) }}</td>-->
                                    <td  class="text-center" style="white-space: nowrap;">{{ number_format($data['m_deveng_a'],2) }}</td>
                                    @if($data['m_pip']==0)
                                      <td  class="text-center" style="white-space: nowrap;">0.0</td>
                                    @else
                                      <td  class="text-center" style="white-space: nowrap;">{{ number_format(($data['m_deveng_a']/$data['m_pip'])*100,2) }}</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                      </div>
                    </div>

                    <div class="row col-md-12">
                      <div class="col-md-4"><br>
                        <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#m_infFin"><i class="fa fa-files-o"></i> Detalle</button>
                      </div>

                      <!-- MODAL INFORMACION FINANCIERA/ Large modal -->
                      <div id="m_infFin" class="modal fade" tabindex="-1" data-width="760" style="top:45%;outline: none;">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                          <h3>Información Financiera</h3>
                        </div>
                        <div class="modal-body">
                          <table id="strip" style="width: 100%; font-size:12px;border-color: black;text-align: left;font-size: 14px" border="1">
                            <thead style="background-color:grey;color:white">
                              <tr>
                                <th style="width: 30px;text-align:center;font-size: 15px">EJECUTORA</th>
                                <th style="width: 30px;text-align:center;font-size: 15px">AÑO</th>
                                <th style="width: 30px;text-align:center;font-size: 15px">PIA</th>
                                <th style="width: 30px;text-align:center;font-size: 15px">PIM</th>
                                <th style="width: 30px;text-align:center;font-size: 15px">CERTIFICACIÓN</th>
                                <th style="width: 30px;text-align:center;font-size: 15px">DEVENGADO</th>
                              </tr>
                              </thead>
                            <tbody id='str'>
                              @if(!empty($InfFinanciera))
                                @foreach($InfFinanciera as $if)
                                  <tr>
                                    <td>{{ $if['uni_ejec'] }}</td>
                                    <td style="text-align: center">{{ $if['anio_financ'] }}</td>
                                    <td style="text-align: center">{{ number_format($if['pia'],2) }}</td>
                                    <td style="text-align: center">{{ number_format($if['pim'],2) }}</td>
                                    <td style="text-align: center">{{ number_format($if['certif'],2) }}</td>
                                    <td style="text-align: center">{{ number_format($if['dev'],2) }}</td>
                                  </tr>
                                @endforeach
                              @else
                                  <tr>
                                   <td colspan="6" style="text-align: center;"><b>No Se Encontró Información Financiera</b></td>
                                  </tr>
                              @endif
                            </tbody>
                          </table>
                        </div>
                        <div class="modal-footer">
                          <p class="pull-left"><b>Fuente:</b><span>Aplicativo Informático SOSEM</span></p>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                      </div>
                      <!-- ·end INFORMACION FINANCIERA/ Large modal -->
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- #end colapse Datos Financieros -->
                <!-- collapse Ubigeo -->
                <div class="box box-success box-solid">
                  <div class="box-header with-border">
                    <h3 class="box-title">Ubigeos</h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                    <!-- /.box-tools -->
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body" style="">
                    <div class="row col-md-12">
                      <table style="width: 100%; font-size:18px;border-color: black;text-align: left;font-size: 14px;white-space:nowrap" border="1">
                        <thead style="background-color:#337ab7;color:white">
                          <tr>
                            <th style="width: 1%;text-align:center;font-size: 15px">Departamento</th>
                            <th style="width: 1%;text-align:center;font-size: 15px">Provincia</th>
                            <th style="width: 1%;text-align:center;font-size: 15px">Distrito</th>
                            <th style="width: 1%;text-align:center;font-size: 15px">Localidad</th>
                          </tr>
                        </thead>
                        <tbody style="font-size:18px;">
                          @if(count($Alcance) > 0)
                            @foreach($Alcance as $row)
                              <tr>
                                <td style="white-space: nowrap;text-align:center;">{{ $row->departamento }}</td>
                                <td style="white-space: nowrap;text-align:center;">{{ $row->provincia }}</td>
                                <td style="white-space: nowrap;text-align:center;">{{ $row->distrito }}</td>
                                <td style="white-space: nowrap;text-align:center;">{{ $row->localidad }}</td>
                              </tr>
                            @endforeach
                          @else
                          <tr>
                            <td style="white-space: nowrap;text-align:center;" colspan="4">No hay datos</td>
                          </tr>
                          @endif
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- #end colapse Ubigeos -->
              </div>
            </div>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="tab_2">
              <div id = 'message'></div>
              <input type="hidden" id="uid" name="uid" value="{{ $data['cod_unif'] }}"/>
              <div class="row">
                <div class="col-md-12">
                  <div class="box" >
                    <div class="box-header with-border">
                    </div>
                    <div class="box-body" style="padding-left:30px;padding-right:30px;">
                      <div class="row">
                        <div class="col-md-4">
                          <h4 class="box-title" style="font-weight: 700;">Meta a la que pertecen(*)</h4>
                          <div class="form-group">
                            @foreach($Obras as $o)
                              <div class="radio">
                                <label><input type="radio" name="optObra" value="{{$o->id}}">
                                  <?php
                                    switch ($o->tipo) {
                                      case 'E':
                                        echo '<label style="padding-left: 5px;" class="label label-success">Ejecución Integral</label>';
                                        break;
                                      case 'M':
                                        echo '<label style="padding-left: 5px;" class="label label-primary">Meta</label>';
                                        break;
                                      case 'S':
                                        echo '<label style="padding-left: 5px;" class="label label-warning">Otros</label>';
                                        break;
                                    }
                                  ?>
                                  {{$o->nom_meta}}
                                </label>
                              </div>
                            @endforeach
                          </div>
                        </div>
                        <div class="col-md-4">
                          <h4 class="box-title" style="font-weight: 700;">Tiempo de toma de imagenes(*)</h4>
                          <div class="form-group">
                            <div class="radio"><label><input type="radio" name="tiempo" value="antes"> Antes de la Ejecución</label></div>
                            <div class="radio"><label><input type="radio" name="tiempo" value="durante"> Durante la Ejecución</label></div>
                            <div class="radio"><label><input type="radio" name="tiempo" value="despues"> Despues de la Ejecución</label></div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <h4 class="box-title" style="font-weight: 700;">Tipo(*)</h4>
                          <div class="form-group">
                            <div class="radio"><label><input type="radio" name="tipo" value="E"> Primera piedra</label></div>
                            <div class="radio"><label><input type="radio" name="tipo" value="PP" checked> Ejecución</label></div>
                            <div class="radio"><label><input type="radio" name="tipo" value="I"> Inauguración</label></div>
                            <div class="radio"><label><input type="radio" name="tipo" value="P"> Paralizado</label></div>
                            <div class="radio"><label><input type="radio" name="tipo" value="O"> Otro</label></div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-8">
                          <h4 class="box-title" style="font-weight: 700;">Descripción (Opcional)</h4>
                          <div class="form-group">
                            <textarea id = "txtDescripcion" class="form-control"></textarea>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <h4 class="box-title" style="font-weight: 700;">Fecha de toma de las imagenes anexadas(*)</h4>
                          <div class="form-group">
                              <input type="date" class="form-control" name="fecha" id="fecha" />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                              <h3><span id="counter"></span></h3>
                              <h4 class="box-title" style="font-weight: 700;">Insertar fotos (3 como minimo) (*)</h4>
                              <form action="{{ action('PipTotalPrioriController@imgUpload') }}" class="dropzone text-center" files="true" id="dzone">
                                <div class="dz-message">
                                </div>
                                <div class="fallback">
                                    <input name="file" type="file" multiple />
                                </div>
                                <div class="dropzone-previews" id="dropzonePreviewAntes"></div>
                                <h4 style="text-align: center;color:#428bca;">Arrastra las imagenes a esta área  <span class="glyphicon glyphicon-open-file"></span></h4>
                                <button id="submit-all">Guardar</button>
                              </form>
                          </div>
                        </div>
                      </div>
                      <div class="text-left">
                        <b>(*) Campos Obligatorios.</b>
                      </div>
                    </div>
                  </div>
                  <hr width="100%" style="border-top: 1px solid #000;" />
                  <!-- Dropzone Preview Template -->
                  <div id="preview-template" style="padding-left:25px;padding-right:25px;">
                      <div class="dz-preview dz-file-preview">
                          <div class="dz-image"><img data-dz-thumbnail=""></div>
                          <input type="hidden" class="serverfilename"/>
                          <div class="dz-details">
                              <div class="dz-size"><span data-dz-size=""></span></div>
                              <div class="dz-filename"><span data-dz-name=""></span></div>
                          </div>
                          <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
                          <div class="dz-error-message"><span data-dz-errormessage=""></span></div>
                          <div class="dz-success-mark">
                          </div>
                          <div class="dz-error-mark">
                          </div>
                      </div>
                  </div>
                  <!-- End Dropzone Preview Template -->
                  <!-- BOXES -->
                  <div id="imgPorEjecucion" style="padding-left:25px;padding-right:25px;">
                  </div>
                </div>
              </div>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="tab_3">
          <br/>
              <form id="frm_location" class="ubicacion" method="POST">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="col-md-2 col-md-offset-1">
                              <div class="input-group">
                                  <span class="input-group-addon">
                                    <label for="cod_prov">Ubigeo</label>
                                  </span>
                                  <div>
                                    <input type="text" name="cod_prov" id="ubigeo" class="form-control" disabled>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <br/>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="col-md-3 col-md-offset-1">
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                  <input type="text" class="form-control col-md-12" id="pac-input" placeholder="Busqueda en mapa"/>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="input-group">
                                  <span class="input-group-addon">
                                    <label for="latitud">Latitud</label>
                                  </span>
                                    <input type="text" name="latitud" id="lat" class="form-control">
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="input-group">
                                  <span class="input-group-addon">
                                    <label for="longitud">Longitud</label>
                                  </span>
                                  <input type="text" name="longitud" id="lon" class="form-control">
                              </div>
                          </div>
                      </div>
                      <br>
                      <div class="mapContainer col-md-offset-1 col-md-10">
                        <div class="row">
                            <div id="map"></div>
                        </div>
                      </div>
                  </div>
                  <br>
                  <div class="modal-footer">
                    <div class="row">
                      <a type="button" class="btn btn-danger" href="{{URL::to('/piptotalpriori')}}"><span class="glyphicon glyphicon-arrow-left"></span> VOLVER</a>
                      <input type="hidden" id="uid" name="uid" value="{{ $data['cod_unif'] }}"/>
                      <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> GUARDAR</button>
                    </div>
                  </div>
              </form>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
    </div>

    <script  src="https://momentjs.com/downloads/moment.js"></script>
    <!-- MAIN SCRIPT -->
    <script>
        //INIT
        $(function(){
                      
        //=========== TAB FICHA ===================

            //POPULATING DDLS
            selectDistrito();
            //comboUno();
            $("#combo2").change(function () {
                comboUno();
            });

            $("#combo4").change(function () {
                comboDos();
            });

            //============== TAB UBICACION =============
            getLocationInfo();
            $('#tabUbicacion').click(function(e) {
                //getLocationInfo();
                setTimeout(initMap, 500);
            });

        });
    </script>

    <script>
        //============================ FICHA TECNICA ==============================
        function comboUno() {
            $("#combo2 option:selected").each(function () {
                var id = $(this).val();
                if (id == "")
                    id = 0;
                $.ajax({
                    url: "{{URL::to('/piptotalpriori/combodistrito')}}/" + id,
                    success: function (data)
                    {
                        $("#combo3").html(data);
                    }
                });
            });
        }
        function selectDistrito(){
            $("#combo3 option:selected").each(function () {
                var distrito = $(this).val();
                console.log(distrito);
                comboUno();
                setTimeout(function () {
                    $("#combo3 option").each(function(){
                        //console.log($(this).val(),distrito);
                        if($(this).val() === distrito){ // EDITED THIS LINE
                            //console.log($(this).val());
                            $(this).attr("selected","selected");
                        }
                    });
                },1500);
            });
        }

        //============================== UBICACIÓN ================================

        // GET LOCATION SAVED OR SET DEFAULT
        var lat = -11.127036;
        var lon = -77.596699;
        function getLocationInfo(){
            uid = document.getElementById('uid').value;
            $.ajax({
                url: "/getLocationInfo",
                type:'POST',
                data: {uid:uid},
                success: function (data)
                {
                    $('#lat').val(data.data['latitud']);
                    $('#lon').val(data.data['longitud']);
                    $('#ubigeo').val(data.data['cod_dist']);
                    //console.log(!isNaN(data.data['latitud']));
                    //console.log(!isNaN(data.data['longitud']));
                    //console.log(!isNaN(data.data['latitud'])==true && !isNaN(data.data['latitud'])==true);
                    //console.log(isNaN(data.data['latitud'])==true && !isNaN(data.data['latitud'])==true);
                    if( (data.data['latitud'].length === 0 || !data.data['latitud']) && (data.data['longitud'].length === 0 ||  !data.data['longitud']) ){
                        lat = -11.127036;
                        lon = -77.596699;
                    } else {
                        lat = parseFloat(data.data['latitud']);
                        lon = parseFloat(data.data['longitud']);
                    }
                }
            });
        }

        //LOAD GOOGLE MAPS API
        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: lat, lng: lon},
                zoom: 100,
                mapTypeId: google.maps.MapTypeId.HYBRID
            });

            var marker = new google.maps.Marker({
                position: {lat: lat, lng: lon},
                map: map
            });
            console.log(lat,lon);
            google.maps.event.addListener(map, 'click', function( event ){
                $('#lat').val(event.latLng.lat());
                $('#lon').val(event.latLng.lng());

            });
            google.maps.event.trigger(map, 'resize');
            google.maps.event.addListenerOnce(map, 'idle', function() {
                google.maps.event.trigger(map, 'resize');
            });
            // Create the search box and link it to the UI element.
            var input = /** @type {HTMLInputElement} */ (
                    document.getElementById('pac-input'));


            var searchBox = new google.maps.places.SearchBox(
                    /** @type {HTMLInputElement} */
                    (input));
            // Listen for the event fired when the user selects an item from the
            // pick list. Retrieve the matching places for that item.
            var markers = [];
            google.maps.event.addListener(searchBox, 'places_changed', function() {
                var places = searchBox.getPlaces();
                if (places.length == 0) {
                    return;
                }

                // Clear out the old markers.
                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
                markers = [];

                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {
                    var icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };

                    // Create a marker for each place.
                    markers.push(new google.maps.Marker({
                        map: map,
                        icon: icon,
                        title: place.name,
                        position: place.geometry.location
                    }));

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });
        }
        //SAVE LOCATION PARAMS
        $("#frm_location").submit(function(e){
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: '/updateLocationInfo',
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('button').attr('disabled','disabled');
                },
                success: function (response) {
                    $('button').removeAttr('disabled');
                    swal(
                            'Correcto',
                            'Datos actualizados correctamente!',
                            'success'
                    );
                    getLocationInfo();
                },
                error: function(response){
                    $('button').removeAttr('disabled');
                    response = $.parseJSON(response.responseText);
                    swal(
                            'Error',
                            'Error al guardar los cambios',
                            'error'
                    );
                }
            });
            return false;
        });

        $("#frm_datos").submit(function(e){
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: '/update_datos_TotalPriori',
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                },
                success: function (response) {
                    swal(
                            'Correcto',
                            'Datos actualizados correctamente!',
                            'success'
                    );
                },
                error: function(response){
                    response = $.parseJSON(response.responseText);
                    swal(
                            'Error',
                            'Error al guardar los cambios',
                            'error'
                    );
                }
            });
            return false;
        });

        //INPUT COLOR CHANGE ON TEXT MODIFICATION
        $(".form-control").focus(function(){
            var that = this;
            var a_val = $(this).val();
            $(this).keyup(function(){
                if(a_val === $(that).val()){
                    $(that).css({"background-color":"white","color":"black"});
                }else{
                    $(this).css({"background-color":"rgb(0,114,200)","color":"white"});
                }
            });
            $(this).change(function(){
                if(a_val === $(that).val()){
                    $(that).css({"background-color":"white","color":"black"});
                }else{
                    $(this).css({"background-color":"rgb(0,114,200)","color":"white"});
                }
            });

        });

        //PREVENT FORM SUBMITTING ON KEY ENTER PRESS
        $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
          if(e.which == 13) {
            e.preventDefault();
            return false;
          }
        });
    </script>

    <!-- DROPZONE -->
    <script src="{{ asset('/librerias/dropzone/dropzone.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
    <script type="text/javascript" src= "//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <!--script type="text/javascript" src= "https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script-->
    <script>

        function formato_numero(e){
          if (e.id=='m_exp_tec') {
            $("#m_exp_tec").val(number_format($("#m_exp_tec").val(),2));
          }else if(e.id=='m_vreferencial'){
            $("#m_vreferencial").val(number_format($("#m_vreferencial").val(),2));
          }else if(e.id=='m_supervision'){
            $("#m_supervision").val(number_format($("#m_supervision").val(),2));
          }
        }
      
        function number_format(amount, decimals) {

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

            return amount_parts.join('.');
        }

        function total_obra(e)
        {
          m_exp_tec=parseFloat($("#m_exp_tec").val().replace(/[^0-9\.]/g, ''));
          m_vreferencial=parseFloat($("#m_vreferencial").val().replace(/[^0-9\.]/g, ''));
          m_supervision=parseFloat($("#m_supervision").val().replace(/[^0-9\.]/g, ''));
          total=(m_exp_tec + m_vreferencial + m_supervision);
          $("#total_obra").text('S/ ' + number_format(total,2));
        }

        function buscar_contrato(e)
        {
          $.ajax({
            url: "{{URL::to('/piptotalpriori/buscacontrato')}}",
            data:{'n_contrato':$(e).val(),idproyecto:{{$data['id']}}},
            beforeSend: function () {
            },
            success: function (response) {
              if (response.data.length >0) {
                $("#f_contrato").val(response.data[0].contrato_fecha);
                $("#m_ejecucion").val(response.data[0].mon_monto);
              }else {
                $("#f_contrato").val('');
                $("#m_ejecucion").val('0.00');
              }
            },
            complete: function(response) {
            },
            error: function (response){
              try{
                var data = $.parseJSON(response.responseText);
              }catch(Exception){
                console.log('Error de conexión');
              }
            }
          });
        }

        function AdmOContM(e){
          var x = $(e).val();
          if(x === 'CONTRATA'){
            $("#dvNro_ContratoM").show();
          } else {
            $("#dvNro_ContratoM").hide();
          }
        }

        function AdmOContMopc(e){
          var x = $(e).val();
          if(x === 'CONTRATA'){
            $("#dvNro_ContratoMopc").show();
          } else {
            $("#dvNro_ContratoMopc").hide();
          }
        }

        function loadModal(url,modaltype,CRUD,opc) {
          $modal = $('#' + modaltype);
          //clean errors
          $(".m-message").html('<div></div>');
          switch (CRUD) {
              case '1':
                  $.ajax({
                      url: url,
                      type: 'POST',
                      data: {'id': opc},
                      beforeSend: function () {
                          // $("#error").fadeOut();
                      },
                      success: function (response) {
                          $('#' + modaltype + ' .modal-title').html($(response).filter('.cabecera'));
                          $('#' + modaltype + ' .modal-body').html($(response).filter('#container'));
                          $('#' + modaltype + ' .modal-footer').append($(response).filter('.pie'));
                          $('#' + modaltype).modal('show', {backdrop: 'true'});
                      },
                      error : function (response) {

                      }
                  }).done(function(){

                    AdmOContM($("#mod_ejec"));

                    $( "#situa_obra, #cboEtapa, #cboSubEtapa, #a_fisico_obra" ).bind( "change keyup", function() {
                        var currentDate = new Date();
                        var day = currentDate.getDate();
                        var month = currentDate.getMonth() + 1;
                        var year = currentDate.getFullYear();
                        if(day <10){
                            day = '0' + day;
                        }
                        if(month<10){
                            month = '0' + month;
                        }
                        var today =year + "-" + month + "-" + day  ;
                        // console.log(today);
                        $("#fecha_act").val(today).prop('required',true);
                    });

                    if($("#a_fisico_obra").val() === ''){
                      $("#a_fisico_obra").val('0.00');
                    }

                    $( "#a_fisico_obra" ).bind( "change keyup", function() {

                        var valor = $(this).val();
                        if(valor === ''){
                            $(this).val('0.00');
                        }
                    });

                    total_obra();

                  });
                  break;
          }
        }

        updateObra = function(e) {
          e.preventDefault();
            $.ajax({
              method: "POST",
              url: $("#frmObra").attr('action'),
              data: $("#frmObra").serialize(),
              beforeSend: function () {

              },
              error: function (response){
                try{
                  var data = $.parseJSON(response.responseText);
                }catch(Exception){
                  console.log('Error');
                }

                var li = "";
                $.each(data,function(key,val){
                      li += "<li>" + val + "</li>";
                });
                $('.validation-message').remove();
                $("#frmObra").prepend('<div id = "frm_message" class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' + li + '</div>');
                $(".modal-scrollable").animate({ scrollTop: 0 }, 'slow');

                $("#frm_message").focus();
              },
              success: function (response) {
                    $('.validation-message').remove();
                    swal(
                          'Guardado',
                          'Los cambios se guardaron exitosamente!',
                          'success'
                        );
                    updateTables();
              }
            });
          };

        loadSubEtapa = function(){

          var etapa = $('.modal-scrollable #cboEtapa :selected').val();
          if (etapa=='CULMINADO' || etapa=='EN LIQUIDACIÓN' || etapa=='EN TRANSFERENCIA') {
            $("#f_inicio").prop('required',true);
            $("label[for='f_inicio']").text("Fecha Inicio Programada (*)");
            $("#f_termino").prop('required',true);
            $("label[for='f_termino']").text("Fecha Finalización Programada (*)");
            $("#mod_ejec").prop('required',true);
            $("label[for='mod_ejec']").text("Modalidad de Ejecucion de la obra (*)");
          }else {
            $("#f_inicio").prop('required',false);
            $("label[for='f_inicio']").text("Fecha Inicio Programada");
            $("#f_termino").prop('required',false);
            $("label[for='f_termino']").text("Fecha Finalización Programada");
            $("#mod_ejec").prop('required',false);
            $("label[for='mod_ejec']").text("Modalidad de Ejecucion de la obra");
          }


          $.ajax({
            url: "{{URL::to('/piptotalpriori/combosubetapa')}}/" + etapa,
            beforeSend: function () {
              $("#loader").show();
            },
            success: function (response) {
              $(".modal-scrollable #cboSubEtapa").html(response);
            },
            complete: function(response) {
              $("#loader").hide();
            }
          });
        }

        cambiarsubetapa = function()
        {
          var etapa = $('.modal-scrollable #cboEtapa :selected').val();
          var subetapa = $('.modal-scrollable #cboSubEtapa :selected').val();
          if (etapa=='EN EJECUCIÓN'){
            if (subetapa=='POR INICIAR' || subetapa=='EN EJECUCIÓN' || subetapa== 'ARBITRAJE' || subetapa=='PARALIZADO') {
              $("#f_inicio").prop('required',true);
              $("label[for='f_inicio']").text("Fecha Inicio Programada (*)");
              $("#f_termino").prop('required',true);
              $("label[for='f_termino']").text("Fecha Finalización Programada (*)");
              $("#mod_ejec").prop('required',true);
              $("label[for='mod_ejec']").text("Modalidad de Ejecucion de la obra (*)");
            }else {
              $("#f_inicio").prop('required',false);
              $("label[for='f_inicio']").text("Fecha Inicio Programada");
              $("#f_termino").prop('required',false);
              $("label[for='f_termino']").text("Fecha Finalización Programada");
              $("#mod_ejec").prop('required',false);
              $("label[for='mod_ejec']").text("Modalidad de Ejecucion de la obra");
            }
          }
        }

        function cambiaretapa() {
          etapa=$('#cboEtapa').val();
          if (etapa=='EN EJECUCIÓN' || etapa=='CULMINADO' || etapa=='EN LIQUIDACIÓN' || etapa=='EN TRANSFERENCIA' ) {
            $('#estado_obli').show();
            $('#estado_obli_cab').show();
          }else {
            $('#estado_obli').hide();
            $('#estado_obli_cab').hide();
          }
        }

        loadfrmEdit = function(id){
          $.ajax({
            url: '/piptotalpriori/ejecucion/estado/edit',
            type: 'POST',
            data: {'id': id},
            beforeSend: function () {
              $("#loader").show();
            },
            success: function (response) {
              $('#full-width .modal-title').html($(response).filter('.cabecera'));
              $('#full-width .modal-body').html($(response).filter('#container'));
              $('#full-width .modal-footer').append($(response).filter('.pie'));
              $('#full-width').modal('show', {backdrop: 'true'});
            },
            complete: function(response) {
              $("#loader").hide();
              fireDZ(id);
              cargarImg(id);
            //FANCYBOX INIT
            $(".fancybox").fancybox();
            },
            error: function(response){
              $("#loader").hide();
            }
          });
        }

        cargarImg = function(id){
          var imguid = id;
          $.get('/piptotalpriori/ejecucion/estado/img/get/' + imguid.toString(), function(data) {
          $('#full-width #obras').html('');
              //console.log(data.taller_img.length);
              if(data.taller_img.length != 0){
                  $.each(data.taller_img, function (key, value) {
                    url = '/images' + value.url + "/" + value.nombre;
                    $('#full-width #obras')
                    .append('<div class="container col-lg-3 col-sm-6 col-md-4 col-xs-12">'
                                +'<div style="border:1px solid;border-radius:2%;margin-right:8px;margin-top:12px;">'
                                    +'<a class="fancybox" rel="group" href="'+ url +'">'
                                        +'<img width=100% height=150px src="'+ url +'" alt="" />'
                                    +'</a>'
                                    +'<div style="height:35px;text-align:left;background-color:rgba(208, 206, 206, 0.83);">'
                                        +'<span style="font-weight:bold">&nbsp&nbspFecha: ' + value.created_at + '</span>'
                                    +'</div>'
                                    +'<div style="height:35px;text-align:left;background-color:rgba(208, 206, 206, 0.83);">'
                                        + '<button style="float:right" onclick = "deleteImg('+value.id+','+imguid
                                        +')" class="btn btn-danger"><i class="fa fa-trash"></i></button> '
                                        <?php
                                            if( Auth::user()->hasRole('admin') or Auth::user()->hasRole('adminpoi') ){
                                        ?>
                                        + '<button style="float:right" onclick = "showImgData('+value.id+')" class="btn btn-info"><i class="fa fa-eye"></i></button>'
                                        <?php
                                            }
                                        ?>
                                    +'</div>'
                                +'</div>'
                            +'</div>');
                     });
              } else {
                  $('#full-width #obras').append('<h4>No hay imágenes disponibles</h4>');
              }
          });
        };

        fireDZ = function(id){
          var id = id;
          var counter = 0;
          var actual = 0;
          var cleanUp = true;    ;
          $("#full-width #dzone").dropzone({
            uploadMultiple: true,
            autoProcessQueue: false,
            maxFiles: 1,
            parallelUploads: 1,
            maxFilesize: 250,
            acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg,.mp4,.mkv,.avi",
            previewsContainer: '#dropzonePreviewAntes',
            previewTemplate: document.querySelector('#preview-template').innerHTML,
            addRemoveLinks: true,
            dictRemoveFile: 'Quitar',
            //dictFileTooBig: 'La imagen es mayor a 8MB',
            dictRemoveFileConfirmation: "¿Estas seguro que deseas quitar esta imagen?",
            // The setting up of the dropzone
            createImageThumbnails: true,
            maxThumbnailFilesize: 100,
          init:function() {
              var dzuid = id;
              var submitButton = document.querySelector("#submit-all");
              myDropzone = this; // closure
              submitButton.addEventListener("click", function(event) {
                  event.preventDefault();
                  if($('#fecha').val() !== '') {
                      myDropzone.processQueue(); // Tell Dropzone to process all queued files.
                  } else{
                      $('#submit-all').attr('disabled','disabled').addClass('btn btn-alert');
                  }
              });
              $('input[type=radio][name=tipo]').change(function() {
                  cleanUp = false;
                  btnState(actual);
              });
              this.on("addedfile", function(file) {
                  actual++;
                  console.log(file);
                  btnState(actual);
              });
              this.on("maxfilesexceeded", function(){
                  swal(
                          'Error',
                          'Solo Puede subir una imagen!',
                          'error'
                  );
              });
              indx = 0;
              this.on("sendingmultiple", function(file, xhr, formData){
                  var csrf_token = $('meta[name="csrf-token"]').attr('content');
                  var uid = id;
                  var nDate = new Date(file[0].lastModified)
                  var datestring = nDate.getFullYear() + "-" +
                                   ("0"+(nDate.getMonth()+1)).slice(-2) + "-" +
                                   ("0" + nDate.getDate()).slice(-2) + " " +
                                   ("0" + nDate.getHours()).slice(-2) + ":" +
                                   ("0" + nDate.getMinutes()).slice(-2) + ":" +
                                   ("0" + nDate.getSeconds()).slice(-2);
                  console.log(JSON.stringify(file[0]));
                  formData.append('uid',id);
                  formData.append('fecha',datestring);
                  formData.append('cdata', file[0].lastModifiedDate+ ";" + file[0].name + ";" + file[0].lastModified  );
                  formData.append('_token', csrf_token);
              });
              this.on("error", function(file){if (!file.accepted) this.removeFile(file);});
              this.on("removedfile", function(file) {
                  actual--;
                  btnState(actual);
              });
          },
          error: function(file, response) {
              $('.validation-message').remove();
              if(response.error){
                  if(response.messages){
                      var li = "";
                      $.each(response.messages, function( index, value ) {
                          li += "<li>"+ value +"</li>";
                      });
                      $('#message').prepend('<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' + li + '</div>');
                      swal(
                          'Error',
                          'Error al subir la imagen, intentelo nuevamente!',
                          'error'
                      );
                  }
                  else if(response.message){
                      $('.validation-message').remove();
                      var li = "";
                      $('#message').prepend('<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' + response.message + '</div>');
                      swal(
                          'Error',
                          response.message,
                          'error'
                      );
                  }
              }
          },
          success: function(file,response) {
              $('.validation-message').remove();
              var myDropzone = this;
              $('.serverfilename', file.previewElement).val(response.filename);
              counter++;
              $("#photoCounterAntes").text( "(" + counter + ")");

              //$('#message').html('<div class=\'alert alert-success fade in\'>La imagen se Guardó Exitosamente</div>');
              cargarImg(id);
              cleanUp = false;
              myDropzone.removeAllFiles();
              swal(
                      'Correcto',
                      'La imágen se guardó correctamente',
                      'success'
              );
              //$("#poitaller-table").ajax.reload();
          }
          });
        };

        var tableObras;
        loadTableEstadoList = function($id){
          setTimeout(function(){
            tableObras = $('.modal-scrollable #listestado-table').DataTable({
              processing: true,
              serverSide: true,
              orderCellsTop: true,
              autoWidth: false,
              stateSave: false,
              dom: 'rt',
              responsive: {
                details: {
                    type: 'column'
                }
              },
              ajax: {
                url: '{{ url("/piptotalpriori/ejecucion/estado/filter") }}',
                type: 'POST',
                data: function (d) {
                    d.id = $id;
                },
              },
              columnDefs: [
                {
                    className: "dt-center",
                    targets: "_all"
                },
                {
                    orderable: false,
                    targets:   0,
                    render: function (data, type, full, meta) {
                        bEdit = "<button type='button' class='btn btn-primary' onclick='loadfrmEdit(" + data + ")'><i id='E' class='fa fa-pencil' aria-hidden='true'></i></button> ";
                        bDelete = "<button type='button' class='btn btn-danger' onclick='deleteEstado("+ data +")'><i id='S' class='fa fa-trash' aria-hidden='true'></i></button> ";
                        return bEdit + bDelete;
                    }
                }
              ],
              language:{
                "sProcessing":     "<img src='/images/sys/pplp.gif' width='70px' height='70px'>",
                "sLengthMenu":     "Mostrar _MENU_",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando _START_ al _END_ de _TOTAL_ registros",
                "sInfoEmpty":      "Vacio",
                "sInfoFiltered":   "(filtrado de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
              },
              columns: [
              {data: 'id', name: 'accion', orderable: false, searchable: false, width: '10%'},
              {data: 'fecha_act', name: 'fecha_act', width: '8%'},
              {data: 'etapa', name: 'etapa', width: '8%'},
              {data: 'sub_etapa', name: 'sub_etapa', width: '7%', orderable: false},
              {data: 'est_situ', name: 'est_situ', width: '7%', orderable: false},
              {data: 'a_fisico', name: 'a_fisico', width: '5%'}
              ]
            });
            $.fn.dataTable.ext.errMode = 'none';
          },2000);
        }

        deleteEstado = function($id){
          var id = $id;
          swal({
              title: '¿Estas seguro?',
              text: "Se eliminara la ejecucion registrada",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si',
              cancelButtonText: 'No, cancelar!',
              confirmButtonClass: 'btn btn-success',
              cancelButtonClass: 'btn btn-danger',
              buttonsStyling: true
          }).then(function() {
              $.ajax({
                  url: "/piptotalpriori/ejecucion/estado/delete",
                  type: 'POST',
                  data: {id: id},
                  success: function (data) {
                      swal(
                          'Listo',
                          'Se ha eliminado el estado',
                          'success'
                      )
                      tableObras.ajax.reload( null, false );
                  },
                  error: function(e){
                      swal(
                      'Error',
                      'Error al eliminar estado',
                      'error'
                      )
                  }
              });
          }, function(dismiss) {
              swal(
                'Cancelado',
                'Operación cancelada',
                'error'
              )
          }).catch(swal.noop);
        }

        deleteImg = function($id, $idtaller){
          var id = $id;
          swal({
            title: '¿Estas seguro?',
            text: "Se eliminara esta imagen",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No, cancelar!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: true
          }).then(function() {
          $.ajax({
              url: "/piptotalpriori/ejecucion/estado/img/delete",
              type: 'POST',
              data: {id: id},
              success: function (data) {
                  cargarImg($idtaller);
                  swal(
                      'Listo',
                      'Se ha eliminado la imagen',
                      'success'
                  )
                  tableObras.ajax.reload( null, false );
              },
              error: function(e){
                  swal(
                  'Error',
                  'Error al eliminar la imagen',
                  'error'
                  )
              }
          });
          }, function(dismiss) {
            swal(
                    'Cancelado',
                    'Operación cancelada',
                    'Error'
            )
          }).catch(swal.noop);
        };

        function divMeta(){
          console.log($('input[class=tipometa]:checked').val());
          if ( $('input[class=tipometa]:checked').val() == 'E' ) {
            $('#divMeta').hide();
          } else {
            $('#divMeta').show();
            if ($('input[class=tipometa]:checked').val() == 'S') {
              $('#meta_ocul').hide();
              $("#cl_nom_meta").removeClass("col-md-9");
              $("#cl_nom_meta").addClass("col-md-12");
              $('#cl_nom_meta_s').show();
            }else {
              $('#meta_ocul').show();
              $("#cl_nom_meta").removeClass("col-md-12");
              $("#cl_nom_meta").addClass("col-md-9");
              $('#cl_nom_meta_s').hide();
            }
          }
        }

        $years=[];
        function calculotiempo(){
          $years=[];
            var inicio = new Date($('#f_inicio').val()).getFullYear();
            var termino = new Date($('#f_termino').val()).getFullYear();
            var dias=0;
            if (inicio != termino && inicio<termino) {
              $years.push(inicio);
              for (var i = 1; i < termino-inicio; i++) {
                $years.push(inicio+i);
              }
              $years.push(termino);
            }else {
              $years.push(inicio);
            }
            $("#anio_ejec").val($years);
            dias= moment($('#f_termino').val()).diff(moment($('#f_inicio').val()), 'days');
            if (dias>0) {
              $('#t_ejec_dias').val(dias);
            }else {
              $('#t_ejec_dias').val(0);
            }
        }

        showImgData = function($id){
          $.ajax({
            url: '/piptotalpriori/ejecucion/estado/img/meta',
            type: 'POST',
            data: {'id': $id},
            beforeSend: function () {
              $("#loader").show();
            },
            success: function (response) {
              $('#modal_simple .modal-title').html($(response).filter('.cabecera'));
              $('#modal_simple .modal-body').html($(response).filter('#container'));
              $('#modal_simple .modal-footer').append($(response).filter('.pie'));
              $('#modal_simple').modal('show', {backdrop: 'true'});
            },
            complete: function(response) {
              $("#loader").hide();
            }
          });
        };

        var valorizacionSubmit = function(frm){
          event.preventDefault();
          $.ajax({
              url: '/piptotalpriori/ejecucion/estado/add',
              type: 'POST',
              data: $(frm).serialize(),
              beforeSend: function () {
                $("#loader").show();
              },
              success: function (response) {
                swal(
                        'Listo',
                        response,
                        'success'
                    )
              },
              complete: function(response) {
                $("#loader").hide();
                updateTables();
              }
            });
        };

        updateTables = function(){
          table.ajax.reload( null, false );
          tableObras.ajax.reload( null, false );
        }

        function btnState(actual){
          if( actual > 0 ){
            $('.modal-scrollable #submit-allObraEstado').show();
            $('.modal-scrollable #btnAddPhotoObraEstado').css('display','none');
          }else{
            $('.modal-scrollable #submit-allObraEstado').css('display','none');
            $('.modal-scrollable #btnAddPhotoObraEstado').show();
          }
        }

        dzoneclick = function(){
          $('.modal-scrollable #dzoneObraEstado').trigger('click');
        };

        fireDZ = function(id){
          var id = id;
          var counter = 0;
          var actual = 0;
          var cleanUp = true;
          $("#full-width #dzoneObraEstado").dropzone({
            uploadMultiple: true,
            autoProcessQueue: false,
            maxFiles: 1,
            parallelUploads: 1,
            maxFilesize: 250,
            acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg,.mp4,.mkv,.avi",
            previewsContainer: '#dropzonePreviewAntesObraEstado',
            previewTemplate: document.querySelector('.modal-scrollable #preview-template-ObraEstado').innerHTML,
            addRemoveLinks: true,
            dictRemoveFile: 'Quitar',
            //dictFileTooBig: 'La imagen es mayor a 8MB',
            dictRemoveFileConfirmation: "¿Estas seguro que deseas quitar esta imagen?",
            // The setting up of the dropzone
            createImageThumbnails: true,
            maxThumbnailFilesize: 100,
            init:function() {
                var dzuid = id;
                var submitButton = document.querySelector(".modal-scrollable #submit-allObraEstado");
                myDropzone = this; // closure
                submitButton.addEventListener("click", function(event) {
                    event.preventDefault();
                    myDropzone.processQueue(); // Tell Dropzone to process all queued files.
                });
                $('input[type=radio][name=tipo]').change(function() {
                    cleanUp = false;
                    btnState(actual);
                });
                this.on("addedfile", function(file) {
                    actual++;
                    console.log(file);
                    btnState(actual);
                });
                this.on("maxfilesexceeded", function(){
                    swal(
                            'Error',
                            'Solo Puede subir una imagen!',
                            'error'
                    );
                });
                indx = 0;
                this.on("sendingmultiple", function(file, xhr, formData){
                    var csrf_token = $('meta[name="csrf-token"]').attr('content');
                    var uid = id;
                    var nDate = new Date(file[0].lastModified)
                    var datestring = nDate.getFullYear() + "-" +
                                     ("0"+(nDate.getMonth()+1)).slice(-2) + "-" +
                                     ("0" + nDate.getDate()).slice(-2) + " " +
                                     ("0" + nDate.getHours()).slice(-2) + ":" +
                                     ("0" + nDate.getMinutes()).slice(-2) + ":" +
                                     ("0" + nDate.getSeconds()).slice(-2);
                    console.log(JSON.stringify(file[0]));
                    formData.append('uid',id);
                    formData.append('fecha',datestring);
                    formData.append('cdata', file[0].lastModifiedDate+ ";" + file[0].name + ";" + file[0].lastModified  );
                    formData.append('_token', csrf_token);
                });
                this.on("error", function(file){if (!file.accepted) this.removeFile(file);});
                this.on("removedfile", function(file) {
                    actual--;
                    btnState(actual);
                });
            },
            error: function(file, response) {
                $('.modal-scrollable .validation-message').remove();
                if(response.error){
                    if(response.messages){
                        var li = "";
                        $.each(response.messages, function( index, value ) {
                            li += "<li>"+ value +"</li>";
                        });
                        $('#message').prepend('<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' + li + '</div>');
                        swal(
                            'Error',
                            'Error al subir la imagen, intentelo nuevamente!',
                            'error'
                        );
                    } else if(response.message){
                        $('modal-scrollable .validation-message').remove();
                        var li = "";
                        $('#message').prepend('<div class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' + response.message + '</div>');
                        swal(
                            'Error',
                            response.message,
                            'error'
                        );
                    }
                }
            },
            success: function(file,response) {
                $('modal-scrollable .validation-message').remove();
                var myDropzone = this;
                $('.serverfilename', file.previewElement).val(response.filename);
                counter++;
                $("#photoCounterAntes").text( "(" + counter + ")");
                //$('#message').html('<div class=\'alert alert-success fade in\'>La imagen se Guardó Exitosamente</div>');
                cargarImg(id);
                cleanUp = false;
                myDropzone.removeAllFiles();
                swal(
                        'Correcto',
                        'La imágen se guardó correctamente',
                        'success'
                );
                //$("#poitaller-table").ajax.reload();
            }
          });
        };

        //============= TAB GALERIA ================
        //CARGA DE IMAGENES DE SERVIDOR
        // cargarImg();
        // $("#tabGaleria").click(function(){
        //   cargarImg();
        // });
        //OLD GALERY
        $(function(){
            $('#submit-all').attr('disabled','disabled').addClass('btn btn-alert');
            var counter = 0;
            var actual = 0;
            var cleanUp = true;
            $('#fecha').change(function(){
              obtnState();
            });
            $('#fecha').keyup(function(){
              console.log(actual + counter);
              obtnState();
            });
            Dropzone.options.dzone = {
              uploadMultiple: true,
              autoProcessQueue: false,
              maxFiles: 8,
              parallelUploads: 8,
              maxFilesize: 250,
              acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
              previewsContainer: '#dropzonePreviewAntes',
              previewTemplate: document.querySelector('#preview-template').innerHTML,
              addRemoveLinks: true,
              dictRemoveFile: 'Quitar',
              //dictFileTooBig: 'La imagen es mayor a 8MB',
              dictRemoveFileConfirmation: "¿Estas seguro que deseas borrar esta imagen?",
              //enqueueForUpload: false,
              // The setting up of the dropzone
              /*createImageThumbnails: true,
              maxThumbnailFilesize: 100,*/
              init:function() {
                // Add server images
                //var myDropzone = this;
                //console.log(actual);
                uid = document.getElementById('uid').value;
                var submitButton = document.querySelector("#submit-all");
                myDropzone = this; // closure
                submitButton.addEventListener("click", function(event) {
                    event.preventDefault();
                    if($('#fecha').val() !== '') {
                        myDropzone.processQueue(); // Tell Dropzone to process all queued files.
                    }else{
                        $('#submit-all').attr('disabled','disabled').addClass('btn btn-alert');
                    }
                });
                $('input[type=radio][name=tipo]').change(function() {
                    cleanUp = false;
                    //$('#fecha').val('');
                    //$('#submit-all').attr('disabled','disabled').addClass('btn btn-alert');
                    //counter = 0;
                    //actual  = 0;
                    //myDropzone.removeAllFiles();
                    obtnState();
                    cleanUp = true;
                });
                this.on("addedfile", function() {
                    actual++;
                    console.log(actual);
                    obtnState();
                });
                this.on("maxfilesexceeded", function(){
                    alert("Limite de Imagenes Excedido");
                });
                indx = 0;
                this.on("sendingmultiple", function(file, xhr, formData){
                    var csrf_token = $('meta[name="csrf-token"]').attr('content');
                    uid= document.getElementById('uid').value;
                    console.log(uid);
                    @if( count($Obras) > 1 )
                      formData.append('idObra',$('input[name=optObra]:checked').val());
                    @endif
                    formData.append('descripcion', $('#txtDescripcion').val());
                    formData.append('tiempo',$('input[name=tiempo]:checked').val());
                    formData.append('tipo',$('input[name=tipo]:checked').val());
                    formData.append('uid',uid);
                    formData.append('fecha',$('#fecha').val());
                    formData.append('_token', csrf_token);
                    formData.append('cantidad', counter);
                });
                this.on("error", function(file){if (!file.accepted) this.removeFile(file);});
                this.on("removedfile", function(file) {
                    if(cleanUp) {
                        $.ajax({
                            type: 'POST',
                            url: 'upload/delete',
                            data: {
                                id: $('.serverfilename', file.previewElement).val(),
                                uid: document.getElementById('uid').value,
                                _token: $('#csrf-token').val()
                            },
                            dataType: 'html',
                            success: function (data) {
                                var rep = JSON.parse(data);
                                if (rep.code === 200) {
                                    counter--;
                                    $("#photoCounterAntes").text("(" + counter + ")");
                                }
                            }
                        });
                    }
                    counter--;
                    obtnState();
                });
              },
              error: function(file, response) {
                cleanUp = false;
                myDropzone.removeAllFiles();
                if(response){
                  if(response.message){
                    $('#message').html('<div class=\'alert alert-danger fade in\'>'+ response.message +'</div>');
                    swal(
                    'Error',
                    response.message,
                    'error'
                    );
                  }else{
                    $('#message').html('<div class=\'alert alert-danger fade in\'>Error al guardar las imagenes, intentelo nuevamente</div>');
                    swal(
                    'Error',
                    'Error al subir las imagenes, intentelo nuevamente!',
                    'error'
                    );
                  }
                } else {
                  $('#message').html('<div class=\'alert alert-danger fade in\'>Error al guardar las imagenes, intentelo nuevamente</div>');
                  swal(
                    'Error',
                    'Error al subir las imagenes, intentelo nuevamente!',
                    'error'
                  );
                }
              },
              success: function(file,response) {
                var myDropzone = this;
                $('.serverfilename', file.previewElement).val(response.filename);
                counter++;
                $("#photoCounterAntes").text( "(" + counter + ")");
                $('#message').html('<div class=\'alert alert-success fade in\'>Las imagenes se Guardaron Exitosamente</div>');
                cargarImg();
                cleanUp = false;
                myDropzone.removeAllFiles();
                swal(
                        'Correcto',
                        'Las imagenes se guardaron correctamente',
                        'success'
                );
              }
            };
            function obtnState(){
              if($('#fecha').val() !== '' && actual + counter >= 3 && $('input[name=tiempo]').is(':checked')===true ){
                $('#submit-all').removeAttr('disabled').addClass('btn btn-success');
              }else{
                $('#submit-all').attr('disabled','disabled').addClass('btn btn-alert');
              }
              console.log($('input[name=tipo]').is(':checked'));
              console.log($('input[name=tiempo]').is(':checked'));
              console.log($('#fecha').val());
            }
        });
        //AJAX REQUEST ON IMAGE UPLOAD ->

        cargarImg = function(){
          $.get('/getServer-images2/' + {{ $data['id'] }}, function(data) {
          html = "";
          $.each(data.imgObras, function($i,$k){
            var lbltipo = "";
            switch($k.tipo){
              case 'E':
              lbltipo = " <i><label class='label label-success'>Ejecución Integral</label></i>";
              break;
              case 'S':
              lbltipo = " <i><label class='label label-warning'>Otros</label></i>";
              break;
              case 'M':
              lbltipo = " <i><label class='label label-primary'>Meta</label></i>";
              break;
            }
            html += `
                  <br>
                  <div class="box box-success box-solid">
                    <div class="box-header with-border">
                      <h3 class="box-title">`+$k.nom_proyec +lbltipo+`</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="box-body">
                `;
            if($k.img.length > 0 ) {
              $.each($k.img, function($in,$r){
                html += `
                  <div class="panel-group">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" href="#`+$r.img[0].fecha+`">
                            <i class="glyphicon glyphicon-play"></i> <b>`+$r.img[0].tiempo+ `( <i>`+$r.fecha +`</i> )</b>
                          </a>
                          <button type="button" class="btn btn-primary btn-xs" onclick="loadfrmEditImage(`+$r.img[0].idproyecto+`,`+$r.img[0].idobra+`,'`+$r.img[0].fecha+`','`+$r.img[0].tiempo+`')"><i class="fa fa-edit"></i></button>
                        </h4>
                      </div>
                      <div id="`+$r.img[0].fecha+`" class="panel-collapse collapse">
                        <div class="panel-body">`;
                $.each($r.img, function($x,$y){
                          var imgUrl = '/' + $y.url + $y.nombre;
                        html += `
                                <a href="#">
                                  <img width="180px" height="180px" src="`+imgUrl+`">
                                </a>
                            `;
                      });
                html += `
                        </div>
                      </div>
                    </div>
                  </div>`;
                });
            }
            else{
              html += '<b><i>No se encontraron fotografías registradas</b></i>';
            }
            html += `
                      </div>
                    </div>
                `;
          });
          var porAsignarHtml = '';
          if ( data.imgPorAsignar.length === 0 ) {
            porAsignarHtml = '<b><i>No se encontraron fotografías registradas</b></i>';
          }
          $.each(data.imgPorAsignar, function($i,$k){
            porAsignarHtml += `
              <div class="panel-group">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">
                    <a data-toggle="collapse" href="#`+$k.img[0].fecha+`">
                      <i class="glyphicon glyphicon-play"></i> <b>`+$k.img[0].tiempo+ `( <i>`+$k.fecha +`</i> )</b>
                    </a>
                    <button type="button" class="btn btn-primary btn-xs" onclick="loadfrmEditImage(`+$k.img[0].idproyecto+`,`+$k.img[0].idobra+`,'`+$k.img[0].fecha+`','`+$k.img[0].tiempo+`')"><i class="fa fa-edit"></i></button>
                  </h3>
                </div>
                <div id="`+$k.img[0].fecha+`" class="panel-collapse collapse">
                  <div class="panel-body">`;
                  $.each($k.img, function($x,$y){

                    var imgUrl = '/' + $y.url + $y.nombre;

                    porAsignarHtml += `
                            <a href="#">
                              <img width="180px" height="180px" src="`+imgUrl+`">
                            </a>
                        `;
                  });
            porAsignarHtml += `
                    </div>
                  </div>
                </div>
              </div>`;
          });
          porAsignarHtml = `
            <br>
            <div class="box box-success box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">FOTOGRAFÍAS NO RELACIONADAS A UNA OBRA/ACTIVIDAD</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body">
                `+porAsignarHtml+`
              </div>
            </div>
            `;
          $("#imgPorEjecucion").html("<h3 class='text-center'><b>GALERIA</b></h3>" + html+porAsignarHtml);
          }).fail(function() {
            console.log("Falló obtener lista de fotos");
          });
        };

        cargarImg();

        loadfrmEditImage = function(idproyecto, idobra,fecha, tiempo){
          $.ajax({
            url: '/piptotalpriori/getEditImage/' + idproyecto,
            type: 'GET',
            data: {
              'idobra':idobra,
              'fecha':fecha,
              'tiempo':tiempo
            },
            beforeSend: function () {
              $("#loader").show();
            },
            success: function (response) {
              $('#full-width .modal-title').html($(response).filter('.cabecera'));
              $('#full-width .modal-body').html($(response).filter('#container'));
              $('#full-width .modal-footer').append($(response).filter('.pie'));
              $('#full-width').modal('show', {backdrop: 'true'});
            },
            complete: function(response) {
              $("#loader").hide();
              setDatepicker();
              getPackImages(idobra, fecha, tiempo, idproyecto);
            },
            error: function(response){
              $("#loader").hide();
            }
          });
         }

        getPackImages = function(idobra, fecha, tiempo, idproyecto){
          $.ajax({
            url: '/piptotalpriori/getPackImage/' + idproyecto,
            type: 'GET',
            data: {
              'idobra':idobra,
              'fecha':fecha,
              'tiempo':tiempo
            },
            success: function (response) {
              var html = "";
              $.each(response, function($i,$v){
              html += `
                    <div class="container col-lg-3 col-sm-6 col-md-4 col-xs-12">
                         <div style="border:1px solid;border-radius:2%;margin-right:8px;margin-top:12px;">
                             <a class="fancybox" rel="group" href="/`+ $v['url'] + $v['nombre'] +`">
                                <img width=100% height=150px src="/`+ $v['url'] + $v['nombre'] +`" alt="" />
                             </a>
                             <div style="height:35px;text-align:left;background-color:rgba(208, 206, 206, 0.83);">
                                 <button style="float:right" type="button" onclick = "deleteImgPack(`+$v['id']+`,`+$v['idobra']+`,'`+ $v['fecha']+`','`+ $v['tiempo']+`',`+ $v['idproyecto']+`)" class="btn btn-danger">
                                  <i class="fa fa-trash"></i>
                                 </button>
                             </div>
                         </div>
                     </div>
                     `;
              });
              $("#paqueteImg").html(html);
            },
            error: function(response){
              $("#loader").hide();
            }
          });
        }

        deleteImgPack = function(idimage,idobra, fecha, tiempo, idproyecto){
          var id = idimage;
          swal({
            title: '¿Estas seguro?',
            text: "Se eliminara esta imagen",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No, cancelar!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: true
          }).then(function() {
          $.ajax({
              url: "/piptotalpriori/deleteImagePack/"+id,
              type: 'POST',
              success: function (data) {
                  swal(
                      'Listo',
                      'Se ha eliminado la imagen',
                      'success'
                  );
                  getPackImages(idobra, fecha, tiempo, idproyecto);
              },
              error: function(e){
                  swal(
                  'Error',
                  'Error al eliminar la imagen',
                  'error'
                  )
              }
          });
          },function(dismiss){
            swal(
                'Cancelado',
                'Operación cancelada',
                'Error'
          )
          }).catch(swal.noop);
        };

        updateImage = function(){
          console.log($("#frmImageUpdate").serialize());
          $.ajax({
            method: "POST",
            url: $("#frmImageUpdate").attr('action'),
            data: $("#frmImageUpdate").serialize(),
            beforeSend: function () {
            },
            error: function (response){
              try{
              var data = $.parseJSON(response.responseText);
              }catch(Exception){
                console.log('Error');
              }
              var li = "";
              $.each(data,function(key,val){
                li += "<li>" + val + "</li>";
              });
              $('.validation-message').remove();
              $("#frmImageUpdate").prepend('<div id = "frm_message" class="validation-message alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' + li + '</div>');
              $(".modal-scrollable").animate({ scrollTop: 0 }, 'slow');
              $("#frm_message").focus();
            },
            success: function (response) {
              $('.validation-message').remove();
              swal(
              'Guardado',
              'Los cambios se guardaron exitosamente!',
              'success'
              );
              cargarImg();
              //getPackImages(idobra, fecha, tiempo, idproyecto);
            }
          });
        };
    </script>

<!-- ========================================= LIBS ======================================= -->
    <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBea_vgTFolz7EGBG32BaUeR0FvFJbpdrQ&libraries=places&callback=initMap"></script>
@endsection
