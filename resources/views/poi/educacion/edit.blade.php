<span class="cabecera">
    <h2 style="text-align: center;">Reprogramar Actividad</h2>
</span>

<div id="container" class="container-fluid">


<style>

    /*.valid {
        border: 2px solid green !important;
    }*/



  /*table tr:nth-child(even) {background-color: rgb(216,206,88);}*/

</style>

<div class="col-md-12 main">
    <form id="frmEditTaller" onsubmit="updateTaller(event)">
        <div class="row">
            <div class="row">
                <div class="col-md-12 text-center">
                    @if($Taller->reprogramada == 0)
                        <label class="label label-success">No se ha reprogramado anteriormente</label>
                    @elseif($Taller->reprogramada < 3 && $Taller->reprogramada > 0 )
                        <label class="label label-warning">Veces Re-Programado: {{ $Taller->reprogramada }}</label>
                    @elseif($Taller->reprogramada == 3 )
                        <label class="label label-danger">Veces Re-Programado: {{ $Taller->reprogramada }}</label>
                        <label class="label label-danger">No puede realizar mas reprogramaciones</label>
                    @endif
                </div>
            </div>
            <br>
            <div class="row">
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Responsable Institucional</label>
                            <p> {{ $Taller->resp_institucional }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Responsable Operativo</label>
                            <p> {{ $Taller->nombres . ', ' . $Taller->apellidos }}</p>
                        </div>                                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Lugar</label><br>
                            <input class="form-control" name="txtIe" type="text" value = "{{ $Taller->ie }}" onchange="ctrlHasChanged()" onkeyup="ctrlHasChanged()" >
                            <input type="hidden" name="ie" value = "{{$Taller->ie}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Distrito</label><br>
                            <select class="form-control" style="width: 100%" name = "ddlDistrito" id = "ddlSearchDistrito" onchange="ctrlHasChanged()">
                                @foreach($Distritos as $distrito)
                                    <option value="{{$distrito->gid}}" {{ $distrito->selected }}>{{$distrito->formated_nom_dist}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="distrito" value = "{{$Taller->gid}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?php echo is_numeric($Taller->docente) ? 'Cant. Docentes' :  'Docente' ?></label><br>
                            <input class="form-control" name="txtDocente" type="text" value = "{{ $Taller->docente }}" onchange="ctrlHasChanged()" onkeyup="ctrlHasChanged()" >
                            <input type="hidden" name="docente" value = "{{$Taller->docente}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> DNI Docente </label><br>
                            <input class="form-control" name="txtDni" type="text" maxlength="9" value = "{{ $Taller->dni_docente }}" onchange="ctrlHasChanged()" onkeyup="ctrlHasChanged()" >
                            <input type="hidden" name="dni" value = "{{$Taller->dni_docente}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <input type="hidden" name="id" value="{{$Taller->id}}">
            <div class="row col-xs-12 col-md-6 col-lg-6">
                <div class="input-group">
                    <label>Fecha</label><br>
                    <input class="form-control datepicker" type="text" name="txtFecha" class="datepicker" placeholder="Fecha dd-mm-yyyy" value="{{ date('d-m-Y', strtotime($Taller->fecha)) }}" onchange="ctrlHasChanged()" onkeyup="ctrlHasChanged()">
                    <input type="hidden" name="fecha" value = "{{$Taller->fecha}}">
                </div>
            </div>
        </div>
        <br>
        @if($Taller->reprogramada > 0 and count($Reprogramacion) > 0  )
        <div class="row text-center">
            <h3>Reprogramaciones</h3>
            <div class="form-group">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Observación</th>
                            <th>Docente Antes</th>
                            <th>Docente Despues</th>
                            <th>Fecha Antes</th>
                            <th>Fecha Despues</th>
                            <th>Lugar Antes</th>
                            <th>Lugar Despues</th>
                            <th>Distrito Antes</th>
                            <th>Distrito Despues</th>
                            <th>DNI Antes</th>
                            <th>DNI Despues</th>
                            <th>Realizado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($Reprogramacion as $r)
                        <tr>
                            <td>{{ $r->observacion }}</td>
                            <td>{{ $r->docente_antes }}</td>
                            <td>{{ $r->docente_despues }}</td>
                            <td>{{ $r->fecha_antes }}</td>
                            <td>{{ $r->fecha_despues }}</td>
                            <td>{{ $r->lugar_antes }}</td>
                            <td>{{ $r->lugar_despues }}</td>
                            <td>{{ $r->nom_distrito_antes }}</td>
                            <td>{{ $r->nom_distrito_despues }}</td>
                            <td>{{ $r->dni_antes }}</td>
                            <td>{{ $r->dni_despues }}</td>
                            <td>{{ $r->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        <br>
        @if($Taller->reprogramada < 3 )
        <div id="if-modified" style="display:none">
        <div class="row text-center">
            <div class="form-group">
                <label>Razón</label><br>
                <textarea name="txtRazon" maxlength="250" class="form-control" required></textarea>
            </div>
        </div>
        <br>
        <div class="row text-center">
            <div id="rprogrammedMsg"></div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12" style="text-align: center;">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Reprogramar</button>
            </div>
        </div>
        </div>
        @endif
    </form>
</div>

<div class="pie">
        
</div>