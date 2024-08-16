<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Category;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'role_name'=>'buyer'
        ]);
        Role::create([
            'role_name'=>'seller'
        ]);
        Category::create([
            'name'=>'cloths',
            'description'=>null
        ]);
        Category::create([
            'name'=>'shoes',
            'description'=>null
        ]);
    }
}
