<span class="cabecera">
    <h2 style="text-align: center;">Eliminar Actividad</h2>
</span>

<div id="container" class="container-fluid">

<div class="col-md-12 main">
    <form id="frmDeleteTaller" onsubmit="deleteTaller(event)">
        <div class="row">
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
                            <label>Lugar</label>
                            <p> {{ $Taller->ie }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Distrito</label><br>
                            {{ $Taller->nom_dist }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?php echo is_numeric($Taller->docente) ? 'Cant. Docentes' :  'Docente' ?></label><br>
                            {{ $Taller->docente }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> DNI Docente </label><br>
                            {{ $Taller->dni_docente }}
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
                    {{ date('d-m-Y', strtotime($Taller->fecha)) }}
                </div>
            </div>
        </div>
        <br>
        <div class="row text-center">
            <div class="form-group">
                <label>Razón</label><br>
                <textarea name="txtRazon" maxlength="250" class="form-control" required></textarea>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-12" style="text-align: center;">
                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
            </div>
        </div>
    </form>
</div>

<div class="pie">
        
</div>