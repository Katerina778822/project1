<?php

use App\Http\Controllers\FutureOrderController;
use Illuminate\Support\Facades\Log;

require __DIR__.'/../vendor/autoload.php'; // Путь к автозагрузчику Laravel




$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();
Log::channel('single')->info('Test1');
$orderController = $app->make(\App\Http\Controllers\B24FetchController::class);

Log::channel('single')->info('Test1');
$date = new DateTime();
$date->sub(new DateInterval('PT30M')); // 
$date = $date->format('Y-m-d');

$orderController->updateData($date);
Log::channel('single')->info('cron.php done.');


