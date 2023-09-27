<?php

namespace Database\Seeders;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateSuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $superUser = User::create([
            'email' => 'shulga.alg@gmail.com',
            'name' => 'Admin',
            'crmuser_id' => 1,
            'password' => Hash::make('1234567890'),
            'createdAt' => Carbon::now(),
            'updatedAt' => Carbon::now(),
        ]);

        Role::create([
            'name' => 'super-user',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $superUser->assignRole('super-user');
    }

}
