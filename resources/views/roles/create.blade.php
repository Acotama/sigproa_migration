@extends('starter')

@section('body')

    <div class="row" style="margin-bottom:15px;">
        <div class="col-sm-8 col-xs-12">
            <h2 style="margin-top:0;">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Crear Rol
            </h2>
        </div>
        <div class="col-sm-4 col-xs-12 text-right">
            <a class="btn btn-primary" href="{{ route('roles.index') }}">
                <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Volver
            </a>
        </div>
    </div>
    <hr style="margin-top:0; margin-bottom:20px;">

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Error!</strong> Problemas con los datos ingresados.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('roles.store') }}">
        {{ csrf_field() }}
        <div class="row">
            {{-- Nombre --}}
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Nombre:</strong>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nombre"
                        class="form-control">
                </div>
            </div>

            {{-- Nombre de Presentación --}}
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Nombre de Presentación:</strong>
                    <input type="text" name="display_name" value="{{ old('display_name') }}"
                        placeholder="Nombre de Presentación" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="description"><strong>Descripción:</strong></label>
                    <textarea id="description" name="description" class="form-control" placeholder="Descripción" rows="3">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Permisos --}}
        <div class="col-md-12">
            <h2><b>Permisos:</b></h2>
            <div class="row">

                @php
                    $categorias = [
                        'role' => 'Roles',
                        'user' => 'Usuarios',
                        'pi' => 'Gestión de Proyectos',
                        'pir' => 'Reportes Gerenciales',
                        'image' => 'Multimedia',
                        'pdf' => 'Multimedia',
                        'sayhuite' => 'Sayhuite',
                        'mantvias' => 'Mantenimiento de Vías',
                        'procompite' => 'PROCOMPITE',
                        'mantcanales' => 'Mantenimiento de Canales',
                        'poi' => 'Poi Talleres',
                    ];
                    $tituloMostrado = [];
                @endphp

                @foreach ($categorias as $prefijo => $titulo)
                    @if (!isset($tituloMostrado[$titulo]))
                        <div class="col-md-12">
                            <h3><b>{{ $titulo }}</b></h3>
                            <div class="row">
                                @foreach ($permission as $value)
                                    @php $val = explode('-', $value->name); @endphp
                                    @if ($val[0] == $prefijo)
                                        <div class="col-md-6">
                                            <div class="form-check" style="margin-bottom:5px;">
                                                <label>
                                                    <input type="checkbox" name="permission[]" value="{{ $value->id }}">
                                                    {{ $value->display_name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @php $tituloMostrado[$titulo] = true; @endphp
                    @endif
                @endforeach

            </div>
        </div>

        <div class="col-xs-12 text-center" style="margin-top:20px;">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>

@endsection
