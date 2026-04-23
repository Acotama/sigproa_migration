@if ($data->count())
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Gerencia/Direccion</th>
            <th>Rol</th>
            <th>Usuario</th>
            <th>Apellidos y Nombres</th>
            <th>Activo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
        <tr>
            <td>{{ $item->username }}</td>
            <td>{{ $item->apeNom }}</td>
            <td>@if($item->activo==1)<span class="label label-success">{{'SI'}}</span> @else <span class="label label-danger">{{'NO'}}</span> @endif</td>
            <td>
                <a value="{{ $item->idusuario }}" class="btn btn-primary btn-xs btnEditar" href="{{URL::to('/usuario/edit/'.$item->idusuario)}}"><span class="glyphicon glyphicon-pencil"></span></a>
                <button value="{{ $item->idusuario }}" class="btn btn-danger btn-xs btnEliminar"><span class="glyphicon glyphicon-trash"></span></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div>
    <center>{{ $data->links() }}</center>
</div>

@else
<div id="message" class="alert alert-danger">NO SE ENCONTRARON DATOS.</div>
@endif