@extends('starter')
@section('body')
<div class="col-md-12 main">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading" style="background-color:#3c8dbc">
                <div class="panel-title"><h2><center>CREAR USUARIO</center></h2></div>
            </div>
            <form action="{{ action('UsuarioController@store') }}" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="fecha" value="{{ date('Y-m-d H:i:s') }}">
                        <input type="hidden" name="estado" value="1">
                    </div><br>
                    <div class="row" style="padding: 0px 12px;">
                        <strong><label for="iddependencia">Gerencia/Direccion:</label></strong>
                        <select name="unidades[]" class="form-control" multiple>
                            @foreach($unidad as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <div class="row" style="padding: 0px 12px;">
                        <strong><label for="rol">Rol:</strong>
                        <select name="roles[]" class="form-control" multiple>
                            @foreach($roles as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4"><label for="nombres">Nombres:</label></div>
                        <div class="col-md-8"><input type="text" name="nombres" class="form-control"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4"><label for="apellidos">Apellidos:</label></div>
                        <div class="col-md-8"><input type="text" name="apellidos" class="form-control"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4"><label for="dni">DNI:</label></div>
                        <div class="col-md-4"><input type="text" name="dni" class="form-control"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4"><label for="email">Email:</label></div>
                        <div class="col-md-8"><input type="email" name="email" class="form-control"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4"><label for="username">Usuario:</label></div>
                        <div class="col-md-4"><input type="text" name="username" class="form-control"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4"><label for="password">Password:</label></div>
                        <div class="col-md-4"><input type="password" name="password" class="form-control"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4"><label for="cargo">Cargo:</label></div>
                        <div class="col-md-4"><input type="text" name="cargo" class="form-control"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4"><label for="celular">Celular:</label></div>
                        <div class="col-md-4"><input type="text" name="celular" class="form-control"></div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4"><label for="POI">POI:</label></div>
                        <input type="hidden" name="poi" value="0">
                        <div class="col-md-4"><input type="checkbox" name="poi" id="chkpoi" class="square" value="1"></div>
                    </div><br>
                    <div class="row" style="display: none" id = "divIntervencion">
                        <div class="col-md-4"><label for="intervencion">Intervencion:</label></div>
                        <div class="col-md-4"><input type="text" name="intervencion" class="form-control"></div>
                    </div><br>

                    <script type="text/javascript">                   

                        $("#chkpoi").change(function(e){

                            if ($("#chkpoi").is(":checked")){
                                $("#divIntervencion").show();
                            } else {
                                $("#divIntervencion").css('display','none');
                            }
                        });
                    </script>

                    <div class="row">
                        <div class="col-sm-4"><label for="activo">Activo:</label></div>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div id="radioBtn" class="btn-group">
                                    <a class="btn btnActivado btn-default notActive" data-toggle="activo" data-title="1">ACTIVADO</a>
                                    <a class="btn btnDesactivado btn-default notActive" data-toggle="activo" data-title="0">DESACTIVADO</a>
                                </div>
                                <input type="hidden" name="activo" id="activo">
                            </div>
                        </div>
                        <script type="text/javascript">
                            $('#radioBtn a').on('click', function () {
                                var sel = $(this).data('title');
                                var tog = $(this).data('toggle');
                                $('#' + tog).prop('value', sel);

                                if (sel == "0") {
                                    $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('btn-success active').addClass('btn-default notActive');
                                    $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('btn-default notActive').addClass('btn-danger active');
                                } else {
                                    $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('btn-danger active').addClass('btn-default notActive');
                                    $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('btn-default notActive').addClass('btn-success active');
                                }
                            })
                        </script>
                    </div>
                    @if(Session::has('mensaje_error'))
                    <div class="alert alert-danger">{!!Session::get('mensaje_error')!!}</div>
                    @endif
                    @if(Session::has('mensaje_exito'))
                    <div class="alert alert-success">{!!Session::get('mensaje_exito')!!}</div>
                    @endif
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-danger" href="{{URL::to('/usuario')}}"><span class="glyphicon glyphicon-remove"></span> CANCELAR</a>
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> GUARDAR</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
