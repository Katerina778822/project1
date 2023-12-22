<?php

namespace Database\Seeders;

use App\Models\TaskType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class TaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   /* */
        //
        TaskType::create(['name'=>'Встреча']);
        TaskType::create(['name'=>'Видео звонок']);
        TaskType::create(['name'=>'Звонок']);
        TaskType::create(['name'=>'Чат']);
        TaskType::create(['name'=>'Письмо']);
    }
}
