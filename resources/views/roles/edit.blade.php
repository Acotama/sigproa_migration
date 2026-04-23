@extends('starter')

@section('body')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Editar Rol</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('roles.index') }}">
                    <span class="glyphicon glyphicon-arrow-left"></span> Volver
                </a>
            </div>
        </div>
    </div>

    {{-- Errores --}}
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

    <form method="POST" action="{{ route('roles.update', $role->id) }}">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}

        {{-- Nombre y descripción --}}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="display_name"><strong>Nombre:</strong></label>
                    <input type="text" name="display_name" id="display_name"
                        value="{{ old('display_name', $role->display_name) }}" placeholder="Nombre" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="description"><strong>Descripción:</strong></label>
                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Descripción">{{ old('description', $role->description) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Permisos --}}
        <div class="row">
            <div class="col-md-12">
                <h2><b>Permisos:</b></h2>
                <hr>

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
                        <h3><b>{{ $titulo }}</b></h3>
                        <div class="row">
                            @foreach ($permission as $value)
                                @php $val = explode('-', $value->name); @endphp
                                @if ($val[0] == $prefijo)
                                    <div class="col-md-6">
                                        <label style="display:block;">
                                            <input type="checkbox" name="permission[]" value="{{ $value->id }}"
                                                {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                            {{ $value->display_name }}
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <hr>
                        @php $tituloMostrado[$titulo] = true; @endphp
                    @endif
                @endforeach
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 text-center">
                <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
                </button>
            </div>
        </div>
    </form>
@endsection
