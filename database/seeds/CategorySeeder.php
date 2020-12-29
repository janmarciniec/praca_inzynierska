<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert(['name' => 'Meble']);
        DB::table('categories')->insert(['name' => 'RTV i AGD']);
        DB::table('categories')->insert(['name' => 'Moda']);
        DB::table('categories')->insert(['name' => 'Zwierzęta']);
        DB::table('categories')->insert(['name' => 'Dla dzieci']);
        DB::table('categories')->insert(['name' => 'Sport i hobby']);
        DB::table('categories')->insert(['name' => 'Muzyka']);
        DB::table('categories')->insert(['name' => 'Książki']);
        DB::table('categories')->insert(['name' => 'Pozostałe']);
    }
}
