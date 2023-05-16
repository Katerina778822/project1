<?php

use App\Http\Controllers\FutureOrderController;
use App\Models\B24Analitics;
use Illuminate\Support\Facades\Log;

require __DIR__.'/../vendor/autoload.php'; // Путь к автозагрузчику Laravel




$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

$orderController = $app->make(\App\Http\Controllers\B24FetchController::class);

$date = new DateTime();
$date->sub(new DateInterval('PT30M')); // 
$date = $date->format('Y-m-d H:i:s');

$orderController->updateData($date);
Log::channel('single')->info('cron.php done.');
$currentTime = new DateTime();
$time = new B24Analitics([
    ["AIM" => 3377],
    ["date1" => $currentTime],
]);


