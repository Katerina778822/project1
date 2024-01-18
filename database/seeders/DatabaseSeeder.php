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
        $this->call(TaskTypeSeeder::class);
        $this->call(DealTypeSeeder::class);
        $this->call(BranchSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(CreateSuperUserSeeder::class);
        
        $this->call(RoleSeeder::class);
        $this->call(StageSeeder::class);

 // добавляю простых юзеров с именами пять пукв и такими же паролями
       // $this->call(UserSeeder::class);
       //нет, не добавляю
       
      
    }
}
