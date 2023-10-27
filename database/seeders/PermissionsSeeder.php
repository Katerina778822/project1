<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   /* */
        Permission::create(['name'=>'B24User.read.list']);
        Permission::create(['name'=>'B24User.read.view']);
        Permission::create(['name'=>'B24User.edit']);
        Permission::create(['name'=>'B24User.add']);
        Permission::create(['name'=>'B24User.delete']);

        Permission::create(['name'=>'parser.read.list']);
        Permission::create(['name'=>'parser.read.view']);
        Permission::create(['name'=>'parser.edit']);
        Permission::create(['name'=>'parser.add']);
        Permission::create(['name'=>'parser.delete']);

        Permission::create(['name'=>'role.read.list']);
        Permission::create(['name'=>'role.read.view']);
        Permission::create(['name'=>'role.edit']);
        Permission::create(['name'=>'role.add']);
        Permission::create(['name'=>'role.delete']);

        Permission::create(['name'=>'user.read.list']);
        Permission::create(['name'=>'user.read.view']);
        Permission::create(['name'=>'user.edit']);
        Permission::create(['name'=>'user.add']);
        Permission::create(['name'=>'user.delete']);

        Permission::create(['name'=>'company.read.list']);
        Permission::create(['name'=>'company.read.view']);
        Permission::create(['name'=>'company.edit']);
        Permission::create(['name'=>'company.add']);
        Permission::create(['name'=>'company.delete']);

        Permission::create(['name'=>'contact.read.list']);
        Permission::create(['name'=>'contact.read.view']);
        Permission::create(['name'=>'contact.edit']);
        Permission::create(['name'=>'contact.add']);
        Permission::create(['name'=>'contact.delete']);

        Permission::create(['name'=>'lead.read.list']);
        Permission::create(['name'=>'lead.read.view']);
        Permission::create(['name'=>'lead.edit']);
        Permission::create(['name'=>'lead.add']);
        Permission::create(['name'=>'lead.delete']);

        Permission::create(['name'=>'raport.read.list']);
        Permission::create(['name'=>'raport.read.view']);
        Permission::create(['name'=>'raport.edit']);
        Permission::create(['name'=>'raport.add']);
        Permission::create(['name'=>'raport.delete']);

        Permission::create(['name'=>'agenda.read.list']);
        Permission::create(['name'=>'agenda.read.view']);
        Permission::create(['name'=>'agenda.edit']);
        Permission::create(['name'=>'agenda.add']);
        Permission::create(['name'=>'agenda.delete']);

        Permission::create(['name'=>'branch.read.list']);
        Permission::create(['name'=>'branch.read.view']);
        Permission::create(['name'=>'branch.edit']);
        Permission::create(['name'=>'branch.add']);
        Permission::create(['name'=>'branch.delete']);

        Permission::create(['name'=>'business.read.list']);
        Permission::create(['name'=>'business.read.view']);
        Permission::create(['name'=>'business.edit']);
        Permission::create(['name'=>'business.add']);
        Permission::create(['name'=>'business.delete']);

        Permission::create(['name'=>'event.read.list']);
        Permission::create(['name'=>'event.read.view']);
        Permission::create(['name'=>'event.edit']);
        Permission::create(['name'=>'event.add']);
        Permission::create(['name'=>'event.delete']);


    }
}
