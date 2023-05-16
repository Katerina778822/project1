<?php

use App\Models\B24Analitics;
use Illuminate\Support\Facades\Log;

require __DIR__ . '/../vendor/autoload.php'; // Путь к автозагрузчику Laravel




$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

$orderController = $app->make(\App\Http\Controllers\B24FetchController::class);

$date = new DateTime();
$currentTime = new DateTime();
$currentTime->add(new DateInterval('PT3H'));
$date->sub(new DateInterval('PT30M')); // 
$date = $date->format('Y-m-d H:i:s');

//$orderController->updateData($date); TEMP


$Time = B24Analitics::where('AIM', 3377)->first();
if (empty($Time)) {
    $time = B24Analitics::create([
        'AIM' => 3377,
        'date1' => $currentTime,
    ]);
} else {
    $Time->date1  = $currentTime->format('Y-m-d H:i:s');

    $Time->save();
}
Log::channel('single')->info('cron.php done.');
