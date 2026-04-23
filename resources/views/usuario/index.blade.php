@extends('starter')
@section('body')

<div class="col-md-12 main">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading" style="background-color:#3c8dbc">
                <div class="panel-title"><h2><center>LISTA DE USUARIOS</center></h2></div>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <a class="btn btn-success btnAgregar" href="{{URL::to('/usuario/create')}}"><span class="glyphicon glyphicon-plus"></span> AGREGAR</a>
                    </div>
                </div>
                @if(Session::has('mensaje_error'))
                    <br><div class="alert alert-danger">{{Session::get('mensaje_error')}}</div>
                @endif
                @if(Session::has('mensaje_exito'))
                    <br><div class="alert alert-success">{{Session::get('mensaje_exito')}}</div>
                @endif
                <br>
                <div class="row table-responsive">
                    <table id="users-table">
                        <thead style="background: #3c8dbc;color: white;">
                            <tr>
                                <th class="text-center">
                                  Tipo
                                  <select  name="clasificacion" class="form-control" id="clasificacion">
                                      <option value="" selected>TODOS</option>
                                      <option value="INVERSIÓN">INVERSIÓN</option>
                                      <option value="EDUCACIÓN">EDUCACIÓN</option>
                                  </select>
                                </th>
                                <th class="text-center">
                                  Rol
                                  <select  name="rol" class="form-control" id="rol">
                                    <option value="" selected>TODOS</option>
                                    @foreach($user as $data)
                                      <option value="{{$data->display_name}}">{{$data->display_name}}</option>
                                    @endforeach
                                  </select>
                                </th>
                                <th style="text-align: center;vertical-align: middle">GER./DIR.</th>
                                <th style="text-align: center;vertical-align: middle">Usuario</th>
                                <th style="text-align: center;vertical-align: middle">Nombres</th>
                                <th style="text-align: center;vertical-align: middle">Apellidos</th>
                                <th style="text-align: center;vertical-align: middle">DNI</th>
                                <th style="text-align: center;vertical-align: middle">Activo</th>
                                <th style="text-align: center;vertical-align: middle">Acción</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<!--script type="text/javascript" src= "https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script-->
<script type="text/javascript" src= "//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src= "https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>

<script>

        var table = $('#users-table').DataTable({
            lengthMenu: [[10, 25, 50,100], [10, 25, 50, 100]],
            processing: true,
            serverSide: true,
            orderCellsTop: true,
            autoWidth: false,
            stateSave: false,
            order: [[ 2, "desc" ]],
            dom: 'lpfBrtip',
            responsive: {
                details: {
                    type: 'column'
                }
            },
            ajax: {
                url: '{{ url("/user-filter-data") }}',
                method: 'POST',
            },
            columnDefs: [
                { className: "dt-center", targets: "_all"},
                {
                    processing: false,
                    orderable: false,
                    targets:   0,
                    render: function (data, type, full, meta) {
                        if (data==0) {
                          return 'INVERSIÓN';
                        }else {
                          return 'EDUCACIÓN';
                        }
                    }
                },
                {
                    processing: false,
                    orderable: false,
                    targets:   1,
                },
                {
                    orderable: false,
                    targets:   -1,
                    render: function (data, type, full, meta) {
                        bEdit   = "<button onclick='window.location.assign(\"/usuario/edit/" + data + "\")'\" class = 'btn btn-primary' style='height:30px;width:30px;margin: 0;padding: 0;' id='A' title = 'Editar' type='button' class='e'><i id='A' class='fa fa-edit fa-lg e' aria-hidden='true'></i></button>";

                        bDel   = "<button class = 'btn btn-danger btnEliminar' style='height:30px;width:30px;margin: 0;padding: 0;' id='A' title = 'Eliminar' type='button' value="+ data + " class='e'><i id='A' class='fa fa-trash fa-lg e' aria-hidden='true'></i></button>";

                       return bEdit + bDel;
                    }
                },
                {
                    orderable: false,
                    targets:   -2,
                    render: function (data, type, full, meta) {
                            if(data == 1 ){
                                html = "<label style='font-size:20;' class= 'label label-success'>SI</label>";
                            } else {
                                html = "<label style='font-size:20;' class= 'label label-danger'>NO</label>";
                            }
                        return html;
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
                {data: 'poi', name: 'poi', width: '6%'},
                {data: 'display_name', name: 'display_name', width: '8%'},
                {data: 'denom', name: 'denom', width: '8%'},
                {data: 'username', name: 'username', width: '10%'},
                {data: 'nombres', name: 'nombres', width: '10%'},
                {data: 'apellidos', name: 'apellidos', width: '10%', orderable: true},
                {data: 'dni', name: 'dni', width: '5%'},
                {data: 'activo', name: 'activo', width: '5%'},
                {data: 'idusuario', name: 'accion', orderable: false, searchable: false , width: '10%'}
            ]
        });

        $("#clasificacion").change(function() {
            if ($("#clasificacion").val()=="INVERSIÓN") {
              url='{{ url("/user-filter-data/?id=0")}}';
              rol(0);
            }
            else if ($("#clasificacion").val()=="EDUCACIÓN") {
              url='{{ url("/user-filter-data/?id=1")}}';
              rol(1);
            }else {
              url='{{ url("/user-filter-data")}}';
              rol(2);
            }
            table.ajax.url(url).load();
        });

        $("#rol").change(function() {
            var vrol=$("#rol").val();
            if ($("#clasificacion").val()=="INVERSIÓN") {
              url='{{url("/user-filter-data/?id=0")}}&rol='+ vrol;
            }
            else if ($("#clasificacion").val()=="EDUCACIÓN") {
              url='{{ url("/user-filter-data/?id=1")}}&rol=' + vrol;
            }else {
              url='{{ url("/user-filter-data/?rol=")}}' + vrol;
            }
            table.ajax.url(url).load();
        });

        function rol($id) {
          $.ajax({
              url: "{{url('/usuario/clasificacion_filtro')}}/" + $id,
              success: function (response) {
                html = "";
                html += "<option value=''>TODOS</option>";
                $.each(response,function(key,value){
                    html += "<option value='"+key+"'>"+value+"</option>";
                });
                $("#rol").html(html);
              }
          });
        }

        reloadTable = function (){
           table.ajax.reload( null, false );
           $('#export').val(0);
        }
</script>

    <script>
        $(document).ready(function () {

            $(document).on('click', 'button.btnEliminar', function () {

                var id = $(this).val();
                swal({
                    title: '¿Desea Eliminar Registro?',
                    text: "El usuario será eliminado permanentemente",
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
                        url: "{{url('/usuario/destroy')}}/" + id,
                        success: function (data) {
                            location.reload(true);
                        }
                    });
                }, function(dismiss) {
                    // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                    $(that).prop('checked',nemesis);
                    swal(
                            'Cancelado',
                            'Operación cancelada',
                            'error'
                    )

                }).catch(swal.noop);
            });
        });
    </script>
@stop
