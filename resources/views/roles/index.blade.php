@extends('starter')

@section('htmlhead')
    <!-- JqueryUI -->
    <link rel="stylesheet" href="{{ asset('librerias/jquery-ui/themes/redmond/jquery-ui.min.css') }}">
    <!-- DROPZONE -->
    <link rel="stylesheet" href="{{ asset('librerias/dropzone/dropzone.min.css') }}">
@endsection

@section('body')
<div class="col-md-12 main">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading" style="background-color:#3c8dbc">
                <div class="panel-title">
                    <h2 class="text-center">Administración de Roles</h2>
                </div>
            </div>

            <div class="panel-body">
                {{-- Fila superior: buscador y botón --}}
                <div class="row">
                    <div class="col-sm-6">
                        <form class="form-inline" method="GET" action="{{ route('roles.index') }}">
                            <div class="form-group">
                                <input type="text"
                                       name="q"
                                       value="{{ request('q') }}"
                                       class="form-control"
                                       placeholder="Buscar por nombre...">
                            </div>
                            <button type="submit" class="btn btn-default">
                                <i class="glyphicon glyphicon-search"></i> Buscar
                            </button>
                            @if(request('q'))
                                <a href="{{ route('roles.index') }}" class="btn btn-warning">
                                    <i class="glyphicon glyphicon-remove"></i> Limpiar
                                </a>
                            @endif
                        </form>
                    </div>
                    <div class="col-sm-6 text-right">
                        @permission('role-create')
                            <a class="btn btn-success" href="{{ route('roles.create') }}">
                                <i class="glyphicon glyphicon-plus"></i> Crear Nuevo Rol
                            </a>
                        @endpermission
                    </div>
                </div>

                {{-- Mensajes flash --}}
                <br>
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="glyphicon glyphicon-ok"></i> {{ session('success') }}
                    </div>
                @endif

                {{-- Tabla --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width:60px">N°</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th style="width:280px">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                                <tr>
                                    <td>{{ $roles->firstItem() + $loop->index }}</td>
                                    <td>{{ $role->display_name }}</td>
                                    <td>{{ $role->description }}</td>
                                    <td style="text-align: center">
                                        <a class="btn btn-info" href="{{ route('roles.show', $role->id) }}">
                                            <i class="glyphicon glyphicon-eye-open"></i> Ver
                                        </a>
                                        @permission('role-edit')
                                            <a class="btn btn-primary" href="{{ route('roles.edit', $role->id) }}">
                                                <i class="glyphicon glyphicon-pencil"></i> Editar
                                            </a>
                                        @endpermission
                                        @permission('role-delete')
                                            <form method="POST"
                                                  action="{{ route('roles.destroy', $role->id) }}"
                                                  style="display:inline;"
                                                  onsubmit="return confirm('¿Seguro que deseas borrar este rol?');">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="glyphicon glyphicon-trash"></i> Borrar
                                                </button>
                                            </form>
                                        @endpermission
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No hay roles para mostrar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Paginación --}}
                    <div class="text-center">
                        {!! $roles->appends(request()->query())->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
