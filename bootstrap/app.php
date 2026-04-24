<?php

use Illuminate\Contracts\Console\Kernel as ConsoleKernelContract;
use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use Illuminate\Contracts\Http\Kernel as HttpKernelContract;
use Illuminate\Foundation\Application;

$app = Application::configure(dirname(__DIR__))->create();

// Keep legacy kernels/handler bindings for backward compatibility.
$app->singleton(HttpKernelContract::class, sayhuite\Http\Kernel::class);
$app->singleton(ConsoleKernelContract::class, sayhuite\Console\Kernel::class);
$app->singleton(ExceptionHandlerContract::class, sayhuite\Exceptions\Handler::class);

return $app;
