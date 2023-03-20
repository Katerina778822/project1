<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin=Role::create([
            'name'=>'admin',
            'slug'=>'admin',
            'permissions'=>[
                'InsertDataAll'=> true,
                'DeleteDataAll'=> true,
                'UpdateData'=> true
                ]
        ]);
        $head=Role::create([
            'name'=>'head',
            'slug'=>'head',
            'permissions'=>[
                'InsertDataTeam'=> true,
                'InsertDataPeople'=> true,
                'DeleteDataPeople'=> true,
                'UpdateDataPeople'=> true,
                'UpdateDataTeam'=> true
                ]
        ]);
    }

   
    //
} 

