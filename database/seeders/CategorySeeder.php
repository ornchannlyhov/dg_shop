<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'electronic'],
            ['name' => 'cloth'],
            ['name' => 'shoe'],
            ['name' => 'home appliances'],
            ['name' => 'books'],
        ]);
    }
}
