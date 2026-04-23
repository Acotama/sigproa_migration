<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;

class PythonController extends Controller
{
    public function run()
    {
        // 🔹 Ruta base del proyecto Laravel
        $basePath = base_path();

        // 🔹 Ruta del ejecutable Python
        $pythonPath = 'python'; // o la ruta completa si no está en el PATH

        // 🔹 Ruta absoluta del script
        $scriptPath = '/www/AIOMaintainer/test.py';

        // 🔹 Ejecutar el script y capturar salida
        $command = "$pythonPath \"$scriptPath\" 2>&1";
        $output = shell_exec($command);

        return response()->json([
            'mensaje' => 'Script ejecutado correctamente',
            'ruta' => $scriptPath,
            'resultado' => $output
        ]);
    }
}
