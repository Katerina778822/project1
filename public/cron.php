<?php

use App\Models\B24Analitics;
use Illuminate\Support\Facades\Log;

require __DIR__ . '/../vendor/autoload.php'; // Путь к автозагрузчику Laravel




$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

$orderController = $app->make(\App\Http\Controllers\B24FetchController::class);
$timezone = new DateTimeZone('Europe/Kiev');
$date = new DateTime('now', $timezone);
$currentTime = new DateTime('now', $timezone);

$date->sub(new DateInterval('PT30M')); // 
$date = $date->format('Y-m-d H:i:s');

$orderController->fetchAll($date);


$Time = B24Analitics::where('AIM', 3377)->first();
if (empty($Time)) {//запись даты обновления в БД
    $time = B24Analitics::create([
        'AIM' => 3377,
        'date1' => $currentTime->format('Y-m-d H:i:s'),
    ]);
} else {
    $Time->date1  = $currentTime->format('Y-m-d H:i:s');

    $Time->save();
}
Log::channel('single')->info('cron.php fetchAll  done.');

$orderController = $app->make(\App\Http\Controllers\B24RaportController::class);
$orderController->fetchAll($date);
$Time = B24Analitics::where('AIM', 4477)->first();
if (empty($Time)) {//запись даты обновления в БД
    $time = B24Analitics::create([
        'AIM' => 4477,
        'date1' => $currentTime->format('Y-m-d H:i:s'),
    ]);
} else {
    $Time->date1  = $currentTime->format('Y-m-d H:i:s');

    $Time->save();
}
Log::channel('single')->info('cron.php Raport created.');
