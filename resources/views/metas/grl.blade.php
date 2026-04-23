@extends('starter')

@section('body')
<div class="row" style="margin-bottom:15px;">
    <div class="col-sm-12">
        <h2 style="margin-top:0;">
            <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Metas por UEI
        </h2>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

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

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Importar Excel/CSV (Carga Masiva)</h3>
    </div>
    <form method="POST" action="{{ URL::to('metas/grl/import') }}" enctype="multipart/form-data" id="form-import-grl">
        {{ csrf_field() }}
        <div class="box-body">
            <div class="row">
                <div class="col-md-8 form-group">
                    <label>Archivo</label>
                    <input type="file" name="file" id="file-grl" class="form-control" accept=".xlsx,.xls,.csv,.txt" required>
                </div>
                <div class="col-md-4 form-group">
                    <label>Formato esperado</label>
                    <p class="form-control-static">Columnas: anio, direc_uei, m_enero ... m_diciembre, fecha_subida, tipo(opcional)</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Hoja a importar</label>
                    <select name="selected_sheet" id="selected-sheet-grl" class="form-control" required disabled>
                        <option value="">Seleccione una hoja...</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-info">Importar Meta UEI</button>
        </div>
    </form>
</div>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Sumatoria Agrupada por Fecha</h3>
    </div>
    <div class="box-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Fecha Subida</th>
                    <th>Registros</th>
                    <th>Enero</th>
                    <th>Febrero</th>
                    <th>Marzo</th>
                    <th>Abril</th>
                    <th>Mayo</th>
                    <th>Junio</th>
                    <th>Julio</th>
                    <th>Agosto</th>
                    <th>Setiembre</th>
                    <th>Octubre</th>
                    <th>Noviembre</th>
                    <th>Diciembre</th>
                    <th>Total Anual</th>
                    <th>Eliminación Masiva</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resumenes as $item)
                    <tr>
                        <td>{{ $item->fecha_subida }}</td>
                        <td>{{ $item->total_registros }}</td>
                        <td>{{ number_format((float) $item->m_enero, 2, '.', ',') }}</td>
                        <td>{{ number_format((float) $item->m_febrero, 2, '.', ',') }}</td>
                        <td>{{ number_format((float) $item->m_marzo, 2, '.', ',') }}</td>
                        <td>{{ number_format((float) $item->m_abril, 2, '.', ',') }}</td>
                        <td>{{ number_format((float) $item->m_mayo, 2, '.', ',') }}</td>
                        <td>{{ number_format((float) $item->m_junio, 2, '.', ',') }}</td>
                        <td>{{ number_format((float) $item->m_julio, 2, '.', ',') }}</td>
                        <td>{{ number_format((float) $item->m_agosto, 2, '.', ',') }}</td>
                        <td>{{ number_format((float) $item->m_setiembre, 2, '.', ',') }}</td>
                        <td>{{ number_format((float) $item->m_octubre, 2, '.', ',') }}</td>
                        <td>{{ number_format((float) $item->m_noviembre, 2, '.', ',') }}</td>
                        <td>{{ number_format((float) $item->m_diciembre, 2, '.', ',') }}</td>
                        <td><strong>{{ number_format((float) $item->total_anual, 2, '.', ',') }}</strong></td>
                        <td style="white-space: nowrap;">
                            <form method="POST" action="{{ URL::to('metas/grl/delete-fecha') }}" style="display:inline;">
                                {{ csrf_field() }}
                                <input type="hidden" name="fecha_subida" value="{{ $item->fecha_subida }}">
                                <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Seguro que desea eliminar todos los registros de esta fecha?');">
                                    Eliminar Fecha
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="16">Sin registros.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $resumenes->links() }}
    </div>
</div>
@endsection

@section('script')
<script>
$(function () {
    $('#file-grl').on('change', function () {
        var fileInput = this;
        var file = fileInput.files && fileInput.files[0] ? fileInput.files[0] : null;
        var $sheetSelect = $('#selected-sheet-grl');

        $sheetSelect.prop('disabled', true).html('<option value=\"\">Cargando hojas...</option>');

        if (!file) {
            $sheetSelect.html('<option value=\"\">Seleccione una hoja...</option>');
            return;
        }

        var fd = new FormData();
        fd.append('file', file);

        $.ajax({
            url: '{{ URL::to("metas/grl/sheets") }}',
            method: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function (resp) {
                if (!resp.ok || !resp.sheets || resp.sheets.length === 0) {
                    $sheetSelect.html('<option value=\"\">Sin hojas detectadas</option>');
                    return;
                }

                var options = '<option value=\"\">Seleccione una hoja...</option>';
                for (var i = 0; i < resp.sheets.length; i++) {
                    var name = resp.sheets[i];
                    options += '<option value=\"' + name + '\">' + name + '</option>';
                }
                $sheetSelect.html(options).prop('disabled', false);
            },
            error: function () {
                $sheetSelect.html('<option value=\"\">No se pudieron leer las hojas</option>');
            }
        });
    });
});
</script>
@endsection
