<div id="container_acuerdo">
    @foreach($acuerdos as $key => $acuerdo)
        <div class="col-md-12">
            <div class="box box-default">
            <div class="box-header with-border">
                <i class="fa fa-calendar-check-o"></i>
                <h3 class="box-title bold"><strong>{{ count($acuerdos)>1 ? 'Acuerdo N° '. ($key + 1) : 'Acuerdo' }}</strong></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="callout callout-success" style="text-align: justify;height: 200px;overflow-y: scroll;">
                            <h4><ins>Problemática/Riesgo</ins></h4>
                            <?php $problematica = explode(".;",$acuerdo->problematica) ?>
                            <p>
                                @foreach($problematica as $p)
                                    - {{ trim($p) }}</br>
                                @endforeach
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="callout callout-success" style="text-align: justify;height: 200px;overflow-y: scroll;">
                            <h4><ins>Acuerdo</ins></h4>
                            <?php $p_acuerdo = explode(".;",$acuerdo->acuerdo) ?>
                            <p>
                                @foreach($p_acuerdo as $a)
                                    {{ trim($a) }}</br>
                                @endforeach
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="callout callout-success" style="text-align: justify;height: 200px;overflow-y: scroll;">
                            <h4><ins>Entregable</ins></h4>
                            <?php $entregable = explode(".;",$acuerdo->entregable) ?>
                            <p>
                                @foreach($entregable as $e)
                                    {{ trim($e) }}</br>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box" style="box-shadow: 1px 1px 1px 1px rgb(0, 166, 90);">
                            <span class="info-box-icon bg-green"><i class="glyphicon glyphicon-user"></i></span>
                            <div class="info-box-content">
                            <span class="info-box-text"><strong><ins>Responsables</ins></strong></span>
                            <?php $responsable = explode(".;",$acuerdo->responsable) ?>
                            <span class="info-box-number" style="font-size: 14px;">
                                @foreach($responsable as $r)
                                    {{ trim($r) }}</br>
                                @endforeach
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box" style="box-shadow: 1px 1px 1px 1px rgb(0, 192, 239);">
                            <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-calendar"></i></span>
                            <div class="info-box-content">
                            <span class="info-box-text"><strong><ins>Fecha de Entrega</ins></strong></span>
                            <?php $fecha_entrega = explode(".;",$acuerdo->fecha_entrega) ?>
                            <span class="info-box-number">
                                @foreach($fecha_entrega as $f)
                                    {{ trim($f) }}</br>
                                @endforeach
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    @endforeach
</div>