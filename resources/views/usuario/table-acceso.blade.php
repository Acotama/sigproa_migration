@if ($data->accesos()->get()->count())

<?php $accesos = $data->accesos()->orderBy('ingreso','desc')->paginate(10) ?> 
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th colspan="5">HISTORIAL DE ACCESOS</th>
        </tr>
        <tr>
            <th>IP</th>
            <th>Sistema Operativo</th>
            <th>Navegador Web</th>
            <th>Ingreso</th>
            <th>Salida</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($accesos as $item)
        <tr>
            <td>{{ $item->ip }}</td>
            <td>{{ $item->so }}</td>
            <td>{{ $item->navegador }}</td>
            <td>{{ $item->ingreso }}</td>
            <td>{{ $item->salida }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div>
    <center>{{ $accesos->links() }}</center>
</div>

@else
<div id="message" class="alert alert-danger">NO SE ENCONTRARON HISTORIALES.</div>
@endif
