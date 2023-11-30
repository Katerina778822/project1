<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Business;
use App\Models\dealType;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DealTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *///4-новый; 3-Остывший; 2 - База; 1 - Клиент;
    public function run()
    {

        $business = dealType::create(['name' => 'Клиент','id' => 1]);
        $business = dealType::create(['name' => 'База','id' => 2]);
        $business = dealType::create(['name' => 'Остывший','id' => 3]);
        $business = dealType::create(['name' => 'Новый','id' => 4]);

    }


    
}
