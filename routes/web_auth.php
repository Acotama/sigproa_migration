<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    require base_path('routes/auth/core.php');
    require base_path('routes/auth/pip.php');
    require base_path('routes/auth/ejecucion_obras.php');
    require base_path('routes/auth/mantcanales_procompite.php');
    require base_path('routes/auth/reporting_roles_misc.php');
    require base_path('routes/auth/modulos.php');
});
