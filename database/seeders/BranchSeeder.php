<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Business;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      //  $business = Business::create(['name' => 'Geleon','type' => 1]);
        $business = Branch::create(['name' => 'Развоз','business_id' => 1]);
        $business = Branch::create(['name' => 'Украина','business_id' => 1]);
        $business = Branch::create(['name' => 'Опт', 'business_id' => 1]);
    }


    
}
