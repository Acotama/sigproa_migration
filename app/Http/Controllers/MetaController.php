<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MetaController extends Controller
{
    private $months = [
        'm_enero',
        'm_febrero',
        'm_marzo',
        'm_abril',
        'm_mayo',
        'm_junio',
        'm_julio',
        'm_agosto',
        'm_setiembre',
        'm_octubre',
        'm_noviembre',
        'm_diciembre',
    ];

    public function proyectoIndex()
    {
        $resumenes = DB::table('meta_mef_proyecto')
            ->select(
                'fecha_subida',
                DB::raw('COUNT(*) as total_registros'),
                DB::raw('SUM(m_enero) as m_enero'),
                DB::raw('SUM(m_febrero) as m_febrero'),
                DB::raw('SUM(m_marzo) as m_marzo'),
                DB::raw('SUM(m_abril) as m_abril'),
                DB::raw('SUM(m_mayo) as m_mayo'),
                DB::raw('SUM(m_junio) as m_junio'),
                DB::raw('SUM(m_julio) as m_julio'),
                DB::raw('SUM(m_agosto) as m_agosto'),
                DB::raw('SUM(m_setiembre) as m_setiembre'),
                DB::raw('SUM(m_octubre) as m_octubre'),
                DB::raw('SUM(m_noviembre) as m_noviembre'),
                DB::raw('SUM(m_diciembre) as m_diciembre'),
                DB::raw('SUM(m_enero + m_febrero + m_marzo + m_abril + m_mayo + m_junio + m_julio + m_agosto + m_setiembre + m_octubre + m_noviembre + m_diciembre) as total_anual')
            )
            ->groupBy('fecha_subida')
            ->orderBy('fecha_subida', 'desc')
            ->paginate(20);

        return view('metas.proyecto', compact('resumenes'));
    }

    public function proyectoImport(Request $request)
    {
        $this->setImportRuntimeLimits();

        $this->validate($request, [
            'file' => 'required|mimes:xlsx,xls,csv,txt',
            'selected_sheet' => 'required',
        ]);

        $rows = $this->loadExcelRows($request->file('file'), $request->input('selected_sheet'));
        if (empty($rows)) {
            return redirect('metas/proyecto')->with('error', 'El archivo no tiene filas para importar.');
        }

        $requiredHeaders = array_merge(['anio', 'codigo_unico', 'fecha_subida'], $this->months);
        $row0 = $this->normalizeRowKeys($rows[0]);
        $headerRow = array_keys($row0);
        $missing = array_diff($requiredHeaders, $headerRow);
        if (count($missing) > 0) {
            return redirect('metas/proyecto')->with('error', 'Faltan columnas en el archivo: ' . implode(', ', $missing));
        }

        $batch = [];
        $imported = 0;
        $skipped = 0;

        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                $row = $this->normalizeRowKeys($row);
                if ($this->rowIsEmpty($row)) {
                    continue;
                }

                $anio = $this->toInt($row, 'anio');
                $codigoUnico = $this->toString($row, 'codigo_unico');
                if (empty($anio) || $codigoUnico === '') {
                    $skipped++;
                    continue;
                }

                $payload = [
                    'anio' => $anio,
                    'codigo_unico' => $codigoUnico,
                    'fecha_subida' => $this->normalizeDate($row['fecha_subida']),
                ];

                foreach ($this->months as $month) {
                    $payload[$month] = $this->toNumber($row, $month);
                }

                $batch[] = $payload;

                if (count($batch) >= 500) {
                    DB::table('meta_mef_proyecto')->insert($batch);
                    $imported += count($batch);
                    $batch = [];
                }
            }

            if (count($batch) > 0) {
                DB::table('meta_mef_proyecto')->insert($batch);
                $imported += count($batch);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('metas/proyecto')->with('error', 'Error al importar: ' . $e->getMessage());
        }

        return redirect('metas/proyecto')->with('success', 'Importación completada. Filas importadas: ' . $imported . '. Filas omitidas: ' . $skipped . '.');
    }

    public function proyectoSheets(Request $request)
    {
        return $this->sheetListResponse($request);
    }

    public function proyectoDeleteByFecha(Request $request)
    {
        $this->validate($request, [
            'fecha_subida' => 'required|date',
        ]);

        $fecha = $request->input('fecha_subida');
        $deleted = DB::table('meta_mef_proyecto')->where('fecha_subida', $fecha)->delete();

        return redirect('metas/proyecto')->with('success', 'Eliminación masiva completada para ' . $fecha . '. Registros eliminados: ' . $deleted . '.');
    }

    public function grlIndex()
    {
        $resumenes = DB::table('meta_mef')
            ->select(
                'fecha_subida',
                DB::raw('COUNT(*) as total_registros'),
                DB::raw('SUM(m_enero) as m_enero'),
                DB::raw('SUM(m_febrero) as m_febrero'),
                DB::raw('SUM(m_marzo) as m_marzo'),
                DB::raw('SUM(m_abril) as m_abril'),
                DB::raw('SUM(m_mayo) as m_mayo'),
                DB::raw('SUM(m_junio) as m_junio'),
                DB::raw('SUM(m_julio) as m_julio'),
                DB::raw('SUM(m_agosto) as m_agosto'),
                DB::raw('SUM(m_setiembre) as m_setiembre'),
                DB::raw('SUM(m_octubre) as m_octubre'),
                DB::raw('SUM(m_noviembre) as m_noviembre'),
                DB::raw('SUM(m_diciembre) as m_diciembre'),
                DB::raw('SUM(m_enero + m_febrero + m_marzo + m_abril + m_mayo + m_junio + m_julio + m_agosto + m_setiembre + m_octubre + m_noviembre + m_diciembre) as total_anual')
            )
            ->groupBy('fecha_subida')
            ->orderBy('fecha_subida', 'desc')
            ->paginate(20);

        return view('metas.grl', compact('resumenes'));
    }

    public function grlImport(Request $request)
    {
        $this->setImportRuntimeLimits();

        $this->validate($request, [
            'file' => 'required|mimes:xlsx,xls,csv,txt',
            'selected_sheet' => 'required',
        ]);

        $rows = $this->loadExcelRows($request->file('file'), $request->input('selected_sheet'));
        if (empty($rows)) {
            return redirect('metas/grl')->with('error', 'El archivo no tiene filas para importar.');
        }

        $requiredHeaders = array_merge(['anio', 'direc_uei', 'fecha_subida'], $this->months);
        $row0 = $this->normalizeRowKeys($rows[0]);
        $headerRow = array_keys($row0);
        $missing = array_diff($requiredHeaders, $headerRow);
        if (count($missing) > 0) {
            return redirect('metas/grl')->with('error', 'Faltan columnas en el archivo: ' . implode(', ', $missing));
        }

        $batch = [];
        $imported = 0;
        $skipped = 0;

        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                $row = $this->normalizeRowKeys($row);
                if ($this->rowIsEmpty($row)) {
                    continue;
                }

                $anio = $this->toInt($row, 'anio');
                $direcUei = $this->toString($row, 'direc_uei');
                if (empty($anio) || $direcUei === '') {
                    $skipped++;
                    continue;
                }

                $payload = [
                    'anio' => $anio,
                    'direc_uei' => $direcUei,
                    'tipo' => $this->toString($row, 'tipo', true),
                    'fecha_subida' => $this->normalizeDate($row['fecha_subida']),
                ];

                foreach ($this->months as $month) {
                    $payload[$month] = $this->toNumber($row, $month);
                }

                $batch[] = $payload;

                if (count($batch) >= 500) {
                    DB::table('meta_mef')->insert($batch);
                    $imported += count($batch);
                    $batch = [];
                }
            }

            if (count($batch) > 0) {
                DB::table('meta_mef')->insert($batch);
                $imported += count($batch);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('metas/grl')->with('error', 'Error al importar: ' . $e->getMessage());
        }

        return redirect('metas/grl')->with('success', 'Importación completada. Filas importadas: ' . $imported . '. Filas omitidas: ' . $skipped . '.');
    }

    public function grlSheets(Request $request)
    {
        return $this->sheetListResponse($request);
    }

    public function grlDeleteByFecha(Request $request)
    {
        $this->validate($request, [
            'fecha_subida' => 'required|date',
        ]);

        $fecha = $request->input('fecha_subida');
        $deleted = DB::table('meta_mef')->where('fecha_subida', $fecha)->delete();

        return redirect('metas/grl')->with('success', 'Eliminación masiva completada para ' . $fecha . '. Registros eliminados: ' . $deleted . '.');
    }

    private function normalizeRowKeys(array $row)
    {
        $normalized = [];
        foreach ($row as $key => $value) {
            $normalized[trim(strtolower($key))] = $value;
        }
        return $normalized;
    }

    private function rowIsEmpty(array $row)
    {
        foreach ($row as $value) {
            if (trim((string) $value) !== '') {
                return false;
            }
        }
        return true;
    }

    private function toString(array $row, $key, $nullable = false)
    {
        $value = isset($row[$key]) ? trim((string) $row[$key]) : '';
        if ($nullable && $value === '') {
            return null;
        }
        return $value;
    }

    private function toInt(array $row, $key)
    {
        $value = isset($row[$key]) ? trim((string) $row[$key]) : '';
        if ($value === '') {
            return null;
        }
        return (int) $value;
    }

    private function toNumber(array $row, $key)
    {
        $value = isset($row[$key]) ? trim((string) $row[$key]) : '';
        if ($value === '') {
            return 0;
        }
        $value = str_replace(',', '', $value);
        return is_numeric($value) ? $value : 0;
    }

    private function normalizeDate($value)
    {
        $value = trim((string) $value);
        if ($value === '') {
            return date('Y-m-d');
        }

        if (is_numeric($value)) {
            $timestamp = ((int) $value - 25569) * 86400;
            return gmdate('Y-m-d', $timestamp);
        }

        $timestamp = strtotime($value);
        if ($timestamp === false) {
            return date('Y-m-d');
        }

        return date('Y-m-d', $timestamp);
    }

    private function loadExcelRows($file, $selectedSheet)
    {
        $path = $file->getRealPath();

        $reader = IOFactory::createReaderForFile($path);
        $reader->setReadDataOnly(true);

        $sheetNames = $reader->listWorksheetNames($path);
        if (!in_array($selectedSheet, $sheetNames)) {
            throw new \Exception('La hoja seleccionada no existe en el archivo.');
        }

        if (method_exists($reader, 'setLoadSheetsOnly')) {
            $reader->setLoadSheetsOnly([$selectedSheet]);
        }

        $excel = $reader->load($path);
        $worksheet = $excel->getSheetByName($selectedSheet);
        if (!$worksheet) {
            $worksheet = $excel->getActiveSheet();
        }

        return $this->worksheetToAssocRows($worksheet);
    }

    private function sheetListResponse(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx,xls,csv,txt',
        ]);

        try {
            $path = $request->file('file')->getRealPath();
            $reader = IOFactory::createReaderForFile($path);
            $sheetNames = $reader->listWorksheetNames($path);
            if (!is_array($sheetNames) || count($sheetNames) === 0) {
                $sheetNames = ['Sheet1'];
            }

            return response()->json([
                'ok' => true,
                'sheets' => array_values($sheetNames),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => 'No se pudo leer las hojas del archivo: ' . $e->getMessage(),
            ], 422);
        }
    }

    private function worksheetToAssocRows($worksheet)
    {
        $highestRow = (int) $worksheet->getHighestDataRow();
        $highestColumn = $worksheet->getHighestDataColumn();
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

        if ($highestRow < 1 || $highestColumnIndex < 1) {
            return [];
        }

        $headers = [];
        for ($col = 0; $col < $highestColumnIndex; $col++) {
            $cell = $worksheet->getCellByColumnAndRow($col, 1);
            $header = trim(strtolower((string) $this->cellRawValue($cell)));
            if ($header === '') {
                $header = 'col_' . $col;
            }
            $headers[$col] = $header;
        }

        $rows = [];
        for ($row = 2; $row <= $highestRow; $row++) {
            $item = [];
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $cell = $worksheet->getCellByColumnAndRow($col, $row);
                $item[$headers[$col]] = $this->cellRawValue($cell);
            }
            $rows[] = $item;
        }

        return $rows;
    }

    private function cellRawValue($cell)
    {
        $value = $cell->getValue();

        if (is_string($value) && strlen($value) > 0 && $value[0] === '=') {
            $old = method_exists($cell, 'getOldCalculatedValue') ? $cell->getOldCalculatedValue() : null;
            if ($old !== null) {
                return $old;
            }
        }

        return $value;
    }

    private function setImportRuntimeLimits()
    {
        @ini_set('max_execution_time', '300');
        @set_time_limit(300);
        @ini_set('memory_limit', '768M');
    }
}
