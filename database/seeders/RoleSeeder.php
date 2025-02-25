<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::insert([
            ['name' => 'Guest'],
            ['name' => 'Subscriber'],
            ['name' => 'Theme Manager'],
            ['name' => 'Editor']
        ]);
    }
}
