<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {    
        // \App\Models\User::factory(10)->create();
     //   $this->call(DealTypeSeeder::class);
        $this->call(BranchSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(CreateSuperUserSeeder::class);
        
        $this->call(RoleSeeder::class);
        $this->call(StageSeeder::class);
       
      
    }
}
