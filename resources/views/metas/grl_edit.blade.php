@extends('starter')

@section('body')
<div class="row" style="margin-bottom:15px;">
    <div class="col-sm-8 col-xs-12">
        <h2 style="margin-top:0;">
            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Editar Meta por UEI
        </h2>
    </div>
    <div class="col-sm-4 col-xs-12 text-right">
        <a class="btn btn-default" href="{{ URL::to('metas/grl') }}">Volver</a>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Error:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Actualizar Registro ID {{ $meta->id_meta }}</h3>
    </div>
    <form method="POST" action="{{ URL::to('metas/grl/update/' . $meta->id_meta) }}">
        {{ csrf_field() }}
        <div class="box-body">
            <div class="row">
                <div class="col-md-3 form-group">
                    <label>Año</label>
                    <input type="number" name="anio" class="form-control" value="{{ old('anio', $meta->anio) }}" required>
                </div>
                <div class="col-md-5 form-group">
                    <label>Dirección UEI</label>
                    <input type="text" name="direc_uei" class="form-control" value="{{ old('direc_uei', $meta->direc_uei) }}" required>
                </div>
                <div class="col-md-2 form-group">
                    <label>Tipo</label>
                    <input type="text" name="tipo" class="form-control" value="{{ old('tipo', $meta->tipo) }}">
                </div>
                <div class="col-md-2 form-group">
                    <label>Fecha subida</label>
                    <input type="date" name="fecha_subida" class="form-control" value="{{ old('fecha_subida', $meta->fecha_subida) }}" required>
                </div>
            </div>

            <div class="row">
                @php $meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','setiembre','octubre','noviembre','diciembre']; @endphp
                @foreach ($meses as $mes)
                    <div class="col-md-3 form-group">
                        <label>{{ ucfirst($mes) }}</label>
                        <input type="number" step="0.0000001" name="m_{{ $mes }}" class="form-control" value="{{ old('m_'.$mes, $meta->{'m_'.$mes}) }}" required>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Actualizar Meta UEI</button>
        </div>
    </form>
</div>
@endsection
